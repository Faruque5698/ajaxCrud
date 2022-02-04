<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
//use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function index(){
        return view('employee');
    }

    public function store(Request $request){
        $employee = new Employee();

        $employee_image = $request->file('image');

        $employee->name = $request->name;
        $employee->phone = $request->phone;

        if ($employee_image) {
            $imageName = $employee_image->getClientOriginalName();
            $directory = 'image/employee/';
            $imageUrl = $directory . $imageName;
            $employee_image->move($directory, $imageName);
            $employee->image = $imageUrl;
        }
        $employee->save();

        return response()->json([
           'status'=>200,
            'message' =>'successfully data save'
        ]);
    }

    public function show(){
        $employee = Employee::all();
        return response()->json([

           'employee'=>$employee
        ]);
    }

    public function edit($id){
        $employee = Employee::find($id);

        if ($employee){
            return response()->json([
               'status'=>200,
               'employee'=>$employee
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>"data not found"
            ]);
        }


    }

    public function update(Request $request){
        $employee = Employee::find($request->emp_id);

//        return $employee;


            $employee_image = $request->file('image');
            if ($employee_image){
                unlink($employee->image);
                $imageName = $employee_image->getClientOriginalName();
                $directory ='image/employee/';
                $imageUrl = $directory . $imageName;
                $employee_image->move($directory, $imageName);

                $employee->name = $request->name;
                $employee->phone = $request->phone;
                $employee->image = $imageUrl;

                $employee->save();
            }else{
                $employee->name = $request->name;
                $employee->phone = $request->phone;
//                $employee->image = $imageUrl;

                $employee->save();
            }

            return response()->json([
                'status'=>200,
                'message'=>'Employee Updated'
            ]);




    }

    public function delete($id){
        $employee = Employee::find($id);
        $employee->delete();
        return response()->json([
           'status'=>200,
           'message'=>'Employee Deleted Successfully'
        ]);
    }
}
