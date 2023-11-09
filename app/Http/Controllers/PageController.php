<?php

namespace App\Http\Controllers;

use App\Models\Employee;

use Carbon\Carbon;

class PageController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function home()
    {
        $data = array();

        $data['maleCount'] = Employee::where("gender", "Male")->count();
        $data['femaleCount'] = Employee::where("gender", "Female")->count();
        $data['totalSalary'] = Employee::all()->sum('monthly_salary');

        $allEmployees = Employee::all();
        $ages = array();
        $totalEmployees = count($allEmployees);
        foreach ($allEmployees as $employee) {
            $dateOfBirth = date('Y-m-d', strtotime($employee['birthday']));

            $age = Carbon::parse($dateOfBirth)->age;
            $ages[] = $age;
        }

        $average = array_sum($ages) / $totalEmployees;
        $data['averageAge'] = round($average);
        return view('home', $data);
    }

    public function records()
    {
        return view('records');
    }
}
