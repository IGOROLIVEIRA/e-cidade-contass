<?php

use Phinx\Migration\AbstractMigration;

class Oc20817v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        alter table orcsuplementacaoparametro add o134_superavitloa boolean;
        alter table orcsuplementacaoparametro add o134_excessoarrecad boolean;

        UPDATE orcamento.orcsuplementacaoparametro
        SET o134_superavitloa=true, o134_excessoarrecad=true
        WHERE o134_anousu=2023;

        insert
            into
            db_syscampo (codcam,nomecam,conteudo,descricao,valorinicial,rotulo,tamanho,nulo,maiusculo,autocompl,aceitatipo,tipoobj,rotulorel)
        values (
                (
        select
            max(codcam)+ 1
        from
            db_syscampo),'o134_superavitloa','boolean','Considerar o Superávit no limite da Loa','','Considerar o Superávit no limite da Loa',1,false,true,false,0,'boolean','Considerar o Superávit no limite da Loa');


        insert
            into
            db_sysarqcamp (codarq,codcam,seqarq,codsequencia)
        values (
            ( select 	codarq
                from 	db_sysarqcamp
                where	codcam = 
                ( select	codcam
                    from   db_syscampo
                    where 	nomecam in ('o134_percentuallimiteloa'))),
            ( select codcam
                from
                    db_syscampo
                where
                nomecam = 'o134_superavitloa'),
            ( select max(seqarq)+ 1
                from
                    db_sysarqcamp
                where
                    codcam =
                ( select	codcam
                    from db_syscampo
                    where nomecam in ('o134_percentuallimiteloa'))), 0);
			
        insert
            into
            db_syscampo (codcam,nomecam,conteudo,descricao,valorinicial,rotulo,tamanho,nulo,maiusculo,autocompl,aceitatipo,tipoobj,rotulorel)
        values (
                (
        select
            max(codcam)+ 1
        from
            db_syscampo),'o134_excessoarrecad','boolean','Considerar Excesso de Arrecadação no limite da Loa
        ','','Considerar Excesso de Arrecadação no limite da Loa',1,false,true,false,0,'boolean','Considerar Excesso de Arrecadação');


        insert
            into
            db_sysarqcamp (codarq,codcam,seqarq,codsequencia)
        values (
                ( select 	codarq
                    from 	db_sysarqcamp
                    where	codcam = 
                    ( select	codcam
                        from   db_syscampo
                        where 	nomecam in ('o134_percentuallimiteloa'))),
                ( select codcam
                    from
                        db_syscampo
                    where
                    nomecam = 'o134_excessoarrecad'),
                ( select max(seqarq)+ 1
                    from
                        db_sysarqcamp
                    where
                        codcam =
                    ( select	codcam
                        from db_syscampo
                        where nomecam in ('o134_percentuallimiteloa'))), 0);			

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}