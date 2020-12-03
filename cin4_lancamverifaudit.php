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
include("dbforms/db_funcoes.php");
include("classes/db_processoaudit_classe.php");
db_postmemory($HTTP_POST_VARS);

$clprocessoaudit = new cl_processoaudit;
$clrotulo        = new rotulocampo;
$clrotulo->label('ci03_codproc');
$clrotulo->label('ci03_objaudit');

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
                <b>Lançamento de Verificações</b>
                </legend>
                <table>
                    <form name="form1">
                        <tr>
                            <td align="left">
                                <? db_ancora("Processo de Auditoria","js_pesquisaProcessoAuditoria(true);",1);  ?>
                            </td>
                            <td colspan="2">
                                <? db_input('ci03_codproc',10,$Ici03_codproc,true,'text',1," onchange='js_pesquisaProcessoAuditoria(false);'");
                                   db_input('ci03_objaudit',80,$Ic50_descr,true,'text',3); ?>
                            </td>
                            <input type="hidden" name="ci03_numproc" id="ci03_numproc" value="">
                            <input type="hidden" name="ci03_anoproc" id="ci03_anoproc" value="">
                        </tr>
                    </form>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br>
<center>
    <input  name="processar" id="processar" type="button" value="Processar" onclick="js_processa();">
</center>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

function js_pesquisaProcessoAuditoria(lMostra) {

    if (lMostra) {
        js_OpenJanelaIframe('top.corpo','db_iframe_processoaudit','func_processoaudit.php?funcao_js=parent.js_mostraProcessoAuditoria1|ci03_codproc|ci03_objaudit|ci03_numproc|ci03_anoproc','Pesquisa',true);
    } else {
        js_OpenJanelaIframe('top.corpo','db_iframe_processoaudit','func_processoaudit.php?pesquisa_chave='+document.form1.ci03_codproc.value+'&objetivo=true&funcao_js=parent.js_mostraProcessoAuditoria','Pesquisa',false);
    }
}

function js_mostraProcessoAuditoria(chave, chave1, chave2, erro) {
    
    document.form1.ci03_objaudit.value = chave;
    document.getElementById('ci03_numproc').setAttribute('value', chave1);
    document.getElementById('ci03_anoproc').setAttribute('value', chave2);
    if(erro == true) {
        document.form1.ci03_codproc.focus();
        document.form1.ci03_objaudit = '';
    }
    
}

function js_mostraProcessoAuditoria1(chave1, chave2, chave3, chave4) {
    
    document.form1.ci03_codproc.value = chave1;
    document.form1.ci03_objaudit.value = chave2;
    document.getElementById('ci03_numproc').setAttribute('value', chave3);
    document.getElementById('ci03_anoproc').setAttribute('value', chave4);
    db_iframe_processoaudit.hide();

}

function js_processa() {

    const sUrl  = 'cin4_lancamverifaudit001.php';
    var sParams = '';
    
    if (document.form1.ci03_codproc.value == null || document.form1.ci03_codproc.value == "") {
        alert("Informe o Processo de Auditoria");
        return;
    }

    sParams = '?ci03_codproc='+document.form1.ci03_codproc.value;
    sParams += '&ci03_numproc='+document.form1.ci03_numproc.value;
    sParams += '&ci03_anoproc='+document.form1.ci03_anoproc.value;

    document.location.href = sUrl + sParams;

}

</script>