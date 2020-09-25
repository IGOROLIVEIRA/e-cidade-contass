<?
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$clhomologacaoadjudica->rotulo->label();

$cliframe_seleciona = new cl_iframe_seleciona;
$clpcprocitem       = new cl_pcprocitem;
$clrotulo           = new rotulocampo;

$clrotulo->label("l20_codigo");
?>
<script>

  function js_submit() {

    if(document.getElementById('l202_licitacao').value != "") {
      var dados="";
      var itens = new Array();
      var iframe = document.getElementById('ativ');
      var campos = iframe.contentWindow.document.getElementsByTagName('input');
      for (i=0;i<campos.length;i++) {
        campo = campos[i];
        if (campo.type == 'checkbox'){
          if (campo.checked) {
            itens[i] = campo.value;
          }
        }
      }
      document.getElementById('l203_itens').value = itens;
      document.form1.submit();
    } else {
      alert("Selecione uma licitacao");
      return false;
    }
  }

  function js_processa(){
    if(document.getElementById('l202_licitacao').value != "") {
      document.form1.submit();
    }else{
      alert("Selecione uma licitacao");
      return false;
    }
  }

</script>
<form name="form1" method="post" action="">
  <center>
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tl202_sequencial?>">
          <?=@$Ll202_sequencial?>
        </td>
        <td>
          <?
          db_input('l202_sequencial',10,$Il202_sequencial,true,'text',3,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tl202_licitacao?>">
          <?
          db_ancora(@$Ll202_licitacao,"js_pesquisal202_licitacao(true);",$db_opcao);
          ?>
        </td>
        <td>
          <?
          db_input('l202_licitacao',10,$Il202_licitacao,true,'text',$db_opcao," onchange='js_pesquisal202_licitacao(false);'")
          ?>
          <?
          $pc50_descr = $pc50_descr ." ".$l20_numero;
          db_input('pc50_descr',40,$Ipc50_descr,true,'text',3,'')
          ?>
        </td>
      </tr>
      <? if(!empty($l202_licitacao)){ ?>
        <tr>
          <td nowrap title="<?=@$Tl202_datahomologacao?>">
            <?=@$Ll202_datahomologacao?>
          </td>
          <td>
            <?
            db_inputdata('l202_datahomologacao',@$l202_datahomologacao_dia,@$l202_datahomologacao_mes,@$l202_datahomologacao_ano,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>

        <?php
        $result = $clliclicita->sql_record($clliclicita->sql_query_file(null,'l20_usaregistropreco',null,'l20_codigo ='.$l202_licitacao));
        $l20_usaregistropreco = db_utils::fieldsMemory($result, 0)->l20_usaregistropreco;
        ?>
        <tr>
          <?php if($l20_usaregistropreco != 't') { ?>
            <td nowrap title="<?=@$Tl202_dataadjudicacao?>">
              <?=@$Ll202_dataadjudicacao?>
            </td>
            <td>
              <?
              db_inputdata('l202_dataadjudicacao',@$l202_dataadjudicacao_dia,@$l202_dataadjudicacao_mes,@$l202_dataadjudicacao_ano,true,'text',$db_opcao,"")
              ?>
            </td>
          <?php } ?>
          <td>
            <input name="l203_itens[]" type="hidden" id="l203_itens" value="">
            <input name="l20_usaregistropreco" type="hidden" id="l20_usaregistropreco" value="<?php echo $l20_usaregistropreco ?>">
          </td>
        </tr>
      <? } ?>
    </table>
  </center>
  <? if(!empty($l202_licitacao)){ ?>

    <? if($db_opcao == 1){ ?>
      <input id="db_opcao" type="submit" value="Homologar" onclick="js_submit()" name="incluir" tabindex="4">
    <? }else{ ?>
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" onclick="js_submit()" id="db_opcao" value="<?=($db_opcao==1?"Homologar":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <? } ?>
  <? }else{ ?>
    <input name="processar" type="button" id="processar" value="Processar" onclick="js_processa()" disabled>
  <? } ?>
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa(<?=$db_opcao == 1 ? false : true ?>);" >
  <? if($db_opcao == 1 and !empty($l202_licitacao)){ ?>
    <input name="novo" type="button" id="novo" value="Novo" onclick="location.href='lic1_homologacaoadjudica001.php'" >
  <? } ?>
  <center>
    <table>
      <?php
      /**
       * Na fase de homologação só podem ser listados itens que possuem fornecedores ganhadores.
       * @see OC 3714
       */
      $sWhere = " liclicitem.l21_codliclicita = {$l202_licitacao} and pc24_pontuacao = 1 ";
      if(!empty($l202_licitacao)){

        $result=$clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query(null,"*",null,"l202_licitacao=$l202_licitacao"));

        if ($clhomologacaoadjudica->numrows>0){

          $sql = $clhomologacaoadjudica->sql_query_itens(null,
            "distinct
                                                       pc81_codprocitem,
                                                       pc11_seq,
                                                       pc11_codigo,
                                                       pc11_quant,
                                                       pc11_vlrun,
                                                       m61_descr,
                                                       pc01_codmater,
                                                       pc01_descrmater,
                                                       pc11_resum",
            "pc11_seq",$sWhere
          );
          if($db_opcao == 1) {

            echo
            "<script>
                    document.getElementById('db_opcao').disabled       = true;
                    document.getElementById('l202_licitacao').style.backgroundColor = '#DEB887';
                    document.getElementById('l202_licitacao').readOnly = true;
                    </script>";

            $sql_disabled = $clhomologacaoadjudica->sql_query_itens(null,
              "distinct
                                                       pc81_codprocitem,
                                                       pc11_seq,
                                                       pc11_codigo,
                                                       pc11_quant,
                                                       pc11_vlrun,
                                                       m61_descr,
                                                       pc01_codmater,
                                                       pc01_descrmater,
                                                       pc11_resum",
              "pc11_seq",$sWhere
            );
          }
          if($db_opcao == 2) {
            $iItens = $clhomologacaoadjudica->itensHomologados($l202_licitacao);
            $sql_marca = $clhomologacaoadjudica->sql_query_marcados(null,
              "distinct pc81_codprocitem",
              null,
              "pc81_codprocitem in ({$iItens})
                                                                  and (    l21_codliclicita <> {$l202_licitacao}
                                                                        or l21_codliclicita = {$l202_licitacao} and l21_codigo is not null
                                                                        or ( e54_anulad is null and e55_sequen is not null)
                                                                      )");

          }

          if($db_opcao == 1 || $db_opcao == 3 || $db_opcao == 33){
            $sql_disabled = $clhomologacaoadjudica->sql_query_itens(null,
              "distinct
                                                       pc81_codprocitem,
                                                       pc11_seq,
                                                       pc11_codigo,
                                                       pc11_quant,
                                                       pc11_vlrun,
                                                       m61_descr,
                                                       pc01_codmater,
                                                       pc01_descrmater,
                                                       pc11_resum",
              "pc11_seq",$sWhere
            );
          }

        }else{

          if($db_opcao == 1) {

            echo
            "<script>
                      document.getElementById('l202_licitacao').style.backgroundColor = '#DEB887';
                      document.getElementById('l202_licitacao').readOnly = true;
                      </script>";
          }
          $sql = $clhomologacaoadjudica->sql_query_itens(null,
            "distinct
                                                         pc81_codprocitem,
                                                         pc11_seq,
                                                         pc11_codigo,
                                                         pc11_quant,
                                                         pc11_vlrun,
                                                         m61_descr,
                                                         pc01_codmater,
                                                         pc01_descrmater,
                                                         pc11_resum",
            "pc11_seq",$sWhere
          );


        }

      }else{
        $sql = $clhomologacaoadjudica->sql_query_itens(1000000000000,
          "distinct
                                                     pc81_codprocitem,
                                                     pc11_seq,
                                                     pc11_codigo,
                                                     pc11_quant,
                                                     pc11_vlrun,
                                                     m61_descr,
                                                     pc01_codmater,
                                                     pc01_descrmater,
                                                     pc11_resum",
          "pc11_seq"
        );
      }

      $cliframe_seleciona->sql=@$sql;
      $cliframe_seleciona->campos  = "pc81_codprocitem,pc11_seq,pc11_codigo,pc11_quant,pc11_vlrun,m61_descr,pc01_codmater,pc01_descrmater,pc11_resum";
      $cliframe_seleciona->legenda="Itens";
      if($db_opcao == 2){
        $cliframe_seleciona->sql_marca=@$sql_marca;
      }
      if($db_opcao == 1 || $db_opcao == 3 || $db_opcao == 33){
        $cliframe_seleciona->sql_disabled=@$sql_disabled;
      }
      $cliframe_seleciona->iframe_nome ="itens_teste";
      $cliframe_seleciona->chaves = "pc81_codprocitem";
      $cliframe_seleciona->iframe_seleciona(1);

      ?>
    </table>
  </center>
</form>
<script>

    if(<?= $db_opcao ?> == 2){
        iLicitacao = document.form1.l202_licitacao.value;
    }

    if(document.getElementById('processar')){
        document.getElementById('processar').disabled = true;
    }

    /* Validação para não inserir códigos de licitações do tipo Dispensa */
    let element = document.getElementById('l202_licitacao');
    element.addEventListener('keyup', (e) => {
        if(document.getElementById('processar')){
            document.getElementById('processar').disabled = !(iLicitacao == e.target.value && iLicitacao != '');
        }

        if(document.getElementById('db_opcao')){
            document.getElementById('db_opcao').disabled = !(iLicitacao == e.target.value && iLicitacao != '');
        }
    });
  <?php
  /**
   * ValidaFornecedor:
   * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
   * @see ocorrência 2278
   */
  ?>
    function js_pesquisal202_licitacao(mostra){
        let opcao = "<?= $db_opcao?>";

        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+(opcao == '1' ? '1' : '10')+
                '&funcao_js=parent.js_mostraliclicita1|l20_codigo|pc50_descr|l20_numero&validafornecedor=1','Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+(opcao == '1' ? '1' : '10')+
                '&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1','Pesquisa',false);
            }else{
                document.form1.l202_licitacao.value = '';
                document.form1.pc50_descr.value = '';
                if(document.getElementById('processar')){
                    document.getElementById('processar').disabled = true;
                }else{
                    document.getElementById('db_opcao').disabled = true;
                }
            }
        }
    }
    function js_mostraliclicita(chave,erro){

        document.form1.pc50_descr.value = chave;
        if(erro==true){
            iLicitacao = '';
            document.form1.l202_licitacao.focus();
            document.form1.l202_licitacao.value = '';
        }else{
            iLicitacao = document.form1.l202_licitacao.value;
            if(document.getElementById('processar')){
                document.getElementById('processar').disabled = false;
            }else{
                document.getElementById('db_opcao').disabled = false;
            }
        }
    }
  /**
   * Função alterada para receber o parametro da numeração da modalidade.
   * Acrescentado o parametro chave3 que recebe o l20_numero vindo da linha 263.
   * Solicitado por danilo@contass e deborah@contass
   */
    function js_mostraliclicita1(chave1,chave2,chave3){
        iLicitacao = chave1;

        document.form1.l202_licitacao.value = chave1;
        document.form1.pc50_descr.value = chave2+' '+chave3;
        if(document.getElementById('processar')){
            document.getElementById('processar').disabled = false;
        }else{
            document.getElementById('db_opcao').disabled = false;
        }
        db_iframe_liclicita.hide();
    }
  function js_pesquisa(homologacao=false){
        if(!homologacao){
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=1&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('top.corpo','db_iframe_homologacaoadjudica','func_homologacaoadjudica.php?validadispensa=true&situacao=10&funcao_js=parent.js_preenchepesquisa|l202_sequencial','Pesquisa',true);
        }
  }
  function js_preenchepesquisa(chave){
    db_iframe_homologacaoadjudica.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }
</script>
