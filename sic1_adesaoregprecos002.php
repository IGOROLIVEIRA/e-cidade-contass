<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_adesaoregprecos_classe.php");
include("classes/db_itensregpreco_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clcflicita        = new cl_cflicita;
$cladesaoregprecos = new cl_adesaoregprecos;
$clitensregpreco   = new cl_itensregpreco;
$clacordo          = new cl_acordo;
$clacordoposicao   = new cl_acordoposicao;
$clempautoriza     = new cl_empautoriza;
$clliclicita       = new cl_liclicita;
$clempempenho      = new cl_empempenho;
$clempempaut       = new cl_empempaut;
$db_botao = true;
$sqlerro  = false;

$db_opcao = isset($alterar) ? 2 : 1;

if (isset($incluir) || isset($alterar)) {


  $rsAdesao = db_query("select * from adesaoregprecos where si06_numeroadm = $si06_numeroadm and si06_anomodadm != (select si06_anomodadm from adesaoregprecos where si06_sequencial = $si06_sequencial) and si06_anomodadm = $si06_anomodadm;");

  if(pg_num_rows($rsAdesao) > 0){
    $erro_msg = 'Erro, o número do processo de adesão informado já está sendo utilizado no exercício de ' . $si06_anomodadm;
    $sqlerro = true;
  }

  $sDataAta = join('-', array_reverse(explode('/', $si06_dataata)));
  $sDataAbertura = join('-', array_reverse(explode('/', $si06_dataabertura)));

  if ($sDataAta > $sDataAbertura && !$sqlerro) {
    $sqlerro = true;
    $erro_msg = 'Data da Ata é maior que a Data de Abertura!';
  }

  $oDaoPcProc = db_utils::getDao('pcproc');
  $rsProc = $oDaoPcProc->sql_record($oDaoPcProc->sql_query_file($si06_processocompra));
  $sDataCotacao = db_utils::fieldsMemory($rsProc, 0)->pc80_data;

  if ($sDataCotacao > $sDataAbertura && !$sqlerro) {
    $sqlerro = true;
    $erro_msg = 'Data da Cotação é maior que a Data de Abertura! ';
  }
}
if (!$sqlerro) {
  if (isset($incluir)) {
    $db_opcao = 1;

    db_inicio_transacao();

    /**
     * Verificar Encerramento Periodo Patrimonial
     */
    if (!empty($si06_dataadesao)) {
      $clcondataconf = new cl_condataconf;
      if (!$clcondataconf->verificaPeriodoPatrimonial($si06_dataadesao)) {
        $cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
        $cladesaoregprecos->erro_status = "0";
        $sqlerro  = true;
      }
    }

    if (!$sqlerro) {
      $cladesaoregprecos->si06_anocadastro = db_getsession('DB_anousu');
      if (db_getsession('DB_anousu') >= 2020) {
        $cladesaoregprecos->si06_edital = $si06_edital;
        $cladesaoregprecos->si06_cadinicial = 1;
        $cladesaoregprecos->si06_exercicioedital = db_getsession('DB_anousu');
      }
      $cladesaoregprecos->incluir(null);
    }
    if ($cladesaoregprecos->erro_status == "0") {

      $cladesaoregprecos->erro(true, false);
      $db_botao = true;
      echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
      if ($cladesaoregprecos->erro_campo != "") {
        echo "<script> document.form1." . $cladesaoregprecos->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1." . $cladesaoregprecos->erro_campo . ".focus();</script>";
      }
    } else {
      if (!$sqlerro) {
        $sSql = "select * from adesaoregprecos order by si06_sequencial desc limit 1;";
        $rsResult = pg_query($sSql);
        db_fieldsmemory($rsResult, 0);
        $_SESSION["codigoAdesao"] = $si06_sequencial;
        echo "<script>
                alert('Inclusão efetuada com sucesso');
                parent.document.formaba.db_itens.disabled=false;
                parent.mo_camada('db_itens');
                parent.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=" . $si06_sequencial . "';
            </script>";
      }
    }
    db_fim_transacao();
  }

  if (isset($alterar)) {
    if ($si06_numeroadm != "" && $si06_numeroadm != null && $si06_anomodadm != "" && $si06_anomodadm != null && $si06_nummodadm != "" && $si06_nummodadm != null) {
      db_inicio_transacao();
      $db_opcao = 2;
      $sqlerro  = false;

      /**
       * Verificar Encerramento Periodo Patrimonial
       */
      $dataadesao = db_utils::fieldsMemory(db_query($cladesaoregprecos->sql_query_file($si06_sequencial, "si06_dataadesao")), 0)->si06_dataadesao;

      if ($sqlerro == false) {

        $cladesaoregprecos->si06_departamento = $si06_departamento;
        $cladesaoregprecos->alterar($si06_sequencial);

        $sSqlItemacordo = $clacordo->sql_record($clacordo->sql_query_sequencial_acordo($si06_sequencial));
        $numrows_unid = $clacordo->numrows;

        if ($numrows_unid > 0) {

          db_fieldsmemory($sSqlItemacordo, 0);
          $sSqlItemacordoposicao = $clacordoposicao->sql_record($clacordoposicao->sql_query_empenhoautori_acordo($ac16_sequencial));
          $numrows_unid = $clacordoposicao->numrows;

          for ($i = 0; $i < $numrows_unid; $i++) {
            db_fieldsmemory($sSqlItemacordoposicao, $i);
            $clempautoriza->e54_nummodalidade = $si06_nummodadm;
            $clempautoriza->e54_numerl = $si06_numeroadm . "/" . $si06_anomodadm;
            $clempautoriza->e54_autori = $e54_autori;
            $clempautoriza->alterar($e54_autori);
            if ($e60_numemp != "" && $e60_numemp != null) {
              $clempempenho->e60_numerol = $si06_numeroadm . "/" . $si06_anomodadm;
              $clempempenho->e60_numemp = $e60_numemp;
              $clempempenho->alterar($e60_numemp);
            }
          }
        } else {
          $sSqlItemempempaut = $clempempaut->sql_record($clempempaut->sql_query_empenhoautori($si06_anoproc, $si06_sequencial));
          $numrows_unid = $clempempaut->numrows;
          for ($i = 0; $i < $numrows_unid; $i++) {
            db_fieldsmemory($sSqlItemempempaut, $i);
            $clempautoriza->e54_nummodalidade = $si06_nummodadm;
            $clempautoriza->e54_numerl = $si06_numeroadm . "/" . $si06_anomodadm;
            $clempautoriza->e54_autori = $e61_autori;
            $clempautoriza->alterar($e61_autori);
            if ($e61_numemp != "" && $e61_numemp != null) {
              $clempempenho->e60_numerol = $si06_numeroadm . "/" . $si06_anomodadm;
              $clempempenho->e60_numemp = $e61_numemp;
              $clempempenho->alterar($e61_numemp);
            }
          }
        }
      }

      if ($si06_processoporlote == 2) {
        $sSqlItens = $clitensregpreco->sql_query(null, "itensregpreco.*", null, "si07_sequencialadesao = {$si06_sequencial}");
        $rsItens   = $clitensregpreco->sql_record($sSqlItens);

        for ($count = 0; $count < pg_num_rows($rsItens); $count++) {
          $oItem = db_utils::fieldsMemory($rsItens, $count);

          $clitensregpreco->si07_descricaolote = '';
          $clitensregpreco->si07_numerolote    = '';
          $clitensregpreco->si07_sequencialadesao = $si06_sequencial;
          $clitensregpreco->alterar($oItem->si07_sequencial);
        }
      }
      db_fim_transacao();
      $_SESSION["codigoAdesao"] = $si06_sequencial;
      echo "<script>
          parent.document.formaba.db_itens.disabled=false;
          parent.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=" . $si06_sequencial . "';
          </script>";
    } else {
      $sqlerro = true;
      $erro_msg = 'Informe todas as informações do orgão de adesão!';
      $campo = "si06_anomodadm";
    }
  } else if (isset($chavepesquisa) || isset($_SESSION["codigoAdesao"])) {
    $db_opcao = 2;
    if (!isset($chavepesquisa)) {
      $chavepesquisa = $_SESSION["codigoAdesao"];
    }
    unset($_SESSION["codigoAdesao"]);
    $result = $cladesaoregprecos->sql_record($cladesaoregprecos->sql_query($chavepesquisa));
    db_fieldsmemory($result, 0);
    $db_botao = true;
  }

  if (isset($excluir)) {
    if (!$si06_sequencial) {
      $sqlerro = true;
      $erro_msg = 'Adesão de Registro de Preço ainda não cadastrada.';
    } else {
      db_inicio_transacao();
      $db_opcao = 3;

      /**
       * Verificar Encerramento Periodo Patrimonial
       */
      $dataadesao = db_utils::fieldsMemory(db_query($cladesaoregprecos->sql_query_file($si06_sequencial, "si06_dataadesao")), 0)->si06_dataadesao;

      if (!empty($si06_dataadesao)) {
        $clcondataconf = new cl_condataconf;
        if (!$clcondataconf->verificaPeriodoPatrimonial($dataadesao)) {
          $cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
          $cladesaoregprecos->erro_status = "0";

          $sqlerro  = true;
          $erro_msg = $clcondataconf->erro_msg;
        }
      }

      if ($sqlerro == false) {
        $clitensregpreco = new cl_itensregpreco;
        $clitensregpreco->excluir(null, " si07_sequencialadesao = $si06_sequencial");
        $cladesaoregprecos->excluir($si06_sequencial);
      }

      db_fim_transacao();
    }
  } else if (isset($chavepesquisa) || isset($_SESSION["codigoAdesao"])) {
    // $db_opcao = 3;
    if (!isset($chavepesquisa)) {
      $chavepesquisa = $_SESSION["codigoAdesao"];
    }
    unset($_SESSION["codigoAdesao"]);
    echo "<script>
        parent.document.formaba.db_itens.disabled=false;
        parent.CurrentWindow.corpo.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=" . $chavepesquisa . "';
        </script>";
    $result = $cladesaoregprecos->sql_record($cladesaoregprecos->sql_query($chavepesquisa, "*,cgm.z01_nome as z01_nomeorg,c.z01_nome as z01_nomeresp"));
    db_fieldsmemory($result, 0);
    $db_botao = true;
  }
}

if ($sqlerro) {
  echo "<script>";
  echo "alert('$erro_msg');";
  echo "</script>";
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
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 40px;">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmadesaoregprecos.php");
          ?>
        </center>
      </td>
    </tr>
  </table>
</body>

</html>

<?

if (isset($alterar)) {

  if ($cladesaoregprecos->erro_status == "0") {

    $cladesaoregprecos->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($cladesaoregprecos->erro_campo != "") {
      echo "<script> document.form1." . $cladesaoregprecos->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $cladesaoregprecos->erro_campo . ".focus();</script>";
    }
  } else {
    echo "<script> document.form1." . $campo . ".style.backgroundColor='#99A9AE';</script>";
    echo "<script> document.form1." . $campo . ".focus();</script>";
    echo "
    <script>
    document.formaba.db_itens.disabled=false;
    parent.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=" . $si06_sequencial . "';
    </script>";
    $cladesaoregprecos->erro(true, false);
    $db_opcao = 22;
  }
}
if ($db_opcao == 22 && !$sqlerro) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
if (isset($excluir) && !$sqlerro) {
  if ($cladesaoregprecos->erro_status == "0") {
    $cladesaoregprecos->erro(true, false);
  } else {
    $cladesaoregprecos->erro(true, true);
  }
}
if ($db_opcao == 33) {
  echo "<script>document.form1.pesquisar.click();</script>";
}

?>