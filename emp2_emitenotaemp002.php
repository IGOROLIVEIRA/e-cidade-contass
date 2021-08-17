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

require_once("fpdf151/impcarne.php");
require_once("fpdf151/scpdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_empempitem_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_cgmalt_classe.php");
require_once("classes/db_pcforneconpad_classe.php");

/*
 * Configurações GED
*/
require_once("integracao_externa/ged/GerenciadorEletronicoDocumento.model.php");
require_once("integracao_externa/ged/GerenciadorEletronicoDocumentoConfiguracao.model.php");
require_once("libs/exceptions/BusinessException.php");

$oGet = db_utils::postMemory($_GET);
$oConfiguracaoGed = GerenciadorEletronicoDocumentoConfiguracao::getInstance();
if ($oConfiguracaoGed->utilizaGED()) {

  if (!empty($oGet->dtInicial) || !empty($oGet->dtFinal)) {

    $sMsgErro  = "O parâmetro para utilização do GED (Gerenciador Eletrônico de Documentos) está ativado.<br><br>";
    $sMsgErro .= "Neste não é possível informar interválos de códigos ou datas.<br><br>";
    db_redireciona("db_erros.php?fechar=true&db_erro={$sMsgErro}");
    exit;
  }
}


$clempparametro      = new cl_empparametro;
$clempautitem       = new cl_empautitem;
$clcgmalt           = new cl_cgmalt;
$cldb_pcforneconpad = new cl_pcforneconpad;
$clempempitem       = new cl_empempitem;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);

$head3 = "CADASTRO DE CÓDIGOS";
//$head5 = "PERÍODO : ".$mes." / ".$ano;

$sqlpref  = "select db_config.*, cgm.z01_incest as inscricaoestadualinstituicao ";
$sqlpref .= "  from db_config                                                     ";
$sqlpref .= " inner join cgm on cgm.z01_numcgm = db_config.numcgm                 ";
$sqlpref .=  "	where codigo = " . db_getsession("DB_instit");

$resultpref = db_query($sqlpref);

db_fieldsmemory($resultpref, 0);

$anousu = db_getsession("DB_anousu");
$dbwhere = '1=1';
if (isset($e60_numemp) && $e60_numemp != '') {
  $dbwhere     = " e60_numemp = $e60_numemp ";
  $sql         = "select e60_anousu as anousu from empempenho where $dbwhere";
  $res_empenho = @db_query($sql);
  $numrows_empenho = @pg_numrows($res_empenho);
  if ($numrows_empenho != 0) {
    db_fieldsmemory($res_empenho, 0);
  }
} else if ((isset($e60_codemp) && $e60_codemp != '') && (isset($e60_codemp_fim) && $e60_codemp_fim != '')) {
  $arr = explode("/", $e60_codemp);
  $arr2 = explode("/", $e60_codemp_fim);
  if (count($arr) == 2  && isset($arr[1]) && $arr[1] != '') {
    $dbwhere_ano = " and e60_anousu = " . $arr[1];
    $anousu = $arr[1];
  } else {
    $dbwhere_ano = " and e60_anousu = " . db_getsession("DB_anousu");
  }
  $dbwhere = "e60_codemp::integer >=" . $arr[0] . ". and e60_codemp::integer <='" . $arr2[0] . "'$dbwhere_ano";
} else if (isset($e60_codemp) && $e60_codemp != '') {
  $arr = explode("/", $e60_codemp);
  if (count($arr) == 2  && isset($arr[1]) && $arr[1] != '') {
    $dbwhere_ano = " and e60_anousu = " . $arr[1];
    $anousu = $arr[1];
  } else {
    $dbwhere_ano = " and e60_anousu = " . db_getsession("DB_anousu");
  }
  $dbwhere = "e60_codemp='" . $arr[0] . "'$dbwhere_ano";
} else {
  if (isset($dtini_dia)) {
    $dbwhere = " e60_emiss >= '$dtini_ano-$dtini_mes-$dtini_dia'";

    if (isset($dtfim_dia)) {
      $dbwhere .= " and e60_emiss <= '$dtfim_ano-$dtfim_mes-$dtfim_dia'";
    }
  }
}

if (isset($listacgm) && $listacgm != '') {
  if ($ver == 'com')
    $dbwhere .= "and cgm.z01_numcgm in ($listacgm)";
  elseif ($ver == 'sem')
    $dbwhere .= "and cgm.z01_numcgm not in ($listacgm)";
}

$sqlemp  = " SELECT empempenho.*, ";
$sqlemp .= "        cgm.*, ";
$sqlemp .= "        o58_orgao, ";
$sqlemp .= "        o40_descr, ";
$sqlemp .= "        o58_unidade, ";
$sqlemp .= "        o41_descr, ";
$sqlemp .= "        o58_funcao, ";
$sqlemp .= "        o52_descr, ";
$sqlemp .= "        o58_subfuncao, ";
$sqlemp .= "        o53_descr, ";
$sqlemp .= "        o58_programa, ";
$sqlemp .= "        o54_descr, ";
$sqlemp .= "        o58_projativ, ";
$sqlemp .= "        o55_descr, ";
$sqlemp .= "        o58_coddot, ";
$sqlemp .= "        o41_cnpj, ";
$sqlemp .= "        o56_elemento AS sintetico, ";
$sqlemp .= "        o56_descr AS descr_sintetico, ";
$sqlemp .= "        o58_codigo, ";
$sqlemp .= "        o15_descr, ";
$sqlemp .= "        e61_autori, ";
$sqlemp .= "        pc50_descr, ";
$sqlemp .= "        fc_estruturaldotacao(o58_anousu,o58_coddot) AS estrutural, ";
$sqlemp .= "        e41_descr, ";
$sqlemp .= "        c58_descr, ";
$sqlemp .= "        e56_orctiporec, ";
$sqlemp .= "        e54_anousu, ";
$sqlemp .= "        e54_praent, ";
$sqlemp .= "        e54_tipoautorizacao, ";
$sqlemp .= "        e54_tipoorigem, ";
$sqlemp .= "        e54_nummodalidade, ";
$sqlemp .= "        e54_licoutrosorgaos, ";
$sqlemp .= "        e54_adesaoregpreco, ";
$sqlemp .= "        e54_numerl, ";
$sqlemp .= "        e54_codout, ";
$sqlemp .= "        e54_conpag, ";
$sqlemp .= "        e54_autori, ";
/*OC4401*/
$sqlemp .= "        e60_id_usuario, ";
$sqlemp .= "        db_usuarios.nome, ";
/*FIM - OC4401*/
$sqlemp .= "        ordena.z01_numcgm AS cgmordenadespesa, ";
$sqlemp .= "        ordena.z01_nome AS ordenadesp, ";
$sqlemp .= "        liquida.z01_numcgm AS cgmliquida, ";
$sqlemp .= "        liquida.z01_nome AS liquida, ";
$sqlemp .= "        paga.z01_numcgm AS cgmpaga, ";
$sqlemp .= "        paga.z01_nome AS ordenapaga, ";
$sqlemp .= "        contador.z01_nome AS contador, ";
$sqlemp .= "        contad.si166_crccontador AS crc, ";
$sqlemp .= "        controleinterno.z01_nome AS controleinterno ";
$sqlemp .= " FROM empempenho ";
/*OC4401*/
$sqlemp .= " LEFT JOIN db_usuarios ON db_usuarios.id_usuario = e60_id_usuario";
/*FIM - OC4401*/
$sqlemp .= " LEFT JOIN pctipocompra ON pc50_codcom = e60_codcom ";
$sqlemp .= " INNER JOIN orcdotacao ON o58_coddot = e60_coddot AND o58_instit = " . db_getsession("DB_instit") . " AND o58_anousu = e60_anousu ";
$sqlemp .= " INNER JOIN orcorgao ON o58_orgao = o40_orgao AND o40_anousu = $anousu ";
$sqlemp .= " INNER JOIN orcunidade ON o58_unidade = o41_unidade AND o58_orgao = o41_orgao AND o41_anousu = o58_anousu ";
$sqlemp .= " INNER JOIN orcfuncao ON o58_funcao = o52_funcao ";
$sqlemp .= " INNER JOIN orcsubfuncao ON o58_subfuncao = o53_subfuncao ";
$sqlemp .= " INNER JOIN orcprograma ON o58_programa = o54_programa AND o54_anousu = o58_anousu ";
$sqlemp .= " INNER JOIN orcprojativ ON o58_projativ = o55_projativ AND o55_anousu = o58_anousu ";
$sqlemp .= " INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu ";
$sqlemp .= " INNER JOIN orctiporec ON o58_codigo = o15_codigo ";
$sqlemp .= " INNER JOIN cgm ON z01_numcgm = e60_numcgm ";
$sqlemp .= " INNER JOIN concarpeculiar ON concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar ";
$sqlemp .= " LEFT JOIN cgm AS ordena ON ordena.z01_numcgm = o41_orddespesa ";
$sqlemp .= " LEFT JOIN cgm AS paga ON paga.z01_numcgm = o41_ordpagamento ";
$sqlemp .= " LEFT JOIN cgm AS liquida ON liquida.z01_numcgm = o41_ordliquidacao ";
$sqlemp .= " LEFT JOIN identificacaoresponsaveis contad ON contad.si166_instit= e60_instit ";
$sqlemp .= " AND contad.si166_tiporesponsavel=2 ";
$sqlemp .= " AND (contad.si166_dataini <=  e60_emiss ";
$sqlemp .= " AND contad.si166_datafim >=  e60_emiss) ";
$sqlemp .= " LEFT JOIN cgm AS contador ON contador.z01_numcgm = contad.si166_numcgm ";
$sqlemp .= " LEFT JOIN identificacaoresponsaveis controle ON controle.si166_instit= e60_instit ";
$sqlemp .= " AND controle.si166_tiporesponsavel=3 ";
$sqlemp .= " AND (controle.si166_dataini <=  e60_emiss ";
$sqlemp .= " AND controle.si166_datafim >=  e60_emiss) ";
$sqlemp .= " LEFT JOIN cgm AS controleinterno ON controleinterno.z01_numcgm = controle.si166_numcgm ";
$sqlemp .= " LEFT OUTER JOIN empempaut ON e60_numemp = e61_numemp ";
$sqlemp .= " LEFT JOIN empautoriza ON e61_autori = e54_autori ";
$sqlemp .= " LEFT JOIN empautidot ON e61_autori = e56_autori ";
//$sqlemp .= "LEFT JOIN empautitem ON e55_autori = e56_autori";
$sqlemp .= " LEFT OUTER JOIN emptipo ON e60_codtipo= e41_codtipo ";
$sqlemp .= " WHERE $dbwhere ";
$sqlemp .= " order by e60_codemp::bigint ";

$result = db_query($sqlemp);
//die($sqlemp); db_criatabela($result);exit;

if (pg_numrows($result) == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado !  ");
}

$pdf = new scpdf();

$pdf->Open();

$pdf1 = new db_impcarne($pdf, '6');
$pdf1->objpdf->SetTextColor(0, 0, 0);
//$pdf1->objpdf->Output();

//rotina que pega o numero de vias
//add campo e30_impobslicempenho
$sCampos      = "e30_nroviaemp,e30_numdec,e30_impobslicempenho,e30_dadosbancoempenho";
$sSqlEmpParam = $clempparametro->sql_query_file(db_getsession("DB_anousu"), $sCampos);
$result02     = $clempparametro->sql_record($sSqlEmpParam);
if ($clempparametro->numrows == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado na empparametro!");
}

db_fieldsmemory($result02, 0);

//recebido variavel
$pdf1->nvias              = $e30_nroviaemp;
$pdf1->casadec            = $e30_numdec;
$pdf1->dadosbancoemprenho = $e30_dadosbancoempenho;

for ($i = 0; $i < pg_numrows($result); $i++) {

  db_fieldsmemory($result, $i);

  $sSqlPcFornecOnPad  = $cldb_pcforneconpad->sql_query(null, "*", null, "pc63_numcgm = {$e60_numcgm}");
  $rsSqlPcFornecOnPad = $cldb_pcforneconpad->sql_record($sSqlPcFornecOnPad);

  if (!$rsSqlPcFornecOnPad == false && $cldb_pcforneconpad->numrows > 0) {
    $oPcFornecOnPad     = db_utils::fieldsMemory($rsSqlPcFornecOnPad, 0);
  } else {

    $oPcFornecOnPad = new stdClass();
    $oPcFornecOnPad->pc63_banco       = '';
    $oPcFornecOnPad->pc63_agencia     = '';
    $oPcFornecOnPad->pc63_agencia_dig = '';
    $oPcFornecOnPad->pc63_conta       = '';
    $oPcFornecOnPad->pc63_conta_dig   = '';
  }

  $sSqlPacto  = " SELECT distinct pactoplano.* ";
  $sSqlPacto .= "   from empautitem ";
  $sSqlPacto .= "        inner join empautitempcprocitem       on empautitempcprocitem.e73_autori = empautitem.e55_autori";
  $sSqlPacto .= "                                             and empautitempcprocitem.e73_sequen = empautitem.e55_sequen";
  $sSqlPacto .= "        inner join pcprocitem                 on pcprocitem.pc81_codprocitem     = empautitempcprocitem.e73_pcprocitem";
  $sSqlPacto .= "        inner join solicitem                  on pc81_solicitem                  = pc11_codigo";
  $sSqlPacto .= "        inner join orctiporecconveniosolicita on pc11_numero                     = o78_solicita";
  $sSqlPacto .= "        inner join pactoplano                 on o78_pactoplano                  = o74_sequencial";
  $sSqlPacto .= "  where e55_autori = {$e61_autori}";
  $rsPacto    = db_query($sSqlPacto);

  $o74_descricao       = null;
  $o78_pactoplano      = null;
  if (@pg_num_rows($rsPacto) > 0) {

    $oPacto              = db_utils::fieldsMemory($rsPacto, 0);
    $o74_descricao       = $oPacto->o74_descricao;
    $o78_pactoplano      = $oPacto->o74_sequencial;
  }

  /**
   * Busca o processo
   */
  $oDaoEmpAutorizaProcesso  = db_utils::getDao("empautorizaprocesso");
  $sWhereBuscaProcessoAdmin = " e150_empautoriza = {$e61_autori}";
  $sSqlBuscaProcessoAdmin   = $oDaoEmpAutorizaProcesso->sql_query_file(null, "e150_numeroprocesso", null, $sWhereBuscaProcessoAdmin);
  $rsBuscaProcessoAdmin     = $oDaoEmpAutorizaProcesso->sql_record($sSqlBuscaProcessoAdmin);
  $sProcessoAdministrativo  = "";

  if ($rsBuscaProcessoAdmin && $oDaoEmpAutorizaProcesso->numrows > 0) {
    $sProcessoAdministrativo = db_utils::fieldsMemory($rsBuscaProcessoAdmin, 0)->e150_numeroprocesso;
  }

  $sCondtipos = "";
  if (isset($tipos) && !empty($tipos)) {
    $sCondtipos = " $tipos as tipos, ";
  }

  $sqlitem  = " select distinct ";
  $sqlitem .= "        pc01_complmater, ";
  $sqlitem .= "        pc01_descrmater, ";
  $sqlitem .= "        pc10_numero, ";
  $sqlitem .= "        e62_sequen, ";
  $sqlitem .= "        e62_numemp, ";
  $sqlitem .= "        pc01_codmater, ";
  $sqlitem .= "        e62_quant, ";
  $sqlitem .= "        e62_vltot, ";
  $sqlitem .= "        e62_vlrun, ";
  $sqlitem .= "        e62_codele, ";
  $sqlitem .= "        o56_elemento, ";
  $sqlitem .=          $sCondtipos;
  $sqlitem .= "        o56_descr, ";
  $sqlitem .= "        rp.pc81_codproc, ";
  $sqlitem .= "        solrp.pc11_numero, ";
  $sqlitem .= "        solrp.pc11_codigo, ";
  $sqlitem .= "        l20_prazoentrega, ";
  $sqlitem .= "        e55_marca, ";
  /*OC4401*/
  $sqlitem .= "        e60_id_usuario, ";
  $sqlitem .= "        db_usuarios.nome, ";
  /*FIM - OC4401*/
  $sqlitem .= "        case when pc10_solicitacaotipo = 5 then coalesce(trim(pcitemvalrp.pc23_obs), '') ";
  $sqlitem .= "             else  coalesce(trim(pcorcamval.pc23_obs), '') end as pc23_obs ";
  $sqlitem .= "   from empempitem ";
  $sqlitem .= "       inner join empempenho           on empempenho.e60_numemp           = empempitem.e62_numemp ";
  /*OC4401*/
  $sqlitem .= "       left join db_usuarios ON db_usuarios.id_usuario = empempenho.e60_id_usuario";
  /*OC4401*/
  $sqlitem .= "       inner join pcmater              on pcmater.pc01_codmater           = empempitem.e62_item ";
  $sqlitem .= "       inner join orcelemento          on orcelemento.o56_codele          = empempitem.e62_codele ";
  $sqlitem .= "                                      and orcelemento.o56_anousu          = empempenho.e60_anousu ";
  $sqlitem .= "       left join empempaut             on empempaut.e61_numemp            = empempenho.e60_numemp ";
  $sqlitem .= "       left join empautitem            on empautitem.e55_autori           = empempaut.e61_autori ";
  $sqlitem .= "                                      and e62_sequen = e55_sequen ";

  // verificação de empenhos de registro de preco

  $sqlitem .= "       left join empautitempcprocitem        on empautitempcprocitem.e73_autori      = empautitem.e55_autori ";
  $sqlitem .= "                                            and empautitempcprocitem.e73_sequen      = empautitem.e55_sequen ";
  $sqlitem .= "       left join pcprocitem rp               on rp.pc81_codprocitem                  = empautitempcprocitem.e73_pcprocitem ";
  $sqlitem .= "       left join solicitem solrp             on solrp.pc11_codigo                    = rp.pc81_solicitem ";
  $sqlitem .= "       left join solicita                    on solicita.pc10_numero                 = solrp.pc11_numero ";
  $sqlitem .= "       left join solicitemvinculo            on solicitemvinculo.pc55_solicitemfilho = solrp.pc11_codigo ";
  $sqlitem .= "       left join solicitem compilacao        on solicitemvinculo.pc55_solicitempai   = compilacao.pc11_codigo ";
  $sqlitem .= "       left join pcprocitem proccompilacao   on pc55_solicitempai                    = proccompilacao.pc81_solicitem ";
  $sqlitem .= "       left join liclicitem licitarp         on proccompilacao.pc81_codprocitem      = licitarp.l21_codpcprocitem ";
  $sqlitem .= "       left join pcorcamitemlic pcitemrp     on licitarp.l21_codigo                  = pcitemrp.pc26_liclicitem ";
  $sqlitem .= "       left join pcorcamjulg julgrp          on pcitemrp.pc26_orcamitem              = julgrp.pc24_orcamitem ";
  $sqlitem .= "                                            and julgrp.pc24_pontuacao                = 1 ";
  $sqlitem .= "       left join pcorcamval pcitemvalrp      on julgrp.pc24_orcamitem                = pcitemvalrp.pc23_orcamitem ";
  $sqlitem .= "                                            and julgrp.pc24_orcamforne               = pcitemvalrp.pc23_orcamforne ";

  //verficaao de empenhos gerados a partir de licitacao normal.

  $sqlitem .= "       left join empautitempcprocitem  pcprocitemaut  on pcprocitemaut.e73_autori        = empautitem.e55_autori ";
  $sqlitem .= "                                                     and pcprocitemaut.e73_sequen        = empautitem.e55_sequen ";
  $sqlitem .= "       left join pcprocitem                           on pcprocitem.pc81_codprocitem     = pcprocitemaut.e73_pcprocitem ";
  $sqlitem .= "       left join solicitem                            on solicitem.pc11_codigo           = pcprocitem.pc81_solicitem ";
  $sqlitem .= "       left join liclicitem                           on liclicitem.l21_codpcprocitem    = pcprocitemaut.e73_pcprocitem ";
  $sqlitem .= "       left join pcorcamitemlic                       on pcorcamitemlic.pc26_liclicitem  = liclicitem.l21_codigo ";
  $sqlitem .= "       left join pcorcamjulg                          on pcorcamjulg.pc24_orcamitem      = pcorcamitemlic.pc26_orcamitem ";
  $sqlitem .= "                                                     and pcorcamjulg.pc24_pontuacao      = 1 ";
  $sqlitem .= "       left join pcorcamval                           on pcorcamval.pc23_orcamitem       = pcorcamjulg.pc24_orcamitem ";
  $sqlitem .= "                                                     and pcorcamval.pc23_orcamforne      = pcorcamjulg.pc24_orcamforne ";
  $sqlitem .= "		left join solicitemunid on solicitem.pc11_codigo = solicitemunid.pc17_codigo";
  $sqlitem .= "		left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid or matunid.m61_codmatunid = e55_unid";
  $sqlitem .= "       left join liclicita on liclicitem.l21_codliclicita = liclicita.l20_codigo ";
  $sqlitem .= "  where e62_numemp = '{$e60_numemp}' ";
  $sqlitem .= " order by e62_sequen, o56_elemento,pc01_descrmater";
  //    echo $sqlitem;exit;
  $resultitem = db_query($sqlitem);

  db_fieldsmemory($resultitem, 0);

  $result_cgmalt = $clcgmalt->sql_record($clcgmalt->sql_query_file(null, "z05_numcgm as z01_numcgm,z05_nome as z01_nome,z05_telef as z01_telef,z05_ender as z01_ender,z05_numero as z01_numero,z05_munic as z01_munic,z05_cgccpf as z01_cgccpf,z05_cep as z01_cep", " abs(z05_data_alt - date '$e60_emiss') asc, z05_sequencia desc limit 1", "z05_numcgm = $z01_numcgm and z05_data_alt > '$e60_emiss' "));

  if ($clcgmalt->numrows > 0) {
    db_fieldsmemory($result_cgmalt, 0);
  }

  /**
   * Verificamos o cnpj da unidade. caso diferente de null, e diferente do xcnpj da instituição,
   * mostramso a descrição e o cnpj da unidade
   */
  if ($o41_cnpj != "" && $o41_cnpj != $cgc) {
    $nomeinst = $o41_descr;
    $cgc      = $o41_cnpj;
  }

  $sSqlFuncaoOrdenaPagamento  = "select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenapagamento ";
  $sSqlFuncaoOrdenaPagamento .= " from rhpessoal  ";
  $sSqlFuncaoOrdenaPagamento .= "LEFT join rhpessoalmov on rh02_regist=rh01_regist  ";
  $sSqlFuncaoOrdenaPagamento .= "LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao ";
  $sSqlFuncaoOrdenaPagamento .= "LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes ";
  $sSqlFuncaoOrdenaPagamento .= "LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo  ";
  $sSqlFuncaoOrdenaPagamento .= "LEFT JOIN rhpesrescisao ON rh02_seqpes=rh05_seqpes ";
  $sSqlFuncaoOrdenaPagamento .= "where rh05_recis is null and rh01_numcgm = $cgmpaga ";
  $sSqlFuncaoOrdenaPagamento .= " AND rh02_anousu = " . date('Y', strtotime($e60_emiss));
  $sSqlFuncaoOrdenaPagamento .= " AND rh02_mesusu = " . date('m', strtotime($e60_emiss));
  $sSqlFuncaoOrdenaPagamento .= " order by  rh02_seqpes asc limit 1 ";
  $pdf1->cargoordenapagamento = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenaPagamento), 0)->cargoordenapagamento;

  $sSqlFuncaoOrdenadespesa = " select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenadespesa";
  $sSqlFuncaoOrdenadespesa .= " from rhpessoal ";
  $sSqlFuncaoOrdenadespesa .= " LEFT join rhpessoalmov on rh02_regist=rh01_regist ";
  $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao";
  $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes";
  $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo ";
  $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhpesrescisao ON rh02_seqpes=rh05_seqpes ";
  $sSqlFuncaoOrdenadespesa .= " where rh05_recis is null and rh01_numcgm = $cgmordenadespesa";
  $sSqlFuncaoOrdenadespesa .= " AND rh02_anousu = " . date('Y', strtotime($e60_emiss));
  $sSqlFuncaoOrdenadespesa .= " AND rh02_mesusu = " . date('m', strtotime($e60_emiss));
  $sSqlFuncaoOrdenadespesa .= "order by rh02_seqpes asc limit 1";

  $pdf1->cargoordenadespesa = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenadespesa), 0)->cargoordenadespesa;

  //assinaturas
  $pdf1->ordenadespesa   =  $ordenadesp;
  $pdf1->liquida         =  $liquida;
  $pdf1->ordenapagamento =  $ordenapaga;
  $pdf1->contador        =  $contador;
  $pdf1->crccontador     =  $crc;
  $pdf1->controleinterno =  $controleinterno;
  $pdf1->emptipo              = $e41_descr;
  $pdf1->prefeitura           = $nomeinst;
  $pdf1->enderpref            = $ender . ", " . $numero;
  $pdf1->cgcpref              = $cgc;
  $pdf1->municpref            = $munic;
  $pdf1->telefpref            = $telef;
  $pdf1->emailpref            = $email;

  $pdf1->inscricaoestadualinstituicao    = '';
  if ($db21_usasisagua == 't') {
    $pdf1->inscricaoestadualinstituicao    = "- Inscrição Estadual: " . $inscricaoestadualinstituicao;
  }

  $pdf1->numcgm               = $z01_numcgm;
  $pdf1->nome                 = $z01_nome;
  $pdf1->telefone             = $z01_telef;
  $pdf1->ender                = $z01_ender;
  $pdf1->bairro               = $z01_bairro;
  $pdf1->munic                = $z01_munic;
  $pdf1->cnpj                 = $z01_cgccpf;
  $pdf1->cep                  = $z01_cep;
  $pdf1->ufFornecedor         = $z01_uf;
  $pdf1->prazo_entrega        = $e54_praent;
  $pdf1->condicao_pagamento   = $e54_conpag;
  $pdf1->outras_condicoes     = $e54_codout;
  $pdf1->iBancoFornecedor     = $oPcFornecOnPad->pc63_banco;
  $pdf1->iAgenciaForncedor    = $oPcFornecOnPad->pc63_agencia . "-" . $oPcFornecOnPad->pc63_agencia_dig;
  $pdf1->iContaForncedor      = $oPcFornecOnPad->pc63_conta . "-" . $oPcFornecOnPad->pc63_conta_dig;
  $pdf1->dotacao              = $estrutural;
  $pdf1->solicitacao          = $pc10_numero;
  $pdf1->num_licitacao        = $e60_numerol;
  $pdf1->cod_concarpeculiar   = $e60_concarpeculiar;
  $pdf1->descr_concarpeculiar = substr($c58_descr, 0, 34);
  $pdf1->logo                 = $logo;
  $pdf1->SdescrPacto          = $o74_descricao;
  $pdf1->iPlanoPacto          = $o78_pactoplano;
  $pdf1->contrapartida        = $e56_orctiporec;
  $pdf1->observacaoitem       = "pc23_obs";
  $pdf1->Snumeroproc          = "pc81_codproc";
  $pdf1->Snumero              = "pc11_numero";
  $pdf1->marca                = "e55_marca";
  $pdf1->processo_administrativo = $sProcessoAdministrativo;
  $pdf1->coddot           = $o58_coddot;
  $pdf1->destino          = $e60_destin;
  $pdf1->licitacao        = $e60_codtipo;
  $pdf1->recorddositens   = $resultitem;
  $pdf1->linhasdositens   = pg_numrows($resultitem);
  //Zera as variáveis
  $pdf1->resumo = "";
  $resumo_lic   = "";

  //    $result_licita = $clempautitem->sql_record($clempautitem->sql_query_lic(null,null,"distinct l20_edital, l20_anousu, l20_objeto, l03_descr",null,"e55_autori = $e61_autori "));
  //    if ($clempautitem->numrows>0){
  //        db_fieldsmemory($result_licita,0);
  //
  //        $pdf1->edital_licitacao     = $l20_edital;
  //        $pdf1->ano_licitacao        = $l20_anousu;
  //        $resumo_lic                 = $l20_objeto;
  //
  //    } else {
  //
  //        $l03_descr                  = '';
  //        $l20_objeto                 = '';
  //        $pdf1->edital_licitacao     = '';
  //        $pdf1->ano_licitacao        = '';
  //
  //    }
  //
  $result_licita = $clempautitem->sql_record($clempautitem->sql_query_lic(null, null, "distinct l20_edital, l20_numero, l20_anousu, l20_objeto,l03_descr", null, "e55_autori = $e54_autori "));

  if ($clempautitem->numrows > 0) {
    db_fieldsmemory($result_licita, 0);
    $pdf1->edital_licitacao = $l20_edital . '/' . $l20_anousu;
    $pdf1->ano_licitacao = $l20_anousu;
    $pdf1->modalidade = $l20_numero . '/' . $l20_anousu;
    $resumo_lic = $l20_objeto;
    $pdf1->observacaoitem = "pc23_obs";
  }


  if (isset($resumo_lic) && $resumo_lic != "") {
    if ($e30_impobslicempenho == 't') {
      $pdf1->resumo = $resumo_lic . "\n" . $e60_resumo;
    } else {
      $pdf1->resumo = $e60_resumo;
    }
  } else {
    $pdf1->resumo = $e60_resumo;
  }


  $Sresumo = $pdf1->resumo;
  $vresumo = explode("\n", $Sresumo);

  if (count($vresumo) > 1) {
    $Sresumo   = "";
    $separador = "";
    for ($x = 0; $x < count($vresumo); $x++) {
      if (trim($vresumo[$x]) != "") {
        $separador = ". ";
        $Sresumo  .= $vresumo[$x] . $separador;
      }
    }
  }

  if (count($vresumo) == 0) {
    $Sresumo = str_replace("\n", ". ", $Sresumo);
  }

  $Sresumo = str_replace("\r", "", $Sresumo);

  $pdf1->resumo = substr($Sresumo, 0, 730);


  /**
   * Crio os campos PROCESSO/ANO,MODALIDADE/ANO e DESCRICAO MODALIDADE de acordo com solicitação
   * @MarioJunior OC 7425
   */
  //tipo Direta

  if ($e54_tipoautorizacao == 1 || $e54_tipoautorizacao == 0) {
    $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo", null, "e55_autori = $e54_autori "));
    if ($clempautitem->numrows > 0) {
      db_fieldsmemory($result_empaut, 0);
      if ($e54_numerl != "") {
        $arr_numerl = explode("/", $e54_numerl);
        $pdf1->edital_licitacao = $arr_numerl[0] . '/' . $arr_numerl[1];
        $pdf1->modalidade = $e54_nummodalidade . '/' . $arr_numerl[1];
        $pdf1->resumo     = $e60_resumo;
      } else {
        $pdf1->edital_licitacao = "";
        $pdf1->modalidade = "";
      }
    }
    $pdf1->descr_tipocompra = $pc50_descr;
    $pdf1->descr_modalidade = $pc50_descr;
  }

  //tipo licitacao de outros orgaos

  if ($e54_tipoautorizacao == 2) {
    $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo", null, "e55_autori = $e54_autori "));
    if ($clempautitem->numrows > 0) {
      db_fieldsmemory($result_empaut, 0);
      $arr_numerl = explode("/", $e54_numerl);
      $pdf1->edital_licitacao = $arr_numerl[0] . '/' . $arr_numerl[1];
      $pdf1->modalidade = $e54_nummodalidade . '/' . $arr_numerl[1];
      $pdf1->resumo     = $e60_resumo;
    }
    $pdf1->descr_tipocompra = substr($pc50_descr, 0, 36);
    $pdf1->descr_modalidade = '';
  }

  //tipo licitacao
  if ($e54_tipoautorizacao == 3) {
    $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo", null, "e55_autori = $e54_autori "));
    if ($clempautitem->numrows > 0) {
      db_fieldsmemory($result_empaut, 0);
      $arr_numerl = explode("/", $e54_numerl);
      $pdf1->edital_licitacao = $arr_numerl[0] . '/' . $arr_numerl[1];
      $pdf1->modalidade = $e54_nummodalidade . '/' . $arr_numerl[1];
      $pdf1->resumo     = $e60_resumo;
    }
    $pdf1->descr_tipocompra = $pc50_descr;
    $pdf1->descr_modalidade = $pc50_descr;
  }

  //tipo Adesao regpreco
  if ($e54_tipoautorizacao == 4) {
    $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo", null, "e55_autori = $e54_autori "));
    if ($clempautitem->numrows > 0) {
      db_fieldsmemory($result_empaut, 0);
      $arr_numerl = explode("/", $e54_numerl);
      $pdf1->edital_licitacao = $arr_numerl[0] . '/' . $arr_numerl[1];
      $pdf1->modalidade = $e54_nummodalidade . '/' . $arr_numerl[1];
      $pdf1->resumo     = $e60_resumo;
    }
    $pdf1->descr_tipocompra = $pc50_descr;
    $pdf1->descr_modalidade = '';
  }

  $sSql = " SELECT ac16_numeroacordo, ac16_anousu from empempenhocontrato JOIN acordo ON ac16_sequencial = e100_acordo where e100_numemp = " . $e60_numemp;
  $rsAcordo = db_query($sSql);
  $oAcordo = db_utils::fieldsMemory($rsAcordo, 0);

  //    if (isset($resumo_lic)&&$resumo_lic!=""){
  //        if (isset($e54_resumo) && trim($e54_resumo) != ""){
  //            $pdf1->resumo     = trim($e54_resumo);//trim($sResumo);
  //        } else {
  //            $pdf1->resumo     = trim($resumo_lic);
  //        }
  //
  //    } else {
  //
  //        if (isset($e54_resumo) && trim($e54_resumo) != "") {
  //            $pdf1->resumo = trim($e54_resumo);
  //        } else {
  //            $pdf1->resumo = trim($sResumo);
  //        }
  //
  //        $pdf1->observacaoitem  = 'e55_descr';
  //    }
  //
  //$pdf1->resumo  = substr(str_replace("\n", " ", $pdf1->resumo), 0, 400);
  $pdf1->resumo  = substr($pdf1->resumo, 0, 730);

  if (!empty($e54_praent)) {
    $pdf1->prazo_ent              = $e54_praent;
  } else {
    $pdf1->prazo_ent              = db_utils::fieldsMemory($resultitem, 0)->l20_prazoentrega;
  }

  $pdf1->quantitem        = "e62_quant";
  $pdf1->valoritem        = "e62_vltot";
  $pdf1->valor            = "e62_vlrun";
  $pdf1->descricaoitem    = "pc01_descrmater";
  $pdf1->complmater       = "pc01_complmater";

  $pdf1->orcado          = $e60_vlrorc;
  $pdf1->saldo_ant        = $e60_salant;
  $pdf1->empenhado        = $e60_vlremp;
  $pdf1->numemp           = $e60_numemp;
  /*OC4401*/
  $pdf1->usuario          = $nome;
  /*FIM - OC4401*/
  $pdf1->codemp           = $e60_codemp;
  $pdf1->numaut           = $e61_autori;
  $pdf1->orgao            = $o58_orgao;
  $pdf1->descr_orgao      = $o40_descr;
  $pdf1->unidade          = $o58_unidade;
  $pdf1->descr_unidade    = $o41_descr;
  $pdf1->funcao           = $o58_funcao;
  $pdf1->descr_funcao     = $o52_descr;
  $pdf1->subfuncao        = $o58_subfuncao;
  $pdf1->descr_subfuncao  = $o53_descr;
  $pdf1->programa         = $o58_programa;
  $pdf1->descr_programa   = $o54_descr;
  $pdf1->projativ         = $o58_projativ;
  $pdf1->descr_projativ   = $o55_descr;
  $pdf1->analitico        = "o56_elemento";
  $pdf1->descr_analitico  = "o56_descr";
  $pdf1->sintetico        = $sintetico;
  $pdf1->descr_sintetico  = $descr_sintetico;
  $pdf1->recurso          = $o58_codigo;
  $pdf1->descr_recurso    = $o15_descr;
  $pdf1->banco            = null;
  $pdf1->agencia          = null;
  $pdf1->conta            = null;
  $pdf1->tipos            = $tipos;
  $pdf1->numero           = $z01_numero;
  $pdf1->marca            = 'e55_marca';
  $pdf1->acordo           = $oAcordo->ac16_numeroacordo;
  $pdf1->anoacordo        = $oAcordo->ac16_anousu;

  $sql  = "select c61_codcon
              from conplanoreduz
                   inner join conplano on c60_codcon = c61_codcon and c60_anousu=c61_anousu
                   inner join consistema on c52_codsis = c60_codsis
             where c61_instit   = " . db_getsession("DB_instit") . "
               and c61_anousu   =" . db_getsession("DB_anousu") . "
               and c61_codigo   = $o58_codigo
               and c52_descrred = 'F' ";
  $result_conta = db_query($sql);

  if ($result_conta != false && (pg_numrows($result_conta) == 1)) {

    db_fieldsmemory($result_conta, 0);
    $sqlconta     = "select * from conplanoconta where c63_codcon = $c61_codcon and c63_anousu = " . db_getsession("DB_anousu");
    $result_conta = db_query($sqlconta);

    if (pg_result($result_conta, 0) == 1) {

      db_fieldsmemory($result_conta, 0);
      $pdf1->banco            = $c63_banco;
      $pdf1->agencia          = $c63_agencia;
      $pdf1->conta            = $c63_conta;
    }
  }

  $pdf1->emissao          = db_formatar($e60_emiss, 'd');
  $pdf1->texto            = "";

  $pdf1->imprime();
  echo 'tesate1';exit;
}
//include("fpdf151/geraarquivo.php");

if ($oConfiguracaoGed->utilizaGED()) {

  try {

    $sTipoDocumento = GerenciadorEletronicoDocumentoConfiguracao::EMPENHO;

    $oGerenciador = new GerenciadorEletronicoDocumento();
    $oGerenciador->setLocalizacaoOrigem("tmp/");
    $oGerenciador->setNomeArquivo("{$sTipoDocumento}_{$e60_numemp}.pdf");

    $oStdDadosGED        = new stdClass();
    $oStdDadosGED->nome  = $sTipoDocumento;
    $oStdDadosGED->tipo  = "NUMERO";
    $oStdDadosGED->valor = $e60_numemp;
    $pdf1->objpdf->Output("tmp/{$sTipoDocumento}_{$e60_numemp}.pdf");
    $oGerenciador->moverArquivo(array($oStdDadosGED));
  } catch (Exception $eErro) {

    db_redireciona("db_erros.php?fechar=true&db_erro=" . $eErro->getMessage());
  }
} else {
  $pdf1->objpdf->Output();
}
