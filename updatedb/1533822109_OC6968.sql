
-- Ocorrência 6968 - SCRIPT 04


-- Início do script

------------------------------------------
--    DUPLICAÇÃO NA TABELA periodo      --
------------------------------------------
BEGIN;
SELECT fc_startsession();

create or replace
 function fc_duplicaperiodo6968(numrelatorio int, numnovorelatorio int) returns void as $$

   DECLARE
    reg record;

   BEGIN
   -- realiza um loop e busca todos os registros
   for reg in (
    SELECT o114_sequencial
      FROM orcparamrelperiodos
        INNER JOIN periodo
          ON o114_sequencial = o113_periodo
            WHERE o113_orcparamrel = numrelatorio
   )loop

   INSERT
    INTO orcparamrelperiodos(o113_sequencial, o113_periodo, o113_orcparamrel)
      VALUES(
        (SELECT MAX(o113_sequencial)+1
          FROM orcparamrelperiodos
            WHERE o113_sequencial
              NOT IN
                (4000803,4000802,4000801,4000800,4000799,4000798,4000797,4000796,4000795,4000794,4000793,4000792,
                 4000790,4000789,4000788,4000787,4000786,4000785,4000784,4000783,4000782,4000781,4000780,4000779,
                 4000778,4000777,4000776,4000775,4000774,4000773,4000772,4000771,4000770,4000769,4000768,4000767,
                 4000766,4000765,4000764,4000763,4000762,4000761,4000760,4000759,4000758,4000757,4000756,4000755)
                AND o113_sequencial < 1000000),

        reg.o114_sequencial,
        numnovorelatorio
      );

   end loop;
end
$$
language plpgsql;
COMMIT;

-------------------------------
--    CHAMADA DAS FUNÇÕES    --
-------------------------------
BEGIN;
  SELECT fc_startsession();
  SELECT fc_duplicaperiodo6968(145,155);
  SELECT fc_duplicaperiodo6968(81,156);
  SELECT fc_duplicaperiodo6968(148,157);
  SELECT fc_duplicaperiodo6968(88,158);
  SELECT fc_duplicaperiodo6968(146,159);
  SELECT fc_duplicaperiodo6968(147,160);
  SELECT fc_duplicaperiodo6968(105,161);
  SELECT fc_duplicaperiodo6968(149,162);
  SELECT fc_duplicaperiodo6968(106,163);
  SELECT fc_duplicaperiodo6968(107,164);
  SELECT fc_duplicaperiodo6968(87,165);
  SELECT fc_duplicaperiodo6968(89,166);
  SELECT fc_duplicaperiodo6968(90,167);
  SELECT fc_duplicaperiodo6968(91,168);
  SELECT fc_duplicaperiodo6968(92,169);
  SELECT fc_duplicaperiodo6968(108,170);
  SELECT fc_duplicaperiodo6968(109,171);
  SELECT fc_duplicaperiodo6968(93,172);

COMMIT;


-- Fim do script