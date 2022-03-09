<?php

use Phinx\Migration\AbstractMigration;

class Oc16961 extends AbstractMigration
{
    public function up()
    {
        $nAnoInicial = 2022;
        if(($handle = fopen("db/migrations/planoorcamentario2022.txt", "r")) !== FALSE)  {
            while ( ($aPcasp = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($aPcasp[0] === 'CONTA'){
                    continue;
                }
                $aExercicios = $this->fetchAll("select distinct c60_anousu from conplanoorcamento where c60_anousu >= {$nAnoInicial}");
                foreach($aExercicios as $oExercicios){
                    // se existir o estrutural não deve ser inserido nem atualizado.
                    $sEstrut = str_pad($aPcasp[0], 15, "0");
                    $aConplanoExiste = $this->fetchAll("select * from conplanoorcamento where c60_anousu={$oExercicios['c60_anousu']} and c60_estrut = '{$sEstrut}'");
                    if(!empty($aConplanoExiste)){
                        continue;
                    }

                    $c60_codcon                     = current($this->fetchRow("select nextval('conplanoorcamento_c60_codcon_seq')"));
                    $c60_anousu                     = $oExercicios['c60_anousu'];
                    $c60_estrut                     = $sEstrut;
                    $c60_descr                      = substr($aPcasp[1], 0, 50);
                    $c60_finali                     = $aPcasp[2];
                    $c60_codsis                     = $aPcasp[9] !== '' ? $aPcasp[9] : 0;
                    $c60_codcla                     = 1;
                    $c60_consistemaconta            = 0;
                    $c60_naturezasaldo              = $aPcasp[3] == 'D' ? 1 : $aPcasp[3] == 'C' ? 2 : 3;
                    $c60_funcao                     = $aPcasp[2];

                    $aConPlano = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla,
                                       $c60_consistemaconta, $c60_naturezasaldo, $c60_funcao);

                    $this->insertConplanoOrcamento($aConPlano);
                    if($aPcasp[14] == 'S'){
                        $aInstituicoes = $this->fetchAll("select distinct c61_instit from conplanoorcamentoanalitica where c61_anousu = {$oExercicios['c60_anousu']} order by 1 ");

                        foreach($aInstituicoes as $oInstituicao){
                            $c61_codcon        = $c60_codcon;
                            $c61_anousu        = $oExercicios['c60_anousu'];
                            $c61_reduz         = current($this->fetchRow("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')"));
                            $c61_instit        = $oInstituicao['c61_instit'];
                            $c61_codigo        = 100;
                            $c61_contrapartida = 0;
                            $c61_codtce        = 0;
                            $aConPlanoReduz    = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida, $c61_codtce);
                            $this->insertConplanoOrcamentoAnalitica($aConPlanoReduz);

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
            'c61_codtce',
        );
        $this->table('conplanoorcamentoanalitica', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }


}
