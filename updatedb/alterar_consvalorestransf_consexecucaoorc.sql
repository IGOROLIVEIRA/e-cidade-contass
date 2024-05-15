begin;
select fc_startsession();
alter table consvalorestransf add column c201_anousu int8;
update consvalorestransf set c201_anousu=2014;

alter table consexecucaoorc add column c202_anousu int8;
update consexecucaoorc set c202_anousu=2014;
commit;
