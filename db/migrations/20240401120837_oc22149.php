<?php

use Phinx\Migration\AbstractMigration;

class Oc22149 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            begin;

            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'tipoinstrumentoconvocatorioid','int8' ,'Instrumento Convocatorio' ,'', 'Instrumento Convocatorio' ,11   ,false, false, false, 1, 'int8', 'Instrumento Convocatorio');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'pc80_modalidadecontratacao','int8' ,'Modalidade de Contratação' ,'', 'Modalidade de Contratação' ,11   ,false, false, false, 1, 'int8', 'Modalidade de Contratação');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l213_dtlancamento','date' ,'Data lançamento' ,'', 'Data lançamento' ,11   ,false, false, false, 1, 'date', 'Data lançamento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'pc80_orcsigiloso','bool' ,'Orçamento Sigiloso' ,'', 'Orçamento Sigiloso' ,11   ,false, false, false, 1, 'bool', 'Orçamento Sigiloso');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'mododisputaid','int8' ,'Modo Disputa' ,'', 'Modo Disputa' ,11   ,false, false, false, 1, 'int8', 'Modo Disputa');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'pc80_criteriojulgamento','int8' ,'Critério de Julgamento' ,'', 'Criterio de Julgamento' ,11   ,false, false, false, 1, 'int8', 'Criterio de Julgamento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l212_lei','int8' ,'Amaparo Legal' ,'', 'Amaparo Legal' ,11   ,false, false, false, 1, 'int8', 'Amaparo Legal');

            commit;
        ";

        $this->execute($sql);
    }
}
