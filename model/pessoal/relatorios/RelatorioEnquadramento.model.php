<?php
require_once("RelatorioFolhaPagamentoPontoFixo.model.php");

/**
 * @fileoverview Classe para relatório da folha analitico/sintetico
 *
 * @author  Rafael Lopes rafael.lopes@dbseller.com.br
 *          Rafael Nery  rafael.nery@dbseller.com.br
 *
 * @package Pessoal
 * @revision $Author: dbrafael.nery $
 * @version $Revision: 1.5 $
 */
class RelatorioEnquadramento extends RelatorioFolhaPagamentoPontoFixo  {
  
  protected $aRetorno   = array();
  protected $aDadosBase = array();
  protected $lAfastados = true;
  
  public function __construct(){
    parent::__construct();
  }
    /**
     * metodo para retornarmos os dados basicos do relatorio
     * tratamos junto o where dos afastados
     *
     * @return $this
     */
  public function getDadosBase(){
    
    $oDadosRetorno                         = new stdClass();
    $sWhere                                = null;
    
	  if (!$this->lAfastados) {
	  		  
	    $sWhere  = " rh01_regist not in (select r45_regist                                   
	                                              from afasta 
	                                             where r45_anousu = {$this->iAno}
          	                                     and r45_mesusu = {$this->iMes} 
	                                               and(r45_regist is not null 
	                                                    and (    r45_dtreto is null 
	                                                          or r45_dtreto > '{$this->iAno}-{$this->iMes}-01')
	                                                        ) 
	                                     )";
	                                     
	  }   	
	  
    $aSQLBase = $this->retornaSQLBaseRelatorio($sWhere);
    
    foreach ($aSQLBase as $sTabelaPonto => $sSqlBase){
      
      $rsDados                                                    = db_query($sSqlBase);
      
      if ( $rsDados && pg_num_rows($rsDados) > 0 ) {
        
        while ($oDados = pg_fetch_object($rsDados) ) {
          
        	
        	//print_r($oDados);exit;
        	
          $oDadosServidor = new stdClass();
          $oDadosServidor->matricula_servidor                  = $oDados->matricula_servidor;
          $oDadosServidor->nome_servidor                       = $oDados->nome_servidor     ;
          $oDadosServidor->codigo_cargo                        = $oDados->codigo_cargo      ;
          $oDadosServidor->descr_cargo                         = $oDados->descr_cargo       ;
          $oDadosServidor->codigo_lotacao                      = $oDados->codigo_lotacao    ;
          $oDadosServidor->estrutural_lotacao                  = $oDados->estrutural_lotacao;
          $oDadosServidor->descr_lotacao                       = $oDados->descr_lotacao     ;
          $oDadosServidor->codigo_funcao                       = $oDados->codigo_funcao     ;
          $oDadosServidor->descr_funcao                        = $oDados->descr_funcao      ;
          $oDadosServidor->data_admissao                       = $oDados->data_admissao     ;
          $oDadosServidor->descr_regime												 = $oDados->descr_regime      ;
          $oDadosServidor->horas_mensais                       = $oDados->horas_mensais     ;
          $oDadosServidor->salario_base                        = $oDados->rh02_salari       ;
          
          
          $oDadosRubricas = new stdClass();                   
          $oDadosRubricas->rubrica                             = $oDados->rubrica           ;
          $oDadosRubricas->valor_rubrica                       = $oDados->valor_rubrica     ;
          $oDadosRubricas->quant_rubrica                       = $oDados->quant_rubrica     ;
          $oDadosRubricas->provento_desconto                   = $oDados->provento_desconto ;
          $oDadosRubricas->descr_rubrica                       = $oDados->descr_rubrica     ;
          
          $oDadosRetorno->aDadosServidor[$oDados->matricula_servidor]                                  = $oDadosServidor ;
          $oDadosRetorno->aDadosRubricas[$sTabelaPonto][$oDados->matricula_servidor][$oDados->rubrica] = $oDadosRubricas ;
          
          $oRubricas = new stdClass();
          $oRubricas->rubrica                                  = $oDados->rubrica;
          $oRubricas->descr_rubrica                            = $oDados->descr_rubrica;
                    
          $oDadosRetorno->aRubricas     [$oDados->rubrica]     = $oRubricas;
          asort($oDadosRetorno->aRubricas);
        }
      } else {
        
        $oDadosRetorno->aDadosServidor   = array();
        $oDadosRetorno->aDadosRubricas   = array();
        $oDadosRetorno->aRubricas        = array();
      }
    }
    return $oDadosRetorno;
  }
  
  
  /**
   * metodo set para definirmos se filtramos ou nao pelos
   * servidores afastados
   *
   * @param bollean $lAfastados
   * @return $this
   */
  public function setAfastados($lAfastados){
  	
  	$this->lAfastados = $lAfastados;
  	return $this;
  }
  
}
