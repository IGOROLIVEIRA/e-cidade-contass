<?php
require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_db_sysarqcamp_classe.php");
require_once("classes/db_matunid_classe.php");
require_once("classes/db_empautitem_classe.php");

$oJson                = new services_json();
$oParam               = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oDaoSysArqCamp    = new cl_db_sysarqcamp();
$clmatunid         = new cl_matunid;
$clempautitem      = new cl_empautitem;


switch ($_POST["action"]) {

  case 'buscaItens':

    $autori = $_POST["autori"];
    $cgm    = $_POST["cgm"];
    $tabela = $_POST["tabela"];
    $codele = $_POST["codele"];

    $iAnoSessao         = db_getsession('DB_anousu');

    $result_unidade = array();
    $result_sql_unid = $clmatunid->sql_record($clmatunid->sql_query_file(null, "m61_codmatunid,substr(m61_descr,1,20) as m61_descr,m61_usaquant,m61_usadec", "m61_descr"));
    $numrows_unid = $clmatunid->numrows;
    for ($i = 0; $i < $numrows_unid; $i++) {
      db_fieldsmemory($result_sql_unid, $i);
      $result_unidade[$m61_codmatunid] = $m61_descr;
    }

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
       AND orcelemento.o56_anousu = $iAnoSessao
       WHERE l20_codigo =
           (SELECT e54_codlicitacao
            FROM empautoriza
            WHERE e54_autori = $autori)
         AND pc24_pontuacao=1";
    $sqlQueryTotal = $sqlQuery;
    if (!empty($_POST["tabela"])) {
      $sqlQuery .= " and  pc94_sequencial = $tabela";
    }
    if (!empty($_POST["codele"])) {
      $sqlQuery .= " and  pc07_codele = $codele";
    } else {
      $sqlQuery .= "AND pc07_codele=1";
    }
    $sqlQuery .= "UNION SELECT distinct pcmater.pc01_codmater,
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
       AND orcelemento.o56_anousu = $iAnoSessao
       WHERE l20_codigo =
           (SELECT e54_codlicitacao
            FROM empautoriza
            WHERE e54_autori = $autori)";
    $sqlTotal = $sqlQueryTotal;
    if (!empty($_POST["tabela"])) {
      $sqlQuery .= " and  pc94_sequencial = $tabela";
    }
    if (!empty($_POST["codele"])) {
      $sqlQuery .= " and  pc07_codele = $codele";
    } else {
      $sqlQuery .= "AND pc07_codele=1";
    }
    $sqlQuery .= "
         AND (pcmater.pc01_tabela = 't'
              OR pcmater.pc01_taxa = 't')
         AND pcmater.pc01_codmater NOT IN
           (SELECT pc94_codmater
            FROM pctabela) ) fornecedores
    WHERE fornecedores.z01_numcgm = $cgm
    ";

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
        $resultEmpAutItem = $clempautitem->sql_record($clempautitem->sql_query_file($autori, null, "*", "e55_sequen", "e55_item = $oDados->pc01_codmater"));
        $oDadosEmpAutItem = db_utils::fieldsMemory($resultEmpAutItem, $i);

        $itemRows  = array();

        $selectunid = "";
        $selectunid = "<select id='unidade_{$oDados->pc01_codmater}'>";
        $selectunid .= "<option selected='selected'>..</option>";
        foreach ($result_unidade as $key => $item) {
          if ($key == $oDadosEmpAutItem->e55_unid)
            $selectunid .= "<option value='$key' selected='selected'>$item</option>";
          else
            $selectunid .= "<option value='$key'>$item</option>";
        }
        $selectunid .= "</select>";

        $itemRows[] = "<input type='checkbox' id='checkbox_{$oDados->pc01_codmater}' name='checkbox_{$oDados->pc01_codmater}' onclick='consultaValores(this)'>";
        $itemRows[] = $oDados->pc01_codmater;
        $itemRows[] = $oDados->pc01_descrmater;
        $itemRows[] = $selectunid;
        $itemRows[] = "<input type='text' id='marca_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_marca}' />";
        $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_quant}' onkeyup='js_calcula(this)' />";
        $itemRows[] = "<input type='text' id='vlrunit_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vlrun}' onkeyup='js_calcula(this)' />";
        $itemRows[] = "<input type='text' id='desc_{$oDados->pc01_codmater}' value='$oDados->desconto' onkeyup='js_calcula(this)' />";
        $itemRows[] = "<input type='text' id='total_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vltot}' />";
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

  case 'salvar':

    db_inicio_transacao();

    foreach ($_POST['dados'] as $item) :

      $result_itens = $clempautitem->sql_record($clempautitem->sql_query(null, null, "e55_item,pc01_descrmater,e55_descr,e55_codele,o56_descr,e55_sequen,e55_quant,e55_vltot", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . ""));
      // echo $clempautitem->sql_query(null, null, "e55_item,pc01_descrmater,e55_descr,e55_codele,o56_descr,e55_sequen,e55_quant,e55_vltot", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . "");
      // exit;
      if ($clempautitem->numrows == 0) {
        $clempautitem->e55_descr  = $_POST['descr'];
        $clempautitem->e55_codele = $_POST['codele'];
        $clempautitem->e55_item   = $item['id'];
        $clempautitem->e55_quant  = $item['qtd'];
        $clempautitem->e55_unid   = $item['unidade'];
        $clempautitem->e55_marca  = $item['marca'];
        $clempautitem->e55_vlrun  = $item['vlrunit'];
        $clempautitem->e55_vltot  = $item['total'];

        $clempautitem->incluir($_POST['autori'], 1);
      } else {
        $clempautitem->e55_descr  = $_POST['descr'];
        $clempautitem->e55_codele = $_POST['codele'];
        $clempautitem->e55_item   = $item['id'];
        $clempautitem->e55_quant  = $item['qtd'];
        $clempautitem->e55_unid   = $item['unidade'];
        $clempautitem->e55_marca  = $item['marca'];
        $clempautitem->e55_vlrun  = $item['vlrunit'];
        $clempautitem->e55_vltot  = $item['total'];
        $clempautitem->alterar($_POST['autori'], $_POST['sequen']);
      }
    endforeach;
    db_fim_transacao();

    if ($clempautitem->erro_status == 0) {

      $oRetorno          = new stdClass();
      $oRetorno->status  = 1;
      $oRetorno->message = $clempautitem->erro_msg;
      break;
    }

  case "verificaSaldoCriterio":

    try {

      $sql = "
                                SELECT * FROM (
                                  SELECT DISTINCT pcmater.pc01_codmater,
                                                  pcmater.pc01_descrmater,
                                                  pc07_codele,
                                                  pcmater.pc01_servico,
                                                  pc23_orcamforne,
                                                  z01_numcgm,
                                                  pc23_quant,
                                                  pc23_vlrun,
                                                  pc23_valor,
                                                  pc80_criterioadjudicacao,
                                                  pcmater.pc01_servico,
                                                  'itemtabela' as tipoitem,
                                                  pctabela.pc94_sequencial
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
                                              AND orcelemento.o56_anousu = " . db_getsession('DB_anousu') . "
                                  WHERE l20_codigo =
                                          (SELECT e54_codlicitacao
                                          FROM empautoriza
                                          WHERE e54_autori = {$_POST['e55_autori']}
                                          and pcmater.pc01_codmater = {$_POST['e55_item']})
                                      AND pc24_pontuacao=1

                                  UNION

                                  SELECT DISTINCT pcmater.pc01_codmater,
                                          pcmater.pc01_descrmater,
                                          pc07_codele,
                                          pcmater.pc01_servico,
                                          pc23_orcamforne,
                                          z01_numcgm,
                                          pc23_quant,
                                          pc23_vlrun,
                                          pc23_valor,
                                          pc80_criterioadjudicacao,
                                          pcmater.pc01_servico,
                                          'naoitem' as tipoitem,
                                          0 as pc94_sequencial
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
                                LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pcmater.pc01_codmater
                                LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
                                AND orcelemento.o56_anousu = " . db_getsession('DB_anousu') . "
                                WHERE l20_codigo =
                                        (SELECT e54_codlicitacao
                                          FROM empautoriza
                                          WHERE e54_autori = {$_POST['e55_autori']}
                                          and pcmater.pc01_codmater = {$_POST['e55_item']})
                                    AND pc24_pontuacao=1
                                    AND (pcmater.pc01_tabela = 't' OR pcmater.pc01_taxa = 't')
                                    AND pcmater.pc01_codmater NOT IN (select pc94_codmater from pctabela)
                                ) fornecedores
                                WHERE fornecedores.z01_numcgm = {$_POST['cgm']}
                                ORDER BY fornecedores.pc01_codmater
                            ";

      $result = db_query($sql);
      db_fieldsmemory($result, 0);
      $oRetorno->itens   = verificaSaldoCriterio($_POST['e55_autori'], $_POST['e55_item'], $tipoitem, $pc94_sequencial);
      $oRetorno->itensqt = verificaSaldoCriterioItemQuantidade($_POST['e55_autori'], $_POST['e55_item']);
    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

    break;
}

function verificaSaldoCriterio($e55_autori, $e55_item, $tipoitem, $pc94_sequencial)
{
  $sSQL = "";
  if (strcasecmp($tipoitem, 'item') === 0) {
    $sSQL = "
     select sum(e55_vltot) as totalitens
      from empautitem
       inner join empautoriza on e54_autori = e55_autori
        where e54_codlicitacao = ( select e54_codlicitacao from empautoriza where e54_autori = {$e55_autori} )
         and e55_item = {$e55_item}
    ";
  } else {

    $sSQL = "
      select sum(e55_vltot) as totalitens
      from empautitem
       inner join empautoriza on e54_autori = e55_autori
       inner join pctabelaitem on pctabelaitem.pc95_codmater = empautitem.e55_item
       inner join pctabela on pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela
        where e54_codlicitacao = (
                                  select e54_codlicitacao
                                   from empautoriza
                                    where e54_autori = {$e55_autori}
                                  )
                                  and pc94_sequencial = {$pc94_sequencial}
    ";
  }
  $rsConsulta = db_query($sSQL);
  $oItens = db_utils::getCollectionByRecord($rsConsulta);
  return $oItens;
}

function verificaSaldoCriterioItemQuantidade($e55_autori, $e55_item)
{

  $sSQL = "
   select sum(e55_quant) as totalitensqt
    from empautitem
     inner join empautoriza on e54_autori = e55_autori
      where e54_codlicitacao = ( select e54_codlicitacao from empautoriza where e54_autori = {$e55_autori} )
       and e55_item = {$e55_item}
  ";

  $rsConsulta = db_query($sSQL);
  $oItens = db_utils::getCollectionByRecord($rsConsulta);
  return $oItens;
}

echo $oJson->encode($oRetorno);
