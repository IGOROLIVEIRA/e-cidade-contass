<?
//ini_set("display_erros", "on");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_transferenciaveiculos_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$cltransferenciaveiculos = new cl_transferenciaveiculos;
$cltransferenciaveiculos->rotulo->label("ve80_sequencial");
$cltransferenciaveiculos->rotulo->label("ve80_motivo");

  $departamentos  = db_query("
                      select coddepto, descrdepto
                        from db_depart
                          inner join veiccadcentral on veiccadcentral.ve36_coddepto = db_depart.coddepto
                      where db_depart.instit = ".db_getsession("DB_instit")." order by db_depart.descrdepto
                  ");
  $aDepartamentos = db_utils::getCollectionByRecord($departamentos);

  $Departamento = array();
  $Departamento = array(""=>"selecione...");
  for ($p = 0; $p < count($aDepartamentos); $p++) {
    $Departamento[$aDepartamentos[$p]->coddepto] = $aDepartamentos[$p]->descrdepto;

  }

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
      <legend>Pesquisa de Transferência de veículos</legend>
      <table border="0" class="form-container">
        <tr>
          <td><label for="chave_ve80_sequencial"> <?= @$Lve80_sequencial; ?> </label></td>
          <td>
            <?php db_input('ve80_sequencial', 10, $Ive80_sequencial, true, 'text', 4, "", "chave_ve80_sequencial");?>
          </td>
        </tr>
        <tr>
          <td><label for="chave_ve80_coddeptodestino">Secretaria Destino: </label></td>
          <td style="width: 70px;">
            <?php db_select('chave_ve80_coddeptodestino', $Departamento, 1, $Ive80_coddeptodestino);?>
          </td>
        </tr>
        <tr>
          <td><label for="chave_ve80_motivo"> <?= @$Lve80_motivo; ?> </label></td>
          <td>
            <?php db_input('ve80_motivo', 30, $Ive80_motivo, true, 'text', 4, "", "chave_ve80_motivo");?>
          </td>
        </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_transferenciaveiculos.hide();">
  </form>
      <?
      if (!isset($pesquisa_chave)) {
        $where = null;
        $orderby  = "ve80_sequencial DESC";
        $filtro = null;
        if (isset($campos)==false) {
           if (file_exists("funcoes/db_func_transferenciaveiculos.php")==true) {
             include("funcoes/db_func_transferenciaveiculos.php");
           }
        } else {
          $campos = "transferenciaveiculos.oid,transferenciaveiculos.*";
        }

        if (isset($chave_ve80_sequencial) && !empty($chave_ve80_sequencial)) {
          $filtro  = $chave_ve80_sequencial;
          $orderby = null;
          $where   = " ve80_sequencial = {$chave_ve80_sequencial}";

        }

        if (isset($chave_ve80_coddeptodestino) && !empty($chave_ve80_coddeptodestino)) {
          $filtro  = $chave_ve80_coddeptodestino;
          $orderby = null;
          $where   = " ve80_coddeptodestino = {$chave_ve80_coddeptodestino}";

        }

        if (isset($chave_ve80_motivo) && !empty($chave_ve80_motivo)) {
          $filtro  = $chave_ve80_motivo;
          $orderby = null;
          $where   = " ve80_motivo ilike '{$chave_ve80_motivo}%'";

        }

        $sql = $cltransferenciaveiculos->sql_query($filtro,'*',$where,$orderby);

        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa,false);
        echo '  </fieldset>';
        echo '</div>';
      }

      else {

        if ($pesquisa_chave!=null && $pesquisa_chave!="") {

          $result = $cltransferenciaveiculos->sql_record($cltransferenciaveiculos->sql_query($pesquisa_chave));
          if ($cltransferenciaveiculos->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$oid',false);</script>";
          } else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }


        if (isset($codT) && !empty($codT)) {

          $sSQL = $cltransferenciaveiculos->sql_query(null, '*', "transferenciaveiculos.ve80_sequencial = {$codT}", "transferenciaveiculos.ve80_sequencial limit 1");

          $result = $cltransferenciaveiculos->sql_record($sSQL);

          if ($cltransferenciaveiculos->numrows!=0) {
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('{$descrdepto}',false);</script>";
          } else {
            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado', true);</script>";
          }

        }

        else {
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
</body>
</html>
<?
if (!isset($pesquisa_chave)) {
  ?>
  <script>

  </script>
  <?
}
?>
