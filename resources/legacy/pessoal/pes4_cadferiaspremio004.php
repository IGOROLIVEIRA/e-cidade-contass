<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica             
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
include("classes/db_cadferiaspremio_classe.php");
include("classes/db_cadferia_classe.php");
include("classes/db_selecao_classe.php");
include("classes/db_rhpesrescisao_classe.php");
include("classes/db_rhpessoal_classe.php");
include("libs/db_sql.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$clcadferiaspremio = new cl_cadferiaspremio;
$clcadferia = new cl_cadferia;
$clrhpesrescisao = new cl_rhpesrescisao;
$clselecao = new cl_selecao;
$clsql = new cl_gera_sql_folha;
$db_opcao = 1;
$db_botao = true;
$sqlerro = false;
$anofolha = db_anofolha();
$mesfolha = db_mesfolha();
if(isset($r95_regist) && !isset($incluir)) {

  $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query_matricula_cgm($r95_regist, "rh01_regist, z01_nome, rh01_admiss"));
  $oDadosServidor = db_utils::fieldsMemory($result, 0);
  $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query(null, "*", "r95_sequencial desc", "r95_regist = $r95_regist"));
  $oFeriasPremio = db_utils::fieldsMemory($result, 0);

  $oPeriodoAquisitivo = new DateTime((!empty($oFeriasPremio->r95_peraf) ? $oFeriasPremio->r95_peraf : $oDadosServidor->rh01_admiss));
  $z01_nome = $oDadosServidor->z01_nome;

  $r95_perai = mktime(0,0,0,$oPeriodoAquisitivo->format('m'),$oPeriodoAquisitivo->format('d'),$oPeriodoAquisitivo->format('Y'));
  $r95_perai_dia = $oPeriodoAquisitivo->format('d');
  $r95_perai_mes = $oPeriodoAquisitivo->format('m'); 
  $r95_perai_ano = $oPeriodoAquisitivo->format('Y');

  $oPeriodoAquisitivo->add(new DateInterval("P5Y"));
  $r95_peraf = mktime(0,0,0,$oPeriodoAquisitivo->format('m'),$oPeriodoAquisitivo->format('d'),$oPeriodoAquisitivo->format('Y'));
  $r95_peraf_dia = $oPeriodoAquisitivo->format('d');
  $r95_peraf_mes = $oPeriodoAquisitivo->format('m');
  $r95_peraf_ano = $oPeriodoAquisitivo->format('Y');

  if ($sqlerro == false) {
    $result_rescisao = $clrhpesrescisao->sql_record($clrhpesrescisao->sql_query_ngeraferias(null,"*","",
                                  "rh02_regist = $r95_regist and rh02_anousu = $anofolha and rh02_mesusu = $mesfolha"));
    if($clrhpesrescisao->numrows > 0) {
      $sqlerro = true;
      db_msgbox("Funcionário rescindiu contrato.");
    }
  }
}
if(isset($incluir)) {

  db_inicio_transacao();
  $aMatriculas = array();
  if (!empty($r95_regist)) {
    $aMatriculas[] = $r95_regist;
  } else {
    $result = $clselecao->sql_record($clselecao->sql_query_file($r44_selec, db_getsession("DB_instit")));
    if ($clselecao->erro_status == "0") {
      $sqlerro = true;
      db_msgbox("Erro ao buscar seleção.");
    }
    if ($sqlerro == false) {
      $sql = $clsql->gerador_sql("", $anofolha, $mesfolha, null, null, " rh01_regist ", "rh01_regist", db_utils::fieldsMemory($result, 0)->r44_where);
      $result = $clsql->sql_record($sql);
      if ($result == false){
        $sqlerro = true;
        db_msgbox("Erro ao buscar matrículas por seleção.");
      } else {
        for ($iCont=0; $iCont < pg_num_rows($result); $iCont++) { 
          $aMatriculas[] = db_utils::fieldsMemory($result, $iCont)->rh01_regist;
        }
      }
    }
  }


  foreach ($aMatriculas as $matricula) {
    
    $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query_file(null, "*", null, "r95_regist = {$matricula} and r95_mesusu = {$mesfolha} and r95_anousu = {$anofolha}"));

    $r95_per1i_banco = "{$r95_per1i_ano}-{$r95_per1i_mes}-{$r95_per1i_dia}";
    $r95_per1f_banco = "{$r95_per1f_ano}-{$r95_per1f_mes}-{$r95_per1f_dia}";
    $result = $clcadferia->sql_record($clcadferia->sql_query_file(null, "*", null, "r30_regist = {$matricula} and ((
      (r30_per1i between '{$r95_per1i_banco}' and '{$r95_per1f_banco}') OR 
      (r30_per1f between '{$r95_per1i_banco}' and '{$r95_per1f_banco}') OR
      ('{$r95_per1i_banco}' between r30_per1i and r30_per1f) OR
      ('{$r95_per1f_banco}' between r30_per1i and r30_per1f) 
    ) or (
      (r30_per2i between '{$r95_per1i_banco}' and '{$r95_per1f_banco}') OR 
      (r30_per2f between '{$r95_per1i_banco}' and '{$r95_per1f_banco}') OR
      ('{$r95_per1i_banco}' between r30_per2i and r30_per2f) OR
      ('{$r95_per1f_banco}' between r30_per2i and r30_per2f)
    ))"));
    if ($clcadferiaspremio->numrows > 0 || $clcadferia->numrows > 0) {
      $sqlerro = true;
      db_msgbox("Já existem férias lançadas neste período para a matrícula {$matricula}.");
      break;
    }
    if ($sqlerro == false) {

      if (!empty($r44_selec)) {

        $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query_matricula_cgm($matricula, "rh01_regist, z01_nome, rh01_admiss"));
        $oDadosServidor = db_utils::fieldsMemory($result, 0);
        $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query(null, "*", "r95_sequencial desc", "r95_regist = $matricula"));
        $oFeriasPremio = db_utils::fieldsMemory($result, 0);
        $clcadferiaspremio->setPeriodoAquisitivo((!empty($oFeriasPremio->r95_peraf) ? $oFeriasPremio->r95_peraf : $oDadosServidor->rh01_admiss));
        $clcadferiaspremio->r95_regist = $matricula;
      }
      $ndiasMatricula = $r95_ndias;
      $anofolha = db_anofolha();
      $mesfolha = db_mesfolha();
      while ($ndiasMatricula > 0) {
        $oData = new DateTime("$anofolha-$mesfolha-01");
        $oData->modify("last day of this month");
        if ($mesfolha == db_mesfolha()) {
          $ndias = $oData->format('d')-($r95_per1i_dia-1);
        } else if ($ndiasMatricula > $oData->format('d')) {
          $ndias = $oData->format('d');
        } else {
          $ndias = $ndiasMatricula;
        }
        $ndiasMatricula -= $ndias;
        $clcadferiaspremio->r95_ndias = $ndias;
        $clcadferiaspremio->r95_anousu = $anofolha;
        $clcadferiaspremio->r95_mesusu = $mesfolha;
        $clcadferiaspremio->incluir(null);
        if ($clcadferiaspremio->erro_status == "0") {
          $sqlerro = true;
          db_msgbox("Erro ao incluir matrícula {$matricula}. ".$clcadferiaspremio->erro_msg);
          break;
        }
        $mesfolha++;
        if ($mesfolha > 12) {
          $mesfolha = 1;
          $anofolha++; 
        }
      }
      if ($sqlerro == true) {
        break;
      }
    }
  }
  db_fim_transacao($sqlerro);
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScrpit" type="text/javascript" src="scripts/classes/DBViewFormularioFolha/ValidarFolhaPagamento.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
      <center>
        <?
        include("forms/db_frmcadferiaspremio001.php");
        ?>
      </center>
    </td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if (isset($incluir) && $sqlerro == false) {
    db_msgbox("Inclusão efetuada com sucesso.");
    echo "<script>location.href = 'pes4_cadferiaspremio001.php';</script>";
} else if ($sqlerro == true) {
  echo "<script>location.href = 'pes4_cadferiaspremio001.php';</script>";
}
?>