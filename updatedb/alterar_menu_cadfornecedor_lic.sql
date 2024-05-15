begin;
select fc_startsession();
insert into db_itensmenu values (3000251,'Fornecedor','Fornecedor','',1,1,'Cadastro de fornecedores','t');
update db_menu set id_item_filho = 3000251 where id_item=3470 and modulo=381 and menusequencia=4;
update db_menu set id_item = 3000251 where id_item=3962 and modulo=381;
commit;
