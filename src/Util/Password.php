<?php

namespace MichaelDouglas\MService\Util;

/**
 * Classe Responsável por gerar um password alatorio.
 * Class Password
 * @package App\Util
 */

class Password
{

    protected $hashkeys = 'abcdefghijklmnopqrstuwxyzABCDEFGEHJKLMNOPQRSTUWXYZ1234567890';
    protected $specialChars = '!@#$%*_+';
    protected $stringSize = 6;
    protected $keyLength;

    public function __construct()
    {
        $this->keyLength = strlen($this->hashkeys);
    }


    public function generate()
    {
        $string = '';

        for ($i = 0; $i < $this->stringSize; $i++) {
            $string .= $this->hashkeys[rand(0, $this->keyLength - 1)];
        }

        // COLOCA UM CARACTER ESPECIAL //
        $string .= $this->specialChars[rand(0, strlen($this->specialChars) - 1)];

        return ['password_string' => $string, 'password_hash' => bcrypt($string)];
    }

    public function setSize($size)
    {
        $this->stringSize = $size;
    }

    public static function getInstance()
    {
        $instance = null;
        if ($instance == null)
            return new self();
    }


}