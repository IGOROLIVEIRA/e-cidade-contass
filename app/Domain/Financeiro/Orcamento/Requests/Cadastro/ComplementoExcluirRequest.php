<?php

namespace App\Domain\Financeiro\Orcamento\Requests\Cadastro;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class ComplementoRequest
 * @package App\Domain\Financeiro\Orcamento\Requests\Cadastro
 */
class ComplementoExcluirRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @param array $errors
     * @return DBJsonResponse|JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $mensagem = $errors[array_keys($errors)[0]][0];
        return new DBJsonResponse($errors, $mensagem, 406, false);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'codigo' => 'required|integer',
        ];
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [
            'codigo.required' => '� obrigat�rio informar o C�digo do complemento a ser exclu�do.',
            'codigo.integer' => 'O C�digo deve ser um inteiro.',
        ];
    }
}
