<?php

/*
|--------------------------------------------------------------------------
| MIC Office Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth']], 
              function () {

  // User
  Route::get('user/settings', [
    'as'=>'user.settings', 'uses'=>'MIC\UserController@userSettings' 
  ]);
  Route::post('user/settings', [
    'as'=>'user.save_settings.post', 'uses'=>'MIC\UserController@saveUserSettings' 
  ]);

  // Claim Doc 
  Route::post('claim/{claim_id}/upload-doc', [
    'as'=>'claim.upload.doc', 'uses'=>'MIC\ClaimController@uploadClaimDoc' 
  ]);
  Route::get('claim/{claim_id}/delete/{doc_id}', [
    'as'=>'claim.delete.doc', 'uses'=>'MIC\ClaimController@deleteClaimDoc' 
  ]);

  Route::get('claim/{claim_id}/doc-list', [
    'as'=>'claim.doc_list', 'uses'=>'MIC\ClaimController@claimDocList' 
  ]);

  Route::get('claim/{claim_id}/view/{doc_id}', [
    'as'=>'claim.doc.view_panel', 'uses'=>'MIC\ClaimController@claimDocViewPanel' 
  ]);

  // Claim Doc Comment
  Route::get('claim/doc/{doc_id}/comment/{comment_id}/post', [
    'as'=>'claim.doc.comment.post', 'uses'=>'MIC\ClaimController@postClaimDocComment' 
  ]);

  Route::get('claim/doc/{doc_id}/comment/list', [
    'as'=>'claim.doc.comment.list', 'uses'=>'MIC\ClaimController@claimDocCommentList' 
  ]);

  // Activity
  Route::get('claim/{claim_id}/activity-list', [
    'as'=>'claim.activity_list', 'uses'=>'MIC\ClaimController@claimAcitivityList' 
  ]);  

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

  Route::get('patient/claim/{claim_id}', [
    'as'=>$as1.'claim.page', 'uses'=>'MIC\ClaimController@patientClaimPage' 
  ]);

  Route::post('patient/claim/{claim_id}/upload-photo', [
    'as'=>$as1.'claim.upload.photo', 'uses'=>'MIC\ClaimController@patientUploadPhoto' 
  ]);
  Route::get('patient/claim/{claim_id}/delete/{photo_id}', [
    'as'=>$as1.'claim.delete.photo', 'uses'=>'MIC\ClaimController@patientDeletePhoto' 
  ]);

  Route::get('patient/claim/{claim_id}/photo-list', [
    'as'=>$as1.'claim.photo_list', 'uses'=>'MIC\ClaimController@claimPhotoList' 
  ]);

  Route::get('patient/claim/{claim_id}/assign-request/{car_id}/{action}', [
    'as'=>$as1.'claim.assign-request.action', 'uses'=>'MIC\ClaimController@patientCARAction' 
  ]);

  Route::post('claim/{claim_id}/update-ioi', [
    'as'=>$as1.'claim.update.ioi', 'uses'=>'MIC\ClaimController@updateIOI' 
  ]);
});

Route::group(['middleware' => ['auth', 'permission:PARTNER_PANEL']], 
              function () {
  $as2 = 'partner.';
  Route::get('partner/claims', [
    'as'=>$as2.'claims', 'uses'=>'MIC\ClaimController@partnerClaims' 
  ]);

  Route::get('partner/claim/{claim_id}', [
    'as'=>$as2.'claim.page', 'uses'=>'MIC\ClaimController@partnerClaimPage' 
  ]);
  Route::get('partner/claim/{claim_id}/assign-request/{car_id}/{action}', [
    'as'=>$as2.'claim.assign-request.action', 'uses'=>'MIC\ClaimController@partnerCARAction' 
  ]);
});