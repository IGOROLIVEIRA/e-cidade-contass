BEGIN;
select fc_startsession();
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES (
  (SELECT max(id_item)+1 FROM db_itensmenu),'RP Sem Disponiblidade','RP Sem Disponiblidade','con1_emprestosemdesponi001.php',1,1,'RP Sem Disponiblidade','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values
  (3332,(SELECT id_item FROM db_itensmenu WHERE funcao = 'con1_emprestosemdesponi001.php'),205,209);
COMMIT;