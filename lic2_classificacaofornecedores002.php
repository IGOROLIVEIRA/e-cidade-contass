<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("model/licitacao.model.php");

$clliclicita         = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem        = new cl_liclicitem;
$clempautitem        = new cl_empautitem;
$clpcorcamjulg       = new cl_pcorcamjulg;
$clrotulo            = new rotulocampo;

$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);
$sWhere = "";
$sAnd   = "";
if (($data != "--") && ($data1 != "--")) {

  $sWhere .= $sAnd . " l20_datacria  between '$data' and '$data1' ";
  $data = db_formatar($data, "d");
  $data1 = db_formatar($data1, "d");
  $info = "De $data até $data1.";
  $sAnd = " and ";
} else if ($data != "--") {

  $sWhere .= $sAnd . " l20_datacria >= '$data'  ";
  $data = db_formatar($data, "d");
  $info = "Apartir de $data.";
  $sAnd = " and ";
} else if ($data1 != "--") {

  $sWhere .= $sAnd . " l20_datacria <= '$data1'   ";
  $data1 = db_formatar($data1, "d");
  $info = "Até $data1.";
  $sAnd = " and ";
}
if ($l20_codigo != "") {

  $sWhere .= $sAnd . " l20_codigo=$l20_codigo ";
  $sAnd = " and ";
}
if ($l20_numero != "") {

  $sWhere .= $sAnd . " l20_numero=$l20_numero ";
  $sAnd = " and ";
  $info1 = "Numero: " . $l20_numero;
}
if ($l03_codigo != "") {

  $sWhere .= $sAnd . " l20_codtipocom=$l03_codigo ";
  $sAnd = " and ";
  if ($l03_descr != "") {
    $info2 = "Modalidade: " . $l03_codigo . " - " . mb_convert_encoding($l03_descr, 'ISO-8859-1', 'UTF-8');;
  }
}

$sWhere        .= $sAnd . " l20_licsituacao in (1, 10, 13) and l20_instit = " . db_getsession("DB_instit");
$sSqlLicLicita  = $clliclicita->sql_query(null, "distinct l20_codigo, l20_codtipocom,l20_edital,l20_dataaber,l20_objeto,l20_numero,l03_descr,l20_anousu", "l20_codtipocom,l20_numero,l20_anousu", $sWhere);
$result         = $clliclicita->sql_record($sSqlLicLicita);
$numrows        = $clliclicita->numrows;

if ($numrows == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
  exit;
}

$head2 = "Classificação de Fornecedores";
$head3 = @$info;
$head4 = @$info1;
$head5 = @$info2;
$pdf   = new PDF('L');
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca       = 1;
$alt         = 4;
$total       = 0;
$p           = 0;
$valortot    = 0;
$muda        = 0;
$mostraAndam = $mostramov;
$oInfoLog    = array();

function limitarTexto($texto, $limite = 1000) {
  if (strlen($texto) > $limite) {
      $posicao_espaco = strpos($texto, ' ', $limite); // Encontra a posição do próximo espaço após o limite
      if ($posicao_espaco !== false) {
          $texto_cortado = substr($texto, 0, $posicao_espaco); // Obtém a parte da string até o próximo espaço
      } else {
          $texto_cortado = substr($texto, 0, $limite); // Se não houver espaço após o limite, corta na posição do limite
      }
      $texto_cortado .= '...'; // Adiciona reticências para indicar texto cortado
  } else {
      $texto_cortado = $texto; // Se a string for menor que o limite, não é necessário cortar
  }
  return $texto_cortado;
}

for ($i = 0; $i < $numrows; $i++) {

  db_fieldsmemory($result, $i);

  if (empty($l20_procadmin)) {

    $oDAOLiclicitaproc    = db_utils::getDao("liclicitaproc");
    $sSqlProcessoSistema  = $oDAOLiclicitaproc->sql_query(null, "*", null, "l34_liclicita = {$l20_codigo}");
    $rsProcessoSistema    = $oDAOLiclicitaproc->sql_record($sSqlProcessoSistema);

    if ($oDAOLiclicitaproc->numrows == 1) {

      $oLiclicitaproc = db_utils::fieldsMemory($rsProcessoSistema, 0);
      $l20_procadmin  = substr($oLiclicitaproc->p58_numero . "/" . $oLiclicitaproc->p58_ano . " - " . $oLiclicitaproc->p51_descr, 0, 120);
    }
  }

  $oLicitacao = new licitacao($l20_codigo);
  /**
   * itens da autorização para pegar fornecedor e saldo dos itens
   */

  if ($l20_licsituacao == 3) {
    $oInfoLog = $oLicitacao->getInfoLog();
  }
  if ($mostra == 'n') {

    if ($pdf->gety() > $pdf->h - 30 || $muda == 0) {

      $pdf->addpage();
      $muda = 1;
    }
  } else {
    $pdf->addpage();
  }
  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(30, $alt, 'Código Sequencial:', 0, 0, "R", 0);
  $pdf->setfont('arial', '', 7);
  $pdf->cell(60, $alt, $l20_codigo, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(30, $alt, 'Processo :', 0, 0, "R", 0);
  $pdf->setfont('arial', '', 7);
  $pdf->cell(30, $alt, $l20_edital, 0, 0, "L", 0);


  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(80, $alt, 'Modalidade :', 0, 0, "R", 0);
  $pdf->setfont('arial', '', 7);
  $pdf->cell(60, $alt, $l03_descr, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(30, $alt, 'Data Abertura :', 0, 0, "R", 0);
  $pdf->setfont('arial', '', 7);
  $pdf->cell(30, $alt, db_formatar($l20_dataaber, 'd'), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(80, $alt, 'Número :', 0, 0, "R", 0);
  $pdf->setfont('arial', '', 7);
  $pdf->cell(30, $alt, $l20_numero, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell(30, $alt, 'Objeto :', 0, 0, "R", 0);
  $pdf->setfont('arial', 'b', 8);
  $pdf->multicell(250, $alt, $l20_objeto, 0, "L", 0);

  $pdf->cell(280, $alt, '', 'T', 1, "L", 0);

  $troca = 1;

  $subWhere = " WHERE l20_codigo = {$l20_codigo}";
  $subOrder = " order by l21_ordem, pc24_pontuacao";

  if($tipo == 2) {
    $subWhere .= " and pc24_pontuacao = 1";
  }

  $sSql = "SELECT DISTINCT
          l21_ordem as codigo,
          case
            when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
            else pc01_descrmater || '. ' || pc01_complmater
          end as descricao,
          --pc01_descrmater as descricao,
          matunid.m61_descr,
          pc23_quant,
          pc23_vlrun,
          pc23_valor,
          z01_nome|| ' - ' ||z01_cgccpf as fornecedor,
          l21_ordem,
          pc24_pontuacao
        FROM liclicitem
          INNER JOIN liclicitemlote on l04_liclicitem=l21_codigo
          INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
          INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
          INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
          INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
          INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
          INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
          INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
          INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
          INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
          INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
          LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
          INNER JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
          INNER JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
          INNER JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
          INNER JOIN cgm ON pc21_numcgm = z01_numcgm
          INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
          INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
          INNER join pcorcamitem on pc22_orcamitem=pc26_orcamitem";

  $sSql = $sSql . $subWhere . $subOrder;
  
  $result_itens = $clliclicitem->sql_record($sSql);
  if ($clliclicitem->numrows > 0) {
    $ordem = 0;

    for ($w = 0; $w < $clliclicitem->numrows; $w++) {

      db_fieldsmemory($result_itens, $w);

      if ($ordem != $l21_ordem) {
        $troca = 1;
      }

      if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

        if ($pdf->gety() > $pdf->h - 30) {
          $pdf->addpage();
        }
        
        $pdf->cell(280, $alt*2, "", 0, 1, "L", 0);

        $pdf->setfont('arial', 'b', 8);

        // Ajusta o texto e pega o tamanho para quebra de linhas
        $text = str_replace(array("\n", "\r"), ' ', $descricao);
        $text = limitarTexto($text);
        $text = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');
        $text = mb_strtolower($text, 'UTF-8');
        $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
        $text = ucfirst($text);
        $pdf->setfont('arial', '', 7);
        
        $textWidth = $pdf->GetStringWidth($text) * 1.0339;
        $tamanho  = $textWidth > 235 ? ceil($textWidth / 235) : 1;
        
        $pdf->setfont('arial', 'b', 8);

        $pdf->cell(20, $alt, "ITEM", 1, 0, "C", 0);
        $pdf->cell(235, $alt, 'DESCRIÇÃO ', 1, 0, "C", 0);
        $pdf->cell(25, $alt, 'UNIDADE', 1, 1, "C", 0);

        
        
        $pdf->setfont('arial', '', 7);
        $pdf->cell(20, $alt*$tamanho, $codigo, 1, 0, "C", 0);

        // Pega o x e y antes do multicell
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->MultiCell(235, $alt, $text, 0, "J", 0);

        // Reseta o x e o y adiciona o tamanho do multicell ao y
        $pdf->SetXY($x + 235,$y);
        $pdf->cell(25, $alt*$tamanho, ucfirst(strtolower($m61_descr)), 1, 1, "C", 0);

        // Adiciona segundo header
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(20, $alt, 'COLOCAÇÃO', 1, 0, "C", 0);
        $pdf->cell(195, $alt, 'FORNECEDOR', 1, 0, "L", 0);
        $pdf->cell(15, $alt, 'QTDD', 1, 0, "L", 0);
        $pdf->cell(25, $alt, 'VLR UNIT.', 1, 0, "L", 0);
        $pdf->cell(25, $alt, 'VLR TOTAL', 1, 1, "L", 0);


        /*
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(20, $alt, 'Unidade: ', 1, 0, "L", 1);
        $pdf->setfont('arial', '', 7);
        $pdf->cell(260, $alt, ucfirst(strtolower($m61_descr)), 1, 1, "L", 0);

        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(20, $alt, 'Qtdd.: ', 1, 0, "L", 1);
        $pdf->setfont('arial', '', 7);
        $pdf->cell(260, $alt, $pc23_quant, 1, 1, "L", 0);

        
        $pdf->setfont('arial', '', 7);
        $pdf->MultiCell(260, $alt, $text, 1, "L", 0);    

        $pdf->cell(280, 2, "", 0, 1, "L", 0);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(20, $alt, 'Colocação', 1, 0, "L", 1);
        $pdf->cell(210, $alt, 'Fornecedor', 1, 0, "L", 1);
        $pdf->cell(25, $alt, 'Vlr Unit.', 1, 0, "C", 1);
        $pdf->cell(25, $alt, 'Vlr Total', 1, 1, "C", 1);
        */
        $troca = 0;
        $p     = 0;
      }

      $pdf->setfont('arial', '', 7);
      $pdf->cell(20, $alt, $pc24_pontuacao, 1, 0, "C", $p);
      $pdf->cell(195, $alt, $fornecedor, 1, 0, "L", $p);
      $pdf->cell(15, $alt, $pc23_quant, 1, 0, "C", 0);
      $pdf->cell(25, $alt, 'R$ ' .db_formatar($pc23_vlrun, "f"), 1, 0, "C", $p);
      $pdf->cell(25, $alt, 'R$ ' .db_formatar($pc23_valor, "f"), 1, 1, "C", $p);
      

      $ordem = $l21_ordem;
      $troca = 0;
    }
  }
}
$pdf->Output();
