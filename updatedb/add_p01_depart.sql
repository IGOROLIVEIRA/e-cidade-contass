begin;

select fc_startsession();

alter table protprocessodocumento add column p01_depart integer;

commit;
