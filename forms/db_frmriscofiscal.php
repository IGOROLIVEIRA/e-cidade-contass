<?
//MODULO: sicom
$clriscofiscal->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o119_versao");
      if($db_opcao==1){
 	   $db_action="sic1_riscofiscal004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="sic1_riscofiscal005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="sic1_riscofiscal006.php";
      }

$si53_instituicao= db_getsession("DB_instit");
?>
<form name="form1" method="post" action="<?=$db_action?>" onsubmit="js_submit();">
<center>
<fieldset style="width: 800px; margin-left: 200px; margin-top: 80px;"><legend
	style="font-weight: bold;"> Riscos Fiscais</legend>
<table border="0">
	<tr>
    <td nowrap title="<?=@$Tsi53_sequencial?>">
       <?=@$Lsi53_sequencial?>
    </td>
    <td>
	<?
	db_input('si53_sequencial',8,$Isi53_sequencial,true,'text',3,"")
	?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi53_exercicio?>">
       <?=@$Lsi53_exercicio?>
    </td>
    <td>
		<?
		db_input('si53_exercicio',8,$Isi53_exercicio,true,'text',$db_opcao,"")
		?>
    </td>
  </tr>


   </tr>
  <tr>
    <td nowrap title="<?=@$Tsi53_instituicao?>">
       <b>Instituição:</b>
    </td>
    <td>
		<?
		db_input('si53_instituicao',8,$Isi53_instituicao,true,'text',3,"")
		?>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tsi53_codigoppa?>">
       <?
       db_ancora(@$Lsi53_codigoppa,"js_pesquisasi53_codigoppa(true);",$db_opcao);
       ?>
    </td>
    <td>
		<?
			db_input('si53_codigoppa',8,$Isi53_codigoppa,true,'text',3," onchange='js_pesquisasi53_codigoppa(false);'")
		?>
		<?
			db_input('o119_versao',15,$Io119_versao,true,'text',3,'')
		?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi53_codriscofiscal?>">
       <?=@$Lsi53_codriscofiscal?>
    </td>
    <td>
	<?
	//db_input('si53_codriscofiscal',8,$Isi53_codriscofiscal,true,'text',$db_opcao,"")
	$asi53_codriscofiscal = array("1"=>"1- Demandas Judiciais","2"=>"2- Dívidas em Processo de Reconhecimento",
	"3"=>"3- Avais e Garantias Concedidas","4"=>"4- Assunção de Passivos","5"=>"5- Assistências Diversas","6"=>"6- Outros Passivos Contingentes",
	"7"=>"7- Frustração de Arrecadação","8"=>"8- Restituição de Tributos a Maior","9"=>"9- Discrepância de Projeções","10"=>"10-Outros Riscos Fiscais");
	   db_select("si53_codriscofiscal",$asi53_codriscofiscal,true,$db_opcao);
    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi53_dscriscofiscal?>">
       <?=@$Lsi53_dscriscofiscal?>
    </td>
    <td>
		<?
    db_textarea("si53_dscriscofiscal",7,40, "", true, "text", $db_opcao, "", "", "",500);
		?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tsi53_valorisco?>">
       <?=@$Lsi53_valorisco?>
    </td>
    <td>
<?
db_input('si53_valorisco',15,$Isi53_valorisco,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

function js_pesquisasi53_codigoppa(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_riscofiscal','db_iframe_ppaversao','func_ppaversao.php?funcao_js=parent.js_mostrappaversao1|o119_sequencial|o01_descricao','Pesquisa',true,'0','1');
  }else{
     if(document.form1.si53_codigoppa.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_riscofiscal','db_iframe_ppaversao','func_ppaversao.php?pesquisa_chave='+document.form1.si53_codigoppa.value+'&funcao_js=parent.js_mostrappaversao','Pesquisa',false,'0','1');
     }else{
       document.form1.o119_versao.value = '';
     }
  }
}
function js_mostrappaversao(chave,erro){
  document.form1.o119_versao.value = chave;
  if(erro==true){
    document.form1.si53_codigoppa.focus();
    document.form1.si53_codigoppa.value = '';
  }
}
function js_mostrappaversao1(chave1,chave2){
  document.form1.si53_codigoppa.value = chave1;
  document.form1.o119_versao.value = chave2;
  db_iframe_ppaversao.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_riscofiscal','db_iframe_riscofiscal','func_riscofiscal.php?funcao_js=parent.js_preenchepesquisa|si53_sequencial','Pesquisa',true,'0','1');
}
function js_preenchepesquisa(chave){
  db_iframe_riscofiscal.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_submit() {

    if ( document.form1.si53_codriscofiscal.value == 10 && document.form1.si53_dscriscofiscal.value == '' ) {

        alert('Informe a Descrição do Risco');
        event.preventDefault();

    }
}
</script>
