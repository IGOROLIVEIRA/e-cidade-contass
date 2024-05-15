begin;
select fc_startsession();
alter table orcprogramahorizontetemp alter COLUMN o17_valor TYPE double precision;
commit;
