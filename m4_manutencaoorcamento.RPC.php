<?php

require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_utils.php';
require_once 'libs/JSON.php';

db_postmemory($_POST);

$oJson = new services_json();
$oParam = json_decode(str_replace('\\', '', $_POST['json']));

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->erro = '';

try {
    $rsInformacoesOrcamento = db_query("select
    to_char(pc20_dtate, 'DD/MM/YYYY') as dataorcamento, 
    pc20_hrate as horadoorcamento,
    pc20_prazoentrega as prazoentrega,
    pc20_validadeorcamento as validade,
    pc20_cotacaoprevia as cotacaoprevia,
    pc20_obs as obs,
    l21_ordem as item,
    pc01_codmater as codigo,
    pc01_descrmater as descricao,
    pc11_quant as qtddsolicitada,
    pc23_quant as qtddorcada,
    pc23_vlrun as vlrun,
    pc23_valor as vlrtotal,
    pc23_obs as marca
    from pcorcam
    join pcorcamforne on pc21_codorc=pc20_codorc
    join pcorcamitem on pc22_codorc=pc20_codorc
    join pcorcamval on pc23_orcamitem=pc22_orcamitem
    join pcorcamitemlic on pc26_orcamitem=pc22_orcamitem
    join liclicitem on l21_codigo=pc26_liclicitem
    join liclicita on l20_codigo = l21_codliclicita
    join pcorcamitem as orclicita on orclicita.pc22_orcamitem=pc26_orcamitem
    join pcprocitem on pc81_codprocitem=l21_codpcprocitem
    join solicitem on pc11_codigo=pc81_solicitem
    join solicitempcmater on pc16_solicitem = pc11_codigo
    join pcmater on pc01_codmater = pc16_codmater
    where l20_codigo = 1261 order by item");

    $oRetorno->dataorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->dataorcamento;
    $oRetorno->horadoorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->horadoorcamento;
    $oRetorno->prazoentrega = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->prazoentrega;
    $oRetorno->validade = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->validade;
    $oRetorno->cotacaoprevia = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->cotacaoprevia;
    $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->obs);
    $oRetorno->itens = db_utils::getCollectionByRecord($rsInformacoesOrcamento);

    //var_dump($rsInformacoesOrcamento);
} catch (Exception $e) {
    $oRetorno->erro = urlencode($e->getMessage());
    $oRetorno->status = 2;
}

echo $oJson->encode($oRetorno);
