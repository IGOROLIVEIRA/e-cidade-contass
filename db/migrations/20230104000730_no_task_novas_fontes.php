<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class NoTaskNovasFontes extends PostgresMigration
{
    public function up()
    {
        $sqlFontes = " CREATE TABLE public.mytable1(
                            FONTE2022   INTEGER,
                            FONTE2023   INTEGER,
                            COD_TCE     INTEGER,
                            COD_STN     INTEGER,
                            DESCRICAO   VARCHAR(81) NOT NULL,
                            FINALIDADE  VARCHAR(214) NOT NULL
                       );
          
          INSERT INTO mytable1(FONTE2022,FONTE2023,COD_TCE,COD_STN,DESCRICAO,FINALIDADE) VALUES
          (1,15000000,1500000,1500,'RECURSOS NAO VINCULADOS DE IMPOSTOS','Recursos nao vinculados de Impostos'),
          (100,15000000,1500000,1500,'RECURSOS NAO VINCULADOS DE IMPOSTOS','Recursos nao vinculados de Impostos'),
          (101,15000001,1500000,1500,'RECURSOS DE IMPOSTOS - MDE','Recursos de Impostos - MDE'),
          (102,15000002,1500000,1500,'RECURSOS DE IMPOSTOS - ASPS','Recursos de Impostos - ASPS'),
          (103,18000000,1800000,1800,'RECURSOS VINCULADOS AO RPPS - FUNDO EM CAPITALIZACAO','Recursos vinculados ao RPPS - Fundo em Capitalizacao (Plano Previdenciario)'),
          (104,18010000,1801000,1801,'RECURSOS VINCULADOS AO RPPS - FUNDO EM REPARTICAO','Recursos vinculados ao RPPS - Fundo em Reparticao (Plano Financeiro)'),
          (105,18020000,1802000,1802,'RECURSOS VINCULADOS AO RPPS - TAXA DE ADMINISTRACAO','Recursos vinculados ao RPPS - Taxa de Administracao'),
          (106,15760010,1576001,1576,'TRANSFERENCIAS DE RECURSOS PARA O PTE','Transferencias de Recursos para o Programa Estadual de Transporte Escolar (PTE)'),
          (107,15440000,1544000,1544,'RECURSOS DE PRECATORIOS DO FUNDEF','Recursos de Precatorios do FUNDEF'),
          (108,17080000,1708000,1708,'TRANSFERENCIA DA UNIAO REFERENTE A CFEM','Transferencia da Uniao Referente a Compensacao Financeira de Recursos Minerais'),
          (112,16590020,1659002,1659,'SERVICOS DE SAUDE','Servicos de Saude'),
          (113,15990030,1599003,1599,'SERVICOS EDUCACIONAIS','Servicos Educacionais'),
          (116,17500000,1750000,1750,'RECURSOS DA CONTRIBUICAO DE INTERVENCAO NO DOMINIO ECONOMICO','Recursos da Contribuicao de Intervencao no DomInio Economico - CIDE'),
          (117,17510000,1751000,1751,'RECURSOS DA CONTRIBUICAO PARA CUST. SER. ILUM. PUB. - COSIP','Recursos da Contribuicao para o Custeio do Servico de Iluminacao Publica - COSIP'),
          (118,15400007,1540000,1540,'TRANSFERENCIAS DO FUNDEB - IMPOS. E TRANSF. DE IMPOSTOS - 70','Transferencias do FUNDEB - Impostos e Transferencias de Impostos - 70'),
          (119,15400000,1540000,1540,'TRANSFERENCIAS DO FUNDEB - IMPOS. E TRANSF. DE IMPOSTOS - 30','Transferencias do FUNDEB - Impostos e Transferencias de Impostos - 30'),
          (120,15760000,1576000,1576,'TRANSF. DE RECURSOS DOS ESTADOS PARA PROGRAMAS DE EDUCACAO','Transferencias de Recursos dos Estados para programas de Educacao'),
          (121,16220000,1622000,1622,'TRANSF. FUNDO A FUNDO DE REC. DO SUS PROV. GOVER. MUNICIPAIS','Transferencias Fundo a Fundo de Recursos do SUS provenientes dos Governos Municipais'),
          (122,15700000,1570000,1570,'TRANSF. GOV. FEDERAL REF. CONVENIOS E CONGE VINC. EDUCACAO','Transferencias do Governo Federal referentes a Convenios e Instrumentos Congeneres vinculados a Educacao'),
          (123,16310000,1631000,1631,'TRANSF. GOV. FEDERAL REF. CONVENIOS E INST CONGE VINC. SAUDE','Transferencias do Governo Federal referentes a Convenios e Instrumentos Congeneres vinculados a Saude'),
          (124,17000000,1700000,1700,'OUTRAS TRANSF. DE CONVENIOS OU INST. CONGENERES DA UNIAO','Outras Transferencias de Convenios ou Instrumentos Congeneres da Uniao'),
          (129,16600000,1660000,1660,'TRANSF. DE REC. DO FUNDO NACIONAL DE ASSISTENCIA SOCIAL FNAS','Transferencia de Recursos do Fundo Nacional de Assistencia Social - FNAS'),
          (130,18990040,1899004,1899,'TRANSF. ACORDO JUDICIAL BARRAGEM FUNDAO','Transferencia referente ao Acordo Judicial de Reparacao dos Impactos Socioeconomicos e Ambientais do Rompimento da Barragem de Fundao'),
          (131,17590050,1759005,1759,'REPASSE TARIFARIO PARA OS FUNDOS MUNICIPAIS DE SANEAMENTO','Repasse tarifario para os Fundos Municipais de Saneamento'),
          (142,16650000,1665000,1665,'TRANSF. DE CONVENIOS E INST CONGE VINC. A ASSISTENCIA SOCIAL','Transferencias de Convenios e Instrumentos Congeneres Vinculados a Assistencia Social'),
          (143,15510000,1551000,1551,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PDDE','Transferencias de Recursos do FNDE Referentes ao Programa Dinheiro Direto na Escola (PDDE)'),
          (144,15520000,1552000,1552,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PNAE','Transferencias de Recursos do FNDE Referentes ao Programa Nacional de Alimentacao Escolar (PNAE)'),
          (145,15530000,1553000,1553,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PNATE','Transferencias de Recursos do FNDE Referentes ao Programa Nacional de Apoio ao Transporte Escolar (PNATE)'),
          (146,15690000,1569000,1569,'OUTRAS TRANSFERENCIAS DE RECURSOS DO FNDE','Outras Transferencias de Recursos do FNDE'),
          (147,15500000,1550000,1550,'TRANSFERENCIA DO SALARIO-EDUCACAO','Transferencia do Salario-Educacao'),
          (153,16010000,1601000,1601,'TRANSF. DE REC. DO SUS PROV. GOV. FEDERAL - BLOCO ESTR. ASPS','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Federal - Bloco de Estruturacao da Rede de Servicos Publicos de Saude'),
          (154,16590000,1659000,1659,'OUTROS RECURSOS VINCULADOS A SAUDE','Outros Recursos Vinculados a Saude'),
          (155,16210000,1621000,1621,'TRANSFERENCIAS FUNDO A FUNDO DE RECURSOS DO SUS PROVENIENTES DO GOVERNO ESTADUAL','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Estadual'),
          (156,16610000,1661000,1661,'TRANSFERENCIA DE RECURSOS DOS FUNDOS ESTADUAIS DE ASSISTENCIA SOCIAL','Transferencia de Recursos dos Fundos Estaduais de Assistencia Social'),
          (157,17520000,1752000,1752,'RECURSOS VINCULADOS AO TRÂNSITO','Recursos Vinculados ao Trânsito'),
          (158,18990060,1899006,1899,'CONTRIB. ASSIST. A SAUDE DOS SERVIDORES','Contribuicao para a Assistencia a Saude dos Servidores: Patronal, dos Servidores, dos Prestadores de Servicos Contratados'),
          (159,16000000,1600000,1600,'TRANSF. DE REC. DO SUS - GOVERNO FEDERAL - BLOCO MANUT. ASPS','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Federal - Bloco de Manutencao das Acoes e Servicos Publicos de Saude'),
          (160,17040000,1704000,1704,'TRANSF. DA UNIAO REF. A COMP. FINAN. EXPLO. DE REC. NATURAIS','Transferencias da Uniao Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (161,17070000,1707000,1707,'TRANSFERENCIAS DA UNIAO - INCISO I DO ART. 5º DA LEI COMPLEMENTAR 173/2020','Transferencias da Uniao - inciso I do art. 5º da Lei Complementar 173/2020'),
          (162,17490120,1749012,1749,'TRANSF. DE REC. LEI ALDIR BLANC','Transferencia de Recursos para aplicacao em Acoes Emergenciais de Apoio ao Setor Cultural (Lei Aldir Blanc)'),
          (163,17130070,1713007,1713,'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANCA PUBLICA','Transferencias de Convenios Vinculados a Seguranca Publica'),
          (164,17060000,1706000,1706,'TRANSFERENCIA ESPECIAL DA UNIAO','Transferencia Especial da Uniao'),
          (132, 16040000, 1604000, 1604, 'TRANSF. DO GOVERNO FEDERAL DEST. AO VENCIMENTO DOS AGENTES', 'Transferencias provenientes do Governo Federal destinadas ao vencimento dos agentes comunitarios de saude e dos agentes de combate as endemias.');
          
          INSERT INTO mytable1(FONTE2022,FONTE2023,COD_TCE,COD_STN,DESCRICAO,FINALIDADE) VALUES
          (165,18990000,1899000,1899,'OUTROS RECURSOS VINCULADOS','Outros Recursos Vinculados'),
          (166,15420007,1542000,1542,'TRANSFERENCIAS DO FUNDEB - COMPLEMENTACAO DA UNIAO - VAAT - 70','Transferencias do FUNDEB - Complementacao da Uniao - VAAT - 70'),
          (167,15420000,1542000,1542,'TRANSFERENCIAS DO FUNDEB - COMPLEMENTACAO DA UNIAO - VAAT - 30','Transferencias do FUNDEB - Complementacao da Uniao - VAAT - 30'),
          (168,17100100,1710010,1710,'TRANSF. ESP. ESTADO - BARRAGEM BRUMADINHO','Transferencia Especial do Estado - Acordo Judicial de Reparacao dos Impactos Socioeconomicos e Ambientais do Rompimento de Barragem em Brumadinho'),
          (169,17100000,1710000,1710,'TRANSFERENCIA ESPECIAL DOS ESTADOS','Transferencia Especial dos Estados'),
          (170,15010000,1501000,1501,'OUTROS RECURSOS NAO VINCULADOS','Outros Recursos nao Vinculados'),
          (171,15710000,1571000,1571,'TRANSF. DO ESTADO REF. A CONV. E INST. CONG. VINC. EDUCACAO','Transferencias do Estado referentes a Convenios e Instrumentos Congeneres vinculados a Educacao'),
          (172,15720000,1572000,1572,'TRANSF. MUNICPIOS  REF. A CONV. E INST. CONG. VINC. EDUCACAO','Transferencias de MunicIpios referentes a Convenios e Instrumentos Congeneres Vinculados a Educacao'),
          (173,15750000,1575000,1575,'OUTRAS TRANSF. DE CONVENIOS E INST. CONGE VINC. EDUCACAO','Outras Transferencias de Convenios e Instrumentos Congeneres Vinculados a Educacao'),
          (174,15740000,1574000,1574,'OPERACOES DE CREDITO VINCULADAS A EDUCACAO','Operacoes de Credito Vinculadas a Educacao'),
          (175,15730000,1573000,1573,'ROYALTIES DO PETROLEO E GAS NATURAL VINCULADOS A EDUCACAO','Royalties do Petroleo e Gas Natural Vinculados a Educacao'),
          (176,16320000,1632000,1632,'TRANSF. DO ESTADO REF. CONVENIOS E INST. CONGE VINC. SAUDE','Transferencias do Estado referentes a Convenios e Instrumentos Congeneres Vinculados a Saude'),
          (177,16330000,1633000,1633,'TRANSF. DE MUNICÍPIOS REF. CONVENIOS E INST CONGE VINC SAUDE','Transferencias de MunicIpios referentes a Convenios e Instumentos Congeneres Vinculados a Saude'),
          (178,16360000,1636000,1636,'OUTRAS TRANSF CONVENIOS E INST CONGENERES VINCULADOS A SAUDE','Outras Transferencias de Convenios e Instrumentos Congeneres Vinculados a Saude'),
          (179,16340000,1634000,1634,'OPERACOES DE CREDITO VINCULADAS A SAUDE','Operacoes de Credito Vinculadas a Saude'),
          (180,16350000,1635000,1635,'ROYALTIES DO PETROLEO E GAS NATURAL VINCULADOS A SAUDE','Royalties do Petroleo e Gas Natural Vinculados a Saude'),
          (181,17010000,1701000,1701,'OUTRAS TRANSF. DE CONVENIOS OU INST. CONGENERES DOS ESTADOS','Outras Transferencias de Convenios ou Instrumentos Congeneres dos Estados'),
          (182,17020000,1702000,1702,'OUTRAS TRANSF DE CONVENIOS OU INST CONGENERES DOS MUNICIPIOS','Outras Transferencias de Convenios ou Instrumentos Congeneres dos MunicIpios'),
          (183,17030000,1703000,1703,'OUTRAS TRANSF DE CONVENIOS OU INST CONGE DE OUTRAS ENTIDADES','Outras Transferencias de Convenios ou Instrumentos Congeneres de outras Entidades'),
          (184,17090000,1709000,1709,'TRANSF. DA UNIAO REF. A COMPENSACAO FINAN. DE REC. HIDRICOS','Transferencia da Uniao referente a Compensacao Financeira de Recursos HIdricos'),
          (185,17530000,1753000,1753,'REC. PROVENIENTES DE TAXAS, CONTRIBUICOES E PRECOS PUBLICOS','Recursos Provenientes de Taxas, Contribuicoes e Precos Publicos'),
          (186,17040000,1704000,1704,'TRANSF. DA UNIAO REF. COMP. FINAN EXPLORACAO DE REC NATURAIS','Transferencias da Uniao Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (187,17050000,1705000,1705,'TRANSF. DOS ESTADOS REF. COMP. FINAN EXPLORACAO REC NATURAIS','Transferencias dos Estados Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (188,15000080,1500008,1500,'DIS. CAIXA. VINCULADA A RESTOS A PAGAR - SAUDE','Disponibilidade de Caixa vinculada a Restos a Pagar considerados na Aplicacao MInima da Saude e posteriormente Cancelados ou Prescritos'),
          (189,15000090,1500009,1500,'DIS. CAIXA. VINCULADA A RESTOS A PAGAR - EDUCACAO','Disponibilidade de Caixa vinculada a Restos a Pagar considerados na Aplicacao MInima da Educacao e posteriormente Cancelados ou Prescritos'),
          (190,17540000,1754000,1754,'RECURSOS DE OPERACOES DE CREDITO','Recursos de Operacoes de Credito'),
          (191,17540000,1754000,1754,'RECURSOS DE OPERACOES DE CREDITO','Recursos de Operacoes de Credito'),
          (192,17550000,1755000,1755,'RECURSOS DE ALIENACAO DE BENS-ATIVOS - ADMINISTRACAO DIRETA','Recursos de Alienacao de Bens/Ativos - Administracao Direta'),
          (193,18990130,1899013,1899,'OUTRAS RECEITAS NAO PRIMARIAS','Outras Receitas Nao Primarias');
          
          INSERT INTO mytable1(FONTE2022,FONTE2023,COD_TCE,COD_STN,DESCRICAO,FINALIDADE) VALUES 
          (200,25000000,2500000,2500,'RECURSOS NAO VINCULADOS DE IMPOSTOS','Recursos nao vinculados de Impostos'),
          (201,25000001,2500000,2500,'RECURSOS DE IMPOSTOS - MDE','Recursos de Impostos - MDE'),
          (202,25000002,2500000,2500,'RECURSOS DE IMPOSTOS - ASPS','Recursos de Impostos - ASPS'),
          (203,28000000,2800000,2800,'RECURSOS VINCULADOS AO RPPS - FUNDO EM CAPITALIZACAO','Recursos vinculados ao RPPS - Fundo em Capitalizacao (Plano Previdenciario)'),
          (204,28010000,2801000,2801,'RECURSOS VINCULADOS AO RPPS - FUNDO EM REPARTICAO','Recursos vinculados ao RPPS - Fundo em Reparticao (Plano Financeiro)'),
          (205,28020000,2802000,2802,'RECURSOS VINCULADOS AO RPPS - TAXA DE ADMINISTRACAO','Recursos vinculados ao RPPS - Taxa de Administracao'),
          (206,25760010,2576001,2576,'TRANSFERENCIAS DE RECURSOS PARA O PTE','Transferencias de Recursos para o Programa Estadual de Transporte Escolar (PTE)'),
          (207,25440000,2544000,2544,'RECURSOS DE PRECATORIOS DO FUNDEF','Recursos de Precatorios do FUNDEF'),
          (208,27080000,2708000,2708,'TRANSFERENCIA DA UNIAO REFERENTE A CFEM','Transferencia da Uniao Referente a Compensacao Financeira de Recursos Minerais'),
          (212,26590020,2659002,2659,'SERVICOS DE SAUDE','Servicos de Saude'),
          (213,25990030,2599003,2599,'SERVICOS EDUCACIONAIS','Servicos Educacionais'),
          (216,27500000,2750000,2750,'RECURSOS DA CONTRIBUICAO DE INTERVENCAO NO DOMINIO ECONOMICO','Recursos da Contribuicao de Intervencao no DomInio Economico - CIDE'),
          (217,27510000,2751000,2751,'RECURSOS DA CONTRIBUICAO PARA CUST. SER. ILUM. PUB. - COSIP','Recursos da Contribuicao para o Custeio do Servico de Iluminacao Publica - COSIP'),
          (218,25400007,2540000,2540,'TRANSFERENCIAS DO FUNDEB - IMPOS. E TRANSF. DE IMPOSTOS - 70','Transferencias do FUNDEB - Impostos e Transferencias de Impostos - 70'),
          (219,25400000,2540000,2540,'TRANSFERENCIAS DO FUNDEB - IMPOS. E TRANSF. DE IMPOSTOS - 30','Transferencias do FUNDEB - Impostos e Transferencias de Impostos - 30'),
          (220,25760000,2576000,2576,'TRANSF. DE RECURSOS DOS ESTADOS PARA PROGRAMAS DE EDUCACAO','Transferencias de Recursos dos Estados para programas de Educacao'),
          (221,26220000,2622000,2622,'TRANSF. FUNDO A FUNDO DE REC. DO SUS PROV. GOVER. MUNICIPAIS','Transferencias Fundo a Fundo de Recursos do SUS provenientes dos Governos Municipais'),
          (222,25700000,2570000,2570,'TRANSF. GOV. FEDERAL REF. CONVENIOS E CONGE VINC. EDUCACAO','Transferencias do Governo Federal referentes a Convenios e Instrumentos Congeneres vinculados a Educacao'),
          (223,26310000,2631000,2631,'TRANSF. GOV. FEDERAL REF. CONVENIOS E INST CONGE VINC. SAUDE','Transferencias do Governo Federal referentes a Convenios e Instrumentos Congeneres vinculados a Saude'),
          (224,27000000,2700000,2700,'OUTRAS TRANSF. DE CONVENIOS OU INST. CONGENERES DA UNIAO','Outras Transferencias de Convenios ou Instrumentos Congeneres da Uniao'),
          (229,26600000,2660000,2660,'TRANSF. DE REC. DO FUNDO NACIONAL DE ASSISTENCIA SOCIAL FNAS','Transferencia de Recursos do Fundo Nacional de Assistencia Social - FNAS'),
          (230,28990040,2899004,2899,'TRANSF. ACORDO JUDICIAL BARRAGEM FUNDAO','Transferencia referente ao Acordo Judicial de Reparacao dos Impactos Socioeconomicos e Ambientais do Rompimento da Barragem de Fundao'),
          (231,27590050,2759005,2759,'REPASSE TARIFARIO PARA OS FUNDOS MUNICIPAIS DE SANEAMENTO','Repasse tarifario para os Fundos Municipais de Saneamento'),
          (242,26650000,2665000,2665,'TRANSF. DE CONVENIOS E INST CONGE VINC. A ASSISTENCIA SOCIAL','Transferencias de Convenios e Instrumentos Congeneres Vinculados a Assistencia Social'),
          (243,25510000,2551000,2551,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PDDE','Transferencias de Recursos do FNDE Referentes ao Programa Dinheiro Direto na Escola (PDDE)'),
          (244,25520000,2552000,2552,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PNAE','Transferencias de Recursos do FNDE Referentes ao Programa Nacional de Alimentacao Escolar (PNAE)'),
          (245,25530000,2553000,2553,'TRANSFERENCIAS DE RECURSOS DO FNDE REFERENTES AO PNATE','Transferencias de Recursos do FNDE Referentes ao Programa Nacional de Apoio ao Transporte Escolar (PNATE)'),
          (246,25690000,2569000,2569,'OUTRAS TRANSFERENCIAS DE RECURSOS DO FNDE','Outras Transferencias de Recursos do FNDE'),
          (247,25500000,2550000,2550,'TRANSFERENCIA DO SALARIO-EDUCACAO','Transferencia do Salario-Educacao'),
          (253,26010000,2601000,2601,'TRANSF. DE REC. DO SUS PROV. GOV. FEDERAL - BLOCO ESTR. ASPS','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Federal - Bloco de Estruturacao da Rede de Servicos Publicos de Saude'),
          (254,26590000,2659000,2659,'OUTROS RECURSOS VINCULADOS A SAUDE','Outros Recursos Vinculados a Saude'),
          (255,26210000,2621000,2621,'TRANSFERENCIAS FUNDO A FUNDO DE RECURSOS DO SUS PROVENIENTES DO GOVERNO ESTADUAL','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Estadual'),
          (256,26610000,2661000,2661,'TRANSFERENCIA DE RECURSOS DOS FUNDOS ESTADUAIS DE ASSISTENCIA SOCIAL','Transferencia de Recursos dos Fundos Estaduais de Assistencia Social'),
          (257,27520000,2752000,2752,'RECURSOS VINCULADOS AO TRÂNSITO','Recursos Vinculados ao Trânsito'),
          (258,28990060,2899006,2899,'CONTRIB. ASSIST. A SAUDE DOS SERVIDORES','Contribuicao para a Assistencia a Saude dos Servidores: Patronal, dos Servidores, dos Prestadores de Servicos Contratados'),
          (259,26000000,2600000,2600,'TRANSF. DE REC. DO SUS - GOVERNO FEDERAL - BLOCO MANUT. ASPS','Transferencias Fundo a Fundo de Recursos do SUS provenientes do Governo Federal - Bloco de Manutencao das Acoes e Servicos Publicos de Saude'),
          (260,27040000,2704000,2704,'TRANSF. DA UNIAO REF. A COMP. FINAN. EXPLO. DE REC. NATURAIS','Transferencias da Uniao Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (261,27070000,2707000,2707,'TRANSFERENCIAS DA UNIAO - INCISO I DO ART. 5º DA LEI COMPLEMENTAR 173/2020','Transferencias da Uniao - inciso I do art. 5º da Lei Complementar 173/2020'),
          (262,27490120,2749012,2749,'TRANSF. DE REC. LEI ALDIR BLANC','Transferencia de Recursos para aplicacao em Acoes Emergenciais de Apoio ao Setor Cultural (Lei Aldir Blanc)'),
          (263,27130070,2713007,2713,'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANCA PUBLICA','Transferencias de Convenios Vinculados a Seguranca Publica'),
          (264,27060000,2706000,2706,'TRANSFERENCIA ESPECIAL DA UNIAO','Transferencia Especial da Uniao'),
          (265,28990000,2899000,2899,'OUTROS RECURSOS VINCULADOS','Outros Recursos Vinculados'),
          (266,25420007,2542000,2542,'TRANSFERENCIAS DO FUNDEB - COMPLEMENTACAO DA UNIAO - VAAT - 70','Transferencias do FUNDEB - Complementacao da Uniao - VAAT - 70'),
          (267,25420003,2542000,2542,'TRANSFERENCIAS DO FUNDEB - COMPLEMENTACAO DA UNIAO - VAAT - 30','Transferencias do FUNDEB - Complementacao da Uniao - VAAT - 30'),
          (268,27100100,2710010,2710,'TRANSF. ESP. ESTADO - BARRAGEM BRUMADINHO','Transferencia Especial do Estado - Acordo Judicial de Reparacao dos Impactos Socioeconomicos e Ambientais do Rompimento de Barragem em Brumadinho'),
          (269,27100000,2710000,2710,'TRANSFERENCIA ESPECIAL DOS ESTADOS','Transferencia Especial dos Estados'),
          (270,25010000,2501000,2501,'OUTROS RECURSOS NAO VINCULADOS','Outros Recursos nao Vinculados'),
          (271,25710000,2571000,2571,'TRANSF. DO ESTADO REF. A CONV. E INST. CONG. VINC. EDUCACAO','Transferencias do Estado referentes a Convenios e Instrumentos Congeneres vinculados a Educacao'),
          (272,25720000,2572000,2572,'TRANSF. MUNICPIOS  REF. A CONV. E INST. CONG. VINC. EDUCACAO','Transferencias de MunicIpios referentes a Convenios e Instrumentos Congeneres Vinculados a Educacao'),
          (273,25750000,2575000,2575,'OUTRAS TRANSF. DE CONVENIOS E INST. CONGE VINC. EDUCACAO','Outras Transferencias de Convenios e Instrumentos Congeneres Vinculados a Educacao'),
          (274,25740000,2574000,2574,'OPERACOES DE CREDITO VINCULADAS A EDUCACAO','Operacoes de Credito Vinculadas a Educacao');
          
          INSERT INTO mytable1(FONTE2022,FONTE2023,COD_TCE,COD_STN,DESCRICAO,FINALIDADE) VALUES
          (275,25730000,2573000,2573,'ROYALTIES DO PETROLEO E GAS NATURAL VINCULADOS A EDUCACAO','Royalties do Petroleo e Gas Natural Vinculados a Educacao'),
          (276,26320000,2632000,2632,'TRANSF. DO ESTADO REF. CONVENIOS E INST. CONGE VINC. SAUDE','Transferencias do Estado referentes a Convenios e Instrumentos Congeneres Vinculados a Saude'),
          (277,26330000,2633000,2633,'TRANSF. DE MUNICÍPIOS REF. CONVENIOS E INST CONGE VINC SAUDE','Transferencias de MunicIpios referentes a Convenios e Instumentos Congeneres Vinculados a Saude'),
          (278,26360000,2636000,2636,'OUTRAS TRANSF CONVENIOS E INST CONGENERES VINCULADOS A SAUDE','Outras Transferencias de Convenios e Instrumentos Congeneres Vinculados a Saude'),
          (279,26340000,2634000,2634,'OPERACOES DE CREDITO VINCULADAS A SAUDE','Operacoes de Credito Vinculadas a Saude'),
          (280,26350000,2635000,2635,'ROYALTIES DO PETROLEO E GAS NATURAL VINCULADOS A SAUDE','Royalties do Petroleo e Gas Natural Vinculados a Saude'),
          (281,27010000,2701000,2701,'OUTRAS TRANSF. DE CONVENIOS OU INST. CONGENERES DOS ESTADOS','Outras Transferencias de Convenios ou Instrumentos Congeneres dos Estados'),
          (282,27020000,2702000,2702,'OUTRAS TRANSF DE CONVENIOS OU INST CONGENERES DOS MUNICIPIOS','Outras Transferencias de Convenios ou Instrumentos Congeneres dos MunicIpios'),
          (283,27030000,2703000,2703,'OUTRAS TRANSF DE CONVENIOS OU INST CONGE DE OUTRAS ENTIDADES','Outras Transferencias de Convenios ou Instrumentos Congeneres de outras Entidades'),
          (284,27090000,2709000,2709,'TRANSF. DA UNIAO REF. A COMPENSACAO FINAN. DE REC. HIDRICOS','Transferencia da Uniao referente a Compensacao Financeira de Recursos HIdricos'),
          (285,27530000,2753000,2753,'REC. PROVENIENTES DE TAXAS, CONTRIBUICOES E PRECOS PUBLICOS','Recursos Provenientes de Taxas, Contribuicoes e Precos Publicos'),
          (286,27040000,2704000,2704,'TRANSF. DA UNIAO REF. COMP. FINAN EXPLORACAO DE REC NATURAIS','Transferencias da Uniao Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (287,27050000,2705000,2705,'TRANSF. DOS ESTADOS REF. COMP. FINAN EXPLORACAO REC NATURAIS','Transferencias dos Estados Referentes a Compensacoes Financeiras pela Exploracao de Recursos Naturais'),
          (288,25000080,2500008,2500,'DIS. CAIXA. VINCULADA A RESTOS A PAGAR - SAUDE','Disponibilidade de Caixa vinculada a Restos a Pagar considerados na Aplicacao MInima da Saude e posteriormente Cancelados ou Prescritos'),
          (289,25000090,2500009,2500,'DIS. CAIXA. VINCULADA A RESTOS A PAGAR - EDUCACAO','Disponibilidade de Caixa vinculada a Restos a Pagar considerados na Aplicacao MInima da Educacao e posteriormente Cancelados ou Prescritos'),
          (290,27540000,2754000,2754,'RECURSOS DE OPERACOES DE CREDITO','Recursos de Operacoes de Credito'),
          (291,27540000,2754000,2754,'RECURSOS DE OPERACOES DE CREDITO','Recursos de Operacoes de Credito'),
          (292,27550000,2755000,2755,'RECURSOS DE ALIENACAO DE BENS-ATIVOS - ADMINISTRACAO DIRETA','Recursos de Alienacao de Bens/Ativos - Administracao Direta'),
          (293,28990130,2899013,2899,'OUTRAS RECEITAS NAO PRIMARIAS','Outras Receitas Nao Primarias'),
          
          -- Fonte apontada por Carol, conversa discord de 31-10-2022
          (136,17180000,1718000,1718,'', '');
          
          
          UPDATE conplanoorcamentoanalitica
          SET c61_codigo = FONTE2022
          FROM mytable1
          WHERE c61_codigo = FONTE2023
            AND c61_anousu < 2023
            AND FONTE2022 IS NOT NULL;
          
          
          UPDATE conplanoorcamentoanalitica
          SET c61_codigo = FONTE2023
          FROM mytable1
          WHERE c61_codigo = FONTE2022
            AND c61_anousu >= 2023
            AND FONTE2022 IS NOT NULL;
          

          UPDATE conplanoreduz
          SET c61_codigo = FONTE2023
          FROM mytable1
          WHERE c61_codigo = FONTE2022
            AND c61_anousu >= 2023
            AND FONTE2022 IS NOT NULL;
          

          UPDATE conplanoreduz
          SET c61_codigo = FONTE2022
          FROM mytable1
          WHERE c61_codigo = FONTE2023
            AND c61_anousu < 2023
            AND FONTE2022 IS NOT NULL;
          

          UPDATE rhlotavinc
          SET rh25_recurso = FONTE2023
          FROM mytable1
          WHERE rh25_recurso = FONTE2022
            AND rh25_anousu = 2023
            AND FONTE2022 IS NOT NULL;
          

          UPDATE rhlotavincrec
          SET rh43_recurso = rh25_recurso
          FROM rhlotavinc
          WHERE rh25_codlotavinc = rh43_codlotavinc
            AND rh25_anousu = 2023
            AND rh43_recurso != rh25_recurso;
          

          UPDATE rhempenhofolhaexcecaorubrica
          SET rh74_recurso = FONTE2023
          FROM mytable1
          WHERE rh74_recurso = FONTE2022
            AND rh74_anousu = 2023
            AND FONTE2022 IS NOT NULL;
          
          
          UPDATE orctiporec
          SET o15_datalimite = '2023-01-01'
          WHERE length(o15_codigo::varchar) < 5
            AND o15_datalimite = '2022-12-31';
          
          
          DROP TABLE mytable1";

        $this->execute($sqlFontes);

    }
}
