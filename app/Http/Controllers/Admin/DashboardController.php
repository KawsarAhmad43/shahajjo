<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System\Menu;
use App\Models\UserLoginHistory;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // Menus for dashboard.
            $menus = Menu::get();
            $dashboardMenus = Menu::query()
                ->where('show_dasboard', true)
                ->get()
                ->each(function ($menu) use ($menus) {
                    $getParentById = function ($id, $parents) {
                        $parent = $parents->firstWhere('id', $id);

                        return $parent;
                    };

                    $parent = $getParentById($menu->parent_id, $menus);

                    if (! is_null($parent)) {
                        $menu->parent_title = $parent->menu_name;
                    } else {
                        $menu->parent_title = $menu->menu_name;
                    }
                });

            // Get recent application activity.
            $activities = [];

            if (auth('admin')->user()->id == 1) {
                $activities = Activity::query()
                    ->latest()
                    ->limit(10)
                    ->get();
            } else {
                $userId = auth('admin')->user()->id;
                $activities = Activity::query()
                    ->where('causer_id', $userId)
                    ->latest()
                    ->limit(10)
                    ->get();
            }

            $loginHistories = [];

            // Get recent login information of users.
            if (auth('admin')->user()->id == 1) {
                $loginHistories = UserLoginHistory::query()
                    ->with('user')
                    ->latest()
                    ->limit(10)
                    ->get();
            } else {
                $userId = auth('admin')->user()->id;
                $loginHistories = UserLoginHistory::query()
                    ->with('user')
                    ->where('user_id', $userId)
                    ->latest()
                    ->limit(10)
                    ->get();
            }

            return [
                'dashboardMenus' => $dashboardMenus,
                'activities' => $activities,
                'loginHistories' => $loginHistories,
            ];
        }

        return view('admin.layouts.admin_app');
    }
}
