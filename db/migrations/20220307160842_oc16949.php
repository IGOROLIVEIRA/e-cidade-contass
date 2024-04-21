<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc16949 extends PostgresMigration
{

   private $estruturalOrcamentoDe           = "331911302000000";
   private $sDescricao                      = "CONTRIB. PREV. RPPS PESSOAL ATIVO PLANO PREVID";
   private $sDescricaoInativada             = "DESATIVADA EM 2022";
   private $estruturalOrcamentoPara         = "331911308000000";
   private $estruturalOrcamentoDesativada   = "331911308990000";
   private $estruturalElementoPara          = "331911308000";
   private $estruturalElementoParaDestivada = "331911308990";
   private $anoUsu                          = 2021;

   public function up()
   {
        //Não rodar no cliente CMBH
        $aCmbhNaoExecutar = $this->fetchAll("select codigo from db_config where cgc in ('17316563000196','18715383000140')");
        if(empty($aCmbhNaoExecutar)){
            $aPlanoExistentesNovo = $this->fetchAll("select c60_codcon, c60_anousu, c60_estrut, c60_descr from conplanoorcamento where c60_anousu > {$this->anoUsu} and c60_estrut = '{$this->estruturalOrcamentoPara}' ");
            if(!empty($aPlanoExistentesNovo)) {
                $this->desativar($aPlanoExistentesNovo);
            }
            $aPlanoExistentesAntigo = $this->fetchAll("select c60_codcon, c60_anousu, c60_estrut, c60_descr from conplanoorcamento where c60_anousu > {$this->anoUsu} and c60_estrut = '{$this->estruturalOrcamentoDe}' ");

            if(!empty($aPlanoExistentesAntigo)) {
                $this->atualiza($aPlanoExistentesAntigo);
                return;
            }

            $aAnoExistentes = $this->fetchAll("select distinct c60_anousu from conplanoorcamento where c60_anousu > {$this->anoUsu} and c60_estrut like '3%'");

            foreach($aAnoExistentes as $ano) {
                $c60_codcon                     = current($this->fetchRow("select nextval('conplanoorcamento_c60_codcon_seq')"));
                $c60_anousu                     = $ano['c60_anousu'];
                $c60_estrut                     = $this->estruturalOrcamentoPara;
                $c60_descr                      = $this->sDescricao;
                $c60_finali                     = $this->sDescricao;
                $c60_codsis                     = 2;
                $c60_codcla                     = 1;
                $c60_consistemaconta            = 0;
                $c60_funcao                     = $this->sDescricao;
                $aConPlano = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla,
                                    $c60_consistemaconta,  $c60_funcao);

                $this->insertConplanoOrcamento($aConPlano);
                $aInstituicoes = $this->fetchAll("select distinct c61_instit from conplanoorcamentoanalitica where c61_anousu = {$ano['c60_anousu']} order by 1 ");
                foreach($aInstituicoes as $oInstituicao){
                    $c61_codcon        = $c60_codcon;
                    $c61_anousu        = $ano['c60_anousu'];
                    $c61_reduz         = current($this->fetchRow("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')"));
                    $c61_instit        = $oInstituicao['c61_instit'];
                    $c61_codigo        = 100;
                    $c61_contrapartida = 0;
                    $aConPlanoReduz    = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida);
                    $this->insertConplanoOrcamentoAnalitico($aConPlanoReduz);
                }
                $this->insertOrcElemento(array($c60_codcon, $c60_anousu, $this->estruturalElementoPara, $c60_descr, $c60_descr, 't'));

            }

            $aExisteAnalitica = $this->fetchAll("select * from conplanoorcamento left join conplanoorcamentoanalitica on c60_codcon=c61_codcon
                                            and c60_anousu=c61_anousu where c60_anousu > {$this->anoUsu} and c60_estrut = '{$this->estruturalOrcamentoPara}' order by 1 ");
            if(!empty($aExisteAnalitica)){
                foreach($aExisteAnalitica as $SemAnalitica){
                    if(!$SemAnalitica['c61_codcon']){
                        $aInstituicoes = $this->fetchAll("select distinct c61_instit from conplanoorcamentoanalitica where c61_anousu = {$ano['c60_anousu']} order by 1 ");
                        foreach($aInstituicoes as $oInstituicao){
                            $c61_codcon        = $SemAnalitica['c60_codcon'];
                            $c61_anousu        = $SemAnalitica['c60_anousu'];
                            $c61_reduz         = current($this->fetchRow("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')"));
                            $c61_instit        = $oInstituicao['c61_instit'];
                            $c61_codigo        = 100;
                            $c61_contrapartida = 0;
                            $aConPlanoReduz    = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida);
                            $this->insertConplanoOrcamentoAnalitico($aConPlanoReduz);
                        }
                    }
                }
            }
        }
   }

   public function atualiza($aPlanoExistentes){
    foreach($aPlanoExistentes as $oPlano){
        $sSql = "
        begin;
            update conplanoorcamento set c60_estrut='{$this->estruturalOrcamentoPara}', c60_descr = '{$this->sDescricao}' where c60_codcon = {$oPlano['c60_codcon']} and c60_anousu= {$oPlano['c60_anousu']};
            update orcelemento set  o56_elemento='{$this->estruturalElementoPara}', o56_descr = '{$this->sDescricao}' where o56_codele = {$oPlano['c60_codcon']} and o56_anousu= {$oPlano['c60_anousu']};
        commit;
        ";
        $this->execute($sSql);
    }
   }

   public function desativar($aPlanoExistentes){
    foreach($aPlanoExistentes as $oPlano){

        $sSql = "
        begin;
            update conplanoorcamento set c60_estrut='{$this->estruturalOrcamentoDesativada}', c60_descr = '{$this->sDescricaoInativada}' where c60_codcon = {$oPlano['c60_codcon']} and c60_anousu= {$oPlano['c60_anousu']};
            update orcelemento set  o56_elemento='{$this->estruturalElementoParaDestivada}', o56_descr = '{$this->sDescricaoInativada}' where o56_codele = {$oPlano['c60_codcon']} and o56_anousu= {$oPlano['c60_anousu']};
        commit;
        ";
        $this->execute($sSql);
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
            'c60_funcao',
        );
        $this->table('conplanoorcamento', array('schema' => 'contabilidade'))->insert($columns, array($data))->saveData();
    }

    /**
     * Faz a carga dos dados na tabela
     * @param Array $data
     */
    public function insertConplanoOrcamentoAnalitico($data) {
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
    public function insertOrcElemento($data) {
        $columns = array(
            'o56_codele',
            'o56_anousu',
            'o56_elemento',
            'o56_descr',
            'o56_finali',
            'o56_orcado',
        );
        $this->table('orcelemento', array('schema' => 'orcamento'))->insert($columns, array($data))->saveData();
    }
}
