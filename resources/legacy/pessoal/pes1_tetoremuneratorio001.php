<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tetoremuneratorio_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

$cltetoremuneratorioanterior = new cl_tetoremuneratorio;
$cltetoremuneratorio = new cl_tetoremuneratorio;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){


  db_inicio_transacao();

  $rsUltimoTeto                                    = $cltetoremuneratorioanterior->sql_record($cltetoremuneratorioanterior->sql_query(null,'*','te01_sequencial desc limit 1',''));
  $ultimoSequencial                                = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_sequencial;
  $cltetoremuneratorioanterior->te01_dtinicial     = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_dtinicial;
  $cltetoremuneratorioanterior->te01_dtfinal       = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_dtfinal;
  $cltetoremuneratorioanterior->te01_codteto       = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_codteto;
  $cltetoremuneratorioanterior->te01_tipocadastro  = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_tipocadastro;
  $cltetoremuneratorioanterior->te01_justificativa = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_justificativa;
  $cltetoremuneratorioanterior->te01_nrleiteto     = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_nrleiteto;
  $cltetoremuneratorioanterior->te01_valor         = db_utils::fieldsMemory($rsUltimoTeto, 0)->te01_valor;

  $ToDataFinal                       = date('Y-m-d',strtotime(implode('-', array_reverse(explode('/', $te01_dtinicial)))));

  $cltetoremuneratorioanterior->te01_dtfinal           = date('Y-m-d',strtotime("-1 days", strtotime($ToDataFinal)));
  $cltetoremuneratorioanterior->te01_sequencial = $ultimoSequencial;
  $cltetoremuneratorioanterior->alterar($ultimoSequencial);

  db_fim_transacao();



  db_inicio_transacao();

  $cltetoremuneratorio->incluir($te01_sequencial);

  db_fim_transacao();
}

$rsTeto       = $cltetoremuneratorio->sql_record($cltetoremuneratorio->sql_query(null,'*','te01_sequencial desc limit 1',''));
$te01_dtfinal = db_utils::fieldsMemory($rsTeto, 0)->te01_dtfinal;

if(!empty($te01_dtfinal)){

    $te01_dtinicial = date('d/m/Y', strtotime("+1 days",strtotime($te01_dtfinal)));
    $aDtinicial = explode('/',$te01_dtinicial);
    $te01_dtinicial_dia = $aDtinicial[0];
    $te01_dtinicial_mes = $aDtinicial[1];
    $te01_dtinicial_ano = $aDtinicial[2];
    $bDisable = false;

}else{
    $bDisable = true;
}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">

    <?
    db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js");
    ?>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmtetoremuneratorio.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","te01_valor",true,1,"te01_valor",true);

</script>
<?
if(isset($incluir)){
  if($cltetoremuneratorio->erro_status=="0"){
    $cltetoremuneratorio->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cltetoremuneratorio->erro_campo!=""){
      echo "<script> document.form1.".$cltetoremuneratorio->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cltetoremuneratorio->erro_campo.".focus();</script>";
    }
  }else{
    $cltetoremuneratorio->erro(true,true);
  }
}


?>
