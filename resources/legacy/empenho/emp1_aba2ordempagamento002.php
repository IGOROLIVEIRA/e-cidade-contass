<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
include("classes/db_pagordem_classe.php");
include("classes/db_empempenho_classe.php");
include("classes/db_conlancam_classe.php");
include("classes/db_empdiaria_classe.php");
require_once("std/Modification.php");
require_once ("libs/db_liborcamento.php");

$clmatordem = new cl_matordem;
$clpagordem   = new cl_pagordem;
$clempempenho = new cl_empempenho;
$clrotulo = new rotulocampo;
$clconlancam = new cl_conlancam;
$clempdiaria = new cl_empdiaria;

$clempempenho->rotulo->label();
$clmatordem->rotulo->label();
$clrotulo->label("e60_codemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e50_codord");
$clrotulo->label("e50_obs");
// $clrotulo->label("e50_compdesp");

$clpagordem->rotulo->label("e60_codemp");
$clpagordem->rotulo->label("e60_numemp");
$clpagordem->rotulo->label("e50_codord");
$clpagordem->rotulo->label("e50_obs");
// $clpagordem->rotulo->label("e50_compdesp");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

if (isset($aFiltros['empenho']) && !empty($aFiltros['empenho'])) {
    $empenho = $aFiltros['empenho'];
}

$sqlerro = false;

db_inicio_transacao();

if (isset($alterar)) {
    $estornoAlterado = false;
    if($dataEstorno !== ""){
        $dataEstorno = str_replace('/', '-', $dataEstorno);
        $dataEstorno = date('Y-m-d', strtotime($dataEstorno));
        if($dataEstornoAtual !== ""){
            $dataEstornoAtual = str_replace('/', '-', $dataEstornoAtual);
            $dataEstornoAtual = date('Y-m-d', strtotime($dataEstornoAtual));
            $estornoAlterado = strtotime($dataEstornoAtual) !== strtotime($dataEstorno) ? true : false;
        }
    }

    $liquidacaoAlterado = false;
    if($dataLiquidacao !== ""){
        $dataLiquidacao = str_replace('/', '-', $dataLiquidacao);
        $dataLiquidacao = date('Y-m-d', strtotime($dataLiquidacao));
        if($dataLiquidacaoAtual !== ""){
            $dataLiquidacaoAtual = str_replace('/', '-', $dataLiquidacaoAtual);
            $dataLiquidacaoAtual = date('Y-m-d', strtotime($dataLiquidacaoAtual));
            $liquidacaoAlterado = strtotime($dataLiquidacaoAtual) !== strtotime($dataLiquidacao) ? true : false;
        }
    }
    
    $sSqlConsultaFimPeriodoContabil   = "SELECT * FROM condataconf WHERE c99_anousu = ".db_getsession('DB_anousu')." and c99_instit = ".db_getsession('DB_instit');
    $rsConsultaFimPeriodoContabil     = db_query($sSqlConsultaFimPeriodoContabil);

    if (pg_num_rows($rsConsultaFimPeriodoContabil) > 0) {
      
        $oFimPeriodoContabil = db_utils::fieldsMemory($rsConsultaFimPeriodoContabil, 0);

        if ($oFimPeriodoContabil->c99_data != '' 
        && (($estornoAlterado && db_strtotime($dataEstorno) <= db_strtotime($oFimPeriodoContabil->c99_data))
        || ($liquidacaoAlterado && db_strtotime($dataLiquidacao) <= db_strtotime($oFimPeriodoContabil->c99_data)))) {

            $erro_msg = "Dados da OP não alterados!\nData inferior à data do fim do período contábil.";
            $sqlerro = true;

        }

    }

    //Verifica se a data de OP e anterior a data da OC, caso não seja uma OC gerada automaticamente
    if(!$sqlerro && isset($dataLiquidacao) && $dataLiquidacao !== ""){
        $ordemCompra = $clmatordem->verificaTipo($e50_codord);
        if(isset($ordemCompra)){
            if($ordemCompra->tipo === 'normal'){
                if($dataLiquidacao < $ordemCompra->m51_data){
                    $erro_msg = "Dados da OP não alterados!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                    $sqlerro = true;
                }
            }
        }
    }

    //Verifica se data da liquidação é anterior a data do empenho
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clconlancam->verificaDataEmpenho($e60_numemp);
        $result = db_query($sql);
        if(pg_num_rows($result) > 0){
            $result = pg_fetch_object($result);
            if (strtotime($dataLiquidacao) < strtotime($result->data_empenho)){
                $erro_msg = "Dados da OP não alterados!\nVerifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Verifica se data de liquidaçao é posterior a data de pagamento
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clconlancam->verificaDataPagamento($e50_codord);
        $result = db_query($sql);
        if(pg_num_rows($result) > 0){
            $result = pg_fetch_object($result);
            if (strtotime($dataLiquidacao) > strtotime($result->data_pagamento)){
                $erro_msg = "Dados da OP não alterados!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Verifica se empenho tem saldo na data desejada
    if(!$sqlerro && strtotime($dataLiquidacao) < strtotime($e50_data) && $liquidacaoAlterado){
        $sql = $clempempenho->verificaSaldoEmpenho($e60_numemp, $dataLiquidacao);
        $result = pg_fetch_object(db_query($sql));
        if ($result->saldo_empenho < $e53_valor){
            $erro_msg = "Dados da OP não alterados!\nEmpenho não possui saldo na data desejada.";
            $sqlerro = true;
        }
    }

    //Verifica se empenho não ficará negativo
    if(!$sqlerro && $liquidacaoAlterado){
        $sql = $clempempenho->verificaSaldoEmpenhoPosterior($e60_numemp, $dataLiquidacao, $e50_codord, 20);
        $result = pg_fetch_object(db_query($sql));
        if ($result->saldo_empenho < 0){
            $erro_msg = "Dados da OP não alterados!\nO empenho não pode ficar com saldo negativo.";
            $sqlerro = true;
        }
    }

    //Verifica se data da liquidação é posterior a data do estorno
    if(!$sqlerro && ($estornoAlterado || $liquidacaoAlterado)){
        if(isset($dataEstorno) && $dataEstorno !== ""){
            if (strtotime($dataLiquidacao) > strtotime($dataEstorno)){
                $erro_msg = "Dados da OP não alterados!\nA data informada é inconsistente. Verifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Altera data liquidação
    if(!$sqlerro && $liquidacaoAlterado){
        $dataLiquidacaoAtual = str_replace('/', '-', $dataLiquidacaoAtual);
        $dataLiquidacaoAtual = date('Y-m-d', strtotime($dataLiquidacaoAtual)); 
        if(strtotime($dataLiquidacao) <= db_getsession("DB_datausu")){
            db_inicio_transacao();
            $sqlAlteraDataOp = $clpagordem->alteraDataOp($e50_codord,$dataLiquidacaoAtual,$dataLiquidacao, date('m',db_getsession('DB_datausu')), $ordemCompra->tipo);
            db_query($sqlAlteraDataOp);
            db_fim_transacao();
        }else{
            $erro_msg = "Dados da OP não alterados!\nA data da OP não pode ser posterior a data atual.";
            $sqlerro = true;  
        }
    }

    //Altera data do estorno
    if(!$sqlerro && $estornoAlterado){

        if(strtotime($dataEstorno) <= db_getsession("DB_datausu")){
            db_inicio_transacao();
            $sqlAlteraDataEstorno = $clpagordem->alteraDataEstorno($e50_codord,$dataEstornoAtual,$dataEstorno, date('m',db_getsession('DB_datausu')));
            db_query($sqlAlteraDataEstorno);
            db_fim_transacao();
        }else{
            $erro_msg = "Dados da OP não alterados!\nA data do estorno não pode ser posterior a data atual.";
            $sqlerro = true;  
        }
    }

    if (!$sqlerro) {
    
        $aEmpenho = explode("/",$e60_codemp);
        $sSql = $clpagordem->sql_query_pagordemele("","substr(o56_elemento,1,7) AS o56_elemento","e50_codord","e60_codemp =  '".$aEmpenho[0]."' and e60_anousu = ".$aEmpenho[1]." and e60_instit = ".db_getsession("DB_instit"));
        $rsElementDesp = db_query($sSql);
        $clpagordem->e50_obs = $historicoOp;
        $clpagordem->alterar($e50_codord,db_utils::fieldsMemory($rsElementDesp,0)->o56_elemento);
        if($clpagordem->erro_status == 0) {
            $sqlerro = true;
        }
        $erro_msg = $clpagordem->erro_msg;

    }

    if (!$sqlerro && $salvarDiaria == 1 && ($desdobramentoDiaria == '14' || $desdobramentoDiaria == '33')) {
        $sqlerroDiaria = false;
        $erro_msg_diaria = "Dados da OP não alterados!\n";
        if($e140_matricula == '' || $e140_matricula == null){
            $erro_msg_diaria .= "- Campo Matricula Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_cargo == '' || $e140_cargo == null){
            $erro_msg_diaria .= "- Campo Cargo Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($diariaOrigemMunicipio == '' || $diariaOrigemMunicipio == null
        || $diariaOrigemUf == '' || $diariaOrigemUf == null){
            $erro_msg_diaria .= "- Campo Origem Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($diariaDestinoMunicipio == '' || $diariaDestinoMunicipio == null
        || $diariaDestinoUf == '' || $diariaDestinoUf == null){
            $erro_msg_diaria .= "- Campo Destino Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_dtautorizacao == '' || $e140_dtautorizacao == null){
            $erro_msg_diaria .= "- Campo Data da Autorização Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_dtinicial == '' || $e140_dtinicial == null){
            $erro_msg_diaria .= "- Campo Data Inicial da Viagem Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_horainicial == '' || $e140_horainicial == null){
            $erro_msg_diaria .= "- Campo Hora Inicial Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_dtfinal == '' || $e140_dtfinal == null){
            $erro_msg_diaria .= "- Campo Data Final da Viagem Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_horafinal == '' || $e140_horafinal == null){
            $erro_msg_diaria .= "- Campo Hora Final Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e140_objetivo == '' || $e140_objetivo == null){
            $erro_msg_diaria .= "- Campo Objetivo da Viagem Obrigatório.\n";
            $sqlerroDiaria = true;
        }
        if($e53_valor != $diariaVlrDespesa){
            $erro_msg_diaria .= "- Valor da Liquidação precisa ser igual ao Valor Liquidado.\n";
            $sqlerroDiaria = true;
        }          

        if(!$sqlerroDiaria){

            $clempdiaria->sql_record($clempdiaria->sql_query(null,'*',null,' e140_codord = '.$e50_codord));

            $clempdiaria->e140_matricula             = $e140_matricula;
            $clempdiaria->e140_cargo                 = $e140_cargo;
            $clempdiaria->e140_dtautorizacao         = $e140_dtautorizacao == '' ? $e140_dtautorizacao : App\Support\String\DateFormatter::convertDateFormatBRToISO($e140_dtautorizacao);
            $clempdiaria->e140_dtinicial             = $e140_dtinicial == '' ? $e140_dtinicial : App\Support\String\DateFormatter::convertDateFormatBRToISO($e140_dtinicial);
            $clempdiaria->e140_dtfinal               = $e140_dtfinal == '' ? $e140_dtfinal : App\Support\String\DateFormatter::convertDateFormatBRToISO($e140_dtfinal);
            $clempdiaria->e140_horainicial           = $e140_horainicial;
            $clempdiaria->e140_horafinal             = $e140_horafinal;
            $clempdiaria->e140_origem                = $diariaOrigemMunicipio.' - '.$diariaOrigemUf;
            $clempdiaria->e140_destino               = $diariaDestinoMunicipio.' - '.$diariaDestinoUf;
            $clempdiaria->e140_qtddiarias            = $e140_qtddiarias != '' ? $e140_qtddiarias : 0;
            $clempdiaria->e140_vrldiariauni          = $e140_vrldiariauni != '' ? $e140_vrldiariauni : 0;
            $clempdiaria->e140_qtddiariaspernoite    = $e140_qtddiariaspernoite != '' ? $e140_qtddiariaspernoite : 0;
            $clempdiaria->e140_vrldiariaspernoiteuni = $e140_vrldiariaspernoiteuni != '' ? $e140_vrldiariaspernoiteuni : 0;
            $clempdiaria->e140_qtdhospedagens        = $e140_qtdhospedagens != '' ? $e140_qtdhospedagens : 0;
            $clempdiaria->e140_vrlhospedagemuni      = $e140_vrlhospedagemuni != '' ? $e140_vrlhospedagemuni : 0;
            $clempdiaria->e140_transporte            = $e140_transporte;
            $clempdiaria->e140_vlrtransport          = $e140_vlrtransport != '' ? $e140_vlrtransport : 0;
            $clempdiaria->e140_objetivo              = $e140_objetivo;
            if($clempdiaria->numrows > 0){
                $clempdiaria->alterar($e140_sequencial);
            }else{
                $clempdiaria->e140_codord            = $e50_codord;
                $clempdiaria->incluir();
            }
            if($clempdiaria->erro_status == 0) {
                $sqlerroDiaria = true;
            }
        }

        if($sqlerroDiaria){
            $erro_msg = $erro_msg_diaria;
            $sqlerro = true;
        }
    }

    if (!$sqlerro) {
        $erro_msg = "Dados da OP alterados com sucesso!";
    }
}
db_fim_transacao($sqlerro);

db_inicio_transacao();

if (isset($alterar)) {
    $sqlerroReinf = false;
    if (!$sqlerroReinf) {
        $aEstabelecimentos = json_decode(str_replace("\\","",$arrayEstabelecimentos));
        $aEstabelecimentosExcluidos = json_decode(str_replace("\\","",$arrayEstabelecimentosExcluidos));
        $clpagordemreinf        = new cl_pagordemreinf;
        foreach ($aEstabelecimentos as $estabelecimento){
            $clpagordemreinf->e102_codord = $e50_codord;
            $clpagordemreinf->e102_numcgm = $estabelecimento->e102_numcgm;
            $clpagordemreinf->e102_vlrbruto = $estabelecimento->e102_vlrbruto;
            $clpagordemreinf->e102_vlrbase = $estabelecimento->e102_vlrbase;
            $clpagordemreinf->e102_vlrir = $estabelecimento->e102_vlrir;
            $clpagordemreinf->sql_record($clpagordemreinf->sql_query($e50_codord, $estabelecimento->e102_numcgm));
            if($clpagordemreinf->numrows == 0){
                $clpagordemreinf->incluir();
                if($clpagordemreinf->erro_status == 0){
                    $sqlerroReinf = true;
                    $erro_msg_reinf = $clpagordemreinf->erro_msg;
                    break;
                }
            }else if($clpagordemreinf->numrows == 1){
                $clpagordemreinf->alterar($e50_codord,$estabelecimento->e102_numcgm);
                if($clpagordemreinf->erro_status == 0){
                    $sqlerroReinf = true;
                    $erro_msg_reinf = $clpagordemreinf->erro_msg;
                    break;
                }
            }
        }
    }

    if(!$sqlerroReinf){
        $aEstabelecimentosExcluidos = json_decode(str_replace("\\","",$arrayEstabelecimentosExcluidos));
        $clpagordemreinf        = new cl_pagordemreinf;
        foreach ($aEstabelecimentosExcluidos as $estabelecimento){
            $clpagordemreinf->excluir($e50_codord,$estabelecimento->e102_numcgm);
            if($clpagordemreinf->erro_status == 0){
                $sqlerroReinf = true;
                $erro_msg_reinf = $clpagordemreinf->erro_msg;
                break;
            }
        }
    }

    if(!$sqlerroReinf){
    $clpagordem->e50_retencaoir = $reinfRetencao;
    $clpagordem->e50_naturezabemservico = $naturezaCod;
    $clpagordem->alterar($e50_codord,db_utils::fieldsMemory($rsElementDesp,0)->o56_elemento);
    if($clpagordem->erro_status == 0) {
        $sqlerro = true;
    }
    $erro_msg_reinf = $clpagordem->erro_msg;

    }

    if(!$sqlerroReinf){
        $erro_msg .= "\n\nDados do EFD-Reinf atualizados.";
    }
}
db_fim_transacao($sqlerroReinf);

db_inicio_transacao();

if (isset($alterar) && $ct01_codcategoria) {

  // Esocial
  $sqlerroEsocial = false;
  if (!$sqlerroEsocial) {
      $aEmpenho = explode("/",$e60_codemp);
      $clpagordemEsocial      = new cl_pagordem;
      $where = " e60_codemp =  '".$aEmpenho[0]."' and e60_anousu = ".$aEmpenho[1]." and e60_instit = ".db_getsession("DB_instit");
      $sql = $clpagordemEsocial->sql_record($clpagordemEsocial->sql_query_emp(null,"*",null,$where));
   
      if ($clpagordemEsocial->numrows > 0) {
          $oEsocial= db_utils::fieldsMemory($sql, 0);
          
          $clpagordemEsocial = new cl_pagordem;
          $clpagordemEsocial->e50_retencaoir                = $reinfRetencao;
          $clpagordemEsocial->e50_naturezabemservico        = $naturezaCod;
          $clpagordemEsocial->e50_cattrabalhador            = $ct01_codcategoria;
          $clpagordemEsocial->e50_cattrabalhadorremurenacao = $ct01_codcategoriaremuneracao;
          $clpagordemEsocial->e50_empresadesconto           = $numempresa;
          $clpagordemEsocial->e50_contribuicaoPrev          = $contribuicaoPrev;
          $clpagordemEsocial->e50_valorremuneracao          = str_replace(',', '', $valorremuneracao);
          $clpagordemEsocial->e50_valordesconto             = str_replace(',', '', $valordesconto);

          if ($competencia && $competencia != "undefined") {
            $clpagordemEsocial->e50_datacompetencia         = formateDateReverse($competencia);
          }
          
          $clpagordemEsocial->alterar($oEsocial->e50_codord,null);
          $erro_msg_esocial = $clpagordemEsocial->erro_status;

      } 
  }

  if($erro_msg_esocial == 1){
      $erro_msg .= "\n\nDados do Esocial atualizados.";
  } else{
     $erro_msg .= "\n\nFalhas ao Salvar Dados do Esocial.";
  }
}
db_fim_transacao($sqlerroEsocial);
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaOrdemPagamento(document.form1.empenho.value)" >
<br><br>
<center>
    <?php require_once (modification::getFile("forms/db_frmordempagamento.php")); ?>
</center>
</body>
</html>
<?php
if(isset($alterar)){
    if($sqlerro == true){
        db_msgbox($erro_msg);
        if($clpagordem->erro_campo!=""){
            echo "<script> document.form1.".$clpagordem->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clpagordem->erro_campo.".focus();</script>";
        }
    }else{
        db_msgbox($erro_msg);
    }
}
function formateDateReverse(string $date): string
{
   
    $data_objeto = DateTime::createFromFormat('d/m/Y', $date);
    $data_formatada = $data_objeto->format('Y-m-d');
    return date('Y-m-d', strtotime($data_formatada));
}
?>