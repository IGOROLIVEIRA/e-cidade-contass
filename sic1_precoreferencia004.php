    <?php
    require_once 'model/relatorios/Relatorio.php';
    include("classes/db_db_docparag_classe.php");
    include("classes/db_itemprecoreferencia_classe.php");
    require("libs/db_utils.php");
    $oGet = db_utils::postMemory($_GET);
    parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
    db_postmemory($HTTP_POST_VARS);
    $clitemprecoreferencia = new cl_itemprecoreferencia;
    //ini_set('display_errors', 'on');

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
                        from pcproc
                        join pcprocitem on pc80_codproc = pc81_codproc
                        left join processocompraloteitem on pc69_pcprocitem = pcprocitem.pc81_codprocitem
                        left join processocompralote on pc68_sequencial = pc69_processocompralote
                        where pc80_codproc = {$codigo_preco} and pc68_sequencial is not null
                        order by pc68_sequencial asc");

    $rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
    $criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
    $sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";
    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

    $sSql = "SELECT si01_datacotacao,
                    si01_numcgmcotacao
                    FROM precoreferencia
                WHERE si01_processocompra = {$codigo_preco}";
    $rsResultData = db_query($sSql) or die(pg_last_error());

    $head3 = "Preço de Referência";
    $head5 = "Processo de Compra: $codigo_preco";
    $head8 = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao)));

    $queryCGM = "select z01_nome from cgm where z01_numcgm = " . db_utils::fieldsMemory($rsResultData, 0)->si01_numcgmcotacao;

    $rsCGM = db_query($queryCGM) or die(pg_last_error());

    $nomeResponsavel = db_utils::fieldsMemory($rsCGM, 0);
    ob_start();

    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatório</title>
        <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
        <style type="text/css">
            .content {
                width: 1070px
            }

            .table {
                font-size: 10px;
                background: url(imagens/px_preto.jpg) repeat center;
                background-repeat: repeat-y;
                background-position: 0 50px;
                height: 30px
            }

            .col-item {
                width: 45px
            }

            .col-descricao_item {
                width: 650px
            }

            .col-valor_un {
                width: 80px;
                padding-right: 5px
            }

            .col-quant {
                width: 60px
            }

            .col-un {
                width: 45px
            }

            .col-total {
                width: 90px;
                padding-left: 5px
            }

            .col-valor_total-text {
                width: 925px;
                padding-left: 5px
            }

            .col-valor_total-valor {
                width: 120px;
                padding-right: 5px
            }

            .linha-vertical {
                border-top: 2px solid;
                text-align: center;
                margin-top: 80px;
                margin-left: 19%;
                width: 50%;
                line-height: 1.3em
            }

            .item-menu {
                border: 1px solid #000;
                text-align: center;
                font-weight: 700
            }

            .item-text-descricao {
                border: 1px solid #000;
                text-align: justify
            }

            .item-text {
                border: 1px solid #000;
                text-align: center
            }

            .item-text-total {
                font-weight: 700
            }

            .item-menu-color {
                background: #f5f5f0;
                font-weight: 700
            }

            .item-total-color {
                background: #f5f5f0;
                font-weight: 700;
                width: 935px
            }

            td
        </style>
    </head>

    <body>

        <?php
        $nTotalItens = 0;

        if (pg_num_rows($rsLotes) > 0) {
            $oLinha = null;
            $cabecalho = array();

            for ($i = 0; $i < pg_num_rows($rsLotes); $i++) {

                $oLotes = db_utils::fieldsMemory($rsLotes, $i);

                $sSql = "SELECT pc01_servico,
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
                CASE
                    WHEN pc01_complmater IS NOT NULL
                         AND pc01_complmater != pc01_descrmater THEN pc01_descrmater ||'. '|| pc01_complmater
                    ELSE pc01_descrmater
                END AS pc01_descrmater,
                pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq,
                pc11_reservado,
                si02_vlprecoreferencia,
                si01_justificativa
                FROM pcprocitem
                JOIN solicitem ON pc11_codigo=pc81_solicitem
                JOIN solicita ON pc10_numero = pc11_numero
                JOIN solicitempcmater ON pc16_solicitem=pc11_codigo
                JOIN solicitemunid ON pc17_codigo = pc11_codigo
                JOIN matunid ON pc17_unid = m61_codmatunid
                JOIN pcmater ON pc01_codmater = pc16_codmater
                JOIN pcorcamitemproc ON pc31_pcprocitem=pc81_codprocitem
                JOIN pcorcamitem ON pc22_orcamitem=pc31_orcamitem
                JOIN itemprecoreferencia ON si02_itemproccompra = pc22_orcamitem
                JOIN precoreferencia ON si02_precoreferencia = si01_sequencial
                JOIN pcorcamval ON pc23_orcamitem=pc22_orcamitem
                JOIN pcorcamforne ON pc21_orcamforne=pc23_orcamforne
                AND pc23_orcamitem=pc22_orcamitem
                JOIN pcorcamjulg ON pc24_orcamforne=pc21_orcamforne
                AND pc24_orcamitem=pc22_orcamitem
                LEFT JOIN solicitaprotprocesso ON pc90_solicita = pc10_numero
                LEFT JOIN processocompraloteitem ON pc69_pcprocitem = pcprocitem.pc81_codprocitem
                WHERE pc81_codproc={$codigo_preco} and pc69_processocompralote = $oLotes->pc68_sequencial
                    AND pc24_pontuacao=1 order by pc11_seq;
                ";

                $rsResult = db_query($sSql) or die(pg_last_error());

                $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;

                $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
                $sWhere .= " AND db03_instit = db02_instit ";
                $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

                $cl_docparag = new cl_db_docparag;

                $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
                $rs = $cl_docparag->sql_record($sAssinatura);
                $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;

                $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
                $sWhere .= " AND db03_instit = db02_instit ";
                $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');


                if (!isset($cabecalho[$oLotes->pc68_sequencial])) {

                    if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                        echo <<<HTML
                        <table class="table">
                            <tr class="">
                                <td class="item-menu item-menu-color">{$oLotes->pc68_nome}</td>
                            </tr>
                            <tr class="">
                                <td class="item-menu item-menu-color" style="width:50px">ITEM</td>
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
                            <div class="th col-item align-center"               style="width:55px">ITEM</div>
                            <div class="th col-item align-center"               style="width:40px">CODIGO</div>
                            <div class="th col-descricao_item align-center"     style="width:620px">DESCRIÇÃO DO ITEM</div>
                            <div class="th col-valor_un align-center"           style="margin-left:20px">VALOR UN</div>
                            <div class="th col-quant align-center">QUANT</div>
                            <div class="th col-un align-center">UN</div>
                            <div class="th col-total align-center">TOTAL</div>
                        </div>
HTML;
                    }
                }
        ?>
            <?php
                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                    $oResult = db_utils::fieldsMemory($rsResult, $iCont);

                    $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;

                    $nTotalItens += $lTotal;
                    $oDadosDaLinha = new stdClass();
                    $oDadosDaLinha->seq = $iCont + 1;
                    $oDadosDaLinha->item = $oResult->pc01_codmater;
                    if ($oResult->pc11_reservado == 't') {
                        $oDadosDaLinha->descricao = '<span style="font-weight: bold;">[ME/EPP]</span> - ' . $oResult->pc01_descrmater;
                    } else {
                        $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
                    }
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
                                <div class="td col-item align-center" style="width:40px">
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
                $cabecalho[$oLotes->pc68_sequencial] = $oLotes->pc68_sequencial;
            }
        } /*fim do if lotes*/ else {
            $sSql = "select *
                from
                itemprecoreferencia
                inner join precoreferencia on si01_sequencial = si02_precoreferencia
                where
                si02_precoreferencia = (
                select
                    si01_sequencial
                from
                    precoreferencia
                where
                    si01_processocompra = {$codigo_preco});";
            $rsResult = db_query($sSql) or die(pg_last_error());

            $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->si02_criterioadjudicacao;
            $codigoItem = db_utils::fieldsMemory($rsResult, 0)->si02_coditem;

            $sqlV = "select pc11_numero,
                            pc11_reservado,
                            pc11_quant,
                            pc16_codmater
                    from
                        pcproc
                    join pcprocitem on
                        pc80_codproc = pc81_codproc
                    join solicitem on
                        pc81_solicitem = pc11_codigo
                    join solicitempcmater on
                        pc11_codigo = pc16_solicitem
                    join pcmater on
                        pc16_codmater = pc01_codmater
                    where
                        pc80_codproc = {$codigo_preco}
                        and pc11_reservado = true;";

            $rsResultV = db_query($sqlV) or die(pg_last_error());
            $arrayValores = array();

            for ($j = 0; $j < pg_num_rows($rsResultV); $j++) {
                $valores = db_utils::fieldsMemory($rsResultV, $j);
                $arrayValores[$j][0] = $valores->pc16_codmater;
                $arrayValores[$j][1] = $valores->pc11_quant;
            }
            $quantLinhas = count($arrayValores);
            if ($codigoItem == "") {

                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
                    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                    $sSql = "select
                            pc23_quant,
                            pc11_reservado,
                            pc01_codmater,
                            pc01_tabela,
                            pc01_taxa,
                            m61_codmatunid,
                            pc80_criterioadjudicacao
                        from pcproc 
                        join pcprocitem on pc80_codproc = pc81_codproc
                        join solicitem on pc81_solicitem = pc11_codigo
                        join solicitempcmater on pc11_codigo = pc16_solicitem
                        join pcmater on pc16_codmater = pc01_codmater
                        join solicitemunid on pc11_codigo = pc17_codigo
                        join matunid on pc17_unid = m61_codmatunid
                        join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
                        join pcorcamitem on pc31_orcamitem = pc22_orcamitem
                        join pcorcamval on pc22_orcamitem = pc23_orcamitem
                        where pc23_orcamitem = $oResult->si02_itemproccompra
                            and (pc23_vlrun <> 0 or  pc23_percentualdesconto <> 0)
                        group by pc23_quant, pc31_pcprocitem, pc11_reservado, pc11_seq, pc01_codmater, pc01_tabela, pc01_taxa, m61_codmatunid, pc80_criterioadjudicacao;";
                    $rsResultee = db_query($sSql);
                    $resultado = db_utils::fieldsMemory($rsResultee, 0);

                    if ($resultado->pc11_reservado == "") {
                        $valor = "f";
                    } else {
                        $valor = $resultado->pc11_reservado;
                    }
                    $sql = " update itemprecoreferencia set ";
                    $sql .= "si02_coditem = " . $resultado->pc01_codmater;
                    $sql .= ",si02_qtditem = " . $resultado->pc23_quant;
                    $sql .= ",si02_codunidadeitem = " . $resultado->m61_codmatunid;
                    $sql .= ",si02_reservado = '" . $valor . "'";
                    $sql .= ",si02_tabela = '" . $resultado->pc01_tabela . "'";
                    $sql .= ",si02_taxa = '" . $resultado->pc01_taxa . "'";
                    $sql .= ",si02_criterioadjudicacao = " . $resultado->pc80_criterioadjudicacao;
                    $sql .= " where si02_sequencial = " . $oResult->si02_sequencial;

                    $rsResultado = db_query($sql);
                }
                $sSql = "select * from itemprecoreferencia inner join precoreferencia on si01_sequencial = si02_precoreferencia
                    where si02_precoreferencia = (select si01_sequencial from precoreferencia where si01_processocompra = {$codigo_preco});";
                $rsResult = db_query($sSql) or die(pg_last_error());
            }

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

            $sqencia = 0;
            for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                $sSql1 = "select
                            m61_abrev
                        from
                            matunid
                        where m61_codmatunid = $oResult->si02_codunidadeitem";
                $rsResult1 = db_query($sSql1) or die(pg_last_error());
                $oResult1 = db_utils::fieldsMemory($rsResult1, 0);

                $sSql2 = "select
                            case when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
                            else pc01_descrmater||'. '||pc01_complmater end as pc01_descrmater
                        from
                            pcmater
                        where
                            pc01_codmater = $oResult->si02_coditem";
                $rsResult2 = db_query($sSql2) or die(pg_last_error());
                $oResult2 = db_utils::fieldsMemory($rsResult2, 0);

                $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->si02_qtditem;

                $nTotalItens += $lTotal;
                $oDadosDaLinha = new stdClass();

                $op = 1;

                for ($i = 0; $i < $quantLinhas; $i++) {

                    if ($arrayValores[$i][0] == $oResult->si02_coditem) {
                        $valorqtd = $arrayValores[$i][1];
                        $op = 2;
                    }
                }
                if ($op == 1) {
                    $fazerloop = 1;
                } else {
                    $fazerloop = 2;
                }
                $controle = 0;
                while ($controle != $fazerloop) {
                    $oDadosDaLinha->seq = $sqencia + 1;
                    $oDadosDaLinha->item = $oResult->si02_coditem;
                    if ($controle == 1) {
                        $oDadosDaLinha->descricao = '<span style="font-weight: bold;">[ME/EPP]</span> - ' . $oResult2->pc01_descrmater;
                    } else {
                        $oDadosDaLinha->descricao = $oResult2->pc01_descrmater;
                    }
                    if ($oResult->si02_tabela == "t" || $oResult->si02_taxa == "t") {
                        $oDadosDaLinha->valorUnitario = "-";
                        $oDadosDaLinha->quantidade = "-";

                        if ($oResult->si02_mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = "-";
                        if ($controle == 1) {
                            $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * ($oResult->si02_qtditem - $valorqtd);
                        }
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    } else {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
                        if ($controle == 0 && $fazerloop == 2) {
                            $oDadosDaLinha->quantidade = $oResult->si02_qtditem - $valorqtd;
                        } else if ($controle == 1 && $fazerloop == 2) {
                            $oDadosDaLinha->quantidade = $valorqtd;
                        } else {
                            $oDadosDaLinha->quantidade = $oResult->si02_qtditem;
                        }

                        if ($oResult->si02_mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "-";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = $oResult1->m61_abrev;
                        if ($controle == 0 && $fazerloop == 2) {
                            $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * ($oResult->si02_qtditem - $valorqtd);
                        } else if ($controle == 1 && $fazerloop == 2) {
                            $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $valorqtd;
                        }
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    }

                    $controle++;
                    $sqencia++;

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
        }
        ?>

        <div style="tr row">
            <div class="td item-total-color">
                VALOR TOTAL ESTIMADO
            </div>
            <?php //echo $nTotalItens 
            ?>
            <div class="td item-menu-color">
                <?= "R$" . number_format($nTotalItens, 2, ",", ".") ?>
            </div>
        </div>
        <?php if ($oGet->impjust == 't') : ?>
            <div class="tr bg_eb">
                <div class="th col-valor_total-text align-left">
                    Justificativa
                </div>
            </div>
            <div class="tr">
                <div class="td">
                    <?= $oResult->si01_justificativa; ?>
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
                $sCotacao .= "<strong>" . strtoupper(str_replace($chars, $byChars, $nomeResponsavel->z01_nome)) . "</strong>";
                $sCotacao .= $count ? '' : "<br/>";
            }
            $sCotacao .= "</div>";
            echo <<<HTML
            $sCotacao
HTML;
        } else {
            echo <<<HTML
                <div class="linha-vertical">
                    <strong>{$nomeResponsavel->z01_nome}</strong>
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
    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

    $mPDF
        ->addInfo($head3, 2)
        ->addInfo($head5, 4)
        ->addInfo($head8, 7);
    $html = ob_get_contents();

    ob_end_clean();
    $mPDF->WriteHTML(utf8_encode($html));
    $mPDF->Output();

    ?>