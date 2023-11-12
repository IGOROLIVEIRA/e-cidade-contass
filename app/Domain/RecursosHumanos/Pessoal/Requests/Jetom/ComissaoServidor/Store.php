<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoServidor;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\ComissaoServidor;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\ComissaoFuncao;
use Illuminate\Validation\Rule;

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
            'comissao' => [
                'required',
                'integer',
                'exists:jetomcomissao,rh242_sequencial',
            ],
            'matricula' => 'required|integer',
            'mesinicio' => 'integer|between:1,12',
            'mesfim' => 'integer|between:1,12',
            'anoinicio' => 'integer|min:' . date("Y"),
            'anofim' => 'integer',
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial',
            ],
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
            "comissao.required" => utf8_encode("C�digo da comiss�o n�o informado."),
            "comissao.integer" => utf8_encode("C�digo inv�lido da comiss�o."),
            "comissao.exists" => utf8_encode("Comiss�o n�o encontrada."),
            "funcao.required" => utf8_encode("Fun��o do servidor n�o informada."),
            "funcao.integer" => utf8_encode("Fun��o inv�lida do servidor."),
            "funcao.exists" => utf8_encode("Fun��o n�o encontrada."),
            "funcao.unique" => utf8_encode("Fun��o j� cadastrada para o servidor."),
            "matricula.required" => utf8_encode("Matricula n�o informada."),
            "matricula.integer" => utf8_encode("Matricula inv�lida."),
            "mesinicio.integer" => utf8_encode("M�s de inicio da fun��o inv�lido."),
            "mesinicio.between" => utf8_encode("M�s de inicio da fun��o deve ser entre 1 e 12."),
            "mesfim.integer" => utf8_encode("M�s de termino da fun��o inv�lido."),
            "mesfim.between" => utf8_encode("M�s de termino da fun��o deve ser entre 1 e 12."),
            "anoinicio.integer" => utf8_encode("Ano de inicio da fun��o inv�lido."),
            "anoinicio.min" => utf8_encode("Ano inicial n�o pode ser inferior a " . date("Y") . "."),
            "anofim.integer" => utf8_encode("Ano de termino da fun��o inv�lido."),
        ];
    }
}
