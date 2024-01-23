<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

$parameters = [];

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"], $parameters);

$oDaoVeiculos             = db_utils::getdao('veiculos');
$oDaoVeicCadCentralDepart = db_utils::getdao('veiccadcentraldepart');
$oDaoVeiculosPlaca        = db_utils::getdao('veiculosplaca');

$oDaoVeiculos->rotulo->label("ve01_codigo");
$oDaoVeicCadCentralDepart->rotulo->label("ve37_veiccadcentral");

// Monta consulta para consulta das alterações de placa por veiculo
$in = "";
$where = "";

$veiIn = "";
$veiWhere = "";

// Busca centrais do departamento
$sqlCentral = $oDaoVeicCadCentralDepart->sql_query(
  "",
  "ve37_veiccadcentral",
  "",
  "ve36_coddepto = " . db_getsession("DB_coddepto")
);
$resultCentral = $oDaoVeicCadCentralDepart->sql_record($sqlCentral);

if ($resultCentral != false && $oDaoVeicCadCentralDepart->numrows > 0) {
  $records = db_utils::getCollectionByRecord($resultCentral);

  $veiccadcentralValues = array_map(function ($record) {
    return $record->ve37_veiccadcentral;
  }, $records);

  $veiIn = implode(", ", $veiccadcentralValues);
}

// Primeiro filtro de veiculos
if (!empty($veiIn)) {
  $veiWhere = "ve36_sequencial in($veiIn) ";
} else {
  $veiWhere = "ve36_coddepto = " . db_getsession("DB_coddepto") . " ";
}

$veiCampos  = "distinct ve01_codigo";

// Se existir o código do veiculo na filtragem
if (isset($chave_ve01_codigo) && !empty($chave_ve01_codigo)) {
  $veiWhere .= " and ve01_codigo = " . $chave_ve01_codigo;
}

$sqlVeiculos = $oDaoVeiculos->sql_query_central("", $veiCampos, "ve01_codigo", $veiWhere);
$resultVeiculos = $oDaoVeiculos->sql_record($sqlVeiculos);

if ($resultVeiculos != false && $oDaoVeiculos->numrows > 0) {
  $records = db_utils::getCollectionByRecord($resultVeiculos);

  $ve01_codigoValues = array_map(function ($record) {
    return $record->ve01_codigo;
  }, $records);

  $in = implode(", ", $ve01_codigoValues);
}

$where = "ve76_veiculo in ($in) ";

$sql = $oDaoVeiculosPlaca->sql_query_ultima_alteracao($where);

?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td height="63" align="center" valign="top">
        <table width="23%" border="0" align="center" cellspacing="0">
          <form name="form1" method="post" action="">
            <tr>
              <td width="4%" align="right" nowrap title="<?= $Tve01_codigo ?>">
                <?= $Lve01_codigo ?>
              </td>
              <td width="96%" align="left" nowrap>
                <?
                db_input("ve01_codigo", 10, $Ive01_codigo, true, "text", 4, "", "chave_ve01_codigo");
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                <input name="limpar" type="reset" id="limpar" value="Limpar">
                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_excluialterarplaca.hide();">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <?
        
        if (!isset($chave_ve01_codigo) || empty($chave_ve01_codigo)) {
          $repassa = array();
          db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa, false);
        } else {

          $funcao_js = explode('|', $funcao_js)[0];

          if (!empty($chave_ve01_codigo)) {
            $result = $oDaoVeiculosPlaca->sql_record($sql);
            if ($oDaoVeiculosPlaca->numrows != 0) {
              db_fieldsmemory($result, 0);
              echo "<script>" . $funcao_js . "('". $ve76_sequencial ."',false);</script>";
            } else {
              echo "<script>" . $funcao_js . "(true,'Chave(" . $pesquisa_chave . ") não Encontrado');</script>";
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