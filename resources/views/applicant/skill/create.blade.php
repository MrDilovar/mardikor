@extends('layout')
@section('content')
    <div class="container">
        <div class="row my-4 align-items-center">
            <div class="col-auto">
                <h4 class="text-center font-weight-light">Навыки</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('applicant.skill.index') }}" class="btn btn-sm btn-outline-primary">Назад</a>
            </div>
        </div>
        <form action="{{ route('applicant.skill.store') }}" method="post">
            {{ csrf_field() }}
            <div class="mb-4 ml-2">
                <div class="form-group row">
                    <div class="col-lg-2">Навык</div>
                    <div class="col-7 col-lg-4">
                        <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-sm">
                        @if ($errors->has('name'))
                            <span class="font-weight-bold small">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button class="btn btn-sm btn-primary shadow" type="submit">Добавить</button>
        </form>
    </div>
@endsection