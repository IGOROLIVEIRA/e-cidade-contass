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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_pcorcamitem_classe.php");
require_once("classes/db_pcorcamitemlic_classe.php");
require_once("classes/db_pcorcamforne_classe.php");
require_once("classes/db_pcorcamfornelic_classe.php");
require_once("classes/db_pcorcamval_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_liclicitatipoempresa_classe.php");
require_once("classes/db_pcorcamjulgamentologitem_classe.php");
require_once("classes/db_credenciamento_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("libs/db_utils.php");
require_once("model/licitacao.model.php");
require_once("classes/db_habilitacaoforn_classe.php");
require_once("classes/db_registroprecovalores_classe.php");

db_postmemory($HTTP_POST_VARS);
if (isset($_GET['chavepesquisa']) && $_GET['chavepesquisa'] != '') {
  $chavepesquisa = $_GET['chavepesquisa'];
}

echo "<script>parent.document.formaba.db_cred.disabled=true;</script>";
// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

$clpcorcamforne               = new cl_pcorcamforne;
$clpcorcamfornelic            = new cl_pcorcamfornelic;
$clpcorcam                    = new cl_pcorcam;
$clpcorcamitem                = new cl_pcorcamitem;
$clpcorcamitemlic             = new cl_pcorcamitemlic;
$clliclicita                  = new cl_liclicita;
$clliclicitem                 = new cl_liclicitem;
$clpcorcamval                 = new cl_pcorcamval;
$oDaoTipoEmpresa              = new cl_liclicitatipoempresa;
$oDaoPcorcamjulgamentologitem = new cl_pcorcamjulgamentologitem;
$clpcorcamjulg                = new cl_pcorcamjulg;


$db_opcao = 2;
$db_botao = true;
$op       = 11;

if (isset($alterar) || isset($excluir) || isset($incluir) || isset($verificado)) {
  $sqlerro = false;
  $clpcorcamforne->pc21_orcamforne = $pc21_orcamforne;
  $clpcorcamforne->pc21_codorc = $pc20_codorc;
  $clpcorcamforne->pc21_numcgm = $pc21_numcgm;
  $clpcorcamforne->pc21_importado = '0';

  //VERIFICA SE O FORNECEDOR ESTÁ BLOQUEADO
  $oForne = db_utils::getDao("pcforne");
  $oForne = $oForne->sql_record($oForne->sql_query($pc21_numcgm));
  $oForne = db_utils::fieldsMemory($oForne);
  if (isset($incluir)) {
    if (!empty($oForne->pc60_databloqueio_ini) && !empty($oForne->pc60_databloqueio_fim)) {

      if (
        strtotime(date("Y-m-d", db_getsession("DB_datausu"))) >= strtotime($oForne->pc60_databloqueio_ini) &&
        strtotime(date("Y-m-d", db_getsession("DB_datausu"))) <= strtotime($oForne->pc60_databloqueio_fim)
      ) {
        $erro_msg  = "\\n\\n Fornecedor " . $oForne->z01_nome . " está bloqueado para participar de licitações !\\n\\n\\n\\n";
        $sqlerro = true;
      }
    }
  }

  //VERIFICA CPF E CNPJ ZERADOS OC 7037
  if (isset($incluir)) {
    $result_cgmzerado = db_query("select z01_cgccpf from cgm where z01_numcgm = {$pc21_numcgm}");
    db_fieldsmemory($result_cgmzerado, 0)->z01_cgccpf;

    if (strlen($z01_cgccpf) == 14) {
      if ($z01_cgccpf == '00000000000000') {
        $sqlerro = true;
        $erro_msg = "ERRO: Número do CNPJ está zerado. Corrija o CGM do fornecedor e tente novamente";
      }
    }

    if (strlen($z01_cgccpf) == 11) {
      if ($z01_cgccpf == '00000000000') {
        $sqlerro = true;
        $erro_msg = "ERRO: Número do CPF está zerado. Corrija o CGM do fornecedor e tente novamente";
      }
    }
  }
  //FIM OC 7037

  if ($sqlerro == false) {

    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$pc21_numcgm} and z09_tipo = 1");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
    $dtsession   = date("Y-m-d", db_getsession("DB_datausu"));

    if ($dtsession < $z09_datacadastro) {
      db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
      $sqlerro = true;
    }

    /**
     * controle de encerramento peri. Patrimonial
     */
    $clcondataconf = new cl_condataconf;
    $resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'), db_getsession('DB_instit'), 'c99_datapat'));
    db_fieldsmemory($resultControle, 0);

    if ($dtsession <= $c99_datapat) {
      db_msgbox("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
      $sqlerro = true;
    }
  }
}

$sSql = "SELECT z01_cgccpf
FROM cgm
WHERE z01_numcgm = $pc21_numcgm";

$result  = db_query($sSql);
$tipocgm = db_utils::fieldsMemory($result, 0)->z01_cgccpf;

$sSql = "SELECT pc81_sequencia,
       pc81_datini,
       pc81_datfin,
       pc81_obs,
       b.z01_nome AS pc81_cgmresp,
       pc81_tipopart
FROM pcfornereprlegal
INNER JOIN cgm a ON a.z01_numcgm = pcfornereprlegal.pc81_cgmforn
INNER JOIN cgm b ON b.z01_numcgm = pcfornereprlegal.pc81_cgmresp
WHERE pc81_cgmforn = $pc21_numcgm
ORDER BY b.z01_nome";

$result = db_query($sSql);

for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

  $dados = db_utils::fieldsMemory($result, $iCont);

  if ($dados->pc81_tipopart == 1) {
    $tipopart1 = $dados->pc81_tipopart;
  } elseif ($dados->pc81_tipopart == 2) {
    $tipopart2 = $dados->pc81_tipopart;
  } elseif ($dados->pc81_tipopart == 3) {
    $tipopart3 = $dados->pc81_tipopart;
  }
}

if (isset($incluir)) {

  if (strlen($tipocgm) == 14) {

    if ((isset($tipopart1) && isset($tipopart2)) || isset($tipopart3)) {

      db_inicio_transacao();


      /*
             * logica para verificaÃ§Ã£o de saldos das modalidades
             */

      //$lSaldoModalidade = licitacao::verificaSaldoModalidade($l20_codigo, $iModadalidade, $iItem, $dtJulgamento)

      //echo ("<pre>".print_r($oLicitacao, 1)."</pre>");
      //die();

      $result = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));

      if ($clliclicita->numrows == 0) {
        $result_dt = $clliclicita->sql_record($clliclicita->sql_query_file($l20_codigo));
        db_fieldsmemory($result_dt, 0);

        $clpcorcam->pc20_dtate = $l20_dataaber;
        $clpcorcam->pc20_hrate = $l20_horaaber;
        $clpcorcam->incluir(null);
        $pc20_codorc = $clpcorcam->pc20_codorc;
        if ($clpcorcam->erro_status == 0) {
          $sqlerro = true;
          $erro_msg = $clpcorcam->erro_msg;
        }
        if ($sqlerro == false) {
          $result_itens = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo and l21_situacao=0"));
          if ($clliclicitem->numrows == 0) {
            echo "<script>
					           alert('Impossivel incluir fornecedores!!Licitação sem itens cadastrados!!');
						   top.corpo.location.href='lic1_fornec001.php';
					        </script>";
            exit;
          }

          for ($w = 0; $w < $clliclicitem->numrows; $w++) {
            db_fieldsmemory($result_itens, $w);
            if ($sqlerro == false) {
              $clpcorcamitem->pc22_codorc = $pc20_codorc;
              $clpcorcamitem->incluir(null);
              $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
              if ($clpcorcamitem->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clpcorcamitem->erro_msg;
              }
            }
            if ($sqlerro == false) {
              $clpcorcamitemlic->pc26_orcamitem = $pc22_orcamitem;
              $clpcorcamitemlic->pc26_liclicitem = $l21_codigo;
              $clpcorcamitemlic->incluir();
              if ($clpcorcamitemlic->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clpcorcamitemlic->erro_msg;
              }
            }
          }
        }
      }
      $result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", " pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc20_codorc"));
      if ($clpcorcamforne->numrows > 0) {
        $sqlerro = true;
        $erro_msg = "ERRO: Número de CGM já cadastrado.";
      }

      if ($sqlerro == false) {
        $clpcorcamforne->pc21_codorc = $pc20_codorc;
        $clpcorcamforne->incluir($pc21_orcamforne);
        $pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
        $erro_msg = $clpcorcamforne->erro_msg;
        if ($clpcorcamforne->erro_status == 0) {
          $sqlerro = true;
        }
      }
      if ($sqlerro == false) {
        $clpcorcamfornelic->pc31_liclicita = $l20_codigo;
        $clpcorcamfornelic->incluir($pc21_orcamforne);
        if ($clpcorcamfornelic->erro_status == 0) {
          $sqlerro = true;
          $erro_msg = $clpcorcamfornelic->erro_msg;
        }
      }
      db_fim_transacao($sqlerro);
      $op = 1;
    } else {
      echo "<script>alert('É necessário cadastrar pelo menos um representante legal e demais membros para o fornecedor.')</script>";
      $op = 1;
    }
  } else {
    db_inicio_transacao();


    /*
         * logica para verificação de saldos das modalidades
         */

    //$lSaldoModalidade = licitacao::verificaSaldoModalidade($l20_codigo, $iModadalidade, $iItem, $dtJulgamento)

    //echo ("<pre>".print_r($oLicitacao, 1)."</pre>");
    //die();

    $result = $clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo));

    if ($clliclicita->numrows == 0) {
      $result_dt = $clliclicita->sql_record($clliclicita->sql_query_file($l20_codigo));
      db_fieldsmemory($result_dt, 0);

      $clpcorcam->pc20_dtate = $l20_dataaber;
      $clpcorcam->pc20_hrate = $l20_horaaber;
      $clpcorcam->incluir(null);
      $pc20_codorc = $clpcorcam->pc20_codorc;
      if ($clpcorcam->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcam->erro_msg;
      }
      if ($sqlerro == false) {
        $result_itens = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo and l21_situacao=0"));
        if ($clliclicitem->numrows == 0) {
          echo "<script>
					           alert('Impossivel incluir fornecedores!!Licitação sem itens cadastrados!!');
						   top.corpo.location.href='lic1_fornec001.php';
					        </script>";
          exit;
        }

        for ($w = 0; $w < $clliclicitem->numrows; $w++) {
          db_fieldsmemory($result_itens, $w);
          if ($sqlerro == false) {
            $clpcorcamitem->pc22_codorc = $pc20_codorc;
            $clpcorcamitem->incluir(null);
            $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;
            if ($clpcorcamitem->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clpcorcamitem->erro_msg;
            }
          }
          if ($sqlerro == false) {
            $clpcorcamitemlic->pc26_orcamitem = $pc22_orcamitem;
            $clpcorcamitemlic->pc26_liclicitem = $l21_codigo;
            $clpcorcamitemlic->incluir();
            if ($clpcorcamitemlic->erro_status == 0) {
              $sqlerro = true;
              $erro_msg = $clpcorcamitemlic->erro_msg;
            }
          }
        }
      }
    }
    $result_igualcgm = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", " pc21_numcgm=$pc21_numcgm and pc21_codorc=$pc20_codorc"));
    if ($clpcorcamforne->numrows > 0) {
      $sqlerro = true;
      $erro_msg = "ERRO: Número de CGM já cadastrado.";
    }

    if ($sqlerro == false) {
      $clpcorcamforne->pc21_codorc = $pc20_codorc;
      $clpcorcamforne->incluir($pc21_orcamforne);
      $pc21_orcamforne = $clpcorcamforne->pc21_orcamforne;
      $erro_msg = $clpcorcamforne->erro_msg;
      if ($clpcorcamforne->erro_status == 0) {
        $sqlerro = true;
      }
    }
    if ($sqlerro == false) {
      $clpcorcamfornelic->pc31_liclicita = $l20_codigo;
      $clpcorcamfornelic->incluir($pc21_orcamforne);
      if ($clpcorcamfornelic->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamfornelic->erro_msg;
      }
    }
    db_fim_transacao($sqlerro);
    $op = 1;
  }
} else if (isset($excluir)) {
  $resultValores = $clpcorcamval->sql_record($clpcorcamval->sql_query_file($pc21_orcamforne, null, "sum(pc23_vlrun) as valor", null, ""));
  db_fieldsmemory($resultValores, 0)->valor;
  if ($valor > 0) {
    $sqlerro = true;
    $erro_msg = "Fornecedor com valores lançados";
  } else {
    if (!$sqlerro) {
      $clpcorcamjulg->excluir(null, $pc21_orcamforne, null);
      if ($clpcorcamjulg->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamjulg->erro_msg;
      }
    }

    if (!$sqlerro) {
      $clpcorcamval->excluir($pc21_orcamforne);
      if ($clpcorcamval->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamval->erro_msg;
      }
    }

    db_inicio_transacao();
    if ($sqlerro == false) {
      $clpcorcamfornelic->excluir($pc21_orcamforne);
      if ($clpcorcamfornelic->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clpcorcamfornelic->erro_msg;
      }
    }

    /**
     * Exclui da pcorcamjulgamentologitem
     */
    if (!$sqlerro) {
      $result = $oDaoPcorcamjulgamentologitem->sql_record($oDaoPcorcamjulgamentologitem->sql_query_file(null, "*", null, "pc93_pcorcamforne = $pc21_orcamforne"));
      if ($oDaoPcorcamjulgamentologitem->numrows > 0) {
        $sWhere = "pc93_pcorcamforne = {$pc21_orcamforne}";
        $oDaoPcorcamjulgamentologitem->excluir(null, $sWhere);

        $erro_msg = $oDaoPcorcamjulgamentologitem->erro_msg;
        if ($oDaoPcorcamjulgamentologitem->erro_status == 0) {
          $sqlerro = true;
        }
      }
    }
    // ini_set('display_errors', 'On');
    // error_reporting(E_ALL);
    if ($sqlerro == false) {
      $clregistroprecovalores = new cl_registroprecovalores;

      $clregistroprecovalores->excluir(null, "pc56_orcamforne = $pc21_orcamforne");

      if ($clregistroprecovalores->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clregistroprecovalores->erro_msg;
      }
    }

    /**
     * excluir habilitacao do fornecedor
     */
    if ($sqlerro == false) {
      $clhabilitacaoforn = new cl_habilitacaoforn;
      $clhabilitacaoforn->excluir(null, "l206_licitacao = {$l20_codigo} and l206_fornecedor = ( select pc21_numcgm from pcorcamforne where pc21_orcamforne={$pc21_orcamforne} limit 1)");

      if ($clhabilitacaoforn->erro_status == 0) {
        $sqlerro = true;
        $erro_msg = $clhabilitacaoforn->erro_msg;
      }
    }

    if ($sqlerro == false) {
      $clpcorcamforne->excluir($pc21_orcamforne);
      $erro_msg = $clpcorcamforne->erro_msg;
      if ($clpcorcamforne->erro_status == 0) {
        $sqlerro = true;
      }
    }

    if ($sqlerro == false) {

      $result_forne = $clpcorcamfornelic->sql_record($clpcorcamfornelic->sql_query(null, "*", null, "pc20_codorc=$pc20_codorc"));

      if ($clpcorcamfornelic->numrows == 0) {

        if ($sqlerro == false) {

          $sWhere = "pc26_orcamitem in                                         ";
          $sWhere .= "(select pcorcamitem.pc22_orcamitem                        ";
          $sWhere .= " from pcorcamitem                                         ";
          $sWhere .= "   inner join pcorcam                                     ";
          $sWhere .= "     on    pcorcam.pc20_codorc = pcorcamitem.pc22_codorc  ";
          $sWhere .= "     where pcorcam.pc20_codorc ={$pc20_codorc})           ";
          $sWhere .= "                                                          ";
          $clpcorcamitemlic->excluir(null, $sWhere);

          if ($clpcorcamitemlic->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcamitemlic->erro_msg;
          }
        }

        if ($sqlerro == false) {

          $sWhere = " pcorcamitem.pc22_codorc in (                          ";
          $sWhere .= " select pc20_codorc                                    ";
          $sWhere .= " from pcorcam                                          ";
          $sWhere .= " where                                                 ";
          $sWhere .= "         pcorcam.pc20_codorc = pcorcamitem.pc22_codorc ";
          $sWhere .= "   and   pcorcam.pc20_codorc = {$pc20_codorc})         ";
          $clpcorcamitem->excluir(null, $sWhere);

          $pc22_orcamitem = $clpcorcamitem->pc22_orcamitem;

          if ($clpcorcamitem->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcamitem->erro_msg;
          }
        }

        if ($sqlerro == false) {

          $clpcorcam->excluir($pc20_codorc);
          if ($clpcorcam->erro_status == 0) {

            $sqlerro = true;
            $erro_msg = $clpcorcam->erro_msg;
          }
        }
        if ($sqlerro == false) {
          $exc_tudo = true;
        }
      }
    }
    $op = 1;
    db_fim_transacao($sqlerro);
  }
} else if (isset($opcao) || (isset($chavepesquisa) && $chavepesquisa != "")) {
  $l20_codigo = $chavepesquisa;
  $result = $clliclicita->sql_record($clliclicita->sql_query_pco($chavepesquisa));
  if ($result != false && $clliclicita->numrows > 0) {
    db_fieldsmemory($result, 0);
  }
  $db_botao = true;
  $op = 1;
}
$l20_codigo = $chavepesquisa;
$result = $clliclicita->sql_record($clliclicita->sql_query_pco($chavepesquisa));
if ($result != false && $clliclicita->numrows > 0) {
  db_fieldsmemory($result, 0);
}

if ($l03_pctipocompratribunal == "102" || $l03_pctipocompratribunal == "103") {
  echo "<script>
     parent.document.formaba.db_cred.disabled=false;
    </script>";
  $clcredenciamento = new cl_credenciamento();
  $result_credenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null, "*", null, "l205_licitacao = $l20_codigo"));

  if (pg_num_rows($result_credenciamento) == 0) {
    $db_botao = false;
  }
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
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table width="790" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>

          <?
          include("forms/db_frmforneclic.php");
          ?>

        </center>
      </td>
    </tr>
  </table>
</body>

</html>
<?


if (isset($alterar) || isset($excluir) || isset($incluir) || isset($verificado)) {
  if (isset($excluir) && isset($exc_tudo) && $exc_tudo == true) {
    db_msgbox($erro_msg);
    //echo "<script>location.href='lic1_fornec001.php';</script>";
  } else {
    if ($sqlerro == true) {
      db_msgbox($erro_msg);
      if ($clpcorcamforne->erro_campo != "") {
        echo "<script> document.form1." . $clpcorcamforne->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1." . $clpcorcamforne->erro_campo . ".focus();</script>";
      }
    } else {
      if (isset($tipopart1) && isset($tipopart2)) {
        db_msgbox($erro_msg);
      }
      //echo "<script>location.href='lic1_fornec001.php?chavepesquisa=$l20_codigo';</script>";
    }
  }
}

$sWhere = "1!=1";
if (isset($pc21_codorc) && !empty($pc21_codorc)) {
  $sWhere = "pc21_codorc=" . @$pc21_codorc;
}

$result_libera = $clpcorcamforne->sql_record($clpcorcamforne->sql_query_file(null, "pc21_codorc", "", $sWhere));
$tranca        = "true";

if ($clpcorcamforne->numrows > 0) {
  $tranca = "false";
}
if ($op == 11) {
  echo "<script>document.form1.pesquisar.click();</script>";
}

$sWhere = "pc21_codorc=" . @$pc20_codorc;
$result_fornaba = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null, "pc21_orcamforne,pc21_codorc,pc21_numcgm,z01_nome", "", $sWhere));
$iNumCgmForn  = db_utils::fieldsMemory($result_fornaba, 0)->pc21_numcgm;
?>

<input type="hidden" id="cgmaba" value="<? echo $iNumCgmForn ?>" />

<script>
  //parent.document.formaba.db_cred.disabled=true;
  //parent.document.formaba.db_hab.disabled=true;

  if (parent.document.formaba.db_cred.onclick != '') {

    var param1 = $('pc20_codorc').value;
    var param2 = $('l20_codigo').value;
    var param3 = $('cgmaba').value;

    top.corpo.iframe_db_cred.location.href = 'lic1_credenciamento001.php?pc20_codorc=' + param1 + '&l20_codigo=' + param2 + '&l205_fornecedor=' + param3;
    //parent.document.formaba.db_cred.disabled=false;
    //parent.document.formaba.db_hab.disabled=false;

  }

  if (parent.document.formaba.db_habi.onclick != '') {

    var param1 = $('pc20_codorc').value;
    var param2 = $('l20_codigo').value;

    top.corpo.iframe_db_habi.location.href = 'lic1_habilitacaoforn001.php?l20_codigo=' + param2 + '&pc20_codorc=' + param1;
    //parent.document.formaba.db_cred.disabled=false;
    //parent.document.formaba.db_hab.disabled=false;

  }
</script>
