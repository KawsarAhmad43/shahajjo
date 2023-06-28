<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Menu extends Model
{
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->oldest('sorting');
    }

    public function childMenus()
    {
        return $this->childs()->with('childMenus');
    }

    public static function menus()
    {
        $premitedMenuArr = App::make('premitedMenuArr');

        return Menu::whereNull('parent_id')->with(['childMenus' => function ($query) use ($premitedMenuArr) {
            $query->whereIn('route_name', $premitedMenuArr);
        }])->oldest('sorting')->get()->toArray();
    }

    public static function getMenuList()
    {
        $parent = Menu::with('childs')->where('parent_id', null)
            ->oldest('sorting')->get();
        $menus = Menu::recursiveMenuList($parent);

        return $menus;
    }

    public static function recursiveMenuList($datas)
    {
        static $menus = [];
        static $level = 0;
        $level++;
        if (! empty($datas)) {
            foreach ($datas as $desiglist) {
                if (! empty($desiglist['childs'])) {
                    $arr = ['id' => $desiglist['id'], 'name' => str_repeat('|__', $level - 1).$desiglist['menu_name']];
                    $menus[] = $arr;

                } else {
                    $arr = ['id' => $desiglist['id'], 'name' => str_repeat('|__', $level - 1).$desiglist['menu_name']];
                    $menus[] = $arr;
                }
                Menu::recursiveMenuList($desiglist['childs']);
            }
        }
        $level--;

        return $menus;
    }
}
