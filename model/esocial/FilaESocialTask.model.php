<?php

use ECidade\RecursosHumanos\ESocial\Integracao\ESocial;
use ECidade\RecursosHumanos\ESocial\Integracao\Recurso;
use \ECidade\V3\Extension\Registry;

require_once ("interfaces/iTarefa.interface.php");
require_once ("model/configuracao/Task.model.php");
require_once ("classes/db_esocialenvio_classe.php");

class FilaESocialTask extends Task implements iTarefa
{
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

        require_once ("libs/db_conn.php");
        require_once ("libs/db_stdlib.php");
        require_once ("libs/db_utils.php");
        require_once ("dbforms/db_funcoes.php");

        try {

            /**
             * Conecta no banco com variaveis definidas no 'libs/db_conn.php'
             */
            if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
                die("\nErro ao conectar ao banco. host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA \n");
            }

            $dao = new \cl_esocialenvio();
            $sql = $dao->sql_query_file(null, "*", "rh213_sequencial", "rh213_situacao = 1");
            
            $rs  = \db_query($sql."\n");

            if (!$rs && pg_num_rows($rs) == 0) {
                die("Agendamento nao encontrado. \n");
            }
            for ($iCont=0; $iCont < pg_num_rows($rs); $iCont++) { 
                
                $dadosEnvio = \db_utils::fieldsMemory($rs, $iCont);

                $daoEsocialCertificado = new \cl_esocialcertificado();
                $sql = $daoEsocialCertificado->sql_query(null, "rh214_senha as senha,rh214_certificado as certificado, z01_cgccpf as nrinsc, z01_nome as nmRazao", "rh214_sequencial", "rh214_cgm = {$dadosEnvio->rh213_empregador}");
                $rsEsocialCertificado  = \db_query($sql."\n");

                if (!$rsEsocialCertificado && pg_num_rows($rsEsocialCertificado) == 0) {
                    die("Certificado nao encontrado. \n");
                }
                $dadosCertificado = \db_utils::fieldsMemory($rsEsocialCertificado, 0);
                $dadosCertificado->nmrazao = utf8_encode($dadosCertificado->nmrazao); 
                $dados = array($dadosCertificado,json_decode($dadosEnvio->rh213_dados));

                // $sRecurso = Recurso::getRecursoByEvento($dadosEnvio->rh213_evento);

                $exportar = new ESocial(Registry::get('app.config'));
                $exportar->setDados($dados);
                $retorno = $exportar->request();
                echo "<br> \n ";
            $dao->rh213_situacao = 2;
            $dao->rh213_sequencial = $dadosEnvio->rh213_sequencial;
            $dao->alterar($dadosEnvio->rh213_sequencial);

            if ($dao->erro_status == 0) {
                die("Não foi possível alterar situação da fila. \n");
            }
            }
        } catch (\Exception $e) {
            $this->log("Erro na execução:\n{$e->getMessage()} - ");
        }
        // parent::terminar();
    }

    public function cancelar()
    {
    }

    public function abortar()
    {
    }
}
