<?php

use Phinx\Migration\AbstractMigration;

class Oc18148 extends AbstractMigration
{
    public function up()
    {
        $this->criaCampo();
        $this->insereDados();
        $this->removeInstitNull();
    }

    public function criacampo()
    {
        $sqlCria = "
        
        select fc_startsession();

        begin;
        
        alter table relatorios add column rel_instit int;

        select setval('relatorios_rel_sequencial_seq',(select max(rel_sequencial) from relatorios));

        commit;

        ";

        $this->execute($sqlCria);
    }

    public function insereDados()
    {
        $codInst = $this->fetchAll("SELECT DISTINCT codigo FROM db_config");

        foreach ($codInst as $instit) {

            $autorizacao = $this->fetchRow("SELECT rel_descricao,rel_arquivo,rel_corpo FROM relatorios WHERE rel_sequencial = 1");
            $autuacao = $this->fetchRow("SELECT rel_descricao,rel_arquivo,rel_corpo FROM relatorios WHERE rel_sequencial = 2");

            $rel_sequencial_autorizacao = intval(current($this->fetchRow("SELECT nextval('relatorios_rel_sequencial_seq')")));
            $rel_sequencial_autuacao = intval(current($this->fetchRow("SELECT nextval('relatorios_rel_sequencial_seq')")));

            $campos = array(
                  'rel_sequencial',
                  'rel_descricao',
                  'rel_arquivo',
                  'rel_corpo',
                  'rel_instit'
                );

            $rel1 = array($rel_sequencial_autorizacao, $autorizacao['rel_descricao'], $autorizacao['rel_arquivo'], $autorizacao['rel_corpo'], $instit['codigo']);
            $rel2 = array($rel_sequencial_autuacao, $autuacao['rel_descricao'], $autuacao['rel_arquivo'], $autuacao['rel_corpo'], $instit['codigo']);
            
            $this->table('relatorios', array('schema' => 'public'))->insert($campos, array($rel1))->saveData();
            $this->table('relatorios', array('schema' => 'public'))->insert($campos, array($rel2))->saveData();
        }
    }

    public function removeInstitNull(){
        $remove = "begin;
        
        delete from relatorios where rel_instit is null;

        commit;";

        $this->execute($remove);
    }
}
