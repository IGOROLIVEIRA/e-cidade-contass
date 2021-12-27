<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;

class Evento
{

    /**
     * C�digo do Evento do eSocial
     *
     * @var integer
     */
    private $tipoEvento;

    /**
     * C�digo do empregador
     *
     * @var integer
     */
    private $empregador;

    /**
     * C�digo do responsavel pelo evento
     * @var mixed
     */
    private $responsavelPreenchimento;

    /**
     * Dados do Evento
     *
     * @var \stdClass
     */
    private $dado;

    /**
     * md5 do objeto salvo
     *
     * @var string
     */
    private $md5;

    /**
     * Ambiente Envio
     *
     * @var integer
     */
    private $tpAmb;

    /**
     * In�cio Validade das informa��es
     *
     * @var string
     */
    private $iniValid;

    /**
     * modo
     *
     * @var string
     */
    private $modo;

    /**
     * Undocumented function
     *
     * @param integer $tipoEvento
     * @param integer $empregador
     * @param string $responsavelPreenchimento
     * @param \stdClass $dados
     */
    public function __construct($tipoEvento, $empregador, $responsavelPreenchimento, $dado, $tpAmb, $iniValid, $modo)
    {
        /**
         * @todo pesquisar exite na fila um evento do tipo: $tipoEvento para o : $responsavelPreenchimento
         * @todo N�o existido, cria uma agenda e inclui na tabela
         * @todo se houver e os $dados forem iguais ( usar md5 ), desconsidera
         * @todo se houver e os $dados forem diferentes ( usar md5 ), altera / inclui novo registro e reagenda
         *
         */
        $this->tipoEvento               = str_replace('S', '', $tipoEvento);
        $this->empregador               = $empregador;
        $this->responsavelPreenchimento = $responsavelPreenchimento;
        $this->dado                     = $dado;
        $this->tpAmb                    = $tpAmb;
        $this->iniValid                 = $iniValid;
        $this->modo                     = $modo;

        $dado = json_encode(\DBString::utf8_encode_all($this->dado));
        if (is_null($dado)) {
            throw new \Exception("Erro ao codificar dados para envio.");
        }
        $this->md5 = md5($dado);
    }

    public function adicionarFila()
    {
        $where = array(
            "rh213_evento = {$this->tipoEvento}",
            "rh213_empregador = {$this->empregador}",
            "rh213_responsavelpreenchimento = '{$this->responsavelPreenchimento}'",
        );

        $where = implode(" and ", $where);
        $dao   = new \cl_esocialenvio();
        $sql   = $dao->sql_query_file(null, "*", null, $where);
        $rs    = db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar registros do evento para verifica��o.");
        }

        if (pg_num_rows($rs) > 0 && $this->modo === 'INC') {
            $md5Evento = \db_utils::fieldsMemory($rs, 0)->rh213_md5;
            if ($md5Evento == $this->md5) {
                throw new \Exception("J� existe um envio do evento S-{$this->tipoEvento} com as mesmas informa��es.");
            }
        }
        $this->adicionarEvento();
        return true;
    }

    /**
     *
     *
     * @param integer $codigo
     */
    private function adicionarEvento()
    {
        $dados                                          = $this->montarDadosAPI();
        $daoFilaEsocial                                 = new \cl_esocialenvio();
        $daoFilaEsocial->rh213_evento                   = $this->tipoEvento;
        $daoFilaEsocial->rh213_empregador               = $this->empregador;
        $daoFilaEsocial->rh213_responsavelpreenchimento = $this->responsavelPreenchimento;
        $daoFilaEsocial->rh213_ambienteenvio            = $this->tpAmb;

        $daoFilaEsocial->rh213_dados    = pg_escape_string(json_encode(\DBString::utf8_encode_all($dados)));
        $daoFilaEsocial->rh213_md5      = $this->md5;
        $daoFilaEsocial->rh213_situacao = \cl_esocialenvio::SITUACAO_NAO_ENVIADO;
        $daoFilaEsocial->rh213_dataprocessamento = date('Y-m-d h:i:s');

        if (is_object($dados) || count($dados) > 0) {
            $daoFilaEsocial->incluir(null);
            if ($daoFilaEsocial->erro_status == 0) {
                throw new \Exception("N�o foi poss�vel adicionar na fila. \n {$daoFilaEsocial->erro_msg}");
            }
        }

        $this->adicionarTarefa($daoFilaEsocial->rh213_sequencial);
    }

    /**
     * Cria o job
     *
     * @param integer $idFila
     */
    private function adicionarTarefa($idFila)
    {
        $job = new \Job();
        $job->setNome("eSocial_Evento_" . $this->tipoEvento . "_$idFila");
        $job->setCodigoUsuario(1);
        $time = new \DateTime();
        $job->setMomentoCricao($time->modify('+ 1 minute')->getTimestamp());
        $job->setDescricao('Evento eSocial ' . $this->tipoEvento);
        $job->setNomeClasse('FilaESocialTask');
        $job->setTipoPeriodicidade(\Agenda::PERIODICIDADE_UNICA);
        $job->adicionarParametro("id_fila", $idFila);
        $job->setCaminhoPrograma('model/esocial/FilaESocialTask.model.php');
        $job->salvar();
    }

    /**
     * Retorna dados para envio no formato requerido conforme cada Evento
     *
     * @param array stdClass
     */
    private function montarDadosAPI()
    {
        $sNomeClasse = "\ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoS" . $this->tipoEvento;
        $evento = new $sNomeClasse($this->dado);
        $evento->setIniValid($this->iniValid);
        $evento->setModo($this->modo);
        if (!is_object($evento)) {
            throw new \Exception("Objeto S{$this->tipoEvento} n�o encontrado.");
        }
        return $evento->montarDados();
    }
}
