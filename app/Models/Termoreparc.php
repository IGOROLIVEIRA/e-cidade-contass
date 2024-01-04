<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use DateTime;

class Termoreparc extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'divida.termoreparc';

    /**
     * @var string
     */
    protected $primaryKey = 'v08_sequencial';

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
        'v08_sequencial',
        'v08_parcel',
        'v08_parcelorigem',
    ];

    public static function getQueryMonetaryAdjustmentFromFcCalcula(int $instalmentNumber, int $instit, int $year, DateTime $dueDate): string
    {
        $formatedDueDate = $dueDate->format('Y-m-d');
        return "
                  SELECT 4 as SELECT,
                        y.v08_parcelorigem,
                        y.k00_numpar  as v01_exerc,
                        y.k03_tipo,
                        y.k00_tipo    as tipo,
                        y.k00_descr,
                        y.k00_valor   as valor,
                        substr(fc_calcula, 15, 13)::float8 AS vlrcor,
                        substr(fc_calcula, 28, 13)::float8 AS juros,
                        substr(fc_calcula, 41, 13)::float8 AS multa,
                        substr(fc_calcula, 54, 13)::float8 AS desconto,
                        y.k00_dtvenc  as v01_dtvenc,
                        y.v07_numpre,
                        y.k00_numpre,
                        y.k00_numpar,
                        (select coalesce(k00_matric, 0)
                        from arrematric
                        inner join termo on v07_numpre = k00_numpre
                        where v07_parcel = v08_parcelorigem
                        order by k00_perc desc limit 1) as matric,
                        (select coalesce(k00_inscr, 0)
                        from arreinscr
                        inner join termo on v07_numpre = k00_numpre
                        where v07_parcel = v08_parcelorigem
                        order by k00_perc desc limit 1) as inscr,
                        0 as contr,
                        '' as nomematric,
                        '' as nomeinscr,
                        '' as nomecontr,
                        '' as v03_descr
                FROM
                  (SELECT DISTINCT termoreparc.*,
                                   arretipo.*,
                                   coalesce(tipoparc.descjur, 0) AS descjur,
                                   coalesce(tipoparc.descmul, 0) AS descmul,
                                   coalesce(tipoparc.descvlr, 0) AS desccor,
                                   termoori.v07_numpre,
                                   arrecad.k00_numcgm,
                                   arrecad.k00_receit,
                                   arrecad.k00_tipojm,
                                   arrecad.k00_numpre,
                                   arrecad.k00_numpar,
                                   arrecad.k00_numtot,
                                   arrecad.k00_numdig,
                                   arrecad.k00_valor,
                                   arrecad.k00_dtvenc,
                                   fc_calcula(arrecad.k00_numpre, arrecad.k00_numpar, arrecad.k00_receit, '{$formatedDueDate}', '{$formatedDueDate}', {$year})
                   FROM termoreparc
                   INNER JOIN termo termoori ON v08_parcelorigem = termoori.v07_parcel
                   AND termoori.v07_instit = {$instit}
                   INNER JOIN arrecad ON termoori.v07_numpre = arrecad.k00_numpre
                   INNER JOIN arretipo ON arrecad.k00_tipo = arretipo.k00_tipo
                   INNER JOIN cadtipo ON arretipo.k03_tipo = cadtipo.k03_tipo
                   INNER JOIN termo termoatual ON termoatual.v07_parcel = termoreparc.v08_parcel
                   LEFT JOIN cadtipoparc ON cadtipoparc.k40_codigo = termoatual.v07_desconto
                   LEFT JOIN
                     (SELECT *
                      FROM tipoparc
                      INNER JOIN cadtipoparc ON tipoparc.cadtipoparc = cadtipoparc.k40_codigo
                      AND cadtipoparc.k40_instit = {$instit}
                      INNER JOIN termo ON termo.v07_desconto = cadtipoparc.k40_codigo
                      AND termo.v07_instit = {$instit}
                      WHERE termo.v07_parcel = {$instalmentNumber}
                        AND termo.v07_instit = {$instit}
                        AND termo.v07_dtlanc BETWEEN tipoparc.dtini AND tipoparc.dtfim
                        AND termo.v07_totpar BETWEEN 1 AND tipoparc.maxparc
                      ORDER BY maxparc
                      LIMIT 1) AS tipoparc ON tipoparc.cadtipoparc = cadtipoparc.k40_codigo
                   LEFT JOIN cadtipoparcdeb ON cadtipoparc.k40_codigo = cadtipoparcdeb.k41_cadtipoparc
                   AND cadtipoparcdeb.k41_arretipo = arrecad.k00_tipo
                   AND arrecad.k00_dtvenc BETWEEN k41_vencini AND k41_vencfim
                   WHERE v08_parcel = {$instalmentNumber}) AS y
    ";
    }
}
