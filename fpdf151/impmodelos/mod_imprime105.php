<?php
global $resparag, $resparagpadrao, $db61_texto, $db02_texto;

function definicaoValorUnitarioePercentual($pc80_criterioadjudicacao,$si02_tabela,$si02_taxa,&$valorUnitario,&$percentual)
{

    if($pc80_criterioadjudicacao == 1 && $si02_tabela == "t"){
        $valorUnitario = 0;
        $valorUnitario = $valorUnitario > 0 ? "R$ $valorUnitario" : "-";
        return true;
    }

    if($pc80_criterioadjudicacao == 1 && $si02_tabela == "f"){
        $percentual->mediapercentual = "-";
        return true;
    }

    if($pc80_criterioadjudicacao == 2 && $si02_taxa == "t"){
        $valorUnitario = 0;
        $valorUnitario = $valorUnitario > 0 ? "R$ $valorUnitario" : "-";
        return true;
    }

    if($pc80_criterioadjudicacao == 2 && $si02_taxa == "f"){
        $percentual = "-";
        return true;

    }
}

function preencherCelulas($objpdf, $oDadosDaLinha, $iContadorLinhasCriterios, $alt)
{
    $descricao = '';
    $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);

    $old_y = $objpdf->gety();

    $addalt =  $iContadorLinhasCriterios * 4;


    $objpdf->setfont('arial', '', 7);
    $objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
    $objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
    $objpdf->multicell(180, $alt, mb_strtoupper(str_replace("\n", "", $oDadosDaLinha->descricao)), "T", "J", 0);

    $objpdf->sety($old_y);
    $objpdf->setx(214);
    $objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
    $objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);
    $objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
    $objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
}

$dist = 4;

$this->objpdf->SetAutoPageBreak(false);
$this->objpdf->AliasNbPages();
$this->objpdf->AddPage('L');
$this->objpdf->settopmargin(1);
$this->objpdf->setleftmargin(4);
$pagina = 1;
$xlin = 20;
$xcol = 4;
$this->objpdf->sety(150);
$this->objpdf->SetFillColor(235, 235, 235);
$this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
$this->objpdf->setfillcolor(255);
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
$this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
$this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
$this->objpdf->text(230, $xlin - 6, $this->codpreco);
if ($this->pc80_tipoprocesso == 1) {
    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
    $this->objpdf->text(230, $xlin - 2, 'Por Item');
} else {
    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
    $this->objpdf->text(230, $xlin - 2, 'Por Lote');
}

if ($this->pc80_criterioadjudicacao == 1) {
    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
    $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
} else if ($this->pc80_criterioadjudicacao == 2) {
    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
    $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
} else {
    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
    $this->objpdf->text(230, $xlin + 2, 'Outros');
}


$this->objpdf->text(202, $xlin + 6, 'Data:');
$this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->Line(4, 27, 287, 27);


$this->objpdf->Setfont('Arial', 'BI', 9);
$this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
$this->objpdf->Setfont('Arial', 'BI', 9);
$this->objpdf->text(40, $xlin - 15, $this->prefeitura);
$this->objpdf->Setfont('Arial', 'I', 8);
$this->objpdf->text(40, $xlin - 11, $this->enderpref);
$this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
$this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
$this->objpdf->text(40, $xlin - 2, $this->emailpref);
$this->objpdf->text(40, $xlin + 1, $this->url);
$this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


$this->objpdf->sety($xlin + 15);
$alt = 4;

if (pg_num_rows($this->rsLotes) > 0) {
    $oLinha = null;
    $cabecalho = array();

    for ($i = 0; $i < pg_num_rows($this->rsLotes); $i++) {

        $oLotes = db_utils::fieldsMemory($this->rsLotes, $i);

        $sSql = "SELECT DISTINCT pc01_servico,
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
        si02_vltotalprecoreferencia,
        si02_tabela,
        si02_taxa,
        si02_mediapercentual,
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
        JOIN pcorcamjulg ON pc24_orcamforne=pc21_orcamforne
        LEFT JOIN solicitaprotprocesso ON pc90_solicita = pc10_numero
        LEFT JOIN processocompraloteitem ON pc69_pcprocitem = pcprocitem.pc81_codprocitem
        WHERE pc81_codproc={$this->codpreco} and pc69_processocompralote = $oLotes->pc68_sequencial
            AND pc24_pontuacao=1 order by pc11_seq;
        ";

        $rsResult = db_query($sSql) or die(pg_last_error());
        $oResult = db_utils::fieldsMemory($rsResult, 0);
        $linhas = ceil(strlen($oResult->pc01_descrmater) / 115);
        $addalt = $linhas * 4;
        if (($this->objpdf->gety() > $this->objpdf->h - 20) || $this->objpdf->gety() + $addalt > $this->objpdf->h - 20) {
            $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
            $this->objpdf->Setfont('Arial', '', 5);
            $this->objpdf->cell(285, $alt, "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
            $this->objpdf->Setfont('Arial', 'I', 6);
            $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
            $this->objpdf->Setfont('Arial', '', 7);
            $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
            $this->objpdf->SetAutoPageBreak(false);
            $this->objpdf->AliasNbPages();
            $this->objpdf->AddPage('L');
            $this->objpdf->settopmargin(1);
            $this->objpdf->setleftmargin(4);
            $pagina++;
            $xlin = 20;
            $xcol = 4;
            $this->objpdf->sety(150);
            $this->objpdf->SetFillColor(235, 235, 235);
            $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
            $this->objpdf->setfillcolor(255, 255, 255);
            $this->objpdf->Setfont('Arial', '', 7);
            $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
            $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
            $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
            $this->objpdf->text(230, $xlin - 6, $this->codpreco);
            if ($this->pc80_tipoprocesso == 1) {
                $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                $this->objpdf->text(230, $xlin - 2, 'Por Item');
            } else {
                $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                $this->objpdf->text(230, $xlin - 2, 'Por Lote');
            }

            if ($this->pc80_criterioadjudicacao == 1) {
                $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
            } else if ($this->pc80_criterioadjudicacao == 2) {
                $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
            } else {
                $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
                $this->objpdf->text(230, $xlin + 2, 'Outros');
            }


            $this->objpdf->text(202, $xlin + 6, 'Data:');
            $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
            $this->objpdf->Setfont('Arial', 'B', 7);
            $this->objpdf->Line(4, 27, 287, 27);


            $this->objpdf->Setfont('Arial', 'BI', 9);
            $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
            $this->objpdf->Setfont('Arial', 'BI', 9);
            $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
            $this->objpdf->Setfont('Arial', 'I', 8);
            $this->objpdf->text(40, $xlin - 11, $this->enderpref);
            $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
            $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
            $this->objpdf->text(40, $xlin - 2, $this->emailpref);
            $this->objpdf->text(40, $xlin + 1, $this->url);
            $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


            $this->objpdf->sety($xlin + 15);
            $alt = 4;
        }

        if (!isset($cabecalho[$oLotes->pc68_sequencial]) && pg_num_rows($rsResult) > 0) {

            if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {
                $this->objpdf->setfont('arial', 'B', 7);
                $this->objpdf->setfillcolor(235);
                $this->objpdf->cell(285, $alt, $oLotes->pc68_nome, 1, 1, "L", 1);
                $this->objpdf->setfont('arial', '', 7);
                $this->objpdf->cell(15, $alt, "SEQ", 1, 0, "C", 1);
                $this->objpdf->cell(15, $alt, "ITEM", 1, 0, "C", 1);
                $this->objpdf->cell(160, $alt, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
                $this->objpdf->cell(15, $alt, "UNIDADE", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "QUANTIDADE", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "UNITÁRIO", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "PERCENTUAL", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "VLR ESTIMADO", 1, 1, "C", 1);
                $this->objpdf->setfillcolor(255);
            } else {

                $this->objpdf->setfont('arial', 'B', 7);
                $this->objpdf->setfillcolor(235);
                $this->objpdf->cell(285, $alt, $oLotes->pc68_nome, 1, 1, "L", 1);
                $this->objpdf->setfont('arial', '', 7);
                $this->objpdf->cell(15, $alt, "SEQ", 1, 0, "C", 1);
                $this->objpdf->cell(15, $alt, "ITEM", 1, 0, "C", 1);
                $this->objpdf->cell(180, $alt, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
                $this->objpdf->cell(15, $alt, "UNIDADE", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "QUANTIDADE", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "UNITÁRIO", 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt, "TOTAL", 1, 1, "C", 1);
                $this->objpdf->setfillcolor(255);
            }
        }


        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oResult = db_utils::fieldsMemory($rsResult, $iCont);




            $oDadosDaLinha = new stdClass();
            $oDadosDaLinha->seq = $iCont + 1;
            $oDadosDaLinha->item = $oResult->pc01_codmater;
            if ($oResult->pc11_reservado == 't') {
                $oDadosDaLinha->descricao = '[ME/EPP] - ' . $oResult->pc01_descrmater;
            } else {
                $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
            }
            if ($oResult->si02_tabela == "t" || $oResult->si02_taxa == "t") {
                $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $this->quant_casas, ",", ".");
                $oDadosDaLinha->quantidade = $oResult->pc11_quant;

                $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";

                $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                $oResult->si02_vltotalprecoreferencia = $oResult->pc11_quant * $oResult->si02_vlprecoreferencia;
                $oDadosDaLinha->total = number_format($oResult->si02_vltotalprecoreferencia,2);
                $nTotalItens += $oResult->si02_vltotalprecoreferencia;
            } else {
                $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $this->quant_casas, ",", ".");
                $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                if ($oResult->mediapercentual == 0) {
                    $oDadosDaLinha->mediapercentual = "-";
                } else {
                    $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";
                }
                $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                $oResult->si02_vltotalprecoreferencia = $oResult->pc11_quant * $oResult->si02_vlprecoreferencia;
                $oDadosDaLinha->total = number_format($oResult->si02_vltotalprecoreferencia,2,",", ".");
                $nTotalItens += $oResult->si02_vltotalprecoreferencia;
            }
            if (($this->objpdf->gety() > $this->objpdf->h - 20) || $this->objpdf->gety() + $addalt > $this->objpdf->h) {

                $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
                $this->objpdf->Setfont('Arial', '', 5);
                $this->objpdf->cell(285, $alt, "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
                $this->objpdf->Setfont('Arial', 'I', 6);
                $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
                $this->objpdf->Setfont('Arial', '', 7);
                $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
                $this->objpdf->SetAutoPageBreak(false);
                $this->objpdf->AliasNbPages();
                $this->objpdf->AddPage('L');
                $this->objpdf->settopmargin(1);
                $this->objpdf->setleftmargin(4);
                $pagina++;
                $xlin = 20;
                $xcol = 4;
                $this->objpdf->sety(150);

                $this->objpdf->SetFillColor(235, 235, 235);
                $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
                $this->objpdf->setfillcolor(255, 255, 255);
                $this->objpdf->Setfont('Arial', '', 7);
                $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
                $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
                $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
                $this->objpdf->text(230, $xlin - 6, $this->codpreco);
                if ($this->pc80_tipoprocesso == 1) {
                    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                    $this->objpdf->text(230, $xlin - 2, 'Por Item');
                } else {
                    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                    $this->objpdf->text(230, $xlin - 2, 'Por Lote');
                }

                if ($this->pc80_criterioadjudicacao == 1) {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                    $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
                } else if ($this->pc80_criterioadjudicacao == 2) {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                    $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
                } else {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
                    $this->objpdf->text(230, $xlin + 2, 'Outros');
                }


                $this->objpdf->text(202, $xlin + 6, 'Data:');
                $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
                $this->objpdf->Setfont('Arial', 'B', 7);
                $this->objpdf->Line(4, 27, 287, 27);


                $this->objpdf->Setfont('Arial', 'BI', 9);
                $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
                $this->objpdf->Setfont('Arial', 'BI', 9);
                $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
                $this->objpdf->Setfont('Arial', 'I', 8);
                $this->objpdf->text(40, $xlin - 11, $this->enderpref);
                $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
                $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
                $this->objpdf->text(40, $xlin - 2, $this->emailpref);
                $this->objpdf->text(40, $xlin + 1, $this->url);
                $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


                $this->objpdf->sety($xlin + 15);
                $alt = 4;
            }

            if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {

                $descricao = '';
                $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);
                $addalt = $linhas * 4;
                $old_y = $this->objpdf->gety();

                $this->objpdf->setfont('arial', '', 7);
                $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
                $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
                $this->objpdf->multicell(140, $alt, mb_strtoupper($oDadosDaLinha->descricao), "T", "J", 0);

                $this->objpdf->sety($old_y);
                $this->objpdf->setx(194);
                $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);
                if ($oDadosDaLinha->valorUnitario > 0) {
                    $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
                } else {
                    $this->objpdf->cell(20, $alt + $addalt, " - ", 1, 0, "C", 1);
                }
                $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->mediapercentual, 1, 0, "C", 1);
                $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
            } else {

                $descricao = '';
                $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);
                $addalt = $linhas * 4;


                $old_y = $this->objpdf->gety();
                $this->objpdf->setfont('arial', '', 7);
                $this->objpdf->cell(15, $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
                $this->objpdf->cell(15, $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
                $this->objpdf->multicell(180, $alt, mb_strtoupper($oDadosDaLinha->descricao), "T", "J", 0);

                $this->objpdf->sety($old_y);
                $this->objpdf->setx(214);
                $this->objpdf->cell(15, $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
                $this->objpdf->cell(20, $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);
                $this->objpdf->cell(20, $addalt, "R$ " . $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
                $this->objpdf->cell(20, $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
            }
        }
        $cabecalho[$oLotes->pc68_sequencial] = $oLotes->pc68_sequencial;
    }
} else {


    if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {
        $this->objpdf->setfont('arial', 'B', 7);
        $this->objpdf->setfillcolor(235);
        $this->objpdf->cell(15, $alt, "SEQ", 1, 0, "C", 1);
        $this->objpdf->cell(15, $alt, "ITEM", 1, 0, "C", 1);
        $this->objpdf->cell(160, $alt, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
        $this->objpdf->cell(15, $alt, "UNIDADE", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "QUANTIDADE", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "UNITÁRIO", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "PERCENTUAL", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "VLR ESTIMADO", 1, 1, "C", 1);
        $this->objpdf->setfillcolor(255);
    } else {

        $this->objpdf->setfont('arial', 'B', 7);
        $this->objpdf->setfillcolor(235);
        $this->objpdf->cell(15, $alt, "SEQ", 1, 0, "C", 1);
        $this->objpdf->cell(15, $alt, "ITEM", 1, 0, "C", 1);
        $this->objpdf->cell(180, $alt, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
        $this->objpdf->cell(15, $alt, "UNIDADE", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "QUANTIDADE", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "UNITÁRIO", 1, 0, "C", 1);
        $this->objpdf->cell(20, $alt, "TOTAL", 1, 1, "C", 1);
        $this->objpdf->setfillcolor(255);
    }
    $quantLinhas = $this->quantLinhas;

    $sqencia = 0;
    for ($iCont = 0; $iCont < pg_num_rows($this->sqlitens); $iCont++) {

        $oResult = db_utils::fieldsMemory($this->sqlitens, $iCont);
        $sSql1 = "select m61_abrev from matunid where m61_codmatunid = $oResult->si02_codunidadeitem";
        $rsResult1 = db_query($sSql1) or die(pg_last_error());
        $oResult1 = db_utils::fieldsMemory($rsResult1, 0);

        $sSql2 = "select case when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
        else pc01_descrmater||'. '||pc01_complmater end as pc01_descrmater from pcmater where
        pc01_codmater = $oResult->si02_coditem";
        $rsResult2 = db_query($sSql2) or die(pg_last_error());
        $oResult2 = db_utils::fieldsMemory($rsResult2, 0);


        $oDadosDaLinha = new stdClass();

        $op = 1;

        for ($i = 0; $i < $quantLinhas; $i++) {

            if ($this->arrayValores[$i][0] == $oResult->si02_coditem) {
                $valorqtd = $this->arrayValores[$i][1];
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
            $quebraPagina = false;
            $oDadosDaLinha->seq = $sqencia + 1;
            $oDadosDaLinha->item = $oResult->si02_coditem;
            if ($controle == 1) {
                $oDadosDaLinha->descricao = '[ME/EPP] - ' . $oResult2->pc01_descrmater;
            } else {
                $oDadosDaLinha->descricao = $oResult2->pc01_descrmater;
            }
            if ($oResult->si02_tabela == "t" || $oResult->si02_taxa == "t") {
                $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $this->quant_casas, ",", ".");
                if($controle == 0 && $fazerloop==2){
                    $oDadosDaLinha->quantidade = $oResult->si02_qtditem - $valorqtd;
                }else if($controle == 1 && $fazerloop==2){
                    $oDadosDaLinha->quantidade = $valorqtd;
                }else{
                    $oDadosDaLinha->quantidade = $oResult->si02_qtditem;
                }
                $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";
                $oDadosDaLinha->unidadeDeMedida = $oResult1->m61_abrev;
                $oResult->si02_vltotalprecoreferencia = $oDadosDaLinha->quantidade * $oResult->si02_vlprecoreferencia;
                $oDadosDaLinha->total = number_format($oResult->si02_vltotalprecoreferencia,2,",", ".");
                $nTotalItens += $oResult->si02_vltotalprecoreferencia;
            } else {
                $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $this->quant_casas, ",", ".");
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
                $oResult->si02_vltotalprecoreferencia = $oDadosDaLinha->quantidade * $oResult->si02_vlprecoreferencia;
                $oDadosDaLinha->total = number_format($oResult->si02_vltotalprecoreferencia,2,",", ".");
                $nTotalItens += $oResult->si02_vltotalprecoreferencia;
            }

            $controle++;
            if ($oDadosDaLinha->quantidade === 0) {
                continue;
            }
            $sqencia++;
            $iContadorLinhasCriterios = 0;
            $iContadorLinhasCriterios = $this->objpdf->NbLines(180, mb_strtoupper(str_replace("\n", "", $oDadosDaLinha->descricao)));
            $y = ($iContadorLinhasCriterios * 4) + $this->objpdf->gety();
            $addalt = $y;
            $x = 1;

            if (($this->objpdf->gety() > $this->objpdf->h - 10) || ($y >  $this->objpdf->h - 10)) {
                if ($y >  $this->objpdf->h - 20) {
                    for ($x == 1; $iContadorLinhasCriterios > $x; $x++) {
                        if (($x * 4 + $this->objpdf->gety()) > $this->objpdf->h - 20) {
                            break;
                        }
                    }
                    $addalt =  $x * 4;
                    $descricao = substr($oDadosDaLinha->descricao, 0, $x * 180);
                    if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {


                        $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);
                        $descricao = substr($oDadosDaLinha->descricao, 0, $x * 115);
                        $old_y = $this->objpdf->gety();

                        $this->objpdf->setfont('arial', '', 7);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
                        $this->objpdf->multicell(160, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);

                        $this->objpdf->sety($old_y);
                        $this->objpdf->setx(194);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);

                        definicaoValorUnitarioePercentual($this->pc80_criterioadjudicacao,$oResult->si02_tabela,$oResult->si02_taxa,$oDadosDaLinha->valorUnitario,$oDadosDaLinha->mediapercentual);

                        $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->mediapercentual, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
                    } else {


                        $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);

                        $old_y = $this->objpdf->gety();

                        $descricao = substr($oDadosDaLinha->descricao, 0, $x * 115);

                        $this->objpdf->setfont('arial', '', 7);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
                        $this->objpdf->multicell(180, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);

                        $this->objpdf->sety($old_y);
                        $this->objpdf->setx(214);
                        $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
                    }
                }

                $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
                $this->objpdf->Setfont('Arial', '', 5);
                $this->objpdf->cell(285, $alt, $x . "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
                $this->objpdf->Setfont('Arial', 'I', 6);
                $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
                $this->objpdf->Setfont('Arial', '', 7);
                $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
                $this->objpdf->SetAutoPageBreak(false);
                $this->objpdf->AliasNbPages();
                $this->objpdf->AddPage('L');
                $this->objpdf->settopmargin(1);
                $this->objpdf->setleftmargin(4);
                $pagina++;
                $xlin = 20;
                $xcol = 4;
                $this->objpdf->sety(150);

                $this->objpdf->SetFillColor(235, 235, 235);
                $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
                $this->objpdf->setfillcolor(255, 255, 255);
                $this->objpdf->Setfont('Arial', '', 7);
                $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
                $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
                $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
                $this->objpdf->text(230, $xlin - 6, $this->codpreco);
                if ($this->pc80_tipoprocesso == 1) {
                    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                    $this->objpdf->text(230, $xlin - 2, 'Por Item');
                } else {
                    $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                    $this->objpdf->text(230, $xlin - 2, 'Por Lote');
                }

                if ($this->pc80_criterioadjudicacao == 1) {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                    $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
                } else if ($this->pc80_criterioadjudicacao == 2) {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                    $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
                } else {
                    $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
                    $this->objpdf->text(230, $xlin + 2, 'Outros');
                }


                $this->objpdf->text(202, $xlin + 6, 'Data:');
                $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
                $this->objpdf->Setfont('Arial', 'B', 7);
                $this->objpdf->Line(4, 27, 287, 27);


                $this->objpdf->Setfont('Arial', 'BI', 9);
                $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
                $this->objpdf->Setfont('Arial', 'BI', 9);
                $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
                $this->objpdf->Setfont('Arial', 'I', 8);
                $this->objpdf->text(40, $xlin - 11, $this->enderpref);
                $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
                $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
                $this->objpdf->text(40, $xlin - 2, $this->emailpref);
                $this->objpdf->text(40, $xlin + 1, $this->url);
                $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


                $this->objpdf->sety($xlin + 15);
                $alt = 4;

                if (($y >  $this->objpdf->h - 20 ) && ($iContadorLinhasCriterios != $x)) {

                    for ($z == 1; $iContadorLinhasCriterios > $z; $z++) {
                        if (($z * 4 + $this->objpdf->gety()) > $this->objpdf->h - 20) {
                            break;
                        }
                    }
                    $descricao = substr($oDadosDaLinha->descricao, $x * 115, strlen($oDadosDaLinha->descricao));
                    $addalt = ($iContadorLinhasCriterios - $x) * 4;

                    if($z < ($iContadorLinhasCriterios - $x)){
                        $descricao = substr($descricao, 0, $z*115);
                        $addalt = $z * 4;
                    }

                    if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {


                        $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);
                        $descricao = substr($oDadosDaLinha->descricao, $x * 115, strlen($oDadosDaLinha->descricao));
                        $old_y = $this->objpdf->gety();

                        $this->objpdf->setfont('arial', '', 7);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->multicell(160, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);

                        $this->objpdf->sety($old_y);
                        $this->objpdf->setx(194);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 1, "C", 1);
                    } else {

                        $old_y = $this->objpdf->gety();

                        $this->objpdf->setfont('arial', '', 7);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->multicell(180, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);

                        $this->objpdf->sety($old_y);
                        $this->objpdf->setx(214);
                        $this->objpdf->cell(15, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 0, "C", 1);
                        $this->objpdf->cell(20, $alt + $addalt, '', 1, 1, "C", 1);
                    }

                    if (($this->objpdf->gety() > $this->objpdf->h - 20)) {
                        $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
                        $this->objpdf->Setfont('Arial', '', 5);
                        $this->objpdf->cell(285, $alt, $x . "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
                        $this->objpdf->Setfont('Arial', 'I', 6);
                        $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
                        $this->objpdf->Setfont('Arial', '', 7);
                        $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
                        $this->objpdf->SetAutoPageBreak(false);
                        $this->objpdf->AliasNbPages();
                        $this->objpdf->AddPage('L');
                        $this->objpdf->settopmargin(1);
                        $this->objpdf->setleftmargin(4);
                        $pagina++;
                        $xlin = 20;
                        $xcol = 4;
                        $this->objpdf->sety(150);

                        $this->objpdf->SetFillColor(235, 235, 235);
                        $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
                        $this->objpdf->setfillcolor(255, 255, 255);
                        $this->objpdf->Setfont('Arial', '', 7);
                        $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
                        $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
                        $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
                        $this->objpdf->text(230, $xlin - 6, $this->codpreco);
                        if ($this->pc80_tipoprocesso == 1) {
                            $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                            $this->objpdf->text(230, $xlin - 2, 'Por Item');
                        } else {
                            $this->objpdf->text(202, $xlin - 2, 'Tipo:');
                            $this->objpdf->text(230, $xlin - 2, 'Por Lote');
                        }

                        if ($this->pc80_criterioadjudicacao == 1) {
                            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                            $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
                        } else if ($this->pc80_criterioadjudicacao == 2) {
                            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
                            $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
                        } else {
                            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
                            $this->objpdf->text(230, $xlin + 2, 'Outros');
                        }


                        $this->objpdf->text(202, $xlin + 6, 'Data:');
                        $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
                        $this->objpdf->Setfont('Arial', 'B', 7);
                        $this->objpdf->Line(4, 27, 287, 27);


                        $this->objpdf->Setfont('Arial', 'BI', 9);
                        $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
                        $this->objpdf->Setfont('Arial', 'BI', 9);
                        $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
                        $this->objpdf->Setfont('Arial', 'I', 8);
                        $this->objpdf->text(40, $xlin - 11, $this->enderpref);
                        $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
                        $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
                        $this->objpdf->text(40, $xlin - 2, $this->emailpref);
                        $this->objpdf->text(40, $xlin + 1, $this->url);
                        $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


                        $this->objpdf->sety($xlin + 15);
                        $alt = 4;
                    }
                }

            } else {

                if ($this->pc80_criterioadjudicacao == 2 || $this->pc80_criterioadjudicacao == 1) {

                    $descricao = '';
                    $linhas = ceil(strlen($oDadosDaLinha->descricao) / 115);

                    $old_y = $this->objpdf->gety();
                    $addalt =  $iContadorLinhasCriterios * 4;
                    $this->objpdf->setfont('arial', '', 7);
                    $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->seq, 1, 0, "C", 1);
                    $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->item, 1, 0, "C", 1);
                    $this->objpdf->multicell(160, $alt, mb_strtoupper(str_replace("\n", "", $oDadosDaLinha->descricao)), "T", "J", 0);

                    $this->objpdf->sety($old_y);
                    $this->objpdf->setx(194);
                    $this->objpdf->cell(15, $alt + $addalt, $oDadosDaLinha->unidadeDeMedida, 1, 0, "C", 1);
                    $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->quantidade, 1, 0, "C", 1);

                    definicaoValorUnitarioePercentual($this->pc80_criterioadjudicacao,$oResult->si02_tabela,$oResult->si02_taxa,$oDadosDaLinha->valorUnitario,$oDadosDaLinha->mediapercentual);

                    $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->valorUnitario, 1, 0, "C", 1);
                    $this->objpdf->cell(20, $alt + $addalt, $oDadosDaLinha->mediapercentual, 1, 0, "C", 1);
                    $this->objpdf->cell(20, $alt + $addalt, "R$ " . $oDadosDaLinha->total, 1, 1, "C", 1);
                } else {
                    preencherCelulas($this->objpdf, $oDadosDaLinha, $iContadorLinhasCriterios, $alt);
                }
            }
        }
    }

    if (($this->objpdf->gety() > $this->objpdf->h - 20)) {
        $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
        $this->objpdf->Setfont('Arial', '', 5);
        $this->objpdf->cell(285, $alt, "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
        $this->objpdf->Setfont('Arial', 'I', 6);
        $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
        $this->objpdf->Setfont('Arial', '', 7);
        $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
        $this->objpdf->SetAutoPageBreak(false);
        $this->objpdf->AliasNbPages();
        $this->objpdf->AddPage('L');
        $this->objpdf->settopmargin(1);
        $this->objpdf->setleftmargin(4);
        $pagina++;
        $xlin = 20;
        $xcol = 4;
        $this->objpdf->sety(150);

        $this->objpdf->SetFillColor(235, 235, 235);
        $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
        $this->objpdf->setfillcolor(255, 255, 255);
        $this->objpdf->Setfont('Arial', '', 7);
        $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
        $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
        $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
        $this->objpdf->text(230, $xlin - 6, $this->codpreco);
        if ($this->pc80_tipoprocesso == 1) {
            $this->objpdf->text(202, $xlin - 2, 'Tipo:');
            $this->objpdf->text(230, $xlin - 2, 'Por Item');
        } else {
            $this->objpdf->text(202, $xlin - 2, 'Tipo:');
            $this->objpdf->text(230, $xlin - 2, 'Por Lote');
        }

        if ($this->pc80_criterioadjudicacao == 1) {
            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
            $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
        } else if ($this->pc80_criterioadjudicacao == 2) {
            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
            $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
        } else {
            $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
            $this->objpdf->text(230, $xlin + 2, 'Outros');
        }


        $this->objpdf->text(202, $xlin + 6, 'Data:');
        $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
        $this->objpdf->Setfont('Arial', 'B', 7);
        $this->objpdf->Line(4, 27, 287, 27);


        $this->objpdf->Setfont('Arial', 'BI', 9);
        $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
        $this->objpdf->Setfont('Arial', 'BI', 9);
        $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
        $this->objpdf->Setfont('Arial', 'I', 8);
        $this->objpdf->text(40, $xlin - 11, $this->enderpref);
        $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
        $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
        $this->objpdf->text(40, $xlin - 2, $this->emailpref);
        $this->objpdf->text(40, $xlin + 1, $this->url);
        $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


        $this->objpdf->sety($xlin + 15);
        $alt = 4;
    }
}

if (($this->objpdf->gety() > $this->objpdf->h - 20) || $this->objpdf->gety() + $addalt > $this->objpdf->h)
{
    $this->objpdf->Line(4, $this->objpdf->gety(), 287, $this->objpdf->gety());
    $this->objpdf->Setfont('Arial', '', 5);
    $this->objpdf->cell(285, $alt, "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
    $this->objpdf->Setfont('Arial', 'I', 6);
    $this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
    $this->objpdf->Setfont('Arial', '', 7);
    $this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
    $this->objpdf->SetAutoPageBreak(false);
    $this->objpdf->AliasNbPages();
    $this->objpdf->AddPage('L');
    $this->objpdf->settopmargin(1);
    $this->objpdf->setleftmargin(4);
    $pagina++;
    $xlin = 20;
    $xcol = 4;
    $this->objpdf->sety(150);

    $this->objpdf->SetFillColor(235, 235, 235);
    $this->objpdf->Rect(200, $xlin - 16, $xcol + 85, 23, 'DF');
    $this->objpdf->setfillcolor(255, 255, 255);
    $this->objpdf->Setfont('Arial', '', 7);
    $this->objpdf->text(202, $xlin - 10, 'Preço de Referência:');
    $this->objpdf->text(230, $xlin - 10, $this->precoreferencia);
    $this->objpdf->text(202, $xlin - 6, 'Processo de Compra:');
    $this->objpdf->text(230, $xlin - 6, $this->codpreco);
    if ($this->pc80_tipoprocesso == 1) {
        $this->objpdf->text(202, $xlin - 2, 'Tipo:');
        $this->objpdf->text(230, $xlin - 2, 'Por Item');
    } else {
        $this->objpdf->text(202, $xlin - 2, 'Tipo:');
        $this->objpdf->text(230, $xlin - 2, 'Por Lote');
    }

    if ($this->pc80_criterioadjudicacao == 1) {
        $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
        $this->objpdf->text(230, $xlin + 2, 'Desconto sobre Tabela');
    } else if ($this->pc80_criterioadjudicacao == 2) {
        $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição');
        $this->objpdf->text(230, $xlin + 2, 'Menor Taxa ou percentual');
    } else {
        $this->objpdf->text(202, $xlin + 2, 'Critério de Adjudição:');
        $this->objpdf->text(230, $xlin + 2, 'Outros');
    }


    $this->objpdf->text(202, $xlin + 6, 'Data:');
    $this->objpdf->text(230, $xlin + 6, db_formatar($this->datacotacao, 'd'));
    $this->objpdf->Setfont('Arial', 'B', 7);
    $this->objpdf->Line(4, 27, 287, 27);


    $this->objpdf->Setfont('Arial', 'BI', 9);
    $this->objpdf->Image('imagens/files/' . $this->logo, 10, $xlin - 18, 22);
    $this->objpdf->Setfont('Arial', 'BI', 9);
    $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
    $this->objpdf->Setfont('Arial', 'I', 8);
    $this->objpdf->text(40, $xlin - 11, $this->enderpref);
    $this->objpdf->text(40, $xlin - 8, $this->municpref . " - MG");
    $this->objpdf->text(40, $xlin - 5, $this->telefpref . " - CNPJ:");
    $this->objpdf->text(40, $xlin - 2, $this->emailpref);
    $this->objpdf->text(40, $xlin + 1, $this->url);
    $this->objpdf->text(40, $xlin + 4, $this->inscricaoestadualinstituicao);


    $this->objpdf->sety($xlin + 15);
    $alt = 4;
}
$this->objpdf->setfont('arial', '', 7);
$this->objpdf->cell(265, $alt, "VALOR TOTAL ESTIMADO", 1, 0, "L", 1);
$this->objpdf->cell(20, $alt, "R$" . number_format($nTotalItens, 2, ",", "."), 1, 1, "C", 1);
if ($this->impjust == 't') {
    $this->objpdf->setfillcolor(235);
    $this->objpdf->Setfont('Arial', 'B', 7);
    $this->objpdf->cell(285, $alt, "JUSTIFICATIVA", 1, 1, "L", 1);
    $this->objpdf->setfillcolor(255);
    $this->objpdf->Setfont('Arial', '', 7);
    $old_y = $this->objpdf->gety();
    //$this->objpdf->sety($old_y);


    $this->objpdf->Rect(4, $old_y, 285, $this->objpdf->NbLines(285, mb_strtoupper(str_replace("\n", "", $oResult->si01_justificativa)))*4, 'DF','1234');
    $this->objpdf->multicell(285, $alt, mb_strtoupper(str_replace("\n", "", $oResult->si01_justificativa)), "T", "J", 0);
}
$sSql = "SELECT si01_datacotacao, si01_numcgmcotacao FROM precoreferencia WHERE si01_processocompra = {$this->codpreco}";
$rsResultData = db_query($sSql) or die(pg_last_error());

$queryCGM = "select z01_nome from cgm where z01_numcgm = " . db_utils::fieldsMemory($rsResultData, 0)->si01_numcgmcotacao;

$rsCGM = db_query($queryCGM) or die(pg_last_error());

$nomeResponsavel = db_utils::fieldsMemory($rsCGM, 0);

$chars = array('', '', '', '', '', '', '', '', '', '', '', '', '');
$byChars = array('', '', '', '', '', '', '', '', '', '', '', '', '');

$dadosAssinatura = explode('\n', $sAssinaturaCotacao);
$sCotacao = '';
$this->objpdf->setfont('arial', 'B', 7);

$this->objpdf->sety($this->objpdf->gety()+10);
$this->objpdf->Line(220, $this->objpdf->gety(), 80, $this->objpdf->gety());
$this->objpdf->cell(285, $alt, $nomeResponsavel->z01_nome, 0, 1, "C", 1);

if($this->sAssinaturaCotacao){
    $this->objpdf->sety($this->objpdf->gety()+10);
    $this->objpdf->Line(220, $this->objpdf->gety(), 80, $this->objpdf->gety());

}

$this->objpdf->cell(285, $alt, $this->sAssinaturaCotacao, 0, 0, "C", 1);

$this->objpdf->sety(200);
$this->objpdf->Setfont('Arial', '', 5);
$this->objpdf->cell(285, $alt, "Base: " . db_getsession("DB_base"), "T", 1, "L", 1);
$this->objpdf->Setfont('Arial', 'I', 6);
$this->objpdf->cell(265, $alt, "Processo de compras>Preço de Referência sic1_precoreferencia007.php Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data: " . date("d/m/Y H:i:s", db_getsession("DB_datausu")), 0, 0, "L", 1);
$this->objpdf->Cell(20, $alt, 'Pg ' . $this->objpdf->PageNo() . '/{nb}', 0, 1, 'R');
