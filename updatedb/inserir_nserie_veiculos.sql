begin;
select fc_startsession();
insert into db_syscampo values(2011700,'ve01_nroserie','varchar(20)','Nº de Série','null','Nº de Série',20,'f','f','f',0,'text','Nº de Série');
insert into db_sysarqcamp values(1590,2011700,25,0);
alter table veiculos add column ve01_nroserie varchar(20);
alter table veiculos alter column ve01_veiccadcateg drop default;
alter table veiculos alter column ve01_veiccadcateg drop not null;
alter table veiculos alter column ve01_veiccadpotencia drop default;
alter table veiculos alter column ve01_veiccadpotencia drop not null;
alter table veiculos alter column ve01_veiccadtipo drop default;
alter table veiculos alter column ve01_veiccadtipo drop not null;
alter table veiculos alter column ve01_veiccadmodelo  drop default;
alter table veiculos alter column ve01_veiccadmodelo  drop not null;
alter table veiculos alter column ve01_veiccadcor  drop default;
alter table veiculos alter column ve01_veiccadcor  drop not null;
alter table veiculos alter column ve01_veiccadproced  drop default;
alter table veiculos alter column ve01_veiccadproced  drop not null;


alter table veiculos alter column ve01_veiccadcategcnh  drop default;
alter table veiculos alter column ve01_veiccadcategcnh  drop not null;

alter table veiculos alter column ve01_veiccadtipocapacidade  drop default;
alter table veiculos alter column ve01_veiccadtipocapacidade  drop not null;

commit;
