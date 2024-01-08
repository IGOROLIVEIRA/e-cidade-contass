<?
require_once "libs/db_stdlib.php";
require_once "libs/db_utils.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "classes/db_veiculosplaca_classe.php";

$clveiculosplaca  = new cl_veiculosplaca;
$funcao_js        = "";

/*
 * Recupera as informações passadas por GET para o objeto $oGet e efetua a busca
 * de retiradas e exibe na db_lovrot
 */
$oGet               = db_utils::postMemory($_GET, false);
$sCampos            = "ve76_sequencial,ve76_veiculo,ve76_placaanterior,ve76_placa,ve76_data, LEFT(ve76_obs, 50) ve76_obs, '(' || id_usuario || ') ' || nome as ve76_usuario ";
$sWhere             = "veiculos.veiculosplaca.ve76_veiculo = $oGet->veiculo";
$sSqlBuscaAlteracoesPlaca = $clveiculosplaca->sql_query(null, $sCampos, "ve76_sequencial desc", $sWhere);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
  <body>
    <center>
      <fieldset>
        <?db_lovrot($sSqlBuscaAlteracoesPlaca, 15, "()", "%", $funcao_js);?>
      </fieldset>
    </center>
  </body>
</html>