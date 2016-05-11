select fc_startsession();
begin;
alter table regraencerramentonaturezaorcamentaria add column c117_contareferencia varchar(1) default 'D';
commit;