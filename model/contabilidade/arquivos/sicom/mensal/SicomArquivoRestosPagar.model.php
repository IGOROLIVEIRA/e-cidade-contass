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

    $sSql  = "select          e60_anousu,
		o58_orgao, 
		o58_unidade, 
		o58_funcao, 
		o58_subfuncao, 
		o58_programa, 
		o58_projativ,
		o56_elemento,
		o15_codtri,
		e60_numemp,
                e60_codemp,
                e60_emiss,
                z01_numcgm,
                z01_nome,
                z01_cgccpf,
                o58_codigo,
                sum(case when c71_coddoc = 1          then round(c70_valor,2) else 0 end) as e60_vlremp,
                sum(case when c71_coddoc in (2,31,32) then round(c70_valor,2) else 0 end) as e60_vlranu,
                sum(case when c71_coddoc in (3,23,33) then round(c70_valor,2)
                         when c71_coddoc in (4,24,34) then round(c70_valor,2) *-1     
                         else 0 end) as e60_vlrliq,
                sum(case when c71_coddoc in (5,35,37) then round(c70_valor,2)
                         when c71_coddoc in (6,36,38) then round(c70_valor,2) *-1
                         else 0 end) as e60_vlrpag
       from     empempenho
                inner join empresto     on e60_numemp = e91_numemp and e91_anousu = ".db_getsession("DB_anousu")." 
                inner join conlancamemp on e60_numemp = c75_numemp
                inner join conlancamcgm on c75_codlan = c76_codlan
                inner join cgm          on c76_numcgm = z01_numcgm
                inner join conlancamdoc on c75_codlan = c71_codlan
                inner join conlancam    on c75_codlan = c70_codlan
                inner join orcdotacao   on e60_coddot = o58_coddot
                                       and e60_anousu = o58_anousu
                inner join orcelemento  on o58_codele = o56_codele
                                       and o58_anousu = o56_anousu
                join orctiporec on o58_codigo = o15_codigo
       where    e60_anousu < ".db_getsession("DB_anousu")." 
            and c70_data <= '".(db_getsession("DB_anousu")-1)."-12-31' 
     group by   e60_anousu,
                e60_codemp,
                e60_emiss,
                z01_numcgm,
                z01_cgccpf,
                z01_nome,
                e60_numemp,
                o58_codigo,
                o58_orgao, 
                o58_unidade, 
                o58_funcao, 
                o58_subfuncao, 
                o58_programa, 
                o58_projativ,
                o56_elemento,
                o15_codtri";
    	
			 $rsRestos = db_query($sSql);
			 
			 
			    /**
     		 * percorrer registros de detalhamento anulação retornados do sql acima
     		 */
			 
			 for ($iCont = 0;$iCont < pg_num_rows($rsRestos); $iCont++) {
			 
		 	   $oRestos  = db_utils::fieldsMemory($rsRestos,$iCont);
    			
		 	   $data_nova = explode("-",$this->sDataInicial);
		 	   
    		   if (($data_nova[1] == '01') && ( (round( ($oRestos->e60_vlremp - $oRestos->e60_vlranu - $oRestos->e60_vlrliq) ,2))  > 0 
    		   			|| round(($oRestos->e60_vlrliq - $oRestos->e60_vlrpag),2)  > 0 ) ) {
		 	   		/*	
    		   		 echo $oRestos->e60_numemp." - ";		
    		   		 echo "$oRestos->e60_vlremp | $oRestos->e60_vlranu | $oRestos->e60_vlrliq"." | ";
    		   		 echo round(($oRestos->e60_vlremp - $oRestos->e60_vlranu - $oRestos->e60_vlrliq),2)." - ";
    		   		 echo round(($oRestos->e60_vlrliq - $oRestos->e60_vlrpag),2)."<br>";*/
				     $oDadosRestos = new stdClass();
				 	   
		    		 $oDadosRestos->tipoRegistro            = 10; 
		    		 $oDadosRestos->detalhesessao 			   	= 10;
		    		 $oDadosRestos->codReduzido							= str_pad($oRestos->e60_numemp, 2, "0", STR_PAD_LEFT);
		    		 $oDadosRestos->codOrgao							  = $sOrgao;//$oRestos->e60_anousu;//$sOrgao;
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
		    		 $oDadosRestos->nomeCredor					=  substr($oRestos->z01_nome, 0, 120);
		    		 $oDadosRestos->vlOriginal					=  number_format(($oRestos->e60_vlremp - $oRestos->e60_vlranu), 2, "", "");
		    		 $oDadosRestos->vlSaldoAntProce				=  number_format($oRestos->e60_vlrliq - $oRestos->e60_vlrpag  , 2, "", "");
		    		 $oDadosRestos->vlSaldoAntNaoProc			=  number_format(abs(($oRestos->e60_vlremp - $oRestos->e60_vlranu - $oRestos->e60_vlrliq)), 2, "", "");
		         
		    		 
		    		 $this->aDados[] = $oDadosRestos;
		    		   
	    		   $oDadosRestos2 = new stdClass();
				 	   
		    		 $oDadosRestos2->tipoRegistro                =  11; 
		    		 $oDadosRestos2->detalhesessao 			   	 =  11;
		    		 $oDadosRestos2->codReduzido 			   	 =  substr( $oRestos->e60_numemp, 0, 15);
		    		 $oDadosRestos2->codFontRecursos			 =  str_pad($oRestos->o15_codtri, 3, "0", STR_PAD_LEFT); 
		    		 $oDadosRestos2->vlOriginalFonte			 =  number_format(($oRestos->e60_vlremp - $oRestos->e60_vlranu), 2, "", "");
		             $oDadosRestos2->vlSaldoAntProceFonte        =  number_format($oRestos->e60_vlrliq - $oRestos->e60_vlrpag, 2, "", "");
		             $oDadosRestos2->vlSaldoAntNaoProcFonte		 =	number_format(abs(($oRestos->e60_vlremp - $oRestos->e60_vlranu - $oRestos->e60_vlrliq)), 2, "", "");
		             		   
		         $this->aDados[] = $oDadosRestos2;
	             
    		   }   
			 }
			 
			$sqlCancelRestos = "select 20 as tiporegistro,
									   c75_numemp as codreduzido, 
									   ' ' as codorgao,
									   lpad(o58_orgao,2,0)||
								           lpad(o58_unidade,3,0)|| 
									   lpad(o58_funcao,2,0)|| 
									   lpad(o58_subfuncao,3,0)|| 
									   lpad(o58_programa,4,0)||
									   lpad(o58_projativ,4,0)||
									   substr(o56_elemento,2,6)||'00' as dotorig,
									   e60_codemp as nroempenho,
									   e60_emiss as dtempenho,
								           (CASE length(z01_cgccpf) WHEN 11 THEN 1
										ELSE 2
									    END) as tipodocumentocredor,
									   z01_cgccpf as nrodocumentocredor,
									   z01_nome as nomecredor,
									   case when c71_coddoc = 31 then 1 else 2 end as tiporestospagar,
								           1 as tipomovimento,
									   c70_data as dtmovimentacao,
								           c70_valor as vlmovimentacao,
									   ' ' as vlsaldoanterior, 
									   ' ' as codorgaoencampatribuic,
									   ' ' as codunidadesub, 
									   c72_complem as justcancelamento,
									   c75_numemp as atocancelamento, 
									   c70_data as dataAtoCancelamento,o15_codtri as codfontrecursos 
								      from conlancamdoc 
								      join conlancamemp on c75_codlan = c71_codlan 
								      join conlancam on c70_codlan = c75_codlan
								inner join empempenho on c75_numemp = e60_numemp 
								inner join orcdotacao on e60_coddot = o58_coddot
								       and e60_anousu = o58_anousu
								inner join orcelemento on o58_codele = o56_codele
								       and o58_anousu = o56_anousu
								inner join orctiporec on o58_codigo = o15_codigo
								inner join cgm on e60_numcgm = z01_numcgm
								left  join conlancamcompl on c72_codlan = c70_codlan
								     where c71_coddoc in (31,32) 
								       and c75_data between '".$this->sDataInicial."' and '".$this->sDataFinal."' 
								       and e60_instit = ".db_getsession("DB_instit");
			
			$rsCancelRestos = db_query($sqlCancelRestos);
			//db_criatabela($rsCancelRestos);
			$aCaracteres = array("°",chr(13),chr(10),"'",";");
			
			for ($iContador = 0;$iContador < pg_num_rows($rsCancelRestos); $iContador++) {
			 
		 	    $oRestosAnulado  = db_utils::fieldsMemory($rsCancelRestos,$iContador);
		 	    
		 	    
		 	            
			$sqlSaldo="select  sum(case when c71_coddoc = 1          then round(c70_valor,2) else 0 end) as vlremp,
				                sum(case when c71_coddoc in (2,31,32) then round(c70_valor,2) else 0 end) as vlranu,
				                sum(case when c71_coddoc in (3,23,33) then round(c70_valor,2)
				                         when c71_coddoc in (4,24,34) then round(c70_valor,2) *-1     
				                         else 0 end) as vlrliq,
				                sum(case when c71_coddoc in (5,35,37) then round(c70_valor,2)
				                         when c71_coddoc in (6,36,38) then round(c70_valor,2) *-1
				                         else 0 end) as vlrpag
				          from  empempenho
				                inner join empresto     on e60_numemp = e91_numemp
				                inner join conlancamemp on e60_numemp = c75_numemp
				                inner join conlancamcgm on c75_codlan = c76_codlan
				                inner join cgm          on c76_numcgm = z01_numcgm
				                inner join conlancamdoc on c75_codlan = c71_codlan
				                inner join conlancam    on c75_codlan = c70_codlan
				                inner join orcdotacao   on e60_coddot = o58_coddot
				                                       and e60_anousu = o58_anousu
				                inner join orcelemento  on o58_codele = o56_codele
				                                       and o58_anousu = o56_anousu
				                join orctiporec on o58_codigo = o15_codigo
				       where    e60_anousu < ".db_getsession("DB_anousu")." 
				            and c70_data < '{$oRestosAnulado->dtmovimentacao}' 
					    and e60_numemp = {$oRestosAnulado->codreduzido}
				     group by   e60_anousu, e60_codemp, e60_emiss, z01_numcgm, z01_cgccpf, z01_nome, e60_numemp,
				                o58_codigo, o58_orgao, o58_unidade, o58_funcao, o58_subfuncao,  o58_programa, 
				                o58_projativ, o56_elemento, o15_codtri";
			
				$oRestosSaldo  = db_utils::fieldsMemory(db_query($sqlSaldo),0);
				
				
				if($oRestosSaldo->tiporestospagar == 1){
					$saldo = $oRestosSaldo->vlrliq - $oRestosSaldo->vlrpag; 
				}else{
					$saldo = $oRestosSaldo->vlremp - $oRestosSaldo->vlranu - $oRestosSaldo->vlrliq;
				}
				
				$oDadosRestosAnulacao20 = new stdClass();
				
				$oDadosRestosAnulacao20->tipoRegistro      			 = 20;
				$oDadosRestosAnulacao20->detalhesessao 			   	 = 20;
	            $oDadosRestosAnulacao20->codReduzido				 = $oRestosAnulado->codreduzido;
		        $oDadosRestosAnulacao20->codOrgao					 = $sOrgao;
		    	$oDadosRestosAnulacao20->dotOrig					 = $oRestosAnulado->dotorig;
		    	$oDadosRestosAnulacao20->nroEmpenho					 = $oRestosAnulado->nroempenho;
				$oDadosRestosAnulacao20->dtEmpenho					 = implode(array_reverse(explode("-", $oRestosAnulado->dtempenho)));
				$oDadosRestosAnulacao20->tipoDocumentoCredor		 = $oRestosAnulado->tipodocumentocredor;
				$oDadosRestosAnulacao20->nroDocumentoCredor			 = $oRestosAnulado->nrodocumentocredor;
				$oDadosRestosAnulacao20->nomeCredor					 = $oRestosAnulado->nomecredor;
				$oDadosRestosAnulacao20->tipoRestosPagar			 = $oRestosAnulado->tiporestospagar;
				$oDadosRestosAnulacao20->tipoMovimento				 = $oRestosAnulado->tipomovimento;
				$oDadosRestosAnulacao20->dtMovimentacao				 = implode(array_reverse(explode("-", $oRestosAnulado->dtmovimentacao)));
				$oDadosRestosAnulacao20->vlMovimentacao				 = number_format($oRestosAnulado->vlmovimentacao, 2, "", "");
				$oDadosRestosAnulacao20->vlSaldoAnterior			 = number_format($saldo, 2, "", "");
				$oDadosRestosAnulacao20->codOrgaoEncampAtribuic		 = $oRestosAnulado->codorgaoencampatribuic;
				$oDadosRestosAnulacao20->codUnidadeSub				 = $oRestosAnulado->codunidadesub;
	    		$oDadosRestosAnulacao20->justCancelamento			 = utf8_decode(substr(str_replace($aCaracteres, '', $oRestosAnulado->justcancelamento),0,200));
	    		
	    		$oDadosRestosAnulacao20->atoCancelamento			 = $oRestosAnulado->atocancelamento;
	    		$oDadosRestosAnulacao20->dataAtoCancelamento		 = implode(array_reverse(explode("-", $oRestosAnulado->dataatocancelamento)));
	    		
	    		$this->aDados[] = $oDadosRestosAnulacao20;
	    		
	    		$oDadosRestosAnulacao21 = new stdClass();
	    			    		
	    		$oDadosRestosAnulacao21->tipoRegistro			= 21;
	    		$oDadosRestosAnulacao21->detalhesessao 			= 21;
	    		$oDadosRestosAnulacao21->codReduzido			= $oRestosAnulado->codreduzido;
	            $oDadosRestosAnulacao21->codFontRecursos		= $oRestosAnulado->codfontrecursos;
	    		$oDadosRestosAnulacao21->vlMovimentacaoFonte	= number_format($oRestosAnulado->vlmovimentacao, 2, "", "");
	    	    $oDadosRestosAnulacao21->vlSaldoAnteriorFonte	= number_format($saldo, 2, "", "");
	    		
	    		$this->aDados[] = $oDadosRestosAnulacao21;
			}
			
			//echo "<pre>";print_r($this->aDados);exit;
			
			
			
  
    }
		
  }