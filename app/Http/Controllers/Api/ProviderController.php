<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provider;

class ProviderController extends Controller
{
    //
    public function list(){
        return response()->json(Provider::orderBy('id', 'DESC')->get());
    }

    public function store(Request $request){
       
        $provider = Provider::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'address' => $request->address,
        ]);

        if($provider)
            return response()->json(['message' => 'Fornecedor cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $provider = Provider::findOrFail($id);   
        $provider->name = $request->name;
        $provider->phone = $request->phone_number;
        $provider->email = $request->email;
        $provider->address = $request->address;
        $provider->save();

        return response()->json(['message' => 'Dados do Fornecedor actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $user = Provider::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $user]);
        
    }

    public function destroy($id){
        
        Provider::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Fornecedor apagado com sucesso!', 'success' => true]);
        
    }
}
