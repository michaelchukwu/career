<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\WalletController;
use App\Models\Job;
use App\Models\Account;
use App\Models\Applicant;
use App\Models\Application as Apply;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;

// Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $enableViews = config('fortify.views', true);

    // Authentication...
    if ($enableViews) {
        Route::get('/soup-kitchen', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/soup-kitchen', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]));

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware(['guest:'.config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware(['auth:'.config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['auth:'.config('fortify.guard'), 'signed', 'throttle:'.$verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['auth:'.config('fortify.guard'), 'throttle:'.$verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    if ($enableViews) {
        Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->middleware(['auth:'.config('fortify.guard')])
            ->name('password.confirm');
    }

    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware(['auth:'.config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware(['auth:'.config('fortify.guard')]);

    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        if ($enableViews) {
            Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:'.config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
            ]));

        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? ['auth:'.config('fortify.guard'), 'password.confirm']
            : ['auth:'.config('fortify.guard')];

        Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.enable');

        Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.disable');

        Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.qr-code');

        Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
            ->middleware($twoFactorMiddleware)
            ->name('two-factor.recovery-codes');

        Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
            ->middleware($twoFactorMiddleware);
    }
// });


Route::get('/', function (HttpRequest $request) {
    $jobs = Job::when($request->term, function ($query, $term){
        $query->where('title', 'LIKE', '%'.$term.'%');
    })->where('is_live', true)->paginate(100);
    if($request->wantsJson()){
        return $jobs;
    }
    return Inertia::render('Welcome', [
        'jobs' => $jobs
    ]);
})->name('home');
Route::get('/position/{jobi}', function ($jobi) {
    $job = Job::find($jobi);
    $job->type = DB::table('job_types')->where('id', $job->job_type_id)->first();
    return Inertia::render('Show', [
        'job' => $job
    ]);
})->name('job');
Route::post('/apply', function (HttpRequest $request) {
    //upload all possible files
    $image_path = '';
    $cv_path = '';
    $cover_letter_path = '';

    if ($request->hasFile('image')) {
        $guessExtension = $request->file('image')->guessExtension();
        $image_path = $request->file('image')->storeAs('image', $request->first_name.'_'.now().'_'.'image'.$guessExtension, 'public');
    }
    if ($request->hasFile('cv')) {
        $guessExtension = $request->file('cv')->guessExtension();
        $cv_path = $request->file('cv')->storeAs('cv', $request->first_name.'_'.now().'_'.'cv'.$guessExtension, 'public');
    }
    if ($request->hasFile('cover_letter')) {
        $guessExtension = $request->file('cover_letter')->guessExtension();
        $cover_letter_path = $request->file('cover_letter')->storeAs('cover_letter', $request->first_name.'_'.now().'_'.'cover_letter'.$guessExtension, 'public');
        // $cover_letter_path = $request->file('cover_letter')->store('cover_letter', 'public');
    }
    $request->image=$image_path;
    $request->cv=$cv_path;
    $request->cover_letter=$cover_letter_path;
    //create the applicant
    $applicant = new Applicant();
    $applicant->email = $request->email;
    $applicant->phone = $request->phone;
    $applicant->first_name = $request->first_name;
    $applicant->last_name = $request->last_name;
    $applicant->linkedin = $request->linkedin;
    $applicant->twitter = $request->twitter;
    $applicant->facebook = $request->facebook;
    $applicant->website = $request->website;
    $applicant->cv = $request->cv;
    $applicant->cover_letter = $request->cover_letter;
    $applicant->image = $request->image;
    $applicant->state = $request->state;
    $applicant->city = $request->city;
    $applicant->street = $request->street;
    $applicant->age = $request->age;
    $applicant->dob = $request->dob;
    $applicant->gender = $request->gender;
    $applicant->exp_post = $request->exp_post;
    $applicant->experience = $request->experience;
    $applicant->first_degree = $request->first_degree;
    $applicant->first_course = $request->first_course;
    $applicant->second_degree = $request->second_degree;
    $applicant->second_course = $request->second_course;
    $applicant->third_degree = $request->third_degree;
    $applicant->third_course = $request->third_course;
    $applicant->professional = $request->professional;
    $applicant->created_at = now();
    $applicant->save();
    //get the
    DB::table('applications')->insert(['job_id'=>$request->job, 'applicant_id'=>$applicant->id, 'status'=>'applied', 'created_at'=>now()]);
    //create an application
    return back();
})->name('apply');
Route::middleware(['auth:sanctum', 'verified'])->get('backup', [BackupController::class, 'index'])->name('backup.index');
Route::middleware(['auth:sanctum', 'verified'])->get('backup/dl/{folder}/{file}', [BackupController::class, 'dl']);
Route::middleware(['auth:sanctum', 'verified'])->get('backup/rm/{folder}/{file}', [BackupController::class, 'rm']);
Route::middleware(['auth:sanctum', 'verified'])->get('backup/create', function(){
    Artisan::call('database:backup');
    return back();
})->name('backup.now');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $jobs = DB::table('jobs')
        ->join('job_types', 'jobs.job_type_id', '=', 'job_types.id')
        ->orderBy('jobs.id','DESC')
        ->select(
            'jobs.id as jobs_id',
            'job_types.id as job_types_id',
            'jobs.title as jobs_title',
            'job_types.title as job_types_title',
            'jobs.created_at')
        ->paginate(5);
        return Inertia::render('Job/Index',['jobs'=>$jobs]);
})->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    // Route::resource('roles', RoleController::class);
    // Route::resource('users', UserController::class);
    // Route::resource('products', ProductController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('applications', ApplicationController::class);
    Route::get('export', [ApplicationController::class, 'export'])->name('export');
    Route::get('jobs/publish/{job}', [JobController::class, 'publish']);
    Route::get('jobs/unpublish/{job}', [JobController::class, 'unPublish']);
    Route::resource('job-types', JobTypeController::class);
});
