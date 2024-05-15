BEGIN;
SELECT fc_startsession();
delete from db_menu where id_item_filho = 3000183 and modulo=439;
delete from db_itensmenu where descricao like 'Departamento/Divis%o';
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (3000256,'Departamento/Divisão','Departamento/Divisão','pat2_gerardepartdiv.php',1,1,'Departamento/Divisão','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (30,3000256,600,439);
COMMIT;

