<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Website\Gallery\Slider;
use Illuminate\Support\Facades\App;

class LibController extends Controller
{
    private $variable = [];

    private function index()
    {
        return [
            'variable' => $this->variable,
        ];
    }

    /**
     * SYSTEMS DATA RETURN
     */
    public function systems()
    {
        return [
            'global' => $this->index(),
            'permissions' => App::make('premitedMenuArr'),
            'site' => App::make('siteSettingObj'),
            'menus' => App::make('sideMenus'),
            'sliderPosition' => $this->sliderPostionList(),
            'sliderLists' => Slider::get(),
            'sliderButtonTypes' => $this->sliderButtonTypes(),

        ];
    }

    /**
     * Slider button list
     *
     * @return array
     */
    public function sliderButtonTypes()
    {
        return [
            'Inside',
            'Outside',
        ];
    }

    /**
     * Slider position list
     *
     * @return array
     */
    public function sliderPostionList()
    {
        return [
            'Header',
            'Footer',
        ];
    }
}
