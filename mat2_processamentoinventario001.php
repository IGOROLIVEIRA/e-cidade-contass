<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once ("dbforms/db_classesgenericas.php");

$aux = new cl_arquivo_auxiliar;
$aux->cabecalho = "<strong>Material</strong>";
                 $aux->codigo = "m60_codmater"; //chave de retorno da func
                 $aux->descr  = "m60_descr";   //chave de retorno
                 $aux->nomeobjeto = 'material';
                 $aux->funcao_js = 'js_mostra2';
                 $aux->funcao_js_hide = 'js_mostra3';
                 $aux->sql_exec  = "";

                 $aux->func_arquivo = "func_matestoque.php";  //func a executar
                 $aux->nomeiframe = "db_iframe_matestoque";
                 $aux->localjan = "";
                 $aux->tamanho_campo_descricao = 29;
                 $aux->onclick = "";
                 $aux->db_opcao = 2;
                 $aux->tipo = 2;
                 $aux->top = 0;
                 $aux->linhas = 5;
                 $aux->vwidth = 400;

 ?>
 <html>
 <head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php db_app::load("estilos.css, scripts.js, prototype.js, strings.js"); ?>
</head>
<body bgcolor="#cccccc">
  <form id="form1" name="form1">
    <input type="hidden" name="dataini" id="dataini" value="">
    <input type="hidden" name="datafim" id="datafim" value="">
    <div class="container">

      <fieldset>
        <legend><b>Relatório Fechamento de Inventário</b></legend>

        <table>
          <tr>
            <td nowrap="nowrap" >
              <?php db_ancora('<b>Inventário</b>', 'js_pesquisaInventario(true);', 2); ?>
            </td>
            <td title="Inventario">
              <?php db_input('iInventario', 10, "", true, 'text',3); ?>
            </td>
          </tr>

        </table>
        <?php $aux->funcao_gera_formulario();  ?>
        <table>
          <tr>
            <td nowrap="nowrap" >
              <b>Tipó de impressão</b>
            </td>
            <td title="Inventario">
              <select name="tipoImpressao" id="tipoImpressao" >
                <option value="1">Analítico</option>
                <option value="2">Sintético</option>
              </select>
            </td>
          </tr>

        </table>

      </fieldset>

      <input type="button" name="btnImprimir" id ="btnImprimir" value="Imprimir" onclick="js_imprimir();" />
    </form>

  </div>

</body>
</html>

<?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>

<script type="text/javascript">

  function js_pesquisaInventario(lMostra){
    var sUrlLookUp = "func_inventario.php?situacao=3&funcao_js=parent.js_mostraInventario|t75_sequencial|t75_periodoinicial|t75_periodofinal";
    js_OpenJanelaIframe('', 'db_iframe_inventario', sUrlLookUp, 'Pesquisa Inventarário', lMostra);
  }
  function js_mostraInventario(iInventario, dataini, datafim) {
    db_iframe_inventario.hide();
    $('iInventario').value = iInventario;
    $('dataini').value     = dataini;
    $('datafim').value     = datafim;
  }

  function js_imprimir() {

    if(empty($('iInventario').value)){
      alert('Informe a o inventário.');
      return false;
    }
    material = new Array;
    for(i=0;i<document.form1.material.length;i++){
      material.push(document.form1.material[i].value);
    }
    var sQueryString = 'mat2_processamentoinventario002.php?inventario='+$('iInventario').value;
        sQueryString += '&dataini='+$('dataini').value;
        sQueryString += '&datafim='+$('datafim').value;
        sQueryString += '&materiais='+material;
        sQueryString += '&tipoimpressao='+$('tipoImpressao').value;
    var janela = window.open(sQueryString, '', 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');

    janela.moveTo(0, 0);
  }
</script>
