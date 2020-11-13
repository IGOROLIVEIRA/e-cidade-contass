<?php

use Phinx\Migration\AbstractMigration;

class Oc12746 extends AbstractMigration
{
    public function up(){
        $this->addColumn();
        $this->addDicionarioDados();
        $this->atualizaCampo();
    }
    
    public function addColumn(){
        $this->execute("ALTER TABLE empenho.pagordem ADD COLUMN e50_compdesp DATE;");
    }

    public function addDicionarioDados(){
        $this->execute("INSERT INTO configuracoes.db_syscampo
                        VALUES ((SELECT max(codcam)+1 FROM configuracoes.db_syscampo), 
                                'e50_compdesp',
                                'date',
                                'Cód. Sequencial',
                                '',
                                'Compet. Despesa',
                                11,
                                FALSE,
                                FALSE,
                                FALSE,
                                1,
                                'date',
                                'Compet. Despesa')");

        $this->execute("INSERT INTO configuracoes.db_sysarqcamp
                        VALUES ((SELECT max(codarq) FROM configuracoes.db_sysarquivo),
                                (SELECT codcam FROM configuracoes.db_syscampo
                                WHERE nomecam = 'e50_compdesp'), 
                                1,
                                0)");
    }

    public function atualizaCampo(){
        $this->execute("UPDATE empenho.pagordem t1
                        SET e50_compdesp = e60_datasentenca
                        FROM empenho.empempenho
                        JOIN empenho.pagordem t2 ON e60_numemp = t2.e50_numemp
                        JOIN empenho.empelemento ON e64_numemp = e60_numemp
                        JOIN orcamento.orcelemento ON (o56_codele, o56_anousu) = (e64_codele, e60_anousu) 
                        WHERE e60_numemp = t1.e50_numemp
                        AND (substr(o56_elemento,1,7), e60_anousu) = ('3339092',2020)");
    }
}
