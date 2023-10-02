<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require("std/db_stdClass.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_parcustos_classe.php");
require("libs/db_utils.php");
require_once("libs/db_app.utils.php");
db_postmemory($HTTP_POST_VARS);

$clparcustos = new cl_parcustos;
$aux = new cl_arquivo_auxiliar;

$rsParam                  = $clparcustos->sql_record($clparcustos->sql_query_file(db_getsession("DB_anousu"),"cc09_tipocontrole","","cc09_instit = ".db_getsession("DB_instit")) );
if($clparcustos->numrows > 0){
 db_fieldsmemory($rsParam,0);
}else{
 $cc09_tipocontrole = 0;
}


    db_app::load("scripts.js,
                  strings.js,
                  prototype.js,
                  datagrid.widget.js,
                  widgets/DBLancador.widget.js,
                  estilos.css,
                  grid.style.css
                 ");
    
    db_app::load("widgets/windowAux.widget.js,
    		          widgets/dbtextField.widget.js,
    		          dbmessageBoard.widget.js,
    		          dbcomboBox.widget.js,
    		          prototype.maskedinput.js,
    	 	          DBTreeView.widget.js,
    		          arrays.js");  


?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script>
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
  </tr>
</table >
<fieldset style="width: 50%; margin: 0px auto; margin-top:15px;">
   <legend><b>Relatório de Movimentações Manuais</b></legend>
  <table    align="center" border='0'>
    <form name="form1" method="post" action="">
       <tr> 
           <td>
                <strong>Opções:</strong>
            </td>
            <td>    
                <select name="ver">
                    <option name="condicao1" value="com">Com os departamentos selecionados</option>
                    <option name="condicao1" value="sem">Sem os departamentos selecionados</option>
                </select>
          </td>
       </tr>
      <tr>
        <td colspan=3 ><?
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
      
      <tr id='data' style='display:""'>
        <td>
          <b>Período: </b>
        </td>
        <td>      
          <? 
           db_inputdata('data1','','','',true,'text',1,"");   		          
           echo "<b> a</b> ";
           db_inputdata('data2','','','',true,'text',1,"");
         ?>&nbsp;
	      </td>
      </tr>
      <tr>
        <td nowrap="nowrap" title="Quebra por departamento" align="left" >
          <strong>Quebra por departamento :</strong>
        </td>
        <td nowrap="nowrap"  align="left">
          <? 
            $tipo_que = array("N"=>"Não","S"=>"Sim");
            db_select("quebra",$tipo_que,true,2,""); 
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap="nowrap" title="Tipo Movimentação" align="left" >
          <strong>Tipo :</strong>
        </td>
        <td nowrap="nowrap"  align="left">
          <? 
            $tipo = array("T"=>"Todos","E"=>"Entradas","S"=>"Saídas");
            db_select("tipo",$tipo,true,2,""); 
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" align = "center"><br> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_mandadados();" >
        </td>
      </tr>
  </form>
  </fieldset>
 </table>
</body>
</html>
<script>


var windowGrupo = '';
var oTreeViewGrupos = new DBTreeView('treeViewGrupo');

function js_mandadados(){
 
 query="";
 vir="";
 listadepart="";
 
 for(x=0;x<document.form1.departamentos.length;x++){
  listadepart+=vir+document.form1.departamentos.options[x].value;
  vir=",";
 }
 
 vir="";
 listamat="";
 for(x=0;x<parent.iframe_g2.document.form1.material.length;x++){
  listamat+=vir+parent.iframe_g2.document.form1.material.options[x].value;
  vir=",";
 }
       
 var sDataIni = new String(document.form1.data1.value).trim();
 var sDataFim = new String(document.form1.data2.value).trim();
   
    
 if ( sDataIni == '' && sDataFim == '' ) {
   alert('Favor informe algum período!');
   return false;
 } else if ( sDataIni == '' ) {
   alert('Favor informe período inicial!');
   return false;
 } else if ( sDataFim == '' ) {
   alert('Favor informe período final!');
   return false;     
 }

 
 query+='&listadepart='+listadepart+'&verdepart='+document.form1.ver.value;
 query+='&listamat='+listamat+'&vermat='+parent.iframe_g2.document.form1.ver.value;
 query+='&data_inicial='+sDataIni;
 query+='&data_final='+sDataFim; 
 query+='&quebrapordepartamento='+document.form1.quebra.value;
 query+='&tipomov='+document.form1.tipo.value;
 
 jan = window.open('mat2_relatoriomovimentacaomanual002.php?'+query,'',
                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
 jan.moveTo(0,0);
 
}

</script>