<?php

use Phinx\Migration\AbstractMigration;

class AjustaCadastroUsers extends AbstractMigration
{

    public function up()
    {
        $arrUsers = array(
            array('nome' => 'MARIA FERNANDA MURCA MACHADO', 'login' => 'mfmm.contass', 'senha' => '8c86496d9f2a57ec0a84578e77f1086dc0825f2b', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-04 00:00:00.0'),
            array('nome' => 'JUNIOR JADSON ARAUJO DOS SANTOS', 'login' => 'jjas.contass', 'senha' => '79fed642ca7cb2876f6b846135a4285b3f6cfb5e', 'usuarioativo' => '1', 'email' => 'junior.santos@contassconsultoria.com.br', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-04 00:00:00.0'),
            array('nome' => 'RAFAELA ALVES CARDOSO', 'login' => 'rac.contass', 'senha' => 'f194690cbb115068b498687bf7b7ac86f737f8f6', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-04 00:00:00.0'),
            array('nome' => 'MAX WENDEL DE OLIVEIRA', 'login' => 'mwo.contass', 'senha' => '9b6955f57aab44af55a3fe6c09d781ba5b522f29', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-04 00:00:00.0'),
            array('nome' => 'ROMULO NERIO SANTOS SILVA', 'login' => 'rnss.contass', 'senha' => '50ab4989e82fab1e0cbffaea0acddea5ad5f6ce7', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-09 00:00:00.0'),
            array('nome' => 'FRANCYELE MENDES ALVES OLIVEIRA', 'login' => 'fmao.contass', 'senha' => 'fa86accab2c5fb101e1e9c17ada95775f5c1abd0', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-04-02 00:00:00.0'),
            array('nome' => 'REDIMILSON FRANCISCO OLIVA', 'login' => 'rfo.contass', 'senha' => '54342dee46b5d0ae1df13d9a3f39c212e40d9d71', 'usuarioativo' => '1', 'email' => 'redimilson@contassconsultoria.com.br', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-11 00:00:00.0'),
            array('nome' => 'HELLEN CHRISTINA GOMES CAMPOS', 'login' => 'hcgc.contass', 'senha' => 'ed93dc4cac453566f4c97ee512b520153e025abf', 'usuarioativo' => '1', 'email' => '', 'usuext' => '0', 'administrador' => '1', 'datatoken' => '2020-03-11 00:00:00.0'),
        );

        foreach ($arrUsers as $user) {
            $userEcidade = $this->fetchRow("select * from db_usuarios where login = '{$user['login']}'");

            $cgm = $this->fetchRow("select z01_numcgm from cgm where z01_nome = '{$user['nome']}' limit 1");

            $this->execute("update db_usuarios set nome = '{$user['nome']}' where id_usuario = {$userEcidade['id_usuario']}");

            $this->execute("update db_usuacgm set cgmlogin = {$cgm['z01_numcgm']} where id_usuario = {$userEcidade['id_usuario']}");
        }

    }

    public function down()
    {

    }
}
