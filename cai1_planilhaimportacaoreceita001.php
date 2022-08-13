<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("model/caixa/PlanilhaArrecadacao.model.php");
require_once("classes/db_tabrec_classe.php");

db_postmemory($HTTP_POST_VARS);
define('MENSAGENS', 'financeiro.caixa.cai1_planilhalancamento001.');
define('DEBUG', true);
montarDebug("Debug Ativo");

if (isset($processar)) {
    db_inicio_transacao();
    try {
        // Recebendo o arquivo da planilha
        db_postmemory($_FILES["arquivo"]);
		$arq_name    = substr(basename($name), 0, -4);  
		$arq_type    = $type;
		$arq_tmpname = basename($tmp_name);
		$arq_size    = $size;
		$arq_array   = file($tmp_name);
        $arq_ext     = substr($name, -3);

        if ($arq_ext != "txt")
            throw new BusinessException("Apenas arquivos de texto (.txt)");
            
        montarDebug("Dados do arquivo: {$arq_ext} {$arq_name} {$arq_type} {$arq_tmpname} {$arq_size}");

        $oPlanilhaArrecadacao = new PlanilhaArrecadacao();
        $dtArrecadacao = date('Y-m-d', db_getsession('DB_datausu'));
        $oPlanilhaArrecadacao->setDataCriacao($dtArrecadacao);
        $oPlanilhaArrecadacao->setInstituicao(InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit')));
        $oPlanilhaArrecadacao->setProcessoAdministrativo($arq_name);

        $oDaoDBConfig = db_utils::getDao("db_config");
        $rsInstit = $oDaoDBConfig->sql_record($oDaoDBConfig->sql_query_file(db_getsession("DB_instit")));
        $oInstit = db_utils::fieldsMemory($rsInstit, 0);

        montarDebug($oInstit);

        foreach ($arq_array as $iPosicao => $sLinha) {
            $oReceita = preencherLayout2($sLinha);
            
            montarDebug($oReceita);

            $iNumeroCgm        = $oInstit->numcgm;
            $iInscricao        = "";
            $iMatricula        = "";
            $iConvenio         = "";
            $sObservacao       = "";
            $sOperacaoBancaria = "";
            $iOrigem           = 1; // 1 - CGM
            $dtArrecadacao     = date('Y-m-d', db_getsession('DB_datausu'));
            $iEmParlamentar    = 3;

            $oReceitaPlanilha = new ReceitaPlanilha();
            $oReceitaPlanilha->setCaracteristicaPeculiar(new CaracteristicaPeculiar("000"));
            $oReceitaPlanilha->setCGM(CgmFactory::getInstanceByCgm($iNumeroCgm));
            // Número ficticio, será substituido pelo cadastro de Agente Arrecadador
            $oContaTesouraria = new contaTesouraria(4915);
            $oContaTesouraria->validaContaPorDataMovimento($dtArrecadacao);
            $oReceitaPlanilha->setContaTesouraria($oContaTesouraria);
            $oReceitaPlanilha->setDataRecebimento(new DBDate($oReceita->dDataCredito));
            $oReceitaPlanilha->setInscricao($iInscricao);
            $oReceitaPlanilha->setMatricula($iMatricula);
            $oReceitaPlanilha->setObservacao(db_stdClass::normalizeStringJsonEscapeString($sObservacao));
            $oReceitaPlanilha->setOperacaoBancaria($sOperacaoBancaria);
            $oReceitaPlanilha->setOrigem($iOrigem);
            $oReceitaPlanilha->setRecurso(new Recurso($oReceita->iRecurso));
            $oReceitaPlanilha->setRegularizacaoRepasse("");
            $oReceitaPlanilha->setRegExercicio("");
            $oReceitaPlanilha->setEmendaParlamentar($iEmParlamentar);
            $oReceitaPlanilha->setTipoReceita($oReceita->iReceita);
            $oReceitaPlanilha->setValor($oReceita->nValor);
            $oReceitaPlanilha->setConvenio("");
            $oPlanilhaArrecadacao->adicionarReceitaPlanilha($oReceitaPlanilha);
        }

        $oPlanilhaArrecadacao->salvar();
        db_msgbox("Planilha {$oPlanilhaArrecadacao->getCodigo()} inclusa com sucesso.\n\n");
        db_fim_transacao(false);
    } catch (Exception $oException) {
        db_fim_transacao(true);
		db_msgbox($oException->getMessage());
	}
}

function preencherLayout2($sLinha) {
    $oReceita = new stdClass();
    $oReceita->iCodBanco        = substr($sLinha, 0, 3);
    $oReceita->sDescricaoBanco  = ""; // Buscar de Agentes Arrecadadores
    $oReceita->iContaBancaria   = 0; // Buscar de Agentes Arrecadadores
    $oReceita->sCodAgencia      = substr($sLinha, 3, 4);
    $oReceita->dDataCredito     = montarData(substr($sLinha, 7, 8));
    $oReceita->nValor           = montarValor(substr($sLinha, 21, 13));
    $oReceita->sCodContabil     = montarCodigoContabil(str_replace(".", "", substr($sLinha, 35, 17)));
    $oDadosReceita              = buscarReceita($oReceita->sCodContabil);
    $oReceita->iRecurso         = $oDadosReceita->iRecurso;
    $oReceita->iReceita         = $oDadosReceita->iReceita;
    return $oReceita;
}

function buscarReceita($sCodContabil) {
    $oDadosReceita = new stdClass();
    $oDadosReceita->iReceita = 0;
    $oDadosReceita->iRecurso = 0;

    $cltabrec = new cl_tabrec;
    $sqlTabrec = $cltabrec->sql_query_inst("", "*", "k02_estorc"," k02_estorc like '{$sCodContabil}%' ");
    $rsTabrec = $cltabrec->sql_record($sqlTabrec);

    if ($cltabrec->numrows == 0) {
        throw new Exception("Não encontrado receita para conta contábil {$sCodContabil} ");
    } 

    while ($oTabRec = pg_fetch_object($rsTabrec)) {
        $oDadosReceita->iReceita = $oTabRec->k02_codigo;
        $oDadosReceita->iRecurso = $oTabRec->recurso;
        montarDebug("Código da Receita: {$oTabRec->k02_codigo} Fonte de Recurso: {$oTabRec->recurso}");
    }

    return $oDadosReceita;
}

function montarDebug($oDebug) {
    if (DEBUG) {
        var_dump($oDebug);
        echo "<br><hr/>";
    }
    return;
}

function montarCodigoContabil($sCodContabil) {
    if (in_array(substr($sCodContabil, 0, 1), array(1, 7, 9)))
        return "4{$sCodContabil}";
    return $sCodContabil;
}

/**
 * Função para formatar a data confida no txt
 *
 * @param [string] $sData
 * @return date
 */
function montarData($sData) {
    $sDia = substr($sData, 0, 2);
    $sMes = substr($sData, 2, 2);
    $sAno = substr($sData, 4, 4);
    return date("Y-m-d", strtotime("{$sDia}-{$sMes}-{$sAno}"));
}

/**
 * Função para formatar os valores contidos no txt
 *
 * @param [string] $sValor
 * @return float
 */
function montarValor($sValor) {
    return (float) ((int) substr($sValor, 0, 11)) . "." . substr($sValor, 11, 2);
}

?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
    db_app::load("scripts.js, strings.js, prototype.js, estilos.css");
    ?>
</head>

<body class="body-default" onLoad="a=1">
    <?php
    include("forms/db_planilhaimportacaoreceita001.php");
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>