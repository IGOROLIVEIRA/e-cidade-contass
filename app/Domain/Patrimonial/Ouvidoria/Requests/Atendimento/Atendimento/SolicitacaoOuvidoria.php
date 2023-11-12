<?php
namespace App\Domain\Patrimonial\Ouvidoria\Requests\Atendimento\Atendimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class SolicitacaoOuvidoria extends BaseFormRequest
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
            "numeroProcesso.required" => utf8_encode("C�digo da Numero de Processo n�o informado."),
            "numeroProcesso.filled" => utf8_encode("O c�digo da Numero de Processo informado est� vazio."),
            "numeroProcesso.integer" => utf8_encode("C�digo inv�lido da Numero de Processo."),
            "anoProcesso.required" => utf8_encode("C�digo do anoProcesso n�o informado."),
            "anoProcesso.filled" => utf8_encode("O c�digo do anoProcesso informado est� vazio."),
            "anoProcesso.integer" => utf8_encode("C�digo inv�lido do anoProcesso."),
        ];
    }
}
