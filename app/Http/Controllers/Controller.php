<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function setIfNotEmpty($object, $key, $value)
    {
        if (!empty($value)) {
            $object->$key = $value;
        }
    }
}
