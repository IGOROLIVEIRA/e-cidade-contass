<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Pré Validação para Rules dentro de Form Requests
     *
     * @return array|bool
     */
    protected function preValidacaoRule()
    {

        $instituicao = empty($this->request->get('instituicao')) ? "abc" : $this->request->get('instituicao') ;

        return !is_numeric($instituicao) ? ['instituicao' => 'required|integer',] : false ;
    }

    public function messages()
    {
        return [
            "instituicao.required" => utf8_encode("Institui��o obrigat�ria."),
            "instituicao.integer"  => utf8_encode("Institui��o precisa ser um n�mero.")
        ];
    }
}
