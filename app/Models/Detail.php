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
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function insurances()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
    
    public function titleDetails()
    {
        return $this->belongsTo(TitleDetail::class, 'title_detail_id');
    }

    public function rateType()
    {
        return $this->hasMany(RateType::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}