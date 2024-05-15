<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_fornemensalemp_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clfornemensalemp = new cl_fornemensalemp;
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
          <form name="form2" method="post" action="" >
              <tr>
                  <td width="4%" align="right" nowrap title="<?=$Tfm101_numcgm?>">
                      <?='CGM Fornecedor:'?>
                  </td>
                  <td width="96%" align="left" nowrap>
                      <?
                      db_input("fm101_numcgm",8,$Ifm101_numcgm,true,"text",4,"","chave_fm101_numcgm");
                      ?>
                  </td>
              </tr>
              <tr>
                  <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
                      <?='Nome Fornecedor:'?>
                  </td>
                  <td width="96%" align="left" nowrap>
                      <?
                      db_input("z01_nome",40,$Iz01_nome,true,"text",4,"","chave_z01_nome");
                      ?>
                  </td>
              </tr>
          </form>
      </table>
    </fieldset>
    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
    <input name="limpar" type="reset" id="limpar" value="Limpar" >
    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_fornemensalemp.hide();">
  </form>
      <?
      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_fornemensalemp.php")==true){
             include("funcoes/db_func_fornemensalemp.php");
           }else{
           $campos = "fornemensalemp.*";
           }
        }
        if(isset($chave_fm101_numcgm) && (trim($chave_fm101_numcgm)!="") ){
              $campos .= ", z01_numcgm, z01_nome ";
              $sql = $clfornemensalemp->sql_query("",$campos,"fm101_numcgm", "fm101_numcgm = {$chave_fm101_numcgm}");
        }else if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
              $sql = $clfornemensalemp->sql_query("",$campos,"z01_nome"," z01_nome like '$chave_z01_nome%' ");
        }else{
            $sql = $clfornemensalemp->sql_query($fm101_sequencial, 'fm101_sequencial, z01_numcgm, z01_nome, fm101_datafim',"fm101_sequencial" );
        }
        db_lovrot($sql,15,"()","",$funcao_js);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clfornemensalemp->sql_record($clfornemensalemp->sql_query(null, "z01_numcgm, z01_nome", null, " z01_numcgm = {$pesquisa_chave}"));
          if($clfornemensalemp->numrows!=0){
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
  </script>
  <?
}
?>
