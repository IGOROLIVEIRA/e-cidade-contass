begin;
select fc_startsession();
update db_syscampo set descricao='Itens em Ponto de Pedido',rotulo='Itens em Ponto de Pedido',rotulorel='Itens em Ponto de Pedido' where nomecam='dif_ponto_pedido';
commit;
