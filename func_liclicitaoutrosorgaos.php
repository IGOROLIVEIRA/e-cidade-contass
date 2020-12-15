<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicitaoutrosorgaos_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clliclicitaoutrosorgaos = new cl_liclicitaoutrosorgaos;

$clliclicitaoutrosorgaos->rotulo->label("lic211_sequencial");
$clliclicitaoutrosorgaos->rotulo->label("lic211_numero");

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
              <td height="63" align="center" valign="top">
                  <table width="35%" border="0" align="center" cellspacing="0">
                      <form name="form2" method="post" action="" >
                          <tr>
                              <td width="4%" align="right" nowrap title="<?=$Tlic211_sequencial?>">
                                  <b>Cód. Sequencial:</b>
                              </td>
                              <td width="96%" align="left" nowrap>
								  <?
								  db_input("lic211_sequencial", 10, $Ilic211_sequencial, true, "text", 4, "", "chave_lic211_sequencial");
								  ?>
                              </td>
                          </tr>

                          <tr>
                              <td width="4%" align="right" nowrap title="<?=$Tl20_numero?>">
								  <b>Numeração</b>
                              </td>
                              <td width="96%" align="left" nowrap>
								  <?
								  db_input("lic211_processo",10,$Ilic211_numero,true,"text",4,"","chave_lic211_processo");
								  ?>
                              </td>
                          </tr>
                          <tr>

                          <tr>
                              <td width="4%" align="right" nowrap title="<?=$Tl03_descr?>">
								  <b>Descrição do Tipo:</b>
                              </td>
                              <td width="96%" align="left" nowrap>
								  <?
								  db_input("lic211_tipo",60,$Ilic211_tipo,true,"text",4,"","chave_lic211_tipo");
								  db_input("param",10,"",false,"hidden",3);
								  ?>
                              </td>
                          </tr>
                          <tr>
                              <td align="right">
                                  <b>Ano:</b>
                              </td>
                              <td>
								  <?php
								  db_input("lic211_anousu", 10, "int", true, "text", 1, null,"chave_lic211_anousu", null, null, 4);
								  ?>
                              </td>
                          </tr>
                      </form>
                  </table>
              </td>
          </tr>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicitaoutrosorgaos.hide();">
  </form>
      <?

      $camposCgm = " z01_numcgm,
                     z01_ender,
                     z01_numero,
                     z01_compl,
                     z01_bairro,
                     z01_munic,
                     z01_uf,
                     z01_cep,
                     z01_cadast";

      /* Mostra a descrição ao invés do número do tipo */

      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_liclicitaoutrosorgaos.php")==true){
               include("funcoes/db_func_liclicitaoutrosorgaos.php");
           }else{
               $campos = "liclicitaoutrosorgaos.oid,liclicitaoutrosorgaos.*";
           }
        }

        if(!$tipodescr){
            $campos .= ",";
            $campos .= "liclicitaoutrosorgaos.lic211_tipo,";
        }else{
            $campos .= ",";
            $campos .= "  CASE
                           WHEN lic211_tipo = 5 THEN 'Licitação realizada por outro órgão ou entidade'
                           WHEN lic211_tipo = 6 THEN 'Dispensa ou Inexigibilidade realizada por outro órgão ou entidade'
                           WHEN lic211_tipo = 7 THEN 'Licitação - Regime Diferenciado de Contratações'
                           WHEN lic211_tipo = 8 THEN 'Licitação realizada por consorcio público'
                           ELSE 'Licitação realizada por outro ente da federação'
                        END AS lic211_tipo,";
        }


		  if(isset($chave_lic211_sequencial) && (trim($chave_lic211_sequencial)!="") ){
			  $sql = $clliclicitaoutrosorgaos->sql_query(null, $campos . $camposCgm,"lic211_sequencial"," lic211_sequencial = $chave_lic211_sequencial");
		  }else if(isset($chave_lic211_processo) && (trim($chave_lic211_processo)!="") ){
			  $sql = $clliclicitaoutrosorgaos->sql_query(null, $campos . $camposCgm,"lic211_sequencial"," lic211_processo = $chave_lic211_processo ");
		  }else if(isset($chave_lic211_tipo) && (trim($chave_lic211_tipo)!="") ){
			  $sql = $clliclicitaoutrosorgaos->sql_query(null, $campos . $camposCgm,"lic211_sequencial");
			  $sql = "SELECT * from ({$sql}) as query where lic211_tipo ilike '$chave_lic211_tipo%' ";
		  }else if(isset($chave_lic211_anousu) && (trim($chave_lic211_anousu)!="")){
			  $sql = $clliclicitaoutrosorgaos->sql_query(null, $campos . $camposCgm,"lic211_sequencial"," and lic211_anousu = {$chave_lic211_anousu}");
		  }else{
              $sql = $clliclicitaoutrosorgaos->sql_query('',$campos . $camposCgm);
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
          if (isset($poo) && $poo = true) {
              $sSQL = "select z01_nome,lic211_tipo,lic211_processo,lic211_numero,lic211_anousu from liclicitaoutrosorgaos inner join cgm on z01_numcgm = lic211_orgao where lic211_sequencial = {$pesquisa_chave}";
              $result = $clliclicitaoutrosorgaos->sql_record($sSQL);
          } else {
              $result = $clliclicitaoutrosorgaos->sql_record($clliclicitaoutrosorgaos->sql_query($pesquisa_chave));
          }

          if($clliclicitaoutrosorgaos->numrows!=0){
            db_fieldsmemory($result,0);
            if (isset($poo) && $poo = true) {
                echo "<script>".$funcao_js."('$z01_nome','$lic211_tipo','$lic211_processo','$lic211_numero','$lic211_anousu',false);</script>";
            } else {
                echo "<script>" . $funcao_js . "('$oid',false);</script>";
            }
          }

          else{
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
  </script>
  <?
}
?>
