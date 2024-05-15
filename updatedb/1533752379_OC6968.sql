
-- Ocorrência 6968 - SCRIPT 02


-- Início do script
BEGIN;
SELECT fc_startsession();

create or replace
 function fc_duplicaregistrorelatorio() returns void as $$

   DECLARE
   a integer[] := array[145,81,148,88,146,147,105,149,106,107,87,89,90,91,92,108,109,93];
   i integer;

   BEGIN
   -- realiza um loop e busca todos os registros
   FOREACH i IN ARRAY a loop
     INSERT
        INTO orcparamrel(o42_codparrel, o42_descrrel, o42_orcparamrelgrupo, o42_notapadrao)
          VALUES(
              (SELECT max(o42_codparrel) + 1 FROM orcparamrel WHERE o42_codparrel not IN (4000003, 100000, 99999)),
              (SELECT o42_descrrel FROM orcparamrel WHERE o42_codparrel = i),
              (SELECT o42_orcparamrelgrupo FROM orcparamrel WHERE o42_codparrel = i),
              (SELECT o42_notapadrao FROM orcparamrel WHERE o42_codparrel = i)
            );

   end loop;
end
$$
language plpgsql;
COMMIT;

BEGIN;
 SELECT fc_startsession();
 SELECT fc_duplicaregistrorelatorio();
COMMIT;

-- Fim do script