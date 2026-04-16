<?php

use App\Models\Organization;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home.index');
});
Route::redirect('/admin', '/admin/sign-in');
Route::get('/admin/sign-in', [App\Http\Controllers\Admin\AdminController::class, 'adminSignInForm'])->name('adminSignInForm');
Route::post('/admin/sign-in', [App\Http\Controllers\Admin\AdminController::class, 'adminSignIn'])->name('adminSignIn');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::get('/chart/{year}', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'chart'])->name('admin.dashboard.chart');
    // feedback route
    Route::get('/feedback', [App\Http\Controllers\Admin\Dashboard\FeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::get('/feedback/show/{id}', [App\Http\Controllers\Admin\Dashboard\FeedbackController::class, 'show'])->name('admin.feedback.show');
    // oraganization rating route
    Route::get('/organization-rating', [App\Http\Controllers\Admin\Dashboard\OrganizationController::class, 'index'])->name('admin.organizationRating.index');

    Route::get('/organization-rating/show/{id}', [App\Http\Controllers\Admin\Dashboard\OrganizationController::class, 'show'])->name('admin.organizationRating.show');


    Route::post('/organization-rating/approve/{id}', [App\Http\Controllers\Admin\Dashboard\OrganizationController::class, 'approve'])->name('admin.organizationRating.approve');

    Route::post('/organization-rating/reject/{id}', [App\Http\Controllers\Admin\Dashboard\OrganizationController::class, 'reject'])->name('admin.organizationRating.reject');

    // peer rating route
    Route::get('/peer-rating', [App\Http\Controllers\Admin\Dashboard\PeerController::class, 'index'])->name('admin.peerRating.index');

    Route::get('/peer-rating/show/{id}', [App\Http\Controllers\Admin\Dashboard\PeerController::class, 'show'])->name('admin.peerRating.show');

    Route::post('/peer-rating/approve/{id}', [App\Http\Controllers\Admin\Dashboard\PeerController::class, 'approve'])->name('admin.peerRating.approve');

    Route::post('/peer-rating/reject/{id}', [App\Http\Controllers\Admin\Dashboard\PeerController::class, 'reject'])->name('admin.peerRating.reject');

    // reported coment route

    /*============================reported-comments routes goes here========================== */
    Route::get('/reported-comments', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'reportedComments'])->name('admin.reportedComments');
    Route::get('/organization-reported-Comments', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'fetehReportedComments'])->name('admin.fetehReportedComments');
    Route::get('/organization-reported-Comments/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'getReportedComments'])->name('admin.gethReportedComments');
    Route::delete('/deleteReportedComments/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'deleteReportedComments'])->name('admin.deleteReportedComments');
    Route::get('/peer-reported-Comments', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'fetehPeerReportedComments'])->name('admin.fetehPeerReportedComments');
    Route::get('/peer-reported-Comments/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'getPeerReportedComments'])->name('admin.gethPeerReportedComments');
    Route::delete('/deletePeerReportedComments/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'deletePeerReportedComments'])->name('admin.deletePeerReportedComments');
    Route::post('/keep-peer-reported-comment/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'keepPeerComment'])->name('admin.keepPeerComment');
    Route::post('/keep-organization-reported-comment/{id}', [App\Http\Controllers\Admin\Dashboard\ReportComments\ReportComments::class, 'keepOrganizationComment'])->name('admin.keepOrganizationComment');

    /*============================Organization routes goes here========================== */
    Route::get('/organizations', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'index'])->name('admin.organization.index');
    Route::get('/organizations/fetch-data', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'fetehOrganizations'])->name('admin.organization.fetchData');
    Route::delete('/organizations/delete/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'deleteOrganization'])->name('admin.organization.delete');
    Route::get('/organizations/pending-approval', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'pendingApproval'])->name('admin.organization.pendingApproval');
    Route::get('/organizations/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'show'])->name('admin.organization.show');
    Route::post('/organizations/approve/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'approveOrganization'])->name('admin.organization.approve');
    Route::post('/organizations/reject/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'rejectOrganization'])->name('admin.organization.reject');
    Route::get('/organizations/peers/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'organizationPeers'])->name('admin.organization.organizationPeers');
    Route::get('/organizations/{id}/ratings', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'organizationRating'])->name('admin.organization.organizationRating');
    Route::get('/organizations/reviews/{id}', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'organizationReviewsDetail'])->name('admin.organization.organizationReviewsDetail');
    Route::delete('/organizations/{orgId}/peer/{peerId}/delete/', [App\Http\Controllers\Admin\Dashboard\Organization\OrganizationController::class, 'deleteOrganizationPeer'])->name('admin.organization.deleteOrganizationPeer');

    /*============================Peer routes goes here========================== */
    Route::get('/peers', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'index'])->name('admin.peer.index');
    Route::get('/peers/fetch-data', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'fetehPeers'])->name('admin.peer.fetchData');
    Route::delete('/peers/delete/{id}', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'deletePeer'])->name('admin.peer.delete');
    Route::get('/peers/pending-approval', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'pendingApproval'])->name('admin.peer.pendingApproval');
    Route::get('/peers/{id}', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'show'])->name('admin.peer.show');
    Route::post('/peers/approve/{id}', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'approvePeer'])->name('admin.peer.approve');
    Route::post('/peers/reject/{id}', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'rejectPeer'])->name('admin.peer.reject');
    Route::get('/peers/reviews/{id}', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'peerReviewsDetail'])->name('admin.peer.peerReviewsDetail');
    Route::get('/peers/{id}/ratings', [App\Http\Controllers\Admin\Dashboard\Peer\PeerController::class, 'peerRating'])->name('admin.peer.peerRating');

    /*============================User routes goes here========================== */
    Route::get('/users', [App\Http\Controllers\Admin\Dashboard\User\UserController::class, 'getUsers'])->name('admin.user.index');
    Route::post('/users/block/{id}', [App\Http\Controllers\Admin\Dashboard\User\UserController::class, 'blockUser'])->name('admin.user.block');
    Route::post('/users/unblock/{id}', [App\Http\Controllers\Admin\Dashboard\User\UserController::class, 'unblockUser'])->name('admin.user.unblock');
    Route::delete('/users/delete/{id}', [App\Http\Controllers\Admin\Dashboard\User\UserController::class, 'deleteUser'])->name('admin.user.delete');
    Route::get('/blocked-users', [App\Http\Controllers\Admin\Dashboard\User\UserController::class, 'getBlockedUsers'])->name('admin.blockedUsers');
    /*============================Olds routes goes here========================== */
    Route::get('/homes', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
    Route::get('/fetchData', [App\Http\Controllers\HomeController::class, 'anyData'])->name('datatables.data');
    Route::get('/getUsers', [App\Http\Controllers\HomeController::class, 'getUsers'])->name('admin.listing');


    /*============================================== Configuration & ErrorLog routes here ============================================= */
    Route::get('configuration-variable', [App\Http\Controllers\ConfigurationController::class, 'view'])->name('configuration-variable');
    Route::get('configuration-variable-edit', [App\Http\Controllers\ConfigurationController::class, 'index'])->name('configuration-variable-edit');
    Route::post('configuration-variable-update', [App\Http\Controllers\ConfigurationController::class, 'update'])->name('configuration-variable-update');
    Route::get('error-logs', [App\Http\Controllers\ErrorLogController::class, 'index'])->name('get.error.logs');
    Route::get('error-log/detail/{id}', [App\Http\Controllers\ErrorLogController::class, 'show'])->name('get.error.logs.detail');
    Route::post('error-log/comment', [App\Http\Controllers\ErrorLogController::class, 'store'])->name('add.error.logs.comment');

    /*============================================== Terms Condition routes here ============================================= */
    Route::get('/term-condition/index', [App\Http\Controllers\Admin\TermsConditionController::class, 'index'])->name('term-condition.index');
    Route::post('/term-condition', [App\Http\Controllers\Admin\TermsConditionController::class, 'store'])->name('term-condition.store');
    Route::get('/term-condition', [App\Http\Controllers\Admin\TermsConditionController::class, 'view'])->name('term-condition.view');

    /*============================================== Privacy Policy routes here ============================================= */
    Route::get('/privacy-policy/index', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::post('/privacy-policy', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'store'])->name('privacy-policy.store');
    Route::get('/privacy-policy', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'view'])->name('privacy-policy.view');
});
Route::get('/data-script', [App\Http\Controllers\DataScriptController::class, 'dataScript']);

/*==============================================Artisan routes here============================================= */
Route::get('artisan-login', [App\Http\Controllers\ArtisanCommandController::class, 'configurationPassword'])->middleware('artisan_view');
Route::post('artisanlogin', [App\Http\Controllers\ArtisanCommandController::class, 'checkConfigurationPassword'])->name('artisanlogin');
Route::get('php_artisan_cmd', [App\Http\Controllers\ArtisanCommandController::class, 'runCommand'])->middleware('artisan_view');
Route::get('artisan', [App\Http\Controllers\ArtisanCommandController::class, 'indexArtisan'])->middleware(['artisan_view', 'artisan']);
Route::get('artisan-logout', [App\Http\Controllers\ArtisanCommandController::class, 'configurationLogout'])->name('artisanLogout')->middleware('artisan_view');

/*============================Route for the Terms & Conditions & Privacy Policy goes here ========================== */
// Terms & Conditions
Route::get('/terms-and-conditions', [App\Http\Controllers\User\TermsPolicy\TermsPolicyController::class, 'termsAndCondition'])->name('termsAndCondition');
// Privacy Policy
Route::get('/privacy-policy', [App\Http\Controllers\User\TermsPolicy\TermsPolicyController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::group(['prefix' => 'feedback'], function () {
    Route::get('/add', [App\Http\Controllers\User\AppFeedback\AppFeedbackController::class, 'addAppFeedbackForm'])->name('user.appFeedback.addAppFeedbackForm');
    Route::post('/save', [App\Http\Controllers\User\AppFeedback\AppFeedbackController::class, 'saveAppFeedback'])->name('user.appFeedback.saveAppFeedback');
});
Route::group(['prefix' => 'organization'], function () {
    Route::get('/add', [App\Http\Controllers\User\Organization\OrganizationController::class, 'addOrganizationForm'])->name('user.organization.addOrganizationForm');
    Route::post('/save', [App\Http\Controllers\User\Organization\OrganizationController::class, 'saveOrganization'])->name('user.organization.saveOrganization');
    Route::post('/rate/save', [App\Http\Controllers\User\Organization\OrganizationController::class, 'saveOrganizationRating'])->name('user.organization.saveOrganizationRating');
});
// Report-Ratings
Route::get('user/organization/report-rating/{organization_peerRatingId}', [App\Http\Controllers\User\Home\ReportRatingController::class, 'organizationReportRatingForm'])->name('user.organization.organizationReportRatingForm');
Route::post('user/organization/report-rating', [App\Http\Controllers\User\Home\ReportRatingController::class, 'addReportRatingOrganization'])->name('user.organization.addReportRatingOrganization');

// Report-Ratings
Route::get('user/peer/report-rating/{organization_peerRatingId}', [App\Http\Controllers\User\Home\ReportRatingController::class, 'peerReportRatingForm'])->name('user.peer.peerReportRatingForm');
Route::post('user/peer/report-rating', [App\Http\Controllers\User\Home\ReportRatingController::class, 'addReportRatingPeer'])->name('user.peer.addReportRatingPeer');

Route::group(['prefix' => 'peer'], function () {
    Route::get('/add/{id?}', [App\Http\Controllers\User\Peer\PeerController::class, 'addPeerForm'])->name('user.peer.addPeerForm');
    Route::post('/save', [App\Http\Controllers\User\Peer\PeerController::class, 'savePeer'])->name('user.peer.savePeer');
    Route::post('/rate/save', [App\Http\Controllers\User\Peer\PeerController::class, 'savePeerRating'])->name('user.peer.savePeerRating');
});
Route::post('/helpful', [App\Http\Controllers\User\Home\HelpfulController::class, 'saveHelpfulOrganization'])->name('user.organization.helpful.saveHelpfulOrganization');
Route::post('peer/helpful', [App\Http\Controllers\User\Home\HelpfulController::class, 'saveHelpfulPeer'])->name('user.peer.helpful.saveHelpfulPeer');

Route::group(['prefix' => 'department'], function () {
    Route::post('/add', [App\Http\Controllers\User\Department\DepartmentController::class, 'add'])->name('user.department.add');
});
/*
|--------------------------------------------------------------------------
| User's Route
|--------------------------------------------------------------------------
|
*/
/*============================ Authenticated User's Route goes here ========================== */
Route::group(['prefix' => 'user', 'middleware' => ['auth', 'checkStatus', 'role:User']], function () {
    /*============================Dashboard Routes goes here ========================== */
    Route::get('/home', [App\Http\Controllers\User\Home\HomeController::class, 'index'])->name('user.dashboard.index');

    /*============================Profile Setting Routes goes here ========================== */
    Route::group(['prefix' => 'profile-setting'], function () {
        Route::get('/user-setting', [App\Http\Controllers\User\ProfileSetting\ProfileSettingController::class, 'profileSettingForm'])->name('user.profileSetting.profileSettingForm');
        Route::put('/user-setting', [App\Http\Controllers\User\ProfileSetting\ProfileSettingController::class, 'update'])->name('user.profileSetting.update');
        Route::post('/user-setting/unSaveOrganization', [App\Http\Controllers\User\ProfileSetting\ProfileSettingController::class, 'unSaveOrganization'])->name('user.profileSetting.unSaveOrganization');
        Route::post('/user-setting/unSavePeer', [App\Http\Controllers\User\ProfileSetting\ProfileSettingController::class, 'unSavePeer'])->name('user.profileSetting.unSavePeer');
    });

    /*============================App Feedback Setting Routes goes here ========================== */

    /*============================Route for the Departments goes here ========================== */


    /*============================ Organization Routes goes here ========================== */
    Route::group(['prefix' => 'organization'], function () {
        Route::get('/rate/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'rateOrganizationForm'])->name('user.organization.rateOrganizationForm');
        Route::post('/saved-organization', [App\Http\Controllers\User\Organization\OrganizationController::class, 'savedOrganization'])->name('user.organization.savedOrganization');
        Route::get('/compare/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'compareOrganizationForm'])->name('user.organization.compareOrganizationForm');
        Route::get('/compare/compare-organization/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'compareOrganizationForm'])->name('user.organization.compareOrganization');
        Route::get('/list', [App\Http\Controllers\User\Organization\OrganizationController::class, 'listOrganization'])->name('user.organization.listOrganization');
        Route::get('/list/organization-name', [App\Http\Controllers\User\Organization\OrganizationController::class, 'listOrganization'])->name('user.organization.list.organizationName');
        // Show Home-Organization Details
        Route::get('/{id}', [App\Http\Controllers\User\Home\OrganizationController::class, 'show'])->name('user.organization.show');
    });

    /*============================ Peer Routes goes here ========================== */
    Route::group(['prefix' => 'peer'], function () {
        Route::get('/rate/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'ratePeerForm'])->name('user.peer.ratePeerForm');
        Route::post('/saved-peer', [App\Http\Controllers\User\Peer\PeerController::class, 'savedPeer'])->name('user.peer.savedPeer');
        Route::get('/compare/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'comparePeerForm'])->name('user.peer.comparePeerForm');
        Route::get('/compare/compare-peer/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'comparePeerForm'])->name('user.peer.comparePeer');
        Route::get('/list', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('user.peer.listPeer');
        Route::get('/list/peer-query', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('user.peer.list.listPeerByQuery');
        Route::get('/list/{organizationId}', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('user.peer.list.viewAllPeerByOrganizationId');
        // Show Home-Peer Details
        Route::get('/{id}', [App\Http\Controllers\User\Home\PeerController::class, 'show'])->name('user.peer.show');



        // Helpful

    });
});


/*============================Route for the Departments goes here ========================== */
Route::group(['prefix' => 'department'], function () {
    Route::get('/get-departments/{organizationId}', [App\Http\Controllers\User\Department\DepartmentController::class, 'getDepartments'])->name('user.department.getDepartments');
});


/*============================Route for the States goes here ========================== */
Route::group(['prefix' => 'state'], function () {
    Route::get('/get-states/{countryId}', [App\Http\Controllers\User\State\StateController::class, 'getStates'])->name('state.getStates');
    // Get Organization/Peer Data (Home Page) -> Authenticated User
    Route::get('/organization-peer-get-data', [App\Http\Controllers\User\Home\HomeController::class, 'getData'])->name('user.organization-peer.getData');
});


/*============================Route for the Both User guest and auth goes here ========================== */
/*============================Route for the Departments goes here ========================== */
Route::group(['prefix' => 'department'], function () {
    Route::get('/get-departments/{organizationId}', [App\Http\Controllers\User\Department\DepartmentController::class, 'getDepartments'])->name('user.department.getDepartments');
});

/*============================Route for the States goes here ========================== */
Route::group(['prefix' => 'state'], function () {
    Route::get('/get-states/{countryId}', [App\Http\Controllers\User\State\StateController::class, 'getStates'])->name('state.getStates');
});

Route::post('/save-location', [App\Http\Controllers\User\Home\HomeController::class, 'saveLocation'])->name('user.saveLocation');
/* ==================================================================================================== */
/*============================Authentication Guest Route goes here ========================== */
Route::group(['middleware' => 'guest'], function () {

    /*============================Home Routes goes here ========================== */
    Route::get('/home', [App\Http\Controllers\User\Home\HomeController::class, 'index'])->name('home.index');

    /*============================ Organization Routes goes here ========================== */
    Route::group(['prefix' => 'organization'], function () {
        Route::get('/rate/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'rateOrganizationForm'])->name('organization.rateOrganizationForm');
        Route::get('/compare/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'compareOrganizationForm'])->name('organization.compareOrganizationForm');
        Route::get('/compare/compare-organization/{organizationId}', [App\Http\Controllers\User\Organization\OrganizationController::class, 'compareOrganizationForm'])->name('organization.compareOrganization');
        Route::get('/list', [App\Http\Controllers\User\Organization\OrganizationController::class, 'listOrganization'])->name('organization.listOrganization');
        Route::get('/list/organization-name', [App\Http\Controllers\User\Organization\OrganizationController::class, 'listOrganization'])->name('organization.list.organizationName');
        // Show Organization details
        Route::get('/{id}', [App\Http\Controllers\User\Home\OrganizationController::class, 'show'])->name('organization.show');
    });

    /*============================ Peer Routes goes here ========================== */
    Route::group(['prefix' => 'peer'], function () {
        Route::get('/rate/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'ratePeerForm'])->name('peer.ratePeerForm');
        Route::get('/compare/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'comparePeerForm'])->name('peer.comparePeerForm');
        Route::get('/compare/compare-peer/{peerId}', [App\Http\Controllers\User\Peer\PeerController::class, 'comparePeerForm'])->name('peer.comparePeer');
        Route::get('/list', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('peer.listPeer');
        Route::get('/list/peer-query', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('peer.list.listPeerByQuery');
        Route::get('/list/{organizationId}', [App\Http\Controllers\User\Peer\PeerController::class, 'listPeer'])->name('peer.list.viewAllPeerByOrganizationId');
        // Show Home-Peer Details
        Route::get('/{id}', [App\Http\Controllers\User\Home\PeerController::class, 'show'])->name('peer.show');
    });

    // Get Organization/Peer Data (Home Page) -> Guest User
    Route::get('/organization-peer-get-data', [App\Http\Controllers\User\Home\HomeController::class, 'getData'])->name('organization-peer.getData');

    /*============================Sign-in , Sign-up Route goes here ========================== */
    Route::get('/sign-in', [App\Http\Controllers\User\Auth\AuthController::class, 'signInForm'])->name('user.auth.signInForm');
    Route::post('/send-otp/{otpType}', [App\Http\Controllers\User\Auth\AuthController::class, 'sendOtp'])->name('user.auth.sendOtp');
    Route::post('/verify-otp/{otpType}', [App\Http\Controllers\User\Auth\AuthController::class, 'verifyOtp'])->name('user.auth.verifyOtp');

    Route::get('/sign-up', [App\Http\Controllers\User\Auth\AuthController::class, 'signUpForm'])->name('user.auth.signUpForm');
    Route::get('/profile', [App\Http\Controllers\User\Auth\AuthController::class, 'profileForm'])->name('user.auth.profileForm');
    Route::post('/complete/profile', [App\Http\Controllers\User\Auth\AuthController::class, 'completeProfile'])->name('user.auth.completeProfile');

    // Redirect to social authentication
    Route::get('auth/{provider}', [App\Http\Controllers\User\Auth\AuthController::class, 'redirectToProvider'])->name('user.auth.provider');
    // Handle social authentication callback
    Route::match(['get', 'post'], 'auth/{provider}/callback', [App\Http\Controllers\User\Auth\AuthController::class, 'handleProviderCallback'])->name('user.auth.provider.callback');
});
