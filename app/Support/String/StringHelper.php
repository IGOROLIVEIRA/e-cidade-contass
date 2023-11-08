<?php declare(strict_types=1);

namespace App\Support\String;

class StringHelper
{
    public static function removeAccent(string $string): string
    {
        $accents = [
            '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a', '�' => 'a',
            '�' => 'e', '�' => 'e', '�' => 'e', '�' => 'e',
            '�' => 'i', '�' => 'i', '�' => 'i', '�' => 'i',
            '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o', '�' => 'o',
            '�' => 'u', '�' => 'u', '�' => 'u', '�' => 'u',
            '�' => 'c',
            '�' => 'n',
            '�' => 'y', '�' => 'y',
        ];

        return strtr($string, $accents);
    }
}
