CREATE SEQUENCE dotacoes_id_seq;

CREATE TABLE dotacoes (
                id INTEGER NOT NULL DEFAULT nextval('dotacoes_id_seq'),
                exercicio INTEGER,
                coddotacao INTEGER NOT NULL,
                orgao_id INTEGER NOT NULL,
                unidade_id INTEGER NOT NULL,
                funcao_id INTEGER NOT NULL,
                subfuncao_id INTEGER NOT NULL,
                programa_id INTEGER NOT NULL,
                projeto_id INTEGER NOT NULL,
                planoconta_id INTEGER NOT NULL,
                recurso_id INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                CONSTRAINT dotacoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE dotacoes IS 'Cadastro de Dotações';
COMMENT ON COLUMN dotacoes.id IS 'ID da Dotação';
COMMENT ON COLUMN dotacoes.exercicio IS 'Exercício da Dotação';
COMMENT ON COLUMN dotacoes.coddotacao IS 'Código da Dotação';
COMMENT ON COLUMN dotacoes.orgao_id IS 'Orgão da Dotação';
COMMENT ON COLUMN dotacoes.unidade_id IS 'Unidade da Dotação';
COMMENT ON COLUMN dotacoes.funcao_id IS 'Função da Dotação';
COMMENT ON COLUMN dotacoes.subfuncao_id IS 'SubFunção da Dotação';
COMMENT ON COLUMN dotacoes.programa_id IS 'Programa da Dotação';
COMMENT ON COLUMN dotacoes.projeto_id IS 'Projeto / Açao da Dotação';
COMMENT ON COLUMN dotacoes.planoconta_id IS 'Plano de Contas da Dotação';
COMMENT ON COLUMN dotacoes.recurso_id IS 'Recurso da Dotação';
COMMENT ON COLUMN dotacoes.instituicao_id IS 'Instituição da Dotação';


ALTER SEQUENCE dotacoes_id_seq OWNED BY dotacoes.id;

CREATE SEQUENCE empenhos_id_seq;

CREATE TABLE empenhos (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_id_seq'),
                codempenho INTEGER NOT NULL,
                exercicio INTEGER NOT NULL,
                codigo VARCHAR(15) NOT NULL,
                planoconta_id INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                dataemissao DATE NOT NULL,
                tipo_compra VARCHAR(100) NOT NULL,
                dotacao_id INTEGER NOT NULL,
                valor_pago NUMERIC(15,2) DEFAULT 0 NOT NULL,
                pessoa_id INTEGER NOT NULL,
                valor NUMERIC(15,2) DEFAULT 0 NOT NULL,
                valor_liquidado NUMERIC(15,2) DEFAULT 0 NOT NULL,
                valor_anulado NUMERIC(15,2) DEFAULT 0 NOT NULL,
                resumo TEXT,
                CONSTRAINT empenhos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos IS 'Cadastro de Empenhos';
COMMENT ON COLUMN empenhos.id IS 'ID do Empenho';
COMMENT ON COLUMN empenhos.codempenho IS 'N�mero do Empenho';
COMMENT ON COLUMN empenhos.exercicio IS 'Exercício do Empenho';
COMMENT ON COLUMN empenhos.codigo IS 'Código do Empenho';
COMMENT ON COLUMN empenhos.instituicao_id IS 'Instituição do Empenho';
COMMENT ON COLUMN empenhos.dataemissao IS 'Data de Emissao do Empenho';
COMMENT ON COLUMN empenhos.tipo_compra IS 'TIpo de Compra';
COMMENT ON COLUMN empenhos.dotacao_id IS 'Dotação do Empenho';
COMMENT ON COLUMN empenhos.valor_pago IS 'Valor Pago do Empenho';
COMMENT ON COLUMN empenhos.pessoa_id IS 'Favorecido do Empenho';
COMMENT ON COLUMN empenhos.valor IS 'Valor do Empenho';
COMMENT ON COLUMN empenhos.valor_liquidado IS 'Valor Liquidado do Empenho';
COMMENT ON COLUMN empenhos.valor_anulado IS 'Valor Anulado do Empenho';
COMMENT ON COLUMN empenhos.resumo IS 'Resumo do Empenho';


ALTER SEQUENCE empenhos_id_seq OWNED BY empenhos.id;

CREATE SEQUENCE empenhos_itens_id_seq;

CREATE TABLE empenhos_itens (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_itens_id_seq'),
                empenho_id INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                quantidade NUMERIC(15,2) DEFAULT 0 NOT NULL,
                valor_unitario NUMERIC(15,2) DEFAULT 0 NOT NULL,
                valor_total NUMERIC(15,2) DEFAULT 0 NOT NULL,
                CONSTRAINT empenhos_itens_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos_itens IS 'Itens do Empenho';
COMMENT ON COLUMN empenhos_itens.id IS 'ID do Item do Empenho';
COMMENT ON COLUMN empenhos_itens.empenho_id IS 'Código do Empenho';
COMMENT ON COLUMN empenhos_itens.descricao IS 'Descrição do Item do Empenho';
COMMENT ON COLUMN empenhos_itens.quantidade IS 'Quantidade do Item do Empenho';
COMMENT ON COLUMN empenhos_itens.valor_unitario IS 'Valor Unitário do Item do Empenho';
COMMENT ON COLUMN empenhos_itens.valor_total IS 'Valor Total do Item do Empenho';


ALTER SEQUENCE empenhos_itens_id_seq OWNED BY empenhos_itens.id;

CREATE SEQUENCE empenhos_movimentacoes_id_seq;

CREATE TABLE empenhos_movimentacoes (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_movimentacoes_id_seq'),
                empenho_movimentacao_tipo_id INTEGER NOT NULL,
                empenho_id INTEGER NOT NULL,
                data DATE NOT NULL,
                valor NUMERIC(15,2) DEFAULT 0 NOT NULL,
                historico TEXT,
                CONSTRAINT empenhos_movimentacoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos_movimentacoes IS 'Cadastro de Movimentações Financeiras do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.id IS 'ID da Movimentação Financeira do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.empenho_movimentacao_tipo_id IS 'Tipo de Movimentação Financeira do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.empenho_id IS 'Código do Empenho da Movimentação Financeira do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.data IS 'Data da Movimentação Financeira do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.valor IS 'Valor da Movimentação Financeira do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes.historico IS 'Histórico da Movimentação Financeira do Empenho';


ALTER SEQUENCE empenhos_movimentacoes_id_seq OWNED BY empenhos_movimentacoes.id;

CREATE SEQUENCE empenhos_movimentacoes_exercicios_id_seq;

CREATE TABLE empenhos_movimentacoes_exercicios (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_movimentacoes_exercicios_id_seq'),
                empenho_id INTEGER NOT NULL,
                exercicio INTEGER NOT NULL,
                CONSTRAINT empenhos_movimentacoes_exercicios_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos_movimentacoes_exercicios IS 'Exercícios da Movimentações do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes_exercicios.id IS 'ID dos Exercícios da Movimentação do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes_exercicios.empenho_id IS 'Empenho dos Exercícios da Movimentação do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes_exercicios.exercicio IS 'Exercícios da Movimentação do Empenho';


ALTER SEQUENCE empenhos_movimentacoes_exercicios_id_seq OWNED BY empenhos_movimentacoes_exercicios.id;

CREATE SEQUENCE empenhos_movimentacoes_tipos_id_seq;

CREATE TABLE empenhos_movimentacoes_tipos (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_movimentacoes_tipos_id_seq'),
                codtipo INTEGER NOT NULL,
                codgrupo INTEGER NOT NULL,
                descricao VARCHAR(50) NOT NULL,
                CONSTRAINT empenhos_movimentacoes_tipos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos_movimentacoes_tipos IS 'Cadastro de Tipo de Movimentação do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes_tipos.id IS 'ID do Tipo de Movimentação do Empenho';
COMMENT ON COLUMN empenhos_movimentacoes_tipos.codtipo IS 'Código do Tipo de Movimentação';
COMMENT ON COLUMN empenhos_movimentacoes_tipos.codgrupo IS 'Grupo do Tipo de Movimentação';
COMMENT ON COLUMN empenhos_movimentacoes_tipos.descricao IS 'Descrição do Tipo de Movimentação do Empenho';


ALTER SEQUENCE empenhos_movimentacoes_tipos_id_seq OWNED BY empenhos_movimentacoes_tipos.id;

CREATE SEQUENCE empenhos_processos_id_seq;

CREATE TABLE empenhos_processos (
                id INTEGER NOT NULL DEFAULT nextval('empenhos_processos_id_seq'),
                empenho_id INTEGER NOT NULL,
                processo INTEGER NOT NULL,
                CONSTRAINT empenhos_processos_pk PRIMARY KEY (id)
);
COMMENT ON TABLE empenhos_processos IS 'Processos de Compra do Empenho';
COMMENT ON COLUMN empenhos_processos.id IS 'ID do Processo do Empenho';
COMMENT ON COLUMN empenhos_processos.empenho_id IS 'Código do Empenho';
COMMENT ON COLUMN empenhos_processos.processo IS 'Código do Processo de Compra';


ALTER SEQUENCE empenhos_processos_id_seq OWNED BY empenhos_processos.id;

CREATE SEQUENCE funcoes_id_seq;

CREATE TABLE funcoes (
                id INTEGER NOT NULL DEFAULT nextval('funcoes_id_seq'),
                codfuncao INTEGER NOT NULL,
                descricao VARCHAR(40) NOT NULL,
                CONSTRAINT funcoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE funcoes IS 'Cadastro de Funções';
COMMENT ON COLUMN funcoes.id IS 'ID da Função';
COMMENT ON COLUMN funcoes.codfuncao IS 'Código da Função';
COMMENT ON COLUMN funcoes.descricao IS 'Descrição da Função';


ALTER SEQUENCE funcoes_id_seq OWNED BY funcoes.id;

CREATE SEQUENCE glossarios_id_seq;

CREATE TABLE glossarios (
                id INTEGER NOT NULL DEFAULT nextval('glossarios_id_seq'),
                glossario_tipo_id INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                resumo TEXT,
                CONSTRAINT glossarios_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE glossarios IS 'Cadastro do Glossário do Portal da Transparência';
COMMENT ON COLUMN glossarios.id IS 'ID do Glossário';
COMMENT ON COLUMN glossarios.glossario_tipo_id IS 'Tipo de Glossário';
COMMENT ON COLUMN glossarios.descricao IS 'Descrição do Glossário';
COMMENT ON COLUMN glossarios.resumo IS 'Resumo do Glossário';


ALTER SEQUENCE glossarios_id_seq OWNED BY glossarios.id;

CREATE SEQUENCE glossarios_tipos_id_seq;

CREATE TABLE glossarios_tipos (
                id INTEGER NOT NULL DEFAULT nextval('glossarios_tipos_id_seq'),
                descricao VARCHAR(200) NOT NULL,
                resumo TEXT,
                CONSTRAINT glossarios_tipos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE glossarios_tipos IS 'Cadastro de Tipos de Glossário utilizados no Portal da Transparência. Valores Defaults 1 - Finanças Públicas 2 - Despesas 3 - Receitas';
COMMENT ON COLUMN glossarios_tipos.id IS 'ID do Tipo de Glossário';
COMMENT ON COLUMN glossarios_tipos.descricao IS 'Descrição do Tipo de Glossário';
COMMENT ON COLUMN glossarios_tipos.resumo IS 'Resumo do Tipo de Glossário';


ALTER SEQUENCE glossarios_tipos_id_seq OWNED BY glossarios_tipos.id;

CREATE SEQUENCE importacoes_id_seq;

CREATE TABLE importacoes (
                id INTEGER NOT NULL DEFAULT nextval('importacoes_id_seq'),
                data DATE NOT NULL,
                hora CHAR(5) NOT NULL,
                CONSTRAINT importacoes_pk PRIMARY KEY (id)
);
COMMENT ON TABLE importacoes IS 'Cadastro da Importação dos Dados';


ALTER SEQUENCE importacoes_id_seq OWNED BY importacoes.id;

CREATE SEQUENCE instituicoes_id_seq;

CREATE TABLE instituicoes (
                id INTEGER NOT NULL DEFAULT nextval('instituicoes_id_seq'),
                codinstit INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT instituicoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE instituicoes IS 'Cadastro de Instituições do Município';
COMMENT ON COLUMN instituicoes.id IS 'ID da Instituição';
COMMENT ON COLUMN instituicoes.descricao IS 'Descrição da Instituição';


ALTER SEQUENCE instituicoes_id_seq OWNED BY instituicoes.id;

CREATE SEQUENCE orgaos_id_seq;

CREATE TABLE orgaos (
                id INTEGER NOT NULL DEFAULT nextval('orgaos_id_seq'),
                exercicio INTEGER NOT NULL,
                codorgao INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT orgaos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE orgaos IS 'Cadastro de Orgãos';
COMMENT ON COLUMN orgaos.id IS 'ID do Orgão';
COMMENT ON COLUMN orgaos.exercicio IS 'Exercício do Orgão';
COMMENT ON COLUMN orgaos.codorgao IS 'Código do Orgão';
COMMENT ON COLUMN orgaos.instituicao_id IS 'Instituição do Orgão';
COMMENT ON COLUMN orgaos.descricao IS 'Descrição do Orgão';


ALTER SEQUENCE orgaos_id_seq OWNED BY orgaos.id;

CREATE SEQUENCE pessoas_id_seq;

CREATE TABLE pessoas (
                id INTEGER NOT NULL DEFAULT nextval('pessoas_id_seq'),
                codpessoa INTEGER NOT NULL,
                nome VARCHAR(100) NOT NULL,
                cpfcnpj VARCHAR(14) NOT NULL,
                CONSTRAINT pessoas_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE pessoas IS 'Cadastro de Contribuintes do Município';
COMMENT ON COLUMN pessoas.id IS 'ID do Contribuínte';
COMMENT ON COLUMN pessoas.nome IS 'Nome do Contribuínte';
COMMENT ON COLUMN pessoas.cpfcnpj IS 'CNPJ / CPF do Contribuínte';


ALTER SEQUENCE pessoas_id_seq OWNED BY pessoas.id;

CREATE SEQUENCE planocontas_id_seq;

CREATE TABLE planocontas (
                id INTEGER NOT NULL DEFAULT nextval('planocontas_id_seq'),
                codcon INTEGER NOT NULL,
                exercicio INTEGER NOT NULL,
                estrutural VARCHAR(20) NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT planocontas_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE planocontas IS 'Cadastro do Plano de Contas';
COMMENT ON COLUMN planocontas.id IS 'ID do Plano de Conta';
COMMENT ON COLUMN planocontas.codcon IS 'Código do Plano de Conta';
COMMENT ON COLUMN planocontas.exercicio IS 'Exercício do Plano de Conta';
COMMENT ON COLUMN planocontas.estrutural IS 'Estrutural do Plano de Conta';
COMMENT ON COLUMN planocontas.descricao IS 'Descrição do Plano de Conta';


ALTER SEQUENCE planocontas_id_seq OWNED BY planocontas.id;

CREATE SEQUENCE programas_id_seq;

CREATE TABLE programas (
                id INTEGER NOT NULL DEFAULT nextval('programas_id_seq'),
                exercicio INTEGER NOT NULL,
                codprograma INTEGER NOT NULL,
                descricao VARCHAR(40) NOT NULL,
                CONSTRAINT programas_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE programas IS 'Cadastro de Programas';
COMMENT ON COLUMN programas.id IS 'ID do Programa';
COMMENT ON COLUMN programas.exercicio IS 'Exercício do Programa';
COMMENT ON COLUMN programas.codprograma IS 'Código do Programa';
COMMENT ON COLUMN programas.descricao IS 'Descrição do Programa';


ALTER SEQUENCE programas_id_seq OWNED BY programas.id;

CREATE SEQUENCE projetos_id_seq;

CREATE TABLE projetos (
                id INTEGER NOT NULL DEFAULT nextval('projetos_id_seq'),
                exercicio INTEGER NOT NULL,
                codprojeto INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                tipo INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT projetos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE projetos IS 'Cadastro de Projetos / Ações';
COMMENT ON COLUMN projetos.id IS 'ID do Projeto / Ação';
COMMENT ON COLUMN projetos.exercicio IS 'Exercício do Projeto / Ação';
COMMENT ON COLUMN projetos.codprojeto IS 'Código do Projeto / Ação';
COMMENT ON COLUMN projetos.instituicao_id IS 'Instituição do Projeto / Ação';
COMMENT ON COLUMN projetos.tipo IS 'Tipo do Projeto / Ação';
COMMENT ON COLUMN projetos.descricao IS 'Descrição do Projeto / Ação';


ALTER SEQUENCE projetos_id_seq OWNED BY projetos.id;

CREATE SEQUENCE receitas_id_seq;

CREATE TABLE receitas (
                id INTEGER NOT NULL DEFAULT nextval('receitas_id_seq'),
                exercicio INTEGER NOT NULL,
                codreceita INTEGER NOT NULL,
                planoconta_id INTEGER NOT NULL,
                recurso_id INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                CONSTRAINT receitas_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE receitas IS 'Cadastro de Receitas';
COMMENT ON COLUMN receitas.id IS 'ID da Receita';
COMMENT ON COLUMN receitas.exercicio IS 'Exercício da Receita';
COMMENT ON COLUMN receitas.codreceita IS 'Código da Receita';
COMMENT ON COLUMN receitas.planoconta_id IS 'Conta no Plano de Contas da Receita';
COMMENT ON COLUMN receitas.recurso_id IS 'Recurso da Receita';
COMMENT ON COLUMN receitas.instituicao_id IS 'Instituição da Receita';


ALTER SEQUENCE receitas_id_seq OWNED BY receitas.id;

CREATE SEQUENCE receitas_movimentacoes_id_seq;

CREATE TABLE receitas_movimentacoes (
                id INTEGER NOT NULL DEFAULT nextval('receitas_movimentacoes_id_seq'),
                receita_id INTEGER NOT NULL,
                data DATE NOT NULL,
                valor NUMERIC(15,2) DEFAULT 0 NOT NULL,
                CONSTRAINT receitas_movimentacoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE receitas_movimentacoes IS 'Cadastro de Movimentações Financeiras da Receita';
COMMENT ON COLUMN receitas_movimentacoes.id IS 'ID da Movimentação Financeira da Receita';
COMMENT ON COLUMN receitas_movimentacoes.receita_id IS 'Receita da Movimentação Financeira da Receita';
COMMENT ON COLUMN receitas_movimentacoes.data IS 'Data da Movimentação Financeira da Receita';
COMMENT ON COLUMN receitas_movimentacoes.valor IS 'Valor da Movimentação Financeira da Receita';


ALTER SEQUENCE receitas_movimentacoes_id_seq OWNED BY receitas_movimentacoes.id;

CREATE SEQUENCE recursos_id_seq;

CREATE TABLE recursos (
                id INTEGER NOT NULL DEFAULT nextval('recursos_id_seq'),
                codrecurso INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT recursos_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE recursos IS 'Cadastro de Recursos';
COMMENT ON COLUMN recursos.id IS 'ID do Recurso';
COMMENT ON COLUMN recursos.descricao IS 'Descrição do Recurso';


ALTER SEQUENCE recursos_id_seq OWNED BY recursos.id;

CREATE TABLE resumos (
                id INTEGER NOT NULL,
                resumo_tipo_id INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                resumo TEXT NOT NULL,
                CONSTRAINT resumos_pk PRIMARY KEY (id)
);
COMMENT ON TABLE resumos IS 'Resumos do Portal da Transparência';
COMMENT ON COLUMN resumos.id IS 'ID do Resumo do Portal da Transparência';
COMMENT ON COLUMN resumos.resumo_tipo_id IS 'Tipo de Resumo do Portal da Transparência';
COMMENT ON COLUMN resumos.descricao IS 'Descrição do Resumo do Portal da Transparência';
COMMENT ON COLUMN resumos.resumo IS 'Rumos do Resumo do Portal da Transparencia';


CREATE SEQUENCE resumos_tipos_id_seq;

CREATE TABLE resumos_tipos (
                id INTEGER NOT NULL DEFAULT nextval('resumos_tipos_id_seq'),
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT resumos_tipos_pk PRIMARY KEY (id)
);
COMMENT ON TABLE resumos_tipos IS 'Tipos de Resumos do Portal da Transparência';
COMMENT ON COLUMN resumos_tipos.id IS 'ID do Tipo de Resumo do Portal da Transparência';
COMMENT ON COLUMN resumos_tipos.descricao IS 'Descrição do Tipo de Resumo do Portal da Transparência';


ALTER SEQUENCE resumos_tipos_id_seq OWNED BY resumos_tipos.id;

CREATE SEQUENCE subfuncoes_id_seq;

CREATE TABLE subfuncoes (
                id INTEGER NOT NULL DEFAULT nextval('subfuncoes_id_seq'),
                codsubfuncao INTEGER NOT NULL,
                descricao VARCHAR(40) NOT NULL,
                CONSTRAINT subfuncoes_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE subfuncoes IS 'Cadastro de SubFunções';
COMMENT ON COLUMN subfuncoes.id IS 'ID da SubFunção';
COMMENT ON COLUMN subfuncoes.codsubfuncao IS 'Código da SubFunção';
COMMENT ON COLUMN subfuncoes.descricao IS 'Descrição da SubFunção';


ALTER SEQUENCE subfuncoes_id_seq OWNED BY subfuncoes.id;

CREATE SEQUENCE unidades_id_seq;

CREATE TABLE unidades (
                id INTEGER NOT NULL DEFAULT nextval('unidades_id_seq'),
                exercicio INTEGER NOT NULL,
                orgao_id INTEGER NOT NULL,
                codunidade INTEGER NOT NULL,
                instituicao_id INTEGER NOT NULL,
                descricao VARCHAR(100) NOT NULL,
                CONSTRAINT unidades_id_pk PRIMARY KEY (id)
);
COMMENT ON TABLE unidades IS 'Cadastro de Unidade Orçamentária';
COMMENT ON COLUMN unidades.id IS 'ID da Unidade Orçamentária';
COMMENT ON COLUMN unidades.exercicio IS 'Exercício da Unidade Orçamentária';
COMMENT ON COLUMN unidades.orgao_id IS 'Orgão da Unidade Orçamentária';
COMMENT ON COLUMN unidades.codunidade IS 'Código da Unidade Orçamentária';
COMMENT ON COLUMN unidades.instituicao_id IS 'Instituição da Unidade Orçamentária';
COMMENT ON COLUMN unidades.descricao IS 'Descrição da Unidade Orçamentária';


ALTER SEQUENCE unidades_id_seq OWNED BY unidades.id;

CREATE INDEX empenhos_dotacao_id_in
 ON empenhos
 ( dotacao_id );

CREATE INDEX empenhos_movimentacoes_empenho_id_in
 ON empenhos_movimentacoes
 ( empenho_id );

CREATE INDEX empenhos_movimentacoes_empenho_movimentacao_tipo_id_in
 ON empenhos_movimentacoes
 ( empenho_movimentacao_tipo_id );

CREATE INDEX dotacoes_funcao_id_in
 ON dotacoes
 ( funcao_id );

CREATE INDEX glossarios_glossario_tipo_id_in
 ON glossarios
 ( glossario_tipo_id );

CREATE INDEX dotacoes_instituicao_id_in
 ON dotacoes
 ( instituicao_id );

CREATE INDEX dotacoes_orgao_id_in
 ON dotacoes
 ( orgao_id );

CREATE INDEX empenhos_pessoa_id_in
 ON empenhos
 ( pessoa_id );

CREATE INDEX dotacoes_planoconta_id_in
 ON dotacoes
 ( planoconta_id );

CREATE INDEX dotacoes_programa_id_in
 ON dotacoes
 ( programa_id );

CREATE INDEX dotacoes_projeto_id_in
 ON dotacoes
 ( projeto_id );

CREATE INDEX receitas_movimentacoes_receita_id_in
 ON receitas_movimentacoes
 ( receita_id );

CREATE INDEX dotacoes_recurso_id_in
 ON dotacoes
 ( recurso_id );

CREATE INDEX dotacoes_subfuncao_id_in
 ON dotacoes
 ( subfuncao_id );

CREATE INDEX dotacoes_unidade_id_in
 ON dotacoes
 ( unidade_id );


CREATE UNIQUE INDEX programas_exercicio_codprograma_uk
 ON programas
 ( exercicio, codprograma );

CREATE UNIQUE INDEX planocontas_codcon_exercicio_uk
 ON planocontas USING BTREE
 ( codcon, exercicio );

CREATE UNIQUE INDEX dotacoes_coddotacao_anousu_uk
 ON dotacoes USING BTREE
 ( coddotacao, exercicio );

CREATE UNIQUE INDEX empenhos_codempenho_exercicio_id_instituicao_uk
 ON empenhos USING BTREE
 ( codempenho, exercicio, instituicao_id );

CREATE UNIQUE INDEX funcoes_codfuncao_uk
 ON funcoes USING BTREE
 ( codfuncao );

CREATE UNIQUE INDEX orgaos_exercicio_codorgao_uk
 ON orgaos USING BTREE
 ( exercicio, codorgao );

CREATE UNIQUE INDEX pessoas_codpessoa_uk
 ON pessoas USING BTREE
 ( codpessoa );

CREATE UNIQUE INDEX projetos_exercicio_codprojeto_uk
 ON projetos USING BTREE
 ( codprojeto, exercicio );

CREATE UNIQUE INDEX receitas_exercicio_codreceita_uk
 ON receitas USING BTREE
 ( exercicio, codreceita );

CREATE UNIQUE INDEX recursos_codrecurso_uk
 ON recursos USING BTREE
 ( codrecurso );

CREATE UNIQUE INDEX subfuncoes_codsubfuncao_uk
 ON subfuncoes USING BTREE
 ( codsubfuncao );

CREATE UNIQUE INDEX empenhos_movimentacoes_tipos_codtipo_uk
 ON empenhos_movimentacoes_tipos USING BTREE
 ( codtipo );

CREATE UNIQUE INDEX unidades_exercicio_id_orgao_codunidade_uk
 ON unidades USING BTREE
 ( exercicio, orgao_id, codunidade );


ALTER TABLE empenhos ADD CONSTRAINT empenhos_dotacao_id_fk
FOREIGN KEY (dotacao_id)
REFERENCES dotacoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE empenhos_itens ADD CONSTRAINT empenhos_empenhos_itens_fk
FOREIGN KEY (empenho_id)
REFERENCES empenhos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE empenhos_movimentacoes ADD CONSTRAINT empenhos_movimentacoes_empenho_id_fk
FOREIGN KEY (empenho_id)
REFERENCES empenhos (id)
ON DELETE NO ACTION
ON UPDATE SET NULL
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE empenhos_movimentacoes_exercicios ADD CONSTRAINT empenhos_empenhos_movimentacoes_exercicios_fk
FOREIGN KEY (empenho_id)
REFERENCES empenhos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE empenhos_processos ADD CONSTRAINT empenhos_empenhos_processos_fk
FOREIGN KEY (empenho_id)
REFERENCES empenhos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE empenhos_movimentacoes ADD CONSTRAINT empenhos_movimentacoes_empenho_movimentacao_tipo_id_fk
FOREIGN KEY (empenho_movimentacao_tipo_id)
REFERENCES empenhos_movimentacoes_tipos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_funcao_id_fk
FOREIGN KEY (funcao_id)
REFERENCES funcoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE glossarios ADD CONSTRAINT glossarios_glossario_tipo_id_fk
FOREIGN KEY (glossario_tipo_id)
REFERENCES glossarios_tipos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE empenhos ADD CONSTRAINT empenhos_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE orgaos ADD CONSTRAINT orgaos_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE projetos ADD CONSTRAINT projetos_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE receitas ADD CONSTRAINT receitas_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE unidades ADD CONSTRAINT unidades_instituicao_id_fk
FOREIGN KEY (instituicao_id)
REFERENCES instituicoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_orgao_id_fk
FOREIGN KEY (orgao_id)
REFERENCES orgaos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE unidades ADD CONSTRAINT unidades_orgao_id_fk
FOREIGN KEY (orgao_id)
REFERENCES orgaos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE empenhos ADD CONSTRAINT empenhos_pessoa_id_fk
FOREIGN KEY (pessoa_id)
REFERENCES pessoas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_planocontas_id_fk
FOREIGN KEY (planoconta_id)
REFERENCES planocontas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE empenhos ADD CONSTRAINT planocontas_empenhos_fk
FOREIGN KEY (planoconta_id)
REFERENCES planocontas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE receitas ADD CONSTRAINT receitas_planoconta_id_fk
FOREIGN KEY (planoconta_id)
REFERENCES planocontas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_programa_id_fk
FOREIGN KEY (programa_id)
REFERENCES programas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_projeto_id_fk
FOREIGN KEY (projeto_id)
REFERENCES projetos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE receitas_movimentacoes ADD CONSTRAINT receitas_movimentacoes_receita_id_fk
FOREIGN KEY (receita_id)
REFERENCES receitas (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_recurso_id_fk
FOREIGN KEY (recurso_id)
REFERENCES recursos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE receitas ADD CONSTRAINT receitas_recurso_id_fk
FOREIGN KEY (recurso_id)
REFERENCES recursos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE resumos ADD CONSTRAINT resumos_tipos_resumos_portal_fk
FOREIGN KEY (resumo_tipo_id)
REFERENCES resumos_tipos (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_subfuncao_id_fk
FOREIGN KEY (subfuncao_id)
REFERENCES subfuncoes (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;

ALTER TABLE dotacoes ADD CONSTRAINT dotacoes_unidade_id_fk
FOREIGN KEY (unidade_id)
REFERENCES unidades (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
DEFERRABLE INITIALLY DEFERRED;
