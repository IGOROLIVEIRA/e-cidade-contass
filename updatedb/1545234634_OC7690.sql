
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'De/Para Orcamento MSC','De/Para Orcamento MSC.','con4_sicominfocomplementarmsc.php',1,1,'De/Para Orcamento MSC','t');
INSERT INTO db_menu values (3962,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 3962 and modulo = 2000018),2000018);


--DROP TABLE:
DROP TABLE IF EXISTS elemdespmsc CASCADE;
--Criando drop sequences

-- TABELAS E ESTRUTURA

-- Modulo: contabilidade
CREATE TABLE elemdespmsc(
c211_elemdespestrut varchar(8) NOT NULL,
c211_mscestrut varchar(8) ,
CONSTRAINT elemdespmsc_c211_elemdespestrut_c211_mscestrut PRIMARY KEY (c211_elemdespestrut,c211_mscestrut));

CREATE UNIQUE INDEX elemdespmsc_index ON elemdespmsc(c211_elemdespestrut,c211_mscestrut);
--Dicionário
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'elemdespmsc', 'De/Para Orçamento MSC Elemento da Despesa', 'c211 ', '2018-12-20', 'De/Para Orçamento MSC Elemento da Despesa', 0, false, false, false, false);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c211_elemdespestrut', 'varchar(8)', 'E-Cidade', '', 'E-Cidade', 8, false, true, false, 0, 'text', 'E-Cidade');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c211_mscestrut', 'varchar(8)', 'MSC', '', 'MSC', 8, false, true, false, 0, 'text', 'MSC');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c211_elemdespestrut'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c211_mscestrut'), 2, 0);

INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'elemdespmsc_index', (select max(codarq) from db_sysarquivo), '0');



--DROP TABLE:
DROP TABLE IF EXISTS natdespmsc CASCADE;
--Criando drop sequences

-- TABELAS E ESTRUTURA

-- Modulo: contabilidade
CREATE TABLE natdespmsc(
c212_natdespestrut varchar(8) NOT NULL,
c212_mscestrut varchar(8) ,
CONSTRAINT natdespmsc_c212_natdespestrut_c212_mscestrut PRIMARY KEY (c212_natdespestrut,c212_mscestrut));

CREATE UNIQUE INDEX natdespmsc_index ON natdespmsc(c212_natdespestrut,c212_mscestrut);
--Dicionário
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'natdespmsc', 'De/Para Orçamento MSC Natureza da Despesa', 'c212 ', '2018-12-20', 'De/Para Orçamento MSC Natureza da Despesa', 0, false, false, false, false);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c212_natdespestrut', 'varchar(8)', 'E-Cidade', '', 'E-Cidade', 8, false, true, false, 0, 'text', 'E-Cidade');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c212_mscestrut', 'varchar(8)', 'MSC', '', 'MSC', 8, false, true, false, 0, 'text', 'MSC');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c212_natdespestrut'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c212_mscestrut'), 2, 0);

INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'natdespmsc_index', (select max(codarq) from db_sysarquivo), '0');

-- Fim do script

COMMIT;
