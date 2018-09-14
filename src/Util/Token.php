<?php

namespace MichaelDouglas\MService\Util;

class Token
{
    /**
     * generates random strings. Can generate unique strings by passing a
     * fully namespaced model class and field name to check against.
     * @param  integer $length     Length of string to be generated. max 64
     * @param  [type]  $modelClass fully namespaced model class to check unique
     * @param  [type]  $fieldName  field name to check unique in model
     * @return [type]              random/unique string of specified length
     */
    public static function generate($length=64, $modelClass = null, $fieldName=null)
    {
        $token = substr(\Illuminate\Support\Facades\Password::getRepository()->createNewToken(), 0, $length);

        if ($modelClass && $fieldName) {
            if ($modelClass::where($fieldName, '=', $token)->exists()) {
                //Model Found -- call self.
                self::generate($length, $modelClass, $fieldName);
            } else {
                //Model Not found. is uinque
                return $token;
            }
        } else {
            return $token;
        }
    }

}