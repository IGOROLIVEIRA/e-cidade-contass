begin;
select fc_startsession();

insert into veiccadpotencia values (0,'nenhuma','nenhuma');
insert into veiccadcategcnh values (0,'nenhuma');

alter table veiculos alter column ve01_veiccadcategcnh set default 0;
alter table veiculos alter column ve01_veiccadpotencia set default 0;
commit;
