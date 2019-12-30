@extends('layout')
@section('content')
    <main>
        <section class="container">
            <div class="jumbotron py-3 mt-4">
                <h3 class="">Соискателям</h3>
                <div class="row mt-3">
                    @php
                        $per_page = (int)ceil($specializations->count() / 2);
                    @endphp
                    @for ($i = 1; $i <= 2; $i++)
                        <div class="col-6 mb-1">
                            @for($j = $per_page * $i - $per_page; $j < $per_page * $i; $j++)
                                <div class="mb-1">
                                    <a class="small text-dark d-flex justify-content-between" href="{{ route('guest.search_vacancy', ['specialization'=>$specializations[$j]->id]) }}">
                                        <span>{{ $specializations[$j]->name }}</span>
                                        <span><span class="badge badge-pill badge-dark">{{ $specializations[$j]->vacancies }}</span></span>
                                    </a>
                                </div>
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>
            <div class="jumbotron py-3 mt-4">
                <h3 class="">Работодателям</h3>
                <div class="row mt-3">
                    @php
                        $per_page = (int)ceil($specializations->count() / 2);
                    @endphp
                    @for ($i = 1; $i <= 2; $i++)
                        <div class="col-6 mb-1">
                            @for($j = $per_page * $i - $per_page; $j < $per_page * $i; $j++)
                                <div class="mb-1">
                                    <a class="small text-dark d-flex justify-content-between align-items-center" href="{{ route('guest.search_resume', ['specialization'=>$specializations[$j]->id]) }}">{{ $specializations[$j]->name }} <span class="badge badge-pill badge-dark">{{ $specializations[$j]->resumes }}</span></a>
                                </div>
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>
        </section>
        <section class="container mt-3">
                <h5>Вакансии</h5>
                <div class="row mt-3">
                    @foreach($vacancies as $vacancy)
                    <div class="col-sm-6 col-sm-4 mb-1">
                        <p class="mb-2 border rounded p-2">
                            <a href="{{ route('guest.vacancy', $vacancy->id) }}">{{ $vacancy->name }}</a>
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
                            <a href="{{ route('guest.employer', $vacancy->employer->id) }}" class="d-block text-muted small">{{ $vacancy->employer->brand }}, г. {{ $vacancy->city->name }}</a>
                        </p>
                    </div>
                    @endforeach
                </div>
                <hr>
                <h5 class="mb-3">Резюме</h5>
                <div class="row mb-3">
                    @foreach($resumes as $resume)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-1">
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
                                <div class="font-weight-bold">
                                    @if(!is_null($resume->salary))
                                        {{ $resume->salary }} сомони
                                    @else
                                        з/п не указана
                                    @endif
                                </div>
                                @if($resume->applicant->vacancy_experience_id != 1)
                                    <div class="small text-muted">Опыт работы</div>
                                    <div class="text-success font-weight-bold">{{ $resume->experience_year != 0 ? $resume->experience_year . ' лет' : '' }} {{ $resume->experience_month != 0 ? ($resume->experience_year != 0 ? 'и ' : '') . $resume->experience_month . ' месяцев' : '' }}</div>
                                @else
                                    <div class="small text-muted">Нет опыта</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <h5 class="mb-3">Работа в компаниях</h5>
                <div class="row">
                    @foreach($employers as $employer)
                        <div class="col-md-6 col-lg-4 mb-1">
                            <a class="text-dark d-flex justify-content-between" href="{{ route('guest.employer', $employer->id) }}">
                                <span>{{ $employer->brand }}</span>
                                <span class="text-muted">{{ $employer->vacancies }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
    </main>
@endsection