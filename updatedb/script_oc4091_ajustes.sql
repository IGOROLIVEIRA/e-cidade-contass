BEGIN;

ALTER TABLE entesconsorciadosreceitas ADD COLUMN c216_anousu int4 NULL DEFAULT NULL;

ALTER TABLE entesconsorciadosreceitas
ADD CONSTRAINT entesconsorciadosreceitas_receita_fk FOREIGN KEY (c216_receita, c216_anousu)
REFERENCES orcfontes(o57_codfon, o57_anousu);

ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorempenhado        TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorempenhadoanulado TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorliquidado        TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorliquidadoanulado TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorpago             TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_valorpagoanulado      TYPE float8;
ALTER TABLE despesarateioconsorcio ALTER COLUMN c217_percentualrateio      TYPE float8;

COMMIT;

---

BEGIN;

UPDATE db_itensmenu SET funcao = 'con1_entesconsorciados001.php'  WHERE id_item = 4001001;
UPDATE db_itensmenu SET funcao = 'con1_gerarrateio001.php' WHERE id_item = 4001002;
UPDATE db_itensmenu SET funcao = 'con2_relatoriorateio001.php' WHERE id_item = 4001003;

COMMIT;

---

BEGIN;

INSERT INTO tipodereceitarateio
  (c218_sequencial, c218_codigo, c218_descricao) VALUES
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 31, 'Pessoal e Encargos Sociais'),
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 32, 'Juros e Encargos da Dívida'),
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 33, 'Outras Despesas Correntes'),
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 44, 'Investimentos'),
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 45, 'Inversões Financeiras'),
  (nextval('tipodereceitarateio_c218_sequencial_seq'), 46, 'Amortização da Dívida')
;

COMMIT;
