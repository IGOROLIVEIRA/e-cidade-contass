begin;
select fc_startsession();
alter table ordembancariapagamento add constraint ordembancariapagamento_k00_codordembancaria_fk foreign key (k00_codordembancaria) references ordembancaria;
commit;
