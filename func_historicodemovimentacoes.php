<?
require_once "libs/db_stdlib.php";
require_once "libs/db_utils.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";

$oGet = db_utils::postMemory($_GET, false);

$funcao_js = "carregaDetalheMovimentacao|vehistmov_codigo|vehistmov_tipo";
$sSqlHistoricoDeMovimentacoes = <<<SQL
  SELECT 
    codigo AS vehistmov_codigo,
    tipo AS vehistmov_tipo,
    data AS vehistmov_data,
    horas AS vehistmov_horas,
    usuario AS vehistmov_usuario
  FROM 
  (
    (
      SELECT
        vt.ve81_sequencial AS codigo,
        'Transferência de Departamento' AS tipo,
        tv.ve80_dt_transferencia AS data,
        tv.ve80_hora AS horas,
        '(' || u.id_usuario || ') ' || u.nome AS usuario
      FROM 
        veiculostransferencia AS vt
      INNER JOIN transferenciaveiculos AS tv
        ON tv.ve80_sequencial = vt.ve81_transferencia
      INNER JOIN db_usuarios AS u
        ON u.id_usuario = tv.ve80_id_usuario
      WHERE
        vt.ve81_codigo = $oGet->veiculo
    )
    UNION
    (
      SELECT
        vb.ve04_codigo AS codigo,
        'Baixa de Veículos' AS tipo,
        vb.ve04_data AS data,
        vb.ve04_hora AS horas,
        '(' || u.id_usuario || ') ' || u.nome AS usuario
      FROM 
        veicbaixa AS vb
      INNER JOIN db_usuarios AS u
        ON u.id_usuario = vb.ve04_usuario
      WHERE
        vb.ve04_veiculo = $oGet->veiculo
    )
    UNION
    (
      SELECT
        ra.ve82_sequencial AS codigo,
        'Reativação de Veículos' AS tipo,
        ra.ve82_datareativacao AS data,
        TO_CHAR(ra.ve82_criadoem, 'HH24:MI') AS horas,
        '(' || u.id_usuario || ') ' || u.nome AS usuario
      FROM
        veicreativar AS ra
      INNER JOIN db_usuarios AS u
        ON u.id_usuario = ra.ve82_usuario
      WHERE
        ra.ve82_veiculo = $oGet->veiculo
    )
  ) AS historicodemovimentacoes
  ORDER BY data DESC, horas DESC
  SQL;

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
      <? db_lovrot($sSqlHistoricoDeMovimentacoes, 15, "()", "%", $funcao_js); ?>
    </fieldset>
  </center>
  <script type="text/javascript">
    function carregaDetalheMovimentacao(vehistmov_codigo, vehistmov_tipo) {

      let tipo = "";
      let titulo = "";
      switch (vehistmov_tipo) {
        case 'Transferência de Departamento':
          tipo = 'TRANSFERENCIA';
          titulo = 'Detalhes Transferência';
          break;
        case 'Baixa de Veículos':
          tipo = 'BAIXA';
          titulo = 'Detalhes Baixa';
          break;
        case 'Reativação de Veículos':
          tipo = 'REATIVACAO';
          titulo = 'Detalhes Reativação de Veículos';
          break;
        default:
          break;
      }

      if (tipo !== "") {
        var sUrl = `vei3_historicomovimentacao002.php?codigo=${vehistmov_codigo}&tipo=${tipo}`;
        var iWidth = parent.document.body.scrollWidth - 100;
        var iHeight = parent.document.body.scrollHeight - 100;
        js_OpenJanelaIframe('parent', `func_historicodemovimentacoes_${tipo}`, sUrl, titulo, true, '0', 0, iWidth, iHeight);
      }
    }
  </script>
</body>

</html>