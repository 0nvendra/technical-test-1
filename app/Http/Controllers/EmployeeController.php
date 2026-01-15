<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeReq;
use App\Http\Resources\EmployeeResouce;
use App\Models\Company;
use App\Models\Employee;
use App\Notifications\EmployeeNewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $name = 'Employee';
    private $dir = 'Employee/';

    public function index()
    {
        $funcName = 'Index';
        //refrensi https://laravel.com/docs/12.x/eloquent-resources#resource-collections
        $datas = EmployeeResouce::collection(Employee::with(['Company'])->paginate(5)); //<-- ini ambil dari Resources/Employee Resource
        $company = Company::select(['id', 'name'])->get(); //<-- relasi untuk create di dialog nanti
        return Inertia::render($this->dir . $funcName, [
            'title' => $this->name,
            'datas' => $datas,

            // relasi
            'company' => $company,
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
    public function store(StoreEmployeeReq $request) // implementasi rule/request pada at number 11
    {

        DB::beginTransaction();
        try {
            // validasi dulu
            $data = $request->validated();
            $new = Employee::create($data);
            // 
            $new->company->notify(new EmployeeNewNotification($new));
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Employee Enrolled');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEmployeeReq $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $employee->update($data);
            DB::commit();
            return redirect()->route('employee.index')->with('success', 'Company Updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            $employee->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        // return response()->json(['status' => 'success'], 200);
    }
}
