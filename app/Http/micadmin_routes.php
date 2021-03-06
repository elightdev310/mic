<?php

/*
|--------------------------------------------------------------------------
| MIC Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['prefix'=>config('mic.adminRoute'), 
              'middleware' => ['auth', 'permission:CASE_MANAGER_PANEL']], 
              function () {
  $as = 'micadmin.';

  Route::get('/', [
    'as'=>$as.'dashboard', 'uses'=>'MIC\Admin\DashboardController@index' 
  ]);
  
  Route::get('claims', [
    'as'=>$as.'claim.list', 'uses'=>'MIC\Admin\ClaimController@claimsList' 
  ]);

  // Route::get('claim/{claim_id}', [
  //   'as'=>$as.'claim.page', 'uses'=>'MIC\Admin\ClaimController@claimPage' 
  // ]);
  Route::get('claim/{claim_id}', [
    'as'=>$as.'claim.view', 'uses'=>'MIC\Admin\ClaimController@claimIOIPage' 
  ]);
  Route::get('claim/{claim_id}/ioi', [
    'as'=>$as.'claim.view.ioi', 'uses'=>'MIC\Admin\ClaimController@claimIOIPage' 
  ]);
  Route::get('claim/{claim_id}/activity', [
    'as'=>$as.'claim.view.activity', 'uses'=>'MIC\Admin\ClaimController@claimActivityPage' 
  ]);
  Route::get('claim/{claim_id}/docs', [
    'as'=>$as.'claim.view.docs', 'uses'=>'MIC\Admin\ClaimController@claimDocsPage' 
  ]);
  Route::get('claim/{claim_id}/photos', [
    'as'=>$as.'claim.view.photos', 'uses'=>'MIC\Admin\ClaimController@claimPhotosPage' 
  ]);
  Route::get('claim/{claim_id}/action', [
    'as'=>$as.'claim.view.action', 'uses'=>'MIC\Admin\ClaimController@claimActionPage' 
  ]);
  Route::get('claim/{claim_id}/partners', [
    'as'=>$as.'claim.view.partners', 'uses'=>'MIC\Admin\ClaimController@claimPartnersPage' 
  ]);
  Route::get('claim/{claim_id}/invite-partner', [
    'as'=>$as.'claim.view.invite_partner', 'uses'=>'MIC\Admin\ClaimController@claimInvitePartnerPage' 
  ]);

  // Claim Billing Doc 
  Route::post('claim/{claim_id}/upload-billing-doc/{reply_to_doc_id}', [
    'as'=>$as.'claim.upload.billing_doc', 'uses'=>'MIC\Admin\ClaimController@uploadClaimBillingDoc' 
  ]);

  // Route::get('claim/{claim_id}/assign/{partner_uid}', [
  //   'as'=>$as.'claim.assign.partner', 'uses'=>'MIC\Admin\ClaimController@claimAssignPartner' 
  // ]);
  Route::get('claim/{claim_id}/assign-request/{partner_uid}', [
    'as'=>$as.'claim.assign_request.partner', 'uses'=>'MIC\Admin\ClaimController@claimAssignRequest' 
  ]);
  Route::get('claim/{claim_id}/unassign/{partner_uid}', [
    'as'=>$as.'claim.unassign.partner', 'uses'=>'MIC\Admin\ClaimController@claimUnassignPartner' 
  ]);

  Route::get('claim/{claim_id}/doc-access-panel/{doc_id}', [
    'as'=>$as.'claim.doc.access_panel', 'uses'=>'MIC\Admin\ClaimController@claimDocAccessPanel' 
  ]);
  Route::get('claim/{claim_id}/set-doc-access/{doc_id}', [
    'as'=>$as.'claim.doc.set_access', 'uses'=>'MIC\Admin\ClaimController@setClaimDocAccess' 
  ]);

  // Claim Billing Doc 
  Route::post('claim/{claim_id}/summary', [
    'as'=>$as.'claim.summary.post', 'uses'=>'MIC\Admin\ClaimController@saveClaimSummary' 
  ]);

});

Route::group(['prefix'=>config('mic.adminRoute'), 
              'middleware' => ['auth', 'permission:MICADMIN_PANEL']], 
              function () {
  $as = 'micadmin.';

  Route::get('applications/{status}', [
    'as'=>$as.'apps.list', 'uses'=>'MIC\Admin\ApplicationController@appList' 
  ]);

  Route::get('application/{app_id}', [
    'as'=>$as.'app.view', 'uses'=>'MIC\Admin\ApplicationController@appView' 
  ]);
  Route::get('application/{app_id}/approve', [
    'as'=>$as.'app.approve', 'uses'=>'MIC\Admin\ApplicationController@appApprove' 
  ]);
  Route::post('apps/bulk-action', [
    'as'=>$as.'app.bulk_action.post', 'uses'=>'MIC\Admin\ApplicationController@bulkAction' 
  ]);

  Route::get('patients', [
    'as'=>$as.'patients.list', 'uses'=>'MIC\Admin\UserController@patientList' 
  ]);
  Route::get('partners', [
    'as'=>$as.'partners.list', 'uses'=>'MIC\Admin\UserController@partnerList' 
  ]);
  Route::get('users', [
    'as'=>$as.'users.list', 'uses'=>'MIC\Admin\UserController@index' 
  ]);

  Route::get('user/add', [
    'as'=>$as.'user.add', 'uses'=>'MIC\Admin\UserController@addUserPage' 
  ]);
  Route::post('user/add', [
    'as'=>$as.'user.add.post', 'uses'=>'MIC\Admin\UserController@addUserAction' 
  ]);


  Route::get('user/{uid}', [
    'as'=>$as.'user.settings', 'uses'=>'MIC\Admin\UserController@userSettings' 
  ]);
  Route::post('user/{uid}', [
    'as'=>$as.'user.save_settings.post', 'uses'=>'MIC\Admin\UserController@saveUserSettings' 
  ]);
  Route::post('user/{uid}/delete', [
    'as'=>$as.'user.delete_user.post', 'uses'=>'MIC\Admin\UserController@deleteUserAction' 
  ]);

  Route::get('i-questions', [
    'as'=>$as.'iquiz.list', 'uses'=>'MIC\Admin\IQuestionController@quizList' 
  ]);  
  Route::post('i-questions/sort', [
    'as'=>$as.'iquiz.sort.post', 'uses'=>'MIC\Admin\IQuestionController@quizSortPost' 
  ]);  

  Route::get('i-questions/add', [
    'as'=>$as.'iquiz.add', 'uses'=>'MIC\Admin\IQuestionController@quizAddForm' 
  ]);  
  Route::post('i-questions/add', [
    'as'=>$as.'iquiz.add.post', 'uses'=>'MIC\Admin\IQuestionController@quizAddPost' 
  ]);  

  Route::get('i-questions/{quiz_id}/edit', [
    'as'=>$as.'iquiz.edit', 'uses'=>'MIC\Admin\IQuestionController@quizEditForm' 
  ]);  
  Route::post('i-questions/{quiz_id}/edit', [
    'as'=>$as.'iquiz.edit.post', 'uses'=>'MIC\Admin\IQuestionController@quizEditPost' 
  ]);  

  Route::get('i-questions/{quiz_id}/delete', [
    'as'=>$as.'iquiz.delete', 'uses'=>'MIC\Admin\IQuestionController@quizDelete' 
  ]);  

  // Resources
  Route::get('resources', [
    'as'=>$as.'resource.list', 'uses'=>'MIC\Admin\ResourceController@resourceList' 
  ]);  

  Route::post('resources/sort', [
    'as'=>$as.'resource.sort.post', 'uses'=>'MIC\Admin\ResourceController@resourceSortPost' 
  ]);  

  Route::get('resoure/add', [
    'as'=>$as.'resource.add', 'uses'=>'MIC\Admin\ResourceController@resourceAddForm' 
  ]);  
  Route::post('resource/add', [
    'as'=>$as.'resource.add.post', 'uses'=>'MIC\Admin\ResourceController@resourceAddPost' 
  ]);   

  Route::get('resoure/{resource_id}/edit', [
    'as'=>$as.'resource.edit', 'uses'=>'MIC\Admin\ResourceController@resourceEditForm' 
  ]);  
  Route::post('resoure/{resource_id}/edit', [
    'as'=>$as.'resource.edit.post', 'uses'=>'MIC\Admin\ResourceController@resourceEditPost' 
  ]);   

  Route::get('resource/{ra_id}/delete', [
    'as'=>$as.'resource.delete', 'uses'=>'MIC\Admin\ResourceController@resourceDelete' 
  ]);


  // Claims

  Route::get('learning-videos', [
    'as'=>$as.'learning_video.list', 'uses'=>'MIC\Admin\VideoController@videoList' 
  ]);  

  Route::post('learning-videos/sort', [
    'as'=>$as.'learning_video.sort.post', 'uses'=>'MIC\Admin\VideoController@videoSortPost' 
  ]);  

  Route::get('learning-videos/add', [
    'as'=>$as.'learning_video.add', 'uses'=>'MIC\Admin\VideoController@videoAddForm' 
  ]);  
  Route::post('learning-videos/add', [
    'as'=>$as.'learning_video.add.post', 'uses'=>'MIC\Admin\VideoController@videoAddPost' 
  ]);   

  Route::get('learning-videos/{va_id}/delete', [
    'as'=>$as.'learning_video.delete', 'uses'=>'MIC\Admin\VideoController@videoDelete' 
  ]);  

  Route::get('user/{uid}/learning-videos/add', [
    'as'=>$as.'user.learning_video.add', 'uses'=>'MIC\Admin\VideoController@userVideoAddForm' 
  ]);  
  Route::post('user/{uid}/learning-videos/add', [
    'as'=>$as.'user.learning_video.add.post', 'uses'=>'MIC\Admin\VideoController@userVideoAddPost' 
  ]);
  Route::get('user/{uid}/learning-videos/{va_id}/delete', [
    'as'=>$as.'user.learning_video.delete', 'uses'=>'MIC\Admin\VideoController@userVideoDelete' 
  ]);
  Route::post('user/{uid}/learning-videos/sort', [
    'as'=>$as.'user.learning_video.sort.post', 'uses'=>'MIC\Admin\VideoController@userVideoSortPost' 
  ]);  

  Route::get('qbo/connection', 'MIC\QuickBookController@qboConnection');

  Route::get('qbo/oauth', 'MIC\QuickBookController@qboOauth');
  Route::get('qbo/success','MIC\QuickBookController@qboSuccess');
  Route::get('qbo/disconnect','MIC\QuickBookController@qboDisconnect');

});


/**
 * Super Admin Route
 */
Route::group(['prefix'=>config('mic.superRoute'), 
              'middleware' => ['auth', 'permission:ADMIN_PANEL']], 
              function () {
  $as = 'micsuper.';
  Route::get('/', [
    'as'=>$as.'dashboard', 'uses'=>'MIC\SuperAdmin\LogController@historyLogin' 
  ]);  

  Route::get('history/login', [
    'as'=>$as.'history.login', 'uses'=>'MIC\SuperAdmin\LogController@historyLogin' 
  ]);

  Route::get('history/all', [
    'as'=>$as.'history.all', 'uses'=>'MIC\SuperAdmin\LogController@historyAll' 
  ]);  

});
