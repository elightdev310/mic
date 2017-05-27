<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/* ================== Homepage + Admin Routes ================== */
require __DIR__.'/admin_routes.php';
require __DIR__.'/micadmin_routes.php';
require __DIR__.'/mic_routes.php';

Route::get('test-qb', [
  'uses' => 'HomeController@testAction'
]);

/* ============================================================= */
Route::get('login/patient', [
  'as' => 'login.patient', 'uses' => 'Auth\MICAuthController@showLoginPatientForm'
]);
Route::get('login/partner', [
  'as' => 'login.partner', 'uses' => 'Auth\MICAuthController@showLoginPartnerForm'
]);
Route::post('login', 'Auth\MICAuthController@postUserlogin');

Route::get('password/reset/{token?}', 'Auth\MICPasswordController@showResetForm');
Route::post('password/email', 'Auth\MICPasswordController@sendResetLinkEmail');

// Register
Route::get('sign-up', [
  'as' => 'signup', 'uses' => 'Auth\MICAuthController@signUp'
]);

Route::get('register', 'Auth\MICAuthController@register');
Route::get('register/patient', [
  'as' => 'register.patient', 'uses' => 'Auth\MICAuthController@showRegisterPatientForm'
]);
Route::post('register/patient', [
  'as' => 'register.patient.post', 'uses' => 'Auth\MICAuthController@registerPatient'
]);

Route::get('register/complete', [
  'as' => 'register.complete', 'uses' => 'Auth\MICAuthController@registerComplete'
]);

// Confirm Link
Route::get('activation/user/{token}', [
  'as' => 'ativation.user', 'uses' => 'Auth\MICAuthController@activateUser'
]);
Route::get('activation/resend', [
  'as' => 'activation.resend', 'uses' => 'Auth\MICAuthController@resendActivation'
]);

// Complete Profile when started
Route::get('register/complete-profile', [
  'as'=>'register.complete_profile', 'uses' => 'Auth\MICAuthController@completePatientProfileForm'
]);
Route::post('register/complete-profile', [
  'as'=>'register.complete_profile.post', 'uses' => 'Auth\MICAuthController@completePatientProfile'
]);

// Partner Send Application to Admin
Route::group(['middleware' => 'guest'], function () {
  Route::get('apply/step-1', [
    'as' => 'apply.step1', 'uses' => 'MIC\ApplicationController@applyStep1Form',
  ]);
  Route::get('apply/step-2', [
    'as' => 'apply.step2', 'uses' => 'MIC\ApplicationController@applyStep2Form',
  ]);
  Route::get('apply/step-3', [
    'as' => 'apply.step3', 'uses' => 'MIC\ApplicationController@applyStep3Form',
  ]);
  Route::post('apply/step-1', [
    'as' => 'apply.step1.post', 'uses' => 'MIC\ApplicationController@applyStep1',
  ]);
  Route::post('apply/step-2', [
    'as' => 'apply.step2.post', 'uses' => 'MIC\ApplicationController@applyStep2',
  ]);
  Route::post('apply/step-3', [
    'as' => 'apply.step3.post', 'uses' => 'MIC\ApplicationController@applyStep3',
  ]);

  Route::get('apply', 'MIC\ApplicationController@applyStep1Form');
  Route::get('apply/completed', [
    'as' => 'apply.completed', 'uses' => 'MIC\ApplicationController@applyCompleted',
  ]);
});
