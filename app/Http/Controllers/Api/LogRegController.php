<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogRegController extends Controller
{
    public function registerCheck(Request $request) {
        $login = $request->input('login');
        $email = $request->input('email');
        $password = $request->input('password');
        $token = $request->input('token');
        $student = Student::where('sessionID',$token)->first();
        if($student){
            return response()->json([
                'success'=> 1
            ]);
        } else {
            $student = Student::where('email', $email)->first();

            if (!$student) {

                $student = new Student();
                $student->login = $login;
                $student->email = $email;
                $student->password = password_hash($password, PASSWORD_BCRYPT);
                $student->sessionID = $token;
                $student->save();
                return response()->json([
                    'success' => 1
                ]);
            } else {
                return response()->json([
                    'error' => 1
                ]);
            }
        }
    }

    public function logout(Request $request){
        $token = $request->input('token');
        $student = Student::where('sessionID', $token)->first();
        if($student){
            $student->sessionID = "";
            $student->save();
        }
    }

    public function checkLogin(Request $request) {
        $token = $request->input('token');
        $student = Student::where('email', $request->input('login'))->first();
        if(!$student){
            $student = Student::where('login', $request->input('login'))->first();
        }
        $password = $request->input('password');
        if($student){
            if(password_verify($password,$student->password)){
                $student->sessionID = $token;
                $student->save();
                return response()->json([
                    'success'=>1,
                    'username'=> $student->login
                ]);
            } else {
                return response()->json([
                    'error'=>2
                ]);
            }
        } else {
            return response()->json([
                'error'=>1
            ]);
        }
    }

    public function checkLogged(Request $request){
        $token = $request->input('token');
        $student = Student::where('sessionID',$token)->first();
        if($student){
            return response()->json([
                'success'=>1,
                'username'=>$student->login
            ]);
        }
    }
}
