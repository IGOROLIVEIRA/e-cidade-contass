select fc_startsession()
begin;
update db_itensmenu set funcao = 'emp2_empenhospagos001_new.php' where id_item = 9357
commit;
