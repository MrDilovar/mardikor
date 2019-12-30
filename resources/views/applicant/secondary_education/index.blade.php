@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.resume.nav')
        <div class="row my-4 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Среднее образование</h4></div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('applicant.education.secondary.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row mb-3">
            @foreach($secondary_educations as $secondary_education)
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="mb-1 border rounded p-2 text-center">
                    <ul class="list-unstyled">
                        <li>Начало: <b>{{ $secondary_education->study_start }}</b></li>
                        <li>Окончание: <b>{{ $secondary_education->study_finish }}</b></li>
                        <li>Школа: {{ $secondary_education->school }}</li>
                        <li>Город: {{ $secondary_education->city }}</li>
                        <li>Страна: {{ $secondary_education->country }}</li>
                    </ul>
                    <hr class="w-75">
                    <form class="d-inline" action="{{ route('applicant.education.secondary.destroy', $secondary_education->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                    </form>
                    <a href="{{ route('applicant.education.secondary.edit', $secondary_education->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
