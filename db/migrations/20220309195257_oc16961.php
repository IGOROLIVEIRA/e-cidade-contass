<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc16961 extends PostgresMigration
{
    public function up()
    {
        $aCmbhNaoExecutar = $this->fetchAll("select codigo from db_config where cgc in ('17316563000196','18715383000140')");
        if(empty($aCmbhNaoExecutar)){
            $nAnoInicial = 2022;
            if(($handle = fopen("db/migrations/planoorcamentario2022.txt", "r")) !== FALSE)  {
                while ( ($aPlanoOrcamento = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    if($aPlanoOrcamento[0] === 'codigo'){
                        continue;
                    }
                    $aExercicios = $this->fetchAll("select distinct c60_anousu from conplanoorcamento where c60_anousu >= {$nAnoInicial}");
                    foreach($aExercicios as $oExercicios){
                        // se existir o estrutural não deve ser inserido nem atualizado.
                        $sEstrut = str_pad($aPlanoOrcamento[0], 15, "0");
                        $sEstrutPcasp = str_pad($aPlanoOrcamento[4], 15, "0");
                        $aConplanoOrcamentoExiste = $this->fetchRow("select * from conplanoorcamento where c60_anousu={$oExercicios['c60_anousu']} and c60_estrut = '{$sEstrut}'");
                        if(!empty($aConplanoOrcamentoExiste)){
                            $this->updateConplanoOrcamento($aConplanoOrcamentoExiste, substr($aPlanoOrcamento[1], 0, 50), $sEstrutPcasp);
                            continue;
                        }
                        $c60_codcon                     = current($this->fetchRow("select nextval('conplanoorcamento_c60_codcon_seq')"));
                        $c60_anousu                     = $oExercicios['c60_anousu'];
                        $c60_estrut                     = $sEstrut;
                        $c60_descr                      = substr($aPlanoOrcamento[1], 0, 50);
                        $c60_finali                     = $aPlanoOrcamento[1];
                        $c60_codsis                     = 2;
                        $c60_codcla                     = 1;
                        $c60_consistemaconta            = 0;
                        $c60_naturezasaldo              = 0;
                        $c60_funcao                     = $aPlanoOrcamento[1];

                        $aConPlano = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla,
                                        $c60_consistemaconta, $c60_naturezasaldo, $c60_funcao);

                        $this->insertConplanoOrcamento($aConPlano);

                        if($aPlanoOrcamento[3] == 'ANALITICA'){
                            $aInstituicoes = $this->fetchAll("select distinct c61_instit from conplanoorcamentoanalitica where c61_anousu = {$oExercicios['c60_anousu']} order by 1 ");
                            foreach($aInstituicoes as $oInstituicao){
                                $c61_codcon        = $c60_codcon;
                                $c61_anousu        = $oExercicios['c60_anousu'];
                                $c61_reduz         = current($this->fetchRow("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')"));
                                $c61_instit        = $oInstituicao['c61_instit'];
                                $c61_codigo        = 100;
                                $c61_contrapartida = 0;
                                $aConPlanoOrcamentoAnalitica    = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida);
                                $this->insertConplanoOrcamentoAnalitica($aConPlanoOrcamentoAnalitica);

                            }
                            $pcasp = $this->fetchRow("select c60_codcon from conplano where c60_anousu = {$oExercicios['c60_anousu']} and c60_estrut = '{$sEstrutPcasp}' ");
                            if(!empty($pcasp)){
                                $c72_sequencial = current($this->fetchRow("select nextval('conplanoconplanoorcamento_c72_sequencial_seq')"));
                                $c72_conplano = $pcasp['c60_codcon'];
                                $c72_conplanoorcamento = $c60_codcon;
                                $c72_anousu = $oExercicios['c60_anousu'];
                                $aConplanoConplanoOrcamento = array($c72_sequencial, $c72_conplano, $c72_conplanoorcamento, $c72_anousu);
                                $this->insertConplanoConplanoOrcamento($aConplanoConplanoOrcamento);
                            }
                        }
                    }
                }
            }
        }

    }

    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertConplanoOrcamento($data){
        $columns = array(
            'c60_codcon',
            'c60_anousu',
            'c60_estrut',
            'c60_descr',
            'c60_finali',
            'c60_codsis',
            'c60_codcla',
            'c60_consistemaconta',
            'c60_identificadorfinanceiro',
            'c60_funcao',
        );
        $this->table('conplanoorcamento', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertConplanoOrcamentoAnalitica($data) {
        $columns = array(
            'c61_codcon',
            'c61_anousu',
            'c61_reduz',
            'c61_instit',
            'c61_codigo',
            'c61_contrapartida',
        );
        $this->table('conplanoorcamentoanalitica', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertConplanoConplanoOrcamento($data) {
        $columns = array(
            'c72_sequencial',
            'c72_conplano',
            'c72_conplanoorcamento',
            'c72_anousu',
        );
        $this->table('conplanoconplanoorcamento', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }

    /**
     * @param Array $data
     * @param String $descricao
     */
    public function updateConplanoOrcamento($data, $descricao, $sEstrutPcasp){
        $sql = " update conplanoorcamento set c60_descr = '{$descricao}' where c60_anousu = {$data['c60_anousu']} and c60_codcon = {$data['c60_codcon']} ;";
        $sql .= " update orcelemento set o56_descr = '{$descricao}' where o56_anousu = {$data['c60_anousu']} and o56_codele = {$data['c60_codcon']} ;";

        $this->execute($sql);

        $this->execute("delete from conplanoconplanoorcamento where c72_conplanoorcamento = {$data['c60_codcon']} and c72_anousu = {$data['c60_anousu']}");

        $pcasp = $this->fetchRow("select c60_codcon from conplano where c60_anousu = {$data['c60_anousu']} and c60_estrut = '{$sEstrutPcasp}' ");
        if(!empty($pcasp)){
            $c72_sequencial = current($this->fetchRow("select nextval('conplanoconplanoorcamento_c72_sequencial_seq')"));
            $c72_conplano = $pcasp['c60_codcon'];
            $c72_conplanoorcamento = $data['c60_codcon'];
            $c72_anousu = $data['c60_anousu'];
            $aConplanoConplanoOrcamento = array($c72_sequencial, $c72_conplano, $c72_conplanoorcamento, $c72_anousu);
            $this->insertConplanoConplanoOrcamento($aConplanoConplanoOrcamento);
        }
    }

}
