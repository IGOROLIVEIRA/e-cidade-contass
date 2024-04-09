<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("classes/db_bens_classe.php");
require_once("classes/db_bensbaix_classe.php");
require_once("classes/db_cfpatriplaca_classe.php");
require_once("classes/db_benscadcedente_classe.php");
require_once("classes/db_situabens_classe.php");

$clbenscadcedente = new cl_benscadcedente();
$clbens = new cl_bens;
$clbensbaix = new cl_bensbaix;
$clcfpatriplaca = new cl_cfpatriplaca;
$clsituabens = new cl_situabens;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$where = "";
if($codigoDepartamento){

    $where .= " AND t52_depart = $codigoDepartamento";

    $sqlDepartamento = "select descrdepto from db_depart where coddepto = ".$codigoDepartamento;
    $resultDepart = db_query($sqlDepartamento) or die(pg_last_error());
    $oResultDepart = db_utils::fieldsMemory($resultDepart, 0);
}

if($itipobens){
    $where .= " AND t24_sequencial = $itipobens";
}


$sqlTiposbens = "select t24_descricao from bemtipos where t24_sequencial = ".$itipobens;
$resultTipobens = db_query($sqlTiposbens) or die(pg_last_error());
$oResultTipos = db_utils::fieldsMemory($resultTipobens, 0);


$sql = "SELECT DISTINCT t52_bem AS codigo,
                        t52_ident AS placa,
                        t52_descr AS descricao,
                        t52_valaqu AS valoraquisicao,
                        (SELECT t58_valoratual
     FROM benshistoricocalculobem
     JOIN benshistoricocalculo ON t57_sequencial=t58_benshistoricocalculo
     WHERE t57_ano = $ano
         AND t58_bens = t52_bem
         AND t57_mes = $mes
     ORDER BY t58_sequencial DESC
     LIMIT 1)+t44_valorresidual AS valoratual,
                        t52_dtaqu AS dtaquisicao,
                        descrdepto AS departamento,
                        t33_divisao,
                        t30_descr AS divisao,
                        t64_descr as classificacao
        FROM bens
        JOIN bensdepreciacao ON t44_bens = t52_bem
        JOIN db_depart ON coddepto = t52_depart
        JOIN clabens ON t64_codcla=t52_codcla
        JOIN bemtipos ON t24_sequencial=t64_bemtipos
        JOIN benshistoricocalculobem ON t58_bens=t52_bem
        JOIN benshistoricocalculo ON t57_sequencial=t58_benshistoricocalculo
        AND t57_ano = $ano
        AND t57_mes = $mes
        LEFT JOIN bensdiv ON t33_bem=t52_bem
        LEFT JOIN departdiv ON t30_codigo=t33_divisao
        LEFT JOIN bensbaix ON t55_codbem=t52_bem and DATE_PART('MONTH',t55_baixa) = $mes and DATE_PART('YEAR',t55_baixa) = $ano
        AND t30_depto=t52_depart
        WHERE t52_instit = ".db_getsession('DB_instit')."
        $where
                     AND (
        EXTRACT(YEAR FROM t52_dtaqu) < $ano
        OR (
            EXTRACT(YEAR FROM t52_dtaqu) = $ano
            AND EXTRACT(MONTH FROM t52_dtaqu) <= $mes
        )
    )
        AND t52_bem NOT IN
        (SELECT t55_codbem
         FROM bensbaix
         WHERE EXTRACT(YEAR
                 FROM t55_baixa) < $ano
         OR (EXTRACT(YEAR
                     FROM t55_baixa) = $ano
             AND EXTRACT(MONTH
                         FROM t55_baixa) <= $mes))
        UNION
        SELECT DISTINCT t52_bem AS codigo,
                        t52_ident AS placa,
                        t52_descr AS descricao,
                        t52_valaqu AS valoraquisicao,
                        t44_valoratual+t44_valorresidual AS valoratual,
                        t52_dtaqu AS dtaquisicao,
                        descrdepto AS departamento,
                        t33_divisao,
                        t30_descr AS divisao,
                        t64_descr as classificacao
        FROM bens
        JOIN bensdepreciacao ON t44_bens = t52_bem
        JOIN db_depart ON coddepto = t52_depart
        JOIN clabens ON t64_codcla=t52_codcla
        JOIN bemtipos ON t24_sequencial=t64_bemtipos
        LEFT JOIN bensdiv ON t33_bem=t52_bem
        LEFT JOIN departdiv ON t30_codigo=t33_divisao
        LEFT JOIN bensbaix ON t55_codbem=t52_bem and DATE_PART('MONTH',t55_baixa) = $mes and DATE_PART('YEAR',t55_baixa) = $ano
        WHERE t52_instit = ".db_getsession('DB_instit')."
            $where
                     AND (
        EXTRACT(YEAR FROM t52_dtaqu) < $ano
        OR (
            EXTRACT(YEAR FROM t52_dtaqu) = $ano
            AND EXTRACT(MONTH FROM t52_dtaqu) <= $mes
        )
    )
            AND t52_bem NOT IN
        (SELECT t55_codbem
         FROM bensbaix
         WHERE EXTRACT(YEAR
                 FROM t55_baixa) < $ano
         OR (EXTRACT(YEAR
                     FROM t55_baixa) = $ano
             AND EXTRACT(MONTH
                         FROM t55_baixa) <= $mes))
            AND t52_bem NOT IN
        (SELECT t58_bens
         FROM benshistoricocalculobem
         JOIN benshistoricocalculo ON t57_sequencial=t58_benshistoricocalculo
         WHERE t58_bens= t52_bem
             AND t57_ano = $ano
             AND t57_mes = $mes)
             order by placa
";
$resultBens = db_query($sql);
$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 5;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 10);

$totalAtual = 0;
$totalAquisicao = 0;
$pdf->addpage();
$pdf->setfont('arial', 'b', 9);
$pdf->text(215, 10, 'Relatorio Bens Por Valor');
$pdf->text(215, 15, 'Mês:');
$pdf->setfont('arial', '', 9);
$pdf->text(223, 15, $mes);
$pdf->setfont('arial', 'b', 9);
$pdf->text(215, 20, 'Ano:');
$pdf->setfont('arial', '', 9);
$pdf->text(223, 20, $ano);
$pdf->SetFont('arial','B',9);
$pdf->cell(40   ,$alt  ,"Tipo do Bem:",1,0,"L",1);
$pdf->cell(240  ,$alt ,$oResultTipos->t24_descricao,1,1,"L",1);
if($oResultDepart->descrdepto){
    $pdf->cell(40   ,$alt  ,"Departamento:",1,0,"L",1);
    $pdf->cell(240  ,$alt ,$oResultDepart->descrdepto,1,1,"L",1);
}
$pdf->cell(12   ,$alt  ,"Código",1,0,"C",1);
$pdf->cell(12   ,$alt  ,"Placa",1,0,"C",1);
$pdf->cell(100  ,$alt ,"Descrição",1,0,"L",1);
$pdf->cell(25   ,$alt  ,"Data Aquisição",1,0,"C",1);
$pdf->cell(15   ,$alt  ,"Situação",1,0,"C",1);
$pdf->cell(25   ,$alt  ,"Vlr. Aquisição",1,0,"C",1);
$pdf->cell(20   ,$alt  ,"Vlr. Atual",1,0,"C",1);
$pdf->cell(71   ,$alt  ,"Classificação",1,1,"C",1);

$aDadosRelatoriogruppordivisao = array();
for ($iCont = 0; $iCont < pg_num_rows($resultBens); $iCont++) {

    $oResult = db_utils::fieldsMemory($resultBens, $iCont);
    $aDadosRelatoriogruppordivisao[$oResult->divisao][] = $oResult;
}

foreach ($aDadosRelatoriogruppordivisao as $key => $aDadosRelatorio) {
    $passouDiv[] = array($key);
    $descricaodisao = $key;

    if(!in_array($key,$passouDiv)){
        $pdf->SetFont('arial','B',9);
        if($descricaodisao){
            $pdf->cell(280, $alt, "Divisão: " . $descricaodisao , 1, 1, "L", 0);
        }else{
            $pdf->cell(280, $alt, "Divisão: Sem Divisão", 1, 1, "L", 0);
        }
    }
    $totalDivisaoAquisicao = 0;
    $totalDivisao = 0;
    foreach ($aDadosRelatorio as $oDados){

        if ($pdf->getY()  > $pdf->h - 45) {
            $pdf->addpage();
            $pdf->setfont('arial', 'b', 9);
            $pdf->text(215, 10, 'Relatorio Bens Por Valor');
            $pdf->text(215, 15, 'Mês:');
            $pdf->setfont('arial', '', 9);
            $pdf->text(223, 15, $mes);
            $pdf->setfont('arial', 'b', 9);
            $pdf->text(215, 20, 'Ano:');
            $pdf->setfont('arial', '', 9);
            $pdf->text(223, 20, $ano);
        }

        $rsSituacaobem = db_query("SELECT * FROM histbem JOIN situabens ON t70_situac=t56_situac WHERE t56_codbem = $oDados->codigo ORDER BY t56_histbem desc limit 1");
        $oResultSituacao = db_utils::fieldsMemory($rsSituacaobem, 0);
        $dtaquisicao = implode('/', array_reverse(explode('-', $oDados->dtaquisicao)));

        $pdf->SetFont('arial', '', 7);
        $pdf->cell(12, $alt, $oDados->codigo, 0, 0, "C", 0);
        $pdf->cell(12, $alt, $oDados->placa, 0, 0, "C", 0);
        $pdf->cell(100, $alt, substr($oDados->descricao,0,70), 0, 0, "L", 0);
        $pdf->cell(25, $alt, $dtaquisicao, 0, 0, "C", 0);
        $pdf->cell(15, $alt, $oResultSituacao->t70_descr, 0, 0, "C", 0);
        $pdf->cell(25, $alt, db_formatar($oDados->valoraquisicao,'f'), 0, 0, "C", 0);
        $pdf->cell(20, $alt, db_formatar($oDados->valoratual,'f'), 0, 0, "C", 0);
        $pdf->SetFont('arial', '', 6);
        $pdf->cell(71, $alt, $oDados->classificacao, 0, 1, "L", 0);
        $pdf->SetFont('arial', '', 7);
        $totalDivisao += $oDados->valoratual;
        $totalDivisaoAquisicao += $oDados->valoraquisicao;
        $totalAquisicao += $oDados->valoraquisicao;
        $totalAtual += $oDados->valoratual;
    }
    $pdf->SetFont('arial','B',9);
    $pdf->cell(168, $alt,"Total Divisão:", 0, 0, "L", 0);
    $pdf->cell(25, $alt,db_formatar($totalDivisaoAquisicao,'f'), 0, 0, "L", 0);
    $pdf->cell(20, $alt,db_formatar($totalDivisao,'f'), 0, 1, "L", 0);
    $pdf->SetFont('arial', '', 7);

}
$pdf->SetFont('arial','B',10);
$pdf->cell(40   ,$alt  ,"Total:",1,0,"C",1);
$pdf->SetFont('arial','B',9);
$pdf->cell(175, $alt, '', 1, 0, "R", 0);
$pdf->cell(35, $alt, db_formatar($totalAquisicao,'f'), 1, 0, "R", 0);
$pdf->cell(30, $alt, db_formatar($totalAtual,'f'), 1, 1, "R", 0);
$pdf->cell(260,$alt  ,"TOTAL GERAL DE REGISTROS: ".$iCont,0,0,"R",0);
$pdf->Output();
