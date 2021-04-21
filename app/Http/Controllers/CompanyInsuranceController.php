<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TitleDetail;
use App\Models\Company;
use App\Models\Insurance;

use Validator;

class CompanyInsuranceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // Necesito devolver los insurances disponibles y todos los titulos de detalles con su contenido
    // Por compañia
    public function index()
    {
        $detail = TitleDetail::paginate(15);

        if ($detail) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $detail
            ]);
        } else {
        }
    }

    public function show($id)
    {
        $detail = TitleDetail::findOrFail($id);
        if ($detail) {
            return response(['status' => true, 'message' => '', 'data' => $detail]);
        } else {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function createInsurance($id_company, $id_insurance)
    {

        if (empty($id_company) && empty($id_insurance)) {
            return response([
                'status' => false, 'message' => 'Please, select an company or insurance', 'data' => []
            ]);
        }

        $company = Company::find($id_company);
        $hasInsurance = $company->insurances()->where('insurance_id', $id_insurance)->exists();

        if ($hasInsurance) {
            return response(['status' => false, 'message' => 'retry again, cannot save the register. Exist the detail.', 'data' => []]);
        }

        $company->insurances()->attach($id_insurance);

        TitleDetail::saveTitleDetails($id_company, $id_insurance);

        foreach ($company->insurances as $insurance) {
            $id_insurance = $insurance->id;
            $details = Insurance::companyDetails($id_company, $id_insurance);
            $insurance['details'] = $details;
        };

        return response([
            'status' => true, 'message' => 'Register successfully created!', 'data' => $company->insurances
        ]);
    }

    public function update(Request $request, $id)
    {
        $detail = TitleDetail::find($id);

        $detail->name = $request['name'] ?? $detail->name;
        $detail->description = $request['description'] ?? $detail->description;

        if (!$detail->save()) {
            return response(['status' => false, 'message' => 'retry again, cannot update the register', 'data' => []]);
        }

        return response(['status' => true, 'message' => 'Register successfully updated!', 'data' => []]);
    }

    public function delete($id)
    {
        $detail = TitleDetail::findOrFail($id);

        if (!$detail->delete()) {
            return response(['status' => false, 'message' => 'retry again, cannot delete the register', 'data' => []]);
        }

        return response(['status' => true, 'message' => 'Register successfully deleted!', 'data' => []]);
    }
}
