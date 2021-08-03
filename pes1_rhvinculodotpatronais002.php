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
$db_opcao   = 22;
$db_botao   = false;
$iAnoUsu    = db_getsession("DB_anousu");
$iInstit    = db_getsession("DB_instit");
$sql_erro   = false;

if (isset($alterar)) {
  
    db_inicio_transacao();

    for ($iContMes = $rh171_mes; $iContMes <= 13; $iContMes++) {
        
        $clrhvinculodotpatronais->alterar(null, $rh171_orgaoorig, $rh171_unidadeorig, $rh171_projativorig,
                                            $rh171_recursoorig, $iContMes, $iAnoUsu, $iInstit);
        
        if ($clrhvinculodotpatronais->erro_status == 0) {
            $sql_erro = true;
            break;
        }

    }

    $db_opcao = 2;
    $db_opcao_orig = 3;
    db_fim_transacao($sql_erro);

} else if(isset($chavepesquisa)){
    $db_opcao = 2;
    $db_opcao_orig = 3;
    $sCampos = " rhvinculodotpatronais.*, 
                orgaoorig.o40_descr         as o40_descr_orig,
                orgaonov.o40_descr          as o40_descr_nov,
                unidadeorig.o41_descr       as o41_descr_orig,
                unidadenov.o41_descr        as o41_descr_nov,
                orcprojativorig.o55_descr   as o55_descr_orig,
                orcprojativnov.o55_descr    as o55_descr_nov,
                orctiporecorig.o15_descr    as o15_descr_orig,
                orctiporecnov.o15_descr     as o15_descr_nov";
    $result = $clrhvinculodotpatronais->sql_record($clrhvinculodotpatronais->sql_query($chavepesquisa, $sCampos)); 
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
if(isset($alterar)){
  if($clrhvinculodotpatronais->erro_status=="0"){
    $clrhvinculodotpatronais->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clrhvinculodotpatronais->erro_campo!=""){
      echo "<script> document.form1.".$clrhvinculodotpatronais->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clrhvinculodotpatronais->erro_campo.".focus();</script>";
    }
  }else{
    $clrhvinculodotpatronais->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
