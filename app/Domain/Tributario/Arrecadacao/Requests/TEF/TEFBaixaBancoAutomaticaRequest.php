<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class TEFBaixaBancoAutomaticaRequest extends FormRequest
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
            "numpre" => ["required", "integer"],
            "valor" => ["required", "numeric"],
            "conta" => ["required", "integer"],
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
            "numpre.required"        => utf8_encode("Numpre do recibo n�o informado."),
            "numpre.integer"         => utf8_encode("Numpre do recibo inv�lido."),

            "valor.required"         => utf8_encode("Valor do recibo n�o informado."),
            "valor.numeric"           => utf8_encode("Valor do recibo inv�lido."),

            "conta.required"         => utf8_encode("Conta do caixa n�o informado."),
            "conta.integer"          => utf8_encode("Conta do caixa inv�lido."),

            "DB_instit.required"     => utf8_encode("C�digo da institui��o n�o informado."),
            "DB_instit.integer"      => utf8_encode("C�digo da institui��o inv�lido."),

            "DB_coddepto.required"   => utf8_encode("C�digo do departamentro n�o informado."),
            "DB_coddepto.integer"    => utf8_encode("C�digo do departamentro inv�lido."),

            "DB_id_usuario.required" => utf8_encode("C�digo do usu�rio n�o informado."),
            "DB_id_usuario.integer"  => utf8_encode("C�digo do usu�rio inv�lido."),

            "DB_datausu.required"    => utf8_encode("Data do sistema n�o informada n�o informado."),
            "DB_datausu.integer"     => utf8_encode("Data do sistema n�o informada inv�lido.")
        ];
    }
}
