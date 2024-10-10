<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\TwoStepVerificationController;
use App\Http\Controllers\Auth\SmsOtpController;
use App\Http\Controllers\GetStartedController;
use App\Http\Controllers\FicaProcessController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\APIValidationController;
use App\Http\Controllers\ConsumerFicaProcess;
use App\Http\Controllers\CustomerVerification;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCreateController;
use App\Http\Controllers\AdminSelfBankController;
use App\Http\Controllers\ClientCaptureController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\tomerVerification;
use App\Http\Controllers\FAQ;
use App\Http\Controllers\VerificationDataController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::fallback(function(){ return response()->view('errors.404', [], 404); });

Auth::routes();
Route::get('/search', [AdminController::class, 'search'])->name('search');
Route::post('/ajax-search', [AdminController::class, 'ajaxSearch'])->name('ajax-search');
Route::post('/search-sb', [AdminSelfBankController::class, 'searchsb'])->name('search-sb');
Route::any('/sb-results/{id}', [AdminSelfBankController::class, 'sbresults'])->name('sb-results');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home?customer=={customerName}', [HomeController::class, 'index']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//API's
Route::post('/selfie', [UserVerificationController::class, 'facialRecognitionWithXDS'])->name('selfie');
Route::post('/getselfieresult', [UserVerificationController::class, 'getSelfieResultFromxXDS'])->name('getselfieresult');

Route::post('/verifykyc-api', [APIValidationController::class, 'validateKYCAPI'])->name('kyc-api');
Route::post('/verifyavs-api', [APIValidationController::class, 'validateAVSPI'])->name('avs-api');
Route::post('/verifycompliance-api', [APIValidationController::class, 'validateCOMPLIENCEAPI'])->name('compliance-api');


Route::get('/sendotp', [SmsOtpController::class, 'sendOTP'])->name('sendotp');
Route::get('/otp', [TwoStepVerificationController::class, 'otp'])->name('otp');
Route::post('/otp', [TwoStepVerificationController::class, 'otpVerify']);
Route::post('/resendOTP', [TwoStepVerificationController::class, 'resendOTP'])->name('resendOTP');

Route::get('auth/forget-password', [ForgotPasswordController::class, 'ForgetPassword'])->name('forget');
Route::post('auth/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('auth/reset-password/{token?}', [ForgotPasswordController::class, 'ResetPassword'])->name('reset');
Route::post('auth/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::post('/validate-api', [APIValidationController::class, 'validateAPIs'])->name('validateapi');

// Route::get('/startfica', [GetStartedController::class, 'startFica'])->name('startfica');
// Route::post('/startfica', [GetStartedController::class, 'getStarted'])->name('startfica');
// Route::post('/start-fica', [GetStartedController::class, 'getStarted'])->name('start-fica');
// Route::post('/startfica', [FicaProcessController::class, 'ReadNotification'])->name('admin-dashboard-notification');
Route::get('/startfica', [App\Http\Controllers\GetStartedController::class, 'startFica'])->name('startfica');
Route::post('/startfica', [App\Http\Controllers\GetStartedController::class, 'getStarted'])->name('startfica');
Route::post('/start-fica', [App\Http\Controllers\GetStartedController::class, 'getStarted'])->name('start-fica');
Route::post('/deletes3', [App\Http\Controllers\FicaProcessController::class, 'deletefilefroms3'])->name('delete-s3');
Route::post('/startfica', [App\Http\Controllers\FicaProcessController::class, 'ReadNotification'])->name('admin-dashboard-notification');

// Route::get('/fica', [FicaProcessController::class, 'fica'])->name('fica');
// Route::post('/fica', [FicaProcessController::class, 'uploadfile']);
// Route::post('/fica-address', [awsController::class, 'proofOfAddress'])->name('proofofaddress');
// Route::post('/fica-bank', [awsController::class, 'proofOfBank'])->name('proofofbank');
// Route::post('/fica-indentity', [awsController::class, 'identitySubmit'])->name('submitID');
Route::post('/fica-indentity', [App\Http\Controllers\awsController::class, 'identitySubmit'])->name('submitID');
Route::post('/fica-bank', [App\Http\Controllers\awsController::class, 'proofOfBank'])->name('proofofbank');
Route::post('/fica-address', [App\Http\Controllers\awsController::class, 'proofOfAddress'])->name('proofofaddress');
Route::post('/fica', [App\Http\Controllers\FicaProcessController::class, 'uploadfile']);
Route::get('/fica', [App\Http\Controllers\FicaProcessController::class, 'fica'])->name('fica');


//Fica Process continue
Route::post('/personal-user-detail', [ConsumerFicaProcess::class, 'PersonalDetails'])->name('personal-user-detail');
Route::post('/financial-detail', [ConsumerFicaProcess::class, 'FinancialDetails'])->name('financial-detail');
Route::post('/screening', [ConsumerFicaProcess::class, 'Screening'])->name('screening');
Route::post('/declarations', [ConsumerFicaProcess::class, 'Declarations'])->name('declarations');
Route::post('/acknowledgement', [ConsumerFicaProcess::class, 'Acknowledgement'])->name('acknowledgement');

//Admin
Route::post('/admin-test', [App\Http\Controllers\CustomerVerification::class, 'TestResult'])->name('testresult');
Route::get('/admin-vertical', [App\Http\Controllers\CustomerVerification::class, 'AdminVertical'])->name('admin-vertical');
Route::get('/admin-reports', [App\Http\Controllers\CustomerVerification::class, 'AdminReports']);
Route::post('/admin-reports', [App\Http\Controllers\CustomerVerification::class, 'AdminSearchReports'])->name('search-reports');
Route::get('/admin-findusers', [App\Http\Controllers\AdminController::class, 'FindUsers'])->name('admin-findusers');
Route::post('/admin-findusers', [App\Http\Controllers\AdminController::class, 'Display'])->name('display-admin-findusers');
Route::get('/admin-users', [App\Http\Controllers\AdminController::class, 'ShowUsers'])->name('admin-users');
Route::post('/admin-actions', [App\Http\Controllers\CustomerVerification::class, 'AdminActions'])->name('admin-actions');
Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'ShowDashboard'])->name('admin-dashboard');

Route::post('/admin-client', [App\Http\Controllers\AdminCreateController::class, 'ShowCustomerDisplay'])->name('admin-client');
Route::get('/admin-client', [App\Http\Controllers\AdminCreateController::class, 'EditCustomer'])->name('client-show');

Route::get('/admin-display', [App\Http\Controllers\AdminCreateController::class, 'index'])->name('admin-display');
Route::any('/selfsb', [App\Http\Controllers\AdminSelfBankController::class, 'showselfsb'])->name('self-sb');
Route::get('/sb-dashboard', [App\Http\Controllers\AdminSelfBankController::class, 'showsbdashboard'])->name('sb-dashboard');
Route::post('/admin-display', [App\Http\Controllers\AdminCreateController::class, 'CreateAdminUser'])->name('admin-display');
Route::post('/admin-display', [App\Http\Controllers\AdminCreateController::class, 'ShowConglomerateEdit'])->name('conglomerate-edit');

Route::post('/admin-edit', [App\Http\Controllers\AdminCreateController::class, 'ShowCustomerEdit'])->name('edit-customer');
Route::post('/admin-conglomerate', [App\Http\Controllers\AdminCreateController::class, 'EditDetails'])->name('edit-details');  //edit here

Route::get('/admin-create', [App\Http\Controllers\AdminCreateController::class, 'ShowAdminCreate'])->name('admin-create');
Route::post('/admin-create', [App\Http\Controllers\AdminCreateController::class, 'CreateAdmin'])->name('create-admin');

Route::get('/admin-customer', [App\Http\Controllers\AdminCreateController::class, 'ShowCustomerCreate']);
Route::post('/admin-customer', [App\Http\Controllers\AdminCreateController::class, 'CreateCustomer'])->name('admin-customer');

Route::get('/admin-users', [AdminController::class, 'show']);
Route::get('/admin-tabs', [ClientCaptureController::class, 'ScreenUsersTabs'])->name('admin-tabs');
Route::post('/admin-tabs-personal', [CustomerVerification::class, 'PersonalDetailsUpdate'])->name('admin-tabs-personal');
Route::post('/admin-tabs-address', [CustomerVerification::class, 'AddressDetailsUpdate'])->name('admin-tabs-address');
Route::post('/admin-tabs-financial', [CustomerVerification::class, 'FinancialDetailsUpdate'])->name('admin-tabs-financial');
Route::post('/admin-tabs-screening', [CustomerVerification::class, 'ScreeningDetailsCreate'])->name('admin-tabs-screening');
Route::post('/admin-tabs-other', [CustomerVerification::class, 'OtherDetailsCreate'])->name('admin-tabs-other');
Route::get('/admin-comments', [CustomerVerification::class, 'UserComments'])->name('admin-comments');
Route::get('/admin-inbox', [CustomerVerification::class, 'UserInbox'])->name('admin-inbox');
Route::post('/admin-inbox', [CustomerVerification::class, 'SendMessage'])->name('admin-inbox-message');
Route::post('/send-email/{id}', [AdminSelfBankController::class, 'SendEmail'])->name('send-email');

//FAQ
Route::get('/FAQ', [App\Http\Controllers\FAQ::class, 'ShowPage'])->name('FAQ');
Route::get('/verify', [App\Http\Controllers\VerificationDataController::class, 'verifyClientData'])->name('verify');
Route::get('/verifyUserd', [App\Http\Controllers\VerifyUserController::class, 'verifyUser'])->name('verifyUserd');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('todos', TodoController::class);
    Route::resource('companies', CompanyController::class);
});



Route::post('/users.admincreate', [App\Http\Controllers\UserController::class, 'adminstore'])->name('users.adminstore');
Route::get('/users.admincreate', [App\Http\Controllers\UserController::class, 'admincreate'])->name('users.admincreate');
Route::get('/admin-client', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');

/* self banking related routes */
//Route::any('/send-selfservicelink', [AdminSelfBankController::class, 'SendLink'])->name('send-selfservicelink');
Route::get('/selfservice', [AdminSelfBankController::class, 'genearateLink'])->name('send-selfservicelink');
Route::get('/selfbankinglink', [AdminSelfBankController::class, 'selfBanking'])->name('selfbanking');
Route::any('/sb-initiate', [AdminSelfBankController::class, 'selfBankingStart'])->name('agree-selfbanking-tnc');
Route::any('/sb-personalinfo', [AdminSelfBankController::class, 'sbPersonalInfo'])->name('sb-personalinfo');
Route::any('/uploadid', [AdminSelfBankController::class, 'uploadid'])->name('uploadid');
Route::any('/digital-verification', [AdminSelfBankController::class, 'DigiVerification'])->name('digi-verify');
Route::post('/sbgetselfieresult', [AdminSelfBankController::class, 'getSelfieResultFromxXDS'])->name('sbgetselfieresult');
Route::any('/bank-verification', [AdminSelfBankController::class, 'BankVerification'])->name('bank-verify');
Route::post('/sbEmailorPhone', [AdminSelfBankController::class, 'sbEmailorPhone'])->name('sbEmailorPhone');
Route::any('/idvlink', [AdminSelfBankController::class, 'idvlink'])->name('idvlink');
Route::any('/banking', [AdminSelfBankController::class, 'bankingAvs'])->name('banking');
Route::any('/sb-preview-details', [AdminSelfBankController::class, 'previewDetails'])->name('sb-preview-details');
Route::get('/sb-status', [AdminSelfBankController::class, 'processStatus'])->name('process-status');



/* Cron crontroller routes */
Route::any('/getOtlSelfieResponse', [CronJobController::class, 'getDiaResponse'])->name('get-otl-Response');



