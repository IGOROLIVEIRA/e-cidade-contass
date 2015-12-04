<?php
/**
 *
 * @author I
 * @revision $Author: robson
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript"
  src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/widgets/dbmessageBoard.widget.js"></script>
  <script language="JavaScript" type="text/javascript"
  src="scripts/micoxUpload.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <center>


    
      <div style="display: table">
        <fieldset>
          <legend>
            <b>Gerar PCA - Prestação de Contas Anual</b>
          </legend>
          <table style='empty-cells: show; border-collapse: collapse;'>

             <tr>
              <td colspan="3">
                <div id='dadospca'>
                
                  <fieldset>
                  <legend>
            			<b>Enviar Arquivos</b>
          				</legend>
                    <table>
                    
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Relatório de controle interno:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="RCI" />
    <div id="RCI" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','RCI','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Parecer  elaborado pelo Conselho do FUNDEB:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="PARECER_FUNDEB" />
    <div id="PARECER_FUNDEB" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','PARECER_FUNDEB','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                                            
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Balanço orçamentário:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="BO" />
    <div id="BO" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','BO','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Balanço financeiro:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="BF" />
    <div id="BF" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','BF','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Demonstração das variações patrimoniais:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="DVP" />
    <div id="DVP" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','DVP','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Balanço patrimonial:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="BP" />
    <div id="BP" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','BP','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Demonstração dos fluxos de caixa:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="DFC" />
    <div id="DFC" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','DFC','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>
                      
                      <tr>
                      <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                      	<td>
                      	Notas explicativas às demonstrações contábeis:
                      	<div>&nbsp;</div>
                      	</td>
                        <td>
                        	<input type="file" name="NE" />
    <div id="NE" class="recebe">&nbsp;</div>
                        </td>
                        <td>
                        <input type="button" value="Enviar" onclick="micoxUpload(this.form,'con4_uploadarquivospca.php','NE','Carregando...','Erro ao carregar')" />
                        <div>&nbsp;</div>
                        </td>
                      </form>
                      </tr>

                    </table>
                  </fieldset>
                  
                </div>
              </td>
          
            <td colspan=3>

                
                  <fieldset>
                  <legend>
            			<b>Arquivos Gerados</b>
          				</legend>
          				<div id='retorno'
                  style="width: 200px; height: 282px; overflow: scroll;">
                </div>
          				</fieldset>
          				
            </td>
            </tr>
          </table>
        </fieldset>
        <div style="text-align: center;">
          <input type="button" id="btnProcessar" value="Processar"
            onclick="js_processar();" />
        </div>
      </div>
    

  </center>
</body>
</html>
                        <? db_menu(db_getsession("DB_id_usuario"),
                        db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
function js_processar() {

	var aArquivosSelecionados = new Array();
	var aArquivos             = $$("input[type='file']");
  /*
   * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
   */ 
  aArquivos.each(function (oElemento, iIndice) {
    
    aArquivosSelecionados.push(oElemento.name);
    
  });  

  js_divCarregando('Aguarde, processando arquivos','msgBox');
  var oParam           = new Object();
  oParam.exec          = "processarPCA";
  oParam.arquivos      = aArquivosSelecionados;
  var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
		                            {
                                  method:'post',
                                  parameters:'json='+Object.toJSON(oParam),
                                  onComplete:js_retornoProcessamento
		                            }
	      );
  
}

function js_retornoProcessamento(oAjax) {

	  js_removeObj('msgBox');
	  //$('debug').innerHTML = oAjax.responseText;
	  var oRetorno = eval("("+oAjax.responseText+")");
	  if (oRetorno.status == 1) {

		  alert("Processo concluído com sucesso!");  
	    var sRetorno = "<br>";
	    for (var i = 0; i < oRetorno.itens.length; i++) {

	      with (oRetorno.itens[i]) {
	            
	        sRetorno += "<a  href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
	      }
	    }
	    
	    $('retorno').innerHTML = sRetorno;
	  } else {
	    
	    $('retorno').innerHTML = '';
	    //alert("Ouve um erro no processamento!");
	    alert(oRetorno.message.urlDecode());
	    return false;
	  }
	} 

</script>
<div id='debug'>
</div>
