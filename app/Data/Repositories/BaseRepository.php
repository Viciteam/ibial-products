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

    public function insertData($data, $model)
    {
        $prods = $this->business_model->init($data);

        if (!$prods->validate($data)) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on validate';
        }

        // region Data insertion
        if (!$prods->save()) {
            $errors = $prods->getErrors();
            // dump($errors);
            // return 'error on saving';
        }

        return true;
    }

}
