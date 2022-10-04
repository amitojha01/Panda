<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'authenticate']);

/*Registration Resources*/
Route::get('get-country', [App\Http\Controllers\Api\CountryController::class, 'index']);
Route::get('get-state', [App\Http\Controllers\Api\StateController::class, 'index']);
Route::get('get-city', [App\Http\Controllers\Api\CityController::class, 'index']);
/** Get zip based on City */
Route::get('get-zip-codes', [App\Http\Controllers\Api\CityController::class, 'getZipcodes']);


Route::get('get-colleges', [App\Http\Controllers\Api\CollegeController::class, 'index']);
//get congerences
Route::get('get-competitive-level', [App\Http\Controllers\Api\CollegiateConferncesController::class, 'index']);
Route::get('get-conference', [App\Http\Controllers\Api\CollegiateConferncesController::class, 'getConferences']);

Route::get('get-school', [App\Http\Controllers\Api\CollegeController::class, 'getSchool']);
//Get rec/club/travel
Route::get('get-clubs', [App\Http\Controllers\Api\CollegeController::class, 'getClubs']);
//Get Contact Preference (Coach)
Route::get('get-preference', [App\Http\Controllers\Api\PreferenceController::class, 'index']);

Route::get('get-school-playing-level', [App\Http\Controllers\Api\SchoolPlayingLevelController::class, 'index']);
Route::get('get-education-level', [App\Http\Controllers\Api\EducationLevelController::class, 'index']);
/**Competition Levels */
Route::get('get-competition-level', [App\Http\Controllers\Api\CompetitionLevelController::class, 'index']);

Route::get('get-sports', [App\Http\Controllers\Api\SportsController::class, 'index']);
Route::get('get-sports-positions', [App\Http\Controllers\Api\SportsPositionController::class, 'index']);


/*Workouts*/
Route::get('get-workouts', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'index']);
//Workout's library
Route::get('get-workouts/library', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'getWorkoutLibrary']);
/**
 * 
*/
Route::post('save-workouts-library', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'postWorkoutLibrary']);

/**
 * get users saved workout library
*/
Route::get('get-user-workouts', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'getUserWorkoutLibrary']);
/*
    **returen all workouts librarys all together
*/
Route::get('get-workouts-library', [App\Http\Controllers\Api\WorkoutLibraryController::class, 'index']);
//get user subscriptions
Route::get('get-subscription', [App\Http\Controllers\Api\SubscriptionController::class, 'index']);


Route::post('register', [ApiController::class, 'register']);

/**
 *  Athlete Registration
*/
Route::post('/registration/athlete/step-1', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveStepOne']);

Route::post('/registration/athlete/save-guardian-info', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveGuardianInfo']);

Route::post('/registration/athlete/step-2', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveAddressStep']);
//after completed basic step
/*------Physical informations*/
Route::post('/registration/athlete/step-3', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveAthleteStepTwo']);

Route::get('/registration/athlete/dominant', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'dominant']);


/*------Sports informations*/
Route::post('/registration/athlete/step-4', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveAthleteStepThree']);
/*------Sports positions informations*/
Route::post('/registration/athlete/step-5', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveAthleteStepFour']);
/*------College informations*/
Route::post('/registration/athlete/step-6', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveAthleteStepFive']);
//taken subscription
Route::post('/registration/subscription', [App\Http\Controllers\Api\Athlete\RegisterController::class, 'saveSubscriptionStepFive']);
/*------Subscription informations*/
Route::post('registration/verify-email', [App\Http\Controllers\Auth\RegisterController::class, 'getVerifyEmail']);
Route::post('registration/verify-mobile', [App\Http\Controllers\Auth\RegisterController::class, 'getVerifyMobile']);

/**
 *  Coach Registration
*/
Route::post('/registration/coach/step-1', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveStepOne']);

Route::post('/registration/coach/step-2', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveAddressStep']);
//after completed basic step
/*------Other informations informations*/
Route::post('/registration/coach/step-3', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveCoachStepTwo']);

Route::get('numberOf-years-coaching-youth-athletes', [App\Http\Controllers\Api\Coach\RegisterController::class, 'yearsCoachingYouthAthletes']);
Route::get('primaryAgeGroup-you-currently-coach', [App\Http\Controllers\Api\Coach\RegisterController::class, 'primaryAgeGroupyoucurrentlyCoach']);

Route::get('coaching-level', [App\Http\Controllers\Api\Coach\RegisterController::class, 'coach_level']);

Route::get('sport-level', [App\Http\Controllers\Api\Coach\RegisterController::class, 'sport_level']);
/*------Sports informations*/
Route::post('/registration/coach/step-4', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveCoachStepThree']);
/*------College informations*/
Route::post('/registration/coach/step-5', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveCoachStepFour']);
//taken subscription
//Route::post('/registration/subscription', [App\Http\Controllers\Api\Coach\RegisterController::class, 'saveSubscriptionStepFive']);
/*------Subscription informations*/
Route::post('registration/verify-email', [App\Http\Controllers\Auth\RegisterController::class, 'getVerifyEmail']);
Route::post('registration/verify-mobile', [App\Http\Controllers\Auth\RegisterController::class, 'getVerifyMobile']);

/**
 * forgot password 
*/
Route::post('forgot-password', [App\Http\Controllers\Api\ForgotPasswordController::class, 'getForgotPasswordOtp']);
Route::post('validate-otp', [App\Http\Controllers\Api\ForgotPasswordController::class, 'validatePasswordOtp']);
Route::post('update-password', [App\Http\Controllers\Api\ForgotPasswordController::class, 'postUpdatePassword']);

// dashboard

Route::get('dashboard-graph-api/{id}', [App\Http\Controllers\Api\AthleteDashboardController::class, 'dashboardGraphApi']);

Route::post('athlete-profile-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'index']);
    // Route::post('athlete-chatlist-api', [App\Http\Controllers\Api\Athlete\ChatController::class, 'index']);
Route::post('add-follow-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'addFollowApi']);

Route::post('save-compare-group-list-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'groupListApi']);

Route::post('add-group-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'addGroupApi']);
Route::post('add-group-comparison-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'createGroupComparison']);
Route::get('delete-comparison-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'deleteCompare']);
Route::get('group-athlete-compare-details-api', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'groupAthleteCompareDetailsApi']);

// profile edit api.

Route::post('personal-update-profile', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'personalUpdateProfile']);
Route::post('personal-update-address', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'personalUpdateAddress']);
Route::post('personal-update-physical-info', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'personalUpdatePhysicalInfo']);
Route::post('personal-update-sports', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'personalUpdateSports']);
Route::post('personal-update-college', [App\Http\Controllers\Api\Athlete\ProfileController::class, 'personalUpdateCollege']);




Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::post('save-workouts-library', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'postWorkoutLibrary']);
    Route::get('get-workouts-tips', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'getWorkoutTips']);
    Route::post('save-workout-exercise', [App\Http\Controllers\Api\WorkoutCategoryController::class, 'storeWorkoutExecrise']);
    
    Route::get('athlete-dashboard-api', [App\Http\Controllers\Api\AthleteDashboardController::class, 'index']);

    Route::get('athlete-chatlist-api', [App\Http\Controllers\Api\Athlete\ChatController::class, 'index']);
     
    Route::get('events', [App\Http\Controllers\Api\EventsController::class, 'index']);
    Route::post('events', [App\Http\Controllers\Api\EventsController::class, 'store']);
    Route::get('events-details', [App\Http\Controllers\Api\EventsController::class, 'show']);
    Route::post('events-update', [App\Http\Controllers\Api\EventsController::class, 'update']);
    Route::get('events-delete', [App\Http\Controllers\Api\EventsController::class, 'destroy']);
    Route::get('get-events-category', [App\Http\Controllers\Api\EventsController::class, 'getEventCategory']);
    
    Route::get('event-opportunities', [App\Http\Controllers\Api\EventsController::class, 'eventOpportunities']);
    


    Route::get('games', [App\Http\Controllers\Api\GamesHighlightController::class, 'index']);
    Route::post('games', [App\Http\Controllers\Api\GamesHighlightController::class, 'store']);
    Route::get('games-details', [App\Http\Controllers\Api\GamesHighlightController::class, 'show']);
    Route::post('games-update', [App\Http\Controllers\Api\GamesHighlightController::class, 'update']);
    Route::get('games-delete', [App\Http\Controllers\Api\GamesHighlightController::class, 'destroy']);

    //Teamingup

    Route::get('teaming-group', [App\Http\Controllers\Api\TeamingController::class, 'index']);
    //store data
    Route::post('teaming-group', [App\Http\Controllers\Api\TeamingController::class, 'store']);
    Route::get('teaming-group/delete-member', [App\Http\Controllers\Api\TeamingController::class, 'destroyMember']);
    Route::get('teaming-group/get-invite-list', [App\Http\Controllers\Api\TeamingController::class, 'inviteMember']);
    Route::post('teaming-group/send-invite', [App\Http\Controllers\Api\TeamingController::class, 'invite']);
    Route::get('teaming-group-details', [App\Http\Controllers\Api\TeamingController::class, 'show']);
    //self exit
    Route::get('teaming-group/exit', [App\Http\Controllers\Api\TeamingController::class, 'exitGroup']);
    Route::get('teaming-group/delete', [App\Http\Controllers\Api\TeamingController::class, 'deleteGroup']);
    Route::get('teaming-group/admin', [App\Http\Controllers\Api\TeamingController::class, 'changeGroupAdmin']);


    Route::post('/saveGroup', [App\Http\Controllers\Api\TeamingController::class, 'saveGroup']);



    //video evidence

    Route::get('video-evidence', [App\Http\Controllers\Api\VideoEvidenceController::class, 'index']);
    Route::post('video-evidence', [App\Http\Controllers\Api\VideoEvidenceController::class, 'store']);
    Route::post('video-evidence-update', [App\Http\Controllers\Api\VideoEvidenceController::class, 'update']);
    Route::get('video-evidence-delete', [App\Http\Controllers\Api\VideoEvidenceController::class, 'destroy']);
    Route::get('video-evidence-details', [App\Http\Controllers\Api\VideoEvidenceController::class, 'show']);
    

    
});

// Route::get('video-evidence', [App\Http\Controllers\Api\VideoEvidenceController::class, 'index']);

