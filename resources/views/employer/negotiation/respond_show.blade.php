@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">Отправить отклик на резюме</h3>
        @if ($errors->has('resumeId'))
            <div class="alert alert-danger">Произошло неизвестная ошибка!</div>
        @endif
        <form id="form_respond" action="{{ route('employer.negotiation.respond.store', $resume->id) }}" method="post">
            {{ csrf_field() }}
            <div class="ml-2">
                <h4 class="my-4">{{ $resume->title }}</h4>
                <div class="form-group">
                    <span class="font-weight-bold">Вакансия для отклика</span>
                </div>
                @foreach($vacancies as $vacancy)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="resume{{ $vacancy->id }}" name="vacancy_id" value="{{ $vacancy->id }}" class="custom-control-input" {{ $loop->first ? 'checked' : '' }} {{ is_null($allows_vacancies->where('id', $vacancy->id)->first()) ? 'disabled' : '' }}>
                                <label class="custom-control-label" for="resume{{ $vacancy->id }}">{{ $vacancy->name }}</label>
                            </div>
                        </div>
                        <div class="col-auto"><a href="{{ route('guest.vacancy', $vacancy->id) }}" class="small ">Посмотреть вакансию</a></div>
                    </div>
                @endforeach
                <div class="form-group">
                    <button class="btn btn-outline-info btn-sm" type="button" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Сопроводительное письмо
                    </button>
                    <br>
                    @if ($errors->has('letter'))
                        <span class="font-weight-bold small">{{ $errors->first('letter') }}</span>
                    @endif
                </div>
                <div class="form-group row collapse" id="collapseExample">
                    <div class="col-10 col-sm-8 col-lg-5 position-relative">
                        <input type="hidden" name="letter">
                        <div id="letter_editor" class="h-auto" style="min-height: 100px;">
                            <p>Здравствуйте, {{ $resume->applicant->first_name . ' ' . $resume->applicant->last_name }}!</p>
                            <p>Приглашаем Вас на встречу в офис нашей Компании по адресу г. {{ Auth::user()->data->city->name }}, {{ Auth::user()->data->address }}.</p>
                            <p>Для подтверждения своей заинтересованности перезвоните, пожалуйста, в рабочее время по телефону {{ Auth::user()->data->phone }}.</p>
                            <p>С уважением, {{ Auth::user()->data->brand }}.</p>
                        </div>
                    </div>
                </div>
                <div class="form-group my-5">
                    <button class="btn btn-primary" type="submit">Откликнуться</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        new Quill('#letter_editor', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }],
                ]
            },
            theme: 'snow'
        });

        $('#form_respond').submit(function() {
            $('input[name=letter]').val($('#letter_editor .ql-editor').html());
        });
    </script>
@endsection