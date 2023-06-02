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
require_once("classes/db_solicita_classe.php");
$clsolicita = new cl_solicita;
$clrotulo = new rotulocampo;
$clsolicita->rotulo->label();
?>

    <html>
    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Expires" CONTENT="0">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <fieldset style="width: 360px;margin-top: 35px;margin-left: 30%;">
        <legend><strong> Relatório de Solicitação</strong></legend>
        <table >
            <form name="form1" method="post" action="">

                <tr >
                    <td>
                        <?
                        db_ancora(@$Lpc10_numero,"js_pesquisapc10_numero(true);",1);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('pc10_numero',8,$Ipc10_numero,true,"text",1,"onchange='js_pesquisapc10_numero(false);'");
                        ?>
                    </td>
                </tr>
            </form>
        </table>
    </fieldset>
    <input style="margin-left: 41%;margin-top: 10px;" name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
    <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
    </body>
    </html>

    <script>
        function js_emite(){
            jan = window.open('com2_emitesolicitacao003.php?ini='+document.form1.pc10_numero.value+'&fim='+document.form1.pc10_numero.value+'','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
            jan.moveTo(0,0);
        }

        function js_pesquisapc10_numero(mostra){
            qry = "&nada=true";
            if(mostra==true){
                js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_mostrapcorcamitem1|pc10_numero'+qry,'Pesquisa',true);
            }else{
                if(document.form1.pc10_numero.value!=""){
                    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_mostrapcorcamitem&pesquisa_chave='+document.form1.pc10_numero.value+qry,'Pesquisa',false);
                }else{
                    document.form1.pc10_numero.value = "";
                }
            }
        }
        function js_mostrapcorcamitem1(chave1,chave2){
            document.form1.pc10_numero.value = chave1;
            db_iframe_solicita.hide();
        }
        function js_mostrapcorcamitem(chave1,erro){
            if(erro==true){
                document.form1.pc10_numero.value = "";
            }
        }
    </script>

<?
if(isset($ini)){
    echo "<script>
       js_emite();
       </script>";
}
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

?>
