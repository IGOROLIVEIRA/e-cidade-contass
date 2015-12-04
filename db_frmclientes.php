<?
//MODULO: atendimento
$clclientes->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tat01_codcli?>">
       <?=@$Lat01_codcli?>
    </td>
    <td> 
<?
db_input('at01_codcli',4,$Iat01_codcli,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_nomecli?>">
       <?=@$Lat01_nomecli?>
    </td>
    <td> 
<?
db_input('at01_nomecli',40,$Iat01_nomecli,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_email?>">
       <?=@$Lat01_email?>
    </td>
    <td> 
<?
db_input('at01_email',40,$Iat01_email,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_site?>">
       <?=@$Lat01_site?>
    </td>
    <td> 
<?
db_input('at01_site',40,$Iat01_site,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_status?>">
       <?=@$Lat01_status?>
    </td>
    <td> 
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('at01_status',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_cidade?>">
       <?=@$Lat01_cidade?>
    </td>
    <td> 
<?
db_input('at01_cidade',40,$Iat01_cidade,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_ender?>">
       <?=@$Lat01_ender?>
    </td>
    <td> 
<?
db_input('at01_ender',40,$Iat01_ender,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tat01_cep?>">
       <?=@$Lat01_cep?>
    </td>
    <td> 
<?
db_input('at01_cep',10,$Iat01_cep,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_clientes.php?funcao_js=parent.js_preenchepesquisa|0';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
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
