<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoMetasArrecadacaoReceita extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  protected $iCodigoLayout = 145;
  
  protected $sNomeArquivo = 'MTBIARREC';
  
  protected $iCodigoPespectiva;
  
  public function __construct() {
    
  }
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos  = array(
                          "metaArrec1Bim",
                          "metaArrec2Bim",
                          "metaArrec3Bim",
                          "metaArrec4Bim",
                          "metaArrec5Bim",
                          "metaArrec6Bim"
                        );
    return $aElementos;
  }
  
  public function gerarDados(){
  	/*
  	 * base retirada do relatorio contido no arquivo orc2_orcprevmensalrec002.php
  	 */
    require_once ("model/ppaVersao.model.php");
    require_once("libs/db_sql.php");
		require_once("libs/db_utils.php");
		require_once("libs/db_liborcamento.php");
		require_once("libs/db_libcontabilidade.php");
		require_once("classes/db_orccenarioeconomicoparam_classe.php");
		require_once("dbforms/db_funcoes.php");
		require_once("model/cronogramaFinanceiro.model.php");
		require_once("model/relatorioContabil.model.php");
    
    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
    /**
     * objeto usado para receber os dados do municipio conforme especificado no array dos campos
     * @var unknown_type
     */
  	$sArquivo = "config/sicom/sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    $aOrgao = array();
    foreach ($oOrgaos as $oOrgao) {
    		$aOrgao[] = $oOrgao->getAttribute('instituicao');
    }    
    // Lista das instituições selecionadas
		$sListaInstit = implode(",",$aOrgao);
		
		// Selecionar lista de recursos
		$sDataAtual    = implode("-", array_reverse(explode("/", date("d/m/Y"))));
		$sSqlRecursos  = "select o15_codigo from "; 
		$sSqlRecursos .= "orctiporec where 1 = 1 and (o15_datalimite is null or o15_datalimite > '{$sDataAtual}') order by o15_codigo";
		$rsRecursos    = db_query($sSqlRecursos);
		$iRows = pg_num_rows($rsRecursos);
		for ($iCont = 0; $iCont < $iRows; $iCont++) {
			$oGet->slistaRecursos .= db_utils::fieldsMemory($rsRecursos, $iCont)->o15_codigo;
			$oGet->slistaRecursos .= ",";
		}
		
		$oGet->slistaRecursos[strlen($oGet->slistaRecursos)-1] = '';
		//echo "{$oGet->slistaRecursos}<br>";exit;
		//print_r($aRecursos);exit;
		$oGet	   = new stdClass();
		$oGet->iPeriodoImpr = 2;
		$oGet->iFormaImpr   = 1;
		$oGet->iRec         = 1;
		
		// Código do Relatório
		$iCodRel = 76;
		// Array com os recursos selecionados
		if ($oGet->slistaRecursos == '') {
			$aMRecursos = null;
		} else {
			$aMRecursos = explode(',',$oGet->slistaRecursos);	
		}
		
		
		$oRelatorioContabil         = new relatorioContabil($iCodRel);
		$clcronogramaFinanceiro			= new cronogramaFinanceiro($oGet->iRec);
		$clcronogramaFinanceiro->setInstituicoes($aOrgao);
		
		try {
			$aReceitas = $clcronogramaFinanceiro->getMetasReceita(null, $aMRecursos);
		} catch (Exception $erro) {
			db_redireciona('db_erros.php?fechar=true&db_erro='.$erro->getMessage());
		}
		
		if ($oGet->iPeriodoImpr == 1 && $oGet->iFormaImpr == 1) {
			
			//Imprime por receita e mensal

			$aRelatorio       = array();
			$aRelatorioTotais = array();
			$iNumRows         = count($aReceitas);
			for ($iInd = 0; $iInd < $iNumRows; $iInd++) {
				
				$aRelatorio[$iInd] = new stdClass();
				$aRelatorio[$iInd]->o70_codigo = $aReceitas[$iInd]->o57_fonte;
				$aRelatorio[$iInd]->o57_fonte  = $aReceitas[$iInd]->o57_fonte;
				$aRelatorio[$iInd]->o57_descr  = substr(urldecode($aReceitas[$iInd]->o57_descr),0,35);
				$iNumRowsDados                 = count($aReceitas[$iInd]->aMetas->dados);
		
				for ($jInd = 0; $jInd < $iNumRowsDados; $jInd++) {
					
					$aRelatorio[$iInd]->aMetas->dados[$jInd]->valor = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
					if (!empty($aReceitas[$iInd]->o70_codigo)) {
		      
						if (array_key_exists($jInd,$aRelatorioTotais)) {
							$aRelatorioTotais[$jInd] += $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
						} else {
							$aRelatorioTotais[$jInd]  = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
						}
					
					}
					
					$aRelatorio[$iInd]->aMetas->getValues = $aReceitas[$iInd]->o70_valor;							
				}
			}
		} else if($oGet->iPeriodoImpr == 1 && $oGet->iFormaImpr == 2) {

			
			$aRelatorio 			= array();
			$aRelatorioTotais = array();
			
			for ($jInd = 0; $jInd < 12; $jInd++) $aRelatorioTotais[$jInd] = 0;
			
			$iNumRows = count($aReceitas);
			for ($iInd = 0; $iInd < $iNumRows; $iInd++) {
				
				if (empty($aReceitas[$iInd]->o70_codigo)) {
					continue;
				}
				
				if (array_key_exists($aReceitas[$iInd]->o70_codigo, $aRelatorio)) {
					
					$iNumRowsDados                                                 = count($aReceitas[$iInd]->aMetas->dados);
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->getValues += $aReceitas[$iInd]->o70_valor;
					for ($jInd = 0; $jInd < $iNumRowsDados; $jInd++) {
						
						$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->dados[$jInd]->valor += $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
						if (!empty($aReceitas[$iInd]->o70_codigo)) {
						 $aRelatorioTotais[$jInd] += $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
						}
					}
				} else {
					
					$aRelatorio[$aReceitas[$iInd]->o70_codigo] = new stdClass();
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o70_codigo = $aReceitas[$iInd]->o70_codigo;
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o57_fonte  = $aReceitas[$iInd]->o57_fonte;
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o57_descr  = substr(urldecode($aReceitas[$iInd]->o15_descr),0,35);
					$iNumRowsDados                                         = count($aReceitas[$iInd]->aMetas->dados);
					
					for ($jInd = 0; $jInd < $iNumRowsDados; $jInd++) {
						
						$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->dados[$jInd]->valor = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor;
						$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->getValues           = $aReceitas[$iInd]->o70_valor;
						if (!empty($aReceitas[$iInd]->o70_codigo)) {
						  $aRelatorioTotais[$jInd] += $aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->dados[$jInd]->valor;
						}
					}
				}
			}
		} else if($oGet->iPeriodoImpr == 2 && $oGet->iFormaImpr == 1) {
			
			//Imprime por receita e bimestral
			
			$aRelatorio       = array();
			$aRelatorioTotais = array();
			
			for ($iInd = 0; $iInd < 6; $iInd++) $aRelatorioTotais[$iInd] = 0;
			
			$iNumRows = count($aReceitas);
			for ($iInd = 0; $iInd < $iNumRows; $iInd++) {
				
				$aRelatorio[$iInd] = new stdClass();
				$aRelatorio[$iInd]->o70_codigo        = $aReceitas[$iInd]->o57_fonte;
				$aRelatorio[$iInd]->o57_fonte	        = $aReceitas[$iInd]->o57_fonte;
				$aRelatorio[$iInd]->o57_descr         = substr(urldecode($aReceitas[$iInd]->o57_descr),0,35);
				$iNumRowsDados                        = count($aReceitas[$iInd]->aMetas->dados);
				$aRelatorio[$iInd]->aMetas->getValues = 0;
				$indice                               = 0;
				
				for ($jInd = 0; $jInd < $iNumRowsDados; $jInd++) {
					
					if ($jInd%2==0 || $jInd == 0) {
		
						$aRelatorio[$iInd]->aMetas->dados[$indice]->valor = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor +
						                                                    $aReceitas[$iInd]->aMetas->dados[$jInd+1]->valor;
						$aRelatorio[$iInd]->aMetas->getValues            += $aRelatorio[$iInd]->aMetas->dados[$indice]->valor;
						if (!empty($aReceitas[$iInd]->o70_codigo)) {	
						  $aRelatorioTotais[$indice] += $aRelatorio[$iInd]->aMetas->dados[$indice]->valor;
						}
							
						$indice++;
					}
				}
			}
		} else if ($oGet->iPeriodoImpr == 2 && $oGet->iFormaImpr == 2) {
			
			//Imprime por recurso e bimestral
			
			$aRelatorio 			= array();
			$aRelatorioTotais = array();
			
			for ($iInd = 0; $iInd < 6; $iInd++) $aRelatorioTotais[$iInd] = 0;
			
			$iNumRows = count($aReceitas);
			for ($iInd = 0; $iInd < $iNumRows; $iInd++) {
				
		  	if (empty($aReceitas[$iInd]->o70_codigo)) {
		      continue;
		    }
		    
				if (array_key_exists($aReceitas[$iInd]->o70_codigo, $aRelatorio)) {
					
					$iNumRowsDados = count($aReceitas[$iInd]->aMetas->dados);
					$indice        = 0;
					for($jInd = 0; $jInd < ($iNumRowsDados); $jInd++) {
						
						if ($jInd%2==0 || $jInd==0) {
							
							$soma = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor + $aReceitas[$iInd]->aMetas->dados[$jInd+1]->valor;
							$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->dados[$indice]->valor += $soma; 
							$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->getValues             += $soma;
							if (!empty($aReceitas[$iInd]->o70_codigo)) { 
							  $aRelatorioTotais[$indice] += $soma;		
							}
															
							$indice++;
						}
					}
				} else {
					
					$aRelatorio[$aReceitas[$iInd]->o70_codigo] 						 = new stdClass();
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o70_codigo = $aReceitas[$iInd]->o70_codigo;
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o57_fonte  = $aReceitas[$iInd]->o57_fonte;
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->o57_descr  = substr(urldecode($aReceitas[$iInd]->o15_descr),0,35);
					
					$iNumRowsDados = count($aReceitas[$iInd]->aMetas->dados);
					$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->getValues = 0;
					$indice = 0;
					
					for ($jInd = 0; $jInd < ($iNumRowsDados); $jInd++) {
						
						if ($jInd%2==0 || $jInd==0) {
							
							$soma = $aReceitas[$iInd]->aMetas->dados[$jInd]->valor + $aReceitas[$iInd]->aMetas->dados[$jInd+1]->valor;
							$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->dados[$indice]->valor  = $soma;
							$aRelatorio[$aReceitas[$iInd]->o70_codigo]->aMetas->getValues 						 += $soma;
							if (!empty($aReceitas[$iInd]->o70_codigo)) {
							  $aRelatorioTotais[$indice] += $soma;				
							}
							
							$indice++;
						}
					}
				}
			}
		}
		
		


		
		/*if($oGet->iPeriodoImpr == 2) {
			
			
		//Imprime a linha final das totalizações
		
			$iNumRows       = count($oRelatorio->iPeriocidade);
			$iNumRowsTotais = count($aRelatorioTotais);
			//print_r($aRelatorioTotais);
		}*/
		
		
    $oDadosMTBIARREC = new stdClass();
    
    $oDadosMTBIARREC->metaArrec1Bim = number_format($aRelatorioTotais[0], 2, "", "");
    $oDadosMTBIARREC->metaArrec2Bim = number_format($aRelatorioTotais[1], 2, "", "");
    $oDadosMTBIARREC->metaArrec3Bim = number_format($aRelatorioTotais[2], 2, "", "");
    $oDadosMTBIARREC->metaArrec4Bim = number_format($aRelatorioTotais[3], 2, "", "");
    $oDadosMTBIARREC->metaArrec5Bim = number_format($aRelatorioTotais[4], 2, "", "");
    $oDadosMTBIARREC->metaArrec6Bim = number_format($aRelatorioTotais[5], 2, "", "");
    
    $this->aDados[] = $oDadosMTBIARREC;
    
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }
}