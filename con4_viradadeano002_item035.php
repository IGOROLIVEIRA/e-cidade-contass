<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */


$oDaoPccflicitapar = new cl_pccflicitapar();
$oDaoMaterialestoquegrupoconta = new cl_materialestoquegrupoconta();
$oDaoClabensconplano = new cl_clabensconplano();
$oDaoAcordogruponumeracao = new cl_acordogruponumeracao();
$oDaoNumeracaotipoproc = new cl_numeracaotipoproc();

if ($sqlerro == false) {


  try {
    $ano = $iAnoOrigem + 1;
    $sWhereexiste    = " l25_anousu = {$ano}";
    $sSqlDadosexiste = $oDaoPccflicitapar->sql_query_file( null, "*", null, $sWhereexiste );
    $rsDadosexiste   = db_query($sSqlDadosexiste);
    if(pg_numrows($rsDadosexiste)==0){

      $sWhereOrigem    = " l25_anousu = {$iAnoOrigem}";
      $sSqlDadosOrigem = $oDaoPccflicitapar->sql_query_file( null, "*", null, $sWhereOrigem );
      $rsDadosOrigem   = db_query($sSqlDadosOrigem);
      for($x=0;$x<pg_numrows($rsDadosOrigem);$x++){
        $oDados = db_utils::fieldsMemory($rsDadosOrigem, $x);
        $oDaoPccflicitapar->l25_codcflicita = $oDados->l25_codcflicita;
        $oDaoPccflicitapar->l25_anousu = $oDados->l25_anousu +1;
        $oDaoPccflicitapar->l25_numero = '0';
        $oDaoPccflicitapar->incluir(null);
        if ($oDaoPccflicitapar->erro_status == "0") {
          $erro_msg .=$oDaoPccflicitapar->erro_msg;
          $sqlerro=true;
        }
        
      }
    }

    $sWhereexiste    = " m66_anousu = {$ano}";
    $sSqlDadosexiste = $oDaoMaterialestoquegrupoconta->sql_query_file( null, "*", null, $sWhereexiste );
    $rsDadosexiste   = db_query($sSqlDadosexiste);
    if(pg_numrows($rsDadosexiste)==0){

      $sWhereOrigem    = " m66_anousu = {$iAnoOrigem}";
      $sSqlDadosOrigem = $oDaoMaterialestoquegrupoconta->sql_query_file( null, "*", null, $sWhereOrigem );
      $rsDadosOrigem   = db_query($sSqlDadosOrigem);
      for($x=0;$x<pg_numrows($rsDadosOrigem);$x++){
        $oDados = db_utils::fieldsMemory($rsDadosOrigem, $x);
        $oDaoMaterialestoquegrupoconta->m66_materialestoquegrupo = $oDados->m66_materialestoquegrupo;
        $oDaoMaterialestoquegrupoconta->m66_codcon = $oDados->m66_codcon;
        $oDaoMaterialestoquegrupoconta->m66_anousu = $oDados->m66_anousu +1;
        $oDaoMaterialestoquegrupoconta->m66_codconvpd = $oDados->m66_codconvpd;
        $oDaoMaterialestoquegrupoconta->incluir(null);
        if ($oDaoMaterialestoquegrupoconta->erro_status == "0") {
          $erro_msg .=$oDaoMaterialestoquegrupoconta->erro_msg;
          $sqlerro=true;
        }
      }
    }

    $sWhereexiste    = " t86_anousu = {$ano}";
    $sSqlDadosexiste = $oDaoClabensconplano->sql_query_file( null, "*", null, $sWhereexiste );
    $rsDadosexiste   = db_query($sSqlDadosexiste);
    if(pg_numrows($rsDadosexiste)==0){

      $sWhereOrigem    = " t86_anousu = {$iAnoOrigem}";
      $sSqlDadosOrigem = $oDaoClabensconplano->sql_query_file( null, "*", null, $sWhereOrigem );
      $rsDadosOrigem   = db_query($sSqlDadosOrigem);
      for($x=0;$x<pg_numrows($rsDadosOrigem);$x++){
        $oDados = db_utils::fieldsMemory($rsDadosOrigem, $x);
        $oDaoClabensconplano->t86_clabens = $oDados->t86_clabens;
        $oDaoClabensconplano->t86_conplano = $oDados->t86_conplano;
        $oDaoClabensconplano->t86_anousu = $oDados->t86_anousu +1;
        $oDaoClabensconplano->t86_conplanodepreciacao = $oDados->t86_conplanodepreciacao;
        $oDaoClabensconplano->t86_anousudepreciacao = $oDados->t86_anousu +1;
        $oDaoClabensconplano->incluir(null);
        if ($oDaoClabensconplano->erro_status == "0") {
          $erro_msg .=$oDaoClabensconplano->erro_msg;
          $sqlerro=true;
        }
      }
    }

    $sWhereexiste    = " ac03_anousu = {$ano} and ac03_instit= ".db_getsession('DB_instit');
    $sSqlDadosexiste = $oDaoAcordogruponumeracao->sql_query_file( null, "*", null, $sWhereexiste );
    $rsDadosexiste   = db_query($sSqlDadosexiste);
    if(pg_numrows($rsDadosexiste)==0){

      $sWhereOrigem    = " ac03_anousu = {$iAnoOrigem} and ac03_instit= ".db_getsession('DB_instit');
      $sSqlDadosOrigem = $oDaoAcordogruponumeracao->sql_query_file( null, "*", null, $sWhereOrigem );
      $rsDadosOrigem   = db_query($sSqlDadosOrigem);
      for($x=0;$x<pg_numrows($rsDadosOrigem);$x++){
        $oDados = db_utils::fieldsMemory($rsDadosOrigem, $x);
        $oDaoAcordogruponumeracao->ac03_acordogrupo = $oDados->ac03_acordogrupo;
        $oDaoAcordogruponumeracao->ac03_anousu = $oDados->ac03_anousu + 1;
        $oDaoAcordogruponumeracao->ac03_numero = '0';
        $oDaoAcordogruponumeracao->ac03_instit = db_getsession("DB_instit");
        $oDaoAcordogruponumeracao->incluir(null);
        if ($oDaoAcordogruponumeracao->erro_status == "0") {
          $erro_msg .=$oDaoAcordogruponumeracao->erro_msg;
          $sqlerro=true;
        }
      }
    }

    $sWhereexiste    = " p200_ano = {$ano}";
    $sSqlDadosexiste = $oDaoNumeracaotipoproc->sql_query_file( null, "*", null, $sWhereexiste );
    $rsDadosexiste   = db_query($sSqlDadosexiste);
    
    if(pg_numrows($rsDadosexiste)==0){

      $sWhereOrigem    = " p200_ano = {$iAnoOrigem}";
      $sSqlDadosOrigem = $oDaoNumeracaotipoproc->sql_query_file( null, "*", null, $sWhereOrigem );
      $rsDadosOrigem   = db_query($sSqlDadosOrigem);
      
      for($x=0;$x<pg_numrows($rsDadosOrigem);$x++){
        $oDados = db_utils::fieldsMemory($rsDadosOrigem, $x);
        $oDaoNumeracaotipoproc->p200_ano = $oDados->p200_ano + 1;
        $oDaoNumeracaotipoproc->p200_numeracao = 0;
        $oDaoNumeracaotipoproc->p200_tipoproc = $oDados->p200_tipoproc;
        $oDaoNumeracaotipoproc->incluir(null);
        if ($oDaoNumeracaotipoproc->erro_status == "0") {
          $erro_msg .= $oDaoNumeracaotipoproc->erro_msg;
          $sqlerro=true;
        }
      }
    }
    

  } catch(Exception $oErro) {

    $sqlerro  = true;
    $erro_msg = $oErro->getMessage();

    if ( $oErro->getCode() == 2)  {

      $cldb_viradaitemlog->c35_log           = $oErro->getMessage();
      $cldb_viradaitemlog->c35_codarq        = 3781;
      $cldb_viradaitemlog->c35_db_viradaitem = $cldb_viradaitem->c31_sequencial;
      $cldb_viradaitemlog->c35_data          = date("Y-m-d");
      $cldb_viradaitemlog->c35_hora          = date("H:i");
      $cldb_viradaitemlog->incluir(null);
      if ($cldb_viradaitemlog->erro_status == 0) {
        $erro_msg .= $cldb_viradaitemlog->erro_msg;
      }
    }

  }

}
?>