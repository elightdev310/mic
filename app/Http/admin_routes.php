<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== Patients ================== */
	Route::resource(config('laraadmin.adminRoute') . '/patients', 'LA\PatientsController');
	Route::get(config('laraadmin.adminRoute') . '/patient_dt_ajax', 'LA\PatientsController@dtajax');

	/* ================== Partners ================== */
	Route::resource(config('laraadmin.adminRoute') . '/partners', 'LA\PartnersController');
	Route::get(config('laraadmin.adminRoute') . '/partner_dt_ajax', 'LA\PartnersController@dtajax');

	/* ================== PaymentInfos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/paymentinfos', 'LA\PaymentInfosController');
	Route::get(config('laraadmin.adminRoute') . '/paymentinfo_dt_ajax', 'LA\PaymentInfosController@dtajax');

	/* ================== Applications ================== */
	Route::resource(config('laraadmin.adminRoute') . '/applications', 'LA\ApplicationsController');
	Route::get(config('laraadmin.adminRoute') . '/application_dt_ajax', 'LA\ApplicationsController@dtajax');

	/* ================== IQuestions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/iquestions', 'LA\IQuestionsController');
	Route::get(config('laraadmin.adminRoute') . '/iquestion_dt_ajax', 'LA\IQuestionsController@dtajax');

	/* ================== Claims ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claims', 'LA\ClaimsController');
	Route::get(config('laraadmin.adminRoute') . '/claim_dt_ajax', 'LA\ClaimsController@dtajax');

	/* ================== Partner2Claims ================== */
	Route::resource(config('laraadmin.adminRoute') . '/partner2claims', 'LA\Partner2ClaimsController');
	Route::get(config('laraadmin.adminRoute') . '/partner2claim_dt_ajax', 'LA\Partner2ClaimsController@dtajax');

	/* ================== ClaimPhotos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimphotos', 'LA\ClaimPhotosController');
	Route::get(config('laraadmin.adminRoute') . '/claimphoto_dt_ajax', 'LA\ClaimPhotosController@dtajax');

	/* ================== ClaimDocs ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimdocs', 'LA\ClaimDocsController');
	Route::get(config('laraadmin.adminRoute') . '/claimdoc_dt_ajax', 'LA\ClaimDocsController@dtajax');

	/* ================== ClaimDocAccesses ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimdocaccesses', 'LA\ClaimDocAccessesController');
	Route::get(config('laraadmin.adminRoute') . '/claimdocaccess_dt_ajax', 'LA\ClaimDocAccessesController@dtajax');

	/* ================== ClaimDocComments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimdoccomments', 'LA\ClaimDocCommentsController');
	Route::get(config('laraadmin.adminRoute') . '/claimdoccomment_dt_ajax', 'LA\ClaimDocCommentsController@dtajax');

	/* ================== ClaimActivities ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimactivities', 'LA\ClaimActivitiesController');
	Route::get(config('laraadmin.adminRoute') . '/claimactivity_dt_ajax', 'LA\ClaimActivitiesController@dtajax');

	/* ================== ClaimActivityFeeds ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimactivityfeeds', 'LA\ClaimActivityFeedsController');
	Route::get(config('laraadmin.adminRoute') . '/claimactivityfeed_dt_ajax', 'LA\ClaimActivityFeedsController@dtajax');

	/* ================== ClaimAssignRequests ================== */
	Route::resource(config('laraadmin.adminRoute') . '/claimassignrequests', 'LA\ClaimAssignRequestsController');
	Route::get(config('laraadmin.adminRoute') . '/claimassignrequest_dt_ajax', 'LA\ClaimAssignRequestsController@dtajax');

	/* ================== YoutubeVideos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/youtubevideos', 'LA\YoutubeVideosController');
	Route::get(config('laraadmin.adminRoute') . '/youtubevideo_dt_ajax', 'LA\YoutubeVideosController@dtajax');

	/* ================== VideoAccesses ================== */
	Route::resource(config('laraadmin.adminRoute') . '/videoaccesses', 'LA\VideoAccessesController');
	Route::get(config('laraadmin.adminRoute') . '/videoaccess_dt_ajax', 'LA\VideoAccessesController@dtajax');

	/* ================== Notifications ================== */
	Route::resource(config('laraadmin.adminRoute') . '/notifications', 'LA\NotificationsController');
	Route::get(config('laraadmin.adminRoute') . '/notification_dt_ajax', 'LA\NotificationsController@dtajax');

	/* ================== Subscriptions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/subscriptions', 'LA\SubscriptionsController');
	Route::get(config('laraadmin.adminRoute') . '/subscription_dt_ajax', 'LA\SubscriptionsController@dtajax');
});
