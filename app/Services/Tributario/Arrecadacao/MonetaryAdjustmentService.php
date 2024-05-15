<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Services\DTO\MonetaryAdjustmentServiceResponse;
use DateTime;
use Illuminate\Database\Capsule\Manager as DB;

class MonetaryAdjustmentService
{
    public function execute(int $numpre, int $numpar, DateTime $dataAtual, DateTime $dataVencimento, int $anoAtual, int $codReceita = 0): MonetaryAdjustmentServiceResponse
    {
        $response = new MonetaryAdjustmentServiceResponse();
        [
            'db_vlrhis' => $response->valorHistorico,
            'db_vlrcor' => $response->valorCorrecao,
            'db_vlrjuros' => $response->valorJuros,
            'db_vlrmulta' => $response->valorMulta,
            'db_vlrdesconto' => $response->valorDesconto,
            'db_total' => $response->valorTotal
        ] = (array) DB::connection()
            ->selectOne("
            select
               substr(fc_calcula,2,13)::float8 as db_vlrhis,
               substr(fc_calcula,15,13)::float8 as db_vlrcor,
               substr(fc_calcula,28,13)::float8 as db_vlrjuros,
               substr(fc_calcula,41,13)::float8 as db_vlrmulta,
               substr(fc_calcula,54,13)::float8 as db_vlrdesconto,
               (substr(fc_calcula,15,13)::float8+substr(fc_calcula,28,13)::float8+substr(fc_calcula,41,13)::float8-substr(fc_calcula,54,13)::float8) as db_total
               from fc_calcula({$numpre}, {$numpar}, {$codReceita}, '{$dataAtual->format('Y-m-d')}','{$dataVencimento->format('Y-m-d')}',{$anoAtual});
            ");
        return $response;
    }
}
