<?
//MODULO: educação
include("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_cursoedu_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clalunocurso = new cl_alunocurso;
$clcurso = new cl_curso;
$clcurso->rotulo->label("ed29_i_codigo");
$clcurso->rotulo->label("ed29_c_descr");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
 <tr>
  <td height="63" align="center" valign="top">
   <table width="55%" border="0" align="center" cellspacing="0">
    <form name="form2" method="post" action="" >
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Ted29_i_codigo?>">
      <?=$Led29_i_codigo?>
     </td>
     <td width="96%" align="left" nowrap>
      <?db_input("ed29_i_codigo",10,$Ied29_i_codigo,true,"text",4,"","chave_ed29_i_codigo");?>
     </td>
    </tr>
    <tr>
     <td width="4%" align="right" nowrap title="<?=$Ted29_c_descr?>">
      <?=$Led29_c_descr?>
     </td>
     <td width="96%" align="left" nowrap>
       <?
       db_input("ed29_c_descr",30,@$Ied29_c_descr,true,"text",4,"","chave_ed29_c_descr");
       ?>
     </td>
    </tr>
    <tr>
     <td colspan="2" align="center">
      <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
      <input name="limpar" type="reset" id="limpar" value="Limpar" >
      <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_curso.hide();">
     </td>
    </tr>
   </form>
   </table>
    </td>
 </tr>
 <tr>
  <td align="center" valign="top">
   <?
   $escola = db_getsession("DB_coddepto");
   if(!isset($pesquisa_chave)){
    if(isset($campos)==false){
     if(file_exists("funcoes/db_func_alunocurso.php")==true){
      include("funcoes/db_func_alunocurso.php");
     }else{
      $campos = "alunocurso.*";
     }
    }

    if(isset($chave_ed29_i_codigo) && (trim($chave_ed29_i_codigo)!="") ){
     $where = " AND ed29_i_codigo = $chave_ed29_i_codigo";
    }else if(isset($chave_ed29_c_descr) && (trim($chave_ed29_c_descr)!="") ){
     $where = " AND ed29_c_descr like '$chave_ed29_c_descr%'";
    }else{
     $where = "";
    }
    $sql = "SELECT $campos
            FROM cursoedu
             inner join ensino on ensino.ed10_i_codigo = cursoedu.ed29_i_ensino
             inner join cursoescola on cursoescola.ed71_i_curso = cursoedu.ed29_i_codigo
             inner join base on base.ed31_i_curso = cursoedu.ed29_i_codigo
             inner join cursoturno on cursoturno.ed85_i_curso = cursoedu.ed29_i_codigo
            WHERE cursoescola.ed71_i_escola = $escola
            AND cursoescola.ed71_c_situacao = 'S'
            $where
            EXCEPT
            SELECT $campos
            FROM alunocurso
             inner join base on base.ed31_i_codigo = alunocurso.ed56_i_base
             inner join cursoedu on cursoedu.ed29_i_codigo = base.ed31_i_curso
             inner join ensino on ensino.ed10_i_codigo = cursoedu.ed29_i_ensino
            WHERE alunocurso.ed56_i_aluno = $aluno
           ";
    db_lovrot($sql,15,"()","",$funcao_js);
   }else{
    if(file_exists("funcoes/db_func_alunocurso.php")==true){
     include("funcoes/db_func_alunocurso.php");
    }else{
     $campos = "alunocurso.*";
    }
    if($pesquisa_chave!=null && $pesquisa_chave!=""){
    $sql = "SELECT $campos
            FROM cursoedu
             inner join ensino on ensino.ed10_i_codigo = cursoedu.ed29_i_ensino
             inner join cursoescola on cursoescola.ed71_i_curso = cursoedu.ed29_i_codigo
             inner join base on base.ed31_i_curso = cursoedu.ed29_i_codigo
            WHERE cursoescola.ed71_i_escola = $escola
            AND cursoedu.ed29_i_codigo = $pesquisa_chave
            EXCEPT
            SELECT $campos
            FROM alunocurso
             inner join base on base.ed31_i_codigo = alunocurso.ed56_i_base
             inner join cursoedu on cursoedu.ed29_i_codigo = base.ed31_i_curso
            WHERE alunocurso.ed56_i_aluno = $aluno
            ORDER BY ed29_c_descr
           ";
     $result = pg_query($sql);
     $linhas = pg_num_rows($result);
     if($linhas!=0){
      db_fieldsmemory($result,0);
      echo "<script>".$funcao_js."('$ed29_c_descr',false);</script>";
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
