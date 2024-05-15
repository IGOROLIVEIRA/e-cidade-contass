<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_idedcasp2020_classe.php");
require_once("model/contabilidade/arquivos/sicom/2020/dcasp/geradores/GerarIDE.model.php");

/**
 * gerar arquivo de identificacao da Remessa Sicom Acompanhamento Mensal
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoIDE extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  protected $iCodigoLayout = 147;

  protected $sNomeArquivo = 'IDE';

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

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clidedcasp = new cl_idedcasp2020();

    /**
     * inserir informacoes no banco de dados
     */
    db_inicio_transacao();

    $sWhere = "si200_anousu = {$iAnousu} and si200_instit = {$iCodInstit}";
    $sSql = $clidedcasp->sql_query(NULL, '*', NULL, $sWhere);
    $result = $clidedcasp->sql_record($sSql);

    if (!!$result && pg_num_rows($result) > 0) {

      $clidedcasp->excluir(null, $sWhere);
      if ($clidedcasp->erro_status == 0) {
        throw new Exception($clidedcasp->erro_msg);
      }

    }


    $sSql  = "SELECT db21_codigomunicipoestado AS codmunicipio,
                case when si09_tipoinstit::varchar = '2' then cgc::varchar else si09_cnpjprefeitura::varchar end AS cnpjmunicipio,
                si09_tipoinstit AS tipoorgao,
                si09_codorgaotce AS codorgao, cgc AS cnpjorgao,
                prefeitura
              FROM db_config
              LEFT JOIN infocomplementaresinstit ON si09_instit = ".db_getsession("DB_instit")."
              WHERE codigo = ".db_getsession("DB_instit");

    $rsResult = db_query($sSql);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

      $clidedcasp = new cl_idedcasp2020();
      $oDadosIde = db_utils::fieldsMemory($rsResult, $iCont);

      $clidedcasp->si200_anousu              = $iAnousu;
      $clidedcasp->si200_instit              = $iCodInstit;
      $clidedcasp->si200_codmunicipio        = $oDadosIde->codmunicipio;
      $clidedcasp->si200_cnpjorgao           = $oDadosIde->cnpjorgao;
      $clidedcasp->si200_codorgao            = $oDadosIde->codorgao;
      $clidedcasp->si200_tipoorgao           = $oDadosIde->tipoorgao;
			if ($this->getTipoGeracao() == 'CONSOLIDADO') {
					$clidedcasp->si200_tipodemcontabil = 2;
			}else{
					$clidedcasp->si200_tipodemcontabil = 1;
			}
      $clidedcasp->si200_exercicioreferencia = db_getsession("DB_anousu");
      $clidedcasp->si200_datageracao         = date("d-m-Y");
      $clidedcasp->si200_codcontroleremessa  = ' ';


      $clidedcasp->incluir(null);
      if ($clidedcasp->erro_status == 0) {
        throw new Exception($clidedcasp->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarIde = new GerarIDE();
    $oGerarIde->iAnousu     = $iAnousu;
    $oGerarIde->iCodInstit  = $iCodInstit;
    $oGerarIde->gerarDados();

  }

}
