<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
require_once("classes/db_homologacaoadjudica_classe.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_licitemobra_classe.php");
require_once("classes/db_parecerlicitacao_classe.php");
require_once("classes/db_precomedio_classe.php");
require_once("classes/db_condataconf_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
//$oParam          = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch($oParam->exec) {
    case 'adjudicarLicitacao':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $cllicitemobra         = new cl_licitemobra();
        $clparecerlicitacao    = new cl_parecerlicitacao();
        $clprecomedio          = new cl_precomedio();
        $clcondataconf         = new cl_condataconf;
        $clliclicitasituacao   = new cl_liclicitasituacao;

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtAdjudicacao)))));
        $l202_dataAdjudicacao = DateTime::createFromFormat('d/m/Y', $data);

        try {
            //Verifica se os fornecedores vencedores estão habilitados
            if (!$clhomologacaoadjudica->validaFornecedoresHabilitados($l202_licitacao)) {
                $erro = "Procedimento abortado. Verifique os fornecedores habilitados.";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            //Verifica data de julgamento da licitação
            if ($dataJulgamentoLicitacao > $l202_dataAdjudicacao) {
                $erro = "Data de julgamento maior que data de adjudicacao";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
            $l20_naturezaobjeto = db_utils::fieldsMemory($result, 0)->l20_naturezaobjeto;

            //Verifica itens obra
            $aPcmater = $clliclicita->getPcmaterObras($l202_licitacao);
            $aPcmaterverificado = array();

            foreach ($aPcmater as $item) {
                $rsverifica = $cllicitemobra->sql_record($cllicitemobra->sql_query(null, "*", null, "obr06_pcmater = $item->pc16_codmater"));

                if (pg_num_rows($rsverifica) <= 0) {
                    $aPcmaterverificado[] = $item->pc16_codmater;
                }
            }
            $itens = implode(",", $aPcmaterverificado);

            if ($l20_naturezaobjeto == "1") {
                if ($itens != null || $itens != "") {
                    $erro = "Itens obras não cadastrados. Codigos:" . $itens;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }

            /**
             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
             */

            if(!empty($l202_dataAdjudicacao)){
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
                db_fieldsmemory($result);
                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($l202_dataAdjudicacao <= $dtencerramento) {
                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                }
            }

            $parecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao ")));
            $precomedio = pg_num_rows($clprecomedio->sql_record($clprecomedio->sql_query(null, '*', null, 'l209_licitacao =' . $l202_licitacao)));

            if ($clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) >= 1 || $precomedio >= 1) {
                if ($parecer >= 1) {
                    $tipoparecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao")));

                    if ($tipoparecer < 1) {
                        $erro = "Licitação sem Parecer Cadastrado.";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }
                    db_inicio_transacao();
                    /**
                     * Incluindo ADJUDICACAO
                     */
                    $clhomologacaoadjudica->l202_sequencial      = null;
                    $clhomologacaoadjudica->l202_licitacao       = $l202_licitacao;
                    $clhomologacaoadjudica->l202_dataadjudicacao = $oParam->dtAdjudicacao;
                    $clhomologacaoadjudica->incluir(null);

                    if ($clhomologacaoadjudica->erro_status == "0") {
                        $erro = $clhomologacaoadjudica->erro_msg;
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }else{
                        $erro = "Adjudicação salva com sucesso!";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 1;
                    }
                    /**
                     * Incluindo nova situação a licitacao ADJUDICADA
                     */
                    $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 13);

                    $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
                    $clliclicitasituacao->l11_hora        = db_hora();
                    $clliclicitasituacao->l11_obs         = "Licitação Adjudicada";
                    $clliclicitasituacao->l11_licsituacao = 13;
                    $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
                    $clliclicitasituacao->l11_liclicita   = $l202_licitacao;
                    $clliclicitasituacao->incluir(null);
                    db_fim_transacao();

                } else if ($parecer < 1 || empty($parecer)) {

                    $erro = "Cadastro de Parecer.";
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'alteraradjudicarLicitacao':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $cllicitemobra         = new cl_licitemobra();
        $clparecerlicitacao    = new cl_parecerlicitacao();
        $clprecomedio          = new cl_precomedio();
        $clcondataconf         = new cl_condataconf;
        $clliclicitasituacao   = new cl_liclicitasituacao;

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtAdjudicacao)))));
        $l202_dataAdjudicacao = DateTime::createFromFormat('d/m/Y', $data);

        try {
            //Verifica se os fornecedores vencedores estão habilitados
            if (!$clhomologacaoadjudica->validaFornecedoresHabilitados($l202_licitacao)) {
                $erro = "Procedimento abortado. Verifique os fornecedores habilitados.";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            //Verifica data de julgamento da licitação
            if ($dataJulgamentoLicitacao > $l202_dataAdjudicacao) {
                $erro = "Data de julgamento maior que data de adjudicacao";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
            $l20_naturezaobjeto = db_utils::fieldsMemory($result, 0)->l20_naturezaobjeto;

            //Verifica itens obra
            $aPcmater = $clliclicita->getPcmaterObras($l202_licitacao);
            $aPcmaterverificado = array();

            foreach ($aPcmater as $item) {
                $rsverifica = $cllicitemobra->sql_record($cllicitemobra->sql_query(null, "*", null, "obr06_pcmater = $item->pc16_codmater"));

                if (pg_num_rows($rsverifica) <= 0) {
                    $aPcmaterverificado[] = $item->pc16_codmater;
                }
            }
            $itens = implode(",", $aPcmaterverificado);

            if ($l20_naturezaobjeto == "1") {
                if ($itens != null || $itens != "") {
                    $erro = "Itens obras não cadastrados. Codigos:" . $itens;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }

            /**
             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
             */

            if(!empty($l202_dataAdjudicacao)){
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
                db_fieldsmemory($result);
                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($l202_dataAdjudicacao <= $dtencerramento) {
                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                }
            }
            /**
             * BUSCO O REGISTRO A SER ALTERADO
             */
            $homologacaoadjudica = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_sequencial", "l202_sequencial desc limit 1","l202_licitacao = {$oParam->iLicitacao}"));
            db_fieldsmemory($homologacaoadjudica,0);

            $parecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao ")));
            $precomedio = pg_num_rows($clprecomedio->sql_record($clprecomedio->sql_query(null, '*', null, 'l209_licitacao =' . $l202_licitacao)));

            if ($clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) >= 1 || $precomedio >= 1) {
                if ($parecer >= 1) {
                    $tipoparecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao")));

                    if ($tipoparecer < 1) {
                        $erro = "Licitação sem Parecer Cadastrado.";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }
                    db_inicio_transacao();
                    /**
                     * Alterar ADJUDICACAO
                     */
                    $clhomologacaoadjudica->l202_dataadjudicacao = $oParam->dtAdjudicacao;
                    $clhomologacaoadjudica->alterar($l202_sequencial);

                    if ($clhomologacaoadjudica->erro_status == "0") {
                        $erro = $clhomologacaoadjudica->erro_msg;
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }else{
                        $erro = "Adjudicação alterada com sucesso!";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 1;
                    }
                    /**
                     * Alterado nova situação a licitacao ADJUDICADA
                     */
                    $rsSituacao = $clliclicitasituacao->sql_record($clliclicitasituacao->sql_query_file(null,"l11_sequencial",null,"l11_liclicita = {$l202_licitacao} and l11_licsituacao = 13"));
                    db_fieldsmemory($rsSituacao,0);

                    $clliclicitasituacao->l11_sequencial  = $l11_sequencial;
                    $clliclicitasituacao->l11_data        = $oParam->dtAdjudicacao;
                    $clliclicitasituacao->l11_liclicita   = $l202_licitacao;
                    $clliclicitasituacao->alterar($l11_sequencial);
                    db_fim_transacao();

                } else if ($parecer < 1 || empty($parecer)) {

                    $erro = "Cadastro de Parecer.";
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'excluiradjudicarLicitacao':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $clcondataconf         = new cl_condataconf;
        $clliclicitasituacao   = new cl_liclicitasituacao;

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtAdjudicacao)))));
        $l202_dataAdjudicacao = DateTime::createFromFormat('d/m/Y', $data);

        try {
            /**
             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
             */

            if(!empty($l202_dataAdjudicacao)){
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
                db_fieldsmemory($result);
                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($l202_dataAdjudicacao <= $dtencerramento) {
                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                }
            }
            /**
             * BUSCO O REGISTRO DA ADJUDICACAO A SER EXCLUIDA
             */
            $homologacaoadjudica = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_sequencial", "l202_sequencial desc limit 1","l202_licitacao = {$oParam->iLicitacao}"));
            db_fieldsmemory($homologacaoadjudica,0);
            /**
             * BUSCO O REGISTRO DA SITUACAO A SER EXCLUIDA
             */
            $liclicitasituacao = $clliclicitasituacao->sql_record($clliclicitasituacao->sql_query_file(null,"l11_sequencial",null,"l11_liclicita = {$oParam->iLicitacao} and l11_licsituacao = 13"));
            db_fieldsmemory($liclicitasituacao,0);

            db_inicio_transacao();
            /**
             * Excluir ADJUDICACAO
             */
            $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 1);
            $clhomologacaoadjudica->excluir($l202_sequencial);
            $clliclicitasituacao->excluir($l11_sequencial);

            if ($clhomologacaoadjudica->erro_status == "0") {
                $erro = $clhomologacaoadjudica->erro_msg;
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }else{
                $erro = "Adjudicação Excluida com sucesso!";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 1;
            }
            db_fim_transacao();
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'getItens':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $campos = "DISTINCT pc01_codmater,pc01_descrmater,cgmforncedor.z01_nome,m61_descr,pc11_quant,pc23_valor,l203_homologaadjudicacao,pc81_codprocitem";

        //Itens para Inclusao
        if($oParam->dbopcao == "1"){
            $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 AND pc81_codprocitem not in (select l203_item from homologacaoadjudica
                        inner join itenshomologacao on l203_homologaadjudicacao = l202_sequencial where l202_licitacao = {$oParam->iLicitacao})";
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_semhomologacao(null,$campos,"z01_nome",$sWhere));
        }
        //Itens para Inclusao
        if($oParam->dbopcao == "2"){
            $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 AND itenshomologacao.l203_homologaadjudicacao = {$oParam->iHomologacao}";
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_comhomologacao(null,$campos,"z01_nome",$sWhere));
        }
        //Itens para Exclusão
        if($oParam->dbopcao == "3"){
            $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 AND itenshomologacao.l203_homologaadjudicacao = {$oParam->iHomologacao}";
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_comhomologacao(null,$campos,"z01_nome",$sWhere));
        }

        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($result, $iCont);
            $oItem      = new stdClass();
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->z01_nome                        = $oItensLicitacao->z01_nome;
            $oItem->m61_descr                       = $oItensLicitacao->m61_descr;
            $oItem->pc11_quant                      = $oItensLicitacao->pc11_quant;
            $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
            $oItem->l203_homologaadjudicacao        = $oItensLicitacao->l203_homologaadjudicacao;
            $oItem->pc81_codprocitem                = $oItensLicitacao->pc81_codprocitem;
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;
        break;

    case 'getItensAdjudicacao':
        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $campos = "DISTINCT pc01_codmater,pc01_descrmater,cgmforncedor.z01_nome,m61_descr,pc11_quant,pc23_valor,l203_homologaadjudicacao,pc81_codprocitem";

        $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 AND itenshomologacao.l203_sequencial is null";
        $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_semhomologacao(null,$campos,"z01_nome",$sWhere));

        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

            $oItensLicitacao = db_utils::fieldsMemory($result, $iCont);
            $oItem      = new stdClass();
            $oItem->pc01_codmater                   = $oItensLicitacao->pc01_codmater;
            $oItem->pc01_descrmater                 = urlencode($oItensLicitacao->pc01_descrmater);
            $oItem->z01_nome                        = $oItensLicitacao->z01_nome;
            $oItem->m61_descr                       = $oItensLicitacao->m61_descr;
            $oItem->pc11_quant                      = $oItensLicitacao->pc11_quant;
            $oItem->pc23_valor                      = $oItensLicitacao->pc23_valor;
            $oItem->l203_homologaadjudicacao        = $oItensLicitacao->l203_homologaadjudicacao;
            $oItem->pc81_codprocitem                = $oItensLicitacao->pc81_codprocitem;
            $itens[]                                = $oItem;
        }
        $oRetorno->itens = $itens;
        break;

    case 'homologarLicitacao':
        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $cllicitemobra         = new cl_licitemobra();
        $clparecerlicitacao    = new cl_parecerlicitacao();
        $clprecomedio          = new cl_precomedio();
        $clcondataconf         = new cl_condataconf;
        $clliclicitasituacao   = new cl_liclicitasituacao;
        $clitenshomologacao    = new cl_itenshomologacao();

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtHomologacao)))));
        $l202_datahomologacao = DateTime::createFromFormat('d/m/Y', $data);

        /**
         * VERIFICA SE E REGISTRO DE PREÇO
         */

        $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
        $l20_tipnaturezaproced  = db_utils::fieldsMemory($result, 0)->l20_tipnaturezaproced;

        try {
            //Verifica se os fornecedores vencedores estão habilitados
            if (!$clhomologacaoadjudica->validaFornecedoresHabilitados($l202_licitacao)) {
                $erro = "Procedimento abortado. Verifique os fornecedores habilitados.";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            //Verifica data de julgamento da licitação
            if ($dataJulgamentoLicitacao > $l202_datahomologacao) {
                $erro = "Data de julgamento maior que data de adjudicacao";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
            $l20_naturezaobjeto = db_utils::fieldsMemory($result, 0)->l20_naturezaobjeto;

            //Verifica itens obra
            $aPcmater = $clliclicita->getPcmaterObras($l202_licitacao);
            $aPcmaterverificado = array();

            foreach ($aPcmater as $item) {
                $rsverifica = $cllicitemobra->sql_record($cllicitemobra->sql_query(null, "*", null, "obr06_pcmater = $item->pc16_codmater"));

                if (pg_num_rows($rsverifica) <= 0) {
                    $aPcmaterverificado[] = $item->pc16_codmater;
                }
            }
            $itens = implode(",", $aPcmaterverificado);

            if ($l20_naturezaobjeto == "1") {
                if ($itens != null || $itens != "") {
                    $erro = "Itens obras não cadastrados. Codigos:" . $itens;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }

            /**
             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
             */

            if(!empty($l202_datahomologacao)){
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
                db_fieldsmemory($result);
                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($l202_datahomologacao <= $dtencerramento) {
                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                }
            }

            $parecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao ")));
            $precomedio = pg_num_rows($clprecomedio->sql_record($clprecomedio->sql_query(null, '*', null, 'l209_licitacao =' . $l202_licitacao)));

            if ($clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) >= 1 || $precomedio >= 1) {
                if ($parecer >= 1) {
                    $tipoparecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao")));

                    if ($tipoparecer < 1) {
                        $erro = "Licitação sem Parecer Cadastrado.";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }
                    db_inicio_transacao();
                    /**
                     * Incluindo HOMOLOGACAO
                     */
                    if($l20_tipnaturezaproced == '1' || $l20_tipnaturezaproced == '3'){

                        /*inserindo a data de homologacao*/
                        $clhomologacaoadjudica->l202_sequencial = null;
                        $clhomologacaoadjudica->l202_datahomologacao = $oParam->dtHomologacao;
                        $clhomologacaoadjudica->l202_licitacao       = $l202_licitacao;
                        $clhomologacaoadjudica->incluir(null);

                        /*Salva os itens*/
                        foreach ($oParam->aItens as $item) {
                            $clitenshomologacao->l203_item = $item->codigo;
                            $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
                            $clitenshomologacao->incluir(null);
                        }

                        if ($clhomologacaoadjudica->erro_status == "0") {
                            $erro = $clhomologacaoadjudica->erro_msg;
                            $oRetorno->message = urlencode($erro);
                            $oRetorno->status = 2;
                        }else{
                            $erro = "Homologação salva com sucesso!";
                            $oRetorno->message = urlencode($erro);
                            $oRetorno->status = 1;
                        }
                        /**
                         * Incluindo nova situação a licitacao Homologada
                         */
                        $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 10);

                        $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
                        $clliclicitasituacao->l11_hora        = db_hora();
                        $clliclicitasituacao->l11_obs         = "Licitação Homologada";
                        $clliclicitasituacao->l11_licsituacao = 10;
                        $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
                        $clliclicitasituacao->l11_liclicita   = $l202_licitacao;
                        $clliclicitasituacao->incluir(null);
                    }else{

                        /*inserindo a data de homologacao*/
                        $clhomologacaoadjudica->l202_sequencial      = null;
                        $clhomologacaoadjudica->l202_datahomologacao = $oParam->dtHomologacao;
                        $clhomologacaoadjudica->l202_dataadjudicacao = null;
                        $clhomologacaoadjudica->incluir(null);

                        /*Salva os itens*/
                        foreach ($oParam->aItens as $item) {
                            $clitenshomologacao->l203_item = $item->codigo;
                            $clitenshomologacao->l203_homologaadjudicacao = $l202_sequencial;
                            $clitenshomologacao->incluir(null);
                        }

                        if ($clhomologacaoadjudica->erro_status == "0") {
                            $erro = $clhomologacaoadjudica->erro_msg;
                            $oRetorno->message = urlencode($erro);
                            $oRetorno->status = 2;
                        }else{
                            $erro = "Homologação salva com sucesso!";
                            $oRetorno->message = urlencode($erro);
                            $oRetorno->status = 1;
                        }
                        /**
                         * Incluindo nova situação a licitacao Homologada
                         */
                        $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 10);

                        $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
                        $clliclicitasituacao->l11_hora        = db_hora();
                        $clliclicitasituacao->l11_obs         = "Licitação Homologada";
                        $clliclicitasituacao->l11_licsituacao = 10;
                        $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
                        $clliclicitasituacao->l11_liclicita   = $l202_licitacao;
                        $clliclicitasituacao->incluir(null);
                    }
                    db_fim_transacao();

                } else if ($parecer < 1 || empty($parecer)) {

                    $erro = "Cadastro de Parecer.";
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'alterarHomologacao':
        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $cllicitemobra         = new cl_licitemobra();
        $clparecerlicitacao    = new cl_parecerlicitacao();
        $clprecomedio          = new cl_precomedio();
        $clcondataconf         = new cl_condataconf;
        $clliclicitasituacao   = new cl_liclicitasituacao;
        $clitenshomologacao    = new cl_itenshomologacao();

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtHomologacao)))));
        $l202_datahomologacao = DateTime::createFromFormat('d/m/Y', $data);

        /**
         * VERIFICA SE E REGISTRO DE PREÇO
         */

        $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
        $l20_tipnaturezaproced  = db_utils::fieldsMemory($result, 0)->l20_tipnaturezaproced;

        try {
            //Verifica se os fornecedores vencedores estão habilitados
            if (!$clhomologacaoadjudica->validaFornecedoresHabilitados($l202_licitacao)) {
                $erro = "Procedimento abortado. Verifique os fornecedores habilitados.";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            //Verifica data de julgamento da licitação
            if ($dataJulgamentoLicitacao > $l202_datahomologacao) {
                $erro = "Data de julgamento maior que data de adjudicacao";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 2;
            }

            $result = $clliclicita->sql_record($clliclicita->sql_query($l202_licitacao));
            $l20_naturezaobjeto = db_utils::fieldsMemory($result, 0)->l20_naturezaobjeto;

            //Verifica itens obra
            $aPcmater = $clliclicita->getPcmaterObras($l202_licitacao);
            $aPcmaterverificado = array();

            foreach ($aPcmater as $item) {
                $rsverifica = $cllicitemobra->sql_record($cllicitemobra->sql_query(null, "*", null, "obr06_pcmater = $item->pc16_codmater"));

                if (pg_num_rows($rsverifica) <= 0) {
                    $aPcmaterverificado[] = $item->pc16_codmater;
                }
            }
            $itens = implode(",", $aPcmaterverificado);

            if ($l20_naturezaobjeto == "1") {
                if ($itens != null || $itens != "") {
                    $erro = "Itens obras não cadastrados. Codigos:" . $itens;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }

            /**
             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
             */

            if(!empty($l202_datahomologacao)){
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
                db_fieldsmemory($result);
                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($l202_datahomologacao <= $dtencerramento) {
                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                }
            }

            $parecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao ")));
            $precomedio = pg_num_rows($clprecomedio->sql_record($clprecomedio->sql_query(null, '*', null, 'l209_licitacao =' . $l202_licitacao)));

            if ($clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) >= 1 || $precomedio >= 1) {
                if ($parecer >= 1) {
                    $tipoparecer = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null, '*', null, "l200_licitacao = $l202_licitacao")));

                    if ($tipoparecer < 1) {
                        $erro = "Licitação sem Parecer Cadastrado.";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }
                    db_inicio_transacao();
                    /**
                     * Incluindo HOMOLOGACAO
                     */

                    /*inserindo a data de homologacao*/
                    $clhomologacaoadjudica->l202_datahomologacao = $oParam->dtHomologacao;
                    $clhomologacaoadjudica->alterar($oParam->iHomologacao);

                    if ($clhomologacaoadjudica->erro_status == "0") {
                        $erro = $clhomologacaoadjudica->erro_msg;
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    }else{
                        $erro = "Homologação salva com sucesso!";
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 1;
                    }

                    db_fim_transacao();

                } else if ($parecer < 1 || empty($parecer)) {

                    $erro = "Cadastro de Parecer.";
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;

    case 'excluirhomologacao':

        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clliclicita           = new cl_liclicita();
        $clcondataconf         = new cl_condataconf();
        $clliclicitasituacao   = new cl_liclicitasituacao();
        $clitenshomologacao    = new cl_itenshomologacao();

        $l202_licitacao = $oParam->iLicitacao;
        $rsDataJulg = $clhomologacaoadjudica->verificadatajulgamento($l202_licitacao);
        $dtjulglic = (implode("/",(array_reverse(explode("-",$rsDataJulg[0]->l11_data)))));
        $dataJulgamentoLicitacao = DateTime::createFromFormat('d/m/Y', $dtjulglic);
        $data = (implode("/",(array_reverse(explode("-",$oParam->dtAdjudicacao)))));
        $l202_dataAdjudicacao = DateTime::createFromFormat('d/m/Y', $data);

        try {
//            /**
//             * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
//             */
//
//            if(!empty($l202_dataAdjudicacao)){
//                $anousu = db_getsession('DB_anousu');
//                $instituicao = db_getsession('DB_instit');
//                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
//                db_fieldsmemory($result);
//                $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
//                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);
//
//                if ($l202_dataAdjudicacao <= $dtencerramento) {
//                    throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
//                }
//            }

            /**
             * BUSCO O REGISTRO DA SITUACAO A SER EXCLUIDA
             */
            $liclicitasituacao = $clliclicitasituacao->sql_record($clliclicitasituacao->sql_query_file(null,"l11_sequencial",null,"l11_liclicita = {$oParam->iLicitacao} and l11_licsituacao = 10"));
            db_fieldsmemory($liclicitasituacao,0);

            db_inicio_transacao();
            /**
             * Excluir Itens Homologacao
             */
            foreach ($oParam->aItens as $Item){

                $clitenshomologacao->excluir(null,"l203_homologaadjudicacao = {$oParam->iHomologacao} and l203_item = {$Item->codigo}");
                if ($clitenshomologacao->erro_status == "0") {
                    $erro = $clhomologacaoadjudica->erro_msg;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                }
            }

            /**
             * verifico se ainda existem itens
             */
            $ItensHomologacao = pg_num_rows($clitenshomologacao->sql_record($clitenshomologacao->sql_query_file(null,"*",null,"l203_homologaadjudicacao = {$oParam->iHomologacao}")));

            if($ItensHomologacao <= 0){
                /**
                 * Excluir Homologacao caso nao tenha mais itens
                 */

                $clhomologacaoadjudica->excluir($oParam->iHomologacao);

                /**
                 * verifico se existe outras homologacoes para a licitacao
                 */
                $rsOutrasHomologacoes = pg_num_rows($clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"*",null,"l202_licitacao = {$oParam->iLicitacao} and l202_datahomologacao is not null")));

                if($rsOutrasHomologacoes <= 0){
                    $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 13);
                    $clliclicitasituacao->excluir(null,"l11_licsituacao = 10 and l11_liclicita = {$oParam->iLicitacao}");
                }

                    $erro = "Homologação Excluida com sucesso!";
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 1;

            }else{
                $erro = "Itens Excluidos com Sucesso!";
                $oRetorno->message = urlencode($erro);
                $oRetorno->status = 1;
            }
            db_fim_transacao();
        }catch (Exception $eErro){
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;
}
echo json_encode($oRetorno);
