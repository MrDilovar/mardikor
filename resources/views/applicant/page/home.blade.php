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
