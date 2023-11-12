<?php
namespace App\Domain\Tributario\ISSQN\Requests\Veiculos\Veiculo;

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
            'q172_sequencial'    => 'required|filled|integer|exists:issveiculo',
            'q172_datacadastro'  => 'required|filled|date',
            'q172_issbase'       => 'required|filled|integer',
            'q172_tipo'          => 'nullable|integer',
            'q172_marca'         => 'nullable|integer',
            'q172_modelo'        => 'nullable|integer',
            'q172_procedencia'   => 'nullable|integer',
            'q172_categoria'     => 'nullable|integer',
            'q172_chassi'        => 'nullable|string',
            'q172_renavam'       => 'nullable|string',
            'q172_placa'         => 'nullable|string',
            'q172_potencia'      => 'nullable|string',
            'q172_capacidade'    => 'nullable|integer',
            'q172_anofabricacao' => 'nullable|integer',
            'q172_anomodelo'     => 'nullable|integer',
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

            "q172_sequencial.required" => utf8_encode("Sequencial n�o informado."),
            "q172_sequencial.filled"   => utf8_encode("Sequencial informado est� vazio."),
            "q172_sequencial.integer"  => utf8_encode("Sequencial inv�lido."),
            "q172_sequencial.exists"   => utf8_encode("Nenhum registro para o c�digo informado."),

            "q172_datacadastro.required" => utf8_encode("Data de cadastro n�o informada."),
            "q172_datacadastro.filled"   => utf8_encode("Data de cadastro vazia."),
            "q172_datacadastro.date"     => utf8_encode("Data de cadastro inv�lida."),

            "q172_issbase.required"        => utf8_encode("Inscri��o n�o informada."),
            "q172_issbase.filled"          => utf8_encode("Inscri��o informada est� vazia."),
            "q172_issbase.integer"         => utf8_encode("Inscri��o inv�lida."),

            "q172_tipo.integer"          => utf8_encode("Tipo inv�lido."),

            "q172_marca.integer"         => utf8_encode("Marca inv�lida."),

            "q172_modelo.integer"        => utf8_encode("Modelo inv�lido."),

            "q172_procedencia.integer"   => utf8_encode("Procedencia inv�lida."),

            "q172_categoria.integer"     => utf8_encode("Categoria inv�lida."),

            "q172_chassi.string"        => utf8_encode("Chassi inv�lido."),

            "q172_renavam.string"       => utf8_encode("Renavan inv�lido."),

            "q172_placa.string"         => utf8_encode("Placa inv�lida."),

            "q172_potencia.string"      => utf8_encode("Potencia inv�lida."),

            "q172_capacidade.integer"    => utf8_encode("Capacidade inv�lida."),

            "q172_anofabricacao.integer" => utf8_encode("Ano de Fabrica��o inv�lido."),

            "q172_anomodelo.integer"     => utf8_encode("Ano modelo inv�lido."),


        ];
    }
}
