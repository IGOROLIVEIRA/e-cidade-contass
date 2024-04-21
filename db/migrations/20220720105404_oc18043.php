<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18043 extends PostgresMigration
{
    public function up()
    {
        $contas = array(
            array(
                'estrutural' => '417135011020000',
                'descricao' => 'TRANSF DE REC DO BLOCO DE MANUT ASPS AT. PRIMARIA',
                'tipo' => 'Analitica',
                'vinculo' => '4521307',
                'fonte' => '132',
                'natsaldo' => 'C'
            ),
            array(
                'estrutural' => '417135031020000',
                'descricao' => 'TRANSF DE REC DO BLOCO DE MANUT ASPS - VIGILANCIA',
                'tipo' => 'Analitica',
                'vinculo' => '4521307',
                'fonte' => '132',
                'natsaldo' => 'C'
            ),
            array(
                'estrutural' => '419225001040000',
                'descricao' => 'Restituicoes de Recursos Recebidos do SUS - Princi',
                'tipo' => 'Analitica',
                'vinculo' => '4996102',
                'fonte' => '132',
                'natsaldo' => 'C'
            )
        );

//        $clientInstit = $this->fetchRow("SELECT codigo FROM db_config WHERE db21_tipoinstit = 1");
//        $abertura = $this->fetchAll("SELECT c91_anousudestino FROM conaberturaexe WHERE c91_instit = {$clientInstit['codigo']} AND c91_anousudestino >= 2022");
//
//        foreach ($abertura as $exercicio) {
//            foreach ($contas as $conta) :
//                $existeConta = $this->fetchRow("SELECT c60_codcon FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = ({$exercicio['c91_anousudestino']}, '{$conta['estrutural']}')");
//                if (empty($existeConta)) {
//
//                    $c60_codcon                        = intval(current($this->fetchRow("SELECT nextval('conplanoorcamento_c60_codcon_seq')")));
//                    $c60_anousu                        = $exercicio['c91_anousudestino'];
//                    $c60_estrut                        = $conta['estrutural'];
//                    $c60_descr                         = $conta['descricao'];
//                    $c60_finali                        = $conta['descricao'];
//                    $c60_codsis                        = 0;
//                    $c60_codcla                        = intval(1);
//                    $c60_consistemaconta               = 0;
//                    $c60_identificadorfinanceiro       = 'N';
//                    $c60_naturezasaldo                 = 2;
//                    $c60_funcao                        = NULL;
//
//                    $aOrcamento = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla, $c60_consistemaconta, $c60_identificadorfinanceiro, $c60_naturezasaldo, $c60_funcao);
//                    $this->insertOrcamento($aOrcamento);
//
//                    $c61_codcon    = $c60_codcon;
//                    $c61_anousu    = $c60_anousu;
//                    $c61_reduz     = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq')")));
//                    $c61_instit    = $clientInstit['codigo'];
//                    $c61_codigo    = intval($conta['fonte']);
//                    $c61_contrapartida = 0;
//
//                    $aReduzOrcamento = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida);
//                    $this->insertReduzOrcamento($aReduzOrcamento);
//
//                    $this->insertGrupo($c60_anousu, $c60_codcon, $clientInstit['codigo']);
//
//                    $this->insertVinculo($c60_codcon, $c60_anousu, $conta['vinculo'], $clientInstit['codigo']);
//
//                    $this->insertOrcfontes($c60_codcon, $c60_anousu, $conta['estrutural'], $conta['descricao']);
//                }
//            endforeach;
//        }
    }

//    public function insertOrcamento($data)
//    {
//        $fields = array(
//            'c60_codcon',
//            'c60_anousu',
//            'c60_estrut',
//            'c60_descr',
//            'c60_finali',
//            'c60_codsis',
//            'c60_codcla',
//            'c60_consistemaconta',
//            'c60_identificadorfinanceiro',
//            'c60_naturezasaldo',
//            'c60_funcao'
//        );
//
//        $this->table('conplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
//    }

//    public function insertReduzOrcamento($data)
//    {
//        $fields = array(
//            'c61_codcon',
//            'c61_anousu',
//            'c61_reduz',
//            'c61_instit',
//            'c61_codigo',
//            'c61_contrapartida'
//        );
//        $this->table('conplanoorcamentoanalitica', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
//    }

//    public function insertGrupo($ano, $codcon, $instit)
//    {
//        $c21_sequencial = intval(current($this->fetchRow("SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq')")));
//
//        $fields = array(
//            'c21_sequencial',
//            'c21_anousu',
//            'c21_codcon',
//            'c21_congrupo',
//            'c21_instit'
//        );
//
//        $data = array($c21_sequencial, $ano, $codcon, 16, $instit);
//        $this->table('conplanoorcamentogrupo', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
//    }

//    public function insertVinculo($codconOrc, $ano, $estrutPcasp, $instit)
//    {
//        $contaPcasp = $this->fetchRow("SELECT c60_codcon FROM conplano
//                                       JOIN conplanoreduz ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
//                                       WHERE c60_anousu = $ano
//                                         AND c61_instit = $instit
//                                         AND c60_estrut LIKE '{$estrutPcasp}%'
//                                       LIMIT 1");
//
//        if (!empty($contaPcasp)) {
//
//            $c72_sequencial = intval(current($this->fetchRow("SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq')")));
//
//            $fields = array(
//                'c72_sequencial',
//                'c72_conplano',
//                'c72_conplanoorcamento',
//                'c72_anousu'
//            );
//
//            $data = array($c72_sequencial, $contaPcasp['c60_codcon'], $codconOrc, $ano);
//            $this->table('conplanoconplanoorcamento', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
//        }
//    }

//    public function insertOrcfontes($codcon, $ano, $estrut, $descrFinali)
//    {
//        $o57_finali = $descrFinali;
//        $fields = array(
//            'o57_codfon',
//            'o57_anousu',
//            'o57_fonte',
//            'o57_descr',
//            'o57_finali'
//        );
//
//        $data = array($codcon, $ano, $estrut, $descrFinali, $o57_finali);
//        $this->table('orcfontes', array('schema' => 'orcamento'))->insert($fields, array($data))->saveData();
//    }

//    public function down()
//    {
//        $contas = array(
//            array(
//                'estrutural' => '417135011020000',
//                'descricao' => 'TRANSF DE REC DO BLOCO DE MANUT ASPS AT. PRIMARIA',
//                'tipo' => 'Analitica',
//                'vinculo' => '4521307',
//                'fonte' => '132',
//                'natsaldo' => 'C'
//            ),
//            array(
//                'estrutural' => '417135031020000',
//                'descricao' => 'TRANSF DE REC DO BLOCO DE MANUT ASPS - VIGILANCIA',
//                'tipo' => 'Analitica',
//                'vinculo' => '4521307',
//                'fonte' => '132',
//                'natsaldo' => 'C'
//            ),
//            array(
//                'estrutural' => '419225001040000',
//                'descricao' => 'Restituicoes de Recursos Recebidos do SUS - Princi',
//                'tipo' => 'Analitica',
//                'vinculo' => '4996102',
//                'fonte' => '132',
//                'natsaldo' => 'C'
//            )
//        );
//
//        $clientInstit = $this->fetchRow("SELECT codigo FROM db_config WHERE db21_tipoinstit = 1");
//        $abertura = $this->fetchAll("SELECT c91_anousudestino FROM conaberturaexe WHERE c91_instit = {$clientInstit['codigo']} AND c91_anousudestino >= 2022");
//
//        foreach ($abertura as $exercicio) {
//            foreach ($contas as $conta) :
//                $codcon = $this->fetchRow("SELECT c60_codcon, c60_anousu FROM conplanoorcamento WHERE (c60_anousu, c60_estrut) = ({$exercicio['c91_anousudestino']}, '{$conta['estrutural']}')");
//
//                $this->execute("DELETE FROM orcfontes
//                                WHERE (o57_anousu, o57_codfon) = ({$exercicio['c91_anousudestino']}, {$codcon['c60_codcon']})");
//
//                $this->execute("DELETE FROM conplanoconplanoorcamento
//                                WHERE (c72_anousu, c72_conplanoorcamento) = ({$exercicio['c91_anousudestino']}, {$codcon['c60_codcon']})");
//
//                $this->execute("DELETE FROM conplanoorcamentogrupo
//                                WHERE (c21_anousu, c21_codcon) = ({$exercicio['c91_anousudestino']}, {$codcon['c60_codcon']})");
//
//                $this->execute("DELETE FROM conplanoorcamentoanalitica
//                                WHERE (c61_anousu, c61_codcon) = ({$exercicio['c91_anousudestino']}, {$codcon['c60_codcon']})");
//
//                $this->execute("DELETE FROM conplanoorcamento
//                                WHERE (c60_anousu, c60_codcon) = ({$exercicio['c91_anousudestino']}, {$codcon['c60_codcon']})");
//
//            endforeach;
//        }
//    }
}
