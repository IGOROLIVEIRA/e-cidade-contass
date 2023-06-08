<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_transporteescolar_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$cltransporteescolar = new cl_transporteescolar;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
        <td height="63" align="center" valign="top">
            <table width="35%" border="0" align="center" cellspacing="0">
                <form name="form2" method="post" action="">
                    <tr>
                        <td colspan="2" align="center">
                            <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                            <input name="limpar" type="reset" id="limpar" value="Limpar">
                            <input name="Fechar" type="button" id="fechar" value="Fechar"
                                   onClick="parent.db_iframe_transporteescolar.hide();">
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <?
            if (!isset($pesquisa_chave)) {
                if (isset($campos) == false) {
                    if (file_exists("funcoes/db_func_transporteescolar.php") == true) {
                        include("funcoes/db_func_transporteescolar.php");
                    } else {
                        /*
                         * Ocorrência 1012
                         * Alterado a ordem dos campos e criado case para aparecer o nome do mês ao invés do número.
                         */
                        $campos = "ve01_placa,v200_sequencial,v200_veiculo,v200_escola,v200_localidade,v200_numpassageiros,
                        case when v200_periodo = 1 then 'Janeiro' when v200_periodo = 2 then 'Fevereiro' when v200_periodo = 3 then 'Março'
                        when v200_periodo = 4 then 'Abril' when v200_periodo = 5 then 'Maio' when v200_periodo = 6 then 'Junho' when v200_periodo = 7 then 'Julho'
                        when v200_periodo = 8 then 'Agosto' when v200_periodo = 9 then 'Setembro' when v200_periodo = 10 then 'Outubro' when v200_periodo = 11 then 'Novembro'
                        when v200_periodo = 12 then 'Dezembro' else ' ' end as v200_periodo
                        ,v200_diasrodados, v200_distancia,v200_turno,v200_anousu";
                    }
                }
                $where = "ve01_instit = ".db_getsession('DB_instit');
                $sql = $cltransporteescolar->sql_query(null, $campos, " v200_sequencial desc ",$where);
                $repassa = array();
                db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa);
            } else {
                if ($pesquisa_chave != null && $pesquisa_chave != "") {
                    $result = $cltransporteescolar->sql_record($cltransporteescolar->sql_query($pesquisa_chave));
                    if ($cltransporteescolar->numrows != 0) {
                        db_fieldsmemory($result, 0);
                        echo "<script>" . $funcao_js . "('$oid',false);</script>";
                    } else {
                        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                    }
                } else {
                    echo "<script>" . $funcao_js . "('',false);</script>";
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
<?
if (!isset($pesquisa_chave)) {
    ?>
    <script>
    </script>
    <?
}
?>
