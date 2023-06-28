<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website;

use App\Models\Base\BaseModel;
use App\Models\Website\Content\Content;
use Illuminate\Support\Str;

class FrontMenu extends BaseModel
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($menu) {
            $menu->slug = FrontMenu::createSlug($menu->title);
        });
    }

    public static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = FrontMenu::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug.$count;
        }

        return $slug;
    }

    public function parent()
    {
        return $this->belongsTo(FrontMenu::class, 'parent_id', 'id')->select(
            'id',
            'parent_id',
            'title',
            'slug',
            'params',
            'url'
        );
    }

    public function childs()
    {
        return $this->hasMany(FrontMenu::class, 'parent_id', 'id');
    }

    /**
     * Get the content for this model.
     *
     * @return App\Content
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function childrenMenus()
    {
        return $this->hasMany(FrontMenu::class, 'parent_id', 'id')->select(
            'id',
            'parent_id',
            'title',
            'slug',
            'type',
            'params',
            'url'
        );
    }

    public function allChildrenMenus()
    {
        return $this->childrenMenus()->with('allChildrenMenus')->oldest('sorting')->select(
            'id',
            'parent_id',
            'title',
            'slug',
            'type',
            'params',
            'url'
        );
    }

    public static function parentMenus()
    {
        return FrontMenu::where('parent_id', null)->pluck('name', 'id')->oldest('sorting')->toArray();
    }

    public static function getMenuList()
    {
        $parentMenus = FrontMenu::with('childs')->whereNull('parent_id')->oldest('sorting')->get();
        $Menus = FrontMenu::recursiveMenuList($parentMenus);

        return $Menus;
    }

    public static function recursiveMenuList($datas)
    {
        static $menus = [];
        static $level = 0;
        $level++;
        if (isset($datas)) {
            foreach ($datas as $desiglist) {
                if (! empty($desiglist['childs'])) {
                    $arr = ['id' => $desiglist['id'], 'name' => str_repeat('|__', $level - 1).$desiglist['title']];
                    $menus[] = $arr;

                } else {
                    $arr = ['id' => $desiglist['id'], 'name' => str_repeat('|__', $level - 1).$desiglist['title']];
                    $menus[] = $arr;
                }
                FrontMenu::recursiveMenuList($desiglist['childs']);
            }
        }
        $level--;

        return $menus;
    }

    // get menus for home page
    public static function getMenus()
    {
        return FrontMenu::select(
            'id',
            'parent_id',
            'title',
            'url',
            'slug',
            'menu_look_type'
        )->where('parent_id', null)
            ->active()
            ->where('position', 'header')
            ->with('allChildrenMenus')
            ->oldest('sorting')
            ->limit(7)
            ->get()->toArray();
    }

    // get parent id / /title for home page
    public static function getParentMenu($field, $type)
    {
        $menu = FrontMenu::select('parent_id')
            ->where($field, $type)->active()
            ->where('sorting', 'header')->first();
        if (! empty($menu)) {
            $title = FrontMenu::where('id', $menu->parent_id)
                ->select('title')->active()
                ->where('sorting', 'header')->first();
            $data['title'] = $title->title;
        }
        $data['parent_id'] = $menu->parent_id;

        return $data;
    }

    // get left menus for home page
    public static function getLeftMenus($parent_id)
    {
        return FrontMenu::select(
            'parent_id',
            'title',
            'slug',
            'type',
            'params',
            'url'
        )->where('parent_id', $parent_id)
            ->active()
            ->where('sorting', 'header')
            ->oldest('sorting')->get();
    }
}
