
-- Ocorrência 5051
BEGIN;
SELECT fc_startsession();

-- Início do script

UPDATE acordoposicaotipo
SET ac27_descricao = 'Inclusão'
WHERE ac27_sequencial = 1;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Reequilibrio'
WHERE ac27_sequencial = 2;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Realinhamento'
WHERE ac27_sequencial = 3;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Aditamento'
WHERE ac27_sequencial = 4;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Outros'
WHERE ac27_sequencial = 7;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Vigência/Execução'
WHERE ac27_sequencial = 13;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Alteração de Prazo de Execução'
WHERE ac27_sequencial = 8;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Acréscimo de Item(ns)'
WHERE ac27_sequencial = 9;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Decréscimo de Item(ns)'
WHERE ac27_sequencial = 10;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Alteração de Projeto/Especificação'
WHERE ac27_sequencial = 12;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Acrêscimo/Decrêscimo de item(ns) conjugado'
WHERE ac27_sequencial = 14;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Reajuste'
WHERE ac27_sequencial = 5;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Alteração de Prazo de Vigência'
WHERE ac27_sequencial = 6;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Acréscimo de Valor (Apostilamento)'
WHERE ac27_sequencial = 15;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Decréscimo de Valor (Apostilamento)'
WHERE ac27_sequencial = 16;


UPDATE acordoposicaotipo
SET ac27_descricao = 'Não houve alteração de Valor (Apostilamento)'
WHERE ac27_sequencial = 17;

-- Fim do script

COMMIT;

