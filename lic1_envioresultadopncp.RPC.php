<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liccontrolepncp_classe.php");
require_once("model/licitacao/PNCP/AvisoLicitacaoPNCP.model.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'getItens':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();

        $campos = "DISTINCT pc01_codmater,pc01_descrmater,cgmforncedor.z01_numcgm,cgmforncedor.z01_nome,m61_descr,pc11_quant,pc23_valor,l203_homologaadjudicacao,pc81_codprocitem,l04_descricao,pc11_seq,l04_seq";

        //Itens para Inclusao
        $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 AND pc81_codprocitem not in (select l203_item from homologacaoadjudica
                        inner join itenshomologacao on l203_homologaadjudicacao = l202_sequencial where l202_licitacao = {$oParam->iLicitacao})";
        $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_semhomologacao(null, $campos, "l04_descricao,pc11_seq,z01_nome", $sWhere));
        echo $clhomologacaoadjudica->sql_query_itens_semhomologacao(null, $campos, "l04_descricao,pc11_seq,z01_nome", $sWhere);
        exit;

        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($result, $iCont);
            $oItem      = new stdClass();
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->z01_numcgm                      = $oItensLicitacao->z01_numcgm;
            $oItem->z01_nome                        = urlencode($oItensLicitacao->z01_nome);
            $oItem->m61_descr                       = $oItensLicitacao->m61_descr;
            $oItem->pc11_quant                      = $oItensLicitacao->pc11_quant;
            $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
            $oItem->l203_homologaadjudicacao        = $oItensLicitacao->l203_homologaadjudicacao;
            $oItem->pc81_codprocitem                = $oItensLicitacao->pc81_codprocitem;
            $oItem->pc11_seq                        = $oItensLicitacao->pc11_seq;
            if ($l20_tipojulg == "3") {
                $oItem->l04_descricao               = urlencode($oItensLicitacao->l04_descricao);
            } else {
                $oItem->l04_descricao               = "";
            }
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;

        break;
}
echo json_encode($oRetorno);
