<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'years'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function rangeSums()
    {
        return $this->hasMany(RangeSum::class);
    }

}