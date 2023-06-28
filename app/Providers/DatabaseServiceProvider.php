<?php

namespace App\Providers;

use App\Models\System\Menu;
use App\Models\System\RolePermission;
use App\Models\System\SiteSetting;
use App\Models\Website\FrontMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*-----SITE SETTINGS-----*/
        $this->app->singleton('siteSettingObj', function ($app) {
            return Cache::rememberForever('site_setting_cache', function () {
                $site = SiteSetting::first();

                return ! empty($site) ? $site->toArray() : [];
            });
        });

        /*-----LEFT MENUS-----*/
        $this->app->singleton('sideMenus', function ($app) {
            return Menu::menus();
        });

        /*-----PERMISSION ALL PROCESS-----*/
        $this->app->singleton('premitedMenuArr', function ($app) {
            if (Auth::check()) {
                $obj = RolePermission::permissions();
                if ($obj->count()) {
                    $allIndexes = RolePermission::permissionProcess($obj);
                }
            }

            return $allIndexes ?? [];
        });
        // For frontend menu
        $this->app->singleton('frontMenuObj', function ($app) {
            return Cache::rememberForever('front_menu_cache', function () {
                return FrontMenu::getMenus();
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
