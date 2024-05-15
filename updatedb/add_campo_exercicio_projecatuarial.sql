begin;
select fc_startsession();
alter table projecaoatuarial10 add column si168_exercicio int not null default 0;
commit;
