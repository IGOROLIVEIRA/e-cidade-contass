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
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("dbforms/db_funcoes.php");

require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitaata_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_registroprecojulgamento_classe.php");
require_once("classes/db_atatemplategeral_classe.php");
require_once("classes/db_parecerlicitacao_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_homologacaoadjudica_classe.php");

require_once('dbagata/classes/core/AgataAPI.class');
require_once("model/documentoTemplate.model.php");

require_once("model/licitacao.model.php");
require_once("model/MaterialCompras.model.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$oDaoLogJulgamento     = db_utils::getDao('pcorcamjulgamentolog');
$oDaoLogJulgamentoItem = db_utils::getDao('pcorcamjulgamentologitem');

$clrotulo              = new rotulocampo();
$clpcorcam             = new cl_pcorcam;
$clpcorcamjulg         = new cl_pcorcamjulg;
$clliclicita           = new cl_liclicita;
$clliclicitaata        = new cl_liclicitaata;
$clliclicitasituacao   = new cl_liclicitasituacao;
$oDaoRegistroPrecoJulg = new cl_registroprecojulgamento;
$clAtaTemplateGeral    = new cl_atatemplategeral;
$clparecerlicitacao    = new cl_parecerlicitacao;
$clcflicita            = new cl_cflicita;
$clhomologadjudica     = new cl_homologacaoadjudica;

$clpcorcam->rotulo->label();
$clrotulo->label("l20_codigo");

$erro_msg       = "";
$db_botao       = true;
$sqlerro        = false;
$lRegistroPreco = false;
$lListaModelos  = false;
$db_opcao       = 1;

if (isset($_SESSION["modeloataselecionadojulgamento"])) {
  $documentotemplateata = $_SESSION["modeloataselecionadojulgamento"];
}

if (isset($l20_codigo) && $l20_codigo) {

  $lListaModelos   = true;

  $sCamposModelos  = "db82_sequencial, ";
  $sCamposModelos .= "db82_descricao   ";

  $sSqlTemplateModalidade = $clliclicita->sql_query_modelosatas($l20_codigo, $sCamposModelos);
  $rsTemplateModalidade   = $clliclicita->sql_record($sSqlTemplateModalidade);

  if ( $clliclicita->numrows > 0 ) {
    $rsModelos = $rsTemplateModalidade;
  } else {

    $rsTemplateGeral = $clAtaTemplateGeral->sql_record($clAtaTemplateGeral->sql_query(null,$sCamposModelos));
    if ( $clAtaTemplateGeral->numrows > 0 ) {
      $rsModelos = $rsTemplateGeral;
    } else {
      $lListaModelos = false;
    }
  }

  $sSqlDadosLicitacao = $clliclicita->sql_query_file($l20_codigo);

  $rsDadosLicitacao   = $clliclicita->sql_record($sSqlDadosLicitacao);
  if ($clliclicita->numrows > 0) {
    $oDadosLicitacao  = db_utils::fieldsMemory($rsDadosLicitacao, 0);
    $lRegistroPreco   = $oDadosLicitacao->l20_usaregistropreco == 't' ? true : false;
    if ($oDadosLicitacao->l20_licsituacao != 0 && $oDadosLicitacao->l20_licsituacao != 11) {
      $db_opcao = 3;
    }
  }
}

if (isset($confirmar) && trim($confirmar) != "") {

	if(!$dtjulgamento){
		$erro_msg = 'Data do Julgamento não informada. Verifique!';
		$sqlerro = true;
	}

	$dtjulgamento = join('-', array_reverse(explode('/', $dtjulgamento)));

	if(!$sqlerro){
        $sqlTribunal = $clcflicita->sql_query_file($oDadosLicitacao->l20_codtipocom,'l03_pctipocompratribunal', '');
        $rsTribunal = $clcflicita->sql_record($sqlTribunal);
        $iTribunal = db_utils::fieldsMemory($rsTribunal, 0)->l03_pctipocompratribunal;

        // 1ª validação
        if($dtjulgamento < $oDadosLicitacao->l20_datacria){
            $erro_msg = 'Data de Julgamento menor que a data de Abertura de Procedimento Administrativo!';
            $sqlerro = true;
        }
    }

    // 2ª validação
    if(!$sqlerro){
        if(in_array($iTribunal, array(49, 50, 51, 52, 53, 54))){
            $dataaber = $oDadosLicitacao->l20_dataaber;
            $dtpublic = $oDadosLicitacao->l20_dtpublic;
            $recdocumentacao = $oDadosLicitacao->l20_recdocumentacao;
            $public1 = $oDadosLicitacao->l20_datapublicacao1;
            $public2 = $oDadosLicitacao->l20_datapublicacao2;

            if($dtjulgamento < $dataaber){
				$erro_msg = 'Data inválida! Data de Julgamento menor que a Data de Abertura da Licitação\nVerifique!';
				$sqlerro = true;
            }
            if($dtjulgamento < $dtpublic){
				$erro_msg = 'Data inválida! Data de Julgamento menor que a Data de Publicação da Licitação\nVerifique!';
				$sqlerro = true;
            }
            if($dtjulgamento < $recdocumentacao){
				$erro_msg = 'Data inválida! Data de Julgamento menor que a Data de Recebimento da Documentação.\nVerifique!';
				$sqlerro = true;
            }
            if($dtjulgamento < $public1){
				$erro_msg = 'Data inválida! Data de Julgamento menor que a Data Publicação Edital Veiculo 1 .\nVerifique!';
				$sqlerro = true;
            }
            if($dtjulgamento < $public2){
                $erro_msg = 'Data inválida! Data de Julgamento menor que a Data Publicação Edital Veiculo 2.\nVerifique!';
                $sqlerro = true;
            }

//            4ª validação
            if(!$sqlerro){
                $sqlHomoAdjudica = $clhomologadjudica->sql_query('', 'l202_datahomologacao, l202_dataadjudicacao',
                    '', 'l202_licitacao = ' . $l20_codigo);
                $rsHomoAdjudica = $clhomologadjudica->sql_record($sqlHomoAdjudica);
                $oHomoAdjudica = db_utils::fieldsMemory($rsHomoAdjudica, 0);

                if($oHomoAdjudica->l202_datahomologacao && $oHomoAdjudica->l202_dataadjudicacao){
                    if($dtjulgamento > $oHomoAdjudica->l202_datahomologacao){
						$erro_msg = 'Data de Julgamento é maior que Data da Homologação ou maior que a data de adjudicação.';
						$sqlerro = true;
                    }

                    if($dtjulgamento > $oHomoAdjudica->l202_dataadjudicacao){
                        $erro_msg = 'Data de Julgamento é maior que Data da Homologação ou maior que a data de adjudicação.';
                        $sqlerro = true;
                    }
                }
            }
        }
    }

//     3ª validação
    if(!$sqlerro){
		$sqlParecer = $clparecerlicitacao->sql_query('', 'l200_data', '',
			'l200_licitacao = ' . $l20_codigo);
		$rsParecer = $clparecerlicitacao->sql_record($sqlParecer);
		$dataParecer = db_utils::fieldsMemory($rsParecer, 0)->l200_data;

		if($dataParecer){
            if($dtjulgamento > $dataParecer || is_null($dataParecer)){
                $erro_msg = 'Data de Julgamento maior que data do Parecer. Verifique!';
                $sqlerro = true;
            }
        }
    }

//    5ª validação
    if(in_array($iTribunal, array(100, 101, 102, 103)) && !$sqlerro){
		if($dtjulgamento > $oDadosLicitacao->l20_dtpubratificacao && $oDadosLicitacao->l20_dtpubratificacao){
		    $erro_msg = 'Data de Julgamento é maior que a Data de Publicação do Termo de Ratificação. Verifique!';
		    $sqlerro = true;
        }
    }

    if(!$sqlerro) {

		$vitens = explode(":", $itens);
		$vpcorcamjulg = array(array());
		$linha = 0;

		$_SESSION["modeloataselecionadojulgamento"] = $documentotemplateata;

		for ($i = 0; $i < count($vitens); $i++) {

			$str = $vitens[$i];
			$vetor = explode(",", $str);

			/**
			 * verificamos saldo modalidade para cada item da licitacao
			 */

			$iModalidade = $oDadosLicitacao->l20_codtipocom;
//			$dtJulgamento = date("Y-m-d", db_getsession("DB_datausu"));
			$iItem = trim($vetor[0]);

			if ($iItem != null) {
				try {

					$oVerificaSaldo = licitacao::verificaSaldoModalidade($iModalidade, $iItem, $dtjulgamento);
				} catch (Exception $oErro) {

					$erro_msg = $oErro->getMessage();
					$sqlerro = true;
				}
			}

			if (!$sqlerro) {

				if (!$oVerificaSaldo->lPossuiSaldo && $iItem != null) {

					$sqlerro = true;
					$erro_msg = $oVerificaSaldo->sMensagem;
				}
			}

			if (trim($vetor[0]) != "" && trim($vetor[1]) != "") {

				$vpcorcamjulg[$linha]["item"] = $vetor[0];
				$vpcorcamjulg[$linha]["forne"] = $vetor[1];
				$linha++;
			}
		}
	}

    if ($linha == 0 && !$sqlerro) {

        $sqlerro  = true;
        $erro_msg = "Nenhum item a ser julgado.";
    }

  if (isset($documentotemplateata) && !empty($documentotemplateata)) {

    if ($sqlerro == false) {

      $clagata = new cl_dbagata("licitacao/atas.agt");
      $oApi    = $clagata->api;

      $iCasasDecimais     = 2;

      $aParametrosEmpenho = db_stdClass::getParametro('empparametro', array(db_getsession('DB_anousu')));

      if (count($aParametrosEmpenho) > 0) {
        $iCasasDecimais = $aParametrosEmpenho[0]->e30_numdec;
      }

      $sNomeArquivoSxw  = "ata_licitacao_{$l20_codigo}.sxw";
      $sCaminhoSalvoSxw = "tmp/{$sNomeArquivoSxw}";

      $oApi->setOutputPath($sCaminhoSalvoSxw);
      $oApi->setParameter('$licitacao', $l20_codigo);

      if ($sqlerro == false) {

        try {
          $oDocumentoTemplate = new documentoTemplate(5, $documentotemplateata);
        } catch (Exception $eException){

          $erro_msg = str_replace("\\n", "\n", $eException->getMessage());
          $sqlerro  = true;
        }

        $lProcessado = $oApi->parseOpenOffice($oDocumentoTemplate->getArquivoTemplate());

        if ($lProcessado) {

        	db_inicio_transacao();

          $iOidGravaArquivo = pg_lo_create();
          $sStringArquivo   = file_get_contents($sCaminhoSalvoSxw);

          if ( !$sStringArquivo ) {
            $erro_msg = "Falha ao abrir o arquivo {$sCaminhoSalvoSxw}! Modelo de ata inicial não foi gerado.";
            $sqlerro  = true;
          }

          $oLargeObject = pg_lo_open($iOidGravaArquivo, "w");
          if (!$oLargeObject) {
            $erro_msg = "Falha ao buscar objeto do banco de dados! Modelo de ata inicial não foi gerado.";
            $sqlerro  = true;
          }

          $lObjetoEscrito = pg_lo_write($oLargeObject, $sStringArquivo);
          if (!$lObjetoEscrito) {
            $erro_msg = "Falha na escrita do objeto no banco de dados! Modelo de ata inicial não foi gerado.";
            $sqlerro  = true;
          }

          pg_lo_close($oLargeObject);

          $clliclicitaata->l39_arqnome        = $sNomeArquivoSxw;
          $clliclicitaata->l39_arquivo        = $iOidGravaArquivo;
          $clliclicitaata->l39_liclicita      = $l20_codigo;
          $clliclicitaata->l39_posicaoinicial = 'true';
          $clliclicitaata->incluir(null);
          if ($clliclicitaata->erro_status == 0) {

            $erro_msg = $clliclicitaata->erro_msg;
            $sqlerro  = true;
          }
        } else {

          $erro_msg = "Falha ao gerar modelo de ata inicial!";
          $sqlerro  = true;
        }
      }
      db_fim_transacao($sqlerro);
    }
  }

  if ($sqlerro == false) {

    db_inicio_transacao();

    $dtData  =  date("Y-m-d",db_getsession('DB_datausu'));
    $sHora   =  date("H:i");

    $oDaoLogJulgamento->pc92_sequencial      = null ;
    $oDaoLogJulgamento->pc92_usuario         = db_getsession('DB_id_usuario');
    $oDaoLogJulgamento->pc92_datajulgamento  = $dtjulgamento;
    $oDaoLogJulgamento->pc92_hora            = $sHora;
    $oDaoLogJulgamento->pc92_ativo           = "true";
    $oDaoLogJulgamento->incluir(null);

    if ($oDaoLogJulgamento->erro_status == 0) {

      $erro_msg = $oDaoLogJulgamento->erro_msg;
      $sqlerro  = true;
    }

    for ($x = 0; $x < $linha; $x++) {

      $pc24_orcamitem   = $vpcorcamjulg[$x]["item"];
      $pc24_orcamforne  = $vpcorcamjulg[$x]["forne"];

      $sWhereOrcamVal = "pc23_orcamitem = {$pc24_orcamitem} and pc23_orcamforne = {$pc24_orcamforne}";
      $oDaoOrcamVal   = db_utils::getDao('pcorcamval');
      $sSqlOrcamVal   = $oDaoOrcamVal->sql_query_file(null, null, "pc23_vlrun", null, $sWhereOrcamVal);
      $rsOrcamVal     = $oDaoOrcamVal->sql_record($sSqlOrcamVal);

      $nValorUnitario = db_utils::fieldsMemory($rsOrcamVal, 0)->pc23_vlrun;

      if ($oDaoOrcamVal->numrows == 0) {

        $erro_msg = $oDaoOrcamVal->erro_msg;
        $sqlerro  = true;
        break;
      }

      $rResultado = db_query("
            select pc24_orcamforne
            from pcorcamjulg
              where pc24_orcamforne = {$pc24_orcamforne} and pc24_orcamitem = {$pc24_orcamitem}
      ");


      if (pg_num_rows($rResultado) > 0) {
        //db_inicio_transacao();
        $clpcorcamjulg->excluir($pc24_orcamitem,$pc24_orcamforne);
        //db_fim_transacao();
        if ($clpcorcamjulg->erro_status == 0) {
          $erro_msg = $clpcorcamjulg->erro_msg;
          $sqlerro=true;
        }
      }

      $clpcorcamjulg->pc24_orcamitem  = $pc24_orcamitem;
      $clpcorcamjulg->pc24_orcamforne = $pc24_orcamforne;
      $clpcorcamjulg->pc24_pontuacao  = 1;

      $clpcorcamjulg->incluir($pc24_orcamitem,$pc24_orcamforne);
      if ($clpcorcamjulg->erro_status == 0){

        $erro_msg = $clpcorcamjulg->erro_msg;
        $sqlerro  = true;
        break;
      }

      if ($lRegistroPreco) {
        /**
         * buscamos o código do item do registro de preço , e o valor unitário para inserir em registroprecojulgamento
         */
        $sSqlDadosRegistroPreco  = "SELECT pc81_solicitem, ";
        $sSqlDadosRegistroPreco .= "       pc23_vlrun ";
        $sSqlDadosRegistroPreco .= "  from pcorcamitem ";
        $sSqlDadosRegistroPreco .= "       inner join pcorcamitemlic on pc26_orcamitem    = pc22_orcamitem ";
        $sSqlDadosRegistroPreco .= "       inner join liclicitem     on l21_codigo        = pc26_liclicitem ";
        $sSqlDadosRegistroPreco .= "       inner join pcprocitem     on l21_codpcprocitem = pc81_codprocitem ";
        $sSqlDadosRegistroPreco .= "       inner join pcorcamval     on pc23_orcamforne   = {$pc24_orcamforne} ";
        $sSqlDadosRegistroPreco .= "                                and pc23_orcamitem    = pc22_orcamitem";
        $sSqlDadosRegistroPreco .= "       inner join solicitem      on pc11_codigo       = pc81_solicitem   ";
        $sSqlDadosRegistroPreco .= " where pc23_orcamforne = {$pc24_orcamforne} ";
        $sSqlDadosRegistroPreco .= "   and pc23_orcamitem  = {$pc24_orcamitem} ";

        $rsRegistroPreco = db_query($sSqlDadosRegistroPreco);
        if (pg_num_rows($rsRegistroPreco) != 1) {

          $sqlerro  = true;
          $erro_msg = "Não existem registros de preços para esta solicitação.";
          break;
        }

        if ($sqlerro == false) {

          $oDadosRegistroPreco = db_utils::fieldsMemory($rsRegistroPreco, 0);
          $oDaoRegistroPrecoJulg->pc65_ativo         = 1;
          $oDaoRegistroPrecoJulg->pc65_orcamforne    = $pc24_orcamforne;
          $oDaoRegistroPrecoJulg->pc65_orcamitem     = $pc24_orcamitem;
          $oDaoRegistroPrecoJulg->pc65_solicitem     = $oDadosRegistroPreco->pc81_solicitem;
          $oDaoRegistroPrecoJulg->pc65_valorunitario = $oDadosRegistroPreco->pc23_vlrun;
          $oDaoRegistroPrecoJulg->pc65_pontuacao     = 1;
          $oDaoRegistroPrecoJulg->incluir(null);

          if ($oDaoRegistroPrecoJulg->erro_status == 0) {

            $erro_msg = $oDaoRegistroPrecoJulg->erro_msg;
            $sqlerro  = true;
            break;
          }
        }

      }

      $oDaoLogJulgamentoItem->pc93_sequencial            = null;
      $oDaoLogJulgamentoItem->pc93_pcorcamjulgamentolog  = $oDaoLogJulgamento->pc92_sequencial;
      $oDaoLogJulgamentoItem->pc93_pcorcamitem           = $pc24_orcamitem;
      $oDaoLogJulgamentoItem->pc93_pcorcamforne          = $pc24_orcamforne;
      $oDaoLogJulgamentoItem->pc93_valorunitario         = $nValorUnitario;
      $oDaoLogJulgamentoItem->pc93_pontuacao             = 1;
      $oDaoLogJulgamentoItem->incluir(null);

      if ($oDaoLogJulgamentoItem->erro_status == 0){

        $erro_msg = $oDaoLogJulgamentoItem->erro_msg;
        $sqlerro  = true;
        break;
      }
    }

    if ($sqlerro == false) {
      $clliclicita->l20_licsituacao = 1;
      $clliclicita->l20_codigo      = $l20_codigo;
      $clliclicita->l20_regata = $l20_regata;
      $clliclicita->l20_interporrecurso = $l20_interporrecurso;
      $clliclicita->l20_descrinterporrecurso = $l20_descrinterporrecurso;

      $clliclicita->alterar_liclicitajulgamento($l20_codigo);
      if ($clliclicita->erro_status == 0) {

        $erro_msg = $clliclicita->erro_msg;
        $sqlerro  = true;
      }

      if ($sqlerro == false) {

        $l11_sequencial                       = '';
        $clliclicitasituacao->l11_id_usuario  = DB_getSession("DB_id_usuario");
        $clliclicitasituacao->l11_licsituacao = 1;
        $clliclicitasituacao->l11_liclicita   = $clliclicita->l20_codigo;
        $clliclicitasituacao->l11_obs         = "Licitação Julgada";
        $clliclicitasituacao->l11_data        = $dtjulgamento;
        $clliclicitasituacao->l11_hora        = DB_hora();
        //db_inicio_transacao();
        $clliclicitasituacao->incluir($l11_sequencial);
        //db_fim_transacao();
        if ($clliclicitasituacao->erro_status == 0) {
          $sqlerro = true;
        }
      }
    }


    db_fim_transacao($sqlerro);
  }

  if ($sqlerro == false) {

  	$db_opcao = 3;
    $erro_msg = $linha." item(ns) da licitacao ".$l20_codigo." foram julgado(s).";
  }
}

if (isset($salvar) && trim($salvar) != "") {
	//$result_licitacao = $clliclicita->sql_record($clliclicita->sql_query($l20_codigo));
	//die($l20_descrinterporrecurso);
	$clliclicita->l20_licsituacao = 11;
	$clliclicita->l20_codigo      = $l20_codigo;
	$clliclicita->l20_regata = $l20_regata;
	$clliclicita->l20_interporrecurso = $l20_interporrecurso;
	$clliclicita->l20_descrinterporrecurso = $l20_descrinterporrecurso;
	//db_fieldsmemory($result_licitacao, 0);
	//$clliclicita->l20_licsituacao = 11;
	db_inicio_transacao();
	$clliclicita->alterar_liclicitajulgamento($l20_codigo);

 if ($clliclicita->erro_status != 0) {
	  //$disable_confirmar = true;
	  db_msgbox($clliclicita->erro_msg);
	  if ($l20_interporrecurso == 1) {
      echo "<script>location.href='lic1_pcorcamtroca001.php?pc20_codorc=$pc20_codorc&pc21_orcamforne=$pc21_orcamforne&l20_codigo=$l20_codigo&disable_confirmar=true'</script>";
	  }
	} else {
		$sqlerro = true;
	}
	db_fim_transacao($sqlerro);
	//$erro_msg = $clliclicita->erro_msg;
} else {
	$sSqlDadosLicitacao = $clliclicita->sql_query_file($l20_codigo);
	$rsDadosLicitacao   = $clliclicita->sql_record($sSqlDadosLicitacao);
	db_fieldsmemory($rsDadosLicitacao, 0);
	if ($l20_interporrecurso == 1) {
	  $disable_confirmar = true;
	}
}


/*if (isset($liberar) && trim($liberar) != "") {
	$result_licitacao = $clliclicita->sql_record($clliclicita->sql_query($l20_codigo));
	db_fieldsmemory($result_licitacao, 0);
	$clliclicita->l20_licsituacao = 0;
	db_inicio_transacao();
	$clliclicita->alterar($l20_codigo);
	if ($clliclicita->erro_status != 0) {
	  //$disable_confirmar = false;
	  db_msgbox($clliclicita->erro_msg);
    echo "<script>location.href='lic1_pcorcamtroca001.php?pc20_codorc=$pc20_codorc&pc21_orcamforne=$pc21_orcamforne&l20_codigo=$l20_codigo'</script>";
	} else {
		$sqlerro = true;
	}
	db_fim_transacao($sqlerro);
	//$erro_msg = $clliclicita->erro_msg;
}*/

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#CCCCCC">
    <center>
        <?
          include("forms/db_frmpcorcamtrocalic.php");
        ?>
    </center>
    </td>
  </tr>
</table>
</body>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>
<?
/*Acrescentado o parametro criterioajudicacao OC3770*/
if (isset($pc20_codorc) && trim($pc20_codorc)) {
  echo "<script>iframe_solicitem.location.href = 'lic1_trocpcorcamtroca.php?criterioajudicacao=true&orcamento=$pc20_codorc&orcamforne=$pc21_orcamforne';</script>";
}

if (trim($erro_msg) != "") {

  $erro_msg = urldecode($erro_msg);
  db_msgbox($erro_msg);
}

if(isset($salvar)){
  if($clliclicita->erro_status=="0"){
    $clliclicita->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clliclicita->erro_campo!=""){
      echo "<script> document.form1.".$clliclicita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clliclicita->erro_campo.".focus();</script>";
      echo "<script> document.form1.".$clliclicita->erro_campo.".value='';</script>";
    }
  }
}
?>
