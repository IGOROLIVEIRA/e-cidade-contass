<?php

use Phinx\Migration\AbstractMigration;

class Oc21751 extends AbstractMigration
{

    public function up()
    {
        $sSql  = "BEGIN;
                    ALTER TABLE contratos102024 ADD COLUMN si83_vigenciaindeterminada int;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_datafinalvigencia DROP NOT NULL;
                    ALTER TABLE contratos102024 RENAME COLUMN si83_codorgaoresp TO si83_cnpjorgaoentresp;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_cnpjorgaoentresp TYPE VARCHAR(14);
                    ALTER TABLE contratos202024 ADD COLUMN si87_codunidadesubatual varchar(8);
                    ALTER TABLE contratos202024 ADD COLUMN si87_criterioreajuste int;
                    ALTER TABLE contratos202024 ADD COLUMN si87_descricaoreajuste varchar (300);
                    ALTER TABLE contratos202024 RENAME COLUMN si87_dscreajuste TO si87_descricaoindice;
                    ALTER TABLE contratos302024 ADD COLUMN si89_codunidadesubatual varchar(8);
                    ALTER TABLE contratos302024 ADD COLUMN si89_criterioreajuste int;
                    ALTER TABLE contratos302024 ADD COLUMN si89_descricaoindice varchar (300);
                    ALTER TABLE contratos402024 ADD COLUMN si91_codunidadesubatual varchar (8);

                    DROP TABLE public.contratos102024 cascade;

                    CREATE TABLE public.contratos102024 (
                        si83_sequencial int8 NOT NULL DEFAULT 0,
                        si83_tiporegistro int8 NOT NULL DEFAULT 0,
                        si83_tipocadastro int8 NULL,
                        si83_codcontrato int8 NOT NULL DEFAULT 0,
                        si83_codorgao varchar(2) NOT NULL,
                        si83_codunidadesub varchar(8) NOT NULL,
                        si83_nrocontrato int8 NOT NULL DEFAULT 0,
                        si83_exerciciocontrato int8 NOT NULL DEFAULT 0,
                        si83_dataassinatura date NOT NULL,
                        si83_contdeclicitacao int8 NOT NULL DEFAULT 0,
                        si83_cnpjorgaoentresp varchar(14) NULL,
                        si83_codunidadesubresp varchar(8) NULL,
                        si83_nroprocesso varchar(12) NULL,
                        si83_exercicioprocesso int8 NULL DEFAULT 0,
                        si83_tipoprocesso int8 NULL DEFAULT 0,
                        si83_naturezaobjeto int8 NOT NULL DEFAULT 0,
                        si83_objetocontrato varchar(1000) NOT NULL,
                        si83_datainiciovigencia date NOT NULL,
                        si83_vigenciaindeterminada int4 NULL,
                        si83_datafinalvigencia date NULL,
                        si83_vlcontrato float8 NOT NULL DEFAULT 0,
                        si83_formafornecimento varchar(50) NULL,
                        si83_formapagamento varchar(100) NULL,
                        si83_indcriterioreajuste int4 NULL,
                        si83_databasereajuste date NULL,
                        si83_periodicidadereajuste varchar(2) NULL,
                        si83_tipocriterioreajuste varchar(2) NULL,
                        si83_dscreajuste varchar(300) NULL,
                        si83_indiceunicoreajuste varchar(2) NULL,
                        si83_dscindice varchar(300) NULL,
                        si83_unidadedemedidaprazoexec int8 NULL DEFAULT 0,
                        si83_prazoexecucao int8 NULL,
                        si83_multarescisoria varchar(100) NULL,
                        si83_multainadimplemento varchar(100) NULL,
                        si83_garantia int8 NULL DEFAULT 0,
                        si83_cpfsignatariocontratante varchar(11) NOT NULL,
                        si83_datapublicacao date NOT NULL,
                        si83_veiculodivulgacao varchar(50) NOT NULL,
                        si83_mes int8 NOT NULL DEFAULT 0,
                        si83_instit int8 NULL DEFAULT 0,
                        CONSTRAINT contratos102024_sequ_pk PRIMARY KEY (si83_sequencial)
                    );

                    DROP TABLE public.contratos202024 cascade;

                    CREATE TABLE public.contratos202024 (
                        si87_sequencial int8 NOT NULL DEFAULT 0,
                        si87_tiporegistro int8 NOT NULL DEFAULT 0,
                        si87_codaditivo int8 NOT NULL DEFAULT 0,
                        si87_codorgao varchar(2) NOT NULL,
                        si87_codunidadesub varchar(8) NOT NULL,
                        si87_codunidadesubatual varchar(8) NULL,
                        si87_nrocontrato varchar(14) NOT NULL DEFAULT 0,
                        si87_dtassinaturacontoriginal date NULL,
                        si87_nroseqtermoaditivo varchar(2) NOT NULL,
                        si87_dtassinaturatermoaditivo date NOT NULL,
                        si87_tipoalteracaovalor int8 NOT NULL DEFAULT 0,
                        si87_tipotermoaditivo varchar(2) NOT NULL,
                        si87_dscalteracao varchar(250) NULL,
                        si87_novadatatermino date NULL,
                        si87_percentualreajuste float8 NULL,
                        si87_criterioreajuste int4 NULL,
                        si87_descricaoindice varchar(300) NULL,
                        si87_indiceunicoreajuste int4 NULL,
                        si87_descricaoreajuste varchar(300) NULL,
                        si87_valoraditivo float8 NOT NULL DEFAULT 0,
                        si87_datapublicacao date NOT NULL,
                        si87_veiculodivulgacao varchar(50) NOT NULL,
                        si87_mes int8 NOT NULL DEFAULT 0,
                        si87_instit int8 NULL DEFAULT 0,
                        CONSTRAINT contratos202024_sequ_pk PRIMARY KEY (si87_sequencial)
                    );

                    DROP TABLE public.contratos302024;

                    CREATE TABLE public.contratos302024 (
                        si89_sequencial int8 NOT NULL DEFAULT 0,
                        si89_tiporegistro int8 NOT NULL DEFAULT 0,
                        si89_codorgao varchar(2) NOT NULL,
                        si89_codunidadesub varchar(8) NOT NULL,
                        si89_codunidadesubatual varchar(8) NULL,
                        si89_nrocontrato varchar(14) NOT NULL DEFAULT 0,
                        si89_dtassinaturacontoriginal date NOT NULL,
                        si89_tipoapostila varchar(2) NOT NULL,
                        si89_nroseqapostila int8 NOT NULL DEFAULT 0,
                        si89_dataapostila date NOT NULL,
                        si89_tipoalteracaoapostila int8 NOT NULL DEFAULT 0,
                        si89_dscalteracao varchar(250) NOT NULL,
                        si89_percentualreajuste float8 NULL,
                        si89_criterioreajuste int4 NULL,
                        si89_descricaoindice varchar(300) NULL,
                        si89_indiceunicoreajuste int4 NULL,
                        si89_dscreajuste varchar(300) NULL,
                        si89_valorapostila float8 NOT NULL DEFAULT 0,
                        si89_mes int8 NOT NULL DEFAULT 0,
                        si89_instit int8 NULL DEFAULT 0,
                        CONSTRAINT contratos302024_sequ_pk PRIMARY KEY (si89_sequencial)
                    );

                    DROP TABLE public.contratos402024;

                    CREATE TABLE public.contratos402024 (
                        si91_sequencial int8 NOT NULL DEFAULT 0,
                        si91_tiporegistro int8 NOT NULL DEFAULT 0,
                        si91_codorgao varchar(2) NOT NULL,
                        si91_codunidadesub varchar(8) NULL,
                        si91_codunidadesubatual varchar(8) NULL,
                        si91_nrocontrato varchar(14) NOT NULL DEFAULT 0,
                        si91_dtassinaturacontoriginal date NOT NULL,
                        si91_datarescisao date NOT NULL,
                        si91_valorcancelamentocontrato float8 NOT NULL DEFAULT 0,
                        si91_mes int8 NOT NULL DEFAULT 0,
                        si91_instit int8 NULL DEFAULT 0,
                        CONSTRAINT contratos402024_sequ_pk PRIMARY KEY (si91_sequencial)
                    );

                  COMMIT;
      
        ";

        $this->execute($sSql);
    }
}
