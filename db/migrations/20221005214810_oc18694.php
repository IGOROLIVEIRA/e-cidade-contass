<?php

use Phinx\Migration\AbstractMigration;

class Oc18694 extends AbstractMigration
{
    public function up()
    {
        $sql=" begin;
        update db_layoutcampos set db52_nome='ind_tipo_emp', db52_descr='IND_TIPO_EMP' where db52_codigo=4709;
        update db_layoutcampos set db52_nome='status_pag', db52_descr='STATUS_PAG' where db52_codigo=4726;
        delete from db_layoutcampos where db52_codigo in (4700,4704);
        delete from db_layoutcampos where db52_codigo in (4727, 4728, 4729);
        delete from db_layoutcampos where db52_codigo in (4747, 4752, 4753, 4754, 4755, 4756, 4757, 4758, 4759, 4762, 4763);
        commit;
        ";
        $this->execute($sql);
    }
}
