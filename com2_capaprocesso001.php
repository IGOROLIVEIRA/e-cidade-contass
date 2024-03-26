<?
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("pc80_resumo");
$clrotulo->label("pc80_codproc");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC >

<center>
    <div style="margin-top: 20px">
        <form name="form1" method="post">
            <fieldset style="width: 550;">
                <legend><strong>Imprimir Capa de Processo</strong></legend>
                <table >
                    <tr>
                        <td nowrap="nowrap" title="<?=$Tpc80_resumo?>">
                            <b><? db_ancora("Processos de Compra: ","js_pesquisa_pcproc(true);",1);
                                  db_input("pc80_codproc",10,$Ipc80_codproc,true,"text",3,"");
                            ?></b>
                        </td>
                        <td align="left" nowrap="nowrap">
                            <?
                            db_input("pc80_resumo",80,$Ipc80_resumo,true,"text",1,"onchange='js_pesquisa_pcproc(false);'");
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <input name="processar" type="button" onclick='js_emite();'  value="Emitir">
        </form>
    </div>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
    function js_emite() {
        if (document.form1.pc80_codproc.value != "") {
            query = 'pc80_codproc='+document.form1.pc80_codproc.value;
            window.open('com2_capaprocesso002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        }
    }

    function js_pesquisa_pcproc(mostra) {
        if (mostra) {
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc|pc80_resumo','Pesquisa',true);
        }
    }

    function js_mostrapcproc1(chave1,chave2) {
        document.form1.pc80_codproc.value = chave1;
        document.form1.pc80_resumo.value = chave2;
        db_iframe_pcproc.hide();
    }

</script>
</body>
</html>
