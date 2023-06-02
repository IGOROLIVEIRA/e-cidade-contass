<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precoreferencia_classe.php");
include("classes/db_infocomplementares_classe.php");
include("dbforms/db_funcoes.php");
require("libs/db_utils.php");
db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$clinfocomplementares     = new cl_infocomplementares;

/**
 * inserir ou atualizar registro
 */
if (isset($btnSalvar)){

	db_inicio_transacao();
	$clinfocomplementares->si08_anousu = db_getsession("DB_anousu");
	$clinfocomplementares->si08_instit = db_getsession("DB_instit");
	$result = $clinfocomplementares->sql_record($clinfocomplementares->sql_query(null,"*",null,"si08_instit = ".db_getsession("DB_instit")));
	if (pg_num_rows($result) == 0) {
	
		$clinfocomplementares->incluir(null);
	
	  if ($clinfocomplementares->erro_status == 0) {
		  $sqlerro = true;
	  }
	
	}  else {
		//	echo db_utils::fieldsMemory($result, 0)->si08_sequencial;exit;

		$clinfocomplementares->si08_sequencial = db_utils::fieldsMemory($result, 0)->si08_sequencial;
	  $clinfocomplementares->alterar($clinfocomplementares->si08_sequencial);
	
	  if ($clinfocomplementares->erro_status == 0) {
		  $sqlerro = true;
	  }
		
	}
	db_fim_transacao($sqlerro);
	db_msgbox($clinfocomplementares->erro_msg);
	
}

$result = $clinfocomplementares->sql_record($clinfocomplementares->sql_query(null,"*",null,"si08_instit = ".db_getsession("DB_instit"))); 

if (pg_num_rows($result) > 0) {
	
	db_fieldsmemory($result,0);
	$db_opcao = 2;
	
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
</table>
    <center>
	<?
	include("forms/frmsicominfocomplementar.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>


  
