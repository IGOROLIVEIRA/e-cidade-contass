-- [OC22018] Migra historico de calculo de iptu e pagamentos de IPTU de uma matricula para outra
SELECT fc_putsession('DB_instit', '1');

BEGIN;

-- From 4420 to 51056

-- Migra históricos
update iptucalc set j23_matric = 51056 where j23_matric = 4420 and j23_anousu <> 2023;
update iptucale set j22_matric = 51056 where j22_matric = 4420 and j22_anousu <> 2023;
update iptucalv set j21_matric = 51056 where j21_matric = 4420 and j21_anousu <> 2023;

-- Migra pagamentos efetuados
update arrematric set k00_matric = 51056 where k00_numpre in (select j20_numpre from iptunump where j20_matric = 4420 and j20_anousu <> 2023);
update iptunump set j20_matric = 51056 where j20_matric = 4420 and j20_anousu <> 2023;

-- From 4420 to 51056

-- Migra históricos
update iptucalc set j23_matric = 51029 where j23_matric = 17400 and j23_anousu <> 2023;
update iptucale set j22_matric = 51029 where j22_matric = 17400 and j22_anousu <> 2023;
update iptucalv set j21_matric = 51029 where j21_matric = 17400 and j21_anousu <> 2023;

-- Migra pagamentos efetuados
update arrematric set k00_matric = 51029 where k00_numpre in (select j20_numpre from iptunump where j20_matric = 17400 and j20_anousu <> 2023);
update iptunump set j20_matric = 51029 where j20_matric = 17400 and j20_anousu <> 2023;
