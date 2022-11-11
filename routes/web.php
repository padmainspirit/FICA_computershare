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
use App\Http\Controllers\ClientCaptureController;
use App\Http\Controllers\tomerVerification;
use App\Http\Controllers\FAQ;
use App\Http\Controllers\VerificationDataController;

  
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
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');

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

Route::get('/startfica', [GetStartedController::class, 'startFica'])->name('startfica');
Route::post('/startfica', [GetStartedController::class, 'getStarted'])->name('startfica');
Route::post('/start-fica', [GetStartedController::class, 'getStarted'])->name('start-fica');
Route::post('/startfica', [FicaProcessController::class, 'ReadNotification'])->name('admin-dashboard-notification');

Route::get('/fica', [FicaProcessController::class, 'fica'])->name('fica');
Route::post('/fica', [FicaProcessController::class, 'uploadfile']);
Route::post('/fica-address', [awsController::class, 'proofOfAddress'])->name('proofofaddress');
Route::post('/fica-bank', [awsController::class, 'proofOfBank'])->name('proofofbank');
Route::post('/fica-indentity', [awsController::class, 'identitySubmit'])->name('submitID');

//Fica Process continue
Route::post('/personal-user-detail', [ConsumerFicaProcess::class, 'PersonalDetails'])->name('personal-user-detail');
Route::post('/financial-detail', [ConsumerFicaProcess::class, 'FinancialDetails'])->name('financial-detail');
Route::post('/screening', [ConsumerFicaProcess::class, 'Screening'])->name('screening');
Route::post('/declarations', [ConsumerFicaProcess::class, 'Declarations'])->name('declarations');
Route::post('/acknowledgement', [ConsumerFicaProcess::class, 'Acknowledgement'])->name('acknowledgement');

//Admin
Route::post('/admin-test', [CustomerVerification::class, 'TestResult'])->name('testresult');
Route::get('/admin-vertical', [CustomerVerification::class, 'AdminVertical'])->name('admin-vertical');
Route::get('/admin-reports', [CustomerVerification::class, 'AdminReports']);
Route::post('/admin-reports', [CustomerVerification::class, 'AdminSearchReports'])->name('search-reports');
Route::get('/admin-findusers', [AdminController::class, 'FindUsers'])->name('admin-findusers');
Route::post('/admin-findusers', [AdminController::class, 'Display'])->name('display-admin-findusers');
Route::get('/admin-users', [AdminController::class, 'ShowUsers'])->name('admin-users');
Route::post('/admin-actions', [CustomerVerification::class, 'AdminActions'])->name('admin-actions');
Route::get('/admin-dashboard', [AdminController::class, 'ShowDashboard'])->name('admin-dashboard');

Route::get('/admin-client', [AdminCreateController::class, 'EditCustomer'])->name('client-show');
Route::post('/admin-client', [AdminCreateController::class, 'ShowCustomerDisplay'])->name('admin-client');

Route::get('/admin-display', [AdminCreateController::class, 'index']);
Route::post('/admin-display', [AdminCreateController::class, 'CreateAdminUser'])->name('admin-display');

Route::get('/admin-edit', [AdminCreateController::class, 'EditCustomer'])->name('edit-customer');
Route::post('/admin-edit', [AdminCreateController::class, 'ShowCustomerEdit'])->name('admin-edit');

Route::get('/admin-customer', [AdminCreateController::class, 'ShowCustomerCreate']);
Route::post('/admin-customer', [AdminCreateController::class, 'CreateCustomer'])->name('admin-customer');


Route::get('/admin-users', [AdminController::class, 'show']);
Route::get('/admin-tabs', [ClientCaptureController::class, 'ScreenUsersTabs'])->name('admin-tabs');
Route::post('/admin-tabs-personal', [CustomerVerification::class, 'PersonalDetailsUpdate'])->name('admin-tabs-personal');
Route::post('/admin-tabs-address', [CustomerVerification::class, 'AddressDetailsUpdate'])->name('admin-tabs-address');
Route::post('/admin-tabs-financial', [CustomerVerification::class, 'FinancialDetailsUpdate'])->name('admin-tabs-financial');
Route::post('/admin-tabs-screening', [CustomerVerification::class, 'ScreeningDetailsCreate'])->name('admin-tabs-screening');
Route::post('/admin-tabs-other', [tomerVerification::class, 'OtherDetailsCreate'])->name('admin-tabs-other');
Route::get('/admin-comments', [tomerVerification::class, 'UserComments'])->name('admin-comments');
Route::get('/admin-inbox', [CustomerVerification::class, 'UserInbox'])->name('admin-inbox');
Route::post('/admin-inbox', [CustomerVerification::class, 'SendMessage'])->name('admin-inbox-message');

//FAQ
Route::get('/FAQ', [App\Http\Controllers\FAQ::class, 'ShowPage'])->name('FAQ');
Route::get('/verify', [App\Http\Controllers\VerificationDataController::class, 'verifyClientData'])->name('verify');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('todos', TodoController::class);
});