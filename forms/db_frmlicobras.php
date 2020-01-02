<?
//MODULO: Obras
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
            db_ancora('Processo Licitacao:',"js_pesquisa_liclicita(true)",$db_opcao);
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
            <strong>Nº:</strong>
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
      <hr/>
      <table>
        <tr>
          <td>
            <strong>Data Lançamento:</strong>
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
            <strong>Nº Obra: </strong>
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
            db_textarea('obr01_linkobra',0,0,$Iobr01_linkobra,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Tipo Responsável: </strong>
          </td>
          <td>
            <?
            $aValores = array(0 => 'Selecione',
              1 => 'Fiscalização',
              2 => 'Execução',
              3 => 'Projetista');
            db_select('obr01_tiporesponsavel', $aValores, true, $db_opcao," onchange=''");

            db_ancora('Responsável:',"js_pesquisa_responsavel(true)",$db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('obr01_responsavel',10,$Iobr01_responsavel,true,'text',$db_opcao,"onchange='js_pesquisa_responsavel(false)'");
            db_input('z01_nome',40,'',true,'text',3,"")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <strong>Tipo Registro:</strong>
          </td>
          <td>
            <?
            $aValoresreg = array(0 => 'Selecione',
              1 => 'CREA',
              2 => 'CAU');
            db_select('obr01_tiporegistro', $aValoresreg, true, $db_opcao," onchange=''");
            ?>
            <strong>Nº Registro:</strong>
          </td>
          <td>
            <?
            db_input('obr01_numregistro',10,$Iobr01_numregistro,true,'text',$db_opcao,"");
            ?>

            <strong>Numero da ART ou RRT:</strong>
            <?
            db_input('obr01_numartourrt',10,$Iobr01_numartourrt,true,'text',$db_opcao,"onmouseover='myfuncionmsg()'");
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
        <tr>
          <td nowrap title="<?=@$Tobr01_vinculoprofissional?>">
            <?=@$Lobr01_vinculoprofissional?>
          </td>
          <td>
            <?
            $aValoresvinculo = array(0 => 'Selecione',
              1 => 'Profissional da empresa executora',
              2 => 'Servidor(a) Efetivo(a)',
              3 => 'Contratado(a) da administração');
            db_select('obr01_vinculoprofissional', $aValoresvinculo, true, $db_opcao," onchange=''");
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
  </center>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>

  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_licobras','func_licobras.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_licobras.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }

  js_carregarlic();

  /**
   * funcao para retornar licitacao
   */
  function js_pesquisa_liclicita(mostra){
    if(mostra==true){

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_licobras',
        'func_liclicita.php?situacao=10&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto|l20_numero|pc50_descr',
        'Pesquisa Licitações',true);
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
      document.form1.z01_nome.focus();
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
        'Pesquisa Responsáveis',true);
    }else{

      if(document.form1.obr01_responsavel.value != ''){

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_cgm',
          'func_nome.php?pesquisa_chave='+
          document.form1.obr01_responsavel.value+'&funcao_js=parent.js_preencheResponsavel2&filtro=1',
          'Pesquisa',false);
      }else{
        document.form1.obr01_responsavel.value = '';
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheResponsavel(codigo,nome)
  {
    document.form1.obr01_responsavel.value = codigo;
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
</script>
