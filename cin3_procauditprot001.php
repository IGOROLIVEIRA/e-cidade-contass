<?
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
include("classes/db_processoaudit_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clprocessoaudit = new cl_processoaudit;

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
</script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table  border="0" cellspacing="0" cellpadding="0" width='100%'>
<tr>
<td  align="center" valign="top" >

<table border='0'>
    </tr>

        <?

            if (isset($ci03_codproc) && !empty($ci03_codproc)) {

                $sWhere  = "    ci03_codproc = {$ci03_codproc} ";
                $sCampos = "    p58_dtproc,
                                p51_descr,
                                cast(p58_numero||'/'||p58_ano as varchar) as dl_Processo_Nº,
                                z01_numcgm,
                                z01_nome as dl_nome_ou_razão_social,
                                p58_obs,
                                cast(p58_numero||'/'||p58_ano as varchar) as dl_PROTOCOLO_GERAL,
                                p58_codproc,
                                p58_requer as DB_p58_requer,
                                p58_numero";

                $sSql   = " SELECT {$sCampos}
                                FROM processoaudit
                                    LEFT JOIN protprocesso ON p58_codproc = ci03_protprocesso
                                    INNER JOIN cgm ON z01_numcgm = p58_numcgm
                                    INNER JOIN tipoproc ON p51_codigo = p58_codigo
                                WHERE {$sWhere}";

            }

            db_lovrot(@$sSql,15,"()","","js_mostraprotocolo|p58_codproc");
        ?>
</table>

</td>
</tr>
</table>
</body>
</html>
<script>
    function js_mostraprotocolo(iCodProt) {
        js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe', 'pro3_consultaprocesso003.php?codproc='+iCodProt, 'Pesquisa de Processos', true);
    }
</script>
