<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
//include("libs/db_usuariosonline.php");
include("classes/db_arrehist_classe.php");
include("dbforms/db_funcoes.php");

if (isset($_GET["procid"])){
    exec("kill -9 ".$_GET["procid"]);
    echo "<script>location.href='cfg_cconsultasativ.php'</script>";
    
}
    
?>    
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="Javascript">
function mata(id){
    if (confirm("Deseja Matar o Processo '"+id+"'?") == true){
        location.href='?procid='+id;
    }
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table>
<tr style='height:40px'><td>&nbsp;</td>
</table>
<center>
<?
$sql     = "select * from pg_stat_activity";
db_lovrot($sql, 25,"()","","mata|procpid");
?>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>




