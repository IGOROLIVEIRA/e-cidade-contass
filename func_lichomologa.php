<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicita_classe.php");
include("classes/db_liclicitem_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;

$clliclicita->rotulo->label("l20_codigo");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");

$sWhereContratos = " and 1 = 1 ";
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
            <td width="4%" align="right" nowrap title="<?=$Tl20_codigo?>">
              <?=$Ll20_codigo?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
		       db_input("l20_codigo",10,$Il20_codigo,true,"text",4,"","chave_l20_codigo");
		       ?>
            </td>
            </tr>

             <tr>
            <td width="4%" align="right" nowrap title="<?=$Tl20_edital?>">
              <?=$Ll20_edital?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
           db_input("l20_edital",10,$Il20_edital,true,"text",4,"","chave_l20_edital");
           ?>
            </td>
            </tr>

            <tr>
            <td width="4%" align="right" nowrap title="<?=$Tl20_numero?>">
              <?=$Ll20_numero?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
		       db_input("l20_numero",10,$Il20_numero,true,"text",4,"","chave_l20_numero");
		       ?>
            </td>
          </tr>
           <tr>

          <tr>
          <td width="4%" align="right" nowrap title="<?=$Tl03_descr?>">
              <?=$Ll03_descr?>
            </td>
            <td width="96%" align="left" nowrap>
              <?
	        db_input("l03_descr",60,$Il03_descr,true,"text",4,"","chave_l03_descr");
                db_input("param",10,"",false,"hidden",3);
	      ?>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicita.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <?
      $and            = "and ";
      $dbwhere        = "";
      if (isset($tipo) && trim($tipo)!=""){
           $dbwhere   = "l08_altera is true and";
      }
      $situacao = 1;
			if (isset($situacao) && trim($situacao) != '') {

             $dbwhere .= "l20_licsituacao = $situacao and l200_data <= '". date('Y-m-d',db_getsession('DB_datausu')) ."'
             and l11_data <= '". date('Y-m-d',db_getsession('DB_datausu')) ."' and ";

			}
			$sWhereModalidade = "";

			if (isset($iModalidadeLicitacao) && !empty($iModalidadeLicitacao)) {
			  $sWhereModalidade = "and l20_codtipocom = {$iModalidadeLicitacao}";
			}

      $dbwhere_instit = "l20_instit = ".db_getsession("DB_instit"). "{$sWhereModalidade}";


      if (isset($lContratos) && $lContratos == 1 ) {

        $sWhereContratos .= " and ac24_sequencial is null ";
      }

      /**
       * ValidaFornecedor:
       * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
       * @see ocorrência 2278
       */

      if ($validafornecedor == "1"){
          $whereHab = " and exists (select 1 from habilitacaoforn where l206_licitacao = liclicita.l20_codigo) ";
          $whereHab .= "AND l03_pctipocompratribunal NOT IN (100,101,102,103)";
      }

      if(!isset($pesquisa_chave)){

        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_liclicita.php")==true){
             include("funcoes/db_func_liclicita.php");
           }else{
           $campos = "liclicita.*, liclicitasituacao.l11_sequencial";
           }
        }

        $campos .= ", (select max(l11_sequencial) as l11_sequencial from liclicitasituacao where l11_liclicita = l20_codigo) as l11_sequencial ";

        if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
	         $sql = $clliclicita->sql_queryContratosContass(null," " . $campos,"l20_codigo","l20_codigo = $chave_l20_codigo $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
        }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
	         $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l20_numero=$chave_l20_numero $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
	      }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
	         $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l03_descr like '$chave_l03_descr%' $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
        }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
	         $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l03_codigo=$chave_l03_codigo $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
        }else if(isset($chave_l20_edital) && (trim($chave_l20_edital)!="")){
         $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l20_edital=$chave_l20_edital $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
        }else{
                 $sql = $clliclicita->sql_queryContratosContass(""," " .$campos,"l20_codigo","$dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
        }

        if (isset($param) && trim($param) != ""){
	         $dbwhere = " and (e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))";
           if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
	           $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l20_codigo = $chave_l20_codigo$dbwhere $whereHab");
	         }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
	           $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l20_numero=$chave_l20_numero$dbwhere $whereHab");
	         }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
	           $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l03_descr like '$chave_l03_descr%'$dbwhere $whereHab");
           }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
	           $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l03_codigo=$chave_l03_codigo$dbwhere $whereHab");
           } else {
             $sql = $clliclicitem->sql_query_inf("",$campos,"l20_codigo","1=1$dbwhere $whereHab");
           }
	      }
        db_lovrot($sql.' desc ',15,"()","",$funcao_js);


      } else {

        if ($pesquisa_chave != null && $pesquisa_chave != "") {
            if (isset($param) && trim($param) != ""){

              $result = $clliclicitem->sql_record($clliclicitem->sql_query_inf($pesquisa_chave));

              if ($clliclicitem->numrows!=0) {

                db_fieldsmemory($result,0);
                /**
                 *
                 * Adicionado o campo pc50_descr, removido o campo $l20_codigo e, coforme solicitado por Deborah@contass,
                 * inserido a numeração da modalidade. linhas: 187 e 197.
                 *
                 */

                echo "<script>".$funcao_js."('$pc50_descr $l20_numero',false);</script>";
              }else{
  	            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
              }
	          } else {
                 $dbwhere .= " pctipocompra.pc50_pctipocompratribunal not in (100, 101, 102, 103) AND ";
                 $result = $clliclicita->sql_record($clliclicita->sql_queryContratosContass(null,"*",null,"l20_codigo = $pesquisa_chave $and $dbwhere $dbwhere_instit"));
                 if($clliclicita->numrows != 0){

                     db_fieldsmemory($result,0);
                     echo "<script>".$funcao_js."('$pc50_descr $l20_numero',false);</script>";

                 } else {

	                 echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                 }
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
?>
