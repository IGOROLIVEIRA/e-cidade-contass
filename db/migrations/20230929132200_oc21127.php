<?php

use Phinx\Migration\AbstractMigration;

class oc21127 extends AbstractMigration
{

    public function up(){
        $this->atualizaTabelaDeNatureza();
        $this->insereRegistros();
        $this->criaTabelaPagordemreinf();
        $this->insereNovosCamposPagordem();
    }
    
    public function atualizaTabelaDeNatureza(){
        $sql = " 
            BEGIN;

            DROP TABLE IF EXISTS empenho.naturezabemservico;
            CREATE TABLE IF NOT EXISTS empenho.naturezabemservico
            (
                e101_sequencial SERIAL,
                e101_codnaturezarendimento int4,
                e101_descr text NOT NULL,
                e101_resumo varchar(120) NOT NULL,
                e101_aliquota float8 NOT NULL DEFAULT 0
            );

            UPDATE db_itensmenu SET 
            descricao = 'Natureza do Rendimento', 
            help = 'Cadastro de Natureza do Rendimento', 
            desctec = 'Cadastro de Natureza do Rendimento'
            WHERE descricao = 'Natureza de Bem ou Serviço';

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e101_codnaturezarendimento' ,'int4' ,'Cod. Natureza do Rendimento' ,'' ,'Cod. Natureza do Rendimento' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Cod. Natureza do Rendimento' );

            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_codnaturezarendimento'),
            (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico')),0 );

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function insereRegistros(){
        $sql="
            BEGIN;

            INSERT INTO empenho.naturezabemservico (e101_descr, e101_resumo,e101_aliquota,e101_codnaturezarendimento) VALUES
            ('Alimentação','Alimentação','1.2', 17001), 
            ('Energia elétrica','Energia elétrica','1.2', 17002), 
            ('Serviços prestados com emprego de materiais','Serviços prestados com emprego de materiais','1.2', 17003),
            ('Construção Civil por empreitada com emprego de materiais','Construção Civil por empreitada com emprego de materiais','1.2', 17004),
            ('Serviços hospitalares de que trata o art. 30','Serviços hospitalares de que trata o art. 30','1.2', 17005),
            ('Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medicina nuclear e análises e patologias clínicas de que trata o art. 31.','Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medi...','1.2', 17006),
            ('Transporte de cargas, exceto os relacionados no código 8767','Transporte de cargas, exceto os relacionados no código 8767','1.2', 17007),
            ('Produtos farmacêuticos, de perfumaria, de toucador ou de higiene pessoal adquiridos de produtor, importador, distribuidor ou varejista, exceto os relacionados no código 8767 e','Produtos farmacêuticos, de perfumaria, de toucador ou de higiene pessoal adquiridos de produtor, importador, distribu...','1.2', 17008),
            ('Mercadorias e bens em geral.','Mercadorias e bens em geral.','1.2', 17009),
            ('Gasolina, inclusive de aviação, óleo diesel, gás liquefeito de petróleo (GLP), combustíveis derivados de petróleo ou de gás natural, querosene de aviação (QAV), e demais produtos derivados de petróleo, adquiridos de refinarias de petróleo, de demais produtores, de importadores, de distribuidor ou varejista, pelos órgãos da administração pública de que trata o caput do art. 19','Gasolina, inclusive de aviação, óleo diesel, gás liquefeito de petróleo (GLP), combustíveis derivados de petróleo ou ...','0.24', 17010),
            ('Álcool etílico hidratado, inclusive para fins carburantes, adquirido diretamente de produtor, importador ou distribuidor de que trata o art. 20','Álcool etílico hidratado, inclusive para fins carburantes, adquirido diretamente de produtor, importador ou distribui...','0.24', 17011),
            ('Biodiesel adquirido de produtor ou importador, de que trata o art. 21.','Biodiesel adquirido de produtor ou importador, de que trata o art. 21.','0.24', 17012),
            ('Gasolina, exceto gasolina de aviação, óleo diesel, gás liquefeito de petróleo (GLP), derivados de petróleo ou de gás natural e querosene de aviação adquiridos de dis- tribuidores e comerciantes varejistas','Gasolina, exceto gasolina de aviação, óleo diesel, gás liquefeito de petróleo (GLP), derivados de petróleo ou de gás ...','0.24', 17013),
            ('Álcool etílico hidratado nacional, inclusive para fins carburantes adquirido de comerciante varejista','Álcool etílico hidratado nacional, inclusive para fins carburantes adquirido de comerciante varejista','0.24', 17014),
            ('Biodiesel adquirido de distribuidores e comerciantes varejistas','Biodiesel adquirido de distribuidores e comerciantes varejistas','0.24', 17015),
            ('Biodiesel adquirido de produtor detentor regular do selo Combustível Social, fabricado a partir de mamona ou fruto, caroço ou amêndoa de palma produzidos nas regiões norte e nordeste e no semiárido, por agricultor familiar enquadrado no Programa Nacional de Fortalecimento da Agricultura Familiar (Pronaf).','Biodiesel adquirido de produtor detentor regular do selo Combustível Social, fabricado a partir de mamona ou fruto, c...','0.24', 17016),
            ('Transporte internacional de cargas efetuado por empresas nacionais','Transporte internacional de cargas efetuado por empresas nacionais','1.2', 17017),
            ('Estaleiros navais brasileiros nas atividades de construção, conservação, modernização, conversão e reparo de embarcações pré-registradas ou registradas no Registro Especial Brasileiro (REB), instituído pela Lei nº 9.432, de 8 de janeiro de 1997','Estaleiros navais brasileiros nas atividades de construção, conservação, modernização, conversão e reparo de embarcaç...','1.2', 17018),
            ('Produtos farmacêuticos, de perfumaria, de toucador e de higiene pessoal a que se refere o § 1º do art. 22 , adquiridos de distribuidores e de comerciantes varejistas','Produtos farmacêuticos, de perfumaria, de toucador e de higiene pessoal a que se refere o § 1º do art. 22 , adquirido...','1.2', 17019),
            ('Produtos a que se refere o § 2º do art. 22','Produtos a que se refere o § 2º do art. 22','1.2', 17020),
            ('Produtos de que tratam as alíneas \'c\' a \'k\' do inciso I do art. 5º','Produtos de que tratam as alíneas \'c\' a \'k\' do inciso I do art. 5º','1.2', 17021),
            ('Outros produtos ou serviços beneficiados com isenção, não incidência ou alíquotas zero da Cofins e da Contribuição para o PIS/Pasep, observado o disposto no § 5º do art. 2º.','Outros produtos ou serviços beneficiados com isenção, não incidência ou alíquotas zero da Cofins e da Contribuição pa...','1.2', 17022),
            ('Passagens aéreas, rodoviárias e demais serviços de transporte de passageiros, inclusive, tarifa de embarque, exceto as relacionadas no código 8850.','Passagens aéreas, rodoviárias e demais serviços de transporte de passageiros, inclusive, tarifa de embarque, exceto a...','2.40', 17023),
            ('Transporte internacional de passageiros efetuado por empresas nacionais.','Transporte internacional de passageiros efetuado por empresas nacionais.','2.40', 17024),
            ('Serviços prestados por associações profissionais ou assemelhadas e cooperativas.','Serviços prestados por associações profissionais ou assemelhadas e cooperativas.','0', 17025),
            ('Serviços prestados por bancos comerciais, bancos de investimento, bancos de desenvolvimento, caixas econômicas, sociedades de crédito, financiamento e investimento, sociedades de crédito imobiliário, e câmbio, distribuidoras de títulos e valores mobiliários, empresas de arrendamento mercantil, cooperativas de crédito, empresas de seguros privados e de capitalização e entidades abertas de previdência complementar','Serviços prestados por bancos comerciais, bancos de investimento, bancos de desenvolvimento, caixas econômicas, socie...','2.40', 17026),
            ('Seguro saúde.','Seguro saúde.','2.40', 17027),
            ('Serviços de abastecimento de água','Serviços de abastecimento de água','4.80', 17028),
            ('Telefone','Telefone','4.80', 17029),
            ('Correio e telégrafos','Correio e telégrafos','4.80', 17030),
            ('Vigilância','Vigilância','4.80', 17031),
            ('Limpeza','Limpeza','4.80', 17032),
            ('Locação de mão de obra','Locação de mão de obra','4.80', 17033),
            ('Intermediação de negócios','Intermediação de negócios','4.80', 17034),
            ('Administração, locação ou cessão de bens imóveis, móveis e direitos de qualquer natureza','Administração, locação ou cessão de bens imóveis, móveis e direitos de qualquer natureza','4.80', 17035),
            ('Factoring','Factoring','4.80', 17036),
            ('Plano de saúde humano, veterinário ou odontológico com valores fixos por servidor, por empregado ou por animal','Plano de saúde humano, veterinário ou odontológico com valores fixos por servidor, por empregado ou por animal','4.80', 17037),
            ('Demais serviços','Demais serviços','4.80', 17099),         
            ('Pagamento efetuado a sociedade cooperativa pelo fornecimento de bens, conforme art. 24, da IN 1234/12','Pagamento efetuado a sociedade cooperativa pelo fornecimento de bens, conforme art. 24, da IN 1234/12',0,17038),
            ('Pagamento a Cooperativa de produção, em relação aos atos decorrentes da comercialização ou da industrialização de produtos de seus associados, excetuado o previsto no §§ 1º e 2º do art. 25 da IN 1.234/12','Pagamento a Cooperativa de produção, em relação aos atos decorrentes da comercialização ou da industrialização de pro...', 0, 17039),
            ('Serviços prestados por associações profissionais ou assemelhadas e cooperativas que envolver parcela de serviços fornecidos por terceiros não cooperados ou não associados, contratados ou conveniados, para cumprimento de contratos - Serviços prestados com emprego de materiais, inclusive o de que trata a alínea \"C\" do Inciso II do art. 27 da IN 1.1234.','Serviços prestados por associações profissionais ou assemelhadas e cooperativas que envolver parcela de serviços forn...', 0, 17040),
            ('Serviços prestados por associações profissionais ou assemelhadas e cooperativas que envolver parcela de serviços fornecidos por terceiros não cooperados ou não associados, contratados ou conveniados, para cumprimento de contratos - Demais serviços','Serviços prestados por associações profissionais ou assemelhadas e cooperativas que envolver parcela de serviços forn...', 0, 17041),
            ('Pagamentos efetuados às associações e às cooperativas de médicos e de odontólogos, relativamente às importâncias recebidas a título de comissão, taxa de administração ou de adesão ao plano','Pagamentos efetuados às associações e às cooperativas de médicos e de odontólogos, relativamente às importâncias rece...', 0, 17042),
            ('Pagamento efetuado a sociedade cooperativa de produção, em relação aos atos decorrentes da comercialização ou de industrialização, pelas cooperativas agropecuárias e de pesca, de produtos adquiridos de não associados, agricultores, pecuaristas ou pescadores, para completar lotes destinados aoa cumprimento de contratos ou para suprir capacidade ociosa de suas instalações industriais, conforme § 1ºdo art. 25, da IN 1234/12.','Pagamento efetuado a sociedade cooperativa de produção, em relação aos atos decorrentes da comercialização ou de indu...', 0, 17043),
            ('Pagamento referente a aluguel de imóvel quando efetuado à entidade aberta de previdência complementar sem fins lucrativos, de que trata o art 34, § 2º da IN 1.234/2012.','Pagamento referente a aluguel de imóvel quando efetuado à entidade aberta de previdência complementar sem fins lucrat...', 0, 17044),
            ('Serviços prestados por cooperativas de radiotaxi, bem como àquelas cujos cooperados se dediquem a serviços relacionados a atividades culturais e demais cooperativas de serviços, conforme art. 5º-A, da IN RFB 1.234/2012.','Serviços prestados por cooperativas de radiotaxi, bem como àquelas cujos cooperados se dediquem a serviços relacionad...', 0, 17045),
            ('Pagamento efetuado na aquisição de bem imóvel, quando o vendedor for pessoa jurídica que exerce a atividade de compra e venda de imóveis, ou quando se tratar de imóveis adquiridos de entidades abertas de previdência complementar com fins lucrativos, conforme art. 23, inc I, da IN RFB 1234/2012','Pagamento efetuado na aquisição de bem imóvel, quando o vendedor for pessoa jurídica que exerce a atividade de compra...', 0, 17046),
            ('Pagamento efetuado na aquisição de bem imóvel adquirido pertencente ao ativo não circulante da empresa vendedora, conforme art. 23, inc II da IN RFB 1234/2012.','Pagamento efetuado na aquisição de bem imóvel adquirido pertencente ao ativo não circulante da empresa vendedora, con...', 0, 17047),
            ('Pagamento efetuado na aquisição de bem imóvel adquirido de entidade aberta de previdência complementar sem fins lucrativos, conforme art. 23, inc III, da IN RFB 1234/2012.','Pagamento efetuado na aquisição de bem imóvel adquirido de entidade aberta de previdência complementar sem fins lucra...', 0, 17048),
            ('Propaganda e Publicidade, em desconformidade ao art 16 da IN RFB 1234/2012, referente ao § 4º do citado artigo.','Propaganda e Publicidade, em desconformidade ao art 16 da IN RFB 1234/2012, referente ao § 4º do citado artigo.', 0, 17049),
            ('Propaganda e Publicidade, em conformidade ao art 16 da IN RFB 1234/2012, referente ao § 4º do citado artigo.','Propaganda e Publicidade, em conformidade ao art 16 da IN RFB 1234/2012, referente ao § 4º do citado artigo.', 0, 17050),
            ('Rendimento decorrente do trabalho com vínculo empregatício','Rendimento decorrente do trabalho com vínculo empregatício',0,10001),
            ('Rendimento decorrente do trabalho sem vínculo empregatício','Rendimento decorrente do trabalho sem vínculo empregatício',0,10002),
            ('Rendimento decorrente do trabalho pago a trabalhador avulso','Rendimento decorrente do trabalho pago a trabalhador avulso',0,10003),
            ('Participação nos lucros ou resultados (PLR)','Participação nos lucros ou resultados (PLR)',0,10004),
            ('Benefício de Regime Próprio de Previdência Social','Benefício de Regime Próprio de Previdência Social',0,10005),
            ('Benefício do Regime Geral de Previdência Social','Benefício do Regime Geral de Previdência Social',0,10006),
            ('Rendimentos relativos a prestação de serviços de Transporte Rodoviário Internacional de Carga, Auferidos por Transportador Autônomo Pessoa Física, Residente na República do Paraguai, considerado como Sociedade Unipessoal nesse País','Rendimentos relativos a prestação de serviços de Transporte Rodoviário Internacional de Carga, Auferidos por Transpor...',0,10007),
            ('Honorários advocatícios de sucumbência recebidos pelos advogados e procuradores públicos de que trata o art. 27 da Lei nº 13.327','Honorários advocatícios de sucumbência recebidos pelos advogados e procuradores públicos de que trata o art. 27 da Le...',0,10008),
            ('Auxílio moradia','Auxílio moradia',0,10009),
            ('Bolsa ao médico residente','Bolsa ao médico residente',0,10010),
            ('Decorrente de Decisão da Justiça do Trabalho','Decorrente de Decisão da Justiça do Trabalho',0,11001),
            ('Decorrente de Decisão da Justiça Federal','Decorrente de Decisão da Justiça Federal',0,11002),
            ('Decorrente de Decisão da Justiça dos Estados/Distrito Federal','Decorrente de Decisão da Justiça dos Estados/Distrito Federal',0,11003),
            ('Responsabilidade Civil - juros e indenizações por lucros cessantes, inclusive astreinte','Responsabilidade Civil - juros e indenizações por lucros cessantes, inclusive astreinte',0,11004),
            ('Decisão Judicial - Importâncias pagas a título de indenizações por danos morais, decorrentes de sentença judicial.','Decisão Judicial - Importâncias pagas a título de indenizações por danos morais, decorrentes de sentença judicial.',0,11005),
            ('Lucro e Dividendo','Lucro e Dividendo',0,12001),
            ('Resgate de Previdência Complementar - Modalidade Contribuição Definida/Variável - Não Optante pela Tributação Exclusiva','Resgate de Previdência Complementar - Modalidade Contribuição Definida/Variável - Não Optante pela Tributação Exclusi...',0,12002),
            ('Resgate de Fundo de Aposentadoria Programada Individual (Fapi)- Não Optante pela Tributação Exclusiva','Resgate de Fundo de Aposentadoria Programada Individual (Fapi)- Não Optante pela Tributação Exclusiva',0,12003),
            ('Resgate de Previdência Complementar - Modalidade Benefício Definido - Não Optante pela Tributação Exclusiva','Resgate de Previdência Complementar - Modalidade Benefício Definido - Não Optante pela Tributação Exclusiva',0,12004),
            ('Resgate de Previdência Complementar - Modalidade Contribuição Definida/Variável - Optante pela Tributação Exclusiva','Resgate de Previdência Complementar - Modalidade Contribuição Definida/Variável - Optante pela Tributação Exclusiva',0,12005),
            ('Resgate de Fundo de Aposentadoria Programada Individual (Fapi)- Optante pela Tributação Exclusiva','Resgate de Fundo de Aposentadoria Programada Individual (Fapi)- Optante pela Tributação Exclusiva',0,12006),
            ('Resgate de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência- Optante pela Tributação Exclusiva','Resgate de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência- Optante pela Tributação Exclusiva',0,12007),
            ('Resgate de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência - Não Optante pela Tributação Exclusiva','Resgate de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência - Não Optante pela Tributação Exclusi...',0,12008),
            ('Benefício de Previdência Complementar - Modalidade Contribuição Definida/Variável - Não Optante pela Tributação Exclusiva','Benefício de Previdência Complementar - Modalidade Contribuição Definida/Variável - Não Optante pela Tributação Exclu...',0,12009),
            ('Benefício de Fundo de Aposentadoria Programada Individual (Fapi)- Não Optante pela Tributação Exclusiva','Benefício de Fundo de Aposentadoria Programada Individual (Fapi)- Não Optante pela Tributação Exclusiva',0,12010),
            ('Benefício de Previdência Complementar - Modalidade Benefício Definido - Não Optante pela Tributação Exclusiva','Benefício de Previdência Complementar - Modalidade Benefício Definido - Não Optante pela Tributação Exclusiva',0,12011),
            ('Benefício de Previdência Complementar - Modalidade Contribuição Definida/Variável - Optante pela Tributação Exclusiva','Benefício de Previdência Complementar - Modalidade Contribuição Definida/Variável - Optante pela Tributação Exclusiva',0,12012),
            ('Benefício de Fundo de Aposentadoria Programada Individual (Fapi)- Optante pela Tributação Exclusiva','Benefício de Fundo de Aposentadoria Programada Individual (Fapi)- Optante pela Tributação Exclusiva',0,12013),
            ('Benefício de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência- Optante pela Tributação Exclusiva','Benefício de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência- Optante pela Tributação Exclusiva',0,12014),
            ('Benefício de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência - Não Optante pela Tributação Exclusiva','Benefício de Planos de Seguro de Vida com Cláusula de Cobertura por Sobrevivência - Não Optante pela Tributação Exclu...',0,12015),
            ('Juros sobre o Capital Próprio','Juros sobre o Capital Próprio',0,12016),
            ('Rendimento de Aplicações Financeiras de Renda Fixa, decorrentes de alienação, liquidação (total ou parcial), resgate, cessão ou repactuação do título ou aplicação','Rendimento de Aplicações Financeiras de Renda Fixa, decorrentes de alienação, liquidação (total ou parcial), resgate,...',0,12017),
            ('Rendimentos auferidos pela entrega de recursos à pessoa jurídica, sob qualquer forma e a qualquer título, independentemente de ser ou não a fonte pagadora instituição autorizada a funcionar pelo Banco Central','Rendimentos auferidos pela entrega de recursos à pessoa jurídica, sob qualquer forma e a qualquer título, independent...',0,12018),
            ('Rendimentos predeterminados obtidos em operações conjugadas realizadas: nos mercados de opções de compra e venda em bolsas de valores, de mercadorias e de futuros (box); no mercado a termo nas bolsas de valores, de mercadorias e de futuros, em operações de venda coberta e sem ajustes diários, e no mercado de balcão.','Rendimentos predeterminados obtidos em operações conjugadas realizadas: nos mercados de opções de compra e venda em b...',0,12019),
            ('Rendimentos obtidos nas operações de transferência de dívidas realizadas com instituição financeira e outras instituições autorizadas a funcionar pelo Banco Central do Brasil','Rendimentos obtidos nas operações de transferência de dívidas realizadas com instituição financeira e outras institui...',0,12020),
            ('Rendimentos periódicos produzidos por título ou aplicação, bem como qualquer remuneração adicional aos rendimentos prefixados','Rendimentos periódicos produzidos por título ou aplicação, bem como qualquer remuneração adicional aos rendimentos pr...',0,12021),
            ('Rendimentos auferidos nas operações de mútuo de recursos financeiros entre pessoa física e pessoa jurídica e entre pessoas jurídicas, inclusive controladoras, controladas, coligadas e interligadas','Rendimentos auferidos nas operações de mútuo de recursos financeiros entre pessoa física e pessoa jurídica e entre pe...',0,12022),
            ('Rendimentos auferidos em operações de adiantamento sobre contratos de câmbio de exportação, não sacado (trava de câmbio), bem como operações com export notes, com debêntures, com depósitos voluntários para garantia de instância e com depósitos judiciais ou administrativos, quando seu levantamento se der em favor do depositante','Rendimentos auferidos em operações de adiantamento sobre contratos de câmbio de exportação, não sacado (trava de câmb...',0,12023),
            ('Rendimentos obtidos nas operações de mútuo e de compra vinculada à revenda tendo por objeto ouro, ativo financeiro','Rendimentos obtidos nas operações de mútuo e de compra vinculada à revenda tendo por objeto ouro, ativo financeiro',0,12024),
            ('Rendimentos auferidos em contas de depósitos de poupança','Rendimentos auferidos em contas de depósitos de poupança',0,12025),
            ('Rendimentos auferidos sobre juros produzidos por letras hipotecárias','Rendimentos auferidos sobre juros produzidos por letras hipotecárias',0,12026),
            ('Rendimentos ou ganhos decorrentes da negociação de títulos ou valores mobiliários de renda fixa em bolsas de valores, de mercadorias, de futuros e assemelhadas','Rendimentos ou ganhos decorrentes da negociação de títulos ou valores mobiliários de renda fixa em bolsas de valores,...',0,12027),
            ('Rendimentos auferidos em outras aplicações financeiras de renda fixa ou de renda variável','Rendimentos auferidos em outras aplicações financeiras de renda fixa ou de renda variável',0,12028),
            ('Rendimentos auferidos em Fundo de Investimento','Rendimentos auferidos em Fundo de Investimento',0,12029),
            ('Rendimentos auferidos em Fundos de investimento em quotas de fundos de investimento','Rendimentos auferidos em Fundos de investimento em quotas de fundos de investimento',0,12030),
            ('Rendimentos produzidos por aplicações em fundos de investimento em ações','Rendimentos produzidos por aplicações em fundos de investimento em ações',0,12031),
            ('Rendimentos produzidos por aplicações em fundos de investimento em quotas de fundos de investimento em ações','Rendimentos produzidos por aplicações em fundos de investimento em quotas de fundos de investimento em ações',0,12032),
            ('Rendimentos produzidos por aplicações em Fundos Mútuos de Privatização com recursos do Fundo de Garantia por Tempo de Serviço (FGTS)','Rendimentos produzidos por aplicações em Fundos Mútuos de Privatização com recursos do Fundo de Garantia por Tempo de...',0,12033),
            ('Rendimentos auferidos pela carteira dos Fundos de Investimento Imobiliário','Rendimentos auferidos pela carteira dos Fundos de Investimento Imobiliário',0,12034),
            ('Rendimentos distribuídos pelo Fundo de Investimento Imobiliário aos seus cotistas','Rendimentos distribuídos pelo Fundo de Investimento Imobiliário aos seus cotistas',0,12035),
            ('Rendimento auferido pelo cotista no resgate de cotas na liquidação do Fundo de Investimento Imobiliário','Rendimento auferido pelo cotista no resgate de cotas na liquidação do Fundo de Investimento Imobiliário',0,12036),
            ('Rendimentos auferidos pela carteira dos Fundos de Investimento Imobiliário - Distribuição semestral','Rendimentos auferidos pela carteira dos Fundos de Investimento Imobiliário - Distribuição semestral',0,12037),
            ('Rendimentos distribuídos pelo Fundo de Investimento Imobiliário aos seus cotistas - - Distribuição semestral','Rendimentos distribuídos pelo Fundo de Investimento Imobiliário aos seus cotistas - - Distribuição semestral',0,12038),
            ('Rendimento auferido pelo cotista no resgate de cotas na liquidação do Fundo de Investimento Imobiliário - Distribuição semestral','Rendimento auferido pelo cotista no resgate de cotas na liquidação do Fundo de Investimento Imobiliário - Distribuiçã...',0,12039),
            ('Rendimentos e ganhos de capital distribuídos pelo Fundo de Investimento Cultural e Artístico (Ficart)','Rendimentos e ganhos de capital distribuídos pelo Fundo de Investimento Cultural e Artístico (Ficart)',0,12040),
            ('Rendimentos e ganhos de capital distribuídos pelo Fundo de Financiamento da Indústria Cinematográfica Nacional (Funcines)','Rendimentos e ganhos de capital distribuídos pelo Fundo de Financiamento da Indústria Cinematográfica Nacional (Funci...',0,12041),
            ('Rendimentos auferidos no resgate de quotas de fundos de investimento mantidos com recursos provenientes de conversão de débitos externos brasileiros, e de que participem, exclusivamente, residentes ou domiciliados no exterior','Rendimentos auferidos no resgate de quotas de fundos de investimento mantidos com recursos provenientes de conversão ...',0,12042),
            ('Ganho de capital decorrente da integralização de cotas de fundos ou clubes de investimento por meio da entrega de ativos financeiros','Ganho de capital decorrente da integralização de cotas de fundos ou clubes de investimento por meio daentrega de ati...',0,12043),
            ('Distribuição de Juros sobre o Capital Próprio pela companhia emissora de ações objeto de empréstimo','Distribuição de Juros sobre o Capital Próprio pela companhia emissora de ações objeto de empréstimo',0,12044),
            ('Rendimentos de Partes Beneficiárias ou de Fundador','Rendimentos de Partes Beneficiárias ou de Fundador',0,12045),
            ('Rendimentos auferidos em operações de swap','Rendimentos auferidos em operações de swap',0,12046),
            ('Rendimentos auferidos em operações day trade realizadas em bolsa de valores, de mercadorias, de futuros e assemelhadas','Rendimentos auferidos em operações day trade realizadas em bolsa de valores, de mercadorias, de futuros e assemelhada...',0,12047),
            ('Rendimento decorrente de Operação realizada em bolsas de valores, de mercadorias, de futuros, e assemelhadas, exceto day trade','Rendimento decorrente de Operação realizada em bolsas de valores, de mercadorias, de futuros, e assemelhadas, exceto ...',0,12048),
            ('Rendimento decorrente de Operação realizada no mercado de balcão, com intermediação, tendo por objeto ações, ouro ativo financeiro e outros valores mobiliários negociados no mercado à vista','Rendimento decorrente de Operação realizada no mercado de balcão, com intermediação, tendo por objeto ações, ouro ati...',0,12049),
            ('Rendimento decorrente de Operação realizada em mercados de liquidação futura fora de bolsa','Rendimento decorrente de Operação realizada em mercados de liquidação futura fora de bolsa',0,12050),
            ('Rendimentos de debêntures emitidas por sociedade de propósito específico conforme previsto no art. 2º da Lei nº 12.431 de 2011','Rendimentos de debêntures emitidas por sociedade de propósito específico conforme previsto no art. 2º da Lei nº 12.43...',0,12051),
            ('Juros sobre o Capital Próprio cujos beneficiários não estejam identificados no momento do registro contábil','Juros sobre o Capital Próprio cujos beneficiários não estejam identificados no momento do registro contábil',0,12052),
            ('Demais rendimentos de Capital','Demais rendimentos de Capital',0,12099),
            ('Rendimentos de Aforamento','Rendimentos de Aforamento',0,13001),
            ('Rendimentos de Aluguéis, Locação ou Sublocação','Rendimentos de Aluguéis, Locação ou Sublocação',0,13002),
            ('Rendimentos de Arrendamento ou Subarrendamento','Rendimentos de Arrendamento ou Subarrendamento',0,13003),
            ('Importâncias pagas por terceiros por conta do locador do bem (juros, comissões etc.)','Importâncias pagas por terceiros por conta do locador do bem (juros, comissões etc.)',0,13004),
            ('Importâncias pagas ao locador pelo contrato celebrado (luvas, prêmios etc.)','Importâncias pagas ao locador pelo contrato celebrado (luvas, prêmios etc.)',0,13005),
            ('Benfeitorias e quaisquer melhoramentos realizados no bem locado','Benfeitorias e quaisquer melhoramentos realizados no bem locado',0,13006),
            ('Juros decorrente da alienação a prazo de bens','Juros decorrente da alienação a prazo de bens',0,13007),
            ('Rendimentos de Direito de Uso ou Passagem de Terrenos e de aproveitamento de águas','Rendimentos de Direito de Uso ou Passagem de Terrenos e de aproveitamento de águas',0,13008),
            ('Rendimentos de Direito de colher ou extrair recursos vegetais, pesquisar e extrair recursos minerais','Rendimentos de Direito de colher ou extrair recursos vegetais, pesquisar e extrair recursos minerais',0,13009),
            ('Rendimentos de Direito Autoral','Rendimentos de Direito Autoral',0,13010),
            ('Rendimentos de Direito Autoral (quando não percebidos pelo autor ou criador da obra)','Rendimentos de Direito Autoral (quando não percebidos pelo autor ou criador da obra)',0,13011),
            ('Rendimentos de Direito de Imagem','Rendimentos de Direito de Imagem',0,13012),
            ('Rendimentos de Direito sobre películas cinematográficas, Obras Audiovisuais, e Videofônicas','Rendimentos de Direito sobre películas cinematográficas, Obras Audiovisuais, e Videofônicas',0,13013),
            ('Rendimento de Direito relativo a radiodifusão de sons e imagens e serviço de comunicação eletrônica de massa por assinatura','Rendimento de Direito relativo a radiodifusão de sons e imagens e serviço de comunicação eletrônica de massa por assi...',0,13014),
            ('Rendimentos de Direito de Conjuntos Industriais e Invenções','Rendimentos de Direito de Conjuntos Industriais e Invenções',0,13015),
            ('Rendimento de Direito de marcas de indústria e comércio, patentes de invenção e processo ou fórmulas de fabricação','Rendimento de Direito de marcas de indústria e comércio, patentes de invenção e processo ou fórmulas de fabricação',0,13016),
            ('Importâncias pagas por terceiros por conta do cedente dos direitos (juros, comissões etc.)','Importâncias pagas por terceiros por conta do cedente dos direitos (juros, comissões etc.)',0,13017),
            ('Importâncias pagas ao cedente do direito, pelo contrato celebrado (luvas, prêmios etc.)','Importâncias pagas ao cedente do direito, pelo contrato celebrado (luvas, prêmios etc.)',0,13018),
            ('Despesas para conservação dos direitos cedidos (quando compensadas pelo uso do bem ou direito)','Despesas para conservação dos direitos cedidos (quando compensadas pelo uso do bem ou direito)',0,13019),
            ('Juros de mora e quaisquer outras compensações pelo atraso no pagamento de royalties - decorrente de prestação de serviço','Juros de mora e quaisquer outras compensações pelo atraso no pagamento de royalties - decorrente de prestação de serv...',0,13020),
            ('Juros de mora e quaisquer outras compensações pelo atraso no pagamento de royalties - decorrente de aquisição de bens','Juros de mora e quaisquer outras compensações pelo atraso no pagamento de royalties - decorrente de aquisição de bens',0,13021),
            ('Juros decorrente da alienação a prazo de direitos - decorrente de prestação de serviço','Juros decorrente da alienação a prazo de direitos - decorrente de prestação de serviço',0,13022),
            ('Juros decorrente da alienação a prazo de direitos - decorrente de aquisição de bens','Juros decorrente da alienação a prazo de direitos - decorrente de aquisição de bens',0,13023),
            ('Alienação de bens e direitos do ativo não circulante localizados no Brasil','Alienação de bens e direitos do ativo não circulante localizados no Brasil',0,13024),
            ('Rendimento de Direito decorrente da transferência de atleta profissional','Rendimento de Direito decorrente da transferência de atleta profissional',0,13025),
            ('Juros e comissões correspondentes à parcela dos créditos de que trata o inciso XI do art. 1º da Lei nº 9.481, de 1997, não aplicada no financiamento de exportações','Juros e comissões correspondentes à parcela dos créditos de que trata o inciso XI do art. 1º da Lei nº 9.481, de 1997...',0,13026),
            ('Demais rendimentos de Royalties','Demais rendimentos de Royalties',0,13098),
            ('Demais rendimentos de Direito','Demais rendimentos de Direito',0,13099),
            ('Prêmios distribuídos, sob a forma de bens e serviços, mediante loterias, concursos e sorteios, exceto a distribuição realizada por meio de vale-brinde','Prêmios distribuídos, sob a forma de bens e serviços, mediante loterias, concursos e sorteios, exceto a distribuição ...',0,14001),
            ('Prêmios distribuídos, sob a forma de dinheiro, mediante loterias, concursos e sorteios, exceto os de antecipação nos títulos de capitalização e os de amortização e resgate das ações das sociedades anônimas','Prêmios distribuídos, sob a forma de dinheiro, mediante loterias, concursos e sorteios, exceto os de antecipação nos ...',0,14002),
            ('Prêmios de Proprietários e Criadores de Cavalos de Corrida','Prêmios de Proprietários e Criadores de Cavalos de Corrida',0,14003),
            ('Benefícios líquidos mediante sorteio de títulos de capitalização, sem amortização antecipada','Benefícios líquidos mediante sorteio de títulos de capitalização, sem amortização antecipada',0,14004),
            ('Benefícios líquidos resultantes da amortização antecipada, mediante sorteio, dos títulos de capitalização e benefícios atribuídos aos portadores de títulos de capitalização nos lucros da empresa emitente','Benefícios líquidos resultantes da amortização antecipada, mediante sorteio, dos títulos de capitalização e benefício...',0,14005),
            ('Prêmios distribuídos, sob a forma de bens e serviços, mediante sorteios de jogos de bingo permanente ou eventual','Prêmios distribuídos, sob a forma de bens e serviços, mediante sorteios de jogos de bingo permanente ou eventual',0,14006),
            ('Prêmios distribuídos, em dinheiro, obtido mediante sorteios de jogos de bingo permanente ou eventual','Prêmios distribuídos, em dinheiro, obtido mediante sorteios de jogos de bingo permanente ou eventual',0,14007),
            ('Importâncias correspondentes a multas e qualquer outra vantagem, ainda que a título de indenização, em virtude de rescisão de contrato','Importâncias correspondentes a multas e qualquer outra vantagem, ainda que a título de indenização, em virtude de res...',0,14008),
            ('Demais Benefícios Líquidos decorrentes de título de capitalização','Demais Benefícios Líquidos decorrentes de título de capitalização',0,14099),
            ('Importâncias pagas ou creditadas a cooperativas de trabalho relativas a serviços pessoais que lhes forem prestados por associados destas ou colocados à disposição','Importâncias pagas ou creditadas a cooperativas de trabalho relativas a serviços pessoais que lhes forem prestados po...',0,15001),
            ('Importâncias pagas ou creditadas a associações de profissionais ou assemelhadas, relativas a serviços pessoais que lhes forem prestados por associados destas ou colocados à disposição','Importâncias pagas ou creditadas a associações de profissionais ou assemelhadas, relativas a serviços pessoais que lh...',0,15002),
            ('Remuneração de Serviços de administração de bens ou negócios em geral, exceto consórcios ou fundos mútuos para aquisição de bens','Remuneração de Serviços de administração de bens ou negócios em geral, exceto consórcios ou fundos mútuos para aquisi...',0,15003),
            ('Remuneração de Serviços de advocacia','Remuneração de Serviços de advocacia',0,15004),
            ('Remuneração de Serviços de análise clínica laboratorial','Remuneração de Serviços de análise clínica laboratorial',0,15005),
            ('Remuneração de Serviços de análises técnicas','Remuneração de Serviços de análises técnicas',0,15006),
            ('Remuneração de Serviços de arquitetura','Remuneração de Serviços de arquitetura',0,15007),
            ('Remuneração de Serviços de assessoria e consultoria técnica, exceto serviço de assistência técnica prestado a terceiros e concernente a ramo de indústria ou comércio explorado pelo prestador do serviço','Remuneração de Serviços de assessoria e consultoria técnica, exceto serviço de assistência técnica prestado a terceir...',0,15008),
            ('Remuneração de Serviços de assistência social','Remuneração de Serviços de assistência social',0,15009),
            ('Remuneração de Serviços de auditoria','Remuneração de Serviços de auditoria',0,15010),
            ('Remuneração de Serviços de avaliação e perícia','Remuneração de Serviços de avaliação e perícia',0,15011),
            ('Remuneração de Serviços de biologia e biomedicina','Remuneração de Serviços de biologia e biomedicina',0,15012),
            ('Remuneração de Serviços de cálculo em geral','Remuneração de Serviços de cálculo em geral',0,15013),
            ('Remuneração de Serviços de consultoria','Remuneração de Serviços de consultoria',0,15014),
            ('Remuneração de Serviços de contabilidade','Remuneração de Serviços de contabilidade',0,15015),
            ('Remuneração de Serviços de desenho técnico','Remuneração de Serviços de desenho técnico',0,15016),
            ('Remuneração de Serviços de economia','Remuneração de Serviços de economia',0,15017),
            ('Remuneração de Serviços de elaboração de projetos','Remuneração de Serviços de elaboração de projetos',0,15018),
            ('Remuneração de Serviços de engenharia, exceto construção de estradas, pontes, prédios e obras assemelhadas','Remuneração de Serviços de engenharia, exceto construção de estradas, pontes, prédios e obras assemelhadas',0,15019),
            ('Remuneração de Serviços de ensino e treinamento','Remuneração de Serviços de ensino e treinamento',0,15020),
            ('Remuneração de Serviços de estatística','Remuneração de Serviços de estatística',0,15021),
            ('Remuneração de Serviços de fisioterapia','Remuneração de Serviços de fisioterapia',0,15022),
            ('Remuneração de Serviços de fonoaudiologia','Remuneração de Serviços de fonoaudiologia',0,15023),
            ('Remuneração de Serviços de geologia','Remuneração de Serviços de geologia',0,15024),
            ('Remuneração de Serviços de leilão','Remuneração de Serviços de leilão',0,15025),
            ('Remuneração de Serviços de medicina, exceto aquela prestada por ambulatório, banco de sangue, casa de saúde, casa de recuperação ou repouso sob orientação médica, hospital e pronto-socorro','Remuneração de Serviços de medicina, exceto aquela prestada por ambulatório, banco de sangue, casa de saúde, casa de ...',0,15026),
            ('Remuneração de Serviços de nutricionismo e dietética','Remuneração de Serviços de nutricionismo e dietética',0,15027),
            ('Remuneração de Serviços de odontologia','Remuneração de Serviços de odontologia',0,15028),
            ('Remuneração de Serviços de organização de feiras de amostras, congressos, seminários, simpósios e congêneres','Remuneração de Serviços de organização de feiras de amostras, congressos, seminários, simpósios e congêneres',0,15029),
            ('Remuneração de Serviços de pesquisa em geral','Remuneração de Serviços de pesquisa em geral',0,15030),
            ('Remuneração de Serviços de planejamento','Remuneração de Serviços de planejamento',0,15031),
            ('Remuneração de Serviços de programação','Remuneração de Serviços de programação',0,15032),
            ('Remuneração de Serviços de prótese','Remuneração de Serviços de prótese',0,15033),
            ('Remuneração de Serviços de psicologia e psicanálise','Remuneração de Serviços de psicologia e psicanálise',0,15034),
            ('Remuneração de Serviços de química','Remuneração de Serviços de química',0,15035),
            ('Remuneração de Serviços de radiologia e radioterapia','Remuneração de Serviços de radiologia e radioterapia',0,15036),
            ('Remuneração de Serviços de relações públicas','Remuneração de Serviços de relações públicas',0,15037),
            ('Remuneração de Serviços de serviço de despachante','Remuneração de Serviços de serviço de despachante',0,15038),
            ('Remuneração de Serviços de terapêutica ocupacional','Remuneração de Serviços de terapêutica ocupacional',0,15039),
            ('Remuneração de Serviços de tradução ou interpretação comercial','Remuneração de Serviços de tradução ou interpretação comercial',0,15040),
            ('Remuneração de Serviços de urbanismo','Remuneração de Serviços de urbanismo',0,15041),
            ('Remuneração de Serviços de veterinária','Remuneração de Serviços de veterinária',0,15042),
            ('Remuneração de Serviços de Limpeza','Remuneração de Serviços de Limpeza',0,15043),
            ('Remuneração de Serviços de Conservação/ Manutenção, exceto reformas e obras assemelhadas','Remuneração de Serviços de Conservação/ Manutenção, exceto reformas e obras assemelhadas',0,15044),
            ('Remuneração de Serviços de Segurança/Vigilância/Transporte de valores','Remuneração de Serviços de Segurança/Vigilância/Transporte de valores',0,15045),
            ('Remuneração de Serviços Locação de Mão de obra','Remuneração de Serviços Locação de Mão de obra',0,15046),
            ('Remuneração de Serviços de Assessoria Creditícia, Mercadológica, Gestão de Crédito, Seleção e Riscos e Administração de Contas a Pagar e a Receber','Remuneração de Serviços de Assessoria Creditícia, Mercadológica, Gestão de Crédito, Seleção e Riscos e Administração ...',0,15047),
            ('Pagamentos Referentes à Aquisição de Autopeças','Pagamentos Referentes à Aquisição de Autopeças',0,15048),
            ('Pagamentos a entidades imunes ou isentas - IN RFB 1.234/2012','Pagamentos a entidades imunes ou isentas - IN RFB 1.234/2012',0,15049),
            ('Pagamento a título de transporte internacional de valores efetuado por empresas nacionais estaleiros navais brasileiros nas atividades de conservação, modernização, conversão e reparo de embarcações pré-registradas ou registradas no Registro Especial Brasileiro (REB)','Pagamento a título de transporte internacional de valores efetuado por empresas nacionais estaleiros navais brasileir...',0,15050),
            ('Pagamento efetuado a empresas estrangeiras de transporte de valores','Pagamento efetuado a empresas estrangeiras de transporte de valores',0,15051),
            ('Demais comissões, corretagens, ou qualquer outra importância paga/creditada pela representação comercial ou pela mediação na realização de negócios civis e comerciais, que não se enquadrem nas situações listadas nos códigos do grupo 20','Demais comissões, corretagens, ou qualquer outra importância paga/creditada pela representação comercial ou pela medi...',0,15052),
            ('Demais rendimentos de serviços técnicos, de assistência técnica, de assistência administrativa e semelhantes','Demais rendimentos de serviços técnicos, de assistência técnica, de assistência administrativa e semelhantes',0,15099),
            ('Rendimentos de serviços técnicos, de assistência técnica, de assistência administrativa e semelhantes','Rendimentos de serviços técnicos, de assistência técnica, de assistência administrativa e semelhantes',0,16001),
            ('Demais rendimentos de juros e comissões','Demais rendimentos de juros e comissões',0,16002),
            ('Rendimento pago a companhia de navegação aérea e marítima','Rendimento pago a companhia de navegação aérea e marítima',0,16003),
            ('Rendimento de Direito relativo a exploração de obras audiovisuais estrangeiras, radiodifusão de sons e imagens e serviço de comunicação eletrônica de massa por assinatura','Rendimento de Direito relativo a exploração de obras audiovisuais estrangeiras, radiodifusão de sons e imagens e serv...',0,16004),
            ('Demais Rendimentos de qualquer natureza','Demais Rendimentos de qualquer natureza',0,16005),
            ('Demais Rendimentos sujeitos à Alíquota Zero','Demais Rendimentos sujeitos à Alíquota Zero',0,16006),
            ('Fornecimento de bens, nos termos do art. 33 da Lei nº 10.833, de 2003','Fornecimento de bens, nos termos do art. 33 da Lei nº 10.833, de 2003',0,18001),
            ('Prestação de serviços em geral, nos termos do art. 33 da Lei nº 10.833, de 2003','Prestação de serviços em geral, nos termos do art. 33 da Lei nº 10.833, de 2003',0,18002),
            ('Transporte internacional de cargas ou de passageiros efetuados por empresas nacionais, aos estaleiros navais brasileiros e na aquisição de produtos isentos ou com Alíquota zero da Cofins e Pis/Pasep, conforme art. 4º, da IN SRF nº 475 de 2004.','Transporte internacional de cargas ou de passageiros efetuados por empresas nacionais, aos estaleiros navais brasilei...',0,18003),
            ('Pagamentos efetuados às cooperativas, em relação aos atos cooperativos, conforme art. 5º, da IN SRF nº 475 de 2004.','Pagamentos efetuados às cooperativas, em relação aos atos cooperativos, conforme art. 5º, da IN SRF nº 475 de 2004.',0,18004),
            ('Aquisição de imóvel pertencente a ativo permanente da empresa vendedora, conforme art. 19, II, da IN SRF nº 475 de 2004.','Aquisição de imóvel pertencente a ativo permanente da empresa vendedora, conforme art. 19, II, da IN SRF nº 475 de 20...',0,18005),
            ('Pagamentos efetuados às sociedades cooperativas, pelo fornecimento de bens ou serviços, conforme art. 24, II, da IN SRF nº 475 de 2004.','Pagamentos efetuados às sociedades cooperativas, pelo fornecimento de bens ou serviços, conforme art. 24, II, da IN S...',0,18006),
            ('Pagamentos efetuados à sociedade cooperativa de produção, em relação aos atos decorrentes da comercialização ou industrialização de produtos de seus associados, conforme art. 25, da IN SRF nº 475 de 2004.','Pagamentos efetuados à sociedade cooperativa de produção, em relação aos atos decorrentes da comercialização ou indus...',0,18007),
            ('Pagamentos efetuados às cooperativas de trabalho, pela prestação de serviços pessoais prestados pelos cooperados, nos termos do art. 26, da IN SRF nº 475 de 2004.','Pagamentos efetuados às cooperativas de trabalho, pela prestação de serviços pessoais prestados pelos cooperados, nos...',0,18008),
            ('Pagamento de remuneração indireta a Beneficiário não identificado','Pagamento de remuneração indireta a Beneficiário não identificado',0,19001),
            ('Pagamento a Beneficiário não identificado','Pagamento a Beneficiário não identificado',0,19009),
            ('Rendimento de Serviços de propaganda e publicidade','Rendimento de Serviços de propaganda e publicidade',0,20001),
            ('Importâncias a título de comissões e corretagens relativas a colocação ou negociação de títulos de renda fixa','Importâncias a título de comissões e corretagens relativas a colocação ou negociação de títulos de renda fixa',0,20002),
            ('Importâncias a título de comissões e corretagens relativas a operações realizadas em Bolsas de Valores e em Bolsas de Mercadorias','Importâncias a título de comissões e corretagens relativas a operações realizadas em Bolsas de Valores e em Bolsas d...',0,20003),
            ('Importâncias a título de comissões e corretagens relativas a distribuição de emissão de valores mobiliários, quando a pessoa jurídica atuar como agente da companhia emissora','Importâncias a título de comissões e corretagens relativas a distribuição de emissão de valores mobiliários, quando a...',0,20004),
            ('Importâncias a título de comissões e corretagens relativas a operações de câmbio','Importâncias a título de comissões e corretagens relativas a operações de câmbio',0,20005),
            ('Importâncias a título de comissões e corretagens relativas a vendas de passagens, excursões ou viagens','Importâncias a título de comissões e corretagens relativas a vendas de passagens, excursões ou viagens',0,20006),
            ('Importâncias a título de comissões e corretagens relativas a administração de cartões de crédito','Importâncias a título de comissões e corretagens relativas a administração de cartões de crédito',0,20007),
            ('Importâncias a título de comissões e corretagens relativas a prestação de serviços de distribuição de refeições pelo sistema de refeições-convênio','Importâncias a título de comissões e corretagens relativas a prestação de serviços de distribuição de refeições pelo ...',0,20008),
            ('Importâncias a título de comissões e corretagens relativas a prestação de serviço de administração de convênios','Importâncias a título de comissões e corretagens relativas a prestação de serviço de administração de convênios',0,20009);
            

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function criaTabelaPagordemreinf(){
        $sql="
        BEGIN;

        CREATE TABLE IF NOT EXISTS empenho.pagordemreinf
        (
            e102_codord int4 NOT NULL,	
            e102_numcgm int4 NOT NULL,
            e102_vlrbruto float8 NOT NULL DEFAULT 0,
            e102_vlrbase float8 NOT NULL DEFAULT 0,
            e102_vlrir float8 NOT NULL DEFAULT 0
        );
        
        INSERT INTO db_sysarquivo VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'pagordemreinf', 'Tabela de Retenção Realizada por Terceiro', 'e102', CURRENT_DATE, 'Retenção Realizada por Terceiro', 0, 'f', 'f', 'f', 'f' );
        INSERT INTO db_sysarqmod VALUES (38,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'));
        
        INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
        VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e102_codord' ,'int4' ,'Ordem de Pagamento' ,'0' ,'Ordem de Pagamento' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Ordem de Pagamento' );
        INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
        VALUES (
        (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),
        (SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_codord'),1 ,0 );
        
        INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
        VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e102_numcgm' ,'int4' ,'Num. CGM' ,'0' ,'Num. CGM' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Num. CGM' );
        INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
        VALUES (
        (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),
        (SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_numcgm'),1 ,0 );
        
        INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
        VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e102_vlrbruto' ,'float8' ,'Valor Bruto' ,'' ,'Valor Bruto' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Bruto' );
        INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
        VALUES (
        (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),
        (SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbruto'),4 ,0 );
        
        INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
        VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e102_vlrbase' ,'float8' ,'Valor Base' ,'' ,'Valor Base' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor Base' );
        INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
        VALUES (
        (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),
        (SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrbase'),4 ,0 );
        
        INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
        VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e102_vlrir' ,'float8' ,'Valor IR' ,'' ,'Valor IR' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Valor IR' );
        INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
        VALUES (
        (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf'),
        (SELECT codcam FROM db_syscampo WHERE nomecam = 'e102_vlrir'),4 ,0 );

        COMMIT;
        ";

        $this->execute($sql);
    }

    public function insereNovosCamposPagordem(){
        $sql="
            BEGIN;

            ALTER TABLE pagordem ADD COLUMN e50_retencaoir bool;
            ALTER TABLE pagordem ADD COLUMN e50_naturezabemservico int4;

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql="
            BEGIN;

            DELETE FROM db_syssequencia WHERE nomesequencia = 'naturezabemservico_e101_sequencial_seq';

            DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_syscampo WHERE nomecam like 'e101_%';

            DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_sysarquivo WHERE nomearq = 'naturezabemservico';

            DROP TABLE IF EXISTS empenho.naturezabemservico;


            DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf');

            DELETE FROM db_syscampo WHERE nomecam like 'e102_%';

            DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf');

            DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'pagordemreinf');

            DELETE FROM db_sysarquivo WHERE nomearq = 'pagordemreinf';

            DROP TABLE IF EXISTS empenho.pagordemreinf;


            ALTER TABLE pagordem DROP COLUMN e50_retencaoir;
            ALTER TABLE pagordem DROP COLUMN e50_naturezabemservico;

            COMMIT;
        ";

        $this->execute($sql);
    }
}
