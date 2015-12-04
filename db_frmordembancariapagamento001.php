<form name="form1" method="post" action="">
	<fieldset style="width: 500px; height: 105px;">
		<legend>
			<b>Ordens de Pagamento</b>
		</legend>
		<table cellspacing="5px">

			<tr> 
        <td  align="left" nowrap title="<?=$Te53_codord?>">
          <?db_ancora("<b>Ordem de Pagamento</b>","js_buscae53_codord(true)",1);?>
        </td>
        <td align="left" nowrap>
          <? db_input("e53_codord",10,$Ie53_codord,true,"text",4,"onchange='js_buscae53_codord(false);' onkeydown='js_enter_tab();' onchange='js_limpa_slip();'"); ?>
        </td>
  </tr>
  
  <tr>
			<td><? db_ancora("<b>Código Slip: <b>","js_pesquisak17_codigo(true);",$db_opcao);  ?>
							</td>
							<td><? db_input('k17_codigo',16,$Ik17_codigo,true,'text',$db_opcao," onchange='js_pesquisak17_codigo(false);' onkeydown='js_enter_tab();'")  ?>
							</td>
			</tr>

			<tr>
				<td><b>Fornecedor:</b></td>
				<td><b>Valor a Pagar</b></td>
				<td><b>Conta Depósito</b></td>
			</tr>
      
      <tr>
				<td>
				<input type="hidden" name="k00_cgmfornec" id="k00_cgmfornec" >
				<input type="hidden" name="k00_codordembancaria" id="k00_codordembancaria" value="<?php echo $k00_codigo ?>">
				<input type="text" name="nome_fornec" id="nome_fornec" readonly="readonly" style="background-color: rgb(222, 184, 135);">
				</td>
				<td>
				<input type="text" name="k00_valor" id="k00_valor" readonly="readonly" style="background-color: rgb(222, 184, 135);">
				</td>
				<td>
				<select name="k00_contabanco" id="k00_contabanco"  style="min-width:100px" >
				</select>
				</td>
				<td align="right" >
				<input type="button" value="Incluir" name="incluir" onclick="js_nova_linha()"/> 
				</td>
			</tr>
			
		</table>
		
	</fieldset>
	<input type="button" name="gerar_ordem" value="Gerar Ordem" onclick="js_abre()">
	<fieldset  style="width: 800px; ">

<div id="ctnGridPagamentosItens">
  <table id="gridPagamentos" class="DBGrid" cellspacing="0" cellpadding="0" width="100%" border="0" style="border:2px inset white; overflow: scroll;">
  <tr>
  <th class="table_header" style="width: 10%;">Tipo</th>
    <th class="table_header" style="width: 10%;">Código</th>
    <th class="table_header" style="width: 50%;">Fornecedor</th>
	<th class="table_header" style="width: 20%;">Valor</th>
	<th class="table_header" style="width: 20%;">Conta Depósito</th>
	<th class="table_header" style="width: 10%;"></th>
	</tr>
	<?php 
	for ($iCont = 0; $iCont < pg_num_rows($rsResultTabela); $iCont++) {
		
	$oDadosTabela = db_utils::fieldsMemory($rsResultTabela, $iCont);
	$sTabela  = "<tr id=\"{$oDadosTabela->codigo}\" class=\"normal\" style=\"height:1em;\">";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->tipo}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->codigo}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">{$oDadosTabela->z01_nome}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell1\" class=\"linhagrid\" style=\"text-align:center;\">R$".number_format($oDadosTabela->k00_valor,2,",",".")."</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">{$oDadosTabela->contafornec}</td>";
	$sTabela .= "<td id=\"Pagamentosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
	$sTabela .= "<input type=\"button\" name=\"excluir\" value=\"Excluir\" onclick=\"js_excluir({$oDadosTabela->codigo},this)\"></td></tr>";
	echo $sTabela;	    	
	}
	?>
	</table>
</div>
</fieldset>
	
</form>
<script>
function js_nova_linha(){

	if (document.form1.e53_codord.value == '' && document.form1.k17_codigo.value == '') {
		alert("Nenhuma Ordem de Pagamento ou Slip Foi Selecionada");
	  document.form1.k00_cgmfornec.value = '';
	  document.form1.nome_fornec.value = '';
	  document.form1.k00_valor.value = '';
    document.getElementById("k00_contabanco").options.length = 0;
    document.form1.e53_codord.focus();
		return;
	}
	
	if (document.form1.k00_valor.value == 0) {
		alert("Ordem de Pagamento Totalmente Paga");
  	document.form1.e53_codord.value = '';
  	document.form1.k17_codigo.value = '';
	  document.form1.k00_cgmfornec.value = '';
	  document.form1.nome_fornec.value = '';
	  document.form1.k00_valor.value = '';
    document.getElementById("k00_contabanco").options.length = 0;
    document.form1.e53_codord.focus();
		return;
	}

	var i = document.form1.k00_contabanco.selectedIndex;
	if  (document.form1.e53_codord.value == '') {
    var codigo = document.form1.k17_codigo.value;
    var tipo = "SL";
	} else {
		var codigo = document.form1.e53_codord.value;
		var tipo = "OP";
	}
	var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
			  {
		  method:'post',
		  parameters:{k00_cgmfornec: document.form1.k00_cgmfornec.value,k00_codordembancaria: document.form1.k00_codordembancaria.value,k00_codord: document.form1.e53_codord.value,k17_codigo: document.form1.k17_codigo.value,k00_valor: document.form1.k00_valor.value,k00_contabanco: document.form1.k00_contabanco[i].value},
		  onComplete:function(json){
			  var jsonObj = eval("("+json.responseText+")");

		    if (jsonObj.erro == true) {
          alert("Ordem de Pagamento ou Slip já lançada");
	    	  document.form1.e53_codord.value = '';
	    	  document.form1.k17_codigo.value = '';
	    	  document.form1.k00_cgmfornec.value = '';
	    	  document.form1.nome_fornec.value = '';
	    	  document.form1.k00_valor.value = '';
	        document.getElementById("k00_contabanco").options.length = 0;
	        document.form1.e53_codord.focus();
		    } else {
		    	var tabela = "<tr id=\""+codigo+"\" class=\"normal\" style=\"height:1em;\">";
		    	tabela    += "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">"+tipo+"</td>";
		    	tabela    += "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">"+codigo+"</td>";
		    	tabela    += "<td id=\"Pagamentosrow1cell0\" class=\"linhagrid\" style=\"text-align:left;\">"+document.form1.nome_fornec.value+"</td>";
		    	tabela    += "<td id=\"Pagamentosrow1cell1\" class=\"linhagrid\" style=\"text-align:center;\">R$"+js_moeda(document.form1.k00_valor.value,2,",",".")+"</td>";
		    	tabela    += "<td id=\"Pagamentosrow1cell2\" class=\"linhagrid\" style=\"text-align:center;\">"+document.form1.k00_contabanco[i].text+"</td>";
		    	tabela    += "<td id=\"Pagamentosrow1cell3\" class=\"linhagrid\" style=\"text-align:center;\">";
		    	tabela    += "<input type=\"button\" name=\"excluir\" value=\"Excluir\" onclick=\"js_excluir2("+codigo+")\"></td></tr>";

		    	document.getElementById("gridPagamentos").innerHTML += tabela;
		    	document.form1.e53_codord.value = '';
		    	document.form1.k17_codigo.value = '';
		    	document.form1.k00_cgmfornec.value = '';
		    	document.form1.nome_fornec.value = '';
		    	document.form1.k00_valor.value = '';
		      document.getElementById("k00_contabanco").options.length = 0;
		      document.form1.e53_codord.focus();
		    }
 }
 }
);
	
}

function js_excluir(id,obj){

	var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
			  {
		  method:'post',
		  parameters:{codord_excluir: id},
		  onComplete:function(json){ }
			  }
	  );
	var objTR = obj.parentNode.parentNode;
    var objTable = objTR.parentNode;
    var indexTR = objTR.rowIndex;  
    objTable.deleteRow(indexTR);
}

function js_excluir2(id){
	
	var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
			  {
		  method:'post',
		  parameters:{codord_excluir: id},
		  onComplete:function(json){ }
			  }
	  );
	linha = document.getElementById(id);
	linha.parentNode.parentNode.removeChild(linha.parentNode);
}

function js_buscae53_codord(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_pagordemele','func_pagordemele.php?funcao_js=parent.js_mostracodord1|e53_codord','Pesquisa',true);
	  }else{
	     if(document.form1.e53_codord.value != ''){ 
	        js_OpenJanelaIframe('','db_iframe_pagordemele','func_pagordemele.php?pesquisa_chave='+document.form1.e53_codord.value+'&funcao_js=parent.js_mostracodord','Pesquisa',false);
	     }else{
	       document.form1.e53_codord.value = ''; 
	     }
	  }
	}

	function js_mostracodord(chave,erro){
	  if(erro==true){ 
	    document.form1.e53_codord.value = '';
	    document.form1.k17_codigo.value = '';
    	document.form1.k00_cgmfornec.value = '';
    	document.form1.nome_fornec.value = '';
    	document.form1.k00_valor.value = '';
      document.getElementById("k00_contabanco").options.length = 0; 
	    document.form1.e53_codord.focus(); 
	  } else {
		  var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
				  {
			  method:'post',
			  parameters:{e53_codord: document.form1.e53_codord.value},
			  onComplete:function(json){
				    var jsonObj = eval("("+json.responseText+")");

				    if (jsonObj.erro == true) {
              alert("Movimentos não configurados no menu Financeiro->Caixa->Procedimentos->Agenda->Manutenção de Pagamentos");
              document.form1.e53_codord.value = ''; 
      	      document.form1.e53_codord.focus(); 
				    } else {
				    
				    document.form1.k00_cgmfornec.value = jsonObj[0].z01_numcgm;
			    	document.form1.nome_fornec.value = jsonObj[0].z01_nome;
			    	document.form1.k00_valor.value = jsonObj[0].valorapagar;
				    for (var i = 0; i < jsonObj.length; i++){

				    	var op = document.createElement('option');
				    	op.text = jsonObj[i].contafornec;
				    	op.value = jsonObj[i].pc63_contabanco;
				    	document.getElementById("k00_contabanco").add(op);
				    	
				    }
				    document.form1.incluir.focus();

			    }       
				  }
				  }
			  );	
		     
	  }
	}

	function js_mostracodord1(chave1){
	   document.form1.e53_codord.value = chave1;  
	   var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
				  {
			  method:'post',
			  parameters:{e53_codord: document.form1.e53_codord.value},
			  onComplete:function(json){
				    var jsonObj = eval("("+json.responseText+")");

				    if (jsonObj.erro == true) {
           alert("Movimentos não configurados no menu Financeiro->Caixa->Procedimentos->Agenda->Manutenção de Pagamentos");
           document.form1.e53_codord.value = ''; 
   	      document.form1.e53_codord.focus(); 
				    } else {
				    
				    document.form1.k00_cgmfornec.value = jsonObj[0].z01_numcgm;
			    	document.form1.nome_fornec.value = jsonObj[0].z01_nome;
			    	document.form1.k00_valor.value = jsonObj[0].valorapagar;
				    for (var i = 0; i < jsonObj.length; i++){

				    	var op = document.createElement('option');
				    	op.text = jsonObj[i].contafornec;
				    	op.value = jsonObj[i].pc63_contabanco;
				    	document.getElementById("k00_contabanco").add(op);
				    	
				    }
				    document.form1.incluir.focus();
			    }       
				  }
				  }
			  );	
	   db_iframe_pagordemele.hide();
	}


	function js_pesquisak17_codigo(mostra){
		  if(mostra==true){
		    js_OpenJanelaIframe('','db_iframe_slip','func_slip.php?funcao_js=parent.js_mostraslip1|k17_codigo','Pesquisa',true);
		  }else{
		    slip01 = new Number(document.form1.k17_codigo.value);
		    if(slip01 != ""){
		       js_OpenJanelaIframe('','db_iframe_slip','func_slip.php?pesquisa_chave='+slip01+'&funcao_js=parent.js_mostraslip','Pesquisa',false);
		    }else{
		        document.form1.k17_codigo.value='';
		    }   
		  }
		}
		function js_mostraslip(chave,erro){
		  if(erro==true){
		    document.form1.k17_codigo.value = ''; 
	    	document.form1.k00_cgmfornec.value = '';
	    	document.form1.nome_fornec.value = '';
	    	document.form1.k00_valor.value = '';
	      document.getElementById("k00_contabanco").options.length = 0; 
	      document.form1.k17_codigo.focus(); 
		  } else {

			  var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
					  {
				  method:'post',
				  parameters:{k17_codigo: document.form1.k17_codigo.value},
				  onComplete:function(json){
					    var jsonObj = eval("("+json.responseText+")");

					    if (jsonObj.erro == true) {
	              alert("Movimentos não configurados no menu Financeiro->Caixa->Procedimentos->Agenda->Manutenção de Pagamentos");
	              document.form1.e53_codord.value = ''; 
	   	          document.form1.e53_codord.focus(); 
					    } else {
					    
					    document.form1.k00_cgmfornec.value = jsonObj[0].z01_numcgm;
				    	document.form1.nome_fornec.value = jsonObj[0].z01_nome;
				    	document.form1.k00_valor.value = jsonObj[0].k17_valor;
					    for (var i = 0; i < jsonObj.length; i++){

					    	var op = document.createElement('option');
					    	op.text = jsonObj[i].contafornec;
					    	op.value = jsonObj[i].pc63_contabanco;
					    	document.getElementById("k00_contabanco").add(op);
					    	
					    }
					    document.form1.incluir.focus();
				    }       
					  }
					  }
				  );	
				  
			  
		  }
		}
		function js_mostraslip1(chave1,chave2){
		  document.form1.k17_codigo.value = chave1;

		  var oAjax = new Ajax.Request("func_ordembancariapagamento.php",
				  {
			  method:'post',
			  parameters:{k17_codigo: document.form1.k17_codigo.value},
			  onComplete:function(json){
				    var jsonObj = eval("("+json.responseText+")");

				    if (jsonObj.erro == true) {
              alert("Movimentos não configurados no menu Financeiro->Caixa->Procedimentos->Agenda->Manutenção de Pagamentos");
              document.form1.e53_codord.value = ''; 
   	          document.form1.e53_codord.focus(); 
				    } else {
				    
				    document.form1.k00_cgmfornec.value = jsonObj[0].z01_numcgm;
			    	document.form1.nome_fornec.value = jsonObj[0].z01_nome;
			    	document.form1.k00_valor.value = jsonObj[0].k17_valor;
				    for (var i = 0; i < jsonObj.length; i++){

				    	var op = document.createElement('option');
				    	op.text = jsonObj[i].contafornec;
				    	op.value = jsonObj[i].pc63_contabanco;
				    	document.getElementById("k00_contabanco").add(op);
				    	
				    }
				    document.form1.incluir.focus();
			    }       
				  }
				  }
			  );	
		  
		  db_iframe_slip.hide();
		}
	
	function js_enter_tab(oEvent){
		
		  var oEvent = (oEvent)? oEvent : event;
		  var oTarget =(oEvent.target)? oEvent.target : oEvent.srcElement;
		  if(oEvent.keyCode==13)
		    oEvent.keyCode = 9;
		  if(oTarget.type=="text" && oEvent.keyCode==13)
		    //return false;
		    oEvent.keyCode = 9;
		  if (oTarget.type=="radio" && oEvent.keyCode==13)
		    oEvent.keyCode = 9;  

		  
		}
	
	function js_abre(){
		
		   obj = document.form1;
		   query  = document.form1.k00_codordembancaria.value;
		   
		   jan = window.open('cai4_ordembancaria002.php?codigo_ordem='+query,
				   
		                 '',
		                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
		   jan.moveTo(0,0);
		  
		}

	function js_moeda(valor, casas, separdor_decimal, separador_milhar){ 
		 
		 var valor_total = parseInt(valor * (Math.pow(10,casas)));
		 var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
		 var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));
		 
		  
		 if(centavos%10 == 0 && centavos+"".length<2 ){
		  centavos = centavos+"0";
		 }else if(centavos<10){
		  centavos = "0"+centavos;
		 }
		  
		 var milhares = parseInt(inteiros/1000);
		 inteiros = inteiros % 1000; 
		 
		 var retorno = "";
		 
		 if(milhares>0){
		  retorno = milhares+""+separador_milhar+""+retorno
		  if(inteiros == 0){
		   inteiros = "000";
		  } else if(inteiros < 10){
		   inteiros = "00"+inteiros; 
		  } else if(inteiros < 100){
		   inteiros = "0"+inteiros; 
		  }
		 }
		  retorno += inteiros+""+separdor_decimal+""+centavos;
		 
		 
		 return retorno;
		 
		}

	function js_limpa_codord(){
		document.form1.e53_codord.value = '';
  }

	function js_limpa_slip(){
		document.form1.k17_codigo.value = '';
  }
</script>
