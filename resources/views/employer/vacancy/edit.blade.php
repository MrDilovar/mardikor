@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Вакансия</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('employer.vacancy.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form id="form_vacancy" action="{{ route('employer.vacancy.update', $vacancy->id) }}" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Название вакансии</div>
                    <div class="col-7 col-lg-4">
                        <input name="name" value="{{ old('name') ? old('name') : $vacancy->name }}" type="text" class="form-control form-control-sm">
                        @if ($errors->has('name'))
                            <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Специализации</div>
                    <div class="col-7 col-lg-4">
                        <select name="specialization_id" class="form-control form-control-sm">
                            <option value="0">Не выбрано</option>
                            @foreach($specializations as $specialization)
                                <option value="{{ $specialization->id }}" {{ (old('specialization_id') ? old('specialization_id') : $vacancy->specialization_id)  == $specialization->id ? 'selected' : '' }} >{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('specialization_id'))
                            <span class="font-weight-bold small">{{ $errors->first('specialization_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Зарплата</div>
                    <div class="col-7 col-lg-4">
                        <div class="row">
                            <div class="col-6">
                                <input name="compensation_from_visible" value="{{ old('compensation_from_visible') ? old('compensation_from_visible') : $vacancy->compensation_from_visible }}" type="text" class="form-control form-control-sm" placeholder="от">
                            </div>
                            <div class="col-6">
                                <input name="compensation_to_visible" value="{{ old('compensation_to_visible') ? old('compensation_to_visible') : $vacancy->compensation_to_visible }}" type="text" class="form-control form-control-sm" placeholder="до">
                            </div>
                            <div class="col-12">
                                <span class="small"><b>Сомони</b> на руки</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @if ($errors->has('compensation_from_visible'))
                            <div class="font-weight-bold small">{{ $errors->first('compensation_from_visible') }}</div>
                        @endif
                        @if ($errors->has('compensation_to_visible'))
                            <div class="font-weight-bold small">{{ $errors->first('compensation_to_visible') }}</div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Город</div>
                    <div class="col-7 col-lg-4">
                        <select name="city_id" class="form-control form-control-sm">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ (old('city_id') ? old('city_id') : $vacancy->id)  == $city->id  ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('city_id'))
                            <span class="font-weight-bold small">{{ $errors->first('city_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Требуемый опыт работы</div>
                    <div class="col-7 col-lg-4">
                        <select name="vacancy_experience_id" class="form-control form-control-sm">
                            @foreach($vacancy_experiences as $vacancy_experience)
                                <option value="{{ $vacancy_experience->id }}" {{ (old('vacancy_experience_id') ? old('vacancy_experience_id') : $vacancy->vacancy_experience_id)  == $vacancy_experience->id  ? 'selected' : '' }}>{{ $vacancy_experience->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('vacancy_experience_id'))
                            <span class="font-weight-bold small">{{ $errors->first('vacancy_experience_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">Описание вакансии</div>
                    <div class="col-lg-6">
                        <input type="hidden" name="description">
                        <div id="vacancy_editor" style="height: 250px;">
                            {!! old('description') ? old('description') : $vacancy->description !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary shadow" type="submit">Редактировать</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        new Quill('#vacancy_editor', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }],
                ]
            },
            theme: 'snow'
        });

        $('#form_vacancy').submit(function() {
            $('input[name=description]').val($('#vacancy_editor .ql-editor').html());
        });
    </script>
@endsection