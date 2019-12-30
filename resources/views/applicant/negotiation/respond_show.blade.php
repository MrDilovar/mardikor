@extends('layout')
@section('content')
    <div class="container">
        <h3 class="font-weight-light my-4">Отправить отклик на вакансию</h3>
        @if ($errors->has('resumeId'))
            <div class="alert alert-danger">Произошло неизвестная ошибка!</div>
        @endif
        <form id="form_respond" action="{{ route('applicant.negotiation.respond.store', $vacancy->id) }}" method="post">
            {{ csrf_field() }}
            <div class="ml-2">
                <h4 class="my-4">{{ $vacancy->name }}</h4>
                <div class="form-group">
                    <span class="font-weight-bold">Резюме для отклика</span>
                </div>
                @foreach($resumes as $resume)
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="resume{{ $resume->id }}" name="resumeId" value="{{ $resume->id }}" class="custom-control-input" {{ $loop->first ? 'checked' : '' }}>
                                <label class="custom-control-label" for="resume{{ $resume->id }}">{{ $resume->title }}</label>
                            </div>
                        </div>
                        <div class="col-auto"><a href="{{ route('guest.resume', $resume->id) }}" class="small ">Посмотреть резюме</a></div>
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
                            <p>Здравствуйте.</p>
                            <p>Прошу Вас рассмотреть мою кандидатуру на вакансию "{{ $vacancy->name }}".</p>
                            <p>С уважением, {{ $resume->applicant->first_name . ' ' . $resume->applicant->last_name }}.</p>
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