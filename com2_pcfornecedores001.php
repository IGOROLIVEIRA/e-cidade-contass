<?php
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
db_postmemory($HTTP_POST_VARS);
?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

    <script>
        function js_emite() {
            jan = window.open('com2_pcgrupo002.php?ordem=' + document.form1.ordem.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            jan.moveTo(0, 0);
        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        .center {
            width: 1100px;
            margin: 0 auto;
            padding: 0 2%;
            text-align:center;
        }

        fieldset {
            width: 43%;
            margin: 10px auto;
        }

        fieldset #bloqueado {
            width: 50%;
        }

    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <div class="center">
        <fieldset>
            <legend>Fornecedores</legend>
            <form name="form1" method="post" action="">
                <label for="bloqueado"> <strong>Filtrar por:&nbsp;&nbsp;</strong> </label>
                <?php
                $tipo = array("a" => "Todos", "f" => "Ativos", "t" => "Bloqueados");
                db_select("bloqueado", $tipo, true, 2);
                ?>
                <input name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" style="display:block; margin: 10px auto">
            </form>
        </fieldset>
    </div>

    <?php
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<script>
    function js_emite() {
        const obj = document.form1;
        const tipo = document.form1.bloqueado.value;
        const query = `bloqueado=${tipo}`;
        jan = window.open('com2_pcfornecedores002.php?' + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0');
        jan.moveTo(0, 0);
    }
</script>
