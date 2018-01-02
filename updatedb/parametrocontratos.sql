BEGIN;

select fc_startsession();

--DROP TABLE:
DROP TABLE IF EXISTS parametroscontratos CASCADE;
--Criando drop sequences


-- Criando  sequences
-- TABELAS E ESTRUTURA

-- Módulo: acordos
CREATE TABLE parametroscontratos(
pc01_liberaautorizacao		bool NOT NULL default 'f');



-- CHAVE ESTRANGEIRA





-- INDICES


COMMIT;