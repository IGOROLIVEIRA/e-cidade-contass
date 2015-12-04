<?php
/**
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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

$oGet     = db_utils::postMemory($_GET);
$oPost    = db_utils::postMemory($_POST);

if ( isset($oGet->sAcesso) ) {

  if ( $oGet->sAcesso == "substituicao" ) {

    require("pes4_assentamentosubstituicao001.php");
  } else {
    require("pes4_lancamentoassentamento001.php");
  }

  exit;

}

/**
 * Pesquisa os tipos de Assentamento
 */
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php db_app::load("estilos.css, scripts.js"); ?>
  </head>
  <body class="body-default">
   <?php db_menu(); ?>
  </body>
</html>
<script>

var oJanela = js_OpenJanelaIframe(
  "",
  "qualquer",
  "func_tipoasse.php?sAcao=lancamento&funcao_js=parent.redirecionar|h12_natureza|h12_codigo",
  "Tipos de Assentamento com Lançamentos",
  true
);
oJanela.setModal(true);

function redirecionar( iNatureza, iTipoAssentamento ) {

  const SUBSTITUICAO = 2;
  const PADRAO       = 1;

  if ( iNatureza == PADRAO ) {
    window.location.href = 'pes4_assentaloteregistroponto001.php?sAcesso=padrao&iTipoAssentamento='+iTipoAssentamento;
    return;
  } else if (iNatureza == SUBSTITUICAO) {
    window.location.href = 'pes4_assentaloteregistroponto001.php?sAcesso=substituicao';
    return;
  }
  return false;
}
</script>
