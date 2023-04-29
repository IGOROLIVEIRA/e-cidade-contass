<?php

use Phinx\Migration\AbstractMigration;

class Oc20135 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        DROP TABLE public.balancete142023;

        CREATE TABLE public.balancete142023 (
            si181_sequencial int8 NOT NULL DEFAULT 0,
            si181_tiporegistro int8 NOT NULL DEFAULT 0,
            si181_contacontabil int8 NOT NULL DEFAULT 0,
            si181_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
            si181_codorgao varchar(2) NOT NULL,
            si181_codunidadesub varchar(8) NOT NULL,
            si181_codunidadesuborig varchar(8) NOT NULL,
            si181_codfuncao varchar(2) NOT NULL,
            si181_codsubfuncao varchar(3) NOT NULL,
            si181_codprograma varchar(4) NOT NULL,
            si181_idacao varchar(4) NOT NULL,
            si181_idsubacao varchar(4) NULL,
            si181_naturezadespesa int8 NOT NULL DEFAULT 0,
            si181_subelemento varchar(2) NOT NULL,
            si181_codfontrecursos int8 NOT NULL DEFAULT 0,
            si181_codco int8 NOT NULL DEFAULT 0,
            si181_nroempenho int8 NOT NULL DEFAULT 0,
            si181_anoinscricao int8 NOT NULL DEFAULT 0,
            si181_saldoinicialrsp float8 NOT NULL DEFAULT 0,
            si181_naturezasaldoinicialrsp varchar(1) NOT NULL,
            si181_totaldebitosrsp float8 NOT NULL DEFAULT 0,
            si181_totalcreditosrsp float8 NOT NULL DEFAULT 0,
            si181_saldofinalrsp float8 NOT NULL DEFAULT 0,
            si181_naturezasaldofinalrsp varchar(1) NOT NULL,
            si181_mes int8 NOT NULL DEFAULT 0,
            si181_instit int8 NULL DEFAULT 0,
            si181_reg10 int8 NOT NULL,
            CONSTRAINT balancete142023_sequ_pk PRIMARY KEY (si181_sequencial),
            CONSTRAINT fk_balancete142023_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES public.balancete102023(si177_sequencial)
        ); ";

        $sql .= "
            DROP TABLE public.balancete162023;

            CREATE TABLE public.balancete162023 (
                si183_sequencial int8 NOT NULL DEFAULT 0,
                si183_tiporegistro int8 NOT NULL DEFAULT 0,
                si183_contacontabil int8 NOT NULL DEFAULT 0,
                si183_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
                si183_atributosf varchar(1) NOT NULL,
                si183_codfontrecursos int8 NULL DEFAULT 0,
                si183_codco int8 NULL DEFAULT 0,
                si183_saldoinicialfontsf float8 NOT NULL DEFAULT 0,
                si183_naturezasaldoinicialfontsf varchar(1) NOT NULL,
                si183_totaldebitosfontsf float8 NOT NULL DEFAULT 0,
                si183_totalcreditosfontsf float8 NOT NULL DEFAULT 0,
                si183_saldofinalfontsf float8 NOT NULL DEFAULT 0,
                si183_naturezasaldofinalfontsf varchar(1) NOT NULL,
                si183_mes int8 NOT NULL DEFAULT 0,
                si183_instit int8 NULL DEFAULT 0,
                si183_reg10 int8 NOT NULL,
                CONSTRAINT balancete162023_sequ_pk PRIMARY KEY (si183_sequencial),
                CONSTRAINT fk_balancete162023_reg10_fk FOREIGN KEY (si183_reg10) REFERENCES public.balancete102023(si177_sequencial)
            ); ";

        $sql .= "
            DROP TABLE public.balancete172023;

            CREATE TABLE public.balancete172023 (
                si184_sequencial int8 NOT NULL DEFAULT 0,
                si184_tiporegistro int8 NOT NULL DEFAULT 0,
                si184_contacontabil int8 NOT NULL DEFAULT 0,
                si184_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
                si184_atributosf varchar(1) NOT NULL,
                si184_codctb int8 NOT NULL DEFAULT 0,
                si184_codfontrecursos int8 NOT NULL DEFAULT 0,
                si184_codco int8 NOT NULL DEFAULT 0,
                si184_saldoinicialctb float8 NOT NULL DEFAULT 0,
                si184_naturezasaldoinicialctb varchar(1) NOT NULL,
                si184_totaldebitosctb float8 NOT NULL DEFAULT 0,
                si184_totalcreditosctb float8 NOT NULL DEFAULT 0,
                si184_saldofinalctb float8 NOT NULL DEFAULT 0,
                si184_naturezasaldofinalctb varchar(1) NOT NULL,
                si184_mes int8 NOT NULL DEFAULT 0,
                si184_instit int8 NULL DEFAULT 0,
                si184_reg10 int8 NOT NULL,
                CONSTRAINT balancete172023_sequ_pk PRIMARY KEY (si184_sequencial),
                CONSTRAINT fk_balancete172023_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES public.balancete102023(si177_sequencial)
            );
        ";

        $sql .="
            DROP TABLE public.balancete302023;

            CREATE TABLE public.balancete302023 (
                si242_sequencial int8 NOT NULL DEFAULT 0,
                si242_tiporegistro int8 NOT NULL DEFAULT 0,
                si242_contacontaabil int8 NOT NULL DEFAULT 0,
                si242_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
                si242_codorgao varchar(2) NOT NULL,
                si242_codunidadesub varchar(8) NOT NULL,
                si242_codfuncao varchar(2) NOT NULL,
                si242_codsubfuncao varchar(3) NOT NULL,
                si242_codprograma varchar(4) NULL,
                si242_idacao varchar(4) NOT NULL,
                si242_idsubacao varchar(4) NOT NULL,
                si242_naturezadespesa int8 NOT NULL DEFAULT 0,
                si242_subelemento varchar(2) NOT NULL,
                si242_codfontrecursos int8 NOT NULL DEFAULT 0,
                si242_codco int8 NOT NULL DEFAULT 0,
                si242_saldoinicialcde float8 NOT NULL DEFAULT 0,
                si242_naturezasaldoinicialcde varchar(1) NOT NULL,
                si242_totaldebitoscde float8 NOT NULL DEFAULT 0,
                si242_totalcreditoscde float8 NOT NULL DEFAULT 0,
                si242_saldofinalcde float8 NOT NULL DEFAULT 0,
                si242_naturezasaldofinalcde varchar(1) NOT NULL,
                si242_mes int8 NOT NULL DEFAULT 0,
                si242_instit int8 NULL DEFAULT 0,
                si242_reg10 int8 NOT NULL,
                CONSTRAINT balancete302023_sequ_pk PRIMARY KEY (si242_sequencial),
                CONSTRAINT fk_balancete302023_reg10_fk FOREIGN KEY (si242_reg10) REFERENCES public.balancete102023(si177_sequencial)
            );
        ";

        $sql .="
            DROP TABLE public.balancete312023;

            CREATE TABLE public.balancete312023 (
                si243_sequencial int8 NOT NULL DEFAULT 0,
                si243_tiporegistro int8 NOT NULL DEFAULT 0,
                si243_contacontabil int8 NOT NULL DEFAULT 0,
                si243_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
                si243_naturezareceita int8 NOT NULL DEFAULT 0,
                si243_codfontrecursos int8 NOT NULL DEFAULT 0,
                si243_codco int8 NOT NULL DEFAULT 0,
                si243_nrocontratoop varchar(30) NULL,
                si243_dataassinaturacontratoop date NULL,
                si243_saldoinicialcre float8 NOT NULL DEFAULT 0,
                si243_naturezasaldoinicialcre varchar(1) NOT NULL,
                si243_totaldebitoscre float8 NOT NULL DEFAULT 0,
                si243_totalcreditoscre float8 NOT NULL DEFAULT 0,
                si243_saldofinalcre float8 NOT NULL DEFAULT 0,
                si243_naturezasaldofinalcre varchar(1) NOT NULL,
                si243_mes int8 NOT NULL DEFAULT 0,
                si243_instit int8 NULL DEFAULT 0,
                si243_reg10 int8 NOT NULL,
                CONSTRAINT balancete312023_sequ_pk PRIMARY KEY (si243_sequencial),
                CONSTRAINT fk_balancete312023_reg10_fk FOREIGN KEY (si243_reg10) REFERENCES public.balancete102023(si177_sequencial)
            );
        ";
        $this->execute($sql);
    }
}
