BEGIN;

select fc_startsession();

insert into db_tipodoc(db08_codigo, db08_descr) values ((select max(db08_codigo) from db_tipodoc)+1, 'ASSINATURA DO RESPONSÁVEL');
select * from db_tipodoc where db08_descr = 'ASSINATURA DO RESPONSÁVEL';

create temp table instituicoes(
  sequencial SERIAL,
  inst INT
);

insert into instituicoes(inst) (select codigo from db_config);

select * from instituicoes;

CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS
$BODY$
DECLARE
    r instituicoes%rowtype;
BEGIN
    FOR r IN SELECT * FROM instituicoes
    LOOP

        -- RAISE NOTICE 'Line: %', r.inst;

        insert into db_documento(db03_docum, db03_descr, db03_tipodoc, db03_instit) values ((select max(db03_docum) from db_documento)+1,
        'ASSINATURA PADRÃO DO RESPONSÁVEL', (select db08_codigo from db_tipodoc where db08_descr = 'ASSINATURA DO RESPONSÁVEL'), r.inst);

        -- Cria Par?grafo para o Documento

        insert into db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca, db02_altura, db02_largura, db02_alinhamento, db02_tipo, db02_instit)
        values ((select max(db02_idparag) from db_paragrafo)+1, 'ASSINATURA DO RESPONSÁVEL', '', 20, 0, 1, 0, 0, 'C', 1, r.inst);

        RETURN NEXT r;

    END LOOP;
    RETURN;
END
$BODY$
LANGUAGE plpgsql;

select * from getAllCodigos();
 
DROP FUNCTION getAllCodigos();

insert into db_docparag(db04_docum, db04_idparag, db04_ordem)
(SELECT db_documento.db03_docum, db_paragrafo.db02_idparag, 1 as ordem
FROM db_documento,
     db_paragrafo
WHERE db_documento.db03_instit = db_paragrafo.db02_instit
    AND db_documento.db03_descr LIKE 'ASSINATURA PADRÃO DO RESPONSÁVEL'
    AND db_paragrafo.db02_descr LIKE 'ASSINATURA DO RESPONSÁVEL');

COMMIT;
