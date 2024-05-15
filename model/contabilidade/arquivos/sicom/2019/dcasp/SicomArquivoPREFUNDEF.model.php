<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
//require_once("classes/db_prefundefdcasp2019_classe.php");
require_once("model/contabilidade/arquivos/sicom/2019/dcasp/geradores/GerarPREFUNDEF.model.php");

/**
 * gerar arquivo de prefundefntificacao da Remessa Sicom Acompanhamento Mensal
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoPREFUNDEF extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 147;

  protected $sNomeArquivo = 'PREFUNDEF';

    /**
     * @return mixed
     */
    public function getTipoGeracao()
    {
        return $this->sTipoGeracao;
    }

    /**
     * @param mixed $sTipoGeracao
     */
    public function setTipoGeracao($sTipoGeracao)
    {
        $this->sTipoGeracao = $sTipoGeracao;
    }

  /**
   * Retorna o codigo do layout
   * @return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  /**
   * Esse método na verdade nem é usado aqui, mas implementa o iPadArquivoBaseCSV
   */
  public function getCampos(){
    return array();
  }


  /**
   * Contrutor da classe
   */
  public function __construct() { }

  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {
    $iAnousu    = db_getsession("DB_anousu");
    $iCodInstit = db_getsession("DB_instit");

    $oGerarPrefundef = new GerarPREFUNDEF();
    $oGerarPrefundef->iAnousu     = $iAnousu;
    $oGerarPrefundef->iCodInstit  = $iCodInstit;
    $oGerarPrefundef->gerarDados($this->getTipoGeracao());

  }

}
