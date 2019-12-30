@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.resume.nav')
        <div class="row my-4 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Высшее образование</h4></div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('applicant.education.higher.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row mb-3">
            @foreach($higher_educations as $higher_education)
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="mb-1 border rounded p-2 text-center">
                    <ul class="list-unstyled">
                        <li>Вуз: <b>{{ $higher_education->university . '  \'' . $higher_education->graduation }}</b></li>
                        <li>Направление: {{ $higher_education->chair }}</li>
                        <li>Статус: {{ $higher_education->education_status->name }}</li>
                        <li>Город: {{ $higher_education->city }}</li>
                        <li>Страна: {{ $higher_education->country }}</li>
                    </ul>
                    <hr class="w-75">
                    <form class="d-inline" action="{{ route('applicant.education.higher.destroy', $higher_education->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                    </form>
                    <a href="{{ route('applicant.education.higher.edit', $higher_education->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
