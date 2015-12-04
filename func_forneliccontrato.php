<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcorcamfornelic_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clpcorcamfornelic = new cl_pcorcamfornelic;

$clrotulo = new rotulocampo;
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");

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
            <td width="4%" align="right" nowrap title="<?=$Tz01_numcgm?>">
              <?=$Lz01_numcgm?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?
           db_input("z01_numcgm",10,$Iz01_numcgm,true,"text",4,"","chave_z01_numcgm");
           ?>
            </td>
            </tr>

             <tSr>
            <td width="4%" align="right" nowrap title="<?=$Tz01_nome?>">
              <?=$Lz01_nome?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
           db_input("z01_nome",50,$Iz01_nome,true,"text",4,"","chave_z01_nome");
           ?>
            </td>
            </tr>          
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_forneliccontrato.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?
      $where = "pcorcamfornelic.pc31_liclicita = $l20_codigo";
      if(!isset($pesquisa_chave)){
        
        if(isset($campos)==false){
          
           $campos = "cgm.z01_numcgm, z01_nome,trim(z01_cgccpf) as z01_cgccpf, 
           case when length(trim(z01_cgccpf)) = 14 then 'JURIDICA' else 'FÍSICA' end as tipo, trim(z01_ender) as z01_ender, z01_munic, 
           z01_uf, z01_cep, z01_email";
           
        }
         
        if(isset($chave_z01_nome) && (trim($chave_z01_nome)!="") ){
           $sql = $clpcorcamfornelic->sql_query(null,"distinct ".$campos,"","z01_nome like '%$chave_z01_nome%'");
        }else if(isset($chave_z01_numcgm) && (trim($chave_z01_numcgm)!="") ){
           $sql = $clpcorcamfornelic->sql_query(null,"distinct ".$campos,"","z01_numcgm = $chave_z01_numcgm");
        }else{

           $sql = $clpcorcamfornelic->sql_query(null,"distinct ".$campos,"",$where);
        }
        
        db_lovrot($sql.'',15,"()","",$funcao_js);
        
        
      } else {
        
        if ($pesquisa_chave != null && $pesquisa_chave != "") {
        	
          $result = $clpcorcamfornelic->sql_record($clpcorcamfornelic->sql_query(null,"*","","z01_numcgm = $pesquisa_chave and ".$where));
                 
          if($clpcorcamfornelic->numrows != 0){
                   
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."(false,'$z01_nome');</script>";
                     
          } else {
                   
            echo "<script>".$funcao_js."(true,'Chave(".$pesquisa_chave.") não Encontrado');</script>";
          }
           
        } else {
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

