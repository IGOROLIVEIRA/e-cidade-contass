<?
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");

?>
<html>
<head>
    <title>Contass Contabilidade e Consultoria Ltda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC >

<center>
    <div style="margin-top: 20px">
        <form name="form1" method="post">
            <fieldset style="width: 550;">
                <legend><strong>Relatorio Tabela de Rubricas</strong></legend>
            </fieldset>
            <br>
            <input name="processar" type="button" onclick='js_emite();'  value="Emitir">
        </form>
    </div>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
    function js_emite() {
        query = '';
        window.open('con4_reltabrubricas002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    }
</script>
</body>
</html>