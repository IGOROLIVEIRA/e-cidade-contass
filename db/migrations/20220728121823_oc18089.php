<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18089 extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20220728121800_oc18089.json');
        $aDados = json_decode($jsonDados);

        $aInstit = $this->fetchAll("SELECT DISTINCT codigo FROM db_config WHERE codigo = 1");

        foreach ($aDados->Inserir as $contasInserir) {

            $aContaExiste = $this->fetchAll("SELECT c60_codcon FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = (2023, '{$contasInserir->Estrutual}')");

            if (empty($aContaExiste)) {

                $c60_codcon = intval(current($this->fetchRow("SELECT nextval('conplanoorcamento_c60_codcon_seq')")));
                $c60_anousu = 2023;
                $c60_estrut = $contasInserir->Estrutual;
                $c60_descr = $contasInserir->Descricao;
                $c60_finali = $contasInserir->Finalidade;
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

            if ($contasInserir->Fonte != null) {

                foreach ($aInstit as $instituicao) {

                    $sSqlVerificaReduz = "SELECT c61_reduz FROM conplanoorcamentoanalitica
                                           JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
                                           WHERE (c61_anousu, c60_estrut, c61_instit) = (2023, '{$contasInserir->Estrutual}', {$instituicao['codigo']})";

                    $aReduzExiste = $this->fetchAll($sSqlVerificaReduz);

                    if (empty($aReduzExiste)) {

                        $c61_codcon = $c60_codcon;
                        $c61_anousu = 2023;
                        $c61_reduz = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq')")));
                        $c61_instit = $instituicao['codigo'];
                        $c61_codigo = $contasInserir->Fonte;

                        $aReduzOrcamento = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo);

                        $this->insertReduzOrcamento($aReduzOrcamento);

                        $this->insertGrupo($c61_codcon, $c61_instit);
                        $this->insertVinculo($c61_codcon, $contasInserir->PCASP, $c61_instit);
                    }
                }
            }
        }

        foreach ($aDados->Alterar_Descricao as $contasAlteraDescr) {
            $aConta = $this->fetchAll("SELECT c60_codcon FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = (2023, '{$contasAlteraDescr->Estrutual}')");

            if (isset($aConta)) {
                foreach ($aConta as $contaOrc):
                    $newDescr = $contasAlteraDescr->Nova_Descricao;
                    $newFinalidade = $contasAlteraDescr->Nova_Finalidade;
                    $this->updateDescrFinali($newDescr, $newFinalidade, $contaOrc['c60_codcon']);
                endforeach;
            }
        }

        foreach ($aDados->Desativar as $contasDesativadas) {
            $aConta = $this->fetchAll("SELECT c60_codcon FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = (2023, '{$contasDesativadas->Estrutual}')");

            if (isset($aConta)) {
                foreach ($aConta as $contaOrc):
                    $this->updateDesativadas($contaOrc['c60_codcon'], $contasDesativadas->Nova_Descricao);
                endforeach;
            }
        }
    }

    public function insertOrcamento($data)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");
        foreach ($aAbertura as $exercicio) {

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

    public function insertReduzOrcamento($data)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");

        foreach ($aAbertura as $exercicio) {

            $data[1] = $exercicio['c91_anousudestino'];

            $fields = array(
                'c61_codcon',
                'c61_anousu',
                'c61_reduz',
                'c61_instit',
                'c61_codigo'
            );
            $this->table('conplanoorcamentoanalitica', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
        }
    }

    public function insertGrupo($codcon, $instit)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");

        foreach ($aAbertura as $exercicio) {

            $c21_sequencial = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq')")));

            $fields = array(
                'c21_sequencial',
                'c21_anousu',
                'c21_codcon',
                'c21_congrupo',
                'c21_instit'
            );

            $ano = $exercicio['c91_anousudestino'];

            $data = array($c21_sequencial, $ano, $codcon, 16, $instit);

            $this->table('conplanoorcamentogrupo', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
        }
    }

    public function insertVinculo($codconOrc, $estrutPcasp, $instit)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");

        foreach ($aAbertura as $exercicio) {

            $ano = $exercicio["c91_anousudestino"];

            $contaPcasp = $this->fetchRow("SELECT c60_codcon FROM conplano
                                               JOIN conplanoreduz ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
                                               WHERE c60_anousu = $ano
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

                $data = array($c72_sequencial, $contaPcasp['c60_codcon'], $codconOrc, $ano);
                $sSqlVerifica = "SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento WHERE (c72_conplano, c72_conplanoorcamento, c72_anousu) = ({$contaPcasp['c60_codcon']}, {$codconOrc}, $ano)";
                $aVerifica = $this->fetchRow($sSqlVerifica);
                if (empty($aVerifica)) {
                    $this->table('conplanoconplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
                }
            }
        }
    }

    public function insertOrcfontes($codcon, $estrut, $descrFinali)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");
        foreach ($aAbertura as $exercicio) {

            $o57_finali = $descrFinali;
            $ano = $exercicio["c91_anousudestino"];

            $fields = array(
                'o57_codfon',
                'o57_anousu',
                'o57_fonte',
                'o57_descr',
                'o57_finali'
            );

            $data = array($codcon, $ano, $estrut, $descrFinali, $o57_finali);
            $this->table('orcfontes', array('schema' => 'orcamento'))->insert($fields, array($data))->saveData();
        }
    }

    private function updateDescrFinali($newDescr, $newFinalidade, $c60_codcon)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");

        foreach ($aAbertura as $exercicio) {

            $sSqlConplanoorcamento = "UPDATE conplanoorcamento
                                      SET c60_descr = '{$newDescr}', c60_finali = '{$newFinalidade}'
                                      WHERE (c60_codcon, c60_anousu) = ({$c60_codcon}, {$exercicio['c91_anousudestino']})";
            $this->execute($sSqlConplanoorcamento);

            $sSqlOrcfontes = "UPDATE orcfontes
                              SET o57_descr = '{$newDescr}', o57_finali = '{$newFinalidade}'
                              WHERE o57_fonte IN (SELECT c60_estrut FROM conplanoorcamento WHERE (c60_codcon, c60_anousu) = ({$c60_codcon}, {$exercicio['c91_anousudestino']}))";
            $this->execute($sSqlOrcfontes);
        }
    }

    private function updateDesativadas($c60_codcon, $Nova_Descricao)
    {
        $aAbertura = $this->fetchAll("SELECT DISTINCT c91_anousudestino FROM conaberturaexe WHERE c91_anousudestino > 2022 ORDER BY 1");

        foreach ($aAbertura as $exercicio) {

            $this->execute("UPDATE conplanoorcamento
                                SET c60_descr = '{$Nova_Descricao}', c60_finali = '{$Nova_Descricao}'
                                WHERE (c60_codcon, c60_anousu) = ({$c60_codcon}, {$exercicio['c91_anousudestino']})");

            $this->execute("UPDATE orcfontes
                                SET o57_descr = '{$Nova_Descricao}', o57_finali = '{$Nova_Descricao}'
                                WHERE o57_fonte IN (SELECT c60_estrut FROM conplanoorcamento WHERE (c60_codcon, c60_anousu) = ({$c60_codcon}, {$exercicio['c91_anousudestino']}))");
        }
    }

    public function down()
    {
        $jsonDadosDown = file_get_contents('db/migrations/20220728121800_oc18089.json');
        $aDadosDown    = json_decode($jsonDadosDown);

        foreach ($aDadosDown->Inserir as $contas) {
            $codcon = $this->fetchRow("SELECT c60_codcon FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = (2023, '{$contas->Estrutual}')");

            $this->execute("DELETE FROM orcfontes
                                 WHERE o57_fonte = '{$contas->Estrutual}' AND o57_anousu > 2022");

            if (!empty($codcon)) {

                $codConta = $codcon['c60_codcon'];

                $sSql = "SELECT c72_sequencial FROM conplanoconplanoorcamento
                         WHERE c72_anousu > 2022 AND c72_conplanoorcamento =  {$codConta}";

                $verifica = $this->fetchAll($sSql);

                if (!empty($verifica)) {
                    foreach ($verifica as $item) {
                        $seq = $item['c72_sequencial'];

                        $sSql1 = "DELETE FROM conplanoconplanoorcamento
                                  WHERE c72_sequencial = {$seq}";

                        $this->execute($sSql1);
                    }
                }

                $sSql2 = "DELETE FROM conplanoorcamentogrupo
                          WHERE c21_codcon = {$codConta} AND c21_anousu > 2022";

                $this->execute($sSql2);

                $sSql3 = "DELETE FROM conplanoorcamentoanalitica
                          WHERE c61_codcon = {$codConta} AND c61_anousu > 2022";

                $this->execute($sSql3);

                $sSql4 = "DELETE FROM conplanoorcamento
                          WHERE c60_codcon = {$codConta} AND c60_anousu > 2022";

                $this->execute($sSql4);

            }
        }

        foreach ($aDadosDown->Alterar_Descricao as $contasAlteradas):
            $estrut = $this->getEstrutural($contasAlteradas);
            $this->revertChanges($estrut);
        endforeach;

        foreach ($aDadosDown->Desativar as $contasDesativas):
            $estrut = $this->getEstrutural($contasDesativas);
            $this->revertChanges($estrut);
        endforeach;
    }

    private function revertChanges($estrutural)
    {
        $sSqlRevertOrcfontes = " UPDATE orcfontes t1
                                 SET o57_descr = t2.o57_descr, o57_finali = t2.o57_finali
                                 FROM orcfontes t2
                                 WHERE t1.o57_fonte = t2.o57_fonte
                                   AND t2.o57_anousu = 2022
                                   AND t1.o57_anousu > 2022
                                   AND t1.o57_fonte = '{$estrutural}'";

        $sSqlRevertCoplanoOrc = "UPDATE conplanoorcamento t1
                                 SET c60_descr = t2.c60_descr, c60_finali = t2.c60_finali
                                 FROM conplanoorcamento t2
                                 WHERE t1.c60_estrut = t2.c60_estrut
                                   AND t2.c60_anousu = 2022
                                   AND t1.c60_anousu > 2022
                                   AND t1.c60_estrut = '{$estrutural}'";

        $this->execute($sSqlRevertOrcfontes);
        $this->execute($sSqlRevertCoplanoOrc);
    }

    private function getEstrutural($aContasAlteradas)
    {
        foreach ($aContasAlteradas as $estrutural) {
            return $estrutural;
        }
    }

}
