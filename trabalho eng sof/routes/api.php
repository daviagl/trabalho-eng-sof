<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/employees', function () {
    $employees = Employee::all();
    return response()->json($employees);
});

Route::get("/employees/{id}", function ($id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['message' => 'funcionario not found'], 404);
    }
    return response()->json($employee);
});

Route::post("/employees", function (Request $request) {
    $employee = new Employee();
    $employee->name = $request->input('name');
    $employee->cpf = $request->input('cpf');
    $employee->email = $request->input('email');
    $employee->phone = $request->input('phone');
    $employee->basesalary = $request->input('basesalary');
    $employee->department_id = $request->input('department_id');
    $employee->save();
    return response()->json($employee);
});

Route::patch("/employees/{id}", function (Request $request, $id) {
    $employee = Employee::find($id);

    if (!$employee) {
        return response()->json(['message' => 'Funcionario not found'], 404);
    }

    if($request->input('name') !== null){
        $employee->name = $request->input('name');
    }
    
    if($request->input('cpf') !== null){
        $employee->cpf = $request->input('cpf');
    }

    if($request->input('email') !== null){
        $employee->email = $request->input('email');
    }

    if($request->input('phone') !== null){
        $employee->phone = $request->input('phone');
    }

    if($request->input('basesalary') !== null){
        $employee->basesalary = $request->input('basesalary');
    }

    $employee->save();
    return response()->json($employee);
});

Route::delete('/employees/{id}', function ($id){
    $employee = Employee::find($id);

    if (!$employee) {
        return response()->json(['message' => 'Funcionário not found'], 404);
    }

    $employee->delete();

    return response()->json($employee);
});

Route::get('/employees/departments', function () {
    $employees = Employee::with('department')->get();
    return response()->json($employees);
});

Route::get('/employees/{id}/department', function ($id) {
    $employee = Employee::with('department')->find($id);
    
    if (!$employee) {
        return response()->json(['message' => 'Funcionario not found'], 404);
    }

    return response()->json($employee->department);
});

/* ------------------------------------------------------------------------------------- */

Route::get('/departments', function () {
    $departments = Department::all();
    return response()->json($departments);
});

Route::get("/departments/{id}", function ($id) {
    $department = Department::find($id);

    if (!$department) {
        return response()->json(['message' => 'Departamento not found'], 404);
    }

    return response()->json($department);
});

Route::post("/departments", function (Request $request) {
    $department = new Department();
    $department->name = $request->input('name');
    $department->description = $request->input('description');

    $department->save();
    return response()->json($department);
});

Route::patch("/departments/{id}", function (Request $request, $id) {
    $department = Department::find($id);

    if (!$department) {
        return response()->json(['message' => 'Departamento not found'], 404);
    }

    if($request->input('name') !== null){
        $department->name = $request->input('name');
    }
    
    if($request->input('description') !== null){
        $department->description = $request->input('description');
    }

    $department->save();
    return response()->json($department);
});

Route::delete('/departments/{id}', function ($id){
    $department = Department::find($id);

    if (!$department) {
        return response()->json(['message' => 'Departamento not found'], 404);
    }

    $department->delete();

    return response()->json($department);
});

Route::get('/departments/employees', function () {
    $departments = Department::with('employees')->get();
    return response()->json($departments);
});

Route::get('/department/{id}/employees', function ($id) {
    $department = Department::with('employees')->find($id);

    if (!$department) {
        return response()->json(['message' => 'Departamento not found'], 404);
    }

    return response()->json($department->employees);
});
