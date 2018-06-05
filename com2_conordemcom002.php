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
//db_sel_instit();


if($data_ini!="" && $data_fim!=""){
  $sInfo = "De {$data_ini} até {$data_fim}";
}else if($data_ini!=""){
  $sInfo = "Apartir de {$data_ini}";
}else if($data_fim!=""){
  $sInfo = "Até {$data_ini}";
}

$head3 = "RELATÓRIO DE CONTROLE DE ORDEM DE COMPRAS";
$head5 = $sInfo;
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);

$troca = 1;
$alt = 4;
$total = 0;
$totg = 0;
$quebra_cod = 0;

$cor = 1;

$codmater = "";
$complmat = "";
db_postmemory($HTTP_GET_VARS);

if(($data_ini!="")&&($data_fim!="")){
  $data_ini = new DBDate($data_ini);
  $data_ini = $data_ini->getDate();
  $data_fim = new DBDate($data_fim);
  $data_fim = $data_fim->getDate();
}


db_inicio_transacao();
try {
  /*CONSULTA*/
  if($agrupar == '1'){
    $totalizador = "";
  }
  else if($agrupar == '2'){
    $totalizador = "";
  }
  else if($agrupar == '3'){
    $totalizador = "";
  }else{
    $totalizador = "";
  }

  $sSql = "
  SELECT DISTINCT on (m51_codordem,
  pc01_codmater,
  e60_codemp,
  e60_anousu,
  m51_numcgm,
  e69_dtrecebe)
  m51_codordem,
  pc01_codmater,
  e60_codemp,
  e60_anousu,
  m51_numcgm,
  e69_dtrecebe
  m51_data,
  e69_codnota,
  e69_dtnota,
  pc01_descrmater,
  destino.descrdepto AS destino,
  z01_nome,
  m51_valortotal,
  matordemitem.m52_valor as valoritem,
  m51_prazoent,
  origem.descrdepto AS solicitante,
  e53_valor,
  e53_vlranu,
  e53_vlrpag,
  e62_vltot,
  e62_quant,
  pc01_servico,
  CASE
  WHEN e69_dtrecebe IS NULL THEN 'PENDENTE'
  ELSE 'RECEBIDO'
  END AS status,
  (m51_data+m51_prazoent::int) AS dataprevista
  FROM matordem
  INNER JOIN  matordemitem      ON matordemitem.m52_codordem=matordem.m51_codordem
  LEFT JOIN   empnotaord        ON empnotaord.m72_codordem=matordem.m51_codordem
  LEFT JOIN   empnota           ON empnota.e69_codnota=empnotaord.m72_codnota
  LEFT JOIN   empempitem        ON matordemitem.m52_numemp=empempitem.e62_numemp
  AND matordemitem.m52_sequen=empempitem.e62_sequen
  INNER JOIN  empempenho       ON e62_numemp=e60_numemp
  LEFT JOIN   pcmater           ON empempitem.e62_item=pcmater.pc01_codmater
  LEFT JOIN   pagordemnota      ON e71_codnota = empnota.e69_codnota
  LEFT JOIN   pagordemele       ON  e53_codord               = pagordemnota.e71_codord
  INNER JOIN  cgm               ON cgm.z01_numcgm=matordem.m51_numcgm
  INNER JOIN  db_depart destino ON destino.coddepto=matordem.m51_depto
  INNER JOIN  db_depart origem  ON origem.coddepto=matordem.m51_deptoorigem
  LEFT JOIN   matordemanu       ON matordemanu.m53_codordem = matordem.m51_codordem
  WHERE m53_codordem IS NULL ";
  if($situacao == '0'){
    $sSql .= " AND e69_dtrecebe IS NULL ";
  }
  if($situacao == '1'){
    $sSql .= " AND e69_dtrecebe IS NOT NULL ";
  }
  if($codordem ==""){
    if($data_ini!=""){
      $sSql .= " AND m51_data>='{$data_ini}' ";
    }
    if($data_fim!=""){
      $sSql .= " AND m51_data<='{$data_fim}' ";
    }
    if($departamentos!=""){
      $sSql .= " AND (origem.coddepto IN ({$departamentos}) OR destino.coddepto IN ({$departamentos})) ";
    }
    if($materiais!=""){
      $sSql .= " AND pc01_codmater IN ({$materiais}) ";
    }
    if($fornecedor!=""){
      $sSql .= " AND m51_numcgm IN ({$fornecedor}) ";
    }
    if($fornecedor!=""){
      $sSql .= " AND m51_numcgm IN ({$fornecedor}) ";
    }
    if($empenho!=""){
      $infoEmp = explode('/', $empenho);
      $codemp = $infoEmp[0];
      $anoemp = $infoEmp[1];

      $sSql .= " AND e60_codemp = '{$codemp}' AND e60_anousu = {$anoemp} ";
    }
  }else{
    $sSql .= " AND m51_codordem = $codordem";
  }

  if($agrupar == '1'){
    $sSql .= " ORDER BY m51_numcgm, e60_codemp, m51_codordem; ";
  }
  else if($agrupar == '2'){
    $sSql .= " ORDER BY e60_codemp, m51_codordem; ";
  }
  else if($agrupar == '3'){
    $sSql .= " ORDER BY e69_dtrecebe, e60_codemp, m51_codordem; ";
  }else{
    $sSql .= " ORDER BY e60_codemp, m51_codordem; ";
  }

  //echo $sSql; die;
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

?>


<?php
$m51_codordem = 0;
$m51_numcgm = 0;
$e60_codemp = 0;
$status = 0;

$nTotalRegistrosOrdem = 0;
$nTotalRegistros = 0;

$totalPorSessao = 0;
$totalLiquidadoPorSessao = 0;
$totalEmpenhadoPorSessao = 0;

$totalGeral = 0;
$totalLiquidadoGeral = 0;
$totalEmpenhadoGeral = 0;

$troca = true;

$pdf->addpage('A4-L');
foreach($rsResultado as $oRegistro):

  if($agrupar == '1'){
    if($m51_numcgm != $oRegistro->m51_numcgm){
      $troca = true;
    }else{
      $troca = false;
    }
  }
  else if($agrupar == '2'){
    if($e60_codemp != $oRegistro->e60_codemp){
      $troca = true;
    }else{
      $troca = false;
    }
  }
  else if($agrupar == '3'){
   if($status != $oRegistro->status){
    $troca = true;
  }else{
    $troca = false;
  }
}else{

  if($e60_codemp != $oRegistro->e60_codemp){
    $troca = true;
  }else{
    $troca = false;
  }
}
  /**CONDIÇÕES PARA INSERCAO DO TOTALIZADOR
  *
  * VERIFICA SE O CRITÉRIO DE AGRUPAMENTO E NA PRIMEIRA VEZ QUE ENTRAR NO LAÇO DA CONDIÇÃO DE TROCA
  * FAZ UMA SUBQUERY E SALVA OS TOTALIZADORES DE ACORDO COM O CRITERIO DE AGRUPAMENTO E SALVA UMA VARIÁVEL
  * PARA EVITAR QUE TODA VEZ QUE ENTRAR NO LAÇO REPITA A SUBQUERY
  * CASO HAJA A TROCA, EXIBA OS TOTALIZADORES DO ANTIGO AGRUPAMENTO, ZERA AS VARIAVEIS E RECALCULA
  *
  *
  *
  **/
  if($troca || $pdf->gety() > $pdf->h - 50):

    if ($pdf->gety() > $pdf->h - 50) {
      $pdf->AddPage('A4-L');
/*      if($m51_codordem!=0){


        $pdf->SetFont('arial','B',8);
        $pdf->Cell(192,0,""                                                               ,0,1,"C",0);
        $pdf->Cell(20,$alt,"Total Registros: "                                           ,0,0,"C",0);
        $pdf->Cell(115,$alt,$nTotalRegistrosOrdem                                              ,0,0,"L",0);
        $pdf->Cell(30,$alt,"Total Empenhado:"                                              ,0,0,"L",0);
        $pdf->Cell(35,$alt,db_formatar($totalEmpenhadoPorSessao,'f')                                              ,0,0,"L",0);


        $pdf->Cell(19,$alt,"Valor Liquidado: "                                                     ,0,0,"C",0);
        $pdf->Cell(20,$alt,db_formatar($totalLiquidadoPorSessao, 'f'),0,0,"C",0);

        $pdf->Cell(17,$alt,"Valor Total: "                                                     ,0,0,"R",0);
        $pdf->Cell(20,$alt,db_formatar($totalPorSessao-$totalLiquidadoPorSessao, 'f')                               ,0,0,"L",0);

        $pdf->Cell(192,8,"",0,1,"C",0);
        $totalEmpenhadoGeral += $totalEmpenhadoPorSessao;
        $totalPorSessao=0;
        $totalLiquidadoPorSessao=0;
        $totalEmpenhadoPorSessao=0;
        $nTotalRegistrosOrdem = 0;


      }*/
    }else{

      if($m51_codordem!=0 ){

        $pdf->SetFont('arial','B',8);
        $pdf->Cell(192,0,""                                                               ,0,1,"C",0);
        $pdf->Cell(20,$alt,"Total Registros: "                                           ,0,0,"C",0);
        $pdf->Cell(115,$alt,$nTotalRegistrosOrdem                                              ,0,0,"L",0);
        $pdf->Cell(30,$alt,"Total Empenhado:"                                              ,0,0,"L",0);
        $pdf->Cell(35,$alt,db_formatar($totalEmpenhadoPorSessao, 'f')                                              ,0,0,"L",0);

//170
        $pdf->Cell(19,$alt,"Valor Liquidado: "                                                     ,0,0,"C",0);
        $pdf->Cell(20,$alt,db_formatar($totalLiquidadoPorSessao, 'f'),0,0,"C",0);

        $pdf->Cell(17,$alt,"Valor Total: "                                                     ,0,0,"R",0);
        $pdf->Cell(20,$alt,db_formatar($totalPorSessao-$totalLiquidadoPorSessao, 'f')                               ,0,0,"L",0);

        $pdf->Cell(192,8,"",0,1,"C",0);
        $totalEmpenhadoGeral += $totalEmpenhadoPorSessao;
        $totalPorSessao=0;
        $totalLiquidadoPorSessao=0;
        $totalEmpenhadoPorSessao=0;

        $nTotalRegistrosOrdem = 0;


      }
    }

    $pdf->setfont('arial','b',8);
    $pdf->cell(20,$alt,'Fornecedor: ',0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(120,$alt,$oRegistro->z01_nome,0,1,"L",0);
                // terceira linha do cabecalho

    $pdf->setfont('arial','b',8);
    $pdf->cell(20,$alt,'Solicitante: ',0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(120,$alt,$oRegistro->solicitante,0,1,"L",0);

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(23,$alt,"Nº Empenho"                                         ,1,0,"C",1);
    $pdf->Cell(27,$alt,"Ordem de Compra"                                         ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Data"                                    ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Cod. Nota"                                               ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Data Nota"                                               ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Cod. Item"                                               ,1,0,"C",1);
    $pdf->Cell(129,$alt,"Descricao do material"                                   ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Situação"                                           ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Vlr. Unitário"                                           ,1,1,"C",1);

    endif;
                // materiais
    $pdf->SetFont('arial','',7);
    $pdf->Cell(23,$alt,$oRegistro->e60_codemp.'/'.$oRegistro->e60_anousu                           ,1,0,"C",0);
    $pdf->Cell(27,$alt,$oRegistro->m51_codordem                                         ,1,0,"C",0);
    $pdf->Cell(15,$alt,db_formatar($oRegistro->m51_data, 'd')                                    ,1,0,"C",0);
    $pdf->Cell(15,$alt,$oRegistro->e69_codnota                                               ,1,0,"C",0);
    $pdf->Cell(15,$alt,db_formatar($oRegistro->e69_dtnota, 'd')                                               ,1,0,"C",0);
    $pdf->Cell(15,$alt,$oRegistro->pc01_codmater                                               ,1,0,"C",0);
    $pdf->Cell(129,$alt,substr($oRegistro->pc01_descrmater,0,60)                                   ,1,0,"C",0);
    $pdf->Cell(15,$alt,$oRegistro->status                                           ,1,0,"C",0);
    $pdf->Cell(25,$alt,db_formatar($oRegistro->valoritem, 'f')                                           ,1,1,"C",0);

    $nTotalRegistrosOrdem++;
    $nTotalRegistros++;

    $m51_codordem = $oRegistro->m51_codordem;
    $m51_numcgm = $oRegistro->m51_numcgm;
    $e60_codemp = $oRegistro->e60_codemp;
    $status = $oRegistro->status;

    $totalPorSessao += $oRegistro->valoritem;
    $totalLiquidadoPorSessao += $oRegistro->e53_vlranu;
    if($oRegistro->pc01_servico == 't'){
      $totalEmpenhadoPorSessao = ($oRegistro->e62_vltot);
    }else{
      $totalEmpenhadoPorSessao += ($oRegistro->e62_vltot);
    }

    $totalGeral += $oRegistro->valoritem;
    $totalLiquidadoGeral += $oRegistro->e53_vlranu;

    endforeach;
    if ($pdf->gety() > $pdf->h - 50) {
      $pdf->AddPage('A4-L');
    }

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(192,0,""                                                               ,0,1,"C",0);
    $pdf->Cell(20,$alt,"Total Registros: "                                           ,0,0,"C",0);
    $pdf->Cell(115,$alt,$nTotalRegistrosOrdem                                              ,0,0,"L",0);
    $pdf->Cell(30,$alt,"Total Empenhado:"                                              ,0,0,"L",0);
    $pdf->Cell(35,$alt,db_formatar($totalEmpenhadoPorSessao, 'f')                                              ,0,0,"L",0);

    $pdf->Cell(19,$alt,"Valor Liquidado: "                                                     ,0,0,"C",0);
    $pdf->Cell(20,$alt,db_formatar($totalPorSessaoLiquidado, 'f'),0,0,"C",0);

    $pdf->Cell(17,$alt,"Valor Total: "                                                     ,0,0,"R",0);
    $pdf->Cell(20,$alt,db_formatar($totalPorSessao-$totalLiquidadoPorSessao, 'f')                               ,0,0,"L",0);

    $pdf->Cell(192,8,"",0,1,"C",0);

    $totalEmpenhadoGeral += $totalEmpenhadoPorSessao;
    $pdf->SetFont('arial','B',8);
    $pdf->Cell(278,0,""                                                               ,0,1,"C",0);
    $pdf->Cell(278,0,""                                                               ,"T",1,"C",0);

    $pdf->Cell(35,$alt,"Total Geral de Registros: "                                  ,0,0,"L",0);
    $pdf->Cell(90,$alt,$nTotalRegistros                                               ,0,0,"L",0);

    $pdf->Cell(35,$alt,"Total Empenhado:"                                               ,0,0,"L",0);
    $pdf->Cell(35,$alt,db_formatar($totalEmpenhadoGeral, 'f')                                               ,0,0,"L",0);

    $pdf->Cell(17,$alt,"Total Liquidado: "                                               ,0,0,"R",0);
    $pdf->Cell(22,$alt,db_formatar($totalLiquidadoGeral  , 'f')                                           ,0,0,"C",0);

    $pdf->Cell(17,$alt,"Total Geral: "                                               ,0,0,"R",0);
    $pdf->Cell(20,$alt,db_formatar($totalGeral , 'f')                                            ,0,0,"C",0);


    $pdf->Cell(192,2,""                                                               ,0,1,"C",0);

    $pdf->Output();

    ?>
