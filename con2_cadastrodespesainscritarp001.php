<?php
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_orctiporec_classe.php");
include("classes/db_disponibilidadecaixa_classe.php");

db_postmemory($HTTP_POST_VARS);

if ($incluir) {
    db_inicio_transacao();
    $sqlerro = false;

    foreach ($aFonte as $fonte){

        $cldisponibilidadecaixa = new cl_disponibilidadecaixa();

        $cldisponibilidadecaixa->c224_fonte = $fonte['fonte'];
        $cldisponibilidadecaixa->c224_vlrcaixabruta = $fonte['vlr_dispCaixaBruta'];
        $cldisponibilidadecaixa->c224_rpexercicioanterior = $fonte['vlr_rpExerAnteriores'];
        if( db_getsession("DB_anousu") < 2020) {
          $cldisponibilidadecaixa->c224_vlrrestoarecolher = $fonte['vlr_restArecolher'];
          $cldisponibilidadecaixa->c224_vlrrestoregativofinanceiro = $fonte['vlr_restRegAtivoFinan'];
        }else{
          $cldisponibilidadecaixa->c224_vlrrestoarecolher = 0;
          $cldisponibilidadecaixa->c224_vlrrestoregativofinanceiro = 0;
        }
        $cldisponibilidadecaixa->c224_vlrdisponibilidadecaixa = $fonte['vlr_DispCaixa'];
        $cldisponibilidadecaixa->c224_anousu = db_getsession("DB_anousu");
        $cldisponibilidadecaixa->c224_instit = db_getsession("DB_instit");
        $result = $cldisponibilidadecaixa->sql_record($cldisponibilidadecaixa->sql_query(null,"c224_fonte",null," c224_fonte = {$fonte['fonte']} and c224_anousu = ". db_getsession("DB_anousu") ." and c224_instit = {$cldisponibilidadecaixa->c224_instit}"));

        if(pg_num_rows($result) == 0){
            $cldisponibilidadecaixa->incluir();
        }else{
            $cldisponibilidadecaixa->alterar(null);
        }
        if ($cldisponibilidadecaixa->erro_status == 0) {
            $sqlerro = true;
        }
    }
    db_fim_transacao($sqlerro);
}
//if ($cldisponibilidadecaixa->erro_status != 1) {
//    throw new Exception(
//        db_msgbox($cldisponibilidadecaixa->erro_msg),
//        $cldisponibilidadecaixa->erro_status
//    );
//}else{
//    db_msgbox($cldisponibilidadecaixa->erro_msg);
//}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextFieldData.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/roundDecimal.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default">
<center>
    <?
    if( db_getsession("DB_anousu") < 2020) {

      include("forms/db_frmcadastrodespesainscritarp2019.php");

    }else{

      include("forms/db_frmcadastrodespesainscritarp.php");

    }
    ?>
</center>
<?php db_menu(); ?>
</body>
</html>
