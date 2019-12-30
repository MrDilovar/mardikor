@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Среднее образование</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.education.secondary.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.education.secondary.store') }}" method="post">
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Начало</div>
                    <div class="col-4 col-lg-2">
                        <select name="study_start" id="" class="form-control form-control-sm">
                            <option value="0">Год</option>
                            @for($i = 1990; $i <= $current_yer; $i++ )
                                <option value="{{ $i }}" {{ old('study_start') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        @if ($errors->has('study_start'))
                            <span class="font-weight-bold small">{{ $errors->first('study_start') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Окончание</div>
                    <div class="col-4 col-lg-2">
                        <select name="study_finish" id="" class="form-control form-control-sm">
                            <option value="0">Год</option>
                            @for($i = 1990; $i <= $current_yer; $i++ )
                                <option value="{{ $i }}" {{ old('study_finish') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        @if ($errors->has('study_finish'))
                            <span class="font-weight-bold small">{{ $errors->first('study_finish') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Школа</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input name="school" value="{{ old('school') }}" type="text" class="form-control form-control-sm">
                        @if ($errors->has('school'))
                            <span class="font-weight-bold small">{{ $errors->first('school') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Город</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input name="city" value="{{ old('city') }}" type="text" class="form-control form-control-sm">
                        @if ($errors->has('city'))
                            <span class="font-weight-bold small">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Страна</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input name="country" value="{{ old('country') }}" type="text" class="form-control form-control-sm">
                        @if ($errors->has('country'))
                            <span class="font-weight-bold small">{{ $errors->first('country') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Добавить</button>
        </form>
    </div>
@endsection