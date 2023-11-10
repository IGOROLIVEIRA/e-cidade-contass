<?php

namespace App\Domain\Saude\Farmacia\Resources;

use ECidade\Enum\Saude\Farmacia\SituacaoProcessamentoBnafarEnum;
use ECidade\Enum\Saude\Farmacia\TipoOperacaoBnafarEnum;
use ECidade\Enum\Saude\Farmacia\TipoServicoBnafarEnum;

class ConsultaProtocoloBnafarResource
{
    /**
     * @param object $response
     * @return object
     * @throws \Exception
     */
    public static function toBootstrapTable($response)
    {
        $rows = [];

        if (property_exists($response, 'content')) {
            foreach ($response->content as $data) {
                $rows[] = (object)[
                    'protocolo' => $data->protocolo,
                    'codigoIbge' => $data->codigoIbge,
                    'usuarioEnvio' => $data->usuarioEnvio,
                    'dataProtocolo' => date_format(new \DateTime($data->dataProtocolo), 'd/m/Y H:i'),
                    'situacao' => (new SituacaoProcessamentoBnafarEnum($data->situacao))->name(),
                    'tipoServico' => (new TipoServicoBnafarEnum($data->tipoServico))->name(),
                    'tipoOperacao' => (new TipoOperacaoBnafarEnum($data->tipoOperacao))->name()
                ];
            }
        }

        return (object)[
            'total' => $response->totalElements,
            'rows' => $rows
        ];
    }
}
