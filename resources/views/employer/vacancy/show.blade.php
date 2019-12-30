@extends('layout')
@section('content')
    <div class="container py-3">
        <div class="row py-3">
            <div class="col-sm-2">
                <img class="img-fluid rounded-circle" src="/img/applicant/test0.jpg" alt="...">
            </div>
            <div class="col-sm-10">
                <h4 class="mb-3">{{ $resume->first_name }} {{ $resume->last_name }}</h4>
                <div>{{ $resume->gender }}, родился {{ $resume->birthday }}</div>
                <div>{{ $resume->city->name }}</div>
                <div>{{ $resume->email }}</div>
                <div>+992 900 12 88 21</div>
            </div>
        </div>
        <hr>
        <h4 class="mb-3">{{ $resume->title }}</h4>
        <div>{{ $resume->specialization->name }}</div>
        <div>{{ $resume->salary }} <b>сомони</b> на руки</div>
    </div>
@endsection