BEGIN;

select fc_startsession();

ALTER TABLE endereco drop COLUMN db76_codigoibge;
ALTER TABLE cgm ADD COLUMN z01_ibge char(7);

UPDATE db_syscampo SET rotulo = 'CPF do Dependente', rotulorel = 'CPF do Dependente' where nomecam = 'rh31_cpf';

--  Inserção dos campos DATA DE VALIDADE e DATA DE EXPEDIÇÃO na tabela caddocumentoatributo

create temp table sequenciais(
  sequencial SERIAL,
  codatr INT
);

insert into sequenciais(codatr) (select db44_sequencial from caddocumento where db44_descricao like '%CONS%');

CREATE OR REPLACE FUNCTION getAllAtributos() RETURNS SETOF sequenciais AS
$BODY$
DECLARE
    r sequenciais%rowtype;
BEGIN
    FOR r IN SELECT * FROM sequenciais
    LOOP

        insert into caddocumentoatributo (db45_sequencial, db45_caddocumento, db45_codcam, db45_descricao, db45_valordefault, db45_tipo, db45_tamanho)
          values ((select nextval('caddocumentoatributo_db45_sequencial_seq')), r.codatr, null, 'DATA DE VALIDADE', '', 3, 10);

        insert into caddocumentoatributo (db45_sequencial, db45_caddocumento, db45_codcam, db45_descricao, db45_valordefault, db45_tipo, db45_tamanho)
          values ((select nextval('caddocumentoatributo_db45_sequencial_seq')), r.codatr, null, 'DATA DE EXPEDIÇÃO', '', 3, 10);

        RETURN NEXT r;
    END LOOP;
    RETURN;
END
$BODY$
LANGUAGE plpgsql;

select * from getAllAtributos();
select * from caddocumentoatributo;

DROP FUNCTION getAllAtributos();

COMMIT;
