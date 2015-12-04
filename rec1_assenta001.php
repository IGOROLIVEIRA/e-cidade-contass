<?php
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
require_once("classes/db_assenta_classe.php");
require_once("classes/db_tipoasse_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("std/DBDate.php");

db_postmemory($HTTP_POST_VARS);

$classenta  = new cl_assenta;
$cltipoasse = new cl_tipoasse;
$db_opcao   = 1;
$db_botao   = true;

if( !isset($h12_tipo) ) {

  $h12_tipo   = "";
  $h12_tipefe = "";
}

/**
 * Inclui assentamento/afastamento 
 */
if ( isset($incluir) ) {


  $sMensagens = "recursoshumanos.rh.rec1_assenta.";

  db_inicio_transacao();

  try {
    /**
     * h12_assent, no formulario esta como h12_codigo 
     */
    $sCodigoAfastamento = trim($h12_codigo);

    /**
     * Campo com codigo do afastamento nao informado 
     */
    if ( empty($sCodigoAfastamento) ){
      throw new Exception("Campo assentamento/afastamento não informado.");
    }

    /**
     * Validações quando o tipo de assentamento for de reajuste salarial
     */
    $rsVerificaReajuste = $cltipoasse->sql_record( $cltipoasse->sql_query_file( $h16_assent, "h12_tiporeajuste") );

    if ($cltipoasse->numrows > 0) {
      $oTipoasse = db_utils::fieldsMemory($rsVerificaReajuste, 0);

      if ($oTipoasse->h12_tiporeajuste != 0) {

        /**
         * Não permite incusão para servidores ativos ou rescindidos
         */
        require_once("model/pessoal/Servidor.model.php");

        $oServidor = new Servidor($h16_regist);

        if ($oServidor->isAtivo()) {
          /**
           * Limpa o campo tipoasse
           */
          $h12_codigo = '';
          throw new Exception( _M($sMensagens . "reajuste_servidor_ativo") );
        }

        if ($oServidor->isRescindido()) {
          /**
           * Limpa o campo tipoasse
           */
          $h12_codigo = '';
          throw new Exception( _M($sMensagens . "reajuste_servidor_rescindido") );
        }

        /**
         * Verifica se já foi lançado ountro assentamento com o campo tipo de rescisão informado no tipoasse
         */
        $sWhere  = "";

        $sWhere  = " h12_tiporeajuste is not null and h12_tiporeajuste <> 0 ";
        $sWhere .= " and h16_regist = {$h16_regist}";

        $classenta->sql_record( $classenta->sql_query( null, "h16_codigo", null, $sWhere) );

        if ($classenta->numrows > 0) {

          /**
           * Limpa o campo tipoasse
           */
          $h12_codigo = '';
          throw new Exception( _M($sMensagens . "ja_possui_reajuste_salarial") );
        }
      }
    }

    $oDataInicial = new DBDate($h16_dtconc);
    $dDataInicial = $oDataInicial->getDate();

    /**
     * Campo data final no formulario vazia
     * - procura afastamentos com data inicial maior ou igual e com data final menor ou igual
     * - ou com data final vazia(afastamento em aberto)
     * - ou com data inicial do formulario menor ou igual a do banco (afastamento com data posterior ja cadastrado)
     */
    $sWhereDatas  = " (                                                                                      ";
    $sWhereDatas .= "     ('{$dDataInicial}'::date >= h16_dtconc and '{$dDataInicial}'::date <= h16_dtterm ) ";
    $sWhereDatas .= "  or (h16_dtterm is null)                                                               ";
    $sWhereDatas .= "  or ( '{$dDataInicial}'::date <= h16_dtconc )                                          ";
    $sWhereDatas .= " )                                                                                      ";

    /**
     * Caso campo com data final nao estiver vazio procura afastamento entre data inicial e final
     * ou com data final vazia(afastamento em aberto)
     */
    if ( !empty($h16_dtterm) ) {

      $oDataFinal  = new DBDate($h16_dtterm);
      $dDataFinal  = $oDataFinal->getDate();
      $sWhereDatas = " (h16_dtconc, case when h16_dtterm is null then '3000-12-31'::date else h16_dtterm+1 end) overlaps ('{$dDataInicial}'::date, '{$dDataFinal}'::date) ";
    }

    /**
     * Valida datas para assentamento de substituição
     */
    $rsBuscaTipoAssentamento = $cltipoasse->sql_record($cltipoasse->sql_query_file( null, "*", null, "h12_assent = '{$h12_assentdescr}'"));

    if(!$rsBuscaTipoAssentamento || pg_num_rows($rsBuscaTipoAssentamento) <=0 ) {
      throw new Exception("Não foi possível pesquisar o tipo de assentamento.");
    } else {
      $oTipoasse = db_utils::fieldsMemory($rsBuscaTipoAssentamento, 0);
    }

    if($oTipoasse->h12_natureza == AssentamentoSubstituicao::CODIGO_NATUREZA) {

      /**
       * Valida se data final está em branco
       */
      if (empty($h16_dtterm)) {
        throw new Exception("A data final deve ser preenchida.");
      }

      /**
       * Valida se data final é menor que data inicial
       */
      if ( str_replace("-", "", $dDataFinal) < str_replace("-", "", $dDataInicial) ) {
        throw new Exception("A data final não pode ser menor que a data inicial.");
      }
  
      /**
       * Busca o mês e ano das data inicial e final para compará-las
       */
      $sMesAnoDataInicial = preg_replace("/(\d{4}\-\d{2}).*/", "$1", $dDataInicial);
      $sMesAnoDataFinal   = preg_replace("/(\d{4}\-\d{2}).*/", "$1", $dDataFinal);
  
      if($sMesAnoDataFinal != $sMesAnoDataInicial) {
        throw new Exception("A data final deve estar no mesmo mês e ano da data inicial.");
      }
    }

    /**
     * Antes de alterar verifica se já nao tem afastamento cadastrado para o servidor no mesmo periodo 
     *
     * h16_dtterm - data de termino 
     * h16_dtconc - data concessao
     */
    $sWhereValidacao  = " case                                                              ";
    $sWhereValidacao .= "   when exists ( select 1                                          ";
    $sWhereValidacao .= "                   from tipoasse                                   ";
    $sWhereValidacao .= "                  where trim(h12_assent) = '{$sCodigoAfastamento}' ";
    $sWhereValidacao .= "                  and h12_tipo = 'A'                               ";
    $sWhereValidacao .= "               )                                                   ";
    $sWhereValidacao .= "     then (     h16_regist  = {$h16_regist}                        ";
    $sWhereValidacao .= "            and h12_tipo    = 'A'                                  ";
    $sWhereValidacao .= "            and ({$sWhereDatas})                                   ";
    $sWhereValidacao .= "          )                                                        ";
    $sWhereValidacao .= "     else false                                                    ";
    $sWhereValidacao .= " end                                                               ";
    $sSqlValidacao    = $classenta->sql_query(null, '*', 'h16_dtconc', $sWhereValidacao);
    $rsValidacao      = db_query($sSqlValidacao);

    /**
     * Econtrou afastamento para o periodo informado no formulario 
     * Lanca excessao 
     */
    if ( $classenta->numrows > 0 && $h12_vinculaperiodoaquisitivo == 'f') {

      $sMensagemErro  = "Assentamento já cadastrado para este tipo no mesmo período.";
      $aAssentamentos = db_utils::getCollectionByRecord($rsValidacao);

      /**
       * Percorre assentamentos encontrados para montar mensagem de erro 
       */
      foreach( $aAssentamentos as $oAssentamento ) {
        
        /**
         * Encontrou afastamento em aberto 
         */
        if ( $oAssentamento->h16_dtterm == '' ) {
          $sMensagemErro = "Servidor com afastamento em aberto.";
        }

        $oDataInicial = new DBDate($oAssentamento->h16_dtconc);
        $sDataInicial = $oDataInicial->getDate(DBDate::DATA_PTBR);

        $sDataFinal   = null;

        if ( !empty($oAssentamento->h16_dtterm) ) {

          $oDataFinal = new DBDate($oAssentamento->h16_dtterm);
          $sDataFinal = $oDataFinal->getDate(DBDate::DATA_PTBR);
        }

        $sMensagemErro .= "\n\nAfastamento encontrado: {$oAssentamento->h12_assent}";
        $sMensagemErro .= "\nData inicial: {$sDataInicial}";
        $sMensagemErro .= "\nData final  : {$sDataFinal}";
      }

      throw new Exception($sMensagemErro);
    }

    /**
     * Inclui assentamento/afastamento 
     */
    $oAssentamento = new Assentamento();
    $oAssentamento->setMatricula($h16_regist);
    $oAssentamento->setTipoAssentamento($h16_assent);
    $oAssentamento->setDataConcessao(new DBDate($h16_dtconc));
    $oAssentamento->setHistorico($h16_histor);
    $oAssentamento->setCodigoPortaria($h16_nrport);
    $oAssentamento->setDescricaoAto($h16_atofic);
    $oAssentamento->setDias($h16_quant);
    $oAssentamento->setPercentual("0");
    $oAssentamento->setSegundoHistorico('');
    $oAssentamento->setLoginUsuario(db_getsession("DB_id_usuario"));
    $oAssentamento->setDataLancamento(date("Y-m-d",db_getsession("DB_datausu")));
    $oAssentamento->setConvertido("false");
    $oAssentamento->setAnoPortaria($h16_anoato);

    if(isset($h16_dtterm) && !empty($h16_dtterm)) {
      $oAssentamento->setDataTermino(new DBDate($h16_dtterm));
    }
    AssentamentoRepository::persist($oAssentamento);

    if (!empty($h80_db_cadattdinamicovalorgrupo)) {

      $oDaoAssentaAttr = new cl_assentadb_cadattdinamicovalorgrupo();              
      $oDaoAssentaAttr->h80_assenta                     = $oAssentamento->getCodigo();
      $oDaoAssentaAttr->h80_db_cadattdinamicovalorgrupo = $h80_db_cadattdinamicovalorgrupo;
      $oDaoAssentaAttr->incluir($oAssentamento->getCodigo(), $h80_db_cadattdinamicovalorgrupo);

      if ($oDaoAssentaAttr->erro_status == "0") {
        throw new Exception($oDaoAssentaAttr->erro_msg);   
      }
    }
      

    if ($h12_vinculaperiodoaquisitivo == 't') {

      $oPeriodoAquisitivoAssentamento = new PeriodoAquisitivoAssentamento();
      $oPeriodoAquisitivoAssentamento->setAssentamento(new Assentamento($oAssentamento->getCodigo()));
      $oPeriodoAquisitivoAssentamento->setPeriodoAquisitivo(new PeriodoAquisitivoFerias($iPeriodoAquisitivo));
      $oPeriodoAquisitivoAssentamento->salvar();
    }

    if($oTipoasse->h12_natureza == AssentamentoSubstituicao::CODIGO_NATUREZA) {

      if(empty($rh161_regist)) {
        throw new BusinessException("É necessário informar o servidor a substituir.");
      }

      $oAssentamentoSubstituicao = new AssentamentoSubstituicao($oAssentamento->getCodigo());
      $oAssentamentoSubstituicao->setSubstituido(ServidorRepository::getInstanciaByCodigo($rh161_regist, DBPessoal::getAnoFolha(), DBPessoal::getMesFolha()));

      $mResponsePersistAssentamentoSubstituicao = $oAssentamentoSubstituicao->persist();

      if($mResponsePersistAssentamentoSubstituicao !== true) {
        throw new BusinessException($mResponsePersistAssentamentoSubstituicao);
      }
    }

    db_fim_transacao();
    $classenta->erro(true, true);
    db_msgbox("Cadastro Realizado com Sucesso.");
    db_redireciona("");

  } catch(Exception $oErro) {
    
    /**
     * Exibe alert com mensagem de erro e da rollback 
     */
    db_msgbox(str_replace("\n", '\n', $oErro->getMessage()));
    db_fim_transacao(true);
  }

}

if( isset($h16_assent) && trim($h16_assent) != "" ) {

  $result_assent = $cltipoasse->sql_record($cltipoasse->sql_query_file($h16_assent, "h12_tipo, h12_tipefe, h12_vinculaperiodoaquisitivo"));

  if($cltipoasse->numrows > 0){
    db_fieldsmemory($result_assent, 0);
  }

  $h80_db_cadattdinamicovalorgrupo = "";
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="javascript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="javascript" type="text/javascript" src="scripts/strings.js"></script>
<script language="javascript" type="text/javascript" src="scripts/dates.js"></script>
<script language="javascript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
	include("forms/db_frmassenta.php");
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
<script>
js_tabulacaoforms("form1","h16_regist",true,1,"h16_regist",true);
js_limpaPeriodoAquisitivo();
</script>
