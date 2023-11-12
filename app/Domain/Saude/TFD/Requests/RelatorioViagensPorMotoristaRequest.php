<?php

namespace App\Domain\Saude\TFD\Requests;

use App\Http\Requests\DBFormRequest;

/**
 * Classe respons�vel pelas requisi��es de relat�rios de viagens por motorista
 * @package App\Domain\Saude\TFD\Requests
 */
class RelatorioViagensPorMotoristaRequest extends DBFormRequest
{
    public function rules()
    {
        return [
            'motoristas' => 'array',
            'motoristas.*' => 'integer',
            'periodoInicial' => 'required|date',
            'periodoFinal' => 'required|date',
            'destino' => 'integer',
            'ordem' => 'required|integer',
            'tipo' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'motoristas.*.integer' => 'Os valores do campo motoristas devem ser do tipo inteiro.',
        ];
    }
}
