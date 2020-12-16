<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class EmployeeController extends Controller
{
    //
    public function list(){
        return response()->json(User::orderBy('id', 'DESC')->get());
    }

    public function store(Request $request){

        $employee = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'bi' => $request->bi,
            'phone' => $request->phone_number,
            'address' => $request->address,
            'password' => Hash::make(12345678),
        ]);

        if($employee)
            return response()->json(['message' => 'Funcionário cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $employee = User::findOrFail($id);   
       // $employee->first_name = $request->first_name;
       // $employee->last_name = $request->last_name;
        $employee->phone = $request->phone_number;
       // $employee->username = $request->username;
        $employee->email = $request->email;
       // $employee->bi = $request->bi;
       // $employee->address = $request->address;
        $employee->save();

        return response()->json(['message' => 'Dados funcionário actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $user = User::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $user]);
        
    }

    public function destroy($id){
        
        User::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Funcionário apagado com sucesso!', 'success' => true]);
        
    }
}
