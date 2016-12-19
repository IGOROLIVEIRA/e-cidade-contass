select fc_startsession();
begin;
update db_itensmenu set libcliente = false where funcao = 'con2_ddc001.php';

commit;