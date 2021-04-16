<?php

use Phinx\Migration\AbstractMigration;

class Oc12187 extends AbstractMigration
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
        $sql = '
        BEGIN;
              /*deletando primeiro paragrafo*/
              DELETE
                FROM db_docparagpadrao
                WHERE db62_codparag =
                        (SELECT db62_codparag
                         FROM db_documentopadrao
                         INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                         INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                         WHERE db60_tipodoc = 1703
                             AND db62_ordem = 1);
              
             /*adicionando novo padrao ao relatorio paragrafo 2*/
             UPDATE db_paragrafopadrao
                SET db61_texto = \'O Sr(a) #$z01_nome#, CPF no #$z01_cgccpf#, nos usos da suas atribuições legais e nos termos da legislação em vigor, resolve HOMOLOGAR o Processo Licitatório nº #$l20_edital#/#$l20_anousu#, #$l44_descricao# nº #$l20_numero#/#$l20_anousu#, cujo objeto é a #$l20_objeto#, no valor total de R$ #$totallicitacao# conforme fornecedor(es), item(ns) e valor(es) relacionado(s):\'
                WHERE db61_codparag =
                        (SELECT db61_codparag
                         FROM db_documentopadrao
                         INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                         INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                         WHERE db60_tipodoc = 1703
                             AND db62_ordem = 2);
             
            /*deletando terceiro paragravo 3*/
            DELETE
            FROM db_docparagpadrao
            WHERE db62_codparag =
                    (SELECT db62_codparag
                     FROM db_documentopadrao
                     INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                     INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                     WHERE db60_tipodoc = 1703
                         AND db62_ordem = 3);
            
            /*deletando quinto paragravo 4*/
            DELETE
            FROM db_docparagpadrao
            WHERE db62_codparag =
                    (SELECT db62_codparag
                     FROM db_documentopadrao
                     INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                     INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                     WHERE db60_tipodoc = 1703
                         AND db62_ordem = 4);
            
            /*deletando quinto paragravo 5*/
            
            DELETE
            FROM db_docparagpadrao
            WHERE db62_codparag =
                    (SELECT db62_codparag
                     FROM db_documentopadrao
                     INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                     INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                     WHERE db60_tipodoc = 1703
                         AND db62_ordem = 5);               
             
        COMMIT;      
';

        $this->execute($sql);
    }
}
