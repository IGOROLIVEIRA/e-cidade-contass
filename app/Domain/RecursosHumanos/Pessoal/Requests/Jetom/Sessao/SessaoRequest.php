<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Sessao;

use App\Http\Requests\BaseFormRequest;

class SessaoRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rh247_sequencial' => 'nullable|integer',
            'rh247_comissao' => 'required|integer',
            'rh247_processada' => 'nullable|boolean',
            'rh247_tiposessao' => 'integer',
            'rh247_mes' => 'integer',
            'rh247_ano' => 'integer',
        ];
    }

    public function response(array $errors)
    {
        $mensagem = $errors[array_keys($errors)[0]][0];

        return response()->json([
            "message" => $mensagem,
            "errors" => $errors,
            "status" => 406
        ], 406);
    }

    public function messages()
    {
        return [
            'rh247_sequencial.integer' => utf8_encode('C�digo da sess�o inv�lido.'),
            'rh247_comissao.required' => utf8_encode('Comiss�o n�o informada.'),
            'rh247_comissao.integer' => utf8_encode('C�digo da comiss�o inv�lido.'),
            'rh247_processada.boolean' => utf8_encode('Verifica��o de sess�o processada est� em formato inv�lido.'),
            'rh247_tiposessao.required' => utf8_encode('Tipo da sess�o n�o informado.'),
            'rh247_tiposessao.integer' => utf8_encode('Tipo da sess�o em formato inv�lido.'),
            'rh247_mes.integer' => utf8_encode('M�s da compet�ncia em formato inv�lido.'),
            'rh247_ano.integer' => utf8_encode('Ano da compet�ncia em formato inv�lido.')
        ];
    }
}
