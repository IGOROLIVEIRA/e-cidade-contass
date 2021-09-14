<?php

use Phinx\Migration\AbstractMigration;

class Oc15584 extends AbstractMigration
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
        $sql = utf8_encode('
            begin;
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),\'Ratifica��o(novo)\',\'Ratifica��o(novo)\',\'rat2_ratificacaoprocnovo001.php\',1,1,\'Ratifica��o(novo)\',\'t\');
            INSERT INTO db_menu VALUES(1797,(select max(id_item) from db_itensmenu),1002,381);
            INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),\'RATIFICACAO NOVO\');
            
            INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, \'RATIFICACAO NOVO\', (select max(db08_codigo) from db_tipodoc), 1);
            
            INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db61_codparag)
                         FROM db_paragrafopadrao)+1,
                     \'RATIFICACAO NOVO\',
                     \'PROCEDIMENTO ADMINISTRATIVO N� #$l20_edital# 
            TERMO DE #$l44_descricao#  N� #$l20_numero#
            
            O DIRETOR GERAL DA FUNDA��O HOSPITALAR DE JANA�BA/MG, NO USO DE SUAS ATRIBUI��ES LEGAIS,
            
            RESOLVE,
            
            RATIFICAR E HOMOLOGAR, o Procedimento Licitat�rio n� #$l20_edital#, Termo de #$l44_descricao# n� #$l20_numero# conforme justificativa apresentada pela Comiss�o de Licita��o da #$instit#, e Parecer da Assessoria Jur�dica, AUTORIZANDO a #$l20_objeto#  no valor total de R$ #$totallicitacao# para contrata��o do(s) fornecedor(es) relacionado(s) abaixo.\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     1,
                     1);
			insert into db_docparagpadrao(db62_coddoc, db62_codparag, db62_ordem) values ((select max(db60_coddoc) from db_documentopadrao), (select max(db61_codparag) from db_paragrafopadrao), 1);

            commit;           
        ');
        $this->execute($sql);
    }
}
