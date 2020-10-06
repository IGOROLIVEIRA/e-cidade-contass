<?
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clhabilitacaoforn->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc60_dtlanc");
$clrotulo->label("l20_codigo");
$l206_licitacao = $l20_codigo;

if(isset($db_opcaoal)){
   $db_opcao=33;
   //$db_botao=false;
   $db_botao=true;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{  
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $l206_sequencial = "";
     $l206_fornecedor = "";
     //$l206_licitacao = "";
     $l206_representante = "";
     $l206_datahab_dia = "";
     $l206_numcertidaoinss = "";
     $l206_dataemissaoinss_dia = "";
     $l206_datavalidadeinss_dia = "";
     $l206_numcertidaofgts  = "";
     $l206_dataemissaofgts_dia  = "";
     $l206_datavalidadefgts_dia = "";
     $l206_numcertidaocndt  = "";
     $l206_dataemissaocndt_dia  = "";
     $l206_datavalidadecndt_dia = "";
   }
   /*$l206_datahab_dia = date('d' ,db_getsession("DB_datausu"));
   $l206_datahab_mes = date('m' ,db_getsession("DB_datausu"));
   $l206_datahab_ano = date('Y' ,db_getsession("DB_datausu"));*/
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl206_sequencial?>">
       <?//=@$Ll206_sequencial?>
    </td>
    <td> 
<?
db_input('l206_sequencial',10,$Il206_sequencial,true,'hidden',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_fornecedor?>">
       <?=@$Ll206_fornecedor ?>
    </td>
    <td> 
<?
   $sWhere     = "1!=1";
	 if (isset($pc20_codorc) && !empty($pc20_codorc)) {
    $sWhere = " pc21_codorc=".@$pc20_codorc;
	 }
   $result = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"pc21_numcgm,z01_nome","",$sWhere));
   
   db_selectrecord("l206_fornecedor",$result,true,$db_opcao,"","","","","js_verificaforn()");

//db_input('l206_fornecedor',10,$Il206_fornecedor,true,'text',$db_opcao," onchange='js_pesquisal206_fornecedor(false);'")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_licitacao?>">
       <?=@$Ll206_licitacao?>
    </td>
    <td> 
       <?
db_input('l206_licitacao',11,$Il206_licitacao,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_representante?>">
       <?=@$Ll206_representante?>
    </td>
    <td> 
<?
db_input('l206_representante',100,$Il206_representante,true,'text',$db_opcao,"","","#E6E4F1")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_datahab?>">
       <?=@$Ll206_datahab?>
    </td>
    <td> 
<?
db_inputdata('l206_datahab',@$l206_datahab_dia,@$l206_datahab_mes,@$l206_datahab_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_numcertidaoinss?>">
       <?=@$Ll206_numcertidaoinss?>
    </td>
    <td> 
<?
db_input('l206_numcertidaoinss',30,$Il206_numcertidaoinss,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_dataemissaoinss?>">
       <?=@$Ll206_dataemissaoinss?>
    </td>
    <td> 
<?
db_inputdata('l206_dataemissaoinss',@$l206_dataemissaoinss_dia,@$l206_dataemissaoinss_mes,@$l206_dataemissaoinss_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_datavalidadeinss?>">
       <?=@$Ll206_datavalidadeinss?>
    </td>
    <td> 
<?
db_inputdata('l206_datavalidadeinss',@$l206_datavalidadeinss_dia,@$l206_datavalidadeinss_mes,@$l206_datavalidadeinss_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_numcertidaofgts?>">
       <?=@$Ll206_numcertidaofgts?>
    </td>
    <td> 
<?
db_input('l206_numcertidaofgts',30,$Il206_numcertidaofgts,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_dataemissaofgts?>">
       <?=@$Ll206_dataemissaofgts?>
    </td>
    <td> 
<?
db_inputdata('l206_dataemissaofgts',@$l206_dataemissaofgts_dia,@$l206_dataemissaofgts_mes,@$l206_dataemissaofgts_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_datavalidadefgts?>">
       <?=@$Ll206_datavalidadefgts?>
    </td>
    <td> 
<?
db_inputdata('l206_datavalidadefgts',@$l206_datavalidadefgts_dia,@$l206_datavalidadefgts_mes,@$l206_datavalidadefgts_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_numcertidaocndt?>">
       <?=@$Ll206_numcertidaocndt?>
    </td>
    <td> 
<?
db_input('l206_numcertidaocndt',30,$Il206_numcertidaocndt,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_dataemissaocndt?>">
       <?=@$Ll206_dataemissaocndt?>
    </td>
    <td> 
<?
db_inputdata('l206_dataemissaocndt',@$l206_dataemissaocndt_dia,@$l206_dataemissaocndt_mes,@$l206_dataemissaocndt_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl206_datavalidadecndt?>">
       <?=@$Ll206_datavalidadecndt?>
    </td>
    <td> 
<?
db_inputdata('l206_datavalidadecndt',@$l206_datavalidadecndt_dia,@$l206_datavalidadecndt_mes,@$l206_datavalidadecndt_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >

<table>
  <tr>
    <td valign="top"  align="center">  
    <?
	 $chavepri= array("l206_sequencial"=>@$l206_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clhabilitacaoforn->sql_query(null,"l206_sequencial,z01_numcgm,z01_nome",null,"l206_licitacao=$l20_codigo");
	 $cliframe_alterar_excluir->campos  ="l206_sequencial,z01_numcgm,z01_nome";
	 $cliframe_alterar_excluir->legenda="Fornecedores Habilitados";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
    ?>
    </td>
   </tr>
 </table>
</form>
<script>
function js_cancelar(){
	  var opcao = document.createElement("input");
	  opcao.setAttribute("type","hidden");
	  opcao.setAttribute("name","novo");
	  opcao.setAttribute("value","true");
	  document.form1.appendChild(opcao);
	  document.form1.submit();
	}
function js_pesquisal206_fornecedor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_pcforne','func_pcforne.php?funcao_js=parent.js_mostrapcforne1|pc60_numcgm|pc60_dtlanc','Pesquisa',true);
  }else{
     if(document.form1.l206_fornecedor.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_pcforne','func_pcforne.php?pesquisa_chave='+document.form1.l206_fornecedor.value+'&funcao_js=parent.js_mostrapcforne','Pesquisa',false);
     }else{
       document.form1.pc60_dtlanc.value = ''; 
     }
  }
}
function js_mostrapcforne(chave,erro){
  document.form1.pc60_dtlanc.value = chave; 
  if(erro==true){ 
    document.form1.l206_fornecedor.focus(); 
    document.form1.l206_fornecedor.value = ''; 
  }
}
function js_mostrapcforne1(chave1,chave2){
  document.form1.l206_fornecedor.value = chave1;
  document.form1.pc60_dtlanc.value = chave2;
  db_iframe_pcforne.hide();
}
function js_pesquisal206_licitacao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_codigo','Pesquisa',true);
  }else{
     if(document.form1.l206_licitacao.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_liclicita.php?pesquisa_chave='+document.form1.l206_licitacao.value+'&funcao_js=parent.js_mostraliclicita','Pesquisa',false);
     }else{
       document.form1.l20_codigo.value = ''; 
     }
  }
}
function js_mostraliclicita(chave,erro){
  document.form1.l20_codigo.value = chave; 
  if(erro==true){ 
    document.form1.l206_licitacao.focus(); 
    document.form1.l206_licitacao.value = ''; 
  }
}
function js_mostraliclicita1(chave1,chave2){
  document.form1.l206_licitacao.value = chave1;
  document.form1.l20_codigo.value = chave2;
  db_iframe_liclicita.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_habilitacaoforn','func_habilitacaoforn.php?funcao_js=parent.js_preenchepesquisa|l206_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_habilitacaoforn.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_verificaforn() {
    let fornecedor = document.getElementById('l206_fornecedor').value;
    let licitacao  = document.getElementById('l206_licitacao').value;
    var oParam        = new Object();
    oParam.exec       = 'verificaforn';
    oParam.fornecedor = fornecedor;
    oParam.l20_codigo = licitacao;
    js_divCarregando('Aguarde... verificando fornecedor','msgbox');
    var oAjax         = new Ajax.Request(
        'lic1_habilitacaoforn.RPC.php',
        { parameters: 'json='+Object.toJSON(oParam),
            asynchronous:false,
            method: 'post',
            onComplete : js_retornoVerificaforn
        });
}

function js_retornoVerificaforn(oAjax) {
    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");
    if(oRetorno.liberarhabilitacao === false){
        //bloqueia os campos

        document.getElementById('l206_numcertidaoinss').disabled = true;
        document.getElementById('l206_numcertidaoinss').style.background = '#DEB887';

        document.getElementById('l206_dataemissaoinss').disabled = true;
        document.getElementById('l206_dataemissaoinss').style.background = '#DEB887';

        document.getElementById('l206_datavalidadeinss').disabled = true;
        document.getElementById('l206_datavalidadeinss').style.background = '#DEB887';

        document.getElementById('l206_numcertidaofgts').disabled = true;
        document.getElementById('l206_numcertidaofgts').style.background = '#DEB887';

        document.getElementById('l206_dataemissaofgts').disabled = true;
        document.getElementById('l206_dataemissaofgts').style.background = '#DEB887';

        document.getElementById('l206_datavalidadefgts').disabled = true;
        document.getElementById('l206_datavalidadefgts').style.background = '#DEB887';

        document.getElementById('l206_numcertidaocndt').disabled = true;
        document.getElementById('l206_numcertidaocndt').style.background = '#DEB887';

        document.getElementById('l206_dataemissaocndt').disabled = true;
        document.getElementById('l206_dataemissaocndt').style.background = '#DEB887';

        document.getElementById('l206_dataemissaocndt').disabled = true;
        document.getElementById('l206_datavalidadecndt').style.background = '#DEB887';
    }else{

        document.getElementById('l206_numcertidaoinss').disabled = false;
        document.getElementById('l206_numcertidaoinss').style.background = '#ffffff';

        document.getElementById('l206_dataemissaoinss').disabled = false;
        document.getElementById('l206_dataemissaoinss').style.background = '#ffffff';

        document.getElementById('l206_datavalidadeinss').disabled = false;
        document.getElementById('l206_datavalidadeinss').style.background = '#ffffff';

        document.getElementById('l206_numcertidaofgts').disabled = false;
        document.getElementById('l206_numcertidaofgts').style.background = '#ffffff';

        document.getElementById('l206_dataemissaofgts').disabled = false;
        document.getElementById('l206_dataemissaofgts').style.background = '#ffffff';

        document.getElementById('l206_datavalidadefgts').disabled = false;
        document.getElementById('l206_datavalidadefgts').style.background = '#ffffff';

        document.getElementById('l206_numcertidaocndt').disabled = false;
        document.getElementById('l206_numcertidaocndt').style.background = '#ffffff';

        document.getElementById('l206_dataemissaocndt').disabled = false;
        document.getElementById('l206_dataemissaocndt').style.background = '#ffffff';

        document.getElementById('l206_dataemissaocndt').disabled = false;
        document.getElementById('l206_datavalidadecndt').style.background = '#ffffff';
    }
}
js_verificaforn();
</script>
