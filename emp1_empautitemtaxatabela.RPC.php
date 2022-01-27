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

        $sqlElementosTabela = "select distinct pc07_codele,o56_descr,o56_elemento from pctabela 
        inner join pctabelaitem on pc95_codtabela = pc94_sequencial
        inner join pcmaterele on pc07_codmater = pc95_codmater
        LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
        AND orcelemento.o56_anousu = $iAnoSessao
        where pc94_sequencial = $tabela";
       

        $rsEleTabela = db_query($sqlElementosTabela);
        
        $oElementos = db_utils::getCollectionByRecord($rsEleTabela);
        if(pg_numrows($rsEleTabela)>0){
            foreach($oElementos as $row){
                if($row->pc07_codele==$codele){
                    
                   $elementonum = $row->o56_elemento;
                }
            }
        }

        $result_unidade = array();
        $result_sql_unid = $clmatunid->sql_record($clmatunid->sql_query_file(null, "m61_codmatunid,substr(m61_descr,1,20) as m61_descr,m61_usaquant,m61_usadec", "m61_descr"));
        $numrows_unid = $clmatunid->numrows;
        for ($i = 0; $i < $numrows_unid; $i++) {
            db_fieldsmemory($result_sql_unid, $i);
            $result_unidade[$m61_codmatunid] = $m61_descr;
        }

        $sqlQueryTotal = "SELECT distinct pcmater.pc01_codmater,
    pcmater.pc01_descrmater,
    z01_numcgm,
    matunid.m61_codmatunid,
   case
   when pc23_perctaxadesctabela is null then pc23_percentualdesconto
      else pc23_perctaxadesctabela
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
      WHERE e54_autori = $autori)";

        if (!empty($_POST["tabela"])) {
            $sqlQueryTotal .= " and  pc94_sequencial = $tabela";
        }
        if ($_POST["codele"] != '...') {
            $sqlQueryTotal .= " and  pc07_codele = $codele";
        }

        $sqlQuery = "SELECT *
    FROM
      (SELECT distinct pcmater.pc01_codmater,
                        pcmater.pc01_descrmater,
                        z01_numcgm,
                        matunid.m61_codmatunid,
                       case
                       when pc23_perctaxadesctabela is null then pc23_percentualdesconto
      else pc23_perctaxadesctabela
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

        if (!empty($_POST["tabela"])) {
            $sqlQuery .= " and  pc94_sequencial = $tabela";
        }
        //if ($_POST["codele"] != '...') {
        $sqlQuery .= " and  pc07_codele = $codele";
        //}
        if (!empty($_POST["search"]["value"])) {
            $sqlQuery .= " and (pcmater.pc01_descrmater ILIKE '%" . $_POST["search"]["value"] . "%') ";
        }
        $sqlQuery .= "UNION SELECT distinct pcmater.pc01_codmater,
                        pcmater.pc01_descrmater,
                        z01_numcgm,
                        matunid.m61_codmatunid,
                       case
                       when pc23_perctaxadesctabela is null then pc23_percentualdesconto
                       else pc23_perctaxadesctabela
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

        if (!empty($_POST["tabela"])) {
            $sqlQuery .= " and  pc94_sequencial = $tabela";
        }
        //if ($_POST["codele"] != '...') {
        $sqlQuery .= " and  pc07_codele = $codele";
        //}
        if (!empty($_POST["search"]["value"])) {
            $sqlQuery .= " and (pcmater.pc01_descrmater ILIKE '%" . $_POST["search"]["value"] . "%') ";
        }
        $sqlQuery .= "
         AND (pcmater.pc01_tabela = 't'
              OR pcmater.pc01_taxa = 't')
         AND pcmater.pc01_codmater NOT IN
           (SELECT pc94_codmater
            FROM pctabela) ) fornecedores
    WHERE fornecedores.z01_numcgm = $cgm
    ";

        if ($_POST["length"] != -1) {
            $sqlQuery .= 'LIMIT ' . $_POST['length'];
        }

        $rsDadosTotal = $oDaoSysArqCamp->sql_record($sqlQueryTotal);
        $rsDados      = $oDaoSysArqCamp->sql_record($sqlQuery);

        if ($oDaoSysArqCamp->numrows > 0) {
            $employeeData = array();
            for ($i = 0; $i < pg_numrows($rsDados); $i++) {

                $oDados = db_utils::fieldsMemory($rsDados, $i);
                $resultEmpAutItem = $clempautitem->sql_record($clempautitem->sql_query_file($autori, null, "*", "e55_sequen", " e55_autori = $autori and e55_item = $oDados->pc01_codmater"));
                $oDadosEmpAutItem = db_utils::fieldsMemory($resultEmpAutItem, 0);

                $itemRows  = array();

                

                $selectunid = "";
                $selectunid = "<select id='unidade_{$oDados->pc01_codmater}'>";
                $selectunid .= "<option selected='selected'></option>";
                foreach ($result_unidade as $key => $item) {
                    if ($key == $oDadosEmpAutItem->e55_unid)
                        $selectunid .= "<option value='$key' selected='selected'>$item</option>";
                    else
                        $selectunid .= "<option value='$key'>$item</option>";
                }
                $selectunid .= "</select>";

                $selectservico = "";
                if($oDadosEmpAutItem->e55_vlrun != "") {
                    $selectservico = "<select id='servico_{$oDados->pc01_codmater}' disabled onchange='js_servico(this)' >";
                }else{
                    $selectservico = "<select id='servico_{$oDados->pc01_codmater}' onchange='js_servico(this)' >";
                }

                if ($oDadosEmpAutItem->e55_servicoquantidade == 't') {
                    $selectservico .= "<option value='1' selected='selected'>Sim</option>";
                    $selectservico .= "<option value='0'>" . utf8_encode('Não') . "</option>";
                } else {
                    $selectservico .= "<option value='1'>Sim</option>";
                    $selectservico .= "<option value='0' selected='selected'>" . utf8_encode('Não') . "</option>";
                }
                $selectservico .= "</select>";

                if ($oDados->pc01_codmater == $oDadosEmpAutItem->e55_item)
                    $itemRows[] = "<input type='checkbox' checked id='checkbox_{$oDados->pc01_codmater}' name='checkbox_{$oDados->pc01_codmater}' onclick='consultaLancar()'>";
                else
                    $itemRows[] = "<input type='checkbox' id='checkbox_{$oDados->pc01_codmater}' name='checkbox_{$oDados->pc01_codmater}' onclick='consultaLancar()'>";

                $itemRows[] = $oDados->pc01_codmater;
                $itemRows[] = "<input type='text' name ='{$oDados->pc01_descrmater}' title='{$oDados->pc01_descrmater}' style='background-color: #DEB887' readonly value='{$oDados->pc01_descrmater}'  />";
                $itemRows[] = "<input type='text' id='descricao_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_descr}'  />";
                $itemRows[] = $selectunid;
                $itemRows[] = "<input type='text' id='marca_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_marca}'  />";
                $itemRows[] = $selectservico;

                if ($oDadosEmpAutItem->e55_servicoquantidade == 't') {
                    $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='1' onkeyup='js_calcula(this)' readonly maxlength='10' style='width: 80px' />";
                } else {
                    if($oDadosEmpAutItem->e55_vlrun != "") {
                        $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_quant}' maxlength='10' readonly style='background-color: #DEB887; width: 80px' />";
                    }else{
                        $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_quant}' onkeyup='js_calcula(this)' onkeypress='return onlynumber()' maxlength='10' style='width: 80px' />";

                    }
                }
                if($oDadosEmpAutItem->e55_vlrun != "") {
                    $itemRows[] = "<input type='text' id='vlrunit_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vlrun}' readonly onkeyup='js_calcula(this)' onkeypress='return onlynumber()' maxlength='10' style='background-color: #DEB887; width: 80px' />";
                }else{
                    $itemRows[] = "<input type='text' id='vlrunit_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vlrun}' onkeyup='js_calcula(this)' onkeypress='return onlynumber()' maxlength='10' style='width: 80px' />";
                }

                if ($_POST['desconto'] == 'f')
                    $itemRows[] = "<input type='text' id='desc_{$oDados->pc01_codmater}' value='0' onkeyup='js_calcula(this)' readonly maxlength='2' style='background-color: #DEB887; width: 80px' />";
                else
                    $itemRows[] = "<input type='text' id='desc_{$oDados->pc01_codmater}' value='$oDados->desconto' onkeyup='js_calcula(this)' onkeypress='return onlynumber()' maxlength='10' readonly style='background-color: #DEB887; width: 80px' />";
                if($oDadosEmpAutItem->e55_vlrun != "") {
                    $itemRows[] = "<input type='text' id='total_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vltot}' readonly style='background-color: #DEB887; width: 80px' />";
                }else{
                    $itemRows[] = "<input type='text' id='total_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vltot}' readonly style='width: 80px' />";
                }
                $itemRows[] = "<input type='hidden' id='elemtNum' value='{$elementonum}' />";
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

    case 'getElementosTabela':

        $autori = $_POST["e55_autori"];
        $tabela = $_POST["tabela"];
        $codele = $_POST["codele"];
        $iAnoSessao         = db_getsession('DB_anousu');

        $squery = "select e55_codele from empautitem where e55_autori = $autori";
        $rsEle = db_query($squery);

        if(pg_numrows($rsEle)>0){
            $oEle = db_utils::getCollectionByRecord($rsEle);

            foreach($oEle as $row){
                $codEle = $row->e55_codele;
            }
        }
        
    
        $sqlElementosTabela = "select distinct pc07_codele,o56_descr,o56_elemento from pctabela 
        inner join pctabelaitem on pc95_codtabela = pc94_sequencial
        inner join pcmaterele on pc07_codmater = pc95_codmater
        LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
        AND orcelemento.o56_anousu = $iAnoSessao
        where pc94_sequencial = $tabela";
       

        $rsEleTabela = db_query($sqlElementosTabela);
        
        $oElementos = db_utils::getCollectionByRecord($rsEleTabela);
        if(pg_numrows($rsEle)>0){
            $rsElemen = array();
            foreach($oElementos as $row){
                if($row->pc07_codele==$codEle){
                    $rsElemen[0]->pc07_codele = $row->pc07_codele; 
                    $rsElemen[0]->o56_descr = $row->o56_descr; 
                    $rsElemen[0]->o56_elemento = $row->o56_elemento;
                }
            }
            
            $oRetorno->elementos = $rsElemen;

        }else{
            $oRetorno->elementos = $oElementos;
        }
        

        break;

    case 'salvar':

        db_inicio_transacao();

        foreach ($_POST['dados'] as $Seq => $item) :

            $rsItem = $clempautitem->sql_record($clempautitem->sql_query(null, null, "*", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . ""));

            $vlrunit = $item['vlrunit'];
            $vlrunitdesc = ($vlrunit - ($vlrunit * $item['desc'] / 100));

            if (pg_numrows($rsItem) == 0) {
                $clempautitem->e55_codele = $_POST['codele'];
                $clempautitem->e55_item   = $item['id'];
                $clempautitem->e55_descr  = $item['descr'];
                $clempautitem->e55_quant  = $item['qtd'];
                $clempautitem->e55_unid   = $item['unidade'];
                $clempautitem->e55_marca  = $item['marca'];
                $clempautitem->e55_servicoquantidade  = $item['servico'];
                $clempautitem->e55_vlrun  = $vlrunitdesc;
                $clempautitem->e55_vltot  = $item['total'];
                $clempautitem->e55_sequen = $Seq + 1;

                $proximoSequen = db_utils::fieldsMemory($clempautitem->sql_record($clempautitem->sql_query(null, null, "case when max(e55_sequen)+ 1 is null then 1 else max(e55_sequen)+ 1 end as e55_sequen", null, "e55_autori = " . $_POST['autori'])), 0)->e55_sequen;
                $clempautitem->incluir($_POST['autori'], $proximoSequen);
            } else {

                $clempautitem->e55_autori = $_POST['autori'];
                $clempautitem->e55_codele = $_POST['codele'];
                $clempautitem->e55_sequen = db_utils::fieldsMemory($rsItem, 0)->e55_sequen;
                $clempautitem->e55_item   = $item['id'];
                $clempautitem->e55_descr  = $item['descr'];
                $clempautitem->e55_quant  = $item['qtd'];
                $clempautitem->e55_unid   = $item['unidade'];
                $clempautitem->e55_marca  = $item['marca'];
                $clempautitem->e55_servicoquantidade  = $item['servico'];
                $clempautitem->e55_vlrun  = $item['vlrunit'];
                $clempautitem->e55_vltot  = $item['total'];

                $clempautitem->alterar($_POST['autori'], db_utils::fieldsMemory($rsItem, 0)->e55_sequen);
            }
        endforeach;
        db_fim_transacao();

        if ($clempautitem->erro_status == 0) {
            $oRetorno          = new stdClass();
            $oRetorno->status  = 0;
            $oRetorno->message = urlencode(str_replace("\\n", "\n", $clempautitem->erro_msg));
            break;
        } else {
            $oRetorno          = new stdClass();
            $oRetorno->status  = 1;
            $oRetorno->message = urlencode(str_replace("\\n", "\n", $clempautitem->erro_msg));
            break;
        }

        break;

    case "excluir":

        db_inicio_transacao();
        foreach ($_POST['dados'] as $item) :
            $rsItem = $clempautitem->sql_record($clempautitem->sql_query(null, null, "*", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . ""));

            if (pg_numrows($rsItem) > 0)
                $clempautitem->excluir(null, null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id']);

        endforeach;
        db_fim_transacao();

        if ($clempautitem->erro_status == 0) {
            $oRetorno          = new stdClass();
            $oRetorno->status  = 0;
            $oRetorno->message = urlencode(str_replace("\\n", "\n", $clempautitem->erro_msg));
            break;
        } else {
            $oRetorno          = new stdClass();
            $oRetorno->status  = 1;
            $oRetorno->message = utf8_encode('Excluído com sucesso');
            break;
        }

        break;

    case "verificaSaldoCriterio":

        try {
            $oRetorno->itens   = verificaSaldoCriterioDisponivel($_POST['e55_autori'],$_POST['tabela']);
//      $oRetorno->itensqt = verificaSaldoCriterioItemQuantidade($_POST['e55_autori']);
        } catch (Exception $e) {
            $oRetorno->erro = $e->getMessage();
            $oRetorno->status   = 2;
        }

        break;
}

function verificaSaldoCriterioDisponivel ($e55_autori,$tabela){
    $sqlTotal = "SELECT DISTINCT pc23_valor
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
                             WHERE e54_autori = $e55_autori)
                          AND pc94_sequencial = $tabela
                          AND pc24_pontuacao = 1";
    $rsConsultaTotal = db_query($sqlTotal);

    $oDadosTotal = db_utils::getCollectionByRecord($rsConsultaTotal);


    $sqlUtilizado = "SELECT sum(e55_vltot) AS totalitens
                        FROM empautitem
                        INNER JOIN empautoriza ON e54_autori = e55_autori
                        INNER JOIN pctabelaitem ON pctabelaitem.pc95_codmater = empautitem.e55_item
                        INNER JOIN pctabela ON pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela
                        WHERE e54_codlicitacao =
                                (SELECT e54_codlicitacao
                                 FROM empautoriza
                                 WHERE e54_autori = $e55_autori )
                            AND pc94_sequencial = $tabela";
    $rsConsultaUtilizado = db_query($sqlUtilizado);
    $oDadosTotalUtilizado = db_utils::getCollectionByRecord($rsConsultaUtilizado);

    if($oDadosTotalUtilizado[0]->totalitens == ""){
        $disponivel = $oDadosTotal[0]->pc23_valor;
    }else{
        $disponivel = $oDadosTotal[0]->pc23_valor - $oDadosTotalUtilizado[0]->totalitens;
    }

    $saldotabela = new stdClass();
    $saldotabela->disponivel = $disponivel;
    $saldotabela->utilizado  = $oDadosTotalUtilizado[0]->totalitens == "" ? 0 : $oDadosTotalUtilizado[0]->totalitens;
    $saldotabela->total      = $oDadosTotal[0]->pc23_valor;

    return $saldotabela;
}

function verificaSaldoCriterio($e55_autori)
{
    $sSQL = "
          SELECT DISTINCT
          case when e55_vltot is null then pc23_valor
              else pc23_valor-(select sum(e55_vltot) from empautoriza join liclicita on l20_codigo = e54_codlicitacao join empautitem on e55_autori=e54_autori where l20_codigo= (select e54_codlicitacao
              from empautoriza
               where e54_autori = {$e55_autori}
             ))
          end as saldodisponivel,
          (select sum(x.utilizado) from
(select
case
	 when e54_anulad is null and sum(e60_vlranu) is not null  then sum(e55_vltot) - sum(e60_vlranu)
	 when e54_anulad is null and sum(e60_vlranu) is null then sum(e55_vltot)
	 when e54_anulad is not null then 0
end as utilizado,
e54_anulad
from empautoriza
join liclicita on l20_codigo = e54_codlicitacao
join empautitem on e55_autori = e54_autori
left join empempaut on e61_autori=e54_autori
left join empempenho on e60_numemp=e61_numemp
left join empanulado on e94_numemp=e60_numemp
where l20_codigo = (
			select
				e54_codlicitacao
			from
				empautoriza
			where
				e54_autori = {$e55_autori} )
group by empautoriza.e54_anulad) x) as utilizado
          FROM liclicitem
          INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
          INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
          INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
          INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
          INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
          LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
          LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
          LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
          LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
          LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
          LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
          LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
          LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
          AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
          LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
          LEFT JOIN cgm ON pc21_numcgm = z01_numcgm
          LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
          LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
          LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
          LEFT JOIN pcsubgrupo ON pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
          LEFT JOIN pctipo ON pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
          LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
          LEFT JOIN orcelemento ON orcelemento.o56_codele = solicitemele.pc18_codele
          AND orcelemento.o56_anousu = " . db_getsession('DB_anousu') . "
          LEFT JOIN empautitempcprocitem ON empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
          LEFT JOIN empautitem ON empautitem.e55_autori = empautitempcprocitem.e73_autori
          AND empautitem.e55_sequen = empautitempcprocitem.e73_sequen
          LEFT JOIN empautoriza ON empautoriza.e54_autori = empautitem.e55_autori
          LEFT JOIN empempaut ON empempaut.e61_autori = empautitem.e55_autori
          LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
          LEFT JOIN pcdotac ON solicitem.pc11_codigo = pcdotac.pc13_codigo
          left join pcorcamitem on pc22_orcamitem=pc26_orcamitem
          WHERE l21_codliclicita = (select e54_codlicitacao
                                     from empautoriza
                                      where e54_autori = {$e55_autori}
                                    ) and l20_criterioadjudicacao=1

    ";

    $rsConsulta = db_query($sSQL);
    $oItens = db_utils::getCollectionByRecord($rsConsulta);
    return $oItens;
}

function verificaSaldoCriterioItemQuantidade($e55_autori)
{

    $sSQL = "
   select sum(e55_quant) as totalitensqt
    from empautitem
     inner join empautoriza on e54_autori = e55_autori
      where e54_codlicitacao = ( select e54_codlicitacao from empautoriza where e54_autori = {$e55_autori} )
  ";
    $rsConsulta = db_query($sSQL);
    $oItens = db_utils::getCollectionByRecord($rsConsulta);
    return $oItens;
}

echo $oJson->encode($oRetorno);
