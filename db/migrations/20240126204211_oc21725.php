<?php

use Phinx\Migration\AbstractMigration;

class Oc21725 extends AbstractMigration
{

    public function up()
    {
        $sSql = "BEGIN;

        ALTER TABLE dispensa102024 ADD COLUMN si74_codunidadesubedital varchar(8);
        ALTER TABLE dispensa102024 ADD COLUMN si74_tipocriterio int;

        CREATE TABLE public.dispensa302024 (
            si203_sequencial int8 NOT NULL,
            si203_tiporegistro int4 NOT NULL,
            si203_codorgaoresp int4 NOT NULL,
            si203_codunidadesubresp varchar(8) NOT NULL,
            si203_exercicioprocesso int4 NOT NULL,
            si203_nroprocesso varchar(16) NOT NULL,
            si203_tipoprocesso int4 NOT NULL,
            si203_tipodocumento int4 NOT NULL,
            si203_nrodocumento varchar(14) NOT NULL,
            si203_nrolote int4 NULL,
            si203_coditem int4 NULL,
            si203_percdesconto int4 NOT NULL,
            si203_mes int8 NOT NULL DEFAULT 0,
            si203_instit int8 NULL DEFAULT 0,
            CONSTRAINT dispensa302024_sequ_pk PRIMARY KEY (si203_sequencial)
        );  
        
        CREATE TABLE public.dispensa402024 (
            si204_sequencial int8 NOT NULL,
            si204_tiporegistro int4 NOT NULL,
            si204_codorgaoresp int4 NOT NULL,
            si204_codunidadesubresp varchar(8) NOT NULL,
            si204_exercicioprocesso int4 NOT NULL,
            si204_nroprocesso varchar(16) NOT NULL,
            si204_tipoprocesso int4 NOT NULL,
            si204_tipodocumento int4 NOT NULL,
            si204_nrodocumento varchar(14) NOT NULL,
            si204_nrolote int4 NULL,
            si204_coditem int4 NULL,
            si204_perctaxaadm int4 NOT NULL,
            si204_mes int8 NOT NULL DEFAULT 0,
            si204_instit int8 NULL DEFAULT 0,
            CONSTRAINT dispensa402024_sequ_pk PRIMARY KEY (si204_sequencial)
        );

        COMMIT;
        ";

        $this->execute($sSql);
    }
}
