<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_GET_VARS);

$clcaixa   =  new cl_concmanupendecaixa;
$clextrato =  new cl_concmanupendeextrato;


?>
<html>
<head>
	<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Expires" CONTENT="0">
	
	 <script type="text/javascript" src="jquery.js"></script>
     
	<?php 
  	db_app::load("scripts.js, prototype.js, strings.js ");
  	db_app::load("estilos.css, grid.style.css");
  	db_app::load("widgets/windowAux.widget.js");
        db_app::load("dbmessageBoard.widget.js");
	?>
	<link href="conciliacao.css" rel="stylesheet" type="text/css">
  <script>
  
   
    function js_processaRequest(datai,dataf,conta,concilia){
       
      js_divCarregando("Aguarde carregando dados ...", "msgBox");
      var url       = 'cai4_carregadadosconciliacao.php';
      var parametro = 'datai='+datai+'&dataf='+dataf+'&conta='+conta+'&concilia='+concilia;  
      var objAjax   = new Ajax.Request (url,{method:'post',parameters:parametro, onComplete:js_loadTable});
    }


    function js_salvosucesso(){
	      js_removeObj("msgBox");
	      alert("Dados salvos com SUCESSO! ");
	      js_loadTable();
	        
    }


    function js_loadTable(resposta){

			var retorno = resposta.responseText.split('|||');

			if(retorno[0].replace('\n','') != '1')
			{
				if(carregado!=1)
				{
		        	$('divloading').innerHTML = ' <b> Nenhum registro para a data selecionada.  </b>';
		        	js_removeObj("msgBox");
						return false;
				}
			}
			if(retorno[0].replace('\n','') == '3'){	
				js_salvosucesso();
			}else if(retorno[0].replace('\n','') != '2' && retorno[0].replace('\n','') != '3' && retorno[0].replace('\n','') != '1'){
					alert("Ocorreu um erro na rotina de manipulaçao de banco de dados. Verifique!");	      
					js_removeObj("msgBox");
								
				 }     
				   
			

      eval('var objJ = '+retorno[1]+';');
      
      tabela = "  <table class=grid width='100%' id='tabelaAutent'> "+ 
               "    <tr id='cabecalho'>"+ 
               
               "      <td class='cabe' align='center' nowrap > <a href='javascript:js_marcarTodos()'><b>| Marcar todos |</b></a> "+
               "      <td class='cabe' align='center' nowrap > <b> Id                		 </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Descrição          		 </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Cheque                    </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Ordem                     </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Slip                      </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Planilha                  </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Receita                   </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Crédito                   </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Débito                    </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Data              		 </b></td> "+
               "      <td class='cabe' align='center' nowrap > <b> Autenticação       		 </b></td> "+
               "    </tr> ";
      /*
       * Declaro as variáveis para serem usadas no cálculo.
       */
      var debito=0;
      var credito=0;
      credito=new Number(credito); 
      var calculoload=0;
      var status='';
      soma=false;
      var tipocaixa=0;
      var tipoextrato=0;
      var tipopendencia='';
      var somapeninput=0;
      var somapenoutput=0;
 	  var valoratual=parent.document.form1.k200_valor.value;
 	  //  
 	  /*
 	   * Loop para preencher a tabela com dados do select
 	   */
 	  calculoload=objJ[objJ.length-1];// alert( calculoload);
      for (i = 0; i < objJ.length-1; i++) {// para impedir que o objeto da ultima posição seja retornado . O objeto da ultima posição e um calculo
    	  
    	  if (objJ[i].tipopendcaix==1 || objJ[i].tipopendextr==1){
			/*
			 * Retorna o objeto  a posição final  do array que será o calculo no arquivo cai4_carregadadosconciliacao.php 
			 */
    		  //calculoload=objJ[objJ.length-1];
              var checado             = ''; 
              soma=true;
              var linha ='style="background-color: #CCCCFF;"';
             // calculoload=0;
            }else
                {
                	var checado       = 'checked';
                	linha ='';
                }
     
        tabela = tabela+ 
        " <tr id='tabLinha"+i+"'  "+linha+"  class='"+objJ[i].classe+"' onDblClick='parent.js_desprocessarItens("+objJ[i].itemconciliacao+",\"autent\");'> "+
        "   <td nowrap id='chk"+i+"'     align='center' >"+ 
        "	<input type='hidden' name='objJSON"+i+"'       id='objJSON"+i+"'       value='"+objJ[i].toSource()    +"' > "									+ 
        "	<input type='hidden' name='valorpend"+i+"'     id='valorpend"+i+"'     value='"+objJ[i].valorpen      +"'> " 									+
        "	<input type='hidden' name='status"+i+"'        id='status"+i+"'        value='"+objJ[i].status        +"'> " 									    +
        "	<input type='hidden' name='tipopendencia"+i+"' id='tipopendencia"+i+"' value='"+objJ[i].tipopend      +"'> " 								+
        "	<input type='hidden' name='tipocaixa"+i+"'     id='tipocaixa"+i+"'     value='"+objJ[i].tipopendcaix  +"'> " 								+
        "	<input type='hidden' name='tipoextrato"+i+"'   id='tipoextrato"+i+"'   value='"+objJ[i].tipopendextr  +"'> " 							+
        "	<input type='hidden' name='seqpend"+i+"'       id='seqpend"+i+"'       value='"+objJ[i].seqtipend     +"'> " 									+
        "	<input type='hidden' name='datapend"+i+"'      id='datapend"+i+"'      value='"+objJ[i].datapend      +"'> " 									+
        
        "   <input type='checkbox' name='marcado"+i+"' id='marcado"+i+"' "+checado+"  onClick='js_somaAutenticacoes(this,"+i+");'> </td>"+
        "   <td nowrap id='id"+i+"'             align='center' > "+objJ[i].codigocaixa   +"                                                     </td> "+
        "   <td nowrap id='descricao"+i+"'      align='center' > "+objJ[i].descricao     +"                                                     </td> "+
        "   <td nowrap id='cheque"+i+"'         align='center' > "+objJ[i].cheque        +"                                                     </td> "+
        "   <td nowrap id='op"+i+"'             align='center' > "+objJ[i].codordem      +"                                                     </td> "+
        "   <td nowrap id='slip"+i+"'           align='center' > "+objJ[i].codslip       +"                                                     </td> "+
        "   <td nowrap id='planilha"+i+"'       align='center' > "+objJ[i].codplanilha   +"                                                     </td> "+
        "   <td nowrap id='receita"+i+"'        align='center' > "+objJ[i].receita       +"                                                     </td> "+
        "   <td nowrap id='credito"+i+"'        align='center' > "+objJ[i].credito       +"                                                     </td> "+
        "   <td nowrap id='debito"+i+"'         align='center' > "+objJ[i].debito        +"                                                     </td> "+
        "   <td nowrap id='data"+i+"'           align='center' > "+objJ[i].data          +"                                                     </td> "+
        "   <td nowrap id='autenticacao"+i+"'   align='center' > "+objJ[i].codigoaut     +"                                                     </td> "+
        " </tr>  ";
        
        } 

		if(parent.document.form1.k200_valor.value==''){
			parent.document.form1.k200_valor.value='0,00';
		}
       
     
      tabela = tabela+ "</table>"; 
      document.getElementById('tabelaAutenticacoes').innerHTML = tabela;
              // para adicionar na caixa de texto da interface o valor do calculo 
	   	 parent.document.form1.k200_valor.value=calculoload.toFixed(2);
       
      $('divloading').innerHTML = '';
      js_removeObj("msgBox");
      /*
       * Variavel de controle para realização dos calculos na função  js_somaAutenticacoes;
       */
      click=0;
      arrayLinha = new Array();
    }
	   

	/*
	 * Função para marcar todos os checkbox em apenas em um click
	 */
     function js_marcarTodos()
     {   
			var objTableAutent   = document.getElementById('tabelaAutent');

			linha = document.getElementById('tabLinha'+1);

			var inputs = document.getElementsByTagName('input');
	
			for (var i=1;i < objTableAutent.rows.length; i++ )
			{
       				eval('var chk = $("marcado'+(i-1)+'");');
       			
	       	     		if (chk.checked)
						{
							chk.checked = false;
							
						    js_somaAutenticacoes(chk,i);
						}
						else
						{
					    	 chk.checked = true;
					         js_somaAutenticacoes(chk,i);
						}
			}
		}


     /*
      * Função a ser chamada a cada click no checkbox, para realizar as operações matemáticas compatíveis  
      */   
    function js_somaAutenticacoes(obj,id){ 

   	 var valoratual;
	 
		if(soma==true){
	      valoratual=0;
		}else{
		      valoratual=parent.document.form1.k200_valor.value;
			 }
    	 var calculo;
   	     var valorfinalextrato=parent.document.form1.k199_saldofinalextrato.value;
    	 //var valoratual=parent.document.form1.k200_valor.value;
    	 var valorpe= document.getElementById('valorpend'+id).value;
    	 var debito=document.getElementById('debito'+id).innerHTML;
    	 var credito=document.getElementById('credito'+id).innerHTML;
		 var tipopend=document.getElementById('tipopendencia'+id).value;
		 var somaout=0;
		 var somapenin=0;
		 
		 valoratual= parseFloat(valoratual);
		 
		 debito =debito.replace(/\./gi,"");
		 debito = debito.replace(",",".");
		 debito = new Number(debito);
		

		 credito =credito.replace(/\./gi,"");
		 credito = credito.replace(",",".");
		 credito = new Number(credito);

		 valorfinalextrato =valorfinalextrato.replace(/\./gi,"");
		 valorfinalextrato = valorfinalextrato.replace(",",".");
		 valorfinalextrato = new Number(valorfinalextrato);
		 
    	 linha = document.getElementById('tabLinha'+id);
    	 /*
    	  * SE o checkbox estiver marcado, será uma espécie de cálculo, senão será outro.
    	  */
         if(obj.checked==false){
        	 linha.className = 'preselecionado';//css
        	/*
        	 *Para impedir erros nos cálculos, verificando se o mesmo não está vazio ou não é um número!
        	 */
        	 if(isNaN(parseFloat(valorpe.replace(".","")))){
        		 valorpe=document.getElementById('valorpend'+id).value;
        		 valorpe =valorpe.replace(/\./gi,"");
        		 valorpe = valorpe.replace(",",".");
        		 valorpe = new Number(valorpe);
 			 }
 			 else{
 	 			  /*
 	 			   * Para verificar de qual tipo é a conta. Se é entrada ou saída não movimentada no caixa  para aplicar as fórmulas condizentes. 
 	 			   */
	 				if(tipopend==1){
	 					somapenin=document.getElementById('valorpend'+id).value;
	 					//alert("in"+somapenin);
	 				 	//debito=0;
	 				}
	 				else if(tipopend==2){
	 					somaout=document.getElementById('valorpend'+id).value;
	 					somaout =somaout.replace(/\./gi,"");
	 					somaout =somaout.replace(",",".");
	 					somaout = new Number(somaout);
	 					//alert("out"+somaout);
	 					//credito=0;
	 				}		
 			}
         	 /*Math.abs(parseFloat(
         	  * Verifico  qual fórmula matemática devo aplicar. Cálculo (saldofinal + entrada não compensada no caixa - saida não compensada no caixa - entrada nao movimentada no extrato + saída não movimentada no extrato)
         	  */
         	  
         	  if(valoratual=='0,00' || valoratual==0){
        
         		      calculo=parseFloat(valorfinalextrato)+parseFloat(somapenin) - parseFloat(somaout)+parseFloat(debito)-parseFloat(credito);
         		
              }else{
            		  calculo=parseFloat(valoratual)+parseFloat(somapenin) - parseFloat(somaout)+parseFloat(debito)-parseFloat(credito);
                   }
	    		      parent.document.form1.k200_valor.value=calculo.toFixed(2);
         }
         else{
     	 	    linha.className = 'normal';//css
        		if(tipopend==1){
 					somapenin=document.getElementById('valorpend'+id).value;
 				}
 				else if(tipopend==2){
 					somaout=document.getElementById('valorpend'+id).value;
 				}
 				/*
 				 *Variável de controle declarada no inicio da tabela, para verificar clicks . Necessária para a aplicação dos cálculos
 				 */
 				
            	if(click==0){
            		
            		//vatual -(fe+(somapenin-somaout-debito))+credito;
            		if(debito!=0)
            		{
            			calculo=parseFloat(valoratual) - (parseFloat(valorfinalextrato)+(parseFloat(somapenin)-parseFloat(somaout)+debito))-credito;
            			parent.document.form1.k200_valor.value=calculo.toFixed(2);
                	}
            		else{
            			calculo=parseFloat(valoratual)-((parseFloat(valorfinalextrato)+parseFloat(somapenin)) - (parseFloat(somaout)+parseFloat(debito))-parseFloat(credito));
                		}
            		
                	click++;          	
                	parent.document.form1.k200_valor.value=calculo.toFixed(2);
                	
                }else{
                	    valorfinalextrato=0;
                	if(debito!=0){
                		calculo=parseFloat(valoratual) - (parseFloat(valorfinalextrato)+(parseFloat(somapenin)-parseFloat(somaout)+debito))-credito;
                		parent.document.form1.k200_valor.value=calculo.toFixed(2);
                    }else{
                    		calculo=parseFloat(valoratual)-((parseFloat(valorfinalextrato)+parseFloat(somapenin)) - (parseFloat(somaout)+parseFloat(debito))-parseFloat(credito));
                         }
                	
                	    parent.document.form1.k200_valor.value=calculo.toFixed(2);
                     }
                }
      }

    /*
     * Essa função é chamada pelo botao salvar conciliação em arquivo de formulário, sendo enviado a variável ALTEROU, para verificar se o usuario esta alterando ou incluindo a pendência   
     */
    function verificaChecks(alterou){
    
    	var objTableAutent   = document.getElementById('tabelaAutent');
    	var url = 'cai4_conciliacaopendcaixaInsert.php';
    	//var alterou;

    	var datapendencia;
		var id;
		var sequencialconcilicao=parent.document.form1.k199_sequencial.value;
		
		var seqtipend='';
		var datapendenciacaixa='';
		var datapendenciaextrato='';
		var debito=0;
   	 	var credito=0;

   	 	var autenticacao;
		
  	 	
		var datai=parent.document.form1.k199_periodoini.value;

		var cdataidia=parseInt(datai.split("/")[0].toString());
		var cdataimes=parseInt(datai.split("/")[1].toString());
		var cdataiano=parseInt(datai.split("/")[2].toString());

		datai= cdataiano+'-'+cdataimes+'-'+cdataidia;
			
		var dataf=parent.document.form1.k199_periodofinal.value;

		var cdatadiaf=parseInt(dataf.split("/")[0].toString());
		var cdatamesf=parseInt(dataf.split("/")[1].toString());
		var cdatanof= parseInt(dataf.split("/")[2].toString());

		dataf= cdatanof+'-'+cdatamesf+'-'+cdatadiaf;

		var conta = parent.document.form1.k199_codconta.value;
		var row =objTableAutent.rows.length-2; 

		if(alterou) 
		{  js_divCarregando("Salvando dados, Por favor AGUARDE...", "msgBox");
			var arrayPrincipal  =  new Array();
		
			for (var i=0;i <=row; i++ )
			{
		   			eval('var chk = $("marcado'+i+'");');
		   			
		   			var sequencialconcilicao=parent.document.form1.k199_sequencial.value;
		   			tipopendencia=document.getElementById('tipopendencia'+i).value;
		   			datapendencia=document.getElementById('datapend'+i).value;
		   			datapendenciaextrato=document.getElementById('data'+i).innerHTML;
		   			seqtipend=document.getElementById('id'+i).innerHTML;
					autenticacao=document.getElementById('autenticacao'+i).innerHTML;	

					if (chk.checked==false) // se for 1 ou  2 será caixa 
					{ 
						    debito=document.getElementById('debito'+i).innerHTML;
						    credito=document.getElementById('credito'+i).innerHTML;
						    datapendenciaextrato=document.getElementById('data'+i).innerHTML;
						    tipopendencia=document.getElementById('tipopendencia'+i).value;

						    obj = new Object();

						    obj.autenticacao=autenticacao;
							obj.conciliacao= sequencialconcilicao;
							obj.datapend=datapendenciaextrato;
							obj.tipopendencia= tipopendencia;
							obj.credito= credito;
							obj.debito= debito;
							obj.alterou='true';
							obj.sequencialpe=seqtipend;
							obj.insertaltera='false';


							arrayPrincipal[i]=obj;

							oParametro = new  Object();
							oParametro.arquivo = arrayPrincipal; 

					}else{
						    debito=document.getElementById('debito'+i).innerHTML;
						    credito=document.getElementById('credito'+i).innerHTML;
						    datapendenciaextrato=document.getElementById('data'+i).innerHTML;
						    tipopendencia=document.getElementById('tipopendencia'+i).value;

						    obj = new Object();

							obj.autenticacao=autenticacao;
							obj.conciliacao= sequencialconcilicao;
							obj.datapend=datapendenciaextrato;
							obj.tipopendencia= tipopendencia;
							obj.credito= credito;
							obj.debito= debito;
							obj.sequencialpe=seqtipend;
							obj.insertaltera='true';


							arrayPrincipal[i]=obj;

							oParametro = new  Object();
							oParametro.arquivo = arrayPrincipal;
						 }
			  }	//alert("passou1");			 alert(Object.toJSON(arrayPrincipal));
				//js_divCarregando("Salvando dados, Por favor AGUARDE...", "msgBox");
			 var objAjax   = new Ajax.Request (url,{method:'post',parameters:'json='+Object.toJSON(oParametro),  onComplete:js_loadTable});
			 
			 carregado=1;
		}
		else
		{  
			js_divCarregando("Salvando dados, Por favor AGUARDE...", "msgBox");
			var arrayPrincipal  =  new Array();
			for (var i=0;i <=row; i++ )
			{	
		   			eval('var chk = $("marcado'+i+'");');
		   			
		   			tipopendencia=document.getElementById('tipopendencia'+i).value;
		   			
		   			datapendencia=document.getElementById('data'+i).innerHTML;

		   			seqtipend=document.getElementById('id'+i).innerHTML;	
		   			datapendenciaextrato=document.getElementById('data'+i).innerHTML;

					autenticacao=document.getElementById('autenticacao'+i).innerHTML;	
						
					if (chk.checked==false) // se for 1 ou  2 será caixa 
					{   
 					    debito=document.getElementById('debito'+i).innerHTML;
					    credito=document.getElementById('credito'+i).innerHTML;
					    datapendenciaextrato=document.getElementById('data'+i).innerHTML;
					    tipopendencia=document.getElementById('tipopendencia'+i).value;
				 	    
						obj = new Object();
						obj.autenticacao=autenticacao;
						obj.conciliacao= sequencialconcilicao;
						obj.tipopendencia= tipopendencia;
						obj.datapend= datapendenciaextrato;
						obj.credito= credito;
						obj.debito= debito;
						obj.sequencialpe=seqtipend;

						arrayPrincipal[i]=obj;

						oParametro = new  Object();
						oParametro.arquivo = arrayPrincipal;	
					}
			  }//alert("passou2");
			//js_divCarregando("Salvando dados, Por favor AGUARDE...", "msgBox");
			 var objAjax   = new Ajax.Request (url,{method:'post',parameters:'json='+Object.toJSON(oParametro),  onComplete:js_loadTable});
			 carregado=1;
		
			 	 
		 }
     }
     
  </script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <form name='form1'>	

    <div id=divloading ></div>

    <div id=tabelaAutenticacoes>
      <script> js_processaRequest("<?=str_replace(" ", "",$datai)?>","<?=str_replace(" ", "",$dataf)?>","<?=trim($conta)?>","<?=$concilia?>"); </script>
    </div>
  </form>
</body>
</html>
