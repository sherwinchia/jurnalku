<?php

namespace App\Http\Traits;

trait ImageUploader
{
    public function imagesChanged($name, $images)
    {
        $this->$name = $images;
    }
}
