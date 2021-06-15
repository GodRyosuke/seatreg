<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Room extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'building_id', 'floor', 'rows', 'cols', 'capacity', 'capacity_exam', 'capacity_covid', 'creator', 'memo',
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
    //

    // Relations
    public function seats()
    {
        return $this->hasMany('App\Seat');
    }

    public function default_seat()
    {
        return $this->hasOne('App\Seat')->where('row', 0)->where('col', 0)->limit(1);
    }

    public function enabled_seats()
    {
        return $this->hasMany('App\Seat')->where('enabled', true)
            ->where('row', '!=', 0)->where('col', '!=', 0);
    }

    public function building()
    {
        return $this->belongsTo('App\Building');
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'creator_id');
    }

    public function updateAllSeats()
    {
        $seats = $this->seats;
        // 部屋全体の QR コード
        if (!$this->default_seat) {
            $this->seats()->create([
                'enabled' => true,
                'row' => 0,
                'col' => 0,
                'code' => Seat::generateSeatCode(1),
            ]);
        }

        // すべての座席の location 情報を設定
        $all_seats = [];
        for ($row = 1 ; $row <= $this->rows ; $row++) {
            for ($col = 1 ; $col <= $this->cols ; $col++) {
                array_push($all_seats, $row . '-' . $col);
            }
        }

        if ($seats) {
            $has_record = $seats->map(function ($item, $key) {
                return $item->row . '-' . $item->col;
            })->all();
        } else {
            $has_record = [];
        }

        $seats_to_add = array_diff($all_seats, array_diff($has_record, ['0-0']));

        Seat::bulkInsert($seats_to_add, $this->id);

        // 範囲外の座席を disable に
        $this->seats()
            ->where(function($query) {
                $query->where('row', '>', $this->rows)
                    ->orWhere('col', '>', $this->cols);
            })->update(['enabled' => false]);

    }

    public function mappedSeats()
    {
        $seats = $this->seats;
        $mapped = $seats->mapWithKeys(function ($item) {
            return [$item->row . '-' . $item->col => $item->enabled];
        })->all();
        return $mapped;
    }

}
