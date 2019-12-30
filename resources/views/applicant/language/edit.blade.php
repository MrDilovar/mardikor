@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Знание языков</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.language.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.language.update', $applicant_language->id) }}" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Язык</div>
                    <div class="col-7 col-lg-4">
                        <select name="language_id" id="" class="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}" {{ (old('language_id') ? old('language_id') : $applicant_language->language->id) == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('language_id'))
                            <span class="font-weight-bold small">{{ $errors->first('language_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Уровень языка</div>
                    <div class="col-7 col-lg-4">
                        <select name="language_level_id" id="" class="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            @foreach($language_levels as $language_level)
                                <option value="{{ $language_level->id }}" {{ (old('language_level_id') ? old('language_level_id') : $applicant_language->language_level->id) == $language_level->id ? 'selected' : '' }}>{{ $language_level->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('language_level_id'))
                            <span class="font-weight-bold small">{{ $errors->first('language_level_id') }}</span>
                        @endif
                    </div>
                </div>
                <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
            </div>
        </form>
    </div>
@endsection