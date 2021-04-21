<?php
namespace App\Models;

use App\Models\Detail;
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

    public function details()
    {
        return $this->hasMany(Detail::class, 'details');
    }

    public static function saveTitleDetails($id_company, $id_insurance)
    {
        $titleDetails = TitleDetail::all();
        foreach ($titleDetails as $titleDetail) {
            $detail = new Detail();
            $detail->companies()->associate($id_company);
            $detail->insurances()->associate($id_insurance);
            $detail->titleDetails()->associate($titleDetail);
            $detail->save();
        };
    }

}