<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * detalhamento das correcoes das receitas do mes Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoRestosPagar extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 168;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'RSP';
  
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
						    					  "codReduzido",
						                "codOrgao",
						                "dotOrig",
						                "nroEmpenho",
						                "dtEmpenho",
						                "tipoDocumentoCredor",
						                "nroDocumentoCredor",
						    					  "nomeCredor",
						    					  "vlOriginal",
						    					  "vlSaldoAntProce",
						    					  "vlSaldoAntNaoProc"	
                        );
                        
    $aElementos[11] = array(
	                          "tipoRegistro",
	    					            "codReduzido", 
	                          "codFontRecursos",
	    					            "vlOriginalFonte",
	    					            "vlSaldoAntProceFonte",
	    					            "vlSaldoAntNaoProcFonte"
                        );
    $aElementos[12] = array(
	                          "tipoRegistro",
	    					            "codReduzido", 
	                          "tipoDocumento",
	    					            "nroDocumento",
	    					            "nomeCredor"
                        );
    $aElementos[20] = array(
	                          "tipoRegistro",
	    					            "codReduzido", 
	                          "codOrgao",
	    					            "dotOrig",
	    					            "nroEmpenho",
												    "dtEmpenho",
												    "tipoDocumentoCredor",
												    "nroDocumentoCredor",
												    "nomeCredor",
												    "tipoRestosPagar",
												    "tipoMovimento",
												    "dtMovimentacao",
												    "vlMovimentacao",
												    "vlSaldoAnterior",
												    "codOrgaoEncampAtribuic",
												    "codUnidadeSub",
    												"justCancelamento",
    												"atoCancelamento",
    												"dataAtoCancelamento"
                        );
    $aElementos[21] = array(
	                          "tipoRegistro",
	    					            "codReduzido", 
	                          "codFontRecursos",
	    					            "vlMovimentacaoFonte",
	    					            "vlSaldoAnteriorFonte"
                        );                        
    return $aElementos;
    
  }
  
  /**
   * selecionar os dados de Restos pagar do mes para gerar o arquivo
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
      
    	if($oOrgao->getAttribute('instituicao') == db_getsession("DB_instit")){
        $sOrgao     = str_pad($oOrgao->getAttribute('codOrgao'), 2, "0", STR_PAD_LEFT);
    	}
    	
    }
    
    if (!isset($oOrgao)) {
      throw new Exception("Arquivo sem configuração de Orgãos.");
    }

    $sSql = "SELECT e91_numemp,
       e91_vlremp,
       e91_vlranu,
       e91_vlrliq,
       e91_vlrpag,
       e91_recurso,
       o15_descr,
       vlranu,
       vlrliq,
       vlrpag,
       e91_codtipo,
       e90_descr,
       z01_nome,
       e60_numemp,
       e60_instit,
       e60_codemp,
       e60_emiss,
       e60_anousu,
       o58_orgao,
       o58_unidade,
       o58_funcao,
       o58_subfuncao,
       o56_elemento,
       o58_codigo,
       o56_descr,
       o40_descr,
       o41_descr,
       o53_descr,
       /* descrição da subfunçao */ vlranuliq,
                                    vlranunliq,
                                    vlrpagliq
FROM
  (SELECT e91_numemp,
          e91_codtipo,
          e90_descr,
          o15_descr,
          coalesce(e91_vlremp,0) AS e91_vlremp,
          coalesce(e91_vlranu,0) AS e91_vlranu,
          coalesce(e91_vlrliq,0) AS e91_vlrliq,
          coalesce(e91_vlrpag,0) AS e91_vlrpag,
          e91_recurso,
          coalesce(vlranu,0) AS vlranu,
          coalesce(vlranuliq,0) AS vlranuliq,
          coalesce(vlranunliq,0) AS vlranunliq,
          coalesce(vlrliq,0) AS vlrliq,
          coalesce(vlrpag,0) AS vlrpag,
          coalesce(vlrpagliq,0) AS vlrpagliq
   FROM empresto
   INNER JOIN emprestotipo ON e91_codtipo = e90_codigo
   INNER JOIN orctiporec ON e91_recurso = o15_codigo
   LEFT OUTER JOIN
     (SELECT c75_numemp,
             sum(CASE WHEN c53_tipo = 11 THEN c70_valor ELSE 0 END) AS vlranu,
             sum(CASE WHEN c71_coddoc = 31 THEN c70_valor ELSE 0 END) AS vlranuliq,
             sum(CASE WHEN c53_coddoc = 32 THEN c70_valor ELSE 0 END) AS vlranunliq,
             sum(CASE WHEN c53_tipo = 20 THEN c70_valor ELSE (CASE WHEN c53_tipo = 21 THEN c70_valor*-1 ELSE 0 END) END) AS vlrliq,
             sum(CASE WHEN c53_tipo = 30 THEN c70_valor ELSE (CASE WHEN c53_tipo = 31 THEN c70_valor*-1 ELSE 0 END) END) AS vlrpag,
             sum(CASE WHEN c71_coddoc = 37 THEN c70_valor ELSE (CASE WHEN c71_coddoc = 38 THEN c70_valor*-1 ELSE 0 END) END) AS vlrpagliq
      FROM conlancamemp
      INNER JOIN conlancamdoc ON c71_codlan = c75_codlan
      INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
      INNER JOIN conlancam ON c70_codlan = c75_codlan
      INNER JOIN empempenho ON e60_numemp = c75_numemp
      WHERE e60_anousu < ".db_getsession("DB_anousu")."
        AND c75_data BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
        AND e60_instit IN (".db_getsession("DB_instit").")
      GROUP BY c75_numemp) AS x ON x.c75_numemp = e91_numemp
   WHERE e91_anousu = ".db_getsession("DB_anousu").") AS x
INNER JOIN empempenho ON e60_numemp = e91_numemp
INNER JOIN orcdotacao ON o58_coddot = e60_coddot
AND o58_anousu=e60_anousu
AND o58_instit =e60_instit
INNER JOIN orcelemento ON o58_codele = o56_codele
AND o58_anousu=o56_anousu
INNER JOIN orcorgao ON o40_orgao = o58_orgao
AND o40_anousu = o58_anousu 
INNER JOIN orcunidade ON o41_anousu=o58_anousu
AND o41_orgao=o58_orgao
AND o41_unidade=o58_unidade
INNER JOIN orcsubfuncao ON o53_subfuncao = orcdotacao.o58_subfuncao
INNER JOIN cgm ON z01_numcgm = e60_numcgm
WHERE e60_instit IN (".db_getsession("DB_instit").")";
    
    	
			 $rsRestos = db_query($sSql);//echo $sSql;db_criatabela($rsRestos);
			 
			    /**
     		 * percorrer registros de detalhamento anulação retornados do sql acima
     		 */
			 
			 for ($iCont = 0;$iCont < pg_num_rows($rsRestos); $iCont++) {
			 
		 	   $oRestos  = db_utils::fieldsMemory($rsRestos,$iCont);
    			
		 	   $data_nova = explode("-",$this->sDataInicial);
		 	   
    		   if ($data_nova[1] == '01') {
		 	   
				     $oDadosRestos = new stdClass();
				 	   
		    		 $oDadosRestos->tipoRegistro            = 10; 
		    		 $oDadosRestos->detalhesessao 			   	= 10;
		    		 $oDadosRestos->codReduzido							= str_pad($oRestos->e60_numemp, 2, "0", STR_PAD_LEFT);
		    		 $oDadosRestos->codOrgao							  = $sOrgao;
		         $oDadosRestos->dotOrig                 = str_pad($oRestos->o58_orgao, 2, "0", STR_PAD_LEFT);
		         $oDadosRestos->dotOrig								 .=	str_pad($oRestos->o58_unidade, 3, "0", STR_PAD_LEFT);
		         $oDadosRestos->dotOrig								 .=	str_pad($oRestos->o58_funcao, 2, "0", STR_PAD_LEFT);  
		         $oDadosRestos->dotOrig								 .=	str_pad($oRestos->o58_subfuncao, 3, "0", STR_PAD_LEFT);  
		         $oDadosRestos->dotOrig								 .= str_pad($oRestos->o58_programa, 4, "0", STR_PAD_LEFT);  
	           $oDadosRestos->dotOrig								 .= str_pad($oRestos->o58_projativ, 4, "0", STR_PAD_LEFT);  
		         $oDadosRestos->dotOrig								 .=	substr($oRestos->o56_elemento, 1, 8);
		    		 $oDadosRestos->nroEmpenho						 	= substr($oRestos->e60_codemp, 0, 22);
		    		 $oDadosRestos->dtEmpenho						 	  = implode(array_reverse(explode("-", $oRestos->e60_emiss)));
		    		 
		    		 if (strlen($oRestos->z01_cgccpf) == '11') {
		    		   $oDadosRestos->tipoDocumentoCredor		=  1;
		    		 } else {
		    		   $oDadosRestos->tipoDocumentoCredor		=  2;
		    		 }
		    		 $oDadosRestos->nroDocumentoCredor			=  substr( $oRestos->z01_cgccpf, 0, 14);
		    		 $oDadosRestos->nomeCredor						 	=  substr($oRestos->z01_nome, 0, 120);
		    		 $oDadosRestos->vlOriginal						 	=  number_format(($oRestos->e91_vlremp - $oRestos->e91_vlranu), 2, "", "");
		    		 $oDadosRestos->vlSaldoAntProce					=  number_format($oRestos->e91_vlrliq - $oRestos->e91_vlrpag  , 2, "", "");
		    		 $oDadosRestos->vlSaldoAntNaoProc				=  number_format(abs(($oRestos->e91_vlremp - $oRestos->e91_vlranu - $oRestos->e91_vlrliq)), 2, "", "");
		         
		    		 
		    		 $this->aDados[] = $oDadosRestos;
		    		   
	    		   $oDadosRestos2 = new stdClass();
				 	   
		    		 $oDadosRestos2->tipoRegistro              =  11; 
		    		 $oDadosRestos2->detalhesessao 			   		 =  11;
		    		 $oDadosRestos2->codReduzido 			   		   =  substr( $oRestos->e60_numemp, 0, 15);
		    		 $oDadosRestos2->codFontRecursos					 =  str_pad($oRestos->o15_codtri, 3, "0", STR_PAD_LEFT); 
		    		 $oDadosRestos2->vlOriginalFonte					 =  number_format(($oRestos->e91_vlremp - $oRestos->e91_vlranu), 2, "", "");
		         $oDadosRestos2->vlSaldoAntProceFonte      =  number_format($oRestos->e91_vlrliq - $oRestos->e91_vlrpag, 2, "", "");
		         $oDadosRestos2->vlSaldoAntNaoProcFonte		 =	number_format(abs(($oRestos->e91_vlremp - $oRestos->e91_vlranu - $oRestos->e91_vlrliq)), 2, "", "");
		             		   
		         $this->aDados[] = $oDadosRestos2;
	             
    		   }   
			 }
  
    }
		
  }