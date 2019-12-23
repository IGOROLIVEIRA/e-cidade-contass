<?php

/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

/*
*  @todo criar as tabelas com os campos dessa tela e realizar as validações

	Obs.: O campo l20_nroedital não está cadastro no banco ainda. Depende da OC11211 - ABERLIC

*/

$clliclicita->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("l20_nroedital");
$clrotulo->label("l20_numero");
$clrotulo->label("l20_codtipocom");
$db_opcao = 1;
$db_botao = true;

?>
<style type="text/css">
.fieldsetinterno {
	border:0px;
	border-top:2px groove white;
	margin-top:10px;
		
}
fieldset table tr > td {
	width: 180px;
	white-space: nowrap
}  
.label-textarea{
	vertical-align: top;
}
</style>
<form name="form1" method="post" action="" onsubmit="">
	<center>

	<table align=center style="margin-top:25px;">
	<tr><td>

	<fieldset>
	<legend><strong>Editais</strong></legend>

	<fieldset style="border:0px;">

	<table border="0">
	 <tr>
	   <td nowrap title="<?=@$Tl20_nroedital?>">
	    <b>Número do Edital:</b>
	   </td>
	   <td> 
	    <?
	       db_input('l20_nroedital',10,$Il20_nroedital,true,'text',3,"");
	    ?>
	   </td>
	 </tr>
	 <tr>
	    <td nowrap title="<?=@$Tl20_codepartamento?>">
	    	<b>Processo:</b>
	    </td>
	    <td>
	      <?
	        db_input('l20_edital',10,$Il20_edital,true,'text',3,"onchange='';");
	        db_input('l20_objeto',45,$Il20_descricaodep,true,'text',3,"");
	      ?>
	    </td>
	</tr>
	<tr>
	    <td nowrap title="<?=@$Tl20_codepartamento?>">
	    	<b>Modalidade:</b>
	    </td>
	    <td>
	        <?
	        db_input('l20_numero',10,$Il20_edital,true,'text',3,"onchange='';");
	        db_input('l20_descricao',45,$Il20_descricaodep,true,'text',3,"");
	        ?>
	    </td>
	</tr>
	<tr>
	  <td class="label-textarea" nowrap title="Links da publicação">
	    <b>Links da publicação:</b>
	  </td>
	  <td>
        <?
        	db_textarea('links',4,56,$Il20_razao,true,'text',1, '', '', '', 200);
        ?>
      </td>
	</tr>
	<tr>
	  <td nowrap title="Links da publicação">
	    <b>Origem do recurso:</b>
	  </td>
	  <td>
        <?
	        $arr_tipo = array("0"=>"Selecione","1"=>"1- Próprio","2"=>"2- Estadual","3"=>"3- Federal","4"=>"4- Próprio e Estadual", "5"=> "5- Próprio e Federal", "9"=> "9- Outros");
	        db_select("origem_recurso",$arr_tipo,true,1);
	    ?>
	  </td>
	</tr>
	<tr>
	  <td class="label-textarea" nowrap title="Descrição do recurso">
	    <b>Descrição do Recurso:</b>
	  </td>
	  <td>
        <?
        	db_textarea('descricao_recurso',4,56,'',true,'text',1,"", '', '', 250);
        ?>
      </td>
	</tr>
	<tr>
		<td nowrap title="Data de Envio">
	    	<b>Data de Envio:</b>
	  	</td>
		<td>
			<?= db_inputdata("data_referencia",'', '', '',true,'text',1);?>
		</td>
	</tr>
	   </table>
	  </fieldset>
	 </fieldset>
	</td>
   </tr>
  </table>
 </center>
 <input name="<?=($db_opcao==1?'incluir':($db_opcao==2||$db_opcao==22?'alterar':'excluir'))?>" type="submit" id="db_opcao"
           value="<?=($db_opcao==1?'Incluir':($db_opcao==2||$db_opcao==22?'Alterar':'Excluir'))?>"
        <?=($db_botao==false?'disabled':'') ?>  onClick="js_salvarEdital();">
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
 
<script>
	
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_liclicita','func_liclicita.php?tipo=1&situacao=0&edital=1&funcao_js=parent.js_preenchepesquisa|l20_codigo|l20_edital|l20_nroedital|l20_numero|pc50_descr|dl_Data_Referencia|l20_objeto','Pesquisa',true,"0");
    }

    function js_preenchepesquisa(codigo, edital, nroedital, numero, descricao, data, objeto){
    	let dataFormatada = js_formatar(data, 'd');
    	document.getElementById('l20_edital').value = edital;
    	document.getElementById('l20_numero').value = numero;
    	document.getElementById('l20_nroedital').value = nroedital;
    	document.getElementById('l20_descricao').value = descricao;
    	document.getElementById('data_referencia').value = dataFormatada;
    	document.getElementById('l20_objeto').value = objeto;
    	db_iframe_liclicita.hide();
	}

    function js_salvarEdital(){
    	let descricao = document.getElementById('descricao_recurso').value;
    	let origem_recurso = document.getElementById('origem_recurso').value;

    	if(origem_recurso == 9 && !descricao){
    		alert('Campo descrição da origem do recurso é obrigatório');
    		return false;
    	}
    }

    function limpaCampos(){
    	document.getElementById('l20_edital').value = '';
    	document.getElementById('l20_numero').value = '';
    	document.getElementById('l20_nroedital').value = '';
    	document.getElementById('l20_descricao').value = '';
    	document.getElementById('data_referencia').value = '';
    	document.getElementById('l20_objeto').value = '';
    }

</script> 
