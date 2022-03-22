<?php

use Phinx\Migration\AbstractMigration;

class Esocial1010Update extends AbstractMigration
{
    public function up()
    {
        if (!$this->checkField()) {
            return;
        }
        $sql = "
        UPDATE rhrubricas SET rh27_codincidirrf = 3003810 WHERE rh27_codincidirrf = 3003846;

        UPDATE avaliacaoperguntaopcao
        SET db104_valorresposta = '1'
        WHERE db104_avaliacaopergunta = 3000948
            AND db104_valorresposta = '01';

        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
     ((SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao),3000948,'Verba transitada pela folha de pagamento de natureza diversa de rendimento ou retenção/isenção/dedução de IR',false,'verba-transitada-folha',9,'9','codIncIRRF_09');

     UPDATE baserubricasesocial SET e991_rubricasesocial = '9299' WHERE e991_rubricasesocial = '9290';
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        UPDATE rhrubricas SET rh27_codincidirrf = 3003846 WHERE rh27_codincidirrf = 3003810;

        UPDATE avaliacaoperguntaopcao
        SET db104_valorresposta = '01'
        WHERE db104_avaliacaopergunta = 3000948
            AND db104_valorresposta = '1';

        DELETE FROM avaliacaoperguntaopcao WHERE db104_identificador = 'verba-transitada-folha' AND db104_identificadorcampo = 'codIncIRRF_09';

        UPDATE baserubricasesocial SET e991_rubricasesocial = '9290' WHERE e991_rubricasesocial = '9299';
        ";
        $this->execute($sql);
    }

    private function checkField()
    {
        $result = $this->fetchRow("SELECT * FROM avaliacaoperguntaopcao WHERE db104_identificador = 'verba-transitada-folha' AND db104_identificadorcampo = 'codIncIRRF_09'");
        if (empty($result)) {
            return true;
        }
        return false;
    }
}
