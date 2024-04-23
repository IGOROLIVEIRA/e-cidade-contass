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
require_once("classes/db_licobrasmedicao_classe.php");
require_once("classes/db_licobrasanexo_classe.php");
require_once("classes/db_licobrasresponsaveis_classe.php");
require_once("classes/db_homologacaoadjudica_classe.php");
require_once("classes/db_licobras_classe.php");
include("classes/db_licitemobra_classe.php");
include("classes/db_condataconf_classe.php");
include("classes/db_historicocgm_classe.php");

db_app::import("configuracao.DBDepartamento");

$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oErro             = new stdClass();

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec) {

    case 'getAnexos':

        $cllicobrasanexos = new cl_licobrasanexo();
        $resultAnexos = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null, "*", null, "obr04_licobrasmedicao = $oParam->codmedicao"));

        for ($iCont = 0; $iCont < pg_num_rows($resultAnexos); $iCont++) {
            $oDadosAnexo = db_utils::fieldsMemory($resultAnexos, $iCont);

            $oDocumentos      = new stdClass();
            $oDocumentos->iCodigo    = $oDadosAnexo->obr04_sequencial;
            $oDocumentos->sLegenda   = $oDadosAnexo->obr04_legenda;
            $oRetorno->dados[] = $oDocumentos;
        }

        $oRetorno->detalhe    = "documentos";

        break;

    case 'excluirAnexo':
        try {
            db_inicio_transacao();

            $cllicobrasanexos = new cl_licobrasanexo();
            $cllicobrasanexos->excluir($oParam->codAnexo);

            if ($cllicobrasanexo->erro_status == '0') {
                throw new Exception($cllicobrasanexo->erro_msg);
            }

            db_fim_transacao();
        } catch (Exception $eErro) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case 'buscarNumObra':
        $cllicobras = new cl_licobras();

        $rsObra = $cllicobras->sql_record($cllicobras->sql_query(null,'max(obr01_numeroobra) +1 as numeroobra',null,'obr01_instit ='.db_getsession('DB_instit')));
        
        if(pg_num_rows($rsObra) > 0){
            db_fieldsmemory($rsObra,0);
            $oRetorno->status = 1;
            $oRetorno->numobra = $numeroobra;
        }else{
           
            $oRetorno->status = 2;
            $oRetorno->numobra = urlencode("Não Encontrato");
        }

        break;

    case 'alterarAnexo':

        $cllicobrasanexos = new cl_licobrasanexo();
        $rsAnexo =  $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null, "*", null, "obr04_licobrasmedicao = $oParam->codmedicao and obr04_legenda like '%foto sem legenda%'"));
        if (pg_num_rows($rsAnexo) == 1) {
            $ultimoregistro = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null, "max(obr04_sequencial) as obr04_sequencial", null, ""));
            db_fieldsmemory($ultimoregistro, 0);
            $cllicobrasanexos->obr04_legenda = $oParam->legenda;
            $cllicobrasanexos->alterar($obr04_sequencial);
        } else {
            $oRetorno->status = 2;
            $oRetorno->message = "Erro ! Arquivo nao excluido contate o Suporte.";
        }

        break;

    case 'SalvarResp':

        $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $clcondataconf = new cl_condataconf;
        $cllicobras = new cl_licobras();
        $clhistoricocgm = new cl_historicocgm();

        $resulthomologacao = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null, "l202_datahomologacao", null, "l202_licitacao = $oParam->licitacao"));
        db_fieldsmemory($resulthomologacao, 0);
        $data = (implode("/", (array_reverse(explode("-", $l202_datahomologacao)))));
        $datahomologacao = DateTime::createFromFormat('d/m/Y', $data);
        $datainicioatividades = DateTime::createFromFormat('d/m/Y', $oParam->obr05_dtcadastrores);

        $rsObra = $cllicobras->sql_record($cllicobras->sql_query($oParam->obr05_seqobra));
        db_fieldsmemory($rsObra, 0);
        $dtObra = (implode("/", (array_reverse(explode("-", $obr01_dtlancamento)))));
        $dtLancObra = DateTime::createFromFormat('d/m/Y', $dtObra);

        $sWhere = "obr05_seqobra = $oParam->obr05_seqobra and obr05_responsavel = $oParam->obr05_responsavel and obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel";
        $sWhere .= "and obr05_tiporegistro = $oParam->obr05_tiporegistro and obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional";
        $resultresp = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null, "*", null, $sWhere));
        db_fieldsmemory($resultresp, 0);

        try {

            if ($datahomologacao != null) {
                if ($datainicioatividades < $datahomologacao) {
                    throw new Exception("Usuário: Campo Data de Inicio das atividades deve ser maior que data de Homologação da Licitação.");
                }
            }

            if ($datainicioatividades < $dtLancObra) {
                throw new Exception("Usuário: Campo Data de início das atividades deve ser igual ou maior do que a data de lançamento da obra.");
            }

            /**
             * validação com sicom
             */
            if (!empty($datainicioatividades)) {
                $anousu = db_getsession('DB_anousu');
                $instituicao = db_getsession('DB_instit');
                $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu, $instituicao, "c99_datapat", null, null));
                db_fieldsmemory($result);
                $data = (implode("/", (array_reverse(explode("-", $c99_datapat)))));
                $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

                if ($dtencerramento != null || $dtencerramento != "") {
                    if ($datainicioatividades <= $dtencerramento) {
                        throw new Exception("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                    }
                }
            }

            $result_dtcadcgm = $clhistoricocgm->sql_record($clhistoricocgm->sql_query_file(null, "z09_datacadastro", "", "z09_numcgm = $oParam->obr05_responsavel and z09_tipo = 1"));
            db_utils::fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
            $datacgm = (implode("/", (array_reverse(explode("-", $z09_datacadastro)))));
            $date = (implode("/", (array_reverse(explode("-", date("Y-m-d", db_getsession('DB_datausu')))))));
            $dtsessao = DateTime::createFromFormat('d/m/Y', $date);
            $z09_datacadastro = DateTime::createFromFormat('d/m/Y', $datacgm);

            if ($dtsessao < $z09_datacadastro) {
                throw new Exception("Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!");
            }

            if (pg_num_rows($resultresp) > 0) {
                $cllicobrasresponsaveis->obr05_responsavel = $oParam->obr05_responsavel;
                $cllicobrasresponsaveis->obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel;
                $cllicobrasresponsaveis->obr05_tiporegistro = $oParam->obr05_tiporegistro;
                $cllicobrasresponsaveis->obr05_numregistro = $oParam->obr05_numregistro;
                $cllicobrasresponsaveis->obr05_numartourrt = $oParam->obr05_numartourrt;
                $cllicobrasresponsaveis->obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional;
                $cllicobrasresponsaveis->obr05_dtcadastrores = $oParam->obr05_dtcadastrores;
                $cllicobrasresponsaveis->obr05_dscoutroconselho = $oParam->obr05_dscoutroconselho;
                $cllicobrasresponsaveis->alterar($obr05_sequencial);

                if ($cllicobrasresponsaveis->erro_status == 0) {
                    $erro = $cllicobrasresponsaveis->erro_msg;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                } else {
                    $oRetorno->status = 1;
                    $oRetorno->message = urlencode("Responsável Alterado com Sucesso.");
                }
            } else {
                $cllicobrasresponsaveis->obr05_seqobra = $oParam->obr05_seqobra;
                $cllicobrasresponsaveis->obr05_responsavel = $oParam->obr05_responsavel;
                $cllicobrasresponsaveis->obr05_tiporesponsavel = $oParam->obr05_tiporesponsavel;
                $cllicobrasresponsaveis->obr05_tiporegistro = $oParam->obr05_tiporegistro;
                $cllicobrasresponsaveis->obr05_numregistro = $oParam->obr05_numregistro;
                if ($oParam->obr05_numartourrt == "") {
                    $cllicobrasresponsaveis->obr05_numartourrt =  NULL;
                } else {
                    $cllicobrasresponsaveis->obr05_numartourrt = $oParam->obr05_numartourrt;
                }
                $cllicobrasresponsaveis->obr05_vinculoprofissional = $oParam->obr05_vinculoprofissional;
                $cllicobrasresponsaveis->obr05_dtcadastrores = $oParam->obr05_dtcadastrores;
                $cllicobrasresponsaveis->obr05_dscoutroconselho = $oParam->obr05_dscoutroconselho;
                $cllicobrasresponsaveis->obr05_instit = db_getsession("DB_instit");
                $cllicobrasresponsaveis->incluir();

                if ($cllicobrasresponsaveis->erro_status == 0) {
                    $erro = $cllicobrasresponsaveis->erro_msg;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                } else {
                    $oRetorno->status = 1;
                    $oRetorno->message = urlencode("Responsável salvo com sucesso.");
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }

        break;

    case 'getResponsaveis':
        $cllicobrasresponsaveis = new cl_licobrasresponsaveis();

        $rsResponsaveis = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null, "obr05_sequencial,obr05_tiporesponsavel,z01_nome", null, "obr05_seqobra = $oParam->obr05_seqobra"));

        for ($iCont = 0; $iCont < pg_num_rows($rsResponsaveis); $iCont++) {
            $oDadosResponsavel = db_utils::fieldsMemory($rsResponsaveis, $iCont);

            $oResponsaveis                        = new stdClass();
            $oResponsaveis->iCodigo               = $oDadosResponsavel->obr05_sequencial;

            if ($oDadosResponsavel->obr05_tiporesponsavel == "1") {
                $oResponsaveis->iTiporesponsavel = urlencode("Fiscalização");
            } elseif ($oDadosResponsavel->obr05_tiporesponsavel == "2") {
                $oResponsaveis->iTiporesponsavel = urlencode("Execução");
            } elseif ($oDadosResponsavel->obr05_tiporesponsavel == "3") {
                $oResponsaveis->iTiporesponsavel = urlencode("Projetista");
            } else {
                $oResponsaveis->iTiporesponsavel = urlencode("Selecione");
            }
            $oResponsaveis->sNome                 = urlencode($oDadosResponsavel->z01_nome);
            $oRetorno->dados[] = $oResponsaveis;
        }
        break;

    case 'excluirResp':
        $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
        $cllicobrasresponsaveis->excluir($oParam->iCodigo);

        if ($cllicobrasresponsaveis->erro_status == 0) {
            $erro = $cllicobrasresponsaveis->erro_msg;
            $oRetorno->message = urlencode($erro);
        } else {
            $oRetorno->message = urlencode("Responsável Excluido com sucesso.");
        }
        break;
    case 'buscarLotes':
        $clliclicita = new cl_liclicita();

        if ($oParam->iLicitacao != "" || $oParam->iLicitacao != null) {
            $oRetorno->status = 3;
            $resultLotes = $clliclicita->sql_record('select DISTINCT l04_numerolote,l04_descricao from liclicitemlote where l04_liclicitem in (select l21_codigo from liclicitem where l21_codliclicita = ' . $oParam->iLicitacao . ' and l04_numerolote > 0 )');
            if (pg_num_rows($resultLotes) == 0) {
                $oRetorno->status = 2;
            } else {
                $resultLicobras = $clliclicita->sql_record('select DISTINCT obr01_licitacaolote from licobras where obr01_licitacao = ' . $oParam->iLicitacao);
                for ($iCont = 0; $iCont < pg_num_rows($resultLotes); $iCont++) {
                    $oDadosLotes = db_utils::fieldsMemory($resultLotes, $iCont);
                    $contrele = 0;
                    if ($oParam->iObra == 0) {
                        for ($iContLicobras = 0; $iContLicobras < pg_num_rows($resultLicobras); $iContLicobras++) {
                            $oDadosLicobras = db_utils::fieldsMemory($resultLicobras, $iContLicobras);
                            if ($oDadosLicobras->obr01_licitacaolote == $oDadosLotes->l04_numerolote) {
                                $contrele = 1;
                            }
                        }
                    }
                    if ($contrele == 0) {

                        $oRetorno->status = 1;
                        $lotes                        = new stdClass();
                        $lotes->descricao = urlencode($oDadosLotes->l04_descricao);
                        $lotes->numlote = $oDadosLotes->l04_numerolote;
                        $lotes->total = pg_num_rows($resultLotes);
                        $oRetorno->itens[] = $lotes;
                    }
                }
            }
        }
        break;

    case 'getDadosResponsavel':
        $cllicobrasresponsaveis = new cl_licobrasresponsaveis();
        $rsResponsaveis = $cllicobrasresponsaveis->sql_record($cllicobrasresponsaveis->sql_query(null, "licobrasresponsaveis.*,z01_numcgm,z01_nome,licobras.*", null, "obr05_sequencial = $oParam->iCodigo"));

        for ($iCont = 0; $iCont < pg_num_rows($rsResponsaveis); $iCont++) {
            $oDadosResponsavel = db_utils::fieldsMemory($rsResponsaveis, $iCont);

            $oDadosResponsavel->z01_nome = urlencode($oDadosResponsavel->z01_nome);
            $oRetorno->dados[] = $oDadosResponsavel;
        }
        break;

    case 'salvarDocumento':

        try {
            db_inicio_transacao();

            global $conn;

            if (!file_exists($oParam->arquivo)) {
                throw new Exception("Arquivo do Documento não Encontrado.");
            }

            $cllicobrasanexo = new cl_licobrasanexo();
            $sqlanexo = $cllicobrasanexo->sql_query(null, "*", null, "obr04_licobrasmedicao = $oParam->medicao");
            $rsAnexo = $cllicobrasanexo->sql_record($sqlanexo);
            db_fieldsmemory($rsAnexo, 0);

            if (pg_num_rows($rsAnexo) > 0) {
                throw new Exception("Já existe anexo para esta Medição.");
            } else {

                if (!file_exists($oParam->arquivo)) {
                    throw new Exception("Arquivo da foto não Encontrado.");
                }
                $aNomeArquivo = explode("/", $oParam->arquivo);
                $sNomeArquivo = str_replace(" ", "_", $aNomeArquivo[1]);

                /**
                 * Abre um arquivo em formato binario somente leitura
                 */
                $rDocumento = fopen($oParam->arquivo, "rb");
                /**
                 * Pega todo o conteúdo do arquivo e coloca no resource
                 */
                $rDadosDocumento = fread($rDocumento, filesize($oParam->arquivo));
                fclose($rDocumento);
                $oOidBanco = pg_lo_create();

                $cllicobrasanexo->obr04_licobrasmedicao = $oParam->medicao;
                $cllicobrasanexo->obr04_legenda = $oParam->legenda;
                $cllicobrasanexo->obr04_anexo = $oOidBanco;
                $cllicobrasanexo->incluir();

                if ($cllicobrasanexo->erro_status == '0') {
                    throw new Exception($cllicobrasanexo->erro_msg);
                }

                $oObjetoBanco = pg_lo_open($conn, $oOidBanco, "w");
                pg_lo_write($oObjetoBanco, $rDadosDocumento);
                pg_lo_close($oObjetoBanco);
            }
            db_fim_transacao();
        } catch (Exception $oErro) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($oErro->getMessage());
            db_fim_transacao(true);
        }
        break;

    case 'downloadDocumento':

        $cllicobrasanexos = new cl_licobrasanexo();

        $result = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null, "*", null, "obr04_sequencial = $oParam->iCodigoDocumento"));
        db_fieldsmemory($result, 0);

        db_inicio_transacao();

        // Abrindo o objeto no modo leitura "r" passando como parâmetro o OID.
        $sNomeArquivo = "tmp/$obr04_anexo.pdf";
        pg_lo_export($conn, $obr04_anexo, $sNomeArquivo);

        db_fim_transacao();
        $oRetorno->nomearquivo = $sNomeArquivo;

        break;

    case 'getItensObra':

        $cllicitemobra = new cl_licitemobra();

        $sCampos  = " distinct pc01_codmater,pc01_descrmater,obr06_tabela,obr06_descricaotabela,obr06_dtregistro,obr06_dtcadastro,obr06_codigotabela,obr06_versaotabela,l21_ordem";

        if (isset($oParam->l20_codigo) && !empty($oParam->l20_codigo)) {
            $sOrdem   = "l21_ordem";
            $sWhere   = "l21_codliclicita = {$oParam->l20_codigo} and pc01_obras = 't' and pc10_instit = " . db_getsession('DB_instit');
            $sSqlItemLicitacao = $cllicitemobra->sql_query_itens_obras_licitacao(null, $sCampos, $sOrdem, $sWhere);
            $sResultitens = $cllicitemobra->sql_record($sSqlItemLicitacao);
            $oRetorno->itens = db_utils::getCollectionByRecord($sResultitens);
        } else if (isset($oParam->pc80_codproc) && !empty($oParam->pc80_codproc)) {
            $sOrdem   = "pc11_seq";
            $sWhere   = "pc80_codproc = {$oParam->pc80_codproc} and pc01_obras = 't' and pc10_instit = " . db_getsession('DB_instit');
            $sSqlItemProcessodeCompras = $cllicitemobra->sql_query_itens_obras_processodecompras(null, $sCampos, $sOrdem, $sWhere);
            $sResultitens = $cllicitemobra->sql_record($sSqlItemProcessodeCompras);
            $oRetorno->itens = db_utils::getCollectionByRecord($sResultitens);
        } else {
            $oRetorno->message = "selecione um processo de compras ou uma licitacao";
        }

        break;

    case 'SalvarItemObra':
        $cllicitemobra = new cl_licitemobra();
        $clcondataconf = new cl_condataconf;

        try {
            foreach ($oParam->itens as $item) {

                /**
                 * Validação com sicom
                 */
                if (strpos($item->obr06_dtcadastro, '/') !== false) {
                    $dtcadastro = DateTime::createFromFormat('d/m/Y', $item->obr06_dtcadastro);
                } else if (strpos($item->obr06_dtcadastro, '-') !== false) {
                    $dtcadastro = DateTime::createFromFormat('Y-m-d',  $item->obr06_dtcadastro);
                }

                if (!empty($dtcadastro)) {
                    $anousu = db_getsession('DB_anousu');
                    $instituicao = db_getsession('DB_instit');
                    $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu, $instituicao, "c99_datapat", null, null));
                    db_fieldsmemory($result);
                    $data = (implode("/", (array_reverse(explode("-", $c99_datapat)))));
                    $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);
                    if ($dtcadastro <= $dtencerramento) {
                        throw new Exception("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
                    }
                }

                $pcmater = substr($item->obr06_pcmater, 0, -1);

                // Hotfix OC21089: Compatibilidade com anos anteriores à adição da ordem
                if ((int) $oParam->ano < 2024) {
                    $where = " obr06_pcmater = $pcmater ";
                } else {
                    $where = " obr06_pcmater = $pcmater AND obr06_ordem = $item->obr06_ordem ";
                }

                $verificaItem = $cllicitemobra->sql_record($cllicitemobra->sql_query_file(null, "obr06_sequencial", null, $where));
                if (pg_num_rows($verificaItem) <= 0) {
                    db_inicio_transacao();

                    $cllicitemobra->obr06_sequencial        = null;
                    $cllicitemobra->obr06_pcmater           = $pcmater;
                    $cllicitemobra->obr06_tabela            = $item->obr06_tabela;
                    $cllicitemobra->obr06_descricaotabela   = $item->obr06_descricaotabela;
                    $cllicitemobra->obr06_codigotabela      = $item->obr06_codigotabela;
                    $cllicitemobra->obr06_versaotabela      = $item->obr06_versaotabela;
                    $cllicitemobra->obr06_dtregistro        = $item->obr06_dtregistro;
                    $cllicitemobra->obr06_dtcadastro        = $item->obr06_dtcadastro;
                    $cllicitemobra->obr06_instit            = db_getsession("DB_instit");
                    $cllicitemobra->obr06_ordem             = $item->obr06_ordem;
                    $cllicitemobra->incluir();

                    if ($cllicitemobra->erro_status == 0) {
                        $erro = $cllicitemobra->erro_msg;
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    } else {
                        $oRetorno->status = 1;
                        $oRetorno->message = urlencode("Itens salvo com Sucesso!.");
                    }
                    db_fim_transacao();
                } else {

                    db_fieldsmemory($verificaItem, 0);
                    db_inicio_transacao();
                    $cllicitemobra->obr06_sequencial        = $obr06_sequencial;
                    $cllicitemobra->obr06_pcmater           = $pcmater;
                    $cllicitemobra->obr06_tabela            = $item->obr06_tabela;
                    $cllicitemobra->obr06_descricaotabela   = $item->obr06_descricaotabela;
                    $cllicitemobra->obr06_codigotabela      = $item->obr06_codigotabela;
                    $cllicitemobra->obr06_versaotabela      = $item->obr06_versaotabela;
                    $cllicitemobra->obr06_dtregistro        = $item->obr06_dtregistro;
                    $cllicitemobra->obr06_dtcadastro        = $item->obr06_dtcadastro;
                    $cllicitemobra->obr06_instit            = db_getsession("DB_instit");
                    $cllicitemobra->obr06_ordem             = $item->obr06_ordem;

                    $cllicitemobra->alterar($obr06_sequencial);

                    if ($cllicitemobra->erro_status == 0) {
                        $erro = $cllicitemobra->erro_msg;
                        $oRetorno->message = urlencode($erro);
                        $oRetorno->status = 2;
                    } else {
                        $oRetorno->status = 1;
                        $oRetorno->message = urlencode("Itens salvo com Sucesso!.");
                    }
                    db_fim_transacao();
                }
            }
        } catch (Exception $eErro) {
            $oRetorno->status = 2;
            $oRetorno->message = urlencode($eErro->getMessage());
        }
        break;
    case 'ExcluirItemObra':

        foreach ($oParam->itens as $item) {
            $cllicitemobra = new cl_licitemobra();

            $pcmater = substr($item->obr06_pcmater, 0, -1);
            
            // Hotfix OC21089: Compatibilidade com anos anteriores à adição da ordem
            if ((int) $oParam->ano < 2024) {
                $where = " obr06_pcmater = $pcmater ";
            } else {
                $where = " obr06_pcmater = $pcmater AND obr06_ordem = $item->obr06_ordem ";
            }

            $sql = $cllicitemobra->sql_query_file(null, "obr06_sequencial", null, $where);
            $verificaItem = $cllicitemobra->sql_record($sql);
            if (pg_num_rows($verificaItem) > 0) {
                db_fieldsmemory($verificaItem, 0);
                /*
                 * excluindo item
                 */
                $cllicitemobra->obr06_sequencial = $obr06_sequencial;
                $cllicitemobra->excluir($obr06_sequencial);
                if ($cllicitemobra->erro_status == 0) {
                    $erro = $cllicitemobra->erro_msg;
                    $oRetorno->message = urlencode($erro);
                    $oRetorno->status = 2;
                } else {
                    $oRetorno->itens[] = ((int) $oParam->ano < 2024) ? $item->obr06_pcmater : $item->obr06_pcmater."-".$item->obr06_ordem;
                    $oRetorno->status = 1;
                    $oRetorno->message = urlencode("Itens Excluido com Sucesso!.");
                }
            }
        }
        break;
}

echo $oJson->encode($oRetorno);
