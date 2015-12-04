<?
//MODULO: educação
include("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_turma_classe.php");
include("classes/db_serie_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clturma = new cl_turma;
$clserie = new cl_serie;
$clrotulo = new rotulocampo;
$clturma->rotulo->label("ed57_i_codigo");
$clturma->rotulo->label("ed57_c_descr");
$clturma->rotulo->label("ed57_i_calendario");
$clturma->rotulo->label("ed57_i_turno");
$clrotulo->label("ed31_i_curso");
$clturma->rotulo->label("ed57_i_procedimento");
$clturma->rotulo->label("ed57_i_sala");
$escola = db_getsession("DB_coddepto");
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
  <td align="center" valign="top">
   <br><b>Turmas em <?=$anocalendario?>:</b><br><br>
   <?
   $result2 = $clserie->sql_record($clserie->sql_query("","ed11_i_sequencia as seqtranf","","ed11_i_codigo = $codserietransf "));
   if($clserie->numrows>0){
    db_fieldsmemory($result2,0);
    $limitaserie = " AND ed11_i_sequencia >= $seqtranf";
   }else{
    $limitaserie = "";
   }
   if(!isset($pesquisa_chave)){
    $campos = "turma.ed57_i_codigo,
               turma.ed57_c_descr,
               serie.ed11_c_descr,
               calendario.ed52_c_descr,
               calendario.ed52_i_ano,
               cursoedu.ed29_c_descr,
               base.ed31_c_descr,
               turno.ed15_c_nome,
               turma.ed57_i_nummatr,
               turma.ed57_i_numvagas,
               serie.ed11_i_codigo,
               serie.ed11_i_sequencia,
               calendario.ed52_i_codigo ,
               cursoedu.ed29_i_codigo,
               base.ed31_i_codigo,
               turno.ed15_i_codigo
              ";
    $sql = $clturma->sql_query("",$campos,"ed57_c_descr,ed11_i_ensino,ed11_i_sequencia"," ed52_c_passivo = 'N' AND ed57_i_escola = $escola AND ed52_i_ano = $anocalendario".$limitaserie);
    db_lovrot(@$sql,12,"()","",$funcao_js);
   }else{
    if($pesquisa_chave!=null && $pesquisa_chave!=""){
     $result = $clturma->sql_record($clturma->sql_query("","*","ed57_c_descr,ed11_i_ensino,ed11_i_sequencia"," ed52_c_passivo = 'N' AND ed57_i_codigo = $pesquisa_chave AND ed57_i_escola = $escola $limitaserie"));
     if($clturma->numrows!=0){
      db_fieldsmemory($result,0);
      echo "<script>".$funcao_js."($ed57_i_codigo,'$ed57_c_descr','$ed11_c_descr','$ed52_c_descr','$ed29_c_descr','$ed31_c_descr','$ed15_c_nome',$ed11_i_codigo,$ed52_i_codigo,$ed29_i_codigo,$ed31_i_codigo,$ed15_i_codigo,$ed57_i_nummatr,$ed57_i_numvagas,$ed11_i_sequencia,$ed52_i_ano);</script>";
     }else{
      echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado','','','','','','','','',true);</script>";
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
