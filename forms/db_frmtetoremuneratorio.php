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
      <td nowrap title="Cod. Teto">
          <strong>Cod. Teto: </strong>
      </td>
      <td>
          <?
          db_input('te01_codteto',10,$Ite01_codteto,true,'text',$db_opcao,"")
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
//if($bDisable == true){
//    $x = array('1'=>'Cadastro Inicial');
//}else{
//    $x = array('2'=>'Alteração de Cadastro');
//}

$x = array('1'=>'Cadastro Inicial','2'=>'Alteração de Cadastro');

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
db_inputdata('te01_dtinicial',@$te01_dtinicial_dia,@$te01_dtinicial_mes,@$te01_dtinicial_ano,false,'text',$db_opcao,"onchange='validaIntervaloDatas();'","","","parent.validaIntervaloDatas();")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Data final">
        <strong>Data final: </strong>
    </td>
    <td>
<?
if($db_opcao == 1) {
    db_inputdata('te01_dtfinal', @$te01_dtfinal_dia, @$te01_dtfinal_mes, @$te01_dtfinal_ano, true, 'text', 3, "onchange='validaIntervaloDatas();'", "", "", "parent.validaIntervaloDatas();");
}else{
    db_inputdata('te01_dtfinal', @$te01_dtfinal_dia, @$te01_dtfinal_mes, @$te01_dtfinal_ano, true, 'text', $db_opcao, "onchange='validaIntervaloDatas();'", "", "", "parent.validaIntervaloDatas();");
}
?>
    </td>
  </tr>

    <tr>
        <td nowrap title="Número da lei do teto remuneratório">
            <strong>Número da lei do teto: </strong>
        </td>
        <td>
            <?
            db_input('te01_nrleiteto',10,$Ite01_nrleiteto,true,'text',$db_opcao,"")
            ?>
        </td>
    </tr>

    <tr>
        <td nowrap title="Data da publicação da lei do teto remuneratório">
            <strong>Data da publicação: </strong>
        </td>
        <td>
            <?
            db_inputdata('te01_dtpublicacaolei',@$te01_dtpublicacaolei_dia,@$te01_dtpublicacaolei_mes,@$te01_dtpublicacaolei_ano,true,'text',$db_opcao,"")
            ?>
        </td>
    </tr>
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

    <tr>
        <td>
            <input type="hidden" name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>"  value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" />
        </td>
    </tr>

  </table>
     </fieldset>
    </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>"  onclick="js_salvar();" >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tetoremuneratorio','func_tetoremuneratorio.php?funcao_js=parent.js_preenchepesquisa|te01_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_tetoremuneratorio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}


/**
 * Salva os dados do formulário
 */
function js_salvar() {

    if (!js_validaDados()) {
        return false;
    }
    document.form1.submit();

}


/**
 * Valida os dados do formulário
 */
function js_validaDados() {

    if ($F('te01_dtinicial') == '') {
        alert("Data inicial vazia");
        return false;
    }

    return true;

}

function validaIntervaloDatas() {

    if ($F('te01_dtfinal') != '' && $F('te01_dtinicial') != '') {

        if (js_comparadata($F('te01_dtfinal'), $F('te01_dtinicial'), " < ")) {

            alert("data inicial menor que a data final");
            $('te01_dtfinal').value = '';
            return false;
        }
    }

    return true;
}

</script>
