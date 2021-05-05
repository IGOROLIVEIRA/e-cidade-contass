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
require_once("classes/db_conciliacaobancaria_classe.php");
require_once("classes/db_conciliacaobancarialancamento_classe.php");

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
            $oRetorno->aLinhasExtrato = array();
            $data_inicial = data($oParam->params[0]->data_inicial);
            $data_final = data($oParam->params[0]->data_final);
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
                    corrente.k12_conta = " . $oParam->params[0]->conta . "
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
                                    corrente.k12_conta = " . $oParam->params[0]->conta . "
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
                                    corrente.k12_conta = " . $oParam->params[0]->conta . "
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
                                    corrente.k12_conta = " . $oParam->params[0]->conta . "
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
                    corlanc.k12_conta = " . $oParam->params[0]->conta . "
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
                    corrente.k12_conta = " . $oParam->params[0]->conta . "
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
                    $valor = $valor_debito <> 0 ? abs($valor_debito) : abs($valor_credito);
                    // $chave = $i++;
                    $agrupado[$chave][] = array("identificador" => $caixa,
                            "data_lancamento" => date("d/m/Y", strtotime($data)),
                            "data_conciliacao" => "",
                            "credor" => $credor,
                            "numcgm" => $numcgm,
                            "tipo" => descricaoTipoLancamento($cod_doc),
                            "op_rec_slip" => $documento,
                            "documento" => trim($cheque),
                            "movimento" => $movimento,
                            "valor" => $valor,
                            "historico" => descricaoHistorico($tipo, $codigo),
                            "cod_doc" => $cod_doc);

                    if (!array_key_exists($chave, $lancamentos)) {
                        $lancamentos[$chave]["identificador"] = $caixa;
                        $lancamentos[$chave]["data_lancamento"] = date("d/m/Y", strtotime($data));
                        $lancamentos[$chave]["data_conciliacao"] = "";
                        $lancamentos[$chave]["credor"] = $credor;
                        $lancamentos[$chave]["tipo"] = descricaoTipoLancamento($cod_doc);
                        $lancamentos[$chave]["op_rec_slip"] = $documento;
                        $lancamentos[$chave]["documento"] = trim($cheque);
                        $lancamentos[$chave]["movimento"] = $movimento;
                        $lancamentos[$chave]["valor"] = $valor_debito <> 0 ? $valor_debito : $valor_credito;
                        $lancamentos[$chave]["historico"] = descricaoHistorico($tipo, $codigo);
                        $lancamentos[$chave]["cod_doc"][] = $cod_doc;
                        $lancamentos[$chave]["numcgm"] = $numcgm;
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
                    $oDadosLinha->data_conciliacao = data_conciliacao($oParam->params[0]->conta, $lancamento["data_lancamento"], $lancamento["numcgm"],
                        $lancamento["cod_doc"], $lancamento["op_rec_slip"], "", abs($lancamento["valor"]));
                    $oDadosLinha->credor = $lancamento["credor"];
                    $oDadosLinha->tipo = $lancamento["tipo"];
                    $oDadosLinha->op_rec_slip = $lancamento["op_rec_slip"];
                    $oDadosLinha->documento = $lancamento["documento"];
                    $oDadosLinha->movimento = $lancamento["movimento"];
                    $oDadosLinha->valor = abs($lancamento["valor"]);
                    $oDadosLinha->historico = $lancamento["historico"];
                    $oDadosLinha->numcgm = $lancamento["numcgm"];
                    $oDadosLinha->cod_doc = $lancamento["cod_doc"];
                    $oRetorno->aLinhasExtrato[] = $oDadosLinha;
                }
            }
            break;
        case 'Processar':
            db_inicio_transacao();
            $oRetorno->aLinhasExtrato = array();
            $oDaoConciliacaoBancaria = new cl_conciliacaobancaria();
            // Recebe os parametros
            $conta = $oParam->params[0]->conta;
            $data_final = data($oParam->params[0]->data_final);
            $data_conciliacao = data($oParam->params[0]->data_conciliacao);
            $saldo_final_extrato = number_format($oParam->params[0]->saldo_final_extrato, 2, ".", "");
            // busca conciliação
            $oSql = $oDaoConciliacaoBancaria->sql_query_file(null, "*", null, "k171_conta = {$conta} AND k171_data = '{$data_final}' ");
            $oDaoConciliacaoBancaria->sql_record($oSql);
            $oRetorno->aLinhasExtrato = array();
            // $oRetorno->aLinhasExtrato[] = $oParam->params[0];
            // Tratativas
            if ($oDaoConciliacaoBancaria->numrows > 0) {
                $oDaoConciliacaoBancaria->k171_conta = $conta;
                $oDaoConciliacaoBancaria->k171_data = $data_final;
                $oDaoConciliacaoBancaria->k171_dataconciliacao = $data_conciliacao;
                $oDaoConciliacaoBancaria->k171_saldo = $saldo_final_extrato;
                $oDaoConciliacaoBancaria->alterar();
                $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria;
            } else {
                $oDaoConciliacaoBancaria->k171_conta = $conta;
                $oDaoConciliacaoBancaria->k171_data = $data_final;
                $oDaoConciliacaoBancaria->k171_dataconciliacao = $data_conciliacao;
                $oDaoConciliacaoBancaria->k171_saldo = $saldo_final_extrato;
                $oDaoConciliacaoBancaria->incluir();
                $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria;
            }
            // Preenche a movimentação
            $oRetorno->aLinhasExtrato[] = lancamentos_conciliados($oParam->params[0]->movimentos, $conta, $data_conciliacao);
            db_fim_transacao(false);
            break;
        case 'Desprocessar':
            db_inicio_transacao();
            $oRetorno->aLinhasExtrato = array();
            $oDaoConciliacaoBancaria = new cl_conciliacaobancaria();
            // Recebe os parametros
            $conta = $oParam->params[0]->conta;
            $data_final = data($oParam->params[0]->data_final);
            $data_conciliacao = data($oParam->params[0]->data_conciliacao);
            $saldo_final_extrato = number_format($oParam->params[0]->saldo_final_extrato, 2, ".", "");
            // busca conciliação
            $oRetorno->aLinhasExtrato[] = $oDaoConciliacaoBancaria->excluir(null, "k171_conta = {$conta} AND k171_data = '{$data_final}' AND k171_dataconciliacao = '{$data_conciliacao}'");
            // Preenche a movimentação
            $oRetorno->aLinhasExtrato[] = excluir_lancamentos_conciliados($oParam->params[0]->movimentos, $conta, $data_conciliacao);
            db_fim_transacao(false);
        break;
        case 'getDadosExtrato':
            $oRetorno->aLinhasExtrato = array();
            // $oRetorno->aLinhasExtrato[] = "Uso para debug";
            $data_inicial = data($oParam->params[0]->data_inicial);
            $data_final = data($oParam->params[0]->data_final);
            $conta = $oParam->params[0]->conta;
            // Preenche os dados para retorno
            $oDadosLinha = new StdClass();
            $oDadosLinha->saldo_anterior = saldo_anterior_extrato($conta, $data_inicial);
            $oDadosLinha->total_entradas = movimentacao_extrato($conta, $data_inicial, $data_final, 1);
            $oDadosLinha->total_saidas = movimentacao_extrato($conta, $data_inicial, $data_final, 2);
            $oDadosLinha->saldo_final = saldo_final_extrato($conta, $data_final);
            // Retorna os dados
            $oRetorno->aLinhasExtrato[] = $oDadosLinha;
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

function saldo_anterior_extrato($conta, $data) {
    $sql = "select
                substr(fc_saltessaldo, 2, 13) :: float8 as saldo_anterior
            from
                (
                    select
                        fc_saltessaldo(k13_reduz, '{$data}', '{$data}', null, 1)
                    from
                        saltes
                        inner join conplanoexe on k13_reduz = c62_reduz
                            and c62_anousu = " . db_getsession('DB_anousu') . "
                        inner join conplanoreduz on c61_anousu = c62_anousu
                            and c61_reduz = c62_reduz
                            and c61_instit = " . db_getsession("DB_instit") . "
                        inner join conplano on c60_codcon = c61_codcon
                            and c60_anousu = c61_anousu
                    where
                        c61_reduz = {$conta}
                        and c60_codsis = 6
                ) as x";
    $resultado = pg_query($sql);
    while ($row = pg_fetch_object($resultado)) {
        return $row->saldo_anterior;
    }
}

function saldo_final_extrato($conta, $data_final) {
    $sql = "select
                k171_saldo
            from
               conciliacaobancaria
            WHERE
                k171_conta = {$conta}
                AND k171_data = '{$data_final}'";
    $resultado = pg_query($sql);

    if (pg_numrows($resultado) > 0) {
        while ($row = pg_fetch_object($resultado)) {
            return number_format($row->k171_saldo, 2, ".", "");
        }
    } else {
        return 0;
    }
}

function movimentacao_extrato($conta, $data_inicial, $data_final, $movimentacao) {
    $sql = "select
                sum(k172_valor) movimentacao
            from
               conciliacaobancarialancamento
            WHERE
                k172_conta = {$conta}
                AND k172_dataconciliacao BETWEEN '{$data_inicial}' AND '{$data_final}'
                AND k172_mov = {$movimentacao}";
    $resultado = pg_query($sql);
    if (pg_numrows($resultado) > 0) {
        while ($row = pg_fetch_object($resultado)) {
            return number_format($row->movimentacao, 2, ".", "");
        }
    } else {
        return 0;
    }
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

function data($data)
{
    $data = explode("/", $data);
    return $data[2] . "-" . $data[1] . "-" . $data[0];
}

function excluir_lancamentos_conciliados($movimentos, $conta, $data_conciliacao)
{
    $retorno = array();
    // $retorno[] = $movimentos;
    foreach ($movimentos as $id => $movimento) {
        foreach ($movimento->tipo as $tipo) {
            $valor = str_replace(",", ".", str_replace(".", "", $movimento->valor));
            $numcgm = trim($movimento->cgm);
            $documento = trim(utf8_decode($movimento->codigo));
            $data = data($movimento->data_lancamento);
            $conciliacao = new cl_conciliacaobancarialancamento();
            $where = "k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc = {$tipo} AND k172_valor = {$valor} AND k172_dataconciliacao = '{$data_conciliacao}'";
            if ($numcgm)
                $where .= " AND k172_numcgm = {$numcgm} ";
            if ($documento)
                $where .= " AND k172_codigo = '{$documento}' ";
            $retorno[] = $where;
            $retorno[] = $conciliacao->excluir(null, $where);
        }
    }
    return $retorno;
}

function lancamentos_conciliados($movimentos, $conta, $data_conciliacao)
{
    $retorno = array();
    // $retorno[] = $movimentos;
    foreach ($movimentos as $id => $movimento) {
        foreach ($movimento->tipo as $tipo) {
            $valor = str_replace(",", ".", str_replace(".", "", $movimento->valor));
            $numcgm = trim($movimento->cgm);
            $documento = trim(utf8_decode($movimento->codigo));
            $data = data($movimento->data_lancamento);
            $conciliacao = new cl_conciliacaobancarialancamento();
            $where = "k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc = {$tipo} AND k172_valor = {$valor} ";
            if ($numcgm)
                $where .= " AND k172_numcgm = {$numcgm} ";
            if ($documento)
                $where .= " AND k172_codigo = '{$documento}' ";

            $oSql = $conciliacao->sql_query_file(null, "*", null, $where);
            $conciliacao->sql_record($oSql);
            // $oRetorno->aLinhasExtrato[] = $oParam->params[0];
            // Tratativas
            if ($conciliacao->numrows > 0) {
                $conciliacao->k172_conta = $conta;
                $conciliacao->k172_data = data($movimento->data_lancamento);
                $conciliacao->k172_numcgm = trim($movimento->cgm);
                $conciliacao->k172_coddoc = $tipo;
                $conciliacao->k172_mov = $movimento->movimentacao == "E" ? 1 : 2;
                $conciliacao->k172_codigo = trim(utf8_decode($movimento->codigo));
                $conciliacao->k172_valor = str_replace(",", ".", str_replace(".", "", $movimento->valor));
                $conciliacao->k172_dataconciliacao = $data_conciliacao;
                $conciliacao->alterar();
                $retorno[] = $conciliacao;
            } else {
                $conciliacao->k172_conta = $conta;
                $conciliacao->k172_data = data($movimento->data_lancamento);
                $conciliacao->k172_numcgm = trim($movimento->cgm);
                $conciliacao->k172_coddoc = $tipo;
                $conciliacao->k172_mov = $movimento->movimentacao == "E" ? 1 : 2;
                $conciliacao->k172_codigo = trim(utf8_decode($movimento->codigo));
                $conciliacao->k172_valor = str_replace(",", ".", str_replace(".", "", $movimento->valor));
                $conciliacao->k172_dataconciliacao = $data_conciliacao;
                $conciliacao->incluir();
                $retorno[] = $conciliacao;
            }
        }
    }
    return $retorno;
}

function data_conciliacao($conta, $data, $numcgm, $cod_doc, $documento, $cheque, $valor)
{
    $oDaoConciliacaoBancaria = new cl_conciliacaobancarialancamento();
    $cod_doc = implode(",", $cod_doc);
    $data = data($data);
    $where = "k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc IN ({$cod_doc}) AND k172_valor = {$valor}";
    if ($numcgm)
        $where .= " AND k172_numcgm = {$numcgm} ";
    if ($documento)
        $where .= " AND k172_codigo = '{$documento}' ";

    $oSql = $oDaoConciliacaoBancaria->sql_query_file(null, "*", null, $where);
    $linha = $oDaoConciliacaoBancaria->sql_record($oSql);
    if ($oDaoConciliacaoBancaria->numrows > 0) {
        return date("d/m/Y", strtotime(pg_result($linha, 0, 6)));
    } else {
        return "";
    }
}
