<?php
require "libs/db_stdlib.php";
require "libs/db_conecta.php";
include "libs/db_sessoes.php";
include "libs/db_usuariosonline.php";
include "dbforms/db_funcoes.php";
include "classes/db_protocolos_classe.php";
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clprotocolos = new cl_protocolos();
$clprotocolos->rotulo->label("p101_sequencial");
$clprotocolos->rotulo->label("p101_coddeptoorigem");
$clprotocolos->rotulo->label("p101_coddeptodestino");
$clprotocolos->rotulo->label("p101_dt_protocolo");
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
      <legend>Pesquisa de Protocolos</legend>
      <table width="50%" border="0" align="center" cellspacing="3" class="form-container">
        <tr>
          <td><label for="chave_p101_sequencial"> <?= @$Lp101_sequencial; ?> </label></td>
          <td>
            <?php db_input('p101_sequencial', 10, $Ip101_sequencial, true, 'text', 4, "", "chave_p101_sequencial");?>
          </td>
        </tr>

        <tr>
          <td><label for="chave_p101_coddeptoorigem"> <?= @$Lp101_coddeptoorigem; ?> </label></td>
          <td>
            <?php db_input('p101_coddeptoorigem', 10, $Ip101_coddeptoorigem, true, 'text', 4, "", "chave_p101_coddeptoorigem"); ?>
          </td>
        </tr>

        <tr>
          <td><label for="chave_p101_coddeptodestino"> <?= @$Lp101_coddeptodestino; ?> </label></td>
          <td>
            <?php db_input('p101_coddeptodestino', 10, $Ip101_coddeptodestino, true, 'text', 4, "", "chave_p101_coddeptodestino"); ?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_protocolos.hide();">
  </form>
      <?php
      if (!isset($pesquisa_chave)) {
        /*if (isset($campos)==false) {
           if (file_exists("funcoes/db_func_protocolos.php")==true) {
             include "funcoes/db_func_protocolos.php";
           } else {
            $campos = "protocolos.oid,protocolos.*";
           }
        }
        $sql = $clprotocolos->sql_query();
        echo $sql;die;*/
        if (isset($chave_p101_sequencial) && !empty($chave_p101_sequencial)) {
          $where   = " where protocolos.p101_sequencial = {$chave_p101_sequencial}";
        }

        if (isset($chave_p101_coddeptoorigem) && !empty($chave_p101_coddeptoorigem)) {
          $where   = " where protocolos.p101_coddeptoorigem = {$chave_p101_coddeptoorigem}";
        }

        if (isset($chave_p101_coddeptodestino) && !empty($chave_p101_coddeptodestino)) {
          $where   = " where protocolos.p101_coddeptodestino = {$chave_p101_coddeptodestino}";
        }

        $sql = "
          SELECT protocolos.p101_sequencial
                ,protocolos.p101_coddeptoorigem
                ,dor.descrdepto descrdeptoo
                ,protocolos.p101_coddeptodestino
                ,des.descrdepto descrdeptod
                ,RPAD(SUBSTR(protocolos.p101_observacao,0,13),16,'...') as p101_observacao
                ,to_char(protocolos.p101_dt_protocolo, 'DD/MM/YYYY') p101_dt_protocolo
                ,protocolos.p101_hora
                ,to_char(protocolos.p101_dt_anulado, 'DD/MM/YYYY') p101_dt_anulado
                ,db_usuarios.nome
                ,db_usuarios.id_usuario
          FROM protocolos
          INNER JOIN db_usuarios ON db_usuarios.id_usuario = protocolos.p101_id_usuario
          INNER JOIN db_depart dor ON dor.coddepto = protocolos.p101_coddeptoorigem
          INNER JOIN db_depart des ON des.coddepto = protocolos.p101_coddeptodestino
          INNER JOIN db_config ON db_config.codigo = dor.instit {$where} ORDER BY protocolos.p101_sequencial

        ";
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }
      else {
        if ($pesquisa_chave!=null && $pesquisa_chave!="") {
          $result = $clprotocolos->sql_record($clprotocolos->sql_query($pesquisa_chave));
          if ($clprotocolos->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$oid',false);</script>";
          } else {
             echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        } else {
           echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
</body>
</html>
<?php
if (!isset($pesquisa_chave)) {
  ?>
  <script>
  </script>
  <?php
}
?>
