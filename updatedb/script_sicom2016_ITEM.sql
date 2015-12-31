BEGIN;
select fc_startsession();

alter table pcmater add column pc01_data date;
update pcmater set pc01_data = '2000-01-01';

COMMIT;
