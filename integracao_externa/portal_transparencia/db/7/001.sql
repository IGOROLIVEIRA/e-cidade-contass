CREATE SEQUENCE repasses_id_seq;
CREATE TABLE repasses (
                id INTEGER NOT NULL DEFAULT nextval('repasses_id_seq'),
                data DATE NOT NULL,
                credito_repasse_recebido NUMERIC(15,2) DEFAULT 0,
                debito_devolucao_repasse_recebido NUMERIC(15,2) DEFAULT 0,
                credito_devolucao_estorno_repasse_recebido NUMERIC(15,2) DEFAULT 0,
                debito_estorno_repasse_recebido NUMERIC(15,2) DEFAULT 0,
                saldo NUMERIC(15,2) DEFAULT 0,
                instituicao_id INTEGER NOT NULL,
                CONSTRAINT repasses_id_pk PRIMARY KEY (id)
);
 COMMENT ON TABLE repasses IS 'Cadastro de repasses';
 COMMENT ON COLUMN repasses.id IS 'ID da repasse';
 COMMENT ON COLUMN repasses.data IS 'Data da movimentação';
 COMMENT ON COLUMN repasses.data IS 'Data da movimentação';
 COMMENT ON COLUMN repasses.credito_repasse_recebido IS 'Devolução de repasse';
 COMMENT ON COLUMN repasses.debito_devolucao_repasse_recebido IS 'Recebimento de repasse';
 COMMENT ON COLUMN repasses.credito_devolucao_estorno_repasse_recebido IS 'Devolução de repasse';
 COMMENT ON COLUMN repasses.debito_estorno_repasse_recebido IS 'Recebimento de repasse';
 COMMENT ON COLUMN repasses.saldo IS 'Saldo da Câmara';
 COMMENT ON COLUMN repasses.instituicao_id IS 'ID da instituição';

ALTER SEQUENCE repasses_id_seq OWNED BY repasses.id;

