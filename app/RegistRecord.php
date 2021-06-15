<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistRecord extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'seat_id', 
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
    public function seat() {
        return $this->belongsTo('App\Seat');
    }
    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function createRecord($user, $seat)
    {
        $record = new RegistRecord();
        $record->seat()->associate($seat);
        $record->user()->associate($user);
        $record->save();
        return $record;
    }
}
