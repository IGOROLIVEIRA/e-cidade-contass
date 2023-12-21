<?php declare(strict_types=1);

namespace App\Support\String;

class StringHelper
{
    public static function removeAccent(string $string): string
    {
        $accents = [
            '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a',
            '�' => 'A', '�' => 'A', '�' => 'A', '�' => 'A', '�' => 'A', '�' => 'A',
            '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e',
            '�' => 'E', '�' => 'E', '�' => 'E', '�' => 'E',
            '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i',
            '�' => 'I', '�' => 'I', '�' => 'I', '�' => 'I',
            '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o',
            '�' => 'O', '�' => 'O', '�' => 'O', '�' => 'O', '�' => 'O', '�' => 'O',
            '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u',
            '�' => 'U', '�' => 'U', '�' => 'U', '�' => 'U',
            '�' => 'c',
            '�' => 'C',
            '�' => 'n',
            '�' => 'N',
            '�' => 'y', '�' => 'y',
        ];

        return strtr($string, $accents);
    }

    public static function barCodeAmountFormart(float $amount): string
    {
        return str_pad(number_format($amount, 2, "", ""), 11, "0", STR_PAD_LEFT);
    }
}
