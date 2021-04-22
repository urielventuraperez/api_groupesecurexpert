<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Detail;
use App\Models\Deductible;
use App\Models\Insurance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Validator;

class CompanyController extends Controller
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

    public function index()
    {
        $companies = Company::with('insurances')->get();
        if ($companies) {
            return response([
                'status' => true,
                'message' => '',
                'data' => $companies
            ]);
        } else {
            return response([
                'status' => false,
                'message' => 'doesn´t exist registers',
                'data' => []
            ]);
        }
    }

    public function show($id)
    {
        try{
        $company = Company::with('insurances')->findOrFail($id);
            foreach($company->insurances as $insurance) {
                $id_insurance = $insurance->id;
                $details = Detail::where('company_id', $id)
                    ->where('insurance_id', $id_insurance)
                    ->leftJoin('title_details', 'details.title_detail_id', '=', 'title_details.id')
                    ->select('title_details.name', 'details.*')
                    ->get();
                $insurance['details'] = $details;
            };

            return response([
                'status' => true,
                'message' => '',
                'data' => $company
            ]);
        } catch (Exception $e) {
            return response(['status' => false, 'message' => 'doesn´t exist the register']);
        }
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'quote' => 'min:10',
            'order_url' => 'min:10'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $slug = Str::of($request->name)->slug('-');
        // Check if Slug exists
        $checkSlug = Company::where('slug', 'like', '%' . $slug . '%')->get();

        if ($checkSlug->count() == 0) {
            $input['slug'] = $slug;
        } else {
            $input['slug'] = $slug . '-' . $checkSlug->count();
        }

        $input['logo'] = $input['slug'].'-'.$request->file('logo')->getClientOriginalName();

        $company = new Company();

        if (!$company->create($input)) {
            return response(['status' => false, 'message' => 'retry again, cannot save the register', 'data' => []]);
        }

        $request->file('logo')->storeAs("companies", $input['logo']);

        $newCompany = Company::where('slug', $input['slug'])->first();

        return response(['status' => true, 'message' => 'Register successfully created!', 'data' => $newCompany]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        $company->name = $request->name ?? $company->name;
        $company->slug = $request->slug ?? $company->slug;
        $company->description = $request->description ?? $company->description;
        $company->quote = $request->quote ?? $company->quote;
        $company->order_url = $request->order_url ?? $company->order_url;

        $logo = $company->logo;

        if($request->logo) {
            $company->logo = $company->slug.'-'.$request->file('logo')->getClientOriginalName();
            Storage::delete('companies/'.$logo);
            $request->file('logo')->storeAs("companies", $company->logo);
        }

        if (!$company->save()) {
            return response(['status' => false, 'message' => 'retry again, cannot update the register', 'data' => []]);
        }

        return response([
            'status' => true, 
            'message' => 'Register successfully updated!', 
            'data' => $company
        ]);
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $logo = $company->logo;
        if (!$company->delete()) {
            return response(['status' => false, 'message' => 'retry again, cannot delete the register', 'data' => []]);
        }

        Storage::delete('companies/'.$logo);

        return response(['status' => true, 'message' => 'Register successfully deleted!', 'data' => []]);
    }

    public function active($id)
    {
        $company = Company::findOrFail($id);

        $company->active = !$company->active;

        if (!$company->save()) {
            return response(['status' => false, 'message' => 'retry again, cannot delete the register', 'data' => []]);
        }

        return response(['status' => true, 'message' => 'Register successfully updated!', 'data' => $company->active]);
    }

}
