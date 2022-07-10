<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class Helpers
{
    public function unique_id($l = 32)
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public function uploadImage($image, $path)
    {
        $extension = $image->extension();
        $id = Str::random(8);
        $image_name = $id . '.' . $extension;
        $image->move(public_path("uploads/{$path}"), $image_name);

        return $image_name;
    }
}
