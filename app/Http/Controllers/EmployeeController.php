<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Employee;

class EmployeeController extends Controller
{
	public function loadEmployees(Request $request)
	{
		if ($request->ajax()) {

			$data = Employee::all();

			return Datatables::of($data)->addIndexColumn()
				->addColumn('first_name', function ($row) {
					return $row->first_name;
				})
				->addColumn('last_name', function ($row) {
					return $row->last_name;
				})
				->addColumn('gender', function ($row) {
					return $row->gender;
				})
				->addColumn('birthday', function ($row) {
					return date('M d, Y', strtotime($row->birthday));
				})
				->addColumn('monthly_salary', function ($row) {
					return "P" . number_format($row->monthly_salary);
				})
				->addColumn('action', function ($row) {
					$btn = "";
					$btn .= "<button class='btn btn-success btn-sm btn-edit mb-1' data-id='" . $row->id . "'>Edit</button>";
					$btn .= "<button class='btn btn-danger btn-sm btn-delete ms-1 mb-1' data-id='" . $row->id . "'>Delete</button>";
					return $btn;
				})
				->rawColumns(['first_name', 'last_name', 'gender', 'birthday', 'monthly_salary', 'action'])
				->make(true);
		}
	}

	public function saveEmployee(Request $request)
	{
		$result = array();
		$input = $request->all();

		$condition = [
			'first_name' => $input['firstName'],
			'last_name' => $input['lastName'],
			'birthday' => $input['birthday']
		];

		$checkIfExist = Employee::where($condition)
			->first();
		if (!empty($checkIfExist)) {
			$result['success'] = false;
			$result['msg'] = "Employee already exist.";
		} else {
			$employee = new Employee;
			$employee->first_name = $input['firstName'];
			$employee->last_name = $input['lastName'];
			$employee->gender = $input['gender'];
			$employee->birthday = $input['birthday'];
			$employee->monthly_salary = $input['monthlySalary'];

			if ($employee->save()) {
				$result['success'] = true;
			} else {
				$result['success'] = false;
				$result['msg'] = "Something went wrong. Please try again";
			}
		}

		return response()->json($result);
	}

	public function deleteEmployee(Request $request)
	{
		$result = array();
		$id = $request->id;

		Employee::where('id', $id)->delete();
		$result['success'] = true;
		return response()->json($result);
	}

	public function editEmployeeForm(Request $request)
	{
		$result = array();
		$output = "";
		$id = $request->id;

		$employeeInfo = Employee::where("id", $id)->first();
		$genderOutput = "";
		$genders = array('Male', 'Female');

		foreach ($genders as $gender) {
			$selected = ($gender == $employeeInfo['gender']) ? "selected" : "";

			$genderOutput .= "<option " . $selected . " value='" . $gender . "'>" . $gender . "</option>";
		}

		$output = '
			<input type="hidden" name="id" id="edit_id" value="' . $id . '" />
			<div class="form-group mb-2">
				<label>First Name</label>
				<input type="text" name="firstName" id="edit_firstName" class="form-control" value="' . $employeeInfo['first_name'] . '" />
			</div>
			<div class="form-group mb-2">
				<label>Last Name</label>
				<input type="text" name="lastName" id="edit_lastName" class="form-control" value="' . $employeeInfo['last_name'] . '" />
			</div>
			<div class="form-group mb-2">
				<label>Birthday</label>
				<input type="date" name="birthday" id="edit_birthday" class="form-control" value="' . $employeeInfo['birthday'] . '" />
			</div>
			<div class="form-group mb-2">
				<label>Gender</label>
				<select name="gender" id="edit_gender" class="form-control">
					' . $genderOutput . '
				</select>
			</div>
			<div class="form-group mb-2">
				<label>Monthly Salary</label>
				<div class="input-group mb-3">
				<span class="input-group-text" id="addons">P</span>
					<input type="number" name="monthlySalary" id="edit_monthlySalary" class="form-control" aria-describedby="addons" value="' . $employeeInfo['monthly_salary'] . '">
				</div>
			</div>
        ';

		$result['output'] = $output;
		return response()->json($result);
	}

	public function updateEmployee(Request $request)
	{
		$result = array();

		$input = $request->all();

		$updatedData = array(
			'first_name' => $input['firstName'],
			'last_name' => $input['lastName'],
			'gender' => $input['gender'],
			'birthday' => $input['birthday'],
			'monthly_salary' => $input['monthlySalary']
		);

		$update = Employee::where('id', $input['id'])
			->update($updatedData);
		if ($update) {
			$result['success'] = true;
		} else {
			$result['success'] = false;
			$result['msg'] = "Something went wrong. Please try again";
		}

		return response()->json($result);
	}
}
