<?php

use App\Http\Controllers\Website\Dashboard\ProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

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

//  Route::get('/', function () {
//     return view('website.layout.home2');
// })->name('WebsiteHome');;
Route::group(['middleware' => [ 'set.locale']], function () {

    Auth::routes();
    Route::get('/login', 'Auth\Website\LoginController@login')->name('WebsiteLogin');
    Route::post('/login', 'Auth\Website\LoginController@checkLogin')->name('WebsitePostLogin');
    Route::post('/otp', 'Auth\Website\LoginController@otp_send');
    Route::post('/otp_verify', 'Auth\Website\LoginController@otp_verify');



    /*login sochial media*/
    Route::get('/auth/redirect/{provider}', 'Auth\Website\SocialController@redirect');
    Route::get('/callback/{provider}', 'Auth\Website\SocialController@callback');
    Auth::routes(['verify' => true, "login" => false]);
    Route::get('/verify/{token}', 'Auth\Website\LoginController@verify')->name("virifyLink");
    Route::get('/reverify', 'Auth\Website\LoginController@reVerify')->name("reverify");
    Route::post('/reverify', 'Auth\Website\LoginController@reVerifyPost')->name("reverify.post");


    //Route::any('logout', 'Auth\Website\LoginController@logout')->name('WebsiteLogout')->middleware('auth:web');;
    Route::any('logout', 'Auth\Website\LoginController@logout')->name('WebsiteLogout');

    Route::get('/register', 'Auth\Website\RegisterController@register')->name('WebsiteRegister');
    Route::post('/register', 'Auth\Website\RegisterController@postRegister')->name('WebsitePostRegister');
    Route::get('/', 'Website\HomeController@home')->name('WebsiteHome');
    Route::get('/lang/{locale}', 'Website\HomeController@changeWebsiteLang')->name('WebsiteLang');
    Route::get('/currency/{currency?}', 'Website\HomeController@changeWebsiteCurrency')->name('WebsiteCurrency');

    Route::get('/blog/{title}/{blog_id}', 'Website\BlogController@blog')->name('website.blog');
    Route::get('/blog/cat/{title}/{cat_id}', 'Website\BlogController@blogCategory')->name('website.blogCat');
    Route::get('/blogs/categories', 'Website\BlogController@blog_cats')->name('website.blog.categories');
    Route::post('/blog/comment/{blog_id}', 'Website\BlogController@sendBlogCommnet')->name('website.blog.comment');

    //projects list
    Route::any('/projects', 'Website\ProjectsController@index')->name('website.projects.index');
    Route::any('/projects/cat/{title}', 'Website\ProjectsController@category');
    Route::any('/projects/search', 'Website\ProjectsController@search');

    //Route::resource('projects', "Website\ProjectsController",['only' => [ 'create']]);
    Route::get('projects/create', 'Website\ProjectsController@create');
    Route::get('service/create', 'Website\ProjectsController@create_service');
    Route::post('projects/store', 'Website\ProjectsController@storeWithoutLogin');

    Route::get('dash/project/{category}/attr', 'Website\Dashboard\ProjectController@getAttr');

    Route::get('dash/project/{category}/cats', 'Website\Dashboard\ProjectController@getCats');


    //Route::any('/projects/{id}', 'Website\ProjectsController@show');

    Route::get('project/{id}/{title}', 'Website\Dashboard\ProjectBidController@index');
    Route::post('project/{id}/{title}', 'Website\Dashboard\ProjectBidController@store');

    //payment

    Route::get('pay/cancel', 'Payment\BidPayController@cancel')->name('payment.cancel');
    Route::get('pay/success', 'Payment\BidPayController@success')->name('payment.success');

    Route::get('/ajax_projects', 'Website\HomeController@getProjects');
    Route::post('/contact', 'Website\HomeController@store_contact')->name('website.contact.store');

    Route::group(['middleware' => ['auth:web,master']], function () {
        Route::get('/trusted/download/{file}', 'Website\Dashboard\HomeController@downloadTrusted')->name('downloadTrusted');
        Route::get('/trusted/request/{id}', 'Website\Dashboard\HomeController@downloadTrustedRequest')->name('downloadTrustedRequest');
        Route::get('/requests/{id}/download', 'Website\Dashboard\HomeController@downloadTransactionRequest')->name('downloadTransRequest');
    });
    Route::prefix('company')->group(function () {

       // Route::get('register', 'Auth\Website\Company\RegisterController@register')->name('company_register');
        Route::post('register', 'Auth\Website\Company\RegisterController@postRegister')->name('post_company_register');
        //Route::get('login', 'Auth\Website\Company\LoginController@login');
        Route::post('login', 'Auth\Website\Company\LoginController@checkLogin');
    });

});
