@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.resume.nav')
        <div class="row my-4 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Знание языков</h4></div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('applicant.language.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row">
            @foreach($languages as $language)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="mb-1 border rounded p-2 text-center">
                        <div class="font-weight-bold">{{ $language->language->name }} язык</div>
                        <div class="text-muted">{{ $language->language_level->name }}</div>
                        <hr class="w-75">
                        <form class="d-inline" action="{{ route('applicant.language.destroy', $language->id)}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete" />
                            <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                        </form>
                        <a href="{{ route('applicant.language.edit', $language->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
