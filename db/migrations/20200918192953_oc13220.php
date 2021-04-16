<?php

use Classes\PostgresMigration;

class Oc13220 extends PostgresMigration
{
    public function up()
    {

        $table = $this->table('rhlotavincativ', array('schema' => 'pessoal'));
        $table->addColumn('rh39_orgao','integer', array('default' => 0))
              ->addColumn('rh39_unidade','integer', array('default' => 0))
              ->save();

        if ($this->checkDicionarioDados()) {
            $this->insertDicionarioDados();
        }
    }

    public function down()
    {
        $table = $this->table('rhlotavincativ', array('schema' => 'pessoal'));
        $table->removeColumn('rh39_orgao')
              ->removeColumn('rh39_unidade')
              ->save();
    }

    private function checkDicionarioDados()
    {
        $result = $this->fetchRow("SELECT * FROM db_syscampo WHERE nomecam = 'rh39_orgao'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

    private function insertDicionarioDados() 
    {
        $sql = <<<SQL
         
        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh39_orgao', 'int4', 'Orgão', '0', 'Orgão', 2, false, false, false, 1, 'text', 'Orgão');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh39_unidade', 'int4', 'Unidade', '0', 'Unidade', 2, false, false, false, 1, 'text', 'Unidade');
         
        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhlotavincativ'), (select codcam from db_syscampo where nomecam = 'rh39_orgao'), 8, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhlotavincativ'), (select codcam from db_syscampo where nomecam = 'rh39_unidade'), 9, 0);

        -- INSERINDO db_sysforkey
        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhlotavincativ'), (select codcam from db_syscampo where nomecam = 'rh39_orgao'), 1, 756, 0);
        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhlotavincativ'), (select codcam from db_syscampo where nomecam = 'rh39_anousu'), 2, 756, 0);
        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhlotavincativ'), (select codcam from db_syscampo where nomecam = 'rh39_unidade'), 1, 757, 0);
SQL;
        $this->execute($sql);
    }
}
