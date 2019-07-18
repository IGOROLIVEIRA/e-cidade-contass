<?php

use Phinx\Migration\AbstractMigration;

class Oc10069 extends AbstractMigration
{

    public function up()
    {
        $this->insertAssinatura();
    }

    private function insertAssinatura() 
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_tipodoc(db08_codigo, db08_descr) VALUES ((SELECT max(db08_codigo) FROM db_tipodoc)+1, 
            'ASS. RESP. DEC. DE RECURSOS FINANCEIROS');
        SELECT * FROM db_tipodoc WHERE db08_descr = 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS';

        CREATE TEMP TABLE instituicoes(
            sequencial SERIAL,
            inst INT
        );

        INSERT INTO instituicoes(inst) (SELECT codigo FROM db_config);

        SELECT * FROM instituicoes;

        CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS
        $$
        DECLARE
            r instituicoes%rowtype;
        BEGIN
            FOR r IN SELECT * FROM instituicoes
            LOOP

                -- RAISE NOTICE 'Line: %', r.inst;

                INSERT INTO db_documento(db03_docum, db03_descr, db03_tipodoc, db03_instit) VALUES ((SELECT max(db03_docum) FROM db_documento)+1, 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS', (SELECT db08_codigo FROM db_tipodoc WHERE db08_descr = 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS'), r.inst);

                -- Cria Par?grafo para o Documento

                INSERT INTO db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca, db02_altura, db02_largura, db02_alinhamento, db02_tipo, db02_instit)
                VALUES ((SELECT max(db02_idparag) FROM db_paragrafo)+1, 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS', '', 20, 0, 1, 0, 0, 'C', 1, r.inst);

                RETURN NEXT r;

            END LOOP;
            RETURN;
        
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM getAllCodigos();
 
        DROP FUNCTION getAllCodigos();

        INSERT INTO db_docparag(db04_docum, db04_idparag, db04_ordem)
        (SELECT db_documento.db03_docum, db_paragrafo.db02_idparag, 1 AS ordem
        FROM db_documento,
        db_paragrafo
        WHERE db_documento.db03_instit = db_paragrafo.db02_instit
        AND db_documento.db03_descr LIKE 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS'
        AND db_paragrafo.db02_descr LIKE 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS');

        COMMIT;

SQL;
        $this->execute($sql);
    }
}