begin;
select fc_startsession();
alter table conplanoreduz alter column c61_codtce set default 0;
/*update conplanoreduz set c61_codtce = 0 where (select cgc from db_config where prefeitura = 't' limit 1)  != '25223983000156';*/
commit;
