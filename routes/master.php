<?php


use App\Http\Controllers\Master\SiteSettings\CurrencyController;
use App\Http\Controllers\Master\SiteSettings\DiscountController;
use App\Models\SiteSettings\Currency;
use Illuminate\Support\Facades\Route;


Route::prefix('master')->group(function () {
    Route::get('/lang/{locale}', 'Master\DashboardController@changeMasterLang')->name('master.lang');

    Route::get('login', 'Auth\Master\LoginController@login')->name('MasterLogin');
    Route::post('login', 'Auth\Master\LoginController@checkLogin')->name('MasterPostLogin');
    Route::any('logout', 'Auth\Master\LoginController@logout')->name('MasterLogout')->middleware('auth:master');

    Route::post('password/reset', 'Auth\Master\LoginController@forgotPasswordPost')->name('master.do.reset.password');
    Route::get('password/reset/{token}', 'Auth\Master\LoginController@reset_token_get')->name('master.reset.password.token');
    Route::post('reset_token', 'Auth\Master\LoginController@reset_token')->name('master.reset.password.token.post');

    Route::get('language/getLang', 'LanguageController@getLang')->name('master.get.lang');

    Route::group(['middleware' => ['auth:master', 'set.locale'], 'namespace' => 'Master'], function () {
        Route::get('/home', 'DashboardController@index')->name('MasterHome');


        Route::get('permissions', 'Security\PermissionsController@index')->name('master.permissions');
        //        Route::get('permissions', [\App\Http\Controllers\Master\Security\PermissionsController::class, 'index'])->name('master.permissions');
        Route::post('permissions/store', 'Security\PermissionsController@store')->name('master.permissions.store');
        Route::patch('permissions/update', 'Security\PermissionsController@update')->name('master.permissions.update');
        Route::post('permissions/store_translation', 'Security\PermissionsController@storeTranslation')->name('master.permissions.storeTranslation');
        Route::get('permissions/getLangValue', 'Security\PermissionsController@getLangValue')->name('master.permissions.getLangValue');
        Route::delete('permissions/{id}/delete', 'Security\PermissionsController@delete')->name('master.permissions.delete');

        Route::get('roles', 'Security\RolesController@index')->name('master.roles');
        Route::get('roles/create', 'Security\RolesController@create')->name('master.roles.create');
        Route::get('roles/{id}', 'Security\RolesController@edit')->name('master.roles.edit');
        Route::post('roles', 'Security\RolesController@store')->name('master.roles.store');
        Route::post('roles/{id}', 'Security\RolesController@update')->name('master.roles.update');
        Route::delete('roles/{id}/delete', 'Security\RolesController@destroy')->name('master.roles.destroy');
        Route::get('roles/get_permissions/{lang}', 'Security\RolesController@getPermissions');
        Route::get('roles/users/{id}', 'Security\RolesController@getUsers');

        //financial
        Route::match(['get', 'post'],"financial/setting","Financial\SettingController@index")->name("master.financial.setting");

        Route::get('admins', 'Security\AdminController@index')->name('master.admins');
        Route::get('admins/create', 'Security\AdminController@create')->name('master.admins.create');
        Route::post('admins/store', 'Security\AdminController@store')->name('master.admins.store');
        Route::get('admins/{user}/edit', 'Security\AdminController@edit')->name('master.admins.edit');
        Route::patch('admins/{user}', 'Security\AdminController@update')->name('master.admins.update');
        Route::post('admins/{user}/change_password', 'Security\AdminController@changePassword')->name('master.admins.change_password');
        Route::delete('admins/{user}', 'Security\AdminController@destroy')->name('master.admins.destroy');
        Route::post('admins/change_status', 'Security\AdminController@changeStatus')->name('master.admins.changeStatus');

        Route::get('settings/sliders', 'SiteSettings\SliderController@index')->name('master.sliders.index');
        Route::post('settings/sliders/store', 'SiteSettings\SliderController@store')->name('master.sliders.store');
        Route::post('settings/sliders/update', 'SiteSettings\SliderController@update')->name('master.sliders.update');
        Route::get('settings/sliders/get/lang/value', 'SiteSettings\SliderController@getLangValue')->name('master.sliders.lang');
        Route::post('settings/sliders/lang/store', 'SiteSettings\SliderController@storelangTranslation')->name('master.sliders.lang.store');
        Route::delete('settings/sliders/{id}', 'SiteSettings\SliderController@delete')->name('master.sliders.destroy');

        Route::get('settings/countries', 'SiteSettings\CountryController@index')->name('master.country.index');
        Route::post('settings/country/store', 'SiteSettings\CountryController@store')->name('master.country.store');
        Route::post('settings/country/update', 'SiteSettings\CountryController@update')->name('master.country.update');
        Route::get('settings/country/get/lang/value', 'SiteSettings\CountryController@getLangValue')->name('master.country.lang');
        Route::post('settings/country/lang/store', 'SiteSettings\CountryController@storelangTranslation')->name('master.country.lang.store');
        Route::delete('settings/country/{id}', 'SiteSettings\CountryController@delete')->name('master.country.destroy');
        Route::get('settings/country/list', 'SiteSettings\CountryController@countryList')->name('master.country.list');

        Route::get('settings/cities', 'SiteSettings\CityController@index')->name('master.city.index');
        Route::post('settings/city/store', 'SiteSettings\CityController@store')->name('master.city.store');
        Route::post('settings/city/update', 'SiteSettings\CityController@update')->name('master.city.update');
        Route::get('settings/city/get/lang/value', 'SiteSettings\CityController@getLangValue')->name('master.city.lang');
        Route::post('settings/city/lang/store', 'SiteSettings\CityController@storelangTranslation')->name('master.city.lang.store');
        Route::delete('settings/city/{id}', 'SiteSettings\CityController@delete')->name('master.city.destroy');


        Route::resource('settings/currency', "SiteSettings\CurrencyController");
        Route::post('currency/status/{id}', "SiteSettings\CurrencyController@status");

        Route::resource('discounts', "SiteSettings\DiscountController");
        Route::post('discounts/enable/{id}', "SiteSettings\DiscountController@enable");


        Route::get('settings', 'SiteSettings\SettingsController@index')->name('master.settings.index');
        Route::post('settings', 'SiteSettings\SettingsController@store')->name('master.settings.store');
        Route::post('settings/maps', 'SiteSettings\SettingsController@maps')->name('master.settings.maps');

        // Route::get('settings/tags', 'SiteSettings\SettingsController@get_tags')->name('master.tags.index');
        // Route::post('settings/tags/store', 'SiteSettings\SettingsController@store_tag')->name('master.tags.store');
        // Route::post('settings/tags/update', 'SiteSettings\SettingsController@update')->name('master.tags.update');
        // Route::delete('settings/tags/{id}', 'SiteSettings\SettingsController@delete')->name('master.tags.destroy');

        Route::resource('settings/tags', 'SiteSettings\TagsController');
         Route::post('settings/tags/{id}/trans', 'SiteSettings\TagsController@trans');


        Route::get('settings/footers', 'SiteSettings\FooterController@index')->name('master.footer.index');
        Route::post('settings/footer/store', 'SiteSettings\FooterController@store')->name('master.footer.store');
        Route::post('settings/footer/update', 'SiteSettings\FooterController@update')->name('master.footer.update');
        Route::get('settings/footer/get/lang/value', 'SiteSettings\FooterController@getLangValue')->name('master.footer.lang');
        Route::post('settings/footer/lang/store', 'SiteSettings\FooterController@storelangTranslation')->name('master.footer.lang.store');
        Route::delete('settings/footer/{id}', 'SiteSettings\FooterController@delete')->name('master.footer.destroy');
        Route::get('settings/footer/sort', 'SiteSettings\FooterController@sort')->name('master.footer.sort');
        Route::get('settings/footer/{id}', 'SiteSettings\FooterController@get');

        Route::get('contacts', 'SiteSettings\ContactsController@index')->name('master.contact.index');
        Route::get('contacts/{id}/show', 'SiteSettings\ContactsController@show')->name('master.contact.show');
        Route::delete('contacts/{id}', 'SiteSettings\ContactsController@delete')->name('master.contact.destroy');

        Route::get('settings/work_methods', 'SiteSettings\WorkMethodController@index')->name('master.work_method.index');
        Route::post('settings/work_method/store', 'SiteSettings\WorkMethodController@store')->name('master.work_method.store');
        Route::post('settings/work_method/update', 'SiteSettings\WorkMethodController@update')->name('master.work_method.update');
        Route::get('settings/work_method/get/lang/value', 'SiteSettings\WorkMethodController@getLangValue')->name('master.work_method.lang');
        Route::post('settings/work_method/lang/store', 'SiteSettings\WorkMethodController@storelangTranslation')->name('master.work_method.lang.store');
        Route::delete('settings/work_method/{id}', 'SiteSettings\WorkMethodController@delete')->name('master.work_method.destroy');
        Route::get('settings/work_method/sort', 'SiteSettings\WorkMethodController@sort')->name('master.work_method.sort');


        Route::get('blog_categories', 'Blogs\BlogCategoryController@index')->name('master.blog_category.index');
        Route::post('blog_categories/store', 'Blogs\BlogCategoryController@store')->name('master.blog_category.store');
        Route::post('blog_categories/update', 'Blogs\BlogCategoryController@update')->name('master.blog_category.update');
        Route::get('blog_categories/get/lang/value', 'Blogs\BlogCategoryController@getLangValue')->name('master.blog_category.lang');
        Route::post('blog_categories/lang/store', 'Blogs\BlogCategoryController@storelangTranslation')->name('master.blog_category.lang.store');
        Route::delete('blog_categories/{id}', 'Blogs\BlogCategoryController@delete')->name('master.blog_category.destroy');


        Route::resource('blogs', 'Blogs\BlogController');

       // Route::get('blogs', 'Blogs\BlogController@index')->name('master.blogs.index');
        //Route::post('blogs/store', 'Blogs\BlogController@store')->name('master.blogs.store');
        Route::post('blogs/update', 'Blogs\BlogController@update')->name('master.blogs.update');
        Route::get('blogs/get/lang/value', 'Blogs\BlogController@getLangValue')->name('master.blogs.lang');
        Route::post('blogs/lang/store', 'Blogs\BlogController@storelangTranslation')->name('master.blogs.lang.store');
        Route::delete('blogs/{id}', 'Blogs\BlogController@delete')->name('master.blogs.destroy');
        Route::get('blogs/urls/{id}', 'Blogs\BlogController@blogUrls')->name('master.blogs.urls');
        Route::post('blogs/urls/{id}/store', 'Blogs\BlogController@blogUrlsStore')->name('master.blogs.urls.store');
        Route::get('blogs/comments/{id}', 'Blogs\BlogController@blogComments')->name('master.blogs.comments');
        Route::get('blogs/comments/approve/{id}', 'Blogs\BlogController@blogCommentApproval')->name('master.blogs.comments.approve');
        Route::get('blogs/comments/destroy/{id}', 'Blogs\BlogController@blogCommentDestroy')->name('master.blogs.comments.destroy');


        Route::get('complaint/type/get/lang/value', 'Complaints\ComplaintTypeController@getLangValue')->name('master.complaint_type.lang');
        Route::post('complaint/type/lang/store', 'Complaints\ComplaintTypeController@storelangTranslation')->name('master.complaint_type.lang.store');
        Route::resource('complaint/types', 'Complaints\ComplaintTypeController');


        Route::resource('complaint/status', 'Complaints\ComplaintStatusController');
        Route::get('complaint/status/get/lang/value', 'Complaints\ComplaintStatusController@getLangValue')->name('master.complaint_status.lang');
        Route::post('complaint/status/lang/store', 'Complaints\ComplaintStatusController@storelangTranslation')->name('master.complaint_status.lang.store');


        Route::get('complaints', 'Complaints\ComplaintsController@index')->name('master.complaints.index');
        Route::get('complaint/{id}', 'Complaints\ComplaintsController@show')->name('master.complaints.show');
        Route::post('complaint/reply', 'Complaints\ComplaintsController@reply')->name('master.complaints.reply');
        Route::post('complaint/{id}/status', 'Complaints\ComplaintsController@status')->name('master.complaints.status');

        // Route::get('project/status','Projects\ProjStatusController@index')->name('master.proj_status.index');
        // Route::post('project/status/store','Projects\ProjStatusController@store')->name('master.proj_status.store');
        // Route::post('project/status/update','Projects\ProjStatusController@update')->name('master.proj_status.update');
        // Route::delete('project/status/{id}', 'Projects\ProjStatusController@delete')->name('master.proj_status.destroy');

        Route::resource('project/category', 'Projects\ProjCategoryController',['only' => ['index', 'store',"edit"]]);

        // Route::get('project/category', 'Projects\ProjCategoryController@index')->name('master.proj_category.index');
        // Route::post('project/category/store', 'Projects\ProjCategoryController@store')->name('master.proj_category.store');
        Route::post('project/category/update', 'Projects\ProjCategoryController@update')->name('master.proj_category.update');
        Route::get('project/category/get/lang/value', 'Projects\ProjCategoryController@getLangValue')->name('master.proj_category.lang');
        Route::post('project/category/lang/store', 'Projects\ProjCategoryController@storelangTranslation')->name('master.proj_category.lang.store');
        Route::delete('project/category/{id}', 'Projects\ProjCategoryController@delete')->name('master.proj_category.destroy');
        Route::get('project/category/parent', 'Projects\ProjCategoryController@get_parent')->name('master.proj_category.get_parent');
        Route::resource('project/{category}/cat_attr', 'Projects\ProjCategoryAttrController');
        Route::post('project/{category}/cat_attr/up/{id}', 'Projects\ProjCategoryAttrController@up');
        Route::post('project/{category}/cat_attr/down/{id}', 'Projects\ProjCategoryAttrController@down');
        Route::post('project/{category}/cat_attr/save', 'Projects\ProjCategoryAttrController@save');

        Route::resource('project/{category}/cat_attr2', 'Projects\ProjCategoryAttr2Controller');
        Route::post('project/{category}/cat_attr2/up/{id}', 'Projects\ProjCategoryAttr2Controller@up');
        Route::post('project/{category}/cat_attr2/down/{id}', 'Projects\ProjCategoryAttr2Controller@down');
        Route::post('project/{category}/cat_attr2/save', 'Projects\ProjCategoryAttr2Controller@save');

        //Route::post('project/{category}/cat_attr/pay', 'Projects\ProjCategoryAttrController@pay');

        Route::get('projects', 'Projects\ProjectController@index')->name('master.projects.index');
        Route::get('project/{id}/edit', 'Projects\ProjectController@edit')->name('master.projects.edit');
        Route::get('project/{id}/show', 'Projects\ProjectController@show')->name('master.projects.show');
        Route::get('bid/{id}/show', 'Projects\ProjectController@showBid')->name('master.bid.show');
        Route::resource('requests', 'Projects\RequestsController',['only' => ['index', 'show',"update"]]);
        Route::post('trusted', 'SiteSettings\SettingsController@trusted');

        Route::post('logo', 'SiteSettings\SettingsController@logo');

        Route::post('settings/onrequest', 'SiteSettings\SettingsController@onrequest');
        Route::post('settings/intro', 'SiteSettings\SettingsController@intro');



        // Route::post('project/{id}/update','Projects\ProjectController@update')->name('master.projects.update');
        Route::delete('project/{id}', 'Projects\ProjectController@destroy')->name('master.projects.destroy');


        // Route::get('bid/status', 'ProjectBids\BidStatusController@index')->name('master.bid_status.index');
        // Route::post('bid/status/store', 'ProjectBids\BidStatusController@store')->name('master.bid_status.store');
        // Route::post('bid/status/update', 'ProjectBids\BidStatusController@update')->name('master.bid_status.update');
        // Route::delete('bid/status/{id}', 'ProjectBids\BidStatusController@delete')->name('master.bid_status.destroy');

        Route::get('commissions', 'SiteSettings\CommissionController@index')->name('master.commission.index');
        Route::post('commissions/store', 'SiteSettings\CommissionController@store')->name('master.commission.store');
        Route::post('commissions/update', 'SiteSettings\CommissionController@update')->name('master.commission.update');
        Route::delete('commissions/{id}', 'SiteSettings\CommissionController@delete')->name('master.commission.destroy');


        // Route::get('buyers', 'Users\BuyerController@index')->name('master.buyers.index');
        // Route::get('buyers/{user}/edit', 'Users\BuyerController@edit')->name('master.buyers.edit');
        // Route::patch('buyers/{user}', 'Users\BuyerController@update')->name('master.buyers.update');
        // Route::delete('buyers/{user}', 'Users\BuyerController@destroy')->name('master.buyers.destroy');

        Route::get('users', 'Users\FreelancerController@index')->name('master.freelancers.index');
        Route::get('users/{user}/edit', 'Users\FreelancerController@edit')->name('master.freelancers.edit');
        Route::patch('users/{user}', 'Users\FreelancerController@update')->name('master.freelancers.update');
        Route::delete('users/{user}', 'Users\FreelancerController@destroy')->name('master.buyers.destroy');
        Route::get('freelancers/trusted', 'Users\FreelancerController@getTrustedRequests');
        Route::get('freelancers/{id}/trust', 'Users\FreelancerController@trust');
        Route::post('freelancers/{id}/trust', 'Users\FreelancerController@approveTrust');
        Route::delete('freelancers/{id}/trust', 'Users\FreelancerController@removeTrusted');

        Route::get('profile', 'Users\ProfileController@get_profile')->name('master.profile.get');
        Route::post('profile', 'Users\ProfileController@update_profile')->name('master.profile.update');
        Route::post('profile/change_password', 'Users\ProfileController@changePassword')->name('master.profile.change_password');

        Route::get('skills', 'Skills\SkillsController@index')->name('master.skills.index');
        Route::post('skills/store', 'Skills\SkillsController@store')->name('master.skills.store');
        Route::get('skills/get/lang/value', 'Skills\SkillsController@getLangValue')->name('master.skills.lang');
        Route::post('skills/lang/store', 'Skills\SkillsController@storelangTranslation')->name('master.skills.lang.store');
        Route::delete('skills/{id}', 'Skills\SkillsController@delete')->name('master.skills.destroy');
        Route::resource('transactions', 'Transactions\TransactionController',['only' => ['index', 'show']]);


        Route::get('notifications', 'Notifications\NotificationsController@index');
        Route::post('notifications/{id}/read', 'Notifications\NotificationsController@read');
        Route::delete('notifications/{id}/delete', 'Notifications\NotificationsController@destroy');
        Route::delete('notifications/delete', 'Notifications\NotificationsController@destroyAll');
        Route::post('notifications/read', 'Notifications\NotificationsController@readAll');

        Route::resource('company', 'Company\ManagementController',["except" => ["store","create"]]);
        Route::post('company/{id}/activate', 'Company\ManagementController@activate');
    });
});
