@extends('layouts.dashboard') 

@section('title', 'Consultar Compras')

@section('content')
    <purchases-component user_id="{{ Auth::id() }}"></purchases-component>
@endsection
