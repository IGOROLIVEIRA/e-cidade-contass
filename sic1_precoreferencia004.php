    <?php
    require_once 'model/relatorios/Relatorio.php';
    include("classes/db_db_docparag_classe.php");

    // include("fpdf151/pdf.php");
    require("libs/db_utils.php");
    $oGet = db_utils::postMemory($_GET);
    parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
    db_postmemory($HTTP_POST_VARS);

    switch ($oGet->tipoprecoreferencia) {
        case '2':
            $tipoReferencia = " MAX(pc23_vlrun) ";
            break;

        case '3':
            $tipoReferencia = " MIN(pc23_vlrun) ";
            break;

        default:
            $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
            break;
    }

    $rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
                        from
                            pcproc
                        join pcprocitem on
                            pc80_codproc = pc81_codproc
                        left join processocompraloteitem on
                            pc69_pcprocitem = pcprocitem.pc81_codprocitem
                        left join processocompralote on
                            pc68_sequencial = pc69_processocompralote
                        where
                            pc80_codproc = {$codigo_preco}
                            and pc68_sequencial is not null
                            order by pc68_sequencial asc");


    $rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
    $criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
    $sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";


    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

    // echo $sSql;

    // db_criatabela($rsResult);

    $sSql = "select si01_datacotacao FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0";

    $rsResultData = db_query($sSql) or die(pg_last_error());

    $head3 = "Preço de Referência";
    $head5 = "Processo de Compra: $codigo_preco";
    $head8 = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao)));

    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

    $mPDF
        ->addInfo($head3, 2)
        ->addInfo($head5, 4)
        ->addInfo($head8, 7);

    ob_start();

    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatório</title>
        <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
        <style type="text/css">
            .content {
                width: 1070px;
            }

            .table {
                font-size: 10px;
                background: url("imagens/px_preto.jpg") repeat center;
                background-repeat: repeat-y;
                background-position: 0 50px;
                height: 30px;
            }

            .col-item {
                width: 45px;
            }

            .col-descricao_item {
                width: 650px;
            }

            .col-valor_un {
                width: 80px;
                padding-right: 5px;
            }

            .col-quant {
                width: 60px;
            }

            .col-un {
                width: 45px;
            }

            .col-total {
                width: 90px;
                padding-left: 5px;
            }

            .col-valor_total-text {
                width: 925px;
                padding-left: 5px;
            }

            .col-valor_total-valor {
                width: 120px;
                padding-right: 5px;
            }

            .row .col-un,
            .row .col-total,
            .row .col-quant,
            .row .col-valor_un,
            .row .col-valor_un {}

            .linha-vertical {
                border-top: 2px solid;
                text-align: center;
                margin-top: 80px;
                margin-left: 19%;
                width: 50%;
                line-height: 1.3em;
            }


            .item-menu {
                border: 1px solid #000000;
                text-align: center;
                font-weight: bold;
            }

            .item-text-descricao {
                border: 1px solid #000000;
                text-align: justify;
            }

            .item-text {
                border: 1px solid #000000;
                text-align: center;
            }

            .item-text-total {
                font-weight: bold;
            }

            .item-menu-color {
                background: #f5f5f0;
                font-weight: bold;
            }

            .item-total-color {
                background: #f5f5f0;
                font-weight: bold;
                width: 935px;
            }

            td
        </style>
    </head>

    <body>

        <?php
        $nTotalItens = 0;

        if (pg_num_rows($rsLotes) > 0) {

            for ($i = 0; $i < pg_num_rows($rsLotes); $i++) {
                $oLotes = db_utils::fieldsMemory($rsLotes, $i);

                $sSql = "select * from (SELECT
                pc01_codmater,
                pc01_descrmater||'. '||pc01_complmater as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant,
                pc69_seq,
                pc11_seq,
                pc11_reservado
from (
SELECT DISTINCT pc01_servico,
                pc11_codigo,
                pc11_seq,
                pc11_quant,
                pc11_prazo,
                pc11_pgto,
                pc11_resum,
                pc11_just,
                m61_abrev,
                m61_descr,
                pc17_quant,
                pc01_codmater,
                pc01_descrmater,pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq,
                pc11_reservado
FROM solicitem
INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
left join processocompraloteitem on
		pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
			pc68_sequencial = pc69_processocompralote
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
WHERE pc81_codproc = {$codigo_preco}
  AND pc68_sequencial = $oLotes->pc68_sequencial
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY
                pc01_codmater,
                pc11_seq,
                pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq,pc11_reservado ) as matquan join
(SELECT DISTINCT
                pc11_seq,
                {$tipoReferencia} as si02_vlprecoreferencia,
                                     case when pc80_criterioadjudicacao = 1 then
                     round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                     when pc80_criterioadjudicacao = 2 then
                     round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                     end as mediapercentual,
                pc01_codmater,
                si01_datacotacao,
                pc80_criterioadjudicacao,
                pc01_tabela,
                pc01_taxa,
                si01_justificativa
FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";
                //die($sSql);
                $rsResult = db_query($sSql) or die(pg_last_error());
                $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;
                // die($sSql);
                $rsResult = db_query($sSql) or die(pg_last_error());
                $oLinha = null;

                $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
                //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
                $sWhere .= " AND db03_instit = db02_instit ";
                $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

                $cl_docparag = new cl_db_docparag;

                $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
                $rs = $cl_docparag->sql_record($sAssinatura);
                $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


                $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
                //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
                $sWhere .= " AND db03_instit = db02_instit ";
                $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

                if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365

                    echo <<<HTML

    <table class="table">
        <tr class="">
            <td class="item-menu item-menu-color">{$oLotes->pc68_nome}</td>
        </tr>
        <tr class="">
            <td class="item-menu item-menu-color" style="width:50px">ITEM LOTE</td>
            <td class="item-menu item-menu-color">CODIGO</td>
            <td class="item-menu item-menu-color">DESCRIÇÃO DO ITEM</td>
            <td class="item-menu item-menu-color"><strong>TAXA/TABELA</strong></td>
            <td class="item-menu item-menu-color">VALOR UN</td>
            <td class="item-menu item-menu-color">QUANT</td>
            <td class="item-menu item-menu-color">UN</td>
            <td class="item-menu item-menu-color">TOTAL/VLR ESTIMADO</td>
        </tr>
HTML;
                } else {
                    echo <<<HTML
  <div class="table" autosize="1">
    <div class="tr bg_eb">
      <div class="th">{$oLotes->pc68_nome}</div>
    </div>
    <div class="tr bg_eb">
      <div class="th col-item align-center" style="width:55px">ITEM LOTE</div>
      <div class="th col-item align-center" style="width:49px">CODIGO</div>
      <div class="th col-descricao_item align-center" style="width:620px">DESCRIÇÃO DO ITEM</div>
      <div class="th col-valor_un align-center" style="margin-left:20px">VALOR UN</div>
      <div class="th col-quant align-center">QUANT</div>
      <div class="th col-un align-center">UN</div>
      <div class="th col-total align-center">TOTAL</div>
    </div>
HTML;
                }
        ?>
            <?php


                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                    $oResult = db_utils::fieldsMemory($rsResult, $iCont);

                    //    if($quant_casas){
                    $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;
                    //    }
                    // if($quant_casas == 2){
                    //    $lTotal = round($oResult->si02_vlprecoreferencia * $oResult->pc11_quant, 2);
                    // }
                    // else $lTotal = round($oResult->si02_vlprecoreferencia * $oResult->pc11_quant, 3);

                    $nTotalItens += $lTotal;
                    $oDadosDaLinha = new stdClass();
                    $oDadosDaLinha->seq = $iCont + 1;
                    $oDadosDaLinha->item = $oResult->pc01_codmater; //$oResult->pc11_seq;
                    $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
                    if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                        $oDadosDaLinha->valorUnitario = "-";
                        $oDadosDaLinha->quantidade = "-";
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = "-";
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    } else {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
                        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "-";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    }

                    if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                        echo <<<HTML
        <tr class="">
          <td class="item-text" style="width:55px">{$oDadosDaLinha->seq}</td>
          <td class="item-text">{$oDadosDaLinha->item}</td>
          <td class="item-text-descricao" >{$oDadosDaLinha->descricao}</td>
          <td class="item-text" >{$oDadosDaLinha->mediapercentual}</td>
          <td class="item-text">{$oDadosDaLinha->valorUnitario}</td>
          <td class="item-text">{$oDadosDaLinha->quantidade}</td>
          <td class="item-text">{$oDadosDaLinha->unidadeDeMedida}</td>
          <td class="item-text">{$oDadosDaLinha->total}</td>
        </tr>

HTML;
                    } else {
                        echo <<<HTML
         <div class="tr row">
          <div class="td col-item align-center" style="width:50px">
            {$oDadosDaLinha->seq}
          </div>
          <div class="td col-item align-center">
            {$oDadosDaLinha->item}
          </div>
          <div class="td col-descricao_item align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-valor_un align-center">
            R$ {$oDadosDaLinha->valorUnitario}
          </div>
          <div class="td col-quant align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-un align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-total align-center">
            R$ {$oDadosDaLinha->total}
          </div>
        </div>
HTML;
                    }
                }
            }
        } else {

            $sSql = "select * from (SELECT
                pc01_codmater,
                pc01_descrmater||'. '||pc01_complmater as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant,
                pc69_seq,
                pc11_seq
from (
SELECT DISTINCT pc01_servico,
                pc11_codigo,
                pc11_seq,
                pc11_quant,
                pc11_prazo,
                pc11_pgto,
                pc11_resum,
                pc11_just,
                m61_abrev,
                m61_descr,
                pc17_quant,
                pc01_codmater,
                pc01_descrmater,pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq
FROM solicitem
INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
left join processocompraloteitem on
		pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
			pc68_sequencial = pc69_processocompralote
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
WHERE pc81_codproc = {$codigo_preco}
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY
                pc01_codmater,
                pc11_seq,
                pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq ) as matquan join
(SELECT DISTINCT
                pc11_seq,
                {$tipoReferencia} as si02_vlprecoreferencia,
                                     case when pc80_criterioadjudicacao = 1 then
                     round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                     when pc80_criterioadjudicacao = 2 then
                     round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                     end as mediapercentual,
                pc01_codmater,
                si01_datacotacao,
                pc80_criterioadjudicacao,
                pc01_tabela,
                pc01_taxa,
                si01_justificativa
FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";
            //die($sSql);
            $rsResult = db_query($sSql) or die(pg_last_error());
            $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;

            if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365

                echo <<<HTML

    <table class="table">
        <tr class="">
            <td class="item-menu item-menu-color" style="width:50px">SEQ</td>
            <td class="item-menu item-menu-color">ITEM</td>
            <td class="item-menu item-menu-color">DESCRIÇÃO DO ITEM</td>
            <td class="item-menu item-menu-color"><strong>TAXA/TABELA</strong></td>
            <td class="item-menu item-menu-color">VALOR UN</td>
            <td class="item-menu item-menu-color">QUANT</td>
            <td class="item-menu item-menu-color">UN</td>
            <td class="item-menu item-menu-color">TOTAL/VLR ESTIMADO</td>
        </tr>
HTML;
            } else {
                echo <<<HTML
  <div class="table" autosize="1">
    <div class="tr bg_eb">
      <div class="th col-item align-center" style="width:49px">SEQ</div>
      <div class="th col-item align-center">ITEM</div>
      <div class="th col-descricao_item align-center">DESCRIÇÃO DO ITEM</div>
      <div class="th col-valor_un align-right">VALOR UN</div>
      <div class="th col-quant align-center">QUANT</div>
      <div class="th col-un align-center">UN</div>
      <div class="th col-total align-right">TOTAL</div>
    </div>
HTML;
            }
            ?>
        <?php


            for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                $oResult = db_utils::fieldsMemory($rsResult, $iCont);

                //    if($quant_casas){
                $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;
                //    }
                // if($quant_casas == 2){
                //    $lTotal = round($oResult->si02_vlprecoreferencia * $oResult->pc11_quant, 2);
                // }
                // else $lTotal = round($oResult->si02_vlprecoreferencia * $oResult->pc11_quant, 3);

                $nTotalItens += $lTotal;
                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->seq = $iCont + 1;
                $oDadosDaLinha->item = $oResult->pc01_codmater;
                $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
                if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                    $oDadosDaLinha->valorUnitario = "-";
                    $oDadosDaLinha->quantidade = "-";
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->mediapercentual = "";
                    } else {
                        $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = "-";
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                } else {
                    $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
                    $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->mediapercentual = "-";
                    } else {
                        $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                }

                if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                    echo <<<HTML
        <tr class="">
          <td class="item-text">{$oDadosDaLinha->seq}</td>
          <td class="item-text">{$oDadosDaLinha->item}</td>
          <td class="item-text-descricao">{$oDadosDaLinha->descricao}</td>
          <td class="item-text">{$oDadosDaLinha->mediapercentual}</td>
          <td class="item-text">{$oDadosDaLinha->valorUnitario}</td>
          <td class="item-text">{$oDadosDaLinha->quantidade}</td>
          <td class="item-text">{$oDadosDaLinha->unidadeDeMedida}</td>
          <td class="item-text">{$oDadosDaLinha->total}</td>
        </tr>

HTML;
                } else {
                    echo <<<HTML
         <div class="tr row">
          <div class="td col-item align-center">
            {$oDadosDaLinha->seq}
          </div>
          <div class="td col-item align-center">
            {$oDadosDaLinha->item}
          </div>
          <div class="td col-descricao_item align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-valor_un align-right">
            R$ {$oDadosDaLinha->valorUnitario}
          </div>
          <div class="td col-quant align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-un align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-total align-right">
            R$ {$oDadosDaLinha->total}
          </div>
        </div>
HTML;
                }
            }
        }
        ?>

        <div style="tr row">
            <div class="td item-total-color">
                VALOR TOTAL ESTIMADO
            </div>
            <div class="td item-menu-color">
                <?= "R$" . number_format($nTotalItens, 2, ",", ".") ?>
            </div>
        </div>
        <?php if ($oGet->impjust == 's') : ?>
            <div class="tr bg_eb">
                <div class="th col-valor_total-text align-left">
                    Justificativa
                </div>
            </div>
            <div class="tr">
                <div class="td">
                    <?= db_utils::fieldsMemory($rsResult, 0)->si01_justificativa; ?>
                </div>
            </div>
        <?php endif; ?>

        </table>
        </div>
        <?php

        $chars = array('ç', 'ã', 'â', 'à', 'á', 'é', 'è', 'ê', 'ó', 'ò', 'ô', 'ú', 'ù');
        $byChars = array('Ç', 'Ã', 'Â', 'À', 'Á', 'É', 'È', 'Ê', 'Ó', 'Ò', 'Ô', 'Ú', 'Ù');

        $dadosAssinatura = explode('\n', $sAssinaturaCotacao);
        $sCotacao = '';

        if (count($dadosAssinatura) > 1) {
            $sCotacao = '<div class="linha-vertical">';
            for ($count = 0; $count < count($dadosAssinatura); $count++) {
                $sCotacao .= "<strong>" . strtoupper(str_replace($chars, $byChars, $dadosAssinatura[$count])) . "</strong>";
                $sCotacao .= $count ? '' : "<br/>";
            }
            $sCotacao .= "</div>";
            echo <<<HTML
            $sCotacao
HTML;
        } else {
            echo <<<HTML
                <div class="linha-vertical">
                    <strong>{$dadosAssinatura[0]}</strong>
                </div>
HTML;
        }

        ?>


        <?php
        if ($oLinha != null || trim($oLinha) != "") {
            $dadosLinha = explode('\n', $oLinha);
            $stringHtml = '';

            if (count($dadosLinha) > 1) {
                $stringHtml = '<div class="linha-vertical">';
                for ($count = 0; $count < count($dadosLinha); $count++) {
                    $stringHtml .= "<strong>" . strtoupper(str_replace($chars, $byChars, $dadosLinha[$count])) . "</strong>";
                    $stringHtml .= $count ? '' : "<br/>";
                }
                $stringHtml .= "</div>";
                echo <<<HTML
            $stringHtml
HTML;
            } else {
                echo <<<HTML
                <div class="linha-vertical">
                    <strong>{$dadosLinha[0]}</strong>
                </div>
HTML;
            }
        }
        ?>

    </body>

    </html>

    <?php

    $html = ob_get_contents();

    ob_end_clean();
    $mPDF->WriteHTML(utf8_encode($html));
    $mPDF->Output();

    ?>