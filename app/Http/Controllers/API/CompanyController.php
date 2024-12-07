<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'company_name' => 'required|string',
            'gst_number' => [
                'required',
                'string',
                'unique:companies,gst_number',
                'regex:/^[A-Za-z0-9]+([-:][A-Za-z0-9]+)*$/', 
                'between:8,12'
            ],
        ];

        $messages = [
            'company_name.required' => 'Company name is required.',
            'gst_number.required' => 'GST number is required.',
            'gst_number.regex' => 'GST number Invalid',
            'gst_number.unique' => 'GST number already exists.',
            'gst_number.between' => 'GST number Invalid',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // If validation fails, return the errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        // Store the company data in the database
        $company = new Company();
        $company->company_name = $request->input('company_name');
        $company->gst_number = $request->input('gst_number');
        $company->save(); // Save the company to the database

        return response()->json([
            'success' => true,
            'message' => 'GST number is verified',
            'company' => $company
        ], 201);
    }
}
