BEGIN;


select fc_startsession();

alter table orcunidade add column o41_orddespesa bigint;
alter table orcunidade add column o41_ordliquidacao bigint;
alter table orcunidade add column o41_ordpagamento bigint;
alter table orcunidade add column o41_subunidade bigint;

COMMIT;

