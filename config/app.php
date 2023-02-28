<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'IFICA_AS2'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', true),

    /* set default role to user, that is 3 */


    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        // Aws\Laravel\AwsServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        // Org_Heigl\Ghostscript\Ghostscript::class,



        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [
        // 'AWS' => Aws\Laravel\AwsFacade::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        // 'Ghostscript' => Org_Heigl\Ghostscript\Ghostscript::class
    ],

    // Google api code call for register, login, forget and reset views
    'GOOGLE_API_SECRET' => env("GOOGLE_API_SECRET", "6LcWWaQhAAAAAID-WVERnHfeVgvy5A3LIvmle0bg"),
    'GOOGLE_API_ENDPOINT_URL' => env("GOOGLE_API_ENDPOINT_URL", "https://www.google.com/recaptcha/api/siteverify"),

    // OTP auth credentials for sending code via provider
    'API_OTP_KEY' => env("API_OTP_KEY", "c7fda9ca-7795-4be1-891f-7686ca2db620"),
    'API_OTP_SECRET' => env("API_OTP_SECRET", "7pCeMsdU5/1wvlsye6DA87llcahaWEXU"),
    'API_OTP_AUTH_ENDPOINT' => env("API_OTP_AUTH_ENDPOINT", "https://rest.mymobileapi.com/Authentication"),
    'API_OTP_SEND_URL' => env("API_OTP_SEND_URL", "https://rest.mymobileapi.com/bulkmessages"),

    // User Verification API and credentials
    'API_USERNAME' => env("API_USERNAME", "Insprt_uat"),
    'API_PASSWORD' => env("API_PASSWORD", "Id@s0522"),

    // Subject to change in the event of dynamic distribution of User Verification
    'API_ID_KYC' => env("API_ID_KYC", "FA52707C-2DE9-4050-8350-E19988D1B311"),
    'API_ID_AVS' => env("API_ID_AVS", "42365A78-E955-4015-B2E3-7321B444BEB1"),
    'API_ID_DOVS' => env("API_ID_DOVS", "F855922F-B9C0-4132-801D-1593728F85F0"),
    'API_ID_COMPLIANCE' => env("API_ID_COMPLIANCE", "0DF4E073-923C-4352-BB12-E1F24D0438FE"),

    // Some links are the same but are coded in case XDS changes per channel
    'API_SOAP_URL_LIVE_FACIAL' => env("API_SOAP_URL_LIVE_FACIAL", "https://www.web.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_DEMO_FACIAL' => env("API_SOAP_URL_DEMO_FACIAL", "https://www.web.xds.co.za/uatxdsconnect/?WSDL"),
    'API_SOAP_URL_LIVE_XDS_SELFIE_RESULT' => env("API_SOAP_URL_LIVE_XDS_SELFIE_RESULT", "https://www.web.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_DEMO_XDS_SELFIE_RESULT' => env("API_SOAP_URL_DEMO_XDS_SELFIE_RESULT", "https://www.uat.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_LIVE_VERIFY_KYC' => env("API_SOAP_URL_LIVE_VERIFY_KYC", "https://www.web.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_DEMO_VERIFY_KYC' => env("API_SOAP_URL_DEMO_VERIFY_KYC", "https://www.uat.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_LIVE_VERIFY_BANK' => env("API_SOAP_URL_LIVE_VERIFY_BANK", "https://www.web.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_DEMO_VERIFY_BANK' => env("API_SOAP_URL_DEMO_VERIFY_BANK", "https://www.uat.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_LIVE_VERIFY_COMPLIANCE' => env("API_SOAP_URL_LIVE_VERIFY_COMPLIANCE", "https://www.web.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),
    'API_SOAP_URL_DEMO_VERIFY_COMPLIANCE' => env("API_SOAP_URL_DEMO_VERIFY_COMPLIANCE", "https://www.uat.xds.co.za/xdsconnect/XDSConnectWS.asmx?wsdl"),

    // FicaProcess S3 bucket pathline
    'API_UPLOAD_PATH' => env("API_UPLOAD_PATH", "https://file-upload-fica.s3.amazonaws.com/"),

    //  AWS CONTROLLER CREDENTIALS
    'HOME_LOOKUP_TABLE_ID' => env('HOME_LOOKUP_TABLE_ID', '4AA3F8D1-0DF0-45C7-A772-869ECD88AB4D'), //HOME:16 
    'POSTAL_LOOKUP_TABLE_ID' => env('POSTAL_LOOKUP_TABLE_ID', '41B4799E-B1CC-44D1-B067-F963B17694EA'), //POSTAL:15
    'WORK_LOOKUP_TABLE_ID' => env('WORK_LOOKUP_TABLE_ID', 'C3E57D4F-3100-4973-A717-E17355321983'), //WORK:14

    'IDAS_ID' => env('IDAS_ID', '3B5FCCCA-106A-4545-BC02-88D1C15D8626'),

    // Old Key
    // 'TEXTRACT_CLIENT_KEY' => env("TEXTRACT_CLIENT_KEY", "AKIA4IKI2GCK2MKU65VF"),
    // 'TEXTRACT_CLIENT_SECRET' => env("TEXTRACT_CLIENT_SECRET", "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"),

    // New Key
    'TEXTRACT_CLIENT_KEY' => env("TEXTRACT_CLIENT_KEY", "AKIA4IKI2GCKS7SKN4PC"),
    'TEXTRACT_CLIENT_SECRET' => env("TEXTRACT_CLIENT_SECRET", "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"),
    'TEXTRACT_CLIENT_REGION' => env("TEXTRACT_CLIENT_REGION", "us-east-1"),


    // Role Id for Register Controller
    'CUSTOMER_USER_ROLE_ID' => env('CUSTOMER_USER_ROLE_ID', 3),

    //  Verfication Data Controller Credentials
    'VERIFICATION_USER_NAME' => env("VERIFICATION_USER_NAME", "idasAPI@inspirit.co.za"),
    'VERIFICATION_USER_PASSWORD' => env("VERIFICATION_USER_PASSWORD", "31GESS0QTB"),
    'VERIFICATION_USER_URL' => env("VERIFICATION_USER_URL", "https://www.inspiritdata.co.za:55715/token"),
    'VERIFICATION_USER_API_URL' => env("VERIFICATION_USER_API_URL", "https://www.inspiritdata.co.za:55715/api/APISearch?id="),
];
