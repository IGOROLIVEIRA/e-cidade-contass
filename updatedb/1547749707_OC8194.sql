BEGIN;

SELECT fc_startsession();

ALTER TABLE infocomplementaresinstit ADD si09_nroleicute int8 DEFAULT NULL,
                  ADD si09_dataleicute date DEFAULT NULL,
                  ADD si09_contaunicatesoumunicipal int8 DEFAULT 2;
COMMIT;
