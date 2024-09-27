<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Throwable;
use App\Models\CustomerUser;
use App\Models\Consumer;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Exception $e) {

            $url = '/';
            if(Auth::user()){
            $getRoleName = CustomerUser::getCustomerUserRoleName();
                if($getRoleName == 'SuperAdmin')
                {
                    $url = '/admin-display';
                }elseif ($getRoleName == 'CustomerAdmin') {
                    $url = '/sb-dashboard'; //$url = '/admin-dashboard';
                } else {
                    $consumer = Consumer::where('Email', '=', Auth::user()->Email)->where('CustomerUSERID', '=', Auth::user()->Id)->first();
                    $url = ($consumer != null) ? '/fica' : '/startfica';
                }
            }

            if ($e->getPrevious() instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect('/');
            }
            if ($e instanceof UnauthorizedException) {
                if($e->getStatusCode() == 401){
                    $url = '/';
                    return response()->view('errors.401', ['message'=>$e->getMessage(),'url'=>$url], 401);
                }else if($e->getStatusCode() == 403){
                    return response()->view('errors.403', ['message'=>$e->getMessage(),'url'=>$url], 403);
                }
            }
            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', ['message'=>$e->getMessage(),'url'=>$url], 404);
            }
        });
    }
}
