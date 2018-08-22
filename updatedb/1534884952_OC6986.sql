begin;
select fc_startsession();
update db_itensmenu set funcao = 'emp2_empenhospagos001_new.php' where id_item = 4000304;
commit;
