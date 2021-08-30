<?php

use Phinx\Migration\AbstractMigration;

class Oc15328 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL
                /*inserindo novo menu Adjudica��o*/
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Adjudica��o', 'Adjudica��o', ' ', 1, 1, 'Adjudica��o de Licita��o', 't');
                INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),9,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclus�o','Inclus�o','lic_adjudicacaolicitacao001.php',1,1,'Inclus�o','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudica��o'),(select max(id_item) from db_itensmenu),1,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Altera��o','Altera��o','lic_adjudicacaolicitacao002.php',1,1,'Altera��o','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudica��o'),(select max(id_item) from db_itensmenu),2,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclus�o','Exclus�o','lic_adjudicacaolicitacao003.php',1,1,'Exclus�o','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudica��o'),(select max(id_item) from db_itensmenu),3,381);

                /*Removendo not null da tabela homologacao*/
                ALTER table homologacaoadjudica alter COLUMN l202_datahomologacao DROP NOT NULL;

                /*Adicionando nova Situa��o Adjudicada a licitacao*/
                insert into licsituacao values(13,'Adjudicacao','f');
                
                /*Alterado descricao do menu homologacao*/
                update db_itensmenu set descricao = 'Homologa��o' where id_item in (select id_item from db_itensmenu where descricao like '%Homologa��o Adjudica��o%');
SQL;
        $this->execute($sql);
    }
}
