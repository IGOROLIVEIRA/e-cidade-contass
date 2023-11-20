<?php

use Phinx\Migration\AbstractMigration;

class Rfidv3 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
            
        ALTER TABLE patrimonio.cfpatriinstituicao ADD t59_usuarioapi character varying(60);
        ALTER TABLE patrimonio.cfpatriinstituicao ADD t59_senhaapi character varying(40);
        ALTER TABLE patrimonio.cfpatriinstituicao ADD t59_enderecoapi character varying(250);
        ALTER TABLE patrimonio.cfpatriinstituicao ADD t59_ativo boolean;
        ALTER TABLE patrimonio.cfpatriinstituicao ADD t59_tokenapi character varying(5000);
 
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Bens pendentes', 'Bens pendentes', 'pat1_benscontrolerfid001.php', 1, 1, 'Bens pendentes', 't');

        INSERT INTO db_menu VALUES (3647, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 3647 and modulo = 439), 439);

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Bens pendentes de baixa', 'Bens pendentes de baixa', 'pat4_baixacontrolerfid001.php', 1, 1, 'Bens pendentes de baixa', 't');

        INSERT INTO db_menu VALUES (9128, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 9128 and modulo = 439), 439); 

        CREATE TABLE patrimonio.benscontrolerfid(
            t214_sequencial int8 NOT NULL,
            t214_codigobem int8 ,
            t214_placabem int8 ,
            t214_descbem text ,
            t214_placa_impressa text ,
            t214_usuario int8 ,
            t214_dtlancamento date ,
            t214_instit int8 ,
            t214_data_da_aquisicao date ,
            t214_classificacao text ,
            t214_fornecedor text ,
            t214_descricao_aquisicao text ,
            t214_departamento text ,
            t214_divisao text ,
            t214_convenio text ,
            t214_situacao_bem text ,
            t214_valor_aquisicao float8 NOT NULL default 0,
            t214_valor_residual float8 NOT NULL default 0,
            t214_valor_depreciavel float8 NOT NULL default 0,
            t214_tipo_depreciacao text ,
            t214_valor_atual float8 NOT NULL default 0,
            t214_vida_util int8 ,
            t214_medida text ,
            t214_modelo text ,
            t214_marca text ,
            t214_codigo_item_nota text ,
            t214_contabilizado text ,
            t214_observacoes text ,
            t214_codigo_lote int8 ,
            t214_quant_lote int8 ,
            t214_descricao_lote text ,
            t214_itbql int8 ,
            t214_observacoesimovel text ,
            t214_cod_notafiscal int8 ,
            t214_empenho int8 ,
            t214_cod_ordemdecompra int8 ,
            t214_garantia text ,
            t214_empenhosistema int8 ,
            t214_controlerfid int8 ,
            PRIMARY KEY (t214_sequencial),
            FOREIGN KEY (t214_codigobem) REFERENCES bens (t52_bem)
        );
            
        CREATE SEQUENCE patrimonio.benscontrolerfid_t214_sequencial_seq
        INCREMENT BY 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1
        NO CYCLE;  

        COMMIT;
        ";

        $this->execute($sql);
    }
}