<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Guest'], function () {
    Route::get('/', ['as'=>'home', 'uses'=>'HomeController@home']);
    Route::get('/vacancy/{id}', ['as'=>'guest.vacancy', 'uses'=>'HomeController@vacancy'])->where('id', '[0-9]+');
    Route::get('/resume/{id}', ['as'=>'guest.resume', 'uses'=>'HomeController@resume'])->where('id', '[0-9]+');
    Route::get('/employer/{id}', ['as'=>'guest.employer', 'uses'=>'HomeController@employer'])->where('id', '[0-9]+');
    Route::get('/echo', 'HomeController@echo');
    Route::get('/mardikor', ['as'=>'guest.mardikor', 'uses'=>'MardikorController@index']);
    Route::get('/mardikor/create', ['as'=>'guest.mardikor.create', 'uses'=>'MardikorController@create']);
    Route::post('/mardikor', ['as'=>'guest.mardikor.store', 'uses'=>'MardikorController@store']);
    Route::get('/mardikor/{id}', ['as'=>'guest.mardikor.show', 'uses'=>'MardikorController@show'])->where('id', '[0-9]+');
    Route::get('/search/vacancy', ['as'=>'guest.search_vacancy', 'uses'=>'VacancyController@index']);
    Route::get('/search/resume', ['as'=>'guest.search_resume', 'uses'=>'ResumeController@index']);
});

//Auth Routs
Route::group(['middleware'=>['web', 'auth']], function () {

    //Applicant
    Route::group(['prefix'=>'applicant', 'as' => 'applicant.', 'namespace' => 'Applicant', 'middleware'=>'applicant'], function () {
        Route::resource('/resume', 'ResumeController');
        Route::group(['prefix'=>'education', 'as'=>'education.'], function () {
            Route::resource('/secondary', 'EducationSecondaryController');
            Route::resource('/higher', 'EducationHigherController');
        });
        Route::resource('/experience', 'JobExperienceController');
        Route::resource('/skill', 'SkillController');
        Route::resource('/language', 'LanguageController');

        Route::group(['prefix'=>'settings', 'as'=>'settings.'], function () {
            Route::get('/', ['as'=>'applicant.index', 'uses'=>'ApplicantController@applicant_index']);
            Route::post('/', ['as'=>'applicant.store', 'uses'=>'ApplicantController@applicant_store']);
            Route::get('/photo', ['as'=>'photo.index', 'uses'=>'ApplicantController@photo_index']);
            Route::post('/photo', ['as'=>'photo.store', 'uses'=>'ApplicantController@photo_store']);
        });

        Route::group(['prefix'=>'login', 'as'=>'login.'], function () {
            Route::get('/', ['as'=>'index', 'uses'=>'LoginController@index']);
            Route::post('/email', ['as'=>'email', 'uses'=>'LoginController@email']);
            Route::post('/password', ['as'=>'password', 'uses'=>'LoginController@password']);
        });

        Route::get('/negotiation/{id}/respond', 'NegotiationController@respond_show')
            ->name('negotiation.respond.show')
            ->where('id', '[0-9]+');

        Route::post('/negotiation/{id}/respond', 'NegotiationController@respond_store')
            ->name('negotiation.respond.store')
            ->where('id', '[0-9]+');

        Route::resource('/negotiation', 'NegotiationController');
    });

    //Employer
    Route::group(['prefix'=>'employer', 'as'=>'employer.', 'namespace' => 'Employer', 'middleware'=>'employer'], function () {
        Route::resource('/vacancy', 'VacancyController');

        Route::get('/negotiation/{id}/cancel', 'NegotiationController@cancel')
            ->name('negotiation.cancel')
            ->where('id', '[0-9]+');

        Route::get('/negotiation/{id}/discard', 'NegotiationController@discard_show')
            ->name('negotiation.discard.show')
            ->where('id', '[0-9]+');

        Route::post('/negotiation/{id}/discard', 'NegotiationController@discard_store')
            ->name('negotiation.discard.store')
            ->where('id', '[0-9]+');

        Route::get('/negotiation/{id}/invite', 'NegotiationController@invite_show')
            ->name('negotiation.invite.show')
            ->where('id', '[0-9]+');

        Route::post('/negotiation/{id}/invite', 'NegotiationController@invite_store')
            ->name('negotiation.invite.store')
            ->where('id', '[0-9]+');

        Route::get('/negotiation/{id}/respond', 'NegotiationController@respond_show')
            ->name('negotiation.respond.show')
            ->where('id', '[0-9]+');

        Route::post('/negotiation/{id}/respond', 'NegotiationController@respond_store')
            ->name('negotiation.respond.store')
            ->where('id', '[0-9]+');

        Route::resource('/negotiation', 'NegotiationController');

        Route::group(['prefix'=>'settings', 'as'=>'settings.'], function () {
            Route::get('/', ['as'=>'index', 'uses'=>'EmployerController@index']);
            Route::post('/employer', ['as'=>'employer', 'uses'=>'EmployerController@employer']);
            Route::post('/photo', ['as'=>'photo', 'uses'=>'EmployerController@photo']);
            Route::post('/email', ['as'=>'email', 'uses'=>'EmployerController@email']);
            Route::post('/password', ['as'=>'password', 'uses'=>'EmployerController@password']);
        });
    });

});

Auth::routes();

