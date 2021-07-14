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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo();
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
<body>
<center>
    <form name="form1" method="post" action="">

        <fieldset style="width: 480px;">
            <legend><strong>Relatório de Recursos Orçamentarios</strong></legend>

            <table>
                <tr>
                    <td style="font-weight: bolder;" >
                        <? db_ancora("Processos de Compra : ","js_pesquisapc80_codproc(true);",1);?>
                    </td>
                    <td>
                        <?
                        db_input("pc80_codproc", 10, $Ipc80_codproc,true,"text",4,"onchange='js_pesquisapc80_codproc(false);'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Tipo de Relatório</strong>
                    </td>
                    <td>
                        <?$iTipoRelatorio = array(
                            1 =>"Solicitação de Parecer Contábil",
                            2 =>"Solicitação de Disponibilização Financeira",
                            3 =>"Declaração de Recursos Orçamentários");
                        db_select("tiporelatorio",$iTipoRelatorio,true,1,"");
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
    <br>
    <input type="button" name="btnEmitir" id="btnEmitir" value="Emitir" onclick="js_emitirProcesso();">
</center>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"),
    db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
</body>
</html>

<script>

    function js_pesquisapc80_codproc(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_mostrapcproc1|pc80_codproc','Pesquisa',true);
        }else{
            if(document.form1.pc80_codproc.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?pesquisa_chave='+document.form1.pc80_codproc.value+'&funcao_js=parent.js_mostrapcproc','Pesquisa',false);
            }else{
                document.form1.pc80_codproc.value = '';
            }
        }
    }
    function js_mostrapcproc(chave,erro){
        if(erro==true){
            document.form1.pc80_codproc.focus();
            document.form1.pc80_codproc.value = '';
        }
    }
    function js_mostrapcproc1(chave1,x){
        document.form1.pc80_codproc.value = chave1;
        db_iframe_pcproc.hide();
    }

    /**
     * Validamos as informações do formulário e reemitimos o documento do processo de compra
     */
    function js_emitirProcesso() {
        let tiporelatorio = $F('tiporelatorio');

        if(tiporelatorio == 1){

        }

        if(tiporelatorio == 2){

        }

        if(tiporelatorio == 3){
            processodecompras = $F('pc80_codproc');

            if(processodecompras == ""){
                alert("Processo de Compras não informado.");
                return;
            }

            Filtros = "";
            Filtros += "processodecompras="+processodecompras;

            var jan = window.open('com2_relatorioorcamentario003.php?'+Filtros, '', 'location=0, width='+(screen.availWidth - 5)+
                'width='+(screen.availWidth - 5)+', scrollbars=1');
            jan.moveTo(0, 0);
        }

    }

</script>