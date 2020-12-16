<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Costumer;

class ClientController extends Controller
{
    //
    public function list(){
        return response()->json(Costumer::orderBy('id', 'DESC')->get());
    }

    public function store(Request $request){
       
        $client = Costumer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'address' => $request->address,
        ]);

        if($client)
            return response()->json(['message' => 'Cliente cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $client = Costumer::findOrFail($id);   
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone_number;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->save();

        return response()->json(['message' => 'Dados do cliente actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $user = Costumer::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $user]);
        
    }

    public function destroy($id){
        
        Costumer::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Cliente apagado com sucesso!', 'success' => true]);
        
    }
}
