<?php

use Phinx\Migration\AbstractMigration;

class Oc17042 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
            begin;

            select fc_startsession();

            /*inserindo campos na tabela*/
            alter table adesaoregprecos add column si06_anomodadm bigint;
            alter table adesaoregprecos add column si06_nummodadm bigint;

            /*criacao campo si06_anomodadm e vinculo com a tabela*/
            insert into db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'si06_anomodadm', 'int4', 'Ano do Processo', '0', 'Ano do Processo', 4, false, false, true, 1, 'text', 'si06_anomodadm');

            insert into db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si06_anomodadm'), 1, (select max(codsequencia) from db_syssequencia));

            /*criacao campo si06_nummodadm e vinculo com a tabela*/
            insert into db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'si06_nummodadm', 'int8', 'Numero da Modalidade', '0', 'Numero da Modalidade', 10, false, false, true, 1, 'text', 'si06_nummodadm');

            insert into db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'si06_nummodadm'), 1, (select max(codsequencia) from db_syssequencia));

            commit;            
            ";

        $this->execute($sSql);
    }
}
