BEGIN;

select fc_startsession();

ALTER TABLE rhpesdoc ADD COLUMN rh16_cnh_exp date;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh16_cnh_exp                            ', 'date                                    ', 'Data de Expedição da CNH', 'null', 'Data de Expedição da CNH', 10, false, false, false, 1, 'text', 'Data de Expedição da CNH');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh16_cnh_exp'), 16, 0);


COMMIT;
