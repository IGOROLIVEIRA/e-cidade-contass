
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

--Menus
INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Vínculo Pcasp MSC','Vínculo Pcasp MSC.','',1,1,'Vínculo Pcasp MSC','t');
INSERT INTO db_menu values (3962,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 3962 and modulo = 2000018),2000018);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inculir Vínculo Pcasp MSC.','con1_vinculopcaspmsc001.php',1,1,'Inculir Vínculo Pcasp MSC','t');
INSERT INTO db_menu values ((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,2000018);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alterar Vínculo Pcasp MSC.','con1_vinculopcaspmsc002.php',1,1,'Alterar Vínculo Pcasp MSC','t');
INSERT INTO db_menu values ((select max(id_item)-2 from db_itensmenu),(select max(id_item) from db_itensmenu),2,2000018);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Excluir Vínculo Pcasp MSC.','con1_vinculopcaspmsc003.php',1,1,'Excluir Vínculo Pcasp MSC','t');
INSERT INTO db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,2000018);



--DROP TABLE:
DROP TABLE IF EXISTS vinculopcaspmsc CASCADE;
--Criando drop sequences

-- TABELAS E ESTRUTURA

-- Modulo: contabilidade
CREATE TABLE vinculopcaspmsc(
c210_pcaspestrut    varchar(9) NOT NULL ,
c210_mscestrut    varchar(9) ,
CONSTRAINT vinculopcaspmsc_c210_pcaspestrut_c210_mscestrut PRIMARY KEY (c210_pcaspestrut,c210_mscestrut));

CREATE UNIQUE INDEX vinculopcaspmsc_index ON vinculopcaspmsc(c210_pcaspestrut,c210_mscestrut);


--Dicionário
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'vinculopcaspmsc', 'Vinculo Pcasp MSC', 'c210 ', '2018-12-03', 'Vinculo Pcasp MSC', 0, false, false, false, false);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c210_pcaspestrut', 'varchar(9)', 'Estrutural Pcasp MSC', '', 'Estrutural Pcasp MSC', 9, false, true, false, 0, 'text', 'Estrutural Pcasp MSC');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c210_mscestrut', 'varchar(9)', 'Estrutural MSC', '', 'Estrutural MSC', 9, false, true, false, 0, 'text', 'Estrutural MSC');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c210_pcaspestrut'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c210_mscestrut'), 2, 0);

INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'vinculopcaspmsc_index', (select max(codarq) from db_sysarquivo), '0');

-- Fim do script

COMMIT;

