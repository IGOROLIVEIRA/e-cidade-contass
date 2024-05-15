
-- Ocorrência 5593
BEGIN;
SELECT fc_startsession();
INSERT INTO conhistdoc VALUES (122,'RENUNICA DE RECEITA',101);
INSERT INTO conhistdoc VALUES (123,'RENUNICA DE RECEITA ESTORNO',100);
SELECT setval('conhistdocregra_c92_sequencial_seq',(SELECT max(c92_sequencial) FROM conhistdocregra));
INSERT INTO conhistdocregra(c92_sequencial,c92_conhistdoc,c92_descricao,c92_regra,c92_anousu)
VALUES ((select nextval('conhistdocregra_c92_sequencial_seq')),
        122,'RENUNICA DE RECEITA',
        'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 9000 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
        2017);
INSERT INTO conhistdocregra(c92_sequencial,c92_conhistdoc,c92_descricao,c92_regra,c92_anousu)
VALUES ((select nextval('conhistdocregra_c92_sequencial_seq')),
        123,'RENUNICA DE RECEITA',
        'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 9000 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
        2017);
INSERT INTO contrans SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),2017,122,1;
INSERT INTO contrans SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),2017,123,1;
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122 AND c45_anousu = 2017 LIMIT 1), 100,
       'PRIMEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'PRIMEIRO LANCAMENTO',
       1);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122
              AND c45_anousu = 2017
        LIMIT 1), 100,
       'SEGUNDO LANCAMENTO',
       0,
       FALSE,
       0,
       'SEGUNDO LANCAMENTO',
       2);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122
              AND c45_anousu = 2017
        LIMIT 1), 100,
       'TERCEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'TERCEIRO LANCAMENTO',
       3);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2017
        LIMIT 1), 101,
       'PRIMEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'PRIMEIRO LANCAMENTO',
       1);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2017
        LIMIT 1), 101,
       'SEGUNDO LANCAMENTO',
       0,
       FALSE,
       0,
       'SEGUNDO LANCAMENTO',
       2);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2017
        LIMIT 1), 101,
       'TERCEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'TERCEIRO LANCAMENTO',
       3);
INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT min(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2017
          AND c46_ordem = 1
     LIMIT 1 ) AS c47_seqtranslan,
    0 AS c47_debito,
    0 AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2017
          AND c46_ordem = 2
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '621320000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '621100000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2017
          AND c46_ordem = 3
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '721110000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '821110100000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT min(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2017
          AND c46_ordem = 1
     LIMIT 1 ) AS c47_seqtranslan,
    0 AS c47_debito,
    0 AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2017
          AND c46_ordem = 2
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '621100000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '621320000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2017
          AND c46_ordem = 3
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '821110100000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
    WHERE c60_estrut = '721110000000000'
          AND c61_instit = 1
          AND c61_anousu = 2017) AS c47_credito,
    c47_obs,
    c47_ref,
    2017 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2017
  LIMIT 1;

INSERT INTO contranslrvinculo VALUES (nextval('contranslrvinculo_c116_sequencial_seq'),122,123);
INSERT INTO vinculoeventoscontabeis VALUES (nextval('vinculoeventoscontabeis_c115_sequencial_seq'),122,123);

SELECT setval('conhistdocregra_c92_sequencial_seq',(SELECT max(c92_sequencial) FROM conhistdocregra));
INSERT INTO conhistdocregra(c92_sequencial,c92_conhistdoc,c92_descricao,c92_regra,c92_anousu)
VALUES ((select nextval('conhistdocregra_c92_sequencial_seq')),
        122,'RENUNICA DE RECEITA',
        'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 9000 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
        2018);
INSERT INTO conhistdocregra(c92_sequencial,c92_conhistdoc,c92_descricao,c92_regra,c92_anousu)
VALUES ((select nextval('conhistdocregra_c92_sequencial_seq')),
        123,'RENUNICA DE RECEITA',
        'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 9000 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
        2018);
INSERT INTO contrans SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),2018,122,1;
INSERT INTO contrans SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),2018,123,1;
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122 AND c45_anousu = 2018 LIMIT 1), 100,
       'PRIMEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'PRIMEIRO LANCAMENTO',
       1);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122
              AND c45_anousu = 2018
        LIMIT 1), 100,
       'SEGUNDO LANCAMENTO',
       0,
       FALSE,
       0,
       'SEGUNDO LANCAMENTO',
       2);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 122
              AND c45_anousu = 2018
        LIMIT 1), 100,
       'TERCEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'TERCEIRO LANCAMENTO',
       3);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2018
        LIMIT 1), 101,
       'PRIMEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'PRIMEIRO LANCAMENTO',
       1);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2018
        LIMIT 1), 101,
       'SEGUNDO LANCAMENTO',
       0,
       FALSE,
       0,
       'SEGUNDO LANCAMENTO',
       2);
INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 123
              AND c45_anousu = 2018
        LIMIT 1), 101,
       'TERCEIRO LANCAMENTO',
       0,
       FALSE,
       0,
       'TERCEIRO LANCAMENTO',
       3);
INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT min(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2018
          AND c46_ordem = 1
     LIMIT 1 ) AS c47_seqtranslan,
    0 AS c47_debito,
    0 AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2018
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2018
          AND c46_ordem = 2
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '621320000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '621100000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2018
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 122
          AND c45_anousu = 2018
          AND c46_ordem = 3
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '721110000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '821110100000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 100
        AND c45_anousu = 2018
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT min(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2018
          AND c46_ordem = 1
     LIMIT 1 ) AS c47_seqtranslan,
    0 AS c47_debito,
    0 AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2018
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2018
          AND c46_ordem = 2
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '621100000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '621320000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2018
  LIMIT 1;

INSERT INTO contranslr
  SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 123
          AND c45_anousu = 2018
          AND c46_ordem = 3
     LIMIT 1) AS c47_seqtranslan,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '821110100000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_debito,
    (SELECT c61_reduz FROM conplanoreduz
      JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2018
    WHERE c60_estrut = '721110000000000'
          AND c61_instit = 1
          AND c61_anousu = 2018) AS c47_credito,
    c47_obs,
    c47_ref,
    2018 AS c47_anousu,
    c47_instit,
    c47_compara,
    c47_tiporesto
  FROM contrans
    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
    JOIN contranslr ON c46_seqtranslan = c47_seqtranslan
  WHERE c45_coddoc = 101
        AND c45_anousu = 2018
  LIMIT 1;


COMMIT;

