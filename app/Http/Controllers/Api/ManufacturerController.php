<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    //
    public function list(){
        return response()->json(Manufacturer::orderBy('id', 'DESC')->get());
    }

    public function store(Request $request){
        
        $manufacturer = Manufacturer::create([
            'manufacturer' => $request->manufacturer,
        ]);

        if($manufacturer)
            return response()->json(['message' => 'Categoria cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $manufacturer = Manufacturer::findOrFail($id);   
        $manufacturer->manufacturer = $request->manufacturer;
        $manufacturer->save();

        return response()->json(['message' => 'Categoria actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $manufacturer = Manufacturer::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $manufacturer]);
        
    }

    public function destroy($id){
        
        Manufacturer::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Categoria apagada com sucesso!', 'success' => true]);
        
    }
}
