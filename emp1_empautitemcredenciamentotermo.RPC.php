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
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_credenciamentosaldo_classe.php");

$oJson                = new services_json();
$oParam               = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oDaoSysArqCamp         = new cl_db_sysarqcamp();
$clmatunid              = new cl_matunid;
$clempautitem           = new cl_empautitem;


switch ($_POST["action"]) {

    case 'buscaItens':
        $autori     = $_POST["autori"];
        $licitacao  = $_POST["licitacao"];
        $fornecedor = $_POST["fornecedor"];
        $codele = $_POST["codele"];
        $iAnoSessao = db_getsession('DB_anousu');

        $result_unidade = array();
        $result_sql_unid = $clmatunid->sql_record($clmatunid->sql_query_file(null, "m61_codmatunid,substr(m61_descr,1,20) as m61_descr,m61_usaquant,m61_usadec", "m61_codmatunid"));
        $numrows_unid = $clmatunid->numrows;
        for ($i = 0; $i < $numrows_unid; $i++) {
            db_fieldsmemory($result_sql_unid, $i);
            $result_unidade[$m61_codmatunid] = $m61_descr;
        }

        $sqlItens = "SELECT pc11_seq,
                       pc01_codmater,
                       pc01_descrmater,
                       m61_codmatunid,
                       m61_descr,
                
                    (SELECT si02_vlprecoreferencia
                     FROM itemprecoreferencia
                     WHERE si02_itemproccompra = pcorcamitemproc.pc31_orcamitem) AS pc23_vlrun,
                       pc23_quant,
                       pc11_servicoquantidade,
                       sum(l213_qtdcontratada) AS l213_qtdcontratada,
                       pc01_servico
                FROM credenciamento
                INNER JOIN liclicita ON l20_codigo = l205_licitacao
                INNER JOIN liclicitem ON (l21_codliclicita,l21_codpcprocitem) = (l20_codigo,l205_item)
                INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                INNER JOIN pcmaterele ON pc07_codmater = pcmater.pc01_codmater
                LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
                AND orcelemento.o56_anousu = {$iAnoSessao}
                INNER JOIN pcorcamitemproc ON pcorcamitemproc.pc31_pcprocitem = pcprocitem.pc81_codprocitem
                INNER JOIN pcorcamitem ON pcorcamitem.pc22_orcamitem = pcorcamitemproc.pc31_orcamitem
                INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
                INNER JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
                INNER JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
                AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
                INNER JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
                AND pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne
                LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
                LEFT JOIN credenciamentosaldo ON credenciamentosaldo.l213_licitacao = liclicita.l20_codigo
                AND l21_codigo = l213_itemlicitacao
                WHERE l20_codigo = {$licitacao}
                    AND l205_fornecedor = {$fornecedor}
                    AND pc07_codele = {$codele}
                    AND pc24_pontuacao = 1
                GROUP BY pc11_seq,
                         pc01_codmater,
                         m61_codmatunid,
                         pc23_vlrun,
                         pc18_codele,
                         pc23_quant,
                         pc11_servicoquantidade,
                         matunid.m61_descr,
                         matunid.m61_descr,
                         pcorcamitemproc.pc31_orcamitem
                order by pc11_seq";

        $iAnoSessao         = db_getsession('DB_anousu');
        $rsDados      = $oDaoSysArqCamp->sql_record($sqlItens);

        if ($oDaoSysArqCamp->numrows > 0) {
            $employeeData = array();
            for ($i = 0; $i < pg_numrows($rsDados); $i++) {

                $oDados = db_utils::fieldsMemory($rsDados, $i);

                $resultEmpAutItem = $clempautitem->sql_record($clempautitem->sql_query_file($autori, null, "*", "e55_sequen", " e55_autori = $autori and e55_item = $oDados->pc01_codmater"));
                $oDadosEmpAutItem = db_utils::fieldsMemory($resultEmpAutItem, 0);

                $selectunid = "";
                $selectunid = "<select id='unidade_{$oDados->pc01_codmater}'>";
                $selectunid .= "<option selected='selected'></option>";
                foreach ($result_unidade as $key => $item) {
                    if ($key == $oDados->m61_codmatunid)
                        $selectunid .= "<option value='$key' selected='selected'>$item</option>";
                    else
                        $selectunid .= "<option value='$key'>$item</option>";
                }
                $selectunid .= "</select>";
                $qtd_disponivel = $oDados->pc23_quant - $oDados->l213_qtdcontratada;
                $itemRows  = array();
                $itemRows[] = "<input type='checkbox' id='checkbox_{$oDados->pc01_codmater}' name='checkbox_{$oDados->pc01_codmater}'>";
                $itemRows[] = $oDados->pc11_seq;
                $itemRows[] = $oDados->pc01_codmater;
                $itemRows[] = $oDados->pc01_descrmater;
                $itemRows[] = $selectunid;
                $itemRows[] = "<input type='text' id='qtddisponivel_{$oDados->pc01_codmater}' value='{$qtd_disponivel}' readonly style='background-color: #DEB887; width: 80px' />";
                $itemRows[] = "<input type='text' id='vlr_{$oDados->pc01_codmater}' value='{$oDados->pc23_vlrun}' readonly style='background-color: #DEB887; width: 80px' />";
                if($oDadosEmpAutItem->e55_vlrun != "") {
                    $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_quant}' maxlength='10' readonly style='background-color: #DEB887; width: 80px' />";
                }else{
                    $itemRows[] = "<input type='text' id='qtd_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_quant}' onkeyup='js_calcula(this)' maxlength='10' style='width: 80px' />";
                }
                if($oDadosEmpAutItem->e55_vltot != ""){
                    $itemRows[] = "<input type='text' id='total_{$oDados->pc01_codmater}' value='{$oDadosEmpAutItem->e55_vltot}' readonly style='background-color: #DEB887; width: 80px' />";
                }else{
                    $itemRows[] = "<input type='text' id='total_{$oDados->pc01_codmater}' value='' readonly style='background-color: #DEB887; width: 80px' />";
                }
                $employeeData[] = $itemRows;
            }

            $oRetorno = array(
                "draw"  =>  intval($_POST["draw"]),
                "iTotalRecords"  =>   pg_numrows($rsDados),
                "data"  =>   $employeeData
            );
        }
        break;

    case 'getElementos':

        $autori             = $_POST["e55_autori"];
        $e54_numcgm         = $_POST["e54_numcgm"];
        $e54_codlicitacao   = $_POST["e54_codlicitacao"];
        $iAnoSessao         = db_getsession('DB_anousu');

        $sqlElementosTabela = "SELECT DISTINCT pc07_codele,
                                               o56_descr
                    FROM credenciamento
                    INNER JOIN liclicita ON l20_codigo = l205_licitacao
                    INNER JOIN liclicitem ON (l21_codliclicita,l21_codpcprocitem) = (l20_codigo,l205_item)
                    INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                    INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                    INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                    INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                    INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                    INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                    INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                    INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                    INNER JOIN pcmaterele ON pc07_codmater = pcmater.pc01_codmater
                    LEFT JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
                    AND orcelemento.o56_anousu = {$iAnoSessao}
                    INNER JOIN pcorcamitemproc ON pcorcamitemproc.pc31_pcprocitem = pcprocitem.pc81_codprocitem
                    INNER JOIN pcorcamitem ON pcorcamitem.pc22_orcamitem = pcorcamitemproc.pc31_orcamitem
                    INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
                    INNER JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
                    INNER JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
                    AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
                    INNER JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
                    AND pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne
                    LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
                    LEFT JOIN credenciamentosaldo ON credenciamentosaldo.l213_licitacao = liclicita.l20_codigo
                    AND l21_codigo = l213_itemlicitacao
                    WHERE l20_codigo = {$e54_codlicitacao}
                        AND l205_fornecedor = {$e54_numcgm}
                        AND pc24_pontuacao = 1";

        $rsEleTabela = db_query($sqlElementosTabela);

        $oElementos = db_utils::getCollectionByRecord($rsEleTabela);
        $oRetorno->elementos = $oElementos;

        break;

    case 'salvar':

        $licitacao  = $_POST["licitacao"];
        $fornecedor = $_POST["fornecedor"];
        db_inicio_transacao();

        foreach ($_POST['dados'] as $Seq => $item) :

            /**
             * get Codigo do item na liclicitem
             */
            $sSqlItemlic = "
                        SELECT l21_codigo,pc01_descrmater,pc11_quant
                        FROM liclicitem
                        INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                        INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                        LEFT  JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                        LEFT  JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                        LEFT  JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                        LEFT  JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                        where l21_codliclicita = $licitacao and pc01_codmater =".$item['id'];
            $rsDadosItemLiclicitem      = $oDaoSysArqCamp->sql_record($sSqlItemlic);
            $oDadositem = db_utils::fieldsMemory($rsDadosItemLiclicitem, 0);

            $rsItem = $clempautitem->sql_record($clempautitem->sql_query(null, null, "*", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . ""));

            $vlrunit = $item['vlrunit'];

            if (pg_numrows($rsItem) == 0) {

                $clempautitem->e55_codele = $_POST['codele'];
                $clempautitem->e55_item   = $item['id'];
                $clempautitem->e55_descr  = $item['descr'];
                $clempautitem->e55_quant  = $item['qtd'];
                $clempautitem->e55_unid   = $item['unidade'];
                $clempautitem->e55_marca  = $item['marca'];
                $clempautitem->e55_servicoquantidade  = 'f';
                $clempautitem->e55_vlrun  = $item['vlrunit'];
                $clempautitem->e55_vltot  = $item['total'];
                $clempautitem->e55_sequen = $Seq + 1;

                $proximoSequen = db_utils::fieldsMemory($clempautitem->sql_record($clempautitem->sql_query(null, null, "case when max(e55_sequen)+ 1 is null then 1 else max(e55_sequen)+ 1 end as e55_sequen", null, "e55_autori = " . $_POST['autori'])), 0)->e55_sequen;
                $clempautitem->incluir($_POST['autori'], $proximoSequen);

                /**
                 * inserindo na tabela de saldos do credenciamento
                 */
                $cl_credenciamentosaldo = new cl_credenciamentosaldo();
                $cl_credenciamentosaldo->l213_licitacao = $licitacao;
                $cl_credenciamentosaldo->l213_item = $item['id'];
                $cl_credenciamentosaldo->l213_qtdcontratada = $item['qtd'];
                $cl_credenciamentosaldo->l213_contratado = $fornecedor;
                $cl_credenciamentosaldo->l213_itemlicitacao = $oDadositem->l21_codigo;
                $cl_credenciamentosaldo->l213_qtdlicitada = $oDadositem->pc11_quant;
                $cl_credenciamentosaldo->incluir();

            } else {

                $clempautitem->e55_autori = $_POST['autori'];
                $clempautitem->e55_codele = $_POST['codele'];
                $clempautitem->e55_sequen = db_utils::fieldsMemory($rsItem, 0)->e55_sequen;
                $clempautitem->e55_item   = $item['id'];
                $clempautitem->e55_descr  = $item['descr'];
                $clempautitem->e55_quant  = $item['qtd'];
                $clempautitem->e55_unid   = $item['unidade'];
                $clempautitem->e55_marca  = $item['marca'];
                $clempautitem->e55_servicoquantidade  = 'f';
                $clempautitem->e55_vlrun  = $item['vlrunit'];
                $clempautitem->e55_vltot  = $item['total'];

                $clempautitem->alterar($_POST['autori'], db_utils::fieldsMemory($rsItem, 0)->e55_sequen);

                $cl_credenciamentosaldo = new cl_credenciamentosaldo();


                /**
                 * getcredenciamento saldo
                 */
                $rsCredenciamentoSaldo = $cl_credenciamentosaldo->sql_record($cl_credenciamentosaldo->sql_query(null,"l213_sequencial",null,"l213_licitacao = {$licitacao} and l213_contratado = {$fornecedor} and l213_item = ".$item['id']));

                $oDadosCredenciamentoSaldo = db_utils::fieldsMemory($rsCredenciamentoSaldo, 0);

                $cl_credenciamentosaldo->l213_licitacao = $licitacao;
                $cl_credenciamentosaldo->l213_item = $item['id'];
                $cl_credenciamentosaldo->l213_qtdcontratada = $item['qtd'];
                $cl_credenciamentosaldo->l213_contratado = $fornecedor;
                $cl_credenciamentosaldo->l213_itemlicitacao = $oDadositem->l21_codigo;
                $cl_credenciamentosaldo->l213_qtdlicitada = $oDadositem->pc11_quant;
                $cl_credenciamentosaldo->alterar($oDadosCredenciamentoSaldo->l213_sequencial);
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

        $licitacao  = $_POST["licitacao"];
        $fornecedor = $_POST["fornecedor"];

        db_inicio_transacao();
        foreach ($_POST['dados'] as $item) :
            $rsItem = $clempautitem->sql_record($clempautitem->sql_query(null, null, "*", null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id'] . ""));

            if (pg_numrows($rsItem) > 0){
                $clempautitem->excluir(null, null, "e55_autori = " . $_POST['autori'] . " and e55_item = " . $item['id']);
            }

            /**
             * getcredenciamento saldo
             */
            $cl_credenciamentosaldo = new cl_credenciamentosaldo();

            $rsCredenciamentoSaldo = $cl_credenciamentosaldo->sql_record($cl_credenciamentosaldo->sql_query(null,"l213_sequencial",null,"l213_licitacao = {$licitacao} and l213_contratado = {$fornecedor} and l213_item = ".$item['id']));

            $oDadosCredenciamentoSaldo = db_utils::fieldsMemory($rsCredenciamentoSaldo, 0);

            $cl_credenciamentosaldo->excluir($oDadosCredenciamentoSaldo->l213_sequencial);

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

    case 'getNumeroTermo':
        $iAnoSessao      = db_getsession('DB_anousu');

        $sql = "select max(l212_numerotermo) as numeromaximo from credenciamentotermo";
        $rsNumTermo  = db_query($sql);
        $iNumTermo = db_utils::fieldsMemory($rsNumTermo, 0)->numeromaximo;
        if($iNumTermo == ""){
            $iNum = 1;
        }else{
            $ultimonum = explode("/", $iNumTermo);
            $iNum = $ultimonum[0] + 1;
        }

        $iNumTermoAno = $iNum.'/'.$iAnoSessao;

        $oRetorno->numerotermo = $iNumTermoAno;

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
