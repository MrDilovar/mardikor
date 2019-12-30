@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">{{ $negotiation->status->name }}</h3>
        <div>
            <a class="text-secondary" href="{{ route('guest.resume', $negotiation->resume->id) }}">{{ $negotiation->resume->title }}</a>
            в вакансию
            <a href="{{ route('guest.vacancy', $negotiation->vacancy->id) }}">{{ $negotiation->vacancy->name }}</a>
        </div>
        <div class="mt-3">
            @if($negotiation->status->id == 3 || $negotiation->status->id == 4)
                <a href="{{ route('employer.negotiation.cancel', $negotiation->id) }}" class="btn btn-sm btn-success">Отменить</a>
            @else
                <a href="{{ route('employer.negotiation.discard.show', $negotiation->id) }}" class="btn btn-sm btn-danger">Отказ</a>
                <a href="{{ route('employer.negotiation.invite.show', $negotiation->id) }}" class="btn btn-sm btn-success">Приглашение</a>
            @endif
        </div>
        <div class="row mt-4">
            <div class="col-8">
                @if(!is_null($negotiation->resume_letter))
                    <div class="row">
                        <div class="col-md-8">
                            <div class="bg-light small p-3">
                                {!! $negotiation->resume_letter !!}
                            </div>
                            <div class="mt-2 text-muted small">
                                <span>Соискатель</span><br>
                                <span>{{ $negotiation->date }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                @if($negotiation->status->id == 3 || $negotiation->status->id == 4)
                    <div class="row mt-3">
                        <div class="col-md-8 offset-md-2">
                            @if($negotiation->status->id == 3)
                                <div class="small text-success font-weight-bold">Приглашение</div>
                            @elseif($negotiation->status->id == 4)
                                <div class="small text-danger font-weight-bold">Отказ</div>
                            @endif
                            <div class="bg-light small p-3 mt-2">
                                {!! $negotiation->vacancy_letter !!}
                            </div>
                            <div class="mt-2 text-muted small text-right">
                                <span>Работодатель</span><br>
                                <span>{{ $negotiation->employer_date }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection