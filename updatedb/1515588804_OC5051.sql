-- Ocorrência 5051
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE acordo
ALTER COLUMN ac16_acordocomissao
DROP NOT NULL;

ALTER TABLE acordo
ALTER COLUMN ac16_acordocomissao
DROP DEFAULT;

ALTER TABLE acordo
ALTER COLUMN ac16_acordosituacao
DROP NOT NULL;

ALTER TABLE acordo
ALTER COLUMN ac16_acordosituacao
DROP DEFAULT;


ALTER TABLE acordo ADD COLUMN ac16_semvigencia BOOLEAN DEFAULT false;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'ac16_semvigencia',
                              'bool',
                              'Acordo sem Vigência',
                              '',
                              'Acordo sem Vigência',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'bool',
                              'Acordo sem Vigência');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('ac16_sequencial'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'ac16_semvigencia'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('ac16_sequencial'))), 0);

DROP INDEX IF EXISTS acordo_numeroacordo_anousu_instit_in;
DROP SEQUENCE IF EXISTS acordo_ac16_numeroacordo_seq;

CREATE UNIQUE INDEX acordo_numero_vigencia_ano ON acordo USING  btree(ac16_numeroacordo, ac16_anousu, ac16_instit, ac16_acordocategoria, ac16_semvigencia);

CREATE SEQUENCE acordo_ac16_numeroacordo_seq START 101;

-- Fim do script

COMMIT;

