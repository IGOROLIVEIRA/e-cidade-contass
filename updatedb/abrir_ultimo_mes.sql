BEGIN;
update rhfolhapagamento set rh141_aberto = true where rh141_sequencial = (select  max(rh141_sequencial) from rhfolhapagamento);
COMMIT;