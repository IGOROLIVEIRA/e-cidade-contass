<?php

namespace App\Domain\Saude\Farmacia\Services;

use App\Domain\Saude\Farmacia\Clients\BnafarClient;
use App\Domain\Saude\Farmacia\Exceptions\BnafarException;
use App\Domain\Saude\Farmacia\Relatorios\ProtocoloBnafarPdf;
use App\Domain\Saude\Farmacia\Requests\RelatorioProtocoloBnafarRequest;
use App\Domain\Saude\Farmacia\Resources\ConsultaProtocoloBnafarResource;

class BnafarProtocoloService
{
    /**
     * @param \UnidadeProntoSocorro $unidade
     * @param \DateTime[] $periodo
     * @param integer $pagina
     * @param integer $tamanho
     * @return object
     * @throws \Exception
     */
    public function consultar(\UnidadeProntoSocorro $unidade, array $periodo, $pagina, $tamanho)
    {
        $periodoInicio = $periodo[0]->format('Y-m-d');
        $periodoFim = $periodo[1]->format('Y-m-d');
        $dataAtual = new \DateTime();
        if ($dataAtual->getTimestamp() < $periodo[1]->getTimestamp()) {
            $periodoFim = $dataAtual->format('Y-m-d');
        }

        try {
            $client = new BnafarClient($unidade);
            $response = $client->pesquisarProtocolos($periodoInicio, $periodoFim, $pagina - 1, $tamanho);
            return ConsultaProtocoloBnafarResource::toBootstrapTable($response);
        } catch (BnafarException $e) {
            throw new \Exception($e->getDetalhes());
        }
    }

    /**
     * @param RelatorioProtocoloBnafarRequest $request
     * @return string[]
     */
    public function gerarRelatorio(RelatorioProtocoloBnafarRequest $request)
    {
        $dados = json_decode(stripslashes(utf8_encode($request->data)));
        $dados = \DBString::utf8_decode_all($dados);

        $pdf = new ProtocoloBnafarPdf($dados);

        return $pdf->imprimir();
    }
}
