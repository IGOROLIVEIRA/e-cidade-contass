<?php

use ECidade\RecursosHumanos\ESocial\Integracao\ESocial;
use ECidade\RecursosHumanos\ESocial\Integracao\Recurso;
use \ECidade\V3\Extension\Registry;

require_once("interfaces/iTarefa.interface.php");
require_once("model/configuracao/Task.model.php");
require_once("classes/db_esocialenvio_classe.php");

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
                    throw new Exception("Erro ao conectar ao banco. host=localhost dbname=$row[0] port=$row[1] user=dbportal password=dbportal");
                }

                $sql = $dao->sql_query_file(null, "*", "rh213_sequencial", "rh213_situacao = " . cl_esocialenvio::SITUACAO_NAO_ENVIADO);

                $rs  = \db_query($sql . "\n");

                if (!$rs || pg_num_rows($rs) == 0) {
                    //throw new Exception("Agendamento nao encontrado.");
                    echo "Agendamento não encontrado.";
                    var_dump($row);
                    continue;
                }
                $dao->setSituacaoProcessando();
                if ($dao->erro_status == "0") {
                    //throw new Exception("Erro ao Atualizar agendamentos para o status PROCESSANDO.");
                    echo "Erro ao Atualizar agendamentos para o status PROCESSANDO.";
                    var_dump($row);
                    continue;
                }
                for ($iCont = 0; $iCont < pg_num_rows($rs); $iCont++) {
                    $this->enviar($conn, \db_utils::fieldsMemory($rs, $iCont));
                }
            } catch (\Exception $e) {
                die("Erro na execução:\n{$e->getMessage()} \n");
            }
        }
    }

    private function enviar($conn, $dadosEnvio)
    {

        try {

            $dao = new \cl_esocialenvio();
            $daoEsocialCertificado = new \cl_esocialcertificado();
            $sql = $daoEsocialCertificado->sql_query(null, "rh214_senha as senha,rh214_certificado as certificado, z01_cgccpf as nrinsc, z01_nome as nmRazao", "rh214_sequencial", "rh214_cgm = {$dadosEnvio->rh213_empregador}");
            $rsEsocialCertificado  = \db_query($sql);

            if (!$rsEsocialCertificado && pg_num_rows($rsEsocialCertificado) == 0) {
                throw new Exception("Certificado nao encontrado.");
            }
            $dadosCertificado = \db_utils::fieldsMemory($rsEsocialCertificado, 0);
            $dadosCertificado->nmrazao = utf8_encode($dadosCertificado->nmrazao);
            $dados = array($dadosCertificado, json_decode($dadosEnvio->rh213_dados), $dadosEnvio->rh213_evento, $dadosEnvio->rh213_ambienteenvio);

            $exportar = new ESocial(Registry::get('app.config'), "run.php");
            $exportar->setDados($dados);
            $retorno = $exportar->request();

            if (!$retorno) {
                throw new Exception("Erro no envio das informações. \n {$exportar->getDescResposta()}");
            }
            $dao->setSituacaoEnviado($dadosEnvio->rh213_sequencial);
            if ($dao->erro_status == "0") {
                throw new Exception("Não foi possível alterar situação ENVIADO da fila.");
            }

            $dados[] = $exportar->getProtocoloEnvioLote();
            $exportar = new ESocial(Registry::get('app.config'), "consulta.php");
            $exportar->setDados($dados);
            $retorno = $exportar->request();
            if (!$retorno) {
                throw new Exception("Erro ao buscar processamento do envio. \n {$exportar->getDescResposta()}");
            }

            if ($exportar->getCdRespostaProcessamento() != self::LOTE_PROCESSADO_SUCESSO) {
                throw new Exception("Erro no processamento do lote. " . utf8_decode($exportar->getDescRespostaProcessamento()));
            }

            $this->incluirRecido($dadosEnvio->rh213_sequencial, $exportar->getNumeroRecibo());
            echo "{$exportar->getDescResposta()} Recibo de Envio {$exportar->getNumeroRecibo()}";
        } catch (\Exception $e) {
            $dao->setSituacaoErroEnvio($dadosEnvio->rh213_sequencial, $e->getMessage());
            if ($dao->erro_status == "0") {
                echo "Erro na execução:\n Não foi possível alterar situação NAO ENVIADO da fila. \n {$dao->erro_msg}";
            }
            echo "Erro na execução2:\n{$e->getMessage()} \n";
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
        $daoEsocialRecibo->rh215_recibo = $numeroRecibo;
        $daoEsocialRecibo->rh215_dataentrega = date("Y-m-d H:i:s");
        $daoEsocialRecibo->incluir();
        if ($daoEsocialRecibo->erro_status == 0) {
            die("Não foi possível incluir recibo {$numeroRecibo}. \n" . $daoEsocialRecibo->erro_msg);
        }
    }
}
