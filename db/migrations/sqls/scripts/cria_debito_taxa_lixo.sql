BEGIN;


SELECT fc_putsession('DB_instit', '1');


INSERT INTO iptucalc
SELECT DISTINCT 2022 j23_anousu,
                j01_matric AS j23_matric,
                0 j23_testad,
                j34_area j23_arealo,
                0 j23_areafr,
                j39_area j23_areaed,
                0 j23_m2terr,
                0 j23_vlrter,
                0 j23_aliq,
                0 j23_vlrisen,
                CASE
                    WHEN j39_area > 0 THEN 'P'
                    ELSE 'T'
                    END AS j23_tipoim,
                TRUE j23_manual,
                0 j23_tipocalculo,
                0 j23_pontosterr
FROM iptubase
         INNER JOIN lote ON j01_idbql = j34_idbql
         LEFT JOIN iptuconstr ON j01_matric = j39_matric
    AND j39_idprinc IS TRUE
    AND j39_dtdemo IS NULL
WHERE j01_matric <> 8 ;


INSERT INTO iptucalv
SELECT DISTINCT 2022,
                j01_matric,
                223,
                60,
                1,
                2
FROM iptubase
         INNER JOIN lote ON j01_idbql = j34_idbql
         LEFT JOIN iptuconstr ON j01_matric = j39_matric
    AND j39_idprinc IS TRUE
    AND j39_dtdemo IS NULL
WHERE j01_matric <> 8 ;


CREATE TEMP TABLE w_arrecad ON
COMMIT
DROP AS
SELECT nextval('numpref_k03_numpre_seq') AS k00_numpre,
       x.*
FROM
    (SELECT DISTINCT 1 k00_numpar,
                     j01_numcgm k00_numcgm,
                     '2022-11-07'::date k00_dtoper,
         223 k00_receit,
                     11 k00_hist,
                     60 k00_valor,
                     '2022-12-31'::date k00_dtvenc,
         1 k00_numtot,
                     1 k00_numdig,
                     62 k00_tipo,
                     1 k00_tipojm,
                     j01_matric AS k00_matric
     FROM iptubase
              INNER JOIN lote ON j01_idbql = j34_idbql
              LEFT JOIN iptuconstr ON j01_matric = j39_matric
         AND j39_idprinc IS TRUE
         AND j39_dtdemo IS NULL
     WHERE j01_matric <> 8 ) AS x;


INSERT INTO arrecad
SELECT k00_numpre,
       k00_numpar,
       k00_numcgm,
       k00_dtoper,
       k00_receit,
       k00_hist ,
       k00_valor,
       k00_dtvenc,
       k00_numtot,
       k00_numdig,
       k00_tipo ,
       k00_tipojm
FROM w_arrecad;


INSERT INTO arrematric
SELECT k00_numpre,
       k00_matric,
       100
FROM w_arrecad;

commit;
