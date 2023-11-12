<?php
namespace App\Domain\Patrimonial\Ouvidoria\Requests\Atendimento\Atendimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use ECidade\Lib\Session\DefaultSession;

class ProcessoOuvidoria extends BaseFormRequest
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
            DefaultSession::DB_INSTIT => 'required|filled|integer',
            DefaultSession::DB_CODDEPTO => 'required|filled|integer',
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
            DefaultSession::DB_INSTIT + ".required" => utf8_encode(
                "C�digo da instituicao n�o informado."
            ),DefaultSession::DB_INSTIT + ".filled" => utf8_encode(
                "O c�digo da instituicao informado est� vazio."
            ),DefaultSession::DB_INSTIT + ".integer" => utf8_encode(
                "C�digo inv�lido da instituicao."
            ),DefaultSession::DB_CODDEPTO + ".required" => utf8_encode(
                "C�digo do departamento n�o informado."
            ),DefaultSession::DB_CODDEPTO + ".filled" => utf8_encode(
                "O c�digo do departamento informado est� vazio."
            ),DefaultSession::DB_CODDEPTO + ".integer" => utf8_encode(
                "C�digo inv�lido do departamento."
            ),
        ];
    }
}
