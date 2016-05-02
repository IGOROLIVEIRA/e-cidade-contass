<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_orgao102014_classe.php");
require_once ("classes/db_orgao112014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarORGAO.model.php");

 /**
  * selecionar dados de Orgao Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoAmOrgao extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
  /**
   * 
   * Codigo do layout
   * @var Integer
   */
  protected $iCodigoLayout = 148;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var unknown_type
   */
  protected $sNomeArquivo = 'ORGAO';
  
  /**
   * 
   * Contrutor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   *@return Array 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "descOrgao",
                          "tipoOrgao",
                          "cnpjOrgao",
                          "lograOrgao",
                          "bairroLograOrgao",
                          "cepLograOrgao",
                          "telefoneOrgao",
                          "emailOrgao"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "tipoResponsavel",
                          "nome",
                          "cartIdent",
    											"orgEmissorCi",
    											"cpf",
    											"crcContador",
    											"ufCrcContador",
    											"cargoOrdDespDeleg",
    											"dtInicio",
    											"dtFinal",
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
   * selecionar os dados do Orgao referente a instituicao logada
   * 
   */
  public function gerarDados() {
    
  	$clorgao102014 = new cl_orgao102014();
  	$clorgao112014 = new cl_orgao112014();
		
    db_inicio_transacao();
    /**
     * excluir informacoes do mes selecionado
     */
  $result = $clorgao112014->sql_record($clorgao112014->sql_query(NULL,"*",NULL,"si15_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si15_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clorgao112014->excluir(NULL,"si15_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si15_instit = ".db_getsession("DB_instit"));
      if ($clorgao112014->erro_status == 0) {
    	  throw new Exception($clorgao112014->erro_msg);
      }
    }
    
    $result = $clorgao102014->sql_record($clorgao102014->sql_query(NULL,"*",NULL,"si14_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si14_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clorgao102014->excluir(NULL,"si14_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si14_instit = ".db_getsession("DB_instit"));
      if ($clorgao102014->erro_status == 0) {
    	  throw new Exception($clorgao102014->erro_msg);
      }
    }
    
    /**
     * selecionar informacoes
     */
    $sSql = "SELECT db21_codigomunicipoestado AS codmunicipio, 
          cgc as cnpjmunicipio, 
          si09_tipoinstit as tipoorgao,
          si09_codorgaotce as codorgao, 
          prefeitura 
FROM db_config 
left join infocomplementaresinstit on si09_instit = codigo 
  WHERE codigo = ".db_getsession("DB_instit");
    
    $rsResult10 = db_query($sSql);
    
    /**
     * tirar caracteres de campo
     */
    $aCaracteres = array(".","-");
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
    	
    	$clorgao102014 = new cl_orgao102014();
    	$oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
    	
    	$clorgao102014->si14_tiporegistro = 10;
    	$clorgao102014->si14_codorgao     = $oDados10->codorgao;
    	$clorgao102014->si14_tipoorgao    = $oDados10->tipoorgao;
    	$clorgao102014->si14_cnpjorgao    = $oDados10->cnpjmunicipio;
    	$clorgao102014->si14_mes          = $this->sDataFinal['5'].$this->sDataFinal['6'];
    	$clorgao102014->si14_instit       = db_getsession("DB_instit"); 
    	
        $clorgao102014->incluir(null);
		if ($clorgao102014->erro_status == 0) {
		  	throw new Exception($clorgao102014->erro_msg);
		}
    	
    	$sSql = "select * from identificacaoresponsaveis join cgm on si166_numcgm = z01_numcgm where si166_instit = ".db_getsession("DB_instit") ." and si166_tiporesponsavel not in (1,2,3,4) ";
    	$rsResult11 = db_query($sSql);
    	
    	for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {
    		
    		$clorgao112014 = new cl_orgao112014();
    		$oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);
    		//if (strlen($oDados11->z01_cgccpf) > 11)
    		//echo $oDados11->z01_numcgm." | ".$oDados11->z01_cgccpf."<br>";
    		$clorgao112014->si15_tiporegistro      = 11;//echo $clorgao112014->si15_tiporegistro; 
    		$clorgao112014->si15_tiporesponsavel   = $oDados11->si166_tiporesponsavel;
    		$clorgao112014->si15_cartident         = str_replace($aCaracteres, "", $oDados11->z01_ident);
    		$clorgao112014->si15_orgemissorci      = str_replace($aCaracteres, "", $oDados11->z01_identorgao);
    		$clorgao112014->si15_cpf               = $oDados11->z01_cgccpf;
    		$clorgao112014->si15_crccontador       = $oDados11->si166_crccontador;
    		$clorgao112014->si15_ufcrccontador     = $oDados11->si166_ufcrccontador;
    		$clorgao112014->si15_cargoorddespdeleg = $oDados11->si166_cargoorddespesa;
    		$clorgao112014->si15_dtinicio          = $this->sDataInicial;
    		$clorgao112014->si15_dtfinal           = $this->sDataFinal;
    		$clorgao112014->si15_email             = $oDados11->z01_email;
    		$clorgao112014->si15_reg10             = $clorgao102014->si14_sequencial;
    		$clorgao112014->si15_mes               = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		$clorgao112014->si15_instit            = db_getsession("DB_instit");
    		
    	  $clorgao112014->incluir(null);
		    if ($clorgao112014->erro_status == 0) {
		  	  throw new Exception($clorgao112014->erro_msg);
		    }
    		
    	}
    	
    }
    
    db_fim_transacao();
    
    $oGerarOrgao = new GerarORGAO();
    $oGerarOrgao->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarOrgao->gerarDados();
    
  }
}
