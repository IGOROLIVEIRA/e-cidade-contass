<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$sql = "SELECT ed60_i_codigo,ed11_c_descr,ed57_c_descr,ed57_i_base,ed57_i_calendario,ed60_c_situacao,ed60_c_concluida
        FROM matricula
         inner join turma on ed57_i_codigo = ed60_i_turma
         inner join serie on ed11_i_codigo = ed57_i_serie
         inner join base on ed31_i_codigo = ed57_i_base
         inner join calendario on ed52_i_codigo = ed57_i_calendario
        WHERE ed60_i_aluno = $aluno
        AND ed57_i_escola = $escola
        ORDER BY ed60_i_codigo DESC
       ";
$result = pg_query($sql);
db_fieldsmemory($result,0);
?>
<script>
 parent.document.form1.matricula.value = <?=$ed60_i_codigo?>;
 parent.document.form1.turma.value = "<?=$ed11_c_descr?>"+" / "+"<?=$ed57_c_descr?>";
 parent.document.form1.base.value = <?=$ed57_i_base?>;
 parent.document.form1.calendario.value = <?=$ed57_i_calendario?>;
 parent.document.form1.concluida.value = "<?=$ed60_c_concluida?>";
 <?if($ed60_c_concluida=="S"){
  $sql1 = "SELECT ed56_i_base
           FROM alunocurso
           WHERE ed56_i_aluno = $aluno
          ";
  $result1 = pg_query($sql1);
  db_fieldsmemory($result1,0);
  ?>
  parent.document.form1.situacao.value = "CONCLUÍDA";
  parent.document.form1.base.value = <?=$ed56_i_base?>;
 <?}else{?>
  parent.document.form1.situacao.value = "<?=$ed60_c_situacao?>";
 <?}?>
</script>
