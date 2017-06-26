--  Cria os documentos 115 e 116, que serão utilizados na contabilização
-- das deduções das receitas.

select fc_startsession();

BEGIN;

INSERT INTO contrans
SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
       2017,
       115,
       1;

INSERT INTO contrans
SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
       2017,
       116,
       1;

INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
           (SELECT c45_seqtrans
            FROM contrans
            WHERE c45_coddoc = 115
                AND c45_anousu = 2017
            LIMIT 1), 100,
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
            WHERE c45_coddoc = 115
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
            WHERE c45_coddoc = 116
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
            WHERE c45_coddoc = 116
                AND c45_anousu = 2017
            LIMIT 1), 101,
                      'SEGUNDO LANCAMENTO',
                      0,
                      FALSE,
                      0,
                      'SEGUNDO LANCAMENTO',
                      2);

INSERT INTO contranslr
SELECT nextval('contranslr_c47_seqtranslr_seq'),
    (SELECT min(c46_seqtranslan) FROM contranslan
     JOIN contrans ON c46_seqtrans = c45_seqtrans
     WHERE c45_coddoc = 115
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
     WHERE c45_coddoc = 115
         AND c45_anousu = 2017
         AND c46_ordem = 2
         LIMIT 1) AS c47_seqtranslan,
       (SELECT c61_reduz FROM conplanoreduz
        JOIN conplano ON c60_codcon = c61_codcon AND c60_anousu = 2017
        WHERE c60_estrut = '621310100000000'
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
    (SELECT min(c46_seqtranslan) FROM contranslan
     JOIN contrans ON c46_seqtrans = c45_seqtrans
     WHERE c45_coddoc = 116
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
     WHERE c45_coddoc = 116
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
        WHERE c60_estrut = '621310100000000'
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

INSERT INTO contranslan
VALUES(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
       (SELECT c45_seqtrans
        FROM contrans
        WHERE c45_coddoc = 115
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
        WHERE c45_coddoc = 116
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
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 115
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
    (SELECT max(c46_seqtranslan) FROM contranslan
      JOIN contrans ON c46_seqtrans = c45_seqtrans
    WHERE c45_coddoc = 116
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

UPDATE conplanoorcamentogrupo
SET c21_congrupo = 6
WHERE c21_codcon IN
        (SELECT c60_codcon
         FROM conplanoorcamento
         WHERE substr(c60_estrut,1,5) = '49517'
             AND c60_anousu >= 2017)
AND c21_anousu >= 2017;

COMMIT;