<?php

namespace App\Support\String;

use DateTime;
use Exception;

class DateFormatter
{
    public static function formatDateToDmy(string $date): string
    {
        $dateObj = DateTime::createFromFormat('d/m/Y', $date);

        if ($dateObj === false) {
            throw new Exception("Please, provide a string with d/m/Y format.");
        }

        return $dateObj->format('d/m/Y');
    }
}
