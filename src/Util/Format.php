<?php

namespace MichaelDouglas\Mservice\Util;
use Carbon\Carbon;

class Format
{

    /**
     * Formata a data do banco de dados para o formato de visualização do usuário
     * @param $date
     * @param $hour
     * @return false|string
     */
    public static function dateToView($date, $hour = true)
    {
        if(!$hour){
            return date('d/m/Y',strtotime($date));
        }else{
            return date('d/m/Y H:i',strtotime($date));
        }
    }

    /**
     * Retorna somente o horario de uma data
     * @param $date
     * @return false|string
     */
    public static function dateToHour($date)
    {
        return date('H:i:s',strtotime($date));
    }

    public static function numberMonthToNameMonth($monthNumber)
    {
        setlocale(LC_TIME, 'pt_BR');

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $monthName = strftime('%B', mktime(0, 0, 0, $monthNumber));

        return $monthName;
    }

    /** Retorna o mes atual
     * @return string
     */
    public static function getAtualMonth()
    {
        $now = Carbon::now();
        return $now->format('m');
    }

    /** Retorna o mes atual
     * @return string
     */
    public static function getAtualYear()
    {
        $now = Carbon::now();
        return $now->format('Y');
    }

    public static function addDaysToNow($days)
    {
        $now = Carbon::now();
        $now->addDay($days);
        return $now->format('Y-m-d');
    }

    public static function getAtualDateInit()
    {
        $now = Carbon::now();
        return $now->startOfMonth();
    }

    public static function getAtualDateEnd()
    {
        $now = Carbon::now();
        return $now->endOfMonth();
    }

    public static function getAtualDateInitCompetency()
    {
        $now = Carbon::now();
        return $now->format('m/Y');
    }

    /**
     * Formata a data do banco de dados para o formato de visualização do usuário
     * @param $date
     * @param $hour
     * @return false|string
     */
    public static function nameToView($name)
    {
        return explode( ' ', $name)[0];
    }

    /**
     * Transforma o formato de datas que é usado nas views para o formato do sistema
     * @param $date
     * @return string
     */
    public static function viewToDate($date, $hour = true)
    {
        if(!$hour){
            return date_create_from_format("d/m/Y", $date)->format("Y-m-d");
        }else{
            return date_create_from_format("d/m/Y", $date)->format("Y-m-d H:i:s");
        }
    }

    /**
     * Adiciona um mes para uma data
     * @param $date
     * @return string
     */
    public static function addMonthToDate($date, $months = 1)
    {
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $date);
        $dateCarbon->addMonth($months);

        return $dateCarbon->format('Y-m-d');
    }

    /**
     * Transforma o valor de decimal para centavos
     *
     * @author: Paulo Bahia
     * @email: paulo.bahia@synapsebrasil.com.br
     * @param $decimal
     * @return mixed
     */
    public static function decimalToCents($decimal){
        $decimal = $decimal * 100;
        $value = explode(".", strval($decimal));
        return $value[0];
    }

    /**
     * Converte um valor em centavos para decimal
     * @param $cents
     * @return float|int
     */
    public static function centsToDecimal($cents)
    {
        return $cents / 100;
    }

    /**
     * Converte o formato de data da api do IUGU para o formato que o sistema espera
     * @param $date
     * @return false|string
     */

    public static function iuguDateToSystemDate($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * Retorna um formato decimal para o formato em dinheiro
     * @param $money
     * @param bool $enablePrefix
     * @param string $prefix
     * @return string
     */
    public static function moneyToView($money, $enablePrefix = true, $prefix = 'R$')
    {
        if($enablePrefix)
            return $prefix .' '. number_format($money, 2,',','.');

        return number_format($money, 2,',','.');
    }

    /**
     * Retorna o timestamp de uma string em formato de horario
     * @param $string
     * @return string
     */
    public static function stringHourToTime($string)
    {
        $parts = explode(':', $string);
        $hour = Carbon::createFromTime($parts[0], $parts[1]);

        return $hour->format('H:i');
    }

    /**
     * Retorna a idade baseado na data de aniversario
     * @param $date
     * @return int
     */
    public static function birthDateToAge($date)
    {
        // Separa em dia, mês e ano
        list($ano, $mes, $dia) = explode('-', $date);

        //Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

        //Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

        return intval($idade);
    }

    /**
     * Remove toda a formatação do CEP
     * @param $cep
     * @return mixed
     */
    public static function unformatCep($cep)
    {
        $cep = preg_replace('/[^0-9]/', '', (string) $cep);
        return $cep;
    }

    public static function unformatTelephone($telephone)
    {
        return preg_replace('/[^0-9]/', '', (string) $telephone);
    }


    public static function formatTelephone($telephone)
    {
        return self::mask('(##)#####-####',$telephone);
    }

    /**
     * Remove os pontos e traços do cpf
     * @param $cpf
     * @return mixed
     */
    public static function unformatCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        return $cpf;
    }


    public static function moneyTocielo($money){
        return str_replace('.','',$money);
    }

    /**
     * Remove os pontos e traços do cnpj
     * @param $cnpj
     * @return mixed
     */
    public static function unformatCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        return $cnpj;
    }

    /**
     * Formata uma string em formato money para float
     * @param $money
     * @return mixed
     */
    public static function moneyToFloat($money){
        $money = str_replace('.','',$money);
        $money = str_replace(',','.',$money);
        return $money;
    }


    /**
     * Mascara para formatar cpf
     * @param $cpf
     * @return mixed
     */
    public static function formatCpf($cpf)
    {
        return self::mask('###.###.###-##',$cpf);
    }


    /**
     * Converte um formato money para o formato decimal
     * @param $money
     * @param bool $hasPrefix
     * @param string $prefix
     * @return mixed
     */
    public static function moneyToDecimal($money , $hasPrefix = false, $prefix = 'R$')
    {
        $format = str_replace('.','',$money);
        $formatMoney = str_replace(',','.', $format);
        $removeSpaces = str_replace(' ','', $formatMoney);
        return $hasPrefix ? str_replace($prefix, '', $removeSpaces) : $removeSpaces;
    }

    public static function calculatePercent($partial, $total)
    {
        return number_format(100 * $partial/$total, 2, ',', '.');
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

    private static function mask($mask,$str){

        $str = str_replace(" ","",$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }

        return $mask;
    }

    /**
     * Checa se a data2 é o mes anterior a data 1
     * @param $date1
     * @param $date2
     */
    public static function isBeforeMonth($date1, $date2)
    {

    }

    /**
     * Checa se algum dos indices de um array está preenchido
     * @param $array
     * @param null $except
     * @return bool
     */
    public static function arrayKeyIsFill($array, $except = null)
    {
        if(!empty($array)){
            foreach ($array as $key => $value){
                if(!empty($except)){
                    if(!in_array($key,$except) && !is_null($value))
                        return true;
                }else{
                    if(!empty($value)){
                        return true;
                    }
                }
            }
        }

        return false;
    }


    public static function print_r_reverse($input) {
        $reg = '/\[([0-9]+)\] \=\> ([a-z]+)/';

        $m = preg_match_all($reg, $input, $ms);

        dd($m);
    }

}