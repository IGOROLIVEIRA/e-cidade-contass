BEGIN ;
select fc_startsession();
-- Módulo: contabilidade
CREATE TABLE emprestosemdesponi(
c218_anousu		int8 NOT NULL default 0,
c218_numemp		int8 NOT NULL default 0,
c218_valorpago		float8 default 0,
CONSTRAINT emprestosemdesponi_nume_ae_pk PRIMARY KEY (c218_numemp,c218_anousu));

-- CHAVE ESTRANGEIRA
ALTER TABLE emprestosemdesponi
ADD CONSTRAINT emprestosemdesponi_numemp_fk FOREIGN KEY (c218_numemp)
REFERENCES empempenho;

COMMIT ;