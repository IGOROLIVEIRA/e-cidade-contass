<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoFuncao;

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
            'id' => 'required|integer|exists:jetomcomissaofuncao,rh246_sequencial',
            'comissao' => [
                'required',
                'integer',
                'exists:jetomcomissao,rh242_sequencial',
            ],
            'funcao' => [
                'required',
                'integer',
                'exists:jetomfuncao,rh241_sequencial',
                Rule::unique("jetomcomissaofuncao", "rh246_funcao")
                    ->where("rh246_comissao", $this->request->get('comissao'))
                    ->whereNot("rh246_sequencial", $this->request->get('id'))
            ],
            'quantidade' => [
                'integer',
                'required'
            ],
        ];
    }

    /**
     * @param  array $errors
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
            "id.required" => utf8_encode("C�digo da configura��o da fun��o da comiss�o n�o informado."),
            "id.integer" => utf8_encode("C�digo inv�lido da configura��o da fun��o da comiss�o."),
            "id.exists" => utf8_encode("Configura��o da fun��o da comiss�o n�o encontrada."),
            "comissao.required" => utf8_encode("C�digo da comiss�o n�o informado."),
            "comissao.integer" => utf8_encode("C�digo inv�lido da comiss�o."),
            "comissao.exists" => utf8_encode("Comiss�o n�o encontrada"),
            "funcao.required" => utf8_encode("C�digo da fun��o n�o informado."),
            "funcao.integer" => utf8_encode("C�digo inv�lido da fun��o."),
            "funcao.exists" => utf8_encode("Fun��o n�o encontrada."),
            "funcao.unique" => utf8_encode("Fun��o j� cadastrada para a comiss�o."),
            "quantidade.required" => utf8_encode("Quantidade n�o informada."),
            "quantidade.integer" => utf8_encode("Quantidade inv�lida"),
        ];
    }
}
