<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18728Fontes extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20221028111836_oc18728.json');
        $aDados = json_decode($jsonDados);

        foreach ($aDados->Novas_Fontes as $fonte) {

            $db121_sequencial           = current($this->fetchRow("SELECT nextval('db_estruturavalor_db121_sequencial_seq')"));
            $db121_db_estrutura         = 5;
            $db121_estrutural           = "$fonte->Fonte";
            $db121_descricao            = "$fonte->Descricao";
            $db121_estruturavalorpai    = 0;
            $db121_nivel                = 1;
            $db121_tipoconta            = 1;

            $checkInsert = $this->fetchRow("SELECT * FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->Fonte}'");

            if (empty($checkInsert)) {
                $aEstruturaValor = array($db121_sequencial, $db121_db_estrutura, $db121_estrutural, $db121_descricao, $db121_estruturavalorpai, $db121_nivel, $db121_tipoconta);
                $this->insertEstruturaValor($aEstruturaValor);
            }

            $checkInsert2 = $this->fetchRow("SELECT * FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->Fonte}'");
            $checkFonte  = $this->fetchRow("SELECT * FROM orctiporec WHERE o15_codigo = '{$fonte->Fonte}'");

            if (!empty($checkInsert2) && empty($checkFonte)){

                $o15_codigo             = intval($fonte->Fonte);
                $o15_descr              = substr($fonte->Descricao, 0, 59);
                $o15_codtri             = $fonte->Cod_TCE;
                $o15_finali             = $fonte->Finalidade;
                $o15_tipo               = 2;
                $o15_datalimite         = NULL;
                $o15_db_estruturavalor  = current($this->fetchRow("SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->Fonte}'"));
                $o15_codstn             = $fonte->Cod_STN;
                $o15_codstnnovo         = intval($fonte->Cod_STN);

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

    }

    public function down()
    {
        $jsonDadosDown = file_get_contents('db/migrations/20221028111836_oc18728.json');
        $aDadosDown    = json_decode($jsonDadosDown);

        foreach ($aDadosDown->Novas_Fontes as $fonte) {

        $this->execute("DELETE FROM orctiporec WHERE o15_codigo = {$fonte->Fonte}");
        $this->execute("DELETE FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->Fonte}'");
       }
    }
}
