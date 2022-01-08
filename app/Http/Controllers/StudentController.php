<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        return view('student.index');
    }

    public function getstudent(){
        $student = Student::all();
        return response()->json([
            'students'=>$student,
        ]);
    }

    public function store(Request $request){

        $validator = validator::make($request->all(), [
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'phone'=>'required|max:191',
            'course'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = new Student;
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'Student Added Successfully',
            ]);
        }


    }

    public function editstudent($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found',
            ]);
        }
    }

    public function update(Request $request,$id){
        $validator = validator::make($request->all(), [
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'phone'=>'required|max:191',
            'course'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = Student::find($id);
            if($student){
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->course = $request->input('course');
                $student->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully',
                ]);

            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Student Not Found',
                ]);
            }

        }
    }

    public function delete($id){
        $student = Student::find($id)->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Student delete successfully',
        ]);
    }




}
