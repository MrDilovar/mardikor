@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Высшее образование</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.education.higher.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.education.higher.update', $higher_education->id) }}" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Страна</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input value="{{ old('country') ? old('country') : $higher_education->country }}" name="country" type="text" class="form-control form-control-sm">
                        @if ($errors->has('country'))
                            <span class="font-weight-bold small">{{ $errors->first('country') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Город</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input value="{{ old('city') ? old('city') : $higher_education->city }}" name="city" type="text" class="form-control form-control-sm">
                        @if ($errors->has('city'))
                            <span class="font-weight-bold small">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Вуз</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input value="{{ old('university') ? old('university') : $higher_education->university }}" name="university" type="text" class="form-control form-control-sm">
                        @if ($errors->has('university'))
                            <span class="font-weight-bold small">{{ $errors->first('university') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Направление:</div>
                    <div class="col-8 col-md-6 col-lg-4">
                        <input value="{{ old('chair') ? old('chair') : $higher_education->chair }}" name="chair" type="text" class="form-control form-control-sm">
                        @if ($errors->has('chair'))
                            <span class="font-weight-bold small">{{ $errors->first('chair') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Статус</div>
                    <div class="col-4 col-lg-2">
                        <select name="education_status_id" id="" class="form-control form-control-sm">
                            <option value="0">Не выбрана</option>
                            @foreach($education_statuses as $education_status)
                                <option value="{{ $education_status->id }}" {{ (old('education_status_id') ? old('education_status_id') : $higher_education->education_status_id) == $education_status->id ? 'selected' : '' }}>{{ $education_status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        @if ($errors->has('education_status_id'))
                            <span class="font-weight-bold small">{{ $errors->first('education_status_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Дата выпуска</div>
                    <div class="col-4 col-lg-2">
                        <select name="graduation" class="form-control form-control-sm">
                            <option value="0">Не выбрана</option>
                            @for($i = $current_yer+7; $i >= 1990; $i-- )
                                <option value="{{ $i }}" {{ (old('graduation') ? old('graduation') : $higher_education->graduation) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-12">
                        @if ($errors->has('graduation'))
                            <span class="font-weight-bold small">{{ $errors->first('graduation') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
        </form>
    </div>
@endsection