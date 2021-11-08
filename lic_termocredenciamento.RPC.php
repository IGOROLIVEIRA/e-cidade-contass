<?php
require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");

$oJson                = new services_json();
$oParam               = $oJson->decode(str_replace("\\", "", $_POST["json"]));
//echo "<pre>"; print_r($oParam);exit;

switch ($oParam->exec) {

    case 'getFornecedores':
        $iAnoSessao      = db_getsession('DB_anousu');
        if($oParam->idbopcao == "1"){
            $sqlFornecedor = "SELECT DISTINCT z01_numcgm,
                                          z01_nome
            FROM credenciamento
            INNER JOIN cgm ON z01_numcgm = l205_fornecedor
            WHERE l205_licitacao ={$oParam->iLicitacao}";
        }else{
            $sqlFornecedor = "SELECT z01_numcgm,
                                     z01_nome
            FROM credenciamentotermo
            INNER JOIN cgm ON z01_numcgm = l212_fornecedor
            where l212_sequencial = $oParam->iCodtermo";
        }

        $rsFornecedor  = db_query($sqlFornecedor);

        $oFornecedor = db_utils::getCollectionByRecord($rsFornecedor);
        $oRetorno->fornecedores = $oFornecedor;

    break;

    case 'getItensCredenciamento':

        if($oParam->iFornecedor == null){
            $where = "WHERE credenciamentotermo.l212_sequencial = $oParam->iCodtermo order by pc11_seq";
        }else{
            $where = "WHERE l20_codigo = $oParam->iLicitacao and l205_fornecedor = $oParam->iFornecedor order by pc11_seq";
        }

        $sqlItens = "SELECT DISTINCT pc11_seq,
                pc01_codmater,
                pc01_descrmater,
                m61_codmatunid,
                m61_descr,
                    (SELECT si02_vlprecoreferencia
                     FROM itemprecoreferencia
                     WHERE si02_itemproccompra = pcorcamitemproc.pc31_orcamitem) AS pc23_vlrun,
                                pc23_quant
                FROM credenciamento
                INNER JOIN liclicita ON l20_codigo = l205_licitacao
                INNER JOIN liclicitem ON (l21_codliclicita,l21_codpcprocitem) = (l20_codigo,l205_item)
                INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                INNER JOIN pcmaterele ON pc07_codmater = pcmater.pc01_codmater
                INNER JOIN pcorcamitemproc ON pcorcamitemproc.pc31_pcprocitem = pcprocitem.pc81_codprocitem
                INNER JOIN pcorcamitem ON pcorcamitem.pc22_orcamitem = pcorcamitemproc.pc31_orcamitem
                INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
                INNER JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
                INNER JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
                AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
                INNER JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
                AND pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne
                LEFT JOIN credenciamentotermo on l212_fornecedor = l205_fornecedor and l212_licitacao = l205_licitacao 
                LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
                LEFT JOIN credenciamentosaldo ON credenciamentosaldo.l213_licitacao = liclicita.l20_codigo
                AND l21_codigo = l213_itemlicitacao
                $where";
        $resultItens = db_query($sqlItens);
        for ($iCont = 0; $iCont < pg_num_rows($resultItens); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($resultItens, $iCont);
            $oItem      = new stdClass();
            $oItem->pc11_seq                        = $oItensLicitacao->pc11_seq;
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->pc01_complmater                 = urlencode($oItensLicitacao->pc01_complmater);
            $oItem->m61_descr                       = $oItensLicitacao->m61_descr;
            $oItem->varlortotal                     = $oItensLicitacao->pc23_vlrun * $oItensLicitacao->pc23_quant;
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;
    break;

    case 'getNumeroTermo':
        $iAnoSessao      = db_getsession('DB_anousu');

        $sql = "select max(l212_numerotermo) as numeromaximo from credenciamentotermo";
        $rsNumTermo  = db_query($sql);
        $iNumTermo = db_utils::fieldsMemory($rsNumTermo, 0)->numeromaximo;
        if($iNumTermo == ""){
            $iNum = 1;
        }else{
            $ultimonum = explode("/", $iNumTermo);
            $iNum = $ultimonum[0] + 1;
        }

        $iNumTermoAno = $iNum;

        $oRetorno->numerotermo = $iNumTermoAno;

    break;
}
echo $oJson->encode($oRetorno);
