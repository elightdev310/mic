<?php

/*
|--------------------------------------------------------------------------
| MIC Office Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth']], 
              function () {

});

Route::group(['middleware' => ['auth', 'permission:PATIENT_PANEL']], 
              function () {
  $as1 = 'patient.';

  Route::get('claim/create', [
    'as'=>$as1.'claim.create', 'uses'=>'MIC\ClaimController@createClaimPage' 
  ]);
  Route::get('claim/create/call-911', [
    'as'=>$as1.'claim.create.call911', 'uses'=>'MIC\ClaimController@ccCall911Page' 
  ]);
  Route::get('claim/create/injury-questions', [
    'as'=>$as1.'claim.create.injury_quiz', 'uses'=>'MIC\ClaimController@ccInjuryQuestion' 
  ]);
  Route::post('claim/create/injury-questions', [
    'as'=>$as1.'claim.create.injury_quiz.post', 'uses'=>'MIC\ClaimController@ccInjuryQuestionPost' 
  ]);
  Route::get('claim/create/review-answer', [
    'as'=>$as1.'claim.create.review_answer', 'uses'=>'MIC\ClaimController@ccReviewAnswer' 
  ]);
  Route::get('claim/create/cancel', [
    'as'=>$as1.'claim.create.cancel_submit', 'uses'=>'MIC\ClaimController@ccCancelSubmit' 
  ]);
  Route::get('claim/create/submit', [
    'as'=>$as1.'claim.create.submit', 'uses'=>'MIC\ClaimController@ccSubmitClaim' 
  ]);

  Route::get('claim/create/{claim_id}/upload-photo', [
    'as'=>$as1.'claim.create.upload_photo', 'uses'=>'MIC\ClaimController@ccUploadPhoto' 
  ]);

  Route::get('claim/create/complete-submission/{claim_id}', [
    'as'=>$as1.'claim.create.complete', 'uses'=>'MIC\ClaimController@ccCompleteSubmit' 
  ]);

  Route::get('my-claims', [
    'as'=>$as1.'myclaims', 'uses'=>'MIC\ClaimController@myClaimsPage' 
  ]);

});

Route::group(['middleware' => ['auth', 'permission:PARTNER_PANEL']], 
              function () {

});
