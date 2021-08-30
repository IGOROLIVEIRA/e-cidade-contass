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
                /*inserindo novo menu Adjudicação*/
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Adjudicação', 'Adjudicação', ' ', 1, 1, 'Adjudicação de Licitação', 't');
                INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),9,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','lic_adjudicacaolicitacao001.php',1,1,'Inclusão','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudicação'),(select max(id_item) from db_itensmenu),1,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','lic_adjudicacaolicitacao002.php',1,1,'Alteração','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudicação'),(select max(id_item) from db_itensmenu),2,381);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','lic_adjudicacaolicitacao003.php',1,1,'Exclusão','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Adjudicação'),(select max(id_item) from db_itensmenu),3,381);

                /*Removendo not null da tabela homologacao*/
                ALTER table homologacaoadjudica alter COLUMN l202_datahomologacao DROP NOT NULL;

                /*Adicionando nova Situação Adjudicada a licitacao*/
                insert into licsituacao values(13,'Adjudicacao','f');
                
                /*Alterado descricao do menu homologacao*/
                update db_itensmenu set descricao = 'Homologação' where id_item in (select id_item from db_itensmenu where descricao like '%Homologação Adjudicação%');
SQL;
        $this->execute($sql);
    }
}
