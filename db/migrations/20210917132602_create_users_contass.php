<?php

use Classes\PostgresMigration;

class CreateUsersContass extends PostgresMigration
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
            array('FILIPI PEREIRA CASTRO', '', '486', 'SANTOS DUMONT', 'PIRAPORA', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '12220512657', 'M', '2020-04-20 00:00:00.0', '16:58', 'FILIPI PEREIRA CASTRO', 'true', '0', '0', '3143302', 'user' => array('FILIPI PEREIRA CASTRO', 'fpc.contass', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1', 'fpc@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
            array('ALESSIA EVILA BATISTA RODRIGUES', '', '486', 'JOSE BANDEIRA DA MOTA', 'PIRAPORA', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '13448715697', 'M', '2020-04-20 00:00:00.0', '16:58', 'ALESSIA EVILA BATISTA RODRIGUES', 'true', '0', '0', '3143302', 'user' => array('ALESSIA EVILA BATISTA RODRIGUES', 'aebr.contass', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1', 'aebr@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
            array('JULIANA CRISTINA CAPISTRANO COTTA SOUZA', '', '486', 'OLÍMPIO CASSIMIRO', 'SETE LAGOAS', 'MG', '39270000', '2020-04-20 00:00:00.0', '1', '0', '1', '1', '0', '04370129648', 'M', '2020-04-20 00:00:00.0', '16:58', 'JULIANA CRISTINA CAPISTRANO COTTA SOUZA', 'true', '0', '0', '3143302', 'user' => array('JULIANA CRISTINA CAPISTRANO COTTA SOUZA', 'jcccts.contass', '10470c3b4b1fed12c3baac014be15fac67c6e815', '1', 'jcccts@contassconsultoria.com.br', '0', '1', '2020-04-20 00:00:00.0')),
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
