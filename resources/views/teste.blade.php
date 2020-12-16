<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/flat-blue.css') }}">
    <style>
        .recibo{ width: 350px; margin: 0 auto; border: 1px solid rgba(212, 212, 212, 1);}
        .table, td, th, table{ border: none!important; }
    </style>
</head>

<body class="">
    <div id="app">
        <main class="py-4">
            <div class="recibo">
                <table class="table table-sm">
                    <tr><th colspan="4">Farmâcia COERSUM</th></tr>
                    <tr><td colspan="4" class="text-left pl-4">Telefone: data->telefone</td></tr>
                    <tr><td colspan="4" class="text-left pl-4">Email: data->email</td></tr>
                    <tr><td colspan="4" class="text-left pl-4">Factura: factura</td></td>
                    <tr>
                        <th class="text-left pl-4">Produto</th>
                        <th>Preço/Uni</th>
                        <th>Qtd</th>
                        <th>Preço</th>
                    </tr>
                    <tr>
                        <td>SUBTOTAL</td>
                        <td></td>
                        <td></td>
                        <td>subtotal</td>
                    </tr>
                    <tr><td colspan="4">Compra efectuada em @php date("d-m-Y H:i:s") @endphp</td></tr>
                    <tr><td colspan="4">Obrigado e volte sempre</td></tr>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
