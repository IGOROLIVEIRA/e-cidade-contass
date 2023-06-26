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
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'Escola cede espa�o para turmas do Brasil Alfabetiz', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'FORMA DE OCUPAPA��O DO PR�DIO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ESGOTO SANIT�RIO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'INFRA-ESTRUTURA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'Escola abre aos finais de semana para a comunidade', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'MATERIAIS DID�TICOS ESPEC�FICOS', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'EQUIPAMENTOS EXISTENTES', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'DESTINA��O DO LIXO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ABASTECIMENTO DE �GUA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'ABASTECIMENTO DE ENERGIA', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'PREDIO COMPARTILHADO', NULL, NULL, 0),
          (nextval('avaliacaogrupopergunta_db102_sequencial_seq'), 3000000, 'OUTRAS INFORMA��ES', NULL, NULL, 0);

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
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola cede espa�o para turmas do Brasil Alfabetiz'), 'Escola cede espa�o para turmas do Brasil Alfabetizado', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola abre aos finais de semana para a comunidade'), 'Escola abre aos finais de semana para a comunidade', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'FORMA DE OCUPA��O DO PR�DIO'), 'Forma de Ocupa��o do Pr�dio:', TRUE, TRUE, 9, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ESGOTO SANIT�RIO'), 'Esgoto Sanitario:', TRUE, TRUE, 10, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'MATERIAIS DID�TICOS ESPEC�FICOS'), 'Materais Did�ticos Espec�ficos:', TRUE, TRUE, 11, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'EQUIPAMENTOS EXISTENTES'), 'Equipamentos Existentes:', TRUE, TRUE, 12, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'DESTINA��O DO LIXO'), 'Destina��o do Lixo:', TRUE, TRUE, 13, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE �GUA'), 'Abastecimento de �gua', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ENERGIA'), 'Abastecimento de Energia:', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Possui computadores:', TRUE, TRUE, 2, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Acesso � Internet:', TRUE, TRUE, 6, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Banda Larga:', TRUE, TRUE, 7, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Local de Funcionamento:', TRUE, TRUE, 8, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 3, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'), 'Depend�ncias Existentes na Escola', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'Predio Compartilhado', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 1', TRUE, TRUE, 2, 'PredioCompartilhadoInep1', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 2', TRUE, TRUE, 3, 'PredioCompartilhadoInep2', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 3', TRUE, TRUE, 4, 'PredioCompartilhadoInep3', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 4', TRUE, TRUE, 5, 'PredioCompartilhadoInep4', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 5', TRUE, TRUE, 6, 'PredioCompartilhadoInep5', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'), 'C�digo INEP do pr�dio compartilhado 6', TRUE, TRUE, 7, 'PredioCompartilhadoInep6', 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), '�gua consumida pelos Alunos:', TRUE, TRUE, 1, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'Alimenta��o Escolar para os Alunos', TRUE, TRUE, 2, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'N� de Sala de Aula Existentes na Escola:', TRUE, TRUE, 3, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 2, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'N� de Salas Utilizadas como Sala de Aula:', TRUE, TRUE, 4, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'Atividade Complementar', TRUE, TRUE, 5, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'Atendimento Educ. Especializado AEE:', TRUE, TRUE, 6, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'Ensino Fundamental em ciclos:', TRUE, TRUE, 7, NULL, 1, NULL, NULL, FALSE, NULL, NULL),
          (nextval('avaliacaopergunta_db103_sequencial_seq'), 1, (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'), 'Escola com proposta pedagogica de forma��o por altern�ncia', TRUE, TRUE, 8, 'EscolaFormacaoAlternancia', 1, NULL, NULL, FALSE, NULL, NULL),
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
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espa�o para turmas do Brasil Alfabetizado'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espa�o para turmas do Brasil Alfabetizado'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupa��o do Pr�dio:'), 'Pr�prio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupa��o do Pr�dio:'), 'Alugado', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupa��o do Pr�dio:'), 'Cedido', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Rede P�blica', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Fossa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Did�ticos Espec�ficos:'), 'N�o Utiliza', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Did�ticos Espec�ficos:'), 'Quilombola', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Did�ticos Espec�ficos:'), 'Ind�gena', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Aparelho de Televis�o', TRUE, 'aparelho_televisao', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Videocassete', TRUE, 'videocassete', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'DVD', TRUE, 'dvd', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Antena Parab�lica', TRUE, 'antena_parabolica', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Copiadora', TRUE, 'copiadora', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Retroprojetor', TRUE, 'retroprojetor', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Fax', TRUE, 'fax', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'M�quina Fotogr�fica/Filmadora', TRUE, 'maquina_fotografica', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Impressora', TRUE, 'impressora', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Aparelho de som', TRUE, 'aparelho_som', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Projetor Multim�dia (Data show)', TRUE, 'projetor_multimidia', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Computadores', TRUE, 'equipamentos_computadores', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'), 'Impressora Multifuncional', TRUE, 'equipamentos_impressora_multifuncional', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Coleta Peri�dica', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Queima', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Joga em outra �rea', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Recicla', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Enterra', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'), 'Outros', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'), 'Rede P�blica', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'), 'Po�o Artesiano', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'), 'Cacimba/Cisterna/Po�o', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'), 'Fonte/Rio/Igarap�/Riacho', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Rede P�blica', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Gerador', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Outros(Enegria Alternativa)', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'), 'Inexistente', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso � Internet:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso � Internet:'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'), 'Possui', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'), 'N�o Possui', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Pr�dio Escolar', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Templo / Igreja', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Salas de Empresa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Casa do Professor', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Salas em Outra Escola', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Galp�o / Rancho / Paiol', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'OUTROS', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Unidade de Interna��o', FALSE, 'LocalFuncionamentoUnidadeInternacao', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'), 'Unidade Prisional', FALSE, 'LocalFuncionamentoUnidadePrisional', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Cozinha', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Biblioteca', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Berc�rio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Banheiro com chuveiro', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Refeit�tio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Despensa', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Almoxarifado', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Audit�rio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Alojamento de aluno', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Alojamento de professor', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), '�rea verde', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Lavanderia', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'P�tio coberto', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Banheiro adequado a alunos com defici�ncia ou mobilidade reduzida', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Banheiro adequado � educa��o infantil', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Banheiro dentro do pr�dio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Banheiro fora do pr�dio', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Depend�ncias e vias adequadas a alunos com defici�ncia ou mobilidade reduzida', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Laborat�rio de ci�ncias', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Parque infantil', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'P�tio descoberto', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Quadra de esportes coberta', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Quadra de esportes descoberta', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Sala de diretoria', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Sala de leitura', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Sala de professores', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Sala de recursos multifuncionais para Atendimento Educacional Especializado (AEE)', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Sala de secretaria', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'), 'Nenhuma das depend�ncias relacionadas', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 1'), NULL, TRUE, 'PredioCompartilhadoInep1_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 2'), NULL, TRUE, 'PredioCompartilhadoInep2_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 3'), NULL, TRUE, 'PredioCompartilhadoInep3_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 4'), NULL, TRUE, 'PredioCompartilhadoInep4_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 5'), NULL, TRUE, 'PredioCompartilhadoInep5_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 6'), NULL, TRUE, 'PredioCompartilhadoInep6_2', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = '�gua consumida pelos Alunos:'), 'N�O FILTRADA', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = '�gua consumida pelos Alunos:'), 'FILTRADA', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Alimenta��o Escolar para os Alunos'), 'OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N� de Sala de Aula Existentes na Escola:'), NULL, TRUE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N� de Salas Utilizadas como Sala de Aula:'), NULL, TRUE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'N�O EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'N�O OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'), 'EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'N�O EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'EXCLUSIVAMENTE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'), 'N�O OFERECE', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'), 'N�O', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'), 'SIM', FALSE, NULL, NULL, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de forma��o por altern�ncia'), 'SIM', FALSE, 'PossuiFormacaoPorAlternancia', 0, NULL, NULL),
          (nextval('avaliacaoperguntaopcao_db104_sequencial_seq'), (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de forma��o por altern�ncia'), 'N�O', FALSE, 'NaoPossuiFormacaoPorAlternancia', 0, NULL, NULL),
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
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola cede espa�o para turmas do Brasil Alfabetizado'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola abre aos finais de semana para a comunidade'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Forma de Ocupa��o do Pr�dio:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Esgoto Sanitario:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Materais Did�ticos Espec�ficos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Equipamentos Existentes:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Destina��o do Lixo:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de �gua'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Abastecimento de Energia:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Possui computadores:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Acesso � Internet:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Banda Larga:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Local de Funcionamento:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Depend�ncias Existentes na Escola'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Predio Compartilhado'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 1'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 2'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 3'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 4'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 5'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'C�digo INEP do pr�dio compartilhado 6'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = '�gua consumida pelos Alunos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Alimenta��o Escolar para os Alunos'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N� de Sala de Aula Existentes na Escola:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'N� de Salas Utilizadas como Sala de Aula:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atividade Complementar'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Atendimento Educ. Especializado AEE:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Ensino Fundamental em ciclos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Escola com proposta pedagogica de forma��o por altern�ncia'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso de Alunos:'),
            (select db103_sequencial from avaliacaopergunta where db103_descricao = 'Qtde. de Computadores Uso Administrativo:')
        );

        DELETE FROM avaliacaopergunta
        WHERE db103_avaliacaogrupopergunta IN (
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola cede espa�o para turmas do Brasil Alfabetiz'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'Escola abre aos finais de semana para a comunidade'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'FORMA DE OCUPA��O DO PR�DIO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ESGOTO SANIT�RIO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'MATERIAIS DID�TICOS ESPEC�FICOS'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'EQUIPAMENTOS EXISTENTES'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'DESTINA��O DO LIXO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE �GUA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'ABASTECIMENTO DE ENERGIA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'INFRA-ESTRUTURA'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'PREDIO COMPARTILHADO'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'OUTRAS INFORMA��ES'),
            (select db102_sequencial from avaliacaogrupopergunta where db102_descricao = 'COMPUTADORES')
        );

        DELETE FROM avaliacaogrupopergunta
        WHERE db102_avaliacao = 3000000;

        COMMIT;
SQL;
        $this->execute($sql);
    }
}
