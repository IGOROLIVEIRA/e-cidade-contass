<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e80_data");
$clrotulo->label("e83_codtipo");
$clrotulo->label("e80_codage");
$clrotulo->label("e50_codord");
$clrotulo->label("e50_numemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e60_codemp");
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("e60_emiss");
$clrotulo->label("e82_codord");
$clrotulo->label("e87_descgera");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
$clrotulo->label("e21_sequencial");
$clrotulo->label("e21_descricao");
$db_opcao = 1;
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

    <style type="text/css">
    #fieldset_credores, #fieldset_saltes, #fieldset_retencoes, #fieldset_recursos {
    	width: 500px;
    	text-align: center;
    }
    #fieldset_credores table, #fieldset_saltes table, #fieldset_retencoes table, #fieldset_recursos table {
      margin: 0 auto;
    }
    </style>
  </head>
  <body bgcolor=#CCCCCC >
    <form name='form1' id="form1">
			<fieldset style="margin:25px auto 0 auto; width: 500px;">
			<legend>
				<strong>Relatório</strong>
            </legend>
            <fieldset style="margin:0 auto 0 auto; width: 500px;">
            <legend>
                <strong>Datas</strong>
            </legend>
			<table border="0" align="center">
                <tr>
                    <td>
                        <b>Data Inicial:</b>
                    </td>
                    <td>
                        <?
                            db_inputdata("datainicial",null,null,null,true,"text", 1);
                        ?>
                            <b>Data Final:</b>
                        <?
                            db_inputdata("datafinal",null,null,null,true,"text", 1);
                        ?>
                    </td>
                </tr>
            </table>
            </fieldset>  
            <table>
                <tr>
					        <td>
                    <?
                        $oFiltroConta = new cl_arquivo_auxiliar;
                      $oFiltroConta->cabecalho            = "<strong>Contas</strong>";
                      $oFiltroConta->codigo               = "k13_conta";
                      $oFiltroConta->descr                = "k13_descr";
                      $oFiltroConta->nomeobjeto           = 'saltes';
                      $oFiltroConta->funcao_js            = 'js_mostraconta';
                      $oFiltroConta->funcao_js_hide       = 'js_mostraconta1';
                      $oFiltroConta->sql_exec  						= "";
                      $oFiltroConta->func_arquivo 			  = "func_saltes.php";
                      $oFiltroConta->nomeiframe           = "db_iframe_saltes";
                      $oFiltroConta->vwidth               = '400';
                      $oFiltroConta->localjan             = "";
                      $oFiltroConta->db_opcao             = 2;
                      $oFiltroConta->tipo                 = 2;
                      $oFiltroConta->top                  = 0;
                      $oFiltroConta->linhas               = 5;
                      $oFiltroConta->nome_botao           = 'lancarConta';
                      $oFiltroConta->lFuncaoPersonalizada = true;
                      $oFiltroConta->obrigarselecao       = false;
                      $oFiltroConta->funcao_gera_formulario();
                    ?>
				  	      </td>
				        </tr>
                <tr>
                  <td>
                    <b>Tipo:</b>
                  </td>
                  <td>
                    <?
                      $aTipo  = array("s" => "Sintético",
                                      "a" => "Analítico");
                      db_select("tipo", $aTipo,true,1,"style='width:10em'");
                    ?>
                  </td>
                </tr>
				        <tr>
                  <td style='text-align:center' colspan="3">
                    <input type='button' value='Emitir' onclick='js_emitir()'>
                  </td>
				        </tr>
            </table>
            </fieldset>
    </form>
  </body>
</html>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script> 
function js_emitir() 
{
  if ($F('datainicial') == "") {
    alert('A Data do Inicial do período deve ser informada!');
    return false;
  }
  if ($F('datafinal') == "") {
    alert('A Data do Final do período deve ser informada!');
    return false;
  }
  const dataInicial = new Date($F('datainicial'));
  const dataFinal = new Date($F('datafinal'));

  $novaDataIni = $F('datainicial').split('/');
  $novaDataFim = $F('datafinal').split('/');
 
  if ($novaDataIni[2] != $novaDataFim[2]) {
    alert('O ano inicial e final devem ser iguais.');
    return false;
  }

  if (dataInicial > dataFinal) {
    alert('A Data Inicial deve ser menor que à Data do Final!');
    return false;
  }
  var oParametro         = new Object();
  oParametro.datainicial = $F('datainicial');
  oParametro.datafinal   = $F('datafinal');
  oParametro.sContas     = js_campo_recebe_valores_saltes ();
  oParametro.iTipo       = $F('tipo');

  var sFiltros = JSON.stringify(oParametro);
  sFiltros     = sFiltros.replace("(","");
  sFiltros     = sFiltros.replace(")","");
 
  var sUrlRelatorio = "cai2_transfretorc002.php?sFiltros="+sFiltros;
  var jan           = window.open(sUrlRelatorio,
                                  '',
                                  'width='+(screen.availWidth-5)+
                                  ',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}
</script>
