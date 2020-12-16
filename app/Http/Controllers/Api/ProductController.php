<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Provider;

class ProductController extends Controller
{
    //
    public function list(){
        return response()->json([
            'products' => Product::join('categories', 'categories.id', 'category_id')
                                ->join('manufacturers', 'manufacturers.id', 'manufacturer_id')
                                ->leftjoin('stocks', 'stocks.product_id', 'products.id')
                                ->select('products.*', 'manufacturers.manufacturer', 'categories.category', 'stocks.qtd', 'stocks.expire_date')
                                ->orderBy('product')->get(),
            'categories' => Category::orderBy('category')->get(),
            'manufacturers' => Manufacturer::orderBy('manufacturer')->get(),
            'providers' => Provider::orderBy('name')->get(),
        ]);
    }

    public function listProductsToSale(){
        return response()->json([
            'products' => Product::join('categories', 'categories.id', 'category_id')
                                ->join('manufacturers', 'manufacturers.id', 'manufacturer_id')
                                ->leftjoin('stocks', 'stocks.product_id', 'products.id')
                                ->select('products.*', 'manufacturers.manufacturer', 'categories.category', 'stocks.qtd', 'stocks.expire_date')
                                ->where('stocks.qtd', '>', 0)
                                ->orderBy('product')->get(),
            'categories' => Category::orderBy('category')->get(),
            'manufacturers' => Manufacturer::orderBy('manufacturer')->get(),
            'providers' => Provider::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request){
        
        $product = Product::create($request->all());

        if($product)
            return response()->json(['message' => 'Produto cadastrado com sucesso!', 'success' => true]);    
    }
    
    public function update(Request $request, $id){
        $product = Product::findOrFail($id);   
        $product->product = $request->product;
        $product->category_id = $request->category_id;
        $product->manufacturer_id = $request->manufacturer_id;
        $product->details = $request->details;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->place = $request->place;
        $product->save();

        return response()->json(['message' => 'Dados do Produto actualizado com sucesso!', 'success' => true]);  
    }

    public function edit($id){
        
        $user = Product::findOrFail($id);
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'result' => $user]);
        
    }

    public function destroy($id){
        
        Product::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Produto apagado com sucesso!', 'success' => true]);
        
    }
}
