<?php

use ECidade\RecursosHumanos\ESocial\Integracao\ESocial;
use ECidade\RecursosHumanos\ESocial\Integracao\Recurso;
use \ECidade\V3\Extension\Registry;

require_once("interfaces/iTarefa.interface.php");
require_once("model/configuracao/Task.model.php");
require_once("classes/db_esocialenvio_classe.php");
require_once("model/esocial/ImportarDadosEvt5001.model.php");

class FilaESocialTask extends Task implements iTarefa
{
    const LOTE_PROCESSADO_SUCESSO = '201';

    public function iniciar()
    {
        // $job = new \Job();
        // $job->setNome("eSocial_Evento_" . $this->tipoEvento . "_$idFila");

        // $this->setTarefa($job);

        // parent::iniciar();

        if (!isset($_SESSION)) {
            $_SESSION = array();
        }

        $_SESSION['DB_desativar_account'] = true;

        require_once("libs/db_conn.php");
        require_once("libs/db_stdlib.php");
        require_once("libs/db_utils.php");
        require_once("dbforms/db_funcoes.php");
        
        //require_once("libs/db_conecta.php");

        $dao = new \cl_esocialenvio();


        $hostname = gethostname();
        //var_dump($hostname);exit;
        $cmd = shell_exec("cat updatedb/conn | grep -e {$hostname}$");
        $rows        = preg_split('/\s+/', $cmd);
        $rows = array_filter($rows);
        $array_global = array();
        $array_interno = array();
        
        foreach ($rows as $row) {
            if (count($array_interno) <= 3) {
                $array_interno[] = $row;
                if (count($array_interno) == 3) {
                    array_push($array_global, $array_interno);
                    $array_interno = array();
                }
            }
        }

        foreach ($array_global as $row) {
            try {

                /**
                 * Conecta no banco com variaveis definidas no 'libs/db_conn.php'
                 */
                if (!($conn = @pg_connect("host=localhost dbname=$row[0] port=$row[1] user=dbportal password=dbportal"))) {
                    throw new Exception("Erro ao conectar ao banco. host=$DB_SERVIDOR dbname=$row[0] port=$row[1] user=dbportal password=dbportal");
                }

                $sql = $dao->sql_query_file(null, "*", "rh213_sequencial", "rh213_situacao = " . cl_esocialenvio::SITUACAO_NAO_ENVIADO);

                $rs  = \db_query($sql . "\n");

                if (!$rs || pg_num_rows($rs) == 0) {
                    throw new Exception("Agendamento nao encontrado.");
                }
                $dao->setSituacaoProcessando();
                if ($dao->erro_status == "0") {
                    throw new Exception("Erro ao Atualizar agendamentos para o status PROCESSANDO.");
                }
                for ($iCont = 0; $iCont < pg_num_rows($rs); $iCont++) {
                    $this->enviar($conn, \db_utils::fieldsMemory($rs, $iCont));
                }
            } catch (\Exception $e) {
                echo "Erro na execução:\n{$e->getMessage()} \n";
                continue;
            }
        }
    }

    private function enviar($conn, $dadosEnvio)
    {
        try {
            //var_dump('enviar');exit;
            $dao = new \cl_esocialenvio();
            $daoEsocialCertificado = new \cl_esocialcertificado();
            $sql = $daoEsocialCertificado->sql_query(null, "rh214_senha as senha,rh214_certificado as certificado, cgc as nrinsc, z01_nome as nmRazao", "rh214_sequencial", "rh214_cgm = {$dadosEnvio->rh213_empregador}");
            $rsEsocialCertificado  = \db_query($sql);

            if (!$rsEsocialCertificado && pg_num_rows($rsEsocialCertificado) == 0) {
                throw new Exception("Certificado nao encontrado.");
            }
            $dadosCertificado = \db_utils::fieldsMemory($rsEsocialCertificado, 0);
            $dadosCertificado->nmrazao = utf8_encode($dadosCertificado->nmrazao);
            $fase = $this->getFaseEvento($dadosEnvio->rh213_evento);
            $dados = array($dadosCertificado, json_decode($dadosEnvio->rh213_dados), $dadosEnvio->rh213_evento, $dadosEnvio->rh213_ambienteenvio, $fase);

            $exportar = new ESocial(Registry::get('app.config'), "run.php");
            $exportar->setDados($dados);
            //var_dump($exportar);exit;
            
            $retorno = $exportar->request();
            
            //var_dump($exportar->getDescResposta());exit;
            if (!$retorno) {
                throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
            }
            $dao->setSituacaoEnviado($dadosEnvio->rh213_sequencial);
            if ($dao->erro_status == "0") {
                throw new Exception("N?o foi poss?vel alterar situação ENVIADO da fila.");
            }
            
            $dados[] = $exportar->getProtocoloEnvioLote();

            $dao->setProtocolo($dadosEnvio->rh213_sequencial, $exportar->getProtocoloEnvioLote());
            if ($dao->erro_status == "0") {
                throw new Exception("N?o foi poss?vel adicionar o protocolo.");
            }

            /**
             * Esperar alguns segundos pois em muitos casos, o lote ainda n?o havia sido processado
             */
            sleep(15);
            $exportar = new ESocial(Registry::get('app.config'), "consulta.php");
            $exportar->setDados($dados);
            $retorno = $exportar->request();
            //var_dump($retorno);
            if (!$retorno) {
                throw new Exception("Erro ao buscar processamento do envio. \n {$exportar->getDescResposta()}");
            }
            //var_dump($exportar->getCdRespostaProcessamento());exit;
            if ($exportar->getCdRespostaProcessamento() != self::LOTE_PROCESSADO_SUCESSO) {
                throw new Exception($exportar->getCdRespostaProcessamento(). " Erro no processamento do lote. " . utf8_decode($exportar->getDescRespostaProcessamento()));
            }

            $this->incluirRecido($dadosEnvio->rh213_sequencial, $exportar->getNumeroRecibo());
            $this->importarEvtRetorno($exportar->getObjXmlEvtRetorno(), $dadosEnvio);
            echo "{$exportar->getDescResposta()} Recibo de Envio {$exportar->getNumeroRecibo()}";
        } catch (\Exception $e) {
            $dao->setSituacaoErroEnvio($dadosEnvio->rh213_sequencial, $e->getMessage());
            if ($dao->erro_status == "0") {
                echo "Erro na execução:\n Não foi possível alterar situação NAO ENVIADO da fila. \n {$dao->erro_msg}";
            }
            echo "Erro na execução:\n{$e->getMessage()} \n";
        }
    }

    public function consultar()
    {
        if (!isset($_SESSION)) {
            $_SESSION = array();
        }

        $_SESSION['DB_desativar_account'] = true;

        require_once("libs/db_conn.php");
        require_once("libs/db_stdlib.php");
        require_once("libs/db_utils.php");
        require_once("dbforms/db_funcoes.php");

        $hostname = gethostname();
        $cmd = shell_exec("cat updatedb/conn | grep -e {$hostname}$");
        $rows        = preg_split('/\s+/', $cmd);
        $rows = array_filter($rows);
        $array_global = array();
        $array_interno = array();

        foreach ($rows as $row) {
            if (count($array_interno) <= 3) {
                $array_interno[] = $row;
                if (count($array_interno) == 3) {
                    array_push($array_global, $array_interno);
                    $array_interno = array();
                }
            }
        }

        foreach ($array_global as $row) {
            try {

                /**
                 * Conecta no banco com variaveis definidas no 'libs/db_conn.php'
                 */
                if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$row[0] port=$row[1] user=dbportal password=dbportal"))) {
                    throw new Exception("Erro ao conectar ao banco. host=$DB_SERVIDOR dbname=$row[0] port=$row[1] user=dbportal password=dbportal");
                }

                $dao = new \cl_esocialenvio();

                $daoEsocialCertificado = new \cl_esocialcertificado();
                $sql = $daoEsocialCertificado->sql_query(null, "rh214_senha as senha,rh214_certificado as certificado, z01_cgccpf as nrinsc, z01_nome as nmRazao", "rh214_sequencial");
                $rsEsocialCertificado  = \db_query($sql);

                if (!$rsEsocialCertificado && pg_num_rows($rsEsocialCertificado) == 0) {
                    throw new Exception("Certificado nao encontrado.");
                }

                $dadosCertificado = \db_utils::fieldsMemory($rsEsocialCertificado, 0);

                $dadosCertificado->nmrazao = utf8_encode($dadosCertificado->nmrazao);

                $sql = $dao->sql_query_file(null, "*", "rh213_sequencial", "rh213_situacao = " . cl_esocialenvio::SITUACAO_ERRO_ENVIO);

                $rs  = \db_query($sql . "\n");

                if (!$rs || pg_num_rows($rs) == 0) {
                    //throw new Exception("Agendamento nao encontrado.");
                    echo "Agendamento n?o encontrado.";
                    continue;
                }

                for ($iCont = 0; $iCont < pg_num_rows($rs); $iCont++) {
                    $dadosConsulta = \db_utils::fieldsMemory($rs, $iCont);
                    $fase = $this->getFaseEvento($dadosConsulta->rh213_evento);
                    $dados = array($dadosCertificado, json_decode($dadosConsulta->rh213_dados), $dadosConsulta->rh213_evento, $dadosConsulta->rh213_ambienteenvio, $fase);

                    $dados[] = $dadosConsulta->rh213_protocolo;
                    $exportar = new ESocial(Registry::get('app.config'), "consulta.php");

                    $exportar->setDados($dados);
                    $retorno = $exportar->request();

                    if (!$retorno) {
                        throw new Exception("Erro ao buscar processamento do envio. \n {$exportar->getDescResposta()}");
                    }

                    if ($exportar->getCdRespostaProcessamento() != self::LOTE_PROCESSADO_SUCESSO) {
                        throw new Exception("Erro no processamento do lote. " . utf8_decode($exportar->getDescRespostaProcessamento()));
                    }

                    $this->incluirRecido($dadosConsulta->rh213_sequencial, $exportar->getNumeroRecibo());
                    $this->importarEvtRetorno($exportar->getObjXmlEvtRetorno(), $dadosConsulta);
                    echo "{$exportar->getDescResposta()} Recibo de Envio {$exportar->getNumeroRecibo()}";
                }
            } catch (\Exception $e) {
                echo "Erro na execução:\n{$e->getMessage()} \n";
            }
        }
    }

    public function cancelar()
    {
    }

    public function abortar()
    {
    }

    public function incluirRecido($codigoEsocialEnvio, $numeroRecibo)
    {
        $daoEsocialRecibo = new \cl_esocialrecibo();
        $daoEsocialRecibo->rh215_esocialenvio = $codigoEsocialEnvio;
        $daoEsocialRecibo->rh215_recibo       = $numeroRecibo;
        $daoEsocialRecibo->rh215_dataentrega  = date("Y-m-d H:i:s");
        $daoEsocialRecibo->incluir();
        if ($daoEsocialRecibo->erro_status == 0) {
            die("N?o foi poss?vel incluir recibo {$numeroRecibo}. \n" . $daoEsocialRecibo->erro_msg);
        }
    }

    private function getFaseEvento($evento)
    {
        $arrEvtIniciais = array('S1000', 'S1005', 'S1010', 'S1020', 'S1070');
        $arrEvtPeriodicos = array('S1200', 'S1202', 'S1207', 'S1210', 'S1260', 'S1270', 'S1280', 'S1298', 'S1299');
        $arrEvtNaoPeriodicos = array('S2190', 'S2299', 'S2306', 'S2230', 'S2231', 'S2298', 'S2200', 'S2205', 'S2206', 'S2399', 'S2400', 'S2405', 'S2410', 'S2416', 'S2418', 'S2420', 'S3000', 'S5001', 'S2300', 'S5003', 'S5011', 'S5013', 'S5002');
        if (in_array("S{$evento}", $arrEvtIniciais)) {
            return 1;
        }
        if (in_array("S{$evento}", $arrEvtNaoPeriodicos)) {
            return 2;
        }
        if (in_array("S{$evento}", $arrEvtPeriodicos)) {
            return 3;
        }
        throw new Exception("N?o foi poss?vel encontrar a fase deste evento.");
    }

    private function importarEvtRetorno($oXml, $dadosEvento)
    {
        if (in_array($dadosEvento->rh213_evento, array("1200", "2299", "2399"))) {
            $this->importarEvt5001($oXml, $dadosEvento);
        }
        if (in_array($dadosEvento->rh213_evento, array("1299"))) {
            $this->importarEvt5011($oXml, $dadosEvento);
        }
    }

    private function importarEvt5001($oXml, $dadosEvento)
    {
        $oImportarDadosEvt5001 = new ImportarDadosEvt5001(null, $oXml, $dadosEvento);
        $oImportarDadosEvt5001->processar();
    }

    private function importarEvt5011($oXml, $dadosEvento)
    {
        $oImportarDadosEvt5011 = new ImportarDadosEvt5011(null, $oXml, $dadosEvento);
        $oImportarDadosEvt5011->processar();
    }
}