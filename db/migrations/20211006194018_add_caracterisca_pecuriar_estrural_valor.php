<?php

use Phinx\Migration\AbstractMigration;

class AddCaracteriscaPecuriarEstruralValor extends AbstractMigration
{

    public function up()
    {
        // ('096','RECEBIMENTO DE DEVOLUCAO DOS RECURSOS DO FUNDEB', 2, 1, '096');";

        $db121_sequencial = current($this->fetchRow("select nextval('db_estruturavalor_db121_sequencial_seq')"));
        $sql = "INSERT INTO configuracoes.db_estruturavalor (db121_sequencial,db121_db_estrutura,
                      db121_estrutural,db121_descricao,db121_estruturavalorpai,db121_nivel,db121_tipoconta)
                      VALUES ({$db121_sequencial},5, '095', 'DEVOLUCAO DOS RECURSOS DO FUNDEB', 0,0,1);";
        $this->execute($sql);

        $sql = "update contabilidade.concarpeculiar set c58_db_estruturavalor={$db121_sequencial} where c58_sequencial='095'";
        $this->execute($sql);

        $db121_sequencial = current($this->fetchRow("select nextval('db_estruturavalor_db121_sequencial_seq')"));
        $sql = "INSERT INTO configuracoes.db_estruturavalor (db121_sequencial,db121_db_estrutura,
                      db121_estrutural,db121_descricao,db121_estruturavalorpai,db121_nivel,db121_tipoconta)
                      VALUES ({$db121_sequencial},5, '096', 'RECEBIMENTO DE DEVOLUCAO DOS RECURSOS DO FUNDEB', 0,0,1);";
        $this->execute($sql);

        $sql = "update contabilidade.concarpeculiar set c58_db_estruturavalor={$db121_sequencial} where c58_sequencial='096'";
        $this->execute($sql);
    }
}
