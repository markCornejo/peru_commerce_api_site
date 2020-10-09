<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Imagee;

class FileImageService
{

    /**
     * crear imagen logo
     *
     * @param  string $image
     * @param  string $name
     * @param  string $orientation
     * @return boolean
     */
    public function imagecreatelogo(string $image, string $name, $orientation) {
        $sizes = config('services.image.size');
        $directory = config('services.image.url');
        return $this->image($image, $name, $orientation, $sizes, $directory);
    }

    /**
     * delete imagen logo
     *
     * @param  string $name
     * @return void
     */
    public function imagedeletelogo($name) {
        $sizes = config('services.image.size');
        $directory = config('services.image.url');
        return $this->delete($name, $sizes, $directory);
    }

    /**
     * generar carpetas para la imagenes
     *
     * @param  string $image, url  o base64
     * @param  string $name, nombre de la imagen
     * @param  string $orientation, mantener una relación respecto al horizontal 'h', vertical 'v', ambos 'o'
     * @param  array $sizes, tamaños
     * @param  string $directory
     * @return string
     */
    public function image(string $image, string $name, $orientation, $sizes, $directory) {
        // $name = strtolower(Str::random(20)).'_'.$name; // renombrar
        $info = getimagesize($image);
        $gif = strpos($info["mime"], 'gif');
        // $oritation = config('services.image.logo.oritation');
        foreach ($sizes as $key => $value) {

            if($orientation == 'h') {
                $ori_value = $value;
                $this->storage($image, $ori_value, null, $value, $name, $directory); // generar imagen
            }

            if($orientation == 'v') {
                $ori_value = $value;
                $this->storage($image, null, $ori_value, $value, $name, $directory); // generar imagen
            }

            if($orientation == 'o') {
                $ori_value = $value;
                $this->storage($image, $ori_value, $ori_value, $value, $name, $directory); // generar imagen
            }

        }

        if($gif !== false) {
            $this->storagegif($name, $image, $directory);
        }

        return true;

    }


    /**
     * eliminar imagenes
     *
     * @param  string $name
     * @param  array $sizes
     * @param  string $directory
     * @return boolean
     */
    public function delete($name, $sizes, $directory) {
        foreach ($sizes as $key => $size) {
            Storage::delete($directory.'/'.$size.'/'.$name);
        }

        $gif = substr($name, -4);
        if(@$gif === ".gif") {
            Storage::delete($directory.'/'.$name);
        }

        return true;
    }

    /**
     * storage
     *
     * @param  string $image , url de la imagen e.g. http://midominio.com/miimagen
     * @param  int $value1 , tamaño
     * @param  int $value2 , tamaño
     * @param  int $size , tamaño
     * @param  string $name_type , nombre de la imagen
     * @param  string $directory , url principal
     *
     */
    public function storage($image, $value1, $value2, int $size, $name_type, $directory) {

        Storage::makeDirectory($directory.'/'.$size);
        $image =  Imagee::make($image)->resize($value1, $value2, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($directory.'/'.$size.'/'.$name_type, (string) $image->encode());

    }

    public function storagegif($name, $image, $directory) {
        Storage::makeDirectory($directory);
        Storage::put($directory.'/'.$name, /*(string) $image*/ file_get_contents($image));
    }


}
