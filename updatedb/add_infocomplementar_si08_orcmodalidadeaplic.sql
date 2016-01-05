begin;
select fc_startsession();
alter table infocomplementares add column si08_orcmodalidadelic int8 not null default 0;
commit;
