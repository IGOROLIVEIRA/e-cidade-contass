<?
//MODULO: pessoal
$cltetoremuneratorio->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style=" margin-left: 80px; margin-top: 10px;  ">
            <legend>Teto Remuneratório</legend>
<table border="0">
  <tr>
    <td nowrap title="Sequencial">
      <strong>Sequencial: </strong>
    </td>
    <td> 
<?
db_input('te01_sequencial',10,$Ite01_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Valor">
        <strong>Valor: </strong>
    </td>
    <td> 
<?
db_input('te01_valor',10,$Ite01_valor,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Tipo cadastro">
        <strong>Tipo cadastro: </strong>
    </td>
    <td> 
<?
//db_input('te01_tipocadastro',10,$Ite01_tipocadastro,true,'text',$db_opcao,"")
if($db_opcao == 1){
    $x = array('1'=>'Cadastro Inicial');
}
if($db_opcao == 2 || $db_opcao == 22){
    $x = array('2'=>'Alteração de Cadastro');
}

db_select("te01_tipocadastro",$x,true,$db_opcao)

?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Data inicial">
        <strong>Data inicial: </strong>
    </td>
    <td> 
<?
db_inputdata('te01_dtinicial',@$te01_dtinicial_dia,@$te01_dtinicial_mes,@$te01_dtinicial_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Data final">
        <strong>Data final: </strong>
    </td>
    <td> 
<?
db_inputdata('te01_dtfinal',@$te01_dtfinal_dia,@$te01_dtfinal_mes,@$te01_dtfinal_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <?
  if($db_opcao == 2 || $db_opcao == 22) {
      ?>
      <tr>
          <td nowrap title="Justificativa">
              <strong>Justificativa: </strong>
          </td>
          <td>
              <?
              db_input('te01_justificativa', 80, $Ite01_justificativa, true, 'text', $db_opcao, "")
              ?>
          </td>
      </tr>
      <?
  }
    ?>
  </table>
     </fieldset>
    </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_tetoremuneratorio','func_tetoremuneratorio.php?funcao_js=parent.js_preenchepesquisa|te01_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_tetoremuneratorio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
