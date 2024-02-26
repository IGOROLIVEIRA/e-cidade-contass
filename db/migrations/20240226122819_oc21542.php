<?php

use Phinx\Migration\AbstractMigration;

class Oc21542 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        DROP TABLE public.flpgo122024;
        DROP TABLE public.flpgo112024;
        
        -- public.flpgo102024 definition

        -- Drop table

        DROP TABLE public.flpgo102024;

        CREATE TABLE public.flpgo102024 (
            si195_sequencial int8 NOT NULL DEFAULT 0,
            si195_tiporegistro int8 NULL,
            si195_codvinculopessoa int8 NULL,
            si195_regime varchar(1) NULL,
            si195_indtipopagamento varchar(1) NULL,
            si195_dsctipopagextra varchar(150) NULL,
            si195_indsituacaoservidorpensionista varchar(2) NULL,
            si195_datatransferenciareserva date NULL,
            si195_indpensionista int4 NULL,
            si195_nrocpfinstituidor varchar(11) NULL,
            si195_datobitoinstituidor date NULL,
            si195_tipodependencia int8 NULL,
            si195_dscdependencia varchar(150) NULL,
            si195_optouafastpreliminar int4 NULL,
            si195_datfastpreliminar date NULL,
            si195_datconcessaoaposentadoriapensao date NULL,
            si195_dsccargo varchar(120) NULL,
            si195_codcargo int8 NULL,
            si195_sglcargo varchar(3) NULL,
            si195_dscapo varchar(3) NULL,
            si195_natcargo int4 NULL,
            si195_dscnatcargo varchar(150) NULL,
            si195_indcessao varchar(3) NULL,
            si195_dsclotacao varchar(250) NULL,
            si195_dedicacaoexclusiva varchar(1) NULL,
            si195_indsalaaula varchar(1) NULL,
            si195_vlrcargahorariasemanal int8 NULL,
            si195_datefetexercicio date NULL,
            si195_datcomissionado date NULL,
            si195_datexclusao date NULL,
            si195_datcomissionadoexclusao date NULL,
            si195_vlrremuneracaobruta float8 NULL,
            si195_vlrdescontos float8 NULL,
            si195_vlrremuneracaoliquida float8 NULL,
            si195_natsaldoliquido varchar(1) NULL,
            si195_mes int8 NULL,
            si195_inst int8 NULL,
            CONSTRAINT flpgo102024_sequ_pk PRIMARY KEY (si195_sequencial)
        )
            ;

        -- public.flpgo102024_si195_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.flpgo102024_si195_sequencial_seq CASCADE;

        CREATE SEQUENCE public.flpgo102024_si195_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;


        -- public.flpgo112024 definition

        -- Drop table

        -- DROP TABLE public.flpgo112024;

        CREATE TABLE public.flpgo112024 (
            si196_sequencial int8 NOT NULL DEFAULT 0,
            si196_tiporegistro int8 NULL,
            si196_indtipopagamento varchar(1) NULL,
            si196_codvinculopessoa varchar(15) NULL,
            si196_codrubricaremuneracao varchar(4) NULL,
            si196_desctiporubrica varchar(150) NULL,
            si196_vlrremuneracaodetalhada float8 NULL,
            si196_reg10 int8 NULL DEFAULT 0,
            si196_mes int8 NULL,
            si196_inst int8 NULL,
            CONSTRAINT flpgo112024_sequ_pk PRIMARY KEY (si196_sequencial),
            CONSTRAINT flpgo112024_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES public.flpgo102024(si195_sequencial)
        )
            ;


        -- public.flpgo112024_si196_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.flpgo112024_si196_sequencial_seq CASCADE;

        CREATE SEQUENCE public.flpgo112024_si196_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;

        -- public.flpgo122024 definition

        -- Drop table

        -- DROP TABLE public.flpgo122024;

        CREATE TABLE public.flpgo122024 (
            si197_sequencial int8 NOT NULL DEFAULT 0,
            si197_tiporegistro int8 NULL,
            si197_indtipopagamento varchar(1) NULL,
            si197_codvinculopessoa varchar(15) NULL,
            si197_codrubricadesconto varchar(4) NULL,
            si197_desctiporubricadesconto varchar(150) NULL,
            si197_vlrdescontodetalhado float8 NULL,
            si197_reg10 int8 NULL DEFAULT 0,
            si197_mes int8 NULL,
            si197_inst int8 NULL,
            CONSTRAINT flpgo122024_sequ_pk PRIMARY KEY (si197_sequencial),
            CONSTRAINT flpgo122024_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES public.flpgo102024(si195_sequencial)
        )
            ;


        -- public.flpgo122024_si197_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.flpgo122024_si197_sequencial_seq CASCADE;

        CREATE SEQUENCE public.flpgo122024_si197_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;


        -- public.viap102024_si198_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.viap102024_si198_sequencial_seq CASCADE;

        CREATE SEQUENCE public.viap102024_si198_sequencial_seq
        INCREMENT BY 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1;


        -- public.afast102024_si199_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.afast102024_si199_sequencial_seq CASCADE;

        CREATE SEQUENCE public.afast102024_si199_sequencial_seq
        INCREMENT BY 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1;


        -- public.terem202024_si196_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.terem202024_si196_sequencial_seq CASCADE;

        CREATE SEQUENCE public.terem202024_si196_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;
                

        -- public.respinf2024_si197_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.respinf2024_si197_sequencial_seq CASCADE;

        CREATE SEQUENCE public.respinf2024_si197_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;

        SQL;

        $this->execute($sql);
    }
}
