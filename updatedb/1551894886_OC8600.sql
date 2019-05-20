-- Script OC8600
BEGIN;
select fc_startsession();

ALTER TABLE rhcargo ADD COLUMN rh04_cbo varchar(6);
ALTER TABLE rhpesdoc ADD COLUMN rh16_cnh_uf varchar(2);
ALTER TABLE rhdepend ADD COLUMN rh31_cpf varchar(11);
ALTER TABLE endereco ADD COLUMN db76_codigoibge char(7);
ALTER TABLE cgm ADD COLUMN z01_ibge char(7);
-- ALTER TABLE cgm ADD COLUMN z01_ufibge varchar(2);
-- ALTER TABLE cgm ADD COLUMN z01_cidadeibge varchar(40);

-- INSERINDO db_syscampo
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh04_cbo                                ', 'int4                                    ', 'Classificação Brasileira de Ocupações', '0', 'CBO', 6, false, false, false, 1, 'text', 'CBO');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh16_cnh_uf                             ', 'varchar(2)                              ', 'Unidade Federativa da CNH', '', 'UF da CNH', 2, true, true, false, 0, 'text', 'UF da CNH');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh31_cpf                                ', 'varchar(11)                             ', 'CPF do Dependente', '', 'CPF', 11, true, true, false, 0, 'text', 'CPF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'z01_ibge                                ', 'char(7)                                 ', 'Codigo IBGE', '', 'Codigo IBGE', 7, false, false, false, 1, 'text', 'Codigo IBGE');

-- INSERINDO db_sysarqcamp
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhcargo'), (select codcam from db_syscampo where nomecam = 'rh04_cbo'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhpesdoc'), (select codcam from db_syscampo where nomecam = 'rh16_cnh_uf'), 16, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh31_cpf'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'z01_ibge'), 60, 0);

COMMIT;
