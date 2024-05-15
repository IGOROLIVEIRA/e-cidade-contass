begin;
select fc_startsession();
alter table empnota add column e69_notafiscaleletronica int8 not null default 0;
alter table empnota add column e69_chaveacesso varchar(60);
alter table empnota add column e69_nfserie varchar(8);
commit;
