begin;

select fc_startsession();

alter table rhpessoal add column rh01_sicom int default 1;

commit;