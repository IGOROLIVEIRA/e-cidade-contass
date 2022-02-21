<?php

use Classes\PostgresMigration;

class Oc16737NovasContas extends PostgresMigration
{

    public function up()
    {
        $nAnoInclusao = 2022;
        if(($handle = fopen("db/migrations/pcasp2022incluir.csv", "r")) !== FALSE)  {
            while ( ($aPcasp = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if($aPcasp[0] === 'CONTA'){
                    continue;
                }
                // se existir o estrutural não deve ser inserido nem atualizado.
                $sEstrut = str_pad($aPcasp[0],15,"0");
                $aConplanoExiste = $this->fetchAll("select * from conplano where c60_anousu={$nAnoInclusao} and c60_estrut = '{$sEstrut}'");
                if(!empty($aConplanoExiste)){
                    continue;
                }

                $c60_codcon                     = current($this->fetchRow("select nextval('conplano_c60_codcon_seq')"));
                $c60_anousu                     = $nAnoInclusao;
                $c60_estrut                     = $sEstrut;
                $c60_descr                      = substr($aPcasp[1], 0, 50);
                $c60_finali                     = $aPcasp[2];
                $c60_codsis                     = 6; // VER COM BARBARA
                $c60_codcla                     = 1; // VER COM BARBARA
                $c60_consistemaconta            = 2; // VER COM BARBARA
                $c60_identificadorfinanceiro    = $aPcasp[5] == 'P/F' ? 'F' : $aPcasp[5];
                $c60_naturezasaldo              = $aPcasp[3] == 'D' ? 1 : $aPcasp[3] == 'C' ? 2 : 3;
                $c60_funcao                     = $aPcasp[2];
                $c60_nregobrig                  = $aPcasp[6] == '' ? 0 : $aPcasp[6];

                //ver tambem campos MSC E CONTA CORRENTE

                $aConPlano = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla,
                                $c60_consistemaconta, $c60_identificadorfinanceiro, $c60_naturezasaldo, $c60_funcao, $c60_nregobrig);

                $this->insertConplano($aConPlano);
                if($aPcasp[14] == 'S'){
                    $aInstituicoes = $this->fetchAll("select distinct c61_instit from conplanoreduz where c61_anousu = {$nAnoInclusao} order by 1 ");

                    foreach($aInstituicoes as $oInstituicao){
                        $c61_codcon = $c60_codcon;
                        $c61_anousu = $nAnoInclusao;
                        $c61_reduz  = current($this->fetchRow("select nextval('conplano_c60_codcon_seq')"));
                        $c61_instit = $oInstituicao['c61_instit'];
                        $c61_codigo = 100 ;
                        $c61_contrapartida = 0 ;
                        $c61_codtce = 0 ;
                        $aConPlanoReduz = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida, $c61_codtce);
                        $this->insertConplanoReduz($aConPlanoReduz);
                    }
                }
            }
        }

    }

    /**
     * Faz a carga dos dados na tabela db_usuarios
     * @param Array $data
     */
    public function insertConplano($data){
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
            'c60_naturezasaldo',
            'c60_funcao',
            'c60_nregobrig'
        );
        $this->table('conplano', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela db_usuarios
     * @param Array $data
     */
    public function insertConplanoReduz($data) {
        $columns = array(
            'c61_codcon',
            'c61_anousu',
            'c61_reduz',
            'c61_instit',
            'c61_codigo',
            'c61_contrapartida',
            'c61_codtce',
        );
        $this->table('conplanoreduz', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }
}
