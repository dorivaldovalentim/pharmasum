@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="login-box">
            <div>
                <div class="login-form row">
                    <div class="col-sm-12 text-center login-header">
                        <i class="login-logo fa fa-connectdevelop fa-5x"></i>
                        <h4 class="login-title">Acessar minha conta Admin</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="login-body">
                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="control">
                                    <input id="email" type="" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="exemplo: jefthvalentim@hotmail.com">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="control">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="******">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="login-button text-center">
                                    <input type="submit" class="btn btn-primary" value="Entrar">
                                </div>
                            </form>
                        </div>
                        <div class="login-footer">
                            @if (Route::has('password.request'))
                                <span class="text-right">
                                    <a class="black-transparent" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
