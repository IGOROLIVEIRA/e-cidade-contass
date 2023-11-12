<?php
namespace App\Domain\Patrimonial\Ouvidoria\Requests\Atendimento\Atendimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use ECidade\Lib\Session\DefaultSession;

class AprovarAtendimento extends BaseFormRequest
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
            DefaultSession::DB_ID_USUARIO => 'required|filled|integer',
            'numeroProcesso' => 'required|filled|integer',
            'anoProcesso' => 'required|filled|integer',
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
            ),DefaultSession::DB_ID_USUARIO + ".required" => utf8_encode(
                "C�digo do usuario n�o informado."
            ),DefaultSession::DB_ID_USUARIO + ".filled" => utf8_encode(
                "O c�digo do usuario informado est� vazio."
            ),DefaultSession::DB_ID_USUARIO + ".integer" => utf8_encode(
                "C�digo inv�lido do usuario."
            ),
            "numeroProcesso.required" => utf8_encode("C�digo da Numero de Processo n�o informado."),
            "numeroProcesso.filled" => utf8_encode("O c�digo da Numero de Processo informado est� vazio."),
            "numeroProcesso.integer" => utf8_encode("C�digo inv�lido da Numero de Processo."),
            "anoProcesso.required" => utf8_encode("C�digo do anoProcesso n�o informado."),
            "anoProcesso.filled" => utf8_encode("O c�digo do anoProcesso informado est� vazio."),
            "anoProcesso.integer" => utf8_encode("C�digo inv�lido do anoProcesso."),
        ];
    }
}
