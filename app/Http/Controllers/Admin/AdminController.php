<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Costumer;
use App\Models\Product;
use App\Models\Sale;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'employees' => User::get()->count(),
            'clients' => Costumer::get()->count(),
            'products' => Product::get()->count(),
            'sales' => Sale::get()->count(),
        ];
        return view('admin-home', compact('data'));
    }
}
