<?php

use Phinx\Migration\AbstractMigration;

class oc20870 extends AbstractMigration
{

    public function up(){
        $this->criaItensMenu();
        $this->criaTabelaNaturezaBemServico();
        $this->insereControleDaNovaTabela();
        $this->insereRegistrosIniciais();
    }
    
    public function criaItensMenu(){
        $sql = " 
            BEGIN;

            --Cria itens do menu
            INSERT INTO db_itensmenu 
            VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Natureza de Bem ou Serviço', 'Cadastro de Natureza de Bem ou Serviço', '', 1, 1, 'Cadastro de Natureza de Bem ou Serviço', 't');
            
            INSERT INTO db_itensmenu 
            VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclusão', 'Inclusão de naturezabemserviço', 'emp1_naturezabemservico001.php', 1, 1, 'Inclusão de naturezabemserviço', 't');
            
            INSERT INTO db_itensmenu 
            VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Alteração', 'Alteração de naturezabemserviço', 'emp1_naturezabemservico002.php', 1, 1, 'Alteração de naturezabemserviço', 't');
            
            INSERT INTO db_itensmenu 
            VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', 'Exclusão de naturezabemserviço', 'emp1_naturezabemservico003.php', 1, 1, 'Exclusão de naturezabemserviço', 't');

            --Registra ninho do menu
            INSERT INTO db_menu VALUES (29, (SELECT id_item FROM db_itensmenu WHERE help = 'Cadastro de Natureza de Bem ou Serviço'), ((SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 29) ), 398);

            INSERT INTO db_menu 
            VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Natureza de Bem ou Serviço'), (SELECT id_item FROM db_itensmenu WHERE help = 'Inclusão de naturezabemserviço'), 1, 398);
            
            INSERT INTO db_menu 
            VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Natureza de Bem ou Serviço'), (SELECT id_item FROM db_itensmenu WHERE help = 'Alteração de naturezabemserviço'), 2, 398);
            
            INSERT INTO db_menu 
            VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Natureza de Bem ou Serviço'), (SELECT id_item FROM db_itensmenu WHERE help = 'Exclusão de naturezabemserviço'), 3, 398);

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function criaTabelaNaturezaBemServico(){
        $sql="
            BEGIN;

            CREATE TABLE IF NOT EXISTS empenho.naturezabemservico
            (
                e101_sequencial SERIAL,
                e101_descr text not null,
                e101_resumo varchar(120) not null,
                e101_aliquota float8 not null default 0
            );

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function insereControleDaNovaTabela(){
        $sql="
            BEGIN;
            
            --Cria registros da tabela naturezabemservico e de seus campos
            INSERT INTO db_sysarquivo 
            VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'naturezabemservico', 'Tabela de Natureza de Bem ou Serviço', 'e101', CURRENT_DATE, 'Natureza de Bem ou Servico', 0, 'f', 'f', 'f', 'f' );
            
            INSERT INTO db_sysarqmod 
            VALUES (38,(SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'));

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e101_sequencial' ,'int4' ,'Sequencial' ,'0' ,'Sequencial' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Sequencial' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_sequencial'),1 ,0 );

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e101_descr' ,'varchar' ,'Descrição da Natureza de Bem ou Serviço' ,'' ,'Descrição' ,9999 ,'false' ,'false' ,'false' ,0 ,'text' ,'Descrição' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_descr'),2 ,0 );

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e101_resumo' ,'varchar' ,'Resumo da descrição da Natureza de Bem ou Serviço' ,'' ,'Resumo da descrição' ,120,'false' ,'false' ,'false' ,0 ,'text' ,'Resumo da descrição' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_resumo'),3 ,0 );

            INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
            VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e101_aliquota' ,'float8' ,'Aliquota' ,'' ,'Alíquota' ,15 ,'false' ,'false' ,'false' ,4 ,'text' ,'Alíquota' );
            
            INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
            VALUES (
            (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_aliquota'),4 ,0 );

            INSERT INTO db_syssequencia VALUES((SELECT max(codsequencia) + 1 FROM db_syssequencia), 'naturezabemservico_e101_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
            UPDATE db_sysarqcamp SET codsequencia = (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'naturezabemservico_e101_sequencial_seq') WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico') and codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'e101_sequencial');

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function insereRegistrosIniciais(){
        $sql="
            BEGIN;

            INSERT INTO empenho.naturezabemservico (e101_descr, e101_resumo,e101_aliquota) 
            VALUES
            ('Alimentação','Alimentação','1.2'), 
            ('Energia elétrica','Energia elétrica','1.2'), 
            ('Serviços prestados com emprego de materiais','Serviços prestados com emprego de materiais','1.2'),
            ('Construção Civil por empreitada com emprego de materiais','Construção Civil por empreitada com emprego de materiais','1.2'),
            ('Serviços hospitalares de que trata o art. 30','Serviços hospitalares de que trata o art. 30','1.2'),
            ('Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medicina nuclear e análises e patologias clínicas de que trata o art. 31.','Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medi...','1.2'),
            ('Transporte de cargas, exceto os relacionados no código 8767','Transporte de cargas, exceto os relacionados no código 8767','1.2'),
            ('Produtos farmacêuticos, de perfumaria, de toucador ou de higiene pessoal adquiridos de produtor, importador, distribuidor ou varejista, exceto os relacionados no código 8767 e','Produtos farmacêuticos, de perfumaria, de toucador ou de higiene pessoal adquiridos de produtor, importador, distribu...','1.2'),
            ('Mercadorias e bens em geral.','Mercadorias e bens em geral.','1.2'),
            ('Gasolina, inclusive de aviação, óleo diesel, gás liquefeito de petróleo (GLP), combustíveis derivados de petróleo ou de gás natural, querosene de aviação (QAV), e demais produtos derivados de petróleo, adquiridos de refinarias de petróleo, de demais produtores, de importadores, de distribuidor ou varejista, pelos órgãos da administração pública de que trata o caput do art. 19','Gasolina, inclusive de aviação, óleo diesel, gás liquefeito de petróleo (GLP), combustíveis derivados de petróleo ou ...','0.24'),
            ('Álcool etílico hidratado, inclusive para fins carburantes, adquirido diretamente de produtor, importador ou distribuidor de que trata o art. 20','Álcool etílico hidratado, inclusive para fins carburantes, adquirido diretamente de produtor, importador ou distribui...','0.24'),
            ('Biodiesel adquirido de produtor ou importador, de que trata o art. 21.','Biodiesel adquirido de produtor ou importador, de que trata o art. 21.','0.24'),
            ('Gasolina, exceto gasolina de aviação, óleo diesel, gás liquefeito de petróleo (GLP), derivados de petróleo ou de gás natural e querosene de aviação adquiridos de dis- tribuidores e comerciantes varejistas','Gasolina, exceto gasolina de aviação, óleo diesel, gás liquefeito de petróleo (GLP), derivados de petróleo ou de gás ...','0.24'),
            ('Álcool etílico hidratado nacional, inclusive para fins carburantes adquirido de comerciante varejista','Álcool etílico hidratado nacional, inclusive para fins carburantes adquirido de comerciante varejista','0.24'),
            ('Biodiesel adquirido de distribuidores e comerciantes varejistas','Biodiesel adquirido de distribuidores e comerciantes varejistas','0.24'),
            ('Biodiesel adquirido de produtor detentor regular do selo Combustível Social, fabricado a partir de mamona ou fruto, caroço ou amêndoa de palma produzidos nas regiões norte e nordeste e no semiárido, por agricultor familiar enquadrado no Programa Nacional de Fortalecimento da Agricultura Familiar (Pronaf).','Biodiesel adquirido de produtor detentor regular do selo Combustível Social, fabricado a partir de mamona ou fruto, c...','0.24'),
            ('Transporte internacional de cargas efetuado por empresas nacionais','Transporte internacional de cargas efetuado por empresas nacionais','1.2'),
            ('Estaleiros navais brasileiros nas atividades de construção, conservação, modernização, conversão e reparo de embarcações pré-registradas ou registradas no Registro Especial Brasileiro (REB), instituído pela Lei nº 9.432, de 8 de janeiro de 1997','Estaleiros navais brasileiros nas atividades de construção, conservação, modernização, conversão e reparo de embarcaç...','1.2'),
            ('Produtos farmacêuticos, de perfumaria, de toucador e de higiene pessoal a que se refere o § 1º do art. 22 , adquiridos de distribuidores e de comerciantes varejistas','Produtos farmacêuticos, de perfumaria, de toucador e de higiene pessoal a que se refere o § 1º do art. 22 , adquirido...','1.2'),
            ('Produtos a que se refere o § 2º do art. 22','Produtos a que se refere o § 2º do art. 22','1.2'),
            ('Produtos de que tratam as alíneas \'c\' a \'k\' do inciso I do art. 5º','Produtos de que tratam as alíneas \'c\' a \'k\' do inciso I do art. 5º','1.2'),
            ('Outros produtos ou serviços beneficiados com isenção, não incidência ou alíquotas zero da Cofins e da Contribuição para o PIS/Pasep, observado o disposto no § 5º do art. 2º.','Outros produtos ou serviços beneficiados com isenção, não incidência ou alíquotas zero da Cofins e da Contribuição pa...','1.2'),
            ('Passagens aéreas, rodoviárias e demais serviços de transporte de passageiros, inclusive, tarifa de embarque, exceto as relacionadas no código 8850.','Passagens aéreas, rodoviárias e demais serviços de transporte de passageiros, inclusive, tarifa de embarque, exceto a...','2.40'),
            ('Transporte internacional de passageiros efetuado por empresas nacionais.','Transporte internacional de passageiros efetuado por empresas nacionais.','2.40'),
            ('Serviços prestados por associações profissionais ou assemelhadas e cooperativas.','Serviços prestados por associações profissionais ou assemelhadas e cooperativas.','0'),
            ('Serviços prestados por bancos comerciais, bancos de investimento, bancos de desenvolvimento, caixas econômicas, sociedades de crédito, financiamento e investimento, sociedades de crédito imobiliário, e câmbio, distribuidoras de títulos e valores mobiliários, empresas de arrendamento mercantil, cooperativas de crédito, empresas de seguros privados e de capitalização e entidades abertas de previdência complementar','Serviços prestados por bancos comerciais, bancos de investimento, bancos de desenvolvimento, caixas econômicas, socie...','2.40'),
            ('Seguro saúde.','Seguro saúde.','2.40'),
            ('Serviços de abastecimento de água','Serviços de abastecimento de água','4.80'),
            ('Telefone','Telefone','4.80'),
            ('Correio e telégrafos','Correio e telégrafos','4.80'),
            ('Vigilância','Vigilância','4.80'),
            ('Limpeza','Limpeza','4.80'),
            ('Locação de mão de obra','Locação de mão de obra','4.80'),
            ('Intermediação de negócios','Intermediação de negócios','4.80'),
            ('Administração, locação ou cessão de bens imóveis, móveis e direitos de qualquer natureza','Administração, locação ou cessão de bens imóveis, móveis e direitos de qualquer natureza','4.80'),
            ('Factoring','Factoring','4.80'),
            ('Plano de saúde humano, veterinário ou odontológico com valores fixos por servidor, por empregado ou por animal','Plano de saúde humano, veterinário ou odontológico com valores fixos por servidor, por empregado ou por animal','4.80'),
            ('Demais serviços','Demais serviços','4.80');

            COMMIT;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql="
            BEGIN;

            DELETE FROM db_syssequencia WHERE nomesequencia = 'naturezabemservico_e101_sequencial_seq';

            DELETE FROM db_sysarqcamp WHERE codarq = (select codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_syscampo WHERE nomecam like 'e101_%';

            DELETE FROM db_sysarqmod WHERE codarq = (select codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_acount WHERE codarq = (select codarq FROM db_sysarquivo WHERE nomearq = 'naturezabemservico');

            DELETE FROM db_sysarquivo WHERE nomearq = 'naturezabemservico';

            DROP TABLE IF EXISTS empenho.naturezabemservico;

            DELETE FROM db_menu WHERE id_item = (select id_item FROM db_itensmenu WHERE descricao = 'Natureza de Bem ou Serviço');

            DELETE FROM db_itensmenu WHERE desctec = 'Cadastro de Natureza de Bem ou Serviço';
            DELETE FROM db_itensmenu WHERE desctec = 'Inclusão de naturezabemserviço';
            DELETE FROM db_itensmenu WHERE desctec = 'Alteração de naturezabemserviço';
            DELETE FROM db_itensmenu WHERE desctec = 'Exclusão de naturezabemserviço';

            COMMIT;
        ";

        $this->execute($sql);
    }
}
