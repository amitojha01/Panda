<?php
use Illuminate\Support\Facades\Route;
use App\Models\Cms;
use App\Models\Team;
use App\Models\Advisory;
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

 //===twilio Otp====
    Route::get('sendSMS',[App\Http\Controllers\Auth\TwilioSMSController::class, 'sendSms']);

//====================
    Route::get('verify-mobile-otp',[App\Http\Controllers\Auth\TwilioSMSController::class, 'verifyMobileOtp']);

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
Route::match(['GET','POST'],'/registration/athlete/subcription-redirect', [App\Http\Controllers\Auth\RegisterController::class, 'subcriptionedirect']);

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

    $teams = Team::where('status', 1)->get();
    $advisory = Advisory::where('status', 1)->get();
    return view('frontend.about-us')
                ->with('cms_data', $cms_data)
                ->with('teams', $teams)
                ->with('advisory', $advisory)
                ->with('title', 'About Us');
})->name('about-us');

Route::get('/accept-invitation/{token}', [App\Http\Controllers\frontend\InvitationController::class, 'acceptInvitation'])->name('Frontend.accept.invitation');



/**
 * ------------------------------------ Protected routes for athlete---------------------------
*/
Route::get('/user-profile/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'index'])->name('user-profile');

Route::get('/athlete-profile/{id}/{type}', [App\Http\Controllers\frontend\UserProfileController::class, 'athleteProfile'])->name('athlete-profile');

Route::get('/coach-profile/{id}/{type}', [App\Http\Controllers\frontend\UserProfileController::class, 'coachProfile'])->name('coach-profile');

Route::get('/userprofile/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'userprofile'])->name('userprofile');

Route::get('/athleteprofile/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'userprofile'])->name('userprofile');




Route::get('/follower/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'follower'])->name('user.followers');

Route::get('/following/{id}', [App\Http\Controllers\frontend\UserProfileController::class, 'following'])->name('user.following');
//Protected routes
        
// Route::get('/aci-index-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciindexcalculate']);
// Route::get('/aci-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciindexcalculate_value']);
Route::get('/aci-calculate-index', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciRankCal']);
Route::post('/filter-athlete-compare', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'filterAthleteCompare']);
//Workout's library
Route::get('/get-workouts/library', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'getWorkoutLibrary_user']);

Route::match(['GET','POST'],'athlete/add-group-teamingup', [\App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingGroupAdd']);


Route::post('/create-teamingup-group', [\App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingGroup'])->name('athlete.create.teaming_group');

Route::get('/upload-file', [\App\Http\Controllers\frontend\Athlete\FileUpload::class, 'index']);
Route::post('/upload-file-save', [\App\Http\Controllers\frontend\Athlete\FileUpload::class, 'submit_details'])->name('file.save');

Route::match(['GET','POST'],'athlete/payment', [\App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'payment']);
     

Route::group(
    [
        'prefix' => 'athlete',
        'middleware'=> ['CheckAthleteAuth'],
    ],
    function(){
        Route::get('/dashboard', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'index'])->name('athlete.dashboard');
        
        
        // Route::get('/aci-index-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciindexcalculate_value']);
        /** Get ACI index for athlete----- */
        // Route::get('/aci-index-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciIndexCalculate']);
        
        Route::get('/aci-rank-calculate', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'aciRankCalculate']);
        
        

        Route::get('/logout', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'logout'])->name('athlete.logout');

         /*Route::get('get-description',[App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'getDescription']);*/

         Route::post('/get-description', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'getDescription'])->name('athlete.get-description');


        Route::get('/profile', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'index'])->name('athlete.profile');
        Route::get('/edit-profile', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'editProfile'])->name('athlete.edit-profile');
        Route::post('/update-profile/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateProfile'])->name('athlete.update-profile');

    
        Route::get('/follower', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'follower'])->name('athlete.followers');

        Route::get('/following', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'following'])->name('athlete.following');

        Route::get('/coach-request', [App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'coachRequest'])->name('athlete.coach-request');
        Route::post('/request-response',[App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'requestResponse'])->name('athlete.request-response');

        Route::post('/update-bio',[App\Http\Controllers\frontend\Athlete\AthleteDashboardController::class, 'updateBio'])->name('athlete.bio.update');

        

        //unfollow
        Route::post('/unfollow', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'unfollow'])->name('athlete.unfollow');

        Route::post('/remove', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'remove'])->name('athlete.remove');

        Route::post('/follow_unfollow', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'follow_unfollow'])->name('athlete.follow_unfollow');

    

        Route::get('/change-password', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'changePassword'])->name('profile.change-password');

       
        Route::get('/change-read-status', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'changeReadStatus'])->name('athlete.change-read-status');

        Route::get('get-states',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getState']);
        Route::get('get-city',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getCities']);

        Route::post('/update-guardian/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateGuardian'])->name('athlete.update-guardian');        

        Route::post('/update-address/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateAddress'])->name('athlete.update-address');
        Route::post('/update-physical-info/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updatePhysicalInfo'])->name('athlete.update-physical-info');
        Route::get('get-sport-position',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getSportPosition']); 
        Route::post('/update-sports/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateSports'])->name('athlete.update-sports'); 
        Route::post('/update-password/{id}', [App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updatePassword'])->name('athlete.update-password');  

        Route::get('get-sportslist',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getSports']);  

        Route::get('get-collegelist',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getCollege']);

       


        Route::post('/update-college/{id}', [\App\Http\Controllers\frontend\Athlete\ProfileController::class, 'updateCollegeInfo'])->name('update.athlete.college');   

        Route::resource('/workouts', App\Http\Controllers\frontend\Athlete\WorkoutsController::class);
        Route::get('/workouts/show/{cat}/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'show']);
        Route::get('/workouts/{id}/tips', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'getWorkoutTips']);
        Route::post('/workouts/exercise/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'storeWorkoutExecrise'])->name('athlete.workouts.exercise');
       
        Route::get('/workouts/add-video/{cat}/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'addVideo']);

        Route::get('/delete-video/{id}', [App\Http\Controllers\frontend\Athlete\WorkoutsController::class, 'deleteVideo'])->name('athlete.delete-video');


        
        
        Route::match(['GET','POST'],'/compare', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'index'])->name('athlete.compare');
         
        Route::get('/new-athelete/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'AddAthlete'])->name('athlete.new-athelete');
        Route::post('/add-compare', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'addCompare'])->name('athlete.add-compare');
        Route::post('/delete-compare/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'deleteCompare'])->name('athlete.delete-compare');
        Route::post('/delete-compare-user/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'deleteCompareUser'])->name('athlete.delete-compare-user');
        Route::get('/compare-group', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'compareGroup'])->name('athlete.compare-group');
        Route::post('/compare-group/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'compareGroup'])->name('athlete.compare-group-id');
        Route::post('/create-comparison', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'createComparison'])->name('athlete.create-comparison');
        Route::post('/create-comparison-bygroup', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'createComparisonFromGroup'])->name('athlete.create-comparison-bygroup');
        Route::post('/update-comparison/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'updateComparison'])->name('athlete.update-comparison');
        Route::get('/comparison-details/{id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'comparisonDetails'])->name('athlete.comparison-details');
        Route::get('/comparison-details/{id}/{wrk_id}', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'comparisonDetails'])->name('athlete.comparison-details');

        Route::get('/teamingup-group', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'teamingupGroup'])->name('athlete.teamingup-group');
        Route::get('/teamingup-group-details/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'teamingupGroupDetail'])->name('athlete.teamingup-group-details');
        Route::post('/add-group-library/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'addGroupLibrary']);
        
        
        
        Route::get('check-group',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'checkGroup']);

        
        Route::post('/comparison-group-add', [App\Http\Controllers\frontend\Athlete\CompareController::class, 'comparisonGroupAdd'])->name('athlete.create-comparison-bygroup');
        

         Route::get('/game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'index'])->name('athlete.game-highlights');

          Route::post('/save-game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'storeGamehighlights'])->name('athlete.save-game-highlights');

         Route::get('/add-game-highlights', [App\Http\Controllers\frontend\Athlete\GameController::class, 'addGame'])->name('athlete.add-game-highlights');         

         Route::get('/edit-game-highlight/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'editGamehighlights'])->name('athlete.edit-game-highlight');
         Route::post('/update-game-highlight/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'updateGamehighlights'])->name('athlete.update-game-highlight');
         

         Route::get('/delete-game/{id}', [App\Http\Controllers\frontend\Athlete\GameController::class, 'deleteGamehighlights'])->name('athlete.delete-game');

          Route::get('/email-coach', [App\Http\Controllers\frontend\Athlete\EmailController::class, 'index'])->name('athlete.email-coach');

          Route::post('searchcoach',[App\Http\Controllers\frontend\Athlete\EmailController::class, 'searchCoach'])->name('athlete.searchcoach');
          
           /*Route::post('emailcoach',[App\Http\Controllers\frontend\Athlete\EmailController::class, 'emailcoach'])->name('athlete.emailcoach');*/


           Route::match(['GET','POST'],'/emailcoach', [App\Http\Controllers\frontend\Athlete\EmailController::class, 'emailcoach'])->name('athlete.emailcoach');

           Route::get('/sent-list', [App\Http\Controllers\frontend\Athlete\EmailController::class, 'sentList'])->name('athlete.sent-list');

           Route::post('sendMail',[App\Http\Controllers\frontend\Athlete\EmailController::class, 'sendMail'])->name('athlete.sendMail');

           

         


        Route::get('/teamingup-group-details/{id}/invite-member', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'inviteMember'])->name('athlete.teamingup-group-details.add-mamber');

        //Route::get('/invite-member/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'inviteMember'])->name('athlete.invite-member');

        Route::get('invite',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'invite'])->name('athlete.invite');

        Route::post('invite-selected-member',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'inviteSelectedMember'])->name('athlete.invite_selected_member');
        
          Route::post('remove-selected-member',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'removeSelectedMember'])->name('athlete.remove_selected_member');


        Route::get('connection-search',[App\Http\Controllers\frontend\Athlete\TeamingController::class, 'searchConnection']);
        Route::get('/create-teamingup-group', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingupGroup'])->name('athlete.create-teamingup-group');
        // Route::post('/create-teamingup-group', [\App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createTeamingGroup'])->name('athlete.create.teaming_group');

         Route::get('/edit-teamingup-group/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'editTeamingupGroup'])->name('athlete.edit-teamingup-group');

         Route::post('/update-teamingup-group/{id}', [\App\Http\Controllers\frontend\Athlete\TeamingController::class, 'updateTeamingGroup'])->name('athlete.update.teaming_group');

         Route::get('/delete-group/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'deleteGroup'])->name('athlete.delete-group');

         Route::get('/exit-group/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'exitGroup'])->name('athlete.exit-group');
      

         Route::post('/create-group-admin', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'createGroupAdmin'])->name('athlete.create-group-admin');
         
       

        Route::get('/delete-member/{id}', [App\Http\Controllers\frontend\Athlete\TeamingController::class, 'deleteMember'])->name('athlete.delete-member');

        //Coach Recomendation
         Route::get('/coach-recomendation', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'index'])->name('athlete.coach-recomendation');

        Route::get('/new-recomendation', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'newRecomendation'])->name('athlete.new-recomendation');

        Route::post('/accept-recommendation', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'acceptRecomendation'])->name('athlete.accept-recommendation');

        Route::get('/reject-recommendation/{id}', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'rejectRecommend'])->name('athlete.reject-recommendation');

       

        Route::get('get-recommendation',[App\Http\Controllers\frontend\Athlete\ProfileController::class, 'getRecommendation']); 

        Route::get('/report', [App\Http\Controllers\frontend\Athlete\ReportController::class, 'index'])->name('athlete.report');  

        //Route::post('/save-report', [App\Http\Controllers\frontend\Athlete\ReportController::class, 'saveReport'])->name('athlete.save-report');

         Route::post('/save-report', [App\Http\Controllers\frontend\Athlete\ReportController::class, 'saveReport'])->name('athlete.save-report');

       

        /*Route::get('search-user',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'searchUser']);
        */
        Route::get('search-by-userid',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'searchByUserId']);

        Route::get('search-by-email',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'searchByEmail']);

        //Route::get('send-request',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendRequest']);

         Route::post('send-request',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendRequest'])->name('send-request');

        /*Route::get('send-request',[App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendRequest']);*/

        Route::post('/send-registration-link', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendLink'])->name('athlete.send.registraion-link');

        Route::post('/send-profile-link', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'sendProfileLink'])->name('athlete.send.profile-link');

        
        Route::get('/post-recommendation/{id}', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'postRecommend'])->name('athlete.post-recommendation');

        Route::get('/dontpost-recommendation/{id}', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'nopostRecommend'])->name('athlete.dontpost-recommendation');

        Route::post('/contact-coach', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'contactCoach'])->name('athlete.contact-coach');

         Route::post('/save-order', [App\Http\Controllers\frontend\Athlete\RecomendationController::class, 'saveOrder'])->name('athlete.save-order');

        
        

        //Connection

        Route::match(['GET','POST'], '/connections', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'index'])->name('athlete.connections');
        
        Route::post('/connection/message', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'addConnectionMessage'])->name('athlete.add-connections-message');
        Route::post('/addfollowers', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'addFollowers'])->name('athlete.add-follow');

        Route::post('search-coach', [App\Http\Controllers\frontend\Athlete\ConnectionController::class, 'searchCoach'])->name('athlete.search-coach');


        
        //events section
        Route::match(['GET','POST'],'/events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'index'])->name('athlete.events');
        Route::get('/add-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'addEvents'])->name('athlete.add-events');
        Route::get('/edit-events/{id}', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'addEvents'])->name('athlete.edit-events');
        Route::post('/save-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'saveEvents'])->name('athlete.save-events');
        Route::post('/delete-events/{id}', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'deleteEvents'])->name('athlete.delete-events');
        Route::post('/details-events', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'detailsEvents'])->name('athlete.details-events');

        Route::get('/evnt/{id}', [App\Http\Controllers\frontend\Athlete\EventsController::class, 'addEvents'])->name('athlete.edit-events');

         //video evidence section
        Route::get('/video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'index'])->name('athlete.video-evidence');
        Route::get('/add-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'addVideoEvidence'])->name('athlete.add-video-evidence');
        Route::get('/edit-video-evidence/{id}', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'addVideoEvidence'])->name('athlete.edit-video-evidence');
        Route::post('/save-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'saveVideoEvidence'])->name('athlete.save-video-evidence');
        Route::post('/delete-video-evidence/{id}', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'deleteVideoEvidence'])->name('athlete.delete-video-evidence');
        Route::post('/like-video-evidence', [App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'likeVideoEvidence'])->name('athlete.like-video-evidence');

         Route::post('workout-detail',[App\Http\Controllers\frontend\Athlete\VideoEvidenceController::class, 'workoutDetail'])->name('workout-detail');

        //chat

        // Route::get('/chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'index'])->name('athlete.chat');
        Route::get('/chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'messagePage'])->name('athlete.chat');
        Route::get('/chat-ids',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'allChatIds'])->name('athlete.all-chat-ids');
        Route::post('/chat-view',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'viewChats'])->name('athlete.view-chats');
        Route::post('/chat-save',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'viewSave'])->name('athlete.chats-save');
        

        Route::post('/get-chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'getchat'])->name('athlete.get-connections-message'); 
        Route::post('/add-chat',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'savechat'])->name('athlete.save-connections-message'); 
        Route::post('/search-connection',[App\Http\Controllers\frontend\Athlete\ChatController::class, 'SearchConnection'])->name('athlete.search-connections');

    }
);

/**
 * ------------------------------------ Protected routes for coach ---------------------------
*/
//Protected routes
Route::post('/filter-athlete-compare', [App\Http\Controllers\frontend\coach\CompareController::class, 'filterAthleteCompare']);



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

         Route::get('/change-read-status', [App\Http\Controllers\frontend\coach\ProfileController::class, 'changeReadStatus'])->name('coach.change-read-status');

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
        Route::get('/teamingup-group-details/{id}/invite-member', [App\Http\Controllers\frontend\coach\TeamingController::class, 'inviteMember'])->name('coach.teamingup-group-details.add-mamber');
        Route::match(['GET','POST'],'/add-group-teamingup', [\App\Http\Controllers\frontend\coach\TeamingController::class, 'createTeamingGroupAdd']);


        Route::post('/create-teamingup-group', [\App\Http\Controllers\frontend\coach\TeamingController::class, 'createTeamingGroup'])->name('coach.create.teaming_group');

        Route::get('/edit-teamingup-group/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'editTeamingupGroup'])->name('coach.edit-teamingup-group');

        Route::post('/update.teaming_group/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'updateTeamingGroup'])->name('coach.update.teaming_group');

        Route::post('/create-group-admin', [App\Http\Controllers\frontend\coach\TeamingController::class, 'createGroupAdmin'])->name('coach.create-group-admin');

        Route::get('/delete-group/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'deleteGroup'])->name('coach.delete-group');

        

         Route::get('/delete-member/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'deleteMember'])->name('coach.delete-member');

        /*Route::get('/accept-invitation/{token}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'acceptInvitation'])->name('Frontend.accept.invitation');*/

        Route::get('search-connection',[App\Http\Controllers\frontend\coach\TeamingController::class, 'searchConnection']);

           

         Route::post('search-coach', [App\Http\Controllers\frontend\coach\ConnectionController::class, 'searchCoach'])->name('coach.search-coach');

        
         Route::get('check-group-user',[App\Http\Controllers\frontend\coach\TeamingController::class, 'checkGroupUser']);

         Route::get('coach/check-group',[App\Http\Controllers\frontend\coach\TeamingController::class, 'checkGroup']);
         Route::get('/coach-check-group-name',[App\Http\Controllers\frontend\coach\TeamingController::class, 'checkGroupName']);
         Route::post('/add-group-library/{id}', [App\Http\Controllers\frontend\coach\TeamingController::class, 'addGroupLibrary']);
         Route::post('/comparison-group-add', [App\Http\Controllers\frontend\coach\CompareController::class, 'comparisonGroupAdd'])->name('athlete.create-comparison-bygroup');
       
         Route::get('/invite-member/{id}/invite-member', [App\Http\Controllers\frontend\coach\TeamingController::class, 'inviteMember'])->name('coach.invite-member');

         Route::get('member-invite',[App\Http\Controllers\frontend\coach\TeamingController::class, 'invite'])->name('coach.invite');

         Route::post('selected-member-invite',[App\Http\Controllers\frontend\coach\TeamingController::class, 'inviteSelectedMember'])->name('coach.invite_selected_member');
        
          Route::post('selected-member-remove',[App\Http\Controllers\frontend\coach\TeamingController::class, 'removeSelectedMember'])->name('coach.remove_selected_member');

         Route::get('full-calender', [App\Http\Controllers\frontend\coach\TeamingController::class, 'fullCalander']);

         
         Route::post('/event-action',[App\Http\Controllers\frontend\coach\TeamingController::class, 'action'])->name('event-action');

         //Recommendation
         Route::get('/write-recomendation/{id}', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'writeRecommendation'])->name('coach.write-recomendation');

         Route::post('/send-recomendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'sendRecommendation'])->name('coach.send-recomendation');

         Route::post('/request-response',[App\Http\Controllers\frontend\coach\DashboardController::class, 'requestResponse'])->name('request-response');

        
        Route::post('/decline-recommendation',[App\Http\Controllers\frontend\coach\RecommendationController::class, 'declineRecommendation'])->name('coach.decline.recommendation');

         Route::get('/edit-recomendation/{id}', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'editRecommendation'])->name('coach.edit-recomendation');

         Route::post('/update-recomendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'updateRecommendation'])->name('coach.update-recomendation');

          Route::get('get-reply-msg',[App\Http\Controllers\frontend\coach\RecommendationController::class, 'getReplymsg'])->name('coach.get-reply-msg');

        //Lookup
        Route::get('/reverse-lookups', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'index'])->name('coach.lookup');
        Route::post('/save-reverse-lookups', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'saveReverseLookups'])->name('coach.save-reverse-lookups');
        Route::post('/delete-reverse-lookup/{id}', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'deleteReverseLookup'])->name('coach.delete-reverse-lookup');

         Route::get('get-sportslist',[App\Http\Controllers\frontend\coach\ReverselookupController::class, 'getSports']);

         Route::get('get-sport-position',[App\Http\Controllers\frontend\coach\ReverselookupController::class, 'getSportPosition']); 
        
        //Recommendation
        Route::get('/recommendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'index'])->name('coach.recommendation');

        Route::get('/write-recommendation', [App\Http\Controllers\frontend\coach\RecommendationController::class, 'writeRecommendation'])->name('coach.write-recommendation');

        //Search
        Route::match(['GET','POST'], '/connections', [App\Http\Controllers\frontend\coach\ConnectionController::class, 'index'])->name('coach.connections');
        
        Route::post('/connection/message', [App\Http\Controllers\frontend\coach\ConnectionController::class, 'addConnectionMessage'])->name('coach.add-connections-message');
        
        Route::post('/addfollowers', [App\Http\Controllers\frontend\coach\ConnectionController::class, 'addFollowers'])->name('coach.add-follow');

        Route::post('/unfollow', [App\Http\Controllers\frontend\coach\ConnectionController::class, 'unfollow'])->name('coach.unfollow');
        //Events
        Route::match(['GET','POST'],'/events', [App\Http\Controllers\frontend\coach\EventsController::class, 'index'])->name('coach.events');
        Route::get('/add-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'addEvents'])->name('coach.add-events');
        Route::get('/edit-events/{id}', [App\Http\Controllers\frontend\coach\EventsController::class, 'addEvents'])->name('coach.edit-events');
        Route::post('/save-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'saveEvents'])->name('coach.save-events');
        Route::post('/delete-events/{id}', [App\Http\Controllers\frontend\coach\EventsController::class, 'deleteEvents'])->name('coach.delete-events');
        Route::post('/details-events', [App\Http\Controllers\frontend\coach\EventsController::class, 'detailsEvents'])->name('coach.details-events');
    
        
        Route::get('/add-reverse-lookup', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'addReverse'])->name('coach.add-reverse-lookup');
        Route::get('/edit-reverse-lookup/{id}', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'addReverse'])->name('coach.edit-reverse-lookup');
        Route::get('/view-reverse-lookup/{id}', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'viewReverse'])->name('coach.view-reverse-lookup');
        

        Route::get('/report', [App\Http\Controllers\frontend\coach\ReportController::class, 'index'])->name('coach.report');  
         Route::post('/save-report', [App\Http\Controllers\frontend\coach\ReportController::class, 'saveReport'])->name('coach.save-report');
        //Compare section
        // Route::match(['GET','POST'],'/compare', [App\Http\Controllers\frontend\coach\CompareController::class, 'index'])->name('coach.compare');
        // Route::get('/new-athelete/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'AddAthlete'])->name('coach.new-athelete');
        // Route::post('/add-compare', [App\Http\Controllers\frontend\coach\CompareController::class, 'addCompare'])->name('coach.add-compare');
        // Route::post('/delete-compare/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'deleteCompare'])->name('coach.delete-compare');
        // Route::post('/delete-compare-user/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'deleteCompareUser'])->name('coach.delete-compare-user');
        // Route::get('/compare-group', [App\Http\Controllers\frontend\coach\CompareController::class, 'compareGroup'])->name('coach.compare-group');
        // Route::post('/compare-group/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'compareGroup'])->name('coach.compare-group-id');
        // Route::post('/create-comparison', [App\Http\Controllers\frontend\coach\CompareController::class, 'createComparison'])->name('coach.create-comparison');
        //  Route::post('/create-comparison-bygroup', [App\Http\Controllers\frontend\coach\CompareController::class, 'createComparisonFromGroup'])->name('coach.create-comparison-bygroup');
        // Route::post('/update-comparison/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'updateComparison'])->name('coach.update-comparison');
        // Route::get('/comparison-details/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'comparisonDetails'])->name('coach.comparison-details');
       
        //
        Route::match(['GET','POST'],'/compare', [App\Http\Controllers\frontend\coach\CompareController::class, 'index'])->name('coach.compare');
         
        Route::get('/new-athelete/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'AddAthlete'])->name('coach.new-athelete');
        Route::post('/add-compare', [App\Http\Controllers\frontend\coach\CompareController::class, 'addCompare'])->name('coach.add-compare');
        Route::post('/delete-compare/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'deleteCompare'])->name('coach.delete-compare');
        Route::post('/delete-compare-user/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'deleteCompareUser'])->name('coach.delete-compare-user');
        Route::get('/compare-group', [App\Http\Controllers\frontend\coach\CompareController::class, 'compareGroup'])->name('coach.compare-group');
        Route::post('/compare-group/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'compareGroup'])->name('coach.compare-group-id');
        Route::post('/create-comparison', [App\Http\Controllers\frontend\coach\CompareController::class, 'createComparison'])->name('coach.create-comparison');
        Route::post('/create-comparison-bygroup', [App\Http\Controllers\frontend\coach\CompareController::class, 'createComparisonFromGroup'])->name('coach.create-comparison-bygroup');
        Route::post('/update-comparison/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'updateComparison'])->name('coach.update-comparison');
        Route::get('/comparison-details/{id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'comparisonDetails'])->name('coach.comparison-details');
        Route::get('/comparison-details/{id}/{wrk_id}', [App\Http\Controllers\frontend\coach\CompareController::class, 'comparisonDetails'])->name('coach.comparison-details');





        // Route::get('/coach/chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'index'])->name('coach.chat');
        // Route::post('/coach/get-chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'getchat'])->name('coach.get-connections-message'); 
        // Route::post('/coach/add-chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'savechat'])->name('coach.save-connections-message'); 
        // Route::post('/coach/search-connection',[App\Http\Controllers\frontend\coach\ChatController::class, 'SearchConnection'])->name('coach.search-connections');

        Route::get('/chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'messagePage'])->name('coach.chat');
        Route::get('/chat-ids',[App\Http\Controllers\frontend\coach\ChatController::class, 'allChatIds'])->name('coach.all-chat-ids');
        Route::post('/chat-view',[App\Http\Controllers\frontend\coach\ChatController::class, 'viewChats'])->name('coach.view-chats');
        Route::post('/chat-save',[App\Http\Controllers\frontend\coach\ChatController::class, 'viewSave'])->name('coach.chats-save');
        Route::post('/add-chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'savechat'])->name('coach.save-connections-message'); 
       
    }
);
Route::get('/library-measurements-get', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'library_measurements_get']);
Route::get('/sport-position-get', [App\Http\Controllers\frontend\coach\ReverselookupController::class, 'sport_position_get']);




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

            Route::resource('/team', \App\Http\Controllers\Admin\TeamController::class);

            Route::resource('/advisory', \App\Http\Controllers\Admin\AdvisoryController::class);
           /* Route::delete('/team/{id}', [App\Http\Controllers\Admin\TeamController::class, 'destroy']);*/


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


            //Email A Coach
            Route::resource('/email', \App\Http\Controllers\Admin\EmailController::class);

            Route::get('/add-email', [App\Http\Controllers\Admin\EmailController::class, 'create'])->name('admin.email.create');
            Route::post('/save-email', [App\Http\Controllers\Admin\EmailController::class, 'store'])->name('admin.email.save');

             Route::get('/search-coach', [App\Http\Controllers\Admin\EmailController::class, 'search'])->name('admin.coach.search');

              Route::post('searchcoach',[App\Http\Controllers\Admin\EmailController::class, 'searchCoach'])->name('admin.searchcoach');
              Route::get('/edit-coach/{id}', [App\Http\Controllers\Admin\EmailController::class, 'edit'])->name('admin.edit.coach');

               Route::post('/coach-update/{id}', [App\Http\Controllers\Admin\EmailController::class, 'update'])->name('admin.coach.update');
               Route::get('/reset-search', [App\Http\Controllers\Admin\EmailController::class, 'reset'])->name('admin.reset-search');
               
                 Route::post('searchByCon',[App\Http\Controllers\Admin\EmailController::class, 'searchByCon'])->name('admin.searchByCon');



         
           // Route::delete('/email/{id}', [App\Http\Controllers\Admin\EmailController::class, 'destroy']);	
			
			
        }
);



////Firebase Routes


Route::get('/test',[FirebaseController::class, 'index']);
Route::get('/test/getData',[FirebaseController::class, 'getData']);


///Chat 

// Route::get('/coach/chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'index'])->name('coach.chat');

// Route::get('/chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'index'])->name('coach.chat');
// Route::post('/get-chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'getchat'])->name('coach.get-connections-message'); 
// Route::post('/add-chat',[App\Http\Controllers\frontend\coach\ChatController::class, 'savechat'])->name('coach.save-connections-message'); 
// Route::post('/search-connection',[App\Http\Controllers\frontend\coach\ChatController::class, 'SearchConnection'])->name('coach.search-connections');
