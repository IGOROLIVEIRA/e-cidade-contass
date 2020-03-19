<?
//MODULO: Obras
$clrotulo = new rotulocampo;
$clrotulo->label("obr05_numregistro");
$clrotulo->label("obr05_numartourrt");
$cllicobras->rotulo->label();
?>
<form name="form1" method="post" action="">
  <center>
    <fieldset>
      <legend>Cadastro de Obras</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?=@$Tobr01_sequencial?>">
            <input name="oid" type="hidden" value="<?=@$oid?>">
            <strong>Cod. Sequencial:</strong>
          </td>
          <td>
            <?
            db_input('obr01_sequencial',10,$Iobr01_sequencial,true,'text',3,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr01_licitacao?>">
            <?
            db_ancora('Licita��o:',"js_pesquisa_liclicita(true)",$db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('obr01_licitacao',10,$Iobr01_licitacao,true,'text',$db_opcao,"onchange='js_pesquisa_liclicita(false)'")
            ?>
            <strong>Modalidade:</strong>
            <?
            db_input('tipocompra',20,'',true,'text',3,"")
            ?>
            <strong>N�:</strong>
            <?
            db_input('l20_numero',10,$Il20_numero,true,'text',3,"")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Objeto:</strong>
          </td>
          <td>
            <?
            db_textarea('l20_objeto',0,0,$l20_objeto,true,'text',3,"");
            ?>
          </td>
        </tr>
      </table>
      <table style="border-top: 1px solid #808080; margin-top: 5px;">
        <tr>
          <td>
            <strong>Data Lan�amento:</strong>
          </td>
          <td colspan="2">
            <?

            if(!isset($obr01_dtlancamento)) {
              $obr01_dtlancamento_dia=date('d',db_getsession("DB_datausu"));
              $obr01_dtlancamento_mes=date('m',db_getsession("DB_datausu"));
              $obr01_dtlancamento_ano=date('Y',db_getsession("DB_datausu"));
            }
            db_inputdata('obr01_dtlancamento',@$obr01_dtlancamento_dia,@$obr01_dtlancamento_mes,@$obr01_dtlancamento_ano,true,'text',$db_opcao);
            ?>
            <strong>N� Obra: </strong>
            <?
            db_input('obr01_numeroobra',16,$Iobr01_numeroobra,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr01_linkobra?>">
            <?=@$Lobr01_linkobra?>
          </td>
          <td colspan="2">
            <?
            db_textarea('obr01_linkobra',0,0,$Iobr01_linkobra,true,'text',$db_opcao,"","","",'200')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr01_dtinicioatividades?>">
            <?=@$Lobr01_dtinicioatividades?>
          </td>
          <td>
            <?
            db_inputdata('obr01_dtinicioatividades',@$obr01_dtinicioatividades_dia,@$obr01_dtinicioatividades_mes,@$obr01_dtinicioatividades_ano,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
      </table>
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" >
      <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
      <input name="Nova Obra" type="button" id="Nova Obra" value="Nova Obra" onclick="js_novaobra();" >
      <fieldset style="margin-top: 10px; margin-bottom: 10px;">
        <legend>Respons�veis</legend>
        <table style="margin-bottom: 10px;">
          <tr style="display: none">
            <td>
              <?
              db_input('obr05_sequencial',10,$Iobr05_sequencial,true,'text',3,"");
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <strong>Tipo Respons�vel: </strong>
            </td>
            <td>
              <?
              $aValores = array(0 => 'Selecione',
                1 => 'Fiscaliza��o',
                2 => 'Execu��o',
                3 => 'Projetista');
              db_select('obr05_tiporesponsavel', $aValores, true, $db_opcao," onchange=''");
              ?>
              <strong>Tipo Registro:</strong>
              <?
              $aValoresreg = array(0 => 'Selecione',
                1 => 'CREA',
                2 => 'CAU');
              db_select('obr05_tiporegistro', $aValoresreg, true, $db_opcao," onchange=''");
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <?
              db_ancora('Respons�vel:',"js_pesquisa_responsavel(true)",$db_opcao);
              ?>
            </td>
            <td>
              <?
              db_input('obr05_responsavel',10,$Iobr05_responsavel,true,'text',$db_opcao,"onchange='js_pesquisa_responsavel(false)'");
              db_input('z01_nome',40,'',true,'text',3,"")
              ?>
            </td>
          </tr>
          <tr>

            <td>

              <strong>N� Registro:</strong>
            </td>
            <td>
              <?
              db_input('obr05_numregistro',10,$Iobr05_numregistro,true,'text',$db_opcao,"");
              ?>

              <strong>Numero da ART ou RRT:</strong>
              <?
              db_input('obr05_numartourrt',10,$Iobr05_numartourrt,true,'text',$db_opcao,"onmouseover='myfuncionmsg()'");
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?=@$Tobr05_vinculoprofissional?>">
              <strong>Vinculo do Profissional com a administra��o P�blica:</strong>
            </td>
            <td>
              <?
              $aValoresvinculo = array(0 => 'Selecione',
                1 => 'Profissional da empresa executora',
                2 => 'Servidor(a) Efetivo(a)',
                3 => 'Contratado(a) da administra��o');
                db_select('obr05_vinculoprofissional', $aValoresvinculo, true, $db_opcao," onchange=''");
              ?>
            </td>
          </tr>
        </table>
        <input name="inserir" type="button" id="Inserir Respons�vel" value="Inserir Respons�vel" onclick="js_salvarResponsaveis()">
        <div id='ctnDbGridResponsaveis' style="margin-top: 10px;">
        </div>
      </fieldset>
    </fieldset>
  </center>
</form>
<script>

  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_licobraspesquisa','func_licobras.php?funcao_js=parent.js_preenchepesquisa|obr01_sequencial','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_licobraspesquisa.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }

  oGridResponsaveis     = new DBGrid('gridResponsavel');
  oGridResponsaveis.nameInstance = "oGridResponsaveis";
  oGridResponsaveis.setHeight(200);
  oGridResponsaveis.setCellAlign(new Array("center","left","center"));
  oGridResponsaveis.setHeader(new Array("Tipo de Respons�vel","Nome", "A��o"));
  oGridResponsaveis.show($('ctnDbGridResponsaveis'));


  js_carregarlic();
  js_CarregaResponsaveis();

  function js_novaobra() {
    document.location.href = 'obr1_licobras001.php'
  }

  /**
   * funcao para retornar licitacao
   */
  function js_pesquisa_liclicita(mostra){
    if(mostra==true){

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_licobras',
        'func_liclicita.php?situacao=10&obras=true&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto|l20_numero|pc50_descr',
        'Pesquisa Licita��es',true);
    }else{

      if(document.form1.obr01_licitacao.value != ''){

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_licobras',
          'func_liclicita.php?situacao=10&obras=true&pesquisa_chave='+
          document.form1.obr01_licitacao.value+'&funcao_js=parent.js_preencheLicitacao2',
          'Pesquisa',false);
      }else{
        document.form1.obr01_licitacao.value = '';
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheLicitacao(codigo,objeto,numero,descrcompra)
  {
    document.form1.obr01_licitacao.value = codigo;
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_numero.value = numero;
    document.form1.l20_objeto.value = objeto;
    db_iframe_licobras.hide();
  }

  function js_preencheLicitacao2(objeto,numero,descrcompra,erro) {
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_numero.value = numero;
    document.form1.l20_objeto.value = objeto;

    if(erro==true){
      alert("Nenhuma licita��o encontrada.");
      document.form1.z01_nome.focus();
      document.form1.tipocompra.value = "";
      document.form1.l20_numero.value = "";
      document.form1.l20_objeto.value = "";
    }
  }

  /**
   * funcao para retornar o responsavel
   */

  function js_pesquisa_responsavel(mostra){
    if(mostra==true){

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_cgm',
        'func_nome.php?funcao_js=parent.js_preencheResponsavel|z01_numcgm|z01_nome&filtro=1',
        'Pesquisa Respons�veis',true);
    }else{

      if(document.form1.obr05_responsavel.value != ''){

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_cgm',
          'func_nome.php?pesquisa_chave='+
          document.form1.obr05_responsavel.value+'&funcao_js=parent.js_preencheResponsavel2&filtro=1',
          'Pesquisa',false);
      }else{
        document.form1.obr05_responsavel.value = '';
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheResponsavel(codigo,nome)
  {
    document.form1.obr05_responsavel.value = codigo;
    document.form1.z01_nome.value = nome;
    db_iframe_cgm.hide();
  }

  function js_preencheResponsavel2(erro,nome) {
    document.form1.z01_nome.value = nome;

    if(erro==true){
      document.form1.z01_nome.focus();
    }
  }

  function js_carregarlic(){
    let db_opcao = <?=$db_opcao?>;
    if(db_opcao != 1){
      js_pesquisa_liclicita(false);
      js_pesquisa_responsavel(false);
    }
  }

  function js_salvarResponsaveis(){

    if($F('obr01_sequencial') == ""){
      alert("Para adicionar um respons�vel � preciso inserir uma obra, ou ter uma selecionada");
      return false;
    }

    if($F('obr05_tiporesponsavel') == 0){
      alert("Selecione o Tipo de Responsavel");
      return false;
    }

    if($F('obr05_tiporegistro') == 0){
      alert("Selecione o Tipo de Registro");
      return false;
    }

    if($F('obr05_vinculoprofissional') == 0){
      alert("Selecione o Vinculo do Profissional com a administra��o P�blica");
      return false;
    }

    var oParam                        = new Object();
    oParam.exec                       = 'SalvarResp';
    oParam.iCodigo                    = $F('obr05_sequencial');
    oParam.obr05_seqobra              = $F('obr01_sequencial');
    oParam.obr05_responsavel          = $F('obr05_responsavel');
    oParam.obr05_tiporesponsavel      = $F('obr05_tiporesponsavel');
    oParam.obr05_tiporegistro         = $F('obr05_tiporegistro');
    oParam.obr05_numregistro          = $F('obr05_numregistro');
    oParam.obr05_numartourrt          = $F('obr05_numartourrt');
    oParam.obr05_vinculoprofissional  = $F('obr05_vinculoprofissional');
    js_divCarregando('Aguarde... Salvando Respons�vel','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : js_oRetornoResponsaveis
      });
  }

  function js_oRetornoResponsaveis(oAjax) {

    var oRetorno = eval('('+oAjax.responseText+")");

    if(oRetorno.status == '1'){
      alert(oRetorno.message.urlDecode());
      document.form1.obr05_sequencial.value = '';
      document.form1.obr05_responsavel.value = '';
      document.form1.obr05_tiporesponsavel.value = 0;
      document.form1.z01_nome.value = '';
      document.form1.obr05_tiporegistro.value = 0;
      document.form1.obr05_numregistro.value = '';
      document.form1.obr05_numartourrt.value = '';
      document.form1.obr05_vinculoprofissional.value = 0;

    }else{
      alert(oRetorno.message.urlDecode());
    }
    js_CarregaResponsaveis();
    js_removeObj("msgbox");
  }

  function js_CarregaResponsaveis(){
    var oParam        = new Object();
    oParam.exec       = 'getResponsaveis';
    oParam.obr05_seqobra = $F('obr01_sequencial');
    js_divCarregando('Aguarde... Carregando Respons�vel','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : js_oResponsaveis
      });
  }

  function js_oResponsaveis(oAjax) {
    js_removeObj("msgbox");
    var oRetorno = eval('('+oAjax.responseText+")");
    oGridResponsaveis.clearAll(true);

    if (oRetorno.dados.length == 0) {
      return false;
    }
    oRetorno.dados.each(function (oResponsavel, iSeq) {
      var aLinha = new Array();
      aLinha[0]  = oResponsavel.iTiporesponsavel.urlDecode();
      aLinha[1]  = oResponsavel.sNome.urlDecode();
      aLinha[2]  = '<input type="button" value="A" onclick="js_alterar('+oResponsavel.iCodigo+')">    <input type="button" value="E" onclick="js_excluir('+oResponsavel.iCodigo+')">';
      oGridResponsaveis.addRow(aLinha);
    });
    oGridResponsaveis.renderRows();
  }

  function js_alterar(iCodigoResp) {
    var oParam        = new Object();
    oParam.exec       = 'getDadosResponsavel';
    oParam.iCodigo    = iCodigoResp;
    js_divCarregando('Aguarde... Carregando Respons�vel','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : carregarDadosResp
      });
  }

  function carregarDadosResp(oAjax) {
    var oRetorno = eval('('+oAjax.responseText+")");

    js_removeObj("msgbox");
    document.form1.obr05_sequencial.value = oRetorno.dados[0].obr05_sequencial;
    document.form1.obr05_responsavel.value = oRetorno.dados[0].obr05_responsavel;
    document.form1.obr05_tiporesponsavel.value = oRetorno.dados[0].obr05_tiporesponsavel;
    document.form1.z01_nome.value = oRetorno.dados[0].z01_nome;
    document.form1.obr05_tiporegistro.value = oRetorno.dados[0].obr05_tiporegistro;
    document.form1.obr05_numregistro.value = oRetorno.dados[0].obr05_numregistro;
    document.form1.obr05_numartourrt.value = oRetorno.dados[0].obr05_numartourrt;
    document.form1.obr05_vinculoprofissional.value = oRetorno.dados[0].obr05_vinculoprofissional;

  }

  function js_excluir(iCodigoResp) {

    if (!confirm('Deseja excluir esse Respons�vel?')) {
      return false;
    }

    var oParam        = new Object();
    oParam.exec       = 'excluirResp';
    oParam.iCodigo = iCodigoResp;
    js_divCarregando('Aguarde... Excluindo Respons�vel','msgbox');
    var oAjax         = new Ajax.Request(
      'obr1_obras.RPC.php',
      { parameters: 'json='+Object.toJSON(oParam),
        asynchronous:false,
        method: 'post',
        onComplete : js_respospostaExclusao
      });
  }

  function js_respospostaExclusao(oAjax) {
    var oRetorno = eval('('+oAjax.responseText+")");

    if(oRetorno.status == 1){
      alert(oRetorno.message.urlDecode());
    }else{
      alert(oRetorno.message.urlDecode());
    }
    js_removeObj("msgbox");

    js_CarregaResponsaveis()
  }

</script>
