<?php

require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_relatorios_classe.php");
require_once("classes/db_db_sysarqcamp_classe.php");
require_once("classes/db_db_sysarquivo_classe.php");
require_once("vendor/mpdf/mpdf/mpdf.php");

$clrelatorios = new cl_relatorios;
$oDaoSysArqCamp = new cl_db_sysarqcamp();
$oDaoSysArquivo = new cl_db_sysarquivo();
$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();
$dtDia             = date("Y-m-d", db_getsession("DB_datausu"));

switch ($oParam->exec) {

  case 'verificaArquivo':

    $sSqlSysArqCamp = $oDaoSysArqCamp->sql_query($oParam->iArquivo, '', '', 'db_syscampo.*');
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    if ($oDaoSysArqCamp->numrows > 0) {
      for ($i = 0; $i < pg_numrows($rsSysArqCamp); $i++) {

        $oDados = db_utils::fieldsMemory($rsSysArqCamp, $i);
        $oDados->descricao = utf8_encode($oDados->descricao);
        $oRetorno->itens[] = $oDados;
      }
    }
    break;

  case 'getArquivo':

    $sSqlSysArqCamp = $oDaoSysArquivo->sql_query_buscaCamposPkPorTabela($oParam->iArquivo);
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    $oDados = db_utils::fieldsMemory($rsSysArqCamp, 0);
    $oRetorno->arquivo = $oDados;
    break;

  case 'getCorpo':
    $rsCorpo = $clrelatorios->sql_record($clrelatorios->sql_query($oParam->iSequencial, 'rel_corpo'));
    $oDados = db_utils::fieldsMemory($rsCorpo, 0);
    $oRetorno->itens[] = $oDados;
    break;

  case 'Processar':

    $iInstit        = db_getsession('DB_instit');
    $oInstit        = new Instituicao($iInstit);
    $sInstit      = $oInstit->getDescricao();

    $sSqlSysArqCamp = $oDaoSysArquivo->sql_query_buscaCamposPkPorTabela($oParam->iArquivo);
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    $oDados = db_utils::fieldsMemory($rsSysArqCamp, 0);
    $arquivo = $oParam->sArquivo;
    require_once("classes/db_" . $arquivo . "_classe.php");

    $class = "cl_" . $arquivo;

    $cl_arquivo = new $class;

    $rsArquivo = $cl_arquivo->sql_record($cl_arquivo->sql_query_file($oParam->iArquivo));

    $datasistema =  implode("/", array_reverse(explode("-", date('Y-m-d', db_getsession('DB_datausu')))));


    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

    $dSistema = strftime('%A, %d de %B de %Y', strtotime('today'));

    db_fieldsmemory($rsArquivo, 0);

    $mPDF = new mpdf('', 'A4-L', 0, '', 10, 10, 30, 10, 5, 5);
    if (file_exists("imagens/files/{$oInstit->getImagemLogo()}")) {
      $sLogo = "<img src='imagens/files/{$oInstit->getImagemLogo()}' width='70px' >";
    } else {
      $sLogo = "";
    }

    $sComplento = substr(trim($oInstit->getComplemento()), 0, 20);

    if (!empty($sComplento)) {
      $sComplento = ", " . substr(trim($oInstit->getComplemento()), 0, 20);
    }

    $sEndCompleto = trim($oInstit->getLogradouro()) . ", " . trim($oInstit->getNumero()) . $sComplento;
    $sMunicipio   = trim($oInstit->getMunicipio()) . " - " . trim($oInstit->getUF());
    $sTelCnpj     = trim($oInstit->getTelefone()) . "   -    CNPJ : " . db_formatar($oInstit->getCNPJ(), "cnpj");
    $sEmail       = trim($oInstit->getEmail());
    $sSite        = $oInstit->getSite();


    if ($l20_codtipocom) {
      require_once("classes/db_" . $cflicita . "_classe.php");
      $clcflicita = new cl_cflicita;
      db_fieldsmemory($clcflicita->sql_record($clcflicita->sql_query($l20_codtipocom, "distinct l03_descr")), 0);
    }

    $sDescricao = base64_decode($oParam->sDescricao);
    $sCorpo = base64_decode($oParam->sCorpo);
    $corpo = db_geratexto($sCorpo);

    $header = <<<HEADER
      <html>
      <body>
      <div>
            <div style="width: 100%; table-layout: fixed; font-family:sans-serif;">
              <div style="border: 0px solid #000; float: left; width: 80px;">
                      <div style="width: 80px; height: 80px">
                      {$sLogo}
                      </div>
              </div>
              <div style="float: left; width: 300px; font-size: 8pt; font-style: italic; padding-left: 10px">
                  <span style="font-weight: bold;">{$oInstit->getDescricao()}</span><br>
                  <span>{$sEndCompleto}</span><br>
                  <span>{$sMunicipio}</span><br>
                  <span>{$sTelCnpj}</span><br>
                  <span>{$sEmail}</span><br>
                  <span>{$sSite}</span><br>
              </div>
              <div style="border: 1px solid #000; margin-left: 20px; float: left; width: 230px; height: 80px; text-align: center; border-radius: 10px 10px 10px 0px; background-color: #eee;">
                      <div style="padding-top: 35px; font-size: 8pt;">
                      {$sDescricao}
                      </div>
              </div>
            </div>
      </div>

HEADER;

    $container = <<<CONTAINER
    <br /><br /><br /><br />
<div style='width:100%;text-align:right;height:10px;'>
<br />
    {$corpo}
</div>
CONTAINER;

    $footer = <<<FOOTER
      </div>
      <div style='border-top:1px solid #000;width:100%;text-align:right;height:10px;'>

      </div>
      <body>
      </html>
FOOTER;

    $html = $header;
    $html .= $container;
    $html .= $footer;

    $oRetorno->itens[] = base64_encode($html);

    break;
}
echo $oJson->encode($oRetorno);
