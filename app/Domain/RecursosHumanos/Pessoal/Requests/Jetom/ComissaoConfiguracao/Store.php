<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoConfiguracao;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Requests\BaseFormRequest;
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
                Rule::unique("jetomcomissaoconfiguracao", "rh243_comissao")
                ->where("rh243_funcao", $this->request->get('funcao'))
                ->where("rh243_tiposessao", $this->request->get('tiposessao'))
            ],
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial'
            ],
            'tiposessao' => [
                'required',
                'integer',
                'exists:jetomtiposessao,rh240_sequencial'
            ],
            'rubrica' => [
                'string',
                'required',
                'max:4'
            ],
            'valor' => [
                'numeric',
                'required',
                'regex:/^\d+(\.\d{1,2})?$/'
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
            "comissao.exists" => utf8_encode("N�o foi encontrada a comiss�o com o c�digo informado."),
            "comissao.unique" => utf8_encode("Configura��o j� cadastrada."),
            "funcao.required" => utf8_encode("C�digo da fun��o n�o informado."),
            "funcao.integer" => utf8_encode("C�digo inv�lido da fun��o."),
            "funcao.exists" => utf8_encode("Fun��o n�o encontrada."),
            "tiposessao.required" => utf8_encode("Tipo de sess�o n�o informado."),
            "tiposessao.integer" => utf8_encode("C�digo inv�lido para o tipo de sess�o informado."),
            "tiposessao.exists" => utf8_encode("Tipo de sess�o n�o encontrado."),
            "valor.required" => utf8_encode("Valor n�o informado."),
            "valor.numeric" => utf8_encode("Valor inv�lido."),
            "valor.regex" => utf8_encode("O formato do valor esta inv�lido."),
        ];
    }
}
