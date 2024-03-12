<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\PcOrcam;
use App\Models\PcOrcamVal;

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

$pcOrcam = new PcOrcam();
$pcOrcamVal = new PcOrcamVal();

try {

    switch( $oParam->sExecuta ) {

    case 'processar':

        $rsInformacoesOrcamento;

    if($oParam->codigoOrcamento != null){
        $rsInformacoesOrcamento = db_query("select
        to_char(pc20_dtate, 'DD/MM/YYYY') as dataorcamento, 
       pc20_codorc as codigoorcamento,
       pc20_hrate as horadoorcamento,
       pc20_prazoentrega as prazoentrega,
       pc20_validadeorcamento as validade,
       pc20_cotacaoprevia as cotacaoprevia,
       pc20_obs as obs,
       pc11_seq as item,
       pc01_codmater as codigo,
       pc01_descrmater as descricao,
       pc11_quant as qtddsolicitada,
       pc23_orcamforne as orcamforne,
       pc23_orcamitem as orcamitem,
       pc23_quant as qtddorcada,
       pc23_vlrun as vlrun,
       pc23_valor as vlrtotal,
       pc23_obs as marca,
       pc80_criterioadjudicacao as criterioadjudicacao,
       CASE
       WHEN pc80_criterioadjudicacao = 1 THEN pc23_percentualdesconto
       WHEN pc80_criterioadjudicacao = 2 THEN pc23_perctaxadesctabela
       ELSE 0
               END AS porcentagem,
       0 as situacao,
       si01_sequencial as precoreferencia    
       from pcorcam
       join pcorcamforne on pc21_codorc=pc20_codorc
       join pcorcamitem on pc22_codorc=pc20_codorc
       join pcorcamval on pc23_orcamitem=pc22_orcamitem
       join pcorcamitemproc on pc31_orcamitem=pc22_orcamitem
       join pcprocitem on pc81_codprocitem=pc31_pcprocitem
       join pcproc on pc80_codproc=pc81_codproc
       join solicitem on pc11_codigo=pc81_solicitem
       join solicitempcmater on pc16_solicitem = pc11_codigo
       join pcmater on pc01_codmater = pc16_codmater
       left join precoreferencia on si01_processocompra = pc80_codproc
       where pc20_codorc = $oParam->codigoOrcamento
       UNION
       /*Orçamento módulo licitação*/
       select
       to_char(pc20_dtate, 'DD/MM/YYYY') as dataorcamento,
       pc20_codorc as codigoorcamento, 
       pc20_hrate as horadoorcamento,
       pc20_prazoentrega as prazoentrega,
       pc20_validadeorcamento as validade,
       pc20_cotacaoprevia as cotacaoprevia,
       pc20_obs as obs,
       l21_ordem as item,
       pc01_codmater as codigo,
       pc01_descrmater as descricao,
       pc11_quant as qtddsolicitada,
       pc23_orcamforne as orcamforne,
       pc23_orcamitem as orcamitem,
       pc23_quant as qtddorcada,
       pc23_vlrun as vlrun,
       pc23_valor as vlrtotal,
       pc23_obs as marca,
       l20_criterioadjudicacao as criterioadjudicacao,
       CASE
       WHEN l20_criterioadjudicacao = 1 THEN pc23_percentualdesconto
       WHEN l20_criterioadjudicacao = 2 THEN pc23_perctaxadesctabela
       ELSE 0
               END AS porcentagem,
       l20_licsituacao as situacao,
       null as precoreferencia   
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
       where pc20_codorc = $oParam->codigoOrcamento order by item;");
    }   
    
    if($oParam->codigoProcessoCompra != null){
        $rsInformacoesOrcamento = db_query(" select
        to_char(pc20_dtate, 'DD/MM/YYYY') as dataorcamento,
        pc20_codorc as codigoorcamento, 
       pc20_hrate as horadoorcamento,
       pc20_prazoentrega as prazoentrega,
       pc20_validadeorcamento as validade,
       pc20_cotacaoprevia as cotacaoprevia,
       pc20_obs as obs,
       pc11_seq as item,
       pc01_codmater as codigo,
       pc01_descrmater as descricao,
       pc11_quant as qtddsolicitada,
       pc23_orcamforne as orcamforne,
       pc23_orcamitem as orcamitem,
       pc23_quant as qtddorcada,
       pc23_vlrun as vlrun,
       pc23_valor as vlrtotal,
       pc23_obs as marca,
       pc80_criterioadjudicacao as criterioadjudicacao,
       CASE
       WHEN pc80_criterioadjudicacao = 1 THEN pc23_percentualdesconto
       WHEN pc80_criterioadjudicacao = 2 THEN pc23_perctaxadesctabela
       ELSE 0
               END AS porcentagem,
       0 as situacao,
       si01_sequencial as precoreferencia    
       from pcorcam
       join pcorcamforne on pc21_codorc=pc20_codorc
       join pcorcamitem on pc22_codorc=pc20_codorc
       join pcorcamval on pc23_orcamitem=pc22_orcamitem
       join pcorcamitemproc on pc31_orcamitem=pc22_orcamitem
       join pcprocitem on pc81_codprocitem=pc31_pcprocitem
       join pcproc on pc80_codproc=pc81_codproc
       join solicitem on pc11_codigo=pc81_solicitem
       join solicitempcmater on pc16_solicitem = pc11_codigo
       join pcmater on pc01_codmater = pc16_codmater
       left join precoreferencia on si01_processocompra = pc80_codproc
       where pc80_codproc = $oParam->codigoProcessoCompra");
    }   

    if($oParam->codigoLicitacao != null){
        $rsInformacoesOrcamento = db_query("select
        to_char(pc20_dtate, 'DD/MM/YYYY') as dataorcamento,
        pc20_codorc as codigoorcamento, 
        pc20_hrate as horadoorcamento,
        pc20_prazoentrega as prazoentrega,
        pc20_validadeorcamento as validade,
        pc20_cotacaoprevia as cotacaoprevia,
        pc20_obs as obs,
        l21_ordem as item,
        pc01_codmater as codigo,
        pc01_descrmater as descricao,
        pc11_quant as qtddsolicitada,
        pc23_orcamforne as orcamforne,
        pc23_orcamitem as orcamitem,
        pc23_quant as qtddorcada,
        pc23_vlrun as vlrun,
        pc23_valor as vlrtotal,
        pc23_obs as marca,
        l20_criterioadjudicacao as criterioadjudicacao,
        CASE
        WHEN l20_criterioadjudicacao = 1 THEN pc23_percentualdesconto
        WHEN l20_criterioadjudicacao = 2 THEN pc23_perctaxadesctabela
        ELSE 0
                END AS porcentagem,
        l20_licsituacao as situacao
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
        where l20_codigo = $oParam->codigoLicitacao order by item");

    }   

    $situacao = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->situacao;

    if($situacao != "0"){
        throw new Exception("Carregamento de dados abortado, o orçamento selecionado possui Processo Licitatório vinculado que não está com o status Em andamento.");
    }

    $precoreferencia = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->precoreferencia;

    if($precoreferencia != null){
        throw new Exception("Carregamento de dados abortado, o orçamento selecionado possui Preço de Referência");
    }

    $oRetorno->criterioadjudicacao = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->criterioadjudicacao;
    $oRetorno->codigoorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->codigoorcamento;
    $oRetorno->dataorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->dataorcamento;
    $oRetorno->horadoorcamento = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->horadoorcamento;
    $oRetorno->prazoentrega = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->prazoentrega;
    $oRetorno->validade = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->validade;
    $oRetorno->cotacaoprevia = db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->cotacaoprevia;
    $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsInformacoesOrcamento, 0)->obs);
    $oRetorno->itens = db_utils::getCollectionByRecord($rsInformacoesOrcamento);

    break;

    case 'salvar':

        $pcOrcam = PcOrcam::find($oParam->codigoorcamento);
        $pcOrcam->pc20_dtate = $oParam->pc20_dtate;
        $pcOrcam->pc20_hrate = $oParam->pc20_hrate;
        $pcOrcam->pc20_prazoentrega = $oParam->pc20_prazoentrega;
        $pcOrcam->pc20_validadeorcamento = $oParam->pc20_validadeorcamento;
        $pcOrcam->pc20_cotacaoprevia = $oParam->pc20_cotacaoprevia;
        $pcOrcam->pc20_obs = utf8_decode(db_stdClass::db_stripTagsJson($oParam->pc20_obs));
        $pcOrcam->save();

        foreach ($oParam->aItens as $oItem) {

            $dados = ['pc23_obs' => $oItem->marca, 'pc23_quant' => $oItem->qtddorcada, 'pc23_vlrun' => $oItem->vlrun, 'pc23_valor' => $oItem->vlrtotal];
            DB::table('compras.pcorcamval')->where('pc23_orcamforne',$oItem->orcamforne)->where('pc23_orcamitem',$oItem->orcamitem)->update($dados);
        }

    }

} catch (Exception $e) {
    $oRetorno->erro = urlencode($e->getMessage());
    $oRetorno->status = 2;
}

echo $oJson->encode($oRetorno);
