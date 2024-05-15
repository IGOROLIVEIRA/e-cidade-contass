<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18020 extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20220715174851_oc18020.json');
        $dados = json_decode($jsonDados);

        $this->execute("UPDATE orctiporec SET o15_datalimite = '2022-12-31'");

        $this->execute("UPDATE db_estruturanivel
                        SET db78_tamanho = 8
                        WHERE db_estruturanivel.db78_codestrut = 5");

        $this->execute("UPDATE db_estrutura
                        SET db77_estrut = '00000000'
                        WHERE db_estrutura.db77_codestrut = 5 ");

        foreach ($dados->fontes as $fonte) {

            $db121_sequencial           = current($this->fetchRow("SELECT nextval('db_estruturavalor_db121_sequencial_seq')"));
            $db121_db_estrutura         = 5;
            $db121_estrutural           = $fonte->FONTE_DETALHAMENTO;
            $db121_descricao            = $fonte->DESCRICAO;
            $db121_estruturavalorpai    = 0;
            $db121_nivel                = 1;
            $db121_tipoconta            = 1;

            $aEstruturaValor = array($db121_sequencial, $db121_db_estrutura, $db121_estrutural, $db121_descricao, $db121_estruturavalorpai, $db121_nivel, $db121_tipoconta);
            $this->insertEstruturaValor($aEstruturaValor);

            $checkInsert = $this->fetchRow("SELECT * FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->FONTE_DETALHAMENTO}'");
            $checkFonte  = $this->fetchRow("SELECT * FROM orctiporec WHERE o15_codigo = '{$fonte->FONTE_DETALHAMENTO}'");

            if (!empty($checkInsert) && empty($checkFonte)) {

                $o15_codigo             = intval($fonte->FONTE_DETALHAMENTO);
                $o15_descr              = substr($fonte->DESCRICAO, 0, 59);
                $o15_codtri             = $fonte->COD_TCE;
                $o15_finali             = $fonte->FINALIDADE;
                $o15_tipo               = ($fonte->TIPO_RECURSO == "LIVRE" ? 1 : 2);
                $o15_datalimite         = NULL;
                $o15_db_estruturavalor  = current($this->fetchRow("SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->FONTE_DETALHAMENTO}'"));
                $o15_codstn             = $fonte->COD_STN_ANT;
                $o15_codstnnovo         = intval($fonte->COD_STN);

                $aFonte = array($o15_codigo, $o15_descr, $o15_codtri, $o15_finali, $o15_tipo, $o15_datalimite, $o15_db_estruturavalor, $o15_codstn, $o15_codstnnovo);
                $this->insertFontes($aFonte);
            }
        }

    }

    public function insertEstruturaValor(array $estruturaValor)
    {
        $fields = array(
            'db121_sequencial',
            'db121_db_estrutura',
            'db121_estrutural',
            'db121_descricao',
            'db121_estruturavalorpai',
            'db121_nivel',
            'db121_tipoconta'
        );

        $this->table('db_estruturavalor', array('schema' => 'configuracoes'))->insert($fields, array($estruturaValor))->saveData();

    }

    public function insertFontes(array $fontes)
    {
        $this->execute("INSERT INTO orctiporec VALUES ($fontes[0], '{$fontes[1]}', '{$fontes[2]}', '{$fontes[3]}', $fontes[4], NULL, $fontes[6], NULL, $fontes[8])");
        
        if ($fontes[0] == 132 || $fontes[0] == 232) {
            $this->execute("UPDATE orctiporec SET o15_datalimite = '2022-12-31'");
        }
    
    }

    public function down()
    {
        $jsonDados = file_get_contents('db/migrations/20220715174851_oc18020.json');
        $dados = json_decode($jsonDados);

        $this->execute("UPDATE db_estruturanivel
                        SET db78_tamanho = 3
                        WHERE db_estruturanivel.db78_codestrut = 5");

        $this->execute("UPDATE db_estrutura
                        SET db77_estrut = '000'
                        WHERE db_estrutura.db77_codestrut = 5 ");

        foreach ($dados->fontes as $fonte) {

            $this->execute("DELETE FROM orctiporec WHERE o15_codigo = $fonte->FONTE_DETALHAMENTO");
            $this->execute("DELETE FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->FONTE_DETALHAMENTO}'");
        }
    }
}
