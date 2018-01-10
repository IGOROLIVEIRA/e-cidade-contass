<?php
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veicresp_classe.php");
include("classes/db_veicpatri_classe.php");
include("classes/db_veicretirada_classe.php");
include("classes/db_veicmanut_classe.php");
include("classes/db_veicabast_classe.php");
include("classes/db_veicbaixa_classe.php");
include("classes/db_veiculoscomb_classe.php");
include("classes/db_veicitensobrig_classe.php");
include("classes/db_veicutilizacao_classe.php");
include("classes/db_veicmanutitem_classe.php");

$clveiculos       = new cl_veiculos;
$clveicresp       = new cl_veicresp;
$clveicpatri      = new cl_veicpatri;
$clveicretirada   = new cl_veicretirada;
$clveicmanut      = new cl_veicmanut;
$clveicabast      = new cl_veicabast;
$clveicbaixa      = new cl_veicbaixa;
$clveiculoscomb   = new cl_veiculoscomb;
$clveicitensobrig = new cl_veicitensobrig;
$clveicutilizacao = new cl_veicutilizacao;
$clveicmanutitem  = new cl_veicmanutitem;

$clveiculos->rotulo->label();

db_postmemory($_GET);

$clrotulo = new rotulocampo;
$clrotulo->label('');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

if(($ve70_dataini)&&($ve70_datafin)){
    $datainicio = implode("/",(array_reverse(explode("-",$ve70_dataini))));
    $datafim = implode("/",(array_reverse(explode("-",$ve70_datafin))));
$head3 = "Relatorio de Manutenção Periodo: $datainicio a $datafim";
}else{
    $head3 = "Relatorio de Manutenção Periodo";
}

$where = "ve01_codigo in ($ve01_codigo)";
$descr_ve08="";
$descr_ve14="";
$campos="distinct on (ve01_codigo) *, ( select array_to_string(array_accum(distinct a.ve40_veiccadcentral||'-'||c.descrdepto),', ') from veiculos.veiccentral a inner join veiccadcentral b on b.ve36_sequencial = a.ve40_veiccadcentral inner join db_depart c on c.coddepto = b.ve36_coddepto where a.ve40_veiculos = veiculos.ve01_codigo ) as descr_central";
$result = $clveiculos->sql_record($clveiculos->sql_query_veiculo(null,$campos,null,$where));

if ($clveiculos->numrows == 0){
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$total = 0;
$p=0;
$iValormanutperido=0;
for($x = 0; $x < $clveiculos->numrows;$x++) {
    db_fieldsmemory($result, $x);
    $pdf->addpage("P");
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Código Veiculo :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $ve01_codigo, 0, 0, "L", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Placa :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $ve01_placa, 0, 1, "L", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Marca :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $ve01_veiccadmarca . "-" . $ve21_descr, 0, 0, "L", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Modelo :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $ve01_veiccadmodelo . "-" . $ve22_descr, 0, 1, "L", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Central:', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $descr_central, 0, 1, "L", 0);
    $pdf->cell(0, $alt, '', 'T', 1, "R", 0);

    $result_baixa = $clveicbaixa->sql_record($clveicbaixa->sql_query(null, "*", null, "ve04_veiculo=$veiculo and ve01_ativo='0'"));

    if ($clveicbaixa->numrows > 0) {
        db_fieldsmemory($result_baixa, 0);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(30, $alt, 'Data da Baixa :', 0, 0, "R", 0);
        $pdf->setfont('arial', '', 7);
        $pdf->cell(60, $alt, db_formatar($ve04_data, "d"), 0, 0, "L", 0);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(30, $alt, 'Hora da Baixa :', 0, 0, "R", 0);
        $pdf->setfont('arial', '', 7);
        $pdf->cell(60, $alt, $ve04_hora, 0, 1, "L", 0);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(30, $alt, 'Motivo :', 0, 0, "R", 0);
        $pdf->setfont('arial', '', 7);
        $pdf->multicell(0, $alt, $ve04_motivo, 0, "L", 0);
    } else {
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(0, $alt, 'VEICULO NÃO BAIXADO', 0, 1, "L", 0);
    }
    $pdf->cell(0, $alt, '', 'T', 1, "R", 0);
    $pdf->setfont('arial', 'b', 8);

    /*MANUTENÇÃO*/

    $pdf->ln();
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(90, $alt, 'MANUTENÇÕES :', 0, 1, "L", 0);


    $sCamposVeicmanut = " distinct ve62_codigo,ve28_descr,ve62_dtmanut,ve62_hora";
    $sCamposVeicmanut .= ",case when (ve62_vlrpecas is null or ve62_vlrpecas = 0) and ve62_tipogasto in (6,7,8) then ve62_valor else ve62_vlrpecas end as ve62_vlrpecas ";
    $sCamposVeicmanut .= ",case when (ve62_vlrmobra is null or ve62_vlrmobra = 0) and ve62_tipogasto in (9) then ve62_valor else ve62_vlrmobra end as ve62_vlrmobra ";
    $sCamposVeicmanut .= ",ve62_medida,ve62_valor ";
    $sOrdemVeicmanut = " ve62_dtmanut,ve62_codigo ";
    $sWhereVeucmanut = "ve62_veiculos= $ve01_codigo";
    if($ve70_dataini){
        $sWhereVeucmanut.=" and ve62_dtmanut >= '$ve70_dataini'";
    }
    if($ve70_datafin){
        $sWhereVeucmanut.=" and ve62_dtmanut <= '$ve70_datafin'";
    }
    $sSqlVeicmanut = $clveicmanut->sql_query_info(null, $sCamposVeicmanut, $sOrdemVeicmanut,$sWhereVeucmanut);
    $result_manut = $clveicmanut->sql_record($sSqlVeicmanut);
    $numrows_manut = $clveicmanut->numrows;

    $aManutencao = array();

    if ($numrows_manut > 0) {

        for ($w = 0; $w < $numrows_manut; $w++) {

            $oManutencao = db_utils::fieldsMemory($result_manut, $w);
                $sCamposManutitem = " ve63_veicmanut, ve63_descr, ve63_quant, ve63_vlruni, ve64_pcmater ";
                $sWhereManutitem = " ve62_veiculos = {$ve01_codigo}  and ve63_veicmanut = {$oManutencao->ve62_codigo} ";
                $sSqlManutitem = $clveicmanutitem->sql_query_ItensManutencao(null, $sCamposManutitem, "", $sWhereManutitem);
                $rsManutitem = $clveicmanutitem->sql_record($sSqlManutitem);
                $iNumRownsManutitem = $clveicmanutitem->numrows;
                $aItensMant = array();

                if ($iNumRownsManutitem > 0) {

                    for ($i = 0; $i < $iNumRownsManutitem; $i++) {
                        $oItensMant = db_utils::fieldsMemory($rsManutitem, $i);
                        $aItensMant[] = $oItensMant;
                    }
                    $oManutencao->lItens = true;
                    $oManutencao->aItens = $aItensMant;

                } else {
                    $oManutencao->lItens = false;
                }
            $aManutencao[] = $oManutencao;
        }
    }

    /*
     *                                                 COMEÇA IMPRESÃO
     */
    // -> Imprime Manutenções
    if (count($aManutencao) > 0) {

        $troca = 1;
        $p = 0;
        $total_manut = 0;
        $nValorPeca = 0;
        $nValorMaoObra = 0;
        $nValorTotal = 0;
        $nValormanut = 0;

        if ($pdf->gety() > $pdf->h - 30) {

            if ($troca == 0) {
                $pdf->addpage("P");
            }
        }

        for ($ind = 0; $ind < count($aManutencao); $ind++) {

            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("P");
            }

            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(15, $alt, "Manut.", 1, 0, "C", 1);
            $pdf->cell(85, $alt, "Tipo de Serviço", 1, 0, "C", 1);
            $pdf->cell(25, $alt, "Data", 1, 0, "C", 1);
            $pdf->cell(25, $alt, "Hora", 1, 0, "C", 1);
            $pdf->cell(25, $alt, "Medida", 1, 1, "C", 1);

            $pdf->setfont('arial', '', 7);
            $pdf->cell(15, $alt, $aManutencao[$ind]->ve62_codigo, 0, 0, "C", $p);
            $pdf->cell(85, $alt, $aManutencao[$ind]->ve28_descr, 0, 0, "L", $p);
            $pdf->cell(25, $alt, db_formatar($aManutencao[$ind]->ve62_dtmanut, "d"), 0, 0, "C", $p);
            $pdf->cell(25, $alt, $aManutencao[$ind]->ve62_hora, 0, 0, "C", $p);
            $pdf->cell(25, $alt, $aManutencao[$ind]->ve62_medida . " " . $ve07_sigla, 0, 1, "C", $p);


            // -> Imprime Itens de Manutenção

                if ($pdf->gety() > $pdf->h - 30) {
                    $pdf->addpage("P");
                }

                if ($aManutencao[$ind]->lItens == true) {

                    $iTotalItens = 0;
                    $iValormanut = 0;


                    for ($iItens = 0; $iItens < count($aManutencao[$ind]->aItens); $iItens++) {
                        if ($aManutencao[$ind]->lItens == true) {
                            $iValormanut = $iValormanut + $aManutencao[$ind]->aItens[$iItens]->ve63_vlruni * $aManutencao[$ind]->aItens[$iItens]->ve63_quant;
                            if ($pdf->gety() > $pdf->h - 30) {

                                $pdf->addpage("P");
                                $pdf->setfont('arial', 'b', 8);
                                $pdf->cell(15, $alt, "", 0, 0, "C", $p);
                                $pdf->cell(15, $alt, "Item.", 0, 0, "C", $p);
                                $pdf->cell(85, $alt, "Descrição do Item", 0, 0, "C", $p);
                                $pdf->cell(20, $alt, "Quantidade", 0, 0, "C", $p);
                                $pdf->cell(40, $alt, "Valor Item", 0, 1, "C", $p);

                            }

                            if ($iItens == 0) {

                                $pdf->setfont('arial', 'b', 8);
                                $pdf->cell(15, $alt, "", 0, 0, "C", $p);
                                $pdf->cell(15, $alt, "Item.", 1, 0, "C", $p);
                                $pdf->cell(85, $alt, "Descrição do Item", 1, 0, "C", $p);
                                $pdf->cell(20, $alt, "Quantidade", 1, 0, "C", $p);
                                $pdf->cell(40, $alt, "Valor Item", 1, 1, "C", $p);
                            }
                        }

                        $pdf->setfont('arial', '', 7);
                        $pdf->cell(15, $alt, "", 0, 0, "C", $p);
                        $pdf->cell(15, $alt, $aManutencao[$ind]->aItens[$iItens]->ve64_pcmater, 0, 0, "C", $p);
                        $pdf->cell(85, $alt, $aManutencao[$ind]->aItens[$iItens]->ve63_descr, 0, 0, "L", $p);
                        $pdf->cell(20, $alt, $aManutencao[$ind]->aItens[$iItens]->ve63_quant, 0, 0, "C", $p);
                        $pdf->cell(40, $alt, db_formatar($aManutencao[$ind]->aItens[$iItens]->ve63_vlruni, "f"), 0, 1, "R", $p);
                        $iTotalItens++;

                    }
                    $iValormanutperido += $iValormanut;
                    $pdf->setfont('arial', 'b', 10);
                    $pdf->cell(150, $alt, "Total:", 'T', 0, "R", $p, 0);
                    $pdf->cell(25, $alt, db_formatar($iValormanut, "f"), 1, 0, "L", $p, 0);
                    $pdf->ln(5);

                }
            $pdf->ln();
            $total_manut++;
        }
        $pdf->setfont('arial', 'b', 10);
        $pdf->cell(150, $alt, "Valor total das manutenções no periodo:", 'T', 0, "R", $p, 0);
        $pdf->cell(25, $alt, db_formatar($iValormanutperido, "f"), 1, 0, "L", $p, 0);
        $pdf->ln(5);
        $pdf->ln();
        $pdf->ln();

    } else {
        $pdf->cell(0, $alt, "Não Existem Itens ", "T", 1, "L", 0);
    }
}
$pdf->Output();

