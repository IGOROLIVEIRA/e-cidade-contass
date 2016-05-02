<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_respinf102013_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2013/flpg/GerarRESPINF.model.php");

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

    $clrespinf10 = new cl_respinf102013();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clrespinf10->sql_record($clrespinf10->sql_query(NULL,"*",NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clrespinf10->excluir(NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clrespinf10->erro_status == 0) {
        throw new Exception($clrespinf10->erro_msg);
      }
    }

    /*
     * selecionar informacoes registro 10
     */

    if ($this->sDataFinal['5'].$this->sDataFinal['6'] == 01) {
      $sSql = "SELECT z01_ident,z01_nome,z01_identorgao,z01_cgccpf, si166_dataini, si166_datafim   from identificacaoresponsaveis left join cgm on si166_numcgm = z01_numcgm";
      $sSql .= " where si166_instit = " . db_getsession("DB_instit") . " and si166_tiporesponsavel = 1 and DATE_PART('YEAR',si166_dataini) = ". db_getsession('DB_anousu') ." and si166_tiporesponsavel not in (5) ";
    }else{
      $sSql = "SELECT z01_ident,z01_nome,z01_identorgao,z01_cgccpf, si166_dataini, si166_datafim   from identificacaoresponsaveis left join cgm on si166_numcgm = z01_numcgm";
      $sSql .= " where si166_instit = " . db_getsession("DB_instit") . " and si166_tiporesponsavel = 1 and DATE_PART('YEAR',si166_dataini) = ". db_getsession('DB_anousu');
      $sSql .= " and z01_cgccpf not in (select si197_cpf from respinf102013 where si197_mes < ".($this->sDataFinal['5'].$this->sDataFinal['6']).")" ." and si166_tiporesponsavel not in (5) ";
    }


    $rsResult10 = db_query($sSql);
    //echo $sSql;exit;

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clrespinf10 = new cl_respinf102013();
      $clrespinf10->si197_nomeresponsavel       = $oDados10->z01_nome;
      $clrespinf10->si197_cartident             = $oDados10->z01_ident;
      $clrespinf10->si197_orgemissorci          = $oDados10->z01_identorgao;
      $clrespinf10->si197_cpf                   = $oDados10->z01_cgccpf;
      $clrespinf10->si197_dtinicio              = $this->sDataInicial;
      $clrespinf10->si197_dtfinal               = $this->sDataFinal;
      $clrespinf10->si197_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clrespinf10->si197_inst                  = db_getsession("DB_instit");

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
