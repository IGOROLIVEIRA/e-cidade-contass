begin;
select fc_startsession();
alter table veicmanut alter COLUMN ve62_valor TYPE double precision;
commit;
