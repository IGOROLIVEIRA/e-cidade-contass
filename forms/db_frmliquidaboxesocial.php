<? db_app::load("strings.js");?>

<fieldset id='esocial'>
  <legend><b>eSocial</b></legend>
  <table>
    <tr>
      <td>
        <strong>Incide Contribuição Previdenciária:</strong>
      </td>
      <td >
        <?
        $aIncide = array('1' => 'Sim', '2' => 'Não');
        db_select('aIncide', $aIncide, true, 1, "onchange='mensagemesocial()'");
        ?>
      </td>
    </tr>
    <tr>
      <td id='cattrab'><?= db_ancora('<b>Categoria do Trabalhador:</b>', "js_pesquisaCatTrabalhador(true)", 1) ?></td>
      <td id='cattrab1'><? db_input('ct01_codcategoria', 10, $ct01_codcategoria, true, 'text', 1, "onchange='js_pesquisaCatTrabalhador(false)'"); ?> </td>
      <td id='cattrab2'><? db_input('ct01_descricaocategoria', 50, $ct01_descricaocategoria, true, 'text', 3, ''); ?></td>
    </tr>
    <tr>
      <td id="idvinculos">
        <strong>O trabalhador possui outro vínculo/atividade com desconto previdenciário: </strong>
      </td>
      <td>
        <?
        $multiplosvinculos = array('' => 'Selecione', '1' => 'Sim', '2' => 'Não');
        db_select('multiplosvinculos', $multiplosvinculos, true, 1, "onchange='validarVinculos()'");
        ?>
      </td>
    </tr>
    <tr>
      <td id='idcontri' colspan="2">
        <strong>Indicador de Desconto da Contribuição Previdenciária:</strong>
      </td>
      <td colspan="2">
        <?
        $aContribuicao = array(
          '' => 'Selecione', '1' => '1 - O percentual da alíquota será obtido considerando a remuneração total do trabalhador',
          '2' => '2 - O declarante aplica a alíquota de desconto do segurado sobre a diferença entre o limite máximo do salário de contribuição e a remuneração de outra empresa para as quais o trabalhador informou que houve o desconto',
          '3' => '3 - O declarante não realiza desconto do segurado, uma vez que houve desconto sobre o limite máximo de salário de contribuição em outra empresa',
        );
        db_select('contribuicaoPrev', $aContribuicao, true, 1, "");
        ?>
      </td>
    </tr>
    <tr>
      <td id='empresa'><?= db_ancora('<b>Empresa que efetuou desconto:</b>', "js_pesquisaEmpresa(true)", 1) ?></td>
      <td id='empresa1'><? db_input('numempresa', 15, $Inumempresa, true, 'text', 1, "onchange='js_pesquisaEmpresa(false)'"); ?> </td>
      <td id='empresa2'><? db_input('nomeempresa', 50, $Inomeempresa, true, 'text', 3, ''); ?></td>
    </tr>
    <tr>
      <td id='catremuneracao'><?= db_ancora('<b>Categoria do trabalhador na qual houve a remuneração:</b>', "js_pesquisaCatTrabalhadorremuneracao(true)", 1) ?></td>
      <td id='catremuneracao1'><? db_input('ct01_codcategoriaremuneracao', 15, $Ict01_codcategoriaremuneracao, true, 'text', 1, "onchange='js_pesquisaCatTrabalhadorremuneracao(false)'"); ?> </td>
      <td id='catremuneracao2'><? db_input('ct01_descricaocategoriaremuneracao', 50, $Ict01_descricaocategoriaremuneracao, true, 'text', 3, ''); ?></td>
    </tr>
    <tr>
      <td id='vlrremuneracao'><strong>Valor da Remuneração:</strong></td>
      <td id='vlrremuneracao1'>
        <?
        db_input('valorremuneracao', 15, '4', true, 'text', 1, "onchange='casasdecimais(1)'", '', '', 'text-align:right');
        ?>
      </td>
    </tr>
    <tr>
      <td id='vlrdesconto'><strong>Valor do Desconto:</strong></td>
      <td id='vlrdesconto1'>
        <?
        db_input('valordesconto', 15, '4', true, 'text', 1, "onchange='casasdecimais(2)'", '', '', 'text-align:right');
        ?>
      </td>
    </tr>
    <tr>
      <td id='idcompetencia'>
        <b>Competência:</b>
      </td>
      <td id='idcompetencia2'>
        <?
        db_inputdata(
          'competencia',
          @$ac10_datamovimento_dia,
          @$ac10_datamovimento_mes,
          @$ac10_datamovimento_ano,
          true,
          'text',
          $db_opcao,
          'style="width: 99px"'
        );
        ?>
      </td>
    </tr>
  </table>
</fieldset>
<script>

  validarInicio();
  function mensagemesocial() 
  {
    document.getElementById('aIncide').style.width = "100%";
    document.getElementById('ct01_codcategoria').style.width = "100%";
    document.getElementById('multiplosvinculos').style.width = "100%";
    if (document.form1.aIncide.value && document.form1.aIncide.value == '2') {
      var r = confirm("Tem certeza de que não há incidência de contribuição previdenciária para este prestador? ");
      if (r == true) {
        document.getElementById('idcontri').style.display = "none";
        document.getElementById('cattrab').style.display = "none";
        document.getElementById('cattrab1').style.display = "none";
        document.getElementById('cattrab2').style.display = "none";
        document.getElementById('ct01_codcategoria').style.display = "none";
        document.getElementById('ct01_descricaocategoria').style.display = "none";
        document.getElementById('contribuicaoPrev').style.display = "none";
        document.getElementById('idcompetencia').style.display = "none";
        document.getElementById('idcompetencia2').style.display = "none";
        document.getElementById('empresa').style.display = "none";
        document.getElementById('empresa1').style.display = "none";
        document.getElementById('empresa2').style.display = "none";
        document.getElementById('catremuneracao').style.display = "none";
        document.getElementById('catremuneracao1').style.display = "none";
        document.getElementById('catremuneracao2').style.display = "none";
        document.getElementById('vlrremuneracao').style.display = "none";
        document.getElementById('vlrremuneracao1').style.display = "none";
        document.getElementById('vlrdesconto').style.display = "none";
        document.getElementById('vlrdesconto1').style.display = "none";
        document.getElementById('multiplosvinculos').style.display = "none";
        document.getElementById('idvinculos').style.display = "none";
        document.form1.numempresa.value = '';
        document.form1.nomeempresa.value = '';
        document.form1.ct01_codcategoriaremuneracao.value = '';
        document.form1.ct01_descricaocategoriaremuneracao.value = '';
        document.form1.valorremuneracao.value = '';
        document.form1.valordesconto.value = '';
        document.form1.competencia.value = '';
        document.form1.multiplosvinculos.value = '';
      } else {
        document.form1.aIncide.value = '1';
        return false;
      }
    } else {
      document.getElementById('cattrab').style.display = "table-cell";
      document.getElementById('cattrab1').style.display = "table-cell";
      document.getElementById('cattrab2').style.display = "table-cell";
      document.getElementById('ct01_codcategoria').style.display = "table-cell";
      document.getElementById('ct01_descricaocategoria').style.display = "table-cell";
      document.getElementById('multiplosvinculos').style.display = "table-cell";
      document.getElementById('idvinculos').style.display = "table-cell";
      document.form1.contribuicaoPrev.value = '';
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.ct01_codcategoria.value = '';
      document.form1.ct01_descricaocategoria.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value = '';
    }
  }
  function validarInicio() 
  {
    document.getElementById('aIncide').style.width = "100%";
    document.getElementById('ct01_codcategoria').style.width = "100%";
    document.getElementById('multiplosvinculos').style.width = "100%";
    document.getElementById('idcompetencia').style.display = "none";
    document.getElementById('idcompetencia2').style.display = "none";
    document.getElementById('empresa').style.display = "none";
    document.getElementById('empresa1').style.display = "none";
    document.getElementById('empresa2').style.display = "none";
    document.getElementById('catremuneracao').style.display = "none";
    document.getElementById('catremuneracao1').style.display = "none";
    document.getElementById('catremuneracao2').style.display = "none";
    document.getElementById('vlrremuneracao').style.display = "none";
    document.getElementById('vlrremuneracao1').style.display = "none";
    document.getElementById('vlrdesconto').style.display = "none";
    document.getElementById('vlrdesconto1').style.display = "none";
    document.getElementById('idcontri').style.display = "none";
    document.getElementById('contribuicaoPrev').style.display = "none";
    if (document.form1.contribuicaoPrev.value) {
      document.form1.multiplosvinculos.value = 1;
      validarVinculos();
    } else {
      document.form1.multiplosvinculos.value = 2;
      validarVinculos();
    }
  }
  function js_pesquisaCatTrabalhador(mostra) 
  {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_categoriatrabalhador.php?funcao_js=parent.js_mostraCatTrabalhador1|ct01_codcategoria|ct01_descricaocategoria', 'Pesquisa', true);
    } else {
      if (document.form1.ct01_codcategoria.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_categoriatrabalhador.php?pesquisa_chave=' + document.form1.ct01_codcategoria.value + '&funcao_js=parent.js_mostraCatTrabalhador', 'Pesquisa', false);
      } else {
        document.form1.ct01_codcategoria.value = '';
        document.form1.ct01_descricaocategoria.value = '';
      }
    }
  }
  function js_pesquisaEmpresa(mostra) 
  {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostraEmpresa1|z01_numcgm|z01_nome', 'Pesquisa', true);
    } else {
      if (document.form1.numempresa.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + document.form1.numempresa.value + '&funcao_js=parent.js_mostraEmpresa', 'Pesquisa', false);
      } else {
        document.form1.nomeempresa.value = '';
      }
    }
  }
  function js_pesquisaCatTrabalhadorremuneracao(mostra) 
  {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_categoriatrabalhador.php?funcao_js=parent.js_mostraCatTrabalhadorremuneracao1|ct01_codcategoria|ct01_descricaocategoria', 'Pesquisa', true);
    } else {
      if (document.form1.ct01_codcategoriaremuneracao.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_categoriatrabalhador.php?pesquisa_chave=' + document.form1.ct01_codcategoriaremuneracao.value + '&funcao_js=parent.js_mostraCatTrabalhadorremuneracao', 'Pesquisa', false);
      } else {
        document.form1.ct01_codcategoriaremuneracao.value = '';
        document.form1.ct01_descricaocategoriaremuneracao.value = '';
      }
    }
  }
  function js_mostraCatTrabalhador(erro, chave) 
  {
    document.form1.ct01_descricaocategoria.value = chave;
    if (erro == true) {
      document.form1.ct01_codcategoria.focus();
      document.form1.ct01_codcategoria.value = '';
    }
  }
  function js_mostraCatTrabalhador1(chave1, chave2) 
  {
    document.form1.ct01_codcategoria.value = chave1;
    document.form1.ct01_descricaocategoria.value = chave2;
    db_iframe_cgm.hide();
  }
  function js_mostraEmpresa(erro, chave)
  {
    document.form1.nomeempresa.value = chave;
    if (erro == true) {
      document.form1.numempresa.focus();
      document.form1.numempresa.value = '';
    }
  }
  function js_mostraEmpresa1(chave1, chave2)
  {
    document.form1.numempresa.value = chave1;
    document.form1.nomeempresa.value = chave2;
    db_iframe_cgm.hide();
  }
  function js_mostraCatTrabalhadorremuneracao(erro, chave) 
  {
    document.form1.ct01_descricaocategoriaremuneracao.value = chave;
    if (erro == true) {
      document.form1.ct01_codcategoriaremuneracao.focus();
      document.form1.ct01_codcategoriaremuneracao.value = '';
    }
  }
  function js_mostraCatTrabalhadorremuneracao1(chave1, chave2)
  {
    document.form1.ct01_codcategoriaremuneracao.value = chave1;
    document.form1.ct01_descricaocategoriaremuneracao.value = chave2;
    db_iframe_cgm.hide();
  }
  function validarVinculos() 
  {
    if (document.form1.multiplosvinculos.value == '1') {
      document.getElementById('idcontri').style.display = "table-cell";
      document.getElementById('contribuicaoPrev').style.display = "table-cell";
      document.getElementById('idcompetencia').style.display = "table-cell";
      document.getElementById('idcompetencia2').style.display = "table-cell";
      document.getElementById('empresa').style.display = "table-cell";
      document.getElementById('empresa1').style.display = "table-cell";
      document.getElementById('empresa2').style.display = "table-cell";
      document.getElementById('catremuneracao').style.display = "table-cell";
      document.getElementById('catremuneracao1').style.display = "table-cell";
      document.getElementById('catremuneracao2').style.display = "table-cell";
      document.getElementById('vlrremuneracao1').style.display = "table-cell";
      document.getElementById('vlrremuneracao').style.display = "table-cell";
      document.getElementById('vlrdesconto').style.display = "table-cell";
      document.getElementById('vlrdesconto1').style.display = "table-cell";
      document.getElementById('aIncide').style.width = "100%";
      document.getElementById('ct01_codcategoria').style.width = "100%";
      document.getElementById('multiplosvinculos').style.width = "100%";
      document.getElementById('contribuicaoPrev').style.width = "29.8%";
      document.getElementById('numempresa').style.width = "100%";
      document.getElementById('ct01_codcategoriaremuneracao').style.width = "100%";
      document.getElementById('valorremuneracao').style.width = "100%";
      document.getElementById('valordesconto').style.width = "100%";
      document.getElementById('competencia').style.width = "80%";
    }
    if (document.form1.multiplosvinculos.value == '2') {
      document.getElementById('idcontri').style.display = "none";
      document.getElementById('contribuicaoPrev').style.display = "none";
      document.getElementById('idcompetencia').style.display = "none";
      document.getElementById('idcompetencia2').style.display = "none";
      document.getElementById('empresa').style.display = "none";
      document.getElementById('empresa1').style.display = "none";
      document.getElementById('empresa2').style.display = "none";
      document.getElementById('catremuneracao').style.display = "none";
      document.getElementById('catremuneracao1').style.display = "none";
      document.getElementById('catremuneracao2').style.display = "none";
      document.getElementById('vlrremuneracao').style.display = "none";
      document.getElementById('vlrremuneracao1').style.display = "none";
      document.getElementById('vlrdesconto').style.display = "none";
      document.getElementById('vlrdesconto1').style.display = "none";
      document.getElementById('aIncide').style.width = "100%";
      document.getElementById('ct01_codcategoria').style.width = "100%";
      document.getElementById('multiplosvinculos').style.width = "100%";
      document.form1.numempresa.value = '';
      document.form1.nomeempresa.value = '';
      document.form1.ct01_codcategoriaremuneracao.value = '';
      document.form1.ct01_descricaocategoriaremuneracao.value = '';
      document.form1.valorremuneracao.value = '';
      document.form1.valordesconto.value = '';
      document.form1.competencia.value = '';
      document.form1.contribuicaoPrev.value = '';
    }
  }
  function casasdecimais(escolha) 
  {
    var valorremuneracao = (document.form1.valorremuneracao.value).indexOf('.');
    var valordesconto = (document.form1.valordesconto.value).indexOf('.');
    if (escolha == '1' && valorremuneracao > 0) {
      var virgula = document.form1.valorremuneracao.value.substring(valorremuneracao + 0);
      document.form1.valorremuneracao.value = document.form1.valorremuneracao.value.substring(0, valorremuneracao) + virgula.substring(0, 3);
    }
    if (escolha == '2' && valordesconto > 0) {
      var virgula = document.form1.valordesconto.value.substring(valordesconto + 0);
      document.form1.valordesconto.value = document.form1.valordesconto.value.substring(0, valordesconto) + virgula.substring(0, 3);
    }
  }
  function js_preencheDadosEsocial(oAjax) 
  {
    obj = eval("(" + oAjax.responseText + ")");
    document.form1.ct01_codcategoria.value = obj.e50_cattrabalhador;
    document.form1.contribuicaoPrev.value = obj.e50_contribuicaoPrev;
    document.form1.numempresa.value = obj.e50_empresadesconto;
    document.form1.ct01_codcategoriaremuneracao.value = obj.e50_cattrabalhadorremurenacao;
    document.form1.valorremuneracao.value = obj.e50_valorremuneracao;
    document.form1.valordesconto.value = obj.e50_valordesconto;
    document.form1.competencia.value = obj.e50_datacompetencia;
    document.form1.nomeempresa.value = obj.nomeempresa;
    document.form1.ct01_descricaocategoriaremuneracao.value = obj.desctrabremuneracao;
    document.form1.ct01_descricaocategoria.value = obj.desccattrabalhado;
    validarInicio();
  }
  function js_verificaEsocial(e50_codord) 
  {
    var oParam = new Object();
    oParam.method = "verificaEsocial";
    oParam.iCodOrdem = e50_codord;
    let oAjax = new Ajax.Request("emp4_pagordemesocial.RPC.php", {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParam),
      onComplete: js_preencheDadosEsocial
    });
  }
</script>