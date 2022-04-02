<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function ExerTest(){
        return view('exertest');
    }
}
