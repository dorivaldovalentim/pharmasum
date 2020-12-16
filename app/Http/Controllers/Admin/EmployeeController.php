<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    //
    
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        return view('employees.index');
    }

}
