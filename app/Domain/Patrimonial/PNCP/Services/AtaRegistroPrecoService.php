<?php

namespace App\Domain\Patrimonial\PNCP\Services;

use App\Domain\Patrimonial\PNCP\Builders\AtaRegistroPrecoBuilder;
use App\Domain\Patrimonial\PNCP\Builders\RetificacaoAtaBuilder;
use App\Domain\Patrimonial\PNCP\Clients\AtaRegistroPrecoClient;
use App\Domain\Patrimonial\PNCP\Exceptions\CompraEditalAvisoExcpetion;
use App\Domain\Patrimonial\PNCP\Models\ComprasPncp;
use Illuminate\Http\Request;

class AtaRegistroPrecoService
{
    private $http;

    public function __construct()
    {
        $this->http = new AtaRegistroPrecoClient();
    }


    /**
     * @param Request $request
     * @return string[]
     * @throws \Exception
     */
    public function incluir(Request $request)
    {
        $compra = ComprasPncp::where('pn03_liclicita', $request->get('licitacao'))->first();
        $builder = new AtaRegistroPrecoBuilder();
        $builder->setDados($request);
        $dados = $builder->build();
        $link = "https://pncp.gov.br/app/atas/{$request->get('cnpj')}/{$compra->pn03_ano}/$compra->pn03_numero/";

        if (!empty($compra)) {
            try {
                $response = $this->http->incluir(
                    $request->get('cnpj'),
                    $compra->pn03_ano,
                    $compra->pn03_numero,
                    $dados
                );
                $response = explode('/', $response);
                return [
                    'link' => $link . $response[11]
                ];
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
        }
    }

    public function buscar(Request $request)
    {
        $compra = ComprasPncp::where('pn03_liclicita', $request->get('licitacao'))->first();
        $response = [];
        if (!empty($compra)) {
            try {
                $response = $this->http->buscar($request->get('cnpj'), $compra->pn03_ano, $compra->pn03_numero);
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
        }

        return (array)$response;
    }

    public function excluir(Request $request)
    {
        $compra = ComprasPncp::where('pn03_liclicita', $request->get('licitacao'))->first();

        if (!empty($compra)) {
            try {
                $response = $this->http->excluir(
                    $request->get('cnpj'),
                    $compra->pn03_ano,
                    $compra->pn03_numero,
                    $request->get('sequencialAta')
                );
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
        }
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function retificar(Request $request)
    {
        $compra = ComprasPncp::where('pn03_liclicita', $request->get('licitacao'))->first();
        $builder = new RetificacaoAtaBuilder();
        $builder->setDados($request);
        $dados = $builder->build();
        if (!empty($compra)) {
            try {
                 $this->http->retificar(
                     $request->get('cnpj'),
                     $compra->pn03_ano,
                     $compra->pn03_numero,
                     $request->get('sequencialAta'),
                     $dados
                 );
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
        }
    }
}
