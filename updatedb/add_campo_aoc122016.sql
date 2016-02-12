begin;
select fc_startsession();
alter table aoc122016 add column si40_valorabertolei double precision;
alter table aoc142016 add column si42_origemrecalteracao varchar(6);
commit;
