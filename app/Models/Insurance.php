<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Detail;

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

    public static function companyDetails($id_company, $id_insurance)
    {
      return Detail::where('company_id', $id_company)
                ->where('insurance_id', $id_insurance)
                ->leftJoin('title_details', 'details.title_detail_id', '=', 'title_details.id')
                ->select('title_details.name', 'details.*')
                ->get();
    }

}