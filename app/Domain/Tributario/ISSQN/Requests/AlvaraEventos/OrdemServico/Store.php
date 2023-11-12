<?php
namespace App\Domain\Tributario\ISSQN\Requests\AlvaraEventos\OrdemServico;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
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
            'q168_processo'     => 'required_without:q168_processoexterno|integer',
            'q168_cgm'          => 'required_without:q168_inscricao|integer',
            'q168_inscricao'    => 'required_without:q168_cgm|integer',
            'q168_descricao'    => 'required|filled|string',
            'q168_localizacao'  => 'required|filled|string',
            'q168_dataemissao'  => 'nullable|date',
            'q168_datainicio'   => 'required|filled|date',
            'q168_datafim'      => 'required|filled|date',
            'q168_horainicio'   => 'required|filled|string',
            'q168_horafim'      => 'required|filled|string',
            'q168_processoexterno' => 'required_without:q168_processo|string',
            'q168_titularprocessoexterno' => 'required_without:q168_processo|string',
            'q168_dataprocessoexterno' => 'required_without:q168_processo|date',
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
            "q168_processo.required_without"  => utf8_encode("Processo ou Processo Externo devem ser informados!"),
            "q168_processo.integer"           => utf8_encode("Processo inv�lido."),
            "q168_descricao.required"         => utf8_encode("Descricao n�o informada."),
            "q168_descricao.filled"           => utf8_encode("Descricao informada est� vazia."),
            "q168_descricao.string"           => utf8_encode("Descricao inv�lida."),
            "q168_localizacao.required"       => utf8_encode("Localiza��o n�o informada."),
            "q168_localizacao.filled"         => utf8_encode("Localiza��o informada est� vazia."),
            "q168_localizacao.string"         => utf8_encode("Localiza��o inv�lida."),
            "q168_datainicio.required"        => utf8_encode("Data de inicio n�o informada."),
            "q168_datainicio.filled"          => utf8_encode("Data de inicio informada est� vazia."),
            "q168_datainicio.string"          => utf8_encode("Data de inicio inv�lida."),
            "q168_datafim.required"           => utf8_encode("Data de fim n�o informada."),
            "q168_datafim.filled"             => utf8_encode("Data de fim informada est� vazia."),
            "q168_datafim.string"             => utf8_encode("Data de fim inv�lida."),
            "q168_horainicio.required"        => utf8_encode("Hora de inicio n�o informada."),
            "q168_horainicio.filled"          => utf8_encode("Hora de inicio informada est� vazia."),
            "q168_horainicio.string"          => utf8_encode("Hora de inicio inv�lida."),
            "q168_horafim.required"           => utf8_encode("Hora final n�o informada."),
            "q168_horafim.filled"             => utf8_encode("Hora final informada est� vazia."),
            "q168_horafim.string"             => utf8_encode("Hora final inv�lida."),
            "q168_dataemissao.date"           => utf8_encode("Data de emissao inv�lida."),
            "q168_cgm.integer"                => utf8_encode("CGM inv�lido."),
            "q168_cgm.required_without"       => utf8_encode("CGM ou Inscri��o devem ser informados!"),
            "q168_inscricao.integer"          => utf8_encode("Inscri��o inv�lida."),
            "q168_inscricao.required_without" => utf8_encode("CGM ou Inscri��o devem ser informados!"),
            "q168_dataprocessoexterno.date"   => utf8_encode("Data do processo externo inv�lida."),

            "q168_processoexterno.required_without" => utf8_encode(
                "Processo ou Processo Externo devem ser informados!"
            ),
            "q168_titularprocessoexterno.required_without" => utf8_encode(
                "Processo ou Processo Externo devem ser informados!"
            ),
            "q168_dataprocessoexterno.required_without" => utf8_encode(
                "Processo ou Processo Externo devem ser informados!"
            ),
        ];
    }
}
