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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_cflicitatemplateata_classe.php");
require_once("dbforms/db_funcoes.php");

$oPost = db_utils::postMemory($_POST);
$oGet  = db_utils::postMemory($_GET);



if (isset($incluir)) {
  $erro = false;

  $amparos = $oPost->aItensMarcados;
  $modalidade = $oPost->l03_codigo;

  if (!db_query("delete from amparocflicita where l213_modalidade = $modalidade;")) {
    db_msgbox(pg_last_error());
    $erro = true;
  }

  if ($erro == false) {
    for ($i = 0; $i < count($amparos); $i++) {
      $amparo = $amparos[$i];
      if (!db_query("INSERT INTO amparocflicita VALUES ($amparo,$modalidade);")) {
        db_msgbox(pg_last_error());
        $erro = true;
      }
    }
  }



  if ($erro == false) {
    db_msgbox("Amaparos Legais salvos com sucesso");
  }
}

?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmcflicitaamparolegal.php");
          ?>
        </center>
      </td>
    </tr>
  </table>
</body>

</html>
<?

$result = db_query("select * from amparocflicita where l213_modalidade = $l03_codigo");
$numrows = pg_numrows($result);
for ($i = 0; $i < $numrows; $i++) {
  $codigo_amparo = pg_result($result, $i, "l213_amparo");
  echo "<script> document.getElementById('$codigo_amparo').checked = true; </script>";
}


?>