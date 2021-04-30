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
        'option',
        'applicable'
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

    public function detail()
    {
        return $this->belongsTo(Detail::class);
    }
}