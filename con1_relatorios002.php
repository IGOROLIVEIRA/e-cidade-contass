<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_relatorios_classe.php");
include("classes/db_db_sysprocedarq_classe.php");
include("dbforms/db_funcoes.php");
// include("vendor/mpdf/mpdf/mpdf.php");
require_once("model/relatorios/Relatorio.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$iInstit        = db_getsession('DB_instit');
$oInstit        = new Instituicao($iInstit);

$clrelatorios = new cl_relatorios;
$cldb_sysprocedarq = new cl_db_sysprocedarq;
$db_opcao = 1;
$db_botao = true;
if (isset($Gerar)) {

  require_once("classes/db_" . $arquivo . "_classe.php");

  $class = "cl_" . $arquivo;
  $cl_arquivo = new $class;
  $rsArquivo = $cl_arquivo->sql_record($cl_arquivo->sql_query_file($input_arquivo));
  // db_criatabela($rsArquivo);
  // exit;

  $datasistema =  implode("/", array_reverse(explode("-", date('Y-m-d', db_getsession('DB_datausu')))));

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

  $header = <<<HEADER
  <header>
        <div style="width: 100%; border-bottom: 1px solid #000; border-collapse: inherit; table-layout: fixed; font-family:sans-serif;">
        <div style="border: 0px solid #000; float: left; width: 80px;">
                <div style="width: 80px; height: 80px">
                {$sLogo}
                </div>
        </div>
        <div style="float: left; width: 394px; font-size: 8pt; font-style: italic; padding-left: 10px">
            <span style="font-weight: bold;">{$oInstit->getDescricao()}</span><br>
            <span>{$sEndCompleto}</span><br>
            <span>{$sMunicipio}</span><br>
            <span>{$sTelCnpj}</span><br>
            <span>{$sEmail}</span><br>
            <span>{$sSite}</span><br>
        </div>
        <div style="float: left; width: 160px;">&nbsp;</div>
        <div style="border: 1px solid #000; float: left; width: 400px; height: 90px; text-align: center; border-radius: 10px 10px 10px 0px; background-color: #eee;">
                <div style="padding-top: 35px; font-size: 8pt;">
                {$rel_descricao}
                </div>
        </div>
        </div>
  </header>
HEADER;

  $footer = <<<FOOTER
  <div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
        {PAGENO}/{nb}
  </div>
FOOTER;

  $mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
  $mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
  $mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

  $corpo = db_geratexto($rel_corpo);

  $container = <<<CONTAINER

  <html>
  <head><style id="mceDefaultStyles" type="text/css">.mce-content-body div.mce-resizehandle {position: absolute;border: 1px solid black;box-sizing: content-box;background: #FFF;width: 7px;height: 7px;z-index: 10000}.mce-content-body .mce-resizehandle:hover {background: #000}.mce-content-body img[data-mce-selected],.mce-content-body hr[data-mce-selected] {outline: 1px solid black;resize: none}.mce-content-body .mce-clonedresizable {position: absolute;opacity: .5;filter: alpha(opacity=50);z-index: 10000}.mce-content-body .mce-resize-helper {background: #555;background: rgba(0,0,0,0.75);border-radius: 3px;border: 1px;color: white;display: none;font-family: sans-serif;font-size: 12px;white-space: nowrap;line-height: 14px;margin: 5px 10px;padding: 5px;position: absolute;z-index: 10001}
  .mce-visual-caret {position: absolute;background-color: black;background-color: currentcolor;}.mce-visual-caret-hidden {display: none;}*[data-mce-caret] {position: absolute;left: -1000px;right: auto;top: 0;margin: 0;padding: 0;}
  .mce-content-body .mce-offscreen-selection {position: absolute;left: -9999999999px;max-width: 1000000px;}.mce-content-body *[contentEditable=false] {cursor: default;}.mce-content-body *[contentEditable=true] {cursor: text;}
  img:-moz-broken {-moz-force-broken-image-icon:1;min-width:24px;min-height:24px}
  </style><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link rel="stylesheet" type="text/css" id="u0" crossorigin="anonymous" href="https://cdn.tiny.cloud/1/kcd8n7brt444oarrbdfk633ydzmb80qomjucnpdzlhsvfa1y/tinymce/4.9.11-104/skins/lightgray/content.min.css"><script src="moz-extension://a95982a5-8428-4294-90f7-e4f99a5e5eda/assets/prompt.js"></script></head><body id="tinymce" class="mce-content-body " data-id="rel_corpo" spellcheck="false" contenteditable="true">$corpo</body>
  </html>

CONTAINER;

  $html = $container;

  $mPDF->WriteHTML(utf8_encode($html));

  $mPDF->Output($rel_descricao . '.pdf', "D");
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">

  <style>
    #tableLegenda,
    #tableLegenda th,
    #tableLegenda td {
      border: 1px solid black;
    }
  </style>
  <?
  db_app::load("scripts.js, strings.js, datagrid.widget.js, windowAux.widget.js,dbautocomplete.widget.js");
  db_app::load("dbmessageBoard.widget.js, prototype.js, dbtextField.widget.js, dbcomboBox.widget.js");
  db_app::load("estilos.css, grid.style.css");
  ?>
  <script src='https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=kcd8n7brt444oarrbdfk633ydzmb80qomjucnpdzlhsvfa1y'></script>
  <script type="text/javascript">
    // tinymce.init({
    //   selector: '#rel_corpo'
    // });
  </script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmrelatoriosgerador.php");
          ?>
        </center>
      </td>
    </tr>
  </table>
  <?
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>
<script>
  js_tabulacaoforms("form1", "rel_descricao", true, 1, "rel_descricao", true);
</script>
<?
if (isset($gerar)) {
  if ($clrelatorios->erro_status == "0") {
    $clrelatorios->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clrelatorios->erro_campo != "") {
      echo "<script> document.form1." . $clrelatorios->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clrelatorios->erro_campo . ".focus();</script>";
    }
  } else {
    $clrelatorios->erro(true, true);
  }
}

?>
