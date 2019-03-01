
-- Ocorrência 0
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Manutenção Saldo Conta Corrente','Manutenção Saldo Conta Corrente','con4_manutsaldocontacorrente001.php',1,1,'Manutenção Saldo Conta Corrente','t');
INSERT INTO db_menu values (9680,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 9680 and modulo = 209),209);


-- Fim do script

COMMIT;

