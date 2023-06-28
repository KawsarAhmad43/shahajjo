<?php

namespace App\Helpers;

use App\Models\System\Menu;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class Module
{
    // ------------------------------------------------------
    // CHECK MODEL EXIST
    // ------------------------------------------------------
    public static function check($request)
    {
        $model_name = $request->model_name.'.php';
        $models = self::getModelsList();

        if (! empty($models)) {
            foreach ($models as $model) {
                $explode = explode('\\', (string) $model);
                $index = count($explode) - 1;
                $modelName = $explode[$index].'.php';

                if ($modelName === $model_name) {
                    return response()->json(true);
                }

            }
        }

        return response()->json(false);
    }

    // ------------------------------------------------------
    // MODULE CREATE FILE
    // ------------------------------------------------------
    public static function createFile($name, $is_only_model = 0)
    {
        if ($is_only_model == '1') {
            Artisan::call('make:model', ['name' => $name, '-m' => 'default']);
        } else {
            // CREATE A NEW MODEL/CONTROLLER/RESOURCE/DATABASE/FACTORY FILE
            Artisan::call('make:model', ['name' => $name, '-a' => 'default']);
            // Artisan::call('make:resource', ['name' => $name . 'Resource', '--collection' => 'default']);

            // -------------FILE DELETE-------------
            File::delete(base_path('database/seeders/'."{$name}Seeder.php"));
            File::delete(base_path('database/factories/'."{$name}Factory.php"));
            File::delete(base_path('app/Http/Requests/'."Store{$name}Request.php"));
            File::delete(base_path('app/Http/Requests/'."Update{$name}Request.php"));
            File::delete(base_path('app/Policies/'."{$name}Policy.php"));

            // -------------ROUTE CREATE-------------
            self::routeCreate($name);

            // -------------MOVE CONTROLLER-------------
            self::moveController($name.'Controller');

            // -------------CREATE VUE FILES-------------
            Artisan::call('make:vue-create', ['name' => $name.'.Create']);
            Artisan::call('make:vue-index', ['name' => $name.'.Index']);
            Artisan::call('make:vue-view', ['name' => $name.'.View']);

            // -------------MENU CREATE-------------
            self::createMenu($name);
        }

        return response()->json(true);
    }

    // ------------------------------------------------------
    // ROUTE CREATE
    // ------------------------------------------------------
    protected static function routeCreate($name)
    {
        $route = lcfirst($name);
        $controller = "App\Http\Controllers\Admin\\".$name.'Controller::class';
        file_put_contents(
            base_path('routes/admin.php'),
            "Route::resource('$route', $controller);",
            FILE_APPEND
        );
    }

    // ------------------------------------------------------
    // MOVE TO CONTROLLER ONE FOLDER TO ANOTHER FOLDER
    // ------------------------------------------------------
    protected static function moveController($controller)
    {
        File::move(app_path('Http/Controllers/'.$controller.'.php'), app_path('Http/Controllers/Admin/'.$controller.'.php'));

        // $oldPath     = str_replace("'", "", app_path() . "'\Http\Controllers\'" . $controller . ".php");
        // $newPath     = str_replace("'", "", app_path() . "'\Http\Controllers\Backend\'" . $controller . ".php");

        // rename($oldPath, $newPath);
    }

    /* ------------MENU CREATE------------ */
    protected static function createMenu($name)
    {
        $arr = [
            'menu_name' => $name,
            'icon' => "<i class='fa fa-circle-o text-aqua'></i>",
            'route_name' => lcfirst($name).'.index',
            'params' => null,
            'sorting' => 0,
            'show_dasboard' => 0,
        ];
        Menu::create($arr);
        Cache::forget('side_menu_cache');
    }

    // ------------------------------------------------------
    // FOLDER PATH
    // ------------------------------------------------------
    public static function folderPath($name = null)
    {
        return [
            'name' => $name,
            'route' => lcfirst($name),
            'model' => 'app/Model/Backend/'.$name.'.php',
            'controller' => 'app/Http/Controllers/'.$name.'Controller.php',
            'resource' => 'app/Http/Resources/Resource.php',
            'database' => 'database/migrations',
            'vue_file' => 'resources/js/views/backend/'.ucfirst($name).'/Create.vue, Index.vue, View.vue',
        ];
    }

    // ------------------------------------------------------
    // GET MODELs LIST
    // ------------------------------------------------------
    protected static function getModelsList()
    {
        $appNamespace = 'App\\';
        $modelNamespace = 'Models';

        return collect(File::allFiles(app_path($modelNamespace)))->map(function ($item) use ($appNamespace, $modelNamespace) {
            $rel = $item->getRelativePathName();
            $class = sprintf(
                '\%s%s%s',
                $appNamespace,
                $modelNamespace ? $modelNamespace.'\\' : '',
                implode('\\', explode('/', substr($rel, 0, strrpos($rel, '.'))))
            );

            return class_exists($class) ? $class : null;
        })->filter();
    }
}
