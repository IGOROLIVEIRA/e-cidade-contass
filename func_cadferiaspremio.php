<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_cadferiaspremio_classe.php");
db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcadferiaspremio = new cl_cadferiaspremio;
$clrotulo = new rotulocampo;
$clrotulo->label("r95_regist");
$clrotulo->label("z01_nome");
if(!empty($chave_ano) && !empty($chave_mes)) {
  $ano = $chave_ano;
  $mes = $chave_mes;
} else {
  $ano = $chave_ano = db_anofolha();
  $mes = $chave_mes = db_mesfolha();
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
      <legend>Dados para Pesquisa</legend>
      <table width="35%" border="0" align="center" cellspacing="3" class="form-container">
        <tr>
          <td nowrap title="<?=@$Tr95_regist?>">
             <?=@$Lr95_regist?>
          </td>
          <td> 
            <?
            db_input('r95_regist',8,$Ir95_regist,true,'text', 4, "", "chave_r95_regist")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tz01_nome?>">
             <?=@$Lz01_nome?>
          </td>
          <td> 
            <?
            db_input('z01_nome',25,$Iz01_nome,true,'text', 4, "", "chave_z01_nome")
            ?>
          </td>
        </tr>
        <? if (isset($liberaAnoMes)) { ?>
        <tr>
          <td nowrap title="Período">
             <strong>Período: </strong>
          </td>
          <td> 
            <?
            db_input('ano',4,1,true,'text', 4, "onblur='js_verificaAno()'", "chave_ano", "", "", 4);
            echo "/";
            db_input('mes',2,1,true,'text', 4, "onblur='js_verificaMes()'", "chave_mes", "", "", 2);
            ?>
          </td>
        </tr>
        <? } ?>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_cadferiaspremio.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        $sWhereChave = '';
        if(!empty($chave_r95_regist)) {
          $sWhereChave = " and r95_regist = {$chave_r95_regist}";
        }
        if(!empty($chave_z01_nome)) {
          $sWhereChave .= " and cgm.z01_nome ilike '%{$chave_z01_nome}%'";
        }
        $campos = "DISTINCT r95_sequencial,r95_regist,z01_nome,r95_perai ,r95_peraf ,r95_per1i,r95_per1f";
        $sWhere = "r95_anousu = {$ano} AND r95_mesusu = {$mes} ";
        if (!isset($liberaAnoMes)) {
          $campos = "r95_sequencial,r95_regist,z01_nome,r95_anousu,r95_mesusu,r95_perai ,r95_peraf ,r95_per1i,r95_per1f";
          $sWhere .= "AND (r95_regist,(r95_anousu||lpad(r95_mesusu,2,'0'))::integer) in
          (SELECT cad2.r95_regist,min((cad2.r95_anousu||lpad(cad2.r95_mesusu,2,'0'))::integer)
          FROM cadferiaspremio cad2
          WHERE cad2.r95_regist = cadferiaspremio.r95_regist and (cad2.r95_perai,
          cad2.r95_peraf) =
          (SELECT cad3.r95_perai,
               cad3.r95_peraf
          FROM cadferiaspremio cad3
          WHERE cad3.r95_mesusu = {$mes} and cad3.r95_regist = cad2.r95_regist ORDER BY r95_peraf DESC LIMIT 1) GROUP BY r95_regist,r95_peraf ORDER BY r95_peraf DESC LIMIT 1)";
        }
        $sWhere .= " {$sWhereChave}";
	      $sql = $clcadferiaspremio->sql_query(null, $campos, null, $sWhere);
        $repassa = array();
        echo '<div class="container">';
        echo '  <fieldset>';
        echo '    <legend>Resultado da Pesquisa</legend>';
          db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",$repassa);
        echo '  </fieldset>';
        echo '</div>';
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $campos = "cadferiaspremio.*,cgm.z01_nome";
          $sWhere = "r95_anousu = ".db_anofolha()." and r95_mesusu = ".db_mesfolha()." and r95_mesusu = (select min(r95_mesusu) from cadferiaspremio where (r95_perai,r95_peraf) = (select r95_perai,r95_peraf from cadferiaspremio where r95_mesusu = ".db_mesfolha().")) and {$sWhere}";
          $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query($pesquisa_chave, $campos, null, $sWhere));
          if($clcadferiaspremio->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$z01_nome',false);</script>";
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
    function js_verificaAno() {
      if (document.form2.chave_ano.value.length != 4) {
        alert("Ano inválido");
        document.form2.chave_ano.value = '';
      }
    }
    function js_verificaMes() {
      let mes = new Number(document.form2.chave_mes.value);
      if (mes > 12 || mes < 1) {
        alert("Mes inválido");
        document.form2.chave_mes.value = '';
      }
    }
  </script>
  <?
}
?>
