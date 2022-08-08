<?
include("libs/db_stdlib.php");
include("libs/db_conecta.php");
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
encerrar = 0;
function js_iniciar() {
  if(encerrar != 1)
    setTimeout("location.reload()",3000);
}
function vaiprabaixo() {
  window.scrollBy(0,1000000);
}
</script>
<style type="text/css">
<!--
font {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body bgcolor=#CCCCCC onLoad="js_iniciar()">
<?
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
/*
set_time_limit(0);
$result = pg_exec("select uol_chat from db_usuariosonline
                   where uol_id = ".db_getsession("DB_id_usuario")."
  	               and uol_ip = '".(isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$HTTP_SERVER_VARS['REMOTE_ADDR'])."' 
		           and uol_hora = ".db_getsession("DB_uol_hora")."");
$linhas = explode("\n",pg_result($result,0,0));
$numLinhas = sizeof($linhas);
$aux = explode("#",$linhas[1]);
$verHora1 = $aux[1];
*/
//while(1) {
  $result = pg_exec("select uol_chat from db_usuariosonline
                     where uol_id = ".db_getsession("DB_id_usuario")."
	  	             and uol_ip = '".(isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"]:$HTTP_SERVER_VARS['REMOTE_ADDR'])."' 
		             and uol_hora = ".db_getsession("DB_uol_hora")."");					 
  $linhas = explode("\n",pg_result($result,0,0));
  $numLinhas = sizeof($linhas);
  //for($i = ($numLinhas <= 10?1:($numLinhas - 10));$i < $numLinhas;$i++) {
  for($i = 1;$i < $numLinhas;$i++) {
    $aux = explode("#",$linhas[$i]);
  //  $verHora2 = $aux[1];
 //   if($verHora2 > $verHora1) {
//	  $verHora1 = $verHora2;
//	  if(db_indexOf($aux[3],"saio do chat") > 0) {
//        echo "TCHAU<br>";
//        break; 
//      }
      if($aux[0] == db_getsession("DB_id_usuario"))
        $cor = "red";
      else
        $cor = "blue";
      echo "<font style=\"color:".$cor.";font-family:Arial, Helvetica, sans-serif;font-size:11px\"><strong style=\"color:black\">".date("H:i:s",$aux[1])."&nbsp;&nbsp;(".$aux[2]."):</strong> ".$aux[3]."</font><script> vaiprabaixo(); </script><br>\n";
//	}
  }
//  flush();
//  sleep(2);
//}
?>
</body>
</html>
