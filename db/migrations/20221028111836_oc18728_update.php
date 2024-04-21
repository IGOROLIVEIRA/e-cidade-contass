<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18728Update extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20221028111836_oc18728.json');
        $aDados = json_decode($jsonDados);

        foreach ($aDados->Reativa_Receitas as $reativaRec) {
            $aConplanoorc = $this->getConplanoorc($reativaRec->Estrutural);
            $aOrcfontes = $this->getOrcfontes($reativaRec->Estrutural);
            foreach ($aConplanoorc as $conta):
                $this->updateDescr($conta, 1);
                $this->vinculoPcasp($conta);
            endforeach;
            foreach ($aOrcfontes as $conta):
                $this->updateDescr($conta, 2);
            endforeach;
            
        }        

    }

    public function getConplanoorc($estrut)
    {
        $sqlConta = $this->query("SELECT c60_anousu, c60_codcon, c60_estrut, c60_descr, c60_finali FROM conplanoorcamento WHERE c60_estrut LIKE '{$estrut}' AND c60_anousu = 2022");
        $aConplanoorc = $sqlConta->fetchAll(\PDO::FETCH_ASSOC);
        
        return $aConplanoorc;
    }

    public function getOrcfontes($estrut)
    {
        $sqlConta = $this->query("SELECT * FROM orcfontes WHERE o57_fonte LIKE '{$estrut}' AND o57_anousu = 2022");
        $aOrcfontes = $sqlConta->fetchAll(\PDO::FETCH_ASSOC);
        
        return $aOrcfontes;
    }

    public function updateDescr($conta, $table)
    {
        if ($table == 1) {

            $c60_descr = str_replace('\'', '', $conta['c60_descr']);
            $c60_finali = str_replace('\'', '', $conta['c60_finali']);
            
            $sqlUpdate = "UPDATE conplanoorcamento
                          SET c60_descr = '{$c60_descr}', c60_finali = '{$c60_finali}'
                          WHERE c60_anousu >= 2023
                            AND c60_estrut = '{$conta['c60_estrut']}'";
            
            $this->execute($sqlUpdate);
        }

        if ($table == 2) {

            $o57_descr = str_replace('\'', '', $conta['o57_descr']);
            $o57_finali = str_replace('\'', '', $conta['o57_finali']);
            
            $sqlUpdate = "UPDATE orcfontes
                          SET o57_descr = '{$o57_descr}', o57_finali = '{$o57_finali}'
                          WHERE o57_anousu >= 2023
                            AND o57_fonte = '{$conta['o57_fonte']}'";
            
            $this->execute($sqlUpdate);
        }
    }

    public function vinculoPcasp($conta)
    {
        $sqlVinculo = "INSERT INTO conplanoconplanoorcamento
                       SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq'),
                              c72_conplano,
                              c72_conplanoorcamento,
                              2023
                       FROM conplanoconplanoorcamento
                       JOIN conplanoorcamento ON (c72_conplanoorcamento, c72_anousu) = (c60_codcon, c60_anousu)
                       WHERE (c72_anousu, c60_estrut) = (2022, '{$conta['c60_estrut']}')
                         AND c72_conplanoorcamento NOT IN 
                             (SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento
                              WHERE c72_anousu = 2023)";
        
        $this->execute($sqlVinculo);
    }
}
