<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Support;

use App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoImportacaoListaPostagem\ArquivoPostagem;
use BusinessException;
use Exception;

trait StringUtils
{
    public function format(string $data, int $length, string $filler = ArquivoPostagem::FILLER, int $padType = STR_PAD_LEFT): string
    {
        if (!empty($data)) {
            $data = substr($data, 0, $length);
        }

        return str_pad(
            $data,
            $length,
            $filler,
            $padType
        );
    }

    /**
     * @throws BusinessException
     */
    public function set(string $field, string $data, int $length): string
    {
        if (strlen($data) < $length) {
            throw new BusinessException('Valor inválido para o campo '. $field);
        }
        return $data;
    }

    public function filler(string $filler, int $length): string
    {
        return str_repeat($filler, $length);
    }
}