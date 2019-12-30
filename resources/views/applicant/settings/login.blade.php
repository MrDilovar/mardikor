@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.settings.nav')
        @if(session()->get('success'))
            <div class="alert alert-success small">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="form-group row">
            <div class="col-lg-3">Ваш электронный адрес</div>
            <div class="col-7 col-lg-3">
                <input type="text" class="form-control form-control-sm" value={{ $user->email }} disabled>
                @if ($errors->has('email'))
                    <span class="font-weight-bold small">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-light border" data-toggle="modal" data-target="#emailEditModal">Редактировать</button>
                <div class="modal fade" id="emailEditModal" tabindex="-1" role="dialog" aria-labelledby="emailEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('applicant.login.email') }}" method="post" novalidate>
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title">Изменить</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-5">Ваш электронный адрес</div>
                                            <div class="col-sm-7">
                                                <input name="email" type="email" class="form-control form-control-sm" value={{ $user->email }} required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Отменить</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-3">Ваш пароль</div>
            <div class="col-7 col-lg-3">
                <input type="password" class="form-control form-control-sm" placeholder="******" disabled>
                @if ($errors->has('password'))
                    <span class="font-weight-bold small">{{ $errors->first('password') }}</span>
                @endif
                @if ($errors->has('new_password'))
                    <span class="font-weight-bold small">{{ $errors->first('new_password') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-light border" data-toggle="modal" data-target="#passwordEditModal">Редактировать</button>
                <div class="modal fade" id="passwordEditModal" tabindex="-1" role="dialog" aria-labelledby="passwordEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('applicant.login.password') }}" method="post" novalidate>
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title">Изменить</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="form-group row">
                                            <div class="col-sm-4">Ваш пароль</div>
                                            <div class="col-sm-8">
                                                <input name="password" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">Новый пароль</div>
                                            <div class="col-sm-8">
                                                <input name="new_password" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">Подтверждение пароля</div>
                                            <div class="col-sm-8">
                                                <input name="new_password_confirmation" type="password" class="form-control form-control-sm" placeholder="******" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Отменить</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
