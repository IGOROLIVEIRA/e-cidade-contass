<?
//MODULO: sicom
$cladesaoregprecos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("z01_nome");
$clrotulo->label("pc80_data");
$clrotulo->label("z01_nome");
?>
<fieldset style="width: 650px; height: 500px; margin-top: 0px; margin-left: 10px; float: left;"><legend><b>Adesão de registro de preço</b></legend>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi06_sequencial?>">
       <?=@$Lsi06_sequencial?>
    </td>
    <td> 
<?
db_input('si06_sequencial',10,$Isi06_sequencial,true,'text','3',"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_orgaogerenciador?>">
       <?
       db_ancora(@$Lsi06_orgaogerenciador,"js_pesquisasi06_orgaogerenciador(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si06_orgaogerenciador',10,$Isi06_orgaogerenciador,true,'text',$db_opcao," onchange='js_pesquisasi06_orgaogerenciador(false);'")
?>
       <?
db_input('z01_nomeorg',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_modalidade?>">
      <b>
       <?
         db_ancora("Modalidade :","js_pesquisal20_codtipocom(true);",3);
       ?>
      </b>
    </td>
    <td> 
      <?
      	
        $result_tipo=$clcflicita->sql_record($clcflicita->sql_query_numeracao(null,"l03_codigo,l03_descr", null, "l03_instit = " . db_getsession("DB_instit")));
        if ($clcflicita->numrows==0){
		      db_msgbox("Nenhuma Modalidade cadastrada!!");
		      $result_tipo="";
		      $db_opcao=3;
		      $db_botao = false;
		      db_input("si06_modalidade",10,"",true,"text");
		      db_input("si06_modalidade",40,"",true,"text");
        } else {
          db_selectrecord("si06_modalidade",@$result_tipo,true,$db_opcao,"js_mostraRegistroPreco()");
          if (isset($l20_codtipocom)&&$l20_codtipocom!=""){
            echo "<script>document.form1.l20_codtipocom.selected=$l20_codtipocom;</script>";
          }
        }
      ?>
    </td>
  </tr>
 
  <tr>
    <td nowrap title="<?=@$Tsi06_numeroprc?>">
       <?=@$Lsi06_numeroprc?>
    </td>
    <td> 
<?
db_input('si06_numeroprc',10,$Isi06_numeroprc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_numlicitacao?>">
       <?=@$Lsi06_numlicitacao?>
    </td>
    <td> 
<?
db_input('si06_numlicitacao',10,$Isi06_numlicitacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_dataadesao?>">
       <?=@$Lsi06_dataadesao?>
    </td>
    <td> 
<?
db_inputdata('si06_dataadesao',@$si06_dataadesao_dia,@$si06_dataadesao_mes,@$si06_dataadesao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_dataata?>">
       <?=@$Lsi06_dataata?>
    </td>
    <td> 
<?
db_inputdata('si06_dataata',@$si06_dataata_dia,@$si06_dataata_mes,@$si06_dataata_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_datavalidade?>">
       <?=@$Lsi06_datavalidade?>
    </td>
    <td> 
<?
db_inputdata('si06_datavalidade',@$si06_datavalidade_dia,@$si06_datavalidade_mes,@$si06_datavalidade_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_publicacaoaviso?>">
       <?=@$Lsi06_publicacaoaviso?>
    </td>
    <td> 
<?
db_inputdata('si06_publicacaoaviso',@$si06_publicacaoaviso_dia,@$si06_publicacaoaviso_mes,@$si06_publicacaoaviso_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_objetoadesao?>">
       <?=@$Lsi06_objetoadesao?>
    </td>
    <td> 
<?
db_textarea('si06_objetoadesao','10','40',$Isi06_objetoadesao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_orgarparticipante?>">
       <?=@$Lsi06_orgarparticipante?>
    </td>
    <td> 
<?
    $x = array('1'=>'Orgão Participante','2'=>'Não Participante');
	db_select('si06_orgarparticipante',$x,true,$db_opcao," onchange='js_verifica_select(this.value);'");
    ?>

    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_cgm?>">
       <?
       db_ancora(@$Lsi06_cgm,"js_pesquisasi06_cgm(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si06_cgm',10,$Isi06_cgm,true,'text',$db_opcao," onchange='js_pesquisasi06_cgm(false);'")
?>
       <?
db_input('z01_nomeresp',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_descontotabela?>">
       <?=@$Lsi06_descontotabela?>
    </td>
    <td> 
<?
//db_input('si06_descontotabela',10,$Isi06_descontotabela,true,'text',$db_opcao,"")

$x = array('1'=>'Sim','0'=>'Não');
	db_select('si06_descontotabela',$x,true,$db_opcao," onchange='js_verifica_select(this.value);'");

?>
    </td>
  </tr>
  </table>
  </fieldset>
  <fieldset style="width: 640px; height: 190px; margin-top: 40px; "><legend><b>Pesquisa de preços do objeto da adesão</b></legend>
  <table>
  <tr>
    <td nowrap title="<?=@$Tsi06_numeroadm?>">
       <?=@$Lsi06_numeroadm?>
    </td>
    <td> 
<?
db_input('si06_numeroadm',10,$Isi06_numeroadm,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_dataabertura?>">
       <?=@$Lsi06_dataabertura?>
    </td>
    <td> 
<?
db_inputdata('si06_dataabertura',@$si06_dataabertura_dia,@$si06_dataabertura_mes,@$si06_dataabertura_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_processocompra?>">
       <?
       db_ancora(@$Lsi06_processocompra,"js_pesquisasi06_processocompra(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si06_processocompra',10,$Isi06_processocompra,true,'text',$db_opcao," onchange='js_pesquisasi06_processocompra(false);'")
?>
       <?
db_input('pc80_data',10,$Ipc80_data,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_fornecedor?>">
       <?
       db_ancora(@$Lsi06_fornecedor,"js_pesquisasi06_fornecedor(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si06_fornecedor',10,$Isi06_fornecedor,true,'text',$db_opcao," onchange='js_pesquisasi06_fornecedor(false);'")
?>
       <?
db_input('z01_nomef',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_tipodocumento?>">
       <?=@$Lsi06_tipodocumento?>
    </td>
    <td> 
<?
//db_input('si06_tipodocumento',10,$Isi06_tipodocumento,true,'text',$db_opcao,"")
$x = array('1'=>'CPF','2'=>'CNPJ','3'=>'Documento de Estrangeiros');
	db_select('si06_tipodocumento',$x,true,$db_opcao," onchange='js_verifica_select(this.value);'");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi06_numerodocumento?>">
       <?=@$Lsi06_numerodocumento?>
    </td>
    <td> 
<?
db_input('si06_numerodocumento',14,$Isi06_numerodocumento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  <table>
  <tr>
  <td>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="excluir" type="submit" id="db_opcao" value="Excluir"> 
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</td>
</tr>
</table>
</table>
  </center>
</fieldset>
</form>
<script>
function js_pesquisasi06_orgaogerenciador(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgmorgao1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.si06_orgaogerenciador.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.si06_orgaogerenciador.value+'&funcao_js=parent.js_mostracgmorgao','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgmorgao(chave,erro){
  document.form1.z01_nomeorg.value = chave; 
  if(erro==true){ 
    document.form1.si06_orgaogerenciador.focus(); 
    document.form1.si06_orgaogerenciador.value = ''; 
  }
}
function js_mostracgmorgao1(chave1,chave2){
  document.form1.si06_orgaogerenciador.value = chave1;
  document.form1.z01_nomeorg.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisasi06_cgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgmresp1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.si06_cgm.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.si06_cgm.value+'&funcao_js=parent.js_mostracgmresp','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgmresp(chave,erro){
  document.form1.z01_nomeresp.value = chave; 
  if(erro==true){ 
    document.form1.si06_cgm.focus(); 
    document.form1.si06_cgm.value = ''; 
  }
}
function js_mostracgmresp1(chave1,chave2){
  document.form1.si06_cgm.value = chave1;
  document.form1.z01_nomeresp.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisasi06_processocompra(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc|pc80_data','Pesquisa',true);
  }else{
     if(document.form1.si06_processocompra.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_pcproc','func_pcproc.php?pesquisa_chave='+document.form1.si06_processocompra.value+'&funcao_js=parent.js_mostrapcproc','Pesquisa',false);
     }else{
       document.form1.pc80_data.value = ''; 
     }
  }
}
function js_mostrapcproc(chave,erro){
  document.form1.pc80_data.value = chave; 
  if(erro==true){ 
    document.form1.si06_processocompra.focus(); 
    document.form1.si06_processocompra.value = ''; 
  }
}
function js_mostrapcproc1(chave1,chave2){
  document.form1.si06_processocompra.value = chave1;
  document.form1.pc80_data.value = chave2;
  db_iframe_pcproc.hide();
}
function js_pesquisasi06_fornecedor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.si06_fornecedor.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.si06_fornecedor.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nomef.value = ''; 
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nomef.value = chave; 
  if(erro==true){ 
    document.form1.si06_fornecedor.focus(); 
    document.form1.si06_fornecedor.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.si06_fornecedor.value = chave1;
  document.form1.z01_nomef.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
	parent.document.formaba.db_itens.disabled=true;
  js_OpenJanelaIframe('','db_iframe_adesaoregprecos','func_adesaoregprecos.php?funcao_js=parent.js_preenchepesquisa|si06_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_adesaoregprecos.hide();
  <?
  if($db_opcao){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_pesquisal20_codtipocom(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_pctipocompra','func_pctipocompra.php?funcao_js=parent.js_mostrapctipocompra1|pc50_codcom|pc50_descr','Pesquisa',true,0);
	  }else{
	     if(document.form1.l20_codtipocom.value != ''){ 
	        js_OpenJanelaIframe('top.corpo','db_iframe_pctipocompra','func_pctipocompra.php?pesquisa_chave='+document.form1.l20_codtipocom.value+'&funcao_js=parent.js_mostrapctipocompra','Pesquisa',false);
	     }else{
	       document.form1.pc50_descr.value = ''; 
	     }
	  }
	}
	function js_mostrapctipocompra(chave,erro){
	  document.form1.pc50_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.l20_codtipocom.focus(); 
	    document.form1.l20_codtipocom.value = ''; 
	  }
	}
	function js_mostrapctipocompra1(chave1,chave2){
	  document.form1.l20_codtipocom.value = chave1;
	  document.form1.pc50_descr.value = chave2;
	  db_iframe_pctipocompra.hide();
	}

</script>
