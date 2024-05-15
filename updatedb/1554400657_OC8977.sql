select fc_startsession();
begin;
alter table cancdebitos alter column k20_descr type text;
commit;