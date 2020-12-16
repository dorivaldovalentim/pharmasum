@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
     
        <div class="col-sm-3">
            <div class="card green summary-inline">
                <div class="card-body">
                    <i class="icon fa fa-tags fa-4x"></i>
                    <div class="content">
                        <div class="title">{{ $data['products'] }}</div>
                        <div class="sub-title">Produtos</div>
                    </div>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card blue summary-inline">
                <div class="card-body">
                    <i class="icon fa fa-inbox fa-4x"></i>
                    <div class="content">
                        <div class="title">{{ $data['sales'] }}</div>
                        <div class="sub-title">Minhas Vendas</div>
                    </div>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
