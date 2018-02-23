
<?

require_once("model/relatorios/Relatorio.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
db_sel_instit();
db_postmemory($HTTP_POST_VARS);

$dInibd = $dtini;
$dFimbd = $dtfim;
$dbaixa = date("d/m/Y",db_getsession("DB_datausu"));
if (!isset($dtini)) {
  $dtini = date("d/m/Y",db_getsession("DB_datausu"));
}else{

  $dtini=date_create($dtini);
  $dtini = date_format($dtini,"d/m/Y");

}

if (!isset($dtfim)) {
  $dtfim = date("d/m/Y",db_getsession("DB_datausu"));
}else{

  $dtfim = date_create($dtfim);
  $dtfim = date_format($dtfim,"d/m/Y");
}


$head1 = "RELATÓRIO DE DISPENSA DE TOMBAMENTO";
$head3 = ($dtfim == $dtini)?"Não informado": "$dtini à $dtfim";

$head5 = "Data : "  .$dbaixa;
$head6 .= "Período : $head3 ";

$mPDF = new Relatorio('', 'A4-L');
$mPDF->addInfo($head1, 1);
// $mPDF->addInfo($head3, 3);
$mPDF->addInfo($head5, 5);
$mPDF->addInfo($head6, 6);


db_inicio_transacao();
try {

  $sSql = "SELECT
  pc01_codmater AS Material,
  pc01_descrmater AS Bem,
  e69_numero AS NF,
  z01_nome AS Fornecedor,
  coddepto AS Departamento,
  m52_vlruni AS Valor,
  e60_codemp||'/'||e60_anousu AS Empenho,
  m51_codordem AS OC,
  e139_datadispensa AS Datadispensa
  FROM
  bensdispensatombamento
  INNER JOIN
  empnotaitem ON e72_sequencial=e139_empnotaitem
  INNER JOIN
  empnota ON e69_codnota=e72_codnota
  INNER JOIN
  empempitem ON e62_sequencial=e72_empempitem
  INNER JOIN
  empempenho ON e60_numemp=e62_numemp
  INNER JOIN
  matordemitem ON (m52_numemp, m52_sequen) = (e62_numemp, e62_sequen)
  INNER JOIN
  matordem ON m51_codordem=m52_codordem
  INNER JOIN
  cgm ON z01_numcgm = e60_numcgm
  INNER JOIN
  db_depart ON m51_depto=coddepto
  INNER JOIN
  pcmater ON pc01_codmater=e62_item
  ";
  $sWhere = "";
  $sCondicoes = "";

  if($head3!="Não informado"){

    $sWhere = " WHERE ";
    $sCondicoes .= $sWhere."e69_dtrecebe >= '{$dInibd}' AND e69_dtrecebe <= '{$dFimbd}' ";

  }
  if(($pc01_codmater)!=""){
    if($sWhere ==""){
      $sWhere = " WHERE ";
    }else{
      $sWhere = " AND ";
    }
    $sCondicoes .= $sWhere."pc01_codmater=$pc01_codmater";
  }
  if(($z01_numcgm)!=""){
    if($sWhere ==""){
      $sWhere = " WHERE ";
    }else{
      $sWhere = " AND ";
    }
    $sCondicoes .= $sWhere."z01_numcgm=$z01_numcgm";
  }
  if(($e69_numero)!="" && ($e69_numero)!="S/N"){
    if($sWhere ==""){
      $sWhere = " WHERE ";
    }else{
      $sWhere = " AND ";
    }
    $sCondicoes .= $sWhere."e69_numero='$e69_numero'";
  }
  $sSql .= $sCondicoes;
  $sSql .= " ORDER BY e139_datadispensa, pc01_codmater";
  $rsSql = db_query($sSql);
  $rsResultado = db_utils::getCollectionByRecord($rsSql);


  if(pg_num_rows($rsSql)==0){
    //db_redireciona("db_erros.php?fechar=true&db_erro=Não forão encontrados registros.");
  }

  if ( !$rsSql ) {
    throw new DBException('Erro ao Executar Query' .
      pg_last_error() );
  }
 db_fim_transacao(false);//OK Sem problemas. Commit
} catch ( Exception $oException ) {
 db_fim_transacao(true);//Erro, executou rollback
// db_redireciona("db_erros.php?fechar=true&db_erro=Não forão encontrados registros.");
 //print_r($oException);
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Relatório</title>
  <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">

</head>
<body>
  <div class="content">
    <table id="tableTombabemto" style=" width:100%; border-collapse: collapse;">
      <tr style="border:1px solid black;">
        <th style="font-size:14px; width:5%; border:1px solid black;" >Material</th>
        <th style="font-size:14px; width:20%; border:1px solid black;" >Bem</th>
        <th style="font-size:14px; width:10%; border:1px solid black;" >NF</th>
        <th style="font-size:14px; width:20%;border:1px solid black;" >Fornecedor</th>
        <th style="font-size:14px; width:5%; border:1px solid black;" >Depto.</th>
        <th style="font-size:14px; width:7%; border:1px solid black;" >Valor</th>
        <th style="font-size:14px; width:7%; border:1px solid black;" >Empenho</th>
        <th style="font-size:14px; width:10%; border:1px solid black;" >Ordem de Compra</th>
        <th style="font-size:14px; width:10%; border:1px solid black;" >Data Dispensa</th>
      </tr>
      <?php
      setlocale(LC_MONETARY, 'pt_BR');
      $valorTotal = 0;
      $i=0;
      ?>
      <?php foreach ($rsResultado as $oRegistro): ?>

        <tr align="center">
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->material; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->bem; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->nf; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->fornecedor; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->departamento; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo money_format('%#10n', $oRegistro->valor); ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->empenho; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo $oRegistro->oc; ?></td>
          <td  style="text-align:center; border:1px solid #333333; height: 60px;font-size:12px;"><?php echo date_format(date_create($oRegistro->datadispensa), 'd/m/Y'); ?></td>
        </tr>
        <?php
        $i++;
        if($i==9):
          $i=0;
        ?>
        <tr style="border:1px solid black;">
          <th style="font-size:14px; width:5%; border:1px solid black;" >Material</th>
          <th style="font-size:14px; width:20%; border:1px solid black;" >Bem</th>
          <th style="font-size:14px; width:10%; border:1px solid black;" >NF</th>
          <th style="font-size:14px; width:20%;border:1px solid black;" >Fornecedor</th>
          <th style="font-size:14px; width:5%; border:1px solid black;" >Depto.</th>
          <th style="font-size:14px; width:7%; border:1px solid black;" >Valor</th>
          <th style="font-size:14px; width:7%; border:1px solid black;" >Empenho</th>
          <th style="font-size:14px; width:10%; border:1px solid black;" >Ordem de Compra</th>
          <th style="font-size:14px; width:10%; border:1px solid black;" >Data Dispensa</th>
        </tr>
      <?php endif; ?>
      <?php $valorTotal+=$oRegistro->valor; ?>
    <?php endforeach; ?>


    <tr>
      <td colspan="9">

        <br>
        <hr>
      </td>
    </tr>
    <tr>
      <th colspan="5" align="left">Total de registros: <?php echo count($rsResultado); ?></th>
      <th colspan="4" align="right">Valor total dos bens dispensados: <?php echo money_format('%#10n', $valorTotal); ?></th>
    </tr>
  </table>
</div>
</body>
</html>

<?php

$html = ob_get_contents();

ob_end_clean();

try {

  $mPDF->WriteHTML(utf8_encode($html));
  $mPDF->Output();

} catch (Exception $e) {

  print_r($e->getMessage());

}


?>




