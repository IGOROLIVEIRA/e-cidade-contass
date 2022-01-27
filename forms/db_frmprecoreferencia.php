<?php
///MODULO: sicom
  $clprecoreferencia->rotulo->label();
  $clrotulo = new rotulocampo;
  
  if($si01_processocompra!=""){
    $respCotacaocodigo = $si01_numcgmcotacao;
    $respOrcacodigo = $si01_numcgmorcamento;

        $sql = "Select z01_nome from cgm where z01_numcgm = ".$respCotacaocodigo;
        $nome = db_query($sql);
        $nome = db_utils::fieldsMemory($nome,0);
        $respCotacaonome = $nome->z01_nome;

        $sql1 = "Select z01_nome from cgm where z01_numcgm = ".$respOrcacodigo;
        $nome1 = db_query($sql1);
        $nome1 = db_utils::fieldsMemory($nome1,0);
        $respOrcanome = $nome1->z01_nome;
    
        //echo"<pre>";
    //var_dump($oItem2->z01_nome);
    //exit;
   
    //echo"<script>alert($procReferencia->si01_numcgmCotacao);</script>";
  }
?>
<form name="form1" method="post" action="">
  <center>
    <fieldset style="margin-left: 50%; margin-top: 10px;">
      <legend>Preço de Referência</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tsi01_sequencial ?>">
            <?= @$Lsi01_sequencial ?>
          </td>
          <td>
            <?php db_input('si01_sequencial', 10, $Isi01_sequencial, true, 'text', 3, ""); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_processocompra ?>">
            <?php db_ancora(@$Lsi01_processocompra, "js_pesquisasi01_processocompra(true);", $db_opcao); ?>
          </td>
          <td>
            <?php db_input('si01_processocompra', 10, $Isi01_processocompra, true, 'text', $db_opcao, " onchange='js_pesquisasi01_processocompra(false);'"); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_datacotacao ?>">
            <?= @$Lsi01_datacotacao ?>
          </td>
          <td>
            <?php db_inputdata('si01_datacotacao', @$si01_datacotacao_dia, @$si01_datacotacao_mes, @$si01_datacotacao_ano, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_tipoprecoreferencia ?>">
            <?= @$Lsi01_tipoprecoreferencia ?>
          </td>
          <td>
            <?php 
              $x = array('1' => 'Preço Médio', '2' => 'Maior Preço', '3' => 'Menor Preço');
              db_select('si01_tipoprecoreferencia', $x, true, $db_opcao, "");
            ?>
          </td>
          
        </tr>
        <tr>
        <td nowrap title="<?= @$Tsi01_tipoprecoreferencia ?>">
            <strong>Cotação por item:</strong>
          </td>
        <td>
            <?php 
              $y = array('0' => 'Selecione','1' => 'No mínimo uma cotação', '2' => 'No mínimo duas cotação', '3' => 'No mínimo três cotação');
              db_select('si01_cotacaoitem', $y, true, $db_opcao, "");
            ?>
          </td>  
        </tr>
        <tr>
                                    <td nowrap title="respCotacaocodigo">
                                        <?
                                        db_ancora("Responsável pela Cotação: ","js_pesquisal31_numcgm(true,'respCotacaocodigo','respCotacaonome');",$db_opcao)

                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('respCotacaocodigo',10,$respCotacaocodigo,true,'text',$db_opcao,"onchange=js_pesquisal31_numcgm(false,'respCotacaocodigo','respCotacaonome');");
                                        db_input('respCotacaonome',45,$respCotacaonome,true,'text',3,"");
                                        ?>
                                    </td>
        </tr>
        <tr>
                                    <td nowrap title="respOrcacodigo">
                                        <?
                                        db_ancora("Resp. Recursos Orçamentários:","js_pesquisal31_numcgm(true,'respOrcacodigo','respOrcanome');",$db_opcao)

                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        db_input('respOrcacodigo',10,$respOrcacodigo,true,'text',$db_opcao,"onchange=js_pesquisal31_numcgm(false,'respOrcacodigo','respOrcanome');");
                                        db_input('respOrcanome',45,$respOrcanome,true,'text',3,"");
                                        ?>
                                    </td>
        </tr>
        <tr>
          <td><strong>Imprimir Justificativa: </strong></td>
          <td>
            <?php 
              $x = array('n' => 'Não', 's' => 'Sim');
              db_select('impjustificativa', $x, true, $db_opcao, "style = 'width: 91px;'");
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tsi01_justificativa ?>">
            <strong>Justificativa: </strong>
          </td>
          <td>
            <?php db_textarea('si01_justificativa', 7, 60, $Isi01_justificativa, true, 'text', $db_opcao, ""); ?>
          </td>
        </tr>
      </table>
    </fieldset>
  </center>
    <div style="margin-left: 41%; width: 100%">
        <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir e Imprimir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
        <?php if ($db_opcao == 2) : ?>
            <input name="imprimir" type="submit" id="imprimir" value="Imprimir PDF">
            <input name="imprimirword" type="submit" id="imprimirword" value="Imprimir Word">
            <input name="imprimircsv" type="submit" id="imprimircsv" value="Imprimir CSV">
        <?php endif; ?>
        <b>Qtd. de casas decimais:</b>
        <?php
        $aQuant_casas = array("2" => "2", "3" => "3", "4" => "4");
        db_select("quant_casas", $aQuant_casas, true, 4, "style='width:83px;'");
        ?>
    </div>
</form>
<script>
  function js_pesquisasi01_processocompra(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcprocnovo.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc', 'Pesquisa', true);
    } else {
      if (document.form1.si01_processocompra.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcprocnovo.php?pesquisa_chave=' + document.form1.si01_processocompra.value + '&funcao_js=parent.js_mostrapcproc', 'Pesquisa', false);
      }
    }
  }

  function js_mostrapcproc(chave, erro) {
    if (erro == true) {
      document.form1.si01_processocompra.focus();
      document.form1.si01_processocompra.value = '';
    }
  }

  function js_mostrapcproc1(chave1) {
    document.form1.si01_processocompra.value = chave1;
    db_iframe_pcproc.hide();
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_precoreferencia', 'func_precoreferencia.php?funcao_js=parent.js_preenchepesquisa|si01_sequencial', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_precoreferencia.hide(); <?
    if ($db_opcao != 1) {
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]).
      "?chavepesquisa='+chave";
    } ?>
  }

  var varNumCampo;
    var varNomeCampo;
    function js_pesquisal31_numcgm(mostra,numCampo,nomeCampo){
        varNumCampo = numCampo;
        varNomeCampo = nomeCampo;
        
        if(mostra==true){
            js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome&filtro=1','Pesquisa',true,'0','1');
        }else{
            numcgm = document.getElementById(numCampo).value;
            if(numcgm != ''){
                js_OpenJanelaIframe('','db_iframe_cgm','func_nome.php?pesquisa_chave='+numcgm+'&funcao_js=parent.js_mostracgm&filtro=1','Pesquisa',false);
            }else{
                document.getElementById(numCampo).value = ""; 
            }
        }
    }
    
    function js_mostracgm(erro,chave){
        document.getElementById(varNomeCampo).value = chave; 
        if(erro==true){ 
          document.getElementById(varNumCampo).value = "";
          document.getElementById(varNomeCampo).value = "";
          alert("Responsável não encontrado!");
        }
    }
    function js_mostracgm1(chave1,chave2){

    document.getElementById(varNumCampo).value = chave1;
    document.getElementById(varNomeCampo).value = chave2;
    db_iframe_cgm.hide(); 
    } 

</script>