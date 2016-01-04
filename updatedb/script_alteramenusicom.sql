BEGIN;

select fc_startsession();

update db_itensmenu set descricao = 'Cadastros', help = 'Cadastros' where id_item = 3962;

COMMIT;
