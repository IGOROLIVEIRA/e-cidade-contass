<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;

class Evento
{

    /**
     * Código do Evento do eSocial
     *
     * @var integer
     */
    private $tipoEvento;

    /**
     * Código do empregador
     *
     * @var integer
     */
    private $empregador;

    /**
     * Código do responsavel pelo evento
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
     * Undocumented function
     *
     * @param integer $tipoEvento
     * @param integer $empregador
     * @param string $responsavelPreenchimento
     * @param \stdClass $dados
     */
    public function __construct($tipoEvento, $empregador, $responsavelPreenchimento, $dado)
    {
        /**
         * @todo pesquisar exite na fila um evento do tipo: $tipoEvento para o : $responsavelPreenchimento
         * @todo Não existido, cria uma agenda e inclui na tabela
         * @todo se houver e os $dados forem iguais ( usar md5 ), desconsidera
         * @todo se houver e os $dados forem diferentes ( usar md5 ), altera / inclui novo registro e reagenda
         *
         */
        $this->tipoEvento = $tipoEvento;
        $this->empregador = $empregador;
        $this->responsavelPreenchimento = $responsavelPreenchimento;
        $this->dado = $dado;

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
            "rh213_responsavelpreenchimento = '{$this->responsavelPreenchimento}'"
        );

        $where = implode(" and ", $where);
        $dao = new \cl_esocialenvio();
        $sql = $dao->sql_query_file(null, "*", null, $where);
        $rs = db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar registros.");
        }

        if (pg_num_rows($rs) == 1) {
            $md5Evento = \db_utils::fieldsMemory($rs, 0)->rh213_md5;
            if ($md5Evento == $this->md5) {
                return false;
            }
        }
        $codigoFila = pg_num_rows($rs) == 0 ? null : \db_utils::fieldsMemory($rs, 0)->rh213_sequencial;
        $this->adicionarEvento($codigoFila);

        return true;
    }

    /**
     *
     *
     * @param integer $codigo
     */
    private function adicionarEvento($codigo = null)
    {
        $aDadosRubricas = $this->montarDadosAPI();
        $daoFilaEsocial = new \cl_esocialenvio();
        $daoFilaEsocial->rh213_sequencial = $codigo;
        $daoFilaEsocial->rh213_evento = $this->tipoEvento;
        $daoFilaEsocial->rh213_empregador = $this->empregador;
        $daoFilaEsocial->rh213_responsavelpreenchimento = $this->responsavelPreenchimento;
        
        $daoFilaEsocial->rh213_dados = pg_escape_string(json_encode(\DBString::utf8_encode_all($aDadosRubricas)));
        $daoFilaEsocial->rh213_md5 = $this->md5;
        $daoFilaEsocial->rh213_situacao = 1;

        if(count($aDadosRubricas) > 0) {
            
            if (empty($codigo)) {
                $daoFilaEsocial->incluir(null);
            } else {
                $daoFilaEsocial->alterar($codigo);
            }

            if ($daoFilaEsocial->erro_status == 0) {
                throw new \Exception("Não foi possível adicionar na fila.");
            }

        }
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
    private function montarDadosAPI() {
        switch ($this->tipoEvento) {
            case Tipo::S1000:
                return $this->montarDadosS1000API();
                break;
            case Tipo::S1005:
                return $this->montarDadosS1005API();
                break;
            case Tipo::S1010:
                return $this->montarDadosS1010API();
                break;
            case Tipo::SERVIDOR:
                break;
            default:
                throw new \Exception('Tipo de fomulário não encontrado.');
        }
    }

    private function montarDadosS1000API() {

        if ($this->tipoEvento != 1000) {
            return $this->dado;
        }
        if (empty($this->dado->infoCadastro->nrRegEtt)) {
            $this->dado->infoCadastro->nrRegEtt = NULL;
        }
        
        if (empty($this->dado->infoEFR->ideEFR) || $this->dado->infoEFR->ideEFR == "S") {
            $this->dado->infoEFR->cnpjEFR = NULL;
        }
        if (empty($this->dado->infoEnte->nmEnte)) {
            unset($this->dado->infoEnte);
        }

        $oDadosAPI = new \stdClass;
        $oDadosAPI->evtInfoEmpregador = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->sequencial = 1;
        $oDadosAPI->evtInfoEmpregador->modo = "INC";
        $oDadosAPI->evtInfoEmpregador->ideperiodo   = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->ideperiodo->inivalid = '2017-01';
        $oDadosAPI->evtInfoEmpregador->infoCadastro = $this->dado->infoCadastro;
        $oDadosAPI->evtInfoEmpregador->dadosIsencao = empty($this->dado->dadosIsencao) ? new \stdClass : $this->dado->dadosIsencao;
        $oDadosAPI->evtInfoEmpregador->contato      = $this->dado->contato;
        $oDadosAPI->evtInfoEmpregador->infoOP       = $this->dado->infoOP;
        $oDadosAPI->evtInfoEmpregador->infoEFR      = $this->dado->infoEFR;

        $oDadosAPI->evtInfoEmpregador->softwareHouse[0] = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->softwareHouse[0]->cnpjSoftHouse = '00000000000000';
        $oDadosAPI->evtInfoEmpregador->softwareHouse[0]->nmRazao = 'Contass Contabilidade e Consultoria Ltda';
        $oDadosAPI->evtInfoEmpregador->softwareHouse[0]->nmCont = 'Ivan Fonseca de Oliveira Junior';
        $oDadosAPI->evtInfoEmpregador->softwareHouse[0]->telefone = "3832185900";
        $oDadosAPI->evtInfoEmpregador->softwareHouse[0]->email = "contass@contassconsultoria.com.br";

        $oDadosAPI->evtInfoEmpregador->infoComplementares = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->infoComplementares->situacaoPJ = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->infoComplementares->situacaoPJ->indSitPJ = 0;

        return $oDadosAPI;

    }

    private function montarDadosS1005API() {

        if (empty($this->dado->dadosEstab->aliqGilrat->procAdmJudRat->tpProc)) {
            unset($this->dado->dadosEstab->aliqGilrat->procAdmJudRat);
        }
        if (empty($this->dado->dadosEstab->aliqGilrat->procAdmJudFap->tpProc)) {
            unset($this->dado->dadosEstab->aliqGilrat->procAdmJudFap);
        }
        
        if ($this->dado->dadosEstab->infoTrab->infoApr->contApr == 0) {
            $this->dado->dadosEstab->infoTrab->infoApr->nrProcJud = NULL;
            unset($this->dado->dadosEstab->infoTrab->infoApr->contEntEd);
            unset($this->dado->dadosEstab->infoTrab->infoApr->infoEntEduc);
        }

        if ($this->dado->dadosEstab->infoTrab->infoPCD->contPCD == 0) {
            $this->dado->dadosEstab->infoTrab->infoPCD->nrProcJud = NULL;
        }

        $oDadosAPI = new \stdClass;
        $oDadosAPI->evtTabEstab = new \stdClass;
        $oDadosAPI->evtTabEstab->sequencial = 1;
        $oDadosAPI->evtTabEstab->tpInsc = $this->dado->ideEstab->tpInsc;
        $oDadosAPI->evtTabEstab->nrInsc = $this->dado->ideEstab->nrInsc;
        $oDadosAPI->evtTabEstab->iniValid = $this->dado->ideEstab->iniValid;
        $oDadosAPI->evtTabEstab->modo = "INC";
        $oDadosAPI->evtTabEstab->dadosEstab   = $this->dado->dadosEstab;

        return $oDadosAPI;

    }

    private function montarDadosS1010API() {

        $aDadosAPI = array();
        foreach ($this->dado as $iKey => $oDado) {
            if (!isset($oDado->dadosRubrica->natRubr)) {
                continue;
            }
            $oDadosAPI = new \stdClass;
            $oDadosAPI->evtTabRubrica = new \stdClass;
            $oDadosAPI->evtTabRubrica->sequencial = $iKey;
            $oDadosAPI->evtTabRubrica->codRubr = $oDado->ideRubrica->codRubr;
            $oDadosAPI->evtTabRubrica->ideTabRubr = $oDado->ideRubrica->ideTabRubr;
            $oDadosAPI->evtTabRubrica->inivalid = $oDado->ideRubrica->iniValid;
            if(!empty($oDado->ideRubrica->fimValid)) {
                $oDadosAPI->evtTabRubrica->fimvalid = $oDado->ideRubrica->fimValid;
            }
            $oDadosAPI->evtTabRubrica->modo = 'INC';
            $oDadosAPI->evtTabRubrica->dadosRubrica = $oDado->dadosRubrica;
            if (!empty($oDado->ideProcessoCP->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoCP = $oDado->ideProcessoCP;
            }
            if (!empty($oDado->ideProcessoIRRF->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoIRRF = $oDado->ideProcessoIRRF;
            }
            if (!empty($oDado->ideProcessoFGTS->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoFGTS = $oDado->ideProcessoFGTS;
            }
            if (!empty($oDado->ideProcessoSIND->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoSIND = $oDado->ideProcessoSIND;
            }
            $aDadosAPI[] = $oDadosAPI;
        }

        return $aDadosAPI;
    }
}
