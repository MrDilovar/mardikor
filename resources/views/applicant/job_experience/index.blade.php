@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.resume.nav')
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="font-weight-light">
                    Опыт работы
                    @if(Auth::user()->data->vacancy_experience_id != 1)
                        {{ $job_experiences->year != 0 ? $job_experiences->year . ' лет' : '' }} {{ $job_experiences->month != 0 ? ($job_experiences->year != 0 ? 'и ' : '') . $job_experiences->month . ' месяцев' : '' }}
                    @else
                        Нет опыта
                    @endif
                </h4>
            </div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('applicant.experience.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row mb-3">
            @foreach($job_experiences as $job_experience)
            <div class="col-sm-6">
                <div class="mb-1 border rounded p-2 text-center">
                    <ul class="list-unstyled">
                        <li>Начало работы: {{ "$job_experience->begin_job_month $job_experience->begin_job_year" }}</li>
                        <li>Окончание: {{ "$job_experience->end_job_month $job_experience->end_job_year" }}</li>
                        <li>Организация: {{ $job_experience->company_name }}</li>
                        <li>Должность: {{ $job_experience->position }}</li>
                        <li>Обязанности на рабочем месте: {{ $job_experience->description }}</li>
                    </ul>
                    <hr class="w-75">
                    <form class="d-inline" action="{{ route('applicant.experience.destroy', $job_experience->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                    </form>
                    <a href="{{ route('applicant.experience.edit', $job_experience->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
