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

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_db_config_classe.php");
require_once("classes/db_credenciamentotermo_classe.php");
require_once("libs/db_libdocumento.php");

$clliclicita            = new cl_liclicita;
$clrotulo               = new rotulocampo;
$cldbconfig             = new cl_db_config;
$clcredenciamentotermo  = new cl_credenciamentotermo();
$clrotulo->label('');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

$oPDF = new PDF();
$oPDF->Open();
$oPDF->AliasNbPages();
$oPDF->setfillcolor(235);
$oPDF->setfont('arial', 'b', 8);
$oPDF->setfillcolor(235);
$troca    = 1;
$alt      = 4;
$total    = 0;
$p        = 0;
$valortot = 0;
$cor      = 0;
$dbinstit = db_getsession("DB_instit");

$oLibDocumento = new libdocumento(9005, null);

if ($oLibDocumento->lErro) {
    die($oLibDocumento->sMsgErro);
}
$result = $clcredenciamentotermo->sql_record($clcredenciamentotermo->sql_query($l212_sequencial));

if ($clcredenciamentotermo->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
    exit;
}
db_fieldsmemory($result, 0);

$head3 = "TERMO DE CREDENCIAMENTO: Nº " . $l212_numerotermo . "/" . $l212_anousu;
$head4 = "PROCESSO: " . $l20_edital . "/" . substr($l20_anousu, 0, 4);
$head5 = "MODALIDADE:" . trim($pc50_descr);
$dtInicio   = implode("/", array_reverse(explode("-", $l212_dtinicio)));
$dtFim      = implode("/", array_reverse(explode("-", $l212_dtfim)));
$oPDF->addpage('L');
$oPDF->setfont('arial', 'b', 14);
$oPDF->ln();
$oPDF->cell(0, 5, "TERMO DE CREDENCIAMENTO", 0, 1, "C", 0);
$oPDF->ln(15);
$oPDF->setfont('arial', 'b', 10);
$oPDF->cell(23, 5, "Fornecedor :", 0, 0, "L", 0);
$oPDF->setfont('arial', '', 10);
$oPDF->cell(0, 5, $z01_nome, 0, 1, "L", 0);
$oPDF->setfont('arial', 'b', 10);
$oPDF->cell(23, 5, "Nº do Termo:", 0, 0, "L", 0);
$oPDF->setfont('arial', '', 10);
$oPDF->cell(0, 5, $l212_numerotermo . "/" . $l212_anousu, 0, 1, "L", 0);
$oPDF->setfont('arial', 'b', 10);
$oPDF->cell(23, 5, "Vigência:", 0, 0, "L", 0);
$oPDF->setfont('arial', '', 10);
$oPDF->cell(0, 5, $dtInicio . " a " . $dtFim, 0, 1, "L", 0);
$oPDF->setfont('arial', 'b', 10);
$oPDF->cell(23, 5, "Objeto:", 0, 0, "L", 0);
$oPDF->setfont('arial', '', 10);
$oPDF->cell(0, 5, $l20_objeto, 0, 1, "L", 0);
$oPDF->cell(0, 5, "__________________________________________________________________________________________________________________________", 0, 1, "C", 0);
$oPDF->setfont('arial', 'b', 14);
$oPDF->ln(5);
$oPDF->cell(0, 5, "ITENS CREDENCIADOS", 0, 1, "C", 0);
$oPDF->ln(5);
$result_itenscredenciados = $clcredenciamentotermo->sql_record($clcredenciamentotermo->sql_query_itensprecomedio(null, 'pc01_codmater,pc11_seq,pc01_descrmater,m61_descr,si02_vlprecoreferencia,l205_datacred,pc11_quant', null, "l212_sequencial = $l212_sequencial"));
$numrows_itenscredenciamento = $clcredenciamentotermo->numrows;
$oPDF->setfont('arial', 'b', 10);
$oPDF->cell(35, 5, "Código do Material",    1, 0, "C", 0);
$oPDF->cell(20, 5, "Sequencial",            1, 0, "C", 0);
$oPDF->cell(120, 5, "Material",             1, 0, "C", 0);
$oPDF->cell(35, 5, "Unidade de Medida",     1, 0, "C", 0);
$oPDF->cell(20, 5, "Valor Total",        1, 0, "C", 0);
$oPDF->cell(40, 5, "Data Credenciamento",   1, 1, "C", 0);
$oPDF->setfont('arial', '', 8);
for ($x = 0; $x < $numrows_itenscredenciamento; $x++) {
    db_fieldsmemory($result_itenscredenciados, $x);
    $totalItem = $pc11_quant * $si02_vlprecoreferencia;
    $oPDF->cell(35, 5, $pc01_codmater,                              1, 0, "C", 0);
    $oPDF->cell(20, 5, $pc11_seq,                                   1, 0, "C", 0);
    $oPDF->setfont('arial', '', 6);
    $oPDF->cell(120, 5, $pc01_descrmater,                           1, 0, "C", 0);
    $oPDF->setfont('arial', '', 8);
    $oPDF->cell(35, 5, $m61_descr,                                  1, 0, "C", 0);
    $oPDF->cell(20, 5, db_formatar($totalItem, "f"),   1, 0, "C", 1);
    $oPDF->cell(40, 5, implode("/", array_reverse(explode("-", $l205_datacred))), 1, 1, "C", 1);

    $totalRel += $totalItem;
}
$oPDF->setfont('arial', 'b', 11);
$oPDF->cell(240, 5, "Total dos itens:",             0, 0, "R", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(30, 5, db_formatar($totalRel, "f"),         0, 1, "C", 1);

$sSqlDbConfig = $cldbconfig->sql_query(null, "*", null, "codigo = {$dbinstit}");
$result_munic = $cldbconfig->sql_record($sSqlDbConfig);
db_fieldsmemory($result_munic, 0);

$oPDF->Output();
