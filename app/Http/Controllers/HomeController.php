<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'sales' => Sale::whereUserId(Auth::id())->count(),
            'products' => Product::get()->count()
        ];

        return view('home', compact('data'));
    }

    public function settings(){
        return view('settings.index');
    }
}
