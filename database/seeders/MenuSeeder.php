<?php

namespace Database\Seeders;

use App\Models\Website\FrontMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        $count = DB::table('menus')->count();
        if ($count == 0) {
            $menus = [
                [
                    'menu_name' => 'Admin',
                    'icon' => "<i class='fa fa-user'></i>",
                    'route_name' => 'admin.index',
                    'params' => null,
                    'show_dasboard' => 0,
                ],
                [
                    'menu_name' => 'Master Setup',
                    'icon' => "<i class='fab fa-mastodon'></i>",
                    'route_name' => null,
                    'params' => null,
                    'show_dasboard' => 0,
                    'children' => [
                        [
                            'menu_name' => 'Category',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'category.index',
                            'show_dasboard' => 0,
                        ],

                    ],
                ],
                [
                    'menu_name' => 'Contents',
                    'icon' => "<i class='fa fa-windows'></i>",
                    'route_name' => null,
                    'params' => null,
                    'show_dasboard' => 0,
                    'children' => [
                        [
                            'menu_name' => 'Content List',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'content.index',
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'About Us',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'content.edit',
                            'params' => 'about-us',
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
                [
                    'menu_name' => 'Website',
                    'icon' => "<i class='fas fa-globe'></i>",
                    'route_name' => null,
                    'params' => null,
                    'show_dasboard' => 0,
                    'children' => [
                        [
                            'menu_name' => 'Notice',
                            'icon' => "<i class='fab fa-leanpub'></i>",
                            'route_name' => 'notice.index',
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Event',
                            'icon' => "<i class='fas fa-snowflake'></i>",
                            'route_name' => 'events.index',
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Faq',
                            'icon' => "<i class='fas fa-book-open'></i>",
                            'route_name' => 'faq.index',
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Contact Us',
                            'icon' => "<i class='fas fa-address-book'></i>",
                            'route_name' => 'contacts.index',
                            'show_dasboard' => 0,
                        ],

                    ],
                ],
                [
                    'menu_name' => 'News',
                    'icon' => "<i class='fa fa-newspaper-o'></i>",
                    'route_name' => 'news.index',
                    'params' => null,
                    'show_dasboard' => 1,
                ],
                [
                    'menu_name' => 'Profile',
                    'icon' => "<i class='fa fa-user-o'></i>",
                    'route_name' => 'profile.index',
                    'params' => null,
                    'show_dasboard' => 0,
                ],
                [
                    'menu_name' => 'Gallery / Images',
                    'icon' => "<i class='fa fa-windows'></i>",
                    'route_name' => null,
                    'params' => null,
                    'show_dasboard' => 0,
                    'children' => [
                        [
                            'menu_name' => 'Albums',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'album.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Photos',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'photo.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Videos',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'video.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Sliders',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'slider.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
                [
                    'menu_name' => 'System Settings',
                    'icon' => "<i class='fa fa-windows'></i>",
                    'route_name' => null,
                    'params' => null,
                    'show_dasboard' => 0,
                    'children' => [
                        [
                            'menu_name' => 'Role',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'role.index',
                            'params' => null,
                            'show_dasboard' => 1,
                        ],
                        [
                            'menu_name' => 'Menu List',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'menu.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Website Menu List',
                            'icon' => "<i class='fa fa-list text-aqua'></i>",
                            'route_name' => 'frontMenu.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Site Settings',
                            'icon' => "<i class='fa fa-cog text-aqua'></i>",
                            'route_name' => 'siteSetting.index',
                            'params' => null,
                            'show_dasboard' => 1,
                        ],
                        [
                            'menu_name' => 'Activity Log',
                            'icon' => "<i class='fa fa-history'></i>",
                            'route_name' => 'activityLog.index',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                        [
                            'menu_name' => 'Module Create',
                            'icon' => "<i class='fa fa-folder text-aqua'></i>",
                            'route_name' => 'module.create',
                            'params' => null,
                            'show_dasboard' => 0,
                        ],
                    ],
                ],
            ];

            $this->insertMenuItems($menus, null);
            $this->seedWebsiteMenus();
        }
    }

    /**
     * Insert seed data into backend menu.
     *
     * @param [type] $menuItems
     * @param [type] $parentId
     * @return void
     */
    private function insertMenuItems($menuItems, $parentId)
    {
        if (is_array($menuItems) && count($menuItems) > 0) {
            foreach ($menuItems as $key => $item) {
                $children = $item['children'] ?? [];
                unset($item['children']);

                $item['sorting'] = $key;
                $item['parent_id'] = $parentId;
                $id = DB::table('menus')->insertGetId($item);

                if (is_array($children) && count($children) > 0) {
                    $this->insertMenuItems($children, $id);
                }
            }
        }
    }

    /**
     * Insert front seed menu.
     *
     * @return void
     */
    private function seedWebsiteMenus()
    {
        $menus = [
            [
                'menu_look_type' => 'normal',
                'position' => 'header',
                'title' => 'About us',
                'slug' => 'about-us',
                'url' => '#',
                'status' => 'active',
                'type' => 'outside_website',
            ],
            [
                'menu_look_type' => 'normal',
                'position' => 'header',
                'title' => 'Faq',
                'slug' => 'faq',
                'url' => '#',
                'status' => 'active',
                'type' => 'outside_website',
            ],
            [
                'menu_look_type' => 'normal',
                'position' => 'header',
                'title' => 'Contact us',
                'slug' => 'contact-us',
                'url' => '#',
                'status' => 'active',
                'type' => 'outside_website',
            ],
        ];

        foreach ($menus as $menu) {
            FrontMenu::create($menu);
        }
    }
}
