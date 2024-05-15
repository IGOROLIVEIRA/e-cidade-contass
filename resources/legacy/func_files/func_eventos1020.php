<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_eventos1020_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cleventos1020 = new cl_eventos1020;
?>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
    <link href='estilos.css' rel='stylesheet' type='text/css'>
    <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>
<body>
<form name="form2" method="post" action="" class="container">
    <fieldset>
        <legend>Dados para Pesquisa</legend>
        <table width="35%" border="0" align="center" cellspacing="3" class="form-container">
        </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_eventos1020.hide();">
</form>
<?
if(!isset($pesquisa_chave)){
    if(isset($campos)==false){
        if(file_exists("funcoes/db_func_eventos1020.php")==true){
            include("funcoes/db_func_eventos1020.php");
        }else{
            $campos = "eventos1020.oid,eventos1020.*";
        }
    }
    $sql = $cleventos1020->sql_query();
    $repassa = array();
    echo '<div class="container">';
    echo '  <fieldset>';
    echo '    <legend>Resultado da Pesquisa</legend>';
    db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    echo '  </fieldset>';
    echo '</div>';
}else{
    if($pesquisa_chave!=null && $pesquisa_chave!=""){
        $result = $cleventos1020->sql_record($cleventos1020->sql_query($pesquisa_chave));
        if($cleventos1020->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$oid',false);</script>";
        }else{
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
        }
    }else{
        echo "<script>".$funcao_js."('',false);</script>";
    }
}
?>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
    ?>
    <script>
    </script>
    <?
}
?>
