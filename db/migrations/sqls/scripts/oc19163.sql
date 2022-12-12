BEGIN;

CREATE TEMP TABLE tmp_tipcalc_desc (
	codigo int,
	desconto float
) ON COMMIT DROP;

INSERT INTO tmp_tipcalc_desc values (77,40),
                                    (147,5),
                                    (53,40),
                                    (57,30),
                                    (33,40),
                                    (35,40),
                                    (36,40),
                                    (40,45),
                                    (41,45),
                                    (32,40),
                                    (79,40),
                                    (149,5),
                                    (127,5),
                                    (81,40),
                                    (59,30),
                                    (54,40),
                                    (123,5),
                                    (31,40),
                                    (34,40),
                                    (55,40),
                                    (90,20),
                                    (119,40),
                                    (37,45),
                                    (39,45),
                                    (121,30),
                                    (151,5),
                                    (71,40),
                                    (83,40),
                                    (75,40),
                                    (38,45),
                                    (125,5),
                                    (129,5),
                                    (52,30),
                                    (131,5),
                                    (64,40),
                                    (133,5),
                                    (135,5),
                                    (145,40);


INSERT INTO recibounicageracao
VALUES (
           (select nextval('recibounicageracao_ar40_sequencial_seq')),
           1,
           '2022-12-09'::date,
           '2022-12-29'::date,
           5,
           'G',
           true,
           'DECRETO 127/2022');

INSERT INTO recibounica
SELECT distinct y69_numpre,
                '2022-12-29'::date,
    '2022-12-09'::date,
    desconto,
                'G',
                (select max(ar40_sequencial) from recibounicageracao),
                (nextval('recibounica_k00_sequencial_seq')),
                k00_receit
FROM vistorias
         inner join vistinscr on y71_codvist = y70_codvist
         inner join tabativ on q07_inscr = y71_inscr
         inner join vistorianumpre on y69_codvist = y70_codvist
         inner join arrecad on k00_numpre = y69_numpre
         inner join ativprinc on q88_inscr = q07_inscr and q88_seq = q07_seq
         inner join ativtipo on q80_ativ = q07_ativ
         inner join tmp_tipcalc_desc on codigo = q80_tipcal
where desconto = 5;

INSERT INTO recibounicageracao
VALUES (
           (select nextval('recibounicageracao_ar40_sequencial_seq')),
           1,
           '2022-12-09'::date,
           '2022-12-29'::date,
           20,
           'G',
           true,
           'DECRETO 127/2022');

INSERT INTO recibounica
SELECT distinct y69_numpre,
                '2022-12-29'::date,
    '2022-12-09'::date,
    desconto,
                'G',
                (select max(ar40_sequencial) from recibounicageracao),
                (nextval('recibounica_k00_sequencial_seq')),
                k00_receit
FROM vistorias
         inner join vistinscr on y71_codvist = y70_codvist
         inner join tabativ on q07_inscr = y71_inscr
         inner join vistorianumpre on y69_codvist = y70_codvist
         inner join arrecad on k00_numpre = y69_numpre
         inner join ativprinc on q88_inscr = q07_inscr and q88_seq = q07_seq
         inner join ativtipo on q80_ativ = q07_ativ
         inner join tmp_tipcalc_desc on codigo = q80_tipcal
where desconto = 20;

INSERT INTO recibounicageracao
VALUES (
           (select nextval('recibounicageracao_ar40_sequencial_seq')),
           1,
           '2022-12-09'::date,
           '2022-12-29'::date,
           30,
           'G',
           true,
           'DECRETO 127/2022');

INSERT INTO recibounica
SELECT distinct y69_numpre,
                '2022-12-29'::date,
    '2022-12-09'::date,
    desconto,
                'G',
                (select max(ar40_sequencial) from recibounicageracao),
                (nextval('recibounica_k00_sequencial_seq')),
                k00_receit
FROM vistorias
         inner join vistinscr on y71_codvist = y70_codvist
         inner join tabativ on q07_inscr = y71_inscr
         inner join vistorianumpre on y69_codvist = y70_codvist
         inner join arrecad on k00_numpre = y69_numpre
         inner join ativprinc on q88_inscr = q07_inscr and q88_seq = q07_seq
         inner join ativtipo on q80_ativ = q07_ativ
         inner join tmp_tipcalc_desc on codigo = q80_tipcal
where desconto = 30;

INSERT INTO recibounicageracao
VALUES (
           (select nextval('recibounicageracao_ar40_sequencial_seq')),
           1,
           '2022-12-09'::date,
           '2022-12-29'::date,
           40,
           'G',
           true,
           'DECRETO 127/2022');

INSERT INTO recibounica
SELECT distinct y69_numpre,
                '2022-12-29'::date,
    '2022-12-09'::date,
    desconto,
                'G',
                (select max(ar40_sequencial) from recibounicageracao),
                (nextval('recibounica_k00_sequencial_seq')),
                k00_receit
FROM vistorias
         inner join vistinscr on y71_codvist = y70_codvist
         inner join tabativ on q07_inscr = y71_inscr
         inner join vistorianumpre on y69_codvist = y70_codvist
         inner join arrecad on k00_numpre = y69_numpre
         inner join ativprinc on q88_inscr = q07_inscr and q88_seq = q07_seq
         inner join ativtipo on q80_ativ = q07_ativ
         inner join tmp_tipcalc_desc on codigo = q80_tipcal
where desconto = 40;

INSERT INTO recibounicageracao
VALUES (
           (select nextval('recibounicageracao_ar40_sequencial_seq')),
           1,
           '2022-12-09'::date,
           '2022-12-29'::date,
           45,
           'G',
           true,
           'DECRETO 127/2022');

INSERT INTO recibounica
SELECT distinct y69_numpre,
                '2022-12-29'::date,
    '2022-12-09'::date,
    desconto,
                'G',
                (select max(ar40_sequencial) from recibounicageracao),
                (nextval('recibounica_k00_sequencial_seq')),
                k00_receit
FROM vistorias
         inner join vistinscr on y71_codvist = y70_codvist
         inner join tabativ on q07_inscr = y71_inscr
         inner join vistorianumpre on y69_codvist = y70_codvist
         inner join arrecad on k00_numpre = y69_numpre
         inner join ativprinc on q88_inscr = q07_inscr and q88_seq = q07_seq
         inner join ativtipo on q80_ativ = q07_ativ
         inner join tmp_tipcalc_desc on codigo = q80_tipcal
where desconto = 45;
