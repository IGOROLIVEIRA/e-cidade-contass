<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/licitacao.model.php");
require_once("model/Dotacao.model.php");
 /**
  * Homologação da Licitação Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoHomologacaoLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 158;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'HOMOLIC';
  
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
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
                          "tipoDocumento",
					    					  "nroDocumento",
					    					  "nroLote",
					    					  "nroItem",
    											"dscItem",
    											"Quantidade",
					    					  "vlHomologacao"					  
                        );
    $aElementos[20] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
    											"tipoDocumento",
    											"nroDocumento",
    											"nroLote",
					    					  "nroItem",
					    					  "percDesconto"
    										);
    $aElementos[30] = array(
    					            "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "exercicioLicitacao",
                          "nroProcessoLicitatorio",
					    					  "dtHomologacao",
					    					  "dtAdjudicacao"
    										);
    					
   
    					
    return $aElementos;
  }
  
  /**
   * Homologação da Licitação do mes para gerar o arquivo
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
    
   
    /**
  	 * selecionar arquivo xml com homologação
  	 */
    $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhomologalict.xml";
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração das homologações do sicom inexistente!");
    }
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oHomologacoes    = $oDOMDocument->getElementsByTagName('homologalict');
    $aLicitacao = array();
		foreach ($oHomologacoes as $oHomologacao) {

			$dDtHomologacao = implode("-", array_reverse(explode("/",$oHomologacao->getAttribute('dtHomologacao'))));
			if ($oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")
			    && $dDtHomologacao >= $this->sDataInicial
			    && $dDtHomologacao <= $this->sDataFinal){
				$aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');
			}
				
		}
		$sLicitacao = implode(",", $aLicitacao);
		
    /**
	   * selecionar arquivo xml de Dados Compl Licitação
	   */
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomdadoscompllicitacao.xml";
	  if (!file_exists($sArquivo)) {
		  throw new Exception("Arquivo de dados compl licitacao inexistente!");
	  }
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oDadosComplLicitacoes = $oDOMDocument->getElementsByTagName('dadoscompllicitacao');
    
    $sSql    = "select l20_codigo,l20_anousu, l20_numero from liclicita 
			 	inner join db_config on db_config.codigo = liclicita.l20_instit
				inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria
				inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom
				left  join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial
				inner join liclocal on liclocal.l26_codigo = liclicita.l20_liclocal
				inner join liccomissao on liccomissao.l30_codigo = liclicita.l20_liccomissao
				inner join licsituacao on licsituacao.l08_sequencial = liclicita.l20_licsituacao
				inner join cgm on cgm.z01_numcgm = db_config.numcgm 
				inner join db_config as dbconfig on dbconfig.codigo = cflicita.l03_instit
				inner join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom
				inner join bairro on bairro.j13_codi = liclocal.l26_bairro
				inner join ruas on ruas.j14_codigo = liclocal.l26_lograd
				left join liclicitaproc on liclicitaproc.l34_liclicita = liclicita.l20_codigo
				left join protprocesso on protprocesso.p58_codproc = liclicitaproc.l34_protprocesso 
				where l20_codigo in (".$sLicitacao.") 
				and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 
				and l20_licsituacao in (1) 
				and l20_instit = 1 
				order by l20_codtipocom,l20_numero ";
    
	   $rsHomologa = db_query($sSql);
	
	  /**
     * percorrer registros de licitacoes retornados do sql acima
     */
	  $aDadosAgrupados = array();
    for ($iCont = 0;$iCont < pg_num_rows($rsHomologa); $iCont++) {
      
      $oHomologa = db_utils::fieldsMemory($rsHomologa,$iCont);
      
      
     $sSql2 = "select z01_nome,z01_cgccpf ,pc01_descrmater,pc01_codmater,pc11_quant,pc23_valor
	from pcorcamjulg 
		inner join pcorcamforne on pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne 
		inner join pcorcamitem on pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem 
		inner join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm 
		inner join pcorcam on pcorcam.pc20_codorc = pcorcamforne.pc21_codorc 
		inner join pcorcam a on a.pc20_codorc = pcorcamitem.pc22_codorc 
		inner join pcorcamitemlic on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem 
		inner join liclicitem on liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem 
		inner join pcprocitem on pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem 
		inner join pcproc on pcproc.pc80_codproc=pcprocitem.pc81_codproc
		inner join liclicita on liclicita.l20_codigo = liclicitem.l21_codliclicita 
		inner join pcdotac on pc13_codigo=pcprocitem.pc81_solicitem 
		left join pcdotaccontrapartida on pc13_sequencial=pc19_pcdotac 
		inner join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamjulg.pc24_orcamforne 
			and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem 
		inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem 
		inner join solicita on solicita.pc10_numero = solicitem.pc11_numero 
		inner join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo 
		inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
		inner join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo 
		left join solicitemunid on solicitemunid.pc17_codigo = solicitem.pc11_codigo 
		left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid 
		left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
		left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
		left join orcelemento on pc18_codele = o56_codele and o56_anousu = ".db_getsession("DB_anousu")." 
	where  pc24_pontuacao=1 and pc10_instit=". db_getsession("DB_instit") ." and l20_codigo= ".$oHomologa->l20_codigo;
       
       $rsDetalhaDataHomo = db_query($sSql2);
       
       foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			
			   if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
					   && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oHomologa->l20_codigo) {
			     
			     foreach ($oHomologacoes as $oHomologacao) {
			    	
			       if ( $oHomologacao->getAttribute("nroProcessoLicitatorio") ==  $oHomologa->l20_codigo 
			            && $oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")) {	
			       
			         for ($iCont2 = 0; $iCont2 < pg_num_rows($rsDetalhaDataHomo); $iCont2++) {
			        
			       	   $oDetalhaDataHomo = db_utils::fieldsMemory($rsDetalhaDataHomo,$iCont2);
			       	 
			           if (strlen($oDetalhaDataHomo->z01_cgccpf) == 11 ) {
			     	       $iTipoDocumento = 1;	
			     	     } else {
			     	       $iTipoDocumento = 2;
			     	     }
					 
			     	     $sHash  = $sOrgao.$oDadosComplLicitacao->getAttribute('ano').$oDadosComplLicitacao->getAttribute('codigoProcesso');
			     	     $sHash .= $iTipoDocumento.$oDetalhaDataHomo->z01_cgccpf.$oDetalhaDataHomo->pc01_codmater;
			     	     
			     	     if (!isset($aDadosAgrupados[$sHash])) {
			      	   
			     	       $oDadosHomologacao    =  new  stdClass();
						
				      	   $oDadosHomologacao->tipoRegistro    		    = 10;
				      	   $oDadosHomologacao->detalhesessao 		      = 10;
				      	   $oDadosHomologacao->codOrgao				        = $sOrgao;
				      	   $oDadosHomologacao->codUnidade 				    = " ";
				      	   $oDadosHomologacao->exercicioLicitacao		  = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
				      	   $oDadosHomologacao->nroProcessoLicitatorio = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
				      	   $oDadosHomologacao->tipoDocumento			    = $iTipoDocumento;
				      	   $oDadosHomologacao->nroDocumento			      = substr($oDetalhaDataHomo->z01_cgccpf, 0, 14);
				      	   $oDadosHomologacao->nroLote					      = " ";
				      	   $oDadosHomologacao->nroItem					      = substr($oDetalhaDataHomo->pc01_codmater, 0, 4);
				      	   $oDadosHomologacao->dscItem					      = substr($oDetalhaDataHomo->pc01_descrmater,0, 250);
				      	   $oDadosHomologacao->Quantidade				      = number_format($oDetalhaDataHomo->pc11_quant,4,"","");
				      	   $oDadosHomologacao->vlHomologacao				  = 0;
				      	   $oDadosHomologacao->Reg11                  = array();
				    	
				      	   $aDadosAgrupados[$sHash] = $oDadosHomologacao;
			      	   
			     	     } else {
			     	       $oDadosHomologacao = $aDadosAgrupados[$sHash];
			     	     }
			     	     
			     	     $oDadosHomologacao->vlHomologacao += $oDetalhaDataHomo->pc23_valor;
			     	     
			        }
			       
			
			        
			      	   $oDadosDetalhaDataHomo = new stdClass();
			        
			           $oDadosDetalhaDataHomo->tipoRegistro         	=  30;
			           $oDadosDetalhaDataHomo->detalhesessao  		 	  =  30;
			           $oDadosDetalhaDataHomo->codOrgao			 	        =  $sOrgao;
			           $oDadosDetalhaDataHomo->codUnidadeSub	 	      =  " ";
			           $oDadosDetalhaDataHomo->exercicioLicitacao	 	  =  $oDadosHomologacao->exercicioLicitacao;
			           $oDadosDetalhaDataHomo->nroProcessoLicitatorio =  $oDadosHomologacao->nroProcessoLicitatorio;
			           $oDadosDetalhaDataHomo->dtHomologacao  		 	  =  implode(explode("/", $oHomologacao->getAttribute('dtHomologacao')));
			           $oDadosDetalhaDataHomo->dtAdjudicacao  		 	  =  implode(explode("/", $oHomologacao->getAttribute('dtAdjudicacao')));
			             
			           $oDadosHomologacao->Reg11[] = $oDadosDetalhaDataHomo;
			            
			         }
			            
			       }
			         
			     }
          	 
      }
      $aDadosAgrupados[$sHash] = $oDadosHomologacao;
      
    }
    /**
     * passar valores registro 10 para array de dados
     */
    foreach ($aDadosAgrupados as $oDados) {
    	
    	$oDado = clone $oDados;
    	unset($oDado->Reg11);
    	$oDado->vlHomologacao = number_format($oDado->vlHomologacao, 4, "", "");
    	$this->aDados[] = $oDado;
    	/**
    	 * passar valores registro 11 para array de dados
    	 */
    	foreach ($oDados->Reg11 as $oReg11) {
    		$this->aDados[] = $oReg11;
    	}
    	
    }
    
   }
		
  }			