<?
//MODULO: caixa
$clconciliacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("db83_descricao");
db_postmemory($HTTP_POST_VARS);
?>
<form name="form1" method="post" action="" id="form1">
<center>
<fieldset style="width: 1000px;margin-left: 0p	x; margin-top: 80px;">

<legend style="font-weight: bold;"> Apuração da Conciliação Manual</legend>
<table border="0">
  <tr>
    <td>
	<?	
	echo $Lk199_sequencial;//texto do código sequencial da conciliação
	db_input('k199_sequencial',5, $Ik199_sequencial,true,'text',3,'');
	echo $Lk199_codconta;// texto do codigo da conta 
	db_input('k199_codconta',4,$Ik199_codconta,true,'text',3,"");// codigo da conta
	db_input('db83_descricao',30,$Idb83_descricao,true,'text',3,'');// descrição da conta
	
	echo $Lk199_periodofinal;
    ?> 
     &nbsp<input id="k199_periodoini" name="k199_periodoini" type="text" size="9" disabled="disabled" style="background-color: #DEB887; color: black;" value="<?=$k199_periodoini?>" ><b> &nbsp a &nbsp</b>
     <input id="k199_periodofinal" name="k199_periodofinal" type="text" size="9" disabled="disabled"  style="background-color: #DEB887; color: black;"  value="<?=$k199_periodofinal?>" >&nbsp
    
    <?
	echo $Lk199_saldofinalextrato;
	db_input('k199_saldofinalextrato',8,$Ik199_saldofinalextrato,true,'text',3,"");
	?>
    </td>
  </tr>
  
  <td>
    <div id='autenticacoes'>
      <table background="#CCCCCC" width='980px' border="1">
        <tr>
          <td bgcolor='#000099'>
            <center><b><font color='#FFFFFF'>Dados da conciliação manual no sistema</font></b></center>
          </td>
        </tr>
        <tr>
          <td>
          <input name="concilia" type="hidden" id="concilia" value="<?=$k199_sequencial?>" >
            <iframe name="iframeAutent" id="iframeAutent" src="cai4_carregalistaconciliacao.php?datai=<?=implode("-", array_reverse(explode("/", $k199_periodoini)))?>&dataf=<?=implode("-", array_reverse(explode("/", $k199_periodofinal)))?>&conta=<?=$k199_codconta?>&concilia=<?=$k199_sequencial?>" width='100%' height='300' > </iframe>
          </td>
        </tr>
      </table>
    </div>
    </td>
  
  <tr>
    <td><b>Saldo final CONCILIADO R$:</b>
    <?php db_input('k200_valor',15,$Ik200_valor,true,'text',3,"");?>
    
    </td>
  </tr>
  </table>
  </fieldset>
  </center>

     <input name="salvarconciliacao" type="button" id="salvarconciliacao" value="Salvar Conciliação"  onClick='js_salvaconciliacao();' style='width:150px'>
     <input name="pendencia" type="button" id="pendencia" value="Incluir Pendência" onclick="js_pendencia();">
     <input name="<?=($db_opcao==1?"emitir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" disabled="disabled" id="db_opcao" value="<?=($db_opcao==1?"Emitir Relatório":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" "><br>
	 <input name="valor" type="hidden">
	<b> *ATENÇÃO! Os registros a serem conciliados, serão apenas as opções "DESMARCADAS". </b> 
</form>


<?
	if(isset($emitir)){
		
	echo "<script>
	$k199_periodofinal=document.form1.k199_periodofinal.value;
	$k199_codconta=document.form1.k199_codconta.value;
	$k199_periodoini=document.form1.k199_periodoini.value;
	$k200_valor=parent.document.form1.k200_valor.value
	//document.form1.k200_valor.value;
	
	</script>";

	$sql=" select k199_periodofinal from conciliacao where k199_periodofinal='{$k199_periodofinal}' and k199_codconta='{$k199_codconta}'  and k199_periodoini='{$k199_periodoini}'";
	
	$result = db_query($sql);
 	$row=pg_num_rows($result);
 	
 	if($row==0){
 		echo "<script>alert('Não possui uma conciliação  com este período. Verifique!');</script>";
 	}
 	else
 	{
	 	 $sql=" SELECT k199_periodofinal FROM conciliacao WHERE k199_periodofinal='{$k199_periodofinal}' AND k199_codconta='{$k199_codconta}'  AND k199_periodoini='{$k199_periodoini}' AND k199_status= 1 ";

	 	 $result = db_query($sql);
	 	 $row=pg_num_rows($result);
		 
	 	 if($row==0){
		 	 echo "<script>
		 	 var x=confirm('A conciliacao que se encontra  neste período, está em aberto. Deseja emitir relatório nessas condições?');
		 	 if(x){
			 		  jan = window.open('cai4_relatorioconmanusql.php?&banco='+document.form1.db83_descricao.value+'&codigoconta='+document.form1.k199_codconta.value+'&periodoinicio='+document.form1.k199_periodoini.value+'&periodofim='+document.form1.k199_periodofinal.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
			 		  
			 		 }else{
			 		 		window.location.replace(window.location.href);
		 				  }
		 	 </script>";
	 	  }else{
	 	  	echo "<script> jan = window.open('cai4_relatorioconmanusql.php?&banco='+document.form1.db83_descricao.value+'&codigoconta='+document.form1.k199_codconta.value+'&periodoinicio='+document.form1.k199_periodoini.value+'&periodofim='+document.form1.k199_periodofinal.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	 	  	
	 	  	</script>";
	 	  }
 	}
 		//echo "<script> parent.document.form1.k200_valor.value=$k200_valor;</script>";
 		echo "<script>parent.document.form1.valor.value=$k200_valor;</script>";
}

?>		



<script>
function js_click(){

	var banco=document.form1.db83_descricao.value;
	var codigoconta=document.form1.k199_codconta.value;
	var periodoinicio=document.form1.k199_periodoini.value;
	var periodofim=document.form1.k199_periodofinal.value;

	var parametro = 'banco='+banco+'&periodoini='+periodoinicio+'&periodofim='+periodofim+'&codconta='+codigoconta;
	
	oParametro = new  Object();
	oParametro.arquivo =parametro;
	
	 var objAjax   = new Ajax.Request (url,{method:'post',parameters:'json='+Object.toJSON(oParametro)});
    
}


function js_salvaconciliacao(){
	var confirmacao = confirm('Deseja realmente salvar essa conciliação? \n Essa operacão irá gerar pendências \n para todos os registros não selecionados');
	  if(!confirmacao){ 
	    return false;
	  }
	  document.getElementById('pendencia').disabled = true;
	  document.getElementById('db_opcao').disabled = false;
	  iframeAutent.verificaChecks("<?=$alterou;?>");
		
}


function js_pesquisak199_codconta(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?funcao_js=parent.js_mostracontabancaria1|db83_sequencial|db83_descricao','Pesquisa',true);
  }else{
     if(document.form1.k199_codconta.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?pesquisa_chave='+document.form1.k199_codconta.value+'&funcao_js=parent.js_mostracontabancaria','Pesquisa',false);
     }else{   
       document.form1.db83_descricao.value = ''; 
     }
  }
}
function js_mostracontabancaria(chave,erro){
  document.form1.db83_descricao.value = chave; 
  if(erro==true){ 
    document.form1.k199_codconta.focus(); 
    document.form1.k199_codconta.value = ''; 
  }
}
function js_mostracontabancaria1(chave1,chave2){
  document.form1.k199_codconta.value = chave1;
  document.form1.db83_descricao.value = chave2;
  db_iframe_contabancaria.hide();
}



function js_pendencia(){

	var dti=document.form1.k199_periodoini.value;
	var dtf=document.form1.k199_periodofinal.value;
	
	var cdataidia = parseInt(dti.split("/")[0].toString());
	var cdataimes=  parseInt(dti.split("/")[1].toString());
	var cdataiano=  parseInt(dti.split("/")[2].toString());

	var datai=cdataiano+'-'+cdataimes+'-'+cdataidia;

	var cdatafdia = parseInt(dtf.split("/")[0].toString());
	var cdatafmes=  parseInt(dtf.split("/")[1].toString());
	var cdatafano=  parseInt(dtf.split("/")[2].toString());

	var dataf=cdatafano+'-'+cdatafmes+'-'+cdatafdia;

  js_OpenJanelaIframe('','db_iframe_conciliacao','db_frmconciliacaopendencia.php?k199_periodoini='+dti+'&k199_periodofinal='+dtf+'','Incluir Pendência',true);
}


function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_conciliacao','func_conciliacao.php?funcao_js=parent.js_preenchepesquisa|k199_sequencial','Pesquisa',true);
}


function js_preenchepesquisa(chave){
  db_iframe_conciliacao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}




function js_processaConciliacao(strJSONAutent,solicitacao,concilia){

	  var pardata   = $('data').value;
	  var parconta  = $('conta').value; 
	  var url       = 'cai4_processaconciliacao.php';
	  var parametro = 'strJSONAutent='+strJSONAutent.replace(/#/g,'')+'&solicitacao='+solicitacao+'&concilia='+concilia+'&data='+pardata+'&conta='+parconta;  
	  var objAjax   = new Ajax.Request (url,{ 
	                                          method:'post',
	                                          parameters:parametro, 
	                                          onComplete:js_retornoConciliacao
	                                         });
	  $('loading').innerHTML = ' <blink> <b> Aguarde Conciliando registros selecionados ... </b> </blink>';

	}



</script>
