<?php

use Phinx\Migration\AbstractMigration;

class Oc15732criacaoParagrafos extends AbstractMigration
{
    public function up()
    {
        $sql = utf8_encode("
            begin;
            INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),'ADJUDICACAO RELATORIO');
            commit;
        ");
        $this->execute($sql);

        $getIstints = $this->fetchAll('SELECT codigo FROM db_config');
        foreach ($getIstints as $instit) {
            $this->inserirAjudicacao($instit['codigo']);
        }

        $sql = "
            begin;
            INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),'HOMOLOGACAO RELATORIO');
            commit;
        ";
        $this->execute($sql);

        foreach ($getIstints as $instit) {
            $this->inserirHomologacao($instit['codigo']);
        }
    }

    private function inserirAjudicacao($instit)
    {
        $sql = <<<SQL
            begin;
        
                INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, 'ADJUDICACAO RELATORIO', (select max(db08_codigo) from db_tipodoc),$instit);
                insert into db_documento values ((select max(db03_docum)+1 from db_documento),'ADJUDICACAO RELATORIO',(select max(db08_codigo) from db_tipodoc), $instit);

                INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     'ADJUDICACAO RELATORIO',
                     'PROCESSO LICITATÓRIO Nº : #\$l20_edital#/#\$l20_anousu# 
                     PREGÃO PRESENCIAL Nº : #\$l20_numero#/#\$l20_anousu#
                     OBJETO: #\$l20_objeto# 
                     
                                     Sr.(a), #\$z01_nome# no uso de suas atribuições legais e com base no  processo Licitatório acima identificado, resolve adjudicar o julgamento proferido pela comissão de Licitação em favor do(s) licitante(s) na forma abaixo:',
                     0,
                     0,
                     1,
                     5,
                     0,
                     'J',
                     1,
                     $instit);  

                     INSERT INTO db_paragrafopadrao
            VALUES (
                        (SELECT MAX(db61_codparag)+1
                         FROM db_paragrafopadrao),
                         'ADJUDICACAO RELATORIO',
                         'PROCESSO LICITATÓRIO Nº : #\$l20_edital#/#\$l20_anousu# 
                         PREGÃO PRESENCIAL Nº : #\$l20_numero#/#\$l20_anousu#
                         OBJETO: #\$l20_objeto#
                         
                                         Sr.(a), #\$z01_nome# no uso de suas atribuições legais e com base no  processo Licitatório acima identificado, resolve adjudicar o julgamento proferido pela comissão de Licitação em favor do(s) licitante(s) na forma abaixo:',
                     0,
                     0,
                     1,
                    'J',
                     5,
                     0,
                     1);

                     insert into db_docparagpadrao(db62_coddoc, db62_codparag, db62_ordem) values ((select max(db60_coddoc) from db_documentopadrao), (select max(db61_codparag) from db_paragrafopadrao), 1);
                    insert into db_docparag values ((select max(db03_docum) from db_documento),(SELECT MAX(db02_idparag)FROM db_paragrafo),1);
            
            commit;
SQL;
        $this->execute($sql);
    }

    private function inserirHomologacao($instit)
    {
        $sql = <<<SQL
            begin;
        
                INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, 'HOMOLOGACAO RELATORIO', (select max(db08_codigo) from db_tipodoc),$instit);
                insert into db_documento values ((select max(db03_docum)+1 from db_documento),'HOMOLOGACAO RELATORIO',(select max(db08_codigo) from db_tipodoc), $instit);

                INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                         'HOMOLOGACAO RELATORIO',
                         'PROCESSO LICITATÓRIO Nº : #\$l20_edital#/#\$l20_anousu# 
                         PREGÃO PRESENCIAL Nº : #\$l20_numero#/#\$l20_anousu#
                         OBJETO: #\$l20_objeto#
                          
                                         Sr.(a), #\$z01_nome# CPF no #\$z01_cpf#, nos usos das suas atribuições legais e nos termos da legislação em vigor, resolve HOMOLOGAR ao(s) licitante(s) vencedor(es) o(s) item(s) no valor total de R$ #\$valor_total# conforme relacionado(s).',
                     0,
                     0,
                     1,
                     5,
                     0,
                     'J',
                     1,
                     $instit); 

                     INSERT INTO db_paragrafopadrao
            VALUES (
                        (SELECT MAX(db61_codparag)+1
                         FROM db_paragrafopadrao),
                         'HOMOLOGACAO RELATORIO',
                     'PROCESSO LICITATÓRIO Nº : #\$l20_edital#/#\$l20_anousu# 
                     PREGÃO PRESENCIAL Nº : #\$l20_numero#/#\$l20_anousu#
                     OBJETO: #\$l20_objeto#
                      
                                     Sr.(a), #\$z01_nome# CPF no #\$z01_cpf#, nos usos das suas atribuições legais e nos termos da legislação em vigor, resolve HOMOLOGAR ao(s) licitante(s) vencedor(es) o(s) item(s) no valor total de R$ #\$valor_total# conforme relacionado(s).',
                     0,
                     0,
                     1,
                    'J',
                     5,
                     0,
                     1);

                    insert into db_docparagpadrao(db62_coddoc, db62_codparag, db62_ordem) values ((select max(db60_coddoc) from db_documentopadrao), (select max(db61_codparag) from db_paragrafopadrao), 1);
                    insert into db_docparag values ((select max(db03_docum) from db_documento),(SELECT MAX(db02_idparag)FROM db_paragrafo),1);
            
            commit;
SQL;
        $this->execute($sql);
    }
}