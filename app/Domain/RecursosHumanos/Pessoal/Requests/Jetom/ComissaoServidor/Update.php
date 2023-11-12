<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoServidor;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

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
            'id' => 'required|integer|exists:jetomcomissaoservidor,rh245_sequencial',
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
            'ativo' => 'required',
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
        $mensagem = $errors[array_keys($errors)[0]][0];
        return new DBJsonResponse([], $mensagem, 406);
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            "id.required" => "C�digo da fun��o do servidor n�o informado.",
            "id.integer" => "C�digo inv�lido da fun��o do servidor.",
            "id.exists" => "C�digo n�o encontrado da fun��o do servidor.",
            "comissao.required" => "C�digo da comiss�o n�o informado.",
            "comissao.integer" => "C�digo inv�lido da comiss�o.",
            "comissao.exists" => "Comiss�o n�o encontrada.",
            "funcao.required" => "Fun��o do servidor n�o informada.",
            "funcao.integer" => "Fun��o inv�lida do servidor.",
            "funcao.exists" => "Fun��o n�o encontrada.",
            "funcao.unique" => "Fun��o j� cadastrada para o servidor.",
            "matricula.required" => "Matricula n�o informada.",
            "matricula.integer" => "Matricula inv�lida.",
            "mesinicio.integer" => "M�s de inicio da fun��o inv�lido.",
            "mesinicio.between" => "M�s de inicio da fun��o deve ser entre 1 e 12.",
            "mesfim.integer" => "M�s de termino da fun��o inv�lido.",
            "mesfim.between" => "M�s de termino da fun��o deve ser entre 1 e 12.",
            "anoinicio.integer" => "Ano de inicio da fun��o inv�lido.",
            "anoinicio.min" => "Ano inicial n�o pode ser inferior a " . date("Y") . ".",
            "anofim.integer" => "Ano de termino da fun��o inv�lido.",
            "ativo.required" => "O status de ativo n�o informado para a fun��o do servidor.",
        ];
    }
}
