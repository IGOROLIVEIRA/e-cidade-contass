<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

 /**
  * Parecer da Licitação Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoParecerLicitacao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 159;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'PARELIC';
  
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
    
    $aElementos = array(
                        "codOrgao",
                        "codUnidadeSub",
                        "exercicioLicitacao",
                        "nroProcessoLicitatorio",
                        "dataParecer",
				    					  "tipoParecer",
				    					  "nroCpf",
				    					  "nomRespParecer",
				    					  "logradouro",
				    					  "bairroLogra",
				    					  "codCidadeLogra",
				    					  "ufCidadeLogra",
				    					  "cepLogra",
				    					  "telefone",
				    					  "email"					  
                        );			
    return $aElementos;
  }
  
  /**
   * Parecer da Licitação do mes para gerar o arquivo
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
  	 * selecionar arquivo xml com dados do Parecer
  	 */
	  $sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomparecerlicitacao.xml";  
   
    if (!file_exists($sArquivo)) {
      throw new Exception("Arquivo de configuração do parecer do sicom inexistente!");
    }
    
    
    $sTextoXml    = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oPareceres     = $oDOMDocument->getElementsByTagName('parecerlicitacao');
    
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
	    
		/**
		 * selecionar arquivo xml de Homologacao
		 */
		$sArquivo = "config/sicom/".db_getsession("DB_anousu")."/{$sCnpj}_sicomhomologalict.xml";
		if (!file_exists($sArquivo)) {
			throw new Exception("Arquivo de Homologação inexistente!");
		}
		$sTextoXml    = file_get_contents($sArquivo);
		$oDOMDocument = new DOMDocument();
		$oDOMDocument->loadXML($sTextoXml);
		$oHomologacoes = $oDOMDocument->getElementsByTagName('homologalict');
		$aLicitacao = array();
		foreach ($oHomologacoes as $oHomologacao) {
			
			$dDtHomologacao = implode("-", array_reverse(explode("/",$oHomologacao->getAttribute('dtHomologacao'))));		
			if ($oHomologacao->getAttribute('instituicao') == db_getsession("DB_instit")
			&& $dDtHomologacao >= $this->sDataInicial
			&& $dDtHomologacao <= $this->sDataFinal) {
				
				$sSqlLicitacao = "select * from liclicita 
        inner join db_config on db_config.codigo = liclicita.l20_instit 
        inner join db_usuarios on db_usuarios.id_usuario = liclicita.l20_id_usucria 
        inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom 
        left join pctipocompratribunal on cflicita.l03_pctipocompratribunal = pctipocompratribunal.l44_sequencial 
        where l20_codigo = ".$oHomologacao->getAttribute('nroProcessoLicitatorio')." and l20_licsituacao in (1) 
        and l44_codigotribunal in ('1','2','3','4','5','6') and l44_sequencial < 100 and l20_instit = ".db_getsession("DB_instit");
				$rsLicitacao = db_query($sSqlLicitacao);
				if (pg_num_rows($rsLicitacao) > 0) {
				  $aLicitacao[] = $oHomologacao->getAttribute('nroProcessoLicitatorio');	
				}
				
			}
					
		}
	
	
    /**
     * percorrer os dados retornados do xml para selecionar os pareceres da inst logada
     * para selecionar os dados da instit
     */
    foreach ($oPareceres as $oParecer) {
        
      if ($oParecer->getAttribute('instituicao') == db_getsession("DB_instit")) {
    	
      	foreach ($oDadosComplLicitacoes as $oDadosComplLicitacao) {
			//echo $oParecer->getAttribute("nroProcessoLicitatorio")."<br>";
		  if ($oDadosComplLicitacao->getAttribute('instituicao') == db_getsession("DB_instit")
			 && $oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio') == $oParecer->getAttribute("nroProcessoLicitatorio")
			 && in_array($oDadosComplLicitacao->getAttribute('nroProcessoLicitatorio'), $aLicitacao)) {
        
	    	$oDadosParecer = new stdClass();
		  
		    $oDadosParecer->codOrgao               = $sOrgao;
		    $oDadosParecer->codUnidadeSub          = " ";
			  $oDadosParecer->exercicioLicitacao     = str_pad($oDadosComplLicitacao->getAttribute('ano'), 4, "0", STR_PAD_LEFT);
			  $oDadosParecer->nroProcessoLicitatorio = substr($oDadosComplLicitacao->getAttribute('codigoProcesso'), 0, 12);
			  $oDadosParecer->dataParecer            = implode(explode("/", $oParecer->getAttribute("dataParecer")));
		    $oDadosParecer->tipoParecer            = str_replace("0", "", $oParecer->getAttribute("tipoParecer"));
		    $oDadosParecer->dataParecer            = implode(explode("/", $oParecer->getAttribute("dataParecer")));
			  $oDadosParecer->nroCpf                 = str_pad($oParecer->getAttribute("nroCpf"), 4, "0", STR_PAD_LEFT);
			  $oDadosParecer->nomRespParecer         = utf8_decode(substr($oParecer->getAttribute("nomRespParecer"), 0, 50));
			  $oDadosParecer->logradouro             = utf8_decode(substr($oParecer->getAttribute("logradouro"), 0, 75));
			  $oDadosParecer->bairroLogra            = utf8_decode(substr($oParecer->getAttribute("bairroLogra"), 0, 50));
			  $oDadosParecer->codCidadeLogra         = str_pad($oParecer->getAttribute("codCidadeLogra"), 5, "0", STR_PAD_LEFT);
			  $oDadosParecer->ufCidadeLogra          = str_pad($oParecer->getAttribute("ufCidadeLogra"), 2, "0", STR_PAD_LEFT);
			  $oDadosParecer->cepLogra               = str_pad($oParecer->getAttribute("cepLogra"), 8, "0", STR_PAD_LEFT);
			  $oDadosParecer->telefone               = str_pad($oParecer->getAttribute("telefone"), 10, "0", STR_PAD_LEFT);
			  $oDadosParecer->email                  = substr($oParecer->getAttribute("email"), 0, 50);
		      
		    $this->aDados[] = $oDadosParecer;
		      
		  }
		
    } 
 	
   }
	      
  } 
    
 }
		
 }			