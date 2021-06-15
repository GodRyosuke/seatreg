<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Endroid\QrCode\QrCode;
use Str;

class Seat extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'enabled', 'room_id', 'row', 'col', 'qrcode', 'is_priority', 'memo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    // Relations
    public function room()
    {
        return $this->belongsTo('App\Room');
    }
    public function registRecords()
    {
        return $this->hasMany('App\RegistRecord')->withTimestamps();
    }
    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\RegistRecord', 'seat_id', 'id', null, 'user_id');
    }

    public function getFullLocationAttribute()
    {
        return $this->room->code . '-' . $this->location;
    }

    public function generateLocationString()
    {
        return $this->row . '-' . $this->col;
    }


    public function getQrcodeBase64Attribute()
    {
        return base64_encode($this->seat_qrcode);
    }

    public function getSeatQrcodeAttribute()
    {
        $qrcode = new QrCode($this->seat_url);
        $qrcode->setWriterByName('png');
        return $qrcode->writeString();
    }

    public function getSeatUrlAttribute()
    {
        return config('oculocal.qrcode_prefix') . $this->code;
    }

    // 関数の廃止
    public function setCodeAttribute_deprecated($code)
    {
        $seat_url = config('oculocal.qrcode_prefix') . $code;
        /* $qrcode = new QrCode($url); */
        $this->attributes['code'] = $code;
        $this->attributes['url'] = $seat_url;
        /* $this->attributes['qrcode'] = base64_encode($qrcode->writeString()); */
    }

    public static function generateSeatCode($count = 1)
    {
        do {
            $codes = [];
            for ($i = 0 ; $i < $count ; $i++) {
                array_push($codes, Str::random(8));
            }
            $seats = Seat::whereIn('code', $codes)->get();
        } while ($seats->count());
        return ($count == 1) ? $codes[0] : $codes;
    }

    public static function bulkInsert($seats_to_add, $room_id)
    {
        $codes = Seat::generateSeatCode(count($seats_to_add));
        $seatdata = [];
        foreach ($seats_to_add as $item) {
            $rowcol = explode("-", $item);
            $seat_code = array_shift($codes);
            /* $seat_url = config('oculocal.qrcode_prefix') . $seat_code; */
            /* $seat_qrcode = new QrCode($seat_url); */
    
            array_push($seatdata, [
                'row' => $rowcol[0],
                'col' => $rowcol[1],
                'code' => $seat_code,
                'room_id' => $room_id,
                'location' => $item,
                /* 'url' => $seat_url, */
                /*'qrcode' => base64_encode($seat_qrcode->writeString()) */
            ]);
        }

        self::insert($seatdata);
    }
}

