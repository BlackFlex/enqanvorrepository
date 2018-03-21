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

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------|
*/

/* Profile route */
Route::post('/edit-user-general-information', 'Ajax\UserActions@updateUserGeneralInformation');
Route::post('/edit-user-personal-information', 'Ajax\UserActions@updateUserPersonalInformation');
Route::post('/update-user-contact-information', 'Ajax\UserActions@updateUserContactInformation');


Route::get('/auto_withdraw-on', 'Ajax\UserActions@autoWithdrawOn');
Route::get('/auto_withdraw-off', 'Ajax\UserActions@autoWithdrawOff');

Route::get('/auto_recharge-on', 'Ajax\UserActions@autoRechargeOn');
Route::get('/auto_recharge-off', 'Ajax\UserActions@autoRechargeOff');



Route::name('psychic')->get('psychic/{screen_name}/{rateCount}', 'Front\UserDashboardController@showPsychic');
Route::post('/psychic-get-reviews/{rateCount}', 'Front\UserDashboardController@getPsychicReviews');

Route::name('psychic')->get('add-favorite-psychic/{id}', 'Front\UserDashboardController@addFavPsychic');

Route::name('psychic')->get('delete-favorite-psychic/{id}', 'Front\UserDashboardController@deleteFavPsychic');

Route::get('login/facebook', 'SocialLogin@redirectToProvider');
Route::get('login/facebook/callback', 'SocialLogin@handleProviderCallback');

/* Ajax route */
Route::post('/ajax/login', 'Ajax\RegisterController@Login');
Route::post('/ajax/register', 'Ajax\RegisterController@create');
Route::post('/ajax/register-fast', 'Ajax\RegisterController@registerFast');







/* Ajax route send messages*/
Route::post('/send-message', 'MessagesController@sendMessageToUser');
Route::post('/get-conversation', 'MessagesController@getConversationBetweenTwoUsers');
Route::post('/user-is-typing', 'MessagesController@userIsTyping');
Route::post('/user-is-not-typing', 'MessagesController@userIsNotTyping');



Route::post('/get-unread-messages', 'MessagesController@getUnreadMessages');
Route::post('/get-unread-messages-for-per-minute-chat', 'MessagesController@getUnreadMessagesForPerMinuteChat');
Route::post('/get-user-from-search', 'MessagesController@findUser');
Route::post('/delete-conversation', 'MessagesController@removeConversation');
Route::post('/block-conversation', 'MessagesController@blockConversation');
Route::post('/unblock-conversation', 'MessagesController@unblockConversation');
Route::post('/new-conversation-add', 'MessagesController@startNewConversation');
Route::post('/get-users-status', 'MessagesController@getUsersStatus');
Route::post('/check-if-have-conversation', 'MessagesController@checkIfHaveConversation');
Route::post('/change-user-status', 'MessagesController@changeUserStatus');



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

/*User dashboard */
Route::get('/dashboard', 'Front\UserDashboardController@showUserDashboard');

// Home
Route::get('/addpost', 'Api\AddsController@showpage');
Route::post('/addpost', 'Api\AddsController@store');




Route::name('home')->get('/', 'Front\PostController@index');
Route::name('reading-history')->get('/reading-history', 'Front\PostController@readingHistory');
Route::name('payments')->get('/payments', 'Front\PostController@payments');


Route::name('my-psychics')->get('/my-psychics', 'Front\PostController@myPsychics');
Route::name('my-clients')->get('/my-clients', 'Front\PostController@myClients');


Route::name('general-settings')->get('/general-settings', 'Front\UserInfoChangeController@generalSettings');
Route::name('personal-settings')->get('/personal-settings', 'Front\UserInfoChangeController@personalSettings');
Route::name('contact-information-settings')->get('/contact-information-settings', 'Front\UserInfoChangeController@contactInformationSettings');
Route::name('email-settings')->get('/email-settings', 'Front\UserInfoChangeController@emailSettings');
Route::post('email-settings-main' ,'Front\UserInfoChangeController@emailSettingsMain');
Route::post('email-settings-main-expert' ,'Front\UserInfoChangeController@emailSettingsMainExper');

Route::name('payment-settings')->get('/payment-settings', 'Front\UserInfoChangeController@paymentSettings');

Route::name('messages')->get('/messages/{expert}', 'MessagesController@showMessagesPage');
Route::get('/frontpage', 'Front\PostController@frontpage');


// Contact
Route::resource('contacts', 'Front\ContactController', ['only' => ['create', 'store']]);








// Posts and comments
Route::prefix('posts')->namespace('Front')->group(function () {
    Route::name('posts.display')->get('{slug}', 'PostController@show');
    Route::name('posts.tag')->get('tag/{tag}', 'PostController@tag');
    Route::name('posts.search')->get('', 'PostController@search');
    Route::name('posts.comments.store')->post('{post}/comments', 'CommentController@store');
    Route::name('posts.comments.comments.store')->post('{post}/comments/{comment}/comments', 'CommentController@store');
    Route::name('posts.comments')->get('{post}/comments/{page}', 'CommentController@comments');
});

Route::resource('comments', 'Front\CommentController', [
    'only' => ['update', 'destroy'],
    'names' => ['destroy' => 'front.comments.destroy']
]);

Route::name('category')->get('category/{category}', 'Front\PostController@category');
// Authentification
Auth::routes();
/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------|
*/
Route::prefix('admin')->namespace('Back')->group(function () {
    Route::middleware('redac')->group(function () {
        Route::name('admin')->get('/', 'AdminController@index');
        // Posts
        Route::name('posts.seen')->put('posts/seen/{post}', 'PostController@updateSeen')->middleware('can:manage,post');
        Route::name('posts.active')->put('posts/active/{post}/{status?}', 'PostController@updateActive')->middleware('can:manage,post');
        Route::resource('posts', 'PostController');
        // Notifications
        Route::name('notifications.index')->get('notifications/{user}', 'NotificationController@index');
        Route::name('notifications.update')->put('notifications/{notification}', 'NotificationController@update');
        // Medias
        Route::view('medias', 'back.medias')->name('medias.index');
    });
    Route::middleware('admin')->group(function () {
        // Users
        Route::name('users.seen')->put('users/seen/{user}', 'UserController@updateSeen');
        Route::name('users.valid')->put('users/valid/{user}', 'UserController@updateValid');
        Route::resource('users', 'UserController', ['only' => [
            'index', 'edit', 'update', 'destroy'
        ]]);
        // Categories
        Route::resource('categories', 'CategoryController', ['except' => 'show']);
        // Contacts
        Route::name('contacts.seen')->put('contacts/seen/{contact}', 'ContactController@updateSeen');
        Route::resource('contacts', 'ContactController', ['only' => [
            'index', 'destroy'
        ]]);
        // Comments
        Route::name('comments.seen')->put('comments/seen/{comment}', 'CommentController@updateSeen');
        Route::resource('comments', 'CommentController', ['only' => [
            'index', 'destroy'
        ]]);
        // Settings
        Route::name('settings.edit')->get('settings', 'AdminController@settingsEdit');
        Route::name('settings.update')->put('settings', 'AdminController@settingsUpdate');
    });

});
/*** ACCEPT OR REJECT PER MINUTE CHAT REQUEST ***/
Route::post('/per-minute-chat-action', 'PaidSessionController@actionsPerMinuteChat');
Route::post('/per-minute-chat-check-request', 'PaidSessionController@checkRequests');
Route::post('/waitExpertResponse', 'PaidSessionController@waitExpertResponse');
Route::post('/send-request-to-start-session', 'PaidSessionController@sendRequest');
Route::post('/check-if-session-ended', 'PaidSessionController@checkIfSessionEnded');
Route::post('/paid-session-actions', 'PaidSessionController@sessionActions');
Route::post('/add-funds-to-session', 'PaidSessionController@addFundsToSession');
Route::post('/send-message-to-paid-session', 'PaidSessionController@sendMessageToUserPaidSession');
Route::post('/paid-session-rate', 'PaidSessionController@rateSession');
Route::post('/paid-conversation-delete', 'PaidSessionController@conversationDelete');
Route::post('/check-user-balance-before-chat', 'PaidSessionController@checkUserBalanceBeforeChat');
Route::post('/change-status-and-save-to-call', 'PaidSessionController@changeStatusAndSaveToCall');
Route::post('/change-chat-status-to-hang-up-user-side', 'PaidSessionController@changeChatStatusToHangUpUserSide');
Route::post('/change-chat-status-to-hang-up-expert-side', 'PaidSessionController@changeChatStatusToHangUpExpertSide');
/*** ACCEPT OR REJECT PER MINUTE CHAT REQUEST END***/
/*** PAYMET CREATE ***/
Route::post('/make-payment', 'PaymentsController@makePayments');
Route::post('/make-payment-from-user-for-chat', 'PaymentsController@makePaymentFromUserForChat');
Route::post('/make-payment-from-user-for-chat-from-paypal', 'PaymentsController@makePaymentsForChatFromPaypal');
/*** PAYMET CREATE END***/
Route::post('/block-user', 'PaymentsController@blockUser');
Route::post('/get-payment-history', 'PaymentsController@getPaymentHistory');
Route::get('/psychics', 'Front\PostController@psychicsList');
Route::get('/delete-conversation-in-session', 'PaidSessionController@conversationPaidDelete');
Route::name('reading-history')->get('/reading-history/{slug}', 'Front\PostController@readingHistory');

