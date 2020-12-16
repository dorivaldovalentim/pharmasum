@extends('layouts.dashboard') 

@section('title', 'Actualizar Perfil')

@section('content')
    <div class="row">

        <div class="col-xs-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title">Alterar a senha</div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('msg'))
                        <div class="col-md-7 alert alert-info">{{session('msg')}}</div>
                    @endif
                    <form method="post" action="{{ route('update.password') }}">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="inputEmail4">Senha Antiga</label>
                                <input type="password" class="form-control" name="old_password" placeholder="*****" required />
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="inputEmail4">Nova Senha</label>
                                <input type="password" class="form-control" name="password" placeholder="*****" required />
                            </div>

                            <div class="form-group col-md-7">
                                <label>Confirmar Senha</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="*****" required />
                            </div>
                        </div>
                        <button class="btn btn-primary">Actualizar</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
   
@stop