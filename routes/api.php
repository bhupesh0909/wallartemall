<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
# Util Routes
// use Illuminate\Support\Facades\DB;
// Route::get('test', function(){
// 	$rewards = collect(DB::select(DB::raw("SELECT LOWER(REPLACE(reward, ' ', '_')) as reward, chips FROM rewards WHERE deleted_at IS NULL")));
// 	dd($rewards, $rewards->pluck('chips','reward'));
// });
Route::get('clear-cache', function () {
	Artisan::call('cache:clear');
	Artisan::call('route:clear');
	Artisan::call('config:clear');
	Artisan::call('view:clear');
	return "Cache is cleared";
});

Route::post('login', 'TestController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

// Route::middleware('APIToken')->group(function () 
Route::middleware(['jwt.verify'])->group(function () 
{
	
	Route::post('edit_profile', 'UserRegistrationAPIController@EditProfile');
	Route::post('app_setting', 'UserRegistrationAPIController@AppSettings');
	Route::post('change_password', 'UserRegistrationAPIController@ChangePassword');
	Route::post('account_info', 'UserRegistrationAPIController@GetAccountInfo');
	Route::post('user_logout', 'UserRegistrationAPIController@UserLogout');
	Route::post('notification_list', 'UserRegistrationAPIController@GetNotificationList');

	Route::post('delete_user', 'UserRegistrationAPIController@DeleteUser');
	Route::post('kyc_verification', 'UserRegistrationAPIController@KYCVerification');

	Route::post('promo_code', 'PromotionAPIController@PromoCode');


	Route::post('play_game', 'PlayGameAPIController@PlayGame');
	Route::post('game_winner', 'PlayGameAPIController@GameWinner');
	Route::post('register_tournament', 'GameTournamentAPIController@TournamentRegistration');
	Route::post('get_transactions', 'TransactionAPIController@GetTransactionList');
	Route::post('add_cash', 'TransactionAPIController@AddCash');
	Route::POST('withdraw_amount', 'WithdrawAmountAPIController@WithdrawAmount');
	Route::post('game_history', 'PlayGameAPIController@GameHistory');

	Route::post('accept_invitation', 'SendInvitationAPIController@AcceptInvitation');

	Route::post('get_reward', 'ReferAPIController@GetReward');
	Route::post('refer', 'ReferAPIController@ReferFriend');

	Route::POST('razorpay', 'WithdrawAmountAPIController@RazorPay');
	Route::post('send_otp', 'UserRegistrationAPIController@SendOtp');
	Route::get('clear_notification', 'UserRegistrationAPIController@clearNotification');
	Route::get('tournament_list/{user_id?}', 'GameTournamentAPIController@GetTournamentList');
});

Route::post('mobile_otp_verification', 'UserRegistrationAPIController@MobileOtpVerification');
Route::post('user_registration', 'UserRegistrationAPIController@UserRegistration');
Route::post('user_login', 'UserRegistrationAPIController@UserLogin');
Route::post('forgot_password', 'UserRegistrationAPIController@ForgotPassword');
Route::resource('game_types', 'GameTypeAPIController');
Route::post('check_version', 'UserRegistrationAPIController@CheckVersion');
Route::get('getapitoken', 'UserRegistrationAPIController@GetApiToken');


//Route::resource('game_tournaments', 'GameTournamentAPIController');


Route::resource('transactions', 'TransactionAPIController');
Route::post('payment', 'TransactionAPIController@Order');
// Route::post('payment/status', 'OrderController@paymentCallback');


//Route::resource('play_games', 'PlayGameAPIController');

Route::resource('tournament_types', 'TournamentTypeAPIController');

Route::resource('subscriptions', 'SubscriptionAPIController');

Route::resource('awards', 'AwardsAPIController');

Route::resource('banners', 'BannerAPIController');

Route::resource('chips', 'ChipAPIController');

Route::resource('promotions', 'PromotionAPIController');

//Route::resource('withdraw_amounts', 'Withdraw_amountAPIController');
//Route::POST('send_invitation', 'SendInvitationAPIController@SendInvitation');

Route::post('send_invitation', 'SendInvitationAPIController@SendInvitation');

//Route::resource('refers', 'ReferAPIController');
