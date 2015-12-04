<?php
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("classes/db_db_versao_classe.php");
require_once("model/configuracao/SkinService.service.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$cldb_versao = new cl_db_versao;
$result      = $cldb_versao->sql_record($cldb_versao->sql_query(null,"db30_codversao,db30_codrelease","db30_codver desc limit 1"));

if ( $cldb_versao->numrows == 0 ) {

  $db30_codversao  = "1";
  $db30_codrelease = "1";
} else {
  db_fieldsmemory($result,0);
}

/**
 * Salva o skin no cookie
 */
$oSkin = new SkinService();
$oSkin->setCookie();

db_logsmanual_demais("Acesso Liberado ao sistema - Login: " . db_getsession("DB_login"), db_getsession("DB_id_usuario"));
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - DBPortal Vers�o:  2.<?php echo "{$db30_codversao}.{$db30_codrelease}"; ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script>

      function js_obj(obj) {

        if (typeof(obj) != "object") {

          alert("O parametro passado, n�o parece ser um objeto!");
      	  return false;
        }

        var args = js_obj.arguments;
        var F = (typeof(args[1]) == "undefined" || args[1] == "") ? 5 : args[1];
        var temp = "";
        var l = 0;
        var i;
        var x;

        for( i in obj) {
          temp += obj + "   " + i + "  ==> " + obj[i] + "\n";

          if (l++ == F) {
         	  x = confirm(temp);

        	  if(x == false){
        	    break;
            }

        	  temp = "";
        	  l = 0;
      	  }
        }

        return true;
      }

      var jan = null;
      var lin = 0;
      var tab = null;

      // VER: Caixa, emissao de recibo
      function js_criaJanela(){

        jan = window.open('', '', 'width=400,height=400,scrollbars=1,location=0 ');
        jan.moveTo(screen.availWidth-400,0);
        jan.focus();
      }

      function js_enviaTraceLog(descricao, sql, data){

        if (jan == null) {

          js_criaJanela();
          var conteudo  = "<html>";
              conteudo += "  <head>";
              conteudo += "    <title>Trace Log</title>";
              conteudo += "  </head>";
              conteudo += "  <body bgcolor='#CCCCCC' onUnload='opener.js_fechaJanela();'>";
              conteudo += "  </body>";
              conteudo += "</html>";

          jan.document.write(conteudo);
          jan.document.close();

          tab = document.createElement("TABLE");
          jan.document.body.appendChild(tab);
        }

        var  tr = tab.insertRow(lin);
        var td1 = tr.insertCell(0);
        var td2 = tr.insertCell(1);
        var td3 = tr.insertCell(2);

        tr.setAttribute("id", "tr" + lin);

        td1.setAttribute("id", "td1" + lin);
        td2.setAttribute("id", "td2" + lin);
        td3.setAttribute("id", "td3" + lin);

        td1.setAttribute("nowrap", 1);
        td2.setAttribute("nowrap", 1);
        td3.setAttribute("nowrap", 1);

        jan.document.getElementById("td1" + lin).innerHTML = data;
        jan.document.getElementById("td2" + lin).innerHTML = descricao;
        jan.document.getElementById("td3" + lin).innerHTML = sql;
        lin ++;
      }

      function js_fechaJanela() {
        if (jan != null) {
          jan.close();
          jan = null;
          lin = 0;
          tab = null;
        }
        window.open('encerrar.php', '', 'width=400,height=400');
      }
    </script>
  </head>
  <?php
    $oSkin = new SkinService();
    include( $oSkin->getPathFile("inicio.php") );
  ?>
</html>