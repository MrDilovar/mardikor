@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Резюме</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.resume.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.resume.store') }}" method="post">
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Желаемая должность</div>
                    <div class="col-7 col-lg-4">
                        <input class="form-control form-control-sm" name="title" value="{{ old('title') }}" type="text">
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
                        <input name="salary" value="{{ old('salary') }}" type="text" class="form-control form-control-sm">
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
                                <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('specialization_id'))
                            <span class="font-weight-bold small">{{ $errors->first('specialization_id') }}</span>
                            <br>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Добавить</button>
        </form>
    </div>
@endsection