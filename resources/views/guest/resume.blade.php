@extends('layout')
@section('content')
    <div class="container py-3">
        @if(session()->get('success'))
            <div class="alert alert-success mt-4">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="row py-3">
            <div class="col-sm-2">
                @if(!is_null($applicant->photo))
                    <img class="img-fluid rounded-circle" src="{{ $applicant->path_photo }}" alt="...">
                @else
                    @if($resume->applicant->gender == 'M')
                        <img class="rounded-pill" style="max-width: 150px; max-height: 150px;" src="/img/applicant/default-male.jpg" alt="...">
                    @else
                        <img class="rounded-pill" style="max-width: 150px; max-height: 150px;" src="/img/applicant/default-female.jpg" alt="...">
                    @endif
                @endif
            </div>
            <div class="col-sm-10">
                <h4 class="mb-3">{{ $applicant->first_name }} {{ $applicant->last_name }}</h4>
                <div>{{ $applicant->gender === 'W' ? 'Женщина' : 'Мужчина' }}, родился {{ $applicant->birthday }}</div>
                <div>{{ $applicant->city ? $applicant->city->name : '' }}</div>
                <div>{{ $applicant->user->email }}</div>
                <div>{{ $applicant->phone }}</div>
            </div>
        </div>
        <p>
            {{ $applicant->about_yourself }}
        </p>
        <hr>
        <div class="mb-4">
            <h4 class="font-weight-light">{{ $resume->title }}</h4>
            Специализация: <b>{{ $resume->specialization->name }}</b><br>
            <b>{{ $resume->salary }} сомони</b> на руки
        </div>
        <div class="mb-4">
            <h4 class="font-weight-light">Знание языков</h4>
            @foreach($applicant->languages as $language)
                <p class="mb-1"><b>{{ $language->language->name }}</b> — {{ $language->language_level->name }}</p>
            @endforeach
        </div>
        <div class="mb-4">
            <h4 class="font-weight-light">Навыки</h4>
            @foreach($applicant->skills as $skill)
                <span class="font-weight-bold d-inline-block mr-3">{{ $skill->name }}</span>
            @endforeach
        </div>
        <div class="mb-4">
            <h4 class="font-weight-light">Опыт работы</h4>
            @foreach($applicant->job_experiences as $job_experience)
                <div class="mb-2">
                    <b>{{ $job_experience->company_name }}</b><br>
                    {{ $job_experience->position }}<br>
                    {{ $job_experience->description }}<br>
                    {{ $job_experience->begin_job }} <b>—</b> {{ $job_experience->end_job }}<br>
                </div>
            @endforeach
        </div>
        <div class="mb-4">
            <h4 class="font-weight-light">Навыки</h4>
            @foreach($applicant->skills as $skill)
                <span class="font-weight-bold d-inline-block mr-3">{{ $skill->name }}</span>
            @endforeach
        </div>
        <div class="mt-4">
            @can('is_employer')
                @if ($resume->negotiation)
                    <a class="btn btn-outline-success" href="{{ route('employer.negotiation.show', $resume->negotiation->id) }}">Смотреть отклик</a>
                @else
                    <a class="btn btn-primary" href="{{ route('employer.negotiation.respond.show', $resume->id) }}">Откликнуться</a>
                @endif
            @endcan

            @guest
                <a class="btn btn-primary" href="{{ route('employer.negotiation.respond.show', $resume->id) }}">Откликнуться</a>
            @endguest
        </div>
    </div>
@endsection