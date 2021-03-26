<?
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
include("classes/db_tipoquestaoaudit_classe.php");

$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$clrotulo           = new rotulocampo;
$clrotulo->label('ci01_codtipo');
$clrotulo->label('ci01_tipoaudit');


db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<br>
<table align="center" cellspacing='0' border="0">
    <tr>
        <td>
            <fieldset>
                <legend>
                <b>Questões Cadastradas</b>
                </legend>
                <table>
                    <form name="form1">
                        <tr>
                            <td align="left">
                                <? db_ancora(@$Lci01_codtipo,"js_pesquisaTipoQuestao(true);",1);  ?>
                            </td>
                            <td colspan="2">
                                <? db_input('ci01_codtipo',10,$Ici01_codtipo,true,'text',1," onchange='js_pesquisaTipoQuestao(false);'");
                                   db_input('ci01_tipoaudit',80,$Ic50_descr,true,'text',3); ?>
                            </td>
                        </tr>
                    </form>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br>
<center>
    <input  name="emite2" id="emite2" type="button" value="Emitir Relatório" onclick="js_emite();">
</center>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

function js_pesquisaTipoQuestao(lMostra) {

    if (lMostra) {
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?funcao_js=parent.js_mostraTipoQuestao1|ci01_codtipo|ci01_tipoaudit','Pesquisa',true);
    } else {
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?pesquisa_chave='+document.form1.ci01_codtipo.value+'&tipo=true&funcao_js=parent.js_mostraTipoQuestao','Pesquisa',false);
    }
}

function js_mostraTipoQuestao(chave, erro) {

    document.form1.ci01_tipoaudit.value = chave;
    if(erro == true) {
        document.form1.ci01_codtipo.focus();
        document.form1.ci01_tipoaudit = '';
    }

}

function js_mostraTipoQuestao1(chave1, chave2) {

    document.form1.ci01_codtipo.value = chave1;
    document.form1.ci01_tipoaudit.value = chave2;
    db_iframe_tipoquestaoaudit.hide();

}

function js_emite() {

    var sUrl   = 'cin2_relquestaoaudit002.php';
    var sQuery = '';

    if (document.form1.ci01_codtipo.value != null) {
        sQuery = '?iCodTipo='+document.form1.ci01_codtipo.value;
    }

    jan = window.open(sUrl+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');

    jan.moveTo(0,0);

}

</script>
