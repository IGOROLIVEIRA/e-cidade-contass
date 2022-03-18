<?php

use Phinx\Migration\AbstractMigration;

class Oc16966BpDcasp102021 extends AbstractMigration
{
    public function up()
    {
        $sql = "begin;";
        $sql .= "drop table if exists bpdcasp102021;";
        $sql .= "drop table if exists bpdcasp202021; ";
        $sql .= "CREATE TABLE public.bpdcasp102021 (
            si208_sequencial int4 NOT NULL DEFAULT 0,
            si208_tiporegistro int4 NOT NULL DEFAULT 0,
            si208_vlativocircucaixaequicaixa float8 NOT NULL DEFAULT 0,
            si208_vlativocircucredicurtoprazo float8 NOT NULL DEFAULT 0,
            si208_vlativocircuinvestapliccurtoprazo float8 NOT NULL DEFAULT 0,
            si208_vlativocircudemaiscredicurtoprazo float8 NOT NULL DEFAULT 0,
            si208_vlativocircuestoques float8 NOT NULL DEFAULT 0,
            si208_vlativonaocircumantidovenda float8 NOT NULL DEFAULT 0,
            si208_vlativocircuvpdantecipada float8 NOT NULL DEFAULT 0,
            si208_vlativonaocircurlp float8 NOT NULL DEFAULT 0,
            si208_vlativonaocircuinvestimentos float8 NOT NULL DEFAULT 0,
            si208_vlativonaocircuimobilizado float8 NOT NULL DEFAULT 0,
            si208_vlativonaocircuintagivel float8 NOT NULL DEFAULT 0,
            si208_vltotalativo float8 NULL DEFAULT 0,
            si208_ano int4 NOT NULL DEFAULT 0,
            si208_periodo int4 NOT NULL DEFAULT 0,
            si208_institu int4 NOT NULL DEFAULT 0
        );";
        $sql .= "CREATE TABLE public.bpdcasp202021 (
            si209_sequencial int4 NOT NULL DEFAULT 0,
            si209_tiporegistro int4 NOT NULL DEFAULT 0,
            si209_exercicio int4 NOT NULL DEFAULT 0,
            si209_vlpassivcircultrabprevicurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassivcirculemprefinancurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassivocirculafornecedcurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassicircuobrigfiscacurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassivocirculatransffiscalcurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassivocirculaprovisoecurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassicircudemaiobrigcurtoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassinaocircutrabprevilongoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassnaocircemprfinalongpraz float8 NOT NULL DEFAULT 0,
            si209_vlpassivnaocirculforneclongoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassivonaocirculatransffiscallongoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassnaocircobrifisclongpraz float8 NOT NULL DEFAULT 0,
            si209_vlpassivnaocirculprovislongoprazo float8 NOT NULL DEFAULT 0,
            si209_vlpassnaocircdemaobrilongpraz float8 NOT NULL DEFAULT 0,
            si209_vlpassivonaocircularesuldiferido float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidocapitalsocial float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoadianfuturocapital float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoreservacapital float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoajustavaliacao float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoreservalucros float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidodemaisreservas float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoresultexercicio float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidresultacumexeranteri float8 NOT NULL DEFAULT 0,
            si209_vlpatriliquidoacoescotas float8 NOT NULL DEFAULT 0,
            si209_vltotalpassivo float8 NULL DEFAULT 0,
            si209_ano int4 NOT NULL DEFAULT 0,
            si209_periodo int4 NOT NULL DEFAULT 0,
            si209_institu int4 NOT NULL DEFAULT 0
        ) ;";
        $sql .= "commit;";

        $this->execute($sql);
    }
}
