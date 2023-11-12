<?php

namespace App\Domain\Tributario\Arrecadacao\Requests\TEF;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class PendentesRequest extends FormRequest
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
            "dataInicio" => ["required", "date"],
            "dataFim" => ["required", "date"],
            "terminal" => ["integer", "nullable"],
            "DB_modulo" => ["required", "integer"],
            "DB_itemmenu_acessado" => ["required", "integer"]
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
            "dataInicio.required"           => utf8_encode("Data Inicio n�o informada."),
            "dataInicio.date"               => utf8_encode("Data Inicio inv�lida."),

            "dataFim.required"              => utf8_encode("Data Fim n�o informada."),
            "dataFim.date"                  => utf8_encode("Data Fim inv�lida."),

            "terminal.integer"              => utf8_encode("Terminal inv�lido."),

            "DB_modulo.required"            => utf8_encode("M�dulo n�o informado."),
            "DB_modulo.integer"             => utf8_encode("M�dulo inv�lido."),

            "DB_itemmenu_acessado.required" => utf8_encode("Menu n�o informado."),
            "DB_itemmenu_acessado.integer"  => utf8_encode("Menu inv�lido.")
        ];
    }
}
