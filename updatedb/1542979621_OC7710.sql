
-- Ocorrência 7710

--SCRIPT 01
BEGIN;
SELECT fc_startsession();

-- Inserir item de menu Relatórios SIOPS
INSERT INTO db_itensmenu VALUES (
  (select max(id_item)+1 from db_itensmenu),
  'Relatórios SIOPS', 'Relatórios SIOPS',
  '', 1, 1, 'Relatórios SIOPS', 't');

-- Insere item no menu Relatórios
INSERT INTO db_menu VALUES (
  3331,
  (select max(id_item) from db_itensmenu),
  (select max(menusequencia)+1 from db_menu where modulo = 209 and id_item = 3331),
  209);

-- Inserir item de menu Prev. e Exec. das Receitas Orçamentárias
INSERT INTO db_itensmenu VALUES (
  (select max(id_item)+1 from db_itensmenu),
  'Prev. e Exec. das Receitas Orçamentárias',
  'Prev. e Exec. das Receitas Orçamentárias',
  'con2_prevexecreceitasorcamentarias001.php', 1, 1,
  'Prev. e Exec. das Receitas Orçamentárias', 't');

INSERT INTO db_menu VALUES (
  (select max(id_item)-1 from db_itensmenu),
  (select max(id_item) from db_itensmenu),
  1,
  209);

-- REGISTRO DO RELATÓRIO
INSERT
INTO orcparamrel
VALUES(
--   (SELECT MAX(o42_codparrel)+1 FROM orcparamrel WHERE o42_codparrel < 9999),
  173,
  'Prev. e Exec. das Receitas Orçamentárias',
  1
);

--------------------------------------------------------
--            FUNÇÃO DE INCLUSÃO DE LINHA             --
--------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_incluirlinha7710(descricao VARCHAR(250), totalizador BOOLEAN) RETURNS VOID AS
$$
BEGIN

  INSERT
  INTO  orcparamseq
  VALUES (
--     (SELECT  MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 9999), --o69_codparamrel
    173, --o69_codparamrel
    (SELECT  COALESCE((SELECT  MAX(o69_codseq)+1
                       FROM  orcparamseq
--                        WHERE  o69_codparamrel = (SELECT MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 9999)),
                       WHERE  o69_codparamrel = 173),
                       1)), --o69_codseq
    descricao, --o69_descr
    1, --o69_grupo
    0, --o69_grupoexclusao
    0, --o69_nivel
    false, --o69_libnivel
    false, --o69_librec
    false, --o69_libsubfunc
    false, --o69_libfunc
    false, --o69_verificaano
    descricao, --o69_labelrel
    false, --o69_manual
    totalizador, --o69_totalizador
    (SELECT  COALESCE((SELECT  MAX(o69_codseq)+1
                       FROM  orcparamseq
--                        WHERE  o69_codparamrel = (SELECT MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 9999)),
                       WHERE  o69_codparamrel = 173),

                      1)), --o69_ordem
    1, --o69_nivellinha
    '', --o69_observacao
    false, --o69_desdobrarlinha
    1 --o69_origem
  );

END
$$
language plpgsql;

-----------------------------------------------
--            INCLUSÃO DE LINHAS             --
-----------------------------------------------
SELECT fc_incluirlinha7710('Receitas Correntes', TRUE);
SELECT fc_incluirlinha7710('Receita Tributária', TRUE);
SELECT fc_incluirlinha7710('Impostos', TRUE);
SELECT fc_incluirlinha7710('Impostos sobre o Patrimônio e a Renda', TRUE);
SELECT fc_incluirlinha7710('Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU',FALSE);
SELECT fc_incluirlinha7710('Imposto de Renda Retido e Proventos de Qualquer Natureza',TRUE);
SELECT fc_incluirlinha7710('Imposto de Renda Retido nas Fontes sobre os Rendimentos do Trabalho - IRRF',FALSE);
SELECT fc_incluirlinha7710('Imposto de Renda Retido nas Fontes sobre Outros Rendimentos',FALSE);
SELECT fc_incluirlinha7710('Imposto sobre a Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais sobre Imóveis - ITBI',FALSE);
SELECT fc_incluirlinha7710('Imposto sobre a Produção e a Circulação', TRUE);
SELECT fc_incluirlinha7710('Imposto sobre Serviços de Qualquer Natureza - ISS',TRUE);
SELECT fc_incluirlinha7710('Imposto sobre Serviços de Qualquer Natureza',FALSE);
SELECT fc_incluirlinha7710('Adicional ISS - Fundo Municipal de Combate à Pobreza',FALSE);
SELECT fc_incluirlinha7710('ISS / ICMS / SIMPLES - Lei Federal 9.317 / 96 - Imposto sobre Serviços',FALSE);
SELECT fc_incluirlinha7710('Taxas', TRUE);
SELECT fc_incluirlinha7710('Taxas pelo Exercício do Poder de Polícia', TRUE);
SELECT fc_incluirlinha7710('Taxa de Fiscalização de Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Taxa de Saúde Suplementar',FALSE);
SELECT fc_incluirlinha7710('Taxa pela Utilização de Selos de Controle e de Contadores de Produção',FALSE);
SELECT fc_incluirlinha7710('Outras Taxas pelo Exercício do Poder de Polícia',FALSE);
SELECT fc_incluirlinha7710('Taxas pela Prestação de Serviços',FALSE);
SELECT fc_incluirlinha7710('Contribuição de Melhoria',FALSE);
SELECT fc_incluirlinha7710('Receitas de Contribuições', TRUE);
SELECT fc_incluirlinha7710('Contribuições Sociais', TRUE);
SELECT fc_incluirlinha7710('Contribuição para o Fundo de Saúde das Forças Armadas',FALSE);
SELECT fc_incluirlinha7710('Contribuições para o Regime Próprio de Previdência do Servidor Público', TRUE);
SELECT fc_incluirlinha7710('Contribuição Patronal de Servidor Ativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal de Servidor Ativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Inativo Civil',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Inativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Pensionista Civil',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Pensionista Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição do Servidor Ativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuição de Servidor Ativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuições do Servidor Inativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Servidor Inativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Pensionista Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Pensionista Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Previdenciária para Amortização do Déficit Atuarial',FALSE);
SELECT fc_incluirlinha7710('Contribuição Previdenciária em Regime de Parcelamento de Débitos - RPPS',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição Patronal, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição do Servidor Ativo Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição do Servidor Inativo Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento de Pensionista Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Outras Contribuições Previdenciárias',FALSE);
SELECT fc_incluirlinha7710('Outras Contribuições',FALSE);
SELECT fc_incluirlinha7710('Receita Patrimonial', TRUE);
SELECT fc_incluirlinha7710('Receitas Imobiliárias',FALSE);
SELECT fc_incluirlinha7710('Receitas de Valores Mobiliários', TRUE);
SELECT fc_incluirlinha7710('Juros de Títulos de Renda',FALSE);
SELECT fc_incluirlinha7710('Remuneração de Depósitos Bancários', TRUE);
SELECT fc_incluirlinha7710('Remuneração de Depósitos de Recursos Vinculados', TRUE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Royalties', TRUE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Royalties da Educação',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Royalties da Saúde',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas de Remuneração de Depósitos Bancários de Recursos Vinculados - Royalties',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - FUNDEB',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Fundo de Saúde',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Ações e Serviços Públicos de Saúde',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Convênios com a Área de Educação',FALSE);
SELECT fc_incluirlinha7710('Receita de Remuneração de Depósitos Bancários de Recursos Vinculados - Convênios com a Área da Saúde',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas de Remuneração de Outros Depósitos Bancários de Recursos Vinculados',FALSE);
SELECT fc_incluirlinha7710('Remuneração de Depósitos de Recursos não Vinculados',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas de Valores Mobiliários',FALSE);
SELECT fc_incluirlinha7710('Compensações Financeiras',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas Patrimoniais',FALSE);
SELECT fc_incluirlinha7710('Receita Agropecuária',FALSE);
SELECT fc_incluirlinha7710('Receita Industrial',FALSE);
SELECT fc_incluirlinha7710('Receita de Serviços',TRUE);
SELECT fc_incluirlinha7710('Serviços de Saúde',TRUE);
SELECT fc_incluirlinha7710('Serviços Hospitalares',FALSE);
SELECT fc_incluirlinha7710('Serviços de Registro de Análise e de Controle de Produtos Sujeitos a Normas de Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Serviços Radiológicos e Laboratoriais',FALSE);
SELECT fc_incluirlinha7710('Serviços de Assistência à Saúde Suplementar do Servidor Civil',FALSE);
SELECT fc_incluirlinha7710('Serviços de Saúde a Terceiros',TRUE);
SELECT fc_incluirlinha7710('Serviços de Saúde ao Estado',FALSE);
SELECT fc_incluirlinha7710('Serviços de Saúde a Municípios',FALSE);
SELECT fc_incluirlinha7710('Serviços de Consórcios de Saúde',FALSE);
SELECT fc_incluirlinha7710('Serviços de Saúde a Instituições Privadas - Saúde Suplementar (TUNEP)',FALSE);
SELECT fc_incluirlinha7710('Outros Serviços de Saúde a Terceiros',FALSE);
SELECT fc_incluirlinha7710('Serviços Ambulatoriais',FALSE);
SELECT fc_incluirlinha7710('Outros Serviços de Saúde',FALSE);
SELECT fc_incluirlinha7710('Outros Serviços',FALSE);
SELECT fc_incluirlinha7710('Transferências Correntes',TRUE);
SELECT fc_incluirlinha7710('Transferências Intergovernamentais',TRUE);
SELECT fc_incluirlinha7710('Transferências da União',TRUE);
SELECT fc_incluirlinha7710('Participação na Receita da União',TRUE);
SELECT fc_incluirlinha7710('Cota Parte do Fundo de Participação dos Municípios - FPM - Parcela referente à CF, art. 159, I, alínea b (Cota Mensal)',FALSE);
SELECT fc_incluirlinha7710('Cota Parte do Fundo de Participação dos Municípios - (1% Cota entregue no mês de dezembro)',FALSE);
SELECT fc_incluirlinha7710('Cota Parte do Fundo de Participação dos Municípios - (1% Cota entregue no mês de julho)',FALSE);
SELECT fc_incluirlinha7710('Cota Parte do Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte da Contribuição de Intervenção no Domínio Econômico - CIDE',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte do Imposto Sobre Operações de Crédito, Câmbio e Seguro,ou Relativas a Títulos ou Valores Mobiliários-IOF OURO',FALSE);
SELECT fc_incluirlinha7710('Transferência da Compensação Financeira pela Exploração de Recursos Naturais',TRUE);
SELECT fc_incluirlinha7710('Cota-parte da Compensação Financeira de Recursos Hídricos',FALSE);
SELECT fc_incluirlinha7710('Cota-parte da Compensação Financeira de Recursos Minerais - CFEM',FALSE);
SELECT fc_incluirlinha7710('Cota-parte Royalties - Compensação Financeira pela Produção de Petróleo - Lei nº 7.990/89',FALSE);
SELECT fc_incluirlinha7710('Cota-parte Royalties pelo Excedente da Produção do Petróleo - Lei nº 9.478/97, artigo 49, I e II',FALSE);
SELECT fc_incluirlinha7710('Cota-parte Royalties pela Participação Especial - Lei nº 9.478/97, artigo 50',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte do Fundo Especial do Petróleo - FEP',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências Decorrentes de Compensação Financeira pela Exploração de Recursos Naturais',FALSE);
SELECT fc_incluirlinha7710('Custeio das Ações e Serviços Públicos de Saúde',TRUE);
SELECT fc_incluirlinha7710('Atenção Básica',FALSE);
SELECT fc_incluirlinha7710('Atenção de Média e Alta Complexidade Ambulatorial e Hospitalar',FALSE);
SELECT fc_incluirlinha7710('Vigilância em Saúde',FALSE);
SELECT fc_incluirlinha7710('Assistência Farmacêutica',FALSE);
SELECT fc_incluirlinha7710('Gestão do SUS',FALSE);
SELECT fc_incluirlinha7710('Outros Programas Financiados por Transferências Fundo a Fundo',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Fundo Nacional de Assistência Social - FNAS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Fundo Nacional do Desenvolvimento da Educação - FNDE',TRUE);
SELECT fc_incluirlinha7710('Transferências do Salário-Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências Diretas do FNDE Referentes ao Programa Dinheiro Direto na Escola - PDDE',FALSE);
SELECT fc_incluirlinha7710('Transferências Diretas do FNDE Referentes ao Programa Nacional de Alimentação Escolar - PNAE',FALSE);
SELECT fc_incluirlinha7710('Transferências Diretas do FNDE Referentes ao Programa Nacional de Apoio ao Transporte do Escolar - PNATE',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências Diretas do Fundo Nacional do Desenvolvimento da Educação - FNDE',FALSE);
SELECT fc_incluirlinha7710('Transferência Financeira do ICMS - Desoneração - L.C. Nº 87/96 - LEI KANDIR',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Transferências Advindas de Emendas Parlamentares Individuais',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências da União',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Estados',TRUE);
SELECT fc_incluirlinha7710('Participação na Receita dos Estados',TRUE);
SELECT fc_incluirlinha7710('Cota-Parte do ICMS',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte do IPVA',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte do IPI sobre Exportação',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte da Contribuição de Intervenção no Domínio Econômico - CIDE',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos do SUS - Estado',FALSE);
SELECT fc_incluirlinha7710('Outras Participações na Receita dos Estados',FALSE);
SELECT fc_incluirlinha7710('Transferência da Cota-Parte da Compensação Financeira (25%)',TRUE);
SELECT fc_incluirlinha7710('Cota-Parte da Compensação Financeira de Recursos Hídricos',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte da Compensação Financeira de Recursos Minerais - CFEM',FALSE);
SELECT fc_incluirlinha7710('Cota-Parte Royalties - Compensação Financeira pela Produção do Petróleo - Lei nº 7.990/89, artigo 9º',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências Decorrentes de Compensações Financeiras',FALSE);
SELECT fc_incluirlinha7710('Transferência de Recursos do Estado para Programas de Saúde - Repasse Fundo a Fundo',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Estado para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências do Estado para a Área de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências dos Estados',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Municípios',TRUE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Recebimento pela Prestação de Serviços de Saúde a Municípios',FALSE);
SELECT fc_incluirlinha7710('Recebimento pela Prestação de Serviços a Consórcios de Saúde',FALSE);
SELECT fc_incluirlinha7710('Recursos Provenientes do Fundo Municipal de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Municípios para Aquisição de Medicamentos',FALSE);
SELECT fc_incluirlinha7710('Transferência dos Municípios para a Área de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Transferências de Municípios para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências dos Municípios',FALSE);
SELECT fc_incluirlinha7710('Transferências Multigovernamentais',TRUE);
SELECT fc_incluirlinha7710('Transferências de Recursos do FUNDEB',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos da Complementação da União ao FUNDEB',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências Multigovernamentais',FALSE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas',TRUE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Instituições Privadas',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior',TRUE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências do Exterior',FALSE);
SELECT fc_incluirlinha7710('Transferências de Pessoas',TRUE);
SELECT fc_incluirlinha7710('Transferências de Pessoas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Pessoas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Pessoas',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União e de Suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União para o Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União Destinadas a Programas de Saneamento Básico',TRUE);
SELECT fc_incluirlinha7710('Convênios com o Ministério da Saúde para Saneamento Básico',FALSE);
SELECT fc_incluirlinha7710('Outros Convênios da União para Saneamento Básico',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênios da União',FALSE);
SELECT fc_incluirlinha7710('Transferência de Convênios dos Estados e do Distrito Federal e de Suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênio dos Estados para o Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênio dos Estados Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênio dos Estados',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Municípios e de Suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênio dos Municípios para o Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênio dos Municípios Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênios dos Municípios',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios de Instituições Privadas',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios do Exterior',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências Correntes',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas Correntes',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora dos Tributos',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora do Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Taxa de Fiscalização e Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Taxa de Saúde Suplementar',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora do Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora do Imposto sobre a Transmissão Inter Vivos de Bens Imóveis - ITBI',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora do Imposto sobre Serviços de Qualquer Natureza - ISS',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora sobre o ISS / ICMS / SIMPLES',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora de Outros Tributos',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora das Contribuições',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora das Contribuições Para o Regime Próprio de Previdência do Servidor',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora das Contribuições Previdenciárias Para o Regime Geral de Previdência',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora de Outras Contribuições',FALSE);
SELECT fc_incluirlinha7710('Multa e Juros de Mora da Dívida Ativa dos Tributos',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa do Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa do Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa do Imposto sobre a Transmissão Inter Vivos de Bens Imóveis - ITBI',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa do Imposto sobre Serviços de Qualquer Natureza - ISS',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa sobre o ISS / ICMS / SIMPLES',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa da Taxa de Fiscalização e Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora da Dívida Ativa de Outros Tributos',FALSE);
SELECT fc_incluirlinha7710('Multa e Juros de Mora da Dívida Ativa das Contribuições',TRUE);
SELECT fc_incluirlinha7710('Multa e Juros de Mora da Dívida Ativa das Contribuições Previdenciárias Para o Regime Geral de Previdência Social',FALSE);
SELECT fc_incluirlinha7710('Multa e Juros de Mora da Dívida Ativa de Outras Contribuições',FALSE);
SELECT fc_incluirlinha7710('Multa e Juros de Mora da Dívida Ativa de Outras Receitas',FALSE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora de Outras Receitas',FALSE);
SELECT fc_incluirlinha7710('Multas de Outras Origens',FALSE);
SELECT fc_incluirlinha7710('Indenizações e Restituições',TRUE);
SELECT fc_incluirlinha7710('Indenizações',FALSE);
SELECT fc_incluirlinha7710('Restituições',TRUE);
SELECT fc_incluirlinha7710('Restituições do SUS',FALSE);
SELECT fc_incluirlinha7710('Outras Restituições',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa',TRUE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa Tributária',TRUE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa do Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa do Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa do Imposto sobre a Transmissão Inter-Vivos de Bens Imóveis - ITBI',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa do Imposto sobre Serviços de Qualquer Natureza - ISS',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa do ISS / ICMS / SIMPLES',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa da Taxa de Fiscalização e Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa da Taxa de Saúde Suplementar',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa de Outros Tributos',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa não tributária',TRUE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa das Contribuições Previdenciárias Para o Regime Geral da Previdência Social',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa de Ressarcimento ao Regime Único de Saúde',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas da Dívida Ativa não Tributária',FALSE);
SELECT fc_incluirlinha7710('Receitas Decorrentes de Aportes Periódicos para Amortização de Déficit Atuarial do RPPS',FALSE);
SELECT fc_incluirlinha7710('Receitas Decorrentes de Compensações ao RGPS',FALSE);
SELECT fc_incluirlinha7710('Receitas Diversas',FALSE);
SELECT fc_incluirlinha7710('Receitas de Capital',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito Internas',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito Internas - Contratuais',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito Internas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Operações de Crédito Internas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Operações de Crédito Internas para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Operações de Crédito Internas - Contratuais',FALSE);
SELECT fc_incluirlinha7710('Outras Operações de Crédito Internas',FALSE);
SELECT fc_incluirlinha7710('Operações de Crédito Externas',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito Externas - Contratuais',TRUE);
SELECT fc_incluirlinha7710('Operações de Crédito Externas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Operações de Crédito Externas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Operações de Crédito Externas para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Operações de Crédito Externas - Contratuais',FALSE);
SELECT fc_incluirlinha7710('Outras Operações de Crédito Externas',FALSE);
SELECT fc_incluirlinha7710('Alienação de Bens Móveis e Imóveis',FALSE);
SELECT fc_incluirlinha7710('Amortização de Empréstimos',FALSE);
SELECT fc_incluirlinha7710('Transferências de Capital',TRUE);
SELECT fc_incluirlinha7710('Transferências Intergovernamentais',TRUE);
SELECT fc_incluirlinha7710('Transferências da União',TRUE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Sistema Único de Saúde - SUS',TRUE);
SELECT fc_incluirlinha7710('Bloco Investimentos na Rede de Serviços Públicos de Saúde',TRUE);
SELECT fc_incluirlinha7710('Atenção básica',FALSE);
SELECT fc_incluirlinha7710('Atenção especializada',FALSE);
SELECT fc_incluirlinha7710('Vigilância em saúde',FALSE);
SELECT fc_incluirlinha7710('Gestão e desenvolvimento de tecnologias em saúde no SUS',FALSE);
SELECT fc_incluirlinha7710('Gestão do SUS',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Recursos do SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências da União para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Transferências Advindas de Emendas Parlamentares Individuais',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências da União',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Estados',TRUE);
SELECT fc_incluirlinha7710('Transferências de Recursos do Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Estados para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências dos Estados',FALSE);
SELECT fc_incluirlinha7710('Transferências dos Municípios',TRUE);
SELECT fc_incluirlinha7710('Transferências de Recursos Destinadas a Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências de Recursos Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Municípios para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Transferências a Consórcios Públicos',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências dos Municípios',FALSE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas',TRUE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Instituições Privadas para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Instituições Privadas',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior',TRUE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências do Exterior para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências do Exterior',FALSE);
SELECT fc_incluirlinha7710('Transferências de Pessoas',TRUE);
SELECT fc_incluirlinha7710('Transferências de Pessoas para Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências de Pessoas para Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Pessoas para Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Pessoas',FALSE);
SELECT fc_incluirlinha7710('Transferências de Outras Instituições Públicas',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União e de suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União para o Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios da União Destinadas a Programas de Saneamento Básico',TRUE);
SELECT fc_incluirlinha7710('Convênios com o Ministério da Saúde para a Área de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outros Convênios e Transferências da União para Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênios da União',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Estados e do Distrito Federal e de suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Estados para o Sistema Único de Saúde - SUS',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Estados Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Estados Destinadas a Programas de Saneamento Básico',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênios dos Estados',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Municípios e de suas Entidades',TRUE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Municípios Destinados a Programas de Saúde',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Municípios Destinadas a Programas de Educação',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios dos Municípios Destinadas a Programas de Saneamento',FALSE);
SELECT fc_incluirlinha7710('Outras Transferências de Convênios dos Municípios',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios de Instituições Privadas',FALSE);
SELECT fc_incluirlinha7710('Transferências de Convênios do Exterior',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas de Capital',FALSE);
SELECT fc_incluirlinha7710('Receitas Correntes Intra-Orçamentárias',TRUE);
SELECT fc_incluirlinha7710('Receitas Tributárias',TRUE);
SELECT fc_incluirlinha7710('Impostos',TRUE);
SELECT fc_incluirlinha7710('Impostos sobre o Patrimônio e a Renda',TRUE);
SELECT fc_incluirlinha7710('Imposto sobre a Propriedade Territorial Rural - ITR',FALSE);
SELECT fc_incluirlinha7710('Imposto sobre a Renda e Proventos de Qualquer Natureza - IRRF',FALSE);
SELECT fc_incluirlinha7710('Impostos sobre a Produção e a Circulação de Mercadorias',TRUE);
SELECT fc_incluirlinha7710('Imposto sobre Serviços de Qualquer Natureza - ISS',FALSE);
SELECT fc_incluirlinha7710('Taxas',TRUE);
SELECT fc_incluirlinha7710('Taxas pelo Exercício do Poder de Polícia',TRUE);
SELECT fc_incluirlinha7710('Taxa de Fiscalização de Vigilância Sanitária',FALSE);
SELECT fc_incluirlinha7710('Taxa de Saúde Suplementar',FALSE);
SELECT fc_incluirlinha7710('Taxas pela Prestação de Serviços',FALSE);
SELECT fc_incluirlinha7710('Outras Taxas',FALSE);
SELECT fc_incluirlinha7710('Receita de Contribuição',TRUE);
SELECT fc_incluirlinha7710('Contribuições para o Regime Próprio de Previdência do Servidor Público',TRUE);
SELECT fc_incluirlinha7710('Contribuição Patronal de Servidor Ativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal de Servidor Ativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Inativo Civil',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Inativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Pensionista Civil',FALSE);
SELECT fc_incluirlinha7710('Contribuição Patronal - Pensionista Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição do Servidor Ativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuição de Servidor Ativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuições do Servidor Inativo Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Servidor Inativo Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Pensionista Civil para o Regime Próprio',FALSE);
SELECT fc_incluirlinha7710('Contribuições de Pensionista Militar',FALSE);
SELECT fc_incluirlinha7710('Contribuição Previdenciária para Amortização do Déficit Atuarial',FALSE);
SELECT fc_incluirlinha7710('Contribuição Previdenciária em Regime de Parcelamento de Débitos - RPPS',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição Patronal, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição do Servidor Ativo Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento da Contribuição do Servidor Inativo Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Receita de Recolhimento de Pensionista Civil, Oriunda do Pagamento de Sentenças Judiciais',FALSE);
SELECT fc_incluirlinha7710('Outras Contribuições Previdenciárias',FALSE);
SELECT fc_incluirlinha7710('Contribuição Previdenciária Para o Regime Geral de Previdência Social',FALSE);
SELECT fc_incluirlinha7710('Outras Contribuições Sociais',FALSE);
SELECT fc_incluirlinha7710('Receita Patrimonial',FALSE);
SELECT fc_incluirlinha7710('Receita Industrial',FALSE);
SELECT fc_incluirlinha7710('Receita de Serviços',TRUE);
SELECT fc_incluirlinha7710('Serviços de Saúde',TRUE);
SELECT fc_incluirlinha7710('Serviços Hospitalares',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas de Serviços',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas Correntes',TRUE);
SELECT fc_incluirlinha7710('Multas e Juros de Mora',FALSE);
SELECT fc_incluirlinha7710('Indenizações e Restituições',FALSE);
SELECT fc_incluirlinha7710('Receita da Dívida Ativa',TRUE);
SELECT fc_incluirlinha7710('Receita da dívida Ativa dos Tributos',FALSE);
SELECT fc_incluirlinha7710('Outras Receitas da Dívida Ativa',FALSE);
SELECT fc_incluirlinha7710('Receitas Correntes Diversas',FALSE);
SELECT fc_incluirlinha7710('Receitas de Capital Intra - Orçamentárias',FALSE);
SELECT fc_incluirlinha7710('TOTAL GERAL DAS RECEITAS',TRUE);


----------------------------------------------------------
--            FUNÇÃO DE INCLUSÃO DE COLUNAS             --
----------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_registrarcoluna7710(descricao VARCHAR(120),nome VARCHAR(50)) RETURNS VOID AS
$$
BEGIN

  INSERT
  INTO orcparamseqcoluna
  VALUES (
    (SELECT MAX(o115_sequencial)+1 FROM orcparamseqcoluna),
    2018,
    descricao,
    1,
    '',
    nome
  );

END
$$
language plpgsql;


------------------------------------------------------------
--            FUNÇÃO PARA INCLUSÃO DE COLUNAS             --
------------------------------------------------------------
-- SELECT fc_registrarcoluna7710('Previsão das Receitas','prevrec');
-- SELECT fc_registrarcoluna7710('Execução das Receitas Orçamentárias','execrecorc');

SELECT fc_registrarcoluna7710('Previsão Inicial das Receitas Brutas (a)','previnirecbruta');
SELECT fc_registrarcoluna7710('Previsão Atualizada das Receitas Brutas (b)', 'prevatualrecbruta');
SELECT fc_registrarcoluna7710('Receitas Realizadas Brutas (c)','recrealizadabruta');
SELECT fc_registrarcoluna7710('Deduções das Receitas (d)', 'deducrec');
SELECT fc_registrarcoluna7710('Receitas Realizadas da base para cálculo do percentual de aplicação em ASPS (e) = (c-d)','recrealizadabasecalcpercaplicasps');
SELECT fc_registrarcoluna7710('Dedução Para Formação do FUNDEB (f)','deducformacfundeb');
SELECT fc_registrarcoluna7710('Total Geral das Receitas Líquidas Realizadas (g) = (c- d-f)','totgeralrecliqrealiza');
SELECT fc_registrarcoluna7710('Receitas Orcadas','receitasorcadas');

-------------------------------------------------
--            CRIAÇÃO DOS PERÍODOS             --
-------------------------------------------------
INSERT INTO periodo
VALUES(125, '1º BIMESTRE', 6, 1, 1, 29, 2, '1B', 1);

INSERT INTO periodo
VALUES(126, '2º BIMESTRE', 6, 1, 1, 30, 4, '2B', 2);

INSERT INTO periodo
VALUES(127, '3º BIMESTRE', 6, 1, 1, 30, 6, '3B', 3);

INSERT INTO periodo
VALUES(128, '4º BIMESTRE', 6, 1, 1, 31, 8, '4B', 4);

INSERT INTO periodo
VALUES(129, '5º BIMESTRE', 6, 1, 1, 31, 10, '5B', 5);

INSERT INTO periodo
VALUES(130, '6º BIMESTRE', 6, 1, 1, 31, 12, '6B', 6);


-------------------------------------------------------------
--            FUNÇÃO PARA INCLUSÃO DE PERÍODOS             --
-------------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_incluirperiodos7710(periodo INT) RETURNS VOID AS
$$
BEGIN

  INSERT
  INTO orcparamrelperiodos(o113_sequencial, o113_periodo, o113_orcparamrel)
  VALUES ((SELECT MAX(o113_sequencial)+1
             FROM orcparamrelperiodos
            WHERE o113_sequencial
           NOT IN (4000803,4000802,4000801,4000800,4000799,4000798,4000797,4000796,
                   4000795,4000794,4000793,4000792,4000790,4000789,4000788,4000787,
                   4000786,4000785,4000784,4000783,4000782,4000781,4000780,4000779,
                   4000778,4000777,4000776,4000775,4000774,4000773,4000772,4000771,
                   4000770,4000769,4000768,4000767,4000766,4000765,4000764,4000763,
                   4000762,4000761,4000760,4000759,4000758,4000757,4000756,4000755)
              AND o113_sequencial < 1000000),

          periodo,
          173
  );

END
$$
language plpgsql;

----------------------------------
--    INSERÇÃO DE PERÍODOS      --
----------------------------------
SELECT fc_incluirperiodos7710(125);
SELECT fc_incluirperiodos7710(126);
SELECT fc_incluirperiodos7710(127);
SELECT fc_incluirperiodos7710(128);
SELECT fc_incluirperiodos7710(129);
SELECT fc_incluirperiodos7710(130);


----------------------------------------------------------
--            FUNÇÃO DE INCLUSÃO DE FORMULA             --
----------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_incluircoluna7710(codseq INT, coluna VARCHAR(50), formula VARCHAR(250)) RETURNS VOID AS
$$

DECLARE
  reg record;
  ordem INT;

BEGIN
  IF coluna='previnirecbruta'
  THEN ordem := 1;
  END IF;
  IF coluna='prevatualrecbruta'
  THEN ordem := 2;
  END IF;
  IF coluna='recrealizadabruta'
  THEN ordem := 3;
  END IF;
  IF coluna='deducrec'
  THEN ordem := 4;
  END IF;
  IF coluna='recrealizadabasecalcpercaplicasps'
  THEN ordem := 5;
  END IF;
  IF coluna='deducformacfundeb'
  THEN ordem := 6;
  END IF;
  IF coluna='totgeralrecliqrealiza'
  THEN ordem := 7;
  END IF;
  IF coluna='receitasorcadas'
  THEN ordem := 8;
  END IF;

  for reg in (
      SELECT o113_periodo
        FROM orcparamrelperiodos
--        WHERE o113_orcparamrel = (SELECT  MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 500)
       WHERE o113_orcparamrel = 173
    ORDER BY o113_periodo
  )loop

    INSERT
    INTO  orcparamseqorcparamseqcoluna
    VALUES  (
      (SELECT MAX(o116_sequencial)+1 from orcparamseqorcparamseqcoluna),              --o116_sequencial
      codseq,                                                                         --o116_codseq
--       (SELECT  MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 500),        --o116_codparamrel
      173,        --o116_codparamrel
      (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = coluna), --o116_orcparamseqcoluna
      ordem,                                                                          --o116_ordem
      reg.o113_periodo,                                                                    --o116_periodo
      formula                                                                         --o116_formula
    );

  END loop;
END
$$
language plpgsql;


-----------------------------------------------------------------------------------------
--            INCLUSÃO DA FÓRMULA PADRÃO EM TODAS AS LINHAS DE UMA COLUNA              --
-----------------------------------------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_incluirformulapadrao7710(coluna VARCHAR(50)) RETURNS VOID AS
$$

DECLARE
  reg record;
  formula VARCHAR(50);

BEGIN
  IF coluna='previnirecbruta'
  THEN formula := '';
  END IF;
  IF coluna='prevatualrecbruta'
  THEN formula := '';
  END IF;
  IF coluna='recrealizadabruta'
  THEN formula := '';
  END IF;
  IF coluna='deducrec'
  THEN formula := '';
  END IF;
  IF coluna='recrealizadabasecalcpercaplicasps'
  THEN formula := '';
  END IF;
  IF coluna='deducformacfundeb'
  THEN formula := '';
  END IF;
  IF coluna='totgeralrecliqrealiza'
  THEN formula := '';
  END IF;
  IF coluna='receitasorcadas'
  THEN formula := '';
  END IF;

  for reg in (
    SELECT o69_codseq
    FROM orcparamseq
--     WHERE o69_codparamrel = (SELECT  MAX(o42_codparrel) FROM orcparamrel WHERE o42_codparrel < 500)
    WHERE o69_codparamrel = 173
    ORDER BY o69_codseq
  )loop

    PERFORM fc_incluircoluna7710(reg.o69_codseq,coluna, formula);

  END loop;
END
$$
language plpgsql;


----------------------------------------------------------------------------------------------
--            INCLUSÃO DA FÓRMULA PADRÃO EM TODAS AS LINHAS DA PRIMEIRA COLUNA              --
----------------------------------------------------------------------------------------------
SELECT fc_incluirformulapadrao7710('previnirecbruta'); --1
SELECT fc_incluirformulapadrao7710('prevatualrecbruta'); --2
SELECT fc_incluirformulapadrao7710('recrealizadabruta'); --3
SELECT fc_incluirformulapadrao7710('deducrec'); --4
SELECT fc_incluirformulapadrao7710('recrealizadabasecalcpercaplicasps'); --5
SELECT fc_incluirformulapadrao7710('deducformacfundeb'); --6
SELECT fc_incluirformulapadrao7710('totgeralrecliqrealiza'); --7
SELECT fc_incluirformulapadrao7710('receitasorcadas'); --8

---------------------------------------------------------------------------
--            LIMPEZA DE TODAS AS FÓRMULAS DO RELATÓRIO 173              --
---------------------------------------------------------------------------
UPDATE orcparamseqorcparamseqcoluna
   SET o116_formula = ''
 WHERE o116_codparamrel = 173;

-- Adiciona a fórmula #saldo_inicial a todas as linhas da coluna previnirecbruta que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_inicial'
WHERE o116_codparamrel = 173
AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna IN (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna in ('previnirecbruta','receitasorcadas'));

-- Adiciona a fórmula #saldo_inicial+#saldo_prevadic_acum a todas as linhas da coluna prevatualrecbruta que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_inicial+#saldo_prevadic_acum'
WHERE o116_codparamrel = 173
AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = 'prevatualrecbruta');

-- Adiciona a fórmula #saldo_arrecadado a todas as linhas da coluna recrealizadabruta que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_arrecadado'
WHERE o116_codparamrel = 173
AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = 'recrealizadabruta');

-- Adiciona a fórmula #saldo_arrecadado a todas as linhas da coluna deducrec que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_arrecadado'
WHERE o116_codparamrel = 173
AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = 'deducrec');

-- Adiciona a fórmula #saldo_arrecadado a todas as linhas da coluna deducformacfundeb que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_arrecadado'
WHERE o116_codparamrel = 173
AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = 'deducformacfundeb');

-- Adiciona a fórmula #saldo_arrecadado a todas as linhas da coluna deducformacfundeb que possuem estrutural definido
UPDATE orcparamseqorcparamseqcoluna
SET o116_formula = '#saldo_arrecadado'
WHERE o116_codparamrel = 173
      AND o116_codseq IN (5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
                          64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
                          112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
                          148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
                          192,193,195,197,199,201,202,203,204,206,207,210,211,212,213,215,218,221,222,223,224,226,228,232,
                          233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,259,260,261,262,263,264,265,266,267,268,269,271,272,
                          274,275,281,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
                          331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369)
      AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = 'totgeralrecliqrealiza');


------------------------------------------------------------
--            FUNÇÃO DE ALTERAÇÃO DE FÓRMULAS             --
------------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_formula7710(linha INT, coluna VARCHAR(250), formula VARCHAR(250)) RETURNS VOID AS
$$

DECLARE
  a integer[] := (SELECT string_to_array(
      (SELECT replace(
          (SELECT regexp_replace(formula,'A|B|C|D|E|F|G|H|I|\\[|\\]','','g')),
          '+',',')),
      ','));
  i integer;
  formula1 varchar;
  formula2 varchar := '';

BEGIN
  -- realiza um loop e busca todos os registros
  FOREACH i IN ARRAY a
  LOOP
    RAISE NOTICE '%', i;
    formula1 := (SELECT o116_formula FROM orcparamseqorcparamseqcoluna
    WHERE o116_codparamrel = 173
          AND o116_codseq = i
          AND o116_orcparamseqcoluna = (SELECT o115_sequencial
                                        FROM orcparamseqcoluna
                                        WHERE o115_nomecoluna = coluna)
                 LIMIT 1);

    IF formula1 NOT IN ('#saldo_inicial','#saldo_inicial+#saldo_prevadic_acum','#saldo_arrecadado') THEN
      formula2 := CONCAT(formula2,'(F[',i,'])+');
    ELSE formula2 := CONCAT(formula2,'(L[',i,']->',coluna,')+');
    END IF;
  END LOOP;

  UPDATE orcparamseqorcparamseqcoluna
  SET o116_formula = (SELECT RTRIM(formula2,'+'))
  WHERE o116_codparamrel = 173
        AND o116_codseq = linha
        AND o116_orcparamseqcoluna = (SELECT o115_sequencial
                                      FROM orcparamseqcoluna
                                      WHERE o115_nomecoluna = coluna);
END
$$
language plpgsql;



----------------------------------------------------------
--            FUNÇÃO DE CHAMADA DE FÓRMULAS             --
----------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_chamaformula7710(linha INT, c1 VARCHAR(250), c2 VARCHAR(250), c3 VARCHAR(250), c4 VARCHAR(250), c5 VARCHAR(250), c6 VARCHAR(250), c7 VARCHAR(250), c8 VARCHAR(250)) RETURNS VOID AS
$$

BEGIN
  PERFORM fc_formula7710(linha,'previnirecbruta',c1);
  PERFORM fc_formula7710(linha,'prevatualrecbruta',c2);
  PERFORM fc_formula7710(linha,'recrealizadabruta',c3);
  PERFORM fc_formula7710(linha,'deducrec',c4);
  PERFORM fc_formula7710(linha,'recrealizadabasecalcpercaplicasps',c5);
  PERFORM fc_formula7710(linha,'deducformacfundeb',c6);
  PERFORM fc_formula7710(linha,'totgeralrecliqrealiza',c7);
  PERFORM fc_formula7710(linha,'receitasorcadas',c8);
END
$$
language plpgsql;


-----------------------------------------------------------
--            FUNÇÃO DE ALTERAÇÃO DE FÓRMULA             --
-----------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_alterarformula7710(linha INT, col INT, formula VARCHAR(120)) RETURNS VOID AS
$$

DECLARE
  coluna VARCHAR(50);

BEGIN
  IF col=1
  THEN coluna='previnirecbruta';
  END IF;
  IF col=2
  THEN coluna='prevatualrecbruta';
  END IF;
  IF col=3
  THEN coluna='recrealizadabruta';
  END IF;
  IF col=4
  THEN coluna='deducrec';
  END IF;
  IF col=5
  THEN coluna='recrealizadabasecalcpercaplicasps';
  END IF;
  IF col=6
  THEN coluna='deducformacfundeb';
  END IF;
  IF col=7
  THEN coluna='totgeralrecliqrealiza';
  END IF;
  IF col=8
  THEN coluna='receitasorcadas';
  END IF;

  UPDATE orcparamseqorcparamseqcoluna
  SET o116_formula = formula
  WHERE o116_codparamrel = 173
        AND o116_orcparamseqcoluna = (SELECT o115_sequencial FROM orcparamseqcoluna WHERE o115_nomecoluna = coluna)
        AND o116_codseq = linha;

END
$$
language plpgsql;


--------------------------------------------------------------------
--            FUNÇÃO DE ALTERAÇÃO DE FÓRMULAS EM LOTE             --
--------------------------------------------------------------------
CREATE OR REPLACE FUNCTION fc_formulalote7710() RETURNS VOID AS
$$

DECLARE
  a integer[] := array[5,6,8,9,10,13,14,18,21,22,23,28,30,32,34,36,38,40,42,43,44,45,46,47,49,51,58,59,60,61,62,63,
  64,65,66,67,68,69,75,83,84,89,90,91,92,94,96,97,98,99,100,101,102,104,105,106,107,108,109,110,
  112,113,114,115,116,117,118,119,120,123,124,125,126,128,130,131,132,133,134,137,138,140,147,
  148,150,151,152,156,161,165,168,169,172,173,175,176,177,179,180,181,182,183,184,188,189,191,
  192,193,195,197,199,201,202,203,204,206,207,210,211,212,215,218,221,222,223,224,226,228,232,
  233,234,235,240,241,242,243,244,247,248,249,250,251,252,253,263,264,265,267,268,269,271,272,
  274,275,286,291,296,297,300,301,304,305,307,308,309,310,312,313,315,316,318,323,324,326,329,
  331,332,335,337,339,341,343,345,347,349,350,351,352,353,355,356,357,361,363,364,366,368,369];
  i integer;

BEGIN
  -- realiza um loop e busca todos os registros
  FOREACH i IN ARRAY a
  LOOP
    PERFORM fc_alterarformula7710(i,5,CONCAT('(C[',i,',3])-(C[',i,',4])'));
    PERFORM fc_alterarformula7710(i,7,CONCAT('(C[',i,',3])-(C[',i,',4])-(C[',i,',6])'));
  END LOOP;

END
$$
language plpgsql;


SELECT fc_formulalote7710();

-- Fim do script

COMMIT;