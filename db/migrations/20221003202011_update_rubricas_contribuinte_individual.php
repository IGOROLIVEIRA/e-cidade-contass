<?php

use Phinx\Migration\AbstractMigration;

class UpdateRubricasContribuinteIndividual extends AbstractMigration
{

    public function up()
    {
        
        $sql = "
            UPDATE rhrubricas SET rh27_codincidirrf = (select db104_sequencial  from avaliacaoperguntaopcao where db104_descricao ilike 'Parte não tributável do valor de serviço de transporte de passageiros ou cargas' LIMIT 1) WHERE rh27_rubric IN ('R002','R003');
                    ";
        $this->execute($sql);
    }

    public function down() 
    {
        $sql = "
            UPDATE rhrubricas SET rh27_codincidirrf = 4003071 WHERE rh27_rubric IN ('R002','R003');
                    ";
        $this->execute($sql);
    }
}
