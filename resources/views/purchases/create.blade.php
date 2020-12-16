@extends('layouts.dashboard') 

@section('title', 'Efectuar Compra')

@section('content')
    <purchases-create-component user_id="{{ Auth::id() }}"></purchases-create-component>
@endsection
