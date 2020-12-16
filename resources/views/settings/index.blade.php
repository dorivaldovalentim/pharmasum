@extends('layouts.dashboard') 

@section('title', 'Actualizar perfil')

@section('content')
    <div class="row">

        <div class="col-xs-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Perfil do funcionário</div>
                    </div>
                </div>
                
                <div class="card-body">
                    <p><strong>Nome:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                    <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Telefone:</strong> {{ Auth::user()->phone }}</p>
                    <p><strong>Bilhete de Identidade:</strong> {{ Auth::user()->bi }}</p>
                    <p><strong>Endereço Residencial:</strong> {{ Auth::user()->address }}</p>
                    <div class="">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#edit-profile">Editar</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
    
   <modal-edit-component user_id = {{Auth::id()}}></modal-edit-component>
   
@stop