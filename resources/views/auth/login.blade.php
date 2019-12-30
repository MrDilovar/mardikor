@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 mx-auto">
            <h2 class="text-center mt-5 mb-3">Вход</h2>

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Электронный адрес</label>

                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Пароль</label>

                    <input type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Запомнить меня</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Войти</button>
                    <a class="btn btn-link" href="{{ route('password.request') }}">Забыли пароль?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
