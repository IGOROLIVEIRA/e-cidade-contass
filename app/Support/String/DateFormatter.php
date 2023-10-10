<?php

namespace App\Support\String;

use DateTime;
use Exception;

class DateFormatter
{
    public static function convertDateFormatBRToISO(string $date): string
    {
        $dateTime = DateTime::createFromFormat('d/m/Y', $date);

        if ($dateTime === false) {
            throw new Exception("Please, provide a string with d/m/Y format.");
        }

        return $dateTime->format('Y-m-d');
    }
}
