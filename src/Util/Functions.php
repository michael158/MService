<?php

namespace MichaelDouglas\Mservice\Util;


class Functions
{

    /**
     * Verifica se a string de numeros equivale a um CPF
     * @param $string
     * @return bool
     */
    public static function isCpf($string)
    {
        $string = self::removeSpecialChars($string);
        try{
             self::formatCpf($string);
             return true;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Verifica se a string de numeros equivale a um CPF
     * @param $string
     * @return bool
     */
    public static function isCnpj($string)
    {
        $string = self::removeSpecialChars($string);
        try{
            self::maskCnpj($string);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }


    /**
     * Mascara para formatar cpf
     * @param $cpf
     * @return mixed
     */
    public static function formatCpf($string)
    {
        return self::mask('###.###.###-##',$string);
    }

    /**
     * Formata uma string em formato money para float
     * @param $money
     * @return mixed
     */
    public static function moneyToFloat($money)
    {
        $money = str_replace('.', '', $money);
        $money = str_replace(',', '.', $money);
        return $money;
    }

    /**
     * Formata um numero em real no formato "money"
     * @param $value
     * @return string
     */
    public static function maskMoney($value)
    {
        $number = number_format($value, 2, ',', '.');

        return $number;
    }

    /**
     * Mascara para formatar cnpj
     * @param $cnpj
     * @return mixed
     */
    public static function maskCnpj($cnpj)
    {
        return self::mask('##.###.###/####-##', $cnpj);
    }

    /**
     * Remove os pontos e traços do cpf
     * @param $cpf
     * @return mixed
     */
    public static function removeSpecialChars($string)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $string);
        return $cpf;
    }



    private static function mask($mask, $str)
    {

        $str = str_replace(" ", "", $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, "#")] = $str[$i];
        }

        return $mask;

    }


}