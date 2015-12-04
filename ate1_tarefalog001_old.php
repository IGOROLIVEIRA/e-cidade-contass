<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tarefa_classe.php");
include("classes/db_tarefalog_classe.php");
include("classes/db_tarefalogsituacao_classe.php");
include("classes/db_db_usuarios_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS, 2);
$cltarefa            = new cl_tarefa;
$cltarefalog         = new cl_tarefalog;
$cltarefalogsituacao = new cl_tarefalogsituacao;
$cldb_usuarios       = new cl_db_usuarios;
$clcriaabas          = new cl_criaabas;
$db_opcao = 11;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $cltarefalog->incluir($at43_sequencial);
  
  if($cltarefalog->erro_status == 1) {
  	  $cltarefalogsituacao->at48_tarefalog = $cltarefalog->at43_sequencial;
      $cltarefalogsituacao->at48_situacao  = $at48_situacao;
      $cltarefalogsituacao->incluir(null);
  }
  
  db_fim_transacao();
}
if(isset($at40_sequencial)&&$at40_sequencial!="") {
	$result = $cltarefa->sql_record($cltarefa->sql_query_envol($at40_sequencial,"*","at40_sequencial","at40_sequencial=$at40_sequencial"));
	if ($cltarefa->numrows > 0) {
	  db_fieldsmemory($result,0);
	}
	
	$at43_tarefa  = $at40_sequencial;
	$at43_usuario = $at40_responsavel;
	
	$result = $cldb_usuarios->sql_record($cldb_usuarios->sql_query($at40_responsavel,"nome","id_usuario"));
	if ($cldb_usuarios->numrows > 0) {
	  db_fieldsmemory($result,0);
	}

	$db_opcao = 1;
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
<?
	if($mostrar_logs) {
?>
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
	<?
	 $clcriaabas->identifica = array("tarefaand"=>"Andamento","tarefalog"=>"Registros"); 
	 $clcriaabas->src = array("tarefaand"=>"ate1_tarefalog004.php","tarefalog"=>"ate1_tarefalog002.php");
	 $clcriaabas->disabled   =  array("tarefalog"=>"true"); 
	 $clcriaabas->cria_abas(); 
	?>
	</td>
  </tr>
<?
	}
?>
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmtarefalog.php");
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
<?
if(isset($incluir)){
  if($cltarefalog->erro_status=="0"){
    $cltarefalog->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cltarefalog->erro_campo!=""){
      echo "<script> document.form1.".$cltarefalog->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cltarefalog->erro_campo.".focus();</script>";
    };
  }else{
    $cltarefalog->erro(true,true);
  };
};
if(isset($db_opcao)&&$db_opcao == 11) {
	echo "<script> js_pesquisatarefa(); </script>";
}
?>
