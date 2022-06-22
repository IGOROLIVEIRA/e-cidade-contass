<?php
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
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("model/itbi/Itbi.model.php");
$oGet = db_utils::postMemory($_GET);
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >

<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

<table width="790" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <form action="" name="form1" method="post">
	      <center>
          <table id="processando" style="visibility:visible" width="100%" border="0" cellspacing="0">
            <tr>
              <td height="45">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" align="center"><font size="5">Processando Classifica&ccedil;&atilde;o Aguarde...
                </font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <table id="processado" style="visibility:hidden" width="100%" border="0" cellspacing="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="30" align="center"><font size="5">Processo Conclu&iacute;do.</font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </center>
      </form>
	  </td>
  </tr>
</table>
</body>
</html>
<?php

   db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));

   flush();

   try {


   	db_inicio_transacao();

   	if(!isset($oGet->codret) || $oGet->codret == ""){
   		throw new Exception("C�digo do arquivo ({$oGet->codret}) de Retorno Inv�lido.");
   	}
     $oInstit = new Instituicao(db_getsession('DB_instit'));

     if($oInstit->getCodigoCliente() == Instituicao::COD_CLI_PMPIRAPORA) {
       $sSqlIntegracaoJMS = "UPDATE disbanco
                              SET k00_numpre = debitos_jms.k00_numpre,
                                  k00_numpar = debitos_jms.k00_numpar
                              FROM debitos_jms
                              WHERE disbanco.k00_numpre = debitos_jms.k00_numpre_old
                                  AND disbanco.k00_numpar = debitos_jms.k00_numpar_old
                                  AND disbanco.codret = {$oGet->codret}";
       if (!db_query($sSqlIntegracaoJMS)) {
         throw new Exception(str_replace("\n", "", substr(pg_last_error(), 0, strpos(pg_last_error(), "CONTEXT"))));
       }
       /**
        * Quando s�o importados as guias da JMS, as do ecidade ficam com numpre com tamanho < 6. Para n�o ficar lixo,
        * setamos o classi = true.
        */
       $sSqlIgnoraGuiasEcidade = "UPDATE disbanco
                                  SET classi = true
                                  WHERE char_length(k00_numpre::varchar) < 6
                                  AND disbanco.codret = {$oGet->codret}";
     }

$config = db_query("select * from db_config where codigo = ".db_getsession("DB_instit"));
db_fieldsmemory($config,0);

if ($db21_usadebitoitbi == 't') {
 // echo '<br> Entrei ITBI';                                        

     $sSQL_ITBI = <<<SQL
              select arrecad_itbi.k00_numpre as numprearrecad, recibo.k00_numpre as numprerecibo 
                from itbi
                    inner join itbinumpre on itbinumpre.it15_guia = itbi.it01_guia
                    inner join recibo on recibo.k00_numpre = itbinumpre.it15_numpre
                    inner join arrecad_itbi on arrecad_itbi.it01_guia = itbi.it01_guia
                        where recibo.k00_numpre IN (select k00_numpre from disbanco where codret = $oGet->codret);
SQL;

    $resultItbi = db_query($sSQL_ITBI);
    // $oDadosArrecadItbi = db_utils::fieldsMemory($resultItbi, 0);

    for ($iCont=0; $iCont < pg_num_rows($resultItbi); $iCont++) {
        $numprearrecad =  db_utils::fieldsMemory($resultItbi,$iCont)->numprearrecad;
        $numprerecibo =  db_utils::fieldsMemory($resultItbi,$iCont)->numprerecibo;
        
        $sSQL_ALTERA_NUMPRE_ITBI = "UPDATE disbanco 
                                      SET k00_numpre = {$numprearrecad}, k00_numpar = 1 
                                        WHERE disbanco.codret = {$oGet->codret} 
                                        and disbanco.k00_numpre = {$numprerecibo}";
  //echo '<br>'.$sSQL_ALTERA_NUMPRE_ITBI;                                        
        $result_itbi = db_query($sSQL_ALTERA_NUMPRE_ITBI);

        if (!$result_itbi) {
            throw new Exception("Ocorreu um erro ao processar o registro {$numprerecibo} e codret {$oGet->codret}");
        }

    }
    
}

   	$sSql = "select fc_executa_baixa_banco($oGet->codret,'".date("Y-m-d",db_getsession("DB_datausu"))."')";
   	$rsBaixaBanco = db_query($sSql);
   	if (!$rsBaixaBanco) {
   		throw new Exception(str_replace("\n","",substr(pg_last_error(), 0, strpos(pg_last_error(),"CONTEXT"))));
   	}

   	$sRetornoBaixaBanco = db_utils::fieldsMemory($rsBaixaBanco, 0)->fc_executa_baixa_banco;
   	if (substr($sRetornoBaixaBanco,0,1) != '1') {
   	  throw new Exception($sRetornoBaixaBanco);
   	}
    $oItbi = new Itbi();
    $oItbi->processarTransferenciaAutomatica($oGet->codret);
   	db_msgbox($sRetornoBaixaBanco);

   	db_fim_transacao(false);

   } catch (Exception $oErro) {

   	db_fim_transacao(true);
   	$sMsgRetorno  = "Erro durante o processamento da Classifica��o da Baixa de Banco!\\n\\n{$oErro->getMessage()}";
   	db_msgbox($sMsgRetorno);

   }

   db_redireciona("cai4_baixabanco002.php?db_opcao=4&pesquisar=true&k15_codbco={$oGet->k15_codbco}&k15_codage={$oGet->k15_codage}");
?>
