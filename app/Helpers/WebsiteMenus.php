<?php

namespace App\Helpers;

use App\Models\Website\FrontMenu;

class WebsiteMenus
{
    //Frontend menu for header
    public static function menus()
    {
        $menus = FrontMenu::where('parent_id', null)
            ->where('status', 'active')
            ->orderBy('sorting')
            ->where('position', 'header')
            ->get();
        $data = [];
        foreach ($menus as $key => $menu) {
            $data[] = [
                'title' => $menu->title,
                'slug' => $menu->slug,
                'params' => $menu->params,
                'menu_look_type' => $menu->menu_look_type,
                'type' => $menu->type,
                'url' => $menu->url,
                'params' => $menu->params,
            ];
        }

        return $data;
    }
}
