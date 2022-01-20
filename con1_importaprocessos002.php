<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_liclicitem_classe.php");
require_once("dbforms/db_funcoes.php");
require_once('libs/db_utils.php');
require_once("classes/licitacao.model.php");
require_once("classes/db_pcorcamval_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");

$clliclicitem  = new cl_liclicitem;

$clrotulo      = new rotulocampo;
$clrotulo->label("l20_codigo");

db_postmemory($HTTP_GET_VARS);

$oGet         = db_utils::postMemory($_GET);
$sqlerro = false;
$iLicitacao   = $oGet->l20_codigo;
$oLicitacao = new licitacao($iLicitacao);

$sFile = explode("\\", $oGet->file);

if ($oGet->extensao == 1) {
    $extensao = 'txt';
} else if ($oGet->extensao == 2) {
    $extensao = 'csv';
} else if ($oGet->extensao == 3) {
    $extensao = 'imp';
}

if ($delimitador == "1") {
    $del = "|";
} else if ($delimitador == "2") {
    $del = ";";
} else if ($delimitador == "3") {
    $del = ",";
}

//echo $oLicitacao->getDados()->pc21_orcamforne;
//echo $oLicitacao->getDados()->pc22_orcamitem;
//exit;

$file_handle = fopen("tmp/$sFile[4]", "r");
while (!feof($file_handle)) {
    $fields = explode($del, fgets($file_handle));
    if (strlen(fgets($file_handle)) != 0) {
        // echo "<pre>";
        // print_r($fields);

        $clpcorcamval  = new cl_pcorcamval;
        $clpcorcamjulg = new cl_pcorcamjulg;

        $clpcorcamval->pc23_vlrun       = $fields[4];
        $clpcorcamval->pc23_quant       = $fields[5];
        $clpcorcamval->pc23_valor       = $fields[4] * $fields[5];
        $clpcorcamval->pc23_obs         = $fields[7];
        $clpcorcamval->pc23_percentualdesconto   = $fields[6];
        $clpcorcamval->pc23_perctaxadesctabela   = $fields[6];
        $clpcorcamval->incluir($oLicitacao->getDados()->pc21_orcamforne, $oLicitacao->getDados()->pc22_orcamitem);
        if ($clpcorcamval->erro_status == 0) {
            $erro_msg .= $clpcorcamval->erro_msg;
            $sqlerro = true;
            break;
        }

        $clpcorcamjulg->pc24_pontuacao   = $fields[8];
        $clpcorcamjulg->incluir($oLicitacao->getDados()->pc22_orcamitem, $oLicitacao->getDados()->pc21_orcamforne);
        if ($clpcorcamjulg->erro_status == 0) {
            $erro_msg = $clpcorcamjulg->erro_msg;
            $sqlerro = true;
            break;
        }
    }
}
fclose($file_handle);

// system("cd tmp; rm -f {$sNomeAbsoluto}.zip; cd ..");
// system("cd tmp; ../bin/zip -q {$sNomeAbsoluto}.zip $sArquivos 2> erro.txt; cd ..");
?>
<!-- <html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.x01_matric.focus();">-->
<?

    // if ($sqlerro == false) {
    //     $nomearqdados = "tmp/$sFile[4]";
    //     echo "<script>";
    //     echo "  listagem = '$nomearqdados#Arquivo Importado|';";
    //     echo "  parent.js_montarlista(listagem,'form1');";
    //     echo "</script>";
    //     return $sqlerro;
    // }
