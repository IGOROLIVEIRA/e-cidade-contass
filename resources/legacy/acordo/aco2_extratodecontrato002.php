<?

//ini_set('display_errors', 'on');

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");

require_once("classes/db_acordo_classe.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/CgmFactory.model.php");

$clacordo            = new cl_acordo;
$clacordoposicao     = new cl_acordoposicao;
$clacordoitem        = new cl_acordoitem;

//consulta dos dados do acordo
$sSql = db_query("select distinct ac16_sequencial, ac16_numero||'/'||ac16_anousu numcontrato,descrdepto,ac16_dataassinatura,z01_nome,ac16_valor,ac16_datainicio,ac16_datafim,ac16_objeto,ac16_vigenciaindeterminada from acordo inner join db_depart on coddepto = ac16_coddepto inner join cgm on z01_numcgm = ac16_contratado inner join acordoposicao on ac26_acordo = ac16_sequencial and ac26_acordoposicaotipo = 1 where ac16_sequencial = {$sequencial}");

if (pg_numrows($sSql) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado.');
}

$oDados = db_utils::fieldsMemory($sSql, 0, true);

$head2 = "Extrato de Contrato";
$oPDF = new PDF('Landscape', 'mm', 'A4');
$oPDF->Open();
$oPDF->AliasNbPages();
$oPDF->setfillcolor(235);

$iAlt = 6;

$oPDF->addpage();

//informações do contrato

$oPDF->setfont('arial', 'b', 12);
$oPDF->cell(180, $iAlt, 'Extrato de Contrato ', 0, 1, "L", 0);
$oPDF->cell(0, $iAlt, ' ', 0, 1, "C", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Nº Contrato: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(50, $iAlt, $oDados->numcontrato, 0, 0, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Departamento: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(50, $iAlt, $oDados->descrdepto, 0, 1, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Data de Assinatura: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(50, $iAlt, $oDados->ac16_dataassinatura, 0, 0, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Contratado: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(50, $iAlt, $oDados->z01_nome, 0, 1, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$tituloVigencia = $oDados->ac16_vigenciaindeterminada == "t" ? "Vigência Inicial: " : "Período de Vigência: ";
$oPDF->cell(30, $iAlt, $tituloVigencia, 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$dataVigencia = $oDados->ac16_vigenciaindeterminada == "t" ? $oDados->ac16_datainicio : $oDados->ac16_datainicio . ' até ' . $oDados->ac16_datafim;
$oPDF->cell(20, $iAlt, $dataVigencia, 0, 1, "L", 0);
//$oPDF->cell(20, $iAlt, $oDados->ac16_datafim, 0, 1, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Valor do Contrato: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->cell(50, $iAlt, 'R$' . db_formatar($oDados->ac16_valor, 'f'), 0, 1, "L", 0);

$oPDF->setfont('arial', 'b', 8);
$oPDF->cell(30, $iAlt, 'Objeto: ', 0, 0, "L", 0);
$oPDF->setfont('arial', '', 8);
$oPDF->MultiCell(220, $iAlt, $oDados->ac16_objeto, 0, "L", 0);
$oPDF->cell(0, $iAlt, ' ', 0, 1, "C", 0);

//consulta itens do contrato
$sSqlItens = db_query("select ac20_ordem,ac20_pcmater,pc01_descrmater,m61_descr,ac20_quantidade,ac20_valorunitario,ac20_valortotal from acordoitem inner join  acordoposicao on ac26_sequencial = ac20_acordoposicao and ac26_acordoposicaotipo = 1 inner join acordo on ac16_sequencial = ac26_acordo inner join pcmater on pc01_codmater = ac20_pcmater inner join matunid ON m61_codmatunid = ac20_matunid where ac16_sequencial = " . $sequencial . " order by ac20_ordem");

//Cabeçalho itens

$oPDF->setfont('arial', 'b', 6);
$oPDF->cell(8, $iAlt, '', 0, 0, "C", 0);
$oPDF->cell(10, $iAlt, 'Ordem ', 1, 0, "C", 1);
$oPDF->cell(12, $iAlt, 'Item ', 1, 0, "C", 1);
$oPDF->cell(180, $iAlt, 'Descrição', 1, 0, "C", 1);
$oPDF->cell(12, $iAlt, 'Unidade', 1, 0, "C", 1);
$oPDF->cell(14, $iAlt, 'Quantidade', 1, 0, "C", 1);
$oPDF->cell(18, $iAlt, 'Valor Unitário', 1, 0, "C", 1);
$oPDF->cell(18, $iAlt, 'Valor Total', 1, 1, "C", 1);

for ($i = 0; $i < pg_numrows($sSqlItens); $i++) {

    $oDadosItens = db_utils::fieldsMemory($sSqlItens, $i);

    //Itens
    $oPDF->setfont('arial', '', 6);
    $oPDF->cell(8, $iAlt, '', 0, 0, "C", 0);
    $oPDF->cell(10, $iAlt, $oDadosItens->ac20_ordem, 1, 0, "C", 2);
    $oPDF->cell(12, $iAlt, $oDadosItens->ac20_pcmater, 1, 0, "C", 2);
    $oPDF->cell(180, $iAlt, $oDadosItens->pc01_descrmater, 1, 0, "L", 2);
    $oPDF->cell(12, $iAlt, $oDadosItens->m61_descr, 1, 0, "C", 2);
    $oPDF->cell(14, $iAlt, $oDadosItens->ac20_quantidade, 1, 0, "C", 2);
    $oPDF->cell(18, $iAlt, 'R$ ' . db_formatar($oDadosItens->ac20_valorunitario, 'f'), 1, 0, "C", 2);
    $oPDF->cell(18, $iAlt, 'R$ ' . db_formatar($oDadosItens->ac20_valortotal, 'f'), 1, 1, "C", 2);
}

$oPDF->Output();
