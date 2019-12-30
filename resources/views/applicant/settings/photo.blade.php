@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.settings.nav')
        <div class="row">
            <div class="col-sm-6">
                @if(session()->get('success'))
                    <div class="alert alert-success small">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if ($errors->has('photo'))
                    <div class="alert alert-danger small">{{ $errors->first('photo') }}</div>
                @endif
                @empty($applicant->photo)
                    <div class="text-muted">Не задано...</div>
                @else
                    <img src="/{{ $PATH_TO_APPLICANT_PHOTO . $applicant->photo }}" class="img-fluid" alt="applicant photo...">
                @endempty
                <hr>
                <form action="{{ route('applicant.settings.photo.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="image">Изображения:</label>
                        <input class="w-100" name="photo" type="file">
                        <small class="form-text text-muted">Пожалуйста, загрузите действительный файл изображения. Размер изображения не должен превышать 10 МБ.</small>
                    </div>
                    <button class="btn btn-sm btn-primary shadow" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
