<?php

use Classes\PostgresMigration;

class LoadUsersEcidade extends PostgresMigration
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

            array('VICTOR COSTA LAFETA', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-01-01 00:00:00.0', '1', '0', '1', '1', '0', '09570803606', 'M', '2020-01-01 00:00:00.0', '10:12', 'VICTOR COSTA LAFETA', 'true', '0', '0', '3143302', 'user' => array('VICTOR COSTA LAFETA', 'vcl.contass', '38b4d50831623cf534f46b746d9d051f845861f7', '1', 'victor.lafeta@contassconsultoria.com.br', '0', '1', '2020-03-10 00:00:00.0')),
            array('ALZIRIS MARTINS DE SOUZA', 'RUA TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '08355491602', 'M', '2020-03-04 00:00:00.0', '10:32', 'ALZIRIS MARTINS DE SOUZA', 'true', '0', '0', 'null', 'user' => array('ALZIRIS MARTINS DE SOUZA', 'ams.contass', 'd2f9c7fa8c17c5806bbee92bcdd8fc7212e2bb24', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('BÁRBARA DE SOUZA OTONI', 'TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '12958969665', 'M', '2020-03-04 00:00:00.0', '10:35', 'BÁRBARA DE SOUZA OTONI', 'true', '0', '0', '3143302', 'user' => array('BÁRBARA DE SOUZA OTONI', 'bso.contass', 'f21a87ddfe10b0c89b3f1412653ae5a74572f05c', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('JUNIOR JADSON ARAUJO DOS SANTOS', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '10909716641', 'M', '2020-03-04 00:00:00.0', '10:35', 'JUNIOR JADSON ARAUJO DOS SANTOS', 'true', '0', '0', 'null', 'user' => array('MARIA FERNANDA MURCA MACHADO', 'mfmm.contass', '8c86496d9f2a57ec0a84578e77f1086dc0825f2b', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('MARIA FERNANDA MURCA MACHADO', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '09421705637', 'F', '2020-03-04 00:00:00.0', '10:38', 'MARIA FERNANDA MURCA MACHADO', 'true', '0', '0', '3143302', 'user' => array('JUNIOR JADSON ARAUJO DOS SANTOS', 'jjas.contass', '79fed642ca7cb2876f6b846135a4285b3f6cfb5e', '1', 'junior.santos@contassconsultoria.com.br', '0', '1', '2020-03-04 00:00:00.0')),
            array('MAX WENDEL DE OLIVEIRA', 'BRUNO', '120', 'BARCELONA PARK', 'MONTES CLAROS', 'MG', '39401823', '2020-01-01 00:00:00.0', '1', '0', '1', '1', '0', '08130291630', 'M', '2020-01-01 00:00:00.0', '10:40', 'MAX WENDEL DE OLIVEIRA', 'true', '0', '0', '3143302', 'user' => array('RAFAELA ALVES CARDOSO', 'rac.contass', 'f194690cbb115068b498687bf7b7ac86f737f8f6', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('RAFAELA ALVES CARDOSO', 'GAL CAMARA', '0', 'BAIRRO B', 'MONTES CLAROS', 'MG', '39400053', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '11753716616', 'F', '2020-03-04 00:00:00.0', '10:42', 'RAFAELA ALVES CARDOSO', 'true', '0', '0', 'null   ', 'user' => array('MAX WENDEL DE OLIVEIRA', 'mwo.contass', '9b6955f57aab44af55a3fe6c09d781ba5b522f29', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('NÁDJA KARINE DE SOUZA', 'DOUTOR SIDNEY CHAVES', '1171', 'EDGAR PEREIRA', 'MONTES CLAROS', 'MG', '39400648', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '04265996671', 'F', '2020-03-04 00:00:00.0', '10:47', 'NÁDJA KARINE DE SOUZA', 'true', '0', '0', '3143302', 'user' => array('NÁDJA KARINE DE SOUZA', 'nks.contass', '7b461ff36f9758c96439ae6ba1aeeeeb84e61b59', '1', 'karine@contassconsultoria.com.br', '0', '1', '2020-03-04 00:00:00.0')),
            array('JOSE DOMINGOS FAUSTINO', 'RUA TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-01-01 00:00:00.0', '1', '0', '1', '1', '0', '77617614691', 'M', '2020-01-01 00:00:00.0', '10:53', 'JOSE DOMINGOS FAUSTINO', 'true', '0', '0', 'null   ', 'user' => array('JOSE DOMINGOS FAUSTINO', 'jdf.contass', '550541b7cd1dbff815ebce98816451b5518717fb', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('LUKAS COELHO', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '07800349616', 'M', '2020-03-04 00:00:00.0', '13:49', 'LUKAS COELHO', 'true', '0', '0', '5101001', 'user' => array('LUKAS COELHO', 'lc.contass', '6d9121c855d3dbc5d81d202af70cede5fba3be78', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('IGOR FRANCISCO', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '13399908652', 'M', '2020-03-04 00:00:00.0', '14:16', 'IGOR FRANCISCO', 'true', '0', '0', '5300108', 'user' => array('IGOR FRANCISCO', 'ifs.contass', 'b57c054175af65f2ff2c0fda653f925c92f6ce94', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('DANILO MACEDO SILVA', 'DAS AMÉRICAS', '1800', 'INDEPENDÊNCIA', 'MONTES CLAROS', 'MG', '39404303', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '09049625630', 'M', '2020-03-04 00:00:00.0', '16:41', 'DANILO MACEDO SILVA', 'true', '0', '0', '3143302', 'user' => array('DANILO MACEDO SILVA', 'dms.contass', '7c490077e4140de0705f37f9cf6a62396fd44a35', '1', '', '0', '1', '2020-03-09 00:00:00.0')),
            array('DEBORAH LOANE VIEIRA ALVES', 'SIMON BOLIVAR', '240', 'INDEPENDÊNCIA', 'MONTES CLAROS', 'MG', '39404591', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '08965946611', 'F', '2020-03-04 00:00:00.0', '16:42', 'DEBORAH LOANE VIEIRA ALVES', 'true', '0', '0', '3143302', 'user' => array('DEBORAH LOANE VIEIRA ALVES', 'dlva.contass', 'fa784407a53442f96f57f301715d48bb719e3616', '1', '', '0', '1', '2020-03-04 00:00:00.0')),
            array('FRANCYELE MENDES ALVES OLIVEIRA', 'JATOBÁ', '286', 'PLANALTO', 'MONTES CLAROS', 'MG', '', '2020-03-04 00:00:00.0', '1', '0', '1', '2', '0', '09138066688', 'F', '2020-03-04 00:00:00.0', '16:51', 'FRANCYELE MENDES ALVES OLIVEIRA', 'true', '0', '0', 'null   ', 'user' => array('ROMULO NERIO SANTOS SILVA', 'rnss.contass', '50ab4989e82fab1e0cbffaea0acddea5ad5f6ce7', '1', '', '0', '0', '2020-03-09 00:00:00.0')),
            array('ROMULO NERIO SANTOS SILVA', 'CORIOLANO GONZAGA', '686', 'MAJOR PRATES', 'MONTES CLAROS', 'MG', '', '2020-03-04 00:00:00.0', '1', '0', '1', '1', '0', '12329351666', 'M', '2020-03-04 00:00:00.0', '16:51', 'ROMULO NERIO SANTOS SILVA', 'true', '0', '0', '3143302', 'user' => array('FRANCYELE MENDES ALVES OLIVEIRA', 'fmao.contass', 'fa86accab2c5fb101e1e9c17ada95775f5c1abd0', '1', '', '0', '1', '2020-04-02 00:00:00.0')),
            array('IGOR AFONSO OLIVEIRA RUAS', 'TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-03-05 00:00:00.0', '1', '0', '1', '2', '0', '05872917619', 'M', '2020-03-05 00:00:00.0', '10:02', 'IGOR AFONSO OLIVEIRA RUAS', 'true', '0', '0', '3143302', 'user' => array('IGOR AFONSO OLIVEIRA RUAS', 'iaor.contass', '977ab730c858de64ff7a4a700473cf9c4a78ce7f', '1', 'igor@contassconsultoria.com.br', '0', '1', '2020-03-05 00:00:00.0')),
            array('MAISA CAETANO DE OLIVEIRA', 'PORTUGAL', '698', 'INDEPENDÊNCIA', 'MONTES CLAROS', 'MG', '', '2020-03-05 00:00:00.0', '1', '0', '1', '1', '0', '10855958626', 'M', '2020-03-05 00:00:00.0', '13:54', 'MAISA CAETANO DE OLIVEIRA', 'true', '0', '0', 'null   ', 'user' => array('MAISA CAETANO DE OLIVEIRA', 'mco.contass', 'a9be985526ef8dc944a3893b27cc6912823c5cf7', '1', '', '0', '1', '2020-03-05 00:00:00.0')),
            array('WESLEY CAETANO DE OLIVEIRA', 'CRISTINA VASCONCELOS', '6', 'CENTRO', 'MONTES CLAROS', 'MG', '39400000', '2020-01-01 00:00:00.0', '1', '0', '1', '1', '0', '10859875660', 'M', '2020-01-01 00:00:00.0', '09:29', 'WESLEY CAETANO DE OLIVEIRA', 'true', '0', '0', 'null   ', 'user' => array('WESLEY CAETANO DE OLIVEIRA', 'wco.contass', 'b72f9a01d429736892501edb00b91a142fa643f0', '1', '', '0', '1', '2020-03-09 00:00:00.0')),
            array('LORENN SUSY ALMEIDA CRUZ', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-09 00:00:00.0', '1', '0', '1', '1', '0', '11833155629', 'F', '2020-03-09 00:00:00.0', '14:43', 'LORENN SUSY ALMEIDA CRUZ', 'true', '0', '0', '3143302', 'user' => array('LORENN SUSY ALMEIDA CRUZ', 'los.contass', 'f1c22234ae4c79cde1100e8d794eaaeb74f0c9fe', '1', '', '0', '0', '2020-03-09 00:00:00.0')),
            array('MARCOS RODRIGO BATSITA CABRAL', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400000', '2020-03-10 00:00:00.0', '1', '0', '1', '1', '0', '08204040636', 'M', '2020-03-10 00:00:00.0', '10:03', 'MARCOS RODRIGO BATSITA CABRAL', 'true', '0', '0', 'null   ', 'user' => array('MARCOS RODRIGO BATSITA CABRAL', 'mrbc.contass', '58376b689d5e3614bacd30ee6d78385fa3bde831', '1', 'rodrigo.cabral@contassconsultoria.com.br', '0', '1', '2020-03-10 00:00:00.0')),
            array('IVAN FONSECA DE OLIVEIRA', 'RUA TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-03-11 00:00:00.0', '1', '0', '1', '1', '0', '46418911687', 'M', '2020-03-11 00:00:00.0', '15:52', 'IVAN FONSECA DE OLIVEIRA', 'true', '0', '0', 'null   ', 'user' => array('IVAN FONSECA DE OLIVEIRA', 'ifo.contass', 'ddfd58925d37998c50188ed7b21911245b3685c0', '1', '', '0', '0', '2020-03-11 00:00:00.0')),
            array('HELLEN CHRISTINA GOMES CAMPOS', 'TUPIS', '437', 'MELO', 'MONTES CLAROS', 'MG', '39401068', '2020-03-11 00:00:00.0', '1', '0', '1', '2', '0', '06062159645', 'F', '2020-03-11 00:00:00.0', '16:55', 'HELLEN CHRISTINA GOMES CAMPOS', 'true', '0', '0', '3143302', 'user' => array('REDIMILSON FRANCISCO OLIVA', 'rfo.contass', '54342dee46b5d0ae1df13d9a3f39c212e40d9d71', '1', 'redimilson@contassconsultoria.com.br', '0', '1', '2020-03-11 00:00:00.0')),
            array('REDIMILSON FRANCISCO OLIVA', 'SABIÁ', '316', 'ALCIDES RABELO', 'MONTES CLAROS', 'MG', '39401416', '2020-03-11 00:00:00.0', '1', '0', '1', '2', '0', '40480410615', 'M', '2020-03-11 00:00:00.0', '16:56', 'REDIMILSON FRANCISCO OLIVA', 'true', '0', '0', '3143302', 'user' => array('HELLEN CHRISTINA GOMES CAMPOS', 'hcgc.contass', 'ed93dc4cac453566f4c97ee512b520153e025abf', '1', '', '0', '1', '2020-03-11 00:00:00.0')),
            array('ELVIO AQUINO AMARAL', 'NAO INFORMADO', '437', 'CENTRO', 'MONTES CLAROS', 'MG', '39400000', '2020-03-16 00:00:00.0', '1', '0', '1', '2', '0', '08421719670', 'M', '2020-03-16 00:00:00.0', '13:56', '', 'false', '0', '0', 'null   ', 'user' => array('ELVIO AQUINO AMARAL', 'eaa.contass', '3a900e02a2ab203eba5bc73cbd153b97036b0582', '1', '', '0', '1', '2020-03-16 00:00:00.0')),
            array('ROBSON DE JESUS', 'NAO INFORMADO', '0', 'NAO INFORMADO', 'MONTES CLAROS', 'MG', '39400053', '2020-03-26 00:00:00.0', '1', '0', '1', '2', '0', '09801984619', 'M', '2020-03-26 00:00:00.0', '11:25', 'ROBSON DE JESUS', 'true', '0', '0', '3143302', 'user' => array('ROBSON DE JESUS', 'rjgs.contass', '9b4caba62d2262e2f493d75ebfc0d72a67886549', '1', '', '0', '1', '2020-03-26 00:00:00.0')),

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
        $columns = array('z01_numcgm',
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
            'z01_ibge');

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
