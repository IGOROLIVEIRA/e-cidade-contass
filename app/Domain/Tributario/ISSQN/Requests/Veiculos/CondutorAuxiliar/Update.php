<?php
namespace App\Domain\Tributario\ISSQN\Requests\Veiculos\CondutorAuxiliar;

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
        return [
            'q173_sequencial' => 'required|filled|integer|exists:issveiculocondutorauxiliar',
            'q173_cgm'        => 'required|filled|integer',
            'q173_datainicio' => 'required|filled|date',
            'q173_datafim'    => 'nullable|date',
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

            "q173_sequencial.required" => utf8_encode("Sequencial n�o informado."),
            "q173_sequencial.filled"   => utf8_encode("Sequencial informado est� vazio."),
            "q173_sequencial.integer"  => utf8_encode("Sequencial inv�lido."),
            "q173_sequencial.exists"   => utf8_encode("Nenhum registro para o c�digo informado."),

            "q173_cgm.required"        => utf8_encode("Cgm n�o informado."),
            "q173_cgm.filled"          => utf8_encode("Cgm informado est� vazio."),
            "q173_cgm.integer"         => utf8_encode("Cgm inv�lido."),

            "q173_datainicio.required" => utf8_encode("Data de in�cio n�o informada."),
            "q173_datainicio.filled"   => utf8_encode("Data de in�cio vazia."),
            "q173_datainicio.date"     => utf8_encode("Data de in�cio inv�lida."),

            "q173_datafim.date"        => utf8_encode("Data de fim inv�lida."),

        ];
    }
}
