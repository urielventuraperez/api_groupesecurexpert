<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'quote',
        'slug',
        'order_url',
        'logo'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function insurances()
    {
        return $this->hasMany(Detail::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function deductibles()
    {
        return $this->hasMany(Deductible::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

}