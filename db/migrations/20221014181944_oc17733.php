<?php

use Phinx\Migration\AbstractMigration;

class Oc17733 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        begin;

        select fc_startsession();

        create table solicitemanul (pc28_sequencial int8 not null default 0,
                                    pc28_solicitem int8 not null,
                                    pc28_vlranu double precision,
                                    pc28_qtd double precision);

        create sequence solicitemanul_pc28_sequencial_seq
        increment 1
        minvalue 1
        maxvalue 9223372036854775807
        start 1
        cache 1;

        insert into db_sysarquivo values((select max(codarq)+1 from db_sysarquivo),'solicitemanul','Itens anulados da solicitacao no empenho','pc28','2022-01-01','Itens anulados da solicitacao',0,'f','f','f','f');

        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc28_sequencial','int4','Código Sequencial',0,'Código Sequencial',10,'f','f','f',1,'text','Código Sequencial');
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc28_solicitem','int8','Registro Item Solicitacao',0,'Registro Item Solicitacao',10,'f','f','f',1,'text','Registro Item Solicitacao');
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc28_vlranu','float8','Valor Anulado',0,'Valor Anulado',10,'f','f','f',4,'text','Valor Anulado');
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc28_qtd','float8','Quantidade Anulada',0,'Quantidade Anulada',10,'t','f','f',4,'text','Quantidade Anulada');
        
        commit;";

        $this->execute($sSql);
    }
}
