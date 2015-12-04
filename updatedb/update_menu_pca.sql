begin;
select fc_startsession();

update db_itensmenu set descricao = 'Prestação de Contas Anual - PCA' where id_item = 3000100;

commit;
