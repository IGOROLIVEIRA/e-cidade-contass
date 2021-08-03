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

class cl_emite_nota_empenho {

    function get_sql_empenho($iAnoUsu, $iInstit, $sWhere) {

        $sqlemp  = " SELECT empempenho.*, ";
        $sqlemp .= "        cgm.*, ";
        $sqlemp .= "        o58_orgao, ";
        $sqlemp .= "        o40_descr, ";
        $sqlemp .= "        o58_unidade, ";
        $sqlemp .= "        o41_descr, ";
        $sqlemp .= "        o58_funcao, ";
        $sqlemp .= "        o52_descr, ";
        $sqlemp .= "        o58_subfuncao, ";
        $sqlemp .= "        o53_descr, ";
        $sqlemp .= "        o58_programa, ";
        $sqlemp .= "        o54_descr, ";
        $sqlemp .= "        o58_projativ, ";
        $sqlemp .= "        o55_descr, ";
        $sqlemp .= "        o58_coddot, ";
        $sqlemp .= "        o41_cnpj, ";
        $sqlemp .= "        o56_elemento AS sintetico, ";
        $sqlemp .= "        o56_descr AS descr_sintetico, ";
        $sqlemp .= "        o58_codigo, ";
        $sqlemp .= "        o15_descr, ";
        $sqlemp .= "        e61_autori, ";
        $sqlemp .= "        pc50_descr, ";
        $sqlemp .= "        fc_estruturaldotacao(o58_anousu,o58_coddot) AS estrutural, ";
        $sqlemp .= "        e41_descr, ";
        $sqlemp .= "        c58_descr, ";
        $sqlemp .= "        e56_orctiporec, ";
        $sqlemp .= "        e54_anousu, ";
        $sqlemp .= "        e54_praent, ";
        $sqlemp .= "        e54_tipoautorizacao, ";
        $sqlemp .= "        e54_tipoorigem, ";
        $sqlemp .= "        e54_nummodalidade, ";
        $sqlemp .= "        e54_licoutrosorgaos, ";
        $sqlemp .= "        e54_adesaoregpreco, ";
        $sqlemp .= "        e54_numerl, ";
        $sqlemp .= "        e54_codout, ";
        $sqlemp .= "        e54_conpag, ";
        $sqlemp .= "        e54_autori, ";
        $sqlemp .= "        e60_id_usuario, ";
        $sqlemp .= "        db_usuarios.nome, ";
        $sqlemp .= "        ordena.z01_numcgm AS cgmordenadespesa, ";
        $sqlemp .= "        ordena.z01_nome AS ordenadesp, ";
        $sqlemp .= "        liquida.z01_numcgm AS cgmliquida, ";
        $sqlemp .= "        liquida.z01_nome AS liquida, ";
        $sqlemp .= "        paga.z01_numcgm AS cgmpaga, ";
        $sqlemp .= "        paga.z01_nome AS ordenapaga, ";
        $sqlemp .= "        contador.z01_nome AS contador, ";
        $sqlemp .= "        contad.si166_crccontador AS crc, ";
        $sqlemp .= "        controleinterno.z01_nome AS controleinterno ";
        $sqlemp .= " FROM empempenho ";
        $sqlemp .= " LEFT JOIN db_usuarios ON db_usuarios.id_usuario = e60_id_usuario";
        $sqlemp .= " LEFT JOIN pctipocompra ON pc50_codcom = e60_codcom ";
        $sqlemp .= " INNER JOIN orcdotacao ON o58_coddot = e60_coddot AND o58_instit = {$iInstit} AND o58_anousu = e60_anousu ";
        $sqlemp .= " INNER JOIN orcorgao ON o58_orgao = o40_orgao AND o40_anousu = {$iAnoUsu} ";
        $sqlemp .= " INNER JOIN orcunidade ON o58_unidade = o41_unidade AND o58_orgao = o41_orgao AND o41_anousu = o58_anousu ";
        $sqlemp .= " INNER JOIN orcfuncao ON o58_funcao = o52_funcao ";
        $sqlemp .= " INNER JOIN orcsubfuncao ON o58_subfuncao = o53_subfuncao ";
        $sqlemp .= " INNER JOIN orcprograma ON o58_programa = o54_programa AND o54_anousu = o58_anousu ";
        $sqlemp .= " INNER JOIN orcprojativ ON o58_projativ = o55_projativ AND o55_anousu = o58_anousu ";
        $sqlemp .= " INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu ";
        $sqlemp .= " INNER JOIN orctiporec ON o58_codigo = o15_codigo ";
        $sqlemp .= " INNER JOIN cgm ON z01_numcgm = e60_numcgm ";
        $sqlemp .= " INNER JOIN concarpeculiar ON concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar ";
        $sqlemp .= " LEFT JOIN cgm AS ordena ON ordena.z01_numcgm = o41_orddespesa ";
        $sqlemp .= " LEFT JOIN cgm AS paga ON paga.z01_numcgm = o41_ordpagamento ";
        $sqlemp .= " LEFT JOIN cgm AS liquida ON liquida.z01_numcgm = o41_ordliquidacao ";
        $sqlemp .= " LEFT JOIN identificacaoresponsaveis contad ON contad.si166_instit= e60_instit ";
        $sqlemp .= " AND contad.si166_tiporesponsavel=2 ";
        $sqlemp .= " AND (contad.si166_dataini <=  e60_emiss ";
        $sqlemp .= " AND contad.si166_datafim >=  e60_emiss) ";
        $sqlemp .= " LEFT JOIN cgm AS contador ON contador.z01_numcgm = contad.si166_numcgm ";
        $sqlemp .= " LEFT JOIN identificacaoresponsaveis controle ON controle.si166_instit= e60_instit ";
        $sqlemp .= " AND controle.si166_tiporesponsavel=3 ";
        $sqlemp .= " AND (controle.si166_dataini <=  e60_emiss ";
        $sqlemp .= " AND controle.si166_datafim >=  e60_emiss) ";
        $sqlemp .= " LEFT JOIN cgm AS controleinterno ON controleinterno.z01_numcgm = controle.si166_numcgm ";
        $sqlemp .= " LEFT OUTER JOIN empempaut ON e60_numemp = e61_numemp ";
        $sqlemp .= " LEFT JOIN empautoriza ON e61_autori = e54_autori ";
        $sqlemp .= " LEFT JOIN empautidot ON e61_autori = e56_autori ";
        $sqlemp .= " LEFT OUTER JOIN emptipo ON e60_codtipo= e41_codtipo ";
        $sqlemp .= " WHERE $sWhere ";
        $sqlemp .= " order by e60_codemp::bigint ";

        return $sqlemp;

    } 

    function get_sql_pacto($e61_autori) {

        $sSqlPacto  = " SELECT distinct pactoplano.* ";
        $sSqlPacto .= "   from empautitem ";
        $sSqlPacto .= "        inner join empautitempcprocitem       on empautitempcprocitem.e73_autori = empautitem.e55_autori";
        $sSqlPacto .= "                                             and empautitempcprocitem.e73_sequen = empautitem.e55_sequen";
        $sSqlPacto .= "        inner join pcprocitem                 on pcprocitem.pc81_codprocitem     = empautitempcprocitem.e73_pcprocitem";
        $sSqlPacto .= "        inner join solicitem                  on pc81_solicitem                  = pc11_codigo";
        $sSqlPacto .= "        inner join orctiporecconveniosolicita on pc11_numero                     = o78_solicita";
        $sSqlPacto .= "        inner join pactoplano                 on o78_pactoplano                  = o74_sequencial";
        $sSqlPacto .= "  where e55_autori = {$e61_autori}";

        return $sSqlPacto;
    }

    /**
     * Busca o processo
     */
    function get_sql_processo_administrativo($e61_autori) {

        $oDaoEmpAutorizaProcesso  = db_utils::getDao("empautorizaprocesso");
        $sWhereBuscaProcessoAdmin = " e150_empautoriza = {$e61_autori}";
        $sSqlBuscaProcessoAdmin   = $oDaoEmpAutorizaProcesso->sql_query_file(null, "e150_numeroprocesso", null, $sWhereBuscaProcessoAdmin);
        $rsBuscaProcessoAdmin     = $oDaoEmpAutorizaProcesso->sql_record($sSqlBuscaProcessoAdmin);
        $sProcessoAdministrativo  = "";

        if ($rsBuscaProcessoAdmin && $oDaoEmpAutorizaProcesso->numrows > 0) {
            $sProcessoAdministrativo = db_utils::fieldsMemory($rsBuscaProcessoAdmin, 0)->e150_numeroprocesso;
        }

        return $sProcessoAdministrativo;
    }

    function get_sql_item($sCondtipos, $e60_numemp) {

        $sqlitem  = " select distinct ";
        $sqlitem .= "        pc01_complmater, ";
        $sqlitem .= "        pc01_descrmater, ";
        $sqlitem .= "        pc10_numero, ";
        $sqlitem .= "        e62_sequen, ";
        $sqlitem .= "        e62_numemp, ";
        $sqlitem .= "        pc01_codmater, ";
        $sqlitem .= "        e62_quant, ";
        $sqlitem .= "        e62_vltot, ";
        $sqlitem .= "        e62_vlrun, ";
        $sqlitem .= "        e62_codele, ";
        $sqlitem .= "        o56_elemento, ";
        $sqlitem .=          $sCondtipos;
        $sqlitem .= "        o56_descr, ";
        $sqlitem .= "        rp.pc81_codproc, ";
        $sqlitem .= "        solrp.pc11_numero, ";
        $sqlitem .= "        solrp.pc11_codigo, ";
        $sqlitem .= "        l20_prazoentrega, ";
        $sqlitem .= "        e55_marca, ";
        $sqlitem .= "        case when pc10_solicitacaotipo = 5 then coalesce(trim(pcitemvalrp.pc23_obs), '') ";
        $sqlitem .= "             else  coalesce(trim(pcorcamval.pc23_obs), '') end as pc23_obs ";
        $sqlitem .= "   from empempitem ";
        $sqlitem .= "       inner join empempenho           on empempenho.e60_numemp           = empempitem.e62_numemp ";
        $sqlitem .= "       left join db_usuarios ON db_usuarios.id_usuario = empempenho.e60_id_usuario";
        $sqlitem .= "       inner join pcmater              on pcmater.pc01_codmater           = empempitem.e62_item ";
        $sqlitem .= "       inner join orcelemento          on orcelemento.o56_codele          = empempitem.e62_codele ";
        $sqlitem .= "                                      and orcelemento.o56_anousu          = empempenho.e60_anousu ";
        $sqlitem .= "       left join empempaut             on empempaut.e61_numemp            = empempenho.e60_numemp ";
        $sqlitem .= "       left join empautitem            on empautitem.e55_autori           = empempaut.e61_autori ";
        $sqlitem .= "                                      and e62_sequen = e55_sequen ";
        $sqlitem .= "       left join empautitempcprocitem        on empautitempcprocitem.e73_autori      = empautitem.e55_autori ";
        $sqlitem .= "                                            and empautitempcprocitem.e73_sequen      = empautitem.e55_sequen ";
        $sqlitem .= "       left join pcprocitem rp               on rp.pc81_codprocitem                  = empautitempcprocitem.e73_pcprocitem ";
        $sqlitem .= "       left join solicitem solrp             on solrp.pc11_codigo                    = rp.pc81_solicitem ";
        $sqlitem .= "       left join solicita                    on solicita.pc10_numero                 = solrp.pc11_numero ";
        $sqlitem .= "       left join solicitemvinculo            on solicitemvinculo.pc55_solicitemfilho = solrp.pc11_codigo ";
        $sqlitem .= "       left join solicitem compilacao        on solicitemvinculo.pc55_solicitempai   = compilacao.pc11_codigo ";
        $sqlitem .= "       left join pcprocitem proccompilacao   on pc55_solicitempai                    = proccompilacao.pc81_solicitem ";
        $sqlitem .= "       left join liclicitem licitarp         on proccompilacao.pc81_codprocitem      = licitarp.l21_codpcprocitem ";
        $sqlitem .= "       left join pcorcamitemlic pcitemrp     on licitarp.l21_codigo                  = pcitemrp.pc26_liclicitem ";
        $sqlitem .= "       left join pcorcamjulg julgrp          on pcitemrp.pc26_orcamitem              = julgrp.pc24_orcamitem ";
        $sqlitem .= "                                            and julgrp.pc24_pontuacao                = 1 ";
        $sqlitem .= "       left join pcorcamval pcitemvalrp      on julgrp.pc24_orcamitem                = pcitemvalrp.pc23_orcamitem ";
        $sqlitem .= "                                            and julgrp.pc24_orcamforne               = pcitemvalrp.pc23_orcamforne ";
        $sqlitem .= "       left join empautitempcprocitem  pcprocitemaut  on pcprocitemaut.e73_autori        = empautitem.e55_autori ";
        $sqlitem .= "                                                     and pcprocitemaut.e73_sequen        = empautitem.e55_sequen ";
        $sqlitem .= "       left join pcprocitem                           on pcprocitem.pc81_codprocitem     = pcprocitemaut.e73_pcprocitem ";
        $sqlitem .= "       left join solicitem                            on solicitem.pc11_codigo           = pcprocitem.pc81_solicitem ";
        $sqlitem .= "       left join liclicitem                           on liclicitem.l21_codpcprocitem    = pcprocitemaut.e73_pcprocitem ";
        $sqlitem .= "       left join pcorcamitemlic                       on pcorcamitemlic.pc26_liclicitem  = liclicitem.l21_codigo ";
        $sqlitem .= "       left join pcorcamjulg                          on pcorcamjulg.pc24_orcamitem      = pcorcamitemlic.pc26_orcamitem ";
        $sqlitem .= "                                                     and pcorcamjulg.pc24_pontuacao      = 1 ";
        $sqlitem .= "       left join pcorcamval                           on pcorcamval.pc23_orcamitem       = pcorcamjulg.pc24_orcamitem ";
        $sqlitem .= "                                                     and pcorcamval.pc23_orcamforne      = pcorcamjulg.pc24_orcamforne ";
        $sqlitem .= "		left join solicitemunid on solicitem.pc11_codigo = solicitemunid.pc17_codigo";
        $sqlitem .= "		left join matunid on matunid.m61_codmatunid = solicitemunid.pc17_unid or matunid.m61_codmatunid = e55_unid";
        $sqlitem .= "       left join liclicita on liclicitem.l21_codliclicita = liclicita.l20_codigo ";
        $sqlitem .= "  where e62_numemp = '{$e60_numemp}' ";
        $sqlitem .= " order by e62_sequen, o56_elemento,pc01_descrmater";

        return $sqlitem;
    }

    function get_sql_funcao_ordena_pagamento($cgmpaga, $iAno, $iMes) {

        $sSqlFuncaoOrdenaPagamento  ="select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenapagamento ";
        $sSqlFuncaoOrdenaPagamento .=" from rhpessoal  ";
        $sSqlFuncaoOrdenaPagamento .="LEFT join rhpessoalmov on rh02_regist=rh01_regist  ";
        $sSqlFuncaoOrdenaPagamento .="LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao ";
        $sSqlFuncaoOrdenaPagamento .="LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes ";
        $sSqlFuncaoOrdenaPagamento .="LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo  ";
        $sSqlFuncaoOrdenaPagamento .="LEFT JOIN rhpesrescisao ON rh02_seqpes=rh05_seqpes ";
        $sSqlFuncaoOrdenaPagamento .="where rh05_recis is null and rh01_numcgm = $cgmpaga ";
        $sSqlFuncaoOrdenaPagamento .=" AND rh02_anousu = {$iAno}";
        $sSqlFuncaoOrdenaPagamento .=" AND rh02_mesusu = {$iMes}";
        $sSqlFuncaoOrdenaPagamento .=" order by  rh02_seqpes asc limit 1 ";

        return $sSqlFuncaoOrdenaPagamento;
        
    }

    function get_sql_funcao_ordena_despesa($cgmordenadespesa, $iAno, $iMes) {
    
        $sSqlFuncaoOrdenadespesa =" select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenadespesa";
        $sSqlFuncaoOrdenadespesa .=" from rhpessoal ";
        $sSqlFuncaoOrdenadespesa .=" LEFT join rhpessoalmov on rh02_regist=rh01_regist ";
        $sSqlFuncaoOrdenadespesa .=" LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao";
        $sSqlFuncaoOrdenadespesa .=" LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes";
        $sSqlFuncaoOrdenadespesa .=" LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo ";
        $sSqlFuncaoOrdenadespesa .=" LEFT JOIN rhpesrescisao ON rh02_seqpes=rh05_seqpes ";
        $sSqlFuncaoOrdenadespesa .=" where rh05_recis is null and rh01_numcgm = $cgmordenadespesa";
        $sSqlFuncaoOrdenadespesa .=" AND rh02_anousu = {$iAno}";
        $sSqlFuncaoOrdenadespesa .=" AND rh02_mesusu = {$iMes}";
        $sSqlFuncaoOrdenadespesa .="order by rh02_seqpes asc limit 1";

        return $sSqlFuncaoOrdenadespesa;

    }

    function get_dados_licitacao($e54_tipoautorizacao, $e54_autori, $pc50_descr = '') {
    
        /**
         * Crio os campos PROCESSO/ANO,MODALIDADE/ANO e DESCRICAO MODALIDADE de acordo com solicitação
         * @MarioJunior OC 7425
        */

        $clempautitem   = db_utils::getDao("empautitem");
        $sCampos        = "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo";
        $sSqlEmpaut     = $clempautitem->sql_query_processocompras(null, null, $sCampos, null, "e55_autori = $e54_autori ");
        $result_empaut  = $clempautitem->sql_record($sSqlEmpaut);

        $oDado = new stdClass();
        $oDado->edital_licitacao    = '';
        $oDado->modalidade          = '';
        $oDado->descr_tipocompra    = '';
        $oDado->descr_modalidade    = '';
    
        //tipo Direta
        if($e54_tipoautorizacao == 1 || $e54_tipoautorizacao == 0) {
            
            if ($clempautitem->numrows > 0) {
                $oResult = db_utils::fieldsMemory($result_empaut, 0);
                if($oResult->e54_numerl != "") {
                    $arr_numerl = split("/", $oResult->e54_numerl);
                    $oDado->edital_licitacao = $arr_numerl[0] . '/' . $arr_numerl[1];
                    $oDado->modalidade = $oResult->e54_nummodalidade . '/' . $arr_numerl[1];
                }else{
                    $oDado->edital_licitacao = "";
                    $oDado->modalidade = "";
                }
            }
            $oDado->descr_tipocompra = $pc50_descr;
            $oDado->descr_modalidade = $pc50_descr;
        }

        //tipo licitacao de outros orgaos

        if($e54_tipoautorizacao == 2){
            
            if ($clempautitem->numrows > 0) {
                $oResult = db_utils::fieldsMemory($result_empaut, 0);
                $arr_numerl = split("/", $oResult->e54_numerl);
                $oDado->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->modalidade = $oResult->e54_nummodalidade.'/'.$arr_numerl[1];
            }
            $oDado->descr_tipocompra = substr($pc50_descr,0,36);
            $oDado->descr_modalidade = '';
        }

        //tipo licitacao
        if($e54_tipoautorizacao == 3){
            
            if ($clempautitem->numrows > 0) {
                $oResult = db_utils::fieldsMemory($result_empaut, 0);
                $arr_numerl = split("/", $oResult->e54_numerl);
                $oDado->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->modalidade = $oResult->e54_nummodalidade.'/'.$arr_numerl[1];
            }
            $oDado->descr_tipocompra = $pc50_descr;
            $oDado->descr_modalidade = $pc50_descr;
        }

        //tipo Adesao regpreco
        if($e54_tipoautorizacao == 4){
            
            if ($clempautitem->numrows > 0) {
                $oResult = db_utils::fieldsMemory($result_empaut, 0);
                $arr_numerl = split("/", $oResult->e54_numerl);
                $oDado->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->modalidade = $oResult->e54_nummodalidade.'/'.$arr_numerl[1];
            }
            $oDado->descr_tipocompra = $pc50_descr;
            $oDado->descr_modalidade = '';
        }

        return $oDado;

    }

    function get_acordo($e60_numemp) {
    
        $sSql = " SELECT ac16_numeroacordo, ac16_anousu from empempenhocontrato JOIN acordo ON ac16_sequencial = e100_acordo where e100_numemp = ".$e60_numemp;
        $rsAcordo = db_query($sSql);
        return db_utils::fieldsMemory($rsAcordo, 0);

    }

}

?>