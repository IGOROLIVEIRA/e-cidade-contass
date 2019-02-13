/*
-- Ocorrência 7687
BEGIN;
SELECT fc_startsession();

-- Início do script
--INSERINDO USUARIOS

--USUARIO DEBORAH LOANE VIERA ALVES
INSERT INTO cgm VALUES (nextval('cgm_z01_numcgm_seq'),'DEBORAH LOANE VIEIRA ALVES','NAO INFORMADO',0,'','NAO INFORMADO','PORTO ALEGRE','RS',39598000,'','2018-10-29','','',1,'','','','',0,'','','','','','','','','',1,1,'',0,'08965946611','',null,'','','F','2018-10-29','','10:30','','','',null,null,'DEBORAH LOANE VIEIRA ALVES',null,null,0,'',null,'','t',0,'','',0);
INSERT INTO db_usuarios VALUES (nextval('db_usuarios_id_usuario_seq'),'DEBORAH LOANE VIEIRA ALVES','deborah','10470c3b4b1fed12c3baac014be15fac67c6e815',1,'',0,1,'2018-10-29');
INSERT INTO db_usuacgm  VALUES ((select id_usuario from db_usuarios where login like '%deborah%'),(select z01_numcgm from cgm where z01_nome like '%DEBORAH LOANE VIEIRA ALVES%'));
INSERT INTO db_userinst VALUES (1,(select id_usuario from db_usuarios where login like '%deborah%'));
INSERT INTO db_permissao VALUES ((select id_usuario from db_usuarios where login like '%deborah%'),29324,1,2018,1,578);
INSERT INTO db_depusu VALUES ((select id_usuario from db_usuarios where login like '%deborah%'),1,1);
--PEMISSAO DE EMPENHO
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,1,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%deborah%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,2,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%deborah%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,3,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%deborah%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,4,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%deborah%'));

--USUARIO MAISA CAETANO DE OLIVEIRA
INSERT INTO cgm VALUES (nextval('cgm_z01_numcgm_seq'),'MAISA CAETANO DE OLIVEIRA','NAO INFORMADO',0,'','NAO INFORMADO','PORTO ALEGRE','RS',39598000,'','2018-10-29','','',1,'','','','',0,'','','','','','','','','',1,1,'',0,'10855958626','',null,'','','F','2018-10-29','','10:30','','','',null,null,'MAISA CAETANO DE OLIVEIRA',null,null,0,'',null,'','t',0,'','',0);
INSERT INTO db_usuarios VALUES (nextval('db_usuarios_id_usuario_seq'),'MAISA CAETANO DE OLIVEIRA','maisa','10470c3b4b1fed12c3baac014be15fac67c6e815',1,'',0,1,'2018-10-29');
INSERT INTO db_usuacgm  VALUES ((select id_usuario from db_usuarios where login like '%maisa%'),(select z01_numcgm from cgm where z01_nome like '%MAISA CAETANO DE OLIVEIRA%'));
INSERT INTO db_userinst VALUES (1,(select id_usuario from db_usuarios where login like '%maisa%'));
INSERT INTO db_permissao VALUES ((select id_usuario from db_usuarios where login like '%maisa%'),29324,1,2018,1,578);
INSERT INTO db_depusu VALUES ((select id_usuario from db_usuarios where login like '%maisa%'),1,1);
--PERMISSAO DE EMPENHO
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,1,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maisa%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,2,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maisa%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,3,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maisa%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,4,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maisa%'));

--USUARIO IRENE JHECE RIBEIRO DA SILVA
INSERT INTO cgm VALUES (nextval('cgm_z01_numcgm_seq'),'IRENE JHECE RIBEIRO DA SILVA','NAO INFORMADO',0,'','NAO INFORMADO','PORTO ALEGRE','RS',39598000,'','2018-10-29','','',1,'','','','',0,'','','','','','','','','',1,1,'',0,'13199562620','',null,'','','F','2018-10-29','','10:30','','','',null,null,'IRENE JHECE RIBEIRO DA SILVA',null,null,0,'',null,'','t',0,'','',0);
INSERT INTO db_usuarios VALUES (nextval('db_usuarios_id_usuario_seq'),'IRENE JHECE RIBEIRO DA SILVA','irene','10470c3b4b1fed12c3baac014be15fac67c6e815',1,'',0,1,'2018-10-29');
INSERT INTO db_usuacgm  VALUES ((select id_usuario from db_usuarios where login like '%irene%'),(select z01_numcgm from cgm where z01_nome like '%IRENE JHECE RIBEIRO DA SILVA%'));
INSERT INTO db_userinst VALUES (1,(select id_usuario from db_usuarios where login like '%irene%'));
INSERT INTO db_permissao VALUES ((select id_usuario from db_usuarios where login like '%irene%'),29324,1,2018,1,578);
INSERT INTO db_depusu VALUES ((select id_usuario from db_usuarios where login like '%irene%'),1,1);
--PERMISSAO DE EMPENHO
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,1,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%irene%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,2,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%irene%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,3,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%irene%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,4,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%irene%'));


--USUARIO VICTOR COSTA LAFETA
INSERT INTO cgm VALUES (nextval('cgm_z01_numcgm_seq'),'VICTOR COSTA LAFETA','NAO INFORMADO',0,'','NAO INFORMADO','PORTO ALEGRE','RS',39598000,'','2018-10-29','','',1,'','','','',0,'','','','','','','','','',1,1,'',0,'09570803606','',null,'','','F','2018-10-29','','10:30','','','',null,null,'VICTOR COSTA LAFETA',null,null,0,'',null,'','t',0,'','',0);
INSERT INTO db_usuarios VALUES (nextval('db_usuarios_id_usuario_seq'),'VICTOR COSTA LAFETA','victor.lafeta','10470c3b4b1fed12c3baac014be15fac67c6e815',1,'',0,1,'2018-10-29');
INSERT INTO db_usuacgm  VALUES ((select id_usuario from db_usuarios where login like '%victor.lafeta%'),(select z01_numcgm from cgm where z01_nome like '%VICTOR COSTA LAFETA%'));
INSERT INTO db_userinst VALUES (1,(select id_usuario from db_usuarios where login like '%victor.lafeta%'));
INSERT INTO db_permissao VALUES ((select id_usuario from db_usuarios where login like '%victor.lafeta%'),29324,1,2018,1,578);
INSERT INTO db_depusu VALUES ((select id_usuario from db_usuarios where login like '%victor.lafeta%'),1,1);
--PERMISSAO DE EMPENHO
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,1,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%victor.lafeta%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,2,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%victor.lafeta%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,3,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%victor.lafeta%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,4,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%victor.lafeta%'));

--USUARIO MARA FERNANDA MURÇA MACHADO
INSERT INTO cgm VALUES (nextval('cgm_z01_numcgm_seq'),'MARIA FERNANDA MURÇA MACHADO','NAO INFORMADO',0,'','NAO INFORMADO','PORTO ALEGRE','RS',39598000,'','2018-10-29','','',1,'','','','',0,'','','','','','','','','',1,1,'',0,'09421705637','',null,'','','F','2018-10-29','','10:30','','','',null,null,'MARIA FERNANDA MURÇA MACHADO',null,null,0,'',null,'','t',0,'','',0);
INSERT INTO db_usuarios VALUES (nextval('db_usuarios_id_usuario_seq'),'MARIA FERNANDA MURÇA MACHADO','maria.fernanda','10470c3b4b1fed12c3baac014be15fac67c6e815',1,'',0,1,'2018-10-29');
INSERT INTO db_usuacgm  VALUES ((select id_usuario from db_usuarios where login like '%maria.fernanda%'),(select z01_numcgm from cgm where z01_nome like '%VICTOR COSTA LAFETA%'));
INSERT INTO db_userinst VALUES (1,(select id_usuario from db_usuarios where login like '%maria.fernanda%'));
INSERT INTO db_permissao VALUES ((select id_usuario from db_usuarios where login like '%maria.fernanda%'),29324,1,2018,1,578);
INSERT INTO db_depusu VALUES ((select id_usuario from db_usuarios where login like '%maria.fernanda%'),1,1);
--PERMISSAO DE EMPENHO
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,1,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maria.fernanda%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,2,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maria.fernanda%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,3,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maria.fernanda%'));
insert into db_permemp values (nextval('db_permemp_db20_codperm_seq'),2018,4,0,0,0,0,0,0,0,'M');
insert into db_usupermemp values ((select max(db20_codperm) from db_permemp),(select id_usuario from db_usuarios where login like '%maria.fernanda%'));

-- Fim do script

COMMIT;
*/
