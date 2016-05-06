begin;
select fc_startsession();

update bases set r08_codigo = 'S099' where r08_anousu <= 2016 and r08_mesusu <= 7 and r08_codigo = 'S014';
update bases set r08_codigo = 'S100' where r08_anousu <= 2016 and r08_mesusu <= 7 and r08_codigo = 'S015';
update bases set r08_descr = 'AUXILIOS' where r08_anousu <= 2016 and r08_mesusu <= 7 and r08_codigo = 'S013';
update bases set r08_descr = 'PENSAO POR MORTE' where r08_anousu <= 2016 and r08_mesusu <= 7 and r08_codigo = 'S002';

INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 4, 'S014', 'INDENIZACOES                  ', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 4, 'S015', 'ADICIONAL DE DESEMPENHO       ', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 4, 'S016', 'ABONO DE PERMANÊNCIA          ', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 4, 'S017', '13º SALÁRIO                   ', false, false, false, 1);

commit;

begin;

INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 4, 'S100', 'DESC OBRIG IRRF/PREV         ', false, false, false, 1);

commit;