<?php

require_once("model/licitacao/PortalCompras/Modalidades/Componentes/Lote.model.php");
abstract class Licitacao implements \JsonSerializable
{
    protected string     $id;
    protected ?string    $objeto = null;
    protected int        $tipoRealizacao;
    protected int        $numeroProcessoInterno;
    protected int        $numeroProcesso;
    protected int        $anoProcesso;
    protected ?string    $dataLimiteEsclarecimento = null;
    protected ?string    $dataInicioPropostas = null ;
    protected ?string    $dataFinalPropostas = null;
    protected ?string    $dataLimiteImpugnacao = null;
    protected ?string    $dataAberturaPropostas = null;
    protected bool       $orcamentoSigiloso;
    protected bool       $exclusivoMPE;
    protected bool       $aplicar147;
    protected bool       $beneficioLocal;
    protected bool       $exigeGarantia;
    protected int        $casasDecimais;
    protected int        $casasDecimaisQuantidade;
    protected int        $legislacaoAplicavel;
    protected int        $tratamentoFaseLance;
    protected int        $tipoIntervaloLance;
    protected float      $valorIntervaloLance;
    protected bool       $separarPorLotes;
    protected int        $operacaoLote;
    protected array      $lotes;
    protected            $arquivos;
    protected ?string    $pregoeiro = "";
    protected ?string    $autoridadeCompetente = "";
    protected ?array     $equipeDeApoio = [];
    protected ?array     $documentosHabilitacao = [];
    protected ?array     $declaracoes = [];
    protected ?array     $origensRecursos = [];

    /**
     * Retorna os patsh de cada modalidade de licitaçao
     *
     * @param string|null $publicKey
     * @return string
     */
    abstract public function getPathPortalCompras(string $publicKey = null): string;

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }



    /**
     * Get the value of tipoRealizacao
     */
    public function getTipoRealizacao(): int
    {
        return $this->tipoRealizacao;
    }

    /**
     * Set the value of tipoRealizacao
     */
    public function setTipoRealizacao(int $tipoRealizacao): self
    {
        $this->tipoRealizacao = $tipoRealizacao;

        return $this;
    }


    /**
     * Get the value of numeroProcesso
     */
    public function getNumeroProcesso(): int
    {
        return $this->numeroProcesso;
    }

    /**
     * Set the value of numeroProcesso
     */
    public function setNumeroProcesso(int $numeroProcesso): self
    {
        $this->numeroProcesso = $numeroProcesso;

        return $this;
    }

    /**
     * Get the value of anoProcesso
     */
    public function getAnoProcesso(): int
    {
        return $this->anoProcesso;
    }

    /**
     * Set the value of anoProcesso
     */
    public function setAnoProcesso(int $anoProcesso): self
    {
        $this->anoProcesso = $anoProcesso;

        return $this;
    }


    /**
     * Get the value of orcamentoSigiloso
     */
    public function isOrcamentoSigiloso(): bool
    {
        return $this->orcamentoSigiloso;
    }

    /**
     * Set the value of orcamentoSigiloso
     */
    public function setOrcamentoSigiloso(bool $orcamentoSigiloso): self
    {
        $this->orcamentoSigiloso = $orcamentoSigiloso;

        return $this;
    }

    /**
     * Get the value of aplicar147
     */
    public function isAplicar147(): bool
    {
        return $this->aplicar147;
    }

    /**
     * Set the value of aplicar147
     */
    public function setAplicar147(bool $aplicar147): self
    {
        $this->aplicar147 = $aplicar147;

        return $this;
    }

    /**
     * Get the value of beneficioLocal
     */
    public function isBeneficioLocal(): bool
    {
        return $this->beneficioLocal;
    }

    /**
     * Set the value of beneficioLocal
     */
    public function setBeneficioLocal(bool $beneficioLocal): self
    {
        $this->beneficioLocal = $beneficioLocal;

        return $this;
    }

    /**
     * Get the value of exigeGarantia
     */
    public function isExigeGarantia(): bool
    {
        return $this->exigeGarantia;
    }

    /**
     * Set the value of exigeGarantia
     */
    public function setExigeGarantia(bool $exigeGarantia): self
    {
        $this->exigeGarantia = $exigeGarantia;

        return $this;
    }

    /**
     * Get the value of casasDecimais
     */
    public function getCasasDecimais(): int
    {
        return $this->casasDecimais;
    }

    /**
     * Set the value of casasDecimais
     */
    public function setCasasDecimais(int $casasDecimais): self
    {
        $this->casasDecimais = $casasDecimais;

        return $this;
    }

    /**
     * Get the value of casasDecimaisQuantidade
     */
    public function getCasasDecimaisQuantidade(): int
    {
        return $this->casasDecimaisQuantidade;
    }

    /**
     * Set the value of casasDecimaisQuantidade
     */
    public function setCasasDecimaisQuantidade(int $casasDecimaisQuantidade): self
    {
        $this->casasDecimaisQuantidade = $casasDecimaisQuantidade;

        return $this;
    }

    /**
     * Get the value of legislacaoAplicavel
     */
    public function getLegislacaoAplicavel(): int
    {
        return $this->legislacaoAplicavel;
    }

    /**
     * Set the value of legislacaoAplicavel
     */
    public function setLegislacaoAplicavel(int $legislacaoAplicavel): self
    {
        $this->legislacaoAplicavel = $legislacaoAplicavel;

        return $this;
    }

    /**
     * Get the value of tratamentoFaseLance
     */
    public function getTratamentoFaseLance(): int
    {
        return $this->tratamentoFaseLance;
    }

    /**
     * Set the value of tratamentoFaseLance
     */
    public function setTratamentoFaseLance(int $tratamentoFaseLance): self
    {
        $this->tratamentoFaseLance = $tratamentoFaseLance;

        return $this;
    }

    /**
     * Get the value of tipoIntervaloLance
     */
    public function getTipoIntervaloLance(): int
    {
        return $this->tipoIntervaloLance;
    }

    /**
     * Set the value of tipoIntervaloLance
     */
    public function setTipoIntervaloLance(int $tipoIntervaloLance): self
    {
        $this->tipoIntervaloLance = $tipoIntervaloLance;

        return $this;
    }

    /**
     * Get the value of valorIntervaloLance
     */
    public function getValorIntervaloLance(): float
    {
        return $this->valorIntervaloLance;
    }

    /**
     * Set the value of valorIntervaloLance
     */
    public function setValorIntervaloLance(float $valorIntervaloLance): self
    {
        $this->valorIntervaloLance = $valorIntervaloLance;

        return $this;
    }

    /**
     * Get the value of separarPorLotes
     */
    public function isSepararPorLotes(): bool
    {
        return $this->separarPorLotes;
    }

    /**
     * Set the value of separarPorLotes
     */
    public function setSepararPorLotes(string $separarPorLotes): self
    {
        $this->separarPorLotes = false;

        if ($separarPorLotes == 't'){
            $this->separarPorLotes = true;
        }

        return $this;
    }

    /**
     * Get the value of lotes
     */
    public function getLotes()
    {
        return $this->lotes;
    }

    /**
     * Set the value of lotes
     *
     * @param Lote[] $lotes
     */
    public function setLotes(array $lotes): self
    {
        $this->lotes = $lotes;

        return $this;
    }

    /**
     * Get the value of arquivos
     */
    public function getArquivos()
    {
        return $this->arquivos;
    }

    /**
     * Set the value of arquivos
     */
    public function setArquivos($arquivos): self
    {
        $this->arquivos = $arquivos;

        return $this;
    }

    /**
     * Get the value of pregoeiro
     */
    public function getPregoeiro(): ?string
    {
        return $this->pregoeiro;
    }

    /**
     * Set the value of pregoeiro
     */
    public function setPregoeiro(?string $pregoeiro): self
    {
        $this->pregoeiro = $pregoeiro;

        return $this;
    }

    /**
     * Get the value of autoridadeCompetente
     */
    public function getAutoridadeCompetente(): ?string
    {
        return $this->autoridadeCompetente;
    }

    /**
     * Set the value of autoridadeCompetente
     */
    public function setAutoridadeCompetente(?string $autoridadeCompetente): self
    {
        $this->autoridadeCompetente = $autoridadeCompetente;

        return $this;
    }

    /**
     * Get the value of equipeDeApoio
     */
    public function getEquipeDeApoio(): ?array
    {
        return $this->equipeDeApoio;
    }

    /**
     * Set the value of equipeDeApoio
     */
    public function setEquipeDeApoio(?array $equipeDeApoio): self
    {
        $this->equipeDeApoio = $equipeDeApoio;

        return $this;
    }

    /**
     * Get the value of documentosHabilitacao
     */
    public function getDocumentosHabilitacao(): array
    {
        return $this->documentosHabilitacao;
    }

    /**
     * Set the value of documentosHabilitacao
     */
    public function setDocumentosHabilitacao(array $documentosHabilitacao): self
    {
        $this->documentosHabilitacao = $documentosHabilitacao;

        return $this;
    }

    /**
     * Get the value of declaracoes
     */
    public function getDeclaracoes(): array
    {
        return $this->declaracoes;
    }

    /**
     * Set the value of declaracoes
     */
    public function setDeclaracoes(array $declaracoes): self
    {
        $this->declaracoes = $declaracoes;

        return $this;
    }

    /**
     * Get the value of numeroProcessoInterno
     */
    public function getNumeroProcessoInterno(): int
    {
        return $this->numeroProcessoInterno;
    }

    /**
     * Set the value of numeroProcessoInterno
     */
    public function setNumeroProcessoInterno(int $numeroProcessoInterno): self
    {
        $this->numeroProcessoInterno = $numeroProcessoInterno;

        return $this;
    }

    /**
     * Get the value of exclusivoMPE
     */
    public function isExclusivoMPE(): bool
    {
        return $this->exclusivoMPE;
    }

    /**
     * Set the value of exclusivoMPE
     */
    public function setExclusivoMPE(bool $exclusivoMPE): self
    {
        $this->exclusivoMPE = $exclusivoMPE;

        return $this;
    }

    /**
     * Get the value of operacaoLote
     */
    public function getOperacaoLote(): int
    {
        return $this->operacaoLote;
    }

    /**
     * Set the value of operacaoLote
     */
    public function setOperacaoLote(int $operacaoLote): self
    {
        $this->operacaoLote = $operacaoLote;

        return $this;
    }

    /**
     * Get the value of origensRecursos
     */
    public function getOrigensRecursos()
    {
        return $this->origensRecursos;
    }

    /**
     * Set the value of origensRecursos
     */
    public function setOrigensRecursos($origensRecursos): self
    {
        $this->origensRecursos = $origensRecursos;

        return $this;
    }

    /**
     * Get the value of objeto
     */
    public function getObjeto(): ?string
    {
        return $this->objeto;
    }

    /**
     * Set the value of objeto
     */
    public function setObjeto(?string $objeto): self
    {
        $this->objeto = utf8_encode($objeto);

        return $this;
    }

    /**
     * Get the value of dataLimiteEsclarecimento
     */
    public function getDataLimiteEsclarecimento(): ?string
    {
        return $this->dataLimiteEsclarecimento;
    }

    /**
     * Set the value of dataLimiteEsclarecimento
     */
    public function setDataLimiteEsclarecimento(?string $dataLimiteEsclarecimento): self
    {
        $this->dataLimiteEsclarecimento = $dataLimiteEsclarecimento;

        return $this;
    }

    /**
     * Get the value of dataInicioPropostas
     */
    public function getDataInicioPropostas(): ?string
    {
        return $this->dataInicioPropostas;
    }

    /**
     * Set the value of dataInicioPropostas
     */
    public function setDataInicioPropostas(?string $dataInicioPropostas): self
    {
        $this->dataInicioPropostas = $dataInicioPropostas;

        return $this;
    }

    /**
     * Get the value of dataFinalPropostas
     */
    public function getDataFinalPropostas(): ?string
    {
        return $this->dataFinalPropostas;
    }

    /**
     * Set the value of dataFinalPropostas
     */
    public function setDataFinalPropostas(?string $dataFinalPropostas): self
    {
        $this->dataFinalPropostas = $dataFinalPropostas;

        return $this;
    }

    /**
     * Get the value of dataLimiteImpugnacao
     */
    public function getDataLimiteImpugnacao(): ?string
    {
        return $this->dataLimiteImpugnacao;
    }

    /**
     * Set the value of dataLimiteImpugnacao
     */
    public function setDataLimiteImpugnacao(?string $dataLimiteImpugnacao): self
    {
        $this->dataLimiteImpugnacao = $dataLimiteImpugnacao;

        return $this;
    }


    /**
     * Get the value of dataAberturaPropostas
     */
    public function getDataAberturaPropostas(): ?string
    {
        return $this->dataAberturaPropostas;
    }

    /**
     * Set the value of dataAberturaPropostas
     */
    public function setDataAberturaPropostas(?string $dataAberturaPropostas): self
    {
        $this->dataAberturaPropostas = $dataAberturaPropostas;

        return $this;
    }
}