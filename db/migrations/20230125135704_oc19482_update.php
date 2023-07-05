<?php

use Phinx\Migration\AbstractMigration;

class Oc19482Update extends AbstractMigration
{
    public function up()
    {
        $exceptionClient = $this->query("SELECT codigo, nomeinst, cgc FROM db_config WHERE cgc IN ('18715383000140', '17316563000196')");
        $aExceptionClient = $exceptionClient->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($aExceptionClient)) {

            $jsonDados = file_get_contents('db/migrations/20230124112735_oc19482.json');
            $aDados = json_decode($jsonDados);
    
            foreach ($aDados->ALTERACOES as $changeDescr) {
                $aConplanoorc = $this->getConplanoorc($changeDescr->Estrutural, $changeDescr->Descricao);
                $aOrcelemento = $this->getOrcelemento($changeDescr->Estrutural, $changeDescr->Descricao);
                
                if ($aConplanoorc) {
                    foreach ($aConplanoorc as $conta):
                        $this->updateDescr($conta, 1);
                    endforeach;
                }
    
                if ($aOrcelemento) {
                    foreach ($aOrcelemento as $conta):
                        $this->updateDescr($conta, 2);
                    endforeach;
                }
    
                
            }
            foreach ($aDados->EXCLUSOES as $changeDesativadas) {
                $aConplanoorc = $this->getConplanoorc($changeDesativadas->Estrutural, $changeDescr->Descricao);
                if ($aConplanoorc) {
                    foreach ($aConplanoorc as $conta):
                        $this->updateDesativadas($conta);
                    endforeach;
                }
            }
        }

    }

    public function getConplanoorc($estrut, $descr)
    {
        $sqlConta = $this->query("SELECT c60_anousu, c60_codcon, c60_estrut, '{$descr}' AS c60_descr, '{$descr}' AS c60_finali FROM conplanoorcamento WHERE c60_estrut LIKE '{$estrut}%' AND c60_anousu >= 2023");
        $aConplanoorc = $sqlConta->fetchAll(\PDO::FETCH_ASSOC);
        
        return $aConplanoorc;
    }

    public function getOrcelemento($estrut, $descr)
    {
        $estrut = substr($estrut, 0, 13);
        $sqlConta = $this->query("SELECT '{$descr}' AS descr, orcelemento.* FROM orcelemento WHERE o56_elemento LIKE '{$estrut}%' AND o56_anousu >= 2023");
        $aOrcelemento = $sqlConta->fetchAll(\PDO::FETCH_ASSOC);
        
        return $aOrcelemento;
    }

    public function updateDescr($conta, $table)
    {
        if ($table == 1) {

            $c60_descr = str_replace('\'', '', $conta['c60_descr']);
            $c60_descr = substr($c60_descr, 0, 50);
            $c60_descr = strtoupper($c60_descr);
            $c60_finali = str_replace('\'', '', $conta['c60_finali']);
            $c60_finali = strtoupper($c60_finali);
            
            $sqlUpdate = "UPDATE conplanoorcamento
                          SET c60_descr = '{$c60_descr}', c60_finali = '{$c60_finali}'
                          WHERE c60_anousu >= 2023
                            AND c60_estrut = '{$conta['c60_estrut']}'";
            
            $this->execute($sqlUpdate);
        }

        if ($table == 2) {

            $o56_descr = str_replace('\'', '', $conta['descr']);
            $o56_finali = str_replace('\'', '', $conta['descr']);
            $o56_finali = strtoupper($o56_finali);
            $o56_descr = substr($o56_descr, 0, 50);
            $o56_descr = strtoupper($o56_descr);
            $o56_elemento = substr($conta['o56_elemento'], 0, 13);
            
            $sqlUpdate = "UPDATE orcelemento
                          SET o56_descr = '{$o56_descr}', o56_finali = '{$o56_finali}'
                          WHERE o56_anousu >= 2023
                            AND o56_elemento = '{$o56_elemento}'";
            $this->execute($sqlUpdate);
        }
    }

    public function updateDesativadas($conta)
    {
        $sqlUpdate = "UPDATE conplanoorcamento
                         SET c60_descr = 'DESATIVADA 2023', c60_finali = 'DESATIVADA 2023'
                      WHERE c60_anousu >= 2023
                        AND c60_estrut = '{$conta['c60_estrut']}'";
            
        $this->execute($sqlUpdate);
        
        $o56_elemento = substr($conta['c60_estrut'], 0, 13);
        $sqlUpdate1 = "UPDATE orcelemento
                          SET o56_descr = 'DESATIVADA 2023', o56_finali = 'DESATIVADA 2023'
                       WHERE o56_anousu >= 2023
                         AND o56_elemento = '{$o56_elemento}'";
            
        $this->execute($sqlUpdate1);

        $sSql1 = "DELETE FROM conplanoconplanoorcamento
                  USING conplanoorcamento
                  WHERE (c72_conplanoorcamento, c72_anousu) = (c60_codcon, c60_anousu)
                    AND c72_anousu >= 2023
                    AND c60_estrut = '{$conta['c60_estrut']}'";

        $this->execute($sSql1);
    }
    
}
