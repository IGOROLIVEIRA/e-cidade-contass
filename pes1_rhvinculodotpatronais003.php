<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_rhvinculodotpatronais_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clrhvinculodotpatronais = new cl_rhvinculodotpatronais;
$db_botao       = false;
$db_opcao       = 33;
$db_opcao_orig  = 33;
$iAnoUsu        = db_getsession("DB_anousu");
$iInstit        = db_getsession("DB_instit");
$sql_erro       = false;

if (isset($excluir)) {
  
    db_inicio_transacao();   
    
    for ($iContMes = $rh171_mes; $iContMes <= 13; $iContMes++) {
        
        $clrhvinculodotpatronais->excluir(null, $rh171_orgaoorig, $rh171_unidadeorig, $rh171_projativorig,
                                            $rh171_recursoorig, $iContMes, $iAnoUsu, $iInstit, null);

        if ($clrhvinculodotpatronais->erro_status == 0) {
            $sql_erro = true;
            break;
        }

    }

    $db_opcao = 3;
    $db_opcao_orig = 3;
    db_fim_transacao($sql_erro);

} else if(isset($chavepesquisa)) {

    $db_opcao = 3;
    $result = $clrhvinculodotpatronais->sql_record($clrhvinculodotpatronais->sql_query($chavepesquisa)); 
    db_fieldsmemory($result,0);
    $db_botao = true;

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
<br /><br />

    <center>
        <? include("forms/db_frmrhvinculodotpatronais.php"); ?>
    </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($clrhvinculodotpatronais->erro_status=="0"){
    $clrhvinculodotpatronais->erro(true,false);
  }else{
    $clrhvinculodotpatronais->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
