<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use App\Models\Sale;
use App\Models\Stock;
use DB;


class SaleController extends Controller
{
    //
    public function list($id){
        return response()->json([
            'sales' => Sale::join('users', 'users.id', 'user_id')
                            ->select('sales.*', 'users.first_name', 'users.last_name')
                            ->whereUserId($id)->orderBy('id', 'DESC')->get(),
            //'products' => Sale::join('products', 'products.id', 'product_id')->join('users', 'users.id', 'user_id')->orderBy('product')->get(),
        ]);
    }

    public function sales(){
        return response()->json([
            'sales' => Sale::join('users', 'users.id', 'user_id')
                            ->select('sales.*', 'users.first_name', 'users.last_name')
                            ->orderBy('id', 'DESC')->get(),
            //'products' => Sale::join('products', 'products.id', 'product_id')->join('users', 'users.id', 'user_id')->orderBy('product')->get(),
        ]);
    }

    public function store(Request $request){
        
        $sale = Sale::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'amount_recieved' => $request->amount_recieved,
            'amount_change' => $request->amount_change,
        ]);
        
        
        DB::beginTransaction();
        
        try{   

            foreach ($request->products as $product) {
                
                InvoiceItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'sale_price' => $product['price'],
                    'qtd' => $product['qtd']
                ]);
            }
                
            if((new StockController)->reduce($request)){
                
                DB::commit();
                
               $this->invoice($request);
                
                return response()->json(['message' => 'Venda efectuada com sucesso!', 'success' => true]);    
            }

           // (new InvoicePrinter)->inovice($request->products);
            
        }
        
        catch(\Throwable $th){

            DB::rollback();
            
            return response()->json(['message' => 'Erro ao efectuar a venda, verifique a quantidade dos produtos no Stock!', 'success' => false]);    
        }
            
    }
    
    public function update(Request $request, $id){
       
    }

    public function show($id){
        
        $products = InvoiceItem::whereSaleId($id)->join('products', 'products.id', 'invoice_items.product_id')
                                ->select('invoice_items.*', 'products.product')->get();
        
        return response()->json(['message' => 'Operação efectuada com sucesso!', 'success' => true, 'products' => $products]);
        
    }

    public function destroy($id){
        
        Sale::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Venda apagada com sucesso!', 'success' => true]);
        
    }

    public function invoice(Request $request){
      
    }
}
