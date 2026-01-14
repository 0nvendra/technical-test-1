<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyReq;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $datas = CompanyResource::collection(Company::paginate(5)); //<-- ini ambil dari Resources/Company Resource
        return Inertia::render($this->dir . $funcName, [
            'title' => $this->name,
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

    public function store(StoreCompanyReq $request)
    {

        DB::beginTransaction();
        try {
            // validasi dulu pak
            $data = $request->validated();
            if ($request->hasFile('logo')) {

                $logo = $request->file('logo');
                $filename = time() . '.' . $logo->getClientOriginalExtension();

                // menggunakan intervention image refrensi: https://image.intervention.io/v3
                $manager = new ImageManager(new Driver());
                $image = $manager->read($logo->getPathname());
                // resize ke 300x300
                $image->scale(width: 300);

                // jadikan string atau path buat simpan ke db
                $hasil = 'img/' . Str::lower($this->dir) . $filename;
                // return $hasil;
                $data['logo'] =  '/storage/' . $hasil;
                Storage::disk('public')->put($hasil, $image->encode());
            }
            Company::create($data);
            DB::commit();
            // dd($data);
            return redirect()->route('company.index')->with('success', 'Company Enrolled');
            // return response()->json('allright', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return redirect()->back()->with('error', 'Failed to create company');
        }
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
