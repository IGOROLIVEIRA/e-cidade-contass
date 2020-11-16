<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitaproc_classe.php");
require_once("classes/db_pccflicitapar_classe.php");
require_once("classes/db_pccflicitanum_classe.php");
require_once("classes/db_pccfeditalnum_classe.php");
require_once("classes/db_db_usuarios_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_liclocal_classe.php");
require_once("classes/db_liccomissao_classe.php");
require_once("classes/db_condataconf_classe.php");

include("classes/db_decretopregao_classe.php");

db_postmemory($HTTP_POST_VARS);

$clliclicita         = new cl_liclicita;
$clliclicitaproc     = new cl_liclicitaproc;
$clpccflicitapar     = new cl_pccflicitapar;
$clpccflicitanum     = new cl_pccflicitanum;
$clpccfeditalnum     = new cl_pccfeditalnum;
$cldb_usuarios       = new cl_db_usuarios;
$clliclicitasituacao = new cl_liclicitasituacao;
$clcflicita          = new cl_cflicita;
$cldecretopregao     = new cl_decretopregao;

$db_opcao = 1;
$db_botao = true;

if(isset($incluir)){

  $oPost = db_utils::postmemory($_POST);

  // ID's do l03_pctipocompratribunal com base no l20_codtipocom escolhido pelo usurio
  $sSql = $clcflicita->sql_query_file((int)$oPost->l20_codtipocom,'distinct(l03_pctipocompratribunal)');
  $aCf = db_utils::getColectionByRecord($clcflicita->sql_record($sSql));
  $iTipoCompraTribunal = (int)$aCf[0]->l03_pctipocompratribunal;

  //Casos em que o Tipo de Licitao e Natureza do Procedimento devem ser verificados
  $aTipoLicNatProc = array(50,48,49,53,52,54);

  $erro = false;
  $msg = '';

  /*
    Verifica se os Campos "Tipo de Licitao", "Natureza do Procedimento" no foram selecionados.
  */
  if(in_array($iTipoCompraTribunal,$aTipoLicNatProc)){

    if( $oPost->l20_tipliticacao == '0' || empty($oPost->l20_tipliticacao) ){
      $msg .= 'Campo Tipo de Licitacao nao informado\n\n';
      $erro = true;
    }
    if( $oPost->l20_tipnaturezaproced == '0' || empty($oPost->l20_tipnaturezaproced) ){
      $msg .= 'Campo Natureza do Procedimento nao informado\n\n';
      $erro = true;
    }

  }

  /*
    Verifica se o Campo "Natureza do Objeto" no foi selecionado.
  */
  if( $oPost->l20_naturezaobjeto == '0' || empty($oPost->l20_naturezaobjeto) ){
    $msg .= 'Campo Natureza do Objeto nao informado\n\n';
    $erro = true;
  }

  db_inicio_transacao();

  $sqlerro    = false;
  $anousu     = date('Y',db_getsession("DB_datausu"));
  $instit     = db_getsession("DB_instit") ;
  $anousu     = db_getsession("DB_anousu");

  	if(in_array(db_utils::fieldsMemory($clcflicita->sql_record($clcflicita->sql_query($l20_codtipocomdescr,"distinct l03_pctipocompratribunal")),0)->l03_pctipocompratribunal,array("52","53"))){
  		$result = $cldecretopregao->sql_record($cldecretopregao->sql_query('','*'));
  		if($cldecretopregao->numrows == 0){
  			$erro_msg="Não há decreto pregão";
    		$sqlerro = true;
  		}
  	}
	//verifica se as duas modalidades esto configuradas.
	$result_modalidade=$clpccflicitapar->sql_record($clpccflicitapar->sql_query_modalidade(null,"*",null,"l25_codcflicita = $l20_codtipocom and l25_anousu = $anousu and l03_instit = $instit"));
  if ($clpccflicitapar->numrows == 0){
	  $erro_msg="Verifique se esta configurado a numeração de licitação por modalidade.";
    $sqlerro = true;
	}

	$result_numgeral=$clpccflicitanum->sql_record($clpccflicitanum->sql_query_file(null,"*",null,"l24_instit=$instit and l24_anousu=$anousu"));
	if ($clpccflicitanum->numrows==0){
	 $erro_msg="Verifique se esta configurado a numeração de licitação por edital.";
	 $sqlerro = true;
	}

	$result_numedital=$clpccfeditalnum->sql_record($clpccfeditalnum->sql_query_file(null,"max(l47_numero) as l47_numero",null,"l47_instit=$instit and l47_anousu=$anousu"));
  if ($clpccfeditalnum->numrows==0){
	 $erro_msg="Verifique se esta configurado a numeração do edital por licitação.";
	 $sqlerro = true;
	}

	//numeracao por modalidade
	if ($sqlerro == false){

	  if ($clpccflicitapar->numrows > 0){
	  	db_fieldsmemory($result_modalidade,0,2);
	    $l20_numero=$l25_numero+1;
	  } else {
	    $erro_msg="Configure a numeração de licitação por modalidade.";
	    $sqlerro = true;
	  }

	  // if ($sqlerro == false){
      // #1
	    // $clpccflicitapar->l25_numero=$l25_numero+1;
	    // $clpccflicitapar->alterar_where(null,"l25_codigo = $l25_codigo and l25_anousu = $anousu");
	  // }

	  //numeração geral

	  if ($clpccflicitanum->numrows>0){
	    db_fieldsmemory($result_numgeral,0);
	    $l20_edital=$l24_numero+1;
	  } else {
		$erro_msg="Configure a numeração de licitação por edital.";
		$sqlerro = true;
	  }

    if(db_getsession('DB_anousu') >= 2020){
        if ($clpccfeditalnum->numrows>0){
            db_fieldsmemory($result_numedital,0);
            $aModalidades = array(48, 49, 50, 52, 53, 54);

            if(db_getsession('DB_anousu') >= 2021){
                array_push($aModalidades, 102, 103);
            }

            if(in_array($modalidade_tribunal, $aModalidades)){
                $l20_nroedital = $l47_numero + 1;
            }
        } else {
            $erro_msg="Configure a numeração do edital.";
            $sqlerro = true;
        }
    }

	  // if ($sqlerro == false){
      // #2
		  // $clpccflicitanum->l24_numero=$l24_numero+1;
		  // $clpccflicitanum->alterar_where(null,"l24_instit=$instit and l24_anousu=$anousu");
	  // } else {
	  //   $sqlerro = true;
	  // }


	  //verifica se ja existe licitacao por modalidade
    $sqlveriflicitamod = $clpccflicitapar->sql_query_mod_licita(null,"l25_numero as xx",null,"l20_instit=$instit and l25_anousu=$anousu and l20_codtipocom=$l20_codtipocom and l20_numero=$l20_numero and l20_anousu=$anousu");
		$result_verif_licitamod=$clpccflicitapar->sql_record( $sqlveriflicitamod );

		if ($clpccflicitapar->numrows>0){
		  $erro_msg="Ja existe licitação numero $l20_numero.Verificar o cadastro por modalidade.";
		  $sqlerro = true;
		}

		//verifica se existe licitao por edital
		$result_verif_licitaedital=$clpccflicitanum->sql_record($clpccflicitanum->sql_query_edital(null,"l20_edital as yy",null,"l20_instit=$instit and l25_anousu=$anousu and l20_edital= $l20_edital and l20_anousu=$anousu"));

		if ($clpccflicitanum->numrows>0){
		  $erro_msg="Ja existe licitação numero $l20_edital.Verificar numeração por edital.";
		  $sqlerro = true;
		}

		//verifica se existe numero do edital

		if($l20_nroedital){
        $result_verif_editalnum=$clpccfeditalnum->sql_record($clpccfeditalnum->sql_query_edital(null,"l20_edital as yy",null,"l20_instit=$instit and l47_anousu=$anousu and l20_nroedital= $l20_nroedital and l20_anousu=$anousu"));
        if ($clpccfeditalnum->numrows>0){
            $erro_msg="Ja existe edital da licitação com numero $l47_edital.Verificar numeração por edital.";
            $sqlerro = true;
        }
    }


//    /**
//     * Verificar Encerramento Periodo Contabil
//     */
//    if (!empty($l20_dtpubratificacao)) {
//			$clcondataconf = new cl_condataconf;
//	    if (!$clcondataconf->verificaPeriodoContabil($l20_dtpubratificacao)) {
//	      $erro_msg = $clcondataconf->erro_msg;
//	      $sqlerro  = true;
//	    }
//    }

        /**
         * Verificar Encerramento Periodo Patrimonial
         */
        if (!empty($l20_dtpubratificacao)) {
            $clcondataconf = new cl_condataconf;
            if (!$clcondataconf->verificaPeriodoPatrimonial($l20_dtpubratificacao)) {
                $erro_msg = $clcondataconf->erro_msg;
                $sqlerro  = true;
            }
		}

		if ($modalidade_tribunal == 52 || $modalidade_tribunal == 53) {

			$verifica = $clliclicita->verificaMembrosModalidade("pregao", $l20_equipepregao);
			if (!$verifica) {
				$erro_msg = "Para as modalidades Pregao presencial e Pregao eletronico  necessario\nque a Comissao de Licitacao tenham os tipos Pregoeiro e Membro da Equipe de Apoio";
				$sqlerro = true;
			}

		}
		else if ($modalidade_tribunal == 48 || $modalidade_tribunal == 49 || $modalidade_tribunal == 50) {

			$verifica = $clliclicita->verificaMembrosModalidade("outros", $l20_equipepregao);
			if (!$verifica) {
				$erro_msg = "Para as modalidades Tomada de Preços, Concorrencia e Convite  necessario\nque a Comissao de Licitacao tenham os tipos Secretario, Presidente e Membro da Equipe de Apoio";
				$sqlerro = true;
			}

		}

		if ($sqlerro == false){
			$clliclicita->l20_numero      	  =  $l20_numero;
			$clliclicita->l20_edital      	  =  $l20_edital;
			if($anousu >= 2020){
                $clliclicita->l20_nroedital      	=  $l20_nroedital;
			    $clliclicita->l20_exercicioedital =  $anousu;
			}
			$clliclicita->l20_anousu      	  =  $anousu;
			$clliclicita->l20_licsituacao = '0';
			$clliclicita->l20_instit      = db_getsession("DB_instit");

      		$clliclicita->l20_criterioadjudicacao = $l20_criterioadjudicacao;//OC3770
            $clliclicita->incluir(null);

		  	if ($clliclicita->erro_status=="0"){
		  		$erro_msg = $clliclicita->erro_msg;
		  		$sqlerro=true;
		  	}
    	}

		if ( !$sqlerro && $lprocsis == 's') {

			$clliclicitaproc->l34_liclicita    = $clliclicita->l20_codigo;
			$clliclicitaproc->l34_protprocesso = $l34_protprocesso;
			$clliclicitaproc->incluir(null);

			if ( $clliclicitaproc->erro_status == 0 ) {
				$erro_msg = $clliclicitaproc->erro_msg;
				$sqlerro  = true;
			}

		}

	  if ($sqlerro == false) {

			$l11_sequencial = '';
	    $clliclicitasituacao->l11_id_usuario  = DB_getSession("DB_id_usuario");
	    $clliclicitasituacao->l11_licsituacao = '0';
	    $clliclicitasituacao->l11_liclicita   = $clliclicita->l20_codigo;
			$clliclicitasituacao->l11_obs         = "Licitacao em andamento.";
	    $clliclicitasituacao->l11_data        = date("Y-m-d",DB_getSession("DB_datausu"));
	    $clliclicitasituacao->l11_hora        = DB_hora();
      $clliclicitasituacao->incluir($l11_sequencial);

	    $erro_msg = " Licitacao {$l03_descr} número {$l20_numero} incluida com sucesso.";

	    if ($clliclicitasituacao->erro_status == 0){
			  $erro_msg = $clliclicitasituacao->erro_msg;
	      $sqlerro = true;
		  }

	    $codigo   = $clliclicita->l20_codigo;
		  $tipojulg = $clliclicita->l20_tipojulg;

      $clpccflicitapar->l25_numero=$l25_numero+1;
      $clpccflicitapar->alterar_where(null,"l25_codigo = $l25_codigo and l25_anousu = $anousu");

      $clpccflicitanum->l24_numero=$l24_numero+1;
      $clpccflicitanum->alterar_where(null,"l24_instit=$instit and l24_anousu=$anousu");

      if(db_getsession('DB_anousu') >= 2020){
          $clpccfeditalnum->l47_numero=$l47_numero+1;
          $clpccfeditalnum->l47_instit=db_getsession('DB_instit');
          $clpccfeditalnum->l47_anousu=db_getsession('DB_anousu');
          $clpccfeditalnum->incluir(null);
      }
    }

		// db_fim_transacao(false);
	  db_fim_transacao($sqlerro);
	}
}
$l20_liclocal = 0;

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color: #CCCCCC;" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
	    <div class="container">
				<?php
				  require_once("forms/db_frmliclicita.php");
				?>
      </div>
	  </td>
  </tr>
</table>
</body>
</html>
<?
if(isset($incluir)){
  if($erro){
    echo "<script>alert('".$msg."');</script>";
    die();
  }
  if($clliclicita->erro_status=="0"){
    $clliclicita->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clliclicita->erro_campo!=""){
      echo "<script> document.form1.".$clliclicita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clliclicita->erro_campo.".focus();</script>";
    }
  } else {

  	db_msgbox($erro_msg);
    if ($sqlerro==false) {
		if (db_getsession("DB_anousu") >= 2016) {
			if($l20_tipojulg == 3){
				echo "<script>parent.document.formaba.liclicitemlote.disabled=false;</script>";
			}
			echo " <script>
		           parent.iframe_liclicita.location.href='lic1_liclicita002.php?chavepesquisa=$codigo';\n
		           parent.iframe_liclicitem.location.href='lic1_liclicitemalt001.php?licitacao=$codigo';\n
		           parent.document.formaba.resplicita.disabled=false;
		           parent.mo_camada('resplicita');
	           </script> ";
		}else{
			if($l20_tipojulg == 3){
				echo "<script>parent.document.formaba.liclicitemlote.disabled=false;</script>";
			}
			echo " <script>
		           parent.iframe_liclicita.location.href='lic1_liclicita002.php?chavepesquisa=$codigo';\n
		           parent.iframe_liclicitem.location.href='lic1_liclicitemalt001.php?licitacao=$codigo';\n
		           parent.mo_camada('liclicitem');
	           </script> ";
		}
	}
  }
}
?>
