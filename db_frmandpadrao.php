<?
//MODULO: protocolo
$clandpadrao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("p51_descr");
$clrotulo->label("descrdepto");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tp53_codigo?>">
       <?
       db_ancora(@$Lp53_codigo,"js_pesquisap53_codigo(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('p53_codigo',3,$Ip53_codigo,true,'text',$db_opcao," onchange='js_pesquisap53_codigo(false);'")
?>
       <?
db_input('p51_descr',60,$Ip51_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp53_coddepto?>">
       <?
       db_ancora(@$Lp53_coddepto,"js_pesquisap53_coddepto(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('p53_coddepto',5,$Ip53_coddepto,true,'text',$db_opcao," onchange='js_pesquisap53_coddepto(false);'")
?>
       <?
db_input('descrdepto',40,$Idescrdepto,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp53_dias?>">
       <?=@$Lp53_dias?>
    </td>
    <td> 
<?
db_input('p53_dias',2,$Ip53_dias,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tp53_ordem?>">
       <?=@$Lp53_ordem?>
    </td>
    <td> 
<?
db_input('p53_ordem',2,$Ip53_ordem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisap53_codigo(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_tipoproc.php?funcao_js=parent.js_mostratipoproc1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_tipoproc.php?pesquisa_chave='+document.form1.p53_codigo.value+'&funcao_js=parent.js_mostratipoproc';
  }
}
function js_mostratipoproc(chave,erro){
  document.form1.p51_descr.value = chave; 
  if(erro==true){ 
    document.form1.p53_codigo.focus(); 
    document.form1.p53_codigo.value = ''; 
  }
}
function js_mostratipoproc1(chave1,chave2){
  document.form1.p53_codigo.value = chave1;
  document.form1.p51_descr.value = chave2;
  db_iframe.hide();
}
function js_pesquisap53_coddepto(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_db_depart.php?funcao_js=parent.js_mostradb_depart1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_db_depart.php?pesquisa_chave='+document.form1.p53_coddepto.value+'&funcao_js=parent.js_mostradb_depart';
  }
}
function js_mostradb_depart(chave,erro){
  document.form1.descrdepto.value = chave; 
  if(erro==true){ 
    document.form1.p53_coddepto.focus(); 
    document.form1.p53_coddepto.value = ''; 
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.p53_coddepto.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe.hide();
}
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_andpadrao.php?funcao_js=parent.js_preenchepesquisa|0|1';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave,chave1){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave+"&chavepesquisa1="+chave1;
}
</script>
<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
