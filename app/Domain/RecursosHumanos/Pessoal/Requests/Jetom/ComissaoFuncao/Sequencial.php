<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoFuncao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class Sequencial extends BaseFormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|filled|integer|exists:jetomcomissaofuncao,rh246_sequencial',
        ];
    }

    /**
     * @param array $errors
     * @return DBJsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $mensagem = utf8_decode($errors[array_keys($errors)[0]][0]);
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            "id.required" => utf8_encode("C�digo da fun��o da comiss�o n�o informado."),
            "id.filled" => utf8_encode("C�digo inv�lido da fun��o da comiss�o."),
            "id.integer" => utf8_encode("C�digo inv�lido da fun��o da comiss�o."),
            "id.exists" => utf8_encode("Fun��o da comiss�o n�o encontrada."),
        ];
    }
}
