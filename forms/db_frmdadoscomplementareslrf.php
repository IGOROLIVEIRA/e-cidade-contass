<?
//MODULO: contabilidade
$cldadoscomplementareslrf->rotulo->label();
?>
<form name="form1" method="post" action="">

  <table border="0" align="left">
    <tr>
      <td nowrap title="<?=@$Tc218_sequencial?>">

       <?=@$Lc218_sequencial?>
     </td>
     <td align="right">
      <?
      db_input('c218_sequencial',10,$Ic218_sequencial,true,'text',3,"")
      ?>
    </td>
  </tr>

  <tr >
    <td nowrap title="<?=@$Tc218_mesusu?>">
     <b>Mês de referência</b>
   </td>
   <td align="right">
    <?

    db_select('c218_mesusu',array('Selecione',
      1 => "Janeiro",
      2 => "Fevereiro",
      3 => "Março",
      4 => "Abril",
      5 => "Maio",
      6 => "Junho",
      7 => "Julho",
      8 => "Agosto",
      9 => "Setembro",
      10 => "Outubro",
      11 => "Novembro",
      12 => "Dezembro"),
    true,1,"onchange='js_getSaldo()'");

    ?>
  </td>
</tr>

<tr  <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_passivosreconhecidos?>">
   <b>Valores dos passivos reconhecidos:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_passivosreconhecidos',10,$Ic218_passivosreconhecidos,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlsaldoatualconcgarantiainterna?>">
   <b>Saldo atual das concessões com garantia interna:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlsaldoatualconcgarantiainterna',10,$Ic218_vlsaldoatualconcgarantiainterna,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlsaldoatualconcgarantia?>">
   <b>Saldo atual das concessões com garantia externa:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlsaldoatualconcgarantia',10,$Ic218_vlsaldoatualconcgarantia,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlsaldoatualcontragarantiainterna?>">
   <b>Saldo atual das contragarantias  interna recebidas:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlsaldoatualcontragarantiainterna',10,$Ic218_vlsaldoatualcontragarantiainterna,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlsaldoatualcontragarantiaexterna?>">
   <b>Saldo atual das contragarantias externas recebidas:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlsaldoatualcontragarantiaexterna',10,$Ic218_vlsaldoatualcontragarantiaexterna,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap >
   <b>O limite de concessão de Garantia foi ultrapassado:</b>
 </td>
 <td align="right">
  <?
  db_select('medidasCorretivas',array(2=>'Não',1=>'Sim'),true,$db_opcao,"onchange='js_medidasCorretivas();'");
  ?>
</td>
</tr>
<tr style="display:none;" id="medidasCorretivasTextarea">
  <td nowrap colspan="2" title="<?=@$Tc218_medidascorretivas?>">
    <b></b>
    <fieldset>

      <legend>Medidas corretivas adotadas:</legend>
      <?

      db_textarea('c218_medidascorretivas',8,70,0,true,'text',$db_opcao,"","","",4000)
      ?>
    </fieldset>
  </td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_recalieninvpermanente?>">
   <b>Receita de Alienação de Investimentos Permanentes:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_recalieninvpermanente',10,$Ic218_recalieninvpermanente,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vldotatualizadaincentcontrib?>">
   <b>Valor da dotação atualizada de Incentivo a Contribuinte:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vldotatualizadaincentcontrib',10,$Ic218_vldotatualizadaincentcontrib,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlempenhadoicentcontrib?>">
    <b>Valor empenhado de Incentivo a Contribuinte:</b>
  </td>
  <td align="right">
    <?
    db_input('c218_vlempenhadoicentcontrib',10,$Ic218_vlempenhadoicentcontrib,true,'text',$db_opcao,"")
    ?>
  </td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vldotatualizadaincentinstfinanc?>">
   <b>Valor da dotação atualizada de Incentivo concedido por Instituição Financeira:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vldotatualizadaincentinstfinanc',10,$Ic218_vldotatualizadaincentinstfinanc,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlempenhadoincentinstfinanc?>">
   <b>Valor empenhado de Incentivo concedido por Instituição Financeira:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlempenhadoincentinstfinanc',10,$Ic218_vlempenhadoincentinstfinanc,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlliqincentcontrib?>">
   <b>Valor Liquidado de Incentivo:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlliqincentcontrib',10,$Ic218_vlliqincentcontrib,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlliqincentinstfinanc?>">
   <b>Valor concedido por Instituição</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlliqincentinstfinanc',10,$Ic218_vlliqincentinstfinanc,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlirpnpincentcontrib?>">
   <b>Valor Inscrito em RP Não Processados:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlirpnpincentcontrib',10,$Ic218_vlirpnpincentcontrib,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlirpnpincentinstfinanc?>">
   <b>Valor Inscrito em RP Não Processados IF:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlirpnpincentinstfinanc',10,$Ic218_vlirpnpincentinstfinanc,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlrecursosnaoaplicados?>">
   <b>Recursos do FUNDEB não aplicados:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlrecursosnaoaplicados',10,$Ic218_vlrecursosnaoaplicados,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vlapropiacaodepositosjudiciais?>">
   <b>Saldo apurado da apropriação de depósitos judiciais:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vlapropiacaodepositosjudiciais',10,$Ic218_vlapropiacaodepositosjudiciais,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr <?php if(db_getsession("DB_instit") != 1): ?> style="display:none;" <?php endif;?>>
  <td nowrap title="<?=@$Tc218_vloutrosajustes?>">
   <b>Valor de outros ajustes não considerados:</b>
 </td>
 <td align="right">
  <?
  db_input('c218_vloutrosajustes',10,$Ic218_vloutrosajustes,true,'text',$db_opcao,"")
  ?>
</td>
</tr>
<tr id="metaArrecadada" style="display:none;">
  <td nowrap title="<?=@$Tc218_metarrecada?>">
   <b>A meta bimestral de arrecadação foi cumprida:</b>
 </td>
 <td align="right">
  <?
  db_select('c218_metarrecada',array('Selecione',1=>'Sim', 2=>'Não'),true,$db_opcao,"onchange='js_metaBimestral();'");
  ?>
</td>
</tr>
<tr id="medidasAdotadas" style="display:none;">
  <td nowrap colspan="2" title="<?=@$Tc218_dscmedidasadotadas?>">
    <b></b>
    <fieldset>

      <legend>Medidas Adotadas e a Adotar:</legend>
      <?

      db_textarea('c218_dscmedidasadotadas',8,70,0,true,'text',$db_opcao,"","","",4000)
      ?>
    </fieldset>
  </td>

</tr>

<tr>
  <td colspan="2">
    <center>
      <input name="db_opcao" type="button" id="db_opcao" value="<?=($db_opcao==1?"Próximo":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="js_incluirDados();">

      <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </center>
  </td>
</tr>
</table>

</form>
<script>
  document.getElementById("medidasCorretivas").style.width = "100%";
  document.getElementById("c218_mesusu").style.width = "100%";

  function js_medidasCorretivas(){
    if(document.form1.medidasCorretivas.value == '2'){
      document.getElementById("medidasCorretivasTextarea").style.display = 'none';
    }else{
      document.getElementById("medidasCorretivasTextarea").style.display = '';
    }
  }

  function js_incluirDados(){

   /*VALIDAÇÕES*/
   if(document.form1.c218_mesusu.value == "0"){
    alert('O campo "Mês de Referência" não foi preenchido.');
    return false;
  }
   // if(document.form1.c218_metarrecada.value == "0" && ((parseInt(document.form1.c218_mesusu.value)%2) == 0)){
   //  alert('O campo "A meta bimestral de arrecadação foi cumprida" não foi preenchido.');
   //  return false;
   // }
   if(document.form1.c218_metarrecada.value == "2"){
    if(document.form1.c218_dscmedidasadotadas.value == ""){
      alert('O campo "Medidas adotadas e a adotar" não foi preenchido.');
      return false;
    }
  }
  top.corpo.dadoscomplementares.c218_sequencial = document.form1.c218_sequencial.value;
  top.corpo.dadoscomplementares.c218_mesusu = document.form1.c218_mesusu.value;
  top.corpo.dadoscomplementares.c218_passivosreconhecidos = document.form1.c218_passivosreconhecidos.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantiainterna = document.form1.c218_vlsaldoatualconcgarantiainterna.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantia = document.form1.c218_vlsaldoatualconcgarantia.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiainterna = document.form1.c218_vlsaldoatualcontragarantiainterna.value;
  top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiaexterna = document.form1.c218_vlsaldoatualcontragarantiaexterna.value;
  top.corpo.dadoscomplementares.c218_medidascorretivas = document.form1.c218_medidascorretivas.value;
  top.corpo.dadoscomplementares.c218_recalieninvpermanente = document.form1.c218_recalieninvpermanente.value;
  top.corpo.dadoscomplementares.c218_vldotatualizadaincentcontrib = document.form1.c218_vldotatualizadaincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlempenhadoicentcontrib = document.form1.c218_vlempenhadoicentcontrib.value;
  top.corpo.dadoscomplementares.c218_vldotatualizadaincentinstfinanc = document.form1.c218_vldotatualizadaincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlempenhadoincentinstfinanc = document.form1.c218_vlempenhadoincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlliqincentcontrib = document.form1.c218_vlliqincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlliqincentinstfinanc = document.form1.c218_vlliqincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlirpnpincentcontrib = document.form1.c218_vlirpnpincentcontrib.value;
  top.corpo.dadoscomplementares.c218_vlirpnpincentinstfinanc = document.form1.c218_vlirpnpincentinstfinanc.value;
  top.corpo.dadoscomplementares.c218_vlrecursosnaoaplicados = document.form1.c218_vlrecursosnaoaplicados.value;
  top.corpo.dadoscomplementares.c218_vlapropiacaodepositosjudiciais = document.form1.c218_vlapropiacaodepositosjudiciais.value;
  top.corpo.dadoscomplementares.c218_vloutrosajustes = document.form1.c218_vloutrosajustes.value;
  top.corpo.dadoscomplementares.c218_metarrecada = document.form1.c218_metarrecada.value;
  top.corpo.dadoscomplementares.c218_dscmedidasadotadas = document.form1.c218_dscmedidasadotadas.value;


  <?php if(db_getsession('DB_instit') != 1): ?>
   parent.mo_camada('publicacaoeperiodicidadergf');
   <?php else: ?>
     if(top.corpo.dadoscomplementares.c218_mesusu == 12){
      parent.mo_camada('operacoesdecredito');
    }else{
      parent.mo_camada('publicacaoeperiodicidaderreo');
    }
  <?php endif; ?>

  return false;

}

function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_dadoscomplementareslrf','func_dadoscomplementareslrf.php?funcao_js=parent.js_preenchepesquisa|c218_sequencial','Pesquisa',true);
}

function js_preenchepesquisa(chave){
  db_iframe_dadoscomplementareslrf.hide();
  var oParametros = new Object();

  oParametros.exec = 'getDados';
  oParametros.c218_sequencial = chave;
  js_divCarregando('Carregando...', 'msgBox');

  var oAjaxLista = new Ajax.Request("sic1_dadoscomplementareslrf.RPC.php",
  {
    method: "post",
    parameters: 'json=' + Object.toJSON(oParametros),
    onComplete: (function(oAjax){
      oRetorno = eval("(" + oAjax.responseText + ")");
      oRetorno = oRetorno.dadoscomplementares;
      /* PREENCHE OS FORMULÁRIOS */
      document.form1.c218_sequencial.value = oRetorno.c218_sequencial;
      document.form1.c218_mesusu.value = oRetorno.c218_mesusu;
      document.form1.c218_mesusu.disabled = "true";
      document.form1.c218_mesusu.style.background = "#DEB887";
      document.form1.c218_passivosreconhecidos.value = oRetorno.c218_passivosreconhecidos;
      document.form1.c218_vlsaldoatualconcgarantiainterna.value = oRetorno.c218_vlsaldoatualconcgarantiainterna;
      document.form1.c218_vlsaldoatualconcgarantia.value = oRetorno.c218_vlsaldoatualconcgarantia;
      document.form1.c218_vlsaldoatualcontragarantiainterna.value = oRetorno.c218_vlsaldoatualcontragarantiainterna;
      document.form1.c218_vlsaldoatualcontragarantiaexterna.value = oRetorno.c218_vlsaldoatualcontragarantiaexterna;
      document.form1.c218_medidascorretivas.value = oRetorno.c218_medidascorretivas;
      document.form1.c218_recalieninvpermanente.value = oRetorno.c218_recalieninvpermanente;
      document.form1.c218_vldotatualizadaincentcontrib.value = oRetorno.c218_vldotatualizadaincentcontrib;
      document.form1.c218_vlempenhadoicentcontrib.value = oRetorno.c218_vlempenhadoicentcontrib;
      document.form1.c218_vldotatualizadaincentinstfinanc.value = oRetorno.c218_vldotatualizadaincentinstfinanc;
      document.form1.c218_vlempenhadoincentinstfinanc.value = oRetorno.c218_vlempenhadoincentinstfinanc;
      document.form1.c218_vlliqincentcontrib.value = oRetorno.c218_vlliqincentcontrib;
      document.form1.c218_vlliqincentinstfinanc.value = oRetorno.c218_vlliqincentinstfinanc;
      document.form1.c218_vlirpnpincentcontrib.value = oRetorno.c218_vlirpnpincentcontrib;
      document.form1.c218_vlirpnpincentinstfinanc.value = oRetorno.c218_vlirpnpincentinstfinanc;
      document.form1.c218_vlrecursosnaoaplicados.value = oRetorno.c218_vlrecursosnaoaplicados;
      document.form1.c218_vlapropiacaodepositosjudiciais.value = oRetorno.c218_vlapropiacaodepositosjudiciais;
      document.form1.c218_vloutrosajustes.value = oRetorno.c218_vloutrosajustes;
      document.form1.c218_metarrecada.value = oRetorno.c218_metarrecada;
      document.form1.c218_dscmedidasadotadas.value = oRetorno.c218_dscmedidasadotadas;

      top.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.value = oRetorno.c219_contopcredito;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_dsccontopcredito.value = oRetorno.c219_dsccontopcredito;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.value = oRetorno.c219_realizopcredito;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.value = oRetorno.c219_tiporealizopcreditocapta;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.value = oRetorno.c219_tiporealizopcreditoreceb;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.value = oRetorno.c219_tiporealizopcreditoassundir;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.value = oRetorno.c219_tiporealizopcreditoassunobg;

      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.value = oRetorno.c220_publiclrf;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_dtpublicacaorelatoriolrf.value = oRetorno.c220_dtpublicacaorelatoriolrf;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_localpublicacao.value = oRetorno.c220_localpublicacao;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.value = oRetorno.c220_tpbimestre;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_exerciciotpbimestre.value = oRetorno.c220_exerciciotpbimestre;

      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_publicrgf.value = oRetorno.c221_publicrgf;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_dtpublicacaorelatoriorgf.value = oRetorno.c221_dtpublicacaorelatoriorgf;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_localpublicacaorgf.value = oRetorno.c221_localpublicacaorgf;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_tpperiodo.value = oRetorno.c221_tpperiodo;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_exerciciotpperiodo.value = oRetorno.c221_exerciciotpperiodo;
      /* PREENCHE AS VARIAVEIS GLOBAIS */
      top.corpo.dadoscomplementares.c218_sequencial = oRetorno.c218_sequencial;
      top.corpo.dadoscomplementares.c218_mesusu = oRetorno.c218_mesusu;
      top.corpo.dadoscomplementares.c218_passivosreconhecidos = oRetorno.c218_passivosreconhecidos;
      top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantiainterna = oRetorno.c218_vlsaldoatualconcgarantiainterna;
      top.corpo.dadoscomplementares.c218_vlsaldoatualconcgarantia = oRetorno.c218_vlsaldoatualconcgarantia;
      top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiainterna = oRetorno.c218_vlsaldoatualcontragarantiainterna;
      top.corpo.dadoscomplementares.c218_vlsaldoatualcontragarantiaexterna = oRetorno.c218_vlsaldoatualcontragarantiaexterna;
      top.corpo.dadoscomplementares.c218_medidascorretivas = oRetorno.c218_medidascorretivas;
      top.corpo.dadoscomplementares.c218_recalieninvpermanente = oRetorno.c218_recalieninvpermanente;
      top.corpo.dadoscomplementares.c218_vldotatualizadaincentcontrib = oRetorno.c218_vldotatualizadaincentcontrib;
      top.corpo.dadoscomplementares.c218_vlempenhadoicentcontrib = oRetorno.c218_vlempenhadoicentcontrib;
      top.corpo.dadoscomplementares.c218_vldotatualizadaincentinstfinanc = oRetorno.c218_vldotatualizadaincentinstfinanc;
      top.corpo.dadoscomplementares.c218_vlempenhadoincentinstfinanc = oRetorno.c218_vlempenhadoincentinstfinanc;
      top.corpo.dadoscomplementares.c218_vlliqincentcontrib = oRetorno.c218_vlliqincentcontrib;
      top.corpo.dadoscomplementares.c218_vlliqincentinstfinanc = oRetorno.c218_vlliqincentinstfinanc;
      top.corpo.dadoscomplementares.c218_vlirpnpincentcontrib = oRetorno.c218_vlirpnpincentcontrib;
      top.corpo.dadoscomplementares.c218_vlirpnpincentinstfinanc = oRetorno.c218_vlirpnpincentinstfinanc;
      top.corpo.dadoscomplementares.c218_vlrecursosnaoaplicados = oRetorno.c218_vlrecursosnaoaplicados;
      top.corpo.dadoscomplementares.c218_vlapropiacaodepositosjudiciais = oRetorno.c218_vlapropiacaodepositosjudiciais;
      top.corpo.dadoscomplementares.c218_vloutrosajustes = oRetorno.c218_vloutrosajustes;
      top.corpo.dadoscomplementares.c218_metarrecada = oRetorno.c218_metarrecada;
      top.corpo.dadoscomplementares.c218_dscmedidasadotadas = oRetorno.c218_dscmedidasadotadas;

      top.corpo.operacoesdecredito.c219_contopcredito = oRetorno.c219_contopcredito;
      top.corpo.operacoesdecredito.c219_dsccontopcredito = oRetorno.c219_dsccontopcredito;
      top.corpo.operacoesdecredito.c219_realizopcredito = oRetorno.c219_realizopcredito;
      top.corpo.operacoesdecredito.c219_tiporealizopcreditocapta = oRetorno.c219_tiporealizopcreditocapta;
      top.corpo.operacoesdecredito.c219_tiporealizopcreditoreceb = oRetorno.c219_tiporealizopcreditoreceb;
      top.corpo.operacoesdecredito.c219_tiporealizopcreditoassundir = oRetorno.c219_tiporealizopcreditoassundir;
      top.corpo.operacoesdecredito.c219_tiporealizopcreditoassunobg = oRetorno.c219_tiporealizopcreditoassunobg;

      top.corpo.publicacaoeperiodicidaderreo.c220_publiclrf = oRetorno.c220_publiclrf;
      top.corpo.publicacaoeperiodicidaderreo.c220_dtpublicacaorelatoriolrf = oRetorno.c220_dtpublicacaorelatoriolrf;
      top.corpo.publicacaoeperiodicidaderreo.c220_localpublicacao = oRetorno.c220_localpublicacao;
      top.corpo.publicacaoeperiodicidaderreo.c220_tpbimestre = oRetorno.c220_tpbimestre;
      top.corpo.publicacaoeperiodicidaderreo.c220_exerciciotpbimestre = oRetorno.c220_exerciciotpbimestre;

      top.corpo.publicacaoeperiodicidadergf.c221_publicrgf = oRetorno.c221_publicrgf;
      top.corpo.publicacaoeperiodicidadergf.c221_dtpublicacaorelatoriorgf = oRetorno.c221_dtpublicacaorelatoriorgf;
      top.corpo.publicacaoeperiodicidadergf.c221_localpublicacaorgf = oRetorno.c221_localpublicacaorgf;
      top.corpo.publicacaoeperiodicidadergf.c221_tpperiodo = oRetorno.c221_tpperiodo;
      top.corpo.publicacaoeperiodicidadergf.c221_exerciciotpperiodo = oRetorno.c221_exerciciotpperiodo;

      <?php if($db_opcao == 3): ?>

      // DISABILITAÇÃO DOS CAMPOS SELECT QUANDO A OPCAO É EXCLUSAO
      top.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_contopcredito.style.background = "#DEB887";

      top.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_realizopcredito.style.background = "#DEB887";

      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditocapta.style.background = "#DEB887";

      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoreceb.style.background = "#DEB887";

      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassundir.style.background = "#DEB887";

      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.disabled = true;
      top.corpo.iframe_operacoesdecredito.document.form1.c219_tiporealizopcreditoassunobg.style.background = "#DEB887";

      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.disabled = true;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_publiclrf.style.background = "#DEB887";

      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.disabled = true;
      top.corpo.iframe_publicacaoeperiodicidaderreo.document.form1.c220_tpbimestre.style.background = "#DEB887";

      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_publicrgf.disabled = true;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_publicrgf.style.background = "#DEB887";

      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_tpperiodo.disabled = true;
      top.corpo.iframe_publicacaoeperiodicidadergf.document.form1.c221_tpperiodo.style.background = "#DEB887";

    <?php endif; ?>
    <?php if(db_getsession("DB_instit") == 1): ?>
      if(document.form1.c218_mesusu.value == 12){
        top.corpo.formaba[1].setAttribute("onclick", "mo_camada('operacoesdecredito')");
      }else{
        top.corpo.formaba[1].setAttribute("onclick", "");
      }
    <?php endif; ?>
    js_removeObj('msgBox');
 if(oRetorno.c218_metarrecada == "2"){
    document.getElementById("medidasAdotadas").style.display = "";

  }else{
    document.getElementById("medidasAdotadas").style.display = "none";
  }

  if(oRetorno.c218_medidascorretivas!=""){
    document.form1.medidasCorretivas.value = 1;
    document.getElementById("medidasCorretivasTextarea").style.display = "";
  }
  })
});
js_getSaldo();
}
function js_getSaldo(){
 <?php if(db_getsession("DB_instit") == 1): ?>
 if((document.form1.c218_mesusu.value % 2) == 0){
  document.getElementById("metaArrecadada").style.display = "";
  document.getElementById("c218_metarrecada").style.width = "100%";
}else{
  document.getElementById("metaArrecadada").style.display = "none";
}
<?php endif;?>
var oParametros = new Object();

oParametros.exec = 'getSaldo';
oParametros.mesReferencia = document.form1.c218_mesusu.value;
js_divCarregando('Carregando...', 'msgBox');

var oAjaxLista = new Ajax.Request("sic1_dadoscomplementareslrf.RPC.php",
{
  method: "post",
  parameters: 'json=' + Object.toJSON(oParametros),
  onComplete: (function(oAjax){
    oRetorno = eval("(" + oAjax.responseText + ")");
    document.form1.c218_passivosreconhecidos.value = oRetorno.si167_vlsaldoatual;
    js_removeObj('msgBox');
  })
});
<?php if(db_getsession("DB_instit") == 1): ?>
  if(document.form1.c218_mesusu.value == 12){
    top.corpo.formaba[1].setAttribute("onclick", "mo_camada('operacoesdecredito')");
  }else{
    top.corpo.formaba[1].setAttribute("onclick", "");
  }
<?php endif; ?>

}

function js_metaBimestral(){

  if(document.form1.c218_metarrecada.value == "2"){
    document.getElementById("medidasAdotadas").style.display = "";

  }else{
    document.getElementById("medidasAdotadas").style.display = "none";
  }
}
<?php if($db_opcao == 2 || $db_opcao == 3): ?>
 js_pesquisa();
<?php endif; ?>


</script>
