<?php

namespace App\Models;

require '../vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Illuminate\Database\Eloquent\Model;

class InvoicePrinter extends Model
{
    //
    
    public function invoice($itens){

        $data = Information::first();
        $subtotal = 0;
        $factura = 1;
        $connector = new WindowsPrintConnector("POS-80C");
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
  /*       try{
            $logo = EscposImage::load("$data->logotipo", false);
            $printer->bitImage($logo);
        }catch(Exception $e){} */

        $printer->text("\n" . "Farmâcia COERSUM" . "\n");
        $printer->text("\n" . "Tel: $data->telefone" . "\n");
        $printer->text("\n" . "Email: $data->email" . "\n");
        $printer->text("\n" . "Factura:: $factura" . "\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);

        $printer->text("\n" . "Produtos" . "\n");
        $printer->text("Produto       preço/Uni        Qtd        Preço");
      /*   foreach($itens as $item){
        $printer->text("\n" . "$item->product                            $item->price  \n");
        } */
        $printer->text("-----------------------------------------------");
        $printer->text("SUBTOTAL:      $subtotal");
        $printer->text("IVA:      X");
        $printer->text("TOTAL:      $subtotal");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Compra efectuada em " . date("d-m-Y H:i:s") . "\n");
        $printer->text("Obrigado e volte sempre\n");
        $printer->cut();
        $printer->close();
    }
}
