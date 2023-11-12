<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Comissao;

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
     * @return array|bool
     */
    public function rules()
    {
        return $this->preValidacaoRule() ? $this->preValidacaoRule() : [
            'instituicao' => 'required|filled|integer|max:50',
            'descricao' => [
                'required',
                'filled',
                'string',
                'max:50',
                Rule::unique(
                    'jetomcomissao',
                    'rh242_descricao'
                )->where(
                    "rh242_instit",
                    $this->request->all()['instituicao']
                ),
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
            "descricao.required" => utf8_encode("� necess�rio informar a descri��o da comiss�o."),
            "descricao.filled" => utf8_encode("Descri��o n�o pode estar vazia."),
            "descricao.string" => utf8_encode("Descri��o inv�lida."),
            "descricao.unique" => utf8_encode("Esta descri��o j� cadastrada na institui��o."),
            "descricao.max" => utf8_encode("Excedido o limite m�ximo de 50 caracteres."),
            "instituicao.required" => utf8_encode("Institui��o n�o informada para o cadastro da comiss�o."),
            "instituicao.filled" => utf8_encode("O c�digo da institui��o esta vazio."),
            "instituicao.integer" => utf8_encode("C�digo inv�lido da Institui��o."),
        ];
    }
}
