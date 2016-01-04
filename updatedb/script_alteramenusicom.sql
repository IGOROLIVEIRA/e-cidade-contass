BEGIN;

select fc_startsession();

update db_itensmenu set descricao = 'Fornecedores', help = 'Fornecedores' where id_item = 3962;

COMMIT;
