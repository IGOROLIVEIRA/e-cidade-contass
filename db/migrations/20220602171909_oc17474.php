<?php

use Phinx\Migration\AbstractMigration;

class Oc17474 extends AbstractMigration
{
    public function up()
    {
        $sql = "alter table orcparametro add column o50_controlaexcessoarrecadacao boolean;
                update orcparametro set o50_controlaexcessoarrecadacao = 't' where o50_anousu = 2022;";

     $this->execute($sql);

    }

    public function down()
    {
     $sql = "alter table orcparametro drop column o50_controlaexcessoarrecadacao;";
     $this->execute($sql);
    }
}
