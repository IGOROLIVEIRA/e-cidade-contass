<?php
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

require_once(modification("libs/db_sql.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("classes/db_parissqn_classe.php"));
require_once(modification("fpdf151/scpdf.php"));
require_once(modification("fpdf151/impcarne.php"));
require_once(modification("classes/db_tabativ_classe.php"));
require_once(modification("classes/db_issprocesso_classe.php"));
require_once(modification("classes/db_isstipoalvara_classe.php"));
require_once(modification("classes/db_ativprinc_classe.php"));
require_once(modification("classes/db_db_config_classe.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_libtributario.php"));
require_once(modification("libs/db_libsys.php"));
require_once(modification("dbagata/classes/core/AgataAPI.class"));
require_once(modification("model/documentoTemplate.model.php"));
require_once(modification("std/db_stdClass.php"));

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$sCaminhoMensagem = "tributario.issqn.iss2_certibaixa002.";

/**
 * Busca parametros e tipo da Baixa
 */
$sSqlTabativBaixa  = "select q11_inscr, q11_seq, q11_processo, q11_oficio, ";
$sSqlTabativBaixa .= "       case when q11_oficio = 'f' then 'Normal'     ";
$sSqlTabativBaixa .= "            when 't' then 'Ofício'                  ";
$sSqlTabativBaixa .= "       end as tipo_baixa,                           ";
$sSqlTabativBaixa .= "       q11_login, q11_data, q11_hora, q11_numero    ";
$sSqlTabativBaixa .= "  from tabativbaixa                                 ";
$sSqlTabativBaixa .= " where q11_inscr = " .$inscr;

$rsTabativBaixa    = db_query($sSqlTabativBaixa);
if (pg_numrows($rsTabativBaixa) == 0 || !$rsTabativBaixa ){

  db_msgbox(_M($sCaminhoMensagem."baixa_incricao_nao_encontrada"));
  exit;
}

db_fieldsmemory( $rsTabativBaixa, 0 );

$clparissqn   = new cl_parissqn;
$sSqlParissqn = $clparissqn->sql_query_file(null, "*", "q60_receit limit 1");
$rsParissqn   = $clparissqn->sql_record($sSqlParissqn);

$oParissqn    = db_utils::fieldsMemory($rsParissqn, 0);
$q60_templatebaixaalvaranormal  = $oParissqn->q60_templatebaixaalvaranormal;
$q60_templatebaixaalvaraoficial = $oParissqn->q60_templatebaixaalvaraoficial;


$iDocumentoTemplate = $q60_templatebaixaalvaranormal;

$sDescrDoc        = date("YmdHis").db_getsession("DB_id_usuario");
$sNomeRelatorio   = "tmp/CertidaoBaixaInscricao{$sDescrDoc}.pdf";

$aParam           = array();
$aParam['$inscr'] = $inscr;

$cltabativ       = new cl_tabativ();
$clativprinc     = new cl_ativprinc();
$cldb_config     = new cl_db_config();
$clissprocesso   = new cl_issprocesso();

$pdf = new scpdf();
$pdf->Open();

$rsResultpar = db_query("select * from parissqn");
if (pg_numrows($rsResultpar) > 0) {
  db_fieldsmemory($rsResultpar, 0);
}

$impdatas = $q60_impdatas;
$impcodativ = $q60_impcodativ;
$impobsativ = $q60_impobsativ;
$impobslanc = $q60_impobsissqn;

$ano = db_getsession("DB_anousu");

$pdf1 = new db_impcarne($pdf, '98'); // certidão de baixa
$pdf1->objpdf->AddPage();
$pdf1->objpdf->SetTextColor(0, 0, 0);
  
$resul = $cldb_config->sql_record($cldb_config->sql_query(db_getsession("DB_instit"), "nomeinst as prefeitura, munic"));
db_fieldsmemory($resul, 0); //pega o dados da prefa
$munic = strtoupper($munic);

$oUsuario = new UsuarioSistema(db_getsession('DB_id_usuario'));
$nome_usuario = $oUsuario->getNome();

$result = $cltabativ->sql_record($cltabativ->sql_queryinf($inscr, "", "*", "", "(q07_databx <= '" . date("Y-m-d", db_getsession("DB_datausu")) . "' or  q07_databx is null) and tabativ.q07_inscr = $inscr "));
$numrows = $cltabativ->numrows;
if ($numrows > 0) {
  db_fieldsmemory($result, 0);
} else {
  db_redireciona('db_erros.php?fechar=true&db_erro=Atividades não cadastradas!');
}
  
//================================= PARAGRAFOS BAIXA DE ALVARA =====================================================

$pdf1->tipoalvara = 'CERTIDÃO DE BAIXA DE ALVARÁ';
    
$sqlparag = "select *
    from db_documento
    inner join db_docparag on db03_docum = db04_docum
    inner join db_tipodoc on db08_codigo  = db03_tipodoc
    inner join db_paragrafo on db04_idparag = db02_idparag
    where db03_tipodoc = 2036 and db03_instit = " . db_getsession("DB_instit") . "
    and not db02_descr ilike 'assinatura%'
    order by db04_ordem ";
$resparag = db_query($sqlparag);

if (pg_numrows($resparag) == 0) {

  if($q60_templatebaixaalvaranormal == null) {

    db_msgbox(_M($sCaminhoMensagem."documento_template_nao_existe"));
    exit;
  }

  $iDocumentoTemplate = $q60_templatebaixaalvaranormal;

  if($q11_oficio == 't') {

    if($q60_templatebaixaalvaraoficial != null) {

      $iDocumentoTemplate = $q60_templatebaixaalvaraoficial;
    }
  }

  $sDescrDoc        = date("YmdHis").db_getsession("DB_id_usuario");
  $sNomeRelatorio   = "tmp/CertidaoBaixaInscricao{$sDescrDoc}.pdf";
  $sCaminhoSalvoSxw = "tmp/CertidaoBaixaInscricao_{$sDescrDoc}_{$inscr}.sxw";

  $sAgt             = "issqn/certidao_baixa_inscricao.agt";

  $aParam           = array();
  $aParam['$inscr'] = $inscr;

  db_stdClass::oo2pdf(46, $iDocumentoTemplate, $sAgt, $aParam, $sCaminhoSalvoSxw, $sNomeRelatorio);

  exit;

}

$numrows = pg_numrows($resparag);

for($i = 0; $i < $numrows; $i ++) {
  db_fieldsmemory($resparag, $i);
  if ($db04_ordem == '1') {
    $pdf1->texto = $db02_texto;
  }
  if ($db04_ordem == '2') {
    $pdf1->obs = $db02_texto;
  }
  if ($db04_ordem == '3') {
    $pdf1->assalvara = $db02_texto;
  }
}

/**
* Busca parametros e tipo da Baixa
*/
$sSqlTabativBaixa  = "select q11_inscr, q11_seq, q11_processo, q11_oficio, ";
$sSqlTabativBaixa .= "       case when q11_oficio = 'f' then 'Normal'     ";
$sSqlTabativBaixa .= "            when 't' then 'Ofício'                  ";
$sSqlTabativBaixa .= "       end as tipo_baixa,                           ";
$sSqlTabativBaixa .= "       q11_login, q11_data, q11_hora, q11_numero    ";
$sSqlTabativBaixa .= "  from tabativbaixa                                 ";
$sSqlTabativBaixa .= " where q11_inscr = " .$inscr;

$rsTabativBaixa    = db_query($sSqlTabativBaixa);
if (pg_numrows($rsTabativBaixa) > 0) {
    db_fieldsmemory($rsTabativBaixa, 0);
}

$pdf1->numerobaixa = $q11_numero;
$pdf1->dtbaixa = $q11_data;
$pdf1->processobaixa = $q11_processo;
$pdf1->obsbaixa = $obsbaixa;

db_sel_instit();

$pdf1->prefeitura = $nomeinst;
$pdf1->municpref = $munic;
$pdf1->ativ = $q07_ativ;
$pdf1->nrinscr = empty($q02_inscmu) ? $q02_inscr : $q02_inscmu;
$pdf1->nome = $z01_nome;
$pdf1->nomecompl = $z01_nomecomple;
$pdf1->processo    = @$q14_proces;
$pdf1->areaterreno = @$q30_area;
$pdf1->cgm = $z01_numcgm;
$pdf1->fantasia = $z01_nomefanta;
$pdf1->obsativ = $q03_atmemo;
$pdf1->ender = $j14_nome;
$pdf1->bairropri = $j13_descr;
$pdf1->compl = $q02_compl;
$pdf1->numero = $q02_numero;
$pdf1->descrativ = empty($q71_estrutural)  ? $q03_descr : "{$q71_estrutural} - {$q03_descr}";
$pdf1->datainc = $q02_dtinic;
$pdf1->cnpjcpf = $z01_cgccpf;
$pdf1->dtiniativ = $q07_datain;
$pdf1->dtfimativ = $q07_datafi;
$pdf1->lancobs = $q02_memo;
$pdf1->dtinic = $q02_dtinic;
$pdf1->icms = $z01_incest;
$pdf1->rg = $z01_ident;
$pdf1->datacad = $q02_dtcada;
$pdf1->q07horaini = $q07_horaini;
$pdf1->q07horafim = $q07_horafim;
$pdf1->q02memo = $q02_memo;

$pdf1->impdatas = $impdatas;
$pdf1->impcodativ = $impcodativ;
$pdf1->impobsativ = $impobsativ;
$pdf1->impobslanc = $impobslanc;

// PEGA AS ATIVIDADES

$result = $cltabativ->sql_record($cltabativ->sql_queryinf($inscr, "", "*", "", " q88_inscr is not null  and tabativ.q07_inscr = $inscr "));

$numrows = $cltabativ->numrows;
if ($numrows != 0) {
  db_fieldsmemory($result, 0);
} 
  
$arr = array ();
$arr02 = array ();
$descr = "";

$result = $cltabativ->sql_record($cltabativ->sql_queryinf($inscr, "", "*", "", " (q07_databx <= '" . date("Y-m-d", db_getsession("DB_datausu")) . "' or  q07_databx is null) and tabativ.q07_inscr = $inscr "));
$numrows = $cltabativ->numrows;

if ($numrows != 0) {
  for($i = 0; $i < $numrows; $i ++) {
    db_fieldsmemory($result, $i);
    if ($descr != $q03_descr) {
      $arr [$i] ["codativ"] = $q07_ativ;
      $arr [$i] ["descr"] = empty($q71_estrutural)  ? $q03_descr : "{$q71_estrutural} - {$q03_descr}";
      $arr [$i] ["datain"] = $q07_datain;
      $arr [$i] ["datafi"] = $q07_datafi;
      $arr [$i] ["atv_perman"] = $q07_perman;
      $q03_atmemo = str_replace("\n", "", $q03_atmemo);
      $q03_atmemo = str_replace("\r", "", $q03_atmemo);
      $arr02 [$q07_ativ] = $q03_atmemo;
    }
  }
}else {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe atividades registros cadastrados.');
  exit();
}
  
$pdf1->q03_atmemo = $arr02;
$pdf1->outrasativs = $arr;

if (isset($q02_memo)) {
  $pdf1->q02_memo = substr($q02_memo, 0, 3500);
  $pdf1->q02_memo .= " ...";
}

$sSqlCodCnae = " select ativprinc.q88_inscr as princ, q71_estrutural ";
$sSqlCodCnae .= "   from tabativ ";
$sSqlCodCnae .= "        left join ativprinc     on ativprinc.q88_inscr          = tabativ.q07_inscr            ";
$sSqlCodCnae .= "                               and ativprinc.q88_seq            = tabativ.q07_seq              ";
$sSqlCodCnae .= "        left join atividcnae    on atividcnae.q74_ativid        = tabativ.q07_ativ             ";
$sSqlCodCnae .= "        left join cnaeanalitica on cnaeanalitica.q72_sequencial = atividcnae.q74_cnaeanalitica ";
$sSqlCodCnae .= "        left join cnae          on cnae.q71_sequencial          = cnaeanalitica.q72_cnae       ";
$sSqlCodCnae .= "  where q07_inscr = {$inscr} ";
$rsCodCnae = db_query($sSqlCodCnae);
$iTotalLinhas = pg_num_rows($rsCodCnae);
for($i = 0; $i < $iTotalLinhas; $i ++) {

  $oCodCnae = db_utils::fieldsMemory($rsCodCnae, $i);

  if (isset($oCodCnae->princ) && $oCodCnae->princ != "") {
    $pdf1->iAtivPrincCnae = substr($oCodCnae->q71_estrutural, 1, strlen($oCodCnae->q71_estrutural));
  } else {
    $pdf1->aCodigosCnae [] = substr($oCodCnae->q71_estrutural, 1, strlen($oCodCnae->q71_estrutural));
  }

}

$pdf1->nome_usuario = $nome_usuario;

$pdf1->imprime();
$pdf1->objpdf->Output();