<?php

use Phinx\Migration\AbstractMigration;

class Oc15070docparagrafo extends AbstractMigration
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
    public function up(){
        $sql = "
			insert into db_tipodoc(db08_codigo, db08_descr) 
				values ((select max(db08_codigo) from db_tipodoc)+1, 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO');
			
			create temp table instituicoes(
			  sequencial SERIAL,
			  inst INT
			);

			insert into instituicoes(inst) (select codigo from db_config);

			CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS $$
			DECLARE
    			r instituicoes%rowtype;
			BEGIN
				FOR r IN SELECT * FROM instituicoes
				LOOP

                     insert into db_documento(db03_docum, db03_descr, db03_tipodoc, db03_instit)
                        values ((select max(db03_docum) from db_documento)+1,
                    'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO1',
                     (select db08_codigo from db_tipodoc where db08_descr = 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO'), r.inst);


                     insert into db_documento(db03_docum, db03_descr, db03_tipodoc, db03_instit)
                        values ((select max(db03_docum) from db_documento)+1,
                    'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO2',
                     (select db08_codigo from db_tipodoc where db08_descr = 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO'), r.inst);
	
	                insert into db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca, db02_altura, db02_largura, db02_alinhamento, db02_tipo, db02_instit)
                    values ((select max(db02_idparag) from db_paragrafo)+1, 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO1', 
                        'Examinando as Dotações constantes do orçamento fiscal e levando-se em conta os serviços que se pretende contratar, cujo objeto é  #$objeto# , no valor total estimado de #$vlrmedio# em atendimento aos dispositivos da Lei 8666/93, informo que existe dotações das quais correrão a despesas:', 20, 0, 1, 0, 0, 'J', 1, r.inst);

                    insert into db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca, db02_altura, db02_largura, db02_alinhamento, db02_tipo, db02_instit)
                    values ((select max(db02_idparag) from db_paragrafo)+1, 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO2', 
                        'que as despesas atendem ao disposto nos artigos 16 e 17 da Lei Complementar Federal 101/2000, uma vez , foi considerado o impacto na execução orçamentária e também está de acordo com a previsão do Plano Plurianual e da Lei de Diretrizes Orçamentárias para exercício. Informamos ainda que foi verificado o impacto financeiro da despesa e sua inclusão na programação deste órgão.', 20, 0, 1, 0, 0, 'J', 1, r.inst);
	
					RETURN NEXT r;

    			END LOOP;
    			RETURN;
			END
			$$
			LANGUAGE plpgsql;

			select * from getAllCodigos();
			 
			DROP FUNCTION getAllCodigos();

            insert into db_docparag(db04_docum, db04_idparag, db04_ordem)
                (SELECT db_documento.db03_docum, db_paragrafo.db02_idparag, 1 as ordem
                    FROM db_documento,db_paragrafo
                    WHERE db_documento.db03_instit = db_paragrafo.db02_instit
                    AND db_documento.db03_descr LIKE 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO1'
                    AND db_paragrafo.db02_descr LIKE 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO1');

                            insert into db_docparag(db04_docum, db04_idparag, db04_ordem)
                (SELECT db_documento.db03_docum, db_paragrafo.db02_idparag, 1 as ordem
                    FROM db_documento,db_paragrafo
                    WHERE db_documento.db03_instit = db_paragrafo.db02_instit
                    AND db_documento.db03_descr LIKE 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO2'
                    AND db_paragrafo.db02_descr LIKE 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO2');";

        $this->execute($sql);


    }

    public function down()
    {
        $sql = "
				DELETE FROM db_docparag
				WHERE db04_docum in
						(SELECT db03_docum
						 FROM db_documento
						 WHERE db_documento.db03_descr LIKE 'ASSINATURA PADRÃO PREÇO REFERÊNCIA')
						and db04_idparag in (select db02_idparag from db_paragrafo where db02_descr = 'RESPONSÁVEL PELA COTAÇÃO');
				
				
				DELETE FROM db_paragrafo
				WHERE db02_descr = 'RESPONSÁVEL PELA COTAÇÃO';
				
				
				DELETE FROM db_documento
				WHERE db03_tipodoc =
						(SELECT db08_codigo
						 FROM db_tipodoc
						 WHERE db08_descr = 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO');
				
				
				DELETE FROM db_tipodoc
				WHERE db08_descr = 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO';
		";
        $this->execute($sql);
    }
}
