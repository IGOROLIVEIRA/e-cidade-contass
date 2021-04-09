<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
require_once("libs/JSON.php");


$oGet       = db_utils::postMemory($_GET);
$iAnoSessao = db_getsession("DB_anousu");

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#CCCCCC" style="margin-top:30px;">
  <center>
    <form name='form1'>
      <fieldset style="width: 380px">
        <legend><b>Importação saldo CTB/EXT</b></legend>
        <table width="100%">
          <tr>
            <td nowrap="nowrap"><b>Ano:</b></td>
            <td>
              <?php
                db_input("iAnoSessao", 10, null, true, 'text', 3);
              ?>
            </td>
          </tr>
		  <tr>
			<td>
                <label for="contaCorrente"><b>Implantação Conta Corrente:</b></label><br>
			</td>
			<td>
				<select name="contaCorrente" id="contaCorrente" style="width: 84px;">
				<option value="1">Sim</option>
				<option value="0">Não</option>
				</select>
			</td>
		  </tr>
        </table>
      </fieldset>
      <input style="margin-top:10px;" type="button" name="btnProcessar" id="btnProcessar" value="Processar" onclick="processar()"/>
	  <br><br>
	  <div id='retorno'></div>
    </form>
  </center>
 </body>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</html>
<script type="text/javascript">
  function novoAjax(params, onComplete) {

    var request = new Ajax.Request('con4_importacaosaldoctbext.RPC.php', {
      method:'post',
      parameters:'json='+Object.toJSON(params),
      onComplete: onComplete
    });

  }

  function processar() {

	$('retorno').innerHTML = "";
    //var iAnoSessao = document.form1.iAnoSessao.value;

    /*if (!iAnoSessao) {
      alert("Campo ano obrigatório");
      return false;
    }*/

	let iContaCorrente = document.form1.contaCorrente.value;
	let exec = iContaCorrente == 1 ? 'importSaldoCtbExtContaCorrenteDetalhe' : 'importSaldoCtbExt';

    js_divCarregando('Aguarde', 'div_aguarde');
    var params = {
      exec: exec,
      ano: iAnoSessao,
    };

    novoAjax(params, function(e) {
      var oRetorno = JSON.parse(e.responseText);
      js_removeObj('div_aguarde');
		console.log(oRetorno.sArquivoLog);
	  if (oRetorno.sArquivoLog != '') {
		$('retorno').innerHTML = "<b>Contas não implantadas: </b>"
	  	$('retorno').innerHTML += "<a href='db_download.php?arquivo="+oRetorno.sArquivoLog+"'>"+oRetorno.sArquivoLog+"</a><br>";
	  }
      alert(oRetorno.message.urlDecode());
    });
  }

</script>
