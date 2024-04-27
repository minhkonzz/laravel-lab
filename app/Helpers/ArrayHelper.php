<?php 

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ArrayHelper 
{
    public static function handle1(array|Collection $arr, array $keys = ['id', 'name'])
    {
        if (count($keys) != 2) 
        {
            throw new InvalidArgumentException("Keys array must have exactly 2 elements.");
        }

        list($keyField, $valueField) = $keys;

        $result = [];
        foreach ($arr as $item) {
            if (isset($item[$keyField]) && isset($item[$valueField])) 
            {
                $result[$item[$keyField]] = $item[$valueField];
            } else 
            {
                throw new InvalidArgumentException("Item must contain key and value fields.");
            }
        }

        return $result;
    }
}