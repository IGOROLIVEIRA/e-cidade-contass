<?php


namespace App\Domain\Financeiro\Contabilidade\Requests\Procedimento;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class ManutencaoFonteRecursoDespesaRequest
 * @package App\Domain\Financeiro\Contabilidade\Requests\Procedimento
 */
class ManutencaoFonteRecursoDespesaRequest extends FormRequest
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
            'recurso' => 'nullable|string|required_without:idEmpenho',
            'idEmpenho' => 'nullable|integer|required_without:recurso',
            'codigoReceita' => 'nullable|string',
            'dataInicio' => 'date|nullable|required_without:idEmpenho',
            'dataFinal' => 'date|nullable|required_without:idEmpenho',
            'DB_anousu' => 'required',
        ];
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
    public function messages()
    {
        return [
            'recurso.string' => 'O recurso deve ser um código válido.',
            'recurso.required_without' => 'O recurso é obrigatório quando não informado o empenho.',
            'idEmpenho.required_without' => 'O código do empenho deve ser preenchido se não informado o recurso.',
            'dataInicio.date' => "Data Inicial deve ser uma data válida e estar no formato Y-m-d.",
            'dataFinal.date' => "Data Final deve ser uma data válida e estar no formato Y-m-d.",
            'dataInicio.required_without' => "Data Inicial é obrigatória quando não informado empenho.",
            'dataFinal.required_without' => "Data Final é obrigatório quando não informado empenho.",
        ];
    }
}
