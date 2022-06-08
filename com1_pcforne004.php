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
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require("libs/db_app.utils.php");
include("classes/db_pcforne_classe.php");
include("classes/db_pcfornecon_classe.php");
include("classes/db_pcfornemov_classe.php");
include("classes/db_pcfornecert_classe.php");
include("classes/db_condataconf_classe.php");
include("classes/db_licitaparam_classe.php");
include("classes/db_cgm_classe.php");

$clpcforne = new cl_pcforne;
$cllicitaparam = new cl_licitaparam;
$clpcfornecon = new cl_pcfornecon;
$clcgm = new cl_cgm;
db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {
  $sqlerro = false;

  if (strlen($pc60_cnpjcpf) == 14 && $pc60_orgaoreg == 0) {
    $sqlerro = true;
    db_msgbox("Campo Órgão Registro não Selecionado!");
  }


  db_inicio_transacao();

  if ($sqlerro == false) {

    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$pc60_numcgm} and z09_tipo = 1");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
    $dtsession   = date("Y-m-d", db_getsession("DB_datausu"));

    if ($dtsession < $z09_datacadastro) {
      db_msgbox("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
      $sqlerro = true;
    }

    $rsParamLic = $cllicitaparam->sql_record($cllicitaparam->sql_query(null, "*", null, "l12_instit = " . db_getsession('DB_instit')));
    db_fieldsmemory($rsParamLic, 0)->l12_validacadfornecedor;

    if ($l12_validacadfornecedor == "t") {

      if ($z01_telef == "") {
        db_msgbox("Usuário: Campo Telefone não informado !");
        $sqlerro = true;
      }

      if ($z01_email == "") {
        db_msgbox("Usuário: Campo Email não informado !");
        $sqlerro = true;
      }

      /**
       * Verifica conta bancaria
       */
      $rsContaBancaria = $clpcfornecon->sql_record($clpcfornecon->sql_query(null, "*", null, "pc63_numcgm={$pc60_numcgm}"));
      //db_criatabela($rsContaBancaria);exit;
      if (pg_numrows($rsContaBancaria) == 0) {
        db_msgbox("Usuário: E necessario cadastrar ao menos uma conta bancaria !");
        $sqlerro = true;

        echo "
              <script>
                  function js_db_libera(){         
                    parent.document.formaba.pcfornecon.disabled=false;
                    top.corpo.iframe_pcfornecon.location.href='com1_pcfornecon001.php?pc63_numcgm=" . @$pc60_numcgm . "';
                ";
        echo "}\n
                js_db_libera();
              </script>\n
            ";
      }
    }

    /**
     * alterando email e telefone OC15701
     */
    if ($sqlerro == false) {
      $clcgm->z01_numcgm = $pc60_numcgm;
      $clcgm->z01_email = $z01_email;
      $clcgm->z01_telef = $z01_telef;
      $clcgm->alterar($pc60_numcgm);
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
  if ($sqlerro == false) {
    $clpcforne->pc60_usuario = db_getsession("DB_id_usuario");
    $clpcforne->pc60_hora = db_hora();
    $clpcforne->incluir($pc60_numcgm);
    if ($clpcforne->erro_status == 0) {
      $sqlerro = true;
    }
    $erro_msg = $clpcforne->erro_msg;
    db_msgbox($erro_msg);
  }
  db_fim_transacao();
  $db_opcao = 1;
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">

  <?
  db_app::load("scripts.js, strings.js, prototype.js,datagrid.widget.js, widgets/dbautocomplete.widget.js");
  db_app::load("widgets/windowAux.widget.js");
  ?>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <br />
  <center>
    <?
    include("forms/db_frmpcforne.php");
    ?>
  </center>

  <script>
    oAutoComplete = new dbAutoComplete($('z01_nome'), 'com4_pesquisafornecedor.RPC.php');
    oAutoComplete.setTxtFieldId(document.getElementById('pc60_numcgm'));
    oAutoComplete.show();
  </script>
</body>

</html>
<?
if (isset($incluir)) {
  if ($sqlerro == true) {
    if ($clpcforne->erro_campo != "") {
      echo "<script> document.form1." . $clpcforne->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clpcforne->erro_campo . ".focus();</script>";
    };
  } else {
    db_redireciona("com1_pcforne005.php?liberaaba=true&chavepesquisa=$pc60_numcgm");
  }
}
?>