<?php

use Phinx\Migration\AbstractMigration;

class Oc21744 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        ALTER TABLE orcamento.ppalei ADD o01_numeroleiano2 varchar(10) NULL;
        ALTER TABLE orcamento.ppalei ADD o01_numeroleiano3 varchar(10) NULL;
        ALTER TABLE orcamento.ppalei ADD o01_numeroleiano4 varchar(10) NULL;

        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_numeroloaano2 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_numeroloaano3 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_numeroloaano4 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataloaano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataloaano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataloaano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapublicacaoldoano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapublicacaoldoano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapublicacaoldoano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataldoano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataldoano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataldoano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubloaano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubloaano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubloaano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percsuplementacaoano2 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percsuplementacaoano3 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percsuplementacaoano4 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percaroano2 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percaroano3 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percaroano4 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percopercreditoano2 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percopercreditoano3 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_percopercreditoano4 numeric(10, 2) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_orcmodalidadeaplicano2 bool NOT NULL DEFAULT false;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_orcmodalidadeaplicano3 bool NOT NULL DEFAULT false;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_orcmodalidadeaplicano4 bool NOT NULL DEFAULT false;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoppaano2 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoppaano3 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoppaano4 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoppaano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoppaano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoppaano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoldo varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoldoano2 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoldoano3 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_leialteracaoldoano4 varchar(50) NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoldo date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoldoano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoldoano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_dataalteracaoldoano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoldo date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoldoano2 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoldoano3 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ADD o142_datapubalteracaoldoano4 date NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ALTER COLUMN o142_orcmodalidadeaplic DROP NOT NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ALTER COLUMN o142_orcmodalidadeaplicano2 DROP NOT NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ALTER COLUMN o142_orcmodalidadeaplicano3 DROP NOT NULL;
        ALTER TABLE orcamento.ppaleidadocomplementar ALTER COLUMN o142_orcmodalidadeaplicano4 DROP NOT NULL;






                
    COMMIT; 

SQL;
        $this->execute($sql);
    } 
}
