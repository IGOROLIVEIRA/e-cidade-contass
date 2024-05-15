<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_pcparam_classe.php");
$clpcparam = new cl_pcparam;
$clrotulo = new rotulocampo;
$clrotulo->label("pc10_numero");
$db_opcao = 1;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height='18'  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

<table valign="top" marginwidth="0" width="300" border="0" cellspacing="0" cellpadding="0" style="margin-top: 15px;" align="center">
<tr align="center">
<td>
	<fieldset>
		<legend><b>Vigência Registro Preço</b></legend>

	<table valign="top" marginwidth="0" width="300" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td  align="center" valign="top" bgcolor="#CCCCCC">
    <form name='form1'>
    <table>
      <tr id="linha_ano">
        <td nowrap title="<?=@$Tl20_anousu?>">
            <strong>Exercício: </strong>
        </td>
        <td>
            <?php db_input('anousu',10,$Il20_anousu,true,'text',$db_opcao,"onkeyup='ocultarInputPeriodo()'","anousu")  ?>
        </td>
    </tr>
    <tr id="linha_periodo">
        <td nowrap align="left"><strong>Período:</strong></td>
        <td align="left" nowrap>
            <?php
            db_inputdata('periodoInicio', @$dia, @$mes, @$ano, true, 'text', 1, "onkeydown='ocultarInputAno()'","","","none","ocultarInputAno();");
            echo " <b>até:</b> ";
            db_inputdata('periodoFim', @$dia2, @$mes2, @$ano2, true, 'text', 1, "onkeydown='ocultarInputAno()'","","","none","ocultarInputAno();");
            ?>
        </td>
    </tr>
    <tr>
        <td colspan='4' align='center'>
            <input name='pesquisar' type='button' value='Gerar relatório' onclick='js_emite();'>
            <input name='limpar' type='button' value='Limpar' onclick='limparInputs();'>
        </td>
    </tr>
    </table>
    </form>
  </td>
 </tr>
</table>
</fieldset>
</td>
</tr>
</table>
    <?php
      db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
</body>
</html>

<script>
    function ocultarInputAno() {
        document.getElementById('linha_ano').style.display = 'none'
    }

    function ocultarInputPeriodo() {
        document.getElementById('linha_periodo').style.display = 'none'
    }

    function limparInputs() {
        document.getElementById('linha_ano').style.display = '';
        document.getElementById('linha_periodo').style.display = '';

        document.getElementById('anousu').value = '';
        document.getElementById('periodoInicio').value = '';
        document.getElementById('periodoFim').value = '';

    }


    function js_emite(){

        form = document.form1;

        if (form.anousu.value == ""
            && (document.getElementById('linha_periodo').style.display === 'none'
            || document.getElementById('linha_ano').style.display !== "none" )) {
         alert("Administrador: \n \ncampo Ano deve ser informado");
         exit;
        }

        if (form.periodoInicio.value === ""
            && (document.getElementById('linha_ano').style.display === 'none'
            && form.periodoFim.value == '')) {
            alert("Administrador: \n \ncampo Período Inicio deve ser informado");
            exit;
        }

        if (form.periodoFim.value === ""
            && (document.getElementById('linha_ano').style.display === "none"
            && form.periodoInicio.value == '')) {
            alert("Administrador: \n \ncampo Período Fim deve ser informado");
            exit;
        }

        let query = '1=1';

        if (form.anousu.value !== "") {
            query+="&anousu="+form.anousu.value;
        }

        if (form.periodoInicio.value !== "") {

            query+="&periodoInicio="+form.periodoInicio.value;
        }
        if (form.periodoFim.value !== "") {

            query+="&periodoFim="+form.periodoFim.value;
        }

        jan = window.open('com2_vigenciaregpreco002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
        jan.moveTo(0, 0);
    }

</script>
