<?php

use Phinx\Migration\AbstractMigration;

class CreaCamposParaEsocial extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO public.tipodeficiencia (rh150_sequencial, rh150_descricao) VALUES(7, 'Mental');

        ALTER TABLE pessoal.rhpessoalmov ADD rh02_reabreadap boolean NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_cotadeficiencia boolean NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_plansegreg int4 NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_datainicio date NULL;

        ALTER TABLE pessoal.rhdepend ADD rh31_sexo bpchar(1) NULL;
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh31_sexo', 'bpchar(1)', 'Sexo', '', 'Sexo', 3, false, false, false, 1, 'text', 'Sexo');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1186, (select codcam from db_syscampo where nomecam = 'rh31_sexo'), 5, 0);

        ALTER TABLE tpcontra ADD COLUMN h13_categoria int4;
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h13_categoria', 'int4', 'Categoria e-Social', '', 'Categoria e-Social', 3, false, false, false, 1, 'text', 'Categoria e-Social');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'h13_categoria'), 5, 0);

        ALTER TABLE pessoal.inssirf ADD r33_tiporegime varchar(1) NULL;
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'r33_tiporegime', 'varchar(1)', 'Tipo de Regime', '', 'Tipo de Regime', 3, false, false, false, 1, 'text', 'Tipo de Regime');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'r33_tiporegime'), 5, 0);

        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_codterceirosprocjudicial TYPE varchar(50) USING eso08_codterceirosprocjudicial::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_nroprocessojudicial TYPE varchar(50) USING eso08_nroprocessojudicial::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_codindicasuspensao TYPE varchar(50) USING eso08_codindicasuspensao::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_codterceiros TYPE varchar(50) USING eso08_codterceiros::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_codterceiroscombinado TYPE varchar(50) USING eso08_codterceiroscombinado::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_nroinscricaoproprietario TYPE varchar(50) USING eso08_nroinscricaoproprietario::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_numeroinscricaocontratante TYPE varchar(50) USING eso08_numeroinscricaocontratante::varchar;
        ALTER TABLE public.eventos1020 ALTER COLUMN eso08_fatoracidentario TYPE varchar(50) USING eso08_fatoracidentario::varchar;

        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_codindicativosuspensaos1070fap TYPE varchar(50) USING eso06_codindicativosuspensaos1070fap::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_nroprocessos1070fap TYPE varchar(50) USING eso06_nroprocessos1070fap::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_nroprocessos1070rat TYPE varchar(50) USING eso06_nroprocessos1070rat::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_codindicativosuspensaos1070rat TYPE varchar(50) USING eso06_codindicativosuspensaos1070rat::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_nroprocessojudicia TYPE varchar(50) USING eso06_nroprocessojudicia::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_nroinscricaoenteducativa TYPE varchar(50) USING eso06_nroinscricaoenteducativa::varchar;
        ALTER TABLE public.eventos1005 ALTER COLUMN eso06_nroprocessocontratacaodeficiencia TYPE varchar(50) USING eso06_nroprocessocontratacaodeficiencia::varchar;

        ALTER TABLE public.eventos1070 ALTER COLUMN eso09_nroprocessoadm TYPE varchar(50) USING eso09_nroprocessoadm::varchar;
        ALTER TABLE public.eventos1070 ALTER COLUMN eso09_codmuniibge TYPE varchar(50) USING eso09_codmuniibge::varchar;
        ALTER TABLE public.eventos1070 ALTER COLUMN eso09_idvara TYPE varchar(50) USING eso09_idvara::varchar;

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
