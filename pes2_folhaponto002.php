<?php
//include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("dbforms/db_funcoes.php");
include("fpdf151/pdf.php");

$anoControle = array();
$aDias     = array();
$aConsulta = array();
$where    = "";
$andwhere = " AND ";

$anof = "";
$mesf = "";

$hora1 = "";
$hora2 = "";
$hora3 = "";
$hora4 = "";

$periodo1 = "";
$periodo2 = "";
$dia1     = "";
$dia2     = "";
$mes1     = "";
$mes2     = "";
$ano1     = "";
$ano2     = "";
$dt1      = "";
$dt2      = "";

$tipo     = "";
$head3    = "PERÍODO: ";
$head4    = "";

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);
// print_r($aFiltros);
// exit;
try {

    $anof = $aFiltros['anof'];
    $mesf = $aFiltros['mesf'];

    if (isset($aFiltros['hora1']) && !empty($aFiltros['hora1'])) {
        $hora1 = $aFiltros['hora1'];
        $hora2 = $aFiltros['hora2'];
        $hora3 = $aFiltros['hora3'];
        $hora4 = $aFiltros['hora4'];
    }

    if (isset($aFiltros['periodo1']) && !empty($aFiltros['periodo1'])) {
        $periodo1 = $aFiltros['periodo1'];
        $data1 = explode("/", $periodo1);
        $dia1  = $data1[0];
        $mes1  = $data1[1];
        $ano1  = $data1[2];

        $head3 .= $periodo1 . " à ";
    }
    if (isset($aFiltros['periodo2']) && !empty($aFiltros['periodo2'])) {
        $periodo2 = $aFiltros['periodo2'];
        $data2 = explode("/", $periodo2);
        $dia2  = $data2[0];
        $mes2  = $data2[1];
        $ano2  = $data2[2];

        $head3 .= $periodo2;
    }

    $dt1 = implode("-", array_reverse(explode("/", $periodo1)));
    $dt2 = implode("-", array_reverse(explode("/", $periodo2)));

    if (isset($aFiltros['tipo']) && !empty($aFiltros['tipo']) && $aFiltros['tipo'] == "m") {

        // Se for escolhida alguma matrícula

        if (isset($aFiltros['rei']) && !empty($aFiltros['rei']) && isset($aFiltros['ref']) && !empty($aFiltros['ref'])) {
            $rei = $aFiltros['rei'];
            $ref = $aFiltros['ref'];
            // Se for por intervalos e vier matrícula inicial e final
            $where .= $andwhere . " rh01_regist between " . $rei . " and " . $ref;
            $head4 .= "MATRÍCULAS";
            $head4 .= " DE " . $rei . " A " . $ref;
        } else if (isset($aFiltros['rei']) && !empty($aFiltros['rei'])) {
            // Se for por intervalos e vier somente matrícula inicial
            $rei = $aFiltros['rei'];
            $where .= $andwhere . " rh01_regist >= " . $rei;
            $head4 .= "MATRÍCULAS";
            $head4 .= " SUPERIORES A " . $rei;
        } else if (isset($aFiltros['ref']) && !empty($aFiltros['ref'])) {
            // Se for por intervalos e vier somente matrícula final
            $ref = $aFiltros['ref'];
            $where .= $andwhere . " rh01_regist <= " . $ref;
            $head4 .= "MATRÍCULAS";
            $head4 .= " INFERIORES A " . $ref;
        } else if (isset($aFiltros['fre']) && !empty($aFiltros['fre'])) {
            // Se for por selecionados
            $fre = $aFiltros['fre'];
            $where .= $andwhere . " rh01_regist in (" . $fre . ") ";
            $head4 .= "MATRÍCULAS";
            $head4 .= " SELECIONADAS";
        }
    } else if (isset($aFiltros['tipo']) && !empty($aFiltros['tipo']) && $aFiltros['tipo'] == "l") {
        // Se for escolhida alguma lotação

        if (isset($aFiltros['lti']) && !empty($aFiltros['lti']) && isset($aFiltros['ltf']) && !empty($aFiltros['ltf'])) {
            // Se for por intervalos e vier lotação inicial e final
            $lti = $aFiltros['lti'];
            $ltf = $aFiltros['ltf'];

            $where .= $andwhere . " r70_estrut between '" . $lti . "' and '" . $ltf . "' ";
            $head4 .= "LOTAÇÕES";
            $head4 .= " DE " . $lti . " A " . $ltf;
        } else if (isset($aFiltros['lti']) && !empty($aFiltros['lti'])) {
            // Se for por intervalos e vier somente lotação inicial
            $lti = $aFiltros['lti'];
            $where .= $andwhere . " r70_estrut >= '" . $lti . "' ";
            $head4 .= "LOTAÇÕES";
            $head4 .= " SUPERIORES A " . $lti;
        } else if (isset($aFiltros['ltf']) && !empty($aFiltros['ltf'])) {
            // Se for por intervalos e vier somente lotação final
            $ltf = $aFiltros['ltf'];
            $where .= $andwhere . " r70_estrut <= '" . $ltf . "' ";
            $head4 .= "LOTAÇÕES";
            $head4 .= " INFERIORES A " . $ltf;
        } else if (isset($aFiltros['flt']) && !empty($aFiltros['flt'])) {
            // Se for por selecionados
            $flt = $aFiltros['flt'];
            $where .= $andwhere . " r70_estrut in ('" . str_replace(",", "','", $flt) . "') ";
            $head4 .= " SELECIONADAS";
        }
    } else if (isset($aFiltros['tipo']) && !empty($aFiltros['tipo']) && $aFiltros['tipo'] == "t") {
        // Se for escolhido algum local de trabalho

        if (isset($aFiltros['lci']) && !empty($aFiltros['lci']) && isset($aFiltros['lcf']) && !empty($aFiltros['lcf'])) {
            // Se for por intervalos e vier local inicial e final
            $lci = $aFiltros['lci'];
            $lcf = $aFiltros['lcf'];
            $where .= $andwhere . " rh55_estrut between '" . $lci . "' and '" . $lcf . "' ";
            $head4   .= "LOCAIS DE TRABALHO";
            $head4 .= " DE " . $lci . " A " . $lcf;
        } else if (isset($aFiltros['lci']) && !empty($aFiltros['lci'])) {
            // Se for por intervalos e vier somente local inicial
            $lci = $aFiltros['lci'];
            $where .= $andwhere . " rh55_estrut >= '" . $lci . "' ";
            $head4   .= "LOCAIS DE TRABALHO";
            $head4 .= " SUPERIORES A " . $lci;
        } else if (isset($aFiltros['lcf']) && !empty($aFiltros['lcf'])) {
            // Se for por intervalos e vier somente local final
            $lcf = $aFiltros['lcf'];
            $where .= $andwhere . " rh55_estrut <= '" . $lcf . "' ";
            $head4   .= "LOCAIS DE TRABALHO";
            $head4 .= " INFERIORES A " . $lcf;
        } else if (isset($aFiltros['flc']) && !empty($aFiltros['flc'])) {
            // Se for por selecionados
            $flc = $aFiltros['flc'];
            $where .= $andwhere . " rh55_estrut in ('" . str_replace(",", "','", $flc) . "') ";
            $head4 .= " SELECIONADOS";
        }
    } else if (isset($aFiltros['tipo']) && !empty($aFiltros['tipo']) && $aFiltros['tipo'] == "o") {
        // Se for escolhido algum órgão

        if (isset($aFiltros['ori']) && !empty($aFiltros['ori']) && isset($aFiltros['orf']) && !empty($aFiltros['orf'])) {
            // Se for por intervalos e vier órgão inicial e final
            $ori = $aFiltros['ori'];
            $orf = $aFiltros['orf'];
            $where .= $andwhere . " o40_orgao between " . $ori . " and " . $orf;
            $head4 .= "ÓRGÃOS";
            $head4 .= " DE " . $ori . " A " . $orf;
        } else if (isset($aFiltros['ori']) && !empty($aFiltros['ori'])) {
            // Se for por intervalos e vier somente órgão inicial
            $ori = $aFiltros['ori'];
            $where .= $andwhere . " o40_orgao >= " . $ori;
            $head4 .= "ÓRGÃOS";
            $head4 .= " SUPERIORES A " . $ori;
        } else if (isset($aFiltros['orf']) && !empty($aFiltros['orf'])) {
            // Se for por intervalos e vier somente órgão final
            $orf = $aFiltros['orf'];
            $where .= $andwhere . " o40_orgao <= " . $orf;
            $head4 .= "ÓRGÃOS";
            $head4 .= " INFERIORES A " . $orf;
        } else if (isset($aFiltros['for']) && !empty($aFiltros['for'])) {
            // Se for por selecionados
            $orf = $aFiltros['orf'];
            $where .= $andwhere . " o40_orgao in (" . $for . ") ";
            $head4 .= " SELECIONADOS";
        }
    }


    /*Preenchendo as datas*/
    if ($mes1 == $mes2) {
        for ($i = $dia1; $i <= $dia2; $i++) {
            if ($i < 10) {
                $i *= 1;
                $aDias[$i] = "0" . $i . "/" . $mes1;
            } else {
                $aDias[$i] = $i . "/" . $mes1;
            }
            $anoControle[$i] = $ano1;
        }
    } else {
        $nDias1 = cal_days_in_month(CAL_GREGORIAN, $mes1, $ano1);
        if ($ano2 > $ano1) {
            $nDias2 = cal_days_in_month(CAL_GREGORIAN, $mes2, $ano2);
        } else {
            $nDias2 = cal_days_in_month(CAL_GREGORIAN, $mes2, $ano1);
        }
        $indice = $nDias1 - $dia1;

        for ($i = $dia1, $j = 0; $i <= $nDias1 && $j <= $indice; $i++, $j++) {
            if ($i < 10) {
                $i *= 1;
                $aDias[$j] = "0" . $i . "/" . $mes1;
            } else {
                $aDias[$j] = $i . "/" . $mes1;
            }
            $anoControle[$j] = $ano1;
        }

        for ($i = 1, $j = $indice + 1; $i <= $dia2; $i++, $j++) {
            if ($i < 10) {
                $i *= 1;
                $aDias[$j] = "0" . $i . "/" . $mes2;
            } else {
                $aDias[$j] = $i . "/" . $mes2;
            }
            $anoControle[$j] = $ano2;
        }
    }

    /* FIM - Preenchendo as datas*/

    $sSQL = "
    SELECT DISTINCT rh01_regist,
                z01_nome,
                rh37_funcao,
                rh37_descr,
                r70_codigo,
                r70_estrut,
                r70_descr,
                rh02_hrsmen,
                o40_orgao,
                o40_descr,
                rh01_instit
    FROM
        (SELECT rh01_regist,
                z01_nome,
                r70_codigo,
                r70_estrut,
                r70_descr,
                rh37_funcao,
                rh37_descr,
                rh02_hrsmen,
                o40_orgao,
                o40_descr,
                rh01_instit
         FROM rhpessoal
         INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
             AND rhpessoalmov.rh02_anousu = {$anof}
             AND rhpessoalmov.rh02_mesusu = {$mesf}
             AND rhpessoalmov.rh02_instit = " . db_getsession('DB_instit') . "
         LEFT JOIN rhpeslocaltrab ON rhpeslocaltrab.rh56_seqpes = rhpessoalmov.rh02_seqpes
            AND rhpeslocaltrab.rh56_princ = 't'
         LEFT JOIN rhlocaltrab ON rhlocaltrab.rh55_codigo = rhpeslocaltrab.rh56_localtrab
            AND rhlocaltrab.rh55_instit = rhpessoalmov.rh02_instit
         LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
         LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
            AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
         INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
         INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
            AND rhfuncao.rh37_instit = 1
         INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
            AND rhlota.r70_instit = rhpessoalmov.rh02_instit
         INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
         LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
            AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
        LEFT JOIN orcunidade ON orcunidade.o41_anousu = rhlotaexe.rh26_anousu
            AND orcunidade.o41_orgao = rhlotaexe.rh26_orgao
            AND orcunidade.o41_unidade = rhlotaexe.rh26_unidade
        LEFT JOIN orcorgao ON orcorgao.o40_anousu = orcunidade.o41_anousu
            AND orcorgao.o40_orgao = orcunidade.o41_orgao
         LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
            AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
            AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
         LEFT JOIN orcprojativ ON orcprojativ.o55_anousu = rhpessoalmov.rh02_anousu
            AND orcprojativ.o55_projativ = rhlotavinc.rh25_projativ
         LEFT JOIN orctiporec ON orctiporec.o15_codigo = rhlotavinc.rh25_recurso
         LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
         LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
             AND rhpespadrao.rh03_anousu = {$anof}
             AND rhpespadrao.rh03_mesusu = {$mesf}
         LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
             AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
             AND padroes.r02_regime = rhpespadrao.rh03_regime
             AND padroes.r02_codigo = rhpespadrao.rh03_padrao
             AND padroes.r02_instit = " . db_getsession('DB_instit') . "
         WHERE rhpessoalmov.rh02_anousu = {$anof}
             AND rhpessoalmov.rh02_mesusu = {$mesf}
             AND rh05_seqpes IS NULL ) AS x
        WHERE rh01_instit = " . db_getsession('DB_instit') . " {$where}
    ORDER BY rh01_regist
  ";

    $rsConsulta = db_query($sSQL);
    $numrows_dados = pg_numrows($aConsulta);

    $aConsulta = db_utils::getCollectionByRecord($rsConsulta);
    //echo '<pre>';print_r($anoControle);print_r($aDias);die;

    if ($aConsulta === false) {
        throw new Exception("Não foi possível realizar consulta!");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$head2 = "FOLHA DE PONTO";
$alt = 4;
$pdf->SetAutoPageBreak('on', 0);
$pdf->line(2, 148.5, 208, 148.5);

//query responsável por retornar os feriados municipais 
$query_feriados = 
"select r62_calend, r62_data from calendf where r62_calend = 1 order by r62_data ";

//realiza a consulta
$feriadosMunicipais = db_query($query_feriados);

//retorna os registros da consulta
$_feriados =  db_utils::getCollectionByRecord($feriadosMunicipais);

$dataFeriado = array();

foreach($_feriados as $feriado){
    $e = explode("-",$feriado->r62_data);
    $dataFeriado[] = $e[2].'/'.$e[1];
}

#Adiciona os feriados nacionais ao array
array_push($dataFeriado, '01/01', '07/04', '21/04', '01/05', '07/09', '12/10', '02/11', '15/11', '25/12');

foreach ($aConsulta as $servidor) {
    $pdf->addpage();

    $pdf->setfont("arial", "B", 10);
    $pdf->cell(25, $alt, "Funcionário", "0", 0, "L", 0);
    $pdf->cell(1, $alt, ":", "0", 0, "L", 0);
    $pdf->setfont("arial", "", 10);
    $pdf->cell(15, $alt, " " . $servidor->rh01_regist, "0", 0, "L", 0);
    $pdf->cell(35, $alt, $servidor->z01_nome, "0", 0, "L", 0);

    if ($mostrarLotacao == "true"){
        $pdf->ln();
        $pdf->setfont("arial", "B", 10);
        $pdf->cell(25, $alt, "Lotação", "0", 0, "L", 0);
        $pdf->cell(1, $alt, ":", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(15, $alt, " " . $servidor->r70_estrut, "0", 0, "L", 0);
        $pdf->cell(35, $alt, $servidor->r70_descr, "0", 0, "L", 0);
    }

    $pdf->ln();
    $pdf->setfont("arial", "B", 10);
    $pdf->cell(25, $alt, "Secretaria", "0", 0, "L", 0);
    $pdf->cell(1, $alt, ":", "0", 0, "L", 0);
    $pdf->setfont("arial", "", 10);
    $pdf->cell(15, $alt, " " . $servidor->o40_orgao, "0", 0, "L", 0);
    $pdf->cell(35, $alt, $servidor->o40_descr, "0", 0, "L", 0);

    $pdf->ln();
    $pdf->setfont("arial", "B", 10);
    $pdf->cell(25, $alt, "Cargo", "0", 0, "L", 0);
    $pdf->cell(1, $alt, ":", "0", 0, "L", 0);
    $pdf->setfont("arial", "", 10);
    $pdf->cell(15, $alt, " " . $servidor->rh37_funcao, "0", 0, "L", 0);
    $pdf->cell(35, $alt, $servidor->rh37_descr, "0", 0, "L", 0);

    if ($mostrarJornada == "true") {
        $pdf->ln();
        $pdf->setfont("arial", "B", 10);
        $pdf->cell(25, $alt, "Horário Ent:", "0", 0, "L", 0);
        $pdf->cell(1, $alt, ":", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(12, $alt, " " . $hora1, "0", 0, "L", 0);

        $pdf->setfont("arial", "B", 10);
        $pdf->cell(11, $alt, "Saída:", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(10, $alt, $hora2, "0", 0, "L", 0);
        $pdf->cell(5, $alt, " - ", "0", 0, "L", 0);

        $pdf->setfont("arial", "B", 10);
        $pdf->cell(8, $alt, "Ent: ", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(12, $alt, $hora3, "0", 0, "L", 0);

        $pdf->setfont("arial", "B", 10);
        $pdf->cell(8, $alt, "Sai: ", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(7, $alt, $hora4, "0", 0, "L", 0);
        $pdf->cell(7, $alt, "", "0", 0, "L", 0);

        $pdf->setfont("arial", "B", 10);
        $pdf->cell(27, $alt, "Jornada. Mens: ", "0", 0, "L", 0);
        $pdf->setfont("arial", "", 10);
        $pdf->cell(10, $alt, $servidor->rh02_hrsmen . " Horas", "0", 0, "L", 0);
    }

    $pdf->ln(5);

    $pdf->setfont("arial", "B", 8);
    $pdf->cell(13, 5, "DIA/MÊS", "1", 0, "C", 0);
    $pdf->cell(15, 5, "ENTRADA", "1", 0, "C", 0);
    $pdf->cell(28, 5, "ASS. SERV.", "1", 0, "C", 0);
    $pdf->cell(11, 5, "SAÍDA", "1", 0, "C", 0);
    $pdf->cell(28, 5, "ASS. SERV.", "1", 0, "C", 0);
    $pdf->cell(15, 5, "ENTRADA", "1", 0, "C", 0);
    $pdf->cell(28, 5, "ASS. SERV.", "1", 0, "C", 0);
    $pdf->cell(11, 5, "SAÍDA", "1", 0, "C", 0);
    $pdf->cell(28, 5, "ASS. SERV.", "1", 0, "C", 0);
    $pdf->cell(17, 5, "HRs. TRAB.", "1", 0, "C", 0);

    $pdf->ln();
    $controle = 0;

    foreach ($aDias as $aDia) {

        $data = date("D", strtotime($anoControle[$controle] . "-" . implode("-", array_reverse(explode("/", $aDia)))));
        $controle++;

        $pdf->setfont("arial", "", 8);
        $pdf->cell(13, 5, $aDia, "1", 0, "C", 0);
        $pdf->cell(15, 5, "", "1", 0, "C", 0);

        if ($data == 'Sat') {
            $pdf->cell(28, 5, "Sábado", "1", 0, "C", 0);
        } else if ($data == 'Sun') {
            $pdf->cell(28, 5, "Domingo", "1", 0, "C", 0);
        }else if(in_array($aDia, $dataFeriado)){
            $pdf->cell(28, 5, "FERIADO", "1", 0, "C", 0);
        }
        else{
            $pdf->cell(28, 5, "", "1", 0, "C", 0);
        }

        $pdf->cell(11, 5, "", "1", 0, "C", 0);

        if ($data == 'Sat') {
            $pdf->cell(28, 5, "Sábado", "1", 0, "C", 0);
        } else if ($data == 'Sun') {
            $pdf->cell(28, 5, "Domingo", "1", 0, "C", 0);
        }else if(in_array($aDia, $dataFeriado)){
            $pdf->cell(28, 5, "FERIADO", "1", 0, "C", 0);
        }
        else{
            $pdf->cell(28, 5, "", "1", 0, "C", 0);
        }

        $pdf->cell(15, 5, "", "1", 0, "C", 0);

        if ($data == 'Sat') {
            $pdf->cell(28, 5, "Sábado", "1", 0, "C", 0);
        } else if ($data == 'Sun') {
            $pdf->cell(28, 5, "Domingo", "1", 0, "C", 0);
        }else if(in_array($aDia, $dataFeriado)){
            $pdf->cell(28, 5, "FERIADO", "1", 0, "C", 0);
        }else{
            $pdf->cell(28, 5, "", "1", 0, "C", 0);
        }

        $pdf->cell(11, 5, "", "1", 0, "C", 0);

        if ($data == 'Sat') {
            $pdf->cell(28, 5, "Sábado", "1", 0, "C", 0);
        } else if ($data == 'Sun') {
            $pdf->cell(28, 5, "Domingo", "1", 0, "C", 0);
        }else if(in_array($aDia, $dataFeriado)){
            $pdf->cell(28, 5, "FERIADO", "1", 0, "C", 0);
        }
        else{
            $pdf->cell(28, 5, "", "1", 0, "C", 0);
        }

        $pdf->cell(17, 5, "", "1", 0, "C", 0);
        $pdf->ln();
    }



    $pdf->ln();
    $pdf->cell(60, 5, "Ass: _________________________________", "0", 0, "C", 0);
    $pdf->ln(9);
    $pdf->cell(62, 5, "___________________________________", "0", 0, "C", 0);
    $pdf->cell(64, 5, "___________________________________", "0", 0, "C", 0);
    $pdf->cell(66, 5, "___________________________________", "0", 0, "C", 0);
}
$pdf->Output();