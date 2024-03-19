<?php

use Phinx\Migration\AbstractMigration;

class SicomObras2024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        DROP TABLE public.pessoasobra102024;

        CREATE TABLE public.pessoasobra102024 (
            si194_sequencial int8 NULL,
            si194_tipodocumento int8 NULL,
            si194_tiporegistro int8 NULL,
            si194_nrodocumento varchar(14) NULL,
            si194_nome varchar(120) NULL,
            si194_tipocadastro int8 NULL,
            si194_justificativaalteracao text NULL,
            si194_mes int8 NULL,
            si194_instit int4 NULL
        );

        DROP TABLE public.licobras102024;

        CREATE TABLE public.licobras102024 (
            si195_sequencial int8 NULL,
            si195_tiporegistro int8 NULL,
            si195_codorgaoresp varchar(3) NULL,
            si195_codunidadesubrespestadual varchar(4) NULL,
            si195_exerciciolicitacao int8 NULL,
            si195_nroprocessolicitatorio varchar(12) NULL,
            si195_nrolote int8 NULL,
            si195_contdeclicitacao int8 NULL,
            si195_codobra int8 NULL,
            si195_objeto text NULL,
            si195_linkobra text NULL,
            si195_codorgaorespsicom int8 NULL,
            si195_codunidadesubsicom int8 NULL,
            si195_nrocontrato int8 NULL,
            si195_exerciciocontrato int8 NULL,
            si195_dataassinatura date NULL,
            si195_vlcontrato numeric NULL,
            si195_tipodocumento int8 NULL,
            si195_numdocumentocontratado varchar(14) NULL,
            si195_undmedidaprazoexecucao int8 NULL,
            si195_prazoexecucao int8 NULL,
            si195_mes int8 NULL,
            si195_instit int4 NULL
        );

        DROP TABLE public.exeobras102024;

        CREATE TABLE public.exeobras102024 (
            si197_sequencial int8 NULL,
            si197_tiporegistro int8 NULL,
            si197_codorgao varchar(3) NULL,
            si197_codunidadesub varchar(8) NULL,
            si197_nrocontrato int8 NULL,
            si197_tipodocumento int8 NULL,
            si197_numerodocumento varchar(14) NULL,
            si197_exerciciocontrato int8 NULL,
            si197_contdeclicitacao int8 NULL,
            si197_exerciciolicitacao int8 NULL,
            si197_nroprocessolicitatorio int8 NULL,
            si197_codunidadesubresp int8 NULL,
            si197_nrolote int8 NULL,
            si197_codobra int8 NULL,
            si197_objeto text NULL,
            si197_linkobra text NULL,
            si197_mes int8 NULL,
            si197_instit int4 NULL
        );

        ";
        $this->execute($sql);
    }
}
