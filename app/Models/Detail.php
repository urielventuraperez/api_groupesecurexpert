<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function insurances()
    {
        return $this->belongsToMany(Insurance::class);
    }

}