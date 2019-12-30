@extends('layout')
@section('content')
    <div class="container py-3">
        <h4 class="mt-2">Настройки</h4>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <hr>
        <h5 class="mb-4 font-weight-normal">Основные данные</h5>
        <form action="{{ route('employer.settings.employer') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-lg-2">Имя компании</div>
                <div class="col-7 col-lg-4">
                    <input name="brand" type="text" class="form-control form-control-sm" value="{{ $user->data->brand }}">
                    @if ($errors->has('brand'))
                        <span class="font-weight-bold small">{{ $errors->first('brand') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Город</div>
                <div class="col-7 col-lg-4">
                    <select name="city_id" class="form-control form-control-sm">
                        <option value="0">Не выбрано</option>
                        @foreach($cities as $city)
                            <option {{ $city->id === $user->data->city_id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('city_id'))
                        <span class="font-weight-bold small">{{ $errors->first('city_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Адрес компании</div>
                <div class="col-7 col-lg-4">
                    <input name="address" type="text" class="form-control form-control-sm" value="{{ $user->data->address }}">
                    @if ($errors->has('address'))
                        <span class="font-weight-bold small">{{ $errors->first('address') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Телефон</div>
                <div class="col-7 col-lg-4">
                    <input name="phone" type="text" class="form-control form-control-sm" value="{{ $user->data->phone }}" placeholder="+992 XXX XX XX XX">
                    @if ($errors->has('phone'))
                        <span class="font-weight-bold small">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">О компании</div>
                <div class="col-7 col-lg-4">
                    <textarea name="about_employer" type="text" class="form-control form-control-sm">{{ $user->data->about_employer }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary mb-3">Изменить</button>
        </form>
        <hr>
        <h5 class="mb-3 font-weight-normal">Логотип компании</h5>
        <div class="row">
            <div class="col-sm-6">
                @empty($user->data->photo)
                    <div class="text-muted">Не задано...</div>
                @else
                    <div class="p-2 border">
                        <img src="{{'/' . $PATH_TO_EMPLOYER_PHOTO . $user->data->photo }}" class="img-fluid" alt="applicant photo...">
                    </div>
                @endempty
                <form class="border p-3 my-3 rounded bg-light" action="{{ route('employer.settings.photo') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input class="w-100" name="photo" type="file">
                        <small class="form-text text-muted">Пожалуйста, загрузите действительный файл изображения. Размер изображения не должен превышать 10 МБ.</small>
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">Изменить</button>
                </form>
            </div>
        </div>
        <hr>
        <h5 class="mb-3 font-weight-normal">Параметры входа</h5>
        <div class="form-group row">
            <div class="col-lg-2">E-Mail Address</div>
            <div class="col-7 col-lg-4">
                <input type="text" class="form-control form-control-sm" value={{ $user->email }} disabled>
                @if ($errors->has('email'))
                    <span class="font-weight-bold small">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#emailEditModal">Изменить</button>
                <div class="modal fade" id="emailEditModal" tabindex="-1" role="dialog" aria-labelledby="emailEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('employer.settings.email') }}" method="post" novalidate>
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
                                            <div class="col-sm-4">Email address</div>
                                            <div class="col-sm-8">
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
            <div class="col-lg-2">Текущий пароль</div>
            <div class="col-7 col-lg-4">
                <input type="password" class="form-control form-control-sm" placeholder="******" disabled>
                @if ($errors->has('password'))
                    <span class="font-weight-bold small">{{ $errors->first('password') }}</span>
                @endif
                @if ($errors->has('new_password'))
                    <span class="font-weight-bold small">{{ $errors->first('new_password') }}</span>
                @endif
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#passwordEditModal">Изменить</button>
                <div class="modal fade" id="passwordEditModal" tabindex="-1" role="dialog" aria-labelledby="passwordEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form class="formsValidate" action="{{ route('employer.settings.password') }}" method="post" novalidate>
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
                                            <div class="col-sm-4">Текущий пароль</div>
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
