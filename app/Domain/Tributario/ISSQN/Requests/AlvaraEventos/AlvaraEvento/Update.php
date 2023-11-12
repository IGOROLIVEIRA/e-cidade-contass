<?php
namespace App\Domain\Tributario\ISSQN\Requests\AlvaraEventos\AlvaraEvento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class Update extends BaseFormRequest
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
        $id = $this->request->get('q170_codigo');
        $ruleOrdemServico = 'required|filled|integer|unique:alvaraevento,q170_ordemservico,' . $id .',q170_codigo';

        return [
            'q170_codigo'            => 'required|filled|integer',
            'q170_tipoalvara'        => 'required|filled|integer',
            'q170_ordemservico'      => $ruleOrdemServico,
            'q170_certidaobombeiro'  => 'required|filled|string',
            'q170_dataemissao'       => 'nullable|date',
            'q170_estimativapublico' => 'nullable|integer',
            'q170_observacao'        => 'required|filled|string',
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
            "q170_codigo.required"           => utf8_encode("C�digo n�o informado."),
            "q170_codigo.filled"             => utf8_encode("C�digo informada est� vazio."),
            "q170_codigo.integer"            => utf8_encode("C�digo inv�lido."),

            "q170_tipoalvara.required"       => utf8_encode("Tipo de alvar� n�o informado."),
            "q170_tipoalvara.filled"         => utf8_encode("Tipo de alvar� informado est� vazia."),
            "q170_tipoalvara.integer"        => utf8_encode("Tipo de alvar� inv�lido."),

            "q170_ordemservico.required"     => utf8_encode("Ordem de servi�o n�o informada."),
            "q170_ordemservico.filled"       => utf8_encode("Ordem de servi�o informada est� vazia."),
            "q170_ordemservico.integer"      => utf8_encode("Ordem de servi�o inv�lida."),
            "q170_ordemservico.unique"       => utf8_encode("Ordem de servi�o j� vinculada com outro alvar�."),

            "q170_certidaobombeiro.required" => utf8_encode("Certid�o de bombeiros n�o informada."),
            "q170_certidaobombeiro.filled"   => utf8_encode("Certid�o de bombeiros informada est� vazia."),
            "q170_certidaobombeiro.string"   => utf8_encode("Certid�o de bombeiros inv�lida."),

            "q170_dataemissao.date"          => utf8_encode("Data de emissao inv�lida."),

            "q170_observacao.required"       => utf8_encode("Observa��o n�o informada."),
            "q170_observacao.filled"         => utf8_encode("Observa��o informada est� vazia."),
            "q170_observacao.string"         => utf8_encode("Observa��o inv�lida."),
        ];
    }
}
