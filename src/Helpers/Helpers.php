<?php


/**
 * Inicializa helper para atomic transactions
 */
if (!function_exists('Transaction')) {
    function Transaction()
    {
        return new \MichaelDouglas\MService\Helpers\TransactionHelper();
    }

}


if (!function_exists('isMultidimensionalArray')) {
    function isMultidimensionalArray(array $array)
    {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }
}


if (!function_exists('moneyToDecimal')) {
    function moneyToDecimal($money, $hasPrefix = false, $prefix = 'R$')
    {
        return \MichaelDouglas\MService\Util\Format::moneyToDecimal($money, $hasPrefix, $prefix);
    }
}


if (!function_exists('generatePassword')) {
    function generatePassword($size = null)
    {
        $service = \MichaelDouglas\MService\Util\Password::getInstance();

        if(!empty($size))
            $service->setSize($size);

        return $service->generate();
    }
}


if (!function_exists('isCpf')) {
    function isCpf($string)
    {
       return \MichaelDouglas\MService\Util\Functions::isCpf($string);
    }
}

if (!function_exists('isCnpj')) {
    function isCnpj($string)
    {
        return \MichaelDouglas\MService\Util\Functions::isCnpj($string);
    }
}

if (!function_exists('removeSpecialChars')) {
    function removeSpecialChars($string)
    {
        return \MichaelDouglas\MService\Util\Functions::removeSpecialChars($string);
    }
}

if (!function_exists('formatCnpj')) {
    function formatCnpj($string)
    {
        return \MichaelDouglas\MService\Util\Functions::maskCnpj($string);
    }
}

if (!function_exists('formatCpf')) {
    function formatCpf($string)
    {
        return \MichaelDouglas\MService\Util\Functions::formatCpf($string);
    }
}


if (!function_exists('debug')) {
    function debug(...$args)
    {
        http_response_code(500);
        foreach ($args as $x) {
            (new \Illuminate\Support\Debug\Dumper())->dump($x);
        }

        die(1);
    }
}

if (!function_exists('dateToView')) {
    function dateToView($date, $hour = true)
    {
        return \MichaelDouglas\MService\Util\Format::dateToView($date, $hour);
    }
}

if (!function_exists('getSQLRender')) {
    function getSQLRender($builder, $noQuotes = true)
    {
        $sql = $builder->toSql();
        foreach ( $builder->getBindings() as $binding ) {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }

        if($noQuotes)
            $sql = str_replace('`', '', $sql);

        return $sql;
    }
}

if (!function_exists('moneyToDecimal')) {
    function moneyToDecimal($money, $hasPrefix = false, $prefix = 'R$')
    {
        return \MichaelDouglas\MService\Util\Format::moneyToDecimal($money, $hasPrefix, $prefix);
    }
}


