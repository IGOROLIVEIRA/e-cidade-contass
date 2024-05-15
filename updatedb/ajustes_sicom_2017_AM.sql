BEGIN;
SELECT fc_startsession();


-- Criação de tabelas
CREATE TABLE IF NOT EXISTS "precomedio"
(
   "l209_sequencial" BIGINT PRIMARY KEY NOT NULL,
   "l209_licitacao" BIGINT DEFAULT 0 NOT NULL,
   "l209_datacotacao" DATE NOT NULL,
   "l209_item" BIGINT DEFAULT 0 NOT NULL,
   "l209_valor" DOUBLE PRECISION DEFAULT 0,
   FOREIGN KEY ("l209_item") REFERENCES "pcmater" ("pc01_codmater"),
   FOREIGN KEY ("l209_licitacao") REFERENCES "liclicita" ("l20_codigo")
);
CREATE INDEX "precomedio_l209_item_index" ON "precomedio" ("l209_item");
CREATE INDEX "precomedio_l209_licitacao_index" ON "precomedio" ("l209_licitacao");


-- Criação de sequences
CREATE SEQUENCE precomedio_l209_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- Operações nas tabelas
ALTER TABLE aberlic142017 ADD COLUMN si50_vlrefpercentual   float4 NOT NULL default 0;

COMMIT;
