BEGIN;
select fc_startsession();

SELECT fc_startsession();

alter table liccomissaocgm add column l31_licitacao int4;

alter table liccomissaocgm add constraint liccomissaocgm_l31_licitacao_fk foreign key (l31_licitacao) references liclicita (l20_codigo);

COMMIT;
