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
include("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_liborcamento.php");
include("dbforms/db_classesgenericas.php");

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <form name="form1" method="post" action="con2_lrfreceitacorrente002.php">
    <table align="center" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=3 class='table_header'>
          <b>Anexo III - Receita Corrente Líquida</b>
        </td>
      </tr>
      <tr>
        <td>
          <fieldset>
            <legend><b>Filtros</b></legend>
            <table align="center">
              <tr>
                <td colspan=2 nowrap><b>Tipo : </b>
                  <select name=tipoRelatorio align='right' onchange="js_validaTipoRelatorio(this.value)">
                    <option value='arrecadado'>Arrecadado</option>
                    <option value='orcado'>Orçado</option>
                  </select>
              </tr>
              <tr id="selectPeriodoRow">
                <td colspan=2 nowrap><b>Período :</b>
                  <select name="o116_periodo" id="selectPeriodo">
                    <option value="17">Janeiro </option>
                    <option value="18">Fevereiro </option>
                    <option value="19">Março </option>
                    <option value="20">Abril </option>
                    <option value="21">Maio </option>
                    <option value="22">Junho </option>
                    <option value="23">Julho </option>
                    <option value="24">Agosto </option>
                    <option value="25">Setembro </option>
                    <option value="26">Outubro </option>
                    <option value="27">Novembro </option>
                    <option value="28">Dezembro </option>
                  </select>
                </td>
              </tr>
            </table>
          </fieldset>
          <table align="center">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center" colspan="2">
                <input name="emite" id="emite" type="button" value="Imprimir" onclick="js_emite();">
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
  <?
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
  <script>
    function js_emite() {

      obj = document.form1;
      periodo = obj.o116_periodo.value;
      tipoRelatorio = obj.tipoRelatorio.value;

      data_ini = '';
      data_fin = '';
      jan = window.open('con2_lrfreceitacorrente002_novo.php?dtini=' + data_ini + '&dtfin=' + data_fin + '&periodo=' + periodo + '&tipo_relatorio=' + tipoRelatorio, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    }

    function js_validaTipoRelatorio(tipoRelatorio) {
      if (tipoRelatorio == "arrecadado") {
        $("selectPeriodoRow").style.display = "table-row";
        $("selectPeriodo").value = 17;
      } else if (tipoRelatorio == "orcado") {
        $("selectPeriodoRow").style.display = "none";
        $("selectPeriodo").value = 17;
      }
    }
  </script>
</body>

</html>