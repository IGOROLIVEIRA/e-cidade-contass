<?
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_liclicitem_classe.php");
require_once("dbforms/db_funcoes.php");
require_once('libs/db_utils.php');
require_once("classes/licitacao.model.php");
$clliclicitem = new cl_liclicitem;
$clrotulo     = new rotulocampo;
$clrotulo->label("l20_codigo");

db_postmemory($HTTP_GET_VARS);

$oGet         = db_utils::postMemory($_GET);

$iLicitacao   = $oGet->l20_codigo;

if ($oGet->extensao == 1) {
    $extensao = 'txt';
} else if ($oGet->extensao == 2) {
    $extensao = 'csv';
} else if ($oGet->extensao == 3) {
    $extensao = 'imp';
}

//====================  instanciamos a classe da solicitação selecionada para retornar os itens

$oLicitacao = new licitacao($iLicitacao);
try {
    $aEditalLicitacao   = $oLicitacao->getEditalExport();
    $aItensLicitacao    = $oLicitacao->getItensExport();
    $aLoteLicitacao    = $oLicitacao->getLoteExport();
} catch (Exception $oErro) {
    db_redireciona('db_erros.php?fechar=true&db_erro=' . $oErro->getMessage());
}


$clabre_arquivo = new cl_abre_arquivo("tmp/Edital_$iLicitacao.$extensao");

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "\n");

    foreach ($aEditalLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = '1';
        $iCodigoOrgao                    = '01';
        $iTipoOrgao                      = '01';
        $iCnpj                           = $oItens->cnpj;
        $sNomeOrgao                      = $oItens->nomeorgao;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iNroEdital                      = $oItens->processolicitatorio;
        $iExercicioEdital                = $oItens->anoprocessolicitatorio;
        $sProcessoObjeto                 = '';
        $iNaturezaObjeto                 = '';
        $iRegistroPreco                  = '';

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sNomeOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercício, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicioEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sProcessoObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNaturezaObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iRegistroPreco, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}

$clabre_arquivo = new cl_abre_arquivo("tmp/Itens_$iLicitacao.$extensao");

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "\n");

    foreach ($aItensLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = '1';
        $iCodigoOrgao                    = '01';
        $iTipoOrgao                      = '01';
        $iCnpj                           = $oItens->cnpj;
        $sNomeOrgao                      = $oItens->nomeorgao;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iNroEdital                      = $oItens->processolicitatorio;
        $iExercicioEdital                = $oItens->anoprocessolicitatorio;
        $sProcessoObjeto                 = '';
        $iNaturezaObjeto                 = '';
        $iRegistroPreco                  = '';

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sNomeOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercício, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicioEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sProcessoObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNaturezaObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iRegistroPreco, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}

$clabre_arquivo = new cl_abre_arquivo("tmp/Lote_$iLicitacao.$extensao");

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "\n");

    foreach ($aEditalLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = '1';
        $iCodigoOrgao                    = '01';
        $iTipoOrgao                      = '01';
        $iCnpj                           = $oItens->cnpj;
        $sNomeOrgao                      = $oItens->nomeorgao;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sNomeOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}
$aArquivosGerados = array();
$aArquivosGerados[] =  "tmp/Edital_$iLicitacao.$extensao";
$aArquivosGerados[] =  "tmp/Itens_$iLicitacao.$extensao";
$aArquivosGerados[] =  "tmp/Lote_$iLicitacao.$extensao";

$sNomeArquivo = "export_process";

$aListaArquivos = " ";
foreach ($aArquivosGerados as $oArquivo) {
    $aListaArquivos .= " " . $oArquivo;
}
//print_r($aListaArquivos);
system("rm -f tmp/$sNomeArquivo.zip");
system("bin/zip -q tmp/$sNomeArquivo.zip $aListaArquivos");

//compactaArquivos($aArquivosGerados, $sNomeArquivo);

echo "<script>";
echo "  jan = window.open('db_download.php?arquivo=" . "tmp/export_process.zip" . "','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');";
echo "  jan.moveTo(0,0);";
echo "</script>";

// Funcao para formatar um campo
function formatarCampo($valor, $separador, $delimitador)
{

    $del = "";
    if ($delimitador == "1") {
        $del = "|";
    } else if ($delimitador == "2") {
        $del = ";";
    } else if ($delimitador == "3") {
        $del = ",";
    }

    $valor = str_replace("\n", " ", $valor);
    $valor = str_replace("\r", " ", $valor);

    return "{$del}{$valor}{$del}{$separador}";
}
