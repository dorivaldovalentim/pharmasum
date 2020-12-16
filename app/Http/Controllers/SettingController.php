<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amdin;
use Auth;

class SettingController extends Controller
{
    //

    public function __construct(){
        $this->middleware(['auth:admin', 'auth']);
    }
    
    public function admin(){
        return view('settings.admin');
    }

    public function updateAdminPassword(Request $request){
        
        $user = Auth::user();

        if($request->password != $request->confirm_password)
            return redirect()->back()->with('msg', 'As senhas não combinam!'); 

        if(password_verify($request->old_password, $user->password)){
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->back()->with('msg', 'Senha actualizada com sucesso!'); 
        }
       
        return redirect()->back()->with('msg', 'Senha antiga incorrecta!'); 
    }
}
