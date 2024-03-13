<?php

use Phinx\Migration\AbstractMigration;

class Oc21618 extends AbstractMigration
{

    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20240109174754_oc21618.json');
        $oDados = json_decode($jsonDados);

        $sqlValidaCliente = "SELECT codigo, cgc FROM db_config WHERE cgc IN ('17316563000196', '18715383000140')";
        $aValidaCliente = $this->fetchAll($sqlValidaCliente);

        if (empty($aValidaCliente)){
            $this->contasInserir($oDados->Incluir);
            $this->contasAlterar($oDados->Alterar);
            $this->contasInativar($oDados->Inativar);
        }

    }

    public function getInstit()
    {
        $sqlInstit = $this->query("SELECT DISTINCT codigo FROM db_config WHERE db21_ativo = 1");
        $aInstit = $sqlInstit->fetchAll(\PDO::FETCH_ASSOC);
        return $aInstit;
    }

    public function contasInserir($contas): void
    {
        foreach ($contas as $contasInserir) {

            $sqlConta = "SELECT c60_codcon FROM conplanoorcamento WHERE c60_estrut LIKE '{$contasInserir->Estrutural}%' AND c60_anousu = 2024";

            $aContaExiste = $this->fetchAll($sqlConta);
            $c60_codcon = intval(current($this->fetchRow("SELECT nextval('conplanoorcamento_c60_codcon_seq')")));

            if (empty($aContaExiste)) {

                $c60_anousu = 2024;
                $c60_estrut = str_pad("$contasInserir->Estrutural", 15, "0");
                $c60_descr = substr("$contasInserir->Descricao", 0, 50);
                $c60_finali = "$contasInserir->Descricao";
                $c60_codsis = 0;
                $c60_codcla = 1;
                $c60_consistemaconta = 0;
                $c60_identificadorfinanceiro = 'N';
                $c60_naturezasaldo = 2;
                $c60_funcao = NULL;

                $aOrcamento = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla, $c60_consistemaconta, $c60_identificadorfinanceiro, $c60_naturezasaldo, $c60_funcao);
                $this->insertOrcamento($aOrcamento);

                if ($contasInserir->Tipo == 'Analitica') {

                    $aInstit = $this->getInstit();

                    foreach ($aInstit as $cliente) {

                        $c61_instit = $cliente['codigo'];

                        $sSqlVerificaReduz = "SELECT c61_reduz FROM conplanoorcamentoanalitica
                                          JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                                          WHERE c60_estrut LIKE '{$contasInserir->Estrutural}%'
                                            AND c61_instit = {$c61_instit}
                                            AND c61_anousu = 2024";

                        $aReduzExiste = $this->fetchAll($sSqlVerificaReduz);
                        $c61_reduz = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq')")));

                        if (empty($aReduzExiste)) {

                            $aReduzOrcamento = array($c60_codcon, 2024, $c61_reduz, $c61_instit, $contasInserir->Fonte);

                            $this->insertReduzOrcamento($aReduzOrcamento);
                            $this->insertVinculo($c60_codcon, $contasInserir->VinculoPCASP, $c61_instit);

                        }
                    }

                }
            }


        }
    }

    public function insertOrcamento($data)
    {
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

    public function insertReduzOrcamento($data)
    {

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


    public function insertVinculo($codconOrc, $estrutPcasp, $instit)
    {
        $contaPcasp = $this->fetchRow("SELECT c60_codcon FROM conplano
                                            WHERE c60_anousu = 2024
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

            $data = array($c72_sequencial, $contaPcasp['c60_codcon'], $codconOrc, 2024);
            $sSqlVerifica = "SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento 
                             WHERE (c72_conplano, c72_conplanoorcamento, c72_anousu) = ({$contaPcasp['c60_codcon']}, {$codconOrc}, 2024)";
            $aVerifica = $this->fetchRow($sSqlVerifica);
            if (empty($aVerifica)) {
                $this->table('conplanoconplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
            }
        }
    }

    private function contasAlterar($contas)
    {
        foreach ($contas as $contasAlterar) {

            $sqlConta = "SELECT c60_codcon, substr(c60_estrut, 1, 13) AS c60_estrut FROM conplanoorcamento WHERE c60_estrut LIKE '{$contasAlterar->Estrutural}%' AND c60_anousu = 2024";

            $aContaExiste = $this->fetchRow($sqlConta);

            if ($aContaExiste){

                $codcon = $aContaExiste['c60_codcon'];
                $estrut = $aContaExiste['c60_estrut'];
                $descricao = $contasAlterar->Descricao;

                $this->execute("UPDATE conplanoorcamento 
                                     SET c60_descr = '{$descricao}', c60_finali = '{$descricao}'
                                     WHERE (c60_codcon, c60_anousu) = ({$codcon}, 2024)");

                $this->execute("UPDATE orcelemento 
                                     SET o56_descr = '{$descricao}', o56_finali = '{$descricao}'
                                     WHERE (o56_codele, o56_anousu, o56_elemento) = ({$codcon}, 2024, '{$estrut}')");
            }
        }
    }

    private function contasInativar($contas)
    {
        foreach ($contas as $contasInativar) {

            $sqlConta = "SELECT c60_codcon, substr(c60_estrut, 1, 13) AS c60_estrut FROM conplanoorcamento WHERE c60_estrut LIKE '{$contasInativar->Estrutural}%' AND c60_anousu = 2024";

            $aContaExiste = $this->fetchRow($sqlConta);

            if ($aContaExiste){

                $codcon = $aContaExiste['c60_codcon'];
                $estrut = $aContaExiste['c60_estrut'];

                $alterarDescr = $contasInativar->AlterarDescr;
                $this->execute("UPDATE conplanoorcamento 
                                     SET c60_descr = '{$alterarDescr}', c60_finali = '{$alterarDescr}'
                                     WHERE (c60_codcon, c60_anousu) = ({$codcon}, 2024)");

                $this->execute("UPDATE orcelemento 
                                     SET o56_descr = '{$alterarDescr}', o56_finali = '{$alterarDescr}'
                                     WHERE (o56_codele, o56_anousu, o56_elemento) = ({$codcon}, 2024, '{$estrut}')");

                $this->execute("DELETE FROM conplanoorcamentoanalitica
                                     WHERE (c61_codcon, c61_anousu) = ({$codcon}, 2024)");

                $this->execute("DELETE FROM conplanoconplanoorcamento
                                     WHERE (c72_conplanoorcamento, c72_anousu) = ({$codcon}, 2024)");
            }
        }
    }

}
