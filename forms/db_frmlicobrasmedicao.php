<?
//MODULO: Obras
$cllicobrasmedicao->rotulo->label();
?>
<fieldset>
  <legend>Medição da Obra</legend>
  <form name="form1" method="post" action="">
    <table border="0" style="margin-left: -4%;">
      <tr style="display: none">
        <td nowrap title="<?=@$Tobr03_sequencial?>">
          <input name="oid" type="hidden" value="<?=@$oid?>">
          <?=@$Lobr03_sequencial?>
        </td>
        <td>
          <?
          db_input('obr03_sequencial',11,$Iobr03_sequencial,true,'text',3,"")
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>
            Número da Obra:
          </strong>
        </td>
        <td>
          <?
          db_input('obr01_numeroobra',11,$Iobr01_numeroobra,true,'text',3,"");
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <?
          db_ancora('Sequencial da Obra: ',"js_pesquisa_obra(true)",$db_opcao);
          ?>
        </td>
        <td>
          <?
          db_input('obr03_seqobra',11,$Iobr03_seqobra,true,'text',$db_opcao,"onchange='js_pesquisa_obra(false)'");
          ?>
        </td>
        <td>
          <strong>Processo Licitatório: </strong>
          <?
          db_input('l20_edital',6,$Il20_edital,true,'text',3,"");
          ?>
        </td>
        <td>
          <strong>Modalidade: </strong>
          <?
          db_input('tipocompra',25,'',true,'text',3,"");
          ?>
        </td>
        <td>
          <strong>Nº: </strong>
          <?
          db_input('l20_numero',6,$Il20_numero,true,'text',3,"");
          ?>
        </td>

      </tr>
    </table>
    <hr>
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tobr03_dtlancamento?>">
          <?=@$Lobr03_dtlancamento?>
        </td>
        <td colspan="">
          <?
          if(!isset($obr03_dtlancamento)) {
            $obr03_dtlancamento_dia=date('d',db_getsession("DB_datausu"));
            $obr03_dtlancamento_mes=date('m',db_getsession("DB_datausu"));
            $obr03_dtlancamento_ano=date('Y',db_getsession("DB_datausu"));
          }
          db_inputdata('obr03_dtlancamento',@$obr03_dtlancamento_dia,@$obr03_dtlancamento_mes,@$obr03_dtlancamento_ano,true,'text',$db_opcao);
          ?>
        </td>
        <td nowrap title="<?=@$Tobr03_nummedicao?>">
          <?=@$Lobr03_nummedicao?>
          <?
          db_input('obr03_nummedicao',11,$Iobr03_nummedicao,true,'text',$db_opcao,"")
          ?>
        </td>
        <td nowrap title="<?=@$Tobr03_tipomedicao?>">
          <?=@$Lobr03_tipomedicao?>
          <?
          $aValores = array(
            0 => 'Selecione',
            1 => '1 - Medição a preços iniciais',
            2 => '2 - Medição de reajuste',
            3 => '3 - Medição complementar',
            4 => '4 - Medição final',
            5 => '5 - Medição de termo aditivo',
            9 => '9 - Outro documento de medição.');
          db_select('obr03_tipomedicao', $aValores, true, $db_opcao," onchange='js_verificatipomedicao(this.value)'");
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtiniciomedicao?>">
          <?=@$Lobr03_dtiniciomedicao?>
        </td>
        <td>
          <?
          db_inputdata('obr03_dtiniciomedicao',@$obr03_dtiniciomedicao_dia,@$obr03_dtiniciomedicao_mes,@$obr03_dtiniciomedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_outrostiposmedicao?>">
          <?=@$Lobr03_outrostiposmedicao?>
        </td>
        <td colspan="3">
          <?
          db_textarea('obr03_outrostiposmedicao',0,0,$Iobr03_outrostiposmedicao,true,'text',$db_opcao,"","","",'500')
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_descmedicao?>">
          <?=@$Lobr03_descmedicao?>
        </td>
        <td colspan="3">
          <?
          db_textarea('obr03_descmedicao',0,0,$Iobr03_descmedicao,true,'text',$db_opcao,"","","",'500')
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtfimmedicao?>">
          <?=@$Lobr03_dtfimmedicao?>
        </td>
        <td colspan="">
          <?
          db_inputdata('obr03_dtfimmedicao',@$obr03_dtfimmedicao_dia,@$obr03_dtfimmedicao_mes,@$obr03_dtfimmedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>

        <td nowrap title="<?=@$Tobr03_dtentregamedicao?>" colspan="1">
          <?=@$Lobr03_dtentregamedicao?>

          <?
          db_inputdata('obr03_dtentregamedicao',@$obr03_dtentregamedicao_dia,@$obr03_dtentregamedicao_mes,@$obr03_dtentregamedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>
        <td nowrap title="<?=@$Tobr03_vlrmedicao?>">
          <?=@$Lobr03_vlrmedicao?>
          <?
          db_input('obr03_vlrmedicao',11,$Iobr03_vlrmedicao,true,'text',$db_opcao,"");
          ?>
        </td>
      </tr>
    </table>
    <div id="incluirmedicao">
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" >
      <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
      <input name="Nova Medição" type="button" id="Nova Medição" value="Nova Medição" onclick="js_novamedicao();" >
    </div>
  </form>
  <fieldset id="anexosdaobra" style="display: none">
    <legend>Fotos da Obra</legend>
    <form name="form2" id='form2' method="post" action="" enctype="multipart/form-data">
      <table>
        <tr>
          <td>
            <strong>Foto: </strong>
          </td>
          <td>
            <?php
            db_input("uploadfile",30,0,true,"file",1);
            db_input("namefile",30,0,true,"hidden",1);
            ?>
          </td>
          <td>
            <strong>Legenda:</strong>
          </td>
          <td>
            <?
            db_input('obr04_legenda',250,$Iobr04_legenda,true,'text',$db_opcao,"");
            ?>
          </td>
        </tr>
      </table>
      <input type='button' id='btnAnexar' Value='Anexar' />
      <div style="width: 600px;">
        <fieldset>
          <legend><b>Fotos em Anexo</b></legend>
          <div id='ctnDbGridDocumentos'>
          </div>
        </fieldset>
      </div>
    </form>
    <div id='anexo' style='display:none'></div>
  </fieldset>
</fieldset>
<script>

  oGridDocumento     = new DBGrid('gridDocumento');
  oGridDocumento.nameInstance = "oGridDocumento";
  oGridDocumento.setHeight(200);
  oGridDocumento.setCellAlign(new Array("center","center","center"));
  //oGridDocumento.setCellWidth("20%", "20%", "20%", "20%","20%");
  oGridDocumento.setHeader(new Array("Codigo","Legenda", "Ação"));
  oGridDocumento.show($('ctnDbGridDocumentos'));

  function startLoading() {
    js_divCarregando('Aguarde... Carregando Documento','msgbox');
  }

  function js_novamedicao() {
    document.location.href = 'obr1_licobrasmedicao001.php'
  }

  function endLoading() {
    js_removeObj('msgbox');
  }

  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_licobrasmedicao','func_licobrasmedicao.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_licobrasmedicao.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }

  function js_verificatipomedicao(value) {
    if(value == '2' || value == '9'){
      document.getElementById('anexosdaobra').style.display = 'none'
    }else{
      document.getElementById('anexosdaobra').style.display = ''
    }

    if(value == '9'){
      document.getElementById('obr03_outrostiposmedicao').style.backgroundColor = '#ffffff';
    }else{
      document.getElementById('obr03_outrostiposmedicao').style.backgroundColor = '#E6E4F1';
    }
  }

  /**
   * funcao para retornar obras
   */
  function js_pesquisa_obra(mostra){
    if(mostra==true){

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_licobrasituacao',
        'func_licobras.php?funcao_js=parent.js_preencheObra|obr01_sequencial|l20_edital|l20_numero|l03_descr|obr01_numeroobra',
        'Pesquisa Obras',true);
    }else{

      if(document.form1.obr03_seqobra.value != ''){

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_licobrasituacao',
          'func_licobras.php?pesquisa_chave='+
          document.form1.obr03_seqobra.value+'&funcao_js=parent.js_preencheObra2',
          'Pesquisa',false);
      }else{
        document.form1.obr03_seqobra.value = '';
      }
    }
  }

  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheObra(codigo,edital,numero,descrcompra,numeroobra)
  {
    document.form1.obr03_seqobra.value = codigo;
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_edital.value = edital;
    document.form1.l20_numero.value = numero;
    document.form1.obr01_numeroobra.value = numeroobra;
    db_iframe_licobrasituacao.hide();
  }

  function js_preencheObra2(edital,descrcompra,numero,numeroobra,erro) {
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_numero.value = numero;
    document.form1.l20_edital.value = edital;
    document.form1.obr01_numeroobra.value = numeroobra;

    if(erro==true){
      document.form1.obr03_seqobra.focus();
      alert('Nenhuma obra encontrada.');
      document.form1.tipocompra.value = "";
      document.form1.obr01_numeroobra.value = "";
      document.form1.l20_numero.value = "";
      document.form1.l20_edital.value = "";
    }
  }

  js_carregar();

  /***
   * ROTINA PARA SALVAR ANEXO
   */

  js_getAnexo();

  function js_salvarAnexo() {
    var medicao = $F('obr03_sequencial');

    if (medicao == '') {
      alert('Escolha uma medição!');
      return false;
    }
    var iFrame = document.createElement("iframe");
    iFrame.src = 'func_uploadfilemedicao.php?clone=form2&medicao='+$F('obr03_sequencial')+'&descricao='+$F('obr04_legenda');
    iFrame.id  = 'uploadIframe';
    $('anexo').appendChild(iFrame);
  }

  $('btnAnexar').observe("click",js_alterarAnexo);
  $('uploadfile').observe("change",js_salvarAnexo);

  function js_getAnexo() {

    var oParam        = new Object();
    oParam.exec       = 'getAnexos';
    oParam.codmedicao = $F('obr03_sequencial');
    js_divCarregando('Aguarde... Carregando Foto','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : js_retornoGetAnexo
      });
  }

  function js_retornoGetAnexo(oAjax) {
    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");
    oGridDocumento.clearAll(true);

    if (oRetorno.dados.length == 0) {
      return false;
    }
    oRetorno.dados.each(function (oDocumento, iSeq) {
      var aLinha = new Array();
      aLinha[0]  = oDocumento.iCodigo;
      aLinha[1]  = decodeURIComponent(oDocumento.sLegenda.replace(/\+/g,  " "));
      aLinha[2]  = '<input type="button" value="E" onclick="js_excluirAnexo('+oDocumento.iCodigo+')"><input type="button" value="Download" onclick="js_DownloadAnexo('+oDocumento.iCodigo+')">';
      oGridDocumento.addRow(aLinha);
    });
    oGridDocumento.renderRows();
  }

  function js_alterarAnexo() {

    if ($F('uploadfile') == '') {

      alert('Escolha uma Foto!');
      return false;
    }

    if ($F('obr04_legenda') == '') {

      alert('Informe uma Legenda para a foto!');
      return false;
    }

    var oParam        = new Object();
    oParam.exec       = 'alterarAnexo';
    oParam.codmedicao = $F('obr03_sequencial');
    oParam.legenda    = $F('obr04_legenda');
    js_divCarregando('Aguarde... Anexando Foto','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : js_retornoAlterarAnexo
      });
  }

  function js_retornoAlterarAnexo(oAjax) {
    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");

    if (oRetorno.status == 2) {
      alert(oRetorno.message);
    }else {
      alert("Anexo Salvo com Sucesso !");
      $('uploadfile').value     = '';
      $('namefile').value       = '';
      $("obr04_legenda").value  = "";
      js_getAnexo();
    }
  }

  function js_excluirAnexo(iCodigoDocumento) {

    if (!confirm('Confirma a Exclusão do Documento?')) {
      return false;
    }

    var oParam             = new Object();
    oParam.exec            = 'excluirAnexo';
    oParam.codmedicao      = $F('obr03_sequencial');
    oParam.codAnexo = iCodigoDocumento;
    js_divCarregando('Aguarde... excluindo foto','msgbox');
    var oAjax        = new Ajax.Request(
      'obr1_obras.RPC.php',
      { asynchronous:false,
        parameters: 'json='+Object.toJSON(oParam),
        method: 'post',
        onComplete : js_retornoexcuirAnexo
      });

  }

  function js_retornoexcuirAnexo(oAjax) {
    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");

    if (oRetorno.status == 2) {
      alert(oRetorno.message);
    }else {
      alert("Anexo excluido com Sucesso !");
      js_getAnexo();
    }
  }

  function js_DownloadAnexo(iCodigo) {
    if (!confirm('Deseja realizar o Download do Documento?')) {
      return false;
    }
    var oParam             = new Object();
    oParam.exec            = 'downloadDocumento';
    oParam.iCodigoDocumento = iCodigo;
    js_divCarregando('Aguarde... realizando Download do documento','msgbox');
    var oAjax        = new Ajax.Request(
      'obr1_obras.RPC.php',
      { asynchronous:false,
        parameters: 'json='+Object.toJSON(oParam),
        method: 'post',
        onComplete : js_downloadDocumento
      });
  }

  function js_downloadDocumento(oAjax) {

    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");
    if (oRetorno.status == 2) {
      alert("Não foi possivel carregar o documento:\n "+ oRetorno.message);
    }
    window.open("db_download.php?arquivo="+oRetorno.nomearquivo);
  }

  function js_carregar() {
    let value = document.getElementById('obr03_tipomedicao').value;
    let db_opcao = <?=$db_opcao?>;
    if(db_opcao != 1){
      js_pesquisa_obra(false);
    }

    if(value == '2' || value == '9'){
      document.getElementById('anexosdaobra').style.display = 'none'
    }else{
      document.getElementById('anexosdaobra').style.display = ''
    }

    if(value == '9'){
      document.getElementById('obr03_outrostiposmedicao').style.backgroundColor = '#ffffff';
    }else{
      document.getElementById('obr03_outrostiposmedicao').style.backgroundColor = '#E6E4F1';
    }

  }

</script>
