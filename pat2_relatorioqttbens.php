<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bens_classe.php");
include("libs/db_utils.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_cfpatri_classe.php");
include("classes/db_db_depart_classe.php");
include("classes/db_departdiv_classe.php");
include("libs/db_app.utils.php");

$clrotulo 			= new rotulocampo;
$cldb_depart		= new cl_db_depart;
$clcfpatric 		= new cl_cfpatri;
$clbens					=	new cl_bens;
$cldepartdiv 		= new cl_departdiv;
$aux_orgao 			= new cl_arquivo_auxiliar;
$aux_unidade 		= new cl_arquivo_auxiliar;
$aux 						= new cl_arquivo_auxiliar;

$clrotulo->label("t04_sequencial");
$clbens->rotulo->label();
$cldb_depart->rotulo->label();

db_postmemory($HTTP_POST_VARS);

//Verifica se utiliza pesquisa por orgão sim ou não
$t06_pesqorgao = "f";
$resPesquisaOrgao	= $clcfpatric->sql_record($clcfpatric->sql_query_file(null,'t06_pesqorgao'));
if($clcfpatric->numrows > 0) {
	db_fieldsmemory($resPesquisaOrgao,0);
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php 
db_app::load('scripts.js');
db_app::load('prototype.js');
db_app::load('estilos.css');
?>
</head>
<body bgcolor=#CCCCCC>
<form class="container" name="form1" method="post" action="">
<fieldset>
<legend>Quantitativo de bens</legend>
<table class="form-container">

   
  <tr id="datas">
    <td nowrap align="right"><b>Ordem:</b></td>
    <td nowrap>
    <?
    if($t06_pesqorgao == 't'){
       	$matriz = array("depart"=>"Departamento","placa"=>"Placa","bem"=>"Cód. Bem","classi"=>"Classificação",
      "data"=>"Data de aquisição","orgao"=>"Órgão","unidade"=>"Unidade","descricao"=>"Descrição do Bem");
      }else{
      	$matriz = array("depart"=>"Departamento","placa"=>"Placa","bem"=>"Cód. Bem","classi"=>"Classificação",
      "data"=>"Data de aquisição","descricao"=>"Descrição do Bem");
      }
      
      db_select("ordenar",$matriz,true,1,"onChange='js_filtro_ordem(this.value);'");
    ?>
    </td>
  </tr>
  
   <tr id="datas">
    <td nowrap align="right"><b>Tipo:</b></td>
    <td nowrap>
    <?
    
       	$tipos = array("a"=>"Analítico","s"=>"Sintético");
      
      db_select("tipo",$tipos,true,1);
    ?>
    </td>
  </tr>
       	                             
  <tr id="datas" >
       <td nowrap align="right"><b>Aquisição em:</b>
       <td nowrap>
       <?
          db_inputdata("data_inicial","","","",true,"text",4);
       ?>&nbsp;<b>a</b>&nbsp;
       <?
          db_inputdata("data_final","","","",true,"text",4);
       ?>
       </td>
  </tr>
</table>
</fieldset>
<input type="button" value="Emitir relatório" onClick="js_emite();">
</form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
function js_emite(){
   var query        = "";
   var data_inicial = "";
   var data_final   = "";

   if (document.form1.data_inicial_dia.value != ""){
       data_inicial = new String(document.form1.data_inicial_dia.value+"/"+document.form1.data_inicial_mes.value+"/"+document.form1.data_inicial_ano.value);
  }
  if (document.form1.data_final_dia.value != ""){
       data_final   = new String(document.form1.data_final_dia.value+"/"+document.form1.data_final_mes.value+"/"+document.form1.data_final_ano.value);
  }

   query = "data_inicial="+data_inicial+"&data_final="+data_final+"&";
   query += "ordenar="+document.form1.ordenar.value+"&tipo="+document.form1.tipo.value;
  
  
   jan = window.open('pat2_relatorioqttbens002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
   jan.moveTo(0,0);
}

</script>  