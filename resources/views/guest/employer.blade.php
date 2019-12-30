@extends('layout')
@section('content')
    <div class="container my-4">
        <div class="row">
            <div class="col-md-3 mb-3 text-center text-md-left py-3 bg-light">
                @if(!is_null($employer->photo))
                <div class="text-center">
                    <img class="w-100" style="max-width: 200px; max-height: 70px;" src="/{{ $PATH_TO_EMPLOYER_PHOTO . $employer->photo }}" alt="employer icon">
                </div>
                @endif
                <h2 class="d-block d-md-none mt-3">{{ $employer->brand }}</h2>
                <div class="mt-3">г. {{ $employer->city->name }}</div>
                <div>{{ $employer->address }}</div>
                <div class="mt-3">
                    <h6 class="font-weight-bold mb-0">Вакансии</h6>
                    <span class="text-primary">{{ $employer->vacancies->count() }} активных вакансий</span>
                </div>
            </div>
            <div class="col-md-9">
                <h2 class="d-none d-md-block text-md-left text-center">{{ $employer->brand }}</h2>
                <p>
                    {{ $employer->about_employer }}
                </p>
                <hr>
                <div>
                    @if($employer->vacancies->isEmpty())
                        <div class="text-center">Нет вакансии</div>
                    @else
                        @foreach($employer->vacancies as $vacancy)
                            <div class="border px-3 py-2 mb-3">
                                <div class="row no-gutters">
                                    <div>
                                        <a href="{{ route('guest.vacancy', $vacancy->id) }}">{{ $vacancy->name }}</a>
                                    </div>
                                    <div class="ml-auto">
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
                                    </div>
                                </div>
                                <div class="row no-gutters align-items-center mt-2">
                                    <div class="col">
                                        <span class="small">{{ $vacancy->employer->brand }} г. {{ $vacancy->city->name }}</span>
                                        <div>{{ $vacancy->specialization->name }}</div>
                                    </div>
                                    @if(!is_null($vacancy->employer->photo))
                                    <div class="ml-auto my-2">
                                        <div>
                                            <img style="max-width: 70px;" src="/{{$PATH_TO_EMPLOYER_PHOTO . $vacancy->employer->photo }}" alt="...">
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row no-gutters mt-2">
                                    <div>
                                        @can('is_applicant')
                                            @if ($vacancy->responded())
                                                @if($vacancy->responded->hasStatus('invite'))
                                                    <a class="text-success" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                                @elseif($vacancy->responded->hasStatus('discard'))
                                                    <a class="text-danger" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                                @else
                                                    <a class="text-secondary" href="{{ route('applicant.negotiation.show', $vacancy->responded->id) }}">{{ $vacancy->responded->status->name }}</a>
                                                @endif
                                            @else
                                                <a class="text-secondary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
                                            @endif
                                        @endcan

                                        @guest
                                            <a class="text-secondary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
                                        @endguest
                                    </div>
                                    <div class="ml-auto">
                                        {{ $vacancy->get_created_at() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection