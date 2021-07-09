<?php
require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_db_sysarqcamp_classe.php");

$oJson             = new services_json();
$oDaoSysArqCamp    = new cl_db_sysarqcamp();

switch ($_POST["action"]) {

  case 'BuscaItens':

    $autori = $_POST["autori"];
    $cgm    = $_POST["cgm"];

    $sqlQuery = "SELECT *
    FROM
      (SELECT distinct pcmater.pc01_codmater,
                        pcmater.pc01_descrmater,
                        z01_numcgm,
                        matunid.m61_codmatunid,
                       case
                          when pc23_percentualdesconto is null then pc23_perctaxadesctabela
                          else pc23_percentualdesconto
                          end as desconto
       FROM liclicitem
       LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
       LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
       LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
       LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
       LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
       LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
       LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
       LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
       LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
       LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
       LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
       LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
       LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
       LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
       LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
       AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
       LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
       LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
       LEFT JOIN pcmater itemtabela ON itemtabela.pc01_codmater = solicitempcmater.pc16_codmater
       LEFT JOIN pctabela ON pctabela.pc94_codmater = itemtabela.pc01_codmater
       LEFT JOIN pctabelaitem ON pctabelaitem.pc95_codtabela = pctabela.pc94_sequencial
       LEFT JOIN pcmater ON pcmater.pc01_codmater = pctabelaitem.pc95_codmater
       LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pctabelaitem.pc95_codmater
       INNER JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
       AND orcelemento.o56_anousu = 2021
       WHERE l20_codigo =
           (SELECT e54_codlicitacao
            FROM empautoriza
            WHERE e54_autori = $autori)
         AND pc24_pontuacao=1
       UNION SELECT distinct pcmater.pc01_codmater,
                        pcmater.pc01_descrmater,
                        z01_numcgm,
                        matunid.m61_codmatunid,
                       case
                          when pc23_percentualdesconto is null then pc23_perctaxadesctabela
                          else pc23_percentualdesconto
                          end as desconto
       FROM liclicitem
       LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
       LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
       LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
       LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
       LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
       LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
       LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
       LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
       LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
       LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
       LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
       LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
       LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
       LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
       LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
       AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
       LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
       LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
       LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
       LEFT JOIN pctabela ON pctabela.pc94_codmater = pcmater.pc01_codmater
       LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pcmater.pc01_codmater
       LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
       AND orcelemento.o56_anousu = 2021
       WHERE l20_codigo =
           (SELECT e54_codlicitacao
            FROM empautoriza
            WHERE e54_autori = $autori)
         AND pc24_pontuacao=1
         AND (pcmater.pc01_tabela = 't'
              OR pcmater.pc01_taxa = 't')
         AND pcmater.pc01_codmater NOT IN
           (SELECT pc94_codmater
            FROM pctabela) ) fornecedores
    WHERE fornecedores.z01_numcgm = $cgm
    ";
    // echo $sqlQuery;
    // exit;
    $sqlTotal = $sqlQuery;
    if (!empty($_POST["search"]["value"])) {
      // $sqlQuery .= ' and (id LIKE "%' . $_POST["search"]["value"] . '%" ';
      // $sqlQuery .= ' OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
      // $sqlQuery .= ' OR designation LIKE "%' . $_POST["search"]["value"] . '%" ';
      // $sqlQuery .= ' OR address LIKE "%' . $_POST["search"]["value"] . '%" ';
      // $sqlQuery .= ' OR skills LIKE "%' . $_POST["search"]["value"] . '%") ';
    }
    // if (!empty($_POST["order"])) {
    //   $sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
    // } else {
    //   $sqlQuery .= 'ORDER BY id DESC ';
    // }
    if ($_POST["length"] != -1) {
      $sqlQuery .= 'LIMIT ' . $_POST['length'];
    }
    $rsDadosTotal = $oDaoSysArqCamp->sql_record($sqlTotal);
    $rsDados      = $oDaoSysArqCamp->sql_record($sqlQuery);

    if ($oDaoSysArqCamp->numrows > 0) {
      $employeeData = array();
      for ($i = 0; $i < pg_numrows($rsDados); $i++) {

        $oDados = db_utils::fieldsMemory($rsDados, $i);

        $itemRows  = array();

        $itemRows[] = "<input type='checkbox' id='checkbox_{$oDados->pc01_codmater}' name='checkbox_{$oDados->pc01_codmater}' onclick='js_verificaItem(this.id)'>";
        $itemRows[] = $oDados->pc01_codmater;
        $itemRows[] = $oDados->pc01_descrmater;
        $itemRows[] = "<select name='descauto' id='descauto'><option value='f'>Não</option><option value='t'>Sim</option></select>";
        $itemRows[] = $oDados->pc01_codmater;
        $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='' />";
        $itemRows[] = "<input type='text' id='vlrunit_{$oDados->pc01_codmater}' />"; //p/ usuário
        $itemRows[] = "<input type='text' id='desc_{$oDados->pc01_codmater}' value='$oDados->desconto' />";
        $itemRows[] = "<input type='text' id='desc_{$oDados->pc01_codmater}' />";
        $employeeData[] = $itemRows;
      }

      $oRetorno = array(
        "draw"  =>  intval($_POST["draw"]),
        "iTotalRecords"  =>   pg_numrows($rsDados),
        "iTotalDisplayRecords"  =>  pg_numrows($rsDadosTotal),
        "data"  =>   $employeeData
      );
    }
    break;
}
echo $oJson->encode($oRetorno);
