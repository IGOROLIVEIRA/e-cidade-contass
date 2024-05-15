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
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_empempenho_classe.php");

//---  parser POST/GET
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

//---- instancia classes
$clempempenho = new cl_empempenho;
//$aux = new cl_arquivo_auxiliar;
$cliframe_seleciona = new cl_iframe_seleciona;
$clrotulo = new rotulocampo;

//--- cria rotulos e labels
$clempempenho->rotulo->label();
//----
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC bgcolor="#CCCCCC"  >
<table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>  &nbsp; </td>
    </tr>
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <form name="form1" method="post" action="">
                    <table align="center">
                    <table border="0" align="">
                        <tr>
                            <td>
                                <strong>Opções:</strong>
                                <select name="ver">
                                    <option  value="com">Com os Tipos de Compra selecionados</option>
                                    <option  value="sem">Sem os Tipos de Compra selecionadas</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <strong>Filtar por:</strong>
                                <select id="filtrapor">
                                    <option  value="acordo">Contrato</option>
                                    <option  value="tipocom">Tipo de compra</option>
                                    <option  value="lic">Licitação</option>
                                </select>
                            </td>
                        </tr>
                        <table border="0">
                        <tr>
                            <td nowrap>

                                <?
                                $aux = new cl_arquivo_auxiliar;
                                $aux->nome_botao     = "db_tipocom";
                                $aux->cabecalho = "<strong> Tipo de Compra </strong>";
                                $aux->codigo = "pc50_codcom"; //chave de retorno da func
                                $aux->descr  = "pc50_descr";   //chave de retorno
                                $aux->nomeobjeto = 'tipocom';
                                $aux->funcao_js = 'js_mostra';
                                $aux->funcao_js_hide = 'js_mostra1';
                                $aux->sql_exec  = "";
                                $aux->func_arquivo = "func_pctipocompra.php";  //func a executar
                                $aux->nomeiframe = "db_iframe_pctipocompra";
                                $aux->localjan = "";
                                $aux->onclick = "";
                                $aux->db_opcao = 2;
                                $aux->tipo = 2;
                                $aux->top = 1;
                                $aux->linhas = 10;
                                $aux->vwhidth = 400;
                                $aux->funcao_gera_formulario();
                                ?>
                            </td>

                            <td nowrap><table border="0">
                                <?
                                $aux2 = new cl_arquivo_auxiliar;
                                $aux2->nome_botao     = "db_liclicita";
                                $aux2->cabecalho = "<strong> Licitação </strong>";
                                $aux2->codigo = "l20_codigo"; //chave de retorno da func
                                $aux2->descr  = "l20_objeto";   //chave de retorno
                                $aux2->nomeobjeto = 'liclicita';
                                $aux2->funcao_js = 'js_mostralic';
                                $aux2->funcao_js_hide = 'js_mostralic1';
                                $aux2->sql_exec  = "";
                                $aux2->func_arquivo = "func_liclicita.php";  //func a executar
                                $aux2->nomeiframe = "db_iframe_liclicita";
                                $aux2->localjan = "";
                                $aux2->onclick = "";
                                $aux2->db_opcao = 2;
                                $aux2->tipo = 2;
                                $aux2->top = 1;
                                $aux2->linhas = 10;
                                $aux2->vwhidth = 400;
                                $aux2->funcao_gera_formulario();
                                ?>
                            </td>

                            <td nowrap><table border="0">
                                 <?
                                 $aux2 = new cl_arquivo_auxiliar;
                                 $aux2->nome_botao     = "db_acordo";
                                 $aux2->cabecalho = "<strong> Contrato </strong>";
                                 $aux2->codigo = "ac16_sequencial"; //chave de retorno da func
                                 $aux2->descr  = "ac16_resumoobjeto";   //chave de retorno
                                 $aux2->nomeobjeto = 'acordo';
                                 $aux2->funcao_js = 'js_mostraacordo';
                                 $aux2->funcao_js_hide = 'js_mostraacordo1';
                                 $aux2->sql_exec  = "";
                                 $aux2->func_arquivo = "func_acordoinstit.php";  //func a executar
                                 $aux2->nomeiframe = "db_iframe_acordo";
                                 $aux2->localjan = "";
                                 $aux2->onclick = "";
                                 $aux2->db_opcao = 2;
                                 $aux2->tipo = 2;
                                 $aux2->top = 1;
                                 $aux2->linhas = 10;
                                 $aux2->vwhidth = 400;
                                 $aux2->funcao_gera_formulario();
                                 ?>
                            </td>
                        </tr>
                    </table>
                    <table border="0" width="48%">
                        <tr>
                            <td nowrap colspan=3>
                            </td>
                        </tr>
                        <td nowrap>
                        </td>
                        <td nowrap>
                        </td>
                        <td>
                        </td>
                        </tr>
                    </table>
            </center>
            </table>
            </form>

        </td>
    </tr>
</table>
<script>

    CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_acordo').style.display = 'inline';
    CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_tipocom').style.display = 'none';
    CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_liclicita').style.display = 'none';

    CurrentWindow.corpo.iframe_g4.document.getElementById('filtrapor').onchange=function(){
        switch (CurrentWindow.corpo.iframe_g4.document.getElementById('filtrapor').value) {
          case 'lic' :
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_tipocom').style.display = 'none';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_acordo').style.display = 'none';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_liclicita').style.display = 'inline';
          break;

          case 'tipocom' :
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_tipocom').style.display = 'inline';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_acordo').style.display = 'none';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_liclicita').style.display = 'none';
          break;

          case 'acordo' :
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_tipocom').style.display = 'none';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_acordo').style.display = 'inline';
            CurrentWindow.corpo.iframe_g4.document.getElementById('fieldset_liclicita').style.display = 'none';
          break;
        }

    }

</script>

</body>
</html>
