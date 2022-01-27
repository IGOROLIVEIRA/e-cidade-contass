<?php

use Phinx\Migration\AbstractMigration;

class EsocialAddideRubrica extends AbstractMigration
{

    public function up()
    {
        $result = $this->fetchRow("SELECT * FROM avaliacaogrupopergunta WHERE db102_identificador='identificacao-da-rubrica'");
        if (empty($result['db102_sequencial'])) {
            $this->executeSql();
        }
    }

    public function down()
    {

    }

    public function executeSql()
    {
        $sql = "INSERT INTO avaliacaogrupopergunta 
                VALUES((select max(db102_sequencial)+1 from avaliacaogrupopergunta),3000016,
                    'Identificação da Rubrica','identificacao-da-rubrica','ideRubrica');


                UPDATE avaliacaopergunta 
                 SET db103_avaliacaogrupopergunta = (select max(db102_sequencial) from avaliacaogrupopergunta)
                 WHERE db103_sequencial in (3000940,3000941,3000942,3000943);

                ALTER TABLE avaliacaogrupopergunta ADD COLUMN db102_ordem INTEGER DEFAULT 0;

                UPDATE avaliacaogrupopergunta SET db102_ordem = 
                (SELECT row_number+1 FROM (SELECT row_number() OVER (PARTITION BY 0) as row_number,av.db102_sequencial 
                   FROM avaliacaogrupopergunta av 
                   WHERE av.db102_avaliacao = 3000016) AS ordem  
                  WHERE ordem.db102_sequencial=avaliacaogrupopergunta.db102_sequencial) 
                 WHERE db102_avaliacao = 3000016;

                UPDATE avaliacaogrupopergunta SET db102_ordem = 1 
                 WHERE db102_sequencial = (select max(db102_sequencial) from avaliacaogrupopergunta);";
        $this->execute($sql);
    }
}
