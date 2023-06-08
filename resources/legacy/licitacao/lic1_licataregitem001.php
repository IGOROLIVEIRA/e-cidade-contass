<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licataregitem_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicataregitem = new cl_licataregitem;
$db_opcao = 1;
$db_botao = true;

if(isset($incluir)){
  
  
    $sSQLemp  = "SELECT DISTINCT
    l21_ordem,
    pc01_codmater,
    pc01_descrmater,
    m61_descr,
    pc23_quant,
    pc23_vlrun,
    pc23_percentualdesconto,
    pc21_numcgm
    FROM liclicitem
    INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
    INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
    INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
    INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
    LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
    LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
    LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
    LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
    LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
    LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
    AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
    LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
    LEFT JOIN cgm ON pc21_numcgm = z01_numcgm
    LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
    LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
    WHERE l21_codliclicita = $licitacao and pc24_pontuacao=1 and pc21_numcgm = $fornecedor
    ORDER BY l21_ordem";
    $result   = db_query($sSQLemp);

    $numrows  = pg_num_rows($result);
    db_inicio_transacao();
    for ($i = 0; $i < $numrows; $i++) {
      db_fieldsmemory($result, $i);
      
      $cllicataregitem->l222_licatareg=$l222_licatareg;
      $cllicataregitem->l222_ordem = $l21_ordem;
      $cllicataregitem->l222_item = $pc01_codmater;
      $cllicataregitem->l222_descricao = $pc01_descrmater;
      $cllicataregitem->l222_unidade = $m61_descr;
      $cllicataregitem->l222_quantidade = $pc23_quant;
      $cllicataregitem->l222_valorunit = $pc23_vlrun;
      $cllicataregitem->l222_valortot =$pc23_quant * $pc23_vlrun;
      $cllicataregitem->incluir();
      
      
    }
    db_fim_transacao();
    db_msgbox("Itens salvos com Sucesso!");
  
}else if(isset($l222_licatareg)){
  $rscllicataregitem = $cllicataregitem->sql_record("select * from licataregitem where l222_licatareg = $l222_licatareg");
  if(pg_num_rows($rscllicataregitem)>0){
    $db_opcao = 2;
  }
}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >


    <center>
  <?php
	include("forms/db_frmlicataregitem.php");
	?>
    </center>


</body>
</html>
<script>
js_tabulacaoforms("form1","l222_ordem",true,1,"l222_ordem",true);
</script>
<?php
if(isset($incluir)){
  echo " <script>
  parent.iframe_licataregitem.location.href = 'lic1_licataregitem002.php?l222_licatareg= $l222_licatareg&licitacao=$licitacao&fornecedor=$fornecedor';
  </script> ";
}
if($db_opcao==2){
  echo " <script>
  parent.iframe_licataregitem.location.href = 'lic1_licataregitem002.php?l222_licatareg=$l222_licatareg&licitacao=$licitacao&fornecedor=$fornecedor';
  </script> ";
}
?>
