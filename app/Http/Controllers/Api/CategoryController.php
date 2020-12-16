<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function list(){
        return response()->json(Category::orderBy('category')->get());
    }

    public function store(Request $request){
        
        $category = Category::create([
            'category' => $request->category,
        ]);

        if($category)
            return response()->json(['message' => 'Categoria cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $category = Category::findOrFail($id);   
        $category->category = $request->category;
        $category->save();

        return response()->json(['message' => 'Categoria actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $category = Category::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $category]);
        
    }

    public function destroy($id){
        
        Category::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Categoria apagada com sucesso!', 'success' => true]);
        
    }
}
