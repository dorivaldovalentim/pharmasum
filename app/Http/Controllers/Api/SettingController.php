<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class SettingController extends Controller
{
    //

    public function userData($id){
        
        $user = User::findOrFail($id);

        return response()->json(['message' => 'Dados actualizado com sucesso!', 'success' => true, 'data' => $user]); 
        
    }

    public function updateUser(Request $request, $id){
    
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        return response()->json(['message' => 'Dados actualizado com sucesso!', 'success' => true]); 

    }

    public function updateUserPassword(Request $request, $id){
        
        $user = User::findOrFail($id);
        
        if(password_verify($request->old_password, $user->password)){
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['message' => 'Senha actualizada com sucesso!', 'success' => true]); 
        }
       
        return response()->json(['message' => 'Erro ao actualizar a senha!', 'success' => false]); 
    }

}
