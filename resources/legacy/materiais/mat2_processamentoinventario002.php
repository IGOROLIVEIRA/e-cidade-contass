<?

include("fpdf151/pdf.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");

db_postmemory($HTTP_GET_VARS);

$alt = 4;
$whereMateriais = "";
$head2 = "Relatório Analítico de Processamento de Inventário";
$head3 = "Código do Inventário: {$inventario}";
$head4 = "Período: ".implode("/", array_reverse(explode("-", $dataini)))." à ".implode("/", array_reverse(explode("-", $datafim)));
if(isset($materiais) && $materiais != ""){
  $whereMateriais = " and m60_codmater in ($materiais) ";
}
if($tipoimpressao == 1){
  //RELATÓRIO ANALÍTICO
  $pdf = new PDF();
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->SetAutoPageBreak(false);
  $pdf->SetTextColor(0,0,0);
  $pdf->SetFillColor(235);
  db_inicio_transacao();
  try {

    $sSql = "SELECT i77_inventario AS inventario,
                       descrdepto AS almoxarifado,
                       m60_codmater AS codigo_item,
                       m60_descr AS descricao_item,
                       db121_estrutural AS estrutural_subgrupo,
                       i77_estoqueinicial*i77_valormedio AS saldo_inicial,
                       i77_estoqueinicial AS quantidade_inicial,
                       i77_contagem AS contagem,
                       CASE
                           WHEN (i77_estoqueinicial-i77_contagem) > 0 THEN (i77_estoqueinicial-i77_contagem)
                           ELSE 0
                       END AS saida,
                       CASE
                           WHEN (i77_contagem-i77_estoqueinicial) > 0 THEN (i77_contagem-i77_estoqueinicial)
                           ELSE 0
                       END AS entrada,
                       CASE
                           WHEN (i77_contagem-i77_estoqueinicial)* i77_valormedio IS NULL THEN (i77_contagem-i77_estoqueinicial) * i77_valormedio
                           ELSE (i77_contagem-i77_estoqueinicial)* i77_valormedio
                       END AS diferenca,
                       (i77_contagem-i77_estoqueinicial)+i77_estoqueinicial AS quantidade_final,
                       CASE
                           WHEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial) * i77_valormedio IS NULL THEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial) * i77_valormedio
                           ELSE ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)* i77_valormedio
                       END AS valor_final
                FROM inventariomaterial x
                JOIN matestoque q ON m70_codigo = i77_estoque
                JOIN matmater ON m70_codmatmater = m60_codmater
                AND m70_coddepto = i77_db_depart
                JOIN matestoqueini w ON i77_ultimolancamento = m80_codigo
                LEFT JOIN matmaterprecomedio ON m80_data = m85_data
                AND m80_hora = m85_hora
                AND m85_matmater = m70_codmatmater
                AND m85_coddepto = i77_db_depart
                JOIN matmatermaterialestoquegrupo ON m68_matmater = m60_codmater
                JOIN materialestoquegrupo ON m68_materialestoquegrupo = m65_sequencial
                JOIN db_depart ON m70_coddepto = coddepto
                JOIN materialestoquegrupoconta ON m66_materialestoquegrupo = m65_sequencial
                AND m66_anousu = ".db_getsession('DB_anousu')."
                JOIN conplano ON (m66_codcon,
                                  m66_anousu) = (c60_codcon,
                                                 c60_anousu)
                JOIN conplanoreduz ON (c61_codcon,
                                       c61_anousu) = (c60_codcon,
                                                      c60_anousu)
                JOIN db_estruturavalor e ON m65_db_estruturavalor = db121_sequencial
                WHERE i77_inventario = $inventario $whereMateriais
                ORDER BY i77_db_depart, m60_descr";

    $rsSql       = db_query($sSql);
    $rsResultado = db_utils::getCollectionByRecord($rsSql);

    /*TRATAMENTO DE ERRO*/
    if(pg_num_rows($rsSql) == 0) {
      db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
    }
    if(!$rsSql) {
      throw new DBException('Erro ao Executar Query' . pg_last_error());
    }
  db_fim_transacao(false); //OK Sem problemas. Commit
}
catch(Exception $oException) {
  db_fim_transacao(true); //Erro, executou rollback
  db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
  print_r($oException);
}
$pdf->addpage('A4-L');

$mudaInventario = "";

$totalRegistros = 0;
$totalsaldo_inicial = 0;
$totalquantidade_inicial = 0;
$totalcontagem = 0;
$totalentrada = 0;
$totalsaida = 0;
$totaldiferenca = 0;
$totalquantidade_final = 0;
$totalvalor_final = 0;

foreach ($rsResultado as $oRegistro) {
  $totalRegistros++;
  $totalsaldo_inicial += ($oRegistro->saldo_inicial);
  $totalquantidade_inicial += ($oRegistro->quantidade_inicial);
  $totalcontagem += ($oRegistro->contagem);
  $totalentrada += ($oRegistro->entrada);
  $totalsaida += ($oRegistro->saida);
  $totaldiferenca += ($oRegistro->diferenca);
  $totalquantidade_final += ($oRegistro->quantidade_final);
  $totalvalor_final += ($oRegistro->valor_final);

  if($pdf->gety() > $pdf->h - 50){
    $pdf->AddPage('A4-L');
    $mudaInventario="";
  }
  if($mudaInventario!=$oRegistro->almoxarifado){
    $mudaInventario=$oRegistro->almoxarifado;

    $pdf->Ln();

    $pdf->setfont('arial','b',8);
    $pdf->cell(20,$alt,'Almoxarifado:',0,0,"L",0);
    $pdf->setfont('arial','',7);
    $pdf->cell(40,$alt,$oRegistro->almoxarifado,0,1,"L",0);
    $pdf->setfont('arial','b',8);
    //cebeçalho
    $pdf->cell(22,($alt*2),'Cód. do Ítem',1,0,"C",0);
    $pdf->cell(80,($alt*2),'Descrição do Ítem',1,0,"C",0);
    $pdf->cell(23,($alt*2),'Cód. Subgrupo',1,0,"C",0);
    $pdf->cell(20,($alt*2),'Saldo Inicial',1,0,"C",0);
    $pdf->cell(18,($alt*2),'Qt. Inicial',1,0,"C",0);
    $pdf->cell(18,($alt*2),'Contagem',1,0,"C",0);
    $pdf->cell(18,($alt*2),'Qt. Entrada',1,0,"C",0);
    $pdf->cell(18,($alt*2),'Qt. Saída',1,0,"C",0);
    $pdf->cell(22,($alt*2),'Diferença(R$)',1,0,"C",0);
    $pdf->cell(18,($alt*2),'Qt. Final',1,0,"C",0);
    $pdf->cell(20,($alt*2),'Vlr. Total',1,1,"C",0);

  }
  //itens
  $pdf->setfont('arial','',7);
  $pdf->cell(22,($alt*2),$oRegistro->codigo_item,1,0,"C",0);
  $pdf->cell(80,($alt*2),substr($oRegistro->descricao_item,0,50),1,0,"C",0);
  $pdf->cell(23,($alt*2),$oRegistro->estrutural_subgrupo,1,0,"C",0);
  $pdf->cell(20,($alt*2),number_format($oRegistro->saldo_inicial, 2, ',','.'),1,0,"C",0);
  $pdf->cell(18,($alt*2),number_format($oRegistro->quantidade_inicial, 2, ',','.'),1,0,"C",0);
  $pdf->cell(18,($alt*2),number_format($oRegistro->contagem, 2, ',','.'),1,0,"C",0);
  $pdf->cell(18,($alt*2),number_format($oRegistro->entrada, 2, ',','.'),1,0,"C",0);
  $pdf->cell(18,($alt*2),number_format(($oRegistro->saida), 2, ',','.'),1,0,"C",0);
  $pdf->cell(22,($alt*2),number_format($oRegistro->diferenca, 2, ',','.'),1,0,"C",0);
  $pdf->cell(18,($alt*2),number_format($oRegistro->quantidade_final, 2, ',','.'),1,0,"C",0);
  $pdf->cell(20,($alt*2),number_format($oRegistro->valor_final, 2, ',','.'),1,1,"C",0);


}

$pdf->Ln();
$pdf->setfont('arial','B',8);
$pdf->Cell(192,4,"Total de Registros: $totalRegistros",0,1,"L",0);
$pdf->Cell(278,0,"",1,1,"C",0);
$pdf->cell(22,$alt,"",0,0,"C",0);
$pdf->cell(80,$alt,"TOTAL",0,0,"C",0);
$pdf->cell(23,$alt,"",0,0,"C",0);
$pdf->cell(20,$alt,number_format($totalsaldo_inicial, 2, ',','.'),0,0,"C",0);
$pdf->cell(18,$alt,number_format($totalquantidade_inicial, 2, ',','.'),0,0,"C",0);
$pdf->cell(18,$alt,number_format($totalcontagem, 2, ',','.'),0,0,"C",0);
$pdf->cell(18,$alt,number_format($totalentrada, 2, ',','.'),0,0,"C",0);
$pdf->cell(18,$alt,number_format(($totalsaida), 2, ',','.'),0,0,"C",0);
$pdf->cell(22,$alt,number_format($totaldiferenca, 2, ',','.'),0,0,"C",0);
$pdf->cell(18,$alt,number_format($totalquantidade_final, 2, ',','.'),0,0,"C",0);
$pdf->cell(20,$alt,number_format($totalvalor_final, 2, ',','.'),0,1,"C",0);

}else{
  //RELATÓRIO SINTÉTICO
  $pdf = new PDF();
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->SetAutoPageBreak(false);
  $pdf->SetTextColor(0,0,0);
  $pdf->SetFillColor(235);

  db_inicio_transacao();
  try {
    // agrupa pelo subgrupo
    $sSql = "SELECT
                  (SELECT db121_estrutural
                   FROM db_estruturavalor
                   WHERE db121_sequencial = e.db121_estruturavalorpai) AS estrutural_grupo,

                  (SELECT db121_descricao
                   FROM db_estruturavalor
                   WHERE db121_sequencial = e.db121_estruturavalorpai) AS descricao_grupo,
                     db121_descricao AS descricao_subgrupo,
                     c61_reduz AS reduzido,
                     db121_estrutural AS estrutural_subgrupo,
                     sum((i77_estoqueinicial*i77_valormedio)) AS saldo_inicial,
                     sum(CASE
                         WHEN (i77_contagem-i77_estoqueinicial)*i77_valormedio IS NULL THEN (i77_contagem-i77_estoqueinicial)*i77_valormedio
                         ELSE (i77_contagem-i77_estoqueinicial)*i77_valormedio
                     END) AS diferenca,
                     sum(CASE
                         WHEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio IS NULL 
                          THEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio
                            ELSE ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio
                     END) AS valor_final
              FROM inventariomaterial x
              JOIN matestoque q ON m70_codigo = i77_estoque
              JOIN matmater ON m70_codmatmater = m60_codmater
              AND m70_coddepto = i77_db_depart
              JOIN matestoqueini w ON i77_ultimolancamento = m80_codigo
              LEFT JOIN matmaterprecomedio ON m80_data = m85_data
              AND m80_hora = m85_hora
              AND m85_matmater = m70_codmatmater
              AND m85_coddepto = i77_db_depart
              JOIN matmatermaterialestoquegrupo ON m68_matmater = m60_codmater
              JOIN materialestoquegrupo ON m68_materialestoquegrupo = m65_sequencial
              JOIN db_depart ON m70_coddepto = coddepto
              JOIN materialestoquegrupoconta ON m66_materialestoquegrupo = m65_sequencial
              AND m66_anousu = ".db_getsession('DB_anousu')."
              JOIN conplano ON (m66_codcon,
                                m66_anousu) = (c60_codcon,
                                               c60_anousu)
              JOIN conplanoreduz ON (c61_codcon,
                                     c61_anousu) = (c60_codcon,
                                                    c60_anousu)
              JOIN db_estruturavalor e ON m65_db_estruturavalor = db121_sequencial
              WHERE i77_inventario = $inventario $whereMateriais
              GROUP BY 1,
                       2,
                       3,
                       4,
                       5
              ORDER BY (SELECT db121_estrutural
                   FROM db_estruturavalor
                   WHERE db121_sequencial = e.db121_estruturavalorpai)";

    $rsSql       = db_query($sSql);
    $rsResultado = db_utils::getCollectionByRecord($rsSql);
    // agrupa pelo almoxarifado
    $sSqlAlm = "SELECT descrdepto,
                       sum((i77_estoqueinicial*i77_valormedio)) AS saldo_inicial,
                       sum(CASE
                               WHEN (i77_contagem-i77_estoqueinicial)*i77_valormedio IS NULL 
                                THEN (i77_contagem-i77_estoqueinicial)*i77_valormedio
                                  ELSE (i77_contagem-i77_estoqueinicial)*i77_valormedio
                           END) AS diferenca,
                       sum(CASE
                               WHEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio IS NULL 
                                THEN ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio
                                  ELSE ((i77_contagem-i77_estoqueinicial)+i77_estoqueinicial)*i77_valormedio
                           END) AS valor_final
                FROM inventariomaterial x
                JOIN matestoque q ON m70_codigo = i77_estoque
                JOIN matmater ON m70_codmatmater = m60_codmater
                AND m70_coddepto = i77_db_depart
                JOIN matestoqueini w ON i77_ultimolancamento = m80_codigo
                LEFT JOIN matmaterprecomedio ON m80_data = m85_data
                AND m80_hora = m85_hora
                AND m85_matmater = m70_codmatmater
                AND m85_coddepto = i77_db_depart
                JOIN matmatermaterialestoquegrupo ON m68_matmater = m60_codmater
                JOIN materialestoquegrupo ON m68_materialestoquegrupo = m65_sequencial
                JOIN db_depart ON m70_coddepto = coddepto
                JOIN materialestoquegrupoconta ON m66_materialestoquegrupo = m65_sequencial
                AND m66_anousu = ".db_getsession('DB_anousu')."
                JOIN conplano ON (m66_codcon,
                                  m66_anousu) = (c60_codcon,
                                                 c60_anousu)
                JOIN conplanoreduz ON (c61_codcon,
                                       c61_anousu) = (c60_codcon,
                                                      c60_anousu)
                JOIN db_estruturavalor e ON m65_db_estruturavalor = db121_sequencial
                WHERE i77_inventario = $inventario $whereMateriais
                GROUP BY 1
                ";
      $rsSqlAlm = db_query($sSqlAlm);
      $rsSqlAlm = db_utils::getCollectionByRecord($rsSqlAlm);
    /*TRATAMENTO DE ERRO*/
    if(pg_num_rows($rsSql) == 0) {
      db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
    }
    if(!$rsSql) {
      throw new DBException('Erro ao Executar Query' . pg_last_error());
    }
  db_fim_transacao(false); //OK Sem problemas. Commit
}
catch(Exception $oException) {
  db_fim_transacao(true); //Erro, executou rollback
  db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
  print_r($oException);
}
$pdf->addpage('P');


$mudaGrupo = "";
$subtotalsaldo_inicial = 0;
$subtotalvalor_final = 0;
$subtotaldiferenca = 0;

$totalsaldo_inicial = 0;
$totalvalor_final = 0;
$totaldiferenca = 0;
$totalRegistros = 0;
foreach ($rsResultado as $oRegistro) {
  $totalRegistros++;

  if($pdf->gety() > $pdf->h - 50){
    $pdf->AddPage('P');
    $mudaGrupo="";
  }
  if($mudaGrupo!=$oRegistro->estrutural_grupo){
    $mudaGrupo=$oRegistro->estrutural_grupo;
    //imprime o subtotalizador, exceto na no primeiro cabeçalho
    $pdf->setfont('arial','B',7);
    if($totalRegistros>1){

      $pdf->Cell(115,$alt,"TOTAL DO GRUPO",1,0,"R",0);
      $pdf->Cell(25,$alt,number_format($subtotalsaldo_inicial, 2, ',','.'),1,0,"C",0);
      $pdf->Cell(25,$alt,number_format($subtotalvalor_final, 2, ',','.'),1,0,"C",0);
      $pdf->Cell(25,$alt,number_format($subtotaldiferenca, 2, ',','.'),1,1,"C",0);

      $subtotalsaldo_inicial = 0;
      $subtotalvalor_final = 0;
      $subtotaldiferenca = 0;

    }
    $pdf->Ln();
    $pdf->setfont('arial','B',7);
    $pdf->Cell(9,$alt,"Grupo: ",0,0,"L",0);
    $pdf->setfont('arial','',7);
    $pdf->Cell(100,$alt,$oRegistro->descricao_grupo,0,1,"L",0);
    $pdf->setfont('arial','B',7);

    //$pdf->Cell(30,($alt*2),"Grupo",1,0,"C",0);
    $pdf->Cell(23,($alt*2),"Cód. Reduzido",1,0,"C",0);
    $pdf->Cell(27,($alt*2.),"Código Subgrupo",1,0,"C",0);
    $pdf->Cell(65,($alt*2),"Descrição do Subgrupo",1,0,"C",0);
    $pdf->Cell(25,($alt*2),"Saldo Anterior",1,0,"C",0);
    $pdf->Cell(25,($alt*2),"Saldo Final",1,0,"C",0);
    $pdf->Cell(25,($alt*2),"Diferença",1,1,"C",0);
  }
  $pdf->setfont('arial','',6);
  //$pdf->Cell(30,$alt,$oRegistro->estrutural_grupo,1,0,"C",0);
  $pdf->Cell(23,$alt,$oRegistro->reduzido,1,0,"C",0);
  $pdf->Cell(27,$alt,$oRegistro->estrutural_subgrupo,1,0,"C",0);
  $pdf->Cell(65,$alt,$oRegistro->descricao_subgrupo,1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($oRegistro->saldo_inicial, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($oRegistro->valor_final, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($oRegistro->diferenca, 2, ',','.'),1,1,"C",0);

  $subtotalsaldo_inicial += ($oRegistro->saldo_inicial);
  $subtotalvalor_final += ($oRegistro->valor_final);
  $subtotaldiferenca += ($oRegistro->diferenca);

  $totalsaldo_inicial += ($oRegistro->saldo_inicial);
  $totalvalor_final += ($oRegistro->valor_final);
  $totaldiferenca += ($oRegistro->diferenca);
  }

  $pdf->setfont('arial','B',7);
  $pdf->Cell(115,$alt,"TOTAL DO GRUPO",1,0,"R",0);
  $pdf->Cell(25,$alt,number_format($subtotalsaldo_inicial, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($subtotalvalor_final, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($subtotaldiferenca, 2, ',','.'),1,1,"C",0);

  $pdf->Ln();
  $pdf->Cell(115,$alt,"TOTAL GERAL",1,0,"R",0);
  $pdf->Cell(25,$alt,number_format($totalsaldo_inicial, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($totalvalor_final, 2, ',','.'),1,0,"C",0);
  $pdf->Cell(25,$alt,number_format($totaldiferenca, 2, ',','.'),1,1,"C",0);

  $pdf->Ln();
  $pdf->Ln();

//$pdf->Cell(84,($alt*2),"",0,0,"C",0);
  $pdf->Cell(100,($alt*2),"Total por almoxarifado",1,0,"C",0);
  $pdf->Cell(45,($alt*2),"Saldo anterior ao inventário",1,0,"C",0);
  $pdf->Cell(45,($alt*2),"Saldo final após inventário",1,1,"C",0);

// agrupamento por almoxarifado
  foreach ($rsSqlAlm as $oRegistro) {

    $pdf->setfont('arial','',6);
    //$pdf->Cell(84,$alt,"",0,0,"C",0);
    $pdf->Cell(100,$alt,$oRegistro->descrdepto,1,0,"C",0);
    $pdf->Cell(45,$alt,number_format($oRegistro->saldo_inicial, 2, ',','.'),1,0,"C",0);
    $pdf->Cell(45,$alt,number_format($oRegistro->valor_final, 2, ',','.'),1,1,"C",0);

  }
}

$pdf->Output();

?>

