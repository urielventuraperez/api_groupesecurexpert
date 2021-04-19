<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function companies()
    {
      return $this->belongsToMany(Company::class)->withTimestamps()->withPivot('created_at');
    }

    public function details()
    {
      return $this->hasMany(Details::class);
    }

}