<?php

use Phinx\Migration\AbstractMigration;

class Oc15732 extends AbstractMigration
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
                INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),\'Emissão Adjudicação/Homologação\',\'Emissão Adjudicação/Homologação\',\'rat2_homologacaoadjudicacao001.php\',1,1,\'Emissão Adjudicação/Homologação\',\'t\');
                INSERT INTO db_menu VALUES(1797,(select max(id_item) from db_itensmenu),1002,381);
                INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),\'ADJUDICACAO RELATORIO\');
                    
                INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, \'ADJUDICACAO RELATORIO\', (select max(db08_codigo) from db_tipodoc), 1);
                insert into db_documento values ((select max(db03_docum)+1 from db_documento),\'ADJUDICACAO RELATORIO\',(select max(db08_codigo) from db_tipodoc), 1);

                INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     \'ADJUDICACAO RELATORIO\',
                     \'PROCESSO LICITATÓRIO Nº : #$l20_edital#/#$l20_anousu# 
                     PREGÃO PRESENCIAL Nº : #$l20_numero#/#$l20_anousu#
                     OBJETO: TESTE LICITAÇÃO NORMAL - HOMOLOGAÇÃO 
                     
                                     Sr.(a), #$z01_nome# no uso de suas atribuições legais e com base no  processo Licitatório acima identificado, resolve adjudicar o julgamento proferido pela comissão de Licitação em favor do(s) licitante(s) na forma abaixo:\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     1,
                     1);

                     INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),\'HOMOLOGACACAO RELATORIO\');
                    
                INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, \'HOMOLOGACACAO RELATORIO\', (select max(db08_codigo) from db_tipodoc), 1);
                insert into db_documento values ((select max(db03_docum)+1 from db_documento),\'HOMOLOGACACAO RELATORIO\',(select max(db08_codigo) from db_tipodoc), 1);

                INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     \'HOMOLOGACACAO RELATORIO\',
                     \'PROCESSO LICITATÓRIO Nº : #$l20_edital#/#$l20_anousu# 
                     PREGÃO PRESENCIAL Nº : #$l20_numero#/#$l20_anousu#
                     OBJETO: TESTE LICITAÇÃO NORMAL - HOMOLOGAÇÃO
                      
                                     Sr.(a), #$z01_nome# CPF no #$z01_cpf#, nos usos das suas atribuições legais e nos termos da legislação em vigor, resolve HOMOLOGAR ao(s) licitante(s) vencedor(es) o(s) item(s) no valor total de R$ #$valor_total# conforme relacionado(s).\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     1,
                     1);
        commit; 

        ');

        $this->execute($sql);
    }
}
