<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_credenciamento_classe.php");
include("classes/db_habilitacaoforn_classe.php");
include("classes/db_parecerlicitacao_classe.php");
include("classes/db_licitemobra_classe.php");

$cllicitemobra         = new cl_licitemobra;
$clcredenciamento      = new cl_credenciamento;
$clitenshomologacao    = new cl_itenshomologacao;
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clliclicitasituacao   = new cl_liclicitasituacao;
$clliclicita           = new cl_liclicita;
$clliclicitasituacao   = new cl_liclicitasituacao;
$clhabilitacaoforn     = new cl_habilitacaoforn();
$clparecerlicitacao    = new cl_parecerlicitacao();

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));

$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

try{
    db_fim_transacao ();

    switch($oParam->exec) {

        case 'SalvarCred':

            $rsLimiteCred = $clliclicita->sql_record($clliclicita->sql_query_file($oParam->licitacao,"l20_dtlimitecredenciamento",null,null));
            db_fieldsmemory($rsLimiteCred,0)->l20_dtlimitecredenciamento;
            $dtLimitecredenciamento = (implode("/",(array_reverse(explode("-",$l20_dtlimitecredenciamento)))));

          foreach ($oParam->itens as $item){
                $rsHabilitacao = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query_file(null,"l206_datahab",null,"l206_fornecedor = $item->l205_fornecedor and l206_licitacao = $item->l205_licitacao"));
                db_fieldsmemory($rsHabilitacao,0);
                $dtHabilitacaoforne = (implode("/",(array_reverse(explode("-",$l206_datahab)))));

                $clcredenciamento->l205_fornecedor = $item->l205_fornecedor;
                $clcredenciamento->l205_datacred = $item->l205_datacred;
                $clcredenciamento->l205_item = $item->l205_item;
                $clcredenciamento->l205_licitacao = $item->l205_licitacao;
                $clcredenciamento->l205_datacreditem = $item->l205_datacreditem == "" || $item->l205_datacreditem == null ? $item->l205_datacred : $item->l205_datacreditem;

                $rsItem = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_item = {$item->l205_item} and l205_fornecedor={$item->l205_fornecedor}"));
                db_fieldsmemory($rsItem,0)->l205_sequencial;

                if($item->l205_datacred < $dtHabilitacaoforne){
                   throw new Exception ("Usuário: Campo Data de Credenciamento menor que Data de Habilitação do Fornecedor. Item: $item->l205_item");
                }

                if($dtLimitecredenciamento != ""){
                  if($item->l205_datacred > $dtLimitecredenciamento){
                    throw new Exception ("Usuário: Campo Data Credenciamento maior que data Limite de Credenciamento");
                  }
                }

                if ($rsItem == 0) {
                    $clcredenciamento->incluir(null);
                } else {
                    $clcredenciamento->l205_sequencial = $l205_sequencial;
                    $clcredenciamento->alterar();
                }

                if ($clcredenciamento->erro_status == 0) {
                    $sqlerro = true;
                    $erro_msg = $clcredenciamento->erro_msg;
                    break;
                }
              $oRetorno->sequecialforne = $item->sequenciaforne;
            }

            break;

        case 'getCredforne':
            $aItens = array();

            $resultcredforne = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"*",null,"l205_fornecedor = {$oParam->forne} and l205_licitacao = {$oParam->licitacao}"));
            if(pg_num_rows($resultcredforne) != 0){
                $oRetorno->result = $nenhumresultado;
                for ($iContItens = 0; $iContItens < pg_num_rows($resultcredforne); $iContItens++) {
                    $oItens = db_utils::fieldsMemory($resultcredforne, $iContItens);
                    $aItens[] = $oItens;
                }
                $oRetorno->itens = $aItens;
            }else{
                $oRetorno->itens = null;
            }

            break;

        case 'excluirCred':

            $clcredenciamento->excluir(null,$oParam->forne,$oParam->licitacao);

            if ($clcredenciamento->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clcredenciamento->erro_msg;
                break;
            }
            break;

        case 'julgarLic':

            /*altero a situação da licitacao para julgada*/
            $clliclicita->alterarSituacaoCredenciamento($oParam->licitacao,1);

            /*salvo os dados da situação na tabela licsituacao*/
            $l11_sequencial                       = '';
            $clliclicitasituacao->l11_id_usuario  = DB_getSession("DB_id_usuario");
            $clliclicitasituacao->l11_licsituacao = 1;
            $clliclicitasituacao->l11_liclicita   = $oParam->licitacao;
            $clliclicitasituacao->l11_obs         = "Licitação Julgada";
            $clliclicitasituacao->l11_data        = date("Y-m-d",DB_getSession("DB_datausu"));
            $clliclicitasituacao->l11_hora        = DB_hora();
            $clliclicitasituacao->incluir($l11_sequencial);

            if ($clliclicitasituacao->erro_status == 0) {
                $sqlerro = true;
            }

            break;

        case 'salvarHomo':

        	$sSql = 'SELECT c99_datapat FROM condataconf WHERE c99_anousu = '.db_getsession('DB_anousu').' and c99_instit = '.db_getsession('DB_instit');
			$rsSql = db_query($sSql);
			$datapat = db_utils::fieldsMemory($rsSql, 0)->c99_datapat;

			if($datapat >= join('-',array_reverse(explode('/', $oParam->l20_dtpubratificacao)))){
            	throw new Exception('O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
			};

        	/**
             * busco o codtipocom
             */

            $result = $clliclicita->sql_record($clliclicita->sql_query_file(null,"l20_codtipocom",null,"l20_codigo = $oParam->licitacao"));

            $l20_codtipocom = pg_result($result,0,0);

            /**
             * validação do parecer
             *
             */
            $rsParecer = $clparecerlicitacao->sql_record($clparecerlicitacao->sql_query_file(null,"*",null,"l200_licitacao = $oParam->licitacao"));

            if(pg_num_rows($rsParecer) == 0){
              throw new Exception ("Usuário: Licitação sem Parecer cadastrado.");
            }

            /**
            * validação items obra
            */
            $resultLicitacao = $clliclicita->sql_record($clliclicita->sql_query(null,"l20_naturezaobjeto",null,"l20_codigo = $oParam->licitacao"));

            if(pg_num_rows($resultLicitacao) > 0){
              db_fieldsmemory($resultLicitacao,0);

              if($l20_naturezaobjeto == "1"){
                //Verifica itens obra
                $aPcmater = $clliclicita->getPcmaterObras($oParam->licitacao);
                foreach ($aPcmater as $item){
                  $rsverifica = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $item->pc16_codmater"));
                  if(pg_num_rows($rsverifica) == 0){
                    throw new Exception ("Itens obras não cadastrados");
                  }
                }
              }
            }
            /**
             * realiza as alterações na licitaçao
             */

            db_inicio_transacao();
            $result = $clliclicita->sql_record($clliclicita->sql_query_file(null,"l20_codtipocom,l20_datacria",null,"l20_codigo = $oParam->licitacao"));
            $rsCredenciamento = $clcredenciamento->sql_record($clcredenciamento->sql_query(null,"max(l205_datacred) as l205_datacred",null,"l205_licitacao = $oParam->licitacao"));

            $l20_datacria = implode("/",(array_reverse(explode("-",db_utils::fieldsMemory($result,0)->l20_datacria))));
            $l205_datacred  = strtotime(implode("/",(array_reverse(explode("-",db_utils::fieldsMemory($rsCredenciamento,0)->l205_datacred)))));
            $l20_dtpubratificacao = strtotime(implode("/",(array_reverse(explode("-",$oParam->l20_dtpubratificacao)))));
            $l20_dtlimitecredenciamento = strtotime(implode("/",(array_reverse(explode("-",$oParam->l20_dtlimitecredenciamento)))));

          $datapublicacao = DateTime::createFromFormat('d/m/Y', $oParam->l20_dtpubratificacao);
          $datacriacao = DateTime::createFromFormat('d/m/Y', $l20_datacria);

            if($datapublicacao < $datacriacao){
              throw new Exception ("Usuário: Campo Data Publicação Termo Ratificação menor que data de criação.");
            }

            if($oParam->l20_dtpubratificacao == null || $oParam->l20_dtpubratificacao == null){
                throw new Exception ("Usuário: Campo Data Publicação Termo Ratificação não Informado.");
            }

            if($oParam->l20_tipoprocesso == "103" ||  $oParam->l20_tipoprocesso == "102") {

              if ($oParam->l20_dtlimitecredenciamento == "") {
                throw new Exception ("Usuário: Campo Data Limite Credenciamento não Informado.");
              }
            }

            if($oParam->l20_veicdivulgacao == null || $oParam->l20_veicdivulgacao == ""){
                throw new Exception ("Usuário: Campo veículo de divulgação não Informado.");
            }

//            if($oParam->l20_justificativa == null || $oParam->l20_justificativa == ""){
//                throw new Exception ("Usuário: Campo Justificativa não Informado.");
//            }

//            if($oParam->l20_razao == null || $oParam->l20_razao == ""){
//                throw new Exception ("Usuário: Campo Razão não Informado.");
//            }

//            if (strlen($oParam->l20_razao) < 10 || strlen($oParam->l20_razao) > 250) {
//                throw new Exception ("O campo Razão deve ter no mínimo 10 caracteres e no máximo 250");
//            }

//            if (strlen($oParam->l20_justificativa) < 10 || strlen($oParam->l20_justificativa) > 250) {
//                throw new Exception ("O campo justificativa deve ter no mínimo 10 caracteres e no máximo 250");
//            }

            if (strlen($oParam->l20_veicdivulgacao) < 10 || strlen($oParam->l20_veicdivulgacao) > 80) {
                throw new Exception ("O campo Veiculo deve ter no mínimo 10 caracteres e no máximo 80");
            }

            $clliclicita->l20_codtipocom = $l20_codtipocom;
            $clliclicita->l20_datacria = implode("/",(array_reverse(explode("-",db_utils::fieldsMemory($result,0)->l20_datacria))));
            $clliclicita->l205_datacred = implode("/",(array_reverse(explode("-",$l205_datacred))));
            $clliclicita->l20_codigo = $oParam->licitacao;
            $clliclicita->l20_tipoprocesso = $oParam->l20_tipoprocesso;
            $clliclicita->l20_dtpubratificacao = $oParam->l20_dtpubratificacao;
            $clliclicita->l20_dtlimitecredenciamento = $oParam->l20_dtlimitecredenciamento;
            $clliclicita->l20_veicdivulgacao = $oParam->l20_veicdivulgacao;
//            $clliclicita->l20_justificativa = $oParam->l20_justificativa;
//            $clliclicita->l20_razao = $oParam->l20_razao;
            $clliclicita->alterar($oParam->licitacao,null,null);

            if ($clliclicita->erro_status == "0") {
                $erro_msg = $clliclicita->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            /**
             * incluir a situaçao homologada
             */

            $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
            $clliclicitasituacao->l11_hora        = db_hora();
            $clliclicitasituacao->l11_licsituacao = 10;
            $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
            $clliclicitasituacao->l11_liclicita   = $oParam->licitacao;
            $clliclicitasituacao->l11_obs         = "Homologação";
            $clliclicitasituacao->incluir(null);

            if ($clliclicitasituacao->erro_status == "0") {
                $erro_msg = $clliclicitasituacao->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            /**
             * alterando a situação da licitação para homologada
             */

            $clliclicita->alterarSituacaoCredenciamento($oParam->licitacao,10);

            /**
             * incluir a homologação
             */
            $clhomologacaoadjudica->l202_licitacao = $oParam->licitacao;
            $clhomologacaoadjudica->l202_datahomologacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->l202_dataadjudicacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->incluir(null);

            if ($clhomologacaoadjudica->erro_status == "0") {
                $erro_msg = $clhomologacaoadjudica->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }
            /**
             * incluir itens na homologação
             */
            foreach ($oParam->itens as $iten) {
                $clitenshomologacao->l203_item = $iten->l205_item;
                $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
                $clitenshomologacao->incluir(null);
            }

            if ($clitenshomologacao->erro_status == "0") {
                $erro_msg = $clitenshomologacao->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            db_fim_transacao();
            break;

        case 'alterarHomo':

			$sSql = 'SELECT c99_datapat FROM condataconf WHERE c99_anousu = '.db_getsession('DB_anousu').' and c99_instit = '.db_getsession('DB_instit');
			$rsSql = db_query($sSql);
			$datapat = db_utils::fieldsMemory($rsSql, 0)->c99_datapat;

			if($datapat >= join('-',array_reverse(explode('/', $oParam->l20_dtpubratificacao)))){
				throw new Exception('O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
			};

            /**
             * busco sequencial da homologação
             */
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query(null,"l203_homologaadjudicacao",null,"l202_licitacao = $oParam->licitacao"));

            $l203_homologaadjudicacao = pg_result($result,0,0);

            /**
             * busco o codtipocom
             */

            $result = $clliclicita->sql_record($clliclicita->sql_query_file(null,"l20_codtipocom",null,"l20_codigo = $oParam->licitacao"));

            $l20_codtipocom = pg_result($result,0,0);

            /**
             * alterando a data de homologação e adjundicação
             */

            $clhomologacaoadjudica->l202_dataadjudicacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->l202_datahomologacao = $oParam->l20_dtpubratificacao;
            $clhomologacaoadjudica->alterar($l203_homologaadjudicacao);

            if ($clhomologacaoadjudica->erro_status == "0") {
                $erro_msg = $clhomologacaoadjudica->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }


            /**
             * excluindo itens anteriores da homologação
             */
            $clitenshomologacao->excluir(null, "l203_homologaadjudicacao = {$l203_homologaadjudicacao}");

            /**
             * incluindo novos itens
             */
            foreach ($oParam->itens as $iten) {
                $clitenshomologacao->l203_item = $iten->l205_item;
                $clitenshomologacao->l203_homologaadjudicacao = $l203_homologaadjudicacao;
                $clitenshomologacao->incluir(null);
            }

            if ($clitenshomologacao->erro_status == "0") {
                $erro_msg = $clitenshomologacao->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            /**
             * altero a licitação
             */

            $clliclicita->l20_codtipocom = $l20_codtipocom;
            $clliclicita->l20_codigo = $oParam->licitacao;
            $clliclicita->l20_tipoprocesso = $oParam->l20_tipoprocesso;
            $clliclicita->l20_dtpubratificacao = $oParam->l20_dtpubratificacao;
            $clliclicita->l20_dtlimitecredenciamento = $oParam->l20_dtlimitecredenciamento;
            $clliclicita->l20_veicdivulgacao = $oParam->l20_veicdivulgacao;
//            $clliclicita->l20_justificativa = $oParam->l20_justificativa;
//            $clliclicita->l20_razao = $oParam->l20_razao;
            $clliclicita->alterar($oParam->licitacao,null,null);

            if ($clliclicita->erro_status == "0") {
                $erro_msg = $clliclicita->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            break;

        case 'excluirHomo':
            db_inicio_transacao();

            /*
             * Verifica o período de encerramento patrimonial
             * */

            $sSql = 'SELECT c99_datapat FROM condataconf WHERE c99_anousu = '.db_getsession('DB_anousu').' and c99_instit = '.db_getsession('DB_instit');
            $rsSql = db_query($sSql);
            $datapat = db_utils::fieldsMemory($rsSql, 0)->c99_datapat;

            if($datapat >= join('-',array_reverse(explode('/', $oParam->ratificacao)))){
            	throw new Exception('O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
			}

            /**
             * busco sequencial da homologação
             */
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query(null,"l203_homologaadjudicacao",null,"l202_licitacao = $oParam->licitacao"));

            $l203_homologaadjudicacao = pg_result($result,0,0);

            /**
             * excluindo itens da homologação
             */
            $clitenshomologacao->excluir(null, "l203_homologaadjudicacao = {$l203_homologaadjudicacao}");

            /**
             * excluindo homologação
             */
            $clhomologacaoadjudica->excluir(null,"l202_sequencial = {$l203_homologaadjudicacao}");

            /**
             * inseriondo cancelamento de homologacao
             */

            $clliclicitasituacao->l11_data        = date("Y-m-d", db_getsession("DB_datausu"));
            $clliclicitasituacao->l11_hora        = db_hora();
            $clliclicitasituacao->l11_licsituacao = 1;
            $clliclicitasituacao->l11_id_usuario  = db_getsession("DB_id_usuario");
            $clliclicitasituacao->l11_liclicita   = $oParam->licitacao;
            $clliclicitasituacao->l11_obs         = "Cancelamento da Homologação";
            $clliclicitasituacao->incluir(null);

            if ($clliclicitasituacao->erro_status == "0") {
                $erro_msg = $clliclicitasituacao->erro_msg;
                $sqlerro = true;
                $oRetorno = $erro_msg;
            }

            /**
             * alterando a situação da licitacao para julgada
             */

            $clliclicita->alterarSituacaoCredenciamento($oParam->licitacao,1);

            /**
             * alterando a liclicita
             */

            $clliclicita->excluirpublicacaocredenciamento($oParam->licitacao);
            db_fim_transacao();

            break;

        case 'getItensHomo':
            $aItens = array();

            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query(null,"l203_item,l202_datahomologacao,l20_dtlimitecredenciamento",null,"l202_licitacao = {$oParam->licitacao}"));

            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItens[] = $oItens;
            }
            $oRetorno->itens = $aItens;
            $oRetorno->dtpublicacao = $oItens->l202_datahomologacao;
            $oRetorno->dtlimitecredenciamento = $oItens->l20_dtlimitecredenciamento;

            break;

        case 'getCredenciamento':
            $aItensCred = array();

            $result = $clcredenciamento->sql_record($clcredenciamento->sql_query_file(null,"l205_sequencial,l20_licsituacao",null,"l205_licitacao = {$oParam->licitacao} limit 1"));

            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItensCred[] = $oItens;
            }
            $oRetorno->itens = $aItensCred;

            break;
    }

    db_fim_transacao (true);

} catch (Exception $eErro) {
    $oRetorno->erro  = true;
    $oRetorno->status = 2;
    $oRetorno->message = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);
