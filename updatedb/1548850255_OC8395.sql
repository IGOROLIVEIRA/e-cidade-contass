
-- Ocorrência 8395
BEGIN;                   
SELECT fc_startsession();

-- Início do script
update db_itensmenu set funcao = '' where id_item in (select id_item from db_itensmenu where descricao like '%Despesas inscritas em RP%');

insert into db_itensmenu values ((select max(id_item) + 1 from db_itensmenu),
  'Cadastro da Disponibilidade',
  'Cadastro da Disponibilidade',
  'con2_cadastrodespesainscritarp001.php',1,1,
  'Cadastro da Disponibilidade',
  't');

insert into db_menu values((select id_item from db_itensmenu where descricao like '%Despesas inscritas em RP%'),(select max(id_item) from db_itensmenu), 1, 209);

insert into db_itensmenu values ((select max(id_item) + 1 from db_itensmenu),
  'Inscrição de Empenhos',
  'Inscrição de Empenhos',
  'con2_despesainscritarp001.php',1,1,
  'Inscrição de Empenhos',
  't');

insert into db_menu values((select id_item from db_itensmenu where descricao like '%Despesas inscritas em RP%'),(select max(id_item) from db_itensmenu), 2, 209);

--Cria Tabela disponibilidade

CREATE TABLE disponibilidadecaixa(
c224_sequencial		              int8 NOT NULL default 0,
c224_fonte		                  int8 NOT NULL default 0,
c224_vlrcaixabruta		          float8 NOT NULL default 0,
c224_rpexercicioanterior		    float8 NOT NULL default 0,
c224_vlrrestoarecolher		      float8 NOT NULL default 0,
c224_vlrrestoregativofinanceiro	float8 NOT NULL default 0,
c224_vlrdisponibilidadecaixa		float8 NOT NULL default 0,
c224_anousu		                  int4 NOT NULL default 0,
c224_instit		                  int4 NOT NULL default 0);

--Cria sequencia da Tabela

 CREATE SEQUENCE disponibilidadecaixa_c224_sequencial_seq
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;


-- Fim do script

COMMIT;

