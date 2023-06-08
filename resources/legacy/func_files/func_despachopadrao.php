<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_despachopadrao_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cldespachopadrao = new cl_despachopadrao;
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
            <tr>
                <td width="4%" align="left" nowrap title="p201_sequencial">Sequencial:</td>
                <td width="46%" align="left" nowrap><?  db_input("p201_sequencial",6,$Ip201_sequencial,true,"text",4,"","chave_p201_sequencial"); ?> </td>
            </tr>
            <tr>
                <td width="4%" align="left" nowrap title="p201_descricao">Descrição:</td>
                <td width="46%" align="left" nowrap><?  db_input("p201_descricao",50,$Ip201_descricao,true,"text",4,"","chave_p201_descricao"); ?> </td>
            </tr>
        </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_despachopadrao.hide();">
</form>
<?
if(!isset($pesquisa_chave)){
    if(isset($campos)==false){
        if(file_exists("funcoes/db_func_despachopadrao.php")==true){
            include("funcoes/db_func_despachopadrao.php");
        }else{
            $campos = "despachopadrao.oid,despachopadrao.*";
        }
    }
    $campos = "p201_sequencial,p201_descricao,replace(p201_textopadrao,'\n','<br>') as p201_textopadrao";

    $repassa = array("p201_sequencial" =>$p201_sequencial,
                     "p201_descricao" => $p201_descricao,
                     "p201_textopadrao" =>$p201_textopadrao);

if(isset($chave_p201_sequencial) && (trim($chave_p201_sequencial)!="") ){
    $sql = $cldespachopadrao->sql_query(null,$campos,"p201_sequencial","p201_sequencial='$chave_p201_sequencial'");
}else if (isset($chave_p201_descricao) && (trim($chave_p201_descricao)!="") ){
    $sql = $cldespachopadrao->sql_query(null,$campos,"p201_descricao","p201_descricao like '$chave_p201_descricao%'");
}else {
    $sql = $cldespachopadrao->sql_query(null,$campos,null,"1=1");
}

    echo '<div class="container">';
    echo '  <fieldset>';
    echo '    <legend>Resultado da Pesquisa</legend>';
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
    echo '  </fieldset>';
    echo '</div>';
}else{
    if($pesquisa_chave!=null && $pesquisa_chave!=""){
        $sql = "select p201_sequencial,p201_descricao,replace(p201_textopadrao,'\n','<br>') as p201_textopadrao from despachopadrao where p201_sequencial = $pesquisa_chave";
          $result = $cldespachopadrao->sql_record($sql);
        if($cldespachopadrao->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$p201_sequencial','$p201_descricao','$p201_textopadrao',true);</script>";
        }else{
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',false);</script>";
        }
    }else{
        echo "<script>".$funcao_js."('','','',false);</script>";
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
