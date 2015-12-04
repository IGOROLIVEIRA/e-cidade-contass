<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");


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
.marcado { 
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1; parent.iframe_campos.lOrdem = true;" bgcolor="#cccccc">
<center>
<form name="form1" method="post" action="">
  <table  border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td>
	 	<table>
		  <tr>
	   	    <td style="padding-top:20px;"> 
	  		  <fieldset>
	    	    <table 	cellspacing="0" style="border:2px inset white; width:260px;" >
			      <tr>
	    	       <?	  
	    	      	  db_input("CamposConfigurados" ,40,"",true,"hidden",1,"");			   
	      	       ?>
			      	<th class="table_header"><b>Campos Disponíveis</b></th>
			        <th class="table_header" width="12px" ><b>&nbsp;</b></th>
			      </tr>
		      	  <tbody id="listaCampos" style=" height:220px; overflow:scroll; overflow-x:hidden; background-color:white"  >
		     	  </tbody>
			    </table> 		
		 	  </fieldset>
		    </td>
		  <tr> 
	  	</table>
	  </td>
	  <td>
        <table>
          <tr>
      	    <td>
      	  	  <input name="incluiTodos"  type="button" value=">>" style='width:30px;' onClick="js_incluiOrdem(true);">
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>
      	      <input name="inclui"   	 type="button" value=">"  style='width:30px;' onClick="js_incluiOrdem(false);">
      	    </td>
      	  </tr>
      	  <tr>
      	    <td>
      	      <input name="exclui" 	     type="button" value="<"  style='width:30px;' onClick="js_excluiOrdem(false);">
      	    </td>
      	  </tr>	
          <tr>
      	    <td>
      	  	  <input name="excluiTodos"  type="button" value="<<" style='width:30px;' onClick="js_excluiOrdem(true);">
      	    </td>
      	  </tr>      	
        </table>
      </td>
	  <td>
	 	<table>
		  <tr>
	   	    <td style="padding-top:20px;"> 
	  		  <fieldset>
	    	    <table 	cellspacing="0" style="border:2px inset white; width:360px;" >
			      <tr>
			      	<th class="table_header" width="150px" ><b>Campo</b></th>
			      	<th class="table_header" width="198px" ><b>Crescente/Decrescente</b></th>
			        <th class="table_header" width="12px" ><b>&nbsp;</b></th>
			      </tr>
		      	  <tbody id="listaOrdem" style=" height:220px; overflow:scroll; overflow-x:hidden; background-color:white"  >
		     	  </tbody>
			    </table>
		 	  </fieldset>
		    </td>
		    <td>
		      <table>
		        <tr>
		          <td>
		             <img style="cursor:hand"  src="imagens/btnSetaUp.gif" onClick="js_moveUp();">
		          </td>
		        </tr>
		        <tr>
		          <td>
  			        <input name="moveDown"  type="button" value="v" style='width:30px;' onClick="js_moveDown();">
		          </td>
		        </tr>		        
		      </table>
		    </td>
		  <tr> 
	  	</table>
	  </td>	  
	</tr>	
  </table>
</form>
</center>
</body>
</html>
<script>
	
	function js_retornoView(oAjax){
	
	  var sLinha  = "";	
	  var objDisp = eval("("+oAjax.responseText+")");
  	  	
  	  if (objDisp.iStatus && objDisp.iStatus == 2){
     	alert(objDisp.sMensagem.urlDecode());
     	return false ;
  	  }
	  
	  if (objDisp) {
	  	for ( var iInd = 0; iInd < objDisp.length; iInd++ ) {
		  with (objDisp[iInd]) {
		  	sLinha += "<tr id='linhaCampo"+nomecam+"' class='linhagrid' >";		  	
		  	sLinha += "  <td class='linhagrid'  onClick='js_marcaLinha(\"linhaCampo"+nomecam+"\");'  style='text-align:left;'>"+rotulo.urlDecode();
		  	sLinha += "    <input type='hidden' name='"+rotulo.urlDecode()+"' id='"+nomecam+"' value='"+objDisp[iInd].toSource()+"'>";
		  	sLinha += "  </td>";
		  	sLinha += "</tr>";		  		
		  }	  	
	  	}
	  	$('listaCampos').innerHTML = sLinha;
	  }
	 
	  if ( document.form1.CamposConfigurados.value != "" ) {
	    var objConf = eval(document.form1.CamposConfigurados.value);
	    js_confereCampos(objConf);
	  }	
		  
	}

    function js_confereCampos(aObjOrdem){
    
	  var objCampos = $('listaCampos').rows;
	  
      for( var i=0; i < objCampos.length; i++ ){
	    for (var x=0; x < aObjOrdem.length; x++ ){
	      if ( objCampos[i].id.replace('linhaCampo','') == aObjOrdem[x].sNome ) {
	    	objCampos[i].style.display = "none";
		    objCampos[i].className 	 = "linhagrid";		       
		  }
	    }    	
      }
      
      js_carregaOrdem(aObjOrdem);
      
    }
 

	function js_marcaLinha(idCampo){
	
      if ( $(idCampo).className == 'linhagrid') {
  	 	 $(idCampo).className = 'marcado';
  	  } else {
  	     $(idCampo).className = 'linhagrid';
  	  }
  	  
	}
	

	function js_incluiOrdem(lTodos){
	
	  var aMarcados   = new Array(); 
	  
	  if (lTodos) {
	    var objMarcados = $('listaCampos').rows;
	  } else {
	    var objMarcados = js_getElementbyClass($('listaCampos').rows,'marcado');
	  }
	  
	  if ( objMarcados.length == 0 ) {
  	  	alert("Nenhum campo selecionado");
  	  	return false;
  	  }
  	  
	  for (var i=0; i < objMarcados.length; i++) {
	  	$(objMarcados[i].id).style.display = "none";
		$(objMarcados[i].id).className 	   = "linhagrid";
		
		var objCampo = eval($(objMarcados[i].id.replace('linhaCampo','')).value);
        var objOrdem = new js_criaobjOrdem(objCampo.codcam,objCampo.nomecam,'asc',objCampo.rotulo.urlDecode());
		aMarcados[i] = objOrdem;
			  	
	  }
	  
	  js_carregaOrdem(aMarcados);
	
	}
	
	
	function js_criaobjOrdem( iId,sNome,sAscDesc,sAlias){
	  this.iId	    = iId;
	  this.sNome    = sNome;
	  this.sAscDesc = sAscDesc;
	  this.sAlias   = sAlias;
	}


	function js_enviaOrdemInclusao(aCampos){

	  var ConsultaTipo = 'incluirOrdem';
   	  var url          = 'sys4_consultaviewRPC.php';
   	  var sQuery  	   = 'tipo='+ConsultaTipo;
   	  	  sQuery 	  += '&aObjCampos='+JSON.stringify(aCampos);   	  
   	  var oAjax        = new Ajax.Request( url, {
                                                 method: 'post', 
                                                 parameters: sQuery,
                                                 onComplete: js_retornoInclusaoOrdem
                                               } 
                                         );
	}
	
	
	function js_retornoInclusaoOrdem(oAjax){
	  parent.iframe_finalizar.lTestaOrdem = true;
	}


	function js_carregaOrdem(objCampos){
		  
	  for( var i=0; i < objCampos.length; i++){
	  
	  	with (objCampos[i]) {
	  	
	      var elem 		  = document.createElement("tr");
	  	  elem.id         = "ordem"+sNome;
  	  	  elem.className  = "linhagrid";
  	  	 
	  	  $('listaOrdem').appendChild(elem);
				  	  	
		  var sLinha = "  <td class='linhagrid'   onClick='js_marcaLinha(\"ordem"+sNome+"\");' >"+$(sNome).name+"</td>  	       			 ";
		  sLinha  	+= "  <td class='linhagrid' >					 	  										    						 ";
		  sLinha  	+= "     <select name='sAscDesc"+sNome+"' id='sAscDesc"+sNome+"' style='width:100%'  onChange='js_alteraOrdem(this)'>    ";
		  sLinha  	+= "  	  <option value='asc' >Crescente  </option>						   											     ";
		  sLinha  	+= "  	  <option value='desc'>Decrescente</option> 					   											     ";
		  sLinha  	+= "     </select> 														   											     ";
		  sLinha  	+= "  </td>					     										   											     ";
	      sLinha  	+= "  <td><input type='hidden' name='valOrdem"+sNome+"' id='valOrdem"+sNome+"' value='"+objCampos[i].toSource()+"'></td> ";
	  	  
	  	  elem.innerHTML = sLinha;
	  	}
	  
	  }
	  
	  for( var i=0; i < objCampos.length; i++){
	  	$("sAscDesc"+objCampos[i].sNome).value = objCampos[i].sAscDesc; 
	  }
		
	  
	}

	
	
	
	function js_alteraOrdem(obj){
	  
	  var objOrdem 			= eval( $(obj.name.replace('sAscDesc','valOrdem')).value );
		  objOrdem.sAscDesc = obj.value;
	  
	  $(obj.name.replace('sAscDesc','valOrdem')).value = objOrdem.toSource();
		   		
	}
	
	
	function js_excluiOrdem(lTodos){

	  var aMarcados 	 = new Array(); 
	  var aListaMarcados = new Array();
	  
	  if (lTodos) {
	    var objMarcados = $('listaOrdem').rows;
	  } else {
	    var objMarcados = js_getElementbyClass($('listaOrdem').rows,'marcado');
	  }
	  
	  if (objMarcados.length == 0) {
  	  	alert("Nenhuma ordem selecionada");
  	  	return false;
  	  }
  	  
	  for (var i=0; i < objMarcados.length; i++) {
	  
	    aMarcados[i]      = eval($(objMarcados[i].id.replace('ordem','valOrdem')).value);
	    aListaMarcados[i] = objMarcados[i].id;
	    
	    $(objMarcados[i].id.replace('ordem','linhaCampo')).style.display = "";
	    
	  }
	  
	  for (var i=0; i < aListaMarcados.length; i++){
		$('listaOrdem').removeChild($(aListaMarcados[i]));
	  }
	
	}
	
		
	function js_moveUp(){
	  
	  var objMarcados = js_getElementbyClass($('listaOrdem').rows,'marcado');
	  
	  if (objMarcados.length > 1 ) {
	    alert("Favor escolha apenas uma linha");
	    return false;
	  } else if (objMarcados.length == 0) {
	    return false;
	  }	
	  
	  
      var row    = objMarcados[0];
      var tbody  = $('listaOrdem');
      var rowId  = row.rowIndex;
      var hTable = tbody.parentNode;
      var nextId = rowId-1;

      if (nextId == 0) 	{
       return false;
      }
      
	  var next = hTable.rows[nextId];
      tbody.removeChild(row);
      tbody.insertBefore(row, next);
	  
	}	
	
	
	function js_moveDown(){
	
	  var objMarcados = js_getElementbyClass($('listaOrdem').rows,'marcado');	
	
	  if (objMarcados.length > 1 ) {
	    alert("Favor escolha apenas uma linha");
	    return false;
	  } else if (objMarcados.length == 0) {
	    return false;	    
	  }	
	  	
	  var row    = objMarcados[0];
      var tbody  = $('listaOrdem');
      var rowId  = row.rowIndex;
      var hTable = tbody.parentNode;
      var nextId = parseInt(rowId)+2;
      
      if (nextId > hTable.rows.length ) {
        return false;
      }
    
      var next = hTable.rows[nextId];
      tbody.removeChild(row);
      tbody.insertBefore(row, next);
	 
    }
	

	function js_enviaOrdem(){

	  var objLinhas  = $('listaOrdem').rows;  
	  var aObjLinhas = new Array(); 
	  var idOrdem	 = "";
	  
	  if ( objLinhas.length > 0 ) {
	  
	    for (var i=0; i < objLinhas.length; i++) {
		  idOrdem       = objLinhas[i].id.replace('ordem','valOrdem');
		  aObjLinhas[i] = eval($(idOrdem).value);
  	    }
  	    	
  	    js_enviaOrdemInclusao(aObjLinhas);
  	    	
	  }	else {
	  	  parent.iframe_finalizar.lTestaOrdem = true;
	  }
	
	}	
		
	
</script>