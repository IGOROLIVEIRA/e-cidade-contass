<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class M8642ManutencaoJustificativaEmLote extends PostgresMigration
{
    public function up()
    {
        $this->execute("insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10430 ,'Lan�amento de Justificativas em Lote' ,'Lan�amento de Justificativas em Lote' ,'rec4_manutencaojustificativaslote.php' ,'1' ,'1' ,'Inclui justificativas para v�rios servidores atrav�s de sele��o ou matr�culas.' ,'true' );");
        $this->execute("insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10384 ,10430 ,5 ,2323 );");
    }

    public function down()
    {
        $this->execute("delete from db_menu where id_item_filho = 10430 AND modulo = 2323;");
        $this->execute("delete from db_itensmenu where id_item = 10430;");
    }
}
