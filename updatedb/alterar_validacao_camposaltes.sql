begin;
select fc_startsession();
update db_syscampo set aceitatipo=4 where nomecam = 'k13_vlratu';
update db_syscampo set aceitatipo=4 where nomecam = 'k13_saldo';
commit;
