## OC 22134
## Altera receita e historico de calculo de dividas ativas
-- tx coleta
BEGIN;


CREATE TEMP TABLE w_nao_apagar_oc22134_rec9 ON
COMMIT
DROP AS
SELECT DISTINCT k00_numpre,
                k00_numpar,
                v01_coddiv,
                k00_receit,
                v01_proced
FROM divimportareg
INNER JOIN divida ON v01_coddiv = v04_coddiv
INNER JOIN arrecad ON v01_numpre = k00_numpre
AND v01_numpar = k00_numpar
AND k00_receit = 9
WHERE v04_divimporta = 11;


UPDATE arrecad
SET k00_receit = 134,
    k00_hist = 6
WHERE EXISTS
    (SELECT 1
     FROM w_nao_apagar_oc22134_rec9 x
     WHERE x.k00_numpre = arrecad.k00_numpre
       AND x.k00_numpar = arrecad.k00_numpar)
  AND k00_receit = 9
  AND k00_hist = 502;

-- iptu

CREATE TEMP TABLE w_nao_apagar_oc22134_rec1 ON
COMMIT
DROP AS
SELECT DISTINCT k00_numpre,
                k00_numpar,
                v01_coddiv,
                k00_receit,
                v01_proced
FROM divimportareg
INNER JOIN divida ON v01_coddiv = v04_coddiv
INNER JOIN arrecad ON v01_numpre = k00_numpre
AND v01_numpar = k00_numpar
AND k00_receit = 1
WHERE v04_divimporta = 11;


UPDATE arrecad
SET k00_receit = 573,
    k00_hist = 1
WHERE EXISTS
    (SELECT 1
     FROM w_nao_apagar_oc22134_rec1 x
     WHERE x.k00_numpre = arrecad.k00_numpre
       AND x.k00_numpar = arrecad.k00_numpar)
  AND k00_receit = 1
  AND k00_hist = 400;
