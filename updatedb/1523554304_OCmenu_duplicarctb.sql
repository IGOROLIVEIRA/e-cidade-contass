
-- Ocorrência menu_duplicarctb
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES (
  (SELECT max(id_item)+1 FROM db_itensmenu),'Duplicar CTB','Duplicar CTB','con4_duplicarctb.php',1,1,'Duplicar CTB','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values
  (3332,(SELECT id_item FROM db_itensmenu WHERE funcao = 'con4_duplicarctb.php'),205,209);

-- Fim do script

COMMIT;

