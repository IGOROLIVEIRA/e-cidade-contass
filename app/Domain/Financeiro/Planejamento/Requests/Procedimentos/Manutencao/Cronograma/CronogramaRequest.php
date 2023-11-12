<?php

namespace App\Domain\Financeiro\Planejamento\Requests\Procedimentos\Manutencao\Cronograma;

use App\Http\Requests\DBFormRequest;
use Illuminate\Validation\Rule;

class CronogramaRequest extends DBFormRequest
{

    public function rules()
    {
        return [
            'planejamento_id' => 'required|integer',
            'exercicio' => 'required|integer',
            'DB_anousu' => 'required|integer',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'planejamento_id.required' => 'O campo "Planejamento" deve ser informado.',
            'planejamento_id.integer' => 'O c�digo do Planejamento se informado deve ser um inteiro.',
            'exercicio.required' => 'Exerc�cio do planejamento deve ser informado.',
            'exercicio.integer' => 'Exerc�cio do planejamento deve ser um inteiro.',
            'DB_anousu.required' => 'Ano da sess�o deve ser informado.',
            'DB_anousu.integer' => 'Ano da sess�o deve ser um inteiro.',
        ];
    }
}
