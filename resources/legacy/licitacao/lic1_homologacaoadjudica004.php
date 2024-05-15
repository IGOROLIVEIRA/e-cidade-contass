    <?php
    require_once 'model/relatorios/Relatorio.php';
    include("classes/db_db_docparag_classe.php");
    include("classes/homologacaoadjudica_classe.php");
    include("libs/db_libdocumento.php");
    include("classes/db_liclicita_classe.php");
    include("classes/db_liccomissaocgm_classe.php");
    include("classes/db_db_config_classe.php");
    include("classes/db_db_documento_classe.php");
    include("lic1_relatorio_helper.php");


    $clhomologacaoadjudica = new cl_homologacaoadjudica();
    $clliclicita =  new cl_liclicita();
    $clliccomissaocgm     = new cl_liccomissaocgm();
    $cldb_config          = new cl_db_config();
    $cldb_documento          = new cl_db_documento();

    include("fpdf151/pdf.php");
    require("libs/db_utils.php");
    $oGet = db_utils::postMemory($_GET);
    parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
    db_postmemory($HTTP_POST_VARS);

    $result = $cldb_documento->sql_record($cldb_documento->sql_query("", "*", "", "db03_descr like 'HOMOLOGACAO RELATORIO'"));
    $result1 = db_utils::fieldsMemory($result, 0);


    $oPDF = new PDF();
    $oPDF->Open();
    $oPDF->AliasNbPages();
    $total = 0;
    $oPDF->setfillcolor(235);
    $oPDF->setfont('arial', 'b', 8);
    $oPDF->setfillcolor(235);
    $troca    = 1;
    $alt      = 4;
    $total    = 0;
    $p        = 0;
    $valortot = 0;
    $cor      = 0;
    $dbinstit = db_getsession("DB_instit");

    $oLibDocumento = new libdocumento($result1->db03_tipodoc, null);

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

    $sWhere  = " db02_descr like 'ADJUDICACAO RELATORIO' ";
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

    if ($nome == "") {
        $comissao = $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file(null, 'l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome, l31_tipo', null, "l31_licitacao=$codigo_preco"));
        for ($i = 0; $i < $clliccomissaocgm->numrows; $i++) {
            $comisaoRes = db_utils::fieldsMemory($comissao, $i);
            if ($comisaoRes->l31_tipo == 6) {
                $nome = $comisaoRes->z01_nome;
            }
        }
    }

    $nTotalItens = 0;

    if ($valor == "") {

        //$nTotalItens = 0;
        $campos = "DISTINCT pc01_codmater,pc01_descrmater,cgmforncedor.z01_nome,cgmforncedor.z01_cgccpf,m61_descr,pc11_quant,pc23_valor,pcorcamval.pc23_vlrun,l203_homologaadjudicacao,pc81_codprocitem,l04_descricao,pc11_seq";
        $sWhere = " liclicitem.l21_codliclicita = {$codigo_preco} and pc24_pontuacao = 1 AND itenshomologacao.l203_homologaadjudicacao = {$sequencial}";
        $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_comhomologacao(null, $campos, "pc11_seq,z01_nome", $sWhere));

        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
            $oResult = db_utils::fieldsMemory($result, $iCont);

            $nTotalItens += $oResult->pc23_valor;
        }
    }

    $resultLici = $clliclicita->sql_record($clliclicita->sql_query(null, "*", "", "l20_codigo = $codigo_preco"));
    $resultLici = db_utils::fieldsMemory($resultLici, 0);
    $tipojulgamento = $resultLici->l20_tipojulg;
    $oLibDocumento->l20_edital = $resultLici->l20_edital;
    $oLibDocumento->l44_descricao = strtoupper($resultLici->l44_descricao);
    $oLibDocumento->l20_anousu = $resultLici->l20_anousu;
    $oLibDocumento->l20_objeto = $resultLici->l20_objeto;
    $oLibDocumento->l03_descr = $resultLici->l03_descr;

    $oLibDocumento->l20_numero = $resultLici->l20_numero;
    $oLibDocumento->z01_nome = $nome;
    $sql1 = "select * from cgm where z01_nome like '$nome'";
    $rsResul12 = db_query($sql1);
    $resultcpf = db_utils::fieldsMemory($rsResul12, 0);
    $oLibDocumento->z01_cpf = $resultcpf->z01_cgccpf;

    $oLibDocumento->valor_total = db_formatar($nTotalItens,"f");

    $aParagrafos = $oLibDocumento->getDocParagrafos();

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

    $head3 = "Homologação";
    $head5 = "Sequencial: $codigo_preco";
    $head8 = "Data: " . $data;

    $mPDF = new Relatorio('', 'A4', 0, "", 7, 7, 50);

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
                border: 0px solid black !important;
            }

            .table .th {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .cabecalho1 {
                margin-left: 25%;
                margin-top: -100px !important;
            }

            .col-item {
                width: 45px;
            }

            .col-descricao_item {
                width: 210px;
            }

            .col-seq {
                width: 40px;
                padding-right: 5px;
            }

            .col-descricao-item-sem-percentual {
                width: 215px;
            }

            .col-descricao-item-layout-antigo {
                width: 250px;
            }

            .col-valor_un {
                width: 80px;
                padding-right: 5px;
            }

            .col-percentual {
                width: 80px;
                padding-right: 5px;
            }

            .col-seq-item-percentual {
                width: 45px;
            }

            .col-item-percentual {
                width: 45px;
            }

            .col-descricao-item-percentual {
                width: 235px;
            }

            .col-unidade-percentual {
                width: 40px;
                padding-right: 5px;
            }

            .col-marca-percentual {
                width: 40px;
                padding-right: 5px;
            }

            .col-quantidade-percentual {
                width: 65px;
            }

            .col-unitario-percentual {
                width: 40px;
                padding-right: 5px;
            }

            .col-percentual-percentual {
                width: 40px;
            }

            .col-total-percentual {
                width: 70px;
            }

            .col-geral-percentual {
                width: 45px;
            }

            .col-quant {
                width: 65px;
            }

            .col-un {
                width: 40px;
            }

            .col-total {
                width: 65px;
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
            .row .col-seq,
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
            }

            .total-background {
                background: #f5f5f0;
            }

            td
        </style>
    </head>

    <body>
        <h1 class="cabecalho1">HOMOLOGAÇÃO DE PROCESSO</h1>
        <br>
        <?php

        foreach ($aParagrafos as $oParag) {
            $texto = $oParag->oParag->db02_texto;
        }

        $textoP = explode("\n", $texto);
        for ($i = 0; $i < count($textoP); $i++) {
            echo "<strong>$textoP[$i]</strong>";
            echo "<br>";
        }
        ?>
        <?php
        $nTotalItens = 0;
        $lote = FALSE;
        $outros = FALSE;
        $mostra_homologado_geral = FALSE;
        $somaTotalHomologados = 0;

        $campos = "DISTINCT pc01_codmater,pc01_tabela,pc01_taxa,pc01_descrmater,pc01_complmater,cgmforncedor.z01_nome,cgmforncedor.z01_cgccpf,m61_descr,m61_abrev,pc11_quant,pc23_obs,pc23_valor,pcorcamval.pc23_vlrun,pcorcamval.pc23_percentualdesconto,pcorcamval.pc23_perctaxadesctabela,l203_homologaadjudicacao,pc81_codprocitem,l04_descricao,pc11_seq,l20_criterioadjudicacao,liclicitem.l21_ordem AS ordem";
        $sWhere = " liclicitem.l21_codliclicita = {$codigo_preco} and pc24_pontuacao = 1 AND itenshomologacao.l203_homologaadjudicacao = {$sequencial}";
        $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_comhomologacao(null, $campos, "pc11_seq,z01_nome", $sWhere));
        $array1 = array();
        $op = 0;
        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
            $oResult = db_utils::fieldsMemory($result, $iCont);
            $verifica = 0;
            if ($array1 == "") {
                $array1[$op][1] = $oResult->z01_cgccpf;
                $array1[$op][2] = $oResult->z01_nome;
                $array1[$op][3] = $oResult->l04_descricao;
                $op++;
            } else {
                for ($j = 0; $j < $op; $j++) {
                    if ($array1[$j][1] == $oResult->z01_cgccpf) {
                        $verifica = 1;
                    }
                }
                if ($verifica == 0) {
                    $array1[$op][1] = $oResult->z01_cgccpf;
                    $array1[$op][2] = $oResult->z01_nome;
                    $array1[$op][3] = $oResult->l04_descricao;
                    $op++;
                }
            }
        }
        for ($j = 0; $j < $op; $j++) {

            if (strlen($array1[$j][1]) == 14) {
                $bloco_1 = substr($array1[$j][1], 0, 2);
                $bloco_2 = substr($array1[$j][1], 2, 3);
                $bloco_3 = substr($array1[$j][1], 5, 3);
                $bloco_4 = substr($array1[$j][1], 8, 4);
                $digito_verificador = substr($array1[$j][1], -2);
                $cpf_cnpj_formatado = "CNPJ " . $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
            } else if (strlen($array1[$j][1]) == 11) {
                $bloco_1 = substr($array1[$j][1], 0, 3);
                $bloco_2 = substr($array1[$j][1], 3, 3);
                $bloco_3 = substr($array1[$j][1], 6, 3);
                $dig_verificador = substr($array1[$j][1], -2);
                $cpf_cnpj_formatado = "CPF " . $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
            }

        ?>
            <br>
            <?php
                $colspan = getColspan($tipojulgamento, $oResult->l20_criterioadjudicacao);
            ?>

            <div class="table" autosize="0">
                <div class="tr bg_eb">
                    <div class="th col-item align-left" style="width:600px"><?php echo  $array1[$j][2] . " - " . $cpf_cnpj_formatado ?></div>
                </div>
                <?php
                    if (isCriterioAdjucacaoOutrosTipoJulgamentoLote($tipojulgamento, $oResult->l20_criterioadjudicacao) ||
                        isCriterioAdjucacaoDescontoMenorTaxaPercTipoJulgamentoLote($tipojulgamento, $oResult->l20_criterioadjudicacao)
                    ) {
                        $lote = TRUE;
                        getCabecalhoTabelaLinhaLote($array1[$j][3], $colspan);
                    }

                    if (isCriterioAdjucacaoTipoJulgamentoCabecalhoSemPercentual($tipojulgamento, $oResult->l20_criterioadjudicacao)) {
                        $outros = TRUE;
                        $mostra_homologado_geral = TRUE;
                        getCabecalhoTabelaLayout();
                    } elseif (isCriterioAdjucacaoTipoJulgamentoCabecalhoComPercentual($tipojulgamento, $oResult->l20_criterioadjudicacao)) {
                        $outros = TRUE;
                        $mostra_homologado_geral = TRUE;
                        getCabecalhoTabelaLayoutComPercentual();
                    } elseif ($tipojulgamento != 3) {
                        getCabecalhoTabelaLayoutAntigo();
                    }
                ?>

                <?php
                $nTotalItens = 0;
                $valor = 0;
                $controle = 0;
                for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
                    $oDadosDaLinha = new stdClass();
                    $oResult = db_utils::fieldsMemory($result, $iCont);

                    if ($array1[$j][1] == $oResult->z01_cgccpf) {
                        $nTotalItens += $oResult->pc23_valor;
                        $valor += $oResult->pc23_valor;
                        $oDadosDaLinha = new stdClass();
                        $oDadosDaLinha->seq = $iCont + 1;
                        $oDadosDaLinha->item = $oResult->pc01_codmater;
                        $oDadosDaLinha->descricao = strtoupper($oResult->pc01_descrmater) . " " . strtoupper($oResult->pc01_complmater);
                        $oDadosDaLinha->unidadeDeMedida = strtoupper($oResult->m61_abrev);
                        $oDadosDaLinha->marca = $oResult->pc23_obs == "" ? "-" : strtoupper($oResult->pc23_obs);
                        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                        $oDadosDaLinha->valorUnitario = "R$" . number_format($oResult->pc23_vlrun, $oGet->quant_casas, ",", ".");
                        $oDadosDaLinha->total = number_format($oResult->pc23_valor, 2, ",", ".");

                        if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                            if ($oResult->pc01_tabela == "t") {
                                $oDadosDaLinha->percentual = $oResult->pc23_perctaxadesctabela . "%";
                            } else {
                                $oDadosDaLinha->percentual =  $oResult->pc23_percentualdesconto . "%";
                            }

                            $oDadosDaLinha->valorUnitario = '-';
                        } else {
                            $oDadosDaLinha->percentual = "-";
                        }

                        if (isCriterioAdjucacaoTipoJulgamentoCabecalhoSemPercentual($tipojulgamento, $oResult->l20_criterioadjudicacao)) {
                            getDadosTabelaLayout($oResult, $oDadosDaLinha);
                        } elseif (isCriterioAdjucacaoTipoJulgamentoCabecalhoComPercentual($tipojulgamento, $oResult->l20_criterioadjudicacao)) {
                            getDadosTabelaLayoutComPercentual($oResult, $oDadosDaLinha);
                        } else {
                            getDadosTabelaLayoutAntigo($oDadosDaLinha);
                        }
                    }
                }

                if ($mostra_homologado_geral) {
                    $somaTotalHomologados += $nTotalItens;
                    getTabelaLinhaTotalHomologado($nTotalItens, $colspan);
                } else {
                    getTabelaLinhaSemTotalHomologado($valor, $nTotalItens, $colspan);
                }
        }
            ?>

        <?php
            if ($mostra_homologado_geral) {
                getTabelaLinhaTotalGeral($somaTotalHomologados, $colspan);
            }
        ?>
            </div>
            <?php
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            $sSqlDataHomolacao = "select distinct l202_datahomologacao from homologacaoadjudica where l202_licitacao = {$codigo_preco} and l202_datahomologacao is not null";
            $rsDataHomolacao = db_query($sSqlDataHomolacao);
            db_fieldsmemory($rsDataHomolacao,0);
            $dataformatada = strftime('%d de %B de %Y',strtotime($l202_datahomologacao));


            $data = date('d/m/Y');
            $data = explode("/", $data);

            $anousu = date("Y", db_getsession("DB_datausu"));
            $mesusu = date("m", db_getsession("DB_datausu"));
            $diausu = date("d", db_getsession("DB_datausu"));

            switch ($mesusu) {
                case 1:
                    $mes = "Janeiro";
                    break;

                case 2:
                    $mes = "Fevereiro";
                    break;

                case 3:
                    $mes = "Março";
                    break;

                case 4:
                    $mes = "Abril";
                    break;

                case 5:
                    $mes = "Maio";
                    break;

                case 6:
                    $mes = "Junho";
                    break;

                case 7:
                    $mes = "Julho";
                    break;

                case 8:
                    $mes = "Agosto";
                    break;

                case 9:
                    $mes = "Setembro";
                    break;

                case 10:
                    $mes = "Outubro";
                    break;

                case 11:
                    $mes = "Novembro";
                    break;

                case 12:
                    $mes = "Dezembro";
                    break;
            }

            $resultado = $cldb_config->sql_record($cldb_config->sql_query_file(db_getsession('DB_instit')));
            $resultado = db_utils::fieldsMemory($resultado, 0);
            $teste = db_getsession("DB_datausu");

            ?>
            <br>
            <br>
            <div style="text-align: right;margin-right: 5px;">
                <? echo $resultado->munic; ?>, <? echo $dataformatada; ?>
            </div>
            <?php

            $chars = array('ç', 'ã', 'â', 'à', 'á', 'é', 'è', 'ê', 'ó', 'ò', 'ô', 'ú', 'ù');
            $byChars = array('Ç', 'Ã', 'Â', 'À', 'Á', 'É', 'È', 'Ê', 'Ó', 'Ò', 'Ô', 'Ú', 'Ù');

            $dadosAssinatura = explode('\n', $sAssinaturaCotacao);
            $sCotacao = '';

            //if (count($dadosAssinatura) > 1) {
            $sCotacao = '<div class="linha-vertical">';
            //for ($count = 0; $count < count($dadosAssinatura); $count++) {
            $sCotacao .= "<strong>" . strtoupper($nome) . "</strong>";
            //$sCotacao .= $count ? '' : "<br/>";
            //}
            $sCotacao .= "</div>";
            echo <<<HTML
            $sCotacao
HTML;


            ?>

    </body>

    </html>

    <?php

    $html = ob_get_contents();

    ob_end_clean();
    $mPDF->WriteHTML(utf8_encode($html));
    $mPDF->Output();

    ?>
