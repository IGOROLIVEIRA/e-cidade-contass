<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_respinf102021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/flpg/GerarRESPINF.model.php");

/**
 * FLPGO
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoRespinf extends SicomArquivoBase implements iPadArquivoBaseCSV {

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'RESPINF';

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

  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos(){

  }

  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $clrespinf10 = new cl_respinf102021();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrespinf10->sql_record($clrespinf10->sql_query(NULL,"*",NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if($result)
      if (pg_num_rows($result) > 0) {
        $clrespinf10->excluir(NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
        if ($clrespinf10->erro_status == 0) {
          throw new Exception($clrespinf10->erro_msg);
        }
    }

    /*
     * selecionar informacoes registro 10
     */

    $sSql = "SELECT z01_cgccpf, si166_dataini, si166_datafim   from identificacaoresponsaveis left join cgm on si166_numcgm = z01_numcgm";
    $sSql .= " where si166_instit = " . db_getsession("DB_instit") . " and si166_tiporesponsavel = 5 and DATE_PART('YEAR',si166_dataini) <= ". db_getsession('DB_anousu')." and DATE_PART('YEAR',si166_datafim) >= ". db_getsession('DB_anousu');
    $sSql .= " and (DATE_PART('month',si166_dataini) <= ". $this->sDataInicial['5'].$this->sDataInicial['6'] ." or DATE_PART('month',si166_datafim) <= ". $this->sDataFinal['5'].$this->sDataFinal['6'].")";
    // print_r($sSql);
    $mes = $this->sDataFinal['5'].$this->sDataFinal['6'];      // Mês desejado, pode ser por ser obtido por POST, GET, etc.
    $ano = db_getsession('DB_anousu'); // Ano atual
    $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!

    $dtInicial = $ano.'-'.$mes.'-'.'01';

    $dtFinal   = $ano.'-'.$mes.'-'.$ultimo_dia;

    $rsResult10 = db_query($sSql);
    // db_criatabela($rsResult10);die();

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clrespinf10 = new cl_respinf102021();
      // $clrespinf10->si197_nomeresponsavel       = $oDados10->z01_nome;
      // $clrespinf10->si197_cartident             = 'mg99999999';//$oDados10->z01_ident;
      // $clrespinf10->si197_orgemissorci          = 'SSP';//$oDados10->z01_identorgao;
      // $clrespinf10->si197_cpf                   = $oDados10->z01_cgccpf;
      // var_dump($oDados10);
      $clrespinf10->si197_nrodocumento          = $oDados10->z01_cgccpf;
      $clrespinf10->si197_dtinicio              = $dtInicial;
      $clrespinf10->si197_dtfinal               = $dtFinal;
      $clrespinf10->si197_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrespinf10->si197_instit                  = db_getsession("DB_instit");
      // var_dump($clrespinf10);

      $clrespinf10->incluir(null);
      if ($clrespinf10->erro_status == 0) {
        throw new Exception($clrespinf10->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarRESPINF = new GerarRESPINF();
    $oGerarRESPINF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarRESPINF->gerarDados();

  }

}
