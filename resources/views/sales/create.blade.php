@extends('layouts.dashboard') 

@section('content')
    <sales-create-component user_id="{{Auth::user()->id}}"></sales-create-component>
@endsection
