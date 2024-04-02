<?php

use Phinx\Migration\AbstractMigration;

class Oc22150 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        begin;
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'liclicita.l20_mododisputa','int8' ,'Modo de Disputa','', 'Modo de Disputa' ,11,false, false, false, 1, 'int8', 'Modo de Disputa');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'liclicita.l20_horaaberturaprop','varchar' ,'Hora Abertura','', 'Hora Abertura' ,11,false, false, false, 1, 'varchar', 'Hora Abertura');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'liclicita.l20_horaencerramentoprop','varchar' ,'Hora Encerramento','', 'Hora Encerramento' ,11,false, false, false, 1, 'varchar', 'Hora Encerramento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'liclicita.l20_justificativapncp','varchar' ,'Justificativa Presencial','', 'Justificativa Presencial' ,11,false, false, false, 1, 'varchar', 'Justificativa Presencial');
        commit;
        ";
        $this->execute($sql);

    }
}
