<?php

use Phinx\Migration\AbstractMigration;

class InserirRespostaRubricaCodIncidIrrf extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_identificadorcampo,db104_valorresposta)
            VALUES ((SELECT MAX(db104_sequencial)+1 FROM avaliacaoperguntaopcao),
                    3000948,
                    'Parte não tributável do valor de serviço de transporte de passageiros ou cargas',
                    'deducoes-irrf-parte-nao-tributavel',
                    FALSE,
                    701,
                    'codIncIRRF_701',
                    701)";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM avaliacaoperguntaopcao WHERE db104_identificador = 'deducoes-irrf-parte-nao-tributavel' AND db104_avaliacaopergunta = 3000948";
        $this->execute($sql);
    }
}
