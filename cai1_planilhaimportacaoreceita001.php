<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("model/caixa/PlanilhaArrecadacao.model.php");
require_once("classes/db_tabrec_classe.php");
require_once("model/caixa/PlanilhaArrecadacaoImportacaoReceita.model.php");

db_postmemory($HTTP_POST_VARS);
define('MENSAGENS', 'financeiro.caixa.cai1_planilhalancamento001.');
define('DEBUG', false);


if (DEBUG) {
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
}


montarDebug("Debug Ativo");

if (isset($processar)) {
    try {
        // Recebendo o arquivo da planilha
        db_postmemory($_FILES["arquivo"]);
        $arq_name    = substr(basename($name), 0, -4);
        $arq_type    = $type;
        $arq_tmpname = basename($tmp_name);
        $arq_size    = $size;
        $arq_array   = file($tmp_name);
        $arq_ext     = substr($name, -3);

        if ($arq_ext != "txt")
            throw new FileException("Apenas arquivos de texto (.txt)");

        montarDebug("Dados do arquivo: {$arq_ext} {$arq_name} {$arq_type} {$arq_tmpname} {$arq_size}");

        $oPlanilhaArrecadacaoImportacaoReceita = new PlanilhaArrecadacaoImportacaoReceita($arq_name, $layout);
        $oPlanilhaArrecadacaoImportacaoReceita->salvarPlanilhaReceita($arq_array);
    } catch (Exception $oException) {
        db_msgbox($oException->getMessage());
    }
}

function montarDebug($oDebug)
{
    if (DEBUG) {
        var_dump($oDebug);
        echo "<br><hr/>";
    }
    return;
}
?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js, strings.js, prototype.js, estilos.css");
    ?>
</head>

<body class="body-default" onLoad="a=1">
    <?php
    include("forms/db_frmplanilhaimportacaoreceita001.php");
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>