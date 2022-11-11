<?php

use Phinx\Migration\AbstractMigration;

class Oc17299v2 extends AbstractMigration
{

    public function up()
    {
        $sql = "begin;";

        $sql .= "insert into permanexo(p202_sequencial, p202_tipo ) values ((select nextval('permanexo_p202_sequencial_seq')),'Todos/Público');";

        $aRowsPerfis =   $this->fetchAll("select id_usuario from (select distinct u.id_usuario,u.nome,u.login from db_usuarios u
        inner join db_permissao p on p.id_usuario = u.id_usuario where u.usuarioativo = 1 and u.usuext = 2) as x order by lower(login)");

        foreach ($aRowsPerfis as $perfil) {
            $sql .= "insert into perfispermanexo (p203_permanexo,p203_perfil) values ((select last_value from permanexo_p202_sequencial_seq),{$perfil['id_usuario']})";
        }

        $sql .= "commit;";

        $this->execute($sql);
    }
}
