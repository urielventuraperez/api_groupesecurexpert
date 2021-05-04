<?php

namespace App\Models;

use App\Models\RangeSum;
use Illuminate\Database\Eloquent\Model;

class RateType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function details() {
        return $this->belongsTo(Detail::class);
    }

    public function rangeSums() {
        return $this->hasMany(RangeSum::class);
    }

    public function viewRangeSums($idRateType)
    {
        $rangeSum = RangeSum::where('rate_type_id', $idRateType)->get();

        if ($rangeSum) return $rangeSum;

        return [];
    }

}
