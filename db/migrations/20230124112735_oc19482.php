<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc19482 extends PostgresMigration
{
    public function up()
    {
        $exceptionClient = $this->query("SELECT codigo, nomeinst, cgc FROM db_config WHERE cgc IN ('18715383000140', '17316563000196')");
        $aExceptionClient = $exceptionClient->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($aExceptionClient)) {

            $jsonDados = file_get_contents('db/migrations/20230124112735_oc19482.json');
            $aDados = json_decode($jsonDados);
    
            foreach ($aDados->INCLUSOES as $contasInserir) {
                
                $sqlConta = "SELECT c60_codcon FROM conplanoorcamento WHERE c60_estrut = '{$contasInserir->Estrutural}' AND c60_anousu>= 2023";
    
                $aContaExiste = $this->fetchAll($sqlConta);
                
                if (empty($aContaExiste)) {
                    
                    $c60_codcon = intval(current($this->fetchRow("SELECT nextval('conplanoorcamento_c60_codcon_seq')")));
                    
                    $c60_anousu = 1;
                    $c60_estrut = "$contasInserir->Estrutural";
                    $c60_descr = substr("$contasInserir->Descricao",0,50);
                    $c60_descr = strtoupper($c60_descr);
                    $c60_finali = strtoupper("$contasInserir->Descricao");
                    $c60_codsis = 0;
                    $c60_codcla = 1;
                    $c60_consistemaconta = 0;
                    $c60_identificadorfinanceiro = 'N';
                    $c60_naturezasaldo = 2;
                    $c60_funcao = NULL;
    
                    $aOrcamento = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla, $c60_consistemaconta, $c60_identificadorfinanceiro, $c60_naturezasaldo, $c60_funcao);
                    $this->insertOrcamento($aOrcamento);
                    $this->insertOrcelemento($c60_codcon, substr("$c60_estrut", 0, 13), $c60_descr);
    
                }
    
                if ($contasInserir->Tipo == 'Analitica') {
    
                    $aInstit = $this->getInstit();
    
                    foreach ($aInstit as $instit) {
                        
                        $codInstit = $instit['codigo'];
                        $sSqlVerificaReduz = $this->query("SELECT c60_codcon, c61_reduz FROM conplanoorcamento
                                                           LEFT JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu, {$codInstit}) = (c61_codcon, c61_anousu, c61_instit)
                                                           WHERE c60_estrut = '{$contasInserir->Estrutural}'
                                                             AND c60_anousu >= 2023");
        
                        $aReduzExiste = $sSqlVerificaReduz->fetchAll(\PDO::FETCH_ASSOC);
                        $c61_reduz = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq')")));
    
                        $codigo = $aReduzExiste[0]['c60_codcon'];
                        $reduzido = $aReduzExiste[0]['c61_reduz'];
        
                        if (empty($reduzido) && !empty($codigo)){
        
                            $c61_codcon = $c60_codcon;
                            $c61_anousu = 1;
                            $c61_instit = $codInstit;
                            $c61_codigo = 1;
        
                            $aReduzOrcamento = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo);
        
                            $this->insertReduzOrcamento($aReduzOrcamento, $contasInserir->Fonte);
        
                            if (!empty($contasInserir->Vinculo_PCASP)) {
                                
                                $this->insertVinculo($c61_codcon, $contasInserir->Vinculo_PCASP, $codigo);
                            }
                        }
                    }
    
                }
            }
        }

    }

    public function getInstit()
    {
        $sqlInstit = $this->query("SELECT DISTINCT codigo FROM db_config");
        $aInstit = $sqlInstit->fetchAll(\PDO::FETCH_ASSOC);        
        return $aInstit;
    }

    public function getExercicio()
    {
        $sSqlExercicio = $this->query('SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino >= 2023');
        $aExe = $sSqlExercicio->fetchAll(\PDO::FETCH_ASSOC);

        return $aExe;
    }

    public function insertOrcamento($data)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $data[1] = $exercicio['c91_anousudestino'];

            $fields = array(
                'c60_codcon',
                'c60_anousu',
                'c60_estrut',
                'c60_descr',
                'c60_finali',
                'c60_codsis',
                'c60_codcla',
                'c60_consistemaconta',
                'c60_identificadorfinanceiro',
                'c60_naturezasaldo',
                'c60_funcao'
            );
            
            $this->table('conplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
            
        }
    }

    public function insertReduzOrcamento($data, $fonte)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $data[1] = $exercicio['c91_anousudestino'];
            $data[4] = $fonte;

            $fields = array(
                'c61_codcon',
                'c61_anousu',
                'c61_reduz',
                'c61_instit',
                'c61_codigo'
            );

            $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'contabilidade')));
            $this->table('conplanoorcamentoanalitica', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
        }
    }

    
    public function insertVinculo($codconOrc, $estrutPcasp, $codcon)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $contaPcasp = $this->fetchRow("SELECT c60_codcon FROM conplano
                                           WHERE c60_anousu = {$exercicio['c91_anousudestino']}
                                             AND c60_estrut LIKE '{$estrutPcasp}'
                                           LIMIT 1");
            

            if (!empty($contaPcasp) && !empty($codcon)) {

                $c72_sequencial = intval(current($this->fetchRow("SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq')")));

                $fields = array(
                    'c72_sequencial',
                    'c72_conplano',
                    'c72_conplanoorcamento',
                    'c72_anousu'
                );

                $data = array($c72_sequencial, $contaPcasp['c60_codcon'], $codconOrc, $exercicio['c91_anousudestino']);
                $sSqlVerifica = "SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento WHERE (c72_conplano, c72_conplanoorcamento, c72_anousu) = ({$contaPcasp['c60_codcon']}, {$codconOrc}, {$exercicio['c91_anousudestino']})";
                $aVerifica = $this->fetchRow($sSqlVerifica);
                if (empty($aVerifica)) {
                    $this->table('conplanoconplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
                }
            }
        }
    }

    public function insertOrcelemento($codcon, $estrut, $descrFinali)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $o57_finali = $descrFinali;
            $anoInsert = $exercicio['c91_anousudestino'];

            $fields = array(
                'o56_codele',
                'o56_anousu',
                'o56_elemento',
                'o56_descr',
                'o56_finali',
                'o56_orcado'
            );

            $data = array($codcon, $anoInsert, $estrut, $descrFinali, $o57_finali, 't');
            $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'orcamento')));
            $this->table('orcelemento', array('schema' => 'orcamento'))->insert($fields, array($data))->saveData();
        }

    }

    public function down()
    {
        $jsonDadosDown = file_get_contents('db/migrations/20230124112735_oc19482.json');
        $aDadosDown    = json_decode($jsonDadosDown);

        foreach ($aDadosDown->INCLUSOES as $contas) {

            $this->execute("DELETE FROM orcelemento
                            WHERE o56_elemento = '{$contas->Estrutural}' AND o56_anousu >= 2023");

            $sSql1 = "DELETE FROM conplanoconplanoorcamento
                      USING conplanoorcamento
                      WHERE (c72_conplanoorcamento, c72_anousu) = (c60_codcon, c60_anousu)
                        AND c72_anousu >= 2023
                        AND c60_estrut = '{$contas->Estrutural}'";

            $this->execute($sSql1);

            $sSql2 = "DELETE FROM conplanoorcamentoanalitica
                      USING conplanoorcamento
                      WHERE (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu) 
                        AND c61_anousu >= 2023
                        AND c60_estrut = '{$contas->Estrutural}'";

            $this->execute($sSql2);

            $sSql3 = "DELETE FROM conplanoorcamento
                      WHERE c60_estrut = '{$contas->Estrutural}' AND c60_anousu >= 2023";

            $this->execute($sSql3);
        }
    }
}
