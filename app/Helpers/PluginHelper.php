<?php

/**
 * @Ahmad shofiq, Git: Ashofiq
 */

namespace App\Helpers;

use ZipArchive;

class PluginHelper
{
    // move file
    public static function moveFileTodirectory($request)
    {
        // request File extract and get foldername
        $fileName = self::extractAndGetFile($request);

        // scan extract file and get all folder
        $dir = self::getFiles(base_path("public/$fileName"));
        $uploadFolderName = $fileName;
        $modelName = str_replace('.php', '', implode('', self::getFiles(base_path('/')."public/$fileName/model")));
        foreach ($dir as $key => $value) {
            $viewdir = self::getFiles(base_path("public/$uploadFolderName/$value"));
            $destinationRoute = self::getDesName($rootName = $value, $uploadFolderName);
            self::moveViewFile($viewdir, $uploadFolderName, $toFolderName = $value, $destinationRoute);
        }
    }

    // get Destination route
    public static function getDesName($rootName, $uploadFolderName)
    {
        $des = '';
        if ($rootName == 'views') {
            $des = base_path()."/resources/js/views/admin/$uploadFolderName";
        } elseif ($rootName == 'controller') {
            $des = base_path().'/app/Http/Controllers/Admin';
        } elseif ($rootName == 'database') {
            $des = base_path().'/database/migrations';
        } elseif ($rootName == 'model') {
            $des = base_path().'/app/Models';
        }

        return $des;
    }

    // move view file to js/views/admin/{folder_name}
    public static function moveViewFile($viewdir, $uploadFolderName, $toFolderName, $destinationRoute)
    {

        foreach ($viewdir as $vkey => $vDir) {
            $srcFolder = base_path()."/public/$uploadFolderName/$toFolderName/$vDir";
            // only for view
            self::makeDirectory($uploadFolderName);
            // $desninationFolder = base_path() . "/resources/js/views/admin/$uploadFolderName/$vDir";
            $desninationFolder = $destinationRoute.'/'.$vDir;
            // return [$srcFolder, $desninationFolder];
            copy($srcFolder, $desninationFolder);
        }
    }

    // scan directory and return file or folder name
    public static function getFiles($directory)
    {
        $viewdir = scandir($directory, 1);
        unset($viewdir[count($viewdir) - 1]);
        unset($viewdir[count($viewdir) - 1]);

        return $viewdir;
    }

    // make directory if not exist
    public static function makeDirectory($name)
    {
        if (! is_dir(base_path("resources/js/views/admin/$name"))) {
            mkdir(base_path("resources/js/views/admin/$name"));
        }
    }

    // extract file
    public static function extractAndGetFile($request)
    {
        $zipfilename = $request->file('zip_file')->getClientOriginalName();
        $zip = new ZipArchive;
        $res = $zip->open(base_path().'/public/'.$zipfilename);
        if ($res === true) {
            $zip->extractTo(base_path().'/public');
            $zip->close();
        } else {
            echo 'problem';
        }

        return str_replace('.zip', '', $zipfilename);
    }
}
