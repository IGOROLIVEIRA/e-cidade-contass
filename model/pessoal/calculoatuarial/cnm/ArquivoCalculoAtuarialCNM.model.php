<?php
/**
 * Classe que monta um Arquivo de Cálculo Atuarial
 * 
 * @package Calculo Atuarial
 * @author  Rafael Nery <rafael.nery@dbseller.com.br> 
 * @author  Renan Melo  <renan@dbseller.com.br> 
 */
class ArquivoCalculoAtuarialCNM {

  const ATIVOS                      = 0;
  const PENSIONISTAS                = 1;
  const INATIVOS_TEMPO_CONTRIBUICAO = 2;
  const INATIVOS_IDADE              = 3;
  const INATIVOS_INVALIDEZ          = 4;
  const INATIVOS_COMPULSORIA        = 5;

  /**
   * Registros a serem processados.
   * 
   * @var array
   * @access public
   */
  public $aRegistros = array(); 

  /**
   * Tipo de Arquivo que pode ser gerado, definido pelas constantes
   * 
   * @var integer
   * @access public
   */
  public $iTipoArquivo;  

  /**
   * Valida se foram adicionados registros no arquivo
   * @var boolean
   */
  private $lAdicionouRegistros = false;
  
  /**
   * Arquivo que será arquivo
   * @var pointer
   */
  private $pArquivo;
  
  /**
   * Caminho do Arquivo
   * @var string
   */
  private $sCaminho;
  
  /**
   * Construtor da Classe
   *
   * @param mixed $iTipo
   * @access public
   * @return void
   */
  public function __construct( $iTipo ) {

    switch ( $iTipo ) {

      case ArquivoCalculoAtuarialCNM::ATIVOS:
        $this->sNomeclatura = "ATIVOS";  
      break;

      case ArquivoCalculoAtuarialCNM::INATIVOS_INVALIDEZ:
        $this->sNomeclatura = "INATIVOS_INVALIDEZ";  
      break;

      case ArquivoCalculoAtuarialCNM::INATIVOS_TEMPO_CONTRIBUICAO:
        $this->sNomeclatura = "INATIVOS_TEMPO_CONTRIBUICAO";  
      break;

      case ArquivoCalculoAtuarialCNM::INATIVOS_IDADE:
        $this->sNomeclatura = "INATIVOS_IDADE";  
      break;

      case ArquivoCalculoAtuarialCNM::INATIVOS_COMPULSORIA:
        $this->sNomeclatura = "INATIVOS_COMPULSORIA";  
      break;

      case ArquivoCalculoAtuarialCNM::PENSIONISTAS:
        $this->sNomeclatura = "PENSIONISTAS";  
      break;

      default:
        throw new ParameterException("Arquivo de Cálculo Atuarial Inválido.");
      break;
    }

    $this->iTipoArquivo = $iTipo;
    $this->sCaminho = "tmp/_" . date("Ymdis"). rand() ."calculoAtuarialCNM_" . $this->sNomeclatura . ".csv";
    $this->pArquivo = fopen($this->sCaminho,'w');
  }


  /**
   * Adiciona registro ao Arquivo
   *
   * @param InformacaoCalculoAtuarial $oRegistro
   * @access public
   * @return void
   */
  public function lancarRegistro ( InformacaoCalculoAtuarial $oRegistro ) {
   
    switch ( $this->iTipoArquivo ) {

      case ArquivoCalculoAtuarialCNM::ATIVOS:

        if ( !( $oRegistro instanceOf InformacaoCalculoAtuarialAtivos ) ) {
          throw new ParameterException(" Os Registros Passados Devem ser de Servidores Ativos");
        }
      break;

      case ArquivoCalculoAtuarialCNM::INATIVOS_INVALIDEZ:
      case ArquivoCalculoAtuarialCNM::INATIVOS_TEMPO_CONTRIBUICAO:
      case ArquivoCalculoAtuarialCNM::INATIVOS_IDADE:
      case ArquivoCalculoAtuarialCNM::INATIVOS_COMPULSORIA:

        if ( !( $oRegistro instanceOf InformacaoCalculoAtuarialInativos ) ) {
          throw new ParameterException(" Os Registros Passados Devem ser de Servidores Inativos");
        }
      break;

      case ArquivoCalculoAtuarialCNM::PENSIONISTAS:

        if ( !( $oRegistro instanceOf InformacaoCalculoAtuarialPensionistas ) ) {
          throw new ParameterException(" Os Registros Passados Devem ser de Pensionista. ");
        }
      break;

    }
    
    $aLinha = array();
    foreach ($oRegistro->toArray() as $sConteudoColuna) {
    	
    	$aLinha[] = $sConteudoColuna != '' ? $sConteudoColuna : '0'; 
    	
    }
    
    if ( !fputcsv($this->pArquivo, $aLinha, ',', '"' ) ) {
    	throw new Exception("Erro Ao gravar o Registro no Arquivo");
    }
    $this->lAdicionouRegistros = true;
    return;
  }

  /**
   * Processa o Arquivo e Retorna o caminho do arquivo gerador
   *
   * @access public
   * @return string
   */
  public function processar() {

  	if ( !$this->lAdicionouRegistros ) {
  		return null;	
  	}
  	
   //foreach ( $this->aRegistros as $oRegistroServidor ) {
   //
   //  if ( !fputcsv($pArquivo, $oRegistroServidor->toArray(), ',', '"' ) ) {
   //    throw new Exception("Erro Ao gravar o Registro no Arquivo");
   //  }
   //}
    
    fclose($this->pArquivo);
    return $this->sCaminho;
  }


}
