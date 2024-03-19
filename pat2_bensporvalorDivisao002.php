<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("classes/db_bens_classe.php");
require_once("classes/db_bensbaix_classe.php");
require_once("classes/db_cfpatriplaca_classe.php");
require_once("classes/db_benscadcedente_classe.php");

$clbenscadcedente = new cl_benscadcedente();
$clbens = new cl_bens;
$clbensbaix = new cl_bensbaix;
$clcfpatriplaca = new cl_cfpatriplaca;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$where = "";

if($codigoDivisao){
    $where .= " AND t30_codigo = $codigoDivisao";
}

if($exibir){
    $where .= " AND t55_codbem IS NULL";
}

if($itipobens){
    $where .= " AND t24_sequencial = $itipobens";
}

if($ordenar){
    $order = "order by $ordenar";
}

$sqlDivisao = "select t30_descr from departdiv where t30_codigo = ".$codigoDivisao;
$resultDivisao = db_query($sqlDivisao) or die(pg_last_error());
$oResultDivisao = db_utils::fieldsMemory($resultDivisao, 0);


$sqlTiposbens = "select t24_descricao from bemtipos where t24_sequencial = ".$itipobens;
$resultTipobens = db_query($sqlTiposbens) or die(pg_last_error());
$oResultTipos = db_utils::fieldsMemory($resultTipobens, 0);


$sql = "
        SELECT DISTINCT t52_bem AS codigo,
                        t52_ident AS placa,
                        t52_descr AS descricao,
                        t52_obs AS observacao,
                        t52_valaqu AS valoraquisicao,
                        t58_valoratual+t44_valorresidual AS valoratual,
                        t52_dtaqu AS dtaquisicao,
                        descrdepto AS departamento,
                        t30_descr AS divisao,
                        t70_descr
        FROM bens
        JOIN bensdepreciacao ON t44_bens = t52_bem
        JOIN db_depart ON coddepto = t52_depart
        JOIN clabens ON t64_codcla=t52_codcla
        JOIN bemtipos ON t24_sequencial=t64_bemtipos
        JOIN histbem ON t56_codbem=t52_bem
        JOIN situabens ON t70_situac=t56_situac
        JOIN benshistoricocalculobem ON t58_bens=t52_bem
        JOIN benshistoricocalculo ON t57_sequencial=t58_benshistoricocalculo
        AND t57_ano = $ano
        AND t57_mes = $mes
        LEFT JOIN bensdiv ON t33_bem=t52_bem
        LEFT JOIN departdiv ON t30_codigo=t33_divisao
        LEFT JOIN bensbaix ON t55_codbem=t52_bem
        AND t30_depto=t52_depart
        WHERE t52_instit = ".db_getsession('DB_instit')."
        $where
        UNION
        SELECT DISTINCT t52_bem AS codigo,
                        t52_ident AS placa,
                        t52_descr AS descricao,
                        t52_obs AS observacao,
                        t52_valaqu AS valoraquisicao,
                        t44_valoratual+t44_valorresidual AS valoratual,
                        t52_dtaqu AS dtaquisicao,
                        descrdepto AS departamento,
                        t30_descr AS divisao,
                        t70_descr
        FROM bens
        JOIN bensdepreciacao ON t44_bens = t52_bem
        JOIN db_depart ON coddepto = t52_depart
        JOIN clabens ON t64_codcla=t52_codcla
        JOIN bemtipos ON t24_sequencial=t64_bemtipos
        JOIN histbem ON t56_codbem=t52_bem
        JOIN situabens ON t70_situac=t56_situac
        LEFT JOIN bensdiv ON t33_bem=t52_bem
        LEFT JOIN departdiv ON t30_codigo=t33_divisao
        LEFT JOIN bensbaix ON t55_codbem=t52_bem
        AND t30_depto=t52_depart
        WHERE t52_instit = ".db_getsession('DB_instit')."
            $where
            $order
";
$resultBens = db_query($sql);

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 5;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 10);

$contadorLinhas = 0;
$alt = 5;
$totalAtual = 0;
$totalAquisicao = 0;
$pdf->addpage();
$pdf->setfont('arial', 'b', 9);
$pdf->text(215, 10, 'Relatorio Bens Por Valor');
$pdf->text(215, 15, 'M�s:');
$pdf->setfont('arial', '', 9);
$pdf->text(223, 15, $mes);
$pdf->setfont('arial', 'b', 9);
$pdf->text(215, 20, 'Ano:');
$pdf->setfont('arial', '', 9);
$pdf->text(223, 20, $ano);
$pdf->SetFont('arial','B',9);
$pdf->cell(40 ,$alt  ,"Tipo do Bem:",1,0,"L",1);
$pdf->cell(240,$alt  ,$oResultTipos->t24_descricao,1,1,"L",1);
$pdf->cell(40 ,$alt  ,"Divis�o:",1,0,"L",1);
$pdf->cell(240,$alt  ,$oResultDivisao->t30_descr,1,1,"L",1);
$pdf->cell(20 ,$alt  ,"C�digo",1,0,"C",1);
$pdf->cell(20 ,$alt  ,"Placa",1,0,"C",1);
$pdf->cell(150,$alt  ,"Descri��o",1,0,"L",1);
$pdf->cell(25 ,$alt  ,"Data Aquisi��o",1,0,"C",1);
$pdf->cell(20 ,$alt  ,"Situa��o",1,0,"C",1);
$pdf->cell(25 ,$alt  ,"Vlr. Aquisi��o",1,0,"C",1);
$pdf->cell(20 ,$alt  ,"Vlr. Atual",1,1,"C",1);
$iTotalRegistros = 0;
for ($iCont = 0; $iCont < pg_num_rows($resultBens); $iCont++) {
    $oResult = db_utils::fieldsMemory($resultBens, $iCont);
    $descricao = $oResult->descricao.' '.$oResult->observacao;
    $old_y = $pdf->gety();
    $descricao = substr(str_replace("\n", "", $descricao), 0, 1000);
    $linhas = $pdf->NbLines(230, mb_strtoupper(str_replace("\n", "", $descricao)));
    $addalt = $linhas * 6;
    $dtaquisicao = implode('/',array_reverse(explode('-',$oResult->dtaquisicao)));
    $valoraquisicao = db_formatar($oResult->valoraquisicao,'f');
    $valoratual = db_formatar($oResult->valoratual,'f');
    if ($pdf->getY() > $pdf->h - 67) {
        $pdf->addpage();
        $pdf->setfont('arial', 'b', 9);
        $pdf->text(215, 10, 'Relatorio Bens Por Valor');
        $pdf->text(215, 15, 'M�s:');
        $pdf->setfont('arial', '', 9);
        $pdf->text(223, 15, $mes);
        $pdf->setfont('arial', 'b', 9);
        $pdf->text(215, 20, 'Ano:');
        $pdf->setfont('arial', '', 9);
        $pdf->text(223, 20, $ano);
        $pdf->SetFont('arial','B',9);
        $pdf->cell(40   ,$alt  ,"Tipo do Bem:",1,0,"L",1);
        $pdf->cell(240  ,$alt ,$oResultTipos->t24_descricao,1,1,"L",1);
        $pdf->cell(40   ,$alt  ,"Divis�o:",1,0,"L",1);
        $pdf->cell(240  ,$alt ,$oResultDivisao->t24_descricao,1,1,"L",1);
        $pdf->cell(20   ,$alt  ,"C�digo",1,0,"C",1);
        $pdf->cell(20   ,$alt  ,"Placa",1,0,"C",1);
        $pdf->cell(150  ,$alt ,"Descri��o",1,0,"L",1);
        $pdf->cell(25   ,$alt  ,"Data Aquisi��o",1,0,"C",1);
        $pdf->cell(20   ,$alt  ,"Situa��o",1,0,"C",1);
        $pdf->cell(25   ,$alt  ,"Vlr. Aquisi��o",1,0,"C",1);
        $pdf->cell(20   ,$alt  ,"Vlr. Atual",1,1,"C",1);
        $pdf->SetFont('arial','',9);
        $pdf->cell(20, $alt + $addalt, $oResult->codigo, 1, 0, "C", 0);
        $pdf->cell(20, $alt + $addalt, $oResult->placa, 1, 0, "C", 0);
        $pdf->SetFont('arial', '', 7);
        $pdf->multicell(150, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->sety(50);
        $pdf->setx(200);
        $pdf->cell(25, $alt + $addalt, $dtaquisicao, 1, 0, "C", 0);
        $pdf->cell(20, $alt + $addalt, $oResult->t70_descr, 1, 0, "C", 0);
        $pdf->cell(25, $alt + $addalt, $valoraquisicao, 1, 0, "R", 0);
        $pdf->cell(20, $alt + $addalt, $valoratual, 1, 1, "R", 0);
        $pdf->multicell(200, 0, '', "T", "J", 0);
    }else{
        $pdf->SetFont('arial', '', 9);
        $pdf->cell(20, $alt + $addalt, $oResult->codigo, 1, 0, "C", 0);
        $pdf->cell(20, $alt + $addalt, $oResult->placa, 1, 0, "C", 0);
        $pdf->SetFont('arial', '', 7);
        $pdf->multicell(150, $alt, mb_strtoupper(str_replace("\n", "", $descricao)), "T", "J", 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->sety($old_y+0.4);
        $pdf->setx(200);
        $pdf->cell(25, $alt + $addalt, $dtaquisicao, 1, 0, "C", 0);
        $pdf->cell(20, $alt + $addalt, $oResult->t70_descr, 1, 0, "C", 0);
        $pdf->cell(25, $alt + $addalt, $valoraquisicao, 1, 0, "R", 0);
        $pdf->cell(20, $alt + $addalt, $valoratual, 1, 1, "R", 0);
        $pdf->multicell(200, 0, '', "T", "J", 0);
    }

    $totalAquisicao += $oResult->valoraquisicao;
    $totalAtual += $oResult->valoratual;
    $iTotalRegistros += $iCont;

}
$pdf->SetFont('arial','B',10);
$pdf->cell(40   ,$alt  ,"Total:",1,0,"C",1);
$pdf->SetFont('arial','B',9);
$pdf->cell(195, $alt, '', 1, 0, "R", 0);
$pdf->cell(25, $alt, db_formatar($totalAquisicao,'f'), 1, 0, "R", 0);
$pdf->cell(20, $alt, db_formatar($totalAtual,'f'), 1, 1, "R", 0);
$pdf->cell(280,$alt  ,"TOTAL GERAL DE REGISTROS: ".$iTotalRegistros,0,0,"R",0);

$pdf->Output();
