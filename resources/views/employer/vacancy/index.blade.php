@extends('layout')
@section('content')
    <div class="container py-4">
        <div class="row mb-4 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Мои вакансии</h4></div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('employer.vacancy.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="row">
            @foreach($vacancies as $vacancy)
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="border rounded p-2 text-center">
                    <a class="text-primary font-weight-bold" href="{{ route('guest.vacancy', $vacancy->id)  }}">{{ $vacancy->name }}</a>
                    <div>
                        <span class="d-block">{{ $vacancy->title }}</span>
                        <span class="d-block">
                            @isset($vacancy->compensation_from_visible)
                                от {{ $vacancy->compensation_from_visible }}
                            @endisset
                            @isset($vacancy->compensation_to_visible)
                                до {{ $vacancy->compensation_to_visible }}
                            @endisset
                            @if($vacancy->compensation_from_visible || $vacancy->compensation_to_visible)
                                сом.
                            @else
                                з/п не указана
                            @endif
                        </span>
                    </div>
                    <div class="font-weight-light">
                        @isset($vacancy->employer->city)
                            г. {{ $vacancy->city->name }}
                        @endisset
                    </div>
                    <hr class="w-75">
                    <form class="d-inline" action="{{ route('employer.vacancy.destroy', $vacancy->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                    </form>
                    <a href="{{ route('employer.vacancy.edit', $vacancy->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
