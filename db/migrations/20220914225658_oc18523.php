<?php

use Phinx\Migration\AbstractMigration;

class Oc18523 extends AbstractMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20220914225658_oc18523.json');
        $aDados = json_decode($jsonDados);

        foreach ($aDados->receitas as $contasInserir) {

            $sqlConta = "SELECT c60_codcon FROM conplanoorcamento WHERE c60_estrut =  '{$contasInserir->Estrutural}' AND c60_anousu>= 2022";

            $aContaExiste = $this->fetchAll($sqlConta);
            $c60_codcon = intval(current($this->fetchRow("SELECT nextval('conplanoorcamento_c60_codcon_seq')")));

            if (empty($aContaExiste)) {

                $c60_anousu = 1;
                $c60_estrut = "$contasInserir->Estrutural";
                $c60_descr = substr("$contasInserir->DESCRICAO",0,50);
                $c60_finali = "$contasInserir->DESCRICAO";
                $c60_codsis = 0;
                $c60_codcla = 1;
                $c60_consistemaconta = 0;
                $c60_identificadorfinanceiro = 'N';
                $c60_naturezasaldo = 2;
                $c60_funcao = NULL;

                $aOrcamento = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla, $c60_consistemaconta, $c60_identificadorfinanceiro, $c60_naturezasaldo, $c60_funcao);
                $this->insertOrcamento($aOrcamento);
                $this->insertOrcfontes($c60_codcon, $c60_estrut, $c60_descr);

            }

            if ($contasInserir->Tipo == 'Analitica') {

                $sSqlVerificaReduz = "SELECT c61_reduz FROM conplanoorcamentoanalitica
                                      JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                                      WHERE (c60_estrut, c61_instit) = ('{$contasInserir->Estrutural}', 1)
                                        AND c61_anousu >= 2022";

                $aReduzExiste = $this->fetchAll($sSqlVerificaReduz);
                $c61_reduz = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq')")));

                if (empty($aReduzExiste)){

                    $c61_codcon = $c60_codcon;
                    $c61_anousu = 1;
                    $c61_instit = 1;
                    $c61_codigo = 1;

                    $aReduzOrcamento = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo);

                    $this->insertReduzOrcamento($aReduzOrcamento, $contasInserir->Fonte2022, $contasInserir->Fonte2023);

                    $this->insertGrupo($c61_codcon, $c61_instit);
                    $this->insertVinculo($c61_codcon, $contasInserir->VinculoPCASP, $c61_instit);
                }
            }
        }
    }

    public function getExercicio()
    {
        $sSqlExercicio = $this->query('SELECT c91_anousudestino FROM conaberturaexe WHERE c91_instit = 1 AND c91_anousudestino >= 2022');
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

            $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'contabilidade')));
            $this->table('conplanoorcamento')->insert($fields, array($data))->saveData();

        }
    }

    public function insertReduzOrcamento($data, $fonte2022, $fonte2023)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $data[1] = $exercicio['c91_anousudestino'];
            $data[4] = $data[1] == 2022 ? $fonte2022 : $fonte2023;

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

    public function insertGrupo($codcon, $instit)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $c21_sequencial = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq')")));

            $fields = array(
                'c21_sequencial',
                'c21_anousu',
                'c21_codcon',
                'c21_congrupo',
                'c21_instit'
            );

            $data = array($c21_sequencial, $exercicio['c91_anousudestino'], $codcon, 16, $instit);

            $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'contabilidade')));
            $this->table('conplanoorcamentogrupo', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
        }
    }

    public function insertVinculo($codconOrc, $estrutPcasp, $instit)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $contaPcasp = $this->fetchRow("SELECT c60_codcon FROM conplano
                                               JOIN conplanoreduz ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
                                               WHERE c60_anousu = {$exercicio['c91_anousudestino']}
                                                 AND c61_instit = $instit
                                                 AND c60_estrut LIKE '{$estrutPcasp}%'
                                               LIMIT 1");

            if (!empty($contaPcasp)) {

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

    public function insertOrcfontes($codcon, $estrut, $descrFinali)
    {
        $anoInsert = $this->getExercicio();

        foreach ($anoInsert as $exercicio) {

            $o57_finali = $descrFinali;
            $anoInsert = $exercicio['c91_anousudestino'];

            $fields = array(
                'o57_codfon',
                'o57_anousu',
                'o57_fonte',
                'o57_descr',
                'o57_finali'
            );

            $data = array($codcon, $anoInsert, $estrut, $descrFinali, $o57_finali);
            $this->getAdapter()->setOptions(array_replace($this->getAdapter()->getOptions(), array('schema' => 'orcamento')));
            $this->table('orcfontes', array('schema' => 'orcamento'))->insert($fields, array($data))->saveData();
        }

    }

    public function down()
    {
        $jsonDadosDown = file_get_contents('db/migrations/20220914225658_oc18523.json');
        $aDadosDown    = json_decode($jsonDadosDown);

        foreach ($aDadosDown->receitas as $contas) {

            $this->execute("DELETE FROM orcfontes
                                 WHERE o57_fonte = '{$contas->Estrutural}' AND o57_anousu >= 2022");

            $sSql1 = "DELETE FROM conplanoconplanoorcamento
                      USING conplanoorcamento
                      WHERE (c72_conplanoorcamento, c72_anousu) = (c60_codcon, c60_anousu)
                        AND c72_anousu >= 2022
                        AND c60_estrut = '{$contas->Estrutural}'";

            $this->execute($sSql1);

            $sSql2 = "DELETE FROM conplanoorcamentogrupo
                      USING conplanoorcamento
                      WHERE (c21_codcon, c21_anousu) = (c60_codcon, c60_anousu)
                        AND c21_anousu >= 2022
                        AND c60_estrut = '{$contas->Estrutural}'";

            $this->execute($sSql2);

            $sSql3 = "DELETE FROM conplanoorcamentoanalitica
                      USING conplanoorcamento
                      WHERE (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu) 
                        AND c61_anousu >= 2022
                        AND c60_estrut = '{$contas->Estrutural}'";

            $this->execute($sSql3);

            $sSql4 = "DELETE FROM conplanoorcamento
                      WHERE c60_estrut = '{$contas->Estrutural}' AND c60_anousu >= 2022";

            $this->execute($sSql4);
        }
    }
}
