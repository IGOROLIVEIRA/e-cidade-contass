BEGIN;

SELECT fc_startsession();

INSERT INTO acordogarantia
VALUES (5,
        'SEM GARANTIA',
        'SEM GARANTIA',
        'SEM GARANTIA',
        '2017-12-31');

INSERT INTO acordogarantiaacordotipo
VALUES(nextval('acordogarantiaacordotipo_ac05_sequencial_seq'),
       3,
       5);

COMMIT;