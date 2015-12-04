<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");

$oGet = db_utils::postMemory($_GET);

if (isset($oGet->view)) { 
  $sValorView = $oGet->view;
}

if (isset($oGet->codRelatorio)){
  $iCodRelatorio = $oGet->codRelatorio;
}


?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/libJsonJs.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/json2.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
<style>
.marcaEnvia, .marcaRetira { 
            	 			 border-colappse:collapse;
            				 border-right:1px inset black;
            			     border-bottom:1px inset black;
            				 cursor:normal;
            				 font-family: Arial, Helvetica, sans-serif;
          				  	 font-size: 12px;
          					 background-color:#CCCDDD
           				   }
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1;" bgcolor="#cccccc">
<center>
<form name="form1" method="post" action="">
<table  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td style="padding-top:20px;"> 
	  <fieldset>
	  	<legend align="center">
	  	  <b>Campos Disponíveis:</b>
	  	</legend>
	    <table 	cellspacing="0" style="border:2px inset white; width:200px;" >
	      <tr>
	      	<?
			   db_input("sValorView"   		 ,40,"",true,"hidden",1,"");
			   db_input("iCodRelatorio"	     ,40,"",true,"hidden",1,"");
			   db_input("CamposConfigurados" ,40,"",true,"hidden",1,"");			   
	      	?>
	      	<th class="table_header"><b>Campos</b></th>
	        <th class="table_header" width="12px" ><b>&nbsp;</b></th>
	      </tr>
	      	<tbody id="listaCampos" style=" height:300px; overflow:scroll; overflow-x:hidden; background-color:white"  >
	      	</tbody>
	    </table> 		
	  </fieldset>
    </td>
    <td>
      <table>
        <tr>
      	  <td>
      	  	<input name="enviaTodos"  type="button" value=">>"  style='width:30px;' onClick="js_enviaTodosCampos();">
      	  </td>
      	</tr>
      	<tr>
      	  <td>
      	  	<input name="envia"   	  type="button" value=">"   style='width:30px;' onClick="js_enviaCampos();">
      	  </td>
      	</tr>
      	<tr>
      	  <td>
      	  	<input name="retorna" 	   type="button" value="<"  style='width:30px;' onClick="js_retiraCampos();">
      	  </td>
      	</tr>	
      	<tr>
      	  <td>
      	  	<input name="retornaTodos" type="button" value="<<" style='width:30px;' onClick="js_retiraTodosCampos();">
      	  </td>
      	</tr>      	
      </table>
    </td>
    <td style="padding-top:20px;">
      <fieldset>
	  	<legend align="center">
	  	  <b>Campos Selecionados:</b>
	  	</legend>
	    <table 	cellspacing="0" style="border:2px inset white;" >
	      <tr>
	        <th class="table_header" width="150px"><b>Nome</b></th>
	        <th class="table_header" width="70px" ><b>Tamanho</b></th>
	        <th class="table_header" width="100px"><b>Alinhamento Coluna</b></th>
	        <th class="table_header" width="85px" ><b>Formatar</b></th>
	        <th class="table_header" width="85px" ><b>Alinhamento Cabeçalho</b></th>
	        <th class="table_header" width="85px" ><b>Totalizar</b></th>
	        <th class="table_header" width="12px" ><b>&nbsp;</b></th>
	      </tr>  
	      <tbody id="detalheCampos" style=" height:300px; overflow:scroll; overflow-x:hidden; background-color:white"  >
          </tbody>
	    </table> 		
	  </fieldset>
    </td>
  </tr>
</table>
</form>
</center>
</body>
</html>
<script>
    
	var temporizador  = null;	 
    var lFiltros      = false;
    var lOrdem		  = false;
    var lPropriedades = false;
    var lVariaveis    = false;
    var lFinalizar    = false;
    
    js_verificaAbas();
    
    function js_verificaConsulta(){
      
      if ( document.form1.sValorView.value != "" ) {
    	 js_carregaView(document.form1.sValorView.value,js_retornoCarregaView);
      } else if (document.form1.iCodRelatorio.value != "" ) {
         js_carregaRelatorio(document.form1.iCodRelatorio.value);
      } 
       
    }
    
    function js_verificaAbas() {

      if ( lFinalizar && lVariaveis && lPropriedades && lFiltros ) {    
        clearTimeout(temporizador);
        js_verificaConsulta();
      }else{
        temporizador  = setTimeout('js_verificaAbas()',500);
      }
      
    } 
	
	function js_carregaRelatorio(iCodRelatorio){
	  	
	  js_divCarregando('Aguarde...','msgBoxCarregaRelatorio');
	  
   	  var ConsultaTipo = 'carregaRelatorio';
   	  var url          = 'sys4_consultaviewRPC.php';
   	  var oAjax        = new Ajax.Request( url, {
                                                 method: 'post', 
                                                 parameters: 'tipo='+ConsultaTipo+'&codRelatorio='+iCodRelatorio, 
                                                 onComplete: js_retornoRelatorio
                                                }
                                         );
	}


	function js_retornoRelatorio(oAjax){
	  
	  js_removeObj('msgBoxCarregaRelatorio');

	  var objRelatorio = eval("("+oAjax.responseText+")");
	  
	  document.form1.sValorView.value 		  = objRelatorio.view;
	  
	  document.form1.CamposConfigurados.value 					  = objRelatorio.campos.toSource();
	  parent.iframe_ordem.document.form1.CamposConfigurados.value = objRelatorio.ordem.toSource();
	  
	  js_carregaView(objRelatorio.view,js_retornoConfereCampos);
	  
	  //Carrega aba propriedades
      parent.iframe_layout.js_processaPropriedades(objRelatorio.propriedades);
      
      //Carrega aba finalizar
      parent.iframe_finalizar.js_consultaTipoGrupo(objRelatorio.tipogrupo);
      
      //Carrega aba variáveis
	  parent.iframe_variaveis.js_carregaGrid(objRelatorio.variaveis);
	  
	  //Carrega aba filtros
	  parent.iframe_filtros.js_carregaFiltros(objRelatorio.filtros);
	  
	}


	function js_retornoConfereCampos(oAjax){
	  
	  parent.iframe_filtros.js_retornoView(oAjax);
	  parent.iframe_ordem.js_retornoView(oAjax);
	  
	  var objCamposDisp = eval("("+oAjax.responseText+")");
	  
	  if (objCamposDisp.iStatus && objCamposDisp.iStatus == 2){
     	js_removeObj("msgBoxCarregaView");
     	alert(objCamposDisp.sMensagem.urlDecode());
     	parent.document.location.href = "sys4_geradorrelatorio001.php";
     	return false ;
  	  }
  	  
	  var objCamposConf = eval(document.form1.CamposConfigurados.value);
	  	  
	  $('listaCampos').innerHTML = js_montaCamposDisp(objCamposDisp);
	  
	  for(var i=0; i < objCamposDisp.length; i++ ){
	    for(var x=0; x < objCamposConf.length; x++){
	  	  if ( objCamposDisp[i].codcam == objCamposConf[x].iId){
	  		objCamposConf[x].sAlias = objCamposDisp[i].rotulo.urlDecode();
	  		$('linhaCampo'+objCamposDisp[i].codcam).style.display = "none";
	  	  }
	  	}
	  }

	  js_carregaGrid(objCamposConf);
	  
	  js_removeObj("msgBoxCarregaView");
	  					
	}

	function js_carregaView(sValorView,sCallBackFunction){
	  
	  js_divCarregando('Aguarde...','msgBoxCarregaView');
	  
   	  var ConsultaTipo = 'consultaView';
   	  var url          = 'sys4_consultaviewRPC.php';
   	  var oAjax        = new Ajax.Request( url, {
                                               	 method: 'post', 
                                               	 parameters: 'tipo='+ConsultaTipo+'&view='+sValorView, 
                                               	 onComplete: sCallBackFunction
                                                }
                                         );
	}

	function js_retornoCarregaView(oAjax){
	
	  parent.iframe_filtros.js_retornoView(oAjax);	
	  parent.iframe_ordem.js_retornoView(oAjax);
	
	  var objCamposDisp = eval("("+oAjax.responseText+")");
	  
	  if (objCamposDisp.iStatus && objCamposDisp.iStatus == 2){
     	js_removeObj("msgBoxCarregaView");
     	alert(objCamposDisp.sMensagem.urlDecode());
     	parent.document.location.href = "sys4_geradorrelatorio001.php";
     	return false ;
  	  }
	
	  $('listaCampos').innerHTML = js_montaCamposDisp(objCamposDisp);
	  js_removeObj("msgBoxCarregaView");
	  
	  
	}
	

	function js_montaCamposDisp(objCampos){
	  
	  var sLinha  = "";
	  	
	  if (objCampos) {

	  	for ( var iInd = 0; iInd < objCampos.length; iInd++ ) {
	  	
		  with (objCampos[iInd]) {
		  	sLinha += " <tr id='linhaCampo"+codcam+"' >";		  	
		  	sLinha += "   <td class='linhagrid' onDblClick='js_enviaUmCampo(\"linhaCampo"+codcam+"\");'   onClick='js_marcaLinha(\"linhaCampo"+codcam+"\",\"marcaEnvia\");'  style='text-align:left;'>"+rotulo.urlDecode();
		  	sLinha += "     <input type='hidden' name='"+nomecam+"' id='"+codcam+"' value='"+objCampos[iInd].toSource()+"'>";
		  	sLinha += "   </td> ";
		  	sLinha += " </tr> ";	
		  }	  	
	  	}
	  }
	  return sLinha;
	}



	function js_marcaLinha(iId,sTipoMarca){
  	  if ($(iId).className != sTipoMarca){
		$(iId).className = sTipoMarca; 
  	  }else{
   		$(iId).className = 'linhagrid';  	  
  	  }
	}
	
	
	function js_retiraCampos(){
	  
	  var objMarcados = js_getElementbyClass(document.all,'marcaRetira');
	  var aMarcado 	  = new Array();
	  
	  for ( i=0; i < objMarcados.length; i++ ) {
	  
	    var idCampo 	= objMarcados[i].id.replace('linhaGrid','')
	        aMarcado[i] = $(idCampo).name; 
	        idCampo 	= 'linhaCampo'+idCampo;
	        $(idCampo).style.display = '';
	  		$('detalheCampos').removeChild(objMarcados[i]);	        
	  }

	
   	  var url    = 'sys4_consultaviewRPC.php';
   	  var oAjax  = new Ajax.Request( url, {
                                           method: 'post', 
                                           parameters: 'tipo=excluirCampos&aCampos='+aMarcado,
                                          }
                                   );
	}	
	
	function js_retiraTodosCampos(){
	  
	  var objMarcados = $('detalheCampos').rows; 
	  var aMarcado 	  = new Array();
	  
	  for ( i=0; i < objMarcados.length; i++ ) {
	  
	    var idCampo 	= objMarcados[i].id.replace('linhaGrid','')
	        aMarcado[i] = $(idCampo).name; 
	        idCampo 	= 'linhaCampo'+idCampo;
	        $(idCampo).style.display = '';
	        
	  }
	  $('detalheCampos').innerHTML = "";	
	  
   	  var url    = 'sys4_consultaviewRPC.php';
   	  var oAjax  = new Ajax.Request( url, {
                                           method: 'post', 
                                           parameters: 'tipo=excluirCampos&aCampos='+aMarcado,
                                          }
                                   );
	}
	
	
    function js_enviaTodosCampos(){
	  
	  var objMarcados = $('listaCampos').rows;
	  var aMarcados   = new Array();
	  var x = 0;
	  
	  for ( i=0; i < objMarcados.length; i++ ) {
		
		if ( $(objMarcados[i].id).style.display == "") {
		  $(objMarcados[i].id).style.display   = "none";
		  $(objMarcados[i].id).className 	   = "linhagrid";
		  
		  aMarcados[x] = eval($(objMarcados[i].id.replace('linhaCampo','')).value);
		  x++;
		}
	  	
	  }
	  
	  js_enviaCamposInclusao(aMarcados);
	  	  
	}
	
	function js_enviaCampos(){
	  
	  var objMarcados = js_getElementbyClass(document.all,'marcaEnvia');
	  var aMarcados   = new Array();
	  
	  for ( i=0; i < objMarcados.length; i++ ) {
		
		$(objMarcados[i].id).style.display = "none";
		$(objMarcados[i].id).className 	   = "linhagrid";
		aMarcados[i] = eval($(objMarcados[i].id.replace('linhaCampo','')).value);
	  	
	  }
	  
	  js_enviaCamposInclusao(aMarcados);
	  	  
	}

	function js_enviaUmCampo(idCampo){
	  
	  var aMarcados   = new Array();
		
      $(idCampo).style.display = "none";
	  $(idCampo).className 	   = "linhagrid";
	  aMarcados[0] = eval($(idCampo.replace('linhaCampo','')).value);
	  
	  js_enviaCamposInclusao(aMarcados);
	  	  
	}	

	
	function js_enviaCamposInclusao(aCampos){
	
	  var ConsultaTipo = 'incluirCampos';
   	  var url          = 'sys4_consultaviewRPC.php';
   	  var sQuery  	   = 'tipo='+ConsultaTipo;
   	  	  sQuery 	  += '&aObjCampos='+aCampos.toSource();   	  
   	  
   	  var oAjax       = new Ajax.Request( url, {
                                                 method: 'post', 
                                                 parameters: sQuery,
                                                 onComplete: js_retornoCampos
                                               } 
                                         );
	}
	
	
	function js_retornoCampos(oAjax){
	
	  var objCampos = eval("("+oAjax.responseText+")");
      js_carregaGrid(objCampos);
      	  		
	}


	function js_carregaGrid(objCampos){
	
	  var sLinha    = "";
	  
	  for (var i = 0; i < objCampos.length; i++) {	  
 	   
	    with (objCampos[i]) {
	  	
	  	 var elem    	= document.createElement("tr");
	  	 elem.id 		= "linhaGrid"+iId;
	  	 
		 $('detalheCampos').appendChild(elem);
		  
	     sLinha  = "  <td class='linhagrid'      onClick='js_marcaLinha(\"linhaGrid"+iId+"\",\"marcaRetira\");' style='text-align:left;' >"+sAlias.urlDecode()+"</td> ";
	     sLinha += "  <td class='linhagrid' > 																								 			   ";
	     sLinha += "	 <input name='iLargura'  type='text' size='8px' value="+iLargura+" onChange='js_alteraCampo("+iId+",this);' ></input>              ";
	     sLinha += "  </td> 																								  							   ";
	   	 sLinha += "  <td class='linhagrid'  > 	   			 			  	 	    										  							   ";
	     sLinha += "    <select name='sAlinhamento'    id='sAlinhamento"+iId+"'    style='width:100%'  onChange='js_alteraCampo("+iId+",this);'></select>  ";
	     sLinha += "  </td> 						   			 				    										  							   ";
	     sLinha += "  <td class='linhagrid' > 	   			 				  	    										  							   ";
	     sLinha += "    <select name='sMascara'        id='sMascara"+iId+"'        style='width:100%'  onChange='js_alteraCampo("+iId+",this);'></select>  ";
	     sLinha += "  </td> 						   			 				  											  							   ";
	   	 sLinha += "  <td class='linhagrid' > 	   			 				  					  							  							   ";
	     sLinha += "    <select name='sAlinhamentoCab' id='sAlinhamentoCab"+iId+"' style='width:100%'  onChange='js_alteraCampo("+iId+",this);'></select>  ";
	     sLinha += "  </td> 						   			 				  										 	  							   ";
	   	 sLinha += "  <td class='linhagrid' > 	   			 				  						  							   ";
	     sLinha += "    <select name='sTotalizar'      id='sTotalizar"+iId+"'	   style='width:100%'   onChange='js_alteraCampo("+iId+",this);'></select> ";
	     sLinha += "  </td>                                                              								 	  							   ";
		 sLinha += "  <td><input type='hidden' name='atributoCampos' id='atributoCampos"+iId+"' value='"+JSON.stringify(objCampos[i])+"' /></td> 		   ";
		 	
	     sLinha += "<tr><td style='height:auto;'>&nbsp;</td></tr>";
	     
	     elem.innerHTML = sLinha;
		  
   	     var sStrAlinhamento = "[{valor:'c',texto:'Centro'},{valor:'l',texto:'Esquerda'},{valor:'r',texto:'Direita'}]";	      
	     var sStrFormato     = "[{valor:'t',texto:'Texto'} ,{valor:'m',texto:'Moeda'}   ,{valor:'d',texto:'Data'}]";
	     var sStrTotalizar   = "[{valor:'n',texto:'Não'}   ,{valor:'s',texto:'Soma' }   ,{valor:'q',texto:'Quantidade'}]";
	     
	     js_montaSelect($("sAlinhamento"+iId)    ,sStrAlinhamento ,sAlinhamento);
	     js_montaSelect($("sMascara"+iId)		 ,sStrFormato     ,sMascara);
	     js_montaSelect($("sAlinhamentoCab"+iId) ,sStrAlinhamento ,sAlinhamentoCab);
	     js_montaSelect($("sTotalizar"+iId)		 ,sStrTotalizar   ,sTotalizar);
	      
	    }			  		
      }
      


	}
	
	
	function js_alteraCampo(idCampo,objAtributo){
	
	  var objCampo =JSON.parse($('atributoCampos'+idCampo).value);
      	  eval( 'objCampo.'+objAtributo.name+' = "'+objAtributo.value+'"');
      	  $('atributoCampos'+idCampo).value = JSON.stringify(objCampo); 	      
   	  var ConsultaTipo = 'alterarCampos';
   	  var url          = 'sys4_consultaviewRPC.php';
   	  var sQuery  = 'tipo='+ConsultaTipo;
   	  	  sQuery += '&objCampo='+JSON.stringify(objCampo);
   	  var oAjax   = new Ajax.Request( url, {
                                             method: 'post', 
                                             parameters: sQuery
                                           } 
                                    );
	 }
	
	
	 function js_montaSelect(objSel, jsonParametros, sValorPadrao){
	   
	   eval("objParam = "+jsonParametros);
		   
	   for(var i=0; i< objParam.length; i++){
		 objSel.options[i] = new Option();
		 objSel.options[i].value = objParam[i].valor;
		 objSel.options[i].text  = objParam[i].texto;
		 if (objParam[i].valor == sValorPadrao){
		   objSel.options[i].selected = true;
		 }
	   }	
	   
	 }
	
	  
	
	
	
	
	
</script>
