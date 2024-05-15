begin;
select fc_startsession();
alter table orcleialtorcamentaria add column o200_percautorizado double precision default 0;
commit;
