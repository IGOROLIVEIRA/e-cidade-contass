<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_empanuladotipo_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clempanuladotipo = new cl_empanuladotipo();
$clempanuladotipo->rotulo->label("e38_sequencial");
$clempanuladotipo->rotulo->label("e38_descr");
?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="estilos.css" rel="stylesheet" type="text/css">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    </head>
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <table width="35%" border="0" align="center" cellspacing="0">
                    <form name="form2" method="post" action="" >
                        <tr>
                            <td width="4%" align="right" nowrap title="<?=$Te38_sequencial?>">
                                <?=$Le38_sequencial?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?
                                db_input("e38_sequencial",8,$Ie38_sequencial,true,"text",4,"","chave_e38_sequencial");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="4%" align="right" nowrap title="<?=$Te38_descr?>">
                                <?=$Le38_descr?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?
                                db_input("e38_descr",40,$Ie38_descr,true,"text",4,"","chave_e38_descr");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar" >
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_empprestatip.hide();">
                            </td>
                        </tr>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <?
                if(!isset($pesquisa_chave)){
                    if(isset($campos)==false){
                        $campos = "empanuladotipo.*";
                    }
                    if(isset($chave_e38_sequencial) && (trim($chave_e38_sequencial)!="") ){
                        $sql = $clempanuladotipo->sql_query($chave_e38_sequencial,$campos,"e38_sequencial");
                    }else if(isset($chave_e38_descr) && (trim($chave_e38_descr)!="") ){
                        $sql = $clempanuladotipo->sql_query("",$campos,"e38_descr"," e38_descr like '$chave_e38_descr%' and e38_sequencial != 0 ");
                    }else{
                        $sql = $clempanuladotipo->sql_query("",$campos,"e38_sequencial","e38_sequencial != 0");
                    }
                    db_lovrot($sql,15,"()","",$funcao_js);
                }else{
                    if($pesquisa_chave!=null && $pesquisa_chave!=""){
                        $result = $clempanuladotipo->sql_record($clempanuladotipo->sql_query($pesquisa_chave));
                        if($clempanuladotipo->numrows!=0){
                            db_fieldsmemory($result,0);
                            echo "<script>".$funcao_js."('$e38_descr',false);</script>";
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
<?
if(!isset($pesquisa_chave)){
    ?>
    <script>
    </script>
    <?
}
?>