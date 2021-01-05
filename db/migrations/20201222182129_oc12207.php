<?php

use Classes\PostgresMigration;

class Oc12207 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();
        
        CREATE OR REPLACE FUNCTION public.fc_verifica_lancamento(integer, date, integer, double precision)
        RETURNS text
        LANGUAGE plpgsql
        AS $$
        declare

        p_numemp         alias for $1;
        p_dtfim          alias for $2;
        p_doc            alias for $3;
        p_valor          alias for $4;

        c_lanc           record;

        v_dtini          date;
        v_erro           integer default 0;

        v_vlremp         float8 default 0;
        v_vlrliq         float8 default 0;
        v_vlrpag         float8 default 0;

        v_vlremp_g       float8 default 0;
        v_vlrliq_g       float8 default 0;
        v_vlrpag_g       float8 default 0;
        v_total			float8 default 0;

        v_saldodisprp    numeric default 0;

        m_erro           text;

        v_anousu         integer default 0;
        v_instit         integer ;

        v_saldo_dotacao  float8 default 0;
        v_reserva_valor  float8 default 0;

        dataemp          boolean;  --  permite empenho com data maior que o ultimo empenho
        dataserv         boolean;  --  permite empenho com data maior que a data do servidor
        maxdataemp       date;

        begin

        -- para documento numero 1 o valor da variavel p_numemp deve ser o numero da autorizacao
        -- significa que a autorizacao esta sendo empenhada e ira gerar o documento 1
        if p_doc = 1 then

            -- Busca Instituicao da Autorizacao
            select e54_instit
            into v_instit
            from empautoriza
            where e54_autori = p_numemp;

            -- verifica se pode empenhar com data anterior a do servidor ( retornaram a data )
            select e30_empdataemp,
                e30_empdataserv
            into dataemp, dataserv
            from empparametro
            where e39_anousu = substr(p_dtfim,1,4)::integer ;

            if (dataemp = false) then
            -- nao permite empenhar com data anterior ao ultimo empenho emitido
            select max(e60_emiss)
                into maxdataemp
                from empempenho
            where e60_instit = v_instit;

            if  p_dtfim < maxdataemp  then
                return '11 VOCÊ NÃO PODE EMPENHAR COM DATA INFERIOR AO ULTIMO EMPENHO EMITIDO. INSTITUICAO ('||v_instit||')';
            end if;

            end if;

            if (dataserv = false) then
            -- nao permite empenhar com data superior a data do servidor
            if  p_dtfim > current_date  then
                return '11 VOCÊ NÃO PODE EMPENHAR COM DATA SUPERIOR A DATA DO SISTEMA (SERVIDOR). INSTITUICAO ('||v_instit||')';
            end if;

            end if;

            -- testa se existe a reserva de saldo para est
            select o83_codres
            into v_erro
            from orcreservaaut
            where o83_autori = p_numemp;

            if not found then
            return '11 AUTORIZAÇÃO SEM RESERVA DE SALDO. (' || p_numemp || ').';
            else
            select substr(fc_dotacaosaldo(o80_anousu,o80_coddot,2,p_dtfim,p_dtfim),106,13)::float8, o80_valor
                into v_saldo_dotacao, v_reserva_valor
                from orcreserva
            where o80_codres = V_ERRO;

            if v_saldo_dotacao >= v_reserva_valor then
                return '0  PROCESSO AUTORIZADO (' || v_erro || ').';
            else
                return '12 SEM SALDO NA DOTACAO (' || v_erro || ' - ' || v_saldo_dotacao || ').';
            end if;

            end if;

        end if;

        -- testa os lancamentos do empenho
        select e60_emiss,
                e60_anousu,
                e60_instit
            into v_dtini, v_anousu
            from empempenho
        where e60_numemp = p_numemp;

        if v_dtini is null then
            return '14 Empenho não encontrado.';
        end if;

        if v_anousu < substr(p_dtfim,1,4)::integer then

            select round(round(e91_vlremp,2) - round(e91_vlranu,2),2)::float8,
                round(e91_vlrliq,2)::float8,
                round(e91_vlrpag,2)::float8
            into v_vlremp,v_vlrliq,v_vlrpag
            from empresto
            where e91_anousu = substr(p_dtfim,1,4)::integer
            and e91_numemp = p_numemp;

            if v_vlremp is null then
            return '16 EMPENHO NÃO CADASTRADO COMO RESTOS A PAGAR';
            end if;

            v_dtini := (substr(p_dtfim,1,4)||'-01-01')::date;

            v_vlremp_g := v_vlremp;
            v_vlrliq_g := v_vlrliq;
            v_vlrpag_g := v_vlrpag;

        end if;


        if v_dtini > p_dtfim then
            return '14 Data informada menor que data de emissão do Empenho.';
        end if;

        raise notice 'data ini % - EMP %', v_dtini, p_numemp;

        for c_lanc in
            select c53_coddoc,
                    c53_descr,
                    c75_numemp,
                    c70_data,
                    c70_valor
                from conlancamemp
                    inner join conlancamdoc on c75_codlan = c71_codlan
                    inner join conlancam    on c70_codlan = c75_codlan
                    inner join conhistdoc   on c53_coddoc = c71_coddoc
            where c75_numemp = p_numemp
                and c75_data >= v_dtini
            order by c70_data
        loop

            RAISE NOTICE '\n%,%,%,%,%',c_lanc.c53_coddoc,c_lanc.c53_descr,c_lanc.c75_numemp,c_lanc.c70_valor,c_lanc.c70_data;

            /**
            * Empenho - 10
            */
            if c_lanc.c53_coddoc in(1, 82, 304, 308, 410, 500, 504) then

            if c_lanc.c70_data <= p_dtfim then
                v_vlremp := round(v_vlremp + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlremp_g := round(v_vlremp_g + c_lanc.c70_valor,2)::float8;

            /**
            * Estorno de Empenho - 11
            */
            elsif c_lanc.c53_coddoc in(2, 83, 305, 309, 411, 501, 505) then

            if c_lanc.c70_data <= p_dtfim then
                v_vlremp := round(v_vlremp - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlremp_g := round(v_vlremp_g - c_lanc.c70_valor,2)::float8;

            /**
            * Estorno de RP nao processado - 11
            */
            elsif c_lanc.c53_coddoc = 32 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlremp := round(v_vlremp - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlremp_g := round(v_vlremp_g - c_lanc.c70_valor,2)::float8;

            /**
            * Liquidacao - 20
            */
            elsif c_lanc.c53_coddoc in(3, 23, 39, 84, 412, 202, 204, 206, 306, 310, 502, 506) then

            if c_lanc.c70_data <= p_dtfim then
                v_vlrliq := round(v_vlrliq + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrliq_g := round(v_vlrliq_g + c_lanc.c70_valor,2)::float8;

            /**
            * liquidacao de RP - 20
            */
            elsif c_lanc.c53_coddoc = 33 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrliq := round(v_vlrliq + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrliq_g := round(v_vlrliq_g + c_lanc.c70_valor,2)::float8;

            /**
            * Anulacao de liquidacao - 21
            */
            elsif c_lanc.c53_coddoc in(4, 24, 25, 34, 40, 85, 203, 205, 207, 413, 307, 311, 503, 507) then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrliq := round(v_vlrliq - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrliq_g := round(v_vlrliq_g - c_lanc.c70_valor,2)::float8;

            /**
            * Anulacao de Liquidacao de RP - 21
            */
            elsif c_lanc.c53_coddoc = 34 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrliq := round(v_vlrliq - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrliq_g := round(v_vlrliq_g - c_lanc.c70_valor,2)::float8;


            /**
            * pagamento - 30
            */
            elsif c_lanc.c53_coddoc = 5 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g + c_lanc.c70_valor,2)::float8;

            /**
            * estorno de pagamento - 31
            */
            elsif c_lanc.c53_coddoc = 6 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g - c_lanc.c70_valor,2)::float8;

            /**
            * Pagamento de RP - 30
            */
            elsif c_lanc.c53_coddoc = 35 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g + c_lanc.c70_valor,2)::float8;

            /**
            * estorno de pagamento de RP - 31
            */
            elsif c_lanc.c53_coddoc = 36 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g - c_lanc.c70_valor,2)::float8;

            /**
            * Pagamento de RP processado - 30
            */
            elsif c_lanc.c53_coddoc = 37 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag + c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g + c_lanc.c70_valor,2)::float8;

            /**
            * Estorno de RP não processado - 31
            */
            elsif c_lanc.c53_coddoc = 38 then
            if c_lanc.c70_data <= p_dtfim then
                v_vlrpag := round(v_vlrpag - c_lanc.c70_valor,2)::float8;
            end if;
            v_vlrpag_g := round(v_vlrpag_g - c_lanc.c70_valor,2)::float8;
            end if;

        end loop;
        --  raise notice '%,%,%',v_vlremp,v_vlrliq,v_vlrpag;
        --  v_total := round(v_vlremp - v_vlrliq,2)::float8;
        --  raise notice '%,%', v_total,p_valor;

        if p_doc = 2 or p_doc = 32 then

            -- testar anulacao de empenho
            -- precisa ter saldo para anular ( emp - liq > 0 )
            -- erro na data passada
            if round(v_vlremp - v_vlrliq,2)::float8 >= p_valor then
            m_erro := '0 PROCESSO AUTORIZADO.';
            v_erro := 0;
            else
            m_erro :=  '01 Não existe saldo para anular nesta data.';
            v_erro := 1;
            end if;

            -- erro geral no empenho
            if v_erro = 0 then
            if round(v_vlremp_g - v_vlrliq_g,2)::float8 >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '02 Não existe saldo geral no empenho para anular.';
                v_erro := 2;
            end if;
            end if;

        end if;

        if p_doc = 3 or p_doc = 33 or p_doc = 23 then

            -- testar liquidacao de empenho
            -- precisa ter saldo para anular ( emp - liq > 0 )
            -- erro na data passada
            if round(v_vlremp - v_vlrliq,2)::float8 >= round(p_valor,2)::float8 then
            m_erro := '0 PROCESSO AUTORIZADO.';
            v_erro := 0;
            else
            m_erro := '03 Não existe saldo a liquidar nesta data.';
            v_erro := 3;
            end if;

            -- erro geral no empenho
            if v_erro = 0 then
            if round(v_vlremp_g - v_vlrliq_g,2)::float8 >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '04 Não existe saldo geral no empenho para liquidar.';
                v_erro := 4;
            end if;
            end if;
        end if;

        if p_doc = 4 or p_doc = 34 or p_doc = 24 then

            -- testar estorno de liquidacao de empenho
            -- precisa ter saldo para anular ( emp - liq > 0 )
            -- erro na data passada

            if p_doc = 34 then

            select sum(case
                    when c71_coddoc = 33 then
                        c70_valor
                    else
                        c70_valor * -1
                    end)
                into v_saldodisprp
                from conlancam
                    inner join conlancamemp on c75_codlan = c70_codlan
                    inner join conlancamdoc on c71_codlan = c70_codlan
            where c75_numemp = p_numemp
                and c71_coddoc in (33, 34)
                and extract (year from c70_data) = extract (year from p_dtfim);

            --raise notice 'disp: %', v_saldodisprp;

            if v_saldodisprp is null then
                v_saldodisprp = 0;
            end if;

            --raise notice 'doc: % - valor: % - disp: % - numemp: % - p_dtfim: %', p_doc, p_valor, v_saldodisprp, p_numemp, p_dtfim;

            if p_valor > v_saldodisprp then
                m_erro := '05 Não existe saldo para anular a liquidação nesta data.) Saldo Disponível: '|| v_saldodisprp;
                v_erro := 5;
            end if;

            end if;

            if v_erro = 0 then
            if round(v_vlrliq - v_vlrpag,2)::float8 >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '05 Não existe saldo para anular a liquidação nesta data.';
                v_erro := 5;
            end if;
            end if;

            -- erro geral no empenho
            if v_erro = 0 then
            if round(v_vlrliq_g - v_vlrpag_g,2)::float8 >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '06 Não existem saldo geral no empenho para estornar a liquidação.';
                v_erro := 6;
            end if;
            end if;

        end if;


        if p_doc = 5 or p_doc = 35  or p_doc = 37 then

            -- testar pagamento de empenho
            -- precisa ter saldo para anular ( emp - liq > 0 )
            -- erro na data passada
            if( round(v_vlrliq - v_vlrpag,2)::float8 >= p_valor) then
            v_erro := 0;
            m_erro := '0 PROCESSO AUTORIZADO.';
            else
            m_erro := '07 Não existe saldo a pagar nesta data. Empenho: ' || to_char(p_numemp, '9999999999');
            v_erro := 7;
            end if;

            -- erro geral no empenho
            if v_erro = 0 then
            if round(v_vlrliq_g - v_vlrpag_g,2)::float8 >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '08 Não existe saldo geral a pagar no empenho.';
                v_erro := 8;
            end if;
            end if;

        end if;

        if p_doc = 6 or p_doc = 36  or p_doc = 38 then

            -- testar anulacao de pagamento empenho
            -- precisa ter saldo para anular ( emp - liq > 0 )
            -- erro na data passada
            if v_vlrpag >= p_valor then
            m_erro := '0 PROCESSO AUTORIZADO.';
            v_erro := 0;
            else
            m_erro := '09 Não existe saldo para anular pagamento nesta data.';
            v_erro := 9;
            end if;

            -- erro geral no empenho
            if v_erro = 0 then
            if v_vlrpag_g >= p_valor then
                m_erro := '0 PROCESSO AUTORIZADO.';
                v_erro := 0;
            else
                m_erro := '10 Não existe saldo geral no empenho para anular o pagamento.';
                v_erro := 10;
            end if;
            end if;

        end if;


        --raise notice ' ate data %,%,%',v_vlremp,v_vlrliq,v_vlrpag;
        --raise notice ' geral    %,%,%',v_vlremp_g,v_vlrliq_g,v_vlrpag_g;

        return m_erro;

        end;
        $$;

        CREATE OR REPLACE FUNCTION public.fc_saldoitens(integer, boolean, integer, integer)
        RETURNS SETOF tp_saldoitensempenho
        LANGUAGE plpgsql
        AS $$
        declare

        iCodigo             alias for $1;
        lRaiseFunc          alias for $2;
        iTipo               alias for $4;
        iCodItem            alias for $3;
        nQuantIni           numeric  default 0; -- saldo Inicial do Item
        nSaldoItem          numeric  default 0; -- saldo atual do Item;
        nValorIni           numeric  default 0; -- valor inicial do item (valor total dos itens (qtd*valor unitario)
        nSaldoValor         numeric  default 0; -- Saldo do valor do item
        nSaldoEstoque       numeric  default 0;
        nValorEstoque       numeric  default 0;
        nSaldoOrdem         numeric  default 0;
        nValorOrdem         numeric  default 0;
        lControlaQuantidade boolean;
        bRaise              boolean;
        sSQL                varchar;
        sSQLOrdem           varchar;
        sSQLanul            varchar;
        sErro               varchar; -- mensagem de erro
        iInstit             integer;
        iAnoUsu             integer;
        sWhere              varchar default null;
        sJoin               varchar default null;
        iItemAnt            integer default null; -- codigo anterior do item de empenho (usando para controlar contagem dos itens;)

        rtp_saldoitensempenho tp_saldoitensempenho%ROWTYPE;
        rSaldoItens   record;
        rSaldoOrdem   record;
        rSaldoestoque record;
        rNotas        record;
        rAnulado      record;
        begin

        iAnousu   = fc_getsession('DB_anousu');
        iInstit   = fc_getsession('DB_instit');
        bRaise  := ( case when fc_getsession('DB_debugon') is null then false else true end);
        if iAnousu is null then
            raise exception 'variavel de sessao DB_anousu nao inicializada';
        end if ;

        if iInstit is null then
            raise exception  'variavel de sessao DB_instit nao inicializada';
        end if ;

        sWhere = ' e60_instit = '||iInstit;
        if iTipo  = 1 then

            if iCodigo is not null then
            sWhere := sWhere || ' and e62_numemp   = '||iCodigo;
            else
            sWhere := sWhere || ' and e60_anousu   = '||iAnousu;
            end if;

            sJoin  := '';
        else
            if iCodigo is not null then
            sWhere := sWhere || ' and m52_codordem = '||iCodigo;
            end if;
            sJoin  := ' left join matordemitem on m52_numemp = e62_numemp
                                            and m52_sequen = e62_sequen';
        end if;
        if iCodItem is not null then
            sWhere := sWhere ||' and e62_sequencial = '||iCodItem;
        end if;
        sSQL = 'select pc01_descrmater,
                        pc01_servico,
                        e62_numemp,
                        e62_item,
                        e60_anousu,
                        e60_codemp,
                        e62_sequencial,
                        e62_sequen,
                        e62_quant,
                        e62_vltot,
                        e62_vlrun,
                        e62_descr,
                        e62_servicoquantidade
                    From empempitem
                        inner join empempenho   on e62_numemp   = e60_numemp
                        inner join pcmater      on e62_item     = pc01_codmater
                        '||sJoin||'
                where '||sWhere||'
                order by e62_sequen';

            if bRaise then
                raise notice 'Inicializando variaveis - sql %', sSQL;
            end if;
            
            rtp_saldoitensempenho.riNumEmp              := 0;
            rtp_saldoitensempenho.riAnoEmp              := 0;
            rtp_saldoitensempenho.riCodOrdem            := 0;
            rtp_saldoitensempenho.riCodmater            := 0;
            rtp_saldoitensempenho.riCodItem             := 0;
            rtp_saldoitensempenho.riCodEmp              := 0;
            rtp_saldoitensempenho.rsDescr               := 0;
            rtp_saldoitensempenho.rsDescrEmp            := '';
            rtp_saldoitensempenho.riSeqItem             := 0;
            rtp_saldoitensempenho.rnQuantIni            := 0;
            rtp_saldoitensempenho.rnSaldoItem           := 0;
            rtp_saldoitensempenho.rnValorIni            := 0;
            rtp_saldoitensempenho.rnSaldoValor          := 0;
            rtp_saldoitensempenho.rnValorUni            := 0;
            rtp_saldoitensempenho.rnSaldoEstoque        := 0;
            rtp_saldoitensempenho.rnValorEstoque        := 0;
            rtp_saldoitensempenho.rnSaldoOrdem          := 0;
            rtp_saldoitensempenho.rnValorOrdem          := 0;
            rtp_saldoitensempenho.ricoditemordem        := 0;
            rtp_saldoitensempenho.rnSaldoEntradaEmpenho := 0;
            rtp_saldoitensempenho.rlControlaQuantidade  := false;

            if bRaise then
                raise notice 'Iniciando soma dos saldos';
            end if;

            for rSaldoItens in execute sSQL loop

                nSaldoValor   := 0;
                nSaldoItem    := 0;
                nSaldoEstoque := 0;
                nValorEstoque := 0;
                nSaldoOrdem   := 0;
                nValorOrdem   := 0;
                --selecionamos os totais da ordem.
                sSQLOrdem := 'select m52_codordem,
                                    m52_codlanc,
                                    coalesce(sum(m52_quant - (select coalesce(sum(m36_qtd),0)
                                                            from matordemitemanu
                                                            where m36_matordemitem = m52_codlanc)),0) as quantidadeordens,
                                    coalesce(sum(m52_valor - (select coalesce(sum(m36_vrlanu),0)
                                                            from matordemitemanu
                                                            where m36_matordemitem = m52_codlanc)),0) as valorordens
                                from matordemitem
                                    -- inner join matordem on matordem.m51_codordem = m52_codordem
                                                        -- and m51_tipo                = 1
                                    inner join empempitem           on m52_numemp        = e62_numemp
                                                                    and m52_sequen        = e62_sequen
                                    inner join empempenho           on e62_numemp        = e60_numemp
                            where e62_sequencial = '||rSaldoItens.e62_sequencial||'
                            and '||sWhere||'
                            group by m52_codordem,m52_codlanc';

                for rSaldoOrdem in execute sSQLOrdem loop

                nSaldoItem                           = nSaldoItem    + coalesce((rSaldoOrdem.quantidadeordens), 0);
                nSaldoValor                          = nSaldoValor   + (rSaldoOrdem.valorordens);
                nSaldoOrdem                          = nSaldoOrdem   + rSaldoOrdem.quantidadeordens;
                nValorOrdem                          = nValorOrdem   + rSaldoOrdem.valorordens;
                rtp_saldoitensempenho.riCodOrdem     = rSaldoOrdem.m52_codordem;
                rtp_saldoitensempenho.ricoditemordem = rSaldoOrdem.m52_codlanc;

                end loop;
                --selecionamos o totais do estoque
                sSQLOrdem := 'select (coalesce(sum(m75_quant), 0) / m75_quantmult) as m71_quant,
                                    coalesce(sum(m71_valor),0)  as m71_valor
                                from matordemitem
                                    inner join empempitem           on m52_numemp            = e62_numemp
                                                                    and m52_sequen            = e62_sequen
                                    inner join empempenho           on e62_numemp            = e60_numemp
                                    inner join matestoqueitemoc     on m73_codmatordemitem   = m52_codlanc
                                                                    and m73_cancelado  is false
                                    inner join matestoqueitem       on m73_codmatestoqueitem = m71_codlanc
                                    inner  join matestoqueitemunid   on m75_codmatestoqueitem = m71_codlanc
                                where e62_sequencial = '||rSaldoItens.e62_sequencial||'
                                and '||sWhere||'
                                group by m52_codordem,m52_codlanc,m75_quantmult';


                for rSaldoestoque in execute sSQLOrdem loop

                    nSaldoEstoque                        := nSaldoEstoque + rSaldoEstoque.m71_quant;
                    nValorEstoque                        := nValorEstoque + rSaldoEstoque.m71_valor;

                end loop;

                nSaldoOrdem := (nSaldoOrdem - nSaldoEstoque);
                nValorOrdem := (nValorOrdem - nValorEstoque);
                -- selecionamos os totais liquidados do item - encontramos na empnotaitem
                select coalesce(sum(e72_vlrliq) - sum(e72_vlranu),0) as e37_vlrliq
                    into rNotas
                    from empempitem
                        left join empnotaitem    on e62_sequencial = e72_empempitem
                    where e62_sequencial  = rSaldoItens.e62_sequencial;

                -- selecionamos os valores anulados do item  - encontramos na empanuladoitem
                select coalesce(sum(e37_vlranu),0) as e37_vlranu,
                        coalesce(sum(e37_qtd),0)    as e37_qtd
                    into rAnulado
                    from empempitem
                        left join empanuladoitem  on e62_sequencial = e37_empempitem
                    where e62_sequencial  = rSaldoItens.e62_sequencial;

                ------------------- Criamos as linhas do recordset
                rtp_saldoitensempenho.riNumEmp             := rSaldoItens.e62_numemp;
                rtp_saldoitensempenho.riSeqItem            := rSaldoItens.e62_sequen;
                rtp_saldoitensempenho.rnQuantIni           := rSaldoItens.e62_quant;
                rtp_saldoitensempenho.riCodItem            := rSaldoItens.e62_sequencial;
                rtp_saldoitensempenho.rsDescr              := rSaldoItens.pc01_descrmater;
                rtp_saldoitensempenho.rsDescrEmp           := rSaldoItens.e62_descr;
                rtp_saldoitensempenho.rnSaldoItem          := coalesce(rSaldoItens.e62_quant  - nSaldoItem  - rAnulado.e37_qtd,0);
                rtp_saldoitensempenho.rnValorIni           := rSaldoItens.e62_vltot;
                rtp_saldoitensempenho.rnSaldoValor         := coalesce((rSaldoItens.e62_vltot - nSaldoValor - rAnulado.e37_vlranu)::numeric,0);
                rtp_saldoitensempenho.rnValorUni           := rSaldoItens.e62_vlrun;
                rtp_saldoitensempenho.rnSaldoEstoque       := coalesce(nSaldoEstoque,0);
                rtp_saldoitensempenho.rnValorEstoque       := coalesce(nValorEstoque,0);
                rtp_saldoitensempenho.rnSaldoOrdem         := coalesce(nSaldoOrdem,0);
                rtp_saldoitensempenho.rnValorOrdem         := coalesce(nValorOrdem,0);
                rtp_saldoitensempenho.riCodMater           := rSaldoItens.e62_item;
                rtp_saldoitensempenho.riCodEmp             := rSaldoItens.e60_codemp;
                rtp_saldoitensempenho.riAnoEmp             := rSaldoItens.e60_anousu;
                rtp_saldoitensempenho.rnValorLiq           := rNotas.e37_vlrliq;
                rtp_saldoitensempenho.rnValorAnul          := rAnulado.e37_vlranu;
                rtp_saldoitensempenho.rlControlaQuantidade := rSaldoItens.e62_servicoquantidade;
                -- se o item for servico, e o quantidade do empenho for 1 sempre teremos  1 item  de saldo do item. apenas alteramos valor.
                if rSaldoItens.pc01_servico is true then

                    /**
                    * Caso for servi�o e este n�o for controlado por quantidade, setamos o saldo para 1 sempre
                    */
                    if rSaldoItens.e62_servicoquantidade is false then

                    rtp_saldoitensempenho.rnSaldoItem    := 1;
                    rtp_saldoitensempenho.rnSaldoOrdem   := 1;

                    end if;

                    rtp_saldoitensempenho.rnSaldoEstoque := 1;

                end if;

                if bRaise then
                    raise notice 'Calculando item % quant: % saldo:%', rSaldoItens.pc01_descrmater,rSaldoItens.e62_quant, coalesce(nSaldoItem,0);
                    raise notice '    Saldo Estoque: % Valor Estoque: % saldo Ordem:% valor ordem: %',nSaldoEstoque, nValorEstoque,nSaldoEstoque, nValorEstoque;
                end if;

                if rtp_saldoitensempenho.rnSaldoEstoque = (rtp_saldoitensempenho.rnQuantIni -rAnulado.e37_qtd) then

                    rtp_saldoitensempenho.rnSaldoEntradaEmpenho := round(rtp_saldoitensempenho.rnValorIni,2) - round(rtp_saldoitensempenho.rnValorEstoque, 2)
                                                                - round(rAnulado.e37_vlranu, 2);
                    /**
                    * Calculamos o valor a abater do item. caso o saldo do valor for negativo, indica que tivemos uma anulacao
                    * do item do sem solicitacao de anula�ao. esse caso so dever� ocorrer quando a o empenho estiver entrado
                    * totalmente no estoque, e sobrou alguns centavos para anulacao do empenho e o usuario realizou a anulacao
                    * diretamente.
                    */
                    rtp_saldoitensempenho.rnSaldoEntradaEmpenho :=  rtp_saldoitensempenho.rnSaldoEntradaEmpenho - round(abs(rtp_saldoitensempenho.rnSaldoValor),2);
                    if rtp_saldoitensempenho.rnSaldoEntradaEmpenho < 0  or rtp_saldoitensempenho.rnValorOrdem = 0 then
                    rtp_saldoitensempenho.rnSaldoEntradaEmpenho = 0;
                    end if;
                    if rtp_saldoitensempenho.rnSaldoValor < 0 then
                    rtp_saldoitensempenho.rnSaldoValor = 0;
                    end if;
                    else
                    rtp_saldoitensempenho.rnSaldoEntradaEmpenho := 0;
                    end if;
                return next rtp_saldoitensempenho;
            end loop;
        return ;
        end;
        $$;


        COMMIT;

SQL;
    $this->execute($sql);
  }

}