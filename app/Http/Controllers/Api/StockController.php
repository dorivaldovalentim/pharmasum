<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use DB;

class StockController extends Controller
{
    //
    public function list(){
        return response()->json([
            'stock' => Stock::join('products', 'products.id', 'stocks.product_id')->select('stocks.*', 'products.product', 'products.barcode')->get(),
            'products' => Product::orderBy('product')->get()
        ]);
    }

    public function store(Request $request){
        
        Stock::create([
            'product_id' => $request->product_id, 
            'qtd' => $request->qtd, 
            'expire_date' => $request->expireDate, 
            'manufacture_date' => $request->manufactureDate
        ]);

        return response()->json(['message' => 'Produto adicionado ao stock com sucesso!', 'success' => true]);    
    }

    public function add(Request $request){
        
        foreach ($request->products as $product) {
            
            $stock = Stock::where('product_id', $product['product_id'])->where('expire_date', $product['expireDate'])->first();/* ->where('expire_date', $product->expireDate)->first() */;
            
            if($stock){
                
                $stock->qtd += $product['qtd'];

                $stock->save(); 
            }
            else {
                Stock::create([
                    'product_id' => $product['product_id'], 
                    'qtd' => $product['qtd'], 
                    'expire_date' =>  $product['expireDate'], 
                ]);
            }
        }

        return true;    
    }

    public function reduce(Request $request){
        
        DB::beginTransaction();
        try{

            foreach ($request->products as $product) {
               
                $stock = Stock::where('product_id', $product['product_id'])->first();
    
                $stock->qtd -= $product['qtd'];
    
                $stock->save(); 
            }
            
            DB::commit();
            
            return true;    
        }
        catch(\Throwable $th){
            
            DB::rollback();
            
            return false;
        }
    }
    
    public function update(Request $request){
        
        $stock = Stock::findOrFail($request->id);

        $stock->qtd = $request->qtd;

        $stock->save(); 

        return response()->json(['message' => 'Stock actualizado com sucesso!', 'success' => true]);    
    }
    
    public function destroy($id){
        
        $stock = Stock::findOrFail($id)->delete();

        return response()->json(['message' => 'Produto removido do stock com sucesso!', 'success' => true]);    
    }
    
}
