begin;
select fc_startsession();

ALTER TABLE orcsuplemval ADD COLUMN o47_motivo varchar(300);

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o47_motivo', 'varchar(300)', 'Motivo da suplementação', '', 'Motivo', 300, false, true, false, 0, 'text', 'Motivo');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o47_coddot'))), (select codcam from db_syscampo where nomecam = 'o47_motivo'), 6, 0);

commit;

begin;
select fc_startsession();

ALTER TABLE orcparametro ADD COLUMN o50_motivosuplementacao varchar(1);

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o50_motivosuplementacao', 'varchar(1)', 'Parâmetro Motivo da suplementação', '', 'Motivo Suplementacao', 1, false, true, false, 0, 'text', 'Motivo Suplementacao');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o50_anousu'))), (select codcam from db_syscampo where nomecam = 'o50_motivosuplementacao'), (select max(seqarq) + 1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o50_anousu')))), 0);

commit;
