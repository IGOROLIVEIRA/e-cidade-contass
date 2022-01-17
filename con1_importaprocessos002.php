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
$clpcorcamval  = new cl_pcorcamval;
$clpcorcamjulg = new cl_pcorcamjulg;

$clrotulo      = new rotulocampo;
$clrotulo->label("l20_codigo");

db_postmemory($HTTP_GET_VARS);

$oGet         = db_utils::postMemory($_GET);

$iLicitacao   = $oGet->l20_codigo;
$oLicitacao = new licitacao($iLicitacao);
echo '<pre>';
print_r($oLicitacao->);
//$clpcorcamval->alterar();
//$clpcorcamjulg->alterar();
//exit;

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

$file_handle = fopen("tmp/$sFile[4]", "r");
while (!feof($file_handle)) {
    echo "<pre>";
    $fields = explode($del, fgets($file_handle));
    if (strlen(fgets($file_handle)) != 0) {
        print_r($fields);
    }
}
fclose($file_handle);
exit;


// system("cd tmp; rm -f {$sNomeAbsoluto}.zip; cd ..");
// system("cd tmp; ../bin/zip -q {$sNomeAbsoluto}.zip $sArquivos 2> erro.txt; cd ..");

// echo "<script>";
// echo "  jan = window.open('db_download.php?arquivo=" . "tmp/{$sNomeAbsoluto}.zip" . "','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');";
// echo "  jan.moveTo(0,0);";
// echo "</script>";
