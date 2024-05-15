<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_isstipoisen_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

if (!isset($chave_q147_tipo)){
  $chave_q147_tipo = '';
}

$chave_q147_descr = isset($chave_q147_descr) ? stripslashes($chave_q147_descr) : '';

if ( isset($chave_q147_tipo) && !DBNumber::isInteger($chave_q147_tipo) ) {
  $chave_q147_tipo = '';
}

$clisstipoisen = new cl_isstipoisen;
$clisstipoisen->rotulo->label("q147_tipo");
$clisstipoisen->rotulo->label("q147_descr");
?>
<html lang="">
<head>
    <title>DBSeller Informática Ltda - Página Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr>
    <td height="63" align="center" valign="top">
        <form name="form2" method="post" action="">
            <table width="35%" border="0" align="center" cellspacing="0">

                <tr>
                    <td width="4%" align="right" nowrap title="<?= $Tq147_tipo ?>">
                        <?= $Lq147_tipo ?>
                    </td>
                    <td width="96%" align="left" nowrap>
                        <?php
                        db_input("q147_tipo", 4, $Iq147_tipo, true, "text", 4, "", "chave_q147_tipo");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="4%" align="right" nowrap title="<?= $Tq147_descr ?>">
                        <?= $Lq147_descr ?>
                    </td>
                    <td width="96%" align="left" nowrap>
                        <?php
                        db_input("q147_descr", 40, $Iq147_descr, true, "text", 4, "", "chave_q147_descr");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                        <input name="limpar" type="reset" id="limpar" value="Limpar">
                        <input name="Fechar" type="button" id="fechar" value="Fechar"
                               onClick="parent.db_iframe_isstipoisen.hide();">
                    </td>
                </tr>
            </table>
        </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
        <?php

        $chave_q147_descr = addslashes($chave_q147_descr);

        if(!isset($pesquisa_chave)){
            if(isset($campos)==false){
                if(file_exists("funcoes/db_func_isstipoisen.php")==true){
                    include("funcoes/db_func_isstipoisen.php");
                }else{
                    $campos = "isstipoisen.*";
                }
            }

            if( isset($chave_q147_tipo) ){
                if (  !DBNumber::isInteger($chave_q147_tipo) ) {
                    $chave_q147_tipo = '';
                }
            }

            if(isset($chave_q147_tipo) && (trim($chave_q147_tipo)!="" && DBNumber::isInteger($chave_q147_tipo)) ){
                $sql = $clisstipoisen->sql_query($chave_q147_tipo,$campos,"q147_tipo");
            }else if(isset($chave_q147_descr) && (trim($chave_q147_descr)!="") ){
                $sql = $clisstipoisen->sql_query("",$campos,"q147_descr"," q147_descr like '$chave_q147_descr%' ");
            }else{
                $sql = $clisstipoisen->sql_query("",$campos,"q147_tipo","");
            }
            $repassa = array();
            if(isset($chave_q147_descr)){
                $repassa = array("chave_q147_tipo"=>$chave_q147_tipo,"chave_q147_descr"=>$chave_q147_descr);
            }

            if( isset($chave_q147_descr) ){
                $chave_q147_descr = str_replace("\\", "", $chave_q147_descr);
            }

            db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        }else{
            if($pesquisa_chave!=null && $pesquisa_chave!=""){
                $result = $clisstipoisen->sql_record($clisstipoisen->sql_query($pesquisa_chave));
                if($clisstipoisen->numrows!=0){
                    db_fieldsmemory($result,0);
                    echo "<script>".$funcao_js."('$q147_descr',$q147_tipoisen,false);</script>";
                }else{
                    echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                }
            }else{
                echo "<script>".$funcao_js."('',false);</script>";
            }
        }
        ?>
     </td>
   </tr>
</table>
</body>
</html>
<?php
if(!isset($pesquisa_chave)){
  ?>
  <script>
    (function(){

      if( document.getElementById('chave_q147_tipo').value !== '') {
          const oRegex = /^[0-9]+$/;
          if ( !oRegex.test( document.getElementById('chave_q147_tipo').value ) ) {
          alert('Campo Código deve ser preenchido somente com números!');
          document.getElementById('chave_q147_tipo').value = '';
          return false;
        }
      }

    })();
  </script>
    <?php
}
?>
<script>
js_tabulacaoforms("form2","chave_q147_descr",true,1,"chave_q147_descr",true);
</script>
