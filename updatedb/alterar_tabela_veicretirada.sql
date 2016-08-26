select fc_startsession();
begin;
ALTER TABLE veicretirada ADD COLUMN ve60_destinonovo INT;
ALTER TABLE veicretirada ADD CONSTRAINT veicretirada_ve60_destinonovo_fk FOREIGN KEY (ve60_destinonovo) REFERENCES veiccaddestino (ve75_sequencial);
commit;