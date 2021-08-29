<?php

use Carbon\Carbon;

if (!function_exists('fileUpload')) {

    function fileUpload($file = null, $destinationPath = 'uploads')
    {
        $fileName = Carbon::now()->timestamp.".".$file->extension();
        if (!$file->move($destinationPath, $fileName)) {
            return false;
        };
        return $destinationPath . '/' . $fileName;
    }
}

