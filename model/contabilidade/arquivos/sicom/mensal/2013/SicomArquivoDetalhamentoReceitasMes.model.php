<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * detalhamento das receitas do mês Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoReceitasMes extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 149;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REC';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codOrgao",
                          "identificadorDeducao",
                          "rubrica",
                          "especificacao",
                          "vlArrecadado",
                          "vlAcumuladoMesAnt"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codFonte",
                          "vlArrecadadoFonte",
    											"vlAcumuladoFonteMesAnt"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados das receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
    $sSql  = "SELECT * FROM db_config ";
		$sSql .= "	WHERE prefeitura = 't'";
    	
    $rsInst = db_query($sSql);
    $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;
      
  	/**
  	 * selecionar arquivo xml com dados dos orgão
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomorgao.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração dos orgãos do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oOrgaos      = $oDOMDocument->getElementsByTagName('orgao');
    
    /**
     * percorrer os orgaos retornados do xml para selecionar o orgao da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oOrgaos as $oOrgao) {
      
    	if ($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")) {
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
   // select o57_fonte,o60_perc from orcfontesdes join orcfontes on  o57_codfon = o60_codfon and o60_anousu = o57_anousu where o60_anousu = 2013;
    
  
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }
    
    $db_filtro  = "o70_instit = ".db_getsession("DB_instit");

    $anousu  = db_getsession("DB_anousu");

    $aDadosAgrupados = array();
    $rsResult = db_receitasaldo(11,1,3,true,$db_filtro,$anousu,$this->sDataInicial,$this->sDataFinal,false,' * ',true,0);
    //db_criatabela($rsResult);
    /**
     * percorrer os resultados retornados por db_receitasaldo
     */
    for ($iCont = 0;$iCont < pg_num_rows($rsResult); $iCont++) {
    
	    $oReceita = db_utils::fieldsMemory($rsResult,$iCont);
    	
	    if ($oReceita->o70_codrec != 0) {
	    	
    	  /**
	       * o primeiro digito 9 identifica o identificador deducao do sicom no campo especificado
	       */
	      if($oReceita->o70_concarpeculiar[0] == '9'){
	        $iIdentDeducao = $oReceita->o70_concarpeculiar[1].$oReceita->o70_concarpeculiar[2];	
	      }else{
	        $iIdentDeducao = " ";
	      }
	    	
	      /**
	       * 
	       * Hash para agrupar informações no array pela rubrica
	       * @var String
	       */
        $sHash = substr($oReceita->o57_fonte, 0, 9);
        
	      if($oReceita->o57_fonte[1] == 5){
	        $oReceita->o57_fonte[1] = 1; 
	      }
	      
	      /**
	       * cria nova posição no array ou usa uma existente para somar os valores de rubrica igual
	       */
        if (!isset($aDadosAgrupados[$sHash])) {
  	
  	      $oDadosReceitaMes = new stdClass();
    
          $oDadosReceitaMes->tipoRegistro         = 10;
          $oDadosReceitaMes->detalhesessao        = 10;
          $oDadosReceitaMes->codReceita           = substr($oReceita->o70_codrec, 0, 15);
          $oDadosReceitaMes->codOrgao             = $sOrgao;
          $oDadosReceitaMes->identificadorDeducao = $iIdentDeducao;
          $oDadosReceitaMes->rubrica              = substr($oReceita->o57_fonte, 1, 8);
          $oDadosReceitaMes->especificacao        = substr($oReceita->o57_descr, 0, 100);
          $oDadosReceitaMes->vlArrecadado         = 0;
          $oDadosReceitaMes->vlAcumuladoMesAnt    = 0;
          $oDadosReceitaMes->FonteRecusroMes      = array();
    
          $aDadosAgrupados[$sHash] = $oDadosReceitaMes;
    
        } else {
	        $oDadosReceitaMes = $aDadosAgrupados[$sHash];
	      }
	  		
	      /**
	       * 
	       * Hash para agrupar informações no array pela fonte
	       * @var String
	       */
	      $sHashFonte = str_pad($oReceita->o70_codigo, 3, "0", STR_PAD_LEFT);
	      
	      /**
	       * cria nova posição no array ou usa uma existente para somar valores de fontes iguais
	       */
	      if (!isset($oDadosReceitaMes->FonteRecursoMes[$sHashFonte])) {
	  
	      	$rsResultCodTri = db_query("SELECT o15_codtri from orctiporec where o15_codigo = {$oReceita->o70_codigo}");
	      	$iCodTri = db_utils::fieldsMemory($rsResultCodTri, 0)->o15_codtri;
	      	
		      $oDadosFonteRecursoMes = new stdClass();
    
	        $oDadosFonteRecursoMes->tipoRegistro  = 11;
	        $oDadosFonteRecursoMes->detalhesessao = 11;
	        $oDadosFonteRecursoMes->codReceita    = substr($oReceita->o70_codrec, 0, 15);
	        $oDadosFonteRecursoMes->codFonte      = str_pad($iCodTri, 3, "0", STR_PAD_LEFT);
	  
	        $oDadosFonteRecursoMes->vlArrecadadoFonte       = 0;
	        $oDadosFonteRecursoMes->vlAcumuladoFonteMesAnt  = 0;
	      
	        $oDadosReceitaMes->FonteRecursoMes[$sHashFonte] = $oDadosFonteRecursoMes;
	  
	      } else {
		      $oDadosFonteRecursoMes = $oDadosReceitaMes->FonteRecursoMes[$sHashFonte];
	      }
  		  
	      $oDadosFonteRecursoMes->vlArrecadadoFonte       += $oReceita->saldo_arrecadado;
	      $oDadosFonteRecursoMes->vlAcumuladoFonteMesAnt  += $oReceita->saldo_anterior;
		    $oDadosReceitaMes->FonteRecursoMes[$sHashFonte]  = $oDadosFonteRecursoMes;
		    
	      $oDadosReceitaMes->vlPrevistoAtualizado += $oReceita->saldo_inicial;
        $oDadosReceitaMes->vlArrecadado         += $oReceita->saldo_arrecadado;
        $oDadosReceitaMes->vlAcumuladoMesAnt    += $oReceita->saldo_anterior;
        $aDadosAgrupados[$sHash] = $oDadosReceitaMes;
         
      }
      
    }
 		
  	/**
	   * passar todos os dados registro 10 para o $this->aDados[]
	   */
	  foreach ($aDadosAgrupados as $oDado) {

	  	if ($oDado->vlArrecadado <> 0) {
	  	  	
		  	$oDadosReceita = clone $oDado;
		  	unset($oDadosReceita->FonteRecursoMes);
		  	$oDadosReceita->vlPrevistoAtualizado = number_format(abs($oDadosReceita->vlPrevistoAtualizado), 2, "", "");
		  	$oDadosReceita->vlArrecadado         = number_format(abs($oDadosReceita->vlArrecadado), 2, "", "");
	      $oDadosReceita->vlAcumuladoMesAnt    = number_format(abs($oDadosReceita->vlAcumuladoMesAnt), 2, "", "");
		  	$this->aDados[] = $oDadosReceita;
		    	
		  /**
		   * passar todos os dados registro 11 para o $this->aDados[]
		   */
		    foreach ($oDado->FonteRecursoMes as $oFonteRecurso) {
		    	
		    	if ($oFonteRecurso->vlArrecadadoFonte != 0 || $oFonteRecurso->vlAcumuladoFonteMesAnt != 0) {
		    		
		    	  $oFonteRecurso->vlArrecadadoFonte      = number_format(abs($oFonteRecurso->vlArrecadadoFonte), 2, "", "");
		        $oFonteRecurso->vlAcumuladoFonteMesAnt = number_format(abs($oFonteRecurso->vlAcumuladoFonteMesAnt), 2, "", "");
		        $oFonteRecurso->codReceita             = $oDadosReceita->codReceita;
		  		  $this->aDados[] = $oFonteRecurso;
		  		
		    	}
		  		
		   	}
		   	
	  	}	
	  	
	  }

pg_exec("commit");
	    
    }
		
  }