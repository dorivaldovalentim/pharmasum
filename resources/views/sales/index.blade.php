@extends('layouts.dashboard') 

@section('title', 'Consultar minhas Vendas')

@section('content')
    <sales-component user_id="{{Auth::user()->id}}"></sales-component>
@endsection
