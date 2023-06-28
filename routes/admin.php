<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:admin'], function () {

    /*-----sitemap-data-----*/
    Route::get('sitemap-data', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'sitemapData'])->name('sitemapData');

    /*-----dashboard-----*/
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    /*-----logout-----*/
    Route::post('logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');

    /*-----systems-portion-----*/
    Route::get('systems-update', [App\Http\Controllers\Admin\System\RoleController::class, 'systemsRoleUpdate']);
    Route::get('get-permissions', [App\Http\Controllers\Admin\System\RoleController::class, 'getPermissions']);
    Route::get('get-menus/{any?}', [App\Http\Controllers\Admin\System\MenuController::class, 'menus']);
    Route::get('initialize-systems', [App\Http\Controllers\Admin\System\LibController::class, 'systems']);

    /*-----catgory-type-----*/
    Route::get('get-category/{type}', [App\Http\Controllers\Admin\CategoryController::class, 'getCategory']);

    /*-----admin-portion-----*/
    Route::post('check-old-password', [App\Http\Controllers\Admin\AdminController::class, 'checkOldPassword']);
    Route::post('change-password', [App\Http\Controllers\Admin\AdminController::class, 'passwordChange']);
    Route::get('get-dashboard-menus', [App\Http\Controllers\Admin\System\MenuController::class, 'dashboardMenu']);

    /*-----module-portion-----*/
    Route::view('module', 'layouts.admin_app')->name('module.index');
    Route::get('module/check-model', [App\Http\Controllers\Admin\System\ModuleController::class, 'checkModel']);

    /* -----TABLE SORTING FOR GLOBALLY------*/
    Route::get('table-sorting', [App\Http\Controllers\Base\SortingController::class, 'sorting']);
    Route::get('get-last-sorting', [App\Http\Controllers\Base\SortingController::class, 'lastSorting']);

    /* -----Frontend Parent Menu && Content------*/
    Route::get('parent-menus', [App\Http\Controllers\Admin\Website\FrontMenuController::class, 'getParentMenu']);
    Route::get('get-content', [App\Http\Controllers\Admin\Website\ContentController::class, 'index']);
    Route::get('get-album/{type}', [App\Http\Controllers\Admin\Website\Gallery\AlbumController::class, 'album']);
    Route::get('module-delete', [App\Http\Controllers\Admin\System\ModuleController::class, 'moduleDelete'])->name('module.delete');

    /*-----slider-----*/
    Route::get('slider-height-width/{id}', [App\Http\Controllers\Admin\Website\Gallery\SliderDetailsController::class, 'heightWidth']);

    /*-----PERMITTED USER CAN ACCESS THIS PAGE-----*/
    Route::group(['middleware' => ['auth.access']], function () {

        /*-----content portion-----*/
        Route::get('content', [App\Http\Controllers\Admin\Website\ContentController::class, 'index'])->name('content.index');
        Route::post('content', [App\Http\Controllers\Admin\Website\ContentController::class, 'store'])->name('content.store');
        Route::get('content/{slug}', [App\Http\Controllers\Admin\Website\ContentController::class, 'show'])->name('content.show');
        // Route::get( 'content/create', [App\Http\Controllers\Admin\Website\ContentController::class, 'create'] )->name( 'content.create' );
        Route::get('content/{slug}/edit', [App\Http\Controllers\Admin\Website\ContentController::class, 'edit'])->name('content.edit');
        Route::get('content-file/{slug}', [App\Http\Controllers\Admin\Website\ContentController::class, 'file'])->name('content.file');
        Route::post('content-file/{content}', [App\Http\Controllers\Admin\Website\ContentController::class, 'storeFile'])->name('content.storeFile');
        Route::delete('content/{id}', [App\Http\Controllers\Admin\Website\ContentController::class, 'destroy'])->name('content.destroy');

        /*-----front-end-----*/
        Route::resource('album', App\Http\Controllers\Admin\Website\Gallery\AlbumController::class);
        Route::resource('photo', App\Http\Controllers\Admin\Website\Gallery\PhotoController::class);
        Route::resource('video', App\Http\Controllers\Admin\Website\Gallery\VideoController::class);
        Route::resource('slider', App\Http\Controllers\Admin\Website\Gallery\SliderController::class);
        Route::resource('frontMenu', App\Http\Controllers\Admin\Website\FrontMenuController::class);
        Route::resource('news', App\Http\Controllers\Admin\Website\NewsController::class);
        Route::resource('notice', App\Http\Controllers\Admin\Website\NoticeController::class);
        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('contacts', App\Http\Controllers\Admin\ContactsController::class);
        Route::resource('faq', App\Http\Controllers\Admin\FaqController::class);
        Route::resource('events', App\Http\Controllers\Admin\EventsController::class);

        /*-----slider-details-----*/
        Route::resource('slider-details', App\Http\Controllers\Admin\Website\Gallery\SliderDetailsController::class);

        /*-----module portion-----*/
        Route::match(['get', 'post'], 'module/create', [App\Http\Controllers\Admin\System\ModuleController::class, 'create'])->name('module.create');

        Route::get('sitemap-data', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'sitemapData'])->name('sitemapData');

        /*-----activity log-----*/
        Route::get('activityLog', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'index'])->name('activityLog.index');
        Route::get('activityLog/{id}', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'show'])->name('activityLog.show');
        Route::get('allRead', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'allRead'])->name('activityLog.allRead');
        Route::delete('activityLog/{id}', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'destroy'])->name('activityLog.destroy');

        /*-----admin portion-----*/
        Route::resource('role', App\Http\Controllers\Admin\System\RoleController::class);
        Route::resource('menu', App\Http\Controllers\Admin\System\MenuController::class);
        Route::resource('siteSetting', App\Http\Controllers\Admin\System\SiteSettingController::class);
        Route::resource('admin', App\Http\Controllers\Admin\AdminController::class);
        Route::get('sitemap', [App\Http\Controllers\Admin\System\ActivityLogController::class, 'sitemap'])->name('sitemap')->withOutMiddleWare('auth.access');
        Route::resource('profile', App\Http\Controllers\Admin\ProfileController::class);
        Route::resource('plugin', App\Http\Controllers\Admin\PluginController::class);

    });
});
