<?php
//MODULO: caixa
$clcontroleext->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c60_codcon");

// print_r($_GET);
// print_r($_POST);

?>
<form name="form1" method="post" action="">
<center>
<fieldset>
  <legend>Dados da conta</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tk167_sequencial?>">
      <b>Sequencial</b>
    </td>
    <td>
      <?php
        db_input('k167_sequencial',11,$Ik167_sequencial,true,'text',3,"");
        db_input('k167_anocad',4,$Ik167_anocad,true,'hidden',$db_opcao,"");
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk167_codcon?>">
       <? db_ancora('Conta',"js_pesquisak167_codcon(true);",$db_opcao); ?>
    </td>
    <td>
      <?php
        db_input('k167_codcon',8,$Ik167_codcon,true,'text',$db_opcao," onchange='js_pesquisak167_codcon(false);'");
        db_input('c60_descr',30,$Ic60_descr,true,'text',3,'');
        db_input('k167_anousu',4,$Ik167_anousu,true,'hidden',3,'');
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk167_prevanu?>">
      <b>Previsão de recebimento anual: R$</b>
    </td>
    <td>
<?
db_input('k167_prevanu',30,$Ik167_prevanu,true,'text',$db_opcao,'')
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tk167_dtcad?>">
      <b>Data de Cadastro</b>
    </td>
    <td>
<?
db_inputdata('k167_dtcad',@$k167_dtcad_dia,@$k167_dtcad_mes,@$k167_dtcad_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </fieldset>
  </center>

<?php if ($db_opcao == 1): ?>

  <input name="incluir" type="submit" id="db_opcao" value="Incluir" <?= ($db_botao == false ? "disabled" : "") ?>>

<?php elseif ($db_opcao == 2 || $db_opcao == 22): ?>

  <input name="excluir" type="submit" id="db_excluir" value="Excluir">
  <input name="alterar" type="submit" id="db_opcao" value="Alterar">

<?php endif; ?>

<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisak167_codcon(mostra){
  if(mostra==true){
    // c60_codsis = 7
    js_OpenJanelaIframe('','db_iframe_conplano','func_conplano.php?funcao_js=parent.js_mostraconplano1|c60_codcon|c60_descr|c60_anousu&controleext','Pesquisa',true);
  }else{
     if(document.form1.k167_codcon.value != ''){
        js_OpenJanelaIframe('','db_iframe_conplano','func_conplano.php?pesquisa_chave='+document.form1.k167_codcon.value+'&pegaAnousu&funcao_js=parent.js_mostraconplano&controleext','Pesquisa',false);
     }else{
       document.form1.c60_codcon.value = '';
     }
  }
}
function js_mostraconplano(chave1, chave2, erro) {
  document.form1.c60_descr.value = chave1;
  document.form1.k167_anousu.value = chave2;
  if(erro==true){
    document.form1.k167_codcon.focus();
    document.form1.k167_codcon.value = '';
  }
}
function js_mostraconplano1(chave1,chave2,chave3) {
  document.form1.k167_codcon.value = chave1;
  document.form1.c60_descr.value = chave2;
  if (chave3) {
    document.form1.k167_anousu.value = chave3;
  }
  db_iframe_conplano.hide();
}

function js_pesquisa() {
  js_OpenJanelaIframe('','db_iframe_controleext','func_controleext.php?funcao_js=parent.js_preenchepesquisa|k167_sequencial','Pesquisa',true);
}

function js_preenchepesquisa(chave) {

  db_iframe_controleext.hide();

  var controleextvlrtransf = parent.document.querySelector('iframe#controleextvlrtransf');

  controleextvlrtransf.src = 'cai1_controleextvlrtransf002.php?controleext=' + chave;
  location.href = 'cai1_controleext002.php?chavepesquisa=' + chave;

}

function js_excluircontroleext(e) {

  e.preventDefault();
  e.target.parentElement.action = 'cai1_controleext003.php?excluir';
  e.target.parentElement.submit();

}

if (document.getElementById('db_excluir')) {
  document.getElementById('db_excluir').addEventListener('click', js_excluircontroleext);
}

</script>
