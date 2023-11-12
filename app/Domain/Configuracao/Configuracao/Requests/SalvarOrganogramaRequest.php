<?php

namespace App\Domain\Configuracao\Configuracao\Requests;

use App\Http\Requests\DBFormRequest;
use Illuminate\Validation\Rule;

class SalvarOrganogramaRequest extends DBFormRequest
{
    public function rules()
    {
        return [
            'departamento' => ['required', 'integer'],
            'descricao' => ['required', 'string', 'max:100'],
            'departamentofilho' => [
                'required',
                'integer',
                'different:departamento',
                Rule::unique('db_config', 'db21_departamento')
            ],
            'instituicao' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute deve ser informado.',
            'integer' => 'O campo :attribute deve ser do tipo inteiro.',
            'descricao.string' => utf8_encode('A descri��o deve ser do tipo string.'),
            'descricao.max' => utf8_encode('A quantidade m�xima caracteres para a descri��o � de 100.'),
            'departamentofilho.different' => utf8_encode('Opera��o n�o permitida.'),
            'departamentofilho.unique' => utf8_encode('Departamento j� vinculado � Institui��o.')
        ];
    }
}
