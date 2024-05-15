<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_liclicitem_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("classes/db_pcorcamval_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");

$clliclicita  = new cl_liclicita;
$clliclicitem  = new cl_liclicitem;
$clliclicitasituacao  = new cl_liclicitasituacao;

$clrotulo      = new rotulocampo;
$clrotulo->label("l20_codigo");

db_postmemory($HTTP_GET_VARS);

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';

$oGet         = db_utils::postMemory($_GET);
$sqlerro = false;
$iLicitacao   = $oGet->l20_codigo;

$sFile = explode("\\", $oGet->file);

if ($oGet->extensao == 1) {
    $extensao = 'txt';
} else if ($oGet->extensao == 2) {
    $extensao = 'csv';
} else if ($oGet->extensao == 3) {
    $extensao = 'imp';
}

if ($delimitador == "1") {
    $del = "|";
} else if ($delimitador == "2") {
    $del = ";";
} else if ($delimitador == "3") {
    $del = ",";
}

$file_handle = fopen("tmp/$sFile[4]", "r");

while (!feof($file_handle)) {
    $fieldsAll[] = explode($del, fgets($file_handle));
}

fclose($file_handle);

$aSeqPontuacao = array();

$i = 0;
foreach ($fieldsAll as $fields) {

    if (count($fields) != 11) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Arquivo inválido ');
    }

    $seq = $fields[3];
    $pontuacao = $fields[8];

    if (isset($aSeqPontuacao[$seq][$pontuacao])) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Pontuação igual em fornecedores diferentes ');
        break;
    } else {
        $aSeqPontuacao[$seq][$pontuacao] = $i++;
    }
}

db_inicio_transacao();

$rsLiclicita = $clliclicita->sql_record("select distinct z01_cgccpf, pc21_orcamforne,pc22_orcamitem from liclicita
        join liclicitem on l21_codliclicita=l20_codigo
        join pcorcamitemlic on pc26_liclicitem=l21_codigo
        join pcorcamitem on pc22_orcamitem=pc26_orcamitem
        join pcorcam on pc20_codorc=pc22_codorc
        join pcorcamforne on pc21_codorc=pc20_codorc
        join cgm on z01_numcgm=pc21_numcgm
        join liclicitasituacao on l11_liclicita = l20_codigo
        where l20_codigo=$iLicitacao");

for ($cont = 0; $cont < pg_numrows($rsLiclicita); $cont++) {
    db_fieldsmemory($rsLiclicita, $cont);

    if ($clliclicita->numrows == 0) {
        db_fim_transacao(true);
        db_redireciona("db_erros.php?fechar=true&db_erro=Importação abortada, o CNPJ: $fields[9] não foi localizado na base de dados. ");
    }

    $clpcorcamval  = new cl_pcorcamval;
    $rsPcrcamval  = $clpcorcamval->sql_record($clpcorcamval->sql_query($pc21_orcamforne, $pc22_orcamitem));

    if ($clpcorcamval->numrows > 0) {

        $clpcorcamval->excluir($pc21_orcamforne, $pc22_orcamitem);
        if ($clpcorcamval->erro_status == 0) {
            $erro_msg .= $clpcorcamval->erro_msg;
            $sqlerro = true;
            db_redireciona("db_erros.php?fechar=true&db_erro=$clpcorcamval->erro_msg");
            break;
        }
    }

    $clpcorcamjulg = new cl_pcorcamjulg;
    $rsPcorcamjulg  = $clpcorcamjulg->sql_record($clpcorcamjulg->sql_query($pc22_orcamitem, $pc21_orcamforne));

    if ($clpcorcamjulg->numrows > 0) {
        $clpcorcamjulg->excluir($pc22_orcamitem, $pc21_orcamforne);
        if ($clpcorcamjulg->erro_status == 0) {
            $erro_msg = $clpcorcamjulg->erro_msg;
            $sqlerro = true;
            db_redireciona("db_erros.php?fechar=true&db_erro=$clpcorcamjulg->erro_msg");
            break;
        }
    }
}

foreach ($fieldsAll as $fields) {

    $fields[0] = trim($fields[0]);
    $fields[1] = trim($fields[1]);
    $fields[2] = trim($fields[2]);
    $fields[3] = trim($fields[3]);
    $fields[4] = trim($fields[4]);
    $fields[5] = trim($fields[5]);
    $fields[6] = trim($fields[6]);
    $fields[7] = trim($fields[7]);
    $fields[8] = trim($fields[8]);
    $fields[9] = trim($fields[9]);

    $rsLiclicita = $clliclicita->sql_record("select distinct z01_cgccpf, pc21_orcamforne,pc22_orcamitem from liclicita
        join liclicitem on l21_codliclicita=l20_codigo
        join pcorcamitemlic on pc26_liclicitem=l21_codigo
        join pcorcamitem on pc22_orcamitem=pc26_orcamitem
        join pcorcam on pc20_codorc=pc22_codorc
        join pcorcamforne on pc21_codorc=pc20_codorc
        join cgm on z01_numcgm=pc21_numcgm
        join liclicitasituacao on l11_liclicita = l20_codigo
        where l20_codigo=$iLicitacao and l20_licsituacao=0 and z01_cgccpf = '$fields[9]' and l21_ordem = $fields[3]");
    if ($clliclicita->numrows == 0) {
        db_fim_transacao(true);
        db_redireciona("db_erros.php?fechar=true&db_erro=Importação abortada, o CNPJ: $fields[9] não foi localizado na base de dados. ");
    }

    $clpcorcamval  = new cl_pcorcamval;

    $clpcorcamval->pc23_vlrun       = $fields[4];
    $clpcorcamval->pc23_quant       = $fields[5];
    $clpcorcamval->pc23_valor       = $fields[4] * $fields[5];
    $clpcorcamval->pc23_obs         = $fields[7];
    $clpcorcamval->pc23_percentualdesconto   = $fields[6];
    $clpcorcamval->pc23_perctaxadesctabela   = $fields[6];
    $clpcorcamval->incluir(db_utils::fieldsMemory($rsLiclicita, 0)->pc21_orcamforne, db_utils::fieldsMemory($rsLiclicita, 0)->pc22_orcamitem);
    if ($clpcorcamval->erro_status == 0) {
        $erro_msg .= $clpcorcamval->erro_msg;
        $sqlerro = true;
        db_redireciona("db_erros.php?fechar=true&db_erro=$clpcorcamval->erro_msg");
        break;
    }

    $clpcorcamjulg = new cl_pcorcamjulg;

    $clpcorcamjulg->pc24_pontuacao   = $fields[8];
    $clpcorcamjulg->incluir(db_utils::fieldsMemory($rsLiclicita, 0)->pc22_orcamitem, db_utils::fieldsMemory($rsLiclicita, 0)->pc21_orcamforne);
    if ($clpcorcamjulg->erro_status == 0) {
        $erro_msg = $clpcorcamjulg->erro_msg;
        $sqlerro = true;
        db_redireciona("db_erros.php?fechar=true&db_erro=$clpcorcamjulg->erro_msg");
        break;
    }
}

$rsLiclicita = $clliclicita->sql_record("select distinct l20_codtipocom from liclicita where l20_codigo=$iLicitacao and l20_licsituacao=0");
$clliclicita->l20_licsituacao = 1;
$clliclicita->l20_codtipocom = db_utils::fieldsMemory($rsLiclicita, 0)->l20_codtipocom;
$clliclicita->l20_codigo = $iLicitacao;
$clliclicita->alterar($iLicitacao, null, null);
if ($clliclicita->erro_status == 0) {
    $erro_msg = $clliclicita->erro_msg;
    $sqlerro = true;
    db_redireciona("db_erros.php?fechar=true&db_erro=$clliclicita->erro_msg");
    return false;
}

$l11_sequencial                       = '';
$clliclicitasituacao->l11_id_usuario  = DB_getSession("DB_id_usuario");
$clliclicitasituacao->l11_licsituacao = 1;
$clliclicitasituacao->l11_liclicita   = $iLicitacao;
$clliclicitasituacao->l11_obs         = "Licitação Julgada";
$clliclicitasituacao->l11_data        = date("Y-m-d", DB_getSession("DB_datausu"));
$clliclicitasituacao->l11_hora        = DB_hora();
$clliclicitasituacao->incluir($l11_sequencial);

if ($clliclicitasituacao->erro_status == 0) {
    $erro_msg = $clliclicitasituacao->erro_msg;
    $sqlerro = true;
    db_redireciona("db_erros.php?fechar=true&db_erro=$clliclicitasituacao->erro_msg");
    return false;
}

db_fim_transacao($sqlerro);
//fclose($file_handle);

echo "<script>
    alert('Importado com sucesso');
    window.close();
</script>";
