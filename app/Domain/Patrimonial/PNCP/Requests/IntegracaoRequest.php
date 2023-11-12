<?php

namespace App\Domain\Patrimonial\PNCP\Requests;

use App\Http\Requests\DBFormRequest;
use Illuminate\Validation\Rule;

/**
 * @property $documento
 * @property $DB_instit
 */
class IntegracaoRequest extends DBFormRequest
{
    public function rules()
    {
        return [
            'documento' => 'numeric|required|',
            'DB_instit' => [
                'integer',
                'required',
                Rule::unique('integracaopncp', 'pn01_instit')
            ]
        ];
    }

    public function messages()
    {
        $mensagemInteger = utf8_encode("Documento(cgc) vinculado a institui��o inv�lido, verifique o cadastro.");
        $mensagemRequired = utf8_encode("Documento(cgc) vinculado a institui��o � obrigat�rio, verifique o cadastro.");
        $mensagemInstituicao = utf8_encode("Institui��o j� cadastrada na integra��o do PNCP!");
        return [
          'documento.numeric' => $mensagemInteger,
          'documento.required' => $mensagemRequired,
          'DB_instit.unique' => $mensagemInstituicao
        ];
    }
}
