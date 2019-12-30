@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Новое объявление</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('guest.mardikor') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('guest.mardikor.store') }}" method="post">
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Работодател</div>
                    <div class="col-7 col-lg-4">
                        <input name="employer_name" type="text" class="form-control form-control-sm" value="{{ old('employer_name') }}">
                        @if ($errors->has('employer_name'))
                            <span class="font-weight-bold small">{{ $errors->first('employer_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Телефон</div>
                    <div class="col-7 col-lg-4">
                        <input name="phone" type="text" class="form-control form-control-sm" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="font-weight-bold small">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Город</div>
                    <div class="col-7 col-lg-4">
                        <select name="city_id" class="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('city_id'))
                            <span class="font-weight-bold small">{{ $errors->first('city_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Название объявления</div>
                    <div class="col-7 col-lg-4">
                        <input class="form-control form-control-sm" name="title" value="{{ old('title') }}" type="text">
                        @if ($errors->has('title'))
                            <span class="font-weight-bold small">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Зарплата</div>
                    <div class="col-7 col-md-4">
                        <input name="salary" value="{{ old('salary') }}" type="text" class="form-control form-control-sm">
                        <span class="small"><b>Сомони</b> на руки</span>
                        @if ($errors->has('salary'))
                            <br>
                            <span class="font-weight-bold small">{{ $errors->first('salary') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Описание объявления</div>
                    <div class="col-7 col-lg-4">
                        <textarea name="description" type="text" rows="5" class="form-control form-control-sm">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="font-weight-bold small">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Добавить</button>
        </form>
    </div>
@endsection