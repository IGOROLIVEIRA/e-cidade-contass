<?php

use Classes\PostgresMigration;

class CreateUsersContass2 extends PostgresMigration
{
    public function up()
    {
        $this->_run();
    }

    public function down()
    {
    }

    /**
     * Executa a migration com todas as dependencias
     */
    private function _run()
    {
        $data = array(
            array('HUGO DOS SANTOS PEREIRA', '', '486', 'NAO INFORMADO', 'PIRAPORA', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '70029674603', 'M', '2020-04-20 00:00:00.0', '16:58', 'HUGO DOS SANTOS PEREIRA', 'true', '0', '0', '3143302', 'user' => array('HUGO DOS SANTOS PEREIRA', 'hsp.contass', '129706d9673f2b2f4d01b35821abe46e78c07853', '1', 'hsp@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
            array('MARCIA MARIA DOS SANTOS', '', '486', 'NAO INFORMADO', 'PIRAPORA', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '03394059614', 'M', '2020-04-20 00:00:00.0', '16:58', 'MARCIA MARIA DOS SANTOS', 'true', '0', '0', '3143302', 'user' => array('MARCIA MARIA DOS SANTOS', 'mms.contass', 'b3e1cb661a778c76f1aa59e9ce6f292f8f8c7754', '1', 'mms@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
            array('JOSÉ DENISSON RUAS PEREIRA', '', '486', 'NAO INFORMADO', 'PIRAPORA', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '08289914644', 'M', '2020-04-20 00:00:00.0', '16:58', 'JOSÉ DENISSON RUAS PEREIRA', 'true', '0', '0', '3143302', 'user' => array('JOSÉ DENISSON RUAS PEREIRA', 'jdrp.contass', '2510dfdbc2a03f31550c8affec775e2b0614dca9', '1', 'jcccts@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
            array('JEFFERSON DA SILVA ALMEIDA', '', '486', 'NAO INFORMADO', 'Montes Claros', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '10200978683', 'M', '2020-04-20 00:00:00.0', '16:58', 'JEFFERSON DA SILVA ALMEIDA', 'true', '0', '0', '3143302', 'user' => array('JEFFERSON DA SILVA ALMEIDA', 'jsa.contass', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1', 'jsa@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
        );

        foreach ($data as $cgm) {

            $arrUser = $cgm['user'];
            unset($cgm['user']);

            $z01_numcgm = current($this->fetchRow("select nextval('cgm_z01_numcgm_seq')"));
            array_unshift($cgm, $z01_numcgm);
            $this->_loadCgm($cgm);

            $id_usuario = current($this->fetchRow("select nextval('db_usuarios_id_usuario_seq')"));
            array_unshift($arrUser, $id_usuario);
            $this->_loadUsers($arrUser);
            $this->_loadDepartamentos($id_usuario);
            $this->_loadPermissions($id_usuario);

            $this->_loadUsuaCgm(array($id_usuario, $z01_numcgm));

            $arrInstits = $this->fetchAll("select codigo from db_config");

            foreach ($arrInstits as $instit) {
                $this->_loadUserInstit(array($instit['codigo'], $id_usuario));
            }
        }
    }

    /**
     * Faz a carga dos dados na tabela cgm
     * @param Array $data
     */
    private function _loadCgm($data)
    {
        $columns = array(
            'z01_numcgm',
            'z01_nome',
            'z01_ender',
            'z01_numero',
            'z01_bairro',
            'z01_munic',
            'z01_uf',
            'z01_cep',
            'z01_cadast',
            'z01_login',
            'z01_numcon',
            'z01_nacion',
            'z01_estciv',
            'z01_tipcre',
            'z01_cgccpf',
            'z01_sexo',
            'z01_ultalt',
            'z01_hora',
            'z01_nomecomple',
            'z01_trabalha',
            'z01_renda',
            'z01_incmunici',
            'z01_ibge'
        );

        $this->table('cgm', array('schema' => 'protocolo'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela db_usuarios
     * @param Array $data
     */
    private function _loadUsers($data)
    {
        $columns = array(
            'id_usuario',
            'nome',
            'login',
            'senha',
            'usuarioativo',
            'email',
            'usuext',
            'administrador',
            'datatoken',
        );

        $this->table('db_usuarios', array('schema' => 'configuracoes'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela db_usuacgm
     * @param Array $data
     */
    private function _loadUsuaCgm($data)
    {
        $columns = array('id_usuario', 'cgmlogin');

        $this->table('db_usuacgm', array('schema' => 'configuracoes'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela db_userinst
     * @param Array $data
     */
    private function _loadUserInstit($data)
    {
        $columns = array('id_instit', 'id_usuario');

        $this->table('db_userinst', array('schema' => 'configuracoes'))->insert($columns, array($data))->saveData();
    }

    /**
     * Copia os mesmos departamentos do usuario dbseller
     * @param int $id_usuario
     */
    private function _loadDepartamentos($id_usuario)
    {
        $this->execute("insert into db_depusu select {$id_usuario}, coddepto, db17_ordem from db_depusu where id_usuario = 1 order by 2");
    }

    /**
     * Faz a carga das permissoes de acordo com as pemissoes do usuario dbseller
     * @param int $id_usuario
     */
    private function _loadPermissions($id_usuario)
    {
        $this->execute("insert into db_permissao select {$id_usuario}, id_item, permissaoativa, anousu, id_instit, id_modulo from db_permissao where id_usuario = 1 order by 2");
    }
}
