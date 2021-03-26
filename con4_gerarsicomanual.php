<?php
/**
 *
 * @author I
 * @revision $Author: dbiuri $
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
  <script language="JavaScript" type="text/javascript"
  src="scripts/micoxUpload.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <center>


    <form name="form1" method="post" action="">
      <div style="display: table">
        <fieldset>
          <legend>
            <b>Gerar SICOM - Arquivos de Planejamento Anual</b>
          </legend>
          <table style='empty-cells: show; border-collapse: collapse;'>
           <tr>
              <td colspan="3">
                <div id='dadosppa'>
                  <fieldset>
                  <legend>
            			<b>Selecionar Perspectiva</b>
          				</legend>
                    <table>
                      <tr>
                        <td><?
                        db_ancora("<b>Perspectiva Cronograma:</b>","js_pesquisao125_cronogramaperspectiva(true);", 1);
                        ?>
                        </td>
                        <td><?
                        db_input('o124_sequencial',10,$Io124_sequencial,true,'text',
                        1," onchange='js_pesquisao125_cronogramaperspectiva(false);'");
                        db_input('o124_descricao',40,$Io124_descricao,true,'text',3,'')
                        ?>
                        </td>
                      </tr>
                      <tr>
                        <td><?
                        db_ancora("<b>Perspectiva PPA:</b>","js_pesquisa_ppa(true);", 1);
                        ?>
                        </td>
                        <td><?
                        db_input('o119_sequencial',10,$Io124_sequencial,true,'text',
                        1," onchange='js_pesquisa_ppa(false);'");
                        db_input('o119_descricao',40,$Io124_descricao,true,'text',3,'')
                        ?>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                </div>
              </td>
            </tr>
             <tr>
              <td colspan="3">
                <div id='dadosppa'>
                <form name="form1" id='form1' method="post" action="" enctype="multipart/form-data">
                  <fieldset>
                  <legend>
            			<b>Selecionar Arquivos de Leis</b>
          				</legend>
                            <table>
                              <tr>
                                <td class="rotulo">
                                Lei PPA:
                                <div>&nbsp;</div>
                                </td>
                                <td class="file-submit">
                                    <input type="file" name="PPA" />
                                    <div id="recebe_up_ppa" class="recebe">&nbsp;</div>
                                </td>
                                <td>
                                <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=PPA&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_ppa','Carregando...','Erro ao carregar')" />
                                <div>&nbsp;</div>
                                </td>
                              </tr>
                              <tr>
                                <td class="rotulo">
                                Lei LDO:
                                <div>&nbsp;</div>
                                </td>
                                <td class="file-submit">
                                    <input type="file" name="LDO" />
                                    <div id="recebe_up_ldo" class="recebe">&nbsp;</div>
                                </td>
                                <td>
                                <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=LDO&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_ldo','Carregando...','Erro ao carregar')" />
                                <div>&nbsp;</div>
                                </td>
                              </tr>
                              <tr>
                                <td class="rotulo">
                                Lei LOA:
                                <div>&nbsp;</div>
                                </td>
                                <td class="file-submit">
                                    <input type="file" name="LOA" />
                                    <div id="recebe_up_loa" class="recebe">&nbsp;</div>
                                </td>
                                <td>
                                <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=LOA&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_loa','Carregando...','Erro ao carregar')" />
                                <div>&nbsp;</div>
                                </td>
                              </tr>
                                  <tr>
                                    <td style="">
                                      Anexos LOA:
                                    <div>&nbsp;</div>
                                    </td>
                                    <td class="file-submit">
                                      <input type="file" name="ANEXOS_LOA" />
                                      <div id="recebe_up_anexos" class="recebe">&nbsp;</div>
                                    </td>
                                    <td>
                                      <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=ANEXOS_LOA&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_anexos','Carregando...','Erro ao carregar')" />
                                         <div>&nbsp;</div>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td style="">
                                      Opção Semestralidade:
                                    <div>&nbsp;</div>
                                    </td>
                                    <td class="file-submit">
                                      <input type="file" name="OPCAOSEMESTRALIDADE" />
                                      <div id="recebe_up_opsemest" class="recebe">&nbsp;</div>
                                    </td>
                                    <td>
                                      <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=OPCAOSEMESTRALIDADE&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_opsemest','Carregando...','Erro ao carregar')" />
                                         <div>&nbsp;</div>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td style="">
                                      Desopção Semestralidade:
                                    <div>&nbsp;</div>
                                    </td>
                                    <td class="file-submit">
                                      <input type="file" name="DESOPCAOSEMESTRALIDADE" />
                                      <div id="recebe_up_desopsemest" class="recebe">&nbsp;</div>
                                    </td>
                                    <td>
                                      <input type="button" value="Enviar" onclick="micoxUpload(this.form,'upload_leis.php?nome_campo=DESOPCAOSEMESTRALIDADE&ano_usu=<?=substr(db_getsession("DB_anousu"),-2) ?>','recebe_up_desopsemest','Carregando...','Erro ao carregar')" />
                                         <div>&nbsp;</div>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </div>

                  </fieldset>
                  </form>
                </div>
              </td>
            </tr>
            <tr>
            <td colspan=3>
            <fieldset>
          <legend>
            <b>Selecione os Arquivo a serem gerados</b>
          </legend>
            <table>
            <tr>
              <td>Dados Cadastrais</td>
              <td>Dados do Orçamento</td>
              <td></td>
            </tr>
            <tr>
              <td style="border: 2px groove white;" valign="top">
              <input type="checkbox" value="IdentificacaoMunicipio"
                id="IdenficacaoMunicipio" /> <label
                for="IdenficacaoMunicipio">Identificação do Município</label><br>

                <input type="checkbox" value="Orgao" id="Orgao" /> <label
                for="Orgao">Orgãos</label><br>

                <input type="checkbox" value="LeiPPA" id="LeiPPA" /> <label for="LeiPPA">Leis
                  do PPA</label><br>

                <input type="checkbox" value="LeiOrcamentaria" id="LeiOrcamentaria" /> <label for="LeiOrcamentaria">Lei
                  Orçamentária</label><br>

                <input type="checkbox" value="LeiDiretrizOrcamentaria" id="LeiDiretrizesOrcamentaria" />
                <label for="LeiDiretrizesOrcamentaria">Lei de Diretrizes Orçamentárias</label><br>

                <input type="checkbox" value="UnidadeOrcamentaria" id="UnidadeOrcamentaria" />
                <label for="UnidadeOrcamentaria">Unidades Orçamentárias</label><br>

                <input type="checkbox" value="ProgramaPPA" id="ProgramaPPA" />
                <label for="ProgramaPPA">Programas do PPA</label><br>

                  <input type="checkbox" value="AcoesMetasPPA" id="AcoesMetasPPA" /> <label
                for="AcoesMetasPPA">Ações e Metas do PPA</label><br>

              </td>
              <td style="border: 2px groove white;" valign="top">
              <input type="checkbox" value="DespesaOrcamento" id="DespesaOrcamento" /> <label
                for="DespesaOrcamento">Despesas do Orçamento</label><br>

                <input type="checkbox" value="ReceitaOrcamentariaOrgao" id="ReceitaOrcamentariaOrgao" /> <label
                for="ReceitaOrcamentariaOrgao">Receita Orçamentária dos Órgãos</label><br>


                <input type="checkbox" value="DetalhamentoMetasFiscais" id="DetalhamentoMetasFiscais" /> <label
                for="DetalhamentoMetasFiscais">Detalhamento das Metas Fiscais</label><br>

                <input type="checkbox" value="DetalhamentoRiscosFiscais" id="DetalhamentoRiscosFiscais" /> <label
                for="DetalhamentoRiscosFiscais">Detalhamento dos Riscos Fiscais</label><br>

                <input type="checkbox" value="MetasArrecadacaoReceita" id="MetasArrecadacaoReceita" /> <label
                for="MetasArrecadacaoReceita">Metas de Arrecadação de Receita</label><br>

                <input type="checkbox" value="Consideracoes" id="Consideracoes" /> <label
                for="Consideracoes">Considerações</label><br>
              </td>
              <td style="border: 2px groove white;" valign="top">
                <div id='retorno'
                  style="width: 200px; height: 172px; overflow: scroll;">
                </div>
              </td>
            </tr>
            </table>
            </fieldset>
            </td>
            </tr>
          </table>
        </fieldset>
        <div style="text-align: center;">
          <input type="button" id="btnMarcarTodos" value="Marcar Todos" onclick="js_marcaTodos();" />
          <input type="button" id="btnLimparTodos" value="Limpar Todos" onclick="js_limpa();"/>
          <input type="button" id="btnExcArq" value="Excluir Anexos"
            onclick="js_excluirArquivos();" />
          <input type="button" id="btnProcessar" value="Processar"
            onclick="js_processar();" />
        </div>
      </div>
    </form>

  </center>
</body>
</html>
                        <? db_menu(db_getsession("DB_id_usuario"),
                        db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
function js_processar() {

  if ($F('o119_sequencial') == '') {

	  alert("Favor informar a Pespectiva do PPA");
	  js_pesquisa_ppa(true);
    return false;
  }
  var aArquivosSelecionados = new Array();
  var aArquivos             = $$("input[type='checkbox']");

  /*
   * iterando sobre o array de arquivos com uma função anônima para pegar os arquivos selecionados pelo usuário
   */
  aArquivos.each(function (oElemento, iIndice) {

    if (oElemento.checked) {
        aArquivosSelecionados.push(oElemento.value);
    }
  });
  // if (aArquivosSelecionados.length == 0) {

  //   alert("Nenhum arquivo foi selecionado para ser gerado leras");
  //   return false;
  // }
  js_divCarregando('Aguarde, processando arquivos','msgBox');
  var oParam           = new Object();
  oParam.exec          = "processarSicomAnual";
  oParam.arquivos      = aArquivosSelecionados;
  oParam.pespectivappa = $F('o119_sequencial');
  var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
		                            {
                                  method:'post',
                                  parameters:'json='+Object.toJSON(oParam),
                                  onComplete:js_retornoProcessamento
		                            }
	      );

}

function js_retornoProcessamento(oAjax) {
     console.log(oAjax);
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
	    //alert("Ouve um erro no processamento!");
	    alert(oRetorno.message.urlDecode());
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

  function js_excluirArquivos(){

    js_divCarregando('Aguarde, exclusão de documentos','msgBox');
    var oParam           = new Object();
    oParam.exec          = "excluirArquivosIP";
    var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
                                  {
                                    method:'post',
                                    parameters:'json='+Object.toJSON(oParam),
                                    onComplete:js_retornoProcessamento
                                  }
          );

  }


</script>
<div id='debug'>
</div>
