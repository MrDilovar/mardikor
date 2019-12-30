@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.settings.nav')
        @if(session()->get('success'))
            <div class="alert alert-success small shadow">
                {{ session()->get('success') }}
            </div>
        @endif
        <form action="{{ route('applicant.settings.applicant.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <div class="col-lg-2">Имя</div>
                <div class="col-7 col-lg-4">
                    <input name="first_name" type="text" class="form-control form-control-sm" value={{ $applicant->first_name }}>
                    @if ($errors->has('first_name'))
                        <span class="font-weight-bold small">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Фамилия</div>
                <div class="col-7 col-lg-4">
                    <input name="last_name" type="text" class="form-control form-control-sm" value={{ $applicant->last_name }}>
                    @if ($errors->has('last_name'))
                        <span class="font-weight-bold small">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Пол</div>
                <div class="col-7 col-lg-4">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="genderM" name="gender" value="M" class="custom-control-input" {{ $applicant->gender === 'M' ? 'checked="checked"' : '' }}>
                        <label class="custom-control-label" for="genderM">Мужской</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="genderW" name="gender" value="W" class="custom-control-input" {{ $applicant->gender === 'W' ? 'checked="checked"' : '' }}>
                        <label class="custom-control-label" for="genderW">Женской</label>
                    </div>
                    @if ($errors->has('gender'))
                        <span class="font-weight-bold small">{{ $errors->first('gender') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Дата рождения</div>
                <div class="col-auto">
                    <input name="birthday" type="date" class="form-control form-control-sm" value="{{ $applicant->birthday }}">
                    @if ($errors->has('birthday'))
                        <span class="font-weight-bold small">{{ $errors->first('birthday') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Гражданство</div>
                <div class="col-7 col-lg-4">
                    <select name="country_id" class="form-control form-control-sm">
                        <option value="0">Не выбрано</option>
                        @foreach($countries as $country)
                            <option {{ $country->id === $applicant->country_id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('country_id'))
                        <span class="font-weight-bold small">{{ $errors->first('country_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Город проживания</div>
                <div class="col-7 col-lg-4">
                    <select name="city_id" class="form-control form-control-sm">
                        <option value="0">Не выбрано</option>
                        @foreach($cities as $city)
                            <option {{ $city->id === $applicant->city_id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('city_id'))
                        <span class="font-weight-bold small">{{ $errors->first('city_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">Телефон</div>
                <div class="col-7 col-lg-4">
                    <input name="phone" type="text" class="form-control form-control-sm" value={{ $applicant->phone }}>
                    @if ($errors->has('phone'))
                        <span class="font-weight-bold small">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-2">О себе</div>
                <div class="col-7 col-lg-4">
                    <textarea name="about_yourself" type="text" class="form-control form-control-sm">{{ old('about_yourself') ? old('about_yourself') : $applicant->about_yourself }}</textarea>
                    @if ($errors->has('about_yourself'))
                        <span class="font-weight-bold small">{{ $errors->first('about_yourself') }}</span>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary mb-3 shadow">Сохранить</button>
        </form>
    </div>
@endsection
