<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_rhvinculodotpatronais_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clrhvinculodotpatronais = new cl_rhvinculodotpatronais;
$db_opcao       = 1;
$db_opcao_orig  = 1;
$db_botao       = true;
$sql_erro       = false;
$iAnoUsu        = db_getsession("DB_anousu");
$iInstit        = db_getsession("DB_instit");

if (isset($incluir)) {
    
    $clrhvinculodotpatronais->rh171_anousu = $iAnoUsu;
    $clrhvinculodotpatronais->rh171_instit = $iInstit;

    $oDaoRhVinculoDotPatronais = db_utils::getDao('rhvinculodotpatronais');
    $sWhere      = " rh171_orgaoorig = {$rh171_orgaoorig} ";
    $sWhere     .= " and rh171_unidadeorig = {$rh171_unidadeorig} ";
    $sWhere     .= " and rh171_projativorig = {$rh171_projativorig} ";
    $sWhere     .= " and rh171_recursoorig = {$rh171_recursoorig} ";
    $sWhere     .= " and rh171_programaorig = {$rh171_programaorig} ";
    $sWhere     .= " and rh171_funcaoorig = {$rh171_funcaoorig} ";
    $sWhere     .= " and rh171_subfuncaoorig = {$rh171_subfuncaoorig} ";
    $sWhere     .= " and rh171_anousu = {$iAnoUsu} ";
    $sWhere     .= " and rh171_instit = {$iInstit} ";
    
    $rsVinculo  = $oDaoRhVinculoDotPatronais->sql_record($oDaoRhVinculoDotPatronais->sql_query_file(null, "*", null, $sWhere));

    if ($oDaoRhVinculoDotPatronais->numrows > 0) {
        echo 'erro<br>';
        $clrhvinculodotpatronais->erro_msg      = "Já existe de/para cadastrado para dotação original informada.";
        $clrhvinculodotpatronais->erro_status   = 0;
        $sql_erro = true;

    }

    if (!$sql_erro) {

        db_inicio_transacao();
    
        for ($iContMes = $rh171_mes; $iContMes <= 13; $iContMes++) {
            
            $clrhvinculodotpatronais->rh171_mes = $iContMes;
            $clrhvinculodotpatronais->incluir();

            if ($clrhvinculodotpatronais->erro_status == 0) {
                $sql_erro = true;
                break;
            }

        }

        db_fim_transacao($sql_erro);

    }

}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
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
if(isset($incluir)){
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
?>
