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

class cl_emite_nota_liq {

    function get_sql_ordem_pagamento($iInstit, $iAnoUsu, $e50_codord) {
        
        $sql = "select *, 
                    o56_elemento AS sintetico,
                    o56_descr AS descr_sintetico,
                    e03_numeroprocesso as processo
           from
           (select *,fc_estruturaldotacao(o58_anousu,o58_coddot) as estrutural,
	           case when e49_numcgm is null then e60_numcgm else e49_numcgm end as _numcgm,
             ordena.z01_numcgm as cgmordenadespesa,
             ordena.z01_nome as ordenadesp,
             liquida.z01_numcgm as cgmliquida,
             liquida.z01_nome as liquida,
             paga.z01_numcgm as cgmpaga,
             paga.z01_nome as ordenapaga,
             contador.z01_nome as contador,
             contad.si166_crccontador as crc,
             controleinterno.z01_nome as controleinterno,

             (select nome from db_usuarios where id_usuario = pagordem.e50_id_usuario) as usuario,
             e54_autori,
             pc50_descr
           from pagordem
				inner join empempenho on empempenho.e60_numemp = pagordem.e50_numemp
        inner join cgm on cgm.z01_numcgm = empempenho.e60_numcgm
  			inner join empnota on empnota.e69_numemp = pagordem.e50_numemp
				inner join db_config on db_config.codigo = empempenho.e60_instit
				inner join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu
			  and orcdotacao.o58_coddot = empempenho.e60_coddot
				and o58_instit = {$iInstit}
				inner join orcorgao on o58_orgao = o40_orgao
				and o40_anousu = empempenho.e60_anousu
				inner join orcunidade on o58_unidade = o41_unidade
				and o58_orgao = o41_orgao
				and o58_anousu = o41_anousu
				inner join orcfuncao on o58_funcao = o52_funcao
				inner join orcsubfuncao on o58_subfuncao = o53_subfuncao
				inner join orcprograma on o58_programa = o54_programa
				and o54_anousu = o58_anousu
				inner join orcprojativ on o58_projativ = o55_projativ
				and o55_anousu = o58_anousu
				inner join orcelemento a on o58_codele = o56_codele
				and o58_anousu = o56_anousu
				inner join orctiporec on o58_codigo = o15_codigo
				inner join emptipo on emptipo.e41_codtipo = empempenho.e60_codtipo
        left join cgm as ordena on ordena.z01_numcgm = o41_orddespesa
        left join cgm as paga on paga.z01_numcgm = o41_ordpagamento
        left join cgm as liquida on liquida.z01_numcgm = o41_ordliquidacao
        left join identificacaoresponsaveis contad on contad.si166_instit= e60_instit 
        and contad.si166_tiporesponsavel=2
        and {$iAnoUsu} between DATE_PART('YEAR',contad.si166_dataini) AND DATE_PART('YEAR',contad.si166_datafim)
        and contad.si166_dataini <= e50_data
        and contad.si166_datafim >= e50_data
        left join cgm as contador on contador.z01_numcgm = contad.si166_numcgm
        left join identificacaoresponsaveis controle on controle.si166_instit= e60_instit 
        and controle.si166_tiporesponsavel=3
        and {$iAnoUsu} between DATE_PART('YEAR',controle.si166_dataini) AND DATE_PART('YEAR',controle.si166_datafim)
     		and controle.si166_dataini <= e50_data
     		and controle.si166_datafim >= e50_data
        left join cgm as controleinterno on controleinterno.z01_numcgm = controle.si166_numcgm
        left JOIN identificacaoresponsaveis ordenapaga ON ordenapaga.si166_instit= e60_instit 
        and ordenapaga.si166_tiporesponsavel=1
     		and {$iAnoUsu} between DATE_PART('YEAR',ordenapaga.si166_dataini) AND DATE_PART('YEAR',ordenapaga.si166_datafim)
     		and ordenapaga.si166_dataini <= e50_data
     		and ordenapaga.si166_datafim >= e50_data
     		LEFT JOIN cgm AS ordenapagamento ON ordenapagamento.z01_numcgm = ordenapaga.si166_numcgm
				left join pagordemconta on e50_codord = e49_codord
				left join pagordemprocesso on pagordem.e50_codord = pagordemprocesso.e03_pagordem
        left outer join empempaut on e60_numemp = e61_numemp
        left join empautoriza ON e61_autori = e54_autori
        left join pctipocompra on pc50_codcom = e60_codcom
				where pagordem.e50_codord = {$e50_codord} ) as x
        inner join cgm on cgm.z01_numcgm = _numcgm
        left join pcfornecon on pc63_numcgm = _numcgm
        left join pcforneconpad ON pc64_contabanco = pc63_contabanco
        ORDER BY pc64_contabanco
	   ";

       return $sql;
    }

    function get_sql_assinaturas($e50_codord) {
        
        $sql1 = "SELECT desp.z01_nome assindsp, 
            liqu.z01_nome assinlqd, 
            orde.z01_nome assinord
            FROM orcunidade
            LEFT JOIN cgm desp ON desp.z01_numcgm = o41_orddespesa
            LEFT JOIN cgm liqu ON liqu.z01_numcgm = o41_ordliquidacao
            LEFT JOIN cgm orde ON orde.z01_numcgm = o41_ordpagamento 
            LEFT JOIN orcorgao ON o40_anousu = o41_anousu 
            AND o40_orgao = o41_orgao 
            INNER JOIN orcdotacao ON o58_orgao = o41_orgao 
            AND o58_unidade = o41_unidade 
            AND o58_instit = o41_instit 
            INNER JOIN empempenho ON e60_coddot = o58_coddot
            AND e60_anousu = o58_anousu
            INNER JOIN pagordem ON e50_numemp = e60_numemp 
            WHERE e50_codord = {$e50_codord} 
            AND o41_anousu = DATE_PART('YEAR',pagordem.e50_data)
        ";

      return $sql1;
    }

    function get_sql_item_ordem($e50_codord) {

        $sqlitem = "select *,e53_valor - e53_vlranu as saldo, e53_valor - e53_vlranu - e53_vlrpag as saldo_final
              from pagordemele

	           inner join pagordem on pagordem.e50_codord = pagordemele.e53_codord
		   inner join empempenho on empempenho.e60_numemp = pagordem.e50_numemp
		   left join orcelemento on orcelemento.o56_codele = pagordemele.e53_codele and
		                             orcelemento.o56_anousu = empempenho.e60_anousu

		   left join empelemento on empelemento.e64_numemp = empempenho.e60_numemp
		   			 and orcelemento.o56_codele = empelemento.e64_codele

		   where pagordemele.e53_codord = {$e50_codord} ";

        return $sqlitem;

    }

    function get_sql_outras_ordens($e50_codord, $e50_numemp) {

        $sqloutrasordens = " select sum(saldo) as outrasordens
              from
              (select *,e53_valor - e53_vlranu as saldo
              from pagordemele
	           inner join pagordem on pagordem.e50_codord = pagordemele.e53_codord
		   inner join empempenho on empempenho.e60_numemp = pagordem.e50_numemp
		   inner join orcelemento on orcelemento.o56_codele = pagordemele.e53_codele and
		                             orcelemento.o56_anousu = empempenho.e60_anousu
		   inner join empelemento on empelemento.e64_numemp = empempenho.e60_numemp
		   			 and orcelemento.o56_codele = empelemento.e64_codele

		   where pagordem.e50_codord <> {$e50_codord}
		     and pagordem.e50_numemp = {$e50_numemp}) as x";

        return $sqloutrasordens;

    }

    function get_sql_fornecedor($z01_cgccpf) {
        
        $sqlfornecon = "    select *,
                                case 
                                    when pc63_cnpjcpf is not null and trim(pc63_cnpjcpf) <> '' and pc63_cnpjcpf::text::int8 > 0 
                                        then pc63_cnpjcpf 
                                    else '".$z01_cgccpf."' 
                                end as z01_cgccpf 
                            from pcfornecon 
                            inner join pcforneconpad on pc64_contabanco = pc63_contabanco 
                            where pc63_cnpjcpf = '".$z01_cgccpf."' limit 1";
        
        return $sqlfornecon;

    }

    function get_sql_funcao_ordena_pagamento($cgmpaga) {
        
        $sSqlFuncaoOrdenaPagamento  = " select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenapagamento ";
        $sSqlFuncaoOrdenaPagamento .= " from rhpessoal  ";
        $sSqlFuncaoOrdenaPagamento .= " LEFT join rhpessoalmov on rh02_regist=rh01_regist  ";
        $sSqlFuncaoOrdenaPagamento .= " LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao ";
        $sSqlFuncaoOrdenaPagamento .= " LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes ";
        $sSqlFuncaoOrdenaPagamento .= " LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo  ";
        $sSqlFuncaoOrdenaPagamento .= " where rh01_numcgm = $cgmpaga and rh01_admiss >= (select max(rh01_admiss) from rhpessoal where rh01_numcgm = $cgmpaga)";
        $sSqlFuncaoOrdenaPagamento .= " order by rh02_seqpes desc limit 1 ";

        return $sSqlFuncaoOrdenaPagamento;
    }

    function get_sql_funcao_ordena_despesa($cgmordenadespesa) {
        
        $sSqlFuncaoOrdenadespesa  = " select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoordenadespesa";
        $sSqlFuncaoOrdenadespesa .= " from rhpessoal ";
        $sSqlFuncaoOrdenadespesa .= " LEFT join rhpessoalmov on rh02_regist=rh01_regist ";
        $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao";
        $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes";
        $sSqlFuncaoOrdenadespesa .= " LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo ";
        $sSqlFuncaoOrdenadespesa .= " where rh01_numcgm = $cgmordenadespesa and rh01_admiss >= (select max(rh01_admiss) from rhpessoal where rh01_numcgm = $cgmordenadespesa)";
        $sSqlFuncaoOrdenadespesa .= " order by rh02_seqpes desc limit 1 ";

        return $sSqlFuncaoOrdenadespesa;

    }

    function get_sql_funcao_ordena_liquida($cgmliquida) {

        $sSqlFuncaoLiquida  = " select case when length(rh04_descr)>0 then rh04_descr else rh37_descr end as cargoliquida";
        $sSqlFuncaoLiquida .= " from rhpessoal ";
        $sSqlFuncaoLiquida .= " LEFT join rhpessoalmov on rh02_regist=rh01_regist ";
        $sSqlFuncaoLiquida .= " LEFT JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao";
        $sSqlFuncaoLiquida .= " LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes";
        $sSqlFuncaoLiquida .= " LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo ";
        $sSqlFuncaoLiquida .= " where rh01_numcgm = $cgmliquida and rh01_admiss >= (select max(rh01_admiss) from rhpessoal where rh01_numcgm = $cgmliquida)"; 
        $sSqlFuncaoLiquida .= " order by rh02_seqpes desc limit 1 ";

        return $sSqlFuncaoLiquida;

    }

    function get_dados_licitacao($e54_tipoautorizacao, $e54_autori) {

        $sCampos    = "distinct e54_numerl,e54_nummodalidade,e54_anousu,e54_resumo";
        $sWhere     = "e55_autori = $e54_autori ";
        $sSql       = $clempautitem->sql_query_processocompras(null, null, $sCampos, null, $sWhere);
        $result_empaut = $clempautitem->sql_record($sSql);

        $oDado = new stdClass();
        $oDado->processo            = '';
        $oDado->descr_tipocompra    = '';

        //tipo Direta
        if ($e54_tipoautorizacao == 1 || $e54_tipoautorizacao == 0) {

            if ($clempautitem->numrows > 0) {         

                db_fieldsmemory($result_empaut, 0);
                $oDado->processo            = $e54_numerl;
                $oDado->descr_tipocompra    = $pc50_descr;

            }

        }

        //tipo licitacao de outros orgaos
        if ($e54_tipoautorizacao == 2) {
            
            if ($clempautitem->numrows > 0) {

                db_fieldsmemory($result_empaut, 0);
                $arr_numerl = split("/", $e54_numerl);
                $oDado->processo            = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->descr_tipocompra    = $pc50_descr;

            }
        
        }

        //tipo licitacao
        if ($e54_tipoautorizacao == 3) {
            
            if ($clempautitem->numrows > 0) {

                db_fieldsmemory($result_empaut, 0);
                $arr_numerl = split("/", $e54_numerl);
                $oDado->processo            = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->descr_tipocompra    = $pc50_descr;

            }

        }

        //tipo Adesao regpreco
        if ($e54_tipoautorizacao == 4 ) {
            
            if ($clempautitem->numrows > 0) {
            
                db_fieldsmemory($result_empaut, 0);
                $arr_numerl = split("/", $e54_numerl);
                $oDado->processo            = $arr_numerl[0].'/'.$arr_numerl[1];
                $oDado->descr_tipocompra    = $pc50_descr;

            }

        }

        return $oDado;

    }

}

?>