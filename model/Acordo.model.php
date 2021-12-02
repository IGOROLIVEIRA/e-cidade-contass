<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once('model/empenho/AutorizacaoEmpenho.model.php');

/**
 * controle de acordos/contratos
 * @package Contratos
 */
class Acordo
{

    const ORIGEM_PROCESSO_COMPRAS = 1;
    const ORIGEM_LICITACAO = 2;
    const ORIGEM_MANUAL = 3;
    const ORIGEM_EMPENHO = 6;
    const TIPO_ADITAMENTO_REEQUILIBRIO = 2;
    const TIPO_ADITAMENTO_QUANTIDADE_VALOR = 4;

    const CONTRATO_ATIVO = 1;
    const CONTRATO_RESCINDIDO = 2;
    const CONTRATO_CANCELADO = 3;
    const CONTRATO_HOMOLOGADO = 4;
    const CONTRATO_PARALISADO = 5;

    /**
     * Caminho das mensagens do model
     */
    const MENSAGENS = "patrimonial.contratos.Acordo.";

    /**
     * Codigo do acordo;
     *
     * @var integer
     */
    protected $iCodigoAcordo;

    /**
     * Data da inclusão do acordo
     *
     * @var string
     */
    protected $sDataInclusao;

    /**
     * Data inicial do acordo acordo.ac16_datainicio
     *
     * @var string
     */
    protected $sDataInicial;

    /**
     * Data final do acordo acordo.ac16_datatermino
     *
     * @var string
     */
    protected $sDataFinal;

    /**
     * Contratado (numcgm) ac16_contratado
     *
     * @var integer
     */
    protected $oContratado;

    /**
     * Penalidades prevista no contrato
     *
     * @var acordoPenalidade collection
     */

    protected $aPenalidades = array();

    /**
     * Empenhos vinculados ao acordo
     * @var array
     * @access protected
     */
    protected $aEmpenhos = array();

    /**
     * Licitacoes vinculadas ao acordo
     * @var array
     * @access protected
     */
    protected $aLicitacoes = array();


    /**
     * Processos de compras vinculados ao acordo
     * @var array
     * @access protected
     */
    protected $aProcessosDeCompras = array();

    /**
     * garantias previstas no contrato
     *
     * @var acordoGarantia collection
     */
    protected $aGarantias = array();

    /**
     * Codigo do grupo de contrato ac16_acordogrupo
     *
     * @var integer
     */
    protected $iGrupo;

    /**
     * Codigo do departamento que gerou o contrato
     *
     * @var integer
     */
    protected $iDepartamento;

    /**
     * instituicao que gerou o contrato
     *
     * @var integer
     */
    protected $iInstit;

    /**
     * Ano de origem do contrato;
     *
     * @var integer
     */
    protected $iAno;

    /**
     * Data de assinatura do contrato.
     *
     * @var string
     */
    protected $sDataAssinatura;

    /**
     * Data da publicacao do contrato
     *
     * @var string
     */
    protected $sDataPublicacao;

    /**
     * texto com o objeto do contrato
     *
     * @var string
     *
     */
    protected $sObjeto;

    /**
     * resumo do cobjeto do contrato
     *
     * @var string
     */
    protected $sResumoObjeto;

    /**
     * Comissão de vistoria do contrato
     *
     * @var acordoComissão
     */
    protected $oComissao;

    /**
     * Departamento Responsável pelo contrato
     *
     * @var integer
     */
    protected $iDepartamentoResponsavel;

    /**
     * numero da lei
     *
     * @var string
     */
    protected $sLei;

    /**
     * numero da lei
     *
     * @var string
     */
    protected $sDescricaoLei;

    /**
     * número do processo
     *
     * @var string
     */
    protected $sProcesso;

    /**
     * forma de fornecimento
     *
     * @var string
     */
    protected $sFormaFornecimento;

    /**
     * veiculo de divulgação
     *
     * @var string
     */
    protected $sVeiculoDivulgacao;

    /**
     * forma de pagamento
     *
     * @var string
     */
    protected $sFormaPagamento;

    /**
     * Cpf do Signatario Contratante
     * @var string
     */
    protected $sCpfsignatariocontratante;

    /**
     * situação do contrato
     *
     * @var integer
     */
    protected $iSituacao;

    /**
     * Numero do contrato no grupo
     *
     * @var integer
     */
    protected $iNumero;

    /**
     * Numero anual do contrato
     *
     * @var integer
     */
    protected $iNumeroAcordo;

    /**
     * Origem do contrato
     *
     * @var integer
     */
    protected $iOrigem;

    /**
     * Tipo da Origem do contrato
     *
     * @var integer
     */
    protected $iTipoOrigem;

    /**
     * dotacoes do contrato
     *
     * @var array
     */
    protected $aDotacoes = array();

    /**
     * Quantidade de renovacoes em dias/meses
     *
     * @var integer
     */
    protected $iQuantidadeRenovacao;

    /**
     * Tipo da renovacao 1 = Meses 2 Dias
     *
     * @var integer
     */
    protected $iTipoRenovacao;

    protected $oUltimaPosicao;

    /**
     * contrato em caracter emergencial
     *
     * @var bool
     */
    protected $lEmergencial;

    protected $aPosicoes = array();
    /**
     * Retorna Descricao do tipo
     */
    protected $sDesricaoTipo;
    /**
     * Retorna Descricao da Situacao
     */
    protected $sDesricaoSituacao;

    /**
     * @var array
     */
    protected $aDocumento = array();

    /**
     * se o acordo tera periodos de mes comercial
     */
    protected $lPeriodoComercial;

    /**
     * Valor referente ao campo ac16_qtdperiodo
     * Unidade em (dia/mês) de acordo com $iTipoUnidadeTempoVigencia
     * @var integer
     */
    private $iQtdPeriodoVigencia;

    /**
     * Represta o campo ac16_tipounidtempoperiodo que define:
     * 1 - Mês
     * 2 - Dia
     * @var integer
     */
    private $iTipoUnidadeTempoVigencia;

    /**
     * Categoria do acordo
     * @var integer
     */
    private $iCategoriaAcordo;

    /**
     * Data inicial do periodo de vigencia original
     * @var DBDate
     */
    private $dtDataInicialVigenciaOriginal;

    /**
     * Data Final do periodo de vigencia original
     * @var DBDate
     */
    private $dtDataFinalVigenciaOriginal;

    /**
     * Paralizacoes do Contrato
     * @var AcordoParalisacao[]
     */
    private $aParalisacoes = array();

    /**
     * Código da classificacao do acordo
     */
    private $iClassificacao;

    /**
     * Classificacao do acordo
     * @var AcordoClassificacao
     */
    private $oClassificacao;

    /**
     * valor do contrato
     * @var number
     */
    private $nValorContrato;

    /**
     * licitacao para origem manual
     * @var
     */

    protected $iLicitacao;

    /**
     * licitacao de outros orgaos
     * @var
     */
    protected $iLicoutroorgao;

    /**
     * licitacao de outros orgaos
     * @var
     */

    protected $iAdesaoregpreco;

    /**
     * Modalidade
     * @var
     */

    protected $iModalidade;

    /**
     * Tipo
     * @var
     */

    protected $sTipo;
    /**
    *  Tipo cadastros
    */
    protected $iTipocadastro;

    /**
     * Data Rescisao do acordo acordo.ac16_datarescisao
     * @var string
     */
    private $sDataRescisao;


    /**
     * Valor da Rescisao do acordo acordo.ac16_valorrescisao
     * @var float
     */
    private $nValorRescisao;


    /**
     * Situacao da vigência do acordo acordo.ac16_semvigencia
     * @var boolean
     */
    private $lSituacaoVigencia;

    /**
     * Valor da providência do acordo acordo.ac16_providencia
     * @var integer
     */
    private $lProvidencia;

    /**
     * @return mixed
     */
    public function getiLicoutroorgao()
    {
        return $this->iLicoutroorgao;
    }

    /**
     * @param mixed $iLicoutroorgao
     */
    public function setiLicoutroorgao($iLicoutroorgao)
    {
        $this->iLicoutroorgao = $iLicoutroorgao;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getiAdesaoregpreco()
    {
        return $this->iAdesaoregpreco;
    }

    /**
     * @param mixed $iAdesaoregpreco
     */
    public function setiAdesaoregpreco($iAdesaoregpreco)
    {
        $this->iAdesaoregpreco = $iAdesaoregpreco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->sTipo;
    }

    /**
     * @param mixed $sTipo
     */
    public function setTipo($sTipo)
    {
        $this->sTipo = $sTipo;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getModalidade()
    {
        return $this->iModalidade;
    }

    /**
     * @param mixed $iModalidade
     */
    public function setModalidade($iModalidade)
    {
        $this->iModalidade = $iModalidade;
        return $this;
    }
    /**
     * @param boolean $lSituacaoVigencia
     */
    public function setSituacaoVigencia($lSituacaoVigencia)
    {
        $this->lSituacaoVigencia = $lSituacaoVigencia;
        return $this;
    }

    /**
     * @return boolen
     */
    public function getSituacaoVigencia()
    {
        return $this->lSituacaoVigencia;
    }
    /**
     * @return mixed
     */
    public function getLicitacao()
    {
        return $this->iLicitacao;
    }

    /**
     * @param mixed $iLicitacao
     */
    public function setLicitacao($iLicitacao)
    {
        $this->iLicitacao = $iLicitacao;
        return $this;
    }

  /**
   * @return mixed
   */
  public function getITipocadastro()
  {
    return $this->iTipocadastro;
  }

  /**
   * @param mixed $iTipocadastro
   */
  public function setITipocadastro($iTipocadastro)
  {
    $this->iTipocadastro = $iTipocadastro;
  }

    /**
     * Construtor
     * @param integer $iCodigoAcordo
     */
    function __construct($iCodigoAcordo = null)
    {

        if (!empty($iCodigoAcordo)) {

            $this->iCodigoAcordo = $iCodigoAcordo;
            db_utils::getDao("acordo", false);
            $oDaoAcordo = new cl_acordo;
            $sSqlAcordo = $oDaoAcordo->sql_query_completo($iCodigoAcordo, "acordo.*, ac02_descricao,ac54_descricao,l20_edital||'/'||l20_anousu as e54_numerl,
         l03_codcom as modalidade,
         l03_tipo as tipo ");
            $rsAcordo   = $oDaoAcordo->sql_record($sSqlAcordo);

            if ($oDaoAcordo->numrows > 0) {

                $oDadosAcordo = db_utils::fieldsMemory($rsAcordo, 0);
                $this->setAno($oDadosAcordo->ac16_anousu);
                $this->setDataInclusao($oDadosAcordo->ac16_datainclusao);
                $this->setInstit($oDadosAcordo->ac16_instit);
                $this->setComissao(new AcordoComissao($oDadosAcordo->ac16_acordocomissao));
                $oContratado = CgmFactory::getInstanceByCgm($oDadosAcordo->ac16_contratado);
                $this->setContratado($oContratado);
                $iDepartamentoResponsavel = $oDadosAcordo->ac16_deptoresponsavel;
                $this->setDepartamentoResponsavel($iDepartamentoResponsavel);
                $this->setOrigem($oDadosAcordo->ac16_origem);
                $this->setTipoOrigem($oDadosAcordo->ac16_tipoorigem);
                $this->setNumero($oDadosAcordo->ac16_numero);
                $this->setNumeroAcordo($oDadosAcordo->ac16_numeroacordo);
                $this->setGrupo($oDadosAcordo->ac16_acordogrupo);
                $this->setDataAssinatura(db_formatar($oDadosAcordo->ac16_dataassinatura, "d"));
                $this->setDataPublicacao(db_formatar($oDadosAcordo->ac16_datapublicacao, "d"));
                $this->setDataInicial(db_formatar($oDadosAcordo->ac16_datainicio, "d"));
                $this->setDataFinal(db_formatar($oDadosAcordo->ac16_datafim, "d"));
                $this->setDepartamento($oDadosAcordo->ac16_coddepto);
                $this->setLei($oDadosAcordo->ac16_lei);
                $this->setDescricaoLei($oDadosAcordo->ac54_descricao);
                $this->setObjeto($oDadosAcordo->ac16_objeto);
                $this->setResumoObjeto($oDadosAcordo->ac16_resumoobjeto);
                $this->setSituacao($oDadosAcordo->ac16_acordosituacao);
                $this->setProcesso($oDadosAcordo->ac16_numeroprocesso);
                $this->setFormaFornecimento($oDadosAcordo->ac16_formafornecimento);
                $this->setVeiculoDivulgacao($oDadosAcordo->ac16_veiculodivulgacao);
                $this->setFormaPagamento($oDadosAcordo->ac16_formapagamento);
                $this->setCpfsignatariocontratante();
                $this->setQuantidadeRenovacao($oDadosAcordo->ac16_qtdrenovacao);
                $this->setTipoRenovacao($oDadosAcordo->ac16_tipounidtempo);
                $this->setValorContrato($oDadosAcordo->ac16_valor);
                $this->setDataRescisao(db_formatar($oDadosAcordo->ac16_datarescisao, "d"));
                $this->setValorRescisao($oDadosAcordo->ac16_valorrescisao);
                $this->setSituacaoVigencia(($oDadosAcordo->ac16_semvigencia == 'f' || $oDadosAcordo->ac16_semvigencia == "" || $oDadosAcordo->ac16_semvigencia == null) ? false : true);



                if (!empty($oDadosAcordo->ac16_licitacao)) {
                    $this->setLicitacao($oDadosAcordo->ac16_licitacao);
                } else {
                    $this->setLicitacao($oDadosAcordo->e54_numerl);
                }
                $this->setiAdesaoregpreco($oDadosAcordo->ac16_adesaoregpreco);
                $this->setiLicoutroorgao($oDadosAcordo->ac16_licoutroorgao);
                $this->setModalidade($oDadosAcordo->modalidade);
                $this->setTipo($oDadosAcordo->tipo);

                $this->iQtdPeriodoVigencia       = $oDadosAcordo->ac16_qtdperiodo;
                $this->iTipoUnidadeTempoVigencia = $oDadosAcordo->ac16_tipounidtempoperiodo;
                $this->iCategoriaAcordo          = $oDadosAcordo->ac16_acordocategoria;
                $this->iClassificacao            = $oDadosAcordo->ac16_acordoclassificacao;
                $this->iNumeroAcordo             = $oDadosAcordo->ac16_numeroacordo;

                $lComercial = false;
                if ($oDadosAcordo->ac16_periodocomercial == 't') {
                    $lComercial = true;
                }

                $this->setPeriodoComercial($lComercial);

                unset($oDadosAcordo);
            }
        }
    }

    /**retorna a descrição da situação
     * return string
     */
    public function getDescricaoSituacao()
    {

        $this->sDesricaoSituacao = "";
        $oDaoAcordo              = db_utils::getDao("acordo");
        $sSql                    = $oDaoAcordo->sql_query_completo($this->getCodigoAcordo(), "ac17_descricao");
        $rsSql                   = $oDaoAcordo->sql_record($sSql);
        if ($oDaoAcordo->numrows > 0) {

            $this->sDesricaoSituacao = db_utils::fieldsMemory($rsSql, 0)->ac17_descricao;
        }
        return $this->sDesricaoSituacao;
    }

    /**retorna a descrição do tipo
     * return string
     */
    public function getDescricaoTipo()
    {

        $this->sDesricaoTipo = "";
        $oDaoAcordo          = db_utils::getDao("acordo");
        $sSql                = $oDaoAcordo->sql_query_completo($this->getCodigoAcordo(), "ac04_descricao");
        $rsSql               = $oDaoAcordo->sql_record($sSql);
        if ($oDaoAcordo->numrows > 0) {

            $this->sDesricaoTipo = db_utils::fieldsMemory($rsSql, 0)->ac04_descricao;
        }
        return $this->sDesricaoTipo;
    }

    /**
     * @return acordoGarantia
     */
    public function getGarantias()
    {

        if (count($this->aGarantias) == 0) {

            $oDaoGarantias = db_utils::getDao("acordoacordogarantia");
            $sSqlGarantias = $oDaoGarantias->sql_query(null, "ac12_acordogarantia,
          ac12_texto", "ac12_sequencial", "ac12_acordo={$this->getCodigoAcordo()}");
            $rsGarantias   = $oDaoGarantias->sql_record($sSqlGarantias);
            if ($oDaoGarantias->numrows > 0) {

                for ($i = 0; $i < $oDaoGarantias->numrows; $i++) {

                    $oGarantiaPadrao = db_utils::fieldsMemory($rsGarantias, $i);
                    $oGarantia       = new AcordoGarantia($oGarantiaPadrao->ac12_acordogarantia);
                    $oGarantia->setTextoPadrao($oGarantiaPadrao->ac12_texto);
                    $this->aGarantias[] = $oGarantia;
                }
            }
        }
        return $this->aGarantias;
    }

    /**
     * retorna as penalidades do acorsdo
     * @return acordoPenalidade
     */
    public function getPenalidades()
    {

        if (count($this->aPenalidades) == 0) {

            $oDaoPenalidades = db_utils::getDao("acordoacordopenalidade");
            $sSqlPenalidades = $oDaoPenalidades->sql_query(null, "ac15_acordopenalidade,
          ac15_texto", "ac15_sequencial", "ac15_acordo={$this->getCodigoAcordo()}");
            $rsPenalidades   = $oDaoPenalidades->sql_record($sSqlPenalidades);
            if ($oDaoPenalidades->numrows > 0) {

                for ($i = 0; $i < $oDaoPenalidades->numrows; $i++) {

                    $oPenalidadePadrao = db_utils::fieldsMemory($rsPenalidades, $i);
                    $oPenalidade       = new AcordoPenalidade($oPenalidadePadrao->ac15_acordopenalidade);
                    $oPenalidade->setTextoPadrao($oPenalidadePadrao->ac15_texto);
                    $this->aPenalidades[] = $oPenalidade;
                }
            }
        }
        return $this->aPenalidades;
    }


    /**
     * @return integer
     */
    public function getAno()
    {

        return $this->iAno;
    }

    /**
     * @param integer $iAno
     * @return Acordo
     */
    public function setAno($iAno)
    {

        $this->iAno = $iAno;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataInclusao()
    {
        return $this->sDataInclusao;
    }

    /**
     * @param string $sDataInclusao
     *
     * @return Acordo
     */
    public function setDataInclusao($sDataInclusao)
    {
        $this->sDataInclusao = $sDataInclusao;
        return $this;
    }

    /**
     * retorna o codigo do acordo
     * @return integer
     */
    public function getCodigoAcordo()
    {
        return $this->iCodigoAcordo;
    }

    /**
     * @return integer
     */
    public function getCodigo()
    {
        return $this->iCodigoAcordo;
    }

    /**
     * define o codigo do acordo
     * @param integer $iCodigoAcordo
     */
    protected function setCodigoAcordo($iCodigoAcordo)
    {
        $this->iCodigoAcordo = $iCodigoAcordo;
    }

    /**
     * @return CgmBase
     */
    public function getContratado()
    {

        return $this->oContratado;
    }

    /**
     * define o cgm que foi contratado
     * @param integer $iContratato
     * @return Acordo
     */
    public function setContratado(CgmBase $oContratato)
    {

        $this->oContratado = $oContratato;
        return $this;
    }

    /**
     * @return integer
     */
    public function getDepartamento()
    {

        return $this->iDepartamento;
    }

    /**
     * Define o departamento do contrato
     * @param integer $iDepartamento
     * @return Acordo
     */
    public function setDepartamento($iDepartamento)
    {

        $this->iDepartamento = $iDepartamento;
        return $this;
    }

    /**
     * Retorna o Departamento do responsavel pelo contrato.
     * @return integer
     */
    public function getDepartamentoResponsavel()
    {

        return $this->iDepartamentoResponsavel;
    }

    /**
     * Define o departamento responsável pela gestao do contrato.
     * @param integer $iDepartamentoResponsavel
     * @return Acordo
     */
    public function setDepartamentoResponsavel($iDepartamentoResponsavel)
    {

        $this->iDepartamentoResponsavel = $iDepartamentoResponsavel;
        return $this;
    }

    /**
     * @return integer
     */
    public function getGrupo()
    {

        return $this->iGrupo;
    }

    /**
     * define do grupo do contrato
     * @param integer $iGrupo
     * @return Acordo
     */
    public function setGrupo($iGrupo)
    {

        $this->iGrupo = $iGrupo;
        return $this;
    }

    /**
     * retorna a instituição do contrato
     * @return integer
     */
    public function getInstit()
    {

        return $this->iInstit;
    }

    /**
     * @param integer $iInstit
     * @return Acordo
     */
    public function setInstit($iInstit)
    {

        $this->iInstit = $iInstit;
        return $this;
    }

    /**
     * retorna a situacao atual do contrato
     * @return integer
     */
    public function getSituacao()
    {

        return $this->iSituacao;
    }

    /**
     * Define a situacao do contrato
     * @param integer $iSituacao
     * @return Acordo
     */
    public function setSituacao($iSituacao)
    {

        $this->iSituacao = $iSituacao;
        return $this;
    }

    /**
     * @return acordoComissao
     */
    public function getComissao()
    {

        return $this->oComissao;
    }

    /**
     * define a comissao de vistoria do acordo
     * @param acordoComissao $oComissao
     * @return Acordo
     */
    public function setComissao(AcordoComissao $oComissao)
    {

        $this->oComissao = $oComissao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataAssinatura()
    {

        return $this->sDataAssinatura;
    }

    /**
     * @param string $sDataAssinatura
     * @return Acordo
     */
    public function setDataAssinatura($sDataAssinatura)
    {

        $this->sDataAssinatura = $sDataAssinatura;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataPublicacao()
    {
        return $this->sDataPublicacao;
    }

    /**
     *
     * @param $sDataPublicacao
     * @return $this
     */
    public function setDataPublicacao($sDataPublicacao)
    {
        $this->sDataPublicacao = $sDataPublicacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataFinal()
    {

        return $this->sDataFinal;
    }

    /**
     * @param string $sDataFinal
     * @return Acordo
     */
    public function setDataFinal($sDataFinal)
    {

        $this->sDataFinal = $sDataFinal;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataRescisao()
    {

        return $this->sDataRescisao;
    }

    /**
     * @param string $sDataRescisao
     * @return Acordo
     */
    public function setDataRescisao($sDataRescisao)
    {

        $this->sDataRescisao = $sDataRescisao;
        return $this;
    }


    /**
     * @return float
     */
    public function getValorRescisao()
    {

        return $this->nValorRescisao;
    }

    /**
     * @param float $nValorRescisao
     * @return Acordo
     */
    public function setValorRescisao($nValorRescisao)
    {

        $this->nValorRescisao = $nValorRescisao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataInicial()
    {

        return $this->sDataInicial;
    }

    /**
     * @param string $sDataInicial
     * @return Acordo
     */
    public function setDataInicial($sDataInicial)
    {

        $this->sDataInicial = $sDataInicial;
        return $this;
    }

    /**
     * retorna a lei do contrato
     * @return string
     */
    public function getLei()
    {

        return $this->sLei;
    }

    /**
     * define a lei do contrato
     * @param string $sLei
     * @return Acordo
     */
    public function setLei($sLei)
    {

        $this->sLei = $sLei;
        return $this;
    }

    /**
     * retorna a descricao lei do contrato
     * @return string
     */
    public function getDescricaoLei()
    {

        return $this->sDescricaoLei;
    }

    /**
     * define a descricao da lei do contrato
     * @param string $sDescricaoLei
     * @return Acordo
     */
    public function setDescricaoLei($sDescricaoLei)
    {

        $this->sDescricaoLei = $sDescricaoLei;
        return $this;
    }

    /**
     * retorna o processo do contrato
     *
     * @return string
     */
    public function getProcesso()
    {
        return $this->sProcesso;
    }

    /**
     * define o processo do contrato
     *
     * @param string $sProcesso
     * @return Acordo
     */
    public function setProcesso($sProcesso)
    {

        $this->sProcesso = $sProcesso;
        return $this;
    }

    /**
     * retorna o processo do contrato
     *
     * @return string
     */
    public function getFormaFornecimento()
    {
        return $this->sFormaFornecimento;
    }

    /**
     * define a forma de fornecimento
     *
     * @param $sForma
     * @return $this
     */
    public function setFormaFornecimento($sForma)
    {

        $this->sFormaFornecimento = $sForma;
        return $this;
    }

    /**
     * @return string
     */
    public function getVeiculoDivulgacao()
    {
        return $this->sVeiculoDivulgacao;
    }

    /**
     * @param $sVeiculoDivulgacao
     * @return $this
     */
    public function setVeiculoDivulgacao($sVeiculoDivulgacao)
    {
        $this->sVeiculoDivulgacao = $sVeiculoDivulgacao;
        return $this;
    }

    /**
     * define a forma de pagamento
     *
     * @param $sFormaPag
     * @return $this
     */
    public function setFormaPagamento($sFormaPag)
    {

        $this->sFormaPagamento = $sFormaPag;
        return $this;
    }

    /**
     * Retorna a forma de pagamento
     *
     * @return string
     */
    public function getFormaPagamento()
    {
        return $this->sFormaPagamento;
    }

    /**
     * define o cpf do signatario contratante
     * Sempre será o cpf do prefeito/presidente da camara que deve ser configurado no cadastro da instituição
     *
     * @return $this
     * @throws Exception
     */
    public function setCpfsignatariocontratante()
    {
        $sSql = "select si09_gestor from infocomplementaresinstit where si09_instit = " . db_getsession('DB_instit');
        $iCgm = db_utils::fieldsMemory(db_query($sSql), 0)->si09_gestor;

        if ($iCgm == "") {
            throw new Exception("O CPF do Siganatario Contratante não está corretamente configurado no cadastro desta instutuição. Acesse: Cofigurações->Cadastro->Instuição->Alteração.");
        }

        $this->sCpfsignatariocontratante = CgmFactory::getInstanceByCgm($iCgm)->getCgccpf();
        return $this;
    }

    /**
     * retorna o cpf do sgnatario contratante
     *
     * @return string
     */
    public function getCpfsignatariocontratante()
    {
        return $this->sCpfsignatariocontratante;
    }

    /**
     * @return string
     */
    public function getObjeto()
    {
        return $this->sObjeto;
    }

    /**
     * define o objeto do contrato
     * @param string $sObjeto
     * @return Acordo
     */
    public function setObjeto($sObjeto)
    {

        $this->sObjeto = $sObjeto;
        return $this;
    }

    /**
     * resumo do objeto
     * @return string
     */
    public function getResumoObjeto()
    {

        return $this->sResumoObjeto;
    }

    /**
     * Define o resumo do contrato
     * @param string $sResumoObjeto
     * @return Acordo
     */
    public function setResumoObjeto($sResumoObjeto)
    {

        $this->sResumoObjeto = $sResumoObjeto;
        return $this;
    }

    /**
     * @return integer
     */
    public function getOrigem()
    {

        return $this->iOrigem;
    }

    /**
     * @param integer $iOrigem
     * @return Acordo
     */
    public function setOrigem($iOrigem)
    {

        $this->iOrigem = $iOrigem;
        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantidadeRenovacao()
    {

        return $this->iQuantidadeRenovacao;
    }

    /**
     * @param integer $iQuantidadeRenovacao
     * @return Acordo
     */
    public function setQuantidadeRenovacao($iQuantidadeRenovacao)
    {

        $this->iQuantidadeRenovacao = $iQuantidadeRenovacao;
        return $this;
    }

    /**
     * @return int
     */
    public function getTipoOrigem()
    {
        return $this->iTipoOrigem;
    }

    /**
     * @param int $iTipoOrigem
     * @return Acordo
     */
    public function setTipoOrigem($iTipoOrigem)
    {
        $this->iTipoOrigem = $iTipoOrigem;
        return $this;
    }

    /**
     * @return integer
     */
    public function getTipoRenovacao()
    {
        return $this->iTipoRenovacao;
    }

    /**
     * @param integer $iTipoRenovacao
     * @return Acordo
     */
    public function setTipoRenovacao($iTipoRenovacao)
    {

        $this->iTipoRenovacao = $iTipoRenovacao;
        return $this;
    }

    /**
     * @param bool $lEmergencial
     * @return Acordo
     */
    public function setEmergencial($lEmergencial)
    {

        $this->lEmergencial = $lEmergencial;
        return $this;
    }

    /**
     * verifica se o contrato tem caracter emergencial
     *
     * @return unknown
     */
    function isEmergencial()
    {

        return $this->lEmergencial;
    }

    /**
     * @return boolean
     */
    public function getPeriodoComercial()
    {
        return $this->lPeriodoComercial;
    }

    /**
     * Seta se o os períodos do acordo vão ser com base em meses comerciais
     * @param boolean $lPeriodoComercial
     * @return Acordo
     */
    public function setPeriodoComercial($lPeriodoComercial)
    {

        $this->lPeriodoComercial = $lPeriodoComercial;
        return $this;
    }

    /**
     * Retorna a data inicial do periodo de vigencia original
     * @return DBDate
     */
    public function getDataInicialVigenciaOriginal()
    {

        if (empty($this->DataInicialVigenciaOriginal)) {
            $this->buscaVigenciaOriginal();
        }
        return $this->DataInicialVigenciaOriginal;
    }

    /**
     * Retorna a data final do periodo de vigencia original
     * @return DBDate
     */
    public function getDataFinalVigenciaOriginal()
    {

        if (empty($this->DataInicialVigenciaOriginal)) {
            $this->buscaVigenciaOriginal();
        }
        return $this->DataFinalVigenciaOriginal;
    }

    public function getVigenciaFinalOriginal(){

        $this->BuscaVigenciaFinalOriginal();

        return $this->DataFinalVigenciaOriginal;

    }

    /**
     * adiciona uma penalidade ao contrato
     * @param acordoPenalidade $aPenalidades
     * @param string $sTexto texto da penalidade
     *
     * @return Acordo
     */
    public function adicionarPenalidades(acordoPenalidade $oPenalidade, $sTexto = '')
    {

        $lAlterar = false;
        foreach ($this->getPenalidades() as $oPenalidadeCadastrada) {

            if ($oPenalidadeCadastrada->getCodigo() == $oPenalidade->getCodigo()) {
                $oPenalidade = $oPenalidadeCadastrada;
                $lAlterar    = true;
            }
        }
        if ($sTexto != '') {
            $oPenalidade->setTextoPadrao($sTexto);
        }
        if (!$lAlterar) {
            $this->aPenalidades[] = $oPenalidade;
        }
        return $this;
    }

    /**
     * @param acordoGarantia $aGarantias
     * @return Acordo
     */
    public function adicionarGarantias(acordoGarantia $oGarantia, $sTexto = '')
    {


        $lAlterar = false;
        foreach ($this->getGarantias() as $oGarantiaCadastrada) {

            if ($oGarantiaCadastrada->getCodigo() == $oGarantia->getCodigo()) {

                $oGarantia = $oGarantiaCadastrada;
                $lAlterar  = true;
            }
        }
        if ($sTexto != '') {
            $oGarantia->setTextoPadrao($sTexto);
        }
        if (!$lAlterar) {
            $this->aGarantias[$oGarantia->getCodigo()] = $oGarantia;
        }
        return $this;
    }

    public function removerGarantia($iGarantia)
    {

        if (empty($iGarantia)) {

            throw new Exception("Garantia não informada");
        }
        $aGarantias      = $this->getGarantias();
        $iTotalGarantias = count($aGarantias);
        
        
        if($iTotalGarantias==1){
                
                $oDaoAcordoGarantia = db_utils::getDao("acordoacordogarantia");
                $oDaoAcordoGarantia->excluir(null, "ac12_acordo={$this->getCodigoAcordo()}");
                $this->aGarantias = "";
                $op=1;

                
        }else{

            $oDaoGarantias = db_utils::getDao("acordoacordogarantia");
            $sSqlGarantias = $oDaoGarantias->sql_query(null, "ac12_acordogarantia,
          ac12_texto", "ac12_sequencial", "ac12_acordo={$this->getCodigoAcordo()}");
            $rsGarantias   = $oDaoGarantias->sql_record($sSqlGarantias);
            if ($oDaoGarantias->numrows > 0) {

                for ($i = 0; $i < $oDaoGarantias->numrows; $i++) {

                    $oGarantiaPadrao = db_utils::fieldsMemory($rsGarantias, $i);
                    $valor_ac12_acordogarantia = $oGarantiaPadrao->ac12_acordogarantia;
                    if($valor_ac12_acordogarantia==$iGarantia){
                        array_splice($this->aGarantias, $i, 1);
                        break;
                    }
                }
            }/*
            for ($i = 0; $i < $iTotalGarantias; $i++) {
                
                if($op==1){
                    break;
                }
                if ($this->aGarantias[$i]->getCodigo() == $iGarantia) {
                    
                    array_splice($this->aGarantias, $i, 1);
                    break;
                }         
            }*/
        }

        
          
        return $this;
    }

    /**
     * retorna o numero do contrato no grupo
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->iNumero;
    }

    /**
     * Seta o numero do contrato no grupo
     *
     * @param integer $iNumero
     * @return Acordo
     */
    public function setNumero($iNumero)
    {

        $this->iNumero = $iNumero;
        return $this;
    }

    /**
     * remove a penalidade do acordo
     *
     * @param integer $iPenalidade codigo da penalidade
     */
    public function removerPenalidade($iPenalidade)
    {

        if (empty($iPenalidade)) {

            throw new Exception("penalidade não informada");
        }
        $aPenalidades      = $this->getPenalidades();
        $iTotalPenalidades = count($aPenalidades);

        if($iTotalPenalidades==1){
                
            $oDaoPenalidades = db_utils::getDao("acordoacordopenalidade");
            $oDaoPenalidades->excluir(null, "ac15_acordo={$this->getCodigoAcordo()}");
            $this->aPenalidades = ""; 
           

            
    }else{

        $oDaoPenalidades = db_utils::getDao("acordoacordopenalidade");
            $sSqlPenalidades = $oDaoPenalidades->sql_query(null, "ac15_acordopenalidade,
          ac15_texto", "ac15_sequencial", "ac15_acordo={$this->getCodigoAcordo()}");
            $rsPenalidades   = $oDaoPenalidades->sql_record($sSqlPenalidades);
            if ($oDaoPenalidades->numrows > 0) {

                for ($i = 0; $i < $oDaoPenalidades->numrows; $i++) {

                    $oPenalidadePadrao = db_utils::fieldsMemory($rsPenalidades, $i);
                    $valor_penalidade = $oPenalidadePadrao->ac15_acordopenalidade;
                    if($valor_penalidade==$iPenalidade){
                        array_splice($this->aPenalidades, $i, 1);
                        break;
                    }

                }
            }
        /*
        for ($i = 0; $i < $iTotalPenalidades; $i++) {

            if ($this->aPenalidades[$i]->getCodigo() == $iPenalidade) {

                array_splice($this->aPenalidades, $i, 1);
                break;
            }
        }*/
    }
        return $this;
    }

    /**
     * Salva Contrato na Inclusão ou em suas Alterações
     */
    public function save()
    {

        $this->salvarAlteracoesContrato();
        $dtDataInicial = $this->getDataInicial();
        $dtDataFinal   = $this->getDataFinal();
        $oPosicao      = $this->getUltimaPosicao();

        $oDataInicial = new DBDate($dtDataInicial);
        $oDataFinal   = new DBDate($dtDataFinal);
        $this->salvarVigencia($oPosicao, $oDataInicial, $oDataFinal);
    }

    /**
     * Método que inclui vigencia para posição atual do acordo
     * @param DBDate $oDataFim
     * @param DBDate $oDataInicio
     */
    private function salvarVigencia($oPosicao, $oDataInicio, $oDataFim)
    {

        $oDaoAcordoVigencia = db_utils::getDao("acordovigencia");
        $oDaoAcordoVigencia->excluir(null, "ac18_acordoposicao={$oPosicao->getCodigo()}");

        if ($oDaoAcordoVigencia->erro_status == 0) {
            throw new Exception("Erro ao definir vigência do contrato.\n{$oDaoAcordoVigencia->erro_msg}");
        }

        $oDaoAcordoVigencia->ac18_acordoposicao = $oPosicao->getCodigo();
        $oDaoAcordoVigencia->ac18_ativo         = "true";
        $oDaoAcordoVigencia->ac18_datainicio    = $oDataInicio->getDate(DBDate::DATA_EN);
        $oDaoAcordoVigencia->ac18_datafim       = $oDataFim->getDate(DBDate::DATA_EN);
        $oDaoAcordoVigencia->incluir(null);

        if ($oDaoAcordoVigencia->erro_status == 0) {
            throw new Exception("Erro ao definir vigência do contrato.\n{$oDaoAcordoVigencia->erro_msg}");
        }

        $oDaoAcordo = db_utils::getDao('acordo');
        $oDaoAcordo->ac16_sequencial  = $this->getCodigo();
        $oDaoAcordo->ac16_providencia = $this->getProvidencia();
        $oDaoAcordo->alterar($this->getCodigo());

        if($oDaoAcordo->erro_status == 0){
            throw new Exception("Erro ao alterar contrato.\n{$oDaoAcordo->erro_msg}");
        }

    }

    /**
     * persite os dados do acordo na base
     * @return Acordo
     */
    private function salvarAlteracoesContrato()
    {

        $oDaoAcordo                                = db_utils::getDao("acordo");
        $oDaoAcordo->ac16_acordogrupo              = $this->getGrupo();
        $oDaoAcordo->ac16_instit                   = $this->getInstit();
        $oDaoAcordo->ac16_coddepto                 = $this->getDepartamento();
        $oDaoAcordo->ac16_contratado               = $this->getContratado()->getCodigo();
        $oDaoAcordo->ac16_acordosituacao           = $this->getSituacao();
        $oDaoAcordo->ac16_deptoresponsavel         = $this->getDepartamentoResponsavel();
        $oDaoAcordo->ac16_dataassinatura           = "" . implode("-", array_reverse(explode("/", $this->getDataAssinatura())));
        $oDaoAcordo->ac16_datapublicacao           = "" . implode("-", array_reverse(explode("/", $this->getDataPublicacao())));
        $oDaoAcordo->ac16_datainicio               = "" . implode("-", array_reverse(explode("/", $this->getDataInicial())));
        $oDaoAcordo->ac16_datafim                  = "" . implode("-", array_reverse(explode("/", $this->getDataFinal())));
        $oDaoAcordo->ac16_lei                      = $this->getLei();
        $oDaoAcordo->ac16_numeroprocesso           = $this->getProcesso();
        $oDaoAcordo->ac16_formafornecimento        = $this->getFormaFornecimento();
        $oDaoAcordo->ac16_veiculodivulgacao        = $this->getVeiculoDivulgacao();
        $oDaoAcordo->ac16_formapagamento           = $this->getFormaPagamento();
        $oDaoAcordo->ac16_cpfsignatariocontratante = $this->getCpfsignatariocontratante();
        $oDaoAcordo->ac16_numero                   = $this->getNumero();
        $oDaoAcordo->ac16_objeto                   = "{$this->getObjeto()}";
        $oDaoAcordo->ac16_resumoobjeto             = "" . $this->getResumoObjeto() . "";
        $oDaoAcordo->ac16_acordocomissao           = $this->getComissao()->getCodigo();
        $oDaoAcordo->ac16_origem                   = $this->getOrigem();
        $oDaoAcordo->ac16_tipoorigem               = $this->getTipoOrigem();
        $oDaoAcordo->ac16_qtdrenovacao             = $this->getQuantidadeRenovacao();
        $oDaoAcordo->ac16_tipounidtempo            = $this->getTipoRenovacao();
        $oDaoAcordo->ac16_periodocomercial         = $this->getPeriodoComercial();
        $oDaoAcordo->ac16_acordocategoria          = $this->getCategoriaAcordo();
        $oDaoAcordo->ac16_tipounidtempoperiodo     = $this->getTipoUnidadeTempoVigencia();
        $oDaoAcordo->ac16_qtdperiodo               = $this->getQtdPeriodoVigencia();
        $oDaoAcordo->ac16_acordoclassificacao      = $this->getClassificacao()->getCodigo();
        $oDaoAcordo->ac16_valor                    = $this->getValorContrato();
        $oDaoAcordo->ac16_numeroacordo             = $this->getNumeroAcordo();
        $oDaoAcordo->ac16_licitacao                = $this->getLicitacao();
        $oDaoAcordo->ac16_licoutroorgao            = $this->getiLicoutroorgao();
        $oDaoAcordo->ac16_adesaoregpreco           = $this->getiAdesaoregpreco();
        $oDaoAcordo->ac16_tipocadastro             = $this->getITipocadastro();
        $oDaoAcordo->ac16_providencia              = $this->getProvidencia();
        $iCodigoAcordo                             = $this->getCodigoAcordo();

        /**
         * Alteracao
         */

        if (!empty($iCodigoAcordo)) {

            $oDaoAcordo->ac16_sequencial = $this->getCodigoAcordo();

            $oDaoAcordo->alterar($this->getCodigoAcordo());
            if ($oDaoAcordo->erro_status == 0) {
                throw new Exception("Erro ao salvar acordo.\nErro: {$oDaoAcordo->erro_msg}");
            }
            $oPosicao = $this->getUltimaPosicao();
            $oPosicao->setPosicaoPeriodo($this->getDataInicial(), $this->getDataFinal(), $this->getPeriodoComercial())->save();

        } else {


            /**
             * Inclusao
             */
            $oDaoAcordo->ac16_anousu = $this->getAno();
            /**
             * validamos a númeracao do acordo.
             * não podera ser um numero menor ou igual ao maior numero de contrato do grupo e do Tipo instrumento,
             * dentro da instiuição.
             */
            $sWhereNumeracao         = "cast(ac16_numero as bigint) = {$this->getNumero()} ";
            $sWhereNumeracao .= " and ac16_acordogrupo  = {$this->getGrupo()}  ";
            $sWhereNumeracao .= " and ac16_instit       = {$this->getInstit()} ";
            $sWhereNumeracao .= " and ac16_anousu       = {$this->getAno()} ";
            $sWhereNumeracao .= " and ac16_acordocategoria = {$this->getCategoriaAcordo()} ";
            $sSqlValidaNumero  = $oDaoAcordo->sql_query_file(null, "ac16_numero,
              ac16_sequencial", null, $sWhereNumeracao);
            $rsValidaNumeracao = $oDaoAcordo->sql_record($sSqlValidaNumero);
            if ($oDaoAcordo->numrows > 0) {

                $sErroMensagem = "A númeração informada para esse contrato é inválida.\n";
                $sErroMensagem .= "Já existem contratos com essa númeração.\n";
                $sErroMensagem .= "Número sugerido para esse contrato: " . $this->getProximoNumeroContrato($this->getGrupo());
                throw new Exception($sErroMensagem);
            }

            $oDaoAcordo->incluir(null);
            if ($oDaoAcordo->erro_status == 0) {
                throw new Exception("Erro ao salvar acordo.\nErro: {$oDaoAcordo->erro_msg}");
            }
            $this->setCodigoAcordo($oDaoAcordo->ac16_sequencial);

            if ($oDaoAcordo->erro_status == 0) {
                throw new Exception("Erro ao salvar acordo.\nErro: {$oDaoAcordo->erro_msg}");
            }
            /**
             * Atualizamos o número do contrato no grupo
             */
            $oDaoGrupoContrato = db_utils::getDao("acordogruponumeracao");
            $sWhere            = "ac03_anousu = {$this->getAno()} and ac03_instit = {$this->getInstit()} ";
            $sWhere .= "and ac03_acordogrupo={$this->getGrupo()}";
            $sSqlNumeracao = $oDaoGrupoContrato->sql_query_file(null, "*", null, $sWhere);
            $rsNumeracao   = $oDaoGrupoContrato->sql_record($sSqlNumeracao);
            if ($oDaoGrupoContrato->numrows == 0) {

                $sMensagem = "Númeraçao para o grupo {$this->getGrupo()} não foi encontrado.\nInclusão do contrato abortada";
                throw new Exception($sMensagem);
            }

            $oNumeracaoGrupo                    = db_utils::fieldsMemory($rsNumeracao, 0);
            $oDaoGrupoContrato->ac03_sequencial = $oNumeracaoGrupo->ac03_sequencial;
            $oDaoGrupoContrato->ac03_numero     = $this->getNumero();
            $oDaoGrupoContrato->alterar($oNumeracaoGrupo->ac03_sequencial);
            if ($oDaoGrupoContrato->erro_status == 0) {

                $sMensagem = "Houve um erro ao atualizar númeração.\nVerifique o cadastro do grupo escolhido para esse contrato ";
                $sMensagem .= "e sua numeração\nErro Técnico: {$oDaoGrupoContrato->erro_msg} ";
                throw new Exception($sMensagem);
            }
            /**
             * incluimos uma movimentação para o contrato do tipo 1 - Inclusão do Contrato
             */
            $oDaoAcordoMovimentacao                              = db_utils::getDao("acordomovimentacao");
            $oDaoAcordoMovimentacao->ac10_datamovimento          = date("Y-m-d", db_getsession("DB_datausu"));
            $oDaoAcordoMovimentacao->ac10_acordomovimentacaotipo = 1;
            $oDaoAcordoMovimentacao->ac10_acordo                 = $this->getCodigoAcordo();
            $oDaoAcordoMovimentacao->ac10_hora                   = db_hora();
            $oDaoAcordoMovimentacao->ac10_id_usuario             = db_getsession("DB_id_usuario");
            $oDaoAcordoMovimentacao->ac10_obs                    = "Inclusão do contrato";
            $oDaoAcordoMovimentacao->incluir(null);
            if ($oDaoAcordoMovimentacao->erro_status == 0) {

                $sMensagem = "Houve um erro ao inicializar movimentação do contrato.\n inclusão do contrato cancelada";
                $sMensagem .= "\nErro Técnico: {$oDaoGrupoContrato->erro_msg} ";
                throw new Exception($sMensagem);
            }
            if ($this->getDataAssinatura() != "") {

                require_once("model/AcordoAssinatura.model.php");
                $oAssinatura = new AcordoAssinatura();
                $oAssinatura->setDataMovimento(implode("-", array_reverse(explode("/", $this->getDataAssinatura()))));
                $oAssinatura->setAcordo($this->getCodigoAcordo());
                $oAssinatura->setObservacao('Assinado em ' . $this->getDataAssinatura());
                $oAssinatura->save();
            }
            /**
             * incluimos uma posição inicial para o contrato:
             */
            $oPosicao = new AcordoPosicao();
            $oPosicao->setAcordo($this->iCodigoAcordo);
            $oPosicao->setNumero(1);
            $oPosicao->setTipo(1);
            $oPosicao->setData(date("Y-m-d", db_getsession("DB_datausu")));
            $oPosicao->setSituacao(1);
            $oPosicao->setEmergencial($this->isEmergencial());
            $oPosicao->setPosicaoPeriodo($this->getDataInicial(), $this->getDataFinal(), $oDaoAcordo->ac16_periodocomercial);
            $oPosicao->save();

            if ($oDaoAcordo->erro_status == 0) {
                throw new Exception("Erro ao salvar acordo.\nErro: {$oDaoAcordo->erro_msg}");
            }
        }
        /**
         * Salvamos todos as garantias/penalidades vinculadas ao acordo
         */
        $this->getPenalidades();
        $oDaoAcordoPenalidade = db_utils::getDao("acordoacordopenalidade");
        $oDaoAcordoPenalidade->excluir(null, "ac15_acordo={$this->getCodigoAcordo()}");
        foreach ($this->getPenalidades() as $oPenalidade) {

            $oDaoPenalidade                        = db_utils::getDao("acordoacordopenalidade");
            $oDaoPenalidade->ac15_acordo           = $this->getCodigoAcordo();
            $oDaoPenalidade->ac15_texto            = addslashes($oPenalidade->getTextoPadrao());
            $oDaoPenalidade->ac15_acordopenalidade = $oPenalidade->getCodigo();
            $oDaoPenalidade->incluir(null);
            if ($oDaoPenalidade->erro_status == 0) {
                throw new Exception("Erro ao incluir penalidade.\n{$oDaoPenalidade->erro_msg}");
            }
        }

        $this->getGarantias();
        $oDaoAcordoGarantia = db_utils::getDao("acordoacordogarantia");
        $oDaoAcordoGarantia->excluir(null, "ac12_acordo={$this->getCodigoAcordo()}");
        foreach ($this->getGarantias() as $oGarantia) {

            $oDaoGarantia                      = db_utils::getDao("acordoacordogarantia");
            $oDaoGarantia->ac12_acordo         = $this->getCodigoAcordo();
            $oDaoGarantia->ac12_texto          = $oGarantia->getTextoPadrao();
            $oDaoGarantia->ac12_acordogarantia = $oGarantia->getCodigo();
            $oDaoGarantia->incluir(null);

            if ($oDaoGarantia->erro_status == 0) {
                throw new Exception("Erro ao incluir garantia.\n{$oDaoGarantia->erro_msg}");
            }
        }
        return $this;
    }

    /**
     * retorna o proximo numero de contrato a ser utiliziado pelo grupo.
     *
     * @param integer $iGrupoContrato codigo do grupo
     * @return  integer - Codigo do contrato
     */
    public static function getProximoNumeroContrato($iGrupoContrato)
    {


        $sWhere = " ac03_acordogrupo = {$iGrupoContrato}";
        $sWhere .= " and ac03_anousu  = " . db_getsession("DB_anousu");
        $sWhere .= " and ac03_instit  = " . db_getsession("DB_instit");
        $oDaoGrupoContrato  = db_utils::getDao("acordogruponumeracao");
        $iNumero            = 0;
        $sSqlNumeroContrato = $oDaoGrupoContrato->sql_query_file(null, "ac03_numero", null, $sWhere);
        $rsNumeroContrato   = $oDaoGrupoContrato->sql_record($sSqlNumeroContrato);
        if ($oDaoGrupoContrato->numrows == 0) {
            throw new Exception("Não existe numeração cadastrada para o grupo {$iGrupoContrato}");
        }

        $iNumero = db_utils::fieldsMemory($rsNumeroContrato, 0)->ac03_numero + 1;
        return $iNumero;
    }

    /**
     * Função usada pelo Lazy Load para buscar a vigencia original do contrato
     * preenchendo as propriedades referentes
     * @throws DBException
     */
    private function buscaVigenciaOriginal()
    {

        $oDaoAcordoVigencia = db_utils::getDao("acordovigencia");
        $sWhere             = "ac26_acordo  = {$this->getCodigoAcordo()}";
        $sOrder             = "ac26_sequencial asc";
        $sSql               = $oDaoAcordoVigencia->sql_query(null, "*", $sOrder, $sWhere);

        $rsResultado = $oDaoAcordoVigencia->sql_record($sSql);

        if ($oDaoAcordoVigencia->numrows == 0) {
            throw new DBException("Erro Técnico: erro ao buscar dados vigência original do contrato");
        }
        $oStdDados                         = db_utils::fieldsMemory($rsResultado, 0);
        $this->DataInicialVigenciaOriginal = new DBDate($oStdDados->ac18_datainicio);
        $this->DataFinalVigenciaOriginal   = new DBDate($oStdDados->ac18_datafim);

    }

    private function BuscaVigenciaFinalOriginal()
    {

        $oDaoAcordoVigencia = db_utils::getDao("acordovigencia");
        $sWhere             = "ac26_acordo  = {$this->getCodigoAcordo()}";
        $sOrder             = "ac26_sequencial desc";
        $sSql               = $oDaoAcordoVigencia->sql_query(null, "*", $sOrder, $sWhere);

        $rsResultado = $oDaoAcordoVigencia->sql_record($sSql);

        if ($oDaoAcordoVigencia->numrows == 0) {
            throw new DBException("Erro Técnico: erro ao buscar dados vigência original do contrato");
        }
        $oStdDados                         = db_utils::fieldsMemory($rsResultado, 0);
        $this->DataInicialVigenciaOriginal = new DBDate($oStdDados->ac18_datainicio);
        $this->DataFinalVigenciaOriginal   = new DBDate($oStdDados->ac18_datafim);

    }


    /**
     * Retorna a ultima posicao do acordo
     * @param bool|false $bCancelados
     * @return AcordoPosicao
     * @throws Exception
     */
    function getUltimaPosicao($bCancelados = false)
    {

        if ($this->oUltimaPosicao == null) {

            $oDaoPosicao = db_utils::GetDao("acordoposicao");
            $sWhere      = "ac26_acordo       = {$this->getCodigoAcordo()}";
            $sWhere .= $bCancelados ? "" : "and ac26_situacao = 1";
            $sSqlultimaPosicao = $oDaoPosicao->sql_query_file(null, "ac26_sequencial", 'ac26_numero desc limit 1', $sWhere);
            $rsPosicao         = $oDaoPosicao->sql_record($sSqlultimaPosicao);
            if ($oDaoPosicao->numrows == 0) {
                throw new Exception("Acordo sem posições definidas.");
            }

            $iCodigoPosicao       = db_utils::fieldsMemory($rsPosicao, 0)->ac26_sequencial;
            $this->oUltimaPosicao = new AcordoPosicao($iCodigoPosicao);
        }
        return $this->oUltimaPosicao;
    }

    /**
     * retorna todas as posicões do acordo
     * @return AcordoPosicao[]
     */
    function getPosicoes()
    {

        if (count($this->aPosicoes) == 0) {

            $oDaoAcordoPosicao = db_utils::getDao("acordoposicao");
            $sSqlPosicao       = $oDaoAcordoPosicao->sql_query_file(null, "ac26_sequencial", 'ac26_numero', 'ac26_acordo=' . $this->getCodigoAcordo());

            $rsPosicao = $oDaoAcordoPosicao->sql_record($sSqlPosicao);
            for ($i = 0; $i < $oDaoAcordoPosicao->numrows; $i++) {

                $oPos              = db_utils::fieldsMemory($rsPosicao, $i);
                $oPosicao          = new AcordoPosicao($oPos->ac26_sequencial);
                $this->aPosicoes[] = $oPosicao;
                unset($oPos);
            }
        }
        return $this->aPosicoes;
    }

    /**
     * retorna todas as posicões de Aditamento do acordo
     * @return AcordoPosicao[]
     */
    function getPosicoesAditamentos()
    {

        $oDaoAcordoPosicao = db_utils::getDao("acordoposicao");
        $sSqlPosicao       = $oDaoAcordoPosicao->sql_query_file(null, "ac26_sequencial", 'ac26_numero', "ac26_acordo = {$this->getCodigoAcordo()} and ac26_numeroaditamento != '' and ac26_numeroaditamento is not null");

        $rsPosicao = $oDaoAcordoPosicao->sql_record($sSqlPosicao);
        for ($i = 0; $i < $oDaoAcordoPosicao->numrows; $i++) {

            $oPos              = db_utils::fieldsMemory($rsPosicao, $i);
            $oPosicao          = new AcordoPosicao($oPos->ac26_sequencial);
            $this->aPosicoes[] = $oPosicao;
            unset($oPos);
        }

        return $this->aPosicoes;
    }

    /**
     * retorna todas as posicões de Apostilamento do acordo
     * @return AcordoPosicao[]
     */

    function getPosicoesApostilamentos()
    {

        $oDaoAcordoPosicao = db_utils::getDao("acordoposicao");
        $sSqlPosicao       = $oDaoAcordoPosicao->sql_query_file(null, "ac26_sequencial", 'ac26_numero', "ac26_acordo = {$this->getCodigoAcordo()} ");

        $rsPosicao = $oDaoAcordoPosicao->sql_record($sSqlPosicao);
        for ($i = 0; $i < $oDaoAcordoPosicao->numrows; $i++) {

            $oPos              = db_utils::fieldsMemory($rsPosicao, $i);
            $oPosicao          = new AcordoPosicao($oPos->ac26_sequencial);
            $this->aPosicoes[] = $oPosicao;
            unset($oPos);
        }

        return $this->aPosicoes;
    }

    /**
     * retorna a posicao pelo codigo de cadastro
     * @return AcordoPosicao
     */
    function getPosicaoByCodigo($iCodigo)
    {

        $oPosicao = false;
        foreach ($this->getPosicoes() as $oPosicao) {

            if ($oPosicao->getCodigo() == $iCodigo) {
                break;
            }
        }
        return $oPosicao;
    }

    /**
     * Processa as autorizacoes de empenho do contrato
     *
     * @param array $aItens
     * @param bool $lProcessar
     * @param stdClass $oDadosAutorizacao
     * @return array
     * @throws Exception
     */
    public function processarAutorizacoes(array $aItens, $lProcessar = false, $oDadosAutorizacao = null)
    {


        $aAutorizacoes = array();

        foreach ($aItens as $oItem) {

            $oItemContrato = $this->getPosicaoByCodigo($oItem->posicao)->getItemByCodigo($oItem->codigo);

            $aDadosDotacao = $oItemContrato->getDotacoes();
            foreach ($oItem->dotacoes as $oDotacao) {

                $oDotacaoItem = null;
                foreach ($aDadosDotacao as $oDotacaoItem) {
                    if ($oDotacaoItem->dotacao == $oDotacao->dotacao) {
                        break;
                    }
                }

                if ($oDotacao->valorexecutar == 0) {
                    continue;
                }

                if (!isset($aAutorizacoes[$oDotacao->dotacao . $oItemContrato->getElemento()])) {

                    $oAutorizacao           = new stdClass();
                    $oAutorizacao->dotacao  = $oDotacao->dotacao;
                    $oAutorizacao->valor    = $oDotacao->valorexecutar;
                    $oAutorizacao->elemento = $oItemContrato->getElemento();
                    $oAutorizacao->aItens   = array();

                    $oItemAut                       = new stdClass();
                    $oItemAut->descricao            = $oItemContrato->getMaterial()->getDescricao();
                    $oItemAut->codigo               = $oItem->codigo;
                    $oItemAut->elemento             = $oItemContrato->getElemento();
                    $oItemAut->resumo               = urldecode($oItemContrato->getResumo());
                    $oItemAut->valor                = $oDotacao->valorexecutar;
                    $oItemAut->reserva              = $oDotacaoItem->reserva;
                    $oItemAut->codigomaterial       = $oItemContrato->getMaterial()->getMaterial();
                    $oItemAut->iCodigoItemLicitacao = $oItemContrato->getCodigoItemLicitacao();
                    $oItemAut->iCodigoItemProcesso  = $oItemContrato->getCodigoItemProcessoCompras();
                    $oItemAut->iCodigoItemEmpenho   = $oItemContrato->getCodigoItemEmpenho();
                    $oItemAut->unidade              = $oItemContrato->getUnidade();
                    $oItemAut->marca                = $oItemContrato->getMarca();
                    $oItemAut->controlaquantidade = $oItemContrato->getControlaQuantidade();
                    if ($oItemContrato->getMaterial()->isServico() && $oItemContrato->getControlaQuantidade() == 'f') {

                        $oItemAut->quantidade    = 1;
                        $oItemAut->valorunitario = $oDotacao->valorexecutar;

                    } else if ($oItemContrato->getMaterial()->isServico() && $oItemContrato->getControlaQuantidade() == 't') {

                        //$oItemAut->quantidade = round(($oItem->quantidade * $oDotacao->valorexecutar) / $oItemAut->valor, 2);
                        $oItemAut->quantidade    = $oDotacao->quantidade;
                        $oItemAut->valorunitario = $oItemContrato->getValorUnitario();

                    } else {

                        //$oItemAut->quantidade = round(($oItem->quantidade * $oDotacao->valorexecutar) / $oItem->valor, 2);
                        $oItemAut->quantidade    = $oDotacao->quantidade;
                        $oItemAut->valorunitario = $oItemContrato->getValorUnitario();
                    }

                    $oAutorizacao->aItens[]                                            = $oItemAut;
                    $aAutorizacoes[$oDotacao->dotacao . $oItemContrato->getElemento()] = $oAutorizacao;
                } else {

                    $aAutorizacoes[$oDotacao->dotacao . $oItemContrato->getElemento()]->valor += $oDotacao->valor;
                    $oItemAut = new stdClass();

                    $oItemAut->descricao            = $oItemContrato->getMaterial()->getDescricao();
                    $oItemAut->codigomaterial       = $oItemContrato->getMaterial()->getMaterial();
                    $oItemAut->codigo               = $oItem->codigo;
                    $oItemAut->resumo               = urldecode($oItemContrato->getResumo());
                    $oItemAut->elemento             = $oItemContrato->getElemento();
                    $oItemAut->valor                = $oDotacao->valorexecutar;
                    $oItemAut->reserva              = $oDotacaoItem->reserva;
                    $oItemAut->iCodigoItemLicitacao = $oItemContrato->getCodigoItemLicitacao();
                    $oItemAut->iCodigoItemProcesso  = $oItemContrato->getCodigoItemProcessoCompras();
                    $oItemAut->iCodigoItemEmpenho   = $oItemContrato->getCodigoItemEmpenho();
                    $oItemAut->unidade              = $oItemContrato->getUnidade();
                    $oItemAut->marca                = $oItemContrato->getMarca();

                    $oItemAut->controlaquantidade = $oItemContrato->getControlaQuantidade();
                    if ($oItemContrato->getMaterial()->isServico() && $oItemContrato->getControlaQuantidade() == 'f') {

                        $oItemAut->quantidade    = 1;
                        $oItemAut->valorunitario = $oDotacao->valorexecutar;
                    } else if ($oItemContrato->getMaterial()->isServico() && $oItemContrato->getControlaQuantidade() == 't') {

                        //$oItemAut->quantidade = round(($oItem->quantidade * $oDotacao->valorexecutar) / $oItem->valor, 2);
                        $oItemAut->quantidade    = $oDotacao->quantidade;
                        $oItemAut->valorunitario = $oItemContrato->getValorUnitario();
                    } else {

                        //$oItemAut->quantidade = round(($oItem->quantidade * $oDotacao->valorexecutar) / $oItem->valor, 2);
                        $oItemAut->quantidade    = $oDotacao->quantidade;
                        $oItemAut->valorunitario = $oItemContrato->getValorUnitario();
                    }
                    $aAutorizacoes[$oDotacao->dotacao . $oItemContrato->getElemento()]->aItens[] = $oItemAut;
                }
            }
        }
        /*
         * implementada logica para excluir a reserva anterior, para que seja recriadda.
         */
        if ($lProcessar) {

            foreach ($aItens as $oStdItem) {

                foreach ($oStdItem->dotacoes as $oStdDotacaoItem) {

                    if ($oStdDotacaoItem->reserva != "") {

                        $oDaoOrcReserva   = db_utils::getDao("orcreserva");
                        $sSqlDadosReserva = $oDaoOrcReserva->sql_query_file($oStdDotacaoItem->reserva);
                        $rsDadosReserva   = $oDaoOrcReserva->sql_record($sSqlDadosReserva);
                        if ($oDaoOrcReserva->numrows > 0) {

                            $oDadosReserva     = db_utils::fieldsMemory($rsDadosReserva, 0);
                            $nValorReserva     = $oDadosReserva->o80_valor;
                            $nValorNovaReserva = round($nValorReserva - $oStdDotacaoItem->valorexecutar, 2);

                            if ($nValorNovaReserva <= 0) {

                                $oDaoOrcReservaItem = db_utils::getDao("orcreservaacordoitemdotacao");
                                $oDaoOrcReservaItem->excluir(null, "o84_orcreserva = {$oStdDotacaoItem->reserva}");
                                $oDaoOrcReserva->excluir($oStdDotacaoItem->reserva);

                            } else {

                                $oDaoOrcReserva             = db_utils::getDao("orcreserva");
                                $oDaoOrcReserva->o80_codres = $oStdDotacaoItem->reserva;
                                $oDaoOrcReserva->o80_valor  = $nValorNovaReserva;
                                $oDaoOrcReserva->alterar($oDaoOrcReserva->o80_codres);
                            }

                            if ($oDaoOrcReserva->erro_status == 0) {

                                $sErro = "Erro ao alterar dados da reserva do item do contrato!\n";
                                $sErro .= $oDaoOrcReserva->erro_msg;
                                throw new Exception($sErro);
                            }
                        }

                    }
                }
            }

            foreach ($aAutorizacoes as $oAutorizacaoItens) {

                $nValorAutorizacao = 0;
                foreach ($oAutorizacaoItens->aItens as $oItemAutorizacao) {
                    $nValorAutorizacao += round($oItemAutorizacao->valorunitario * $oItemAutorizacao->quantidade, 2);
                }
                /**
                 * Gera a autorização de empenho
                 */
                $oAutorizacaoEmpenho = new AutorizacaoEmpenho();
                $oAutorizacaoEmpenho->setCaracteristicaPeculiar($oDadosAutorizacao->iCaracteristicaPeculiar);
                $oAutorizacaoEmpenho->setFornecedor($this->getContratado());
                $oAutorizacaoEmpenho->setDestino(utf8_decode($oDadosAutorizacao->destino));
                //$oAutorizacaoEmpenho->setResumo(utf8_decode($oDadosAutorizacao->resumo));
                $oAutorizacaoEmpenho->setResumo($oDadosAutorizacao->resumo);
                $oAutorizacaoEmpenho->setNumeroLicitacao($oDadosAutorizacao->licitacao);
                $oAutorizacaoEmpenho->setDotacao($oAutorizacaoItens->dotacao);
                $oAutorizacaoEmpenho->setTipoEmpenho($oDadosAutorizacao->tipoempenho);
                $oAutorizacaoEmpenho->setTipoCompra($oDadosAutorizacao->tipocompra);
                $oAutorizacaoEmpenho->setTipoLicitacao($oDadosAutorizacao->tipolicitacao);
                $oAutorizacaoEmpenho->setModalidade($oDadosAutorizacao->iNumModalidade);
                $oAutorizacaoEmpenho->setSTipoorigem($oDadosAutorizacao->sTipoorigem);
                $oAutorizacaoEmpenho->setSTipoautorizacao($oDadosAutorizacao->sTipoautorizacao);
                $oAutorizacaoEmpenho->setValor($nValorAutorizacao);
                $iSeq        = 1;
                $nValorTotal = 0;


                foreach ($oAutorizacaoItens->aItens as $oStdItemAutorizacao) {

                    $oItem                     = new stdClass();
                    $oItem->codigomaterial     = $oStdItemAutorizacao->codigomaterial;
                    $oItem->quantidade         = $oStdItemAutorizacao->quantidade;
                    $oItem->valortotal         = $oStdItemAutorizacao->valorunitario * $oStdItemAutorizacao->quantidade;
                    $oItem->observacao         = $oStdItemAutorizacao->resumo;
                    $oItem->codigoelemento     = $oStdItemAutorizacao->elemento;
                    $oItem->valorunitario      = $oStdItemAutorizacao->valorunitario;
                    $oItem->acordoitem         = $oStdItemAutorizacao->codigo;
                    $oItem->liclicitem         = $oStdItemAutorizacao->iCodigoItemLicitacao;
                    $oItem->empempitem         = $oStdItemAutorizacao->iCodigoItemEmpenho;
                    $oItem->pcprocitem         = $oStdItemAutorizacao->iCodigoItemProcesso;
                    $oItem->reserva            = $oStdItemAutorizacao->reserva;
                    $oItem->controlaquantidade = $oStdItemAutorizacao->controlaquantidade;
                    $oItem->unidade            = $oStdItemAutorizacao->unidade;
                    $oItem->marca              = $oStdItemAutorizacao->marca;

                    $oAutorizacaoEmpenho->addItem($oItem);
                }
                $oAutorizacaoEmpenho->salvar();
                $iCodigoAutorizacao = $oAutorizacaoEmpenho->getAutorizacao();

                /**
                 * Para cada item autorizado, gerar vinculo com acordo
                 */
                foreach ($oAutorizacaoEmpenho->getItens() as $oItemAutorizacao) {

                    $iCodigoItem = $oItemAutorizacao->sequencial;

                    /**
                     * incluirmos na tabela acordoitemexecutado
                     */
                    $oDaoAcordoItemExecutado                   = new cl_acordoitemexecutado;
                    $oDaoAcordoItemExecutado->ac29_acordoitem  = $oItemAutorizacao->acordoitem;
                    $oDaoAcordoItemExecutado->ac29_automatico  = 'true';
                    $oDaoAcordoItemExecutado->ac29_quantidade  = $oItemAutorizacao->quantidade;
                    $oDaoAcordoItemExecutado->ac29_valor       = round($oItemAutorizacao->valorunitario * $oItemAutorizacao->quantidade, 2);
                    $oDaoAcordoItemExecutado->ac29_tipo        = 1;
                    $oDaoAcordoItemExecutado->ac29_datainicial = date("Y-m-d", db_getsession("DB_datausu"));
                    $oDaoAcordoItemExecutado->ac29_datafinal   = date("Y-m-d", db_getsession("DB_datausu"));
                    $oDaoAcordoItemExecutado->incluir(null);
                    if ($oDaoAcordoItemExecutado->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimetanção do acordo!\nErro:{$oDaoAcordoItemExecutado->erro_msg}");
                    }

                    /**
                     * Vinculamos a autorizacao ao item do acordo
                     */
                    $oDaoAcordoItemExecutadoAut                           = db_utils::getDao("acordoitemexecutadoempautitem");
                    $oDaoAcordoItemExecutadoAut->ac19_acordoitemexecutado = $oDaoAcordoItemExecutado->ac29_sequencial;
                    $oDaoAcordoItemExecutadoAut->ac19_autori              = $iCodigoAutorizacao;
                    $oDaoAcordoItemExecutadoAut->ac19_sequen              = $iCodigoItem;
                    $oDaoAcordoItemExecutadoAut->incluir(null);
                    if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoAcordoItemExecutadoAut->erro_msg}");
                    }

                    /**
                     * inclui saldo executado da dotacao
                     */
                    $oDaoExecucaoDotacao                  = db_utils::getDao("acordoitemexecutadodotacao");
                    $oDaoExecucaoDotacao->ac32_acordoitem = $oItemAutorizacao->acordoitem;
                    $oDaoExecucaoDotacao->ac32_anousu     = db_getsession("DB_anousu");
                    $oDaoExecucaoDotacao->ac32_coddot     = $oAutorizacaoItens->dotacao;
                    $oDaoExecucaoDotacao->ac32_valor      = $oDaoAcordoItemExecutado->ac29_valor;
                    $oDaoExecucaoDotacao->incluir(null);
                    if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoExecucaoDotacao->erro_msg}");
                    }

                    $iSeq++;
                    $nValorTotal += $oDaoAcordoItemExecutado->ac29_valor;
                }

                $aAutorizacoesRetorno[]                  = $oAutorizacaoEmpenho->getAutorizacao();
                $oDaoAcordoEmpautoriza                   = db_utils::getDao("acordoempautoriza");
                $oDaoAcordoEmpautoriza->ac45_acordo      = $this->getCodigoAcordo();
                $oDaoAcordoEmpautoriza->ac45_empautoriza = $oAutorizacaoEmpenho->getAutorizacao();
                $oDaoAcordoEmpautoriza->incluir(null);

                if ($oDaoAcordoEmpautoriza->erro_status == 0) {

                    $sMensagemErro = "[ 1 ] - Erro ao vincular a autorização ao acordo.\n\n";
                    $sMensagemErro .= $oDaoAcordoEmpautoriza->erro_msg;
                    throw new Exception($sMensagemErro);
                }
            }
        }

        if ($lProcessar) {

            return $aAutorizacoesRetorno;
        } else {
            return $aAutorizacoes;
        }
    }

    /**
     * Adicionado $aItensEmpempItem para, quando vier de anulacao de empenho, anular somente
     * a quantidade especificada na anulacao
     */

    public function anularAutorizacao($iAutorizacao, $aItensEmpempItem = array())
    {

        if (empty($iAutorizacao)) {
            throw new Exception("Codigo da autorização não informado.");
        }
        if (!db_utils::inTransaction()) {
            throw new Exception("Nenhuma transação com o banco de dados aberta.\nProcessamento cancelado.");
        }
        /*
         * Verifica se a autorizacao é do contrato,
         */
        $aAutorizacoes = $this->getAutorizacoes($iAutorizacao);
        if (count($aAutorizacoes) == 1) {

            $oAutorizacao = new AutorizacaoEmpenho($iAutorizacao);
            $oAutorizacao->excluirReservaSaldo();
            $oAutorizacao->anularAutorizacaoEmpenho(new DBDate(date("d/m/Y", db_getsession("DB_datausu"))));


            /**
             * Buscamos todos os itens que são da autorizacao
             */
            $aItens = $this->getItensAcordoNaAutorizacao($iAutorizacao);
            /**
             * incluimos um saldo executado negativo, informando que houve um estorno
             */
            foreach ($aItens as $oItem) {

                if (isset($aItensEmpempItem[$oItem->ac20_pcmater])) {
                    $oItem->quantidade = $aItensEmpempItem[$oItem->ac20_pcmater]->quantidade;
                    $oItem->valor      = $aItensEmpempItem[$oItem->ac20_pcmater]->vlrtot;
                    /**
                     * incluirmos na tabela acordoitemexecutado
                     */
                    $oDaoAcordoItemExecutado                   = db_utils::getDao("acordoitemexecutado");
                    $oDaoAcordoItemExecutado->ac29_acordoitem  = $oItem->codigo;
                    $oDaoAcordoItemExecutado->ac29_automatico  = 'true';
                    $oDaoAcordoItemExecutado->ac29_quantidade  = $oItem->quantidade * -1;
                    $oDaoAcordoItemExecutado->ac29_valor       = $oItem->valor * -1;
                    $oDaoAcordoItemExecutado->ac29_tipo        = 1;
                    $oDaoAcordoItemExecutado->ac29_datainicial = date("Y-m-d", db_getsession("DB_datausu"));
                    $oDaoAcordoItemExecutado->ac29_datafinal   = date("Y-m-d", db_getsession("DB_datausu"));
                    $oDaoAcordoItemExecutado->incluir(null);
                    if ($oDaoAcordoItemExecutado->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoAcordoItemExecutado->erro_msg}");
                    }
                    /**
                     * Vinculamos a autorizacao ao item do acordo
                     */
                    $oDaoAcordoItemExecutadoAut                           = db_utils::getDao("acordoitemexecutadoempautitem");
                    $oDaoAcordoItemExecutadoAut->ac19_acordoitemexecutado = $oDaoAcordoItemExecutado->ac29_sequencial;
                    $oDaoAcordoItemExecutadoAut->ac19_autori              = $iAutorizacao;
                    $oDaoAcordoItemExecutadoAut->ac19_sequen              = $oItem->itemautorizacao;
                    $oDaoAcordoItemExecutadoAut->incluir(null);
                    if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoAcordoItemExecutadoAut->erro_msg}");
                    }

                    $oDaoExecucaoDotacao                  = db_utils::getDao("acordoitemexecutadodotacao");
                    $oDaoExecucaoDotacao->ac32_acordoitem = $oItem->codigo;
                    $oDaoExecucaoDotacao->ac32_anousu     = $oItem->anodotacao;
                    $oDaoExecucaoDotacao->ac32_coddot     = $oItem->dotacao;
                    $oDaoExecucaoDotacao->ac32_valor      = $oDaoAcordoItemExecutado->ac29_valor;
                    $oDaoExecucaoDotacao->incluir(null);
                    if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                        throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoExecucaoDotacao->erro_msg}");
                    }
                }
                //$oItemContrato = $this->getUltimaPosicao()->getItemByCodigo($oItem->codigo);
                $aDotacoes    = array();
                $oDotacaoItem = null;
                foreach ($aDotacoes as $oDotacaoItem) {
                    if ($oDotacaoItem->dotacao == $oItem->dotacao) {
                        break;
                    }
                }
                if ($oDotacaoItem != null) {

                    if ($oDotacaoItem->reserva != "") {

                        /**
                         * Verifica se a dotacao possui saldo para reservar o valor do item novamente:
                         */
                        $oDotacaoSaldo    = new Dotacao($oDotacaoItem->dotacao, $oDotacaoItem->ano);
                        $oDaoOrcReserva   = db_utils::getDao("orcreserva");
                        $sSqlDadosReserva = $oDaoOrcReserva->sql_query_file($oDotacaoItem->reserva);
                        $rsDadosReserva   = $oDaoOrcReserva->sql_record($sSqlDadosReserva);
                        if ($oDaoOrcReserva->numrows > 0) {

                            $nValorAcrescentar = $oItem->valor;
                            if ($oDotacaoSaldo->getSaldoFinal() < $oItem->valor) {
                                $nValorAcrescentar = $oDotacaoSaldo->getSaldoFinal();
                            }
                            $oDadosReserva              = db_utils::fieldsMemory($rsDadosReserva, 0);
                            $nValorReserva              = $oDadosReserva->o80_valor;
                            $nValorNovaReserva          = round($nValorReserva + $nValorAcrescentar, 2);
                            $oDaoOrcReserva             = db_utils::getDao("orcreserva");
                            $oDaoOrcReserva->o80_codres = $oDotacaoItem->reserva;
                            $oDaoOrcReserva->o80_valor  = $nValorNovaReserva;
                            $oDaoOrcReserva->alterar($oDotacaoItem->reserva);
                            if ($oDaoOrcReserva->erro_status == 0) {

                                $sErro = "Erro ao alterar dados da reserva do item do contrato!\n";
                                $sErro .= $oDaoOrcReserva->erro_msg;
                                throw new Exception($sErro);
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    public function anularAutorizacao2($iAutorizacao, $aItensEmpempItem = array())
    {

        if (empty($iAutorizacao)) {
            throw new Exception("Codigo da autorização não informado.");
        }
        if (!db_utils::inTransaction()) {
            throw new Exception("Nenhuma transação com o banco de dados aberta.\nProcessamento cancelado.");
        }
        /*
         * Verifica se a autorizacao é do contrato,
         */
        $aAutorizacoes = $this->getAutorizacoes($iAutorizacao);
        if (count($aAutorizacoes) == 1) {

            $oAutorizacao = new AutorizacaoEmpenho($iAutorizacao);
            $oAutorizacao->excluirReservaSaldo();
            $oAutorizacao->anularAutorizacaoEmpenho(new DBDate(date("d/m/Y", db_getsession("DB_datausu"))));


            /**
             * Buscamos todos os itens que são da autorizacao
             */
            $aItens = $this->getItensAcordoNaAutorizacao($iAutorizacao);
            /**
             * incluimos um saldo executado negativo, informando que houve um estorno
             */
            foreach ($aItens as $oItem) {

                if (isset($aItensEmpempItem[$oItem->ac20_pcmater])) {
                    $oItem->quantidade = $aItensEmpempItem[$oItem->ac20_pcmater]->quantidade;
                    $oItem->valor      = $aItensEmpempItem[$oItem->ac20_pcmater]->vlrtot;

                }
                /**
                 * incluirmos na tabela acordoitemexecutado
                 */
                $oDaoAcordoItemExecutado                   = db_utils::getDao("acordoitemexecutado");
                $oDaoAcordoItemExecutado->ac29_acordoitem  = $oItem->codigo;
                $oDaoAcordoItemExecutado->ac29_automatico  = 'true';
                $oDaoAcordoItemExecutado->ac29_quantidade  = $oItem->quantidade * -1;
                $oDaoAcordoItemExecutado->ac29_valor       = $oItem->valor * -1;
                $oDaoAcordoItemExecutado->ac29_tipo        = 1;
                $oDaoAcordoItemExecutado->ac29_datainicial = date("Y-m-d", db_getsession("DB_datausu"));
                $oDaoAcordoItemExecutado->ac29_datafinal   = date("Y-m-d", db_getsession("DB_datausu"));
                $oDaoAcordoItemExecutado->incluir(null);
                if ($oDaoAcordoItemExecutado->erro_status == 0) {
                    throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoAcordoItemExecutado->erro_msg}");
                }
                /**
                 * Vinculamos a autorizacao ao item do acordo
                 */
                $oDaoAcordoItemExecutadoAut                           = db_utils::getDao("acordoitemexecutadoempautitem");
                $oDaoAcordoItemExecutadoAut->ac19_acordoitemexecutado = $oDaoAcordoItemExecutado->ac29_sequencial;
                $oDaoAcordoItemExecutadoAut->ac19_autori              = $iAutorizacao;
                $oDaoAcordoItemExecutadoAut->ac19_sequen              = $oItem->itemautorizacao;
                $oDaoAcordoItemExecutadoAut->incluir(null);
                if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                    throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoAcordoItemExecutadoAut->erro_msg}");
                }

                $oDaoExecucaoDotacao                  = db_utils::getDao("acordoitemexecutadodotacao");
                $oDaoExecucaoDotacao->ac32_acordoitem = $oItem->codigo;
                $oDaoExecucaoDotacao->ac32_anousu     = $oItem->anodotacao;
                $oDaoExecucaoDotacao->ac32_coddot     = $oItem->dotacao;
                $oDaoExecucaoDotacao->ac32_valor      = $oDaoAcordoItemExecutado->ac29_valor;
                $oDaoExecucaoDotacao->incluir(null);
                if ($oDaoAcordoItemExecutadoAut->erro_status == 0) {
                    throw new Exception("Erro ao salvar movimentação do acordo!\nErro:{$oDaoExecucaoDotacao->erro_msg}");
                }
                //$oItemContrato = $this->getUltimaPosicao()->getItemByCodigo($oItem->codigo);
                $aDotacoes    = array();
                $oDotacaoItem = null;
                foreach ($aDotacoes as $oDotacaoItem) {
                    if ($oDotacaoItem->dotacao == $oItem->dotacao) {
                        break;
                    }
                }
                if ($oDotacaoItem != null) {

                    if ($oDotacaoItem->reserva != "") {

                        /**
                         * Verifica se a dotacao possui saldo para reservar o valor do item novamente:
                         */
                        $oDotacaoSaldo    = new Dotacao($oDotacaoItem->dotacao, $oDotacaoItem->ano);
                        $oDaoOrcReserva   = db_utils::getDao("orcreserva");
                        $sSqlDadosReserva = $oDaoOrcReserva->sql_query_file($oDotacaoItem->reserva);
                        $rsDadosReserva   = $oDaoOrcReserva->sql_record($sSqlDadosReserva);
                        if ($oDaoOrcReserva->numrows > 0) {

                            $nValorAcrescentar = $oItem->valor;
                            if ($oDotacaoSaldo->getSaldoFinal() < $oItem->valor) {
                                $nValorAcrescentar = $oDotacaoSaldo->getSaldoFinal();
                            }
                            $oDadosReserva              = db_utils::fieldsMemory($rsDadosReserva, 0);
                            $nValorReserva              = $oDadosReserva->o80_valor;
                            $nValorNovaReserva          = round($nValorReserva + $nValorAcrescentar, 2);
                            $oDaoOrcReserva             = db_utils::getDao("orcreserva");
                            $oDaoOrcReserva->o80_codres = $oDotacaoItem->reserva;
                            $oDaoOrcReserva->o80_valor  = $nValorNovaReserva;
                            $oDaoOrcReserva->alterar($oDotacaoItem->reserva);
                            if ($oDaoOrcReserva->erro_status == 0) {

                                $sErro = "Erro ao alterar dados da reserva do item do contrato!\n";
                                $sErro .= $oDaoOrcReserva->erro_msg;
                                throw new Exception($sErro);
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
    public function excluirAutorizacao($aiAutorizacao = array()){
        $sAutorizacao = join(',', $aiAutorizacao);
        //cria tabela temporaria para limpar a autorizacao
        db_query("CREATE TEMP TABLE contratos_excluir ON
                  COMMIT
                  DROP AS
                  SELECT acordoempautoriza.ac45_acordo AS contrato,
                  acordoempautoriza.ac45_empautoriza AS autorizacao,
                  acordoitemexecutado.ac29_acordoitem AS itens_contrato
                  FROM acordo
                  JOIN acordoempautoriza ON ac45_acordo = ac16_sequencial
                  JOIN acordoposicao ON ac26_acordo = ac16_sequencial
                  JOIN acordoitem ON ac26_sequencial = ac20_acordoposicao
                  JOIN acordoitemexecutado ON ac29_acordoitem = ac20_sequencial
                  WHERE acordoempautoriza.ac45_empautoriza IN ($sAutorizacao);
                ");

        $clorcreservaaut = db_utils::getDao("orcreservaaut");
        $clempautorizaprocesso = db_utils::getDao("empautorizaprocesso");
        $clempautidot = db_utils::getDao("empautidot");
        $clempautitempcprocitem = db_utils::getDao("empautitempcprocitem");
        $clacordoitemexecutadoempautitem = db_utils::getDao("acordoitemexecutadoempautitem");
        $clempautitem = db_utils::getDao("empautitem");
        $clempempaut = db_utils::getDao("empempaut");
        $clacordoempautoriza = db_utils::getDao("acordoempautoriza");
        $clempautoriza = db_utils::getDao("empautoriza");
        $clacordoitemexecutado = db_utils::getDao("acordoitemexecutado");
        $clacordoitemexecutadodotacao = db_utils::getDao("acordoitemexecutadodotacao");

        $rsexcluirAutorizacaoItens = db_query("SELECT DISTINCT * FROM contratos_excluir");
        $rsexcluirAutorizacaoItens = db_utils::getCollectionByRecord($rsexcluirAutorizacaoItens);

        foreach ($rsexcluirAutorizacaoItens as $oAutorizacaoItens) {
            $where = ' ac29_acordoitem='.$oAutorizacaoItens->itens_contrato;
            $where.= ' and e54_autori = '.$oAutorizacaoItens->autorizacao;
            $sqlBuscaAnulados = $clacordoitemexecutado->sql_buscaAnulados(null,'ac29_sequencial', null, $where);
            $rsAnulados = db_query($sqlBuscaAnulados);
            $codAnulacao = db_utils::getCollectionByRecord($rsAnulados);
            $clacordoitemexecutadoempautitem->excluir(null,"ac19_acordoitemexecutado in ($sqlBuscaAnulados)");
            if($clacordoitemexecutadoempautitem->erro_status == 0){
                throw new Exception($clacordoitemexecutadoempautitem->erro_msg);
            }

            $clacordoitemexecutadodotacao->excluir(null, "ac32_acordoitem =".$oAutorizacaoItens->itens_contrato);

            if($clacordoitemexecutadodotacao->erro_status == 0){
                throw new Exception($clacordoitemexecutadodotacao->erro_msg);
            }

            $clacordoitemexecutado->excluir(null, "ac29_acordoitem = $oAutorizacaoItens->itens_contrato and ac29_sequencial in ($sqlBuscaAnulados)");
            if($clacordoitemexecutado->erro_status == 0){
                throw new Exception($clacordoitemexecutado->erro_msg);
            }

        }


        $rsexcluirAutorizacao = db_query("SELECT DISTINCT autorizacao FROM contratos_excluir");
        $rsexcluirAutorizacao = db_utils::getCollectionByRecord($rsexcluirAutorizacao);

        foreach ($rsexcluirAutorizacao as $oAutorizacao) {

            $clorcreservaaut->excluir(null,"o83_autori=".$oAutorizacao->autorizacao);

            if($clorcreservaaut->erro_status == 0){
                throw new Exception($clorcreservaaut->erro_msg);
            }
            $clempautorizaprocesso->excluir(null,"e150_empautoriza =".$oAutorizacao->autorizacao);
            if($clempautorizaprocesso->erro_status == 0){
                throw new Exception($clempautorizaprocesso->erro_msg);
            }
            $clempautidot->excluir(null,"e56_autori=".$oAutorizacao->autorizacao);
            if($clempautidot->erro_status == 0){
                throw new Exception($clempautidot->erro_msg);
            }
            $clempautitempcprocitem->excluir(null,"e73_autori=".$oAutorizacao->autorizacao);
            if($clempautitempcprocitem->erro_status == 0){
                throw new Exception($clempautitempcprocitem->erro_msg);
            }
            $clacordoitemexecutadoempautitem->excluir(null,"ac19_autori=".$oAutorizacao->autorizacao);
            if($clacordoitemexecutadoempautitem->erro_status == 0){
                throw new Exception($clacordoitemexecutadoempautitem->erro_msg);
            }
            $clempautitem->excluir($oAutorizacao->autorizacao);
            if($clempautitem->erro_status == 0){
                throw new Exception($clempautitem->erro_msg);
            }
            $clempempaut->excluir(null,"e61_autori=".$oAutorizacao->autorizacao);
            if($clempempaut->erro_status == 0){
                throw new Exception($clempempaut->erro_msg);
            }
            $clacordoempautoriza->excluir(null,"ac45_empautoriza=".$oAutorizacao->autorizacao);
            if($clacordoempautoriza->erro_status == 0){
                throw new Exception($clacordoempautoriza->erro_msg);
            }
            $clempautoriza->excluir(null,"e54_autori=".$oAutorizacao->autorizacao);
            if($clempautoriza->erro_status == 0){
                throw new Exception($clempautoriza->erro_msg);
            }

        }

        return true;

    }
    public function getLicitacoes()
    {

        $oDaoAcordo        = db_utils::getDao("acordo");
        $sCamposLicitacoes = " liclicita.l20_codigo ";
        $sSqlLicitacoes    = $oDaoAcordo->sql_queryLicitacoesVinculadas($this->iCodigoAcordo, $sCamposLicitacoes);
        $rsLicitacoes      = $oDaoAcordo->sql_record($sSqlLicitacoes);

        if ($oDaoAcordo->numrows > 0) {

            for ($iLicitacao = 0; $iLicitacao < $oDaoAcordo->numrows; $iLicitacao++) {

                $iCodigoLicitacao    = db_utils::fieldsMemory($rsLicitacoes, $iLicitacao)->l20_codigo;
                $this->aLicitacoes[] = new licitacao($iCodigoLicitacao);
            }
        }

        return $this->aLicitacoes;
    }

    public function getAdesaoRegPreco()
    {

        $oDaoAcordo        = db_utils::getDao("acordo");
        $sCamposAdesao = " adesaoregprecos.si06_sequencial ";
        $sSqlAdesao        = $oDaoAcordo->sql_queryAdesaoVinculadas($this->iCodigoAcordo, $sCamposAdesao);
        $rsAdesaovinculada = $oDaoAcordo->sql_record($sSqlAdesao);
        $oDaoAdesaoregpreco = db_utils::getDao("adesaoregprecos");

        if ($oDaoAcordo->numrows > 0) {

            for ($iAdesao = 0; $iAdesao < $oDaoAcordo->numrows; $iAdesao++) {

                $iCodigoAdesao    = db_utils::fieldsMemory($rsAdesaovinculada, $iAdesao)->si06_sequencial;
                $rsAdesao = $oDaoAdesaoregpreco->sql_record($oDaoAdesaoregpreco->sql_query($iCodigoAdesao,"si06_sequencial,si06_objetoadesao,si06_dataadesao,coddepto||'-'||descrdepto as departamento"));
                
                for($i = 0; $i < $oDaoAdesaoregpreco->numrows; $i++){
            
                    $oDadosAdesao = db_utils::fieldsMemory($rsAdesao, $i);
                    $oStdAdesao   = new stdClass();
                    $oStdAdesao->si06_sequencial = $oDadosAdesao->si06_sequencial;
                    $oStdAdesao->si06_objetoadesao = $oDadosAdesao->si06_objetoadesao;
                    $oStdAdesao->si06_dataadesao = $oDadosAdesao->si06_dataadesao;
                    $oStdAdesao->departamento = $oDadosAdesao->departamento;
                    $this->aAdesao[] = $oStdAdesao;
                }
            }
        }

        return $this->aAdesao;
    }

    public function getLicitacaoOutrosOrgaos()
    {

        $oDaoAcordo        = db_utils::getDao("acordo");
        $sCamposLicitacoes = " liclicitaoutrosorgaos.lic211_sequencial ";
        $sSqlLicitacaoOutrosOrgaos        = $oDaoAcordo->sql_queryLicitacoesOutrosOrgaosVinculadas($this->iCodigoAcordo, $sCamposLicitacoes);
        $rsLicitacaoOutrosOrgaos          = $oDaoAcordo->sql_record($sSqlLicitacaoOutrosOrgaos);
        $oDaoliclicitaoutrosorgaos        = db_utils::getDao("liclicitaoutrosorgaos");

        if ($oDaoAcordo->numrows > 0) {

            for ($iLicitacaoOutrosOrgaos = 0; $iLicitacaoOutrosOrgaos < $oDaoAcordo->numrows; $iLicitacaoOutrosOrgaos++) {

                $iCodigoLicitacao    = db_utils::fieldsMemory($rsLicitacaoOutrosOrgaos, $iLicitacaoOutrosOrgaos)->lic211_sequencial;
                
                $rsLicitacao = $oDaoliclicitaoutrosorgaos->sql_record($oDaoliclicitaoutrosorgaos->sql_query($iCodigoLicitacao,"lic211_sequencial,lic211_tipo"));

                for($i = 0; $i < $oDaoliclicitaoutrosorgaos->numrows; $i++){
                    
                    $oDadosLicitacao = db_utils::fieldsMemory($rsLicitacao, $i);
                    
                    if($oDadosLicitacao->lic211_tipo == "5"){
                        $tipo = "5 - Licitação realizada por outro órgão ou entidade";
                    }elseif($oDadosLicitacao->lic211_tipo == "6"){
                        $tipo = "6 - Dispensa ou Inexigibilidade realizada por outro órgão ou entidade";
                    }elseif($oDadosLicitacao->lic211_tipo == "7"){
                        $tipo = "7 - Licitação - Regime Diferenciado de Contratações";
                    }elseif($oDadosLicitacao->lic211_tipo == "8"){
                        $tipo = "8 - Licitação realizada por consorcio público ";
                    }elseif($oDadosLicitacao->lic211_tipo == "9"){
                        $tipo = "9 - Licitação realizada por outro ente da federação ";
                    }

                    $oStdLicitacao   = new stdClass();
                    $oStdLicitacao->lic211_sequencial   = $oDadosLicitacao->lic211_sequencial;
                    $oStdLicitacao->lic211_tipo         = $tipo;
                    $oStdLicitacao->data                = '';
                    $oStdLicitacao->departamento        = '';
                    
                    $this->aLicitacaoOutrosOrgaos[]     = $oStdLicitacao;
                }

            }
        }

        return $this->aLicitacaoOutrosOrgaos;
    }

    public function getProcessosDeCompras()
    {

        $oDaoAcordo              = db_utils::getDao("acordo");
        $sCamposProcesso         = " pc80_codproc ";
        $sSqlProcessosVinculados = $oDaoAcordo->sql_queryProcessosVinculados($this->iCodigoAcordo, $sCamposProcesso);
        $rsProcessosVinculados   = $oDaoAcordo->sql_record($sSqlProcessosVinculados);

        if ($oDaoAcordo->numrows > 0) {

            for ($iProcesso = 0; $iProcesso < $oDaoAcordo->numrows; $iProcesso++) {

                $iCodigoProcesso             = db_utils::fieldsMemory($rsProcessosVinculados, $iProcesso)->pc80_codproc;
                $this->aProcessosDeCompras[] = new ProcessoCompras($iCodigoProcesso);
            }
        }

        return $this->aProcessosDeCompras;
    }


    /**
     * Retorna os empenhos vinculados ao acordo, inclusive de seus aditivos
     * @access public
     * @return void
     */
    public function getEmpenhos()
    {

        $oDaoAcordo             = db_utils::getDao("acordo");
        $sCamposEmpenho         = " e100_numemp ";
        $sSqlEmpenhosVinculados = $oDaoAcordo->sql_queryEmpenhosVinculados($this->iCodigoAcordo, $sCamposEmpenho);
        $rsEmpenhosVinculados   = $oDaoAcordo->sql_record($sSqlEmpenhosVinculados);

        if ($oDaoAcordo->numrows > 0) {

            for ($iEmpenho = 0; $iEmpenho < $oDaoAcordo->numrows; $iEmpenho++) {

                $iNumeroEmpenho    = db_utils::fieldsMemory($rsEmpenhosVinculados, $iEmpenho)->e100_numemp;
                $this->aEmpenhos[] = new EmpenhoFinanceiro($iNumeroEmpenho);
            }
        }

        return $this->aEmpenhos;
    }

    /**
     * Retorna os empenhos vinculados ao acordo, exceto de seus aditivos
     * @access public
     * @return void
     */
    public function getEmpenhosAcordo()
    {

        $oDaoAcordo             = db_utils::getDao("acordo");
        $sCamposEmpenho         = " distinct e60_numemp ";
        $sSqlEmpenhosVinculados = $oDaoAcordo->sql_queryEmpenhosVinculadosContrato($this->iCodigoAcordo, $sCamposEmpenho);
        $rsEmpenhosVinculados   = $oDaoAcordo->sql_record($sSqlEmpenhosVinculados);

        if ($oDaoAcordo->numrows > 0) {

            for ($iEmpenho = 0; $iEmpenho < $oDaoAcordo->numrows; $iEmpenho++) {

                $iNumeroEmpenho    = db_utils::fieldsMemory($rsEmpenhosVinculados, $iEmpenho)->e60_numemp;
                $this->aEmpenhos[] = new EmpenhoFinanceiro($iNumeroEmpenho);
            }
        }

        return $this->aEmpenhos;
    }

    /**
     * Retorna as autorizacoes realizadas para o acordo
     * @param integer [$iAutoriza] codigo da Autorizacao
     * @return array
     */
    public function getAutorizacoes($iAutoriza = '', $iCheckedYear = '')
    {

        $sSqlAutorizacoes = "select  e54_autori as codigo,";
        $sSqlAutorizacoes .= "        sum(e54_valor) as valor,e54_valor,";
        $sSqlAutorizacoes .= "        e54_emiss as dataemissao,";
        $sSqlAutorizacoes .= "        e54_anulad as dataanulacao,";
        $sSqlAutorizacoes .= "        e60_codemp||'/'||e60_anousu as empenho, ";
        $sSqlAutorizacoes .= "        e60_numemp as codigoempenho,";
        $sSqlAutorizacoes .= "        e60_vlranu as valoranulado";
        $sSqlAutorizacoes .= "   from acordoposicao ";
        $sSqlAutorizacoes .= "        inner join acordoitem          on ac20_acordoposicao = ac26_sequencial ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutado on ac20_sequencial    = ac29_acordoitem ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoempautitem on ac29_sequencial = ac19_acordoitemexecutado ";
        $sSqlAutorizacoes .= "        inner join empautitem on e55_sequen = ac19_sequen and ac19_autori = e55_autori ";
        $sSqlAutorizacoes .= "        inner join empautoriza on e54_autori = e55_autori ";
        $sSqlAutorizacoes .= "        left join empempaut on e61_autori = e54_autori ";
        $sSqlAutorizacoes .= "        left join empempenho on e61_numemp = e60_numemp ";
        $sSqlAutorizacoes .= "  where ac26_acordo =  {$this->getCodigoAcordo()} ";

        if($iCheckedYear != ''){
			$sSqlAutorizacoes .= " AND extract(YEAR FROM e54_emiss) = {$iCheckedYear} ";
		}

        if ($iAutoriza != '') {
            $sSqlAutorizacoes .= " and e54_autori = {$iAutoriza}";
        }
        $sSqlAutorizacoes .= "  group by e54_autori,";
        $sSqlAutorizacoes .= "  e54_emiss,  ";
        $sSqlAutorizacoes .= "  e60_codemp, ";
        $sSqlAutorizacoes .= "  e60_anousu, ";
        $sSqlAutorizacoes .= "  e60_numemp,  ";
        $sSqlAutorizacoes .= "  e54_anulad";

        /**
         * pesquisa os empenhos vicnulados por baixa Manual
         */
        $sSqlAutorizacoes .= " UNION ";
        $sSqlAutorizacoes .= "select  distinct e54_autori as codigo,";
        $sSqlAutorizacoes .= "        e54_valor as valor,e54_valor,";
        $sSqlAutorizacoes .= "        e54_emiss as dataemissao,";
        $sSqlAutorizacoes .= "        e54_anulad as dataanulacao,";
        $sSqlAutorizacoes .= "        e60_codemp||'/'||e60_anousu as empenho, ";
        $sSqlAutorizacoes .= "        e60_numemp as codigoempenho,";
        $sSqlAutorizacoes .= "        e60_vlranu as valoranulado";
        $sSqlAutorizacoes .= "   from acordoposicao ";
        $sSqlAutorizacoes .= "        inner join acordoitem          on ac20_acordoposicao = ac26_sequencial ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutado on ac20_sequencial    = ac29_acordoitem ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoperiodo on ac29_sequencial = ac38_acordoitemexecutado";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoempenho on  ac38_sequencial = ac39_acordoitemexecutadoperiodo";
        $sSqlAutorizacoes .= "        inner join empempenho    on ac39_numemp = e60_numemp ";
        $sSqlAutorizacoes .= "        left join empempaut      on e60_numemp  = e61_numemp ";
        $sSqlAutorizacoes .= "        inner join empautoriza   on e54_autori  = e61_autori ";
        $sSqlAutorizacoes .= "  where ac26_acordo =  {$this->getCodigoAcordo()} ";

		if($iCheckedYear != ''){
			$sSqlAutorizacoes .= " AND extract(YEAR FROM e54_emiss) = {$iCheckedYear} ";
		}

        $sSqlAutorizacoes .= "  order by codigo";

        $rsAutorizacoes = db_query($sSqlAutorizacoes);

        return db_utils::getCollectionByRecord($rsAutorizacoes);
    }

    /**
     * Retorna as autorizacoes realizadas para o acordo dentro de um intervalo de datas
     * @param integer [$iAutoriza] codigo da Autorizacao
     * @return array
     */
    public function getAutorizacoesEntreDatas($sDataInicial, $sDataFinal,$iSeqPosicao)
    {

        $sSqlDataDeEmissao = '';
        if( empty($sDataInicial) && !empty($sDataFinal) ){
            $sSqlDataDeEmissao = " AND e60_emiss <= '".date("Y-m-d", strtotime(str_replace('/','-',$sDataFinal)))."'";
        }
        if( !empty($sDataInicial) && empty($sDataFinal) ){
            $sSqlDataDeEmissao = " AND e60_emiss >= '".date("Y-m-d", strtotime(str_replace('/','-',$sDataInicial)))."'";
        }
        if( !empty($sDataInicial) && !empty($sDataFinal) ){
            $sSqlDataDeEmissao = " AND (e60_emiss BETWEEN '".date("Y-m-d", strtotime(str_replace('/','-',$sDataInicial)))."'";
            $sSqlDataDeEmissao .= "                   AND '".date("Y-m-d", strtotime(str_replace('/','-',$sDataFinal)))."') ";
        }

        $sSqlAutorizacoes =  "select  e54_autori as codigo,";
        $sSqlAutorizacoes .= "        sum(e54_valor) as valor,e54_valor,";
        $sSqlAutorizacoes .= "        e54_emiss as dataemissao,";
        $sSqlAutorizacoes .= "        e54_anulad as dataanulacao,";
        $sSqlAutorizacoes .= "        e60_anousu||e60_codemp as codemp, ";
        $sSqlAutorizacoes .= "        e60_codemp||'/'||e60_anousu as empenho, ";
        $sSqlAutorizacoes .= "        e60_numemp as codigoempenho";
        $sSqlAutorizacoes .= "   from acordoposicao ";
        $sSqlAutorizacoes .= "        inner join acordoitem          on ac20_acordoposicao = ac26_sequencial ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutado on ac20_sequencial    = ac29_acordoitem ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoempautitem on ac29_sequencial = ac19_acordoitemexecutado ";
        $sSqlAutorizacoes .= "        inner join empautitem on e55_sequen = ac19_sequen and ac19_autori = e55_autori ";
        $sSqlAutorizacoes .= "        inner join empautoriza on e54_autori = e55_autori ";
        $sSqlAutorizacoes .= "        left join empempaut on e61_autori = e54_autori ";
        $sSqlAutorizacoes .= "        left join empempenho on e61_numemp = e60_numemp ";
        $sSqlAutorizacoes .= "  where ac26_acordo =  {$this->getCodigoAcordo()} and ac26_sequencial = $iSeqPosicao";
        $sSqlAutorizacoes .= $sSqlDataDeEmissao;
        $sSqlAutorizacoes .= "  group by e54_autori,";
        $sSqlAutorizacoes .= "  e54_emiss,  ";
        $sSqlAutorizacoes .= "  e60_codemp, ";
        $sSqlAutorizacoes .= "  e60_anousu, ";
        $sSqlAutorizacoes .= "  e60_numemp,  ";
        $sSqlAutorizacoes .= "  e54_anulad";

        /**
         * pesquisa os empenhos vinculados por baixa Manual
         */
        $sSqlAutorizacoes .= " UNION ";
        $sSqlAutorizacoes .= "select  distinct e54_autori as codigo,";
        $sSqlAutorizacoes .= "        e54_valor as valor,e54_valor,";
        $sSqlAutorizacoes .= "        e54_emiss as dataemissao,";
        $sSqlAutorizacoes .= "        e54_anulad as dataanulacao,";
        $sSqlAutorizacoes .= "        e60_anousu||e60_codemp as codemp, ";
        $sSqlAutorizacoes .= "        e60_codemp||'/'||e60_anousu as empenho, ";
        $sSqlAutorizacoes .= "        e60_numemp as codigoempenho";
        $sSqlAutorizacoes .= "   from acordoposicao ";
        $sSqlAutorizacoes .= "        inner join acordoitem          on ac20_acordoposicao = ac26_sequencial ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutado on ac20_sequencial    = ac29_acordoitem ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoperiodo on ac29_sequencial = ac38_acordoitemexecutado";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoempenho on  ac38_sequencial = ac39_acordoitemexecutadoperiodo";
        $sSqlAutorizacoes .= "        inner join empempenho    on ac39_numemp = e60_numemp ";
        $sSqlAutorizacoes .= "        left join empempaut      on e60_numemp  = e61_numemp ";
        $sSqlAutorizacoes .= "        inner join empautoriza   on e54_autori  = e61_autori ";
        $sSqlAutorizacoes .= "  where ac26_acordo =  {$this->getCodigoAcordo()} and ac26_sequencial = $iSeqPosicao";
        $sSqlAutorizacoes .= $sSqlDataDeEmissao ;
        $sSqlAutorizacoes .= "  order by codemp asc";
        $rsAutorizacoes = db_query($sSqlAutorizacoes);

        return db_utils::getCollectionByRecord($rsAutorizacoes);
    }

    /**
     * retorna os itens do acordo que estão na autorizacao passada por parametro
     *
     * @param integer $iAutoriza codigo do autorizacao
     * @return array
     */
    public function getItensAcordoNaAutorizacao($iAutoriza)
    {


        $sSqlAutorizacoes = "select distinct on (e54_autori,ac29_acordoitem) e54_autori as autorizacao,";
        $sSqlAutorizacoes .= "        ac29_valor as valor,";
        $sSqlAutorizacoes .= "        ac29_acordoitem as codigo,";
        $sSqlAutorizacoes .= "        ac29_quantidade as quantidade,";
        $sSqlAutorizacoes .= "        e56_coddot as dotacao,";
        $sSqlAutorizacoes .= "        e56_anousu as anodotacao,";
        $sSqlAutorizacoes .= "        e55_sequen as itemautorizacao,";
        $sSqlAutorizacoes .= "        ac20_pcmater";
        $sSqlAutorizacoes .= "   from acordoposicao ";
        $sSqlAutorizacoes .= "        inner join acordoitem          on ac20_acordoposicao = ac26_sequencial ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutado on ac20_sequencial    = ac29_acordoitem ";
        $sSqlAutorizacoes .= "        inner join acordoitemexecutadoempautitem on ac29_sequencial = ac19_acordoitemexecutado ";
        $sSqlAutorizacoes .= "        inner join empautitem on e55_sequen = ac19_sequen and ac19_autori = e55_autori ";
        $sSqlAutorizacoes .= "        inner join empautoriza on e54_autori = e55_autori ";
        $sSqlAutorizacoes .= "        inner join empautidot on e56_autori = e54_autori ";
        $sSqlAutorizacoes .= "  where ac26_acordo = {$this->getCodigoAcordo()} ";
        $sSqlAutorizacoes .= "     and e54_autori = {$iAutoriza}";
        $sSqlAutorizacoes .= "  order by e54_autori, ac29_acordoitem";
        $rsAutorizacoes = db_query($sSqlAutorizacoes);
        return db_utils::getCollectionByRecord($rsAutorizacoes);
    }

    /**
     *
     */

    public function getRecisoes()
    {

        $oDaoAcordoMovimentacao      = db_utils::getDao('acordomovimentacao');
        $ac10_acordomovimentacaotipo = 6;
        $sCampos                     = "*";
        $sWhere                      = " ac10_acordomovimentacaotipo = " . $ac10_acordomovimentacaotipo;
        $sWhere .= " and ac10_acordo = " . $this->getCodigoAcordo();
        $sSqlAcordoMovimentacao  = $oDaoAcordoMovimentacao->sql_query(null, $sCampos, null, $sWhere);
        $rsSqlAcordoMovimentacao = $oDaoAcordoMovimentacao->sql_record($sSqlAcordoMovimentacao);
        return db_utils::getCollectionByRecord($rsSqlAcordoMovimentacao);

    }

    public function getAnulacoes()
    {

        $oDaoAcordoMovimentacao      = db_utils::getDao('acordomovimentacao');
        $ac10_acordomovimentacaotipo = 8;
        $sCampos                     = "*";
        $sWhere                      = " ac10_acordomovimentacaotipo = " . $ac10_acordomovimentacaotipo;
        $sWhere .= " and ac10_acordo = " . $this->getCodigoAcordo();
        $sSqlAcordoMovimentacao  = $oDaoAcordoMovimentacao->sql_query(null, $sCampos, null, $sWhere);
        $rsSqlAcordoMovimentacao = $oDaoAcordoMovimentacao->sql_record($sSqlAcordoMovimentacao);
        return db_utils::getCollectionByRecord($rsSqlAcordoMovimentacao);

    }

    /**
     * Mostra os valores contrato
     * @return objeto com o total atual, e total original do contrato
     */
    public function getValoresItens()
    {

        $oValores                    = new stdClass();
        $oValores->valororiginal     = $this->getValorContrato();
        $oValores->valoratual        = 0;
        $oValores->valoraditado      = 0;
        $oValores->percentualaditado = 0;

        foreach ($this->getItens() as $oItem) {
            $oValores->valoratual += $oItem->getValorTotal();
        }

        /**
         * o valor aditado deve ser a diferenca do valor aditado do valor original
         */

        $oValores->valoraditado += $oValores->valoratual - $oValores->valororiginal;
        $oValores->valoraditado = $oValores->valoraditado - $oValores->valororiginal;

        //se o valor aditado for maior que o original, calculamos o percentual
        $oValores->percentualaditado = number_format(abs(($oValores->valoraditado) * 100) / $oValores->valororiginal, 2, ".", "");

        return $oValores;
    }


    /**
     * funcao para atualizar o valor do contrato, baseado na soma dos itens
     * @return bool
     */
    public function atualizaValorContratoPorTotalItens($vigencia = 'f')
    {

        $oValorContrato = $this->getValoresItens();
        $nValorAtual    = $oValorContrato->valoratual;

        $oDaoAcordo                   = new cl_acordo();
        $oDaoAcordo->ac16_sequencial  = $this->getCodigoAcordo();
        $oDaoAcordo->ac16_valor       = $nValorAtual;
        $oDaoAcordo->ac16_semvigencia = $vigencia;
        $oDaoAcordo->alterar($oDaoAcordo->ac16_sequencial);
        if ($oDaoAcordo->erro_status == 0) {

            throw DBException($oDaoAcordo->erro_msg);
        }

        return true;
    }


    /**
     * Realiza um aditamento no contrato
     * Os tipos de aditamento são os listados abaixo:
     * @param $aItens
     * @param $iTipoAditamento
     * @param $dtVigenciaInicial
     * @param $dtVigenciaFinal
     * @param null $sNumeroAditamento
     * @param $dtAssinatura
     * @param $dtPublicacao
     * @param $sDescricaoAlteracao
     * @param $sVeiculoDivulgacao
     * @param $iTipoalteracaoAditivo
     * @param $sVigenciaalterada
     * @return $this
     * @throws Exception
     */
    public function aditar($aItens, $iTipoAditamento, $dtVigenciaInicial, $dtVigenciaFinal, $sNumeroAditamento, $dtAssinatura, $dtPublicacao, $sDescricaoAlteracao, $sVeiculoDivulgacao, $iTipoalteracaoAditivo, $aSelecionados, $sVigenciaalterada, $lProvidencia)
    {
        $nValorItens = 0;

        foreach ($aItens as $oItem) {
            $nValorItens += round($oItem->valorunitario * $oItem->quantidade, 2);
        }


        /**
         * cancelamos a ultima posição do acordo.
         */
        if ($iTipoAditamento != 5) {
            $this->getUltimaPosicao(true)->setSituacao(3);
        }

        $this->getUltimaPosicao()->save();

        $oNovaPosicao = new AcordoPosicao(null);
        $oNovaPosicao->setData(date("Y-m-d", db_getsession("DB_datausu")));
        $oNovaPosicao->setAcordo($this->getCodigoAcordo());
        $oNovaPosicao->setEmergencial(false);
        $oNovaPosicao->setNumero($this->getUltimaPosicao(true)->getNumero() + 1);
        $oNovaPosicao->setNumeroAditamento($this->validaNumeroAditamento($this->getCodigoAcordo(), $sNumeroAditamento));
        $oNovaPosicao->setSituacao(1);
        $oNovaPosicao->setTipo($iTipoAditamento);
        $oNovaPosicao->setVigenciaInicial($dtVigenciaInicial);
        $oNovaPosicao->setVigenciaFinal($dtVigenciaFinal);
        $oNovaPosicao->setPosicaoPeriodo($dtVigenciaInicial, $dtVigenciaFinal, $this->getPeriodoComercial());
        $oNovaPosicao->setVigenciaAlterada($sVigenciaalterada);

        $oNovaPosicao->save();

        $oNovaPosicao->salvarSaldoAditamento($nValorItens, $dtAssinatura, $dtPublicacao, $sDescricaoAlteracao, $sVeiculoDivulgacao);
        $aTiposAlteracao = array();

        if (in_array($iTipoAditamento, array(
            1,
            2,
            3,
            5
        )))
            $aTiposAlteracao[] = $iTipoAditamento;
        $sAtualDtInicial = $this->getDataInicial();
        $sAtualDtFim     = $this->getDataFinal();

        $sAtualDtInicial = DateTime::createFromFormat('d/m/Y', $this->getDataInicial());
        $sAtualDtFim = DateTime::createFromFormat('d/m/Y', $this->getDataFinal());

        $this->setDataInicial($dtVigenciaInicial);
        $this->setDataFinal($dtVigenciaFinal);
        /**
         * A providência do contrato é alterada para 2 (finalizada), se tiver sido redirecionado a partir do arquivo modulos.php
         */
        if($lProvidencia){
            $this->setProvidencia(2);
        }
        $this->salvarAlteracoesContrato();
        if (in_array($iTipoAditamento, array(
            5,
            6,
            7
        ))) {
            /**
             * Verifica se houve alteração do período de vigência do contrato
             */
            $sNovaDtInicial = DateTime::createFromFormat('d/m/Y', $this->getDataInicial());
            $sNovaDtFim = DateTime::createFromFormat('d/m/Y', $this->getDataFinal());

            if ($sAtualDtInicial != $sNovaDtInicial || $sAtualDtFim != $sNovaDtFim) {
                $aTiposAlteracao[] = 6;
            }
        }

        foreach ($aItens as $oItem) {

            $oItemContrato = $this->getUltimaPosicao(true)->getItemByCodigopcmater($oItem->codigoitem);

            $oNovoItem = new AcordoItem(null);
            $oNovoItem->setCodigoPosicao($oNovaPosicao->getCodigo());

            if (!empty($oItem->tipoalteracaoitem)) {
                $oNovoItem->setCodigoPosicaoTipo($oItem->tipoalteracaoitem);
            }

            if ($oItemContrato) {
                $oOrigemItem = $oItemContrato->getOrigem();
                $oNovoItem->setElemento($oItemContrato->getElemento());
                $oNovoItem->setMaterial($oItemContrato->getMaterial());
                $oNovoItem->setResumo($oItemContrato->getResumo());
                $oNovoItem->setOrigem($oOrigemItem->codigo, $oOrigemItem->tipo, $oOrigemItem->codigoorigem);
                $oNovoItem->setUnidade($oItemContrato->getUnidade());
                $oNovoItem->setTipoControle($oItemContrato->getTipocontrole());
                $oNovoItem->setItemVinculo($oItemContrato->getCodigo());
                $oNovoItem->setServicoQuantidade($oItemContrato->getServicoQuantidade());

                $aPeriodosItem = $oItemContrato->getPeriodosItem();

                if (in_array($iTipoAditamento, array(
                    5,
                    6,
                    7
                ))) {
                    /**
                     * Verifica se houve alteração do período de execução do ítem.
                     */
                    $sNovaDtExecucaoInicio = DateTime::createFromFormat('d/m/Y', $oItem->dtexecucaoinicio);
                    $sNovaDtExecucaoFim = DateTime::createFromFormat('d/m/Y', $oItem->dtexecucaofim);
                    if (($sNovaDtExecucaoInicio != $aPeriodosItem[0]->dtDataInicial) || ($sNovaDtExecucaoFim != $aPeriodosItem[0]->dtDataFinal)) {
                        $aPeriodosItem[0]->dtDataInicial = $oItem->dtexecucaoinicio;
                        $aPeriodosItem[0]->dtDataFinal   = $oItem->dtexecucaofim;
                        $aTiposAlteracao[]               = 8;
                    }
                }
                if (!empty($aPeriodosItem)) {
                    $oNovoItem->setPeriodos($aPeriodosItem);
                }
            } else {

                $oNovoItem->setElemento($oItem->codigoelemento);
                $oNovoItem->setMaterial(new MaterialCompras($oItem->codigoitem));
                $oNovoItem->setResumo(utf8_decode(db_stdClass::db_stripTagsJson($oItem->resumo)));
                $oNovoItem->setUnidade($oItem->unidade);
                $oNovoItem->setTipoControle(AcordoItem::CONTROLE_DIVISAO_QUANTIDADE);
                if($oItem->controlaServico == "true"){
                    $oNovoItem->setServicoQuantidade(true);
                }else{
                    $oNovoItem->setServicoQuantidade(false);
                }

                if (!empty($oItem->aPeriodos)) {
                    $oNovoItem->setPeriodos($oItem->aPeriodos);
                }
            }
            //removido OC12680
//            if (in_array($iTipoAditamento, array(
//                    4,
//                    7
//                )) && in_array($oItem->codigoitem, $aSelecionados) && empty($oItem->tipoalteracaoitem)) {
//                /**
//                 * Verifica se houve alteração de quantidade/valor
//                 */
//                if ($oItem->quantidade > $oItemContrato->getQuantidadeAtualizada() || $oItem->valorunitario > $oItemContrato->getValorUnitario()) {
//                    $aTiposAlteracao[] = AcordoPosicao::TIPO_ACRESCIMOITEM;
//                    $oNovoItem->setCodigoPosicaoTipo(AcordoPosicao::TIPO_ACRESCIMOITEM);
//                } elseif ($oItem->quantidade < $oItemContrato->getQuantidadeAtualizada() || $oItem->valorunitario < $oItemContrato->getValorUnitario()) {
//                    $aTiposAlteracao[] = AcordoPosicao::TIPO_DECRESCIMOITEM;
//                    $oNovoItem->setCodigoPosicaoTipo(AcordoPosicao::TIPO_DECRESCIMOITEM);
//                }
//
//            }
            $oNovoItem->setQuantidade((float) $oItem->quantidade);
            $oNovoItem->setValorAditado((float) $oItem->valoraditado); //OC5304
            $oNovoItem->setQuantiAditada((float) $oItem->quantiaditada); //OC5304
            $oNovoItem->setValorUnitario((float) $oItem->valorunitario);
            $oNovoItem->setValorTotal(round($oItem->valorunitario * $oItem->quantidade, 2));


            foreach ($oItem->dotacoes as $oDotacao) {

                $oDotacao->ano = db_getsession("DB_anousu");
                $oNovoItem->adicionarDotacoes($oDotacao);
            }
            /*
             * Alterado opcao para false para nao gerar reserva conforme solicitado por Mario
             */
            $oNovoItem->save(false);
        }

        if (count(array_unique($aTiposAlteracao)) > 1) {

            if (in_array(AcordoPosicao::TIPO_VIGENCIA, $aTiposAlteracao) && in_array(AcordoPosicao::TIPO_EXECUCAO, $aTiposAlteracao)) {
                $iTipoAditamento = AcordoPosicao::TIPO_VIGENCIAEXECUCAO;
            }
            if (in_array(AcordoPosicao::TIPO_ACRESCIMOITEM, $aTiposAlteracao) && in_array(AcordoPosicao::TIPO_DECRESCIMOITEM, $aTiposAlteracao)) {
                $iTipoAditamento = AcordoPosicao::TIPO_ACRESCIMODECRESCIMOITEM;
            }
            if (in_array(AcordoPosicao::TIPO_ACRESCIMOITEM, $aTiposAlteracao) && in_array(AcordoPosicao::TIPO_DECRESCIMOITEM, $aTiposAlteracao) && count(array_unique($aTiposAlteracao)) > 2) {
                $iTipoAditamento = AcordoPosicao::TIPO_ACRESCIMODECRESCIMOITEMCONJUGADO;
            }
        } else {

            $iTipoAditamento = $iTipoalteracaoAditivo != "" ? $iTipoalteracaoAditivo : $aTiposAlteracao[0];
        }
        /**
         * Caso tenha escolhido o tipo do aditamento na tela de inclusao de outros aditivos
         */
        $iTipoAditamento = $iTipoalteracaoAditivo != "" ? $iTipoalteracaoAditivo : $iTipoAditamento;

        if ($iTipoAditamento == "") {
            throw new BusinessException("Nenhuma alteração realizada.");
        }

        $oNovaPosicao->setTipo($iTipoAditamento);
        $oNovaPosicao->save();

        return $this;
    }

    /**
     * retorna as movimentações realizas pelo acordo.
     *
     * @return array
     */
    public function getMovimentacoes()
    {

        $oDaoAcordoMovimentacao = db_utils::getDao("acordomovimentacao");
        $sSqlMov                = $oDaoAcordoMovimentacao->sql_query(null, "ac09_descricao as descricao,
        ac10_hora as hora,
        ac10_datamovimento,
        ac10_obs as observacao", "ac10_sequencial", "ac10_acordo = {$this->getCodigoAcordo()}");
        $rsMovimentos           = $oDaoAcordoMovimentacao->sql_record($sSqlMov);
        return db_utils::getCollectionByRecord($rsMovimentos);
    }

    /**
     *
     * Retorna todos os documentos para o acordo selecionado
     */
    public function getDocumentos()
    {

        $sCampos = "ac40_sequencial ";
        $sWhere  = " ac40_acordo = {$this->getCodigoAcordo()}";

        $oDaoAcordoDocumento = db_utils::getDao("acordodocumento");
        $sSqlDocumentos      = $oDaoAcordoDocumento->sql_query_file(null, $sCampos, 'ac40_sequencial', $sWhere);
        $rsAcordoDocumento   = $oDaoAcordoDocumento->sql_record($sSqlDocumentos);
        if ($oDaoAcordoDocumento->numrows > 0) {

            for ($i = 0; $i < $oDaoAcordoDocumento->numrows; $i++) {

                $this->aDocumento[] = new AcordoDocumento(db_utils::fieldsMemory($rsAcordoDocumento, $i)->ac40_sequencial);
            }
        }

        return $this->aDocumento;

    }

    /**
     *
     * Adiciona um Documento para o Acordo selecionado
     * @param String $sDescricao
     * @param Arquivo $sArquivo (caminho/nome do arquivo)
     */
    public function adicionarDocumento($sDescricao, $sArquivo)
    {

        $oAcordoDocumento = new AcordoDocumento();
        $oAcordoDocumento->setArquivo($sArquivo);
        $oAcordoDocumento->setDescricao($sDescricao);
        $oAcordoDocumento->setCodigoAcordo($this->getCodigoAcordo());

        $aNomeArquivo = explode("/", $sArquivo);
        $sNomeArquivo = str_replace(" ", "_", $aNomeArquivo[1]);
        $oAcordoDocumento->setNomeArquivo($sNomeArquivo);
        $oAcordoDocumento->salvar();

    }

    /**
     *
     * Remove o Documento para o Acordo selecionado
     * @param integer $iCodigoDocumento
     */
    public function removeDocumento($iCodigoDocumento)
    {

        $oAcordoDocumento = new AcordoDocumento($iCodigoDocumento);
        $oAcordoDocumento->remover();

    }


    /**
     * Seta a quantidade ( em dia/mes) referente ao periodo de vigendia
     * @param integer $iQtdPeriodoVigencia
     */
    public function setQtdPeriodoVigencia($iQtdPeriodoVigencia)
    {

        $this->iQtdPeriodoVigencia = $iQtdPeriodoVigencia;
    }

    /**
     * Seta a unidade de tempo (dia/mes) referente ao período de vigência
     * @param integer $iTipoUnidadeTempoVigencia
     */
    public function setTipoUnidadeTempoVigencia($iTipoUnidadeTempoVigencia)
    {

        $this->iTipoUnidadeTempoVigencia = $iTipoUnidadeTempoVigencia;
    }

    /**
     * Seta a categoria do Acordo
     * @param integer $iCategoriaAcordo
     */
    public function setCategoriaAcordo($iCategoriaAcordo)
    {

        $this->iCategoriaAcordo = $iCategoriaAcordo;
    }

    /**
     * Retorna a quantidade ( em dia/mes) referente ao periodo de vigendia
     * @param integer $iQtdPeriodoVigencia
     */
    public function getQtdPeriodoVigencia()
    {

        return $this->iQtdPeriodoVigencia;
    }

    /**
     * Retorna a unidade de tempo (dia/mes) referente ao período de vigência
     * @param integer $iTipoUnidadeTempoVigencia
     */
    public function getTipoUnidadeTempoVigencia()
    {

        return $this->iTipoUnidadeTempoVigencia;
    }

    /**
     * Retorna a categoria do Acordo
     * @param integer $iCategoriaAcordo
     */
    public function getCategoriaAcordo()
    {

        return $this->iCategoriaAcordo;
    }

    /**
     * retorna a descricao da categoria do acordo
     * @param integer categoria
     * @return string sCategoria
     */
    public static function getDescricaoCategoriaAcordo($iCategoria = 0)
    {

        $sCategoria    = 'Não Informado';
        $oDaoCategoria = db_utils::getDao("acordocategoria");
        $sSqlCategoria = $oDaoCategoria->sql_query_file(null, "*", null, "ac50_sequencial = {$iCategoria}");


        $rsCategoria = $oDaoCategoria->sql_record($sSqlCategoria);
        if ($oDaoCategoria->numrows > 0) {

            $sCategoria = db_utils::fieldsMemory($rsCategoria, 0)->ac50_descricao;
        }
        return $sCategoria;
    }


    /**
     * Valida se periodo tem execucao
     *
     * @param integer $iCodigoPeriodo
     * @param DBDate $oDataInicial
     * @param DBDate $oDataFinal
     * @access public
     * @return boolean
     */
    public function verificaSeTemExecucaoPeriodo($iCodigoPeriodo = null, DBDate $oDataInicial, DBDate $oDataFinal)
    {

        $oDaoAcordoposicao = db_utils::GetDao('acordoposicao');
        $sDataInicial      = $oDataInicial->getDate();
        $sDataFinal        = $oDataFinal->getDate();

        $sCampos = "ac37_sequencial";
        $sWhere  = "  ac26_acordo = {$this->getCodigoAcordo()}";
        $sWhere .= "  and ('$sDataInicial', '$sDataFinal') overlaps (ac37_datainicial, ac37_datafinal)                                    ";
        $sWhere .= "  and ac37_quantidadeprevista <= (select sum(aie.ac29_quantidade)                                                     ";
        $sWhere .= "                                    from acordoitemexecutadoperiodo                                                   ";
        $sWhere .= "                                         inner join acordoitemexecutado aie on aie.ac29_sequencial = acordoitemexecutadoperiodo.ac38_acordoitemexecutado";
        $sWhere .= "                                   where ac38_acordoitemprevisao = aip.ac37_sequencial )            ";

        if (!empty($iCodigoPeriodo)) {

            $sWhere .= " and acordoitem.ac20_sequencial = (select ac41_acordoitem                      ";
            $sWhere .= "                                     from acordoitemperiodo                    ";
            $sWhere .= "                                    where ac41_sequencial = {$iCodigoPeriodo}) ";
        }

        $sSqlVerificaPeriodo = $oDaoAcordoposicao->sql_query_periodo_execucao(null, $sCampos, null, $sWhere);

        $rsVerificaPeriodo = $oDaoAcordoposicao->sql_record($sSqlVerificaPeriodo);

        if ($oDaoAcordoposicao->numrows > 0) {
            return false;
        }

        return true;
    }

    /**
     * Remove um acordo e seus dependentes
     *
     * @throws DBException
     * @throws BusinessException
     */
    public function remover()
    {
        $oDaoAcordo = new cl_acordo();

        if (!db_utils::inTransaction()) {
            throw new DBException(_M(self::MENSAGENS . "sem_transacao_ativa"));
        }

        if ($this->getCodigoAcordo() == null) {
            throw new BusinessException(_M(self::MENSAGENS . "sequencial_nao_existente"));
        }

        /**
         * Valida se o contrato está homologado
         */
        if ($this->getSituacao() != 1) {
            throw new BusinessException(_M(self::MENSAGENS . "contrato_homologado"));
        }

        if (!$oDaoAcordo->apagaDependencias($this->getCodigoAcordo())) {
            throw new BusinessException("Não foi possível apagar as dependências do acordo {$this->getCodigo()}.");
        }

        if ($this->possuiLancamentoContabil()) {
            throw new BusinessException("O acordo {$this->getCodigo()} possui lançamento contábil vinculado. Procedimento abortado.");
        }

        $oDataInicial = new DBDate($this->getDataInicial());
        $oDataFinal   = new DBDate($this->getDataFinal());

        /**
         * Valida se existe execução dentro do período do contrato, não permitindo a remoção
         */
        if (!$this->verificaSeTemExecucaoPeriodo(null, $oDataInicial, $oDataFinal)) {

            $oDados               = new stdClass();
            $oDados->sDataInicial = $oDataInicial->getDate(DBDate::DATA_PTBR);
            $oDados->sDataFinal   = $oDataFinal->getDate(DBDate::DATA_PTBR);
            throw new BusinessException(_M(self::MENSAGENS . "periodo_com_execucao", $oDados));
        }

        /**
         * Busca as movimentações canceladas de um acordo, removendo-as
         */
        $oDaoAcordoMovimentacaoCancela   = new cl_acordomovimentacaocancela();
        $sWhereAcordoMovimentacaoCancela = "ac10_acordo = {$this->getCodigoAcordo()}";
        $sSqlAcordoMovimentacaoCancela   = $oDaoAcordoMovimentacaoCancela->sql_query(null, "ac25_sequencial", null, $sWhereAcordoMovimentacaoCancela);
        $rsAcordoMovimentacaoCancela     = $oDaoAcordoMovimentacaoCancela->sql_record($sSqlAcordoMovimentacaoCancela);
        $iTotalAcordoMovimentacaoCancela = $oDaoAcordoMovimentacaoCancela->numrows;

        if ($iTotalAcordoMovimentacaoCancela > 0) {

            for ($iContador = 0; $iContador < $iTotalAcordoMovimentacaoCancela; $iContador++) {

                $iAcordoMovimentacaoCancela = db_utils::fieldsMemory($rsAcordoMovimentacaoCancela, $iContador)->ac25_sequencial;
                $oDaoAcordoMovimentacaoCancela->excluir($iAcordoMovimentacaoCancela, null);

                if ($oDaoAcordoMovimentacaoCancela->erro_status == 0) {
                    throw new BusinessException($oDaoAcordoMovimentacaoCancela->erro_msg);
                }
            }
        }

        /**
         * Remove as movimentações vinculadas ao acordo
         */
        $oDaoAcordoMovimentacao   = new cl_acordomovimentacao();
        $sWhereACordoMovimentacao = "ac10_acordo = {$this->getCodigoAcordo()}";
        $oDaoAcordoMovimentacao->excluir(null, $sWhereACordoMovimentacao);

        if ($oDaoAcordoMovimentacao->erro_status == 0) {
            throw new BusinessException($oDaoAcordoMovimentacao->erro_msg);
        }

        /**
         * Percorre as posições do acordo, removendo as mesmas
         */
        foreach ($this->getPosicoes() as $oAcordoPosicao) {
            $oAcordoPosicao->remover();
        }

        /**
         * Percorre as penalidades do acordo, removendo as mesmas
         */

        $oDaoAcordoPenalidade     = new cl_acordoacordopenalidade;
        $sWhereExclusaoPenalidade = " ac15_acordo = {$this->getCodigoAcordo()}";
        $oDaoAcordoPenalidade->excluir(null, $sWhereExclusaoPenalidade);
        if ($oDaoAcordoPenalidade->erro_status == 0) {
            throw new BusinessException($oDaoAcordoPenalidade->erro_msg);
        }

        /**
         * Percorre as garantias do acordo, removendo as mesmas
         */
        $sWhereGarantias    = " ac12_acordo = {$this->getCodigoAcordo()}";
        $oDaoAcordoGarantia = new cl_acordoacordogarantia();
        $oDaoAcordoGarantia->excluir(null, $sWhereGarantias);
        if ($oDaoAcordoGarantia->erro_status == 0) {
            throw new BusinessException($oDaoAcordoGarantia->erro_msg);
        }

        /**
         * Percorre os documentos do acordo, removendo os mesmos
         */
        foreach ($this->getDocumentos() as $oAcordoDocumento) {
            $oAcordoDocumento->remover();
        }

        /**
         * Remover dos vinculos com empemeho
         */
        $oDaoEmpenhoContrato = new cl_empempenhocontrato();
        $oDaoEmpenhoContrato->excluir(null, "e100_acordo={$this->getCodigoAcordo()}");
        if ($oDaoEmpenhoContrato->erro_status == 0) {
            throw new BusinessException($oDaoEmpenhoContrato->erro_msg);
        }

        /**
         * Remove o acordo
         */
        $oDaoAcordo->excluir($this->getCodigoAcordo());

        if ($oDaoAcordo->erro_status == 0) {
            throw new BusinessException($oDaoAcordo->erro_msg);
        }
    }

    /**
     * Realiza a paralisação de um Contrato
     *
     * @param DBDate $oDataInicio data de inicio da Paralisação
     * @param string $sObervacao Observação
     * @throws BusinessException contrato já esta paralizado
     * @throws DBException Não existe transação ativa
     * @return AcordoParalisacao
     */
    public function paralisar(DBDate $oDataInicio, $sObervacao)
    {

        if ($this->getSituacao() == self::CONTRATO_PARALISADO) {
            throw new BusinessException(_M(self::MENSAGENS . 'contrato_ja_paralisado'));
        }

        if (!db_utils::inTransaction()) {
            throw new DBException(_M(self::CAMINHO_MENSAGEM . 'sem_transacao_ativa'));
        }

        $oParalisacao = new AcordoParalisacao();
        $oParalisacao->setAcordo($this);
        $oParalisacao->setDataInicio($oDataInicio);
        $oParalisacao->setObservacao($sObervacao);
        $oParalisacao->salvar();
        return $oParalisacao;
    }

    /**
     * Retorna todas as paralisações do contrato
     * @return AcordoParalisacao[]
     * @throws DBException
     */
    public function getParalisacoes()
    {

        if (count($this->aParalisacoes) == 0 && !empty($this->iCodigoAcordo)) {

            $oDaoAcordoParalisacao = new cl_acordoparalisacao();

            $sWhereParalisacao = "ac47_acordo = {$this->getCodigoAcordo()} ";
            $sSqlParalisacoes  = $oDaoAcordoParalisacao->sql_query_file(null, "ac47_sequencial", "ac47_sequencial", $sWhereParalisacao);
            $rsParalisacao     = $oDaoAcordoParalisacao->sql_record($sSqlParalisacoes);
            for ($iParalisacao = 0; $iParalisacao < $oDaoAcordoParalisacao->numrows; $iParalisacao++) {

                $iCodigoParalisacao    = db_utils::fieldsMemory($rsParalisacao, $iParalisacao)->ac47_sequencial;
                $this->aParalisacoes[] = new AcordoParalisacao($iCodigoParalisacao);
            }
        }

        return $this->aParalisacoes;
    }

    /**
     * Retorna a última paralisação do acordo
     * @return AcordoParalisacao|null
     */
    public function getUltimaParalisacao()
    {

        $aParalisacoes = $this->getParalisacoes();
        if (count($aParalisacoes) == 0) {
            return null;
        }
        return $aParalisacoes[count($aParalisacoes) - 1];
    }

    /**
     * Define a classificado do acordo
     * @param AcordoClassificacao $oClassificacao
     */
    public function setClassificacao(AcordoClassificacao $oClassificacao)
    {
        $this->oClassificacao = $oClassificacao;
    }

    /**
     * Retorna a cassificacao do acordo
     * @return AcordoClassificacao
     */
    public function getClassificacao()
    {

        if (!$this->oClassificacao instanceof AcordoClassificacao) {
            $this->oClassificacao = new AcordoClassificacao($this->iClassificacao);
        }

        return $this->oClassificacao;
    }

    /**
     * retorna o valor do contrato / acordo
     * @return number $this->nValorContrato
     */
    public function getValorContrato()
    {
        return $this->nValorContrato;
    }

    /**
     * define o valor contrato / acordo
     * @param number $nValorContrato
     */
    public function setValorContrato($nValorContrato)
    {
        $this->nValorContrato = $nValorContrato;
    }

    /**
     * Retorna o numero anual do acordo
     *
     * @return integer $iNumeroEmpenho
     */
    public function getNumeroAcordo()
    {
        return $this->iNumeroAcordo;
    }

    /**
     * Define o numero do contrato de a
     * @param $iNumeroAcordo
     */
    public function setNumeroAcordo($iNumeroAcordo)
    {
        $this->iNumeroAcordo = $iNumeroAcordo;
    }

    /**
     * @return int
     */
    public function getProvidencia(){

        return $this->lProvidencia;
    }

    /**
     * @param int $lProvidencia
     * @return $lProvidencia
     */

    public function setProvidencia($lProvidencia){

        $this->lProvidencia = $lProvidencia;
    }

    /**
     *
     * função para reativar um contrato apos um periodo de paralisação
     *
     * @param array $aPeriodos periodos a serem recriados
     * @param object $oDataAtivacao data da reativacao
     * @param string $sObservacao observacao do movimento de reativacao
     * @return bool
     *
     */
    public function reativar(array $aPeriodos, DBDate $oDataAtivacao, $sObservacao)
    {

        $oUltimaParalisacao = $this->getUltimaParalisacao();
        if (empty($oUltimaParalisacao)) {
            throw new BusinessException(_M(self::MENSAGENS . ('contrato_nao_paralisado')));
        }
        $dtTermino = $oUltimaParalisacao->getDataTermino();

        if (!empty($dtTermino)) {

            throw new BusinessException(_M(self::MENSAGENS . ('paralisacao_ja_retomada')));
        }

        $oReativacaoAcordo = new AcordoReativacao($oUltimaParalisacao);
        $oReativacaoAcordo->setDataReativacao($oDataAtivacao);
        $oReativacaoAcordo->setPeriodosParalizados($aPeriodos);
        $oReativacaoAcordo->setObservacao($sObservacao);

        $oReativacaoAcordo->salvar();
    }

    public function cancelarReativacao(array $aPeriodos, $sObservacao)
    {

        $oUltimaParalisacao = $this->getUltimaParalisacao();
        $oReativacaoAcordo  = new AcordoReativacao($oUltimaParalisacao);
        $oReativacaoAcordo->setPeriodosParalizados($aPeriodos);
        $oReativacaoAcordo->setObservacao($sObservacao);
        $oReativacaoAcordo->cancelar();
    }

    /**
     * Retorna proxima numeracao anual do acordo
     *
     * @return integer
     */
    public static function getProximoNumeroDoAno($iAno, $iInstituicao)
    {

        $oDaoAcordo      = new cl_acordo();
        $sWhere          = "ac16_anousu = {$iAno} and ac16_instit = {$iInstituicao}";
        $sCampo          = "(coalesce(max(ac16_numeroacordo), 0) + 1) as numero";
        $sSqlNumeroAnual = $oDaoAcordo->sql_query_file(null, $sCampo, null, $sWhere);
        $rsNumeroAnual   = db_query($sSqlNumeroAnual);

        if (!$rsNumeroAnual) {
            throw new Exception("Erro ao buscar próximo número do acordo." . pg_last_error());
        }

        return (int) db_utils::fieldsMemory($rsNumeroAnual, 0)->numero;
    }

    /**
     * Retorna proxima numeracao do aditivo
     * @param $iContrato
     * @return int
     * @throws Exception
     */
    public function getProximoNumeroAditivo($iContrato)
    {
        $sSqlNumeroAditivo = "select max(ac26_numeroaditamento::int)+1 proximo
      from
      acordoposicaoaditamento
      inner join acordoposicao on ac26_sequencial = ac35_acordoposicao
      where ac26_acordo = {$iContrato} and ac26_numeroaditamento <> ''";
        $rsNumeroAditivo   = db_query($sSqlNumeroAditivo);

        if (!$rsNumeroAditivo) {
            throw new Exception("Erro ao buscar próximo número do aditivo.");
        }

        return (int) db_utils::fieldsMemory($rsNumeroAditivo, 0)->proximo == "" ? 1 : (int) db_utils::fieldsMemory($rsNumeroAditivo, 0)->proximo;
    }

    /**
     * Retorna proxima numeracao do apostilamento
     * @param $iContrato
     * @return int
     * @throws Exception
     */
    public function getProximoNumeroApostila($iContrato)
    {
        $sSqlNumeroApostilamento = "select max(si03_numapostilamento)+1 proximo
      from
      apostilamento
      where si03_acordo = {$iContrato} and si03_numapostilamento is not null";
        $rsNumeroApostilamento   = db_query($sSqlNumeroApostilamento);

        if (!$rsNumeroApostilamento) {
            throw new Exception("Erro ao buscar próximo número do apostilamento.");
        }

        return (int) db_utils::fieldsMemory($rsNumeroApostilamento, 0)->proximo == "" ? 1 : (int) db_utils::fieldsMemory($rsNumeroApostilamento, 0)->proximo;
    }

    /**
     * Valida se o número do aditivo é válido.
     * Se já existir um numero de aditivo para o contrato o sistema não permite a inclusão do aditamento.
     * @param $iContrato
     * @param $sNumeroAditivo
     * @return $sNumeroAditivo
     * @throws Exception
     */

    public function validaNumeroAditamento($iContrato, $sNumeroAditivo)
    {

        $sSql            = "select * from acordoposicao where ac26_acordo = {$iContrato} and ac26_numeroaditamento = '{$sNumeroAditivo}'";
        $rsNumeroAditivo = db_query($sSql);

        if (pg_num_rows($rsNumeroAditivo) > 0) {
            throw new Exception("A numeração {$sNumeroAditivo} já existe para o contrato {$iContrato}. A próxima numeração disponível é: " . $this->getProximoNumeroAditivo($iContrato));
        }

        return $sNumeroAditivo;

    }

    /**
     * Valida se o número do apostilamento é válido.
     * Se já existir um numero de apostilamento para o contrato o sistema não permite a inclusão do apostilamento.
     * @param $iContrato
     * @param $sNumeroApostilamento
     * @return $sNumeroApostilamento
     * @throws Exception
     */

    public function validaNumeroApostilamento($iContrato, $sNumeroApostilamento)
    {

        $oDaoAcordoPosicao     = db_utils::getDao("acordoposicao");
        $sSql                  = $oDaoAcordoPosicao->sql_query_file(null, "*", "", "ac26_acordo = {$iContrato} and ac26_numeroapostilamento = '{$sNumeroApostilamento}'");
        $rsNumeroApostilamento = db_query($sSql);

        if (pg_num_rows($rsNumeroApostilamento) > 0) {
            throw new Exception("Já existe uma posição com numeração {$sNumeroApostilamento} e contrato {$iContrato}.");
        }

        return $sNumeroApostilamento;

    }

    public function getTipoCompraTribunal($iLicitacao){

        if($iLicitacao == null){
            $sPCtipocompraTribunal = null;
        }else{
            $oDaoLicilicitem = db_utils::getDao("liclicitem");
            $sql = $oDaoLicilicitem->sql_tipocompratribunal($iLicitacao);
            $rsPctipocompraTribunal = db_query($sql);
            $sPCtipocompraTribunal =  db_utils::fieldsMemory($rsPctipocompraTribunal, 0)->l03_pctipocompratribunal;
            if (pg_num_rows($rsPctipocompraTribunal) < 0) {
                throw new Exception("Erro tipo compra tribunal nao encontrado.");
            }
        }

        return $sPCtipocompraTribunal;
    }



    /**
     * Método que verifica se o acordo possui algum lançamento contábil vinculado.
     * @return bool
     */
    public function possuiLancamentoContabil()
    {

        $oDaoConlancamAcordo = new cl_conlancamacordo();
        $sSqlBuscaAcordo     = $oDaoConlancamAcordo->sql_query_file(null, "*", null, "c87_acordo = {$this->iCodigoAcordo}");
        $rsBuscaAcordo       = $oDaoConlancamAcordo->sql_record($sSqlBuscaAcordo);
        if ($oDaoConlancamAcordo->numrows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Retorna os itens do Acordo, com a posicao Atualizada do item
     * @return AcordoItem[]
     */
    public function getItens()
    {

        $aItens         = array();
        $oDaoAcordoitem = new cl_acordoitem;
        $sCampos        = "ac20_ordem, ac20_valoraditado, ac20_quantidadeaditada, sum(case when ac26_acordoposicaotipo <> " . AcordoPosicao::TIPO_REEQUILIBRIO . " then ac20_quantidade else 0 end) as quantidade, ";
        $sCampos .= "sum(ac20_valortotal) as valortotal, ";
        $sCampos .= "pc01_descrmater, pc01_codmater, max(ac20_sequencial) as codigo, max(ac20_acordoposicao) as posicao, ";
        $sCampos .= "m61_codmatunid, m61_abrev ";
        $sWhere       = "ac16_sequencial = {$this->getCodigo()} ";
        $sGroup       = "group by ac20_ordem, pc01_descrmater, pc01_codmater, m61_codmatunid, m61_abrev, ac20_valoraditado, ac20_quantidadeaditada ";
        $sSqlItens    = $oDaoAcordoitem->sql_query_transparencia($sCampos, "ac20_ordem", $sWhere . $sGroup);
        $rsItem       = $oDaoAcordoitem->sql_record($sSqlItens);
        $iTotalLinhas = $oDaoAcordoitem->numrows;
        for ($iItem = 0; $iItem < $iTotalLinhas; $iItem++) {

            $oDadosItem = db_utils::fieldsMemory($rsItem, $iItem);
            $oItem      = new AcordoItem($oDadosItem->codigo);
            $oItem->setCodigoPosicao($oDadosItem->posicao);
            $oItem->setCodigo($oDadosItem->codigo);
            $oItem->setMaterial(MaterialComprasRepository::getByCodigo($oDadosItem->pc01_codmater));
            $oItem->setQuantidade($oDadosItem->quantidade);
            $oItem->setValorAditado($oDadosItem->ac20_valoraditado); //OC5304
            $oItem->setQuantiAditada($oDadosItem->ac20_quantidadeaditada); //OC5304
            $oItem->setValorTotal($oDadosItem->valortotal);
            $oItem->setUnidade($oDadosItem->m61_codmatunid);
            $oItem->setDescricaoUnidade($oDadosItem->m61_abrev);
            $oItem->setOrdem($oDadosItem->ac20_ordem);
            $aItens[] = $oItem;
        }
        return $aItens;

    }

    public function getDotacoesAcordo(){
        $sql = "select DISTINCT ac22_coddot AS ficha,
                o15_codtri AS fonterecurso,
                o58_projativ AS projetoativ,
                o56_elemento as codorcamentario
                from acordoposicao 
            inner join acordoitem on ac20_acordoposicao = ac26_sequencial
            inner join acordoitemdotacao on ac22_acordoitem = ac20_sequencial
            INNER JOIN orcdotacao ON (orcdotacao.o58_anousu,orcdotacao.o58_coddot) = (acordoitemdotacao.ac22_anousu,acordoitemdotacao.ac22_coddot)
            INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
            INNER JOIN orcelemento on (orcelemento.o56_codele,orcelemento.o56_anousu) = (orcdotacao.o58_codele,orcdotacao.o58_anousu)
            where ac26_acordo = {$this->getCodigo()}";

        $rsDotacao = db_query($sql);

        for ($iDot = 0; $iDot < pg_numrows($rsDotacao); $iDot++) {
            $oDadosDotacoes = db_utils::fieldsMemory($rsDotacao, $iDot);
            $aDotacoes[] = $oDadosDotacoes;
        }
            return $aDotacoes;
    }

    public function getSaldoItemPosicao($iPcmater,$iPosicao){
        $oSaldo                             = new stdClass();

        $sSqlSaldos  = "SELECT coalesce(sum(case when ac29_tipo = 1 then ac29_valor end), 0) as valorAutorizado,";
        $sSqlSaldos .= "       coalesce(sum(case when ac29_tipo = 1 then  ac29_quantidade end), 0) as quantidadeautorizada,";
        $sSqlSaldos .= "       coalesce(sum(case when ac29_tipo = 2 then ac29_valor end),0) as valorExecutado,";
        $sSqlSaldos .= "       coalesce(sum(case when ac29_tipo = 2 then  ac29_quantidade end),0) as quantidadeexecutada,";
        $sSqlSaldos .= "       coalesce(sum(case when ac29_tipo = 1 and ac29_automatico is false ";
        $sSqlSaldos .= "                         then ac29_valor end), 0) as valorAutorizadoManual,";
        $sSqlSaldos .= "       coalesce(sum(case when ac29_tipo = 1 and ac29_automatico is false ";
        $sSqlSaldos .= "                         then  ac29_quantidade end), 0) as quantidadeautorizadaManual";
        $sSqlSaldos .= "  from acordoitemexecutado ";
        $sSqlSaldos .= "  inner join acordoitem on ac29_acordoitem = ac20_sequencial ";
        $sSqlSaldos .= "  inner join acordoposicao on ac20_acordoposicao = ac26_sequencial ";
        $sSqlSaldos .= " where ac20_pcmater = $iPcmater and ac26_sequencial = $iPosicao";
        $rsSaldos    = db_query($sSqlSaldos);

          $oCalculoSaldo                       = db_utils::fieldsMemory($rsSaldos, 0);
//        $oSaldo->valorautorizado             = $oCalculoSaldo->valorautorizado;
//        $oSaldo->valorexecutado              = $oCalculoSaldo->valorexecutado;
        $oSaldo->quantidadeautorizada        = $oCalculoSaldo->quantidadeautorizada;
        $oSaldo->quantidadeexecutada         = $oCalculoSaldo->quantidadeexecutada;
//        $oSaldo->valorautorizar             -= $oSaldo->valorautorizado;
//        $oSaldo->quantidadeautorizar        -= $oSaldo->quantidadeautorizada;
//        $oSaldo->valorexecutar              -= $oSaldo->valorexecutado;
//        $oSaldo->quantidadeexecutar         -= $oSaldo->quantidadeexecutada;
//        $oSaldo->quantidadeautorizadamanual  = $oCalculoSaldo->quantidadeautorizadamanual;
//        $oSaldo->valorautorizadomanual       = $oCalculoSaldo->valorautorizado;
        return $oSaldo->quantidadeautorizada;
    }

    /**
     * retorna os itens na possição inicial
     * @return Acordoitem[]
     */
    public function getItensPosicaoInicial()
    {
        $aItens         = array();
        $oDaoAcordoitem = new cl_acordoitem;
        $sCampos        = "ac20_ordem, sum(case when ac26_acordoposicaotipo <> " . AcordoPosicao::TIPO_REEQUILIBRIO . " then ac20_quantidade else 0 end) as quantidade, ";
        $sCampos .= "sum(ac20_valortotal) as valortotal, ";
        $sCampos .= "pc01_descrmater, pc01_codmater, max(ac20_sequencial) as codigo, max(ac20_acordoposicao) as posicao, ";
        $sCampos .= "m61_codmatunid, m61_abrev ";
        $sWhere       = "ac16_sequencial = {$this->getCodigo()} and ac26_acordoposicaotipo = 1";
        $sGroup       = "group by ac20_ordem, pc01_descrmater, pc01_codmater, m61_codmatunid, m61_abrev ";
        $sSqlItens    = $oDaoAcordoitem->sql_query_transparencia($sCampos, "ac20_ordem", $sWhere . $sGroup);
        $rsItem       = $oDaoAcordoitem->sql_record($sSqlItens);
        $iTotalLinhas = $oDaoAcordoitem->numrows;
        for ($iItem = 0; $iItem < $iTotalLinhas; $iItem++) {

            $oDadosItem = db_utils::fieldsMemory($rsItem, $iItem);
            $oItem      = new AcordoItem($oDadosItem->codigo);
            $oItem->setCodigoPosicao($oDadosItem->posicao);
            $oItem->setCodigo($oDadosItem->codigo);
            $oItem->setMaterial(MaterialComprasRepository::getByCodigo($oDadosItem->pc01_codmater));
            $oItem->setQuantidade($oDadosItem->quantidade);
            $oItem->setValorTotal($oDadosItem->valortotal);
            $oItem->setUnidade($oDadosItem->m61_codmatunid);
            $oItem->setDescricaoUnidade($oDadosItem->m61_abrev);
            $oItem->setOrdem($oDadosItem->ac20_ordem);
            $aItens[] = $oItem;
        }
        return $aItens;

    }

    /**
     * Função que verifica se a data de assinatura do acordo é anterior a data de homologação da licitação
     * @param $iLicitacao
     * @param $sDataAssinatura
     * @param $bDispensa
     * @return boolean
     */
    function validaDataAssinatura($iLicitacao, $sDataAssinatura, $bDispensa = false)
    {

        $sCampo          = $bDispensa ? "l20_dtpubratificacao" : "l202_datahomologacao";
        $sSql            = $bDispensa ? "select l20_dtpubratificacao from liclicita where l20_codigo = {$iLicitacao}" : "select l202_datahomologacao from homologacaoadjudica where l202_licitacao = {$iLicitacao}";
        $sDataHomolgacao = db_utils::fieldsMemory(db_query($sSql), 0)->$sCampo;
        if (strtotime(str_replace("/", "-", $sDataAssinatura)) < strtotime($sDataHomolgacao)) {
            return false;
        }
        return true;
    }

    /**
     * Realiza um aditamento no contrato
     * Os tipos de aditamento são os listados abaixo:
     * @param $aItens
     * @param $oApostila
     * @param $dtVigenciaInicial
     * @param $dtVigenciaFinal
     * @param $dtAssinatura
     * @param $dtPublicacao
     * @return $this
     * @throws Exception
     */
    public function apostilar($aItens, $oApostila, $dtVigenciaInicial, $dtVigenciaFinal, $aSelecionados)
    {

        $nValorItens = 0;

        foreach ($aItens as $oItem) {
            $nValorItens += round(abs($oItem->valorapostilado), 2);
        }

        /**
         * cancelamos a ultima posição do acordo.
         */
        $this->getUltimaPosicao(true)->setSituacao(3);

        $this->getUltimaPosicao()->save();

        /**
         * Alterar o valor de Tipo Apostila para valores existentes na acordoposicaotipo
         */
        if ($oApostila->tipoalteracaoapostila == 1) {
            $oApostila->tipoalteracaoapostila = AcordoPosicao::TIPO_ACRESCIMOVALOR_APOSTILA;
        } else if ($oApostila->tipoalteracaoapostila == 2) {
            $oApostila->tipoalteracaoapostila = AcordoPosicao::TIPO_DECRESCIMOVALOR_APOSTILA;
        } else {
            $oApostila->tipoalteracaoapostila = AcordoPosicao::TIPO_SEMALTERACAO_APOSTILA;
        }

        $oNovaPosicao = new AcordoPosicao(null);
        $oNovaPosicao->setData(date("Y-m-d", db_getsession("DB_datausu")));
        $oNovaPosicao->setAcordo($this->getCodigoAcordo());
        $oNovaPosicao->setEmergencial(false);
        $oNovaPosicao->setNumero($this->getUltimaPosicao(true)->getNumero() + 1);
        $oNovaPosicao->setNumeroApostilamento($this->validaNumeroApostilamento($this->getCodigoAcordo(), $oApostila->numapostilamento));
        $oNovaPosicao->setSituacao(1);
        $oNovaPosicao->setTipo($oApostila->tipoalteracaoapostila);
        $oNovaPosicao->setVigenciaInicial($dtVigenciaInicial);
        $oNovaPosicao->setVigenciaFinal($dtVigenciaFinal);
        $oNovaPosicao->setPosicaoPeriodo($dtVigenciaInicial, $dtVigenciaFinal, $this->getPeriodoComercial());

        $oNovaPosicao->save();

        /**
         * Vincular o acordo com o apostilamento
         */

        $oApostila->valorapostila = $nValorItens;
        $oNovaPosicao->salvarApostilamento($oApostila, $this->getDataAssinatura());

        $sAtualDtInicial = new DBDate($this->getDataInicial());
        $sAtualDtFim     = new DBDate($this->getDataFinal());
        $this->setDataInicial($dtVigenciaInicial);
        $this->setDataFinal($dtVigenciaFinal);
        $this->salvarAlteracoesContrato();

        foreach ($aItens as $oItem) {

            $oItemContrato = $this->getUltimaPosicao(true)->getItemByCodigo($oItem->codigo);

            $oNovoItem = new AcordoItem(null);
            $oNovoItem->setCodigoPosicao($oNovaPosicao->getCodigo());

            $oNovoItem->setCodigoPosicaoTipo($oApostila->tipoalteracaoapostila);

            if ($oItemContrato) {

                $oOrigemItem = $oItemContrato->getOrigem();
                $oNovoItem->setElemento($oItemContrato->getElemento());
                $oNovoItem->setMaterial($oItemContrato->getMaterial());
                $oNovoItem->setResumo($oItemContrato->getResumo());
                $oNovoItem->setOrigem($oOrigemItem->codigo, $oOrigemItem->tipo, $oOrigemItem->codigoorigem);
                $oNovoItem->setUnidade($oItemContrato->getUnidade());
                $oNovoItem->setTipoControle($oItemContrato->getTipocontrole());
                $oNovoItem->setItemVinculo($oItemContrato->getCodigo());
                $oNovoItem->setPeriodos($oItemContrato->getPeriodosItem());
                $oNovoItem->setServicoQuantidade($oItemContrato->getServicoQuantidade());

            } else {

                $oNovoItem->setElemento($oItem->codigoelemento);
                $oNovoItem->setMaterial(new MaterialCompras($oItem->codigoitem));
                $oNovoItem->setResumo(utf8_decode(db_stdClass::db_stripTagsJson($oItem->resumo)));
                $oNovoItem->setUnidade($oItem->unidade);
                $oNovoItem->setTipoControle(AcordoItem::CONTROLE_DIVISAO_QUANTIDADE);
                $oNovoItem->setServicoQuantidade("f");

                if (!empty($oItem->aPeriodos)) {
                    $oNovoItem->setPeriodos($oItem->aPeriodos);
                }
            }
            $oNovoItem->setQuantidade((float) $oItem->quantidade);
            $oNovoItem->setValorUnitario((float) $oItem->valorunitario);
            $oNovoItem->setValorTotal(round($oItem->valorunitario * $oItem->quantidade, 2));
            $oNovoItem->setValorAditado($oItem->valorapostilado);

            /**
             * Caso seja servico e nao controlar quantidade,
             * o valor anterior a comparar sera o saldo a executar
             */
            if ($oItemContrato->getMaterial()->isServico() && $oItemContrato->getServicoQuantidade() == "f") {
                $oItemSaldo     = $oItemContrato->getSaldos();
                $nValorComparar = $oItemSaldo->valorautorizar;
            } else {
                $nValorComparar = $oItemContrato->getValorUnitario();
            }

            if (($oItem->valorapostilado < 0 && $oApostila->tipoalteracaoapostila != AcordoPosicao::TIPO_ACRESCIMOVALOR_APOSTILA)
                || ($oItem->valorapostilado > 0 && $oApostila->tipoalteracaoapostila != AcordoPosicao::TIPO_DECRESCIMOVALOR_APOSTILA)) {
                throw new Exception("Valor do item Cod {$oItem->codigoitem} não compatível com o Tipo de alteração Apostila.");
            }

            foreach ($oItem->dotacoes as $oDotacao) {

                $oDotacao->ano = db_getsession("DB_anousu");
                $oNovoItem->adicionarDotacoes($oDotacao);
            }
            /*
             * Alterado opcao para false para nao gerar reserva conforme solicitado por Mario
             */
            $oNovoItem->save(false);
        }

        return $this;
    }

    function getObras($iAcordo)
    {
        $sCampo          = "*";
        $sSql            = "SELECT $sCampo
                              FROM acordo
                              INNER JOIN liclicita ON l20_codigo = ac16_licitacao
                              INNER JOIN licobras ON obr01_licitacao = l20_codigo
                            WHERE ac16_sequencial = $iAcordo";
        $rsObras = db_query($sSql);
        $obra = db_utils::fieldsMemory($rsObras, 0)->obr01_sequencial;
        return $obra;
    }

    function getNaturezaAcordo($iAcordo)
    {
        $sSql            = "SELECT ac02_acordonatureza
                              FROM acordo
                            INNER JOIN acordogrupo on ac16_acordogrupo = ac02_sequencial
                            WHERE ac16_sequencial = $iAcordo";
        $rsNatureza = db_query($sSql);
        $sNatureza = db_utils::fieldsMemory($rsNatureza, 0)->ac02_acordonatureza;
        return $sNatureza;
    }
//
//    function getSaldosItens($iAcordo,$iPosicao){
//            $oContrato = new Acordo($iAcordo);
//            $aItens    = array();
//
//            foreach ($oContrato->getPosicoes() as $oPosicaoContrato) {
//
//                if ($oPosicaoContrato->getCodigo() == $iPosicao) {
//
//                    foreach ($oPosicaoContrato->getItens() as $oItem) {
//                        $oItemRetorno                 = new stdClass();
//                        $oItemRetorno->saldos         = $oItem->getSaldosItem($oItem->getCodigo());
//                        echo "<pre>";
//                        print_r($oItemRetorno);
//                        $itens[]                      = $oItemRetorno;
//                    }
//                }
//            }
////            exit;
//    }

}
