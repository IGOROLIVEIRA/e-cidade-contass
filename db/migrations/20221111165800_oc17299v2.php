<?php

use Phinx\Migration\AbstractMigration;

class Oc17299v2 extends AbstractMigration
{

    public function up()
    {
        $sql1 = "begin;";
        $sql1 .= "insert into permanexo(p202_sequencial, p202_tipo ) values ((select nextval('permanexo_p202_sequencial_seq')),'Todos/Público');";
        $sql1 .= "commit;";
        $this->execute($sql1);
        $sql2 = "begin;";
        $aRowsPerfis =   $this->fetchAll("select id_usuario from (select distinct u.id_usuario,u.nome,u.login from db_usuarios u
        inner join db_permissao p on p.id_usuario = u.id_usuario where u.usuarioativo = 1 and u.usuext = 2) as x order by lower(login);");

        foreach ($aRowsPerfis as $perfil) {
            $sql2 .= "insert into perfispermanexo (p203_permanexo,p203_perfil) values ((select max(p202_sequencial) from permanexo),{$perfil['id_usuario']});";
        }

        $sql2 .= "commit;";

        $this->execute($sql2);
    }
}
