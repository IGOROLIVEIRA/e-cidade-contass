<?
//MODULO: sicom
$cloperacoesdecreditolrf->rotulo->label();
?>
<form name="form1" method="post" action="">

  <table border="0" align="left" >
    <tr>
      <td>

        <table>

          <tr>
            <td nowrap >
             <b>Contratação de Operação que não atendeu limites Art. 33 LC 101/2000:</b>
           </td>
           <td>
            <?
            $x = array("0"=>"Selecione","1"=>"SIM","2"=>"NÃO");
            db_select('c219_contopcredito',$x,true,1,"onchange='js_habilitaDescricao()'");
            ?>
          </td>
        </tr>
        <? if(db_getsession('DB_anousu')>=2021){ ?>
        <tr id="descricaoInstituicao" style="display:none;">
            <td nowrap >
             <b>Descrição do número da instituição financeira da operação de crédito contratada:</b>
           </td>
           <td>
            <?
            db_input('c219_dscnumeroinst', 3,1,true,'text',1, "", "", "", "", 3);

            ?>
          </td>
        </tr>
       <? } ?> 
        <tr id="descricaoOcorrencia" style="display:none;">
          <td colspan="2" >
            <fieldset><legend><b>Descrição da Ocorrência:</b></legend>
              <?
              db_textarea('c219_dsccontopcredito',8,60,0,true,'text',$db_opcao,"","","",4000)
              ?>
            </fieldset>
          </td>
        </tr>
        <tr>
          <td nowrap >
           <b>Realização de Operações de crédito vedadas pelo Art. 37 LC 101/2000:</b>
         </td>
         <td>
          <?

          db_select('c219_realizopcredito',$x,true,1,"");
          ?>
        </td>
      </tr>

      <tr>
        <td nowrap >
         <b>Tipo de realização de operações de crédito vedada (Captação):</b>
       </td>
       <td>
        <?

        db_select('c219_tiporealizopcreditocapta',$x,true,1,"");
        ?>
      </td>
    </tr>
    <tr>
      <td nowrap>
       <b>Tipo de realização de operações de crédito vedada (Recebimento):</b>
     </td>
     <td>
      <?

      db_select('c219_tiporealizopcreditoreceb',$x,true,1,"");
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap>
      <b>Tipo de realização de operações de crédito vedada (Assução direta):</b>
    </td>
    <td>
      <?

      db_select('c219_tiporealizopcreditoassundir',$x,true,1,"");
      ?>
    </td>
  </tr>
  <tr>
    <td nowrap>
      <b>Tipo de realização de operações de crédito vedada (Assução de obrigação):</b>
    </td>
    <td>
      <?

      db_select('c219_tiporealizopcreditoassunobg',$x,true,1,"");
      ?>
    </td>
  </tr>


</table>
<center>
  <br>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="button" id="db_opcao" value="<?=($db_opcao==1?"Próximo":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="js_incluirDados();" >

</center>
</td>
</tr>
</table>
</form>
<script>
  function js_habilitaDescricao(){
    var ano = "<?php echo db_getsession('DB_anousu'); ?>";
    if(document.form1.c219_contopcredito.value == 1){
      document.getElementById("descricaoOcorrencia").style.display = "";
      if(ano>=2021){
        document.getElementById("descricaoInstituicao").style.display = "";
      }  
    }else{
      document.getElementById("descricaoOcorrencia").style.display = "none";
      if(ano>=2021){
        document.getElementById("descricaoInstituicao").style.display = "none";
      }
    }
    }
  
  function js_incluirDados(){
    var ano = "<?php echo db_getsession('DB_anousu'); ?>";
    var opcao = "<?php echo $db_opcao; ?>";
   /*VALIDAÇÕES*/
   if(document.form1.c219_contopcredito.value == "0"){
    alert('O campo "Contratação de Operação que não atendeu limites Art. 33 LC 101/2000" não foi preenchido.');
    return false;
   }
   if(ano>=2021 & opcao!= 3){
      if(document.form1.c219_contopcredito.value == "1" & document.form1.c219_dscnumeroinst.value == ""){
        alert('O campo "Descrição do número da instituição financeira da operação de crédito contratada" não foi preenchido.');
        return false;
      }
      if(document.form1.c219_contopcredito.value == "1" & document.form1.c219_dscnumeroinst.value.length < 3){
        alert('O campo "Descrição do número da instituição financeira da operação de crédito contratada" deve conter 3 números.'); 
        return false;
      }
  }
   if(document.form1.c219_realizopcredito.value == "0"){
    alert('O campo "Realização de Operações de crédito vedadas pelo Art. 37 LC 101/2000" não foi preenchido.');
    return false;
   }
   if(document.form1.c219_tiporealizopcreditocapta.value == "0"){
    alert('O campo "Tipo de realização de operações de crédito vedada (Captação)" não foi preenchido.');
    return false;
   }
   if(document.form1.c219_tiporealizopcreditoreceb.value == "0"){
    alert('O campo "Tipo de realização de operações de crédito vedada (Recebimento)" não foi preenchido.');
    return false;
   }
   if(document.form1.c219_tiporealizopcreditoassundir.value == "0"){
    alert('O campo "Tipo de realização de operações de crédito vedada (Assução direta)" não foi preenchido.');
    return false;
   }
   if(document.form1.c219_tiporealizopcreditoassunobg.value == "0"){
    alert('O campo "Tipo de realização de operações de crédito vedada (Assução de obrigação)" não foi preenchido.');
    return false;
   }
   top.corpo.operacoesdecredito.c219_contopcredito = document.form1.c219_contopcredito.value;
  //  alert(document.form1.c219_contopcredito.value);
  //  if(document.form1.c219_contopcredito.value == 1){ 
  //   alert(document.form1.c219_contopcredito.value);
  //     // top.corpo.operacoesdecredito.c219_dscnumeroinst = "1";
  //     // top.corpo.operacoesdecredito.c219_dsccontopcredito = "2";
  //   }else{
  //     alert(document.form1.c219_contopcredito.value);
  //     // top.corpo.operacoesdecredito.c219_dscnumeroinst = document.form1.c219_dscnumeroinst.value;
  //     // top.corpo.operacoesdecredito.c219_dsccontopcredito = document.form1.c219_dsccontopcredito.value;
  //   }_
   top.corpo.operacoesdecredito.c219_dscnumeroinst = document.form1.c219_dscnumeroinst.value;
   top.corpo.operacoesdecredito.c219_dsccontopcredito = document.form1.c219_dsccontopcredito.value;
   top.corpo.operacoesdecredito.c219_realizopcredito = document.form1.c219_realizopcredito.value;
   top.corpo.operacoesdecredito.c219_tiporealizopcreditocapta = document.form1.c219_tiporealizopcreditocapta.value;
   top.corpo.operacoesdecredito.c219_tiporealizopcreditoreceb = document.form1.c219_tiporealizopcreditoreceb.value;
   top.corpo.operacoesdecredito.c219_tiporealizopcreditoassundir = document.form1.c219_tiporealizopcreditoassundir.value;
   top.corpo.operacoesdecredito.c219_tiporealizopcreditoassunobg = document.form1.c219_tiporealizopcreditoassunobg.value;

   parent.mo_camada('publicacaoeperiodicidaderreo');
 }
 function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|si170_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_dadoscomplementareslrf.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
