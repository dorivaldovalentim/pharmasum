<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;

class PurchaseController extends Controller
{
    //

    public function list(){
        return response()->json([
            'purchases' => Purchase::join('providers', 'purchases.provider_id', 'providers.id')
                            ->select('providers.name', 'purchases.*')->orderBy('id', 'DESC')->get()
        ]);
    }

    public function store(Request $request){

        $purchase = Purchase::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'date' => date('Y-m-d'),
            'provider_id' => $request->provider_id,
        ]);
        
        foreach ($request->products as $product) {
            
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product['product_id'],
                'purchase_price' => $product['price'],
                'qtd' => $product['qtd']
            ]);
        }
        
        if((new StockController)->add($request)){

            return response()->json(['message' => 'Compra registada com sucesso!', 'success' => true]);    
        }

        return response()->json(['message' => 'Erro ao efectuar o registo da compra!', 'success' => false]);    
            
    }
    
    public function show($id){
        
        $products = PurchaseItem::wherePurchaseId($id)->join('products', 'products.id', 'purchase_items.product_id')
                                ->select('purchase_items.*', 'products.product')->get();
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'products' => $products]);
        
    }

}
