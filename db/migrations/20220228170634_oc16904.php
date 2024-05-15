<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc16904 extends PostgresMigration
{
    public function up()
    {
        $aFontesLivres = array(1, 100, 200, 170, 270);
        if(($handle = fopen("db/migrations/fonterecurso2022.txt", "r")) !== FALSE)  {
            while ( ($aFontes = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($aFontes[0] === 'codfonte'){
                    continue;
                }
                $o15_codigo     = $aFontes[0];
                $o15_descr      = $aFontes[4];
                $o15_codtri     = $aFontes[1];
                $o15_finali     = $aFontes[5];
                $o15_tipo       = in_array($aFontes[0], $aFontesLivres) ? 1 : 2;
                $o15_codstnnovo = $aFontes[2];

                $db121_sequencial        = 0;
                $db121_db_estrutura      = 5;
                $db121_estrutural        = $aFontes[0];
                $db121_descricao         = $aFontes[4];
                $db121_estruturavalorpai = 0;
                $db121_nivel             = 0;
                $db121_tipoconta         = 1;

                $aFonteExist = $this->fetchRow("select o15_codigo, o15_db_estruturavalor from orctiporec where o15_codigo={$o15_codigo}");
                if(empty($aFonteExist)){
                    $aDB121_sequencialExist = $this->fetchRow("select db121_sequencial from db_estruturavalor where db121_db_estrutura=5 and db121_estrutural='{$o15_codigo}'");
                    $db121_sequencial = $aDB121_sequencialExist[0];
                    if(empty($aDB121_sequencialExist)){
                        $db121_sequencial = current($this->fetchRow("select nextval('db_estruturavalor_db121_sequencial_seq')"));
                        $this->insertEstruturalValor(array($db121_sequencial, $db121_db_estrutura, $db121_estrutural, $db121_descricao, $db121_estruturavalorpai, $db121_nivel, $db121_tipoconta));
                    }
                    $this->insertFonte(array($o15_codigo, $o15_descr, $o15_codtri, $o15_finali, $o15_tipo, $db121_sequencial, $o15_codstnnovo));
                    continue;
                }
                $o15_db_estruturavalor = $aFonteExist[1];
                $this->updateEstruturalValor(array($db121_db_estrutura, $db121_estrutural, $db121_descricao, $db121_estruturavalorpai, $db121_nivel, $db121_tipoconta), $o15_db_estruturavalor);
                $this->updateFonte(array($o15_descr, $o15_codtri, $o15_finali, $o15_tipo, $o15_db_estruturavalor, $o15_codstnnovo), $o15_codigo);
            }
        }
    }

    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertFonte($data)
    {
        $columns = array('o15_codigo',
            'o15_descr',
            'o15_codtri',
            'o15_finali',
            'o15_tipo',
            'o15_db_estruturavalor',
            'o15_codstnnovo');

        $this->table('orctiporec', array('schema' => 'orcamento'))->insert($columns, array($data))->saveData();
    }


    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertEstruturalValor($data)
    {

        $columns = array('db121_sequencial',
                        'db121_db_estrutura',
                        'db121_estrutural',
                        'db121_descricao',
                        'db121_estruturavalorpai',
                        'db121_nivel',
                        'db121_tipoconta');

        $this->table('db_estruturavalor', array('schema' => 'configuracoes'))->insert($columns, array($data))->saveData();
    }


    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function updateFonte($data, $o15_codigo)
    {
        $sql = "update orctiporec set";
        $sql .= " o15_descr = '{$data[0]}', ";
        $sql .= " o15_codtri = {$data[1]}, ";
        $sql .= " o15_finali = '{$data[2]}', ";
        $sql .= " o15_tipo = {$data[3]}, ";
        $sql .= " o15_db_estruturavalor = {$data[4]}, ";
        $sql .= " o15_codstnnovo = {$data[5]} ";
        $sql .= "where o15_codigo = {$o15_codigo}";
        $this->execute($sql);
    }


     /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function updateEstruturalValor($data, $db121_sequencial)
    {
        $sql = "update db_estruturavalor set ";
        // $sql .= " db121_db_estrutura = {$data[0]}, ";
        // $sql .= " db121_estrutural = {$data[1]}, ";
        $sql .= " db121_descricao = '{$data[2]}', ";
        $sql .= " db121_estruturavalorpai = {$data[3]}, ";
        $sql .= " db121_nivel = {$data[4]}, ";
        $sql .= " db121_tipoconta = {$data[5]} ";
        $sql .= "where db121_sequencial = {$db121_sequencial}";
        $this->execute($sql);
    }
}
