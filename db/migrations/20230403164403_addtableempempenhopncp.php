<?php

use Phinx\Migration\AbstractMigration;

class Addtableempempenhopncp extends AbstractMigration
{
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS empenho.empempenhopncp
                (
                    e213_sequencial bigint NOT NULL,
                    e213_contrato bigint NOT NULL,
                    e213_usuario bigint NOT NULL,
                    e213_dtlancamento date NOT NULL,
                    e213_numerocontrolepncp text NOT NULL,
                    e213_situacao bigint NOT NULL,
                    e213_instit bigint NOT NULL,
                    e213_ano bigint NOT NULL,
                    e213_sequencialpncp bigint NOT NULL,
                    CONSTRAINT empempenhopncp_pkey PRIMARY KEY (e213_sequencial),
                    CONSTRAINT empempenhopncp_e213_contrato_fkey FOREIGN KEY (e213_contrato)
                        REFERENCES empenho.empempenho (e60_numemp) MATCH SIMPLE
                        ON UPDATE NO ACTION
                        ON DELETE NO ACTION,
                    CONSTRAINT fk_id_esituacaoempenhopncp FOREIGN KEY (e213_situacao)
                        REFERENCES public.licsituacaocontrolepncp (l214_sequencial) MATCH SIMPLE
                        ON UPDATE NO ACTION
                        ON DELETE NO ACTION
                );
                
                CREATE SEQUENCE empempenhopncp_e213_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
                ";
        $this->execute($sql);
    }
}
