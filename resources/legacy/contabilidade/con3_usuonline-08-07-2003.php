<?
session_start();
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");

?>
<html><!-- InstanceBegin template="/Templates/corpo.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<script>
function js_iniciar() {
  num = new Number(document.form1.atualizacao.value);
  setTimeout("document.form1.sub.click()",num * 1000);
}
</script>
<!-- InstanceEndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<!-- InstanceBeginEditable name="head" -->
<link href="estilos.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
 <!-- InstanceParam name="leftmargin" type="text" value="0" --> 
<!-- InstanceParam name="onload" type="text" value="js_iniciar()" -->
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="js_iniciar()" >
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
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"><!-- InstanceBeginEditable name="corpo" -->
	<form name="form1" method="post">
	  <table width="200" height="20" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td nowrap>Per&iacute;odo de atualiza&ccedil;&atilde;o:</td>
          <td nowrap>
              <input name="atualizacao" type="text" value="<? echo (!isset($HTTP_POST_VARS["atualizacao"])?"5":$HTTP_POST_VARS["atualizacao"]) ?>" size="2" maxlength="2">&nbsp;
			  <input type="submit" value="Atualizar" name="sub">
           </td>
        </tr>
      </table>
    </form>	  
	<center>
	<table border="1" cellspacing="0" cellpadding="5">
	<tr>
	  <th>Status</th>
	  <th>Máquina</th>
	  <th>Porta</th>
	  <th>Data</th>
	  <th>Hora</th>
	  <th>Usuário</th>
	  <th>Arquivo</th>
	</tr>
		<?
	$result = pg_exec("select * from db_usuariosonline");
	$numrows = pg_numrows($result);
    $arq = file("/proc/net/ip_conntrack");
	$nl = sizeof($arq);
      for($j = 0;$j < $numrows;$j++) {
	    $deletar = 0;
	  	for($i = 0;$i < $nl;$i++) {
	      $arq[$i] = str_replace("      "," ",$arq[$i]);
	      $cam = explode(" ",$arq[$i]);
	      $stat = $cam[3];
	      $src = strstr($arq[$i],"src=");
	      $src = substr($src,4,strpos($src,"dst=")-5);
	      $dst = strstr($arq[$i],"dst=");
	      $dst = substr($dst,4,strpos($dst,"sport=")-5);
	      $sport = strstr($arq[$i],"sport=");
	      $sport = db_parse_int(substr($sport,6,strpos($sport,"dport=")-7));
  	      $dport = strstr($arq[$i],"dport=");
	      $dport = db_parse_int(substr($dport,6,strpos($dport,"src=")-7));
	      if(pg_result($result,$j,"porta") == $sport && 
		     pg_result($result,$j,"ip") == $src && 
		     $dport == $HTTP_SERVER_VARS["SERVER_PORT"] &&
		     $dst == $HTTP_SERVER_VARS["SERVER_ADDR"]) {
		    echo "<tr><td nowrap>$cam[3]</td><td>$src</td><td>$sport</td><td>".date("d-m-Y",pg_result($result,$j,"hora"))."</td><td>".date("H:i:s",pg_result($result,$j,"hora"))."</td><td>".pg_result($result,$j,"login")."</td><td>".(pg_result($result,$j,"arquivo") == "/~dbseller/dbportal2/corpo.php"?"Entrou no Sistema":pg_result($result,$j,"arquivo"))."</td></tr>\n";
            $deletar = 1;
			break;
		  }
		}
		/*
        if($deletar == 0) {
		  echo $arq[$i];
		  pg_exec("delete from db_usuariosonline where id_uso = ".pg_result($result,$j,"id_uso")) or die("Erro(62) excluindo tabela db_usuariosonline: ".pg_errormessage());
		  exit;
		}
		*/
	  }
	?>
    </table>
	</center>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
	<!-- InstanceEndEditable --></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
