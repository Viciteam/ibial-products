<?php

namespace App\Data\Repositories;


/**
 * Class BaseRepository
 *
 * @package App\Data\Repositories
 */
abstract class BaseRepository
{
    public function returnToArray($data)
    {
        if($data !== NULL){
            return $data->toArray();
        } else {
            return [];
        }
    }

    public function inArray($needle, $haystack)
    {
        foreach ($haystack as $key => $value) {
            if($value == $needle){
                return true;
                break;
            }
        }

        return false;
    }

}
