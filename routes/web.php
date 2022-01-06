<?php

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
Route::get('/test', function () {
    // $2y$10$pfLscwPUihvvIMvCtRde3u6dhAbj.yN0aGoySjnAEMzj3Y/Qx5h1q
    dd(bcrypt("1234567890"));
});
Route::get('/', function () {
    return view('index');
});

Route::get('rummygame', function () {
    return view('auth.login');
});

Route::get('download', function () {
    return view('download');
});

Route::get('/run-miggis', function () {
    // return Artisan::call('migrate');
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'DashboardController@index');
    Route::resource('dashboard', 'DashboardController');
    Route::resource('userRegistrations', 'UserRegistrationController');
    Route::post('userRegistration/datatable', ['as' => 'userRegistration.datatable', 'uses' => 'UserRegistrationController@datatable']);
    Route::post('userRegistration/userActivityDataTable', ['as' => 'userRegistration.userActivityDataTable', 'uses' => 'UserRegistrationController@userActivityDataTable']);
    Route::get('editProfile/{id}', 'UserRegistrationController@editProfile')->name('userRegistrations.EditProfile');
    Route::get('userActivity/{id}', 'UserRegistrationController@userActivity')->name('userRegistrations.userActivity');
    Route::get('destroy/{id}', 'UserRegistrationController@destroy')->name('userRegistrations.destroy');
    Route::patch('updateProfile/{id}', 'UserRegistrationController@updateProfile')->name('userRegistrations.updateProfile');
    Route::patch('updatePassword/{id}', 'UserRegistrationController@changePassword')->name('userRegistrations.updatePassword');



    Route::get('user_action/{user_id}', 'UserRegistrationController@UserAction');
    Route::resource('gameTypes', 'GameTypeController');
    Route::get('game_action/{game_id}', 'GameTypeController@GameAction');

    Route::resource('gameTournaments', 'GameTournamentController');

    Route::resource('transactions', 'TransactionController');
    Route::post('transactions/depositDatatable', ['as' => 'transactions.depositDatatable', 'uses' => 'TransactionController@depositDatatable']);
    Route::post('transactions/referDatatable', ['as' => 'transactions.referDatatable', 'uses' => 'TransactionController@referDatatable']);
    Route::post('transactions/gameResultsDatatable', ['as' => 'transactions.gameResultsDatatable', 'uses' => 'TransactionController@gameResultsDatatable']);

    Route::resource('playGames', 'PlayGameController');
    Route::post('playGames/datatable', ['as' => 'playGames.datatable', 'uses' => 'PlayGameController@datatable']);

    Route::resource('tournamentTypes', 'TournamentTypeController');

    Route::resource('subscriptions', 'SubscriptionController');

    Route::resource('awards', 'AwardsController');

    Route::resource('banners', 'BannerController');
    Route::get('banner_is_active/{banner_id}', 'BannerController@BannerIsActive');

    Route::resource('chips', 'ChipController');

    Route::resource('promotions', 'PromotionController');
    Route::GET('is_active_promotion/{promo_id}', 'PromotionController@IsActivePromotion');
    Route::resource('withdrawAmounts', 'WithdrawAmountController');
    Route::post('withdrawAmounts/datatable', ['as' => 'withdrawAmounts.datatable', 'uses' => 'WithdrawAmountController@datatable']);
    Route::get('withdrawAmounts/show/{id}', ['as' => 'withdrawAmounts.show', 'uses' => 'WithdrawAmountController@show']);
    Route::get('payment_release/{w_id}', 'WithdrawAmountController@PaymentRelease');
    Route::resource('rewards', 'RewardsController');
    Route::post('rewards/datatable', ['as' => 'rewards.datatable', 'uses' => 'RewardsController@datatable']);
    Route::get('rewards/edit/{id}', ['as' => 'rewards.edit', 'uses' => 'RewardsController@edit']);
    Route::get('rewards/destroy/{id}', ['as' => 'rewards.destroy', 'uses' => 'RewardsController@destroy']);
    Route::resource('rank', 'PlayerRankController');
    Route::post('rank/datatable', ['as' => 'rank.datatable', 'uses' => 'PlayerRankController@datatable']);
    Route::get('rank/edit/{id}', ['as' => 'rank.edit', 'uses' => 'PlayerRankController@edit']);
    Route::get('rank/destroy/{id}', ['as' => 'rank.destroy', 'uses' => 'PlayerRankController@destroy']);
});

Route::resource('sendInvitations', 'SendInvitationController');

Route::resource('refers', 'ReferController');
Route::get('email_confirmation/{token}', 'UserRegistrationController@ConfirmEmail');
Route::get('set_password/{forgot_token}', 'UserRegistrationController@SetPassword');
Route::post('update_password', 'UserRegistrationController@UpdatePassword');

Route::get('send-sms/{mobile_no}', 'DownloadController@index');

Route::get('contact-us', function () {
    return view('contact_us');
});

Route::get('about-us', function () {
    return view('about_us');
});

Route::get('email-verification-test-route', function () {
    $token = "123";
    return view('emails.user_confirmation', compact('token'));
});
Route::get('email-verified-test-route', function () {
    $username = "virendra343";
    return view('emails.email_verified', compact('username'));
});
