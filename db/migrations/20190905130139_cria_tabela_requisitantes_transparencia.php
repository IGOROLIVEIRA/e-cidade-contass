<?php

use Phinx\Migration\AbstractMigration;

class CriaTabelaRequisitantesTransparencia extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('requisitantes_transparencia', array('schema' => 'configuracoes', 'id' => false, 'primary_key' => array('db149_sequencial')));
        $table->addColumn('db149_sequencial', 'integer', array('identity' => true));
        $table->addColumn('db149_matricula', 'integer');
        $table->addColumn('db149_cpf', 'string', array('limit' => 11));
        $table->addColumn('db149_nome', 'string', array('limit' => 200));
        $table->addColumn('db149_data', 'timestamp');
        $table->create();

        $this->insertMenusConsultaRelatorio();
        $this->insertDicionarioDados();

    }

    private function insertMenusConsultaRelatorio()
    {
        $sql = <<<SQL
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Requisitantes Transparência', 'Requisitantes Transparência','con3_requisitante001.php',1,1,'','t');

        INSERT INTO db_menu VALUES (31,(SELECT max(id_item) FROM db_itensmenu),(SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 31 AND modulo = 1),1);

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Requisitantes Transparência', 'Requisitantes Transparência','con4_relrequisitante001.php',1,1,'','t');

        INSERT INTO db_menu VALUES (30,(SELECT max(id_item) FROM db_itensmenu),(SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 31 AND modulo = 1),1);

SQL;
        $this->execute($sql);

    }

    private function insertDicionarioDados()
    {
        $sql = <<<SQL
        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'requisitantes_transparencia             ', 'Requisitantes Folha Transparência', 'db149', '2019-09-05', 'Requisitantes Folha Transparência', 0, false, false, false, false);
         
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (7, (select max(codarq) from db_sysarquivo));
         
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'db149_sequencial                        ', 'int8                                    ', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'db149_matricula                         ', 'int4                                    ', 'Matricula Consultada', '0', 'Matricula Consultada', 11, false, false, false, 1, 'text', 'Matricula Consultada');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'db149_cpf                               ', 'varchar(11)                             ', 'Cpf do Requisitante', '', 'Cpf do Requisitante', 11, false, true, false, 0, 'text', 'Cpf do Requisitante');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'db149_nome                              ', 'varchar(200)                            ', 'Nome do Requisitante', '', 'Nome do Requisitante', 200, false, true, false, 0, 'text', 'Nome do Requisitante');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'db149_data                              ', 'date                                    ', 'Data da Consulta', 'null', 'Data da Consulta', 10, false, false, false, 1, 'text', 'Data da Consulta');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'db149_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'db149_matricula'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'db149_cpf'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'db149_nome'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'db149_data'), 5, 0);
 
SQL;
        $this->execute($sql);

    }
}
