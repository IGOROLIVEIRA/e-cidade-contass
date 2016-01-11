<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_regadesao102016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarREGADESAO.model.php");

 /**
  * Adesão a Registro de Preços Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoAdesaoRegistroPrecos extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 160;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REGADESAO';
  
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
   *metodo implementado criando um array dos campos para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroProcAdesao",
                          "dtAbertura",
                          "nomeOrgaoGerenciador",
    					            "exercicioLicitacao",
    					            "nroProcessoLicitatorio",
											    "codModalidadeLicitacao",
											    "nroModalidade",
											    "dtAtaRegPreco",
											    "dtValidade",
											    "naturezaProcedimento",
											    "dtPublicacaoAvisoIntencao",
											    "objetoAdesao",
											    "cpfResponsavel",
											    "nomeResponsavel",
											    "logradouro",
											    "bairroLogra",
											    "codCidadeLogra",
											    "ufCidadeLogra",
											    "cepLogra",
											    "telefone",
											    "email",
											    "descontoTabela",
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroProcAdesao",
                          "dtAbertura",
                          "nroLote",
    					            "nroItem",
    					            "dtCotacao",
											    "dscItem",
											    "vlCotPrecosUnitario",
											    "quantidade",
											    "unidade"
                        );
    $aElementos[12] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroProcAdesao",
                          "dtAbertura",
                          "nroLote",
    					            "nroItem",
											    "dscItem",
											    "precoUnitario",
											    "quantidadeLicitada",
											    "quantidadeAderida",
											    "unidade",
											    "nomeVencedor",
											    "tipoDocumento",
											    "nroDocumento"
                        );
    $aElementos[20] = array(
                          "tipoRegistro",
                          "codOrgao",
                          "codUnidadeSub",
                          "nroProcAdesao",
                          "dtAbertura",
                          "nroLote",
    					            "dscLote",
											    "percDesconto",
											    "nomeVencedor",
											    "tipoDocumento",
											    "nroDocumento"
                        );
    return $aElementos;
  }
  
  /**
   * selecionar os dados da adesão a registro de preço do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
  	$oGerarREGADESAO = new GerarREGADESAO();
	  $oGerarREGADESAO->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
	  $oGerarREGADESAO->gerarDados();
  
  }
		
 }
