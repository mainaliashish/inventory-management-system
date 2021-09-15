<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salaries = DB::table('salaries')
        ->select('salary_month')
        ->groupBy('salary_month')
        ->get();
        return response()->json($salaries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paid(Request $request, $id)
    {
        $validateData = $request->validate([
            'amount' => 'required',
            'salary_month' => 'required',
        ]);
        $data = array();
        $month = $request->salary_month;
        $year = $request->salary_year;
        $check = DB::table('salaries')->where('employee_id', $id)
                                      ->where('salary_month', $month)
                                      ->first();
        if($check) {
            return response()->json(['error' => 'Salary already paid.']);
        } else {
        $data['employee_id'] =  $id;
        $data['amount'] = $request->amount;
        $data['salary_date'] = date('d/m/Y');
        $data['salary_month'] =  $request->salary_month;
        $data['salary_year'] =  date('Y');
        DB::table('salaries')->insert($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id   
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary = Salary::find($id);
        return response()->json($salary);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSalary(Request $request, $id)
    {
        $data = array();
        $data['employee_id'] = $request->employee_id;
        $data['amount'] = $request->amount;
        $data['salary_month'] = $request->salary_month;
        $data['salary_date'] = date('d/m/Y');
        $data['salary_year'] = date('Y');
        DB::table('salaries')->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view($id) {
        $month = $id;
        $salaries = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'salaries.*')
            ->where('salaries.salary_month', $month)
            ->get();
        return response() -> json($salaries);
    }

    public function editSalary($id)
    {
        $salary = DB::table('salaries')
        ->join('employees', 'salaries.employee_id', 'employees.id')
        ->select('employees.name', 'employees.email', 'salaries.*')
        ->where('salaries.id', $id)
        ->first();

        return response() -> json($salary);


    }

}
