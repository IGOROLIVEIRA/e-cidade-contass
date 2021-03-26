<?
//MODULO: pessoal
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clrhlotavinc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o55_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trh25_codlotavinc?>">
       <?
       db_ancora(@$Lrh25_codlotavinc,"",3);
       ?>
    </td>
    <td>
<?
db_input('rh25_codlotavinc',8,$Irh25_codlotavinc,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh25_codigo?>">
       <?
       db_ancora(@$Lrh25_codigo,"",3);
       ?>
    </td>
    <td>
<?
db_input('rh25_codigo',8,$Irh25_codigo,true,'text',3)
?>
<?
db_input('rh25_descr',50,$Irh25_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh25_recurso?>">
       <?
       if(!isset($rh25_recurso)){
         $rh25_recurso = 1;
       }

       $result_recurso = $clorctiporec->sql_record($clorctiporec->sql_query_file($rh25_recurso,"o15_descr"));
       if($clorctiporec->numrows >0){
	 db_fieldsmemory($result_recurso,0);
       }
       db_ancora(@$Lrh25_recurso,"js_pesquisarh25_recurso(true)",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('rh25_recurso',8,$Irh25_recurso,true,'text',$db_opcao,"onchange='js_pesquisarh25_recurso(false)'")
?>
<?
db_input('o15_descr',50,$Irh15_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh25_projativ?>">
       <?
       db_ancora(@$Lrh25_projativ,"js_pesquisarh25_projativ(true)",$db_opcao);
       ?>
    </td>
    <td>
<?
$rh25_anousu = db_getsession("DB_anousu");
if(isset($rh25_projativ) && trim($rh25_projativ)!="" && isset($rh25_anousu) && trim($rh25_anousu)!=""){
  $result_projativ = $clorcprojativ->sql_record($clorcprojativ->sql_query_file($rh25_anousu,$rh25_projativ,"o55_descr"));
  if($clorcprojativ->numrows>0){
    db_fieldsmemory($result_projativ,0);
  }
}
db_input('rh25_projativ',8,$Irh25_projativ,true,'text',$db_opcao,"onchange='js_pesquisarh25_projativ(false)'");
db_input('rh25_anousu',4,$Irh25_anousu,true,'text',3);
db_input('o55_descr',44,$Io55_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh25_vinculo?>">
       <?
       db_ancora(@$Lrh25_vinculo,"",3);
       ?>
    </td>
    <td>
<?
$arr_vinculo =  Array();
$arr_vinculo["A"] = "Ativo";
$arr_vinculo["I"] = "Inativo";
$arr_vinculo["P"] = "Pensionista";
db_select("rh25_vinculo",$arr_vinculo,true,$db_opcao);



db_input('opcao',5,0,true,'hidden',3);
db_input('chave',5,0,true,'hidden',3);
db_input('chave1',5,0,true,'hidden',3);
db_input('chave2',5,0,true,'hidden',3);
db_input('chave3',5,0,true,'hidden',3);
db_input('chave4',5,0,true,'hidden',3);
db_input('chave5',5,0,true,'hidden',3);
db_input('opcaoiframe',5,0,true,'text',3);
db_input('defaultifra',5,0,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>>
      <?
      if($db_opcao!=1){
	echo '<input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" >&nbsp;';
      }
      $result_exist = $clrhlotavinc->sql_record($clrhlotavinc->sql_query_file(null,"rh25_codlotavinc","","rh25_codigo=$rh25_codigo"));
      if($clrhlotavinc->numrows>0 && isset($opcao) && $opcao!="excluir"){
	echo '<input name="cadele" type="button" id="cadele" value="Elementos secundários" onclick="js_cadele();" >';
      }
      ?>
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">
    <?
         $where = " rh25_codigo=$rh25_codigo ";
	 if(isset($rh25_codlotavinc) && trim($rh25_codlotavinc)!=""){
	   $where = " and rh25_codlotavinc <> $rh25_codlotavinc ";
	 }
	 $chavepri= array("rh25_codigo"=>@$rh25_codigo,"rh25_codlotavinc"=>@$rh25_codlotavinc);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql = $clrhlotavinc->sql_query(null,"case when rh25_vinculo = 'I' then 'Inativo' else (case when rh25_vinculo = 'A' then 'Ativo' else 'Pensionista' end) end as rh25_vinculo, o55_descr,rh25_anousu,rh25_codigo,rh25_projativ,rh25_codlotavinc,o15_descr","rh25_codigo,rh25_codlotavinc",$where);
	 $cliframe_alterar_excluir->campos  = "rh25_codlotavinc,rh25_projativ,rh25_anousu,o55_descr,o15_descr,rh25_vinculo";
	 $cliframe_alterar_excluir->legenda = "ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height = "160";
	 $cliframe_alterar_excluir->iframe_width  = "700";
	 $cliframe_alterar_excluir->opcoes  = $opcoesae;
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_submitaiframe(projativ,anousu){
  db_iframe_cadele.hide();
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_cadele','pes1_rhlotavincele001.php?chavepesquisa='+projativ+'&chavepesquisa2='+anousu,'Pesquisa',true,'0','1','775','390');
}
function js_cadele(){
  document.form1.opcaoiframe.value = "";
  document.form1.defaultifra.value = "";
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_cadele','pes1_rhlotavincele001.php?lotacao='+document.form1.rh25_codigo.value+'&lotavinc='+document.form1.rh25_codlotavinc.value,'Pesquisa',true,'0','1','775','390');
  //+'&registro='+document.form1.rh25_codlotavinc.value
}
function js_cancelar(){
  document.location.href = "pes1_rhlotavinc001.php?chavepesquisa="+document.form1.rh25_codigo.value;
  /*
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","incluirnovo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
  */
}
function js_pesquisarh25_recurso(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orctiporec','func_orctiporec.php?funcao_js=CurrentWindow.corpo.iframe_rhlotavinc.js_mostraorctiporec|o15_codigo|o15_descr','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.rh25_recurso.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orctiporec','func_orctiporec.php?pesquisa_chave='+document.form1.rh25_recurso.value+'&funcao_js=CurrentWindow.corpo.iframe_rhlotavinc.js_mostraorctiporec1','Pesquisa',false,'0','1','775','390');
     }else{
       document.form1.rh25_recurso.value = '';
     }
  }
}
function js_mostraorctiporec(chave,chave1){
  document.form1.rh25_recurso.value = chave;
  document.form1.o15_descr.value = chave1;
  db_iframe_orctiporec.hide();
}
function js_mostraorctiporec1(chave,erro){
  document.form1.o15_descr.value = chave;
  if(erro==true){
    document.form1.rh25_recurso.value = "";
    document.form1.rh25_recurso.focus();
  }
}

function js_pesquisarh25_projativ(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcprojativ','func_orcprojativ.php?funcao_js=CurrentWindow.corpo.iframe_rhlotavinc.js_mostraprojativ|o55_descr|o55_projativ&anousu=<?=(db_getsession("DB_anousu"))?>','Pesquisa',true,'0','1','775','390');
  }else{
    if(document.form1.rh25_projativ.value!=""){
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcprojativ','func_orcprojativ.php?pesquisa_chave='+document.form1.rh25_projativ.value+'&funcao_js=CurrentWindow.corpo.iframe_rhlotavinc.js_mostraprojativ1','Pesquisa',false,'0','1','775','390');
//      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcprojativ','func_orcprojativ.php?pesquisa_chave='+document.form1.rh25_projativ.value+'&funcao_js=CurrentWindow.corpo.iframe_rhlotavinc.js_mostraprojativ1&mostraanousu=true','Pesquisa',false,'0','1','775','390');
    }else{
      document.form1.o55_descr.value = "";
      document.form1.rh25_projativ.value = "";
      document.form1.rh25_projativ.focus();
    }
  }
}
function js_mostraprojativ(chave,chave1){
  document.form1.o55_descr.value = chave;
  document.form1.rh25_projativ.value = chave1;
  db_iframe_orcprojativ.hide();

 /*
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","incluirnovo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);


  document.form1.submit();
 */
}
function js_mostraprojativ1(chave,erro){
  document.form1.o55_descr.value = chave;
  if(erro==true){
    document.form1.rh25_projativ.value = "";
    document.form1.rh25_projativ.focus();
 /*
    var opcao = document.createElement("input");
    opcao.setAttribute("type","hidden");
    opcao.setAttribute("name","incluirnovo");
    opcao.setAttribute("value","true");
    document.form1.appendChild(opcao);


    document.form1.submit();
 */
  }
}

// funcões chamadas do iframe db_iframe_cadele
function js_mostraprojativ2(chave,chave1){
  document.form1.chave.value = chave;
  document.form1.chave1.value = chave1;
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_cadele','pes1_rhlotavincele001.php?lotacao='+document.form1.rh25_codigo.value+'&lotavinc='+document.form1.rh25_codlotavinc.value+'&chave='+chave+'&chave1='+chave1+'&chave2='+document.form1.chave2.value+'&chave3='+document.form1.chave3.value+'&chave4='+document.form1.chave4.value+'&chave5='+document.form1.chave5.value+'&opcao='+document.form1.opcaoiframe.value+"&default="+document.form1.defaultifra.value+'&npass=true','Pesquisa',true,'0','1','775','390');
  db_iframe_orcprojativ.hide();
}
function js_mostraorcelemento(chave2,chave3){
  document.form1.chave2.value = chave2;
  document.form1.chave3.value = chave3;
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_cadele','pes1_rhlotavincele001.php?lotacao='+document.form1.rh25_codigo.value+'&lotavinc='+document.form1.rh25_codlotavinc.value+'&chave='+document.form1.chave.value+'&chave1='+document.form1.chave1.value+'&chave2='+chave2+'&chave3='+chave3+'&chave4='+document.form1.chave4.value+'&chave5='+document.form1.chave5.value+'&opcao='+document.form1.opcaoiframe.value+"&default="+document.form1.defaultifra.value+'&npass=true','Pesquisa',true,'0','1','775','390');
  db_iframe_orcelemento.hide();
}
function js_mostraorcelemento1(chave4,chave5){
  document.form1.chave4.value = chave4;
  document.form1.chave5.value = chave5;
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_cadele','pes1_rhlotavincele001.php?lotacao='+document.form1.rh25_codigo.value+'&lotavinc='+document.form1.rh25_codlotavinc.value+'&chave='+document.form1.chave.value+'&chave1='+document.form1.chave1.value+'&chave2='+document.form1.chave2.value+'&chave3='+document.form1.chave3.value+'&chave4='+chave4+'&chave5='+chave5+'&opcao='+document.form1.opcaoiframe.value+"&default="+document.form1.defaultifra.value+'&npass=true','Pesquisa',true,'0','1','775','390');
  db_iframe_orcelemento.hide();
}
</script>
