begin;

select fc_startsession();

ALTER TABLE consvalorestransf ADD COLUMN c201_codfontrecursos int8 NOT NULL default 0;
ALTER TABLE consexecucaoorc ADD COLUMN c202_codfontrecursos int8 NOT NULL default 0;
ALTER TABLE consdispcaixaano ADD COLUMN c203_codfontrecursos int8 NOT NULL default 0;

commit;