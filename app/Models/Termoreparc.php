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

    public function termo()
    {
        return $this->belongsTo(Termo::class, 'v08_parcel', 'v07_parcel');
    }

    public static function getQueryOriginReInstalmentFromParentInstallment(int $instalmentNumber, int $instit): string
    {
        return "
                  SELECT 4 as SELECT,
                        y.v08_parcelorigem,
                        y.k00_numpar  as v01_exerc,
                        (select k03_tipo from arretipo where k00_tipo = y.tipo) as k03_tipo,
                        y.tipo,
                        y.k00_descr,
                        y.k00_valor   as valor,
                        y.vlrcor,
                        y.juros,
                        y.multa,
                        y.desconto,
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
                FROM (
                select xx.*,
                    (select k00_descr from arretipo where k00_tipo = coalesce(xx.k00_tipo, 5) limit 1) as k00_descr,
                    coalesce(xx.k00_tipo, 5) as tipo
                    from
                  (SELECT DISTINCT termoreparc.*,
                                   coalesce(tipoparc.descjur, 0) AS descjur,
                                   coalesce(tipoparc.descmul, 0) AS descmul,
                                   coalesce(tipoparc.descvlr, 0) AS desccor,
                                   termoori.v07_numpre,
                                   termoori.v07_numcgm,
                                   0 as k00_receit,
                                   0 as k00_tipojm,
                                   termoori.v07_numpre k00_numpre,
                                   extract('Y' from termoori.v07_dtlanc) k00_numpar,
                                   termoori.v07_totpar k00_numtot,
                                   0 as k00_numdig,
                                   termoori.v07_vlrhis as k00_valor,
                                   termoori.v07_dtvenc as k00_dtvenc,
                                   termoori.v07_vlrcor AS vlrcor,
                                   termoori.v07_vlrjur AS juros,
                                   termoori.v07_vlrmul AS multa,
                                   termoori.v07_vlrdes AS desconto,
                                   case when termoori.v07_situacao = 1 then (select k00_tipo from arrecad where k00_numpre = termoori.v07_numpre limit 1)
                                        when termoori.v07_situacao in (2,3) then (select k00_tipo from arrecant where k00_numpre = termoori.v07_numpre limit 1)
                                   end as k00_tipo

                   FROM termoreparc
                   INNER JOIN termo termoori ON v08_parcelorigem = termoori.v07_parcel
                   AND termoori.v07_instit = {$instit}
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
                   WHERE v08_parcel = {$instalmentNumber}) AS xx ) as y
    ";
    }
}
