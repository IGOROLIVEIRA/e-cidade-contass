<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_licatareg_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cllicatareg = new cl_licatareg;
$cllicatareg->rotulo->label("l221_sequencial");
$cllicatareg->rotulo->label("l221_licitacao");
$cllicatareg->rotulo->label("l221_numata");
$cllicatareg->rotulo->label("l221_fornecedor");
?>
<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
  <link href='estilos.css' rel='stylesheet' type='text/css'>
  <script language='JavaScript' type='text/javascript' src='scripts/scripts.js'></script>
</head>
<body>
  <form name="form2" method="post" action="" class="container">


      <table width="35%" border="0" align="center" cellspacing="3" class="form-container">
          <tr>
            <td height="63" align="center" valign="top">
                <table width="35%" border="0" align="center" cellspacing="0">
                    <form name="form2" method="post" action="">
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl221_sequencial ?>">
                                <?=@$Ll221_sequencial ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                            <?php
                                db_input("l221_sequencial", 10, $Il221_sequencial, true, "text", 4, "", "chave_l221_sequencial");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl221_licitacao ?>">
                                <?= $Ll221_licitacao ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                            <?php
                                db_input("l221_licitacao", 10, $Il221_licitacao, true, "text", 4, "", "chave_l221_licitacao");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl221_numata ?>">
                                <?= $Ll221_numata ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                            <?php
                                db_input("l221_numata", 10, $Il221_numata, true, "text", 4, "", "chave_l221_numata");
                                ?>
                            </td>
                        </tr>
                        <tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl221_fornecedor ?>">
                                <?= $Ll221_fornecedor ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                            <?php
                                db_input("l221_fornecedor", 60, $Il221_fornecedor, true, "text", 4, "", "chave_l221_fornecedor");
                                ?>
                            </td>
                        </tr>

                        <tr>

                            <td colspan="2" align="center">
                              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                              <input name="limpar" type="reset" id="limpar" value="Limpar" >
                              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_licatareg.hide();">
                            </td>
                        </tr>

                    </form>
                </table>
            </td>
          </tr>
      </table>


  </form>
  <?php
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_licatareg.php")==true){
             include("funcoes/db_func_licatareg.php");
           }else{
           $campos = "licatareg.oid,licatareg.*";
           }
        }
        $campos = "l221_sequencial,l221_licitacao,l221_numata,l221_exercicio,z01_nome,l221_dataini,l221_datafinal,l221_datapublica,l221_veiculopublica,l20_objeto";

        if(isset($chave_l221_sequencial) && (trim($chave_l221_sequencial)!="") ){
            $sql = $cllicatareg->sql_query_for(null,$campos,"l221_sequencial DESC","l221_sequencial = $chave_l221_sequencial");
        }else if(isset($chave_l221_licitacao) && (trim($chave_l221_licitacao)!="") ){
            $sql = $cllicatareg->sql_query_for(null,$campos,"l221_licitacao DESC","l221_licitacao=$chave_l221_licitacao");
        }else if(isset($chave_l221_numata) && (trim($chave_l221_numata)!="") ){
            $sql = $cllicatareg->sql_query_for(null,$campos,"l221_sequencial DESC","l221_numata like '$chave_l221_numata%'");
        }else if(isset($chave_l221_fornecedor) && (trim($chave_l221_fornecedor)!="") ){
            $sql = $cllicatareg->sql_query_for(null,$campos,"l221_sequencial DESC","l221_fornecedor=$chave_l221_fornecedor");
        }else{
            $sql = $cllicatareg->sql_query_for(null,$campos,"l221_sequencial DESC");
        }
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $cllicatareg->sql_record($cllicatareg->sql_query($pesquisa_chave));
          if($cllicatareg->numrows!=0){
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
<?php
if(!isset($pesquisa_chave)){
  ?>
  <script>
  </script>
  <?php
}
?>
