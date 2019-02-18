
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

UPDATE orctiporec
SET o15_codstn = (CASE
                      WHEN o15_codtri = '100' THEN 10010000
                      WHEN o15_codtri = '101' THEN 11110000
                      WHEN o15_codtri = '102' THEN 12110000
                      WHEN o15_codtri = '103' THEN 14100131
                      WHEN o15_codtri = '112' THEN 12900000
                      WHEN o15_codtri = '113' THEN 11900000
                      WHEN o15_codtri = '116' THEN 16100000
                      WHEN o15_codtri = '117' THEN 16200000
                      WHEN o15_codtri = '118' THEN 11120000
                      WHEN o15_codtri = '119' THEN 11130000
                      WHEN o15_codtri = '122' THEN 11250000
                      WHEN o15_codtri = '123' THEN 12200000
                      WHEN o15_codtri = '124' THEN 15100000
                      WHEN o15_codtri = '129' THEN 13110000
                      WHEN o15_codtri = '142' THEN 13120000
                      WHEN o15_codtri = '143' THEN 11210000
                      WHEN o15_codtri = '144' THEN 11220000
                      WHEN o15_codtri = '145' THEN 11230000
                      WHEN o15_codtri = '146' THEN 11240000
                      WHEN o15_codtri = '147' THEN 11200000
                      WHEN o15_codtri = '148' THEN 12140000
                      WHEN o15_codtri = '149' THEN 12140000
                      WHEN o15_codtri = '150' THEN 12140000
                      WHEN o15_codtri = '151' THEN 12140000
                      WHEN o15_codtri = '152' THEN 12140000
                      WHEN o15_codtri = '153' THEN 12150000
                      WHEN o15_codtri = '154' THEN 12140000
                      WHEN o15_codtri = '155' THEN 12130000
                      WHEN o15_codtri = '156' THEN 13900000
                      WHEN o15_codtri = '157' THEN 16300000
                      WHEN o15_codtri = '190' THEN 19200000
                      WHEN o15_codtri = '192' THEN 19300000
                  END);

UPDATE orctiporec
SET o15_codstn = (CASE
                      WHEN o15_codtri = '200' THEN 20010000
                      WHEN o15_codtri = '201' THEN 21110000
                      WHEN o15_codtri = '202' THEN 22110000
                      WHEN o15_codtri = '203' THEN 24100131
                      WHEN o15_codtri = '212' THEN 22900000
                      WHEN o15_codtri = '213' THEN 21900000
                      WHEN o15_codtri = '216' THEN 26100000
                      WHEN o15_codtri = '217' THEN 26200000
                      WHEN o15_codtri = '218' THEN 21120000
                      WHEN o15_codtri = '219' THEN 21130000
                      WHEN o15_codtri = '222' THEN 21250000
                      WHEN o15_codtri = '223' THEN 22200000
                      WHEN o15_codtri = '224' THEN 25100000
                      WHEN o15_codtri = '229' THEN 23110000
                      WHEN o15_codtri = '242' THEN 23120000
                      WHEN o15_codtri = '243' THEN 21210000
                      WHEN o15_codtri = '244' THEN 21220000
                      WHEN o15_codtri = '245' THEN 21230000
                      WHEN o15_codtri = '246' THEN 21240000
                      WHEN o15_codtri = '247' THEN 21200000
                      WHEN o15_codtri = '248' THEN 22140000
                      WHEN o15_codtri = '249' THEN 22140000
                      WHEN o15_codtri = '250' THEN 22140000
                      WHEN o15_codtri = '251' THEN 22140000
                      WHEN o15_codtri = '252' THEN 22140000
                      WHEN o15_codtri = '253' THEN 22150000
                      WHEN o15_codtri = '254' THEN 22140000
                      WHEN o15_codtri = '255' THEN 22130000
                      WHEN o15_codtri = '256' THEN 23900000
                      WHEN o15_codtri = '257' THEN 26300000
                      WHEN o15_codtri = '290' THEN 29200000
                      WHEN o15_codtri = '292' THEN 29300000
                  END);

-- Fim do script

COMMIT;

