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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_acordogrupo_classe.php");

$oRotulo = new rotulocampo;
$clacordogrupo = new cl_acordogrupo;
$clacordogrupo->rotulo->label();

$oRotulo->label("ac16_sequencial");
$oRotulo->label("ac16_resumoobjeto");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <?php
  db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
  db_app::load("widgets/windowAux.widget.js");
  ?>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
  <style>
    .fora {background-color: #d1f07c;}
    .select{
      width: calc(100% - 50px);
    }
    td.selectDescription{
      width: 40%;
      padding-left:50px;
    }
    .selectCell{
      width: 60%;
    }
  </style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<center>
  <form name="form1" target='relatorioacordosavencer' id="form1"  method="get" action="">
    <table style="margin-top: 50px;">
      <tr>
        <td>
          <fieldset>
            <legend>
              <b>Previsão e Execução das Receitas Orçamentárias - SIOPS</b>
            </legend>
            <br/>

            <table border="0" width="100%">

              <tr>
                <td class="selectDescription" colspan="1">
                  <b>Período:</b>
                </td>
                <td class="selectCell">
                  <?php
                  $aFiltros = array(
                    125 => "1° Bimestre",
                    126 => "2° Bimestre",
                    127 => "3° Bimestre",
                    128 => "4º Bimestre",
                    129 => "5º Bimestre",
                    130 => "6º Bimestre"
                    );
                  db_select("iBimestre", $aFiltros, true, 1, "class='select'");
                  ?>
                </td>
              </tr>

              <tr>
                <td class="selectDescription" colspan="1">
                  <b>Formato:</b>
                </td>
                <td class="selectCell">
                  <?php
                  $aFiltros = array(1 => "PDF", 2 => "CSV");
                  db_select("iFormato", $aFiltros, true, 1, "class='select'");
                  ?>
                </td>
              </tr>

            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td style="text-align: center;">
          <input name="emite" id="emite" type="button" value='Gerar Relatório' onclick="js_gerarRelatorio();">
        </td>
      </tr>
    </table>
  </form>
  <?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</center>
</body>
</html>
<script type="text/javascript">

  function js_gerarRelatorio(){

    var sUrl = 'con2_prevexecreceitasorcamentarias002.php?iFormato='+document.form1.iFormato.value+'&iBimestre='+document.form1.iBimestre.value;
    jan = window.open(sUrl, '','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);

  }

</script>
