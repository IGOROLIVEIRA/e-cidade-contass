begin;
select fc_startsession();

INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S050', 'DESC ADIANTAMENTOS', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S054', 'DESC PREVIDENCIA', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S055', 'DESC IRRF', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S059', 'DESC ADIANT 1º PARC 13º', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S063', 'DESC PLANO MEDICO ODONTOLOGICO', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S064', 'DESC FERIAS', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S065', 'OUTROS IMPOSTOS/CONTRIBUICOES', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S066', 'DESC PREV/COMPLEMENTAR', false, false, false, 1);
INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'S076', 'DESC PAGAMENTO INDEVIDO', false, false, false, 1);

INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2016, 5, 'SD99', 'OUTROS DESCONTOS', false, false, false, 1);
update bases set r08_codigo = 'SP99', r08_descr = 'OUTROS PROVENTOS' where r08_anousu <= 2016 and r08_mesusu <= 5 and r08_codigo = 'S099';
commit;