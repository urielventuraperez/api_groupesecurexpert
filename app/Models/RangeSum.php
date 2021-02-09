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
        'sum', 'value'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function rangeYear(){
        return $this->belongsTo(RangeYear::class);
    }
}
