<?php


namespace App\Validators;


class SearchFormValidator
{
    /**
     * @return array
     */
    public static function validateData()
    {
        return request()->validate([
            'owner'       => 'max:20|required_without_all:rname,description,language',
            'name'        => 'max:40|required_without_all:owner,description,language',
            'description' => 'max:64|required_without_all:owner,rname,language',
            'language'    => 'required_without_all:owner,rname,description',
        ]);
    }
}
