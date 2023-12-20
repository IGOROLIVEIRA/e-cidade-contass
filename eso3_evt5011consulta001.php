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
require_once("classes/db_evt5011consulta_classe.php");

$evt5011consulta = new cl_evt5011consulta;
$evt5011consulta->rotulo->label();
if (isset($excluir)) {
  db_inicio_transacao();
  $evt5011consulta->excluir($rh219_sequencial);
  $evt5011consulta->erro(true,false);
  db_fim_transacao();
  if ($evt5011consulta->erro_status != "0") {
      echo "<script>location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "'</script>";
  }
}
if (isset($chavepesquisa)) {
    $result = $evt5011consulta->sql_record($evt5011consulta->sql_query($chavepesquisa,"*","rh219_sequencial", " rh219_sequencial = {$chavepesquisa} AND rh219_instit = ".db_getsession("DB_instit")));
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
                db_input('rh219_sequencial', 4, $Irh219_sequencial, true, 'hidden', 3, "")
            ?>
            <fieldset>
                <legend>Dados Consulta</legend>
            <center>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Trh219_perapurano ?>" >
                            <?= @$Lrh219_perapurano ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_perapurano', 4, $Irh219_perapurano, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_perapurmes ?>">
                            <?= @$Lrh219_perapurmes ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_perapurmes', 4, $Irh219_perapurmes, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_indapuracao ?>">
                            <?= @$Lrh219_indapuracao ?>
                        </td>
                        <td>
                            <?
                              $arr_indapuracao = array(1 => 'Mensal', 2 => 'Anual (13° salário)', '' => 'Sem Filtro');
                              db_select("rh219_indapuracao", $arr_indapuracao, true, 3, "", "chave_rh219_indapuracao");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_classtrib ?>">
                            <?= @$Lrh219_classtrib ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_classtrib', 10, $Irh219_classtrib, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_cnaeprep ?>">
                            <?= @$Lrh219_cnaeprep ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_cnaeprep', 20, $Irh219_cnaeprep, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_aliqrat ?>">
                            <?= @$Lrh219_aliqrat ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_aliqrat', 20, $Irh219_aliqrat, true, 'text', 3, "")
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_fap ?>">
                            <?= @$Lrh219_fap ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_fap', 20, 4, $Irh219_fap, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_aliqratajust ?>">
                            <?= @$Lrh219_aliqratajust ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_aliqratajust', 20, 4, $Irh219_aliqratajust, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_fpas ?>">
                            <?= @$Lrh219_fpas ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_fpas', 20, $Irh219_fpas, true, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                </table>
            </center>
           </fieldset>
           <fieldset>
            <legend></legend>
            <center>
                <table border="0">
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrbccp00 ?>">
                            <?= @$Lrh219_vrbccp00 ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrbccp00', 20, 4, $Irh219_vrbccp00, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_baseaposentadoria ?>">
                            <?= @$Lrh219_baseaposentadoria ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_baseaposentadoria', 20, 4, $Irh219_baseaposentadoria, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrsalfam ?>">
                            <?= @$Lrh219_vrsalfam ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrsalfam', 20, 4, $Irh219_vrsalfam, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrsalmat ?>">
                            <?= @$Lrh219_vrsalmat ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrsalmat', 20, 4, $Irh219_vrsalmat, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrdesccp ?>">
                            <?= @$Lrh219_vrdesccp ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrdesccp', 20, 4, $Irh219_vrdesccp, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrcpseg ?>">
                            <?= @$Lrh219_vrcpseg ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrcpseg', 20, 4, $Irh219_vrcpseg, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?= @$Trh219_vrcr ?>">
                            <?= @$Lrh219_vrcr ?>
                        </td>
                        <td>
                            <?
                            db_input('rh219_vrcr', 20, 4, $Irh219_vrcr, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="Valor Devido à Previdência">
                            <strong>Valor Devido à Previdência:</strong>
                        </td>
                        <td>
                            <?
                            $vl_devido = $rh219_vrcr + $rh219_vrcpseg - $rh219_vrsalfam - $rh219_vrsalmat;
                            db_input('vl_devido', 20, 4, $Irh219_vrcr, 'text', 3, "");
                            ?>
                        </td>
                    </tr>
                </table>
            </center>
        </fieldset>
            <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
            <input name="excluir" type="submit" id="pesquisar" value="Excluir" onclick="js_pesquisa();" <?=(!empty($rh219_sequencial)?"":"disabled")?> >
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
    js_OpenJanelaIframe('top.corpo', 'db_iframe_evt5011consulta', 'func_evt5011consulta.php?funcao_js=parent.js_preenchepesquisa|rh219_sequencial', 'Pesquisa', true);
}

function js_preenchepesquisa(chave) {
    db_iframe_evt5011consulta.hide();
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
        'evt' : 5011
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
echo "<script>js_pesquisa();</script>";
?>
