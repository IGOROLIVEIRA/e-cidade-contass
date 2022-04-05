<?php

use Phinx\Migration\AbstractMigration;

class Hotfixchagetypenrinsc extends AbstractMigration
{
    public function up()
    {
        $sql = "
        update avaliacaopergunta set db103_sequencial = 4000643 , db103_avaliacaotiporesposta = 2 , db103_avaliacaogrupopergunta = 4000207 , db103_descricao = 'Informar o número de inscrição do contribuinte de acordo com o tipo de inscrição indicado no campo {tpInsc}' , db103_identificador = 'o-numero-de-inscricao-do-contribuinte-4000643' , db103_obrigatoria = 't' , db103_ativo = 't' , db103_ordem = 2 , db103_tipo = 1 , db103_mascara = '' , db103_camposql = 'nrinsc_localtrabgeral' , db103_identificadorcampo = 'nrInsc' where db103_sequencial = 4000643;
        select nextval('avaliacaoperguntaopcao_db104_sequencial_seq');
        insert into avaliacaoperguntaopcao( db104_sequencial ,db104_avaliacaopergunta ,db104_descricao ,db104_identificador ,db104_aceitatexto ,db104_peso ,db104_identificadorcampo ,db104_valorresposta ) values ( 4003025 ,4000643 ,'' ,'nrInsc-4003025' ,'true' ,0 ,'nrInsc' ,'' );
        ";
        $this->execute($sql);
    }
}
