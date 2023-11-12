<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoServidor;

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
            'id' => 'required|filled|integer|exists:jetomcomissaoservidor,rh245_sequencial',
        ];
    }

    /**
     * @param array $errors
     * @return DBJsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $mensagem = $errors[array_keys($errors)[0]][0];
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            "id.required" => "C�digo do servidor na comiss�o n�o informado.",
            "id.filled" => "C�digo inv�lido do servidor na comiss�o.",
            "id.integer" => "C�digo inv�lido do servidor na comiss�o.",
            "id.exists" => "C�digo n�o encontrado do servidor na comiss�o.",
        ];
    }
}
