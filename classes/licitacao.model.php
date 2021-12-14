<?

class licitacao
{


    private $iCodLicitacao   = null;
    private $aItensLicitacao = array();
    private $oDados          = null;
    private $oDaoLicita      = null;
    function __construct($iCodLicitacao = null)
    {

        if (!empty($iCodLicitacao)) {
            $this->iCodLicitacao = $iCodLicitacao;
        }
        $this->oDaoLicita  = db_utils::getDao("liclicita");
    }


    /**
     * traz os Processos de compra VInculadas a licitacao.
     * @return array
     */

    function getProcessoCompras()
    {

        if ($this->iCodLicitacao == null) {

            throw new exception("Código da licitacao nulo");
            return false;
        }
        $oDaoLicitem  = db_utils::getDao("liclicitem");
        $sCampos      = "distinct pc80_codproc,coddepto, descrdepto,login,pc80_data,pc80_resumo";
        $rsProcessos  = $oDaoLicitem->sql_record(
            $oDaoLicitem->sql_query_inf(
                null,
                $sCampos,
                "pc80_codproc",
                "l21_codliclicita = {$this->iCodLicitacao}"
            )
        );
        if ($oDaoLicitem->numrows > 0) {

            for ($iInd = 0; $iInd < $oDaoLicitem->numrows; $iInd++) {

                $aSolicitacoes[] = db_utils::fieldsMemory($rsProcessos, $iInd);
            }
            return $aSolicitacoes;
        } else {
            return false;
        }
    }
    /**
     * retorna os Dados da Licitacao
     * @return object
     */
    function getDados()
    {

        $rsLicita     = $this->oDaoLicita->sql_record($this->oDaoLicita->sql_query($this->iCodLicitacao));
        $this->oDados = db_utils::fieldsMemory($rsLicita, 0);
        return $this->oDados;
    }

    function getEditalExport()
    {
        if ($this->iCodLicitacao == null) {

            throw new exception("Código da licitacao nulo");
            return false;
        }
        $oDaoLicitem  = db_utils::getDao("liclicita");
        $sCampos = "
        db_config.codigo as tipodoorgao,
	    db_config.nomeinst as nomeorgao,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        CASE
        WHEN pc01_complmater IS NOT NULL
        AND pc01_complmater != pc01_descrmater THEN pc01_descrmater ||'. '|| pc01_complmater
        ELSE pc01_descrmater END AS descricaodoitem,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        l04_codigo as codigodolote,
        l04_liclicitem as codigodoitemvinculadoaolote,
        l04_descricao as descricaodolote";

        $rsItens  = $oDaoLicitem->sql_record(
            $oDaoLicitem->sql_query_licitacao_exporta(
                null,
                $sCampos,
                "l20_edital",
                "l20_codigo = {$this->iCodLicitacao}"
            )
        );

        if ($oDaoLicitem->numrows > 0) {

            for ($iInd = 0; $iInd < $oDaoLicitem->numrows; $iInd++) {

                $aItens[] = db_utils::fieldsMemory($rsItens, $iInd);
            }
            return $aItens;
        } else {
            return false;
        }
    }

    function getItensExport()
    {
        if ($this->iCodLicitacao == null) {

            throw new exception("Código da licitacao nulo");
            return false;
        }
        $oDaoLicitem  = db_utils::getDao("liclicita");
        $sCampos = "
        db_config.codigo as tipodoorgao,
	    db_config.nomeinst as nomeorgao,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        CASE
        WHEN pc01_complmater IS NOT NULL
        AND pc01_complmater != pc01_descrmater THEN pc01_descrmater ||'. '|| pc01_complmater
        ELSE pc01_descrmater END AS descricaodoitem,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        l04_codigo as codigodolote,
        l04_liclicitem as codigodoitemvinculadoaolote,
        l04_descricao as descricaodolote";

        $rsItens  = $oDaoLicitem->sql_record(
            $oDaoLicitem->sql_query_licitacao_exporta(
                null,
                $sCampos,
                "l20_edital",
                "l20_codigo = {$this->iCodLicitacao}"
            )
        );

        if ($oDaoLicitem->numrows > 0) {

            for ($iInd = 0; $iInd < $oDaoLicitem->numrows; $iInd++) {

                $aItens[] = db_utils::fieldsMemory($rsItens, $iInd);
            }
            return $aItens;
        } else {
            return false;
        }
    }

    function getLoteExport()
    {
        if ($this->iCodLicitacao == null) {

            throw new exception("Código da licitacao nulo");
            return false;
        }
        $oDaoLicitem  = db_utils::getDao("liclicita");
        $sCampos = "
        db_config.codigo as tipodoorgao,
	    db_config.nomeinst as nomeorgao,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        CASE
        WHEN pc01_complmater IS NOT NULL
        AND pc01_complmater != pc01_descrmater THEN pc01_descrmater ||'. '|| pc01_complmater
        ELSE pc01_descrmater END AS descricaodoitem,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        cgc as cnpj,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        pc01_codmater as codigodoitem,
        l21_ordem as sequencialdoitemnoprocesso,
        m61_descr as unidadedemedida,
        pc11_quant as quantidadelicitada,
        case
            when pc80_criterioadjudicacao = 3 then si02_vlprecoreferencia
            else si02_vlpercreferencia end as valorunitariomedio,
        case
            when l20_tipojulg = 3 then l04_descricao
            else ' ' end as codigodolote,
        l20_edital as processolicitatorio,
        l20_anousu as anoprocessolicitatorio,
        l04_codigo as codigodolote,
        l04_liclicitem as codigodoitemvinculadoaolote,
        l04_descricao as descricaodolote";

        $rsItens  = $oDaoLicitem->sql_record(
            $oDaoLicitem->sql_query_licitacao_exporta(
                null,
                $sCampos,
                "l20_edital",
                "l20_codigo = {$this->iCodLicitacao}"
            )
        );

        if ($oDaoLicitem->numrows > 0) {

            for ($iInd = 0; $iInd < $oDaoLicitem->numrows; $iInd++) {

                $aItens[] = db_utils::fieldsMemory($rsItens, $iInd);
            }
            return $aItens;
        } else {
            return false;
        }
    }
}
