<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoTipoSessao;

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
            ],
            'tiposessao' => [
                'required',
                'integer',
                'exists:jetomtiposessao,rh240_sequencial',
                Rule::unique("jetomcomissaotiposessao", "rh249_tiposessao")
                ->where("rh249_comissao", $this->request->get('comissao'))

            ],
            'quantidade' => [
                'integer',
                'required'
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
            "comissao.required" => utf8_encode("C�digo do tipo de sess�o da comiss�o n�o informado."),
            "comissao.integer" => utf8_encode("C�digo inv�lido do tipo de sess�o da comiss�o."),
            "comissao.exists" => utf8_encode("C�digo n�o encontrado do tipo de sess�o da comiss�o."),
            "tiposessao.required" => utf8_encode("C�digo do tipo de sess�o n�o informado."),
            "tiposessao.integer" => utf8_encode("C�digo inv�lido do tipo de sess�o."),
            "tiposessao.exists" => utf8_encode("C�digo n�o encontrado do tipo de sess�o."),
            "tiposessao.unique" => utf8_encode("Tipo de sess�o j� cadastrado para a comiss�o."),
            "quantidade.required" => utf8_encode("Quantidade n�o informada."),
            "quantidade.integer" => utf8_encode("Quantidade inv�lida."),
        ];
    }
}
