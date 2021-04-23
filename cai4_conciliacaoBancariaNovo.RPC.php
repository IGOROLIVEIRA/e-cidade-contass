<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/JSON.php");
require_once ("std/db_stdClass.php");
require_once ("std/DBDate.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/exceptions/BusinessException.php");
require_once ("libs/exceptions/DBException.php");
require_once ("libs/exceptions/FileException.php");
require_once ("libs/exceptions/ParameterException.php");

$iEscola           = db_getsession("DB_coddepto");
$oJson             = new Services_JSON();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->dados   = array();
$oRetorno->status  = 1;
$oRetorno->message = '';
$sCaminhoMensagens = 'financeiro.caixa.cai4_concbancnovo';

try {
    switch($oParam->exec) {
        case "getLancamentos":
            $oRetorno->aLinhasExtrato   = array();
            $data_inicial = explode("/", $oParam->params[0]->data_inicial);
            $data_inicial = $data_inicial[2] . "-" . $data_inicial[1] . "-" . $data_inicial[0];
            $data_final = explode("/", $oParam->params[0]->data_final);
            $data_final = $data_final[2] . "-" . $data_final[1] . "-" . $data_final[0];
            $condicao_lancamento = $oParam->params[0]->tipo_lancamento > 0 ? " AND conlancamdoc.c71_coddoc IN (" . tipoDocumentoLancamento($oParam->params[0]->tipo_lancamento) . ") " : " ";
            $sql = "/* empenhos- despesa orçamentaria */
                /* EMPENHO */
                select
                    corrente.k12_id as caixa,
                    corrente.k12_data as data,
                    conlancamdoc.c71_coddoc cod_doc,
                    0 as valor_debito,
                    corrente.k12_valor as valor_credito,
                    'Pgto. Emp. ' || e60_codemp || '/' || e60_anousu :: text || ' OP: ' || coremp.k12_codord :: text as tipo_movimentacao,
                    e60_codemp || '/' || e60_anousu :: text as codigo,
                    'OP' :: text as tipo,
                    0 as receita,
                    null :: text as receita_descr,
                    corhist.k12_histcor :: text as historico,
                    coremp.k12_cheque :: text as cheque,
                    null :: text as contrapartida,
                    coremp.k12_codord as ordem,
                    z01_nome :: text as credor,
                    z01_numcgm :: text as numcgm,
                    k12_codautent,
                    k105_corgrupotipo,
                    '' as codret,
                    '' as dtretorno,
                    '' as arqret,
                    '' as dtarquivo,
                    0 as k153_slipoperacaotipo
                from
                    corrente
                    inner join coremp on coremp.k12_id = corrente.k12_id
                    and coremp.k12_data = corrente.k12_data
                    and coremp.k12_autent = corrente.k12_autent
                    inner join empempenho on e60_numemp = coremp.k12_empen
                    inner join cgm on z01_numcgm = e60_numcgm
                    /* se habilitar o left abaixo e o empenho tiver mais de um cheque os registros ficam duplicados left join empord on e82_codord = coremp.k12_codord left join empageconfche on e91_codcheque = e82_codmov */
                    left join corhist on corhist.k12_id = corrente.k12_id
                    and corhist.k12_data = corrente.k12_data
                    and corhist.k12_autent = corrente.k12_autent
                    left join corautent on corautent.k12_id = corrente.k12_id
                    and corautent.k12_data = corrente.k12_data
                    and corautent.k12_autent = corrente.k12_autent
                    left join corgrupocorrente on corrente.k12_data = k105_data
                    and corrente.k12_id = k105_id
                    and corrente.k12_autent = k105_autent
                    /* Inclusão do tipo doc */
                    LEFT JOIN conlancamord ON conlancamord.c80_codord = coremp.k12_codord
                        AND conlancamord.c80_data = coremp.k12_data
                    LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamord.c80_codlan
                    LEFT JOIN conlancamval ON conlancamval.c69_codlan = conlancamord.c80_codlan
                        AND ((c69_credito = corrente.k12_conta AND corrente.k12_valor > 0)
                            OR (c69_debito = corrente.k12_conta AND corrente.k12_valor < 0))
                WHERE
                    corrente.k12_conta = " . $oParam->params[0]->k13_conta . "
                    AND corrente.k12_data between '" . $data_inicial . "'
                    AND '" . $data_final . "'
                    {$condicao_lancamento}
                    AND c69_sequen IS NOT NULL
                    AND corrente.k12_instit = 1
                union all
                    /* RECIBO */
                select
                    caixa,
                    data,
                    cod_doc,
                    valor_debito,
                    valor_credito,
                    tipo_movimentacao,
                    codigo,
                    tipo,
                    receita,
                    receita_descr,
                    historico,
                    cheque,
                    contrapartida,
                    ordem,
                    credor,
                    '' :: text as numcgm,
                    k12_codautent,
                    0 as k105_corgrupotipo,
                    '' as codret,
                    '' as dtretorno,
                    '' as arqret,
                    '' as dtarquivo,
                    0 as k153_slipoperacaotipo
                from
                    (
                        select
                            caixa,
                            data,
                            cod_doc,
                            sum(valor_debito) as valor_debito,
                            valor_credito,
                            tipo_movimentacao :: text,
                            codigo :: text,
                            tipo :: text,
                            receita,
                            receita_descr :: text,
                            historico :: text,
                            cheque :: text,
                            null :: text as contrapartida,
                            ordem,
                            credor :: text,
                            k12_codautent
                        from
                            (
                                select
                                    corrente.k12_id as caixa,
                                    corrente.k12_data as data,
                                    conlancamdoc.c71_coddoc cod_doc,
                                    cornump.k12_valor as valor_debito,
                                    0 as valor_credito,
                                    ('Recibo ' || k12_numpre || '-' || k12_numpar) :: text as tipo_movimentacao,
                                    k12_numpre || '-' || k12_numpar :: text as codigo,
                                    'REC' :: text as tipo,
                                    cornump.k12_receit as receita,
                                    tabrec.k02_drecei :: text as receita_descr,
                                    (coalesce(corhist.k12_histcor, '.')) :: text as historico,
                                    null :: text as cheque,
                                    null :: text as contrapartida,
                                    e20_pagordem as ordem,
                                    (
                                        select
                                            z01_nome :: text
                                        from
                                            arrepaga
                                            inner join cgm on z01_numcgm = k00_numcgm
                                        where
                                            k00_numpre = cornump.k12_numpre
                                        limit
                                            1
                                    ) as credor,
                                    k12_codautent
                                from
                                    corrente
                                    inner join cornump on cornump.k12_id = corrente.k12_id
                                    and cornump.k12_data = corrente.k12_data
                                    and cornump.k12_autent = corrente.k12_autent
                                    left join corgrupocorrente on corrente.k12_id = k105_id
                                    and corrente.k12_autent = k105_autent
                                    and corrente.k12_data = k105_data
                                    left join retencaocorgrupocorrente on e47_corgrupocorrente = k105_sequencial
                                    left join retencaoreceitas on e47_retencaoreceita = e23_sequencial
                                    left join retencaopagordem on e23_retencaopagordem = e20_sequencial
                                    inner join tabrec on tabrec.k02_codigo = cornump.k12_receit
                                    left join corhist on corhist.k12_id = corrente.k12_id
                                    and corhist.k12_data = corrente.k12_data
                                    and corhist.k12_autent = corrente.k12_autent
                                    left join corautent on corautent.k12_id = corrente.k12_id
                                    and corautent.k12_data = corrente.k12_data
                                    and corautent.k12_autent = corrente.k12_autent
                                    left join corcla on corcla.k12_id = corrente.k12_id
                                    and corcla.k12_data = corrente.k12_data
                                    and corcla.k12_autent = corrente.k12_autent
                                    left join corplacaixa on corrente.k12_id = k82_id
                                    and corrente.k12_data = k82_data
                                    and corrente.k12_autent = k82_autent
                                    /* Inclusão do tipo doc */
                                    LEFT JOIN conlancamcorrente
                                        ON conlancamcorrente.c86_id = corrente.k12_id
                                            AND conlancamcorrente.c86_data = corrente.k12_data
                                            AND conlancamcorrente.c86_autent = corrente.k12_autent
                                    LEFT JOIN conlancam
                                        ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                    LEFT JOIN conlancamdoc
                                        ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                                where
                                    corrente.k12_conta = " . $oParam->params[0]->k13_conta . "
                                    and (
                                        corrente.k12_data between '" . $data_inicial . "'
                                        and '" . $data_final . "'
                                    )
                                    {$condicao_lancamento}
                                    and corrente.k12_instit = 1
                                    and k12_codcla is null
                                    and k82_seqpla is null
                            ) as x
                        group by
                            caixa,
                            data,
                            cod_doc,
                            valor_credito,
                            tipo_movimentacao,
                            codigo,
                            tipo,
                            receita,
                            receita_descr,
                            historico,
                            cheque,
                            contrapartida,
                            ordem,
                            credor,
                            k12_codautent
                    ) as xx
                    /* PLANILHA */
                union all
                select
                    caixa,
                    data,
                    cod_doc,
                    valor_debito,
                    valor_credito,
                    tipo_movimentacao,
                    codigo,
                    tipo,
                    receita,
                    receita_descr,
                    historico,
                    cheque,
                    contrapartida,
                    ordem,
                    credor,
                    '' :: text as numcgm,
                    k12_codautent,
                    0 as k105_corgrupotipo,
                    '' as codret,
                    '' as dtretorno,
                    '' as arqret,
                    '' as dtarquivo,
                    0 as k153_slipoperacaotipo
                from
                    (
                        select
                            caixa,
                            data,
                            cod_doc,
                            sum(valor_debito) as valor_debito,
                            valor_credito,
                            tipo_movimentacao :: text,
                            codigo :: text,
                            tipo :: text,
                            receita,
                            receita_descr :: text,
                            historico :: text,
                            cheque :: text,
                            null :: text as contrapartida,
                            ordem,
                            credor :: text,
                            k12_codautent
                        from
                            (
                                select
                                    corrente.k12_id as caixa,
                                    corrente.k12_data as data,
                                    conlancamdoc.c71_coddoc cod_doc,
                                    case
                                        when k12_valor > 0 then k12_valor
                                        else 0
                                    end as valor_debito,
                                    case
                                        when k12_valor < 0 then k12_valor
                                        else 0
                                    end as valor_credito,
                                    ('planilha :' || k81_codpla) :: text as tipo_movimentacao,
                                    k81_codpla :: text as codigo,
                                    'REC' :: text as tipo,
                                    k81_receita as receita,
                                    tabrec.k02_drecei as receita_descr,
                                    (coalesce(placaixarec.k81_obs, '.')) :: text as historico,
                                    null :: text as cheque,
                                    null :: text as contrapartida,
                                    0 as ordem,
                                    null :: text as credor,
                                    k12_codautent
                                from
                                    corrente
                                    inner join corplacaixa on k12_id = k82_id
                                    and k12_data = k82_data
                                    and k12_autent = k82_autent
                                    inner join placaixarec on k81_seqpla = k82_seqpla
                                    inner join tabrec on tabrec.k02_codigo = k81_receita
                                    /* left join arrenumcgm on k00_numpre = cornump.k12_numpre left join cgm on k00_numcgm = z01_numcgm */
                                    left join corhist on corhist.k12_id = corrente.k12_id
                                    and corhist.k12_data = corrente.k12_data
                                    and corhist.k12_autent = corrente.k12_autent
                                    inner join corautent on corautent.k12_id = corrente.k12_id
                                    and corautent.k12_data = corrente.k12_data
                                    and corautent.k12_autent = corrente.k12_autent
                                    /* Inclusão do tipo doc */
                                    LEFT JOIN conlancamcorrente
                                        ON conlancamcorrente.c86_id = corrente.k12_id
                                            AND conlancamcorrente.c86_data = corrente.k12_data
                                            AND conlancamcorrente.c86_autent = corrente.k12_autent
                                    LEFT JOIN conlancam
                                        ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                    LEFT JOIN conlancamdoc
                                        ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                                where
                                    corrente.k12_conta = " . $oParam->params[0]->k13_conta . "
                                    and (
                                        corrente.k12_data between '" . $data_inicial . "'
                                        and '" . $data_final . "'
                                    )
                                    and corrente.k12_instit = 1
                                    {$condicao_lancamento}
                            ) as x
                        group by
                            caixa,
                            data,
                            cod_doc,
                            valor_credito,
                            tipo_movimentacao,
                            codigo,
                            tipo,
                            receita,
                            receita_descr,
                            historico,
                            cheque,
                            contrapartida,
                            ordem,
                            credor,
                            k12_codautent
                    ) as xx
                    /* BAIXA DE BANCO */
                union all
                select
                    caixa,
                    data,
                    cod_doc,
                    valor_debito,
                    valor_credito,
                    tipo_movimentacao,
                    codigo,
                    tipo,
                    receita,
                    receita_descr,
                    historico,
                    cheque,
                    contrapartida,
                    ordem,
                    credor,
                    '' :: text as numcgm,
                    k12_codautent,
                    0 as k105_corgrupotipo,
                    codret :: text,
                    dtretorno :: text,
                    arqret :: text,
                    dtarquivo :: text,
                    0 as k153_slipoperacaotipo
                from
                    (
                        select
                            caixa,
                            data,
                            cod_doc,
                            sum(valor_debito) as valor_debito,
                            valor_credito,
                            tipo_movimentacao :: text,
                            codigo :: text,
                            tipo :: text,
                            receita,
                            receita_descr :: text,
                            historico :: text,
                            cheque :: text,
                            null :: text as contrapartida,
                            ordem,
                            credor :: text,
                            k12_codautent,
                            codret,
                            dtretorno,
                            arqret,
                            dtarquivo
                        from
                            (
                                select
                                    corrente.k12_id as caixa,
                                    corrente.k12_data as data,
                                    conlancamdoc.c71_coddoc cod_doc,
                                    cornump.k12_valor as valor_debito,
                                    0 as valor_credito,
                                    ('Baixa da banco ') :: text as tipo_movimentacao,
                                    discla.codret as codigo,
                                    'baixa' :: text as tipo,
                                    cornump.k12_receit as receita,
                                    tabrec.k02_drecei :: text as receita_descr,
                                    (coalesce(corhist.k12_histcor, '.')) :: text as historico,
                                    null :: text as cheque,
                                    null :: text as contrapartida,
                                    0 as ordem,
                                    disarq.codret as codret,
                                    disarq.dtretorno as dtretorno,
                                    disarq.arqret as arqret,
                                    disarq.dtarquivo as dtarquivo,
                                    (
                                        select
                                            z01_nome :: text
                                        from
                                            recibopaga
                                            inner join cgm on z01_numcgm = k00_numcgm
                                        where
                                            k00_numpre = cornump.k12_numpre
                                        limit
                                            1
                                    ) as credor,
                                    k12_codautent
                                from
                                    corrente
                                    inner join cornump on cornump.k12_id = corrente.k12_id
                                    and cornump.k12_data = corrente.k12_data
                                    and cornump.k12_autent = corrente.k12_autent
                                    inner join tabrec on tabrec.k02_codigo = cornump.k12_receit
                                    /* left join arrenumcgm on k00_numpre = cornump.k12_numpre left join cgm on k00_numcgm = z01_numcgm */
                                    left join corhist on corhist.k12_id = corrente.k12_id
                                    and corhist.k12_data = corrente.k12_data
                                    and corhist.k12_autent = corrente.k12_autent
                                    left join corautent on corautent.k12_id = corrente.k12_id
                                    and corautent.k12_data = corrente.k12_data
                                    and corautent.k12_autent = corrente.k12_autent
                                    inner join corcla on corcla.k12_id = corrente.k12_id
                                    and corcla.k12_data = corrente.k12_data
                                    and corcla.k12_autent = corrente.k12_autent
                                    inner join discla on discla.codcla = corcla.k12_codcla
                                    and discla.instit = 1
                                    inner join disarq on disarq.codret = discla.codret
                                    and disarq.instit = discla.instit
                                    left join corplacaixa on corplacaixa.k82_id = corrente.k12_id
                                    and corplacaixa.k82_data = corrente.k12_data
                                    and corplacaixa.k82_autent = corrente.k12_autent
                                    /* Inclusão do tipo doc */
                                    LEFT JOIN conlancamcorrente
                                        ON conlancamcorrente.c86_id = corrente.k12_id
                                            AND conlancamcorrente.c86_data = corrente.k12_data
                                            AND conlancamcorrente.c86_autent = corrente.k12_autent
                                    LEFT JOIN conlancam
                                        ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                    LEFT JOIN conlancamdoc
                                        ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                                where
                                    corrente.k12_conta = " . $oParam->params[0]->k13_conta . "
                                    and (
                                        corrente.k12_data between '" . $data_inicial . "'
                                        and '" . $data_final . "'
                                    )
                                    and corrente.k12_instit = 1
                                    and corplacaixa.k82_id is null
                                    and corplacaixa.k82_data is null
                                    and corplacaixa.k82_autent is null
                                    {$condicao_lancamento}
                            ) as x
                        group by
                            caixa,
                            data,
                            cod_doc,
                            valor_credito,
                            tipo_movimentacao,
                            codigo,
                            tipo,
                            receita,
                            receita_descr,
                            historico,
                            cheque,
                            contrapartida,
                            ordem,
                            credor,
                            k12_codautent,
                            codret,
                            dtretorno,
                            arqret,
                            dtarquivo
                    ) as xx
                union all
                    /* transferencias a debito - entradas*/
                select
                    corrente.k12_id as caixa,
                    corlanc.k12_data as data,
                    conlancamdoc.c71_coddoc cod_doc,
                    corrente.k12_valor as valor_debito,
                    0 as valor_credito,
                    'Slip ' || k12_codigo :: text as tipo_movimentacao,
                    k12_codigo :: text as codigo,
                    'SLIP' :: text as tipo,
                    0 as receita,
                    null :: text as receita_descr,
                    slip.k17_texto :: text as historico,
                    e91_cheque :: text as cheque,
                    k17_debito || ' - ' || c60_descr as contrapartida,
                    0 as ordem,
                    z01_nome :: text as credor,
                    z01_numcgm :: text as numcgm,
                    k12_codautent,
                    0 as k105_corgrupotipo,
                    '' as codret,
                    '' as dtretorno,
                    '' as arqret,
                    '' as dtarquivo,
                    sliptipooperacaovinculo.k153_slipoperacaotipo
                from
                    corlanc
                    inner join corrente on corrente.k12_id = corlanc.k12_id
                    and corrente.k12_data = corlanc.k12_data
                    and corrente.k12_autent = corlanc.k12_autent
                    inner join slip on slip.k17_codigo = corlanc.k12_codigo
                    inner join conplanoreduz on c61_reduz = slip.k17_credito
                    and c61_anousu = 2021
                    inner join conplano on c60_codcon = c61_codcon
                    and c60_anousu = c61_anousu
                    left join slipnum on slipnum.k17_codigo = slip.k17_codigo
                    left join cgm on slipnum.k17_numcgm = z01_numcgm
                    left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo
                    left join corconf on corconf.k12_id = corlanc.k12_id
                    and corconf.k12_data = corlanc.k12_data
                    and corconf.k12_autent = corlanc.k12_autent
                    and corconf.k12_ativo is true
                    left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
                    and corconf.k12_ativo is true
                    and empageconfche.e91_ativo is true
                    left join corhist on corhist.k12_id = corrente.k12_id
                    and corhist.k12_data = corrente.k12_data
                    and corhist.k12_autent = corrente.k12_autent
                    left join corautent on corautent.k12_id = corrente.k12_id
                    and corautent.k12_data = corrente.k12_data
                    and corautent.k12_autent = corrente.k12_autent
                    /* Inclusão do tipo doc */
                    LEFT JOIN conlancamcorrente
                        ON conlancamcorrente.c86_id = corrente.k12_id
                            AND conlancamcorrente.c86_data = corrente.k12_data
                            AND conlancamcorrente.c86_autent = corrente.k12_autent
                    LEFT JOIN conlancam
                        ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                    LEFT JOIN conlancamdoc
                        ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                where
                    corlanc.k12_conta = " . $oParam->params[0]->k13_conta . "
                    and corlanc.k12_data between '" . $data_inicial . "'
                    and '" . $data_final . "'
                    {$condicao_lancamento}
                union all
                    /* SLIP CREDITO */
                select
                    corrente.k12_id as caixa,
                    corlanc.k12_data as data,
                    conlancamdoc.c71_coddoc cod_doc,
                    0 as valor_debito,
                    corrente.k12_valor as valor_credito,
                    'Slip ' || k12_codigo :: text as tipo_movimentacao,
                    k12_codigo :: text as codigo,
                    'SLIP' :: text as tipo,
                    0 as receita,
                    null :: text as receita_descr,
                    slip.k17_texto :: text as historico,
                    e91_cheque :: text as cheque,
                    k17_debito || ' - ' || c60_descr as contrapartida,
                    0 as ordem,
                    z01_nome :: text as credor,
                    z01_numcgm :: text as numcgm,
                    k12_codautent,
                    0 as k105_corgrupotipo,
                    '' as codret,
                    '' as dtretorno,
                    '' as arqret,
                    '' as dtarquivo,
                    sliptipooperacaovinculo.k153_slipoperacaotipo
                from
                    corrente
                    inner join corlanc on corrente.k12_id = corlanc.k12_id
                    and corrente.k12_data = corlanc.k12_data
                    and corrente.k12_autent = corlanc.k12_autent
                    inner join slip on slip.k17_codigo = corlanc.k12_codigo
                    inner join conplanoreduz on c61_reduz = slip.k17_debito
                    and c61_anousu = 2021
                    inner join conplano on c60_codcon = c61_codcon
                    and c60_anousu = c61_anousu
                    left join slipnum on slipnum.k17_codigo = slip.k17_codigo
                    left join cgm on slipnum.k17_numcgm = z01_numcgm
                    left join corconf on corconf.k12_id = corlanc.k12_id
                    and corconf.k12_data = corlanc.k12_data
                    and corconf.k12_autent = corlanc.k12_autent
                    and corconf.k12_ativo is true
                    left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip = slip.k17_codigo
                    left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
                    and corconf.k12_ativo is true
                    and empageconfche.e91_ativo is true
                    left join corhist on corhist.k12_id = corrente.k12_id
                    and corhist.k12_data = corrente.k12_data
                    and corhist.k12_autent = corrente.k12_autent
                    left join corautent on corautent.k12_id = corrente.k12_id
                    and corautent.k12_data = corrente.k12_data
                    and corautent.k12_autent = corrente.k12_autent
                    /* Inclusão do tipo doc */
                    LEFT JOIN conlancamcorrente
                        ON conlancamcorrente.c86_id = corrente.k12_id
                            AND conlancamcorrente.c86_data = corrente.k12_data
                            AND conlancamcorrente.c86_autent = corrente.k12_autent
                    LEFT JOIN conlancam
                        ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                    LEFT JOIN conlancamdoc
                        ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                where
                    corrente.k12_conta = " . $oParam->params[0]->k13_conta . "
                    and corrente.k12_data between '" . $data_inicial . "'
                    and '" . $data_final . "'
                    {$condicao_lancamento}
                order by
                    data,
                    caixa,
                    k12_codautent,
                    codigo";

            $resultado = db_query($sql);
            $rows = pg_numrows($resultado);
            $lancamentos = array();
            $agrupado = array();
            $movimentacao_permitida = $oParam->params[0]->tipo_movimento ? array($oParam->params[0]->tipo_movimento) : array("E", "S");
            $i = 0;
            for ($linha = 0; $linha < $rows; $linha++) {
                db_fieldsmemory($resultado, $linha);
                $movimento = ($valor_debito > 0 OR $valor_credito < 0) ? "E" : "S";

                if (in_array($movimento, $movimentacao_permitida) && naoPermitidos($cod_doc)) {
                    $documento = numeroDocumentoLancamento($tipo, $ordem, $codigo, $codigo);
                    $chave = $credor . $data . $cheque . $movimento . $codigo . $cod_doc;
                    // $chave = $i++;
                    $agrupado[$chave][] = array("identificador" => $caixa,
                            "data_lancamento" => date("d/m/Y", strtotime($data)),
                            "data_conciliacao" => $oParam->params[0]->data_inicial,
                            "credor" => $credor,
                            "tipo" => descricaoTipoLancamento($cod_doc),
                            "op_rec_slip" => $documento,
                            "documento" => $cheque,
                            "movimento" => $movimento,
                            "valor" => $valor_debito <> 0 ? abs($valor_debito) : abs($valor_credito),
                            "historico" => descricaoHistorico($tipo, $codigo));

                    if (!array_key_exists($chave, $lancamentos)) {
                        $lancamentos[$chave]["identificador"] = $caixa;
                        $lancamentos[$chave]["data_lancamento"] = date("d/m/Y", strtotime($data));
                        $lancamentos[$chave]["data_conciliacao"] = $oParam->params[0]->data_inicial;
                        $lancamentos[$chave]["credor"] = $credor;
                        $lancamentos[$chave]["tipo"] = descricaoTipoLancamento($cod_doc);
                        $lancamentos[$chave]["op_rec_slip"] = $documento;
                        $lancamentos[$chave]["documento"] = $cheque;
                        $lancamentos[$chave]["movimento"] = $movimento;
                        $lancamentos[$chave]["valor"] = $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["historico"] = descricaoHistorico($tipo, $codigo);
                    } else {
                        $lancamentos[$chave]["valor"] += $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["op_rec_slip"] = "";
                        $lancamentos[$chave]["historico"] = "<a href='#' onclick='js_janelaAgrupados(" .  json_encode($agrupado[$chave]) . ")'>(+) Mais Detalhes</a>";
                    }
                }
            }

            foreach ($lancamentos as $chave => $lancamento) {
                if ($lancamento["valor"] <> 0) {
                    $oDadosLinha = new StdClass();
                    $oDadosLinha->identificador = $lancamento["caixa"];
                    $oDadosLinha->data_lancamento  = $lancamento["data_lancamento"];
                    $oDadosLinha->data_conciliacao = $lancamento["data_conciliacao"];
                    $oDadosLinha->credor = $lancamento["credor"];
                    $oDadosLinha->tipo = $lancamento["tipo"];
                    $oDadosLinha->op_rec_slip = $lancamento["op_rec_slip"];
                    $oDadosLinha->documento = $lancamento["documento"];
                    $oDadosLinha->movimento = $lancamento["movimento"];
                    $oDadosLinha->valor = abs($lancamento["valor"]);
                    $oDadosLinha->historico = $lancamento["historico"];
                    $oRetorno->aLinhasExtrato[] = $oDadosLinha;
                }
            }
            break;

    case 'GetDadosExtrato':

      $oRetorno->aLinhasExtrato = array();

      $aWhere   = array();
      $aWhere[] = " not exists(select 1 from conciliaextrato where k87_extratolinha = k86_sequencial) ";
      $aWhere[] = " not exists(select 1 from conciliapendextrato where k88_extratolinha = k86_sequencial) ";

      if (!empty($oParam->iCodigoExtrato)) {
        $aWhere[] = "k86_extrato = {$oParam->iCodigoExtrato} ";
      }

      if (!empty($oParam->iCodigoContaBancaria)) {
        $aWhere[] = "k86_contabancaria = {$oParam->iCodigoContaBancaria} ";
      }

      if (!empty($oParam->dtProcessamentoInicial)) {

        $oDataProcessamentoInicial = new DBDate($oParam->dtProcessamentoInicial);
        $aWhere[] = "k85_dtproc >= '{$oDataProcessamentoInicial->getDate()}'";
      }

      if (!empty($oParam->dtProcessamentoFinal)) {

        $oDataProcessamentoFinal = new DBDate($oParam->dtProcessamentoFinal);
        $aWhere[] = "k85_dtproc <= '{$oDataProcessamentoFinal->getDate()}'";
      }

      if (!empty($oParam->dtArquivoInicial)) {

        $oDataArquivoInicial = new DBDate($oParam->dtArquivoInicial);
        $aWhere[] = "k85_dtarq >= '{$oDataArquivoInicial->getDate()}'";
      }

      if (!empty($oParam->dtArquivoFinal)) {

        $oDataArquivoFinal = new DBDate($oParam->dtArquivoFinal);
        $aWhere[] = "k85_dtarq <= '{$oDataArquivoFinal->getDate()}'";
      }

      $oDaoExtratoLinha = new cl_extratolinha();
      $sListaCampos     = "k86_sequencial as codigo_linha,";
      $sListaCampos    .= "k86_extrato as codigo_extrato,";
      $sListaCampos    .= "k86_contabancaria as conta_bancaria,";
      $sListaCampos    .= "k86_data as data,";
      $sListaCampos    .= "k86_valor as valor,";
      $sListaCampos    .= "k86_tipo as tipo,";
      $sListaCampos    .= "k86_historico as historico";

      $sWhereLinhasExtrato = implode(" and ", $aWhere);
      $sSqlLinhasExtrato   = $oDaoExtratoLinha->sql_query(null,
                                                          $sListaCampos,
                                                          "k86_sequencial",
                                                          $sWhereLinhasExtrato
                                                         );

      $rsLinhasExtrato = $oDaoExtratoLinha->sql_record($sSqlLinhasExtrato);
      if (!$rsLinhasExtrato) {
        throw new BusinessException(_M("{$sCaminhoMensagens}.sem_linhas_para_exclusao"));
      }
      $iTotalLinhasExtrato = $oDaoExtratoLinha->numrows;
      $aContasBancarias    = array();
      for ($iLinha = 0; $iLinha < $iTotalLinhasExtrato; $iLinha++) {

        $oDadosLinha = db_utils::fieldsMemory($rsLinhasExtrato, $iLinha, false, false, true);

        if (!isset($aContasBancarias[$oDadosLinha->conta_bancaria])) {
          $aContasBancarias[$oDadosLinha->conta_bancaria] = new ContaBancaria($oDadosLinha->conta_bancaria);
        }

        $oContaBancaria = $aContasBancarias[$oDadosLinha->conta_bancaria];
        $oDadosLinha->descricao_conta_bancaria = urlencode($oContaBancaria->getDadosConta());
        $oRetorno->aLinhasExtrato[]            = $oDadosLinha;
      }
      break;

    case 'Processar':

      if (!is_array($oParam->aLinhasExtrato)) {
        throw new ParameterException(_M("{$sCaminhoMensagens}.parametro_linhas_invalido"));
      }

      db_inicio_transacao();
      $oDaoExtratoLinha        = new cl_extratolinha();
      $aLinhasAgrupadasPorData = array();

      /**
       * Excluimos as linhas selecionadas pelo usuario.
       * após a exclusão das mesmas, é recalculado o saldo das contas bancarias envolvidas na exclusão.
       */
      foreach ($oParam->aLinhasExtrato as $iLinhaExtrato) {

        $sSqlDadosLinha  = $oDaoExtratoLinha->sql_query_file($iLinhaExtrato);
        $rsLinhasExtrato = $oDaoExtratoLinha->sql_record($sSqlDadosLinha);
        if ($oDaoExtratoLinha->numrows == 0) {

          $oParametroErro = (object) array("codigo_linha" => $iLinhaExtrato);
          throw new BusinessException(_M("{$sCaminhoMensagens}.linha_nao_encontrada", $oParametroErro));
        }

        $oDadosLinha = db_utils::fieldsMemory($rsLinhasExtrato, 0);
        if (!isset($aLinhasAgrupadasPorData[$oDadosLinha->k86_contabancaria])) {
          $aLinhasAgrupadasPorData[$oDadosLinha->k86_contabancaria] = array();
        }

        if (!in_array($oDadosLinha->k86_data, $aLinhasAgrupadasPorData[$oDadosLinha->k86_contabancaria])) {
          $aLinhasAgrupadasPorData[$oDadosLinha->k86_contabancaria][] = $oDadosLinha->k86_data;
        }

        $oDaoExtratoLinha->excluir($iLinhaExtrato);
        if ($oDaoExtratoLinha->erro_status == 0) {

          $oParametroErro = new stdClass();
          $oParametroErro->erro_tecnico   = $oDaoExtratoLinha->erro_banco;
          $oParametroErro->codigo_linha   = $iLinhaExtrato;
          $oParametroErro->codigo_extrato = $oDadosLinha->k86_extrato;
          $oParametroErro->valor_linha    = $oDadosLinha->k86_valor;
          throw new BusinessException(_M("{$sCaminhoMensagens}.erro_ao_excluir_linha", $oParametroErro));
        }

      }

      $oDaoExtrato = new cl_extratosaldo();
      /**
       * Ordenamos as datas de cada conta
       */
      $oDaoExtratoSaldo = new cl_extratosaldo();
      $sSqlSaldo        = "select * From extratosaldo where k97_extrato=1813";
      $rsSaldo          = db_query($sSqlSaldo);
      foreach ($aLinhasAgrupadasPorData as $iCodigoConta => &$aDatasConta) {
        usort($aLinhasAgrupadasPorData[$iCodigoConta], "ordernarDatasContas");
      }

      foreach ($aLinhasAgrupadasPorData as $iCodigoConta => $aDatasConta) {

        foreach ($aDatasConta as $sData) {
          $oDaoExtrato->recriarSaldo($iCodigoConta, $sData);
        }
      }
      $oDaoExtratoSaldo = new cl_extratosaldo();
      $sSqlSaldo        = "select * From extratosaldo where k97_extrato=1813";
      $rsSaldo          = db_query($sSqlSaldo);
      db_fim_transacao(false);
      break;
  }

} catch (ParameterException $oErro) {

    db_fim_transacao(true);
    $oRetorno->status  = 2;
    $oRetorno->message = urlencode($oErro->getMessage());
} catch (BusinessException $oErro) {

    db_fim_transacao(true);
    $oRetorno->status  = 2;
    $oRetorno->message = urlencode($oErro->getMessage());
}
echo $oJson->encode($oRetorno);

function ordernarDatasContas($aContaAtual, $aProximaConta) {

  $oDataAtual   = new DBDate($aContaAtual);
  $oProximaData = new DBDate($aProximaConta);
  return $oDataAtual->getTimeStamp() > $oProximaData->getTimeStamp() ? 1 : -1;
}

function numeroDocumentoLancamento($tipoLancamento, $numeroOP, $planilha, $numeroSlip)
{
    switch ($tipoLancamento) {
        case "OP":
            return $numeroOP;
            break;
        case "REC":
            return $planilha;
            break;
        case "SLIP":
            return $numeroSlip;
            break;
    }
}

function tipoLancamento($id_tipo_lancamento)
{
    $tipo_lancamento = array("Selecione", "PGTO. EMPENHO", "EST. PGTO EMPENHO", "REC. ORÇAMENTÁRIA",
                                "EST. REC. ORÇAMENTÁRIA", "PGTO EXTRA ORÇAMENTÁRIO", "EST. PGTO EXTRA ORÇAMENTÁRIO",
                                "REC. EXTRA ORÇAMENTÁRIA", "EST. REC. EXTRA ORÇAMENTÁRIA", "PERDAS", "ESTORNO PERDAS",
                                "TRANSFERÊNCIA", "EST. TRANSFERÊNCIA", "PENDÊNCIA", "IMPLANTAÇÃO");
    return $tipo_lancamento[$id_tipo_lancamento];
}


function tipoDocumentoLancamento($tipo_lancamento)
{
    switch (tipoLancamento($tipo_lancamento)) {
        case "PGTO. EMPENHO":
            return "30, 5";
            break;
        case "EST. PGTO EMPENHO":
            return "31, 6";
            break;
        case "REC. ORÇAMENTÁRIA":
            return "100";
            break;
        case "EST. REC. ORÇAMENTÁRIA":
            return "101";
            break;
        case "PGTO EXTRA ORÇAMENTÁRIO":
            return "120, 161";
            break;
        case "EST. PGTO EXTRA ORÇAMENTÁRIO":
            return "121, 163";
            break;
        case "EST. REC. EXTRA ORÇAMENTÁRIA":
            return "131, 151, 153, 162";
            break;
        case "REC. EXTRA ORÇAMENTÁRIA":
            return "130, 150, 152, 160";
            break;
        case "PERDAS":
            return "164";
            break;
        case "ESTORNO PERDAS":
            return "165";
            break;
        case "TRANSFERÊNCIA":
            return "140";
            break;
        case "EST. TRANSFERÊNCIA":
            return "141";
            break;
    }
}

function descricaoTipoLancamento($cod_doc)
{
    switch ($cod_doc) {
        case in_array($cod_doc, array("5", "30")):
            return "PGTO. EMPENHO";
            break;
        case in_array($cod_doc, array("6", "31")):
            return "EST. PGTO EMPENHO";
            break;
        case "100":
            return "REC. ORÇAMENTÁRIA";
            break;
        case "101":
            return "EST. REC. ORÇAMENTÁRIA";
            break;
        case in_array($cod_doc, array("120", "161")):
            return "PGTO EXTRA ORÇAMENTÁRIO";
            break;
        case in_array($cod_doc, array("121", "163")):
            return "EST. PGTO EXTRA ORÇAMENTÁRIO";
            break;
        case in_array($cod_doc, array("131", "151", "153", "162")):
            return "EST. REC. EXTRA ORÇAMENTÁRIA";
            break;
        case in_array($cod_doc, array("130", "150", "152", "160")):
            return "REC. EXTRA ORÇAMENTÁRIA";
            break;
        case "164":
            return "PERDAS";
            break;
        case "165":
            return "ESTORNO PERDAS";
            break;
        case "140":
            return "TRANSFERÊNCIA";
            break;
        case "141":
            return "EST. TRANSFERÊNCIA";
            break;
        default :
            return $cod_doc;
    }
}

function descricaoHistorico($tipo, $codigo)
{
    switch ($tipo) {
        case "OP":
            return "Empenho Nº {$codigo}";
            break;
        case "SLIP":
            return "Slip Nº {$codigo}";
            break;
        case "REC":
            return "Planilha Nº {$codigo}";
            break;
    }
}

function naoPermitidos($cod_doc)
{
    $nao_permitidos = array("116");
    if (in_array($cod_doc, $nao_permitidos))
        return false;
    return true;
}
