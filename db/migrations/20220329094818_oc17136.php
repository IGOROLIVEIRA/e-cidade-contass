<?php

use Phinx\Migration\AbstractMigration;

class Oc17136 extends AbstractMigration
{
    public function up()
    {
        $sql = "begin; ";
        $sql .= "drop table if exists dfcdcasp102021; ";
        $sql .= "CREATE TABLE public.dfcdcasp102021 (
            si219_sequencial int4 NOT NULL DEFAULT 0,
            si219_tiporegistro int4 NOT NULL DEFAULT 0,
            si219_vlreceitatributaria float8 NOT NULL DEFAULT 0,
            si219_vlreceitacontribuicao float8 NOT NULL DEFAULT 0,
            si219_vlreceitapatrimonial float8 NOT NULL DEFAULT 0,
            si219_vlreceitaagropecuaria float8 NOT NULL DEFAULT 0,
            si219_vlreceitaindustrial float8 NOT NULL DEFAULT 0,
            si219_vlreceitaservicos float8 NOT NULL DEFAULT 0,
            si219_vlremuneracaodisponibilidade float8 NOT NULL DEFAULT 0,
            si219_vloutrasreceitas float8 NOT NULL DEFAULT 0,
            si219_vltransferenciarecebidas float8 NOT NULL DEFAULT 0,
            si219_vloutrosingressosoperacionais float8 NOT NULL DEFAULT 0,
            si219_vltotalingressosativoperacionais float8 NULL DEFAULT 0,
            si219_anousu int4 NOT NULL DEFAULT 0,
            si219_periodo int4 NOT NULL DEFAULT 0,
            si219_instit int4 NOT NULL DEFAULT 0
        ); ";
        $sql .="commit; ";
        $this->execute($sql);
    }
}
