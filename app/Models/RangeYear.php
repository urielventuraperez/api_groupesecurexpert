<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RangeYear extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'range'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function rates() {
        return $this->belongsTo(Rate::class);
    }

    public function rangeSums() {
        return $this->hasMany(RangeSum::class);
    }

}
