<?


include("fpdf151/pdf.php");
require_once("libs/db_utils.php");



db_postmemory($HTTP_SERVER_VARS);
$oGet  = db_utils::postMemory($_GET);
$oLicitacao = new licitacao($l20_codigo);

$sql = "select uf, db12_extenso, logo, munic, cgc, ender, bairro, numero, codigo, nomeinst
			from db_config  
				inner join db_uf on db12_uf = uf
			where codigo = " . db_getsession("DB_instit");

$result = pg_query($sql);
db_fieldsmemory($result, 0);

$where = "";
$and = false;

if ($oGet->ac16_sequencial != null || $oGet->ac16_sequencial != "") {
  $where .= " WHERE ac16_sequencial = $oGet->ac16_sequencial ";
  $and = true;
}

if ($oGet->situacao != 0) {
  if ($and == true) {
    $where .= " and ac16_acordosituacao = $oGet->situacao ";
  } else {
    $where .= " WHERE ac16_acordosituacao = $oGet->situacao ";
    $and = true;
  }
}

if ($oGet->exercicio != null || $oGet->exercicio != 0) {
  if ($and == true) {
    $where .= " and ac16_anousu = $oGet->exercicio ";
  } else {
    $where .= " WHERE ac16_anousu = $oGet->exercicio ";
    $and = true;
  }
}

if ($oGet->cgms != null) {
  if ($and == true) {
    $where .= " and ac16_contratado in ($oGet->cgms) ";
  } else {
    $where .= " WHERE ac16_contratado in ($oGet->cgms) ";
    $and = true;
  }
}


if ($and == true) {
  $where .= " and ac16_instit = " . db_getsession("DB_instit");
} else {
  $where .= " WHERE ac16_instit = " . db_getsession("DB_instit");
  $and = true;
}


$sql_acordo = "SELECT acordo.ac16_sequencial AS SEQUENCIAL,
CAST(acordo.ac16_numeroacordo AS NUMERIC) AS NUMERO,
acordo.ac16_anousu AS ANO,
acordo.ac16_numeroprocesso AS PROCESSO,
acordo.ac16_dataassinatura AS ASSINATURA,
acordo.ac16_datafim AS VENCIMENTO,
acordo.ac16_objeto AS OBJETO,
acordo.ac16_contratado AS CODIGO,
ac16_vigenciaindeterminada,
cgm.z01_nome AS CONTRATADO,
acordo.ac16_valor as valor,
ac28_descricao as origem,
ac17_descricao as status,
l20_edital as processolicitatorio,
l20_numero as codmodalidade,
l03_descr as modalidade,
l20_exercicioedital as exercicioedital
FROM acordo
JOIN cgm ON z01_numcgm = ac16_contratado
JOIN acordos.acordoorigem on ac28_sequencial = ac16_origem
JOIN acordos.acordosituacao on ac17_sequencial = ac16_acordosituacao
left join liclicita on l20_codigo = ac16_licitacao
left join cflicita on l03_codigo = l20_codtipocom
 $where
ORDER BY CAST(ac16_numeroacordo AS NUMERIC),ac16_sequencial";

$rs_acordo = db_query($sql_acordo);

if (pg_numrows($rs_acordo) == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado.');
}

$head2 = "Rol de Contratos";

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(3);
$linhas = 1;
$y = 0;
$pagina = 1;


for ($i = 0; $i < pg_numrows($rs_acordo); $i++) {

  $oDadosAcordo = db_utils::fieldsMemory($rs_acordo, $i);




  if (strlen($oDadosAcordo->objeto) > 76) {
    $linhas = floor(strlen($oDadosAcordo->objeto) / 58) + 1;
    $decimal = strval(strlen($oDadosAcordo->objeto) / 58);
    $decimal = substr($decimal, 2);
    $decimal = "0." . $decimal;
    $decimal = floatval($decimal);
    if ($linhas > 10) {
      $linhas = floor(strlen($oDadosAcordo->objeto) / 58) + 3;
    }

    if ($decimal > 0.15 && $decimal < 0.45) {
      $linhas = floor(strlen($oDadosAcordo->objeto) / 58);
    }
  } else {
    $linhas = 1;
  }

  if ($pdf->getY() >= 165) {
    $pdf->Ln(210);
  }


  $pdf->setfillcolor(235);

  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(20, 5, "Código", 1, 0, "C", 1);
  $pdf->Cell(30, 5, "Número/Ano", 1, 0, "C", 1);
  $pdf->Cell(90, 5, "Objeto", 1, 0, "C", 1);
  $pdf->Cell(70, 5, "Fornecedor", 1, 0, "C", 1);
  $pdf->Cell(20, 5, "Vigência", 1, 0, "C", 1);
  $pdf->Cell(20, 5, "Assinatura", 1, 0, "C", 1);
  $pdf->Cell(29, 5, "Valor", 1, 0, "C", 1);

  $pdf->Ln();

  $pdf->SetFont("Arial", "", 7);


  $pdf->Cell(20, 5 * $linhas, $oDadosAcordo->sequencial, 1, 0, "C");
  $pdf->Cell(30, 5 * $linhas, $oDadosAcordo->numero . "/" . $oDadosAcordo->ano, 1, 0, "C");
  $yi = $pdf->getY();
  $pdf->MultiCell(90, 5, $oDadosAcordo->objeto, 1, "C", 0);

  if ($pagina != $pdf->PageNo()) {
    $pdf->SetXY(150, $yi);
  } else {
    if ($pagina != 1) {
      $pdf->SetXY(150, $yi);
    } else {
      $pdf->SetXY(150, 43 + $y);
    }
  }

  $pdf->Cell(70, 5 * $linhas, substr($oDadosAcordo->contratado, 0, 50), 1, 0, "C");

  $dataVigencia = $oDadosAcordo->ac16_vigenciaindeterminada == "t" ? "-" : date('d/m/Y', strtotime($oDadosAcordo->vencimento));

  $pdf->Cell(20, 5 * $linhas, $dataVigencia, 1, 0, "C");

  if ($oDadosAcordo->assinatura != null) {
    $pdf->Cell(20, 5 * $linhas, date('d/m/Y', strtotime($oDadosAcordo->assinatura)), 1, 0, "C");
  } else {
    $pdf->Cell(20, 5 * $linhas, $oDadosAcordo->assinatura, 1, 0, "C");
  }

  $pdf->Cell(29, 5 * $linhas, 'R$' . number_format($oDadosAcordo->valor, 2, ',', '.'), 1, 0, "C");
  $pdf->Ln();
  $pdf->SetFont("Arial", "B", 9);
  $pdf->Cell(230, 5, "Origem: " . $oDadosAcordo->origem, 1, 0, "L", 1);
  $pdf->Cell(49, 5, "Status: " . $oDadosAcordo->status, 1, 0, "L", 1);
  $pdf->Ln();

  if ($oDadosAcordo->processolicitatorio != null) {
    $pdf->Cell(140, 5, "Processo Licitatório: " . $oDadosAcordo->processolicitatorio . "/" . $oDadosAcordo->exercicioedital, 1, 0, "L", 1);
    $pdf->Cell(90, 5, "Modalidade: " . IniciaisMaiusculas($oDadosAcordo->modalidade), 1, 0, "L", 1);
    $pdf->Cell(49, 5, "Numeração: " . $oDadosAcordo->codmodalidade, 1, 0, "L", 1);
    $pdf->Ln();
    $y += 19 + (5 * $linhas);
  } else {
    $y += 14 + (5 * $linhas);
  }

  if ($pagina != $pdf->PageNo()) {
    $y = $yi;
    $pagina = $pdf->PageNo();
  }

  $pdf->Ln(4);
}

function IniciaisMaiusculas($string)
{
  $string = mb_strtolower(trim(preg_replace("/\s+/", " ", $string))); //transformo em minuscula toda a sentença
  $palavras = explode(" ", $string); //explodo a sentença em um array
  $t =  count($palavras); //conto a quantidade de elementos do array
  for ($i = 0; $i < $t; $i++) { //entro em um for limitando pela quantidade de elementos do array
    $retorno[$i] = ucfirst($palavras[$i]); //altero a primeira letra de cada palavra para maiuscula
    if ($retorno[$i] == "Dos" || $retorno[$i] == "De" || $retorno[$i] == "Do" || $retorno[$i] == "Da" || $retorno[$i] == "E" || $retorno[$i] == "Das") :
      $retorno[$i] = mb_strtolower($retorno[$i]); //converto em minuscula o elemento do array que contenha preposição de nome próprio
    endif;
  }
  return implode(" ", $retorno);
}

$pdf->Output();
