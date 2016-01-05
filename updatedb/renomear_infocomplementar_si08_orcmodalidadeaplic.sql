begin;
select fc_startsession();
alter table infocomplementares rename si08_orcmodalidadelic to si08_orcmodalidadeaplic;
commit;
