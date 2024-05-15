begin;
select fc_startsession();
alter table veiculos add column ve01_codigoant integer null;
alter table veiculos add column ve01_codunidadesub varchar(8) null;
commit;
