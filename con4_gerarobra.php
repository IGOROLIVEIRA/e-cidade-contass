<?php
/**
 *
 * @author I
 * @revision $Author: dbrobson $
 * @version $Revision: 1.10 $
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("o124_descricao");
$clrotulo->label("o124_sequencial");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript"
          src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript"
          src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript"
          src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript"
          src="scripts/widgets/dbmessageBoard.widget.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
<center>


  <form name="form1" method="post" action="">
    <div style="display: table">
      <fieldset>
        <legend>
          <b>Gerar SICOM - OBRA</b>
        </legend>
        <table style='empty-cells: show; border-collapse: collapse;'>
          <tr>
            <td colspan="4">
              <fieldset>
                <table>
                  <tr>
                    <td>Mês Referência:
                      <select id="MesReferencia" class="MesReferencia" onchange="js_mostrameta(this.value)">
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                      </select>
                    </td>
                  </tr>
                </table>
              </fieldset>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">Dados</td>
            <!-- <td>Inclusão de Programas</td> -->
            <td>Arquivos Gerados</td>
          </tr>
          <tr>
            <td style="border: 2px groove white;" valign="top">
              <input type="checkbox" value="IdentificacaoRemessaobras" id="IdentificacaoRemessaobras" />
              <label for="IDE">Identificação da Remessa (IDE)</label><br>
              <input type="checkbox" value="PessoaObras" id="PessoaObras" />
              <label for="PESSOA">Pessoas Físicas (PESSOA)</label><br>
              <input type="checkbox" value="Licobras" id="Licobras" />
              <label for="LICOBRAS">Licitação, Obras e Serviços de Engenharia (LICOBRAS)</label><br>
              <input type="checkbox" value="ExecucaodeContratosObras" id="ExecucaodeContratosObras" />
              <label for="EXEOBRAS">Execução dos Contratos de Obras e Serviços de Engenharia (EXEOBRAS)</label><br>
              <input type="checkbox" value="DetalhamentodeObras" id="DetalhamentodeObras" />
              <label for="CADOBRAS">Cadastro do Detalhamento de Obras e Serviços de Engenharia (CADOBRAS)</label><br>
            </td>
            <td style="border: 2px groove white;" valign="top">
            </td>
            <td style="border: 2px groove white;" valign="top">
              <div id='retorno'
                   style="width: 200px; height: 250px; overflow: scroll;">
              </div>
            </td>
          </tr>
          <input type="hidden" value="<?php echo db_getsession("DB_anousu") ?>" id="AnoReferencia" />
        </table>
      </fieldset>
      <div style="text-align: center;">
        <input type="button" id="btnMarcarTodos" value="Marcar Todos" onclick="js_marcaTodos();" />
        <input type="button" id="btnLimparTodos" value="Limpar Todos" onclick="js_limpa();"/>
        <input type="button" id="btnProcessar" value="Processar"
               onclick="js_processar();" />
      </div>
    </div>
  </form>

</center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
  function js_processar() {

    var aArquivosSelecionados = new Array();
    var aArquivos             = $$("input[type='checkbox']");
    var iMesReferencia        = $("MesReferencia");
    /*
     * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
     */
    aArquivos.each(function (oElemento, iIndice) {

      if (oElemento.checked) {
        aArquivosSelecionados.push(oElemento.value);
      }
    });
    if (aArquivosSelecionados.length == 0) {

      alert("Nenhum arquivo foi selecionado para ser gerado");
      return false;
    }
    js_divCarregando('Aguarde, processando arquivos','msgBox');

    var oParam           = new Object();
    oParam.exec          = "processarObra";
    oParam.arquivos      = aArquivosSelecionados;
    oParam.mesReferencia = iMesReferencia.value;
    var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
      {
        method:'post',
        parameters:'json='+Object.toJSON(oParam),
        onComplete:js_retornoProcessamento
      }
    );

  }

  function js_retornoProcessamento(oAjax) {

    js_removeObj('msgBox');
    $('debug').innerHTML = oAjax.responseText;
    var oRetorno = eval("("+oAjax.responseText+")");
    if (oRetorno.status == 1) {

      alert("Processo concluído com sucesso!");
      var sRetorno = "<b>Arquivos Gerados:</b><br>";
      for (var i = 0; i < oRetorno.itens.length; i++) {

        with (oRetorno.itens[i]) {

          sRetorno += "<a  href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
        }
      }

      $('retorno').innerHTML = sRetorno;
    } else {

      $('retorno').innerHTML = '';
      alert("Houve um erro no processamento!" + oRetorno.message.urlDecode());
      //alert(oRetorno.message.urlDecode());
      return false;
    }
  }
  function js_pesquisao125_cronogramaperspectiva(mostra) {

    if (mostra==true){
      /*
       *passa o nome dos campos do banco para pesquisar pela função js_mostracronogramaperspectiva1
       *a variavel funcao_js é uma variável global
       *db_lovrot recebe parâmetros separados por |
       */
      js_OpenJanelaIframe('CurrentWindow.corpo',
        'db_iframe_cronogramaperspectiva',
        'func_cronogramaperspectiva.php?funcao_js='+
        'parent.js_mostracronogramaperspectiva1|o124_sequencial|o124_descricao|o124_ano',
        'Perspectivas do Cronograma',true);
    }else{
      if ($F('o124_sequencial') != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo',
          'db_iframe_cronogramaperspectiva',
          'func_cronogramaperspectiva.php?pesquisa_chave='+
          $F('o124_sequencial')+
          '&funcao_js=parent.js_mostracronogramaperspectiva',
          'Perspectivas do Cronograma',
          false);
      }else{
        $('o124_sequencial').value = '';
      }
    }
  }
  //para retornar sem mostrar a tela de pesquisa. ao digitar o codigo retorna direto para o campo
  function js_mostracronogramaperspectiva(chave,erro, ano) {
    $('o124_descricao').value = chave;
    if(erro==true) {

      $('o124_sequencial').focus();
      $('o124_sequencial').value = '';

    }
  }
  //preenche os campos do frame onde foi chamada com os valores do banco
  function js_mostracronogramaperspectiva1(chave1,chave2,chave3) {

    $('o124_sequencial').value = chave1;
    $('o124_descricao').value  = chave2;
    db_iframe_cronogramaperspectiva.hide();
  }

  function js_pesquisa_ppa(mostra) {

    if(mostra==true){
      js_OpenJanelaIframe('CurrentWindow.corpo',
        'db_iframe_ppa',
        'func_ppaversaosigap.php?funcao_js='+
        'parent.js_mostrappa1|o119_sequencial|o01_descricao',
        'Perspectivas do Cronograma',true);
    }else{
      if( $F('o119_sequencial') != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo',
          'db_iframe_ppa',
          'func_ppaversaosigap.php?pesquisa_chave='+
          $F('o119_sequencial')+
          '&funcao_js=parent.js_mostrappa',
          'Perspectivas do Cronograma',
          false);
      }else{

        document.form1.o124_descricao.value = '';
        document.form1.ano.value             = ''

      }
    }
  }

  function js_mostrappa(chave,erro, ano) {
    $('o119_descricao').value = chave;
    if(erro==true) {

      $('o119_sequencial').focus();
      $('o119_sequencial').value = '';

    }
  }

  function js_mostrappa1(chave1,chave2,chave3) {

    $('o119_sequencial').value = chave1;
    $('o119_descricao').value  = chave2;
    db_iframe_ppa.hide();
  }

  function js_marcaTodos() {

    var aCheckboxes = $$('input[type=checkbox]');
    aCheckboxes.each(function(oCheckbox) {
      oCheckbox.checked = true;
    });
  }

  function js_limpa() {

    var aCheckboxes = $$('input[type=checkbox]');
    aCheckboxes.each(function (oCheckbox) {
      oCheckbox.checked = false;
    });
  }


  function js_emite(){

    qry= "?ano="+document.form1.AnoReferencia.value;
    qry+= "&mes="+document.form1.MesReferencia.value;

    jan = window.open('con4_conferenciaflpgo.php'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);

  }

</script>
<div id='debug'>
</div>
