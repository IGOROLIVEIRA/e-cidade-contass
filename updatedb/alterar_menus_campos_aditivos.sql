begin;
SELECT fc_startsession();
update db_itensmenu set libcliente = 'f' where id_item=8569;
update db_itensmenu set libcliente = 'f' where id_item=8573;
update db_itensmenu set libcliente = 'f' where id_item=8588;
update db_itensmenu set libcliente = 'f' where id_item=8589;
update db_itensmenu set descricao = 'Inclusão', help = 'Inclusão' where id_item = 4000307;

update acordoposicaotipo set ac27_descricao = 'Reajuste' where ac27_sequencial=5;
update acordoposicaotipo set ac27_descricao = 'Alteração de Prazo de Vigência' where ac27_sequencial=6;
commit;
