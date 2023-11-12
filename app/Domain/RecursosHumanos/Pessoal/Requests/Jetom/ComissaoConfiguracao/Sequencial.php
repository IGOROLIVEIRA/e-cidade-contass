<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoConfiguracao;

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
            'id' => 'required|filled|integer|exists:jetomcomissaoconfiguracao,rh243_sequencial',
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
            "id.required" => utf8_encode("C�digo n�o informado da configura��o da rubrica da comiss�o."),
            "id.filled" => utf8_encode("C�digo inv�lido da configura��o da rubrica da comiss�o."),
            "id.integer" => utf8_encode("C�digo inv�lido da configura��o da rubrica da comiss�o."),
            "id.exists" => utf8_encode("N�o foi encontrada a configura��o da rubrica da comiss�o."),
        ];
    }
}
