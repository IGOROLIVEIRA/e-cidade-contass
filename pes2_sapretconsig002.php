<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

include("fpdf151/pdf.php");
include("libs/db_sql.php");

$clrotulo = new rotulocampo;
$clrotulo->label('r06_codigo');
$clrotulo->label('r06_descr');
$clrotulo->label('r06_elemen');
$clrotulo->label('r06_pd');

$clgerasql = new cl_gera_sql_folha;
$clgerasql->inicio_rh = false;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

//where dos descontos
$dbwheredesc = " rh23_rubric is null ";
//where dos proventos
$dbwhereprov = " rh23_rubric is not null ";
$dbwhererubs = "";

if (trim($rubrs) != "") {
    $dbwhererubs = " and #s#_rubric in ('" . str_replace(",", "','", $rubrs) . "')";
}

$arr_pontos = explode(",", $ponts);
//variavel dos descontos
$varDesc = "";
//variavel dos proventos
$varProv = "";

$headPontos = "";

for ($i = 0; $i < 6; $i++) {
    $valor = "";
    if (isset($arr_pontos[$i]) && trim($arr_pontos[$i]) != "") {
        $valor = $arr_pontos[$i];
    } else if (count($arr_pontos) == 1 && trim($arr_pontos[0]) == "") {
        $valor = "$i";
    }
    switch ($valor) {
        case "0":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Salário";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r14",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r14",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r14");
            break;
        case "1":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Adiantamento";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r22",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r22",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r22");
            break;
        case "2":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Férias";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r31",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r31",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r31");
            break;
        case "3":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Rescisão";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r20",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r20",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r20");
            break;
        case "4":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Saldo do 13o.";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r35",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r35",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r35");
            break;
        case "5":
            $headPontos .= (trim($varDesc) != "" ? ", " : "") . "Complementar";
            //query dos descontos
            $varDesc .= (trim($varDesc) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r48",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 " . $dbwhererubs . (isset($semest) && $semest != "T" ? " and r48_semest = " . $semest : "")
            ) . " ) ";
            //query dos proventos
            $varProv .= (trim($varProv) != "" ? " union " : "") . " ( " . $clgerasql->gerador_sql(
                "r48",
                $ano,
                $mes,
                null,
                null,
                "#s#_rubric, #s#_valor, #s#_regist, #s#_pd, #s#_anousu, #s#_mesusu",
                "#s#_rubric",
                "#s#_pd != 3 "
            ) . " ) ";
            $sigla = (isset($sigla) ? $sigla : "r48");
            break;
    }
}

if (count($arr_pontos) == 1 && trim($arr_pontos[0]) == "") {
    $headPontos = "Todos os pontos";
}
$clgerasql->inicio_rh = true;
$clgerasql->inner_rel = false;
$clgerasql->inner_exe = true;
$clgerasql->inner_org = true;
$clgerasql->inner_vin = true;
$clgerasql->inner_pro = true;
$clgerasql->inner_rec = true;
$clgerasql->inner_exc = false;
$clgerasql->usar_rub = true;
$clgerasql->usar_rel = true;
$clgerasql->usar_lot = true;
$clgerasql->usar_exe = true;
$clgerasql->usar_org = true;
$clgerasql->usar_vin = true;
$clgerasql->usar_pro = true;
$clgerasql->usar_rec = true;
$clgerasql->usar_rec = false;
$clgerasql->subsql = $varDesc;
$clgerasql->subsqlano = $sigla . "_anousu";
$clgerasql->subsqlmes = $sigla . "_mesusu";
$clgerasql->subsqlreg = $sigla . "_regist";
$clgerasql->subsqlrub = $sigla . "_rubric";
$clgerasql->trancaGer = true;

//consulta dos descontos por matricula
$sqlDesc = $clgerasql->gerador_sql(
    "",
    $ano,
    $mes,
    null,
    null,
    "rh25_recurso recursodesconto, o15_descr descrrecurso, rh27_descr as descrrubrica," . $sigla . "_rubric as rubrica, round(sum(" . $sigla . "_valor),2) as valordesc, " . $sigla . "_regist matriculadesc",
    $sigla . "_regist," . $sigla . "_rubric, rh25_recurso",
    $dbwheredesc . "group by rh25_recurso, o15_descr, " . $sigla . "_rubric, rh27_descr, x." . $sigla . "_regist"
);

$resultDesc = $clgerasql->sql_record($sqlDesc);
$aDadoDesc = array();

for ($x = 0; $x < pg_num_rows($resultDesc); $x++) {
    db_fieldsmemory($resultDesc, $x);

    //consulta dos proventos e excecao por matricula
    $clgerasql->subsql = $varProv;
    $clgerasql->inner_rel = true;
    $clgerasql->inner_exc = false;
    $clgerasql->usar_exc = true;
    $sqlProv = $clgerasql->gerador_sql(
        "",
        $ano,
        $mes,
        null,
        null,
        "x." . $sigla . "_regist matricula, " . $sigla . "_rubric AS rubricaprov, round(sum(case when x." . $sigla . "_pd = 1 then x." . $sigla . "_valor else 0 end),2) as valorprovento,round(sum(case when x." . $sigla . "_pd = 2 then x." . $sigla . "_valor else 0 end),2) as valordescontoemp, rh74_recurso recursoexc, o2.o15_descr descrrecursoexc",
        $sigla . "_regist," . $sigla . "_rubric",
        $dbwhereprov . " and " . $sigla . "_regist = $matriculadesc group by " . $sigla . "_rubric, o1.o15_codigo, x." . $sigla . "_regist, rh74_recurso, o2.o15_descr"
    );
    $resultProv = $clgerasql->sql_record($sqlProv);

    $objDesconto = new stdClass();
    $objDesconto->matricula = $matriculadesc;
    $objDesconto->rubrica = $rubrica;
    $objDesconto->descrrubrica = $descrrubrica;
    $objDesconto->valordesc = $valordesc;
    $objDesconto->recurso = $recursodesconto;
    $objDesconto->descricaorecurso = $descrrecurso;
    $objDesconto->proventos = db_utils::getCollectionByRecord($resultProv);
    $valorprovento = 0;
    $valordescempenho = 0;

    foreach (db_utils::getCollectionByRecord($resultProv) as $key => $provento) {

        $valordescempenho += $provento->valordescontoemp;
        $valorprovento += $provento->valorprovento;
        $objDesconto->somaproventos = $valorprovento;
        $objDesconto->totaldescempenho = $valordescempenho;
        $objDesconto->totalproventosfinal = $objDesconto->somaproventos - $objDesconto->totaldescempenho;
    }
    $aDadoDesc[] = $objDesconto;
}

foreach ($aDadoDesc as $dado) {

    $percentualexc = 0;
    $valorexcecao = 0;
    $sumvalorexcecao = 0;

    //efetua o calculo das execeçoes por matricula e desconto
    foreach ($dado->proventos as $calcexc) {
        if ($calcexc->recursoexc != null ||  $calcexc->recursoexc != "") {
            $percentualexc = $calcexc->valorprovento / $dado->totalproventosfinal * 100;
            $valorexcecao  = $dado->valordesc * $percentualexc / 100;
            $sumvalorexcecao += $valorexcecao;
            $dado->valorexcecaoformat = round($sumvalorexcecao, 2);
            $dado->recursoexcecao = $calcexc->recursoexc;
            $dado->descrrecursoexc = $calcexc->descrrecursoexc;
        }
        $dado->valordescfinal = $dado->valordesc - $dado->valorexcecaoformat;
    }
    //trecho dicionado e comentado para caso opte por incluir no calculo as rubricas de salario familia e salario maternidade
    //if(empty($dado->proventos)){
    //    $dado->valordescfinal += $dado->valordesc;
    //}
}

if ($quebra == 'f') {
    // agrupar dados por rubrica
    $aRubrica = array();

    foreach ($aDadoDesc as $item) {
        $key = $item->rubrica . '|' . $item->recurso;
        if (!isset($aRubrica[$key])) {
            $aRubrica[$key] = (object) array(
                'rubrica' => $item->rubrica,
                'descrrubrica' => $item->descrrubrica,
                'recurso' => $item->recurso,
                'descricaorecurso' => $item->descricaorecurso,
                'valordescfinal' => $item->valordescfinal

            );
        } else {
            $aRubrica[$key]->valordescfinal += $item->valordescfinal;
        }

        if ($item->recursoexcecao !== null) {
            $keyExcecao = $item->rubrica . '|' . $item->recursoexcecao;
            if (!isset($aRubrica[$keyExcecao])) {
                $aRubrica[$keyExcecao] = (object) array(
                    'rubrica' => $item->rubrica,
                    'descrrubrica' => $item->descrrubrica,
                    'recursoexcecao' => $item->recursoexcecao,
                    'descrrecursoexc' => $item->descrrecursoexc,
                    'valorexcecaoformat' => $item->valorexcecaoformat
                );
            } else {
                $aRubrica[$keyExcecao]->valorexcecaoformat += $item->valorexcecaoformat;
            }
        }
    }

    ksort($aRubrica);

    foreach ($aRubrica as &$rubRecurso) {
        ksort($rubRecurso);
    }

    //totalizar recurso
    $aTotalizaRecurso = array();

    foreach ($aRubrica as $rubrica) {
        $recurso = $rubrica->recurso;
        $recursoexcecao = $rubrica->recursoexcecao;

        if (!isset($aTotalizaRecurso[$recurso])) {
            $aTotalizaRecurso[$recurso] = (object) array(
                'recurso' => $recurso,
                'descricaorecurso' => $rubrica->descricaorecurso,
                'valordescfinal' => $rubrica->valordescfinal
            );
        } else {
            $aTotalizaRecurso[$recurso]->valordescfinal += $rubrica->valordescfinal;
        }

        if (!isset($aTotalizaRecurso[$recursoexcecao])) {
            $aTotalizaRecurso[$recursoexcecao] = (object) array(
                'recurso' => $recursoexcecao,
                'descricaorecurso' => $rubrica->descrrecursoexc,
                'valordescfinal' => $rubrica->valorexcecaoformat
            );
        } else {
            $aTotalizaRecurso[$recursoexcecao]->valordescfinal += $rubrica->valorexcecaoformat;
        }
    }
}

//quando optar por quebra, o relatorio será estruturado por recurso não mais por rubrica
if ($quebra == 't') {

    //agrupa por recurso
    $aRecurso = array();
    foreach ($aDadoDesc as $item) {
        $key = $item->recurso . " - " . $item->descricaorecurso;
        if (!isset($aRecurso[$key][$item->rubrica])) {
            $aRecurso[$key][$item->rubrica] = (object) array(
                'rubrica' => $item->rubrica,
                'descrrubrica' => $item->descrrubrica,
                'recurso' => $item->recurso,
                'descricaorecurso' => $item->descricaorecurso,
                'valordescfinal' => $item->valordescfinal

            );
        } else {
            $aRecurso[$key][$item->rubrica]->valordescfinal += $item->valordescfinal;
        }

        if ($item->recursoexcecao !== null) {
            $keyExcecao = $item->recursoexcecao . " - " . $item->descrrecursoexc;
            if (!isset($aRecurso[$keyExcecao][$item->rubrica])) {
                $aRecurso[$keyExcecao][$item->rubrica] = (object) array(
                    'rubrica' => $item->rubrica,
                    'descrrubrica' => $item->descrrubrica,
                    'recurso' => $item->recursoexcecao,
                    'descricaorecurso' => $item->descrrecursoexc,
                    'valordescfinal' => $item->valorexcecaoformat
                );
            } else {
                $aRecurso[$keyExcecao][$item->rubrica]->valordescfinal += $item->valorexcecaoformat;
            }
        }
    }
    // ordena array de forma crescente
    ksort($aRecurso);

    // ordena subarray de forma crescente
    foreach ($aRecurso as &$subarray) {
        ksort($subarray);
    }
}

//verifica se existem dados para exibir o relatório
if ($resultDesc === false || ($resultDesc !== false && $clgerasql->numrows_exec == 0)) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados no período de ' . $mes . ' / ' . $ano);
}

$head3 = "Retenções e Consignações da Folha";
$head5 = "Período : " . $mes . " / " . $ano;
$head7 = "Pontos: " . $headPontos;

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;

$rubri_ant = "";
$recursoant = "";
$total_rub = 0;
$total_ger = 0;
$cor = 1;
$proxpag = true;

if ($quebra == 'f') {

    foreach ($aRubrica as $key => $valor) {

        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            $pdf->addpage();
            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(15, $alt, 'RUBRICA', 1, 0, "C", 1);
            $pdf->cell(75, $alt, 'DESCRIÇÃO', 1, 0, "C", 1);
            $pdf->cell(75, $alt, 'RECURSO', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'DESCONTO', 1, 1, "C", 1);
            $troca = 0;
            $cor = 1;
            $proxpag = true;
        }

        $cor = 0;
        if (strlen($aRubrica[$key]->descricaorecurso) > 45) {
            $altcol = 2;
        } else {
            $altcol = 1;
        }

        for ($x = 0; $x < sizeof($aRubrica[$key]); $x++) {

            if ($rubri_ant != $aRubrica[$key]->rubrica || $proxpag == true) {
                if ($rubri_ant != $aRubrica[$key]->rubrica && $rubri_ant != "") {
                    $pdf->setfont('arial', 'b', 7);
                    $pdf->cell(165, $alt, "Total da rubrica ", 0, 0, "R", 1);
                    $pdf->cell(25, $alt, db_formatar($total_rub, "f"), 0, 1, "R", 1);
                    $pdf->ln(2);
                    $total_rub = 0;
                    $cor = 0;
                }
                $pdf->setfont('arial', '', 7);
                $pdf->cell(15, $alt * $altcol, $aRubrica[$key]->rubrica, 0, 0, "C", $cor);
                $pdf->cell(75, $alt * $altcol, $aRubrica[$key]->descrrubrica, 0, 0, "L", $cor);
            } else {
                $pdf->setfont('arial', '', 7);
                $pdf->cell(15, $alt * $altcol, "", 0, 0, "C", $cor);
                $pdf->cell(75, $alt * $altcol, "", 0, 0, "L", $cor);
            }

            $pos_x = $pdf->x;
            $pos_y = $pdf->y;
            if ($aRubrica[$key]->recurso != null) {
                $pdf->multicell(75, $alt, $aRubrica[$key]->recurso . " - " . $aRubrica[$key]->descricaorecurso, 0, "L", 0, 0);
                $pdf->x = $pos_x + 75;
                $pdf->y = $pos_y;
                $pdf->cell(25, $alt * $altcol, db_formatar($aRubrica[$key]->valordescfinal, "f"), 0, 1, "R", $cor);
            }

            if ($aRubrica[$key]->recursoexcecao != null) {
                $pdf->cell(75, $alt, $aRubrica[$key]->recursoexcecao . " - " . substr($aRubrica[$key]->descrrecursoexc, 0, 40), 0, "R", 1, 0);
                $pdf->cell(25, $alt * $altcol, db_formatar($aRubrica[$key]->valorexcecaoformat, "f"), 0, 1, "R", $cor);
            }
            $total_rub += $aRubrica[$key]->valordescfinal + $aRubrica[$key]->valorexcecaoformat;
            $total_ger += $aRubrica[$key]->valordescfinal + $aRubrica[$key]->valorexcecaoformat;
            $rubri_ant = $aRubrica[$key]->rubrica;
            $proxpag = false;
        }
    }
    $pdf->ln(1);
    $pdf->setfont('arial', 'B', 7);
    $pdf->cell(165, $alt, "Total da rubrica ", 0, 0, "R", 1);
    $pdf->cell(25, $alt, db_formatar($total_rub, "f"), 0, 1, "R", 1);
    $pdf->ln(1);

    $pdf->setfont('arial', 'B', 8);
    $pdf->cell(165, $alt, "Total geral ", "T", 0, "R", 1);
    $pdf->cell(25, $alt, db_formatar($total_ger, "f"), "T", 1, "R", 1);

    //exibe total por recurso
    $pdf->cell(0, $alt, 'Total dos Recursos ', 0, 1, "L", 0);
    $pdf->setfont('arial', '', 7);
    foreach ($aTotalizaRecurso as $recurso => $valor) {
        if ($aTotalizaRecurso[$recurso]->recurso != null) {
            for ($x = 0; $x < sizeof($aTotalizaRecurso[$recurso]); $x++) {
                $pdf->cell(150, $alt, $aTotalizaRecurso[$recurso]->recurso . " - " . $aTotalizaRecurso[$recurso]->descricaorecurso, 0, 0, "L", '', '', '_');
                $pdf->cell(25, $alt, db_formatar($aTotalizaRecurso[$recurso]->valordescfinal, "f"), 0, 1, "R");
            }
        }
    }
    $pdf->Output();
} else {
    //quebra por página sim
    foreach ($aRecurso as $key => $valor) {

        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            $pdf->addpage();
            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(15, $alt, 'RUBRICA', 1, 0, "C", 1);
            $pdf->cell(75, $alt, 'DESCRIÇÃO', 1, 0, "C", 1);
            $pdf->cell(75, $alt, 'RECURSO', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'DESCONTO', 1, 1, "C", 1);
            $troca = 0;
            $cor = 1;
        }
        foreach ($valor as $index => $item) {
            $pdf->setfont('arial', '', 7);
            $pdf->cell(15, $alt, $item->rubrica, 0, 0, "C", 0);
            $pdf->cell(75, $alt, $item->descrrubrica, 0, 0, "L", 0);
            $pdf->cell(75, $alt, $item->recurso . " - " . substr($item->descricaorecurso, 0, 40), 0, 0, "L", 0);
            $pdf->cell(25, $alt, db_formatar($item->valordescfinal, "f"), 0, 1, "R", 0);

            $totalrecurso += $item->valordescfinal;
            $totalrecursogeral += $item->valordescfinal;
        }
        if ($totalrecurso > 0) {
            $pdf->setfont('arial', 'b', 7);
            $pdf->cell(165, $alt, "Total do recurso: ", 0, 0, "R", 1);
            $pdf->cell(25, $alt, db_formatar($totalrecurso, "f"), 0, 1, "R", 1);
            $pdf->ln(2);
            $totalrecurso = 0;
            $cor = 0;
        }
        $troca = 1;
    }
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(165, $alt, "Total Geral: ", "T", 0, "R", 1);
    $pdf->cell(25, $alt, db_formatar($totalrecursogeral, "f"), "T", 1, "R", 1);

    $pdf->Output();
}
