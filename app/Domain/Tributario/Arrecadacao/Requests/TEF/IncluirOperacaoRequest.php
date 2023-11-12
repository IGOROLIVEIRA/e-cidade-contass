<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class IncluirOperacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "numnov" => ["required", "integer"],
            "valor" => ["required", "numeric"],
            "nsu" => ["integer", "nullable"],
            "operacaotef" => ["required", "integer"],
            "bandeira" => ["string", "nullable"],
            "parcela" => ["nullable", "integer"],
            "confirmado" => ["boolean", "nullable"],
            "mensagemretorno" => ["string", "nullable"],
            "desfeito" => ["boolean", "nullable"],
            "codigoaprovacao" => ["string", "nullable"],
            "nsuautorizadora" => ["integer", "nullable"],
            "cartao" => ["string", "nullable"],
            "retorno" => ["string", "nullable"],
            "grupo" => ["required", "integer"],
            "confirmadoautorizadora" => ["boolean", "nullable"],
            "terminal" => ["required", "integer"],
            "DB_instit" => ["required", "integer"],
            "DB_coddepto" => ["required", "integer"],
            "DB_id_usuario" => ["required", "integer"],
            "DB_datausu" => ["required", "integer"]
        ];
    }

    public function response(array $errors)
    {
        $mensagem = utf8_decode($errors[array_keys($errors)[0]][0]);
        return new DBJsonResponse($errors, $mensagem, 406);
    }

    public function messages()
    {
        return [
            "numnov.required"         => utf8_encode("N�mero do recibo n�o informado."),
            "numnov.integer"          => utf8_encode("N�mero do recibo inv�lido."),

            "valor.required"          => utf8_encode("Valor do recibo n�o informado."),
            "valor.numeric"           => utf8_encode("Valor do recibo inv�lido."),

            "nsu.integer"             => utf8_encode("NSU do CTF inv�lido."),

            "operacaotef.required"    => utf8_encode("Opera��o n�o informada."),
            "operacaotef.integer"     => utf8_encode("Opera��o inv�lida."),

            "bandeira.string"         => utf8_encode("Bandeira inv�lido."),

            "parcela.integer"          => utf8_encode("Parcela inv�lido."),

            "confirmado.string"       => utf8_encode("Confirmado inv�lido."),

            "mensagemretorno.string"  => utf8_encode("Mensagem de Retorno inv�lida."),

            "desfeito.string"         => utf8_encode("Desfeito inv�lido."),

            "codigoaprovacao.string"  => utf8_encode("C�digo de Aprova��o inv�lido."),

            "nsuautorizadora.integer" => utf8_encode("NSU da Autorizadora inv�lido."),

            "cartao.string"           => utf8_encode("Formato cart�o inv�lido."),

            "retorno.string"          => utf8_encode("Retorno do CTFClient inv�lido."),

            "grupo.required"          => utf8_encode("Grupo n�o informado."),
            "grupo.string"            => utf8_encode("Grupo inv�lido."),

            "terminal.required"       => utf8_encode("Terminal n�o informado."),
            "terminal.string"         => utf8_encode("Terminal inv�lido."),

            "confirmadoautorizadora.boolean" => utf8_encode("Confirma��o da Autorizadora inv�lida."),

            "DB_instit.required"      => utf8_encode("C�digo da institui��o n�o informado."),
            "DB_instit.integer"       => utf8_encode("C�digo da institui��o inv�lido."),

            "DB_coddepto.required"    => utf8_encode("C�digo do departamentro n�o informado."),
            "DB_coddepto.integer"     => utf8_encode("C�digo do departamentro inv�lido."),

            "DB_id_usuario.required"  => utf8_encode("C�digo do usu�rio n�o informado."),
            "DB_id_usuario.integer"   => utf8_encode("C�digo do usu�rio inv�lido."),

            "DB_datausu.required"     => utf8_encode("Data do sistema n�o informada n�o informado."),
            "DB_datausu.integer"      => utf8_encode("Data do sistema n�o informada inv�lido.")
        ];
    }
}
