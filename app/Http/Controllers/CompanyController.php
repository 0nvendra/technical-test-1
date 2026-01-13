<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyReq;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $name = 'Company';
    private $dir = 'Company/';

    public function index()
    {
        $funcName = 'Index';
        //refrensi https://laravel.com/docs/12.x/eloquent-resources#resource-collections
        $datas = CompanyResource::collection(Company::paginate(5));
        return Inertia::render($this->dir . $funcName, [
            'title' => $this->name . ' - ' . $funcName,
            // 'columns' => $columns,
            'datas' => $datas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyReq $request) // implementasi rule/request pada at number 11
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // return $company;
        DB::beginTransaction();
        try {
            $company->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        // return response()->json(['status' => 'success'], 200);
        //
    }
}
