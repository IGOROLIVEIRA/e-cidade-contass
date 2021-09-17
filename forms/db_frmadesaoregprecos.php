<?
//MODULO: sicom
$cladesaoregprecos->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("z01_nome");
$clrotulo->label("z01_nome");
$clrotulo->label("si06_anoproc");
?>
<fieldset style="width: 650px; margin-top: 0px;"><legend><b>Informações do Orgão Gerenciador</b></legend>
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
    <tr id="tr_edital">
        <td>
            <b><?="Edital:"?></b>
        </td>
        <td>
            <?= db_input('si06_edital', 10, $Isi06_edital, true, 'text', $db_opcao, 'onkeypress="return onlynumber();"', '', '', '', 10);?>
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
      <td nowrap title="<?=@$Tsi06_anoproc?>">
        <?=@$Lsi06_anoproc?>
      </td>
      <td>
<?
db_input('si06_anoproc',10,$Isi06_anoproc,true,'text',$db_opcao,"")
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
      	$aModalidade = array("2" => "Pregão","1" => "Concorrência");
		    db_select("si06_modalidade",$aModalidade,true,$db_opcao,"");
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

  </table>
  </fieldset>
  <fieldset style="width: 640px; height: 400px; margin-top: 40px; "><legend><b>Informações do Orgão de Adesão</b></legend>
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
    <td nowrap title="<?=@$Tsi06_objetoadesao?>" colspan="2">
    <fieldset><legend><?=@$Lsi06_objetoadesao?></legend>

<?
db_textarea('si06_objetoadesao','10','80',$Isi06_objetoadesao,true,'text',$db_opcao,"onkeypress= 'travarEnter()' onmouseout='travarEnter()'","","",500)
?>
    </fieldset>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tsi06_descontotabela?>">
       <?=@$Lsi06_descontotabela?>
    </td>
    <td>
<?
//db_input('si06_descontotabela',10,$Isi06_descontotabela,true,'text',$db_opcao,"")

$x = array('2'=>'Não','1'=>'Sim');
	db_select('si06_descontotabela',$x,true,$db_opcao," onchange='js_verifica_select(this.value);'");

?>
    </td>
  </tr>

  <tr>
    <td nowrap >
       <b>Processo por Lote: </b>
    </td>
    <td>
<?
$x = array('2'=>'Não','1'=>'Sim');
	db_select('si06_processoporlote',$x,true,$db_opcao,"");
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
    </td>
  </tr>
  </table>
  <table>
  <tr>
  <td>

</td>
</tr>
</table>
</table>
  </center>
</fieldset>
<div align="center">
<? if($db_opcao == 1 || $db_opcao == 2 || $db_opcao == 22){ ?>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<? } ?>
<input name="excluir" type="submit" id="db_opcao" value="Excluir">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</div>
</form>
<script>
    js_exibeEdital();
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
function travarEnter() {
      var  va = document.getElementById("si06_objetoadesao").value;
      var valo = va.split("\n");
      var msg = "";
      for(i=0;i<valo.length;i++){
        if(i==0){
          msg += valo[i];
        }else{
          msg += " "+valo[i];
        }
         
      }
      if(valo.length>0){
        document.getElementById("si06_objetoadesao").value = "";
        document.getElementById("si06_objetoadesao").value = msg;
      }
      var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
      
      if( keyCode == 13 ) {


      if(!e) var e = window.event;

      e.cancelBubble = true;
      e.returnValue = false;

      if (e.stopPropagation) {
        e.stopPropagation();
        e.preventDefault();
      }
    } 

}

function onlynumber(evt) {
   var theEvent = evt || window.event;
   var key = theEvent.keyCode || theEvent.which;
   key = String.fromCharCode( key );
   //var regex = /^[0-9.,]+$/;
   var regex = /^[0-9.]+$/;
   if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
   }
}

function js_mostracgmorgao(erro,chave){
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
    js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgmresp1|z01_numcgm|z01_nome&filtro=1','Pesquisa',true);
  }else{
     if(document.form1.si06_cgm.value != ''){
        js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?pesquisa_chave='+document.form1.si06_cgm.value+'&funcao_js=parent.js_mostracgmresp&filtro=1','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgmresp(erro,chave){
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
    js_OpenJanelaIframe('','db_iframe_pcproc','func_pcproc.php?lFiltroPrecoRef=1&filtrovinculo=true&funcao_js=parent.js_mostrapcproc1|pc80_codproc','Pesquisa',true);
  }else{
     if(document.form1.si06_processocompra.value != ''){
        js_OpenJanelaIframe('','db_iframe_pcproc','func_pcproc.php?lFiltroPrecoRef=1&filtrovinculo=true&pesquisa_chave='+document.form1.si06_processocompra.value+'&funcao_js=parent.js_mostrapcproc','Pesquisa',false);
     }
  }
}
function js_mostrapcproc(chave,erro){
  if(erro==true){
    document.form1.si06_processocompra.focus();
    document.form1.si06_processocompra.value = '';
  }
}
function js_mostrapcproc1(chave1,chave2){
  document.form1.si06_processocompra.value = chave1;
  db_iframe_pcproc.hide();
}

function js_pesquisa(){
	parent.document.formaba.db_itens.disabled=true;
  js_OpenJanelaIframe('','db_iframe_adesaoregprecos','func_adesaoregprecos.php?funcao_js=parent.js_preenchepesquisa|si06_sequencial|si06_anocadastro','Pesquisa',true);
}
function js_preenchepesquisa(chave, anocadastro){
  db_iframe_adesaoregprecos.hide();
  js_exibeEdital(anocadastro);
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
    function js_exibeEdital(ano=null){
        let anousuario = "<?=db_getsession('DB_anousu');?>";
        if(parseInt(anousuario) >= 2020 && (!ano || ano)){
            document.getElementById('tr_edital').style.display = '';
        }else{
            document.getElementById('tr_edital').style.display = 'none';
        }
    }
</script>
