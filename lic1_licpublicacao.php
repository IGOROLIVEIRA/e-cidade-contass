<?
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
$clliccomissaocgm     = new cl_liccomissaocgm;

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));

$oRetorno->status  = 1;
$oRetorno->erro = "";

try {

    $oParam->l20_datacria = implode("-", array_reverse(explode("/", $oParam->l20_datacria)));


    if ($oParam->respPubliccodigo == "") {
        $oRetorno->status = 2;
        $oRetorno->erro   = "Campo Resp. pela Publicacao nao informado";
        echo json_encode($oRetorno);
        exit;
    }

    if ($oParam->l20_diariooficialdivulgacao == '') {
        $oParam->l20_diariooficialdivulgacao = 0;
    }

    if ($oParam->l20_dtpulicacaoedital == "") {
        $oParam->l20_dtpulicacaoedital = "null";
    } else {
        $oParam->l20_dtpulicacaoedital = implode("-", array_reverse(explode("/", $oParam->l20_dtpulicacaoedital)));
        $oParam->l20_dtpulicacaoedital = "'" . $oParam->l20_dtpulicacaoedital . "'";
    }

    if ($oParam->l20_dtpublic == '') {
        $oRetorno->status = 2;
        $oRetorno->erro   = "Campo Data de Publicacao em Diario oficial nao informado";
        echo json_encode($oRetorno);
        exit;
    } else {


        $oParam->l20_dtpublic = implode("-", array_reverse(explode("/", $oParam->l20_dtpublic)));
        $oParam->l20_dtpublic = "'" . $oParam->l20_dtpublic . "'";
    }

    if ($oParam->l20_dtpulicacaopncp == "") {
        $oParam->l20_dtpulicacaopncp = "null";
    } else {
        $oParam->l20_dtpulicacaopncp = implode("-", array_reverse(explode("/", $oParam->l20_dtpulicacaopncp)));
        $oParam->l20_dtpulicacaopncp = "'" . $oParam->l20_dtpulicacaopncp . "'";
    }

    if ($oParam->l20_datapublicacao1 == "") {
        $oParam->l20_datapublicacao1 = "null";
    } else {
        $oParam->l20_datapublicacao1 = implode("-", array_reverse(explode("/", $oParam->l20_datapublicacao1)));

        if ($oParam->l20_datacria > $oParam->l20_datapublicacao1) {

            $oRetorno->status = 2;
            $oRetorno->erro   = "A data da publicacao em Edital Veiculo 1 deve ser superior ou igual a data de criacao.";
            echo json_encode($oRetorno);
            exit;
        }
        $oParam->l20_datapublicacao1 = "'" . $oParam->l20_datapublicacao1 . "'";
    }

    if ($oParam->l20_datapublicacao2 == "") {
        $oParam->l20_datapublicacao2 = "null";
    } else {
        $oParam->l20_datapublicacao2 = implode("-", array_reverse(explode("/", $oParam->l20_datapublicacao2)));
        if ($oParam->l20_datacria > $oParam->l20_datapublicacao2) {

            $oRetorno->status = 2;
            $oRetorno->erro   = "A data da publicacao em Edital Veiculo 2 deve ser superior ou igual a data de criacao.";
            echo json_encode($oRetorno);
            exit;
        }
        $oParam->l20_datapublicacao2 = "'" . $oParam->l20_datapublicacao2 . "'";
    }

    if ($oParam->l20_datacria == "") {
        $oParam->l20_datacria = "null";
    } else {
        $oParam->l20_datacria = implode("-", array_reverse(explode("/", $oParam->l20_datacria)));
        $oParam->l20_datacria = "'" . $oParam->l20_datacria . "'";
    }

    if ($oParam->l20_dataaber == "") {
        $oParam->l20_dataaber = "null";
    } else {
        $oParam->l20_dataaber = implode("-", array_reverse(explode("/", $oParam->l20_dataaber)));
        $oParam->l20_dataaber = "'" . $oParam->l20_dataaber . "'";
    }


    $result =  db_query("UPDATE liclicita
    SET l20_linkedital = '$oParam->l20_linkedital', l20_linkpncp = '$oParam->l20_linkpncp', 
    l20_dtpulicacaoedital = $oParam->l20_dtpulicacaoedital, l20_dtpublic = $oParam->l20_dtpublic,
    l20_dtpulicacaopncp = $oParam->l20_dtpulicacaopncp, l20_datapublicacao1 = $oParam->l20_datapublicacao1,
    l20_datapublicacao2 = $oParam->l20_datapublicacao2, l20_nomeveiculo1 = '$oParam->l20_nomeveiculo1',
    l20_nomeveiculo2 = '$oParam->l20_nomeveiculo2', l20_diariooficialdivulgacao = '$oParam->l20_diariooficialdivulgacao',
    l20_datacria = $oParam->l20_datacria, l20_dataaber = $oParam->l20_dataaber
    WHERE l20_codigo = $oParam->licitacao;");

    if ($oParam->respPubliccodigo != "") {
        $dbquery = "l31_tipo = '8' and l31_licitacao = $oParam->licitacao";
        $clliccomissaocgm->excluir(null, $dbquery);

        $clliccomissaocgm->l31_numcgm = $oParam->respPubliccodigo;
        $clliccomissaocgm->l31_tipo = 8;
        $clliccomissaocgm->l31_licitacao = $oParam->licitacao;
        $clliccomissaocgm->incluir(null);
    }


    if (!$result) {
        $oRetorno->status = 2;
        $oRetorno->erro   = urlencode(str_replace("\\n", "\n", pg_last_error()));
    }
} catch (Exception $eExeption) {

    db_fim_transacao(true);
    $oRetorno->status = 2;
    $oRetorno->erro   = urlencode(str_replace("\\n", "\n", $eExeption->getMessage()));
}



echo json_encode($oRetorno);

//echo $oJson->encode($oRetorno);
