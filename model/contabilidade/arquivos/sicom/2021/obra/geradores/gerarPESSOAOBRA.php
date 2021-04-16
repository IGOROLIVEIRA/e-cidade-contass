<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarPESSOAOBRA extends GerarAM
{
  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {
    $this->sArquivo = "PESSOA";
    $this->abreArquivo();

    $sSql = "select * from pessoasobra102021 where si194_mes = " . $this->iMes . " and si194_instit=" . db_getsession("DB_instit");
    $rspessoaobra10 = db_query($sSql);

    if (pg_num_rows($rspessoaobra10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rspessoaobra10); $iCont++) {

        $aPESSPAOBRA10 = pg_fetch_array($rspessoaobra10, $iCont);

        $aCSVPESSOAOBRA10['si194_tiporegistro'] = str_pad($aPESSPAOBRA10['si194_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVPESSOAOBRA10['si194_nrodocumento'] = substr($aPESSPAOBRA10['si194_nrodocumento'], 0, 50);
        $aCSVPESSOAOBRA10['si194_nome'] = substr($aPESSPAOBRA10['si194_nome'], 0, 120);
        $aCSVPESSOAOBRA10['si194_tipocadastro'] = $aPESSPAOBRA10['si194_tipocadastro'];
        $aCSVPESSOAOBRA10['si194_justificativaalteracao'] = $aPESSPAOBRA10['si194_justificativaalteracao'];
        $this->sLinha = $aCSVPESSOAOBRA10;
        $this->adicionaLinha();
      }
      $this->fechaArquivo();
    }
  }
}
