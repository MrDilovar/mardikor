@extends('layout')
@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success mt-4">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="mt-4">
            <h2 class="font-weight-normal">{{ $vacancy->name }}</h2>
            <h5 class="font-weight-normal">
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
            </h5>
        </div>
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="row justify-content-between">
                    <div class="col-auto my-auto">
                        <h4 class="font-weight-normal"><a href="{{ route('guest.employer', $vacancy->employer->id) }}" class="text-decoration-none">{{ $vacancy->employer->brand }}</a></h4>
                        <span>г. {{ $vacancy->city->name }}</span>
                    </div>
                    @if(!is_null($vacancy->employer->photo))
                        <div class="col-auto py-2">
                            <img style="max-width: 120px; max-height: 80px;" src="{{'/' . $PATH_TO_EMPLOYER_PHOTO . $vacancy->employer->photo }}" alt="applicant photo...">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class=" mt-4">Требуемый опыт работы: {{ $vacancy->vacancy_experience->name }}</div>
        <div class="ql-editor-show mt-4">
            {!! $vacancy->description !!}
        </div>
        <div class="mt-4">
            <span class="font-italic font-weight-bold">Вакансия опубликована <span class="text-lowercase">{{ $vacancy->date }}</span></span>
        </div>
        <div class="mt-4">
            @can('is_applicant')
                @if ($vacancy->negotiation)
                    <a class="btn btn-outline-success" href="{{ route('applicant.negotiation.show', $vacancy->negotiation->id) }}">Смотреть отклик</a>
                @else
                    <a class="btn btn-primary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
                @endif
            @endcan

            @guest
                <a class="btn btn-primary" href="{{ route('applicant.negotiation.respond.show', $vacancy->id) }}">Откликнуться</a>
            @endguest
        </div>
    </div>
@endsection