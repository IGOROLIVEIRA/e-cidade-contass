<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_liborcamento.php");
require_once ("dbforms/db_funcoes.php");
require_once ("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);
$aux = new cl_arquivo_auxiliar;
$rotulo = new rotulocampo();
$rotulo->label("m60_codmater");
$rotulo->label("m60_descr");

?>

<html>
  <head>

    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" content="0">

    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" type="text/css" href="estilos/grid.style.css">

    <script type="text/javascript" src="scripts/scripts.js"></script>
    <script type="text/javascript" src="scripts/prototype.js"></script>
    <script type="text/javascript" src="scripts/strings.js"></script>
    <script type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script type="text/javascript" src="scripts/widgets/DBLancador.widget.js"></script>
    <script type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script type="text/javascript" src="scripts/widgets/DBTreeView.widget.js"></script>
    <script type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script type="text/javascript" src="scripts/classes/material/FiltroGrupoSubgrupo.js"></script>
    <style type="text/css">
      #material { width: 480px; }
    </style>
  </head>
  <body bgcolor="#cccccc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">

    <div class="container">

      <form id="frmDistribuicaoMateriais" name="form1" method="post" action="">
        <table>
          <tr>
            <td align="center" colspan="3">
              <fieldset>

                <legend>Distribuição Mensal de Materiais</legend>

                <!-- Filtros de Pesquisa -->
                <fieldset class="separator">

                  <legend>Filtros</legend>

                  <table style="width: 100%;">

                    <tr>
                      <td style="width: 180px;">
                        <label class="bold" id="lbl_competencia_inicial" for="competencia_inicial_mes">Competência Inicial:</label>
                      </td>
                      <td>
                          <?php
                          $Scompetencia_inicial_mes = 'Competência Inicial';
                          $Scompetencia_inicial_ano = 'Competência Final';
                          db_input('competencia_inicial_mes', '', 1, false, '', '', 'style="width: 8%;" placeholder="mês"', '', '', '', 2);
                          ?>
                          <?php
                          db_input('competencia_inicial_ano', '', 1, false, '', '', 'style="width: 16%;" placeholder="ano"', '', '', '', 4)
                          ?>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <label class="bold" id="lbl_competencia_final" for="competencia_final_mes">Competência Final:</label>
                      </td>
                      <td>
                          <?php
                          $Scompetencia_final_mes = 'Competência Final';
                          $Scompetencia_final_ano = 'Competência Final';
                          db_input('competencia_final_mes', '', 1, false, '', '', 'style="width: 8%;" placeholder="mês"', '', '', '', 2);
                          ?> /
                          <?php db_input('competencia_final_ano', '', 1, true, '', 3, 'style="width: 16%; color: #888;" placeholder="ano"', '', '', '', 4) ?>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <label class="bold" id="lbl_distribuicao_zerada" for="distribuicao_zerada">Exibe Distribuição Zerada:</label>
                      </td>
                      <td>
                          <?php
                          $aOpcoesDistribuicao = array(
                            '0' => 'Não',
                            '1' => 'Sim',
                          );
                          db_select('distribuicao_zerada', $aOpcoesDistribuicao, true, 1, 'style="width: 50%;"');
                          ?>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <label class="bold" id="lbl_grupo_subgrupo" for="btn_grupo_subgrupo">Grupo/Subgrupo:</label>
                      </td>
                      <td>
                          <input type="button" value="Escolher" id="btn_grupo_subgrupo">
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2" nowrap width="100%">
                        <center>
                        <fieldset>
                          <legend>Materiais</legend>
                          <table>
                            <tr>
                              <td nowrap title="<?=@$Tm60_codmater?>">
                               <?
                                  db_ancora(@$Lm60_codmater,"js_pesquisam60_codmater(true);",1);
                               ?>
                               <?
                                  db_input('m60_codmater',7,$Im60_codmater,true,'text',1," onchange='js_pesquisam60_codmater(false);'","")
                               ?>
                               <?
                                  db_input('m60_descr',35,$Im60_descr,true,'text',3,'')
                               ?>
                               <input type="button" value="Lançar" id="btn-lancar"/>
                              </td>
                            </tr>
                            <tr colspan="4">
                              <td>
                                <select name="material[]" id="material" class="DBSelectMultiplo" size="8" multiple></select>
                              </td>
                            </tr>
                          </table>

                          <strong>Dois cliques sobre o item o exclui</strong>

                        </fieldset>
                        </center>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <div id="lancador-departamentos" style="margin-top: 5px;">&nbsp;</div>
                      </td>
                    </tr>

                  </table>
                </fieldset>

                <!-- Op??es de visualiza??o -->
                <fieldset class="separator">

                  <legend>Opções de Visualização</legend>

                  <table style="width: 100%;">

                    <tr>
                      <td style="width: 180px;">
                        <label class="bold" id="lbl_quebra_pagina" for="quebra_pagina">Quebra de Página:</label>
                      </td>
                      <td>
                          <?php
                          $aOpcoesQuebraPagina = array(
                            '0' => 'Nenhuma',
                            '1' => 'Por Departamento',
                          );
                          db_select('quebra_pagina', $aOpcoesQuebraPagina, true, 1, 'style="width: 50%;"');
                          ?>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <label class="bold" id="lbl_agrupar" for="agrupar">Agrupar por Grupo/Subgrupo:</label>
                      </td>
                      <td>
                          <?php
                          $aOpcoesAgrupar = array(
                            '1' => 'Sim',
                            '0' => 'Não',
                          );
                          db_select('agrupar', $aOpcoesAgrupar, true, 1, 'style="width: 50%;"');
                          ?>
                      </td>
                    </tr>

                  </table>
                </fieldset>
              </fieldset>

              <input style="margin-top: 10px;" name="emite" id="emite" type="button" value="Gerar" onclick="js_emite();">

            </td>
          </tr>

        </table>
      </form>
    </div>

    <script type="text/javascript">

      function js_pesquisam60_codmater(mostra){
        if(mostra==true){
          js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_material','func_matmater.php?funcao_js=parent.js_mostramatmater1|m60_codmater|m60_descr','Pesquisa',true);
        }else{
           if(document.form1.m60_codmater.value != ''){
              js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_material','func_matmater.php?pesquisa_chave='+document.form1.m60_codmater.value+'&funcao_js=parent.js_mostramatmater','Pesquisa',false);
           }else{
             document.form1.m60_codmater.value = '';
           }
        }
      }

      function js_mostramatmater(chave2,erro,chave1){
        document.form1.m60_codmater.value = chave1;
        document.form1.m60_descr.value = chave2;
        if(erro==true){
          document.form1.m60_codmater.focus();
          document.form1.m60_codmater.value = '';
          return;
        }
      }

      function js_mostramatmater1(chave1,chave2){
        document.form1.m60_codmater.value = chave1;
        document.form1.m60_descr.value = chave2;
        db_iframe_material.hide();
      }

      var optionsMateriais = document.getElementById("material");

      var oLancador;
      var oFiltroGrupoSubgrupo;
      var URL_RELATORIO = 'mat2_distribuicao002.php';

      function addOption(codigoMaterial, descMaterial) {


        var jaTem = Array.prototype.filter.call(optionsMateriais.children, function(o) {
          return o.value == codigoMaterial;
        });

        if (jaTem.length > 0) {
          alert("Material já inserido.");
          limparCampos();
          return;
        }

        var option = document.createElement('option');
        option.value = codigoMaterial;
        option.innerHTML = descMaterial;
        optionsMateriais.appendChild(option);

        limparCampos();
      }

      function limpar() {
        optionsMateriais.innerHTML = "";
      }

      function limparCampos() {
        document.form1.m60_codmater.value  = '';
        document.form1.m60_descr.value  = '';
        document.form1.material.value = '';
      }

      document.getElementById('btn-lancar').addEventListener('click', function(e) {
        addOption(
          document.form1.m60_codmater.value,
          document.form1.m60_descr.value
        );
      });

      optionsMateriais.addEventListener('dblclick', function excluirMaterial(e) {
        optionsMateriais.removeChild(e.target);
      });


      document.observe('dom:loaded', function () {

        oFiltroGrupoSubgrupo = new FiltroGrupoSubgrupo('filtroGrupoSubgrupo', true);
        $('btn_grupo_subgrupo').observe('click', function(){
          oFiltroGrupoSubgrupo.show();
        });

        $('competencia_inicial_ano').observe('change', function(){
          $('competencia_final_ano').value = $('competencia_inicial_ano').value;
        });

        oLancador = new DBLancador('Lancador');
        oLancador.setNomeInstancia('oLancador');
        oLancador.setLabelAncora('Departamento:');
        oLancador.setParametrosPesquisa('func_db_almoxdepto.php', ['coddepto','descrdepto']);
        oLancador.setTextoFieldset('Departamentos');
        oLancador.setGridHeight(100);
        oLancador.show($('lancador-departamentos'));

        $('agrupar').value = '1';
      });

      function js_emite() {
        var oForm               = $('frmDistribuicaoMateriais');
        var iAnoInicial         = oForm.competencia_inicial_ano.value;
        var iMesInicial         = oForm.competencia_inicial_mes.value;
        var iAnoFinal           = oForm.competencia_final_ano.value;
        var iMesFinal           = oForm.competencia_final_mes.value;
        var iDistribuicaoZerada = oForm.distribuicao_zerada.value;
        var iQuebraPagina       = oForm.quebra_pagina.value;
        var iAgrupar            = oForm.agrupar.value;
        var aGrupoSubgrupo      = oFiltroGrupoSubgrupo.getSelecionados();
        var aDepartamentos      = [];

        $(oLancador.getRegistros()).each(function(oRegistro){
          aDepartamentos.push(oRegistro.sCodigo);
        });

        var dadosMateriais = {
          material: Array.prototype.map.call(optionsMateriais.children, function(o) {
            return o.value;
          }).join(',')
        };


        /**
         * Valida campos vazios
         */
        if (empty(iMesInicial)) {

          alert('O campo Mês da Competência Inicial é de preenchimento obrigat?rio.');
          return;
        }
        if (parseInt(iMesInicial) > 12 || parseInt(iMesInicial) < 1) {

          alert('O Mês da Competência Inicial é inválido. Informe um mês entre 01 e 12.');
          return;
        }
        if (empty(iAnoInicial)) {

          alert('O campo Ano da Competência Inicial é de preenchimento obrigat?rio.');
          return;
        }
        if (iAnoInicial.length !== 4) {

          alert('O Ano da Compet?ncia Inicial é inválido. Informe um ano com 4 dígitos.');
          return;
        }
        if (empty(iMesFinal)) {

          alert('O campo Mês da Competência Final é de preenchimento obrigatório.');
          return;
        }
        if (parseInt(iMesFinal) > 12 || parseInt(iMesFinal) < 1) {

          alert('O Mês da Competência Final é inválido. Informe um mês entre 01 e 12.');
          return;
        }
        if (empty(iAnoFinal)) {

          alert('O campo Ano da Competência Final é de preenchimento obrigatório.');
          return;
        }
        if (iAnoFinal.length !== 4) {

          alert('O Ano da Competência Final é inválido. Informe um ano com 4 dígitos.');
          return;
        }
        if (parseInt(iMesInicial) > parseInt(iMesFinal)) {

          alert('A Competância Inicial não pode ser maior que a Competência Final.');
          return;
        }
        /**
         * Valida sele??o de ao menos um Grupo/Subgrupo
         */
        if (aGrupoSubgrupo.length == 0) {

          alert('Escolha ao menos um Grupo/Subgrupo.');
          return;
        }

        var sQuery  = '?';
            sQuery += 'mes_inicial='             + iMesInicial;
            sQuery += '&ano_inicial='            + iAnoInicial;
            sQuery += '&mes_final='              + iMesFinal;
            sQuery += '&ano_final='              + iAnoFinal;
            sQuery += '&distribuicao_zerada='    + iDistribuicaoZerada;
            sQuery += '&grupo_subgrupo='         + aGrupoSubgrupo.join(',');
            sQuery += '&departamentos='          + aDepartamentos.join(',');
            sQuery += '&quebra_pagina='          + iQuebraPagina;
            sQuery += '&agrupar_grupo_subgrupo=' + iAgrupar;
            sQuery += '&materiais='              + dadosMateriais.material;



        var iHeight = (screen.availHeight - 40);
        var iWidth  = (screen.availWidth  - 5);
        var sOpcoes = 'width=' + iWidth + ',height=' + iHeight + ',scrollbars=1,location=0';
        var oJanela = window.open(URL_RELATORIO + sQuery, '', sOpcoes);

        oJanela.moveTo(0, 0);
      }

    </script>

    <?php db_menu() ?>
  </body>
</html>
