<?php

use Illuminate\Support\Facades\Route;

use App\Models\Cms;
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

Auth::routes();
/**----------------------------Frontend routes ----------------------------------- */
Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index']);
Route::get('/registration', [App\Http\Controllers\Auth\RegisterController::class, 'getRegistration'])->name('registration');
Route::get('/registration/{type}', [App\Http\Controllers\Auth\RegisterController::class, 'getStepOne']);
Route::post('/registration/{type}', [App\Http\Controllers\Auth\RegisterController::class, 'saveStepOne'])->name('registration.step-one');

/*
    ** Saved address informations to update users data
*/
Route::get('/registration/{type}/step-1', [App\Http\Controllers\Auth\RegisterController::class, 'getAddressStep']);
Route::post('/registration/{type}/step-1', [App\Http\Controllers\Auth\RegisterController::class, 'saveAddressStep'])->name('registration.step-address');
//after completed basic step
/*------Physical informations*/
Route::get('/registration/athlete/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'getAthleteStepTwo']);
Route::post('/registration/athlete/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'saveAthleteStepTwo'])->name('registration.athlete.step-two');
/*------Sports informations*/
Route::get('/registration/athlete/step-3', [App\Http\Controllers\Auth\RegisterController::class, 'getAthleteStepThree']);
Route::post('/registration/athlete/step-3', [App\Http\Controllers\Auth\RegisterController::class, 'saveAthleteStepThree'])->name('registration.athlete.step-three');
/*------Sports positions informations*/
Route::get('/registration/athlete/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'getAthleteStepFour']);
Route::post('/registration/athlete/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'saveAthleteStepFour'])->name('registration.athlete.step-four');
/*------College informations*/
Route::get('/registration/athlete/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'getAthleteStepFive']);
Route::post('/registration/athlete/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'saveAthleteStepFive'])->name('registration.athlete.step-five');
/*------Subscription informations*/
Route::get('/registration/athlete/step-6', [App\Http\Controllers\Auth\RegisterController::class, 'getAthleteStepSix']);
//if user skip to taken membership
Route::get('/registration/athlete/redirect-dashboard', [App\Http\Controllers\Auth\RegisterController::class, 'redirectDashboard'])->name('registration.athlete.skip-membership');


//login
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

<<<<<<< .mine
//Coach
/*------Sports informations*/
Route::get('/registration/coach/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepThree']);
Route::post('/registration/coach/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepThree'])->name('registration.coach.step-three');
/*------Sports positions informations*/
Route::get('/registration/coach/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepFour']);
Route::post('/registration/coach/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepFour'])->name('registration.coach.step-four');
/*------College informations*/
Route::get('/registration/coach/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepFive']);
Route::post('/registration/coach/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepFive'])->name('registration.coach.step-five');
/*------Subscription informations*/
Route::get('/registration/coach/step-6', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepSix']);
//if user skip to taken membership
Route::get('/registration/coach/redirect-dashboard', [App\Http\Controllers\Auth\RegisterController::class, 'redirectCoachDashboard'])->name('registration.coach.skip-membership');
||||||| .r125
=======
//cms urls
Route::get('terms-of-use', function(){
    $cms_data = Cms::where('page_slug', 'terms-of-use')->first();
    return view('frontend.cms')
            ->with('cms_data', $cms_data)
            ->with('title', 'Terms of Use');
})->name('terms-of-use');
Route::get('privacy-policy', function(){
    $cms_data = Cms::where('page_slug', 'privacy-policy')->first();
    return view('frontend.cms')            
                ->with('cms_data', $cms_data)
                ->with('title', 'Privacy Policy');
})->name('privacy-policy');
//cms urls
Route::get('terms-and-conditions', function(){
    $cms_data = Cms::where('page_slug', 'terms-and-conditions')->first();
    return view('frontend.cms')
            ->with('cms_data', $cms_data)
            ->with('title', 'Terms and Conditions');
})->name('terms-and-conditions');
Route::get('code-of-conduct', function(){
    $cms_data = Cms::where('page_slug', 'code-of-conduct')->first();
    return view('frontend.cms')            
                ->with('cms_data', $cms_data)
                ->with('title', 'Code of Conduct');
})->name('code-of-conduct');
>>>>>>> .r135


/**
 * ------------------------------------ Protected routes for athlete---------------------------
*/
//Protected routes
Route::group(
    [
        'prefix' => 'athlete',
        'middleware'=> ['CheckAthleteAuth'],
    ],
    function(){
        Route::get('/dashboard', [App\Http\Controllers\frontend\Athlete\DashboardController::class, 'index'])->name('athlete.dashboard');
        Route::get('/logout', [App\Http\Controllers\frontend\Athlete\DashboardController::class, 'logout'])->name('athlete.logout');


        Route::resource('/workouts', App\Http\Controllers\frontend\Athlete\WorkoutsController::class);

    }
);


/**
 * ------------------------------------ Protected routes for coach ---------------------------
*/
//Protected routes
Route::group(
    [
        'prefix' => 'coach',
        'middleware'=> ['CheckCoachAuth'],
    ],
    function(){
        Route::get('/dashboard', [App\Http\Controllers\frontend\coach\DashboardController::class, 'index'])->name('coach.dashboard');
        Route::get('/logout', [App\Http\Controllers\frontend\coach\DashboardController::class, 'logout'])->name('coach.logout');

    }
);

Route::get('/forgot-password', [App\Http\Controllers\frontend\AuthController::class, 'forgotPassword']);

Route::post('/reset-password', [App\Http\Controllers\frontend\AuthController::class, 'resetPassword'])->name('Frontend.reset.password');
//Route::get('/password-reset/{email}', [App\Http\Controllers\frontend\AuthController::class, 'changePassword'])->name('Frontend.change.password');

Route::get('/password-reset/{email}', [App\Http\Controllers\frontend\AuthController::class, 'changePassword'])->name('Frontend.change.password');

Route::post('/password-update', [App\Http\Controllers\frontend\AuthController::class, 'updatePassword'])->name('Frontend.password.update');

/**------------------------------Admin routes----------------------------------- */
Route::get('/admin', [App\Http\Controllers\Admin\AuthControlle::class, 'index']);
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthControlle::class, 'login'])->name('admin.login');

//Protected routes
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['CheckAdminAuth']
    ],
    function()
        {
            // only accessable after login
            Route::get('/logout', [App\Http\Controllers\Admin\AuthControlle::class, 'logout'])->name('admin.logout');
            Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');

            Route::get('/add-settings', [App\Http\Controllers\Admin\SettingsController::class, 'create'])->name('admin.settings.create');

             Route::post('/save-field', [App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('admin.settings.store');

             Route::post('/update-settings/', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.edit');

            
            //banner
            Route::resource('/banners', \App\Http\Controllers\Admin\BannerController::class);
            Route::delete('/banners/{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy']);

            //blog
            Route::resource('/blogs', \App\Http\Controllers\Admin\BlogController::class);
            Route::delete('/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy']);            

            //Colleges
            Route::resource('/colleges', \App\Http\Controllers\Admin\CollegeController::class);
            Route::delete('/colleges/{id}', [App\Http\Controllers\Admin\CollegeController::class, 'destroy']);

            //Education
            Route::resource('/education', \App\Http\Controllers\Admin\EducationController::class);
            Route::delete('/education/{id}', [App\Http\Controllers\Admin\EducationController::class, 'destroy']);

             //Competition
             Route::resource('/competition', \App\Http\Controllers\Admin\CompetitionController::class);
            Route::delete('/competition/{id}', [App\Http\Controllers\Admin\CompetitionController::class, 'destroy']);

             //Collegiate Confernces
             Route::resource('/conference', \App\Http\Controllers\Admin\ConfranseController::class);

             Route::get('/add-conference', [App\Http\Controllers\Admin\ConfranseController::class, 'create'])->name('admin.conference.create');
             Route::post('/save-conference', [App\Http\Controllers\Admin\ConfranseController::class, 'store'])->name('admin.conference.save');

             Route::get('/edit-conference/{id}', [App\Http\Controllers\Admin\ConfranseController::class, 'edit'])->name('admin.conference.edit');

            Route::post('/update-conference/{id}', [App\Http\Controllers\Admin\ConfranseController::class, 'update'])->name('admin.conference.update');

              
            Route::get('/delete-confrence/{id}', [App\Http\Controllers\Admin\ConfranseController::class, 'destroy']);

              //Travel
            Route::resource('/travel', \App\Http\Controllers\Admin\TravelController::class);
            Route::delete('/travel/{id}', [App\Http\Controllers\Admin\TravelController::class, 'destroy']); 

            //School Playing    
             Route::resource('/schoolplaying', \App\Http\Controllers\Admin\SchoolPlayingController::class);
            Route::delete('/schoolplaying/{id}', [App\Http\Controllers\Admin\SchoolPlayingController::class, 'destroy']);

            //Workout Library
            Route::resource('/workoutlibrary', \App\Http\Controllers\Admin\WorkoutLibraryController::class);
            Route::delete('/workoutlibrary/{id}', [App\Http\Controllers\Admin\WorkoutLibraryController::class, 'destroy']);  

            //Workout Category
            Route::resource('/workoutcategory', \App\Http\Controllers\Admin\WorkoutCategoryController::class);
            Route::delete('/workoutcategory/{id}', [App\Http\Controllers\Admin\WorkoutCategoryController::class, 'destroy']);   

            //Sports
            Route::resource('/sports', \App\Http\Controllers\Admin\SportController::class);
            Route::delete('/sports/{id}', [App\Http\Controllers\Admin\SportController::class, 'destroy']);

            Route::get('/sports-position', [App\Http\Controllers\Admin\SportPositionController::class, 'index'])->name('admin.sports.position');

            Route::get('/add-position', [App\Http\Controllers\Admin\SportPositionController::class, 'create'])->name('admin.position.create');
            Route::post('/save-position', [App\Http\Controllers\Admin\SportPositionController::class, 'store'])->name('admin.position.save');

            Route::get('/edit-position/{id}', [App\Http\Controllers\Admin\SportPositionController::class, 'edit'])->name('admin.position.edit');
            Route::post('/update-position/{id}', [App\Http\Controllers\Admin\SportPositionController::class, 'update'])->name('sport.position.update');

            Route::get('/delete-position/{id}', [App\Http\Controllers\Admin\SportPositionController::class, 'destroy']);
            //Exercises
            Route::resource('/exercises', \App\Http\Controllers\Admin\ExercisesController::class);
            Route::delete('/exercises/{id}', [App\Http\Controllers\Admin\ExercisesController::class, 'destroy']);

            //Subscription

            Route::resource('/subscription', \App\Http\Controllers\Admin\SubscriptionController::class);
            Route::delete('/subscription/{id}', [App\Http\Controllers\Admin\SubscriptionController::class, 'destroy']);


            //CMS
            Route::resource('/cms', \App\Http\Controllers\Admin\CmsController::class);

            Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');
            Route::put('/profile/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('admin.profile.change-password');

            Route::post('/update-profile/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfileImage'])->name('admin.profile.update');

            Route::resource('/enquiry', \App\Http\Controllers\Admin\EnquiryController::class);
            Route::get('/delete-enquiry/{id}', [\App\Http\Controllers\Admin\EnquiryController::class, 'destroyEnquiry'])->name('enquiry.delete');
            Route::resource('/newsletter', \App\Http\Controllers\Admin\NewsletterController::class);
            Route::get('/delete-newsletter/{id}', [\App\Http\Controllers\Admin\NewsletterController::class, 'destroyNewsletter'])->name('newsletter.delete');
            
            Route::resource('/user', \App\Http\Controllers\Admin\UserController::class);
            Route::get('/delete-user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroyUser'])->name('user.delete');

            Route::post('/update-physical-info/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updatePhysicalInfo'])->name('update.physical.info');
            Route::post('/update-sport-info/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateSportInfo'])->name('update.sport.info');

            Route::get('/view-user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'viewUser'])->name('user.view');
        }
    );

