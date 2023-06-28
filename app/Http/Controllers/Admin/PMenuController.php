<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PMenuController extends Controller
{
    public function content()
    {
        return view('layouts.admin_app');
    }

    public function galleryImages()
    {
        return view('layouts.admin_app');
    }
}
