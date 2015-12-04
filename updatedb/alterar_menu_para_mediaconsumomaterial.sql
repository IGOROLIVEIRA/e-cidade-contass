begin;
select fc_startsession();
update db_itensmenu set descricao = 'Média de Consumo de Materiais',help = 'Média de Consumo de Materiais',desctec = 'Média de Consumo de Materiais' where  id_item=3000099;
commit;
