<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    

    public function getAllStudents() {
        return Student::all();


    }


    public function addStudent(Request $request) {


        try {

            $event = new Student;

            $student->name = $request->name;
            $student->grade = $request->grade;
        
            $student->save();

            return response()->json(["message"=>"successfully added student"], 201);

        } 
        
        catch (Exception $e) {
            return response()->json(["message"=>$e->getMessage()], 500);
        }
    }
}
