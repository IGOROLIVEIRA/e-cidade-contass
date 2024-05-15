begin;
select fc_startsession();

alter table flpgo112014 RENAME column si196_destiporemuneracao to si196_desctiporemuneracao;
alter table flpgo112015 RENAME column si196_destiporemuneracao to si196_desctiporemuneracao;
alter table flpgo112016 RENAME column si196_destiporemuneracao to si196_desctiporemuneracao;

commit;