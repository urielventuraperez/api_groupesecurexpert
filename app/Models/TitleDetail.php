<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitleDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'content'
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
        return $this->belongsToMany('App\Models\Company', 'details');
    }

}