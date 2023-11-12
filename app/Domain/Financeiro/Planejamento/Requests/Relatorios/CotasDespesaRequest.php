<?php

namespace App\Domain\Financeiro\Planejamento\Requests\Relatorios;

use App\Http\Requests\DBFormRequest;
use Illuminate\Validation\Rule;

class CotasDespesaRequest extends DBFormRequest
{
    public function rules()
    {
        return [
            'planejamento_id' => 'required|integer|filled|exists:planejamento,pl2_codigo',
            'exercicio' => 'required|integer',
            'DB_anousu' => 'required|integer',
            'agruparPor' => [
                'required',
                'string',
                Rule::in([
                    'orgao',
                    'unidade',
                    'funcao',
                    'subfuncao',
                    'programa',
                    'iniciativa',
                    'elemento',
                    'recurso',
                ])],
            'periodicidade' => ['required', 'string', Rule::in(['mensal', 'bimestral'])],
            'instituicoes' => 'required|array',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'planejamento_id.integer' => 'C�digo se informado deve ser um inteiro.',
            'planejamento_id.required' => 'O campo "C�digo" deve ser informado.',
            'planejamento_id.filled' => 'O campo "C�digo" deve ser preenchido.',
            'planejamento_id.exists' => 'Planejamento n�o encontrado no banco de dados.',
            'exercicio.required' => 'O campo "Exerc�cio" deve ser informado.',
            'DB_anousu.required' => 'O campo "Ano da Sess�o" deve ser informado.',
            'agruparPor.required' => 'O campo "Agrupar por" deve ser informado.',
            'periodicidade.required' => 'O campo "Periodicidade" deve ser informado.',
            'instituicoes.required' => 'O campo "Institui��es" deve ser informado.',
        ];
    }
}
