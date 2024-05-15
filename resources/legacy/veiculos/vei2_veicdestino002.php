<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

echo "<pre>";
require_once("fpdf151/pdf.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_SERVER_VARS);


/** $_GET
["ve70_dataini"]    => string(10) "2016-08-01"
["ve70_datafin"]    => string(10) "2016-08-19"
["ve01_codigo"]     => string(12) "4,5,7,8,9,10"
["ve75_sequencial"] => string(2) "30"
 */

/** cada elemento é um critério para o WHERE da QUERY */
$aCriteriosWhere = array();

/** coloca o critério entre parênteses "()", e insere o critério em $aCriteriosWhere */
/** depois junta todos os critérios com um implode(' AND ', $aCriteriosWhere) */
function addCriterio ($str) {
    global $aCriteriosWhere;
    $str = trim($str);
    $str = "({$str})";
    array_push($aCriteriosWhere, $str);
}

/**
 * retorna um critério de data para WHERE da QUERY
 * @param string $dataAux:  data a ser tradada
 * @param string $sinal:    sinal, pode ser >, <, >=, <=, =, !=
 * @param string $campoDB:  campo do banco de dados para ser comparado
 */
function filtroData ($campoDB, $sinal, $dataAux) {
    $campoDB    = trim($campoDB);
    $sinal      = trim($sinal);
    $dataAux    = trim($dataAux);
    if (empty($dataAux) || empty($sinal) || empty($campoDB)) {
        return false;
    }

    return "({$campoDB} {$sinal} '{$dataAux}')";
}

/** filtro ve60_datasaida: $_GET['ve70_dataini'] e $_GET['ve70_dataini'] */
$sPeriodo = "";

$aFiltrosData = array();

if (isset($ve70_dataini)) {
    $filtroAux = filtroData('ve60_datasaida', '>=', $ve70_dataini);
    if ($filtroAux) {
        array_push($aFiltrosData, $filtroAux);
        $sPeriodo = 'a partir de ' . db_formatar($ve70_dataini, "d");
    }
}
if (isset($ve70_datafin)) {
    $filtroAux = filtroData('ve60_datasaida', '<=', $ve70_datafin);
    if ($filtroAux) {
        array_push($aFiltrosData, $filtroAux);
        $sPeriodo .= ' até ' . db_formatar($ve70_datafin, "d");
    }
}
if (!empty($aFiltrosData)) {
    addCriterio(implode(' AND ', $aFiltrosData));
}


/** filtro ve60_codigo: $_GET['ve01_codigo'] */
if (isset($ve01_codigo) && trim($ve01_codigo) != "") {
    addCriterio("ve60_veiculo in ({$ve01_codigo})");
}


/** filtro ve60_destinonovo: $_GET['ve75_sequencial'] */
if (isset($ve75_sequencial) && trim($ve75_sequencial) != "") {
    addCriterio("ve60_destinonovo = {$ve75_sequencial}");
}


$sWhereMov = empty($aCriteriosWhere)? "" : " WHERE " . implode(" AND ", $aCriteriosWhere);


/** pegar veículos */
$sCamposVeiculos = implode(", ", array(
    "ve01_codigo AS codveiculo",
    "ve01_placa AS placa",
    "descrdepto AS departamento"
));

/** pegar movimentações */
$sCamposMov = implode(", ", array(
    "ve60_codigo AS codigo",
    "ve75_destino AS destino",
    "z01_nome AS motorista",
    "ve60_datasaida AS saida",
    "(ve61_medidadevol - ve60_medidasaida) AS media"
));

$sInnerJoinMov = implode(' ', array(
    "INNER JOIN veiculos ON ve60_veiculo = ve01_codigo",
    "INNER JOIN veicmotoristas ON ve60_veicmotoristas = ve05_codigo",
    "INNER JOIN cgm ON ve05_numcgm = z01_numcgm",
    "INNER JOIN veicdevolucao ON ve61_veicretirada = ve60_codigo",
    "INNER JOIN veiccaddestino ON ve60_destinonovo = ve75_sequencial",
    "INNER JOIN db_depart ON ve60_coddepto = coddepto"
));
$sInnerJoinVeiculos = $sInnerJoinMov;


/** @var string $sQueryVeiculos Seleciona todos os veículos do filtro para exibir movimentações (destinos) por veículo */
$sQueryVeiculos = "SELECT DISTINCT {$sCamposVeiculos} FROM veicretirada {$sInnerJoinVeiculos} {$sWhereMov} ORDER BY codveiculo";
//echo $sQueryVeiculos."\n";


$rsVeiculos = db_query($sQueryVeiculos) or die(pg_last_error());
//db_criatabela($rsVeiculos);


/** Se não encontrar nada */
if (pg_num_rows($rsVeiculos) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhum destino com esses filtros.');
}


// Cabeçalho
$head2 = "RELATÓRIO DE DESTINO";

if ($sPeriodo != "") {
    $head3 = "PERIODO: " . $sPeriodo;
}

if (!empty($ve75_sequencial)) {
    $head4 = "DESTINO: {$ve75_destino}";
}
// Cabeçalho


$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetFillColor(235);
$pdf->lMargin = 3;
$pdf->SetFont('Arial', 'B', 8);


$alt = 4;
// Largura de colunas
$iLarguraCodigo     = 40;
$iLarguraDestino    = 80;
$iLarguraMotorista  = 80;
$iLarguraSaida      = 40;
$iLarguraMedia      = 40;


function drawHeadTable () {
    global $pdf, $alt, $iLarguraCodigo, $iLarguraDestino, $iLarguraMotorista, $iLarguraSaida, $iLarguraMedia;

    $pdf->setfont('arial', 'b', 8);
    $pdf->ln($alt);
    $pdf->SetX(10);
    $pdf->cell($iLarguraCodigo   , $alt, "Retirada", 1, 0, 'C', 1);
    $pdf->cell($iLarguraDestino  , $alt, "Destino", 1, 0, 'C', 1);
    $pdf->cell($iLarguraMotorista, $alt, "Motorista", 1, 0, 'C', 1);
    $pdf->cell($iLarguraSaida    , $alt, "Data de Saída", 1, 0, 'C', 1);
    $pdf->cell($iLarguraMedia    , $alt, "Medida Rodada", 1, 1, 'C', 1);
}
function drawTRTable ($codigo, $destino, $motorista, $dataSaida, $medida, $borda = 1) {
    global $pdf, $alt, $iLarguraCodigo, $iLarguraDestino, $iLarguraMotorista, $iLarguraSaida, $iLarguraMedia;

    $pdf->setfont('arial', '', 8);
    $pdf->SetX(10);
    $pdf->cell($iLarguraCodigo   , $alt, $codigo,       $borda, 0, 'L', 0);
    $pdf->cell($iLarguraDestino  , $alt, $destino,      $borda, 0, 'L', 0);
    $pdf->cell($iLarguraMotorista, $alt, $motorista,    $borda, 0, 'L', 0);
    $pdf->cell($iLarguraSaida    , $alt, $dataSaida,    $borda, 0, 'L', 0);
    $pdf->cell($iLarguraMedia    , $alt, $medida,       $borda, 1, 'C', 0);
}



/**
 * Percorre resultado de $rsVeiculos
 */
while ($aVeiculo = pg_fetch_assoc($rsVeiculos)) {
// var_dump($aVeiculo);
// Campos:
//     - codveiculo
//     - placa
//     - departamento
    $pdf->addpage("L");
    $pdf->setfont('arial', 'b', 10);


    /**
     * Exibe cabeçalho para este veículo
     */
    // Código Veículo
    $pdf->setfont('arial','b',8);
    $pdf->cell(30,$alt,'Código Veiculo :',0,0,"R",0);
    $pdf->setfont('arial','',7);
    $pdf->cell(60,$alt,str_pad($aVeiculo['codveiculo'], 2, '0', STR_PAD_LEFT),0,1,"L",0);

    // Placa
    $pdf->setfont('arial','b',8);
    $pdf->cell(30,$alt,'Placa :',0,0,"R",0);
    $pdf->setfont('arial','',7);
    $pdf->cell(60,$alt,$aVeiculo['placa'],0,1,"L",0);

    // Responsável
    $pdf->setfont('arial','b',8);
    $pdf->cell(30,$alt,'Responsável :',0,0,"R",0);
    $pdf->setfont('arial','',7);
    $pdf->cell(60,$alt,$aVeiculo['departamento'],0,1,"L",0);


    /**
     * Cabeçalho tabela
     */
    drawHeadTable();
    $iTotalKmRodados = 0;


    /** @var string $sQueryMov base para busca de destinos para determinado veículo */
    $sWhereEsteVeiculo = $sWhereMov . " AND ve60_veiculo = {$aVeiculo['codveiculo']} ";
    $sQueryMov = "SELECT {$sCamposMov} FROM veicretirada {$sInnerJoinMov} {$sWhereEsteVeiculo} ORDER BY codigo";
    // echo $sQueryMov."\n";

    $rsMovimentacao = db_query($sQueryMov) or die(pg_last_error());
    // db_criatabela($rsMovimentacao);

    /**
     * Percorre resultado de $rsMovimentação para $sWhereEsteVeiculo
     */
    while ($aMovimentacao = pg_fetch_assoc($rsMovimentacao)) {
    // var_dump($aMovimentacao);
    // Campos:
    //     - codigo
    //     - destino
    //     - motorista
    //     - saida
    //     - media
        drawTRTable(
            db_formatar($aMovimentacao['codigo'], 's', '0', 5, 'e'),
            $aMovimentacao['destino'],
            $aMovimentacao['motorista'],
            db_formatar($aMovimentacao['saida'], 'd'),
            $aMovimentacao['media'] . ' Km'
        );

        $iTotalKmRodados += intval($aMovimentacao['media']);
    }

    drawTRTable('', '', '', '', "Total: {$iTotalKmRodados}", 0);
}



$pdf->Output();

?>
