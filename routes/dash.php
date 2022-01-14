<?php

use App\Http\Controllers\Website\Dashboard\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:web', 'set.locale']], function () {
    Route::prefix('dash')->group(function () {
        Route::resource('project', "Website\Dashboard\ProjectController");
        Route::delete('project/attach/{id}', 'Website\Dashboard\ProjectController@delAttach');
        Route::post('project/{id}/publish', 'Website\Dashboard\ProjectController@publish');
         Route::post('project/{id}/edit', 'Website\Dashboard\ProjectController@update');

        Route::get('service/create', 'Website\Dashboard\ProjectController@createService');

        //bids
        Route::get('bid/{id}', 'Website\Dashboard\ProjectBidController@show');
        Route::post('bid/{id}/accept', 'Website\Dashboard\ProjectBidController@accept');
        Route::post('bid/{id}/reject', 'Website\Dashboard\ProjectBidController@reject');
        Route::match(['get', 'post'], 'bids/my', 'Website\Dashboard\ProjectBidController@myBids');
        Route::get('bid/my/{id}', 'Website\Dashboard\ProjectBidController@mySingleBid');
        //work
        Route::post('bid_work/store/{id}', 'Website\Dashboard\ProjectBidController@saveMyWork');
        Route::get('bid_work/download/{id}', 'Website\Dashboard\ProjectBidController@download');
        Route::post('bid_work/complete/{id}', 'Website\Dashboard\ProjectBidController@complete');
        Route::post('bid_work/close/{id}', 'Website\Dashboard\ProjectBidController@close');
        //transactions
        Route::get('transactions', 'Website\Dashboard\TransactionController@index');
        Route::get('transactions/request/{bid_id}', 'Website\Dashboard\TransactionController@onRequest');

        //messages
        // Route::resource('messages', "Website\Dashboard\MessagesController");
        Route::post('message/store', "Website\Dashboard\MessagesController@store");
        Route::get('messages', 'Website\Dashboard\MessagesController@index')->name('website.message.index');
        Route::get('message/{id}/read', 'Website\Dashboard\MessagesController@read_message')->name('website.message.read');
        Route::get('message/{id}/destroy', 'Website\Dashboard\MessagesController@destroy')->name('website.message.destroy');
        Route::post('message/{id}/reply', 'Website\Dashboard\MessagesController@msg_reply')->name('website.message.reply');
    });


    //Notifications
    Route::get('notifications', 'Website\Dashboard\NotificationsController@index');
    Route::post('notifications/{id}/read', 'Website\Dashboard\NotificationsController@read');
    Route::delete('notifications/{id}/delete', 'Website\Dashboard\NotificationsController@destroy');
    Route::delete('notifications/delete', 'Website\Dashboard\NotificationsController@destroyAll');
    Route::post('notifications/read', 'Website\Dashboard\NotificationsController@readAll');


    Route::get('/complaints', 'Website\Dashboard\ComplaintsController@index')->name('website.complaints.index');
    Route::get('/complaints/ticket/{id}', 'Website\Dashboard\ComplaintsController@editTicket')->name('website.complaints.editTicket');
    Route::post('/complaints/ticket/{id}', 'Website\Dashboard\ComplaintsController@updateTicket')->name('website.complaints.updateTicket');
    Route::get('/complaints/ticket/{id}/delete', 'Website\Dashboard\ComplaintsController@deleteTicket')->name('website.complaints.deleteTicket');
    Route::get('/complaints/ticket', 'Website\Dashboard\ComplaintsController@ticket')->name('website.complaints.ticket');
    Route::any('/complaints/open_ticket', 'Website\Dashboard\ComplaintsController@open_ticket')->name('website.complaints.open_ticket');
    Route::post('/complaints/send_ticket', 'Website\Dashboard\ComplaintsController@send_ticket')->name('website.complaints.send_ticket');

    Route::get('/account/profile', 'Website\Dashboard\ProfileController@index')->name('website.profile.index');
    Route::post('/account/profile', 'Website\Dashboard\ProfileController@profile_save')->name('website.profile.save');
    Route::get('/account/personal_info', 'Website\Dashboard\ProfileController@personal_info')->name('website.profile.personal_info');
    Route::post('/account/personal_info/update', 'Website\Dashboard\ProfileController@update_personal_info')->name('website.profile.update_personal_info');
    Route::post('/account/personal_info/update_logo', 'Website\Dashboard\ProfileController@update_logo')->name('website.profile.update_logo');
    Route::get('/city/list', 'Website\Dashboard\ProfileController@cityList')->name('website.city.list');
    Route::get('/account/skills', 'Website\Dashboard\ProfileController@skills')->name('website.profile.skills');
    Route::post('/account/skills', 'Website\Dashboard\ProfileController@save_skills')->name('website.profile.save_skills');
    Route::get('account/trusted', 'Website\Dashboard\TrustedAccount@trusted');
    Route::post('account/trusted', 'Website\Dashboard\TrustedAccount@trustedStore');

    Route::get('/home', 'Website\Dashboard\HomeController@index')->name('home');


});
