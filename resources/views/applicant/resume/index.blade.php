@extends('layout')
@section('content')
    <div class="container">
        @include('applicant.resume.nav')
        <div class="row my-4 align-items-center">
            <div class="col-auto"><h4 class="font-weight-light">Резюме</h4></div>
            <div class="col-auto"><a class="btn btn-sm btn-outline-primary" href="{{ route('applicant.resume.create') }}">Создать</a></div>
        </div>
        @if(session()->get('success'))
            <div class="alert alert-success small">
                {{ session()->get('success') }}
            </div><br />
        @endif
        <div class="row mb-3">
            @foreach($resumes as $resume)
                <div class="col-6 col-md-4 col-lg-3 mb-1">
                    <div class="mb-1 border rounded p-2 text-center">
                        <a href="{{ route('guest.resume', $resume->id) }}">
                            @if(!is_null($resume->applicant->photo))
                                <img class="rounded-pill" style="max-width: 150px; max-height: 150px;" src="{{ $resume->photo }}" alt="...">
                            @else
                                @if($resume->applicant->gender == 'M')
                                    <img class="rounded-pill" style="max-width: 150px; max-height: 150px;" src="/img/applicant/default-male.jpg" alt="...">
                                @else
                                    <img class="rounded-pill" style="max-width: 150px; max-height: 150px;" src="/img/applicant/default-female.jpg" alt="...">
                                @endif
                            @endif
                        </a>
                        <div class="mt-2">
                            <a class="text-primary font-weight-bold" href="{{ route('guest.resume', $resume->id) }}">{{ $resume->title }}</a>
                        </div>
                        <div class="small text-muted">{{ $resume->birthday }} года</div>
                        <div class="font-weight-bold">{{ $resume->salary }} сомони</div>
                        @if($resume->applicant->vacancy_experience_id != 1)
                            <div class="small text-muted">Опыт работы</div>
                            <div>{{ $job_experience_year != 0 ? $job_experience_year . ' лет' : '' }} {{ $job_experience_month != 0 ? ($job_experience_year != 0 ? 'и ' : '') . $job_experience_month . ' месяцев' : '' }}</div>
                        @else
                            <div class="small text-muted">Нет опыта</div>
                        @endif
                        <div class="d-block text-muted small">Обновлено {{ $resume->date }}</div>
                        <hr class="w-75">
                        <form class="d-inline" action="{{ route('applicant.resume.destroy', $resume->id)}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete" />
                            <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                        </form>
                        <a href="{{ route('applicant.resume.edit', $resume->id) }}" class="btn btn-sm btn-outline-secondary">Изменить</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
