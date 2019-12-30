@extends('layout')
@section('content')
    <div class="container py-3">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">{{ $resume->title }}</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.resume.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.resume.update', $resume->id) }}" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <h5 class="mb-3">Специальность</h5>
            <div class="mb-5 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Желаемая должность</div>
                    <div class="col-7 col-lg-4">
                        <input class="form-control form-control-sm" name="title" value="{{ old('title') ? old('title') : $resume->title }}" type="text">
                        <span class="small"><b>Например:</b> Стажер в отдел продаж, Младший специалист технического отдела, Курьер</span>
                        @if ($errors->has('title'))
                            <br>
                            <span class="font-weight-bold small">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Зарплата</div>
                    <div class="col-7 col-md-4">
                        <input name="salary" type="text" class="form-control form-control-sm" value="{{ old('salary') ? old('salary') : $resume->salary }}">
                        <span class="small"><b>Сомони</b> на руки</span>
                        @if ($errors->has('salary'))
                            <br>
                            <span class="font-weight-bold small">{{ $errors->first('salary') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Специализации</div>
                    <div class="col-7 col-lg-4">
                        <select name="specialization_id" class="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            @foreach($specializations as $specialization)
                                <option {{ (old('specialization_id') ? old('specialization_id') : $resume->specialization_id) == $specialization->id ? 'selected' : '' }} value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('specialization_id'))
                            <span class="font-weight-bold small">{{ $errors->first('specialization_id') }}</span>
                            <br>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
        </form>
    </div>
@endsection