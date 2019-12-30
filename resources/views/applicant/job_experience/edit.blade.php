@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Опыт работы</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.experience.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.experience.update', $job_experience->id) }}" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div id="page_resume">
                <div class="mb-5 ml-2">
                    <div class="form-group row">
                        <div class="col-lg-2">Начало работы</div>
                        <div class="col-4 col-lg-2">
                            <select name="begin_month" id="" class="form-control form-control-sm">
                                <option value="0">Месяц</option>
                                @foreach($months as $month)
                                    <option value="{{ $month->id }}" {{ (old('begin_month') ? old('begin_month') : $job_experience->begin_job->month) == $month->id ? 'selected' : '' }}>{{ $month->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 col-lg-2">
                            <select name="begin_yer" id="" class="form-control form-control-sm">
                                <option value="0">Год</option>
                                @for($i = 1990; $i <= $current_yer; $i++ )
                                    <option value="{{ $i }}" {{ (old('begin_yer') ? old('begin_yer') : $job_experience->begin_job->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12">
                            @if ($errors->has('begin_month'))
                                <div class="font-weight-bold small">{{ $errors->first('begin_month') }}</div>
                            @endif
                            @if ($errors->has('begin_yer'))
                                <div class="font-weight-bold small">{{ $errors->first('begin_yer') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">Окончание</div>
                        <div class="col-4 col-lg-2">
                            <select name="end_month" id="" class="form-control form-control-sm">
                                <option value="0">Месяц</option>
                                @foreach($months as $month)
                                    <option value="{{ $month->id }}" {{ (old('end_month') ? old('end_month') : $job_experience->end_job->month) == $month->id ? 'selected' : '' }}>{{ $month->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 col-lg-2">
                            <select name="end_yer" id="" class="form-control form-control-sm">
                                <option value="0">Год</option>
                                @for($i = 1990; $i <= $current_yer; $i++ )
                                    <option value="{{ $i }}" {{ (old('end_yer') ? old('end_yer') : $job_experience->end_job->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12">
                            @if ($errors->has('end_month'))
                                <div class="font-weight-bold small">{{ $errors->first('end_month') }}</div>
                            @endif
                            @if ($errors->has('end_yer'))
                                <div class="font-weight-bold small">{{ $errors->first('end_yer') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">Организация</div>
                        <div class="col-8 col-md-6 col-lg-4">
                            <input name="company_name" type="text" class="form-control form-control-sm" value="{{ old('company_name') ? old('company_name') : $job_experience->company_name }}">
                            @if ($errors->has('company_name'))
                                <span class="font-weight-bold small">{{ $errors->first('company_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">Должность</div>
                        <div class="col-8 col-md-6 col-lg-4">
                            <input name="position" type="text" class="form-control form-control-sm" value="{{ old('position') ? old('position') : $job_experience->position }}">
                            @if ($errors->has('position'))
                                <span class="font-weight-bold small">{{ $errors->first('position') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">Обязанности на рабочем месте</div>
                        <div class="col-8 col-md-6 col-lg-4">
                            <textarea name="description" class="form-control form-control-sm">{{ old('description') ? old('description') : $job_experience->description }}</textarea>
                            @if ($errors->has('description'))
                                <span class="font-weight-bold small">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
            </div>
        </form>
    </div>
@endsection