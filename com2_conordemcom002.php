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

$head5 = "RELATÓRIO DE CONTROLE DE ORDEM DE COMPRAS";

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
  $order_by = " x.z01_nome, x.empenho, x.m51_codordem ";
  if($ordenar == 1){
    $order_by = " x.empenho, x.m51_codordem ";
  }
  $where =" e60_instit = ".db_getsession('DB_instit');

  if($codordem ==""){
    if($data_ini!=""){
      $where .= " AND m51_data>='{$data_ini}' ";
    }
    if($data_fim!=""){
      $where .= " AND m51_data<='{$data_fim}' ";
    }
    if($fornecedor!="" && $empenho == ""){
      $where .= " AND m51_numcgm IN ({$fornecedor}) ";
    }
    if($empenho!=""){
      $infoEmp = explode('/', $empenho);
      $codemp = $infoEmp[0];
      $anoemp = $infoEmp[1];

      $where .= " AND e60_codemp = '{$codemp}' AND e60_anousu = {$anoemp} ";
    }
  }else{
    $where .= " AND m51_codordem = $codordem";
  }
  $sSql = "SELECT DISTINCT ON ($order_by) x.m51_codordem,
                                               x.empenho,
                                               x.m51_data,
                                               x.z01_nome,
                                               x.e60_vlremp,
                                               x.e60_numemp,
                                               coalesce(coalesce(sum(x.m52_valor),0),0) AS totalordem,
                                               coalesce(coalesce(sum(x.m36_vrlanu),0),0) AS anulado,
                                               coalesce(coalesce(sum(x.lancado),0)/count(x.m51_codordem),0) AS lancado,
                                               coalesce(coalesce(sum(x.e70_vlrliq),0)/count(x.m51_codordem),0) AS liquidado,
                                               coalesce(coalesce(sum(x.lancado),0)/count(x.m51_codordem)-coalesce(sum(x.e70_vlrliq),0)/count(x.m51_codordem),0) AS aliquidar,
                                               coalesce(coalesce(sum(x.m52_valor),0) - coalesce(sum(x.m36_vrlanu),0) - coalesce(sum(x.lancado),0)/count(x.m51_codordem),0) AS alancar
                            FROM
                                (SELECT DISTINCT ON (m52_codlanc,
                                                     m51_codordem) m52_codlanc,
                                                    count(m52_codlanc) AS COUNT,
                                                    count(e70_codnota) AS counte70_codnota,
                                                    m52_vlruni,
                                                    m51_codordem,
                                                    m52_quant,
                                                    CASE
                                                        WHEN count(e70_codnota) > 0
                                                             AND count(e70_codnota) <> count(m52_codlanc) THEN m52_valor/count(e70_codnota)
                                                        ELSE m52_valor
                                                    END AS m52_valor,
                                                    e60_vlremp,
                                                    sum(coalesce(m36_vrlanu,0))/count(m52_codlanc) AS m36_vrlanu,
                                                    sum(CASE
                                                            WHEN
                                                                     (SELECT sum(m71_valor)
                                                                      FROM matestoqueitemoc
                                                                      INNER JOIN matordemitem ON matordemitem.m52_codlanc = matestoqueitemoc.m73_codmatordemitem
                                                                      INNER JOIN matestoqueitem ON matestoqueitem.m71_codlanc = matestoqueitemoc.m73_codmatestoqueitem
                                                                      INNER JOIN matordem ON matordem.m51_codordem = matordemitem.m52_codordem
                                                                      INNER JOIN matestoque AS a ON a.m70_codigo = matestoqueitem.m71_codmatestoque
                                                                      WHERE m52_codordem = x.m51_codordem) IS NULL THEN e70_vlrliq
                                                            ELSE
                                                                     (SELECT sum(m71_valor)
                                                                      FROM matestoqueitemoc
                                                                      INNER JOIN matordemitem ON matordemitem.m52_codlanc = matestoqueitemoc.m73_codmatordemitem
                                                                      INNER JOIN matestoqueitem ON matestoqueitem.m71_codlanc = matestoqueitemoc.m73_codmatestoqueitem
                                                                      INNER JOIN matordem ON matordem.m51_codordem = matordemitem.m52_codordem
                                                                      INNER JOIN matestoque AS a ON a.m70_codigo = matestoqueitem.m71_codmatestoque
                                                                      WHERE m52_codordem = x.m51_codordem)
                                                        END)/count(m52_codlanc) AS lancado,
                                                    sum(coalesce(m71_valor,0))/count(m52_codlanc) AS m71_valor,
                                                    CASE
                                                        WHEN count(m52_codlanc) = count(e70_codnota) THEN sum(e70_vlrliq)/count(m52_codlanc)
                                                        ELSE sum(e70_vlrliq)
                                                    END AS e70_vlrliq,
                                                    e60_codemp||'/'||e60_anousu AS empenho,
                                                       m51_data,
                                                       z01_numcgm||' - '||z01_nome AS z01_nome,
                                                       e60_numemp
                                 FROM matordem x
                                 LEFT JOIN empnotaord ON m72_codordem = x.m51_codordem
                                 LEFT JOIN empnotaitem ON e72_codnota = m72_codnota
                                 LEFT JOIN empnota ON e69_codnota = e72_codnota
                                 LEFT JOIN matordemitem ON matordemitem.m52_codordem=x.m51_codordem
                                 LEFT JOIN empempenho ON empempenho.e60_numemp = matordemitem.m52_numemp
                                 LEFT JOIN matestoqueitemoc ON matordemitem.m52_codlanc = matestoqueitemoc.m73_codmatordemitem
                                 LEFT JOIN matestoqueitem ON matestoqueitem.m71_codlanc = matestoqueitemoc.m73_codmatestoqueitem
                                 LEFT JOIN matordemanu ON m53_codordem = m51_codordem
                                 LEFT JOIN empnotaele ON e70_codnota = e69_codnota
                                 LEFT JOIN empelemento ON e64_numemp=e60_numemp
                                 LEFT JOIN cgm ON e60_numcgm = z01_numcgm
                                 LEFT JOIN pagordemnota ON e70_codnota = e71_codnota
                                 AND e71_anulado IS FALSE
                                 LEFT JOIN pagordemele ON e71_codord = e53_codord
                                 LEFT JOIN matordemitemanu ON m52_codlanc = m36_matordemitem
                   WHERE $where
                                GROUP BY e70_codnota,
                                              m51_codordem,
                                              m52_codlanc,
                                              e60_codemp||'/'||e60_anousu,
                                                 m51_data,
                                                 z01_numcgm||' - '||z01_nome,
                                                 e60_vlremp,
                                                 e60_numemp
                                     ORDER BY m52_codlanc,
                                              m51_codordem) x
                                GROUP BY x.m51_codordem,
                                         x.empenho,
                                         x.m51_data,
                                         x.z01_nome,
                                         x.e60_vlremp,
                                         x.e60_numemp
                                ORDER BY
              $order_by";

  //echo $sSql;die;
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

$e60_codemp = 0;
$z01_nome = $rsResultado[0]->z01_nome;

$nTotalRegistros = 0;


$troca = true;
$trocaCredor = true;
$pdf->addpage('P');
if((isset($fornecedor) && $fornecedor != "") && $empenho == "" && $codordem == ""){
  $pdf->SetFont('arial','B',8);
  $pdf->Cell(20,$alt,"Credor:",0,0,"L",0);
  $pdf->SetFont('arial','',8);
  $pdf->Cell(150,$alt,$rsResultado[0]->z01_nome,0,1,"L",0);

}
foreach($rsResultado as $oRegistro):



  if($e60_codemp != $oRegistro->empenho){
    $troca = true;
    if($z01_nome != $oRegistro->z01_nome){
      $trocaCredor = true;
    }else{
      $trocaCredor = false;
    }
  }else{
    $troca = false;
  }

  if($troca || $pdf->gety() > $pdf->h - 50):

    $sSQLemp  = " select sum((select round(rnsaldovalor,2) from fc_saldoitensempenho(e60_numemp, e62_sequencial))) as saldonaoutilizado";
    $sSQLemp .= "  from empempenho ";
    $sSQLemp .= "       inner join empempitem on e62_numemp       = e60_numemp ";
    $sSQLemp .= "       inner join pcmater    on pc01_codmater    = e62_item";
    $sSQLemp .= "       inner join pcsubgrupo on pc04_codsubgrupo = pc01_codsubgrupo";
    $sSQLemp .= "       inner join pctipo     on pc05_codtipo     = pc04_codtipo";
    $sSQLemp .= "       left  join empempaut             on empempaut.e61_numemp            = empempenho.e60_numemp";
    $sSQLemp .= "       left  join empautoriza           on empempaut.e61_autori            = empautoriza.e54_autori";
    $sSQLemp .= "       left  join empautitem            on empempaut.e61_autori            = empautitem.e55_autori and empempitem.e62_sequen          = empautitem.e55_sequen";
    $sSQLemp .= "       left join empautitempcprocitem  pcprocitemaut  on pcprocitemaut.e73_autori        = empautitem.e55_autori and pcprocitemaut.e73_sequen        = empautitem.e55_sequen";
    $sSQLemp .= "       left join pcprocitem                           on pcprocitem.pc81_codprocitem     = pcprocitemaut.e73_pcprocitem";
    $sSQLemp .= "       left join solicitem                            on solicitem.pc11_codigo           = pcprocitem.pc81_solicitem";
    $sSQLemp .= "       left join solicitemunid                on solicitemunid.pc17_codigo                = solicitem.pc11_codigo";
    $sSQLemp .= "       left join matunid                on solicitemunid.pc17_unid                = matunid.m61_codmatunid";
    $sSQLemp .= "       left join matunid matunidaut               on empautitem.e55_unid                = matunidaut.m61_codmatunid";
    $sSQLemp .= "       left join matunid matunidsol               on solicitemunid.pc17_unid                = matunidsol.m61_codmatunid";
    $sSQLemp .= " where  e60_numemp = ".$oRegistro->e60_numemp;


    $result   = db_query($sSQLemp);
    $result = db_utils::fieldsMemory($result);

    $saldonaoutilizado = $result->saldonaoutilizado;
    if($filtro == 1 && $saldonaoutilizado == 0){
      continue;
    }
    if($filtro == 2 && $oRegistro->alancar <= 0){
      continue;
    }
    if($filtro == 3 && $oRegistro->aliquidar <= 0){
      continue;
    }
    if($filtro == 4 && ($oRegistro->aliquidar <= 0 && $oRegistro->alancar <= 0 && $saldonaoutilizado <= 0)){
      continue;
    }

    if ($pdf->gety() > $pdf->h - 50) {
      $pdf->AddPage('P');

    }else{

      if($m51_codordem!=0 ){

        $pdf->Cell(192,8,"",0,1,"C",0);
        $nTotalRegistrosOrdem = 0;

      }
    }
    /**/

      $pdf->Ln();
    /**/
    if((!isset($fornecedor) || $fornecedor == "") && $trocaCredor == true || $nTotalRegistrosotal == 0){
      $pdf->SetFont('arial','B',8);
      $pdf->Cell(20,$alt,"Credor:",0,0,"L",0);
      $pdf->SetFont('arial','',8);
      $pdf->Cell(150,$alt,$oRegistro->z01_nome,0,1,"L",0);
    }

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(33,$alt,"Empenho:",1,0,"L",1);
    $pdf->SetFont('arial','',8);
    $pdf->Cell(33,$alt,$oRegistro->empenho,1,0,"L",1);

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(33,$alt,"Valor Empenhado:",1,0,"L",1);
    $pdf->SetFont('arial','',8);
    $pdf->Cell(33,$alt,number_format($oRegistro->e60_vlremp,2),1,0,"L",1);

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(33,$alt,"Saldo não utilizado:",1,0,"L",1);
    $pdf->SetFont('arial','',8);
    $pdf->Cell(25,$alt,number_format($saldonaoutilizado, 2),1,1,"L",1);

    $pdf->SetFont('arial','B',8);
    $pdf->Cell(20,$alt,"Ordem"                                         ,1,0,"C",1);
    $pdf->Cell(15,$alt,"Data"                                         ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Total da ordem"                                    ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Valor anulado"                                               ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Valor a lançar"                                           ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Valor de entrada"                                           ,1,0,"C",1);
    $pdf->Cell(25,$alt,"Valor a liquidar"                                           ,1,0,"C",1);
    $pdf->Cell(30,$alt,"Valor liquidado"                                           ,1,1,"C",1);

  endif;
                // materiais
  $pdf->SetFont('arial','',7);
  $pdf->Cell(20,$alt,$oRegistro->m51_codordem                                         ,1,0,"C",0);
  $pdf->Cell(15,$alt,db_formatar($oRegistro->m51_data, 'd')                                    ,1,0,"C",0);
  $pdf->Cell(25,$alt,$oRegistro->totalordem                                               ,1,0,"C",0);
  $pdf->Cell(25,$alt,$oRegistro->anulado                                               ,1,0,"C",0);
  $pdf->Cell(25,$alt,$oRegistro->alancar                                               ,1,0,"C",0);
  $pdf->Cell(25,$alt,$oRegistro->lancado                                               ,1,0,"C",0);
  $pdf->Cell(25,$alt,$oRegistro->aliquidar                                               ,1,0,"C",0);
  $pdf->Cell(30,$alt,$oRegistro->liquidado                                               ,1,1,"C",0);

  $nTotalRegistros++;

  $e60_codemp = $oRegistro->empenho;
  $z01_nome = $oRegistro->z01_nome;


endforeach;
if($nTotalRegistros==0){
  db_redireciona("db_erros.php?fechar=true&db_erro=Não foram encontrados registros.");
}
$pdf->Output();

?>
