<?php

use Phinx\Migration\AbstractMigration;

class Oc21511 extends AbstractMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20231202185846_oc21511.json');
        $fontes = json_decode(utf8_decode($jsonDados));
        if ($fontes === null && json_last_error() !== JSON_ERROR_NONE) {
            // JSON decoding failed, handle the error here
            echo "Error decoding JSON: " . json_last_error_msg();
        } else {

            $this->fontes($fontes);
        }
    }

    public function fontes($fontes)
    {
        $this->runInsert($fontes);
        $this->runUpdate($fontes);
    }

    public function runInsert($fontes)
    {
        foreach ($fontes->incluir as $fonte) {

            $db121_sequencial = current($this->fetchRow("SELECT nextval('db_estruturavalor_db121_sequencial_seq')"));
            $db121_db_estrutura = 5;
            $db121_estrutural = "$fonte->CODIGO_ECID";
            $db121_descricao = "$fonte->DESCRICAO";
            $db121_estruturavalorpai = 0;
            $db121_nivel = 1;
            $db121_tipoconta = 1;

            $checkInsert = $this->fetchRow("SELECT * FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->CODIGO_ECID}'");

            if (empty($checkInsert)) {
                $aEstruturaValor = array($db121_sequencial, $db121_db_estrutura, $db121_estrutural, $db121_descricao, $db121_estruturavalorpai, $db121_nivel, $db121_tipoconta);
                $this->insertEstruturaValor($aEstruturaValor);
            }

            $checkInsert2 = $this->fetchRow("SELECT * FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->CODIGO_ECID}'");
            $checkFonte = $this->fetchRow("SELECT * FROM orctiporec WHERE o15_codigo = '{$fonte->CODIGO_ECID}'");

            if (!empty($checkInsert2) && empty($checkFonte)) {

                $o15_codigo = intval($fonte->CODIGO_ECID);
                $o15_descr = substr($fonte->DESCRICAO, 0, 59);
                $o15_codtri = $fonte->CODIGO_TCE;
                $o15_finali = $fonte->FINALIDADE;
                $o15_tipo = $fonte->TIPO_RECURSO == 'Recurso Livre' ? 1 : 2;
                $o15_datalimite = NULL;
                $o15_db_estruturavalor = current($this->fetchRow("SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '{$fonte->CODIGO_ECID}'"));
                $o15_codstn = "";
                $o15_codstnnovo = intval($fonte->CODIGO_STN);

                $aFonte = array($o15_codigo, $o15_descr, $o15_codtri, $o15_finali, $o15_tipo, $o15_datalimite, $o15_db_estruturavalor, $o15_codstn, $o15_codstnnovo);
                $this->insertFontes($aFonte);
            }
        }
    }

    public function runUpdate($fontes)
    {
        foreach ($fontes->inativar as $fonte) {

            $sql = "UPDATE orctiporec SET o15_datalimite = '{$fonte->Data_limite}' WHERE o15_codigo = {$fonte->Codigo}";
            $this->execute($sql);
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

        $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'configuracoes')));
        $this->table('db_estruturavalor', array('schema' => 'configuracoes'))->insert($fields, array($estruturaValor))->saveData();

    }

    public function insertFontes(array $fontes)
    {
        $this->execute("INSERT INTO orctiporec VALUES ($fontes[0], '{$fontes[1]}', '{$fontes[2]}', '{$fontes[3]}', $fontes[4], NULL, $fontes[6], NULL, $fontes[8])");

    }

}
