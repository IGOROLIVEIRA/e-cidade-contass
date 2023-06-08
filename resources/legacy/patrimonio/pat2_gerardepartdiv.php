<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require("std/db_stdClass.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_parcustos_classe.php");
require("libs/db_utils.php");

db_postmemory($HTTP_POST_VARS);

$clparcustos = new cl_parcustos;
$aux = new cl_arquivo_auxiliar;

$rsParam                  = $clparcustos->sql_record($clparcustos->sql_query_file(db_getsession("DB_anousu"),"cc09_tipocontrole","","cc09_instit = ".db_getsession("DB_instit")) );
if($clparcustos->numrows > 0){
 db_fieldsmemory($rsParam,0);
}else{
 $cc09_tipocontrole = 0;
}

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script>
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
  </tr>
</table >
  <table    align="center" style="margin-top:30px">
    <form name="form1" method="post" action="">
      <tr>
         <td align='right' ></td>
         <td ></td>
      </tr>
      <tr >
        <td colspan=2 ><?
                 // $aux = new cl_arquivo_auxiliar;
                 $aux->cabecalho = "<strong>Departamentos</strong>";
                 $aux->codigo = "coddepto"; //chave de retorno da func
                 $aux->descr  = "descrdepto";   //chave de retorno
                 $aux->nomeobjeto = 'departamentos';
                 $aux->funcao_js = 'js_mostra';
                 $aux->funcao_js_hide = 'js_mostra1';
                 $aux->sql_exec  = "";
                 $aux->func_arquivo = "func_db_depart.php";  //func a executar
                 //$aux->passar_query_string_para_func = "&depusu=".db_getsession('DB_id_usuario'); 
                 $aux->nomeiframe = "db_iframe_db_depart";
                 $aux->localjan = "";
                 $aux->onclick                     ="";
                 $aux->executa_script_apos_incluir ='js_verifica_orgao();';
                 $aux->db_opcao = 2;
                 $aux->tipo = 2;
                 $aux->top = 0;
                 $aux->linhas = 10;
                 $aux->vwhidth = 400;
                 $aux->funcao_gera_formulario();
        	?>
       </td>
      </tr>
      <tr align="center" >
       <td colspan=2>
         <table>
	 
       <tr><td align="right">
       	
          <?
		   //verifica se está habilitado o parametro de filtrar por centro de custos.
           if( $cc09_tipocontrole != 0){
		    db_ancora("<b>Centro de de Custo:",'js_pesquisacriterio(true)', 1);
            echo "</td><td>";
            db_input('cc08_sequencial',10,"",true,"text", 1, "onchange='js_pesquisacriterio(false)'");
            db_input('cc08_descricao',40,"",true,"text",3);
            echo "</td></tr>" ;
		   } 
          ?>
	</table>
	</td>
      </tr>
      <tr>
        <td colspan="2" align = "center"><br> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_mandadados();" >
        </td>
      </tr>

  </form>
    </table>
</body>
</html>
<script>
function js_mandadados(){
 
 query="";
 vir="";
 listadepart="";
 
 for(x=0;x<document.form1.departamentos.length;x++){
  listadepart+=vir+document.form1.departamentos.options[x].value;
  vir=",";
 }
 
 query+='&listadepart='+listadepart;

 jan = window.open('pat2_gerardepartdiv002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
 jan.moveTo(0,0);
 
}

function js_pesquisacriterio(mostra) {
 if (mostra) {
   js_OpenJanelaIframe('',
                       'db_iframe_custocriteriorateio',
                       'func_custocriteriorateio.php?funcao_js=parent.js_preenchecriterio|cc08_sequencial|cc08_descricao',
                       'Critérios de Rateios ',
                       true);
  } else {
     var chave = document.getElementById("cc08_sequencial").value; 
    js_OpenJanelaIframe('',
                       'db_iframe_custocriteriorateio',
                       'func_custocriteriorateio.php?pesquisa_chave='+chave+'&funcao_js=parent.js_preenchecriterio2',
                       'Critérios de Rateios ',
                       false);
  }
}

function js_preenchecriterio(sequencial, descricao){
  db_iframe_custocriteriorateio.hide();
  document.getElementById("cc08_sequencial").value = sequencial;
  document.getElementById("cc08_descricao").value = descricao;
}

function js_preenchecriterio2(descricao, erro){
  
  if (!erro) {
  
    document.getElementById("cc08_descricao").value = descricao;
  } else {
  
    document.getElementById("cc08_descricao").value = descricao;
    document.getElementById("cc08_sequencial").value = "";
    document.getElementById("cc08_sequencial").focus();
    
  }
  db_iframe_custocriteriorateio.hide();
}
</script>
