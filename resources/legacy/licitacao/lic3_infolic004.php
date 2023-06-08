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
include("libs/db_sessoes.php");
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicitem_classe.php");
include("classes/db_pcprocitem_classe.php");
include("model/licitacao.model.php");
include("classes/db_liclicitasituacao_classe.php");

$clliclicita = new cl_liclicita();

$oDaoRotulo    = new rotulocampo;
$clliclicita->rotulo->label();

$oGet                = db_utils::postMemory($_GET);

$campos = "l20_dtpubratificacao,l20_justificativa,l20_razao";
$sql = $clliclicita->sql_query($l20_codigo,$campos);
$result = db_query($sql);
db_fieldsmemory($result, 0);
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/tab.style.css" rel="stylesheet" type="text/css">
    <style type="text/css">

        .valor {
            background-color: #FFF;
        }
    </style>
</head>
<body bgcolor="#cccccc" onload="">
<center>
    <form name="form1" method="post">
        <div style="display: table; float:left; width: 60%; margin-left:10%;">
            <fieldset>
                <legend><b>Dispensa/Inexigibilidade</b></legend>
                <table style="" border='0'>
                    <tr>
                        <td  title="Data da publicação do Termo de Ratificação" style="width: 150px;">
                            <strong>Data Pub. Termo Ratificacao:</strong>
                        </td>
                        <td  class="valor" style="width: 431px; text-align: left; ">
                            <?php echo implode("/", array_reverse(explode("-", $l20_dtpubratificacao)));?>
                        </td>
                        </tr>
                    <tr>
                        <td  title="<?=$Tl20_justificativa?>" style=" width: 50px;">
                            <?=$Ll20_justificativa?>
                        </td>
                        <td  class="valor" style="width:431px; text-align: left; ">
                            <?php echo $l20_justificativa;?>
                        </td>
                    </tr>
                    <tr>
                        <td title="<?=$Tl20_razao?>" style="width: 50px;">
                            <?=$Ll20_razao?>
                        </td>
                        <td class="valor" style="width: 431px; text-align: left; ">
                            <?php echo $l20_razao;?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </form>
</center>
</body>
</html>
<script>

</script>