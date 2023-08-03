<?php

use Illuminate\Support\Carbon;

date_default_timezone_set("Asia/Karachi");
ini_set('memory_limit', '1024M');
if (!function_exists('pre')) {
    function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if (!function_exists('formatted_date')) {
    function formatted_date($date, $formate)
    {
        return date($formate, strtotime($date));
    }
}
if (!function_exists('time_diffrence')) {
    function time_diffrence($date)
    {
        $date2 = new DateTime("now", new DateTimeZone('Asia/Karachi'));
        $date1 = new DateTime($date, new DateTimeZone('Asia/Karachi'));
        $diffInms = $date1->diff($date2);
        $days = $diffInms->d;
        //echo $date2."<br>";
        //echo $diffInms."<br>";die;
        //echo $mints;die;
        if ($days > 0) {
            if ($days == 1) {
                return $days . " day ago";
            } else {
                return $days . " days ago";
            }
        } else {
            return "Today";
        }
    }
}

if (!function_exists('date_separate')) {
    function date_separate($date){
        $date_separate=explode(" ", $date);
        return $date_separate[0];
    }
}

if (!function_exists('currency_load')) {
    function currency_load(){
        if(session()->has('system_default_currency_info')==false){
            session()->put('system_default_currency_info',App\Models\Currencies::find(1));
        }
    }
}

if (!function_exists('convert_price')) {
    function convert_price($price){
        currency_load();
        $system_default_currency_info=session('system_default_currency_info');
        $price = floatval($price)/floatval($system_default_currency_info->exchange_rate);

        if(\Illuminate\Support\Facades\Session::has('currency_exchange_rate')){
            $exchange=session('currency_exchange_rate');
        }else{
            $exchange= $system_default_currency_info->exchange_rate;
        }
        $price= floatval($price)*floatval($exchange);
        return $price;
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol(){
        currency_load();
        if(session()->has('currency_symbol')){
            $symbol=session('currency_symbol');
        }else{
            $system_default_currency_info=session('system_default_currency_info');
            $symbol=$system_default_currency_info->symbol;
        }
        return $symbol;
    }
}

if (!function_exists('format_price')) {
    function format_price($price){
        return currency_symbol().number_format($price,2);
    }
}

if (!function_exists('currency_converter')) {
    function currency_converter($amount){
        return format_price(convert_price($amount));
    }
}

if (!function_exists('count_text')) {
    function count_text($text){
        if(strlen($text)>22){
            return substr($text, 0, 22)."...";
        }else{
            return $text;
        }
    }
}

if (!function_exists('format_cat')) {
    function format_cat($text){
        return ucfirst(str_replace('-',' ',$text));
    }
}