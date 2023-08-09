<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

$clrotulo = new rotulocampo;
$db_opcao = 3;
$clrotulo->label("pc10_numero");
$clrotulo->label("pc67_motivo");

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<?
db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
db_app::load("widgets/windowAux.widget.js");
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
<style>

 .fora {background-color: #d1f07c;}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
  </table>
  <center>
    <table style="margin-top: 20px;">
      <tr>
        <td>
          <fieldset>
            <legend>
              <b>Manutenção de Registro de Preço</b>
            </legend>
            <table>
            <tr>
              <td nowrap title="Abertura" width="100%">
                 <?
                  db_ancora("<b>Abertura de Registro:</b>","js_pesquisarAbertura();",1);
                 ?>
              </td>
              <td>
                <?
                db_input('pc10_numeroabertura',10,$Ipc10_numero,true,'text',3)
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="Estimativa" width="100%">
                 <?
                  db_ancora("<b>Estimativa de Registro:</b>","js_pesquisarEstimativa();",1);
                 ?>
              </td>
              <td>
                <?
                db_input('pc10_numeroestimativa',10,$Ipc10_numero,true,'text',3)
                ?>
              </td>
            </tr>
          </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td style="text-align: center;">
          <input type='button' value='Pesquisar' onclick="js_confirma();">
        </td>
      </tr>
    </table>
  </center>
</body>
</html>
<?php
  db_menu( db_getsession("DB_id_usuario"),
           db_getsession("DB_modulo"),
           db_getsession("DB_anousu"),
           db_getsession("DB_instit") );
?>
<script>

function js_pesquisarEstimativa() {

  js_OpenJanelaIframe( '',
                     'db_iframe_solicitaestimativa',
                     'func_alterasolicitaestimativa.php?funcao_js=parent.js_mostraEstimativa|pc10_numero&departamento=true',
                     'Pesquisa de Estimativa de Registro de Preço',
                     true );
}

function js_mostraEstimativa(chave1,chave2){

  $('pc10_numeroestimativa').value = chave1;
  $('pc10_numeroabertura').value = "";
  db_iframe_solicitaestimativa.hide();
}

function js_pesquisarAbertura() {

  js_OpenJanelaIframe( '',
                     'db_iframe_solicitaabertura',
                     'func_alterarsolicitaregistropreco.php?funcao_js=parent.js_mostraAbertura|pc54_solicita&departamento=true',
                     'Pesquisa de Abertura de Registro de Preço',
                     true );
}

function js_mostraAbertura(chave1,chave2){

  $('pc10_numeroabertura').value = chave1;
  $('pc10_numeroestimativa').value = "";
  db_iframe_solicitaabertura.hide();
}

function js_confirma(){

  if($('pc10_numeroestimativa').value === "" && $('pc10_numeroabertura').value === ""){
    alert("Usuário: Busque uma abertura ou estimativa para alteração!");
    return;
  }

  var pc10_numero = $('pc10_numeroabertura').value;
  var sUrl  = 'com4_alteraraberturaregistro002.php';

  if($('pc10_numeroabertura').value === "" ){
    var pc10_numero = $('pc10_numeroestimativa').value;
    var sUrl  = 'com4_alteraestimativaregistro002.php';
  }

  sUrl += '?pc10_numero='+pc10_numero;

   js_OpenJanelaIframe('CurrentWindow.corpo',
                        'db_iframe_processos_filtrados',
                        sUrl,
                        'Processos de Compras encontrados',
                        true
                       );
}
 
</script>