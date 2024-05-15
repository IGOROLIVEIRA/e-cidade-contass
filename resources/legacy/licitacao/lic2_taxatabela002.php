<?

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("model/licitacao.model.php");
require_once("classes/db_habilitacaoforn_classe.php");

$clliclicita = new cl_liclicita;
$clempautoriza = new cl_empautoriza;

if ($l20_codigo != "") {

    $sWhere .= $sAnd . " l20_codigo=$l20_codigo ";
    $sAnd = " and ";
    $info1 = "Código: " . $l20_codigo;
} else {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhuma licitação informada.');
    exit;
}

$sCampos = " distinct l20_codigo,l20_edital,l20_numero,l20_anousu,l20_objeto,l03_descr";
$sWhere .= $sAnd . " l20_instit = " . db_getsession("DB_instit");

$sSqlLicLicita = $clliclicita->sql_query(null, $sCampos, null, $sWhere);
$result = $clliclicita->sql_record($sSqlLicLicita);
$numrows = $clliclicita->numrows;

if ($numrows == 0) {

    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
    exit;
}

$head3 = @$info;
$head2 = "Execução Taxa/Tabela";
$head4 = @$info1;
$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca       = 0;
$alt         = 4;
$total       = 0;
$p           = 0;
$valortot    = 0;
$muda        = 0;



for ($i = 0; $i < $numrows; $i++) {

    db_fieldsmemory($result, $i);

    $pdf->addpage();

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(190, $alt, "", 0, 1, "L", 0);
    $pdf->cell(30, $alt, 'Processo Licitatório :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $l20_codigo, 0, 0, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Modalidade :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $l03_descr, 0, 1, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Número :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, $alt, $l20_edital . '/' . $l20_anousu, 0, 1, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Objeto :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->multicell(220, $alt, $l20_objeto, 0, "L", 0);

    $sSqlTab = "select distinct
            pctabela.pc94_sequencial,
            pcorcamjulg.pc24_orcamforne,
            pcorcamforne.pc21_numcgm,
            cgm.z01_numcgm,
            cgm.z01_nome
            from liclicita
            left join liclicitem on liclicita.l20_codigo = liclicitem.l21_codliclicita
            left join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
            left join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc
            left join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem
            left join solicita on solicita.pc10_numero = solicitem.pc11_numero
            left join db_depart on db_depart.coddepto = solicita.pc10_depto
            left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom
            left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom
            left join pcorcamitemlic on l21_codigo = pc26_liclicitem
            left join pcorcamval on pc26_orcamitem = pc23_orcamitem
            left join pcorcamforne on pc21_orcamforne = pc23_orcamforne
            inner join cgm on z01_numcgm = pcorcamforne.pc21_numcgm
            left join pcorcamjulg on pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem and pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
            left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
            left join pcmater itemtabela on itemtabela.pc01_codmater = solicitempcmater.pc16_codmater
            inner join pctabela on pctabela.pc94_codmater = itemtabela.pc01_codmater
            left join pcmater on pcmater.pc01_codmater = pctabela.pc94_codmater
            where l20_codigo = {$l20_codigo}
            and pc24_pontuacao = 1
            order by z01_nome,pc94_sequencial";
    $result_tab = $clliclicita->sql_record($sSqlTab);
    $numrowsTab = $clliclicita->numrows;

    for ($n = 0; $n < $numrowsTab; $n++) {

        $oItemTab = db_utils::fieldsMemory($result_tab, $n);


        $sSql = "select distinct
        pcmater.pc01_codmater,
        pcmater.pc01_descrmater,
        pc23_valor as estimado,
        (select sum(e55_vltot) as totalitens
        from empautitem
        inner join empautoriza on e54_autori = e55_autori
        left join empempaut on e61_autori = e54_autori
        left join empempenho on e60_numemp = e61_numemp
        inner join empempitem on e62_numemp = e60_numemp
        and e62_item = e55_item
        left join empanulado on e94_numemp = e60_numemp
        left join empanuladoitem on e37_empempitem = e62_sequencial
        inner join pctabelaitem on pctabelaitem.pc95_codmater = empautitem.e55_item
        inner join pctabela on pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela
        where e54_codlicitacao = {$l20_codigo}
        and pc95_codtabela = "  . $oItemTab->pc94_sequencial . "
        and e54_numcgm = " . $oItemTab->pc21_numcgm . "
        and e54_anulad is null
        and e37_sequencial is null) as utilizado,
        pcorcamforne.pc21_numcgm,
        cgm.z01_nome,
        cgm.z01_numcgm
        from liclicita
        left join liclicitem on liclicita.l20_codigo = liclicitem.l21_codliclicita
        left join pcprocitem on liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
        left join pcproc on pcproc.pc80_codproc = pcprocitem.pc81_codproc
        left join solicitem on solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        left join solicita on solicita.pc10_numero = solicitem.pc11_numero
        left join db_depart on db_depart.coddepto = solicita.pc10_depto
        left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom
        left join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom
        left join pcorcamitemlic on l21_codigo = pc26_liclicitem
        left join pcorcamval on pc26_orcamitem = pc23_orcamitem
        left join pcorcamforne on pc21_orcamforne = pc23_orcamforne
        left join pcorcamjulg on pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem and pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
        inner join cgm on z01_numcgm = pcorcamforne.pc21_numcgm
        left join solicitempcmater on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        left join pcmater itemtabela on itemtabela.pc01_codmater = solicitempcmater.pc16_codmater
        inner join pctabela on pctabela.pc94_codmater = itemtabela.pc01_codmater
        left join pcmater on pcmater.pc01_codmater = pctabela.pc94_codmater
        where l20_codigo = {$l20_codigo}
        and pc24_pontuacao = 1
        and pc94_sequencial = " . $oItemTab->pc94_sequencial . "
        and l20_instit = " . db_getsession("DB_instit") . "
        order by z01_nome";

        $result_itens = $clliclicita->sql_record($sSql);
        $numrowsItens = $clliclicita->numrows;

        for ($i = 0; $i < $numrowsItens; $i++) {

            $oItem = db_utils::fieldsMemory($result_itens, $i);

            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(190, $alt, "", 0, 1, "L", 0);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(215, $alt, 'Fornecedor: ' . $oItemTab->z01_nome, 1, 1, "L", 1);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(20, $alt, 'Codigo Item', 1, 0, "C", 1);
            $pdf->cell(120, $alt, 'Descrição', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'Estimado', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'Utilizado', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'Disponível', 1, 1, "C", 1);

            $pdf->setfont('arial', '', 7);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(20, $alt, $oItem->pc01_codmater, 1, 0, "C", 2);
            $pdf->cell(120, $alt, $oItem->pc01_descrmater, 1, 0, "C", 2);
            $pdf->cell(25, $alt, 'R$' . db_formatar($oItem->estimado, 'f'), 1, 0, "C", 2);
            $pdf->cell(25, $alt, 'R$' . db_formatar($oItem->utilizado, 'f'), 1, 0, "C", 2);
            $pdf->cell(25, $alt, 'R$' . db_formatar($oItem->estimado - $oItem->utilizado, 'f'), 1, 1, "C", 2);
        }

        if ($listAutoriza == 't') {

            $sSqlAut = "select distinct empautoriza.e54_autori,
            empautoriza.e54_numcgm,
            cgm.z01_nome,
            empautoriza.e54_valor
            from empautoriza
            inner join cgm on cgm.z01_numcgm = empautoriza.e54_numcgm
            inner join empautitem on empautitem.e55_autori = empautoriza.e54_autori
            inner join pctabelaitem on pctabelaitem.pc95_codmater = empautitem.e55_item
            inner join pctabela on pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela
            where e54_codlicitacao = {$l20_codigo}
            and pc95_codtabela = " . $oItemTab->pc94_sequencial . "
            and e54_desconto is not null
            and e54_anulad is null
            and e54_numcgm = " . $oItem->pc21_numcgm;
            $result_aut = $clempautoriza->sql_record($sSqlAut);
            $numrowsAut = $clempautoriza->numrows;

            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(165, $alt, 'Autorizações', 1, 1, "C", 1);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(20, $alt, 'Autorização', 1, 0, "C", 1);
            $pdf->cell(120, $alt, 'Fornecedor', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'Valor', 1, 1, "C", 1);

            for ($a = 0; $a < $numrowsAut; $a++) {

                $oItemAut = db_utils::fieldsMemory($result_aut, $a);

                $pdf->setfont('arial', '', 7);
                $pdf->cell(30, $alt, "", 0, 0, "L", 0);
                $pdf->cell(20, $alt, $oItemAut->e54_autori, 1, 0, "C", 2);
                $pdf->cell(120, $alt, $oItemAut->z01_nome, 1, 0, "C", 2);
                $pdf->cell(25, $alt, 'R$' . db_formatar($oItemAut->e54_valor, 'f'), 1, 1, "C", 2);

                $total += $oItemAut->e54_valor;
            }

            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(30, $alt, "", 0, 0, "L", 0);
            $pdf->cell(165, $alt, 'Valor Total das Autorizações: R$ ' . db_formatar($total, 'f'), 1, 1, 'R', 1);
            $total = 0;
        }
    }
}

$pdf->Output();
