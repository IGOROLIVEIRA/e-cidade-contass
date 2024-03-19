<?php

use Phinx\Migration\AbstractMigration;

class SicomEmp2024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            DROP TABLE public.emp102024 CASCADE;

            CREATE TABLE public.emp102024 (
                si106_sequencial int8 NOT NULL DEFAULT 0,
                si106_tiporegistro int8 NOT NULL DEFAULT 0,
                si106_codorgao varchar(2) NOT NULL,
                si106_codunidadesub varchar(8) NOT NULL,
                si106_codfuncao varchar(2) NOT NULL,
                si106_codsubfuncao varchar(3) NOT NULL,
                si106_codprograma varchar(4) NOT NULL,
                si106_idacao varchar(4) NOT NULL,
                si106_idsubacao varchar(4) NULL,
                si106_naturezadespesa int8 NOT NULL DEFAULT 0,
                si106_subelemento varchar(2) NOT NULL,
                si106_nroempenho int8 NOT NULL DEFAULT 0,
                si106_dtempenho date NOT NULL,
                si106_modalidadeempenho int8 NOT NULL DEFAULT 0,
                si106_tpempenho varchar(2) NOT NULL,
                si106_vlbruto float8 NOT NULL DEFAULT 0,
                si106_especificacaoempenho varchar(500) NOT NULL,
                si106_despdeccontrato int8 NOT NULL DEFAULT 0,
                si106_codorgaorespcontrato varchar(2) NULL,
                si106_codunidadesubrespcontrato varchar(8) NULL,
                si106_nrocontrato varchar(14) NULL DEFAULT 0,
                si106_dtassinaturacontrato date NULL,
                si106_nrosequencialtermoaditivo varchar(2) NULL,
                si106_despdecconvenio int8 NOT NULL DEFAULT 0,
                si106_nroconvenio varchar(30) NULL,
                si106_dataassinaturaconvenio date NULL,
                si106_despdecconvenioconge int8 NOT NULL DEFAULT 0,
                si106_nroconvenioconge varchar(30) NULL,
                si106_dataassinaturaconvenioconge date NULL,
                si106_despdeclicitacao int8 NOT NULL DEFAULT 0,
                si106_numdocumentoorgao varchar(14) NULL,
                si106_codunidadesubresplicit varchar(8) NULL,
                si106_nroprocessolicitatorio varchar(12) NULL,
                si106_exercicioprocessolicitatorio int8 NULL DEFAULT 0,
                si106_tipoprocesso int8 NULL DEFAULT 0,
                si106_cpfordenador varchar(11) NOT NULL,
                si106_mes int8 NOT NULL DEFAULT 0,
                si106_instit int8 NULL DEFAULT 0,
                CONSTRAINT emp102024_sequ_pk PRIMARY KEY (si106_sequencial)
            );
        ";
        $this->execute($sql);
    }
}
