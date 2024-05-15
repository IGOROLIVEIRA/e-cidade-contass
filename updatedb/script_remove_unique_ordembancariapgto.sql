select fc_startsession();
begin;
alter table ordembancariapagamento DROP CONSTRAINT ordembancariapagamento_k00_codord_key;
commit;