select fc_startsession();
begin;

alter table matestoquetipo add column m81_tipo int4;
create index matestoquetipo_tipo_in on matestoquetipo(m81_tipo);

select fc_schemas_dbportal();
commit
