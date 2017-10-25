begin;
select fc_startsession();
ALTER TABLE entesconsorciadosreceitas ADD COLUMN c216_percentual float4;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((select max(codcam)+1 from db_syscampo), 'c216_percentual', 'float4', 'Percentual', '', 'Percentual', 20, false, true, false, 0, 'float', 'Percentual');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2010423, (select codcam from db_syscampo where nomecam = 'c216_percentual'), 6, 0);
commit;