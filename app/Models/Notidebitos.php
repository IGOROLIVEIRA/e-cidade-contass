<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Database\Capsule\Manager as DB;

class Notidebitos extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'caixa.notidebitos';

    /**
     * @var string
     */
    protected $primaryKey = 'k53_notifica, k53_numpre, k53_numpar';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'k53_notifica', 'k53_numpre', 'k53_numpar'
    ];

    public static function getSomaTributosCorrigidosPorAnoDescricao(string $codigoNotificacao, DateTime $dataAtual, DateTime $dataVencimento, DateTime $dataTabelaDebitos, int $anoAtual): array
    {
        return DB::connection()->select("
    SELECT tributo,
       k22_ano,
       round(sum(db_vlrhis),2) AS k22_vlrhis,
       round(sum(db_vlrcor),2) AS k22_vlrcor,
       round(sum(db_vlrjuros),2) AS k22_juros,
       round(sum(db_vlrmulta),2) AS k22_multa,
       round(sum(db_vlrdesconto),2) AS k22_desconto,
       round(sum(db_total),2) AS k22_total
            FROM
              (SELECT k53_numpre,
                      k53_numpar,
                      k22_tipo,
                      tributo,
                      k22_ano,
                      substr(fc_calcula, 2, 13)::float8 AS db_vlrhis,
                      substr(fc_calcula, 15, 13)::float8 AS db_vlrcor,
                      substr(fc_calcula, 28, 13)::float8 AS db_vlrjuros,
                      substr(fc_calcula, 41, 13)::float8 AS db_vlrmulta,
                      substr(fc_calcula, 54, 13)::float8 AS db_vlrdesconto,
                      (substr(fc_calcula, 15, 13)::float8+substr(fc_calcula, 28, 13)::float8+substr(fc_calcula, 41, 13)::float8-substr(fc_calcula, 54, 13)::float8) AS db_total
               FROM
                 (SELECT DISTINCT k53_numpre,
                                  k53_numpar,
                                  k22_tipo,
                                  CASE
                                      WHEN arretipo.k03_tipo = 5 THEN proced.v03_descr
                                      ELSE arretipo.k00_descr
                                  END AS tributo,
                                  CASE
                                      WHEN k22_exerc IS NULL THEN EXTRACT (YEAR
                                                                           FROM k22_dtoper)
                                      ELSE k22_exerc
                                  END AS k22_ano,
                                  fc_calcula(k53_numpre, k53_numpar, 0, '{$dataAtual->format('Y-m-d')}', '{$dataVencimento->format('Y-m-d')}', {$anoAtual}) AS fc_calcula
                  FROM notidebitos
                  INNER JOIN debitos ON k22_numpre = k53_numpre
                  AND k22_numpar = k53_numpar
                  AND k22_data = '{$dataTabelaDebitos->format('Y-m-d')}'
                  INNER JOIN arretipo ON k00_tipo = k22_tipo
                  LEFT JOIN divida ON divida.v01_numpre = notidebitos.k53_numpre
                  AND divida.v01_numpar = notidebitos.k53_numpar
                  LEFT JOIN proced ON proced.v03_codigo = divida.v01_proced
                  WHERE k53_notifica = '{$codigoNotificacao}'
                    AND EXISTS
                      (SELECT 1
                       FROM arrecad
                       WHERE arrecad.k00_numpre = debitos.k22_numpre
                         AND arrecad.k00_numpar = debitos.k22_numpar
                       LIMIT 1) ) AS x) AS y
            GROUP BY tributo,
                     k22_ano
        ");
    }
}
