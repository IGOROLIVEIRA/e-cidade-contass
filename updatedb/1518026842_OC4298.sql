
-- Ocorrência 4298
BEGIN;
SELECT fc_startsession();

-- Início do script


ALTER TABLE bensdispensatombamento ADD COLUMN e139_datadispensa DATE;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e139_datadispensa',
                              'date',
                              'Data da dispensa',
                              '',
                              'Data da dispensa',
                              10,
                              FALSE,
                              TRUE,
                              FALSE,
                              0,
                              'date',
                              'Data da dispensa');

UPDATE bensdispensatombamento
SET e139_datadispensa =
  (SELECT e69_dtrecebe
   FROM bensdispensatombamento AS p
   INNER JOIN empnotaitem ON e72_sequencial=e139_empnotaitem
   INNER JOIN empnota ON e69_codnota=e72_codnota
   WHERE bensdispensatombamento.e139_sequencial = p.e139_sequencial );

-- Fim do script

COMMIT;
