<?php

use Phinx\Migration\AbstractMigration;

class Oc17435 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO
          avaliacaogrupopergunta (
            db102_sequencial,
            db102_avaliacao,
            db102_descricao,
            db102_identificador,
            db102_identificadorcampo,
            db102_ordem
          )
        VALUES
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'COMPUTADORES', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'Escola cede espaço para turmas do Brasil Alfabetiz', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'FORMA DE OCUPAPAÇÃO DO PRÉDIO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ESGOTO SANITÁRIO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'INFRA-ESTRUTURA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'Escola abre aos finais de semana para a comunidade', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'MATERIAIS DIDÁTICOS ESPECÍFICOS', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'EQUIPAMENTOS EXISTENTES', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'DESTINAÇÃO DO LIXO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ABASTECIMENTO DE ÁGUA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ABASTECIMENTO DE ENERGIA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'PREDIO COMPARTILHADO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'OUTRAS INFORMAÇÕES', NULL, NULL, 0);

        INSERT INTO
          avaliacaopergunta (
            db103_sequencial,
            db103_avaliacaotiporesposta,
            db103_avaliacaogrupopergunta,
            db103_descricao,
            db103_obrigatoria,
            db103_ativo,
            db103_ordem,
            db103_identificador,
            db103_tipo,
            db103_mascara,
            db103_dblayoutcampo,
            db103_perguntaidentificadora,
            db103_camposql,
            db103_identificadorcampo
          )
        VALUES
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola cede espaço para turmas do Brasil Alfabetiz'), 'Escola cede espaço para turmas do Brasil Alfabetizado', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola abre aos finais de semana para a comunidade'), 'Escola abre aos finais de semana para a comunidade', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'FORMA DE OCUPAÇÃO DO PRÉDIO'), 'Forma de Ocupação do Prédio:', TRUE, TRUE, 9, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ESGOTO SANITÁRIO'), 'Esgoto Sanitario:', TRUE, TRUE, 10, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'MATERIAIS DIDÁTICOS ESPECÍFICOS'), 'Materais Didáticos Específicos:', TRUE, TRUE, 11, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'EQUIPAMENTOS EXISTENTES'), 'Equipamentos Existentes:', TRUE, TRUE, 12, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'DESTINAÇÃO DO LIXO'), 'Destinação do Lixo:', TRUE, TRUE, 13, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ÁGUA'), 'Abastecimento de Água', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ENERGIA'), 'Abastecimento de Energia:', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Possui computadores:', TRUE, TRUE, 2, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Acesso à Internet:', TRUE, TRUE, 6, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Banda Larga:', TRUE, TRUE, 7, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Local de Funcionamento:', TRUE, TRUE, 8, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Dependências Existentes na Escola', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Predio Compartilhado', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 1', TRUE, TRUE, 2, 'PredioCompartilhadoInep1', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 2', TRUE, TRUE, 3, 'PredioCompartilhadoInep2', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 3', TRUE, TRUE, 4, 'PredioCompartilhadoInep3', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 4', TRUE, TRUE, 5, 'PredioCompartilhadoInep4', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 5', TRUE, TRUE, 6, 'PredioCompartilhadoInep5', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Código INEP do prédio compartilhado 6', TRUE, TRUE, 7, 'PredioCompartilhadoInep6', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Água consumida pelos Alunos:', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Alimentação Escolar para os Alunos', TRUE, TRUE, 2, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'N° de Sala de Aula Existentes na Escola:', TRUE, TRUE, 3, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'N° de Salas Utilizadas como Sala de Aula:', TRUE, TRUE, 4, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Atividade Complementar', TRUE, TRUE, 5, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Atendimento Educ. Especializado AEE:', TRUE, TRUE, 6, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Ensino Fundamental em ciclos:', TRUE, TRUE, 7, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'), 'Escola com proposta pedagogica de formação por alternância', TRUE, TRUE, 8, 'EscolaFormacaoAlternancia', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'COMPUTADORES'), 'Qtde. de Computadores Uso de Alunos:', TRUE, TRUE, 5, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'COMPUTADORES'), 'Qtde. de Computadores Uso Administrativo:', TRUE, TRUE, 4, NULL, 1, NULL, NULL, FALSE, NULL, NULL);

        INSERT INTO
          avaliacaoperguntaopcao (
            db104_sequencial,
            db104_avaliacaopergunta,
            db104_descricao,
            db104_aceitatexto,
            db104_identificador,
            db104_peso,
            db104_valorresposta,
            db104_identificadorcampo
          )
        VALUES
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espaço para turmas do Brasil Alfabetizado'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espaço para turmas do Brasil Alfabetizado'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupação do Prédio:'), 'Próprio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupação do Prédio:'), 'Alugado', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupação do Prédio:'), 'Cedido', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Rede Pública', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Fossa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Didáticos Específicos:'), 'Não Utiliza', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Didáticos Específicos:'), 'Quilombola', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Didáticos Específicos:'), 'Indígena', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Aparelho de Televisão', TRUE, 'aparelho_televisao', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Videocassete', TRUE, 'videocassete', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'DVD', TRUE, 'dvd', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Antena Parabólica', TRUE, 'antena_parabolica', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Copiadora', TRUE, 'copiadora', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Retroprojetor', TRUE, 'retroprojetor', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Fax', TRUE, 'fax', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Máquina Fotográfica/Filmadora', TRUE, 'maquina_fotografica', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Impressora', TRUE, 'impressora', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Aparelho de som', TRUE, 'aparelho_som', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Projetor Multimídia (Data show)', TRUE, 'projetor_multimidia', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Computadores', TRUE, 'equipamentos_computadores', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Impressora Multifuncional', TRUE, 'equipamentos_impressora_multifuncional', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Coleta Periódica', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Queima', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Joga em outra área', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Recicla', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Enterra', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'), 'Outros', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'), 'Rede Pública', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'), 'Poço Artesiano', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'), 'Cacimba/Cisterna/Poço', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'), 'Fonte/Rio/Igarapé/Riacho', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Rede Pública', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Gerador', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Outros(Enegria Alternativa)', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso à Internet:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso à Internet:'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'), 'Possui', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'), 'Não Possui', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Prédio Escolar', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Templo / Igreja', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Salas de Empresa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Casa do Professor', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Salas em Outra Escola', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Galpão / Rancho / Paiol', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'OUTROS', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Unidade de Internação', FALSE, 'LocalFuncionamentoUnidadeInternacao', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Unidade Prisional', FALSE, 'LocalFuncionamentoUnidadePrisional', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Cozinha', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Biblioteca', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Bercário', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Banheiro com chuveiro', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Refeitótio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Despensa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Almoxarifado', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Auditório', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Alojamento de aluno', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Alojamento de professor', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Área verde', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Lavanderia', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Pátio coberto', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Banheiro adequado a alunos com deficiência ou mobilidade reduzida', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Banheiro adequado à educação infantil', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Banheiro dentro do prédio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Banheiro fora do prédio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Dependências e vias adequadas a alunos com deficiência ou mobilidade reduzida', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Laboratório de ciências', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Parque infantil', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Pátio descoberto', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Quadra de esportes coberta', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Quadra de esportes descoberta', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Sala de diretoria', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Sala de leitura', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Sala de professores', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Sala de recursos multifuncionais para Atendimento Educacional Especializado (AEE)', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Sala de secretaria', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'), 'Nenhuma das dependências relacionadas', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 1'), NULL, TRUE, 'PredioCompartilhadoInep1_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 2'), NULL, TRUE, 'PredioCompartilhadoInep2_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 3'), NULL, TRUE, 'PredioCompartilhadoInep3_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 4'), NULL, TRUE, 'PredioCompartilhadoInep4_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 5'), NULL, TRUE, 'PredioCompartilhadoInep5_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 6'), NULL, TRUE, 'PredioCompartilhadoInep6_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Água consumida pelos Alunos:'), 'NÃO FILTRADA', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Água consumida pelos Alunos:'), 'FILTRADA', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Alimentação Escolar para os Alunos'), 'OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N° de Sala de Aula Existentes na Escola:'), NULL, TRUE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N° de Salas Utilizadas como Sala de Aula:'), NULL, TRUE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'NÃO EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'NÃO OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'NÃO EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'NÃO OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'), 'NÃO', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de formação por alternância'), 'SIM', FALSE, 'PossuiFormacaoPorAlternancia', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de formação por alternância'), 'NÃO', FALSE, 'NaoPossuiFormacaoPorAlternancia', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso de Alunos:'), NULL, TRUE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso Administrativo:'), NULL, TRUE, NULL, NULL, NULL, NULL);
        COMMIT;
SQL;
        $this->execute($sql);

    }

    public  function down()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();

        DELETE FROM avaliacaoperguntaopcao
        WHERE db104_avaliacaopergunta IN (
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espaço para turmas do Brasil Alfabetizado'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupação do Prédio:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Didáticos Específicos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destinação do Lixo:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Água'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso à Internet:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Dependências Existentes na Escola'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 1'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 2'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 3'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 4'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 5'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Código INEP do prédio compartilhado 6'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Água consumida pelos Alunos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Alimentação Escolar para os Alunos'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N° de Sala de Aula Existentes na Escola:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N° de Salas Utilizadas como Sala de Aula:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de formação por alternância'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso de Alunos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso Administrativo:')
        );

        DELETE FROM avaliacaopergunta
        WHERE db103_avaliacaogrupopergunta IN (
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola cede espaço para turmas do Brasil Alfabetiz'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola abre aos finais de semana para a comunidade'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'FORMA DE OCUPAÇÃO DO PRÉDIO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ESGOTO SANITÁRIO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'MATERIAIS DIDÁTICOS ESPECÍFICOS'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'EQUIPAMENTOS EXISTENTES'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'DESTINAÇÃO DO LIXO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ÁGUA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ENERGIA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMAÇÕES'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'COMPUTADORES')
        );

        DELETE FROM avaliacaogrupopergunta
        WHERE db102_avaliacao = 3000000;

        COMMIT;
SQL;
        $this->execute($sql);
    }
}
