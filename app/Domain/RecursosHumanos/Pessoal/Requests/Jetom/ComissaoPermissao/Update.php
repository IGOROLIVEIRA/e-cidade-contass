<?php

namespace App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\ComissaoPermissao;

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
     * @return array|bool
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:jetompermissao,rh251_sequencial',
            'comissao' => 'required|filled|integer',
            'matricula' => [
                'required',
                'filled',
                'integer',
                Rule::unique(
                    'jetompermissao',
                    'rh251_matricula'
                )
                ->where(
                    "rh251_comissao",
                    $this->request->get('comissao')
                ),
            ],
        ];
    }

    /**
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
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
            "id.required" => utf8_encode("C�digo da Permiss�o n�o informado."),
            "id.integer" => utf8_encode("C�digo inv�lido da Permiss�o."),
            "id.exists" => utf8_encode("Permiss�o n�o encontrada."),

            "comissao.required" => utf8_encode("Comiss�o n�o informada para o cadastro da comiss�o."),
            "comissao.filled" => utf8_encode("O c�digo da Comiss�o esta vazio."),
            "comissao.integer" => utf8_encode("C�digo inv�lido da Comiss�o."),

            "matricula.required" => utf8_encode("� necess�rio informar a Matricula da comiss�o."),
            "matricula.filled" => utf8_encode("Matricula n�o pode estar vazia."),
            "matricula.integer" => utf8_encode("Matricula inv�lida."),
            "matricula.unique" => utf8_encode("Esta matricula j� tem cadastro na permiss�o."),
        ];
    }
}
