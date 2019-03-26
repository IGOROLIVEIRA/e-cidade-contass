
-- Ocorrência OC8680
BEGIN;                   
SELECT fc_startsession();

-- Início do script

--crita tabelas
CREATE TABLE metasadotadas(
  c224_sequencial int8 PRIMARY KEY,
  c224_medida int4 NOT NULL,
  c224_descricao text NOT NULL
  );

CREATE SEQUENCE metasadotadas_c224_sequencial_seq;

CREATE TABLE medidasadotadaslrf(
c225_sequencial             int8 NOT NULL,
c225_metasadotadas          int4,
c225_anousu                 int4 NOT NULL,
c225_mesusu                 int4 NOT NULL,
c225_orgao                  int4 NOT NULL,
c225_dadoscomplementareslrf int8 NOT NULL,
PRIMARY KEY (c225_sequencial,c225_metasadotadas),
FOREIGN KEY (c225_metasadotadas) REFERENCES metasadotadas (c224_sequencial),
FOREIGN KEY (c225_dadoscomplementareslrf) references dadoscomplementareslrf (c218_sequencial),
CONSTRAINT medidasadotadaslrf_referencia UNIQUE (c225_metasadotadas, c225_orgao, c225_anousu, c225_mesusu)
);

CREATE SEQUENCE medidasadotadaslrf_c225_sequencial_seq;

--inseriondo dados padroes para tabela
INSERT INTO metasadotadas
VALUES (
            (SELECT nextval('metasadotadas_c224_sequencial_seq')), 1,
                                                                   'Acompanhamento sistemático da inadimplência dos tributos com a cobrança da dívida ativa, apurando-se os valores inscritos para cobrança administrativa e ou judicial.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 2,
                                                                  'Campanhas de conscientização e incentivo da população quanto à quitação de tributos e dívida ativa.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 3,
                                                                  'Recadastramento mobiliário e imobiliário.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 4,
                                                                  'Acompanhamento e expansão da base de arrecadação do ISS - identificação de novas situações de sujeição');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 5,
                                                                  'Informatização e aprimoramento do setor de tributação para melhor controle de suas receitas próprias.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 6,
                                                                  'Implantação da nota fiscal eletrônica.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 7,
                                                                  'Atualização da legislação tributária.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 8,
                                                                  'Estudos e análises para fomentar a fiscalização tributária dos maiores contribuintes do município.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 9,
                                                                  'Manutenção da Junta de Julgamento e de Recursos Fiscais.');
INSERT INTO metasadotadas
VALUES(
           (SELECT nextval('metasadotadas_c224_sequencial_seq')), 99,
                                                                  'Outras medidas de combate a sonegação e evasão de receitas.');

-- Fim do script

COMMIT;

