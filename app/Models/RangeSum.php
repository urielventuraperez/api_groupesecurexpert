<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RangeSum extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sum', 'years'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function rateType(){
        return $this->belongsTo(RateType::class);
    }
}
