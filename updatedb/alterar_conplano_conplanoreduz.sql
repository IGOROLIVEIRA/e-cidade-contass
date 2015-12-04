begin;
drop view vs_planosistema;
drop view vs_planocontas;
alter table conplano alter column c60_estrut type varchar(16);

CREATE OR REPLACE VIEW vs_planosistema AS 
 SELECT conplanosis.c64_codpla, conplanosis.c64_estrut, conplanosis.c64_descr, 
    conplanoref.c65_codcon, conplanoref.c65_codpla, conplano.c60_codcon, 
    conplano.c60_anousu, conplano.c60_estrut, conplano.c60_descr, 
    conplano.c60_finali, conplano.c60_codsis, conplano.c60_codcla, 
    conplanoreduz.c61_codcon, conplanoreduz.c61_anousu, conplanoreduz.c61_reduz, 
    conplanoreduz.c61_instit, conplanoreduz.c61_codigo, 
    conplanoreduz.c61_contrapartida, conplanoexe.c62_anousu, 
    conplanoexe.c62_reduz, conplanoexe.c62_codrec, conplanoexe.c62_vlrcre, 
    conplanoexe.c62_vlrdeb, orctiporec.o15_codigo, orctiporec.o15_descr, 
    orctiporec.o15_codtri, orctiporec.o15_finali, orctiporec.o15_tipo, 
    orctiporec.o15_datalimite, conplanoconta.c63_codcon, 
    conplanoconta.c63_anousu, conplanoconta.c63_banco, 
    conplanoconta.c63_agencia, conplanoconta.c63_conta, 
    conplanoconta.c63_dvconta, conplanoconta.c63_dvagencia, 
    conplanoconta.c63_identificador
   FROM conplanosis
   JOIN conplanoref ON conplanoref.c65_codpla = conplanosis.c64_codpla
   JOIN conplano ON conplano.c60_codcon = conplanoref.c65_codcon
   JOIN conplanoreduz ON conplanoreduz.c61_codcon = conplano.c60_codcon
   JOIN conplanoexe ON conplanoreduz.c61_reduz = conplanoexe.c62_reduz
   JOIN orctiporec ON conplanoreduz.c61_codigo = orctiporec.o15_codigo
   LEFT JOIN conplanoconta ON conplano.c60_codcon = conplanoconta.c63_codcon;

ALTER TABLE vs_planosistema
  OWNER TO dbportal;
GRANT ALL ON TABLE vs_planosistema TO dbportal;
GRANT SELECT ON TABLE vs_planosistema TO dbseller;
GRANT SELECT ON TABLE vs_planosistema TO plugin;


CREATE OR REPLACE VIEW vs_planocontas AS 
 SELECT conplano.c60_codcon, conplano.c60_anousu, conplano.c60_estrut, 
    conplano.c60_descr, conplano.c60_finali, conplano.c60_codsis, 
    conplano.c60_codcla, consistema.c52_codsis, consistema.c52_descr, 
    consistema.c52_descrred, conclass.c51_codcla, conclass.c51_descr, 
    conplanoconta.c63_codcon, conplanoconta.c63_anousu, conplanoconta.c63_banco, 
    conplanoconta.c63_agencia, conplanoconta.c63_conta, 
    conplanoconta.c63_dvconta, conplanoconta.c63_dvagencia, 
    conplanoconta.c63_identificador, conplanoconta.c63_codigooperacao, 
    conplanoconta.c63_tipoconta, conplanoreduz.c61_codcon, 
    conplanoreduz.c61_anousu, conplanoreduz.c61_reduz, conplanoreduz.c61_instit, 
    conplanoreduz.c61_codigo, conplanoreduz.c61_contrapartida, 
    conplanoexe.c62_anousu, conplanoexe.c62_reduz, conplanoexe.c62_codrec, 
    conplanoexe.c62_vlrcre, conplanoexe.c62_vlrdeb, orctiporec.o15_codigo, 
    orctiporec.o15_descr, orctiporec.o15_codtri, orctiporec.o15_finali, 
    orctiporec.o15_tipo, orctiporec.o15_datalimite, db_config.codigo, 
    db_config.nomeinst, db_config.ender, db_config.munic, db_config.uf, 
    db_config.telef, db_config.email, db_config.ident, db_config.tx_banc, 
    db_config.numbanco, db_config.url, db_config.logo, db_config.figura, 
    db_config.dtcont, db_config.diario, db_config.pref, db_config.vicepref, 
    db_config.fax, db_config.cgc, db_config.cep, db_config.tpropri, 
    db_config.tsocios, db_config.prefeitura, db_config.bairro, db_config.numcgm, 
    db_config.codtrib, db_config.tribinst, db_config.segmento, 
    db_config.formvencfebraban, db_config.numero, db_config.nomedebconta, 
    db_config.db21_tipoinstit, db_config.db21_ativo, db_config.db21_regracgmiss, 
    db_config.db21_regracgmiptu, db_config.db21_codcli, db_config.nomeinstabrev, 
    db_config.db21_usasisagua, db_config.db21_codigomunicipoestado, 
    db_config.db21_datalimite, db_config.db21_criacao, db_config.db21_compl
   FROM conplano
   JOIN consistema ON conplano.c60_codsis = consistema.c52_codsis
   JOIN conclass ON conplano.c60_codcla = conclass.c51_codcla
   LEFT JOIN conplanoconta ON conplano.c60_codcon = conplanoconta.c63_codcon AND conplanoconta.c63_anousu = conplano.c60_anousu
   LEFT JOIN conplanoreduz ON conplano.c60_codcon = conplanoreduz.c61_codcon AND conplano.c60_anousu = conplanoreduz.c61_anousu
   LEFT JOIN conplanoexe ON conplanoreduz.c61_anousu = conplanoexe.c62_anousu AND conplanoreduz.c61_reduz = conplanoexe.c62_reduz
   LEFT JOIN orctiporec ON conplanoreduz.c61_codigo = orctiporec.o15_codigo
   LEFT JOIN db_config ON db_config.codigo = conplanoreduz.c61_instit;

ALTER TABLE vs_planocontas
  OWNER TO dbportal;
GRANT ALL ON TABLE vs_planocontas TO dbportal;
GRANT SELECT ON TABLE vs_planocontas TO dbseller;
GRANT SELECT ON TABLE vs_planocontas TO plugin;

alter table contabilidade.conplano add column c60_nregobrig int8;
alter table contabilidade.conplanoreduz add column c61_codtce int8;
update db_syscampo set tamanho=16 where nomecam='c60_estrut';
update db_syscampo set conteudo='varchar(16)' where nomecam='c60_estrut';
commit;
