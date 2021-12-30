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

system("cd tmp; rm -f *.$extensao; cd ..");
$numeroEdital = $aEditalLicitacao[0]->numeroedital;
$anoProcessoLicitatorio = $aEditalLicitacao[0]->anoprocessolicitatorio;
$anoEdital = $aEditalLicitacao[0]->anoedital;
$cnpj = $aEditalLicitacao[0]->cnpj;
$codigotcemg = $aEditalLicitacao[0]->codigotcemg;

$clabre_arquivo = new cl_abre_arquivo("tmp/Edital_".$numeroEdital."_".$anoEdital."_".$iLicitacao."_".$anoProcessoLicitatorio.".".$extensao);

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "");

    foreach ($aEditalLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = $oItens->tiporegistro;
        $iCodigoOrgao                    = $oItens->codigotcemg;
        $iTipoOrgao                      = $oItens->tipodeinstituicao;
        $iCnpj                           = $oItens->cnpj;
        $sNomeOrgao                      = $oItens->nomedainstituicao;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iNroEdital                      = $oItens->numeroedital;
        $iExercicioEdital                = $oItens->anoedital;
        $sProcessoObjeto                 = $oItens->objeto;
        $iNaturezaObjeto                 = $oItens->naturezadoobjeto;
        $iRegistroPreco                  = $oItens->registrodepreco;

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sNomeOrgao, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNroEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicioEdital, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sProcessoObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iNaturezaObjeto, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iRegistroPreco, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}

$clabre_arquivo = new cl_abre_arquivo("tmp/Itens_".$iLicitacao."_".$anoProcessoLicitatorio."_".$cnpj.".".$extensao);

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "");

    foreach ($aItensLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = $oItens->tiporegistro;
        $iCnpj                           = $oItens->cnpj;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iCodMater                       = $oItens->codigodoitem;
        $iOrdem                          = $oItens->sequencialdoitemnoprocesso;
        $sDescrItem                      = $oItens->descricaodoitem;
        $sUnidadeMedida                  = $oItens->unidadedemedida;
        $iQtdLicitada                    = $oItens->quantidadelicitada;
        $iValorUnitMedio                 = $oItens->valorunitariomedio;
        $iCodigodolote                   = $oItens->codigodolote;

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCnpj, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodMater, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iOrdem, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sDescrItem, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sUnidadeMedida, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iQtdLicitada, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iValorUnitMedio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodigodolote, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}

$clabre_arquivo = new cl_abre_arquivo("tmp/Lote_".$iLicitacao."_".$anoProcessoLicitatorio."_".$cnpj.".".$extensao);

if ($clabre_arquivo->arquivo != false) {

    $vir = $separador;
    $del = $delimitador;

    fputs($clabre_arquivo->arquivo, "");

    foreach ($aEditalLicitacao as $iItens => $oItens) {

        $iTipoRegistro                   = $oItens->tiporegistro;
        $iProcessoLicitatorio            = $oItens->processolicitatorio;
        $iExercicio                      = $oItens->anoprocessolicitatorio;
        $iLote                           = $oItens->codigodolote;
        $iCodItem                        = $oItens->codigodoitemvinculadoaolote;
        $sDescrLote                      = $oItens->descricaodolote;

        fputs($clabre_arquivo->arquivo, formatarCampo($iTipoRegistro, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iProcessoLicitatorio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iExercicio, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iLote, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($iCodItem, $vir, $del));
        fputs($clabre_arquivo->arquivo, formatarCampo($sDescrLote, $vir, $del));
        fputs($clabre_arquivo->arquivo, "\n");
    }

    fclose($clabre_arquivo->arquivo);
}
$aArquivosGerados = array();
$aArquivosGerados[] = "Edital_".$numeroEdital."_".$anoEdital."_".$iLicitacao."_".$anoProcessoLicitatorio.".".$extensao;
$aArquivosGerados[] = "Itens_".$iLicitacao."_".$anoProcessoLicitatorio."_".$cnpj.".".$extensao;
$aArquivosGerados[] = "Lote_".$iLicitacao."_".$anoProcessoLicitatorio."_".$cnpj.".".$extensao;

$sNomeAbsoluto = $cnpj."_".$codigotcemg."_".$anoProcessoLicitatorio;

//compactaArquivos($aArquivosGerados, $sNomeArquivo);

      foreach($aArquivosGerados as $sArquivo) {
        $sArquivos .= " $sArquivo";
      }

      system("cd tmp; rm -f {$sNomeAbsoluto}.zip; cd ..");
      system("cd tmp; ../bin/zip -q {$sNomeAbsoluto}.zip $sArquivos 2> erro.txt; cd ..");

echo "<script>";
echo "  jan = window.open('db_download.php?arquivo=" . "tmp/{$sNomeAbsoluto}.zip" . "','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');";
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

    return "{$valor}{$del}";
}
