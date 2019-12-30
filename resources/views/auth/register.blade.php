@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4 mx-auto">
            <h2 class="text-center mt-5 mb-4">Регистрация</h2>
            <div class="btn-group w-100" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-dark active" id="toggleApplicant">Соискател</button>
                <button type="button" class="btn btn-outline-dark" id="toggleEmployer">Работодател</button>
            </div>
            <hr>
            <div id="collapseApplicant">
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="role" value="1">

                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label>Имя</label>

                        <input  type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label>Фамилия</label>

                        <input  type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>Электронный адрес</label>

                        <input  type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

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

                    <div class="form-group">
                        <label>Повторите пароль</label>

                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-dark btn-block">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
            <div id="collapseEmployer" style="display: none;">
                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="role" value="2">

                    <div class="form-group">
                        <label>Название компании</label>

                        <input  type="text" class="form-control" name="brand" value="{{ old('brand') }}" required>

                        @if ($errors->has('brand'))
                            <span class="help-block">
                                <strong>{{ $errors->first('brand') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Электронный адрес</label>

                        <input  type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>

                        <input type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Повторите пароль</label>

                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-dark btn-block">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#toggleApplicant').click(function () {
        let self = $(this);
        if(!self.hasClass('active')) {
            $('#collapseApplicant').show();
            $('#collapseEmployer').hide();
            self.addClass('active');
            $('#toggleEmployer').removeClass('active');
        }
    });
    $('#toggleEmployer').click(function () {
        let self = $(this);
        if(!self.hasClass('active')) {
            $('#collapseApplicant').hide();
            $('#collapseEmployer').show();
            self.addClass('active');
            $('#toggleApplicant').removeClass('active');
        }
    });
</script>
@endsection
