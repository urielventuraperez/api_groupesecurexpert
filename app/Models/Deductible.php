<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deductible extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_saving',
        'value',
        'percentage'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $attributes = [
        'is_saving' => true,
    ];
}