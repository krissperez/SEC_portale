<?php

namespace App\Helper;

use DateTime;

class Validator
{
    public static function validateEmail($email){
        $regex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
        return preg_match($regex, $email);
    }

    public static function validatePartitaIva(string $partitaIva){
        $regex = '/^[0-9]{11}$/';
        return preg_match($regex, $partitaIva);
    }


    public static function validateCap(string $cap){
        $regex = '/^[0-9]{5}$/';
        return preg_match($regex, $cap);
    }

    public static function validatePec(string $pec){
        return filter_var($pec, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhoneNumber(string $phoneNumber){
        $regex = '/^\+?[0-9 \-()]{10,20}$/';
        return preg_match($regex, $phoneNumber);
    }

    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}