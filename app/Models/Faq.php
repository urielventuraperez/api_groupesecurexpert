<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ask',
        'answer',
        'active',
        'slug'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}