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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_evt5001consulta_classe.php");

$evt5001consulta = new cl_evt5001consulta;
$evt5001consulta->rotulo->label();
if (isset($excluir)) {
  db_inicio_transacao();
  $evt5001consulta->excluir($rh218_sequencial);
  $evt5001consulta->erro(true,false);
  db_fim_transacao();
  if ($evt5001consulta->erro_status != "0") {
      echo "<script>location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?openPesquisa=true'</script>";
  }
}
if (isset($chavepesquisa)) {
    $result = $evt5001consulta->sql_record($evt5001consulta->sql_query($chavepesquisa,"*","rh218_sequencial", " rh218_sequencial = {$chavepesquisa} AND rh218_instit = ".db_getsession("DB_instit"))); 
    db_fieldsmemory($result,0);
}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/arrays.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBFileUpload.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
</head>
<body class='body-default'>
    <div class='container'>
        <form name="form1" method="post" action="">
            <?
                db_input('rh218_sequencial', 4, $Irh218_sequencial, true, 'hidden', 3, "")
            ?>
            <fieldset>
                <legend>Dados Consulta</legend>
            <center>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Trh218_perapurano ?>" >
                            <?= @$Lrh218_perapurano ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_perapurano', 4, $Irh218_perapurano, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_perapurmes ?>">
                            <?= @$Lrh218_perapurmes ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_perapurmes', 4, $Irh218_perapurmes, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_regist ?>">
                            <?= @$Lrh218_regist ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_regist', 10, $Irh218_regist, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_codcateg ?>">
                            <?= @$Lrh218_codcateg ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_codcateg', 10, $Irh218_codcateg, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_vrdescseg ?>">
                            <?= @$Lrh218_vrdescseg ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_vrdescseg', 20, $Irh218_vrdescseg, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_vrcpseg ?>">
                            <?= @$Lrh218_vrcpseg ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_vrcpseg', 20, $Irh218_vrcpseg, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="Diferença">
                            <b>Diferença</b>
                        </td>
                        <td>
                            <?
                            $diferenca = $rh218_vrdescseg - $rh218_vrcpseg;
                            db_input('diferenca', 20, 4, true, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh218_vlrbasecalc ?>">
                            <?= @$Lrh218_vlrbasecalc ?>
                        </td>
                        <td>
                            <?
                            db_input('rh218_vlrbasecalc', 20, 4, $Irh218_vlrbasecalc, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                </table>
            </center>
           </fieldset>
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
            <input name="excluir" type="submit" id="pesquisar" value="Excluir" onclick="js_pesquisa();" <?=(!empty($rh218_sequencial)?"":"disabled")?> >
        </form>
        <form name="formImport">
            <fieldset>
                <legend>Importação de Dados</legend>
                <fieldset class="separator">
                    <legend>Clique no botão "Arquivo" e selecione o arquivo a ser importado</legend>
                    <div id="ctnImportacao"></div>
                </fieldset>
            </fieldset>
            <input type="button" id="btnProcessar" value="Processar" disabled='disabled' />
        </form>
    </div>
<?php
  db_menu();
?>
<script type="text/javascript">

function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_evt5001consulta', 'func_evt5001consulta.php?funcao_js=parent.js_preenchepesquisa|rh218_sequencial', 'Pesquisa', true);
}

function js_preenchepesquisa(chave) {
    db_iframe_evt5001consulta.hide();
    <?
    echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    ?>
}

function limpar() {

    document.querySelector(".inputUploadFile").value = '';
}

function retornoEnvioArquivo(retorno) {

  if (retorno.error) {

    alert(retorno.error);
    $('btnProcessar').disabled = true;
    return false;
  }

  var extension = ['xml'];
  if (!extension.in_array(retorno.extension.toLowerCase())) {

    alert("Arquivo inválido.\nArquivo selecionado deve ser um arquivo com a extensão \"" + extension.join(', ') + "\".");
    $('btnProcessar').disabled = true;
    document.querySelector(".inputUploadFile").value = '';
    return false;
  }

  $('btnProcessar').disabled = false;
}


var fileUpload = new DBFileUpload( {callBack: retornoEnvioArquivo, labelButton : 'Arquivo'} );
    fileUpload.show($('ctnImportacao'));

document.querySelector(".inputUploadFile").addClassName('field-size5');

$('btnProcessar').addEventListener('click', function() {

    var paramentros = {
        'exec' : 'importarDadosXml',
        'sFile' : fileUpload.file,
        'sPath' : fileUpload.filePath,
        'evt' : 5001
    };

    new AjaxRequest( 'eso3_evtconsulta.RPC.php', paramentros, function ( retorno, lErro ) {

        alert(retorno.sMessage);
        if ( lErro ) {
            return false;
        }
        limpar();
        <?
        echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+retorno.sequencial";
        ?>
    }).setMessage('Enviando dados para ').execute();
});
</script>
</body>
</html>
<?
if (isset($openPesquisa)) {
  echo "<script>js_pesquisa();</script>";
}
?>
