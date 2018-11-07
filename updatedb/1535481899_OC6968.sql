
-- Ocorrência 6968 - SCRIPT 05


-- Início do script

------------------------------------------
--    FUNÇÃO DUPLICA COLUNAS NIVEL 2    --
------------------------------------------

BEGIN;
SELECT fc_startsession();

CREATE or REPLACE
 function fc_duplicacolunas6968_n2(numrelatorio int, numnovorelatorio int, numlinha int) returns void as $$

   DECLARE
    reg record;

    BEGIN
    for reg in (
      SELECT *
        FROM orcparamseqorcparamseqcoluna
          INNER JOIN orcparamseq
            ON orcparamseq.o69_codparamrel = orcparamseqorcparamseqcoluna.o116_codparamrel
              AND orcparamseq.o69_codseq = orcparamseqorcparamseqcoluna.o116_codseq
                LEFT JOIN periodo
                  ON periodo.o114_sequencial = orcparamseqorcparamseqcoluna.o116_periodo
                    INNER JOIN orcparamseqcoluna
                      ON orcparamseqcoluna.o115_sequencial = orcparamseqorcparamseqcoluna.o116_orcparamseqcoluna
                        INNER JOIN orcparamrel
                          ON orcparamrel.o42_codparrel = orcparamseq.o69_codparamrel
                            WHERE o116_codparamrel = numrelatorio
                              AND o116_codseq = numlinha
                                ORDER BY o114_sigla,o116_ordem
    )loop

    INSERT
      INTO orcparamseqorcparamseqcoluna(o116_sequencial, o116_codseq, o116_codparamrel, o116_orcparamseqcoluna, o116_ordem, o116_periodo, o116_formula)
      VALUES(
        (SELECT MAX(o116_sequencial)+1 FROM orcparamseqorcparamseqcoluna),
        reg.o116_codseq,
        numnovorelatorio,
        reg.o116_orcparamseqcoluna,
        reg.o116_ordem,
        reg.o116_periodo,
        reg.o116_formula
      );

    END loop;
END
$$
language plpgsql;

-- FIM DA FUNÇÃO fc_duplicacolunas6968_n2


------------------------------------------
--    FUNÇÃO DUPLICA COLUNAS NIVEL 1    --
------------------------------------------

CREATE or REPLACE
 function fc_duplicacolunas6968_n1(numrelatorio int, numnovorelatorio int) returns void as $$

   DECLARE
    reg record;

    BEGIN
    for reg in (
      SELECT o69_codseq
        FROM orcparamseq
          WHERE o69_codparamrel = numrelatorio
            ORDER BY o69_codseq
    )loop

    PERFORM fc_duplicacolunas6968_n2(numrelatorio, numnovorelatorio, reg.o69_codseq);

    END loop;
END
$$
language plpgsql;

-- FIM DA FUNÇÃO fc_duplicacolunas6968_n1


-------------------------------
--    CHAMADA DAS FUNÇÕES    --
-------------------------------
  SELECT fc_startsession();
  SELECT fc_duplicacolunas6968_n1(145,155);
  SELECT fc_duplicacolunas6968_n1(81,156);
  SELECT fc_duplicacolunas6968_n1(148,157);
  SELECT fc_duplicacolunas6968_n1(88,158);
  SELECT fc_duplicacolunas6968_n1(146,159);
  SELECT fc_duplicacolunas6968_n1(147,160);
  SELECT fc_duplicacolunas6968_n1(105,161);
  SELECT fc_duplicacolunas6968_n1(149,162);
  SELECT fc_duplicacolunas6968_n1(106,163);
  SELECT fc_duplicacolunas6968_n1(107,164);
  SELECT fc_duplicacolunas6968_n1(87,165);
  SELECT fc_duplicacolunas6968_n1(89,166);
  SELECT fc_duplicacolunas6968_n1(90,167);
  SELECT fc_duplicacolunas6968_n1(91,168);
  SELECT fc_duplicacolunas6968_n1(92,169);
  SELECT fc_duplicacolunas6968_n1(108,170);
  SELECT fc_duplicacolunas6968_n1(109,171);
  SELECT fc_duplicacolunas6968_n1(93,172);

COMMIT;