<?php
use Illuminate\Support\Facades\Route;
use App\Models\Cms;
use App\Http\Controllers\FirebaseController;

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

/**
 * if request user below 12 years then redirect to fill guardian info
*/
Route::get('/registration/{type}/step-guardian', [App\Http\Controllers\Auth\RegisterController::class, 'getGuardianInfoStep']);
Route::post('/registration/{type}/step-guardian', [App\Http\Controllers\Auth\RegisterController::class, 'saveGuardianInfoStep'])->name('athlete.step-guardian');

/*
    ** Saved address informations to update users data
*/
Route::get('/registration/{type}/step-1', [App\Http\Controllers\Auth\RegisterController::class, 'getAddressStep']);
Route::post('/registration/{type}/step-1', [App\Http\Controllers\Auth\RegisterController::class, 'saveAddressStep'])->name('registration.step-address');
//coach other informations

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

//Coach
Route::get('/registration/coach/other-information', [App\Http\Controllers\Auth\RegisterController::class, 'getOtherInformationStep']);
Route::post('/registration/coach/other-information', [App\Http\Controllers\Auth\RegisterController::class, 'saveOtherInformationStep'])->name('registration.coach.other-information');
//after completed basic step
/*------Sports informations*/

Route::get('/registration/coach/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepThree']);
Route::post('/registration/coach/step-2', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepThree'])->name('registration.coach.step-three');
/*------Sports positions informations*/
// Route::get('/registration/coach/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepFour']);
// Route::post('/registration/coach/step-4', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepFour'])->name('registration.coach.step-four');
/*------College informations*/
Route::get('/registration/coach/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepFive']);
Route::post('/registration/coach/step-5', [App\Http\Controllers\Auth\RegisterController::class, 'saveCoachStepFive'])->name('registration.coach.step-five');

//*------------get College--------
   
Route::post('/get-college', [App\Http\Controllers\Auth\RegisterController::class, 'getCollege'])->name('autocomplete.college');


/*------Subscription informations*/
Route::get('/registration/coach/step-6', [App\Http\Controllers\Auth\RegisterController::class, 'getCoachStepSix']);
//if user skip to taken membership
Route::get('/registration/coach/redirect-dashboard', [App\Http\Controllers\Auth\RegisterController::class, 'redirectCoachDashboard'])->name('registration.coach.skip-membership');

//login
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

//Contact details
Route::get('/contact-us', [App\Http\Controllers\frontend\ContactController::class, 'index'])->name('contact-us');
Route::post('/add-contact', [App\Http\Controllers\frontend\ContactController::class, 'save_contact'])->name('add-contact');

//Blogs details
Route::get('/blogs', [App\Http\Controllers\frontend\BlogController::class, 'index'])->name('blogs');
Route::get('/blogs-details/{id}', [App\Http\Controllers\frontend\BlogController::class, 'blog_details'])->name('blogs-details');
//features details
Route::get('/features', [App\Http\Controllers\frontend\FeatureController::class, 'index'])->name('features');
// Route::get('/features-details', [App\Http\Controllers\frontend\FeatureController::class, 'blog_details'])->name('features-details');
Route::get('/pricing', [App\Http\Controllers\frontend\PricingController::class, 'index'])->name('pricing');

//subscription mail
Route::post('/newsletter_subscription', [App\Http\Controllers\frontend\HomeController::class, 'newsletter_subscription'])->name('newsletter_subscription');



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
Route::get('aci-details', function(){
    $cms_data = Cms::where('page_slug', 'aci-details')->first();
    return view('frontend.cms')
                ->with('cms_data', $cms_data)
                ->with('title', 'ACI Index Details');
})->name('aci-details');
Route::get('about-us', function(){
    $cms_data = Cms::where('page_slug', 'about-us')->first();
    return view('frontend.about-us')
                ->with('cms_data', $cms_data)
                ->with('title', 'About Us');
})->name('about-us');

Route::get('/accept-invitation/{token}', [App\Http\Controllers\frontend\InvitationController::class, 'acceptInvitation'])->name('Frontend.accept.invitation');

/**
 * ------------------------------------ Protected routes for athlete---------------------------
*/
Route::get('/user-profile/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'index'])->name('user-profile');
//Protected routes
Route::group(
    [
        'prefix' => 'athlete',
        'middleware'=> ['CheckAthleteAuth'],
    ],
    function(){
        Route::get('/dashboard', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'index'])->name('athlete.dashboard');
        /** Get ACI index for athlete----- */
        Route::get('/aci-index-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciIndexCalculate']);
        
        Route::get('/logout', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'logout'])->name('athlete.logout');

        Route::get('/profile', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'index'])->name('athlete.profile');
        Route::get('/edit-profile', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'editProfile'])->name('athlete.edit-profile');
        Route::post('/update-profile/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateProfile'])->name('athlete.update-profile');

        Route::get('/change-password', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'changePassword'])->name('profile.change-password');

        Route::get('get-states',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getState']);
        Route::get('get-city',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getCities']);

        Route::post('/update-guardian/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateGuardian'])->name('athlete.update-guardian');        

        Route::post('/update-address/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateAddress'])->name('athlete.update-address');
        Route::post('/update-physical-info/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updatePhysicalInfo'])->name('athlete.update-physical-info');
        Route::get('get-sport-position',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getSportPosition']); 
        Route::post('/update-sports/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateSports'])->name('athlete.update-sports'); 
        Route::post('/update-password/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updatePassword'])->name('athlete.update-password');  

        Route::get('get-sportslist',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getSports']);     

        Route::resource('/workouts', App\Http\Controllers\frontend\Athlete\WorkoutsController::class);
        Route::get('/workouts/show/{cat}/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'show']);
        Route::get('/workouts/{id}/tips', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'getWorkoutTips']);
        Route::post('/workouts/exercise/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'storeWorkoutExecrise'])->name('athlete.workouts.exercise');
        
        Route::get('/compare', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'index'])->name('athlete.compare');
        Route::get('/new-athelete', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'AddAthlete'])->name('athlete.new-athelete');
        Route::post('/add-compare', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'addCompare'])->name('athlete.add-compare');
        Route::post('/delete-compare/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'deleteCompare'])->name('athlete.delete-compare');

        Route::get('/teamingup-group', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'teamingupGroup'])->name('athlete.teamingup-group');
        Route::get('/teamingup-group-details/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'teamingupGroupDetail'])->name('athlete.teamingup-group-details');
        Route::get('check-group',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'checkGroup']);

         Route::get('/game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'index'])->name('athlete.game-highlights');

          Route::post('/save-game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'storeGamehighlights'])->name('athlete.save-game-highlights');

         Route::get('/add-game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'addGame'])->name('athlete.add-game-highlights');

         //==

         Route::get('/edit-game-highlight/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'editGamehighlights'])->name('athlete.edit-game-highlight');
         Route::post('/update-game-highlight/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'updateGamehighlights'])->name('athlete.update-game-highlight');
         

         Route::get('/delete-game/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'deleteGamehighlights'])->name('athlete.delete-game');


        Route::get('/teamingup-group-details/{id}/invite-member', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'inviteMember'])->name('athlete.teamingup-group-details.add-mamber');

        //Route::get('/invite-member/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'inviteMember'])->name('athlete.invite-member');

        Route::get('invite',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'invite'])->name('athlete.invite');


        Route::get('connection-search',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'searchConnection']);
        Route::get('/create-teamingup-group', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingupGroup'])->name('athlete.create-teamingup-group');
        Route::post('/create-teamingup-group', [\App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingGroup'])->name('athlete.create.teaming_group');
       

        Route::get('/delete-member/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'deleteMember'])->name('athlete.delete-member');

        //Coach Recomendation
         Route::get('/coach-recomendation', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'index'])->name('athlete.coach-recomendation');

        Route::get('/new-recomendation', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'newRecomendation'])->name('athlete.new-recomendation');

        Route::get('search-user',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'searchUser']);

        Route::get('send-request',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendRequest']);

        /*Route::get('send-request',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendRequest']);*/

        Route::post('/send-registration-link', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendLink'])->name('athlete.send.registraion-link');

        
        Route::get('/post-recommendation/{id}', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'postRecommend'])->name('athlete.post-recommendation');

        Route::get('/dontpost-recommendation/{id}', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'nopostRecommend'])->name('athlete.dontpost-recommendation');

        Route::post('/contact-coach', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'contactCoach'])->name('athlete.contact-coach');

        

        //Connection

        Route::get('/connections', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'index'])->name('athlete.connections');
        Route::post('/connection/message', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'addConnectionMessage'])->name('athlete.add-connections-message');
        Route::post('/addfollowers', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'addFollowers'])->name('athlete.add-follow');
        
        //events section
        Route::get('/events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'index'])->name('athlete.events');
        Route::get('/add-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'addEvents'])->name('athlete.add-events');
        Route::get('/edit-events/{id}', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'addEvents'])->name('athlete.edit-events');
        Route::post('/save-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'saveEvents'])->name('athlete.save-events');
        Route::post('/delete-events/{id}', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'deleteEvents'])->name('athlete.delete-events');
        Route::post('/details-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'detailsEvents'])->name('athlete.details-events');

         //video evidence section
        Route::get('/video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'index'])->name('athlete.video-evidence');
        Route::get('/add-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'addVideoEvidence'])->name('athlete.add-video-evidence');
        Route::get('/edit-video-evidence/{id}', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'addVideoEvidence'])->name('athlete.edit-video-evidence');
        Route::post('/save-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'saveVideoEvidence'])->name('athlete.save-video-evidence');
        Route::post('/delete-video-evidence/{id}', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'deleteVideoEvidence'])->name('athlete.delete-video-evidence');
        Route::post('/like-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'likeVideoEvidence'])->name('athlete.like-video-evidence');

        //chat

        Route::get('/chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'index'])->name('athlete.chat');
        Route::post('/get-chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'getchat'])->name('athlete.get-connections-message'); 
        Route::post('/add-chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'savechat'])->name('athlete.save-connections-message');

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

        Route::get('/change-password', [App\Http\Controllers\frontend\coach\SettingController::class, 'changePassword'])->name('coach.profile.change-password');

        Route::post('/update-password/{id}', [App\Http\Controllers\frontend\coach\SettingController::class, 'updatePassword'])->name('coach.update-password');

        Route::get('/profile', [App\Http\Controllers\frontend\coach\ProfileController::class, 'index'])->name('coach.profile');

        Route::get('/edit-profile', [App\Http\Controllers\frontend\coach\ProfileController::class, 'editProfile'])->name('coach.edit-profile');

        Route::post('/update-profile/{id}', [App\Http\Controllers\frontend\coach\ProfileController::class, 'updateProfile'])->name('coach.update-profile');

        Route::post('/update-address/{id}', [App\Http\Controllers\frontend\coach\ProfileController::class, 'updateAddress'])->name('coach.update-address');

        Route::get('coach-states',[App\Http\Controllers\frontend\coach\ProfileController::class, 'getState']);
        Route::get('coach-city',[App\Http\Controllers\frontend\coach\ProfileController::class, 'getCities']);
        Route::post('/update-other-info/{id}', [App\Http\Controllers\frontend\coach\ProfileController::class, 'updateOtherInfo'])->name('coach.update-other-info');

        Route::get('get-sportlist',[App\Http\Controllers\frontend\coach\ProfileController::class, 'getSports']);
        Route::post('/update-sport/{id}', [\App\Http\Controllers\frontend\coach\ProfileController::class, 'updateSportInfo'])->name('update.coach.sport');

        Route::get('get-collegelist',[App\Http\Controllers\frontend\coach\ProfileController::class, 'getCollege']);

         Route::post('/update-college/{id}', [\App\Http\Controllers\frontend\coach\ProfileController::class, 'updateCollegeInfo'])->name('update.coach.college');
        //Teamingup Group
        Route::get('/teamingup-group', [App\Http\Controllers\frontend\coach\TeamingController::class, 'teamingupGroup'])->name('coach.teamingup-group');
        Route::get('/teamingup-group-details/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'teamingupGroupDetail'])->name('coach.teamingup-group-details');
        Route::get('/create-teamingup-group', [App\Http\Controllers\frontend\coach\TeamingController::class, 'createTeamingupGroup'])->name('coach.create-teamingup-group');

        Route::post('/create-teamingup-group', [\App\Http\Controllers\frontend\coach\TeamingController::class, 'createTeamingGroup'])->name('coach.create.teaming_group');

         Route::get('/delete-member/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'deleteMember'])->name('coach.delete-member');

        /*Route::get('/accept-invitation/{token}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'acceptInvitation'])->name('Frontend.accept.invitation');*/

        Route::get('search-connection',[App\Http\Controllers\frontend\coach\TeamingController::class, 'searchConnection']);

         Route::get('check-group',[App\Http\Controllers\frontend\coach\TeamingController::class, 'checkGroup']);

         Route::get('/invite-member/{id}/invite-member', [App\Http\Controllers\frontend\coach\TeamingController::class, 'inviteMember'])->name('coach.invite-member');

         Route::get('member-invite',[App\Http\Controllers\frontend\coach\TeamingController::class, 'invite'])->name('coach.invite');

         //Recommendation
         Route::get('/write-recomendation/{id}', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'writeRecommendation'])->name('coach.write-recomendation');

         Route::post('/send-recomendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'sendRecommendation'])->name('coach.send-recomendation');

        //Lookup
        Route::get('/reverse-lookups', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'index'])->name('coach.lookup');

        //Recommendation
        Route::get('/recommendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'index'])->name('coach.recommendation');

        Route::get('/write-recommendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'writeRecommendation'])->name('coach.write-recommendation');
        //Events
        Route::get('/events', [App\Http\Controllers\frontend\coach\EventsController::class, 'index'])->name('coach.events');
        Route::get('/add-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'addEvents'])->name('coach.add-events');
        Route::get('/edit-events/{id}', [App\Http\Controllers\frontend\coach\EventsController::class, 'addEvents'])->name('coach.edit-events');
        Route::post('/save-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'saveEvents'])->name('coach.save-events');
        Route::post('/delete-events/{id}', [App\Http\Controllers\frontend\coach\EventsController::class, 'deleteEvents'])->name('coach.delete-events');
        Route::post('/details-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'detailsEvents'])->name('coach.details-events');




    }
);

Route::get('/forgot-password', [App\Http\Controllers\frontend\AuthController::class, 'forgotPassword']);
//validate forgot password OTP & reset Password
Route::get('/reset-password', [App\Http\Controllers\frontend\AuthController::class, 'getResetPassword']);
Route::post('/reset-password', [App\Http\Controllers\frontend\AuthController::class, 'resetPassword'])->name('frontend.reset.password');

Route::get('check-email',[App\Http\Controllers\frontend\AuthController::class, 'checkEmail']);

Route::get('/password-reset/{email}', [App\Http\Controllers\frontend\AuthController::class, 'changePassword'])->name('Frontend.change.password');

Route::post('/password-update', [App\Http\Controllers\frontend\AuthController::class, 'updatePassword'])->name('frontend.password.update');

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
            //stories
            Route::resource('/stories', \App\Http\Controllers\Admin\StoriesController::class);
            Route::delete('/stories/{id}', [App\Http\Controllers\Admin\StoriesController::class, 'destroy']);
            //services
            Route::resource('/services', \App\Http\Controllers\Admin\ServicesController::class);
            Route::delete('/services/{id}', [App\Http\Controllers\Admin\ServicesController::class, 'destroy']);
            //testimonial content
            Route::resource('/testimonial', \App\Http\Controllers\Admin\TestimonialContentController::class);
            Route::delete('/testimonial/{id}', [App\Http\Controllers\Admin\TestimonialContentController::class, 'destroy']);
             //testimonial ReviewList
            Route::resource('/testimonial-review', \App\Http\Controllers\Admin\TestimonialReviewController::class);
            Route::delete('/testimonial-review/{id}', [App\Http\Controllers\Admin\TestimonialReviewController::class, 'destroy']);
             //fitness ReviewList
            Route::resource('/fitness', \App\Http\Controllers\Admin\FitnessController::class);
            Route::delete('/fitness/{id}', [App\Http\Controllers\Admin\FitnessController::class, 'destroy']);


            //blog
            Route::resource('/blogs', \App\Http\Controllers\Admin\BlogController::class);
            Route::delete('/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy']);

            //Cities
            Route::resource('/cities', \App\Http\Controllers\Admin\CityController::class);
            //Colleges
            Route::resource('/colleges', \App\Http\Controllers\Admin\CollegeController::class);
            Route::delete('/colleges/{id}', [App\Http\Controllers\Admin\CollegeController::class, 'destroy']);
            Route::get('get-confrence',[App\Http\Controllers\Admin\CollegeController::class, 'getConfrence']);



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

            //Workout Mesurement            
            Route::resource('/libraryMesurement', \App\Http\Controllers\Admin\LibraryMesurementController::class);
            //Route::delete('/workoutlibrary/{id}', [App\Http\Controllers\Admin\WorkoutLibraryController::class, 'destroy']); 

            //Workout Library
            Route::resource('/workoutlibrary', \App\Http\Controllers\Admin\WorkoutLibraryController::class);
            Route::delete('/workoutlibrary/{id}', [App\Http\Controllers\Admin\WorkoutLibraryController::class, 'destroy']);  

            //Workout Category
            Route::resource('/workoutcategory', \App\Http\Controllers\Admin\WorkoutCategoryController::class);
            Route::delete('/workoutcategory/{id}', [App\Http\Controllers\Admin\WorkoutCategoryController::class, 'destroy']);  

            //Group Management
            Route::resource('/group', \App\Http\Controllers\Admin\GroupController::class); 

            Route::get('/group-detail/{id}', [App\Http\Controllers\Admin\GroupController::class, 'detail'])->name('admin.group.detail');

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
            //   //features
            Route::resource('/features', \App\Http\Controllers\Admin\FeaturesController::class);
            Route::delete('/features/{id}', [App\Http\Controllers\Admin\FeaturesController::class, 'destroy']); 

            //Coach user
            Route::resource('/coach', \App\Http\Controllers\Admin\CoachUserController::class);

            Route::post('/update-address/{id}', [\App\Http\Controllers\Admin\CoachUserController::class, 'updateAddressInfo'])->name('update.coach.address.info');

              Route::post('/update-other-info/{id}', [\App\Http\Controllers\Admin\CoachUserController::class, 'updateOtherInfo'])->name('update.coach.other.info');

              Route::post('/update-coach-sport-info/{id}', [\App\Http\Controllers\Admin\CoachUserController::class, 'updateSportInfo'])->name('update.coach.sport.info');

             Route::get('get-college',[App\Http\Controllers\Admin\CoachUserController::class, 'getCollege']);

             Route::post('/update-coach-college-info/{id}', [\App\Http\Controllers\Admin\CoachUserController::class, 'updateCollegeInfo'])->name('update.coach.college.info');
            
            Route::get('get-states-by-country',[App\Http\Controllers\Admin\UserController::class, 'getState']);
            Route::get('get-cities-by-state',[App\Http\Controllers\Admin\UserController::class, 'getCities']);

            Route::get('get-sports',[App\Http\Controllers\Admin\UserController::class, 'getSports']);

            Route::post('/update-address-info/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateAddressInfo'])->name('update.address.info');
           
            Route::post('/update-guardian-info/{id}', [App\Http\Controllers\Admin\UserController::class, 'saveGuardianInfoStep'])->name('update.guardian.info');

            Route::post('/update-physical-info/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updatePhysicalInfo'])->name('update.physical.info');
            Route::post('/update-sport-info/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateSportInfo'])->name('update.sport.info');
            Route::get('get-position-by-sport',[App\Http\Controllers\Admin\UserController::class, 'getSportPosition']);

            Route::get('/view-user/{id}', [\App\Http\Controllers\Admin\UserController::class, 'viewUser'])->name('user.view');		
			
			
        }
);



////Firebase Routes


Route::get('/test',[FirebaseController::class, 'index']);
Route::get('/test/getData',[FirebaseController::class, 'getData']);


///Chat 

Route::get('/coach/chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'index'])->name('coach.chat');
