@extends('layouts.dashboard') 

@section('title', 'Consultar Vendas')

@section('content')
    <list-sales-component user_id="{{Auth::user()->id}}"></list-sales-component>
@endsection
