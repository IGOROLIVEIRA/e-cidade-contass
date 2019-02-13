
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE infocomplementaresinstit ADD COLUMN si09_instsiconfi varchar(25);

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'si09_instsiconfi', 'varchar', 'Código da Instituição SICONFI', '', 'Código da Instituição SICONFI', 9, false, true, false, 0, 'text', 'Código da Instituição SICONFI');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si09_sequencial')))
    , (select codcam from db_syscampo where nomecam = 'si09_instsiconfi')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si09_sequencial'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('si09_sequencial')))));


--Menu
INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Gerar MSC','Gerar MSC.','con4_gerarmsc.php',1,1,'Gerar MSC.','t');
INSERT INTO db_menu values (32,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 2000018),2000018);

-- Fim do script

COMMIT;

