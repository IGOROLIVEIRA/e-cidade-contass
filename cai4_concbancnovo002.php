<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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


include("fpdf151/pdf.php");
include ("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

// echo($HTTP_SERVER_VARS["QUERY_STRING"]); exit;

$head1 = "Conciliação Bancária";

//$head3 = "PERÍODO : ".db_formatar(@$datai,"d")." A ".db_formatar(@$dataf,"d");
$head3 = "PERÍODO : ".db_formatar(@$data_inicial, "d")." A ".db_formatar(@$data_final,"d");

/// CONTAS MOVIMENTO
$sql ="	    select   k13_reduz,
                     k13_descr,
		     k13_dtimplantacao,
                     c60_estrut,
                     c60_codsis,
	                   c63_conta,
                       c63_dvconta,
                       c63_agencia,
                       c63_dvagencia,
	                   substr(fc_saltessaldo,2,13)::float8 as anterior,
	                   substr(fc_saltessaldo,15,13)::float8 as debitado ,
	                   substr(fc_saltessaldo,28,13)::float8 as creditado,
	                   substr(fc_saltessaldo,41,13)::float8 as atual
            	from (
 	                  select k13_reduz,
 	                         k13_descr,
				 k13_dtimplantacao,
	                         c60_estrut,
		                       c60_codsis,
		                       c63_conta,
                               c63_dvconta,
                               c63_agencia,
                               c63_dvagencia,
	                         fc_saltessaldo(k13_reduz,'".$data_inicial."','".$data_final."',null," . db_getsession("DB_instit") . ")
	                  from   saltes
	                         inner join conplanoexe   on k13_reduz = c62_reduz
		                                              and c62_anousu = ".db_getsession('DB_anousu')."
		                     inner join conplanoreduz on c61_anousu=c62_anousu and c61_reduz = c62_reduz and c61_instit = " . db_getsession("DB_instit") . "
	                         inner join conplano      on c60_codcon = c61_codcon and c60_anousu=c61_anousu
	                         left  join conplanoconta on c60_codcon = c63_codcon and c63_anousu=c60_anousu ";
if($conta_nova != "") {
	$sql .= "where c61_reduz = {$conta_nova} ";
}
$sql .= "  ) as x ";
$sql .= " order by substr(k13_descr,1,3),k13_reduz ";

//echo "2 ".$sql; exit;
$resultcontasmovimento = db_query($sql);

if(pg_numrows($resultcontasmovimento) == 0){
	db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados neste periodo.');
}

$saldo_dia_credito = 0;
$saldo_dia_debito = 0;


$aContas = array();

$numrows = pg_numrows($resultcontasmovimento);
for($linha=0;$linha<$numrows;$linha++){

	db_fieldsmemory($resultcontasmovimento,$linha);
	if (($somente_contas_com_movimento=='s') && $debitado == 0 && $creditado == 0) {
		continue;
	}

	// escreve a conta e a descrição + saldo inicial
	$aContas[$k13_reduz]->k13_reduz = $k13_reduz;
	$aContas[$k13_reduz]->k13_descr = $k13_descr;
    $aContas[$k13_reduz]->c63_conta = $c63_conta.'-'.$c63_dvconta;
    $aContas[$k13_reduz]->c63_agencia = $c63_agencia.'-'.$c63_dvagencia;
	$aContas[$k13_reduz]->k13_dtimplantacao = $k13_dtimplantacao;

	// para contas bancárias, saldo positivo = debito, negativos indica debito
	if ($anterior > 0 ){
		$aContas[$k13_reduz]->debito 	= $anterior;
		$aContas[$k13_reduz]->credito = 0;
	} else {
		$aContas[$k13_reduz]->credito = $anterior;
		$aContas[$k13_reduz]->debito	= 0;
	}
	// ****************** ANALITICO e sintetico****************


	// *********************  EMPENHO ***************************
	$sqlempenho = "
  /* empenhos- despesa orçamentaria */
  /*   EMPENHO */

  select distinct
        corrente.k12_id as caixa,
        corrente.k12_data as data,
		0 as valor_debito,
		corrente.k12_valor as valor_credito,
	    'Pgto. Emp. '||e60_codemp||'/'||e60_anousu::text||' OP: '||coremp.k12_codord::text as tipo_movimentacao,
        e60_codemp||'/'||e60_anousu::text as codigo,
        'empenho'::text as tipo,
        0 as receita,
		null::text as receita_descr,
		corhist.k12_histcor::text as historico,
		case
            when e86_cheque is not null and e86_cheque <> '0' then 'CHE '||e86_cheque::text
            when coremp.k12_cheque = 0 then e81_numdoc::text
            else 'CHE '||coremp.k12_cheque::text
            end as numdoc,
		    null::text as contrapartida,
		    coremp.k12_codord as ordem,
		    z01_nome::text as credor,
		    z01_numcgm::text as numcgm,
		    k12_codautent,
		    k105_corgrupotipo,
		    '' as codret,
			  '' as dtretorno,
			  '' as arqret,
				'' as dtarquivo,
			 0 as k153_slipoperacaotipo
 from corrente
      inner join coremp on coremp.k12_id = corrente.k12_id and coremp.k12_data   = corrente.k12_data
                                                           and coremp.k12_autent = corrente.k12_autent
      inner join empempenho on e60_numemp = coremp.k12_empen
      inner join cgm on z01_numcgm = e60_numcgm
	  left join empord on e82_codord = coremp.k12_codord
	  left join empageconfche on e91_codcheque = e82_codmov
	    left join corhist on  corhist.k12_id     = corrente.k12_id    and corhist.k12_data   = corrente.k12_data  and
					                                                              corhist.k12_autent = corrente.k12_autent
      left join corautent	on corautent.k12_id     = corrente.k12_id   and corautent.k12_data   = corrente.k12_data
							                                                        and corautent.k12_autent = corrente.k12_autent
      left join corgrupocorrente on corrente.k12_data = k105_data and corrente.k12_id = k105_id and corrente.k12_autent = k105_autent
	  left join corempagemov 	on corempagemov.k12_data = coremp.k12_data and corempagemov.k12_id = coremp.k12_id and corempagemov.k12_autent = coremp.k12_autent
	  left join empagemov       on k12_codmov  = e81_codmov
      left join empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
 where corrente.k12_conta = $k13_reduz  and corrente.k12_data between '".$data_inicial."'
                                        and '".$data_final."'
                                        and corrente.k12_instit = ".db_getsession("DB_instit")."


";

	$sqlanalitico = "
  /* RECIBO */

 select
       caixa,
		   data,
		   valor_debito,
		   valor_credito,
		   tipo_movimentacao,
		   codigo,
		   tipo,
		   receita,
       receita_descr,
		   historico,
		   numdoc,
		   contrapartida,
       ordem,
		   credor,
		   ''::text as numcgm,
		   k12_codautent,
		   0 as k105_corgrupotipo,
		   '' as codret,
			 '' as dtretorno,
			 '' as arqret,
			 '' as dtarquivo,
			 0 as k153_slipoperacaotipo
	     from (
      	     select
	                 caixa,
		               data,
		               sum(valor_debito) as valor_debito,
		               valor_credito,
		               tipo_movimentacao::text,
		               codigo::text,
		               tipo::text,
		               receita,
                   receita_descr::text,
		               historico::text,
		               numdoc::text,
		               null::text as contrapartida,
		               ordem,
		               credor::text,
		               k12_codautent
	          from (
                  select
	                      corrente.k12_id as caixa,
                        corrente.k12_data as data,
		                    cornump.k12_valor as valor_debito,
		                    0 as valor_credito,
	                      ('Recibo '||k12_numpre||'-'||k12_numpar)::text
	                       as tipo_movimentacao,
			                  k12_numpre||'-'||k12_numpar::text as codigo,
                        'recibo'::text as tipo,
		                    cornump.k12_receit as receita,
			                  tabrec.k02_drecei::text as receita_descr,
			                  (coalesce(corhist.k12_histcor,'.'))::text as historico,
			                  null::text as numdoc,
			                  null::text as contrapartida,
			                  e20_pagordem as ordem,
		                   (select z01_nome::text from arrepaga inner join cgm on z01_numcgm = k00_numcgm where k00_numpre=cornump.k12_numpre limit 1 ) as credor,			  k12_codautent
                   from corrente
                       inner join cornump on cornump.k12_id = corrente.k12_id and cornump.k12_data = corrente.k12_data
                                                                                    and cornump.k12_autent = corrente.k12_autent
                       left join corgrupocorrente on corrente.k12_id    = k105_id
                                         and corrente.k12_autent = k105_autent and corrente.k12_data = k105_data
                       left join retencaocorgrupocorrente     on e47_corgrupocorrente  = k105_sequencial
                       left join retencaoreceitas             on e47_retencaoreceita   = e23_sequencial
                       left join retencaopagordem             on e23_retencaopagordem  = e20_sequencial
                       inner join tabrec on tabrec.k02_codigo   = cornump.k12_receit
		                   left join corhist on  corhist.k12_id     = corrente.k12_id and corhist.k12_data     = corrente.k12_data
                                                                                  and corhist.k12_autent   = corrente.k12_autent
				               left join corautent	on corautent.k12_id = corrente.k12_id and corautent.k12_data   = corrente.k12_data
							                                                                    and corautent.k12_autent = corrente.k12_autent
                       left  join corcla on corcla.k12_id = corrente.k12_id and corcla.k12_data   = corrente.k12_data
                                                                            and corcla.k12_autent = corrente.k12_autent
                       left join corplacaixa on corrente.k12_id  = k82_id and corrente.k12_data  = k82_data
                                                                          and corrente.k12_autent= k82_autent
	                 where corrente.k12_conta = $k13_reduz
                     and (corrente.k12_data between '".$data_inicial."'
                                        and '".$data_final."')
		                 and corrente.k12_instit = ".db_getsession("DB_instit")."
                     and k12_codcla is null
                     and k82_seqpla is null

              ) as x
		group by
		       caixa,
			   data,
			   valor_credito,
			   tipo_movimentacao,
			   codigo,
			   tipo,
			   receita,
               receita_descr,
			   historico,
			   numdoc,
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
      		   valor_debito,
		         valor_credito,
		         tipo_movimentacao,
		         codigo,
		         tipo,
		         receita,
		         receita_descr,
		         historico,
		         numdoc,
             contrapartida,
		         ordem,
		         credor,
		         ''::text as numcgm,
		         k12_codautent,
			 0 as k105_corgrupotipo,
		         '' as codret,
						 '' as dtretorno,
						 '' as arqret,
						 '' as dtarquivo,
			0 as k153_slipoperacaotipo
	     from (
	           select
	                 caixa,
		               data,
		               sum(valor_debito) as valor_debito,
		               valor_credito,
		               tipo_movimentacao::text,
		               codigo::text,
		               tipo::text,
		               receita,
		               receita_descr::text,
		               historico::text,
		               numdoc::text,
		               null::text as contrapartida,
		               ordem,
		               credor::text	,
                    ". (($imprime_analitico=="a")?"k12_codautent":"null::text as k12_codautent") . "

	           from (
                  select
	                       corrente.k12_id as caixa,
                         corrente.k12_data as data,
                         case when k12_valor > 0 then k12_valor else 0 end as valor_debito,
                         case when k12_valor < 0 then k12_valor else 0 end as valor_credito,
	                       ('planilha :'||k81_codpla)::text as tipo_movimentacao,
			                   k81_codpla::text as codigo,
           	             'planilha'::text as tipo,
		   	                 k81_receita as receita,
                         tabrec.k02_drecei as receita_descr,
		                     (coalesce(placaixarec.k81_obs,'.'))::text as historico,
		                     null::text as numdoc,
			                   null::text as contrapartida,
		                     0 as ordem,
			                   null::text as credor ,
	                       k12_codautent
                  from corrente
			                 	inner join corplacaixa on k12_id = k82_id  and k12_data   = k82_data
                                                                   and k12_autent = k82_autent
                				inner join placaixarec on k81_seqpla = k82_seqpla
			                  inner join tabrec on tabrec.k02_codigo = k81_receita
		                     /*
		                      left  join arrenumcgm on k00_numpre = cornump.k12_numpre
                          left join cgm on k00_numcgm = z01_numcgm
                        */
	                     left join corhist on corhist.k12_id = corrente.k12_id     and corhist.k12_data  = corrente.k12_data
                                                                                 and  corhist.k12_autent = corrente.k12_autent
			                 inner join corautent on corautent.k12_id = corrente.k12_id and corautent.k12_data   = corrente.k12_data
                                                                                 and corautent.k12_autent = corrente.k12_autent
           			where corrente.k12_conta = $k13_reduz  and (corrente.k12_data between '".$data_inicial."'
                                        and '".$data_final."')
		                                                   and corrente.k12_instit = ".db_getsession("DB_instit")."

              ) as x
		group by
		       caixa,
			     data,
			     valor_credito,
			     tipo_movimentacao,
			     codigo,
			     tipo,
			     receita,
			     receita_descr,
			     historico,
           numdoc,
	         contrapartida,
			     ordem,
			     credor,
			     k12_codautent
             ) as xx

/*  BAIXA DE BANCO */

union all

      select
             caixa,
		         data,
		         valor_debito,
		         valor_credito,
		         tipo_movimentacao,
		         codigo,
		         tipo,
		         receita,
             receita_descr,
		         historico,
		         numdoc,
		         contrapartida,
             ordem,
		         credor,
		         ''::text as numcgm,
		         k12_codautent,
			 0 as k105_corgrupotipo,
		         codret::text,
			       dtretorno::text,
			       arqret::text,
			     dtarquivo::text,
			 0 as k153_slipoperacaotipo
     from (
	         select
	                caixa,
      		        data,
		              sum(valor_debito) as valor_debito,
		              valor_credito,
		              tipo_movimentacao::text,
		              codigo::text,
		              tipo::text,
		              receita,
                  receita_descr::text,
		              historico::text,
		              numdoc::text,
		              null::text as contrapartida,
		              ordem,
		              credor::text,
		              k12_codautent,
		              codret,
			            dtretorno,
			            arqret,
			            dtarquivo
	          from (
                  select
	                      corrente.k12_id as caixa,
                        corrente.k12_data as data,
		                    cornump.k12_valor as valor_debito,
		                    0 as valor_credito,
	                      ('Baixa da banco ')::text as tipo_movimentacao,
		                     discla.codret as codigo,
                        'baixa'::text as tipo,
		                    cornump.k12_receit as receita,
		                    tabrec.k02_drecei::text as receita_descr,
		                    (coalesce(corhist.k12_histcor,'.'))::text as historico,
		                    null::text as numdoc,
		                    null::text as contrapartida,
			                  0 as ordem,
			                  disarq.codret as codret,
			                  disarq.dtretorno as dtretorno,
			                  disarq.arqret as arqret,
			                  disarq.dtarquivo as dtarquivo,
		                    (select z01_nome::text from recibopaga inner join cgm on z01_numcgm = k00_numcgm where k00_numpre=cornump.k12_numpre limit 1 ) as credor,k12_codautent
                 from corrente
                      inner join cornump on cornump.k12_id = corrente.k12_id and cornump.k12_data   = corrente.k12_data
                                                                             and cornump.k12_autent = corrente.k12_autent
                      inner join tabrec on tabrec.k02_codigo = cornump.k12_receit

	                 	   /*
                         left  join arrenumcgm on k00_numpre = cornump.k12_numpre
                         left join cgm on k00_numcgm = z01_numcgm
                      */

	                   left join corhist   on corhist.k12_id   = corrente.k12_id  and	corhist.k12_data     = corrente.k12_data
                                                                                and corhist.k12_autent   = corrente.k12_autent
                  	 left join corautent on corautent.k12_id = corrente.k12_id
                                        and corautent.k12_data   = corrente.k12_data
                                        and corautent.k12_autent = corrente.k12_autent

		                 inner join corcla    on corcla.k12_id    = corrente.k12_id  and corcla.k12_data      = corrente.k12_data
                                                                                and corcla.k12_autent    = corrente.k12_autent
                     inner join discla on discla.codcla = corcla.k12_codcla and discla.instit = ".db_getsession("DB_instit")."
           					 inner join disarq on disarq.codret = discla.codret and disarq.instit = discla.instit
                     left join corplacaixa on corplacaixa.k82_id     = corrente.k12_id
                                          and corplacaixa.k82_data   = corrente.k12_data
                                          and corplacaixa.k82_autent = corrente.k12_autent
			          where corrente.k12_conta = $k13_reduz
                  and (corrente.k12_data between '".$data_inicial."'
                                        and '".$data_final."')
                  and corrente.k12_instit = ".db_getsession("DB_instit")."

                  and corplacaixa.k82_id is null
                  and corplacaixa.k82_data is null
                  and corplacaixa.k82_autent is null

              ) as x
		group by
		           caixa,
		      	   data,
			         valor_credito,
			         tipo_movimentacao,
			         codigo,
			         tipo,
			         receita,
               receita_descr,
			         historico,
			         numdoc,
			         contrapartida,
			         ordem,
			         credor,
               k12_codautent,
               codret,
			         dtretorno,
			         arqret,
			         dtarquivo
             ) as xx

";
	//  SINTETICO
	$sqlsintetico = "
   union all
  select caixa,
       data,
       valor_debito,
       valor_credito,
       null::text as tipo_movimentacao,
       codigo,
       tipo,
       0 as receita,
       null::text as receita_descr,
       historico,
       numdoc,
       contrapartida,
       ordem,
       credor,
       ''::text as numcgm,
       k12_codautent,
       0 as k105_corgrupotipo,
       '' as codret,
			 '' as dtretorno,
			 '' as arqret,
			 '' as dtarquivo,
	    0 as k153_slipoperacaotipo
from (
select caixa,
       data,
       sum(valor_debito) as valor_debito,
       sum(valor_credito) as valor_credito,
       codigo,
       tipo,
       historico,
       numdoc,
       contrapartida,
       ordem,
       credor,
       k12_codautent
  from ($sqlanalitico) as agrupado
	group by
		caixa,
		data,
	    codigo,
		tipo,
		historico,
		numdoc,
		contrapartida,
		ordem,
		credor,
		k12_codautent
	) as autent_recibo
";
	/* SLIP DEBITO */
	$sqlslip="

 	     union all
	     /* transferencias a debito - entradas*/
	     select
	           corrente.k12_id as caixa,
	           corlanc.k12_data as data,
		   corrente.k12_valor as valor_debito,
		   0 as valor_credito,
		   'Slip '||k12_codigo::text as tipo_movimentacao,
		   k12_codigo::text as codigo,
		   'slip'::text as tipo,
		   0 as receita,
           null::text as receita_descr,
		   slip.k17_texto::text as historico,
		   case when e91_cheque is null then e81_numdoc::text else 'CHE '||e91_cheque::text end as numdoc,
           k17_debito||' - '||c60_descr as contrapartida,
		   0 as ordem,
		   z01_nome::text as credor,
		   z01_numcgm::text as numcgm,
       k12_codautent,
       0 as k105_corgrupotipo,
       '' as codret,
			 '' as dtretorno,
			 '' as arqret,
			 '' as dtarquivo,
			 sliptipooperacaovinculo.k153_slipoperacaotipo
	     from corlanc
	           inner join corrente on corrente.k12_id  = corlanc.k12_id    and
		                          corrente.k12_data  = corlanc.k12_data  and
					 									 corrente.k12_autent = corlanc.k12_autent

           inner join slip on slip.k17_codigo = corlanc.k12_codigo
		   inner join conplanoreduz on c61_reduz  = slip.k17_credito
                                       and c61_anousu = ".db_getsession('DB_anousu')."
               inner join conplano      on c60_codcon = c61_codcon
                                       and c60_anousu = c61_anousu

		   left join slipnum on slipnum.k17_codigo = slip.k17_codigo
		   left join cgm on slipnum.k17_numcgm = z01_numcgm
           left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip=slip.k17_codigo

		   left join corconf on corconf.k12_id = corlanc.k12_id 				and
		                        corconf.k12_data = corlanc.k12_data 		and
														corconf.k12_autent = corlanc.k12_autent and
														corconf.k12_ativo is true
                   left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov and
                   													  corconf.k12_ativo is true
                   													  and empageconfche.e91_ativo is true
                   left join corhist on   corhist.k12_id     = corrente.k12_id    and
		                          corhist.k12_data   = corrente.k12_data  and
					  corhist.k12_autent = corrente.k12_autent
					left join corautent	on corautent.k12_id     = corrente.k12_id
									and corautent.k12_data   = corrente.k12_data
									and corautent.k12_autent = corrente.k12_autent
					left join corempagemov on corempagemov.k12_data = corautent.k12_data
										   and corempagemov.k12_id = corautent.k12_id
										   and corempagemov.k12_autent = corautent.k12_autent
					left join empagemov on corempagemov.k12_codmov = e81_codmov
			     where corlanc.k12_conta = $k13_reduz  and
	           corlanc.k12_data between '".$data_inicial."'
                                        and '".$data_final."'

	     union all
/* SLIP CREDITO */

	     select
	           corrente.k12_id as caixa,
	           corlanc.k12_data as data,
		   0                  as valor_debito,
		   corrente.k12_valor as valor_credito,
		   'Slip '||k12_codigo::text as tipo_movimentacao,
		   k12_codigo::text as codigo,
		   'slip'::text as tipo,
		   0 as receita,
		   null::text as receita_descr,
		   slip.k17_texto::text as historico,
		   case when e91_cheque is null then e81_numdoc::text else 'CHE '||e91_cheque::text end as numdoc,
		   k17_debito||' - '||c60_descr as contrapartida,
		   0 as ordem,
		   z01_nome::text as credor,
		   z01_numcgm::text as numcgm,
       k12_codautent,
       0 as k105_corgrupotipo,
       '' as codret,
			 '' as dtretorno,
			 '' as arqret,
			 '' as dtarquivo,
			 sliptipooperacaovinculo.k153_slipoperacaotipo
	     from corrente
	           inner join corlanc on corrente.k12_id     = corlanc.k12_id
                                 and corrente.k12_data   = corlanc.k12_data
                                 and corrente.k12_autent = corlanc.k12_autent
		       inner join slip on        slip.k17_codigo = corlanc.k12_codigo
               inner join conplanoreduz    on c61_reduz  = slip.k17_debito
                                          and c61_anousu = ".db_getsession('DB_anousu')."
               inner join conplano         on c60_codcon = c61_codcon
                                          and c60_anousu = c61_anousu
		       left join slipnum on slipnum.k17_codigo = slip.k17_codigo
		       left join cgm on slipnum.k17_numcgm = z01_numcgm
		       left join corconf on corconf.k12_id = corlanc.k12_id
                                and corconf.k12_data = corlanc.k12_data
                                and	corconf.k12_autent = corlanc.k12_autent
                                and corconf.k12_ativo is true
               left join sliptipooperacaovinculo on sliptipooperacaovinculo.k153_slip=slip.k17_codigo
               left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
               												and	corconf.k12_ativo is true
               												and empageconfche.e91_ativo is true
	           left join corhist on corhist.k12_id     = corrente.k12_id
                                and corhist.k12_data   = corrente.k12_data
                                and corhist.k12_autent = corrente.k12_autent
              left join corautent	on corautent.k12_id     = corrente.k12_id
									and corautent.k12_data   = corrente.k12_data
									and corautent.k12_autent = corrente.k12_autent
			  left join empageslip  on empageslip.e89_codigo = slip.k17_codigo
    		  left join empagemov   on e89_codmov=e81_codmov
	     where corrente.k12_conta = $k13_reduz  and
	           corrente.k12_data between '".$data_inicial."'
                                        and '".$data_final."'

	     order by data, caixa, k12_codautent, codigo
";

	//$imprime_analitico = 'a';

	if($imprime_analitico == "a"){
		$sqltotal = $sqlempenho." union all ".$sqlanalitico.$sqlslip;
	}else{
		$sqltotal = $sqlempenho.$sqlsintetico.$sqlslip;
	}
	$sqltotal = $sqlempenho." union all ".$sqlanalitico.$sqlslip;
	// die($sqltotal);
	$resmovimentacao = db_query($sqltotal);
	// echo $sqltotal;
	// db_criatabela($resmovimentacao);exit;
	$quebra_data = '';
	$saldo_dia_final   = $anterior;

	$aContas[$k13_reduz]->data = array();
	$iInd = -1;
	$saldo_dia_debito = 0;
	$saldo_dia_credito = 0;
	//$lPrimeiroDaConta = true;
	if (pg_numrows($resmovimentacao)>0){
		for  ($i=0;$i < pg_numrows($resmovimentacao);$i++){

			db_fieldsmemory($resmovimentacao,$i);

			//quando agrupar os pagamentos o sistema vai retirar as retenções do relatorio.
            if($pagempenhos==3){
				if (  $ordem > 0 and ($k105_corgrupotipo == 5 or $k105_corgrupotipo == 0 or $k105_corgrupotipo == 2)  ) {
					continue;
				}
			}
			if (isset($considerar_retencoes) && $considerar_retencoes == "n") {
				if ( $ordem > 0 and ( $k105_corgrupotipo == 0 or $k105_corgrupotipo == 2 ) ) {
					continue;
				}
			}

			// controla quebra de saldo por dia
			if ($quebra_data != $data && $quebra_data != '' && $totalizador_diario=='s'){
				$lPrimeiroDaConta = false;
				$aContas[$k13_reduz]->data[$iInd]->saldo_dia_debito 	= $saldo_dia_debito;
				$aContas[$k13_reduz]->data[$iInd]->saldo_dia_credito 	= $saldo_dia_credito;
				// calcula saldo a debito ou credito
				if ($saldo_dia_debito < 0){
					$saldo_dia_final -= abs($saldo_dia_debito);
					$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
				} else {
					$saldo_dia_final += $saldo_dia_debito;
					$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
				}

				if ($saldo_dia_credito < 0){
					$saldo_dia_final += abs($saldo_dia_credito);
					$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
				} else {
					$saldo_dia_final -= $saldo_dia_credito;
					$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
				}
				$saldo_dia_debito  = 0;
				$saldo_dia_credito = 0;

			}

			if($quebra_data != $data){
				$aContas[$k13_reduz]->data[++$iInd]->data = $data;
				$aContas[$k13_reduz]->data[$iInd]->movimentacoes = array();
			}

			$oMovimentacao = new stdClass();
			$oMovimentacao->caixa 				= $caixa;
			$oMovimentacao->valor_debito 	= $valor_debito;
			$oMovimentacao->valor_credito	= $valor_credito;
			$oMovimentacao->receita				= $receita;
			$oMovimentacao->k12_codautent = $k12_codautent;
			$oMovimentacao->codigo 				= $codigo;
			$oMovimentacao->credor 				= $credor;
			$oMovimentacao->codigocredor  = $numcgm;
			$oMovimentacao->codret  			= $codret;
			$oMovimentacao->dtretorno  		= $dtretorno != "" ? db_formatar($dtretorno,'d') : "";
			$oMovimentacao->arqret  			= $arqret;
			$oMovimentacao->dtarquivo  		= $dtarquivo != "" ? db_formatar($dtarquivo,'d') : "";//$dtarquivo;

			$oMovimentacao->tipo	 			= $tipo;
			if($tipo=='planilha'){
				$oMovimentacao->planilha	= $codigo;
			}else{
				$oMovimentacao->planilha	= "";
			}
			if($tipo=='baixa'){
				$oMovimentacao->k12_codcla	= $codigo;
			}else{
				$oMovimentacao->k12_codcla	= "";
			}
			//empenho
			if($tipo=='empenho'){
				$oMovimentacao->empenho		= $codigo;
				$oMovimentacao->ordem 		= $ordem;
			}else{
				$oMovimentacao->empenho		= "";
				$oMovimentacao->ordem 		= $ordem;
			}
			$oMovimentacao->numdoc 			= $numdoc;

			if($tipo=='slip'){
				//$pdf->Cell(15,$alt,$codigo,0,0,"C",0);
				$oMovimentacao->slip 		= $codigo;
			}else{
				//$pdf->Cell(15,$alt,"",0,0,"C",0);
				$oMovimentacao->slip 		= "";
			}

			// DEBITO E CREDITO

			if ($valor_debito ==0 &&  $valor_credito != 0  ){
				//$pdf->Cell(20,$alt,'','L',0,"R",0);
				$oMovimentacao->valor_debito = "";
				//Modificação feita para acertar a forma quando é mostrada os valores relativos as planilha de dedução
				if ($tipo == "planilha") {
					$valor_credito = $valor_credito*-1;
					$oMovimentacao->valor_credito = $valor_credito;
				} else {
					$valor_credito = $valor_credito;
					$oMovimentacao->valor_credito = $valor_credito;
				}

			} elseif ($valor_credito== 0 && $valor_debito != 0 ){
				$oMovimentacao->valor_debito = $valor_debito;
				$oMovimentacao->valor_credito = $valor_credito;
			}
			else {
				$oMovimentacao->valor_debito = $valor_debito;
				$oMovimentacao->valor_credito = $valor_credito;
			}

			if ($receita > 0){
				// selecina reduzido da receita no plano de contas

				$sql = "select c61_reduz
		    						from taborc
		      					inner join orcreceita on o70_codrec=taborc.k02_codrec and o70_anousu=k02_anousu and o70_instit=".db_getsession("DB_instit")."
		      					inner join conplanoreduz on c61_codcon=o70_codfon and c61_instit=o70_instit and c61_anousu=o70_anousu
		    					where  k02_codigo = $receita
		       					 and k02_anousu = ".db_getsession("DB_anousu")."
		    		union
	            	select c61_reduz
		    						from tabplan
		        				inner join conplanoreduz on c61_reduz=k02_reduz and c61_instit=".db_getsession("DB_instit")." and c61_anousu=k02_anousu
		    					where k02_codigo = $receita
		      					and k02_anousu = ".db_getsession("DB_anousu")."
	               	";
				//die ($sql);
				$res_rec = db_query($sql);
				$c61_reduz ="";
				if (pg_numrows($res_rec)>0){
					db_fieldsmemory($res_rec,0);
				}

			}
			//$x1= $pdf->GetX ();

			$oMovimentacao->contrapartida = "";

			if($tipo == 'recibo'  || $tipo == 'planilha' || $tipo == 'baixa'){

				//if($imprime_analitico=="a"){
				if($receita > 0){
					$oMovimentacao->contrapartida = $receita." ";
					if($c61_reduz != ""){
						$oMovimentacao->contrapartida .= "(".$c61_reduz.") - ";
					}
					$oMovimentacao->contrapartida .= $receita_descr;
				}
				//}

			}
			if($tipo == 'slip'){
				$oMovimentacao->contrapartida = $contrapartida;
			}
			$oMovimentacao->credor = $credor;

			$oMovimentacao->historico = $historico;

			if($valor_debito != 0 || $valor_credito != 0){
			  // soma acumuladores diarios
			  $saldo_dia_debito  += $valor_debito;
			  $saldo_dia_credito += $valor_credito;

			  $quebra_data = $data;

			  $aContas[$k13_reduz]->data[$iInd]->movimentacoes[] = $oMovimentacao;
			}


		}
	}


	if ($totalizador_diario=='s'){

		// calcula saldo a debito ou credito
		$aContas[$k13_reduz]->data[$iInd]->saldo_dia_debito 	= $saldo_dia_debito;
		$aContas[$k13_reduz]->data[$iInd]->saldo_dia_credito 	= $saldo_dia_credito;
		// calcula saldo a debito ou credito
		if ($saldo_dia_debito < 0){
			$saldo_dia_final -= abs($saldo_dia_debito);
			$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
		} else {
			$saldo_dia_final += $saldo_dia_debito;
			$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
		}
		if ($saldo_dia_credito < 0){
			$saldo_dia_final += abs($saldo_dia_credito);
			$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
		} else {
			$saldo_dia_final -= $saldo_dia_credito;
			$aContas[$k13_reduz]->data[$iInd]->saldo_dia_final = $saldo_dia_final;
		}

	}
	$aContas[$k13_reduz]->debitado  = $debitado;
	$aContas[$k13_reduz]->creditado = $creditado;
	$aContas[$k13_reduz]->atual = $atual;
}

$aMovimentacao = array();
$aContasNovas	 = array();
foreach ($aContas as $key2=>$oConta){
	$aContasNovas[$key2] = $oConta;
	foreach ($oConta->data as $key1=>$oData){
		//$aContasNovas[$oConta->k13_reduz]->data[$key1] = $oData;
		foreach ($oData->movimentacoes as $oMovimento){
			//se por baixa bancária
			if($receitaspor== 2 && $oMovimento->tipo == "Baixa"){
				$controle = false;
				foreach ($aMovimentacao as $key=>$oValor) {
					//echo "<br>$oValor->receita -- $oMovimento->receita";
					if($oValor->tipo == $oMovimento->tipo && $oValor->codigo == $oMovimento->codigo && $controle == false){
						$controle = true;
						$chave = $key;
					}
				}
				if($controle){
					//	echo "<br>aqui1";
					//soma senao inseri no array
					$aMovimentacao[$chave]->valor_debito 		+= $oMovimento->valor_debito;
					$aMovimentacao[$chave]->valor_credito 	+= $oMovimento->valor_credito;
					$aMovimentacao[$chave]->caixa						= "";
					//$aMovimentacao[$chave]->k12_codautent		= "";
					//$aMovimentacao[$chave]->tipo						= "";
					$aMovimentacao[$chave]->planilha				= "";
					$aMovimentacao[$chave]->empenho					= "";
					$aMovimentacao[$chave]->ordem						= "";
					$aMovimentacao[$chave]->numdoc					= "";
					$aMovimentacao[$chave]->slip						= "";
					$aMovimentacao[$chave]->contrapartida		= "Baixa Bancária ref Arquivo ";
					$aMovimentacao[$chave]->contrapartida  .= $oMovimento->arqret.", do dia ";
					$aMovimentacao[$chave]->contrapartida  .= $oMovimento->dtarquivo.", retorno ";
					$aMovimentacao[$chave]->contrapartida  .= $oMovimento->codret." de ";
					$aMovimentacao[$chave]->contrapartida  .= $oMovimento->dtretorno;

					$aMovimentacao[$chave]->credor					= "";
					$aMovimentacao[$chave]->historico				= "";
					$aMovimentacao[$chave]->agrupado				= 'Baixa';
				}else{
					$aMovimentacao[] = $oMovimento;
				}
			}else if($agrupapor == 2 && $oMovimento->receita != "0" && $oMovimento->tipo != "Baixa"){
 				// agrupa por receita
				$controle = false;
				//$chave = $oMovimento->codigo;
				if($oMovimento->tipo == "slip"){
					$aMovimentacao[] = $oMovimento;
				}else{
					foreach ($aMovimentacao as $key=>$oValor) {
						//echo "<br>$oValor->receita -- $oMovimento->receita";
						if($oValor->receita == $oMovimento->receita && $controle == false){
							$controle = true;
							$chave = $key;
						}
					}
					if($controle){
						//echo "<br>aqui1";
						//soma senao inseri no array
						$aMovimentacao[$chave]->valor_debito 		+= $oMovimento->valor_debito;
						$aMovimentacao[$chave]->valor_credito 	+= $oMovimento->valor_credito;
						$aMovimentacao[$chave]->caixa						= "";
						$aMovimentacao[$chave]->k123_codautent	= "";
						$aMovimentacao[$chave]->tipo						= "";
						$aMovimentacao[$chave]->planilha				= "";
						$aMovimentacao[$chave]->empenho					= "";
						$aMovimentacao[$chave]->ordem						= "";
						$aMovimentacao[$chave]->numdoc					= "";
						$aMovimentacao[$chave]->slip						= "";
						$aMovimentacao[$chave]->contrapartida		= $oMovimento->contrapartida;
						$aMovimentacao[$chave]->credor					= "";
						$aMovimentacao[$chave]->historico				= "";
						$aMovimentacao[$chave]->agrupado				= 'receita';
					}else{
						$aMovimentacao[] = $oMovimento;
					}
				}
			}else if($agrupapor == 3 && $oMovimento->tipo == "empenho"){
				$controle = false;
				foreach ($aMovimentacao as $key=>$oValor) {
					//echo "<br>$oValor->receita -- $oMovimento->receita";
					if($oValor->receita == $oMovimento->receita && $oValor->codigo == $oMovimento->codigo &&
						 $oValor->tipo == $oMovimento->tipo &&	$controle == false)
					{
						$controle = true;
						$chave = $key;
					}
				}
				if($controle){
					//echo "<br>aqui1";
					//soma senao inseri no array
					$aMovimentacao[$chave]->valor_debito 		+= $oMovimento->valor_debito;
					$aMovimentacao[$chave]->valor_credito 	+= $oMovimento->valor_credito;
					$aMovimentacao[$chave]->caixa						= "";
					$aMovimentacao[$chave]->k123_codautent	= "";
					//$aMovimentacao[$chave]->tipo						= "";
					$aMovimentacao[$chave]->planilha				= "";
					//$aMovimentacao[$chave]->empenho					= "";
					$aMovimentacao[$chave]->ordem						= "";
					$aMovimentacao[$chave]->numdoc					= "";
					$aMovimentacao[$chave]->slip						= "";
					$aMovimentacao[$chave]->contrapartida		= $oMovimento->credor;
					$aMovimentacao[$chave]->credor					= "";
					$aMovimentacao[$chave]->historico				= "";
					$aMovimentacao[$chave]->agrupado				= 'empenho';
				}else{
					$oMovimento->contrapartida = $oMovimento->credor;
					$aMovimentacao[] = $oMovimento;
				}
			}else if($agrupapor == 2 && $pagempenhos==2){
				$controle = false;
				if($oMovimento->tipo != "empenho"){
					$aMovimentacao[] = $oMovimento;
				}else{
					foreach ($aMovimentacao as $key=>$oValor) {
						if($oValor->ordem == $oMovimento->ordem && $controle == false && $oValor->tipo == "empenho")
						{
							$controle = true;
							$chave = $key;
						}
					}
					if($controle){
						$aMovimentacao[$chave]->valor_debito 		+= $oMovimento->valor_debito;
						$aMovimentacao[$chave]->valor_credito 	+= $oMovimento->valor_credito;
						if($oMovimento->tipo == "empenho" && $oMovimento->empenho != ""){
							$oMovimento->contrapartida = $oMovimento->codigocredor." - ".$oMovimento->credor;
							$aMovimentacao[$chave]->contrapartida = $oMovimento->contrapartida;
						}
					}else{
						if($oMovimento->tipo == "empenho" && $oMovimento->empenho != ""){
							$oMovimento->contrapartida = $oMovimento->codigocredor." - ".$oMovimento->credor;
						}
						if($oMovimento->tipo == "empenho" || $oMovimento->tipo == "slip"){
							$oMovimento->codigo = "";
						}
						$aMovimentacao[] = $oMovimento;
					}
				}
			}else{
				if($pagempenhos == 2 && $imprime_analitico == "s"){
					//								echo "<pre>";
					//								echo var_dump($oMovimento);
					//								echo "<pre>";
					if($oMovimento->tipo !="empenho"){
						$aMovimentacao[] = $oMovimento;
					}else {
						$controle = false;
						foreach ($aMovimentacao as $key=>$oValor) {
							//echo "<br>$oValor->receita -- $oMovimento->receita";
							if($oValor->ordem == $oMovimento->ordem &&
								 $oValor->tipo == $oMovimento->tipo &&	$controle == false && $oValor->tipo == "empenho")
							{
								$controle = true;
								$chave = $key;
							}
						}
						if($controle){
							//echo "<br>aqui1";
							//soma senao inseri no array
							$aMovimentacao[$chave]->valor_debito 		+= $oMovimento->valor_debito;
							$aMovimentacao[$chave]->valor_credito 	+= $oMovimento->valor_credito;
							$aMovimentacao[$chave]->caixa						= "";
							$aMovimentacao[$chave]->k123_codautent	= "";
							//$aMovimentacao[$chave]->tipo						= "";
							$aMovimentacao[$chave]->planilha				= "";
							//$aMovimentacao[$chave]->empenho					= "";
							//$aMovimentacao[$chave]->ordem						= "";
							$aMovimentacao[$chave]->numdoc					= "";
							$aMovimentacao[$chave]->slip						= "";
							$aMovimentacao[$chave]->contrapartida		= $oMovimento->credor;
							$aMovimentacao[$chave]->credor					= "";
							$aMovimentacao[$chave]->historico				= "";
							$aMovimentacao[$chave]->agrupado				= 'empenho';
						}else{
							//$oMovimento->contrapartida = $oMovimento->credor;
							if($oMovimento->tipo == "empenho" && $oMovimento->empenho != ""){
								$oMovimento->contrapartida = $oMovimento->codigocredor." - ".$oMovimento->credor;
							}
							if($oMovimento->tipo == "empenho" || $oMovimento->tipo == "slip"){
								$oMovimento->codigo = "";
								$aMovimentacao[] = $oMovimento;
							}
						}
					}
				}else {
					if($oMovimento->tipo == "empenho" && $oMovimento->empenho != ""){
						$oMovimento->contrapartida = $oMovimento->codigocredor." - ".$oMovimento->credor;
					}
					if($oMovimento->tipo == "empenho" || $oMovimento->tipo == "slip"){
						$oMovimento->codigo = "";
					}
					$aMovimentacao[] = $oMovimento;
				}
			}
		}
		$aContasNovas[$oConta->k13_reduz]->data[$key1]->movimentacoes = $aMovimentacao;
		$aMovimentacao = array();
	}
}
$aContas = $aContasNovas;

/*
echo "<pre>";
print_r($aContas);
echo "</pre>";
exit();
*/
/* DEFININDO A BUSCA */
$sqlPendencias = "SELECT
                *
            FROM
                conciliacaobancariapendencia
            LEFT JOIN cgm ON z01_numcgm = k173_numcgm
            LEFT JOIN conciliacaobancarialancamento ON k172_data = k173_data
                AND ((k172_numcgm IS NULL AND k173_numcgm IS NULL) OR (k172_numcgm = k173_numcgm))
                AND ((k172_coddoc is null AND k173_tipomovimento = '') OR (k172_coddoc::text = k173_tipomovimento))
                AND ((k173_documento is null AND k172_codigo is null) OR
                 (k172_codigo::text = k173_codigo || k173_documento::text ))
                AND k172_valor = k173_valor
                AND k172_mov = k173_mov
            WHERE
                ((k173_data BETWEEN '{$data_inicial}'
                AND '{$data_final}' AND k172_dataconciliacao IS NULL) OR (k172_dataconciliacao > '{$data_final}' AND  k173_data < '{$data_final}') OR (k172_dataconciliacao IS NULL AND k173_data < '{$data_inicial}'))
                AND k173_conta = {$k13_reduz} ";
$query = pg_query($sqlPendencias);

while ($row = pg_fetch_object($query)) {
	// Relátorio busca apenas não conciliados
	$pendencias[$row->k173_mov][] = $row;
}


$sql = query_lancamentos($k13_reduz, $data_inicial, $data_final);
$query = pg_query($sql);

while ($row = pg_fetch_object($query)) {
	$movimento = $row->valor_debito > 0 ? 1 : 2;
	$valor = $row->valor_debito > 0 ? $row->valor_debito : $row->valor_credito;
	if ($valor < 0)
		$movimento = $movimento == 1 ? 2 : 1;
	$data = new StdClass();
	$data->k173_data = $row->data;
	$data->k173_codigo = $row->ordem;
	$data->k173_documento = (!$row->cheque AND $row->cheque == "0") ? "" : $row->cheque;
	$data->k173_historico = descricaoHistorico($row->tipo, $row->codigo);
	$data->k173_valor = abs($valor);
	$lancamentos[$movimento][] = $data;
}

// Definindo a impressão
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetTextColor(0,0,0);
$pdf->setfillcolor(235);
$pdf->AutoPageBreak = false;
$pdf->AddPage("P");

$quebra_data = "";
$lQuebra_Historico = false;

foreach ($aContas as $oConta) {
	$lImprimeSaldo = true;
	if ($pdf->GetY() > $pdf->h - 25){
		$pdf->AddPage("P");
	}

	imprimeConta($pdf,$oConta,$lImprimeSaldo);
  imprimeSaldoExtratoBancario($pdf, 0, 100.00, 0);
	$lImprimeSaldo = false;
	imprimeCabecalho($pdf);

	// Entradas não consideradas pelo banco
	imprimeCabecalhoSub($pdf, "(2) ENTRADAS NÃO CONSIDERADAS PELO BANCO");
	$totalMovimentacao = 0;
	$totalMovimentacaoGeral = 0;
	foreach ($lancamentos[1] as $lancamento) {
		if ($pdf->GetY() > $pdf->h - 25){
			$pdf->AddPage("P");
			imprimeConta($pdf,$oConta,$lImprimeSaldo);
			imprimeCabecalho($pdf);
		}
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
		$pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
		$totalMovimentacao += $lancamento->k173_valor;
		$totalMovimentacaoGeral += $lancamento->k173_valor;
		$pdf->Ln(5);
	}
	imprimeTotalMovConta($pdf, 0, $totalMovimentacao, 2);
	$pdf->Ln(5);

	// Saídas não consideradas pela contabilidade
	imprimeCabecalhoSub($pdf, "(3) SAÍDAS NÃO CONSIDERADAS PELA CONTABILIDADE");
	$totalMovimentacao = 0;
	foreach ($pendencias[2] as $lancamento) {
		if ($pdf->GetY() > $pdf->h - 25){
			$pdf->AddPage("P");
			imprimeConta($pdf,$oConta,$lImprimeSaldo);
			imprimeCabecalho($pdf);
		}
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
		$pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
		$totalMovimentacao += $lancamento->k173_valor;
		$totalMovimentacaoGeral += $lancamento->k173_valor;
		$pdf->Ln(5);
	}
	imprimeTotalMovConta($pdf, 0, $totalMovimentacao, 3);
	$pdf->Ln(5);

	// Saídas não consideradas pelo banco
	imprimeCabecalhoSub($pdf, "(4) SAíDAS NÃO CONSIDERADAS PELO BANCO");
	$totalMovimentacao = 0;
	foreach ($lancamentos[2] as $lancamento) {
		if ($pdf->GetY() > $pdf->h - 25){
			$pdf->AddPage("P");
			imprimeConta($pdf,$oConta,$lImprimeSaldo);
			imprimeCabecalho($pdf);
		}
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
		$pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
		$totalMovimentacao += $lancamento->k173_valor;
		$totalMovimentacaoGeral -= $lancamento->k173_valor;
		$pdf->Ln(5);
	}
	imprimeTotalMovConta($pdf, 0, $totalMovimentacao, 4);
	$pdf->Ln(5);

	// Entradas não consideradas pela contabilidade
	imprimeCabecalhoSub($pdf, "(5) ENTRADAS NÃO CONSIDERADAS PELA CONTABILIDADE");
	$totalMovimentacao = 0;
	foreach ($pendencias[1] as $lancamento) {
		if ($pdf->GetY() > $pdf->h - 25){
			$pdf->AddPage("P");
			imprimeConta($pdf,$oConta,$lImprimeSaldo);
			imprimeCabecalho($pdf);
		}

		$pdf->Cell(25, 5, db_formatar($lancamento->k173_data, "d"), "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_codigo, "T", 0, "C", 0);
		$pdf->Cell(25, 5, $lancamento->k173_documento, "T", 0, "C", 0);
		$pdf->Cell(92, 5, $lancamento->k173_historico, "T", 0, "L", 0);
		$pdf->Cell(25, 5, db_formatar($lancamento->k173_valor, "f"), "T", 0, "R", 0);
		$totalMovimentacao += $lancamento->k173_valor;
		$totalMovimentacaoGeral -= $lancamento->k173_valor;
		$pdf->Ln(5);
	}
	imprimeTotalMovConta($pdf, 0, $totalMovimentacao, 5);
	imprimeTotalMovContabilidade($pdf, 0, $totalMovimentacaoGeral);
	$pdf->Ln(5);
}

if ($pdf->GetY() > $pdf->h - 25){
	$pdf->AddPage("P");
}
// die;
$pdf->Output();
exit();

// imprimeConta($pdf,$oConta->k13_reduz,$oConta->k13_descr,$oConta->k13_dtimplantacao,$oConta->debito,$oConta->credito,$lImprimeSaldo);
// function imprimeConta($pdf,$codigo,$descricao,$dtimplantacao,$debito,$credito,$lImprimeSaldo){
function imprimeConta($pdf,$oConta,$lImprimeSaldo){
	$pdf->SetFont('Arial','b',8);
	$pdf->Cell(12,5,"CONTA:"								,0,0,"L",0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(95,5,$oConta->k13_reduz." - ".$oConta->k13_descr,0,0,"L",0);
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(10,5,"Nº:"								,0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,5,$oConta->c63_conta,0,0,"L",0);
    $pdf->SetFont('Arial','b',8);
    $pdf->Cell(10,5,"AG:"								,0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(15,5,$oConta->c63_agencia,0,0,"L",0);
	$pdf->SetFont('Arial','b',8);
	/**
	if($lImprimeSaldo){
		$pdf->Cell(73,5,"SALDO ANTERIOR:"				,0,0,"R",0);
		$pdf->Cell(25,5,$oConta->debito  == 0 ? "" : db_formatar($oConta->debito,'f')	,0,0,"R",0);
		$pdf->Cell(25,5,$oConta->credito == 0 ? "" : db_formatar($oConta->credito,'f'),0,0,"R",0);
	} */
	$pdf->ln();
	$pdf->SetFont('Arial','',7);
}

function imprimeCabecalhoSub($pdf, $descricao)
{
	$pdf->SetFont('Arial', 'b', 8);
	$pdf->Cell(192, 5, $descricao, "T", 0, "L", 1);
	$pdf->ln();
	$pdf->SetFont('Arial','',7);
}

function imprimeCabecalho($pdf){
	$pdf->SetFont('Arial', 'b', 8);
	$pdf->Cell(25, 5, "DATA", "T", 0, "C", 1);
	$pdf->Cell(25, 5, "OPS/REC/SLIP", "TL", 0, "C", 1);
	$pdf->Cell(25, 5, "DOCUMENTO", "TL", 0, "C", 1);
	$pdf->Cell(92, 5, "HISTÓRICO", "TL", 0, "C", 1);
	$pdf->Cell(25, 5, "VALOR", "TL", 0, "C", 1);
	$pdf->SetFont('Arial','',7);
	$pdf->ln();
}

function imprimeSaldoExtratoBancario($pdf, $saldo_debitado, $saldo_creditado, $total){
    $pdf->SetFont('Arial', 'b', 8);
    $pdf->Cell(20,5,""																	,"TB",0,"R",1);
    $pdf->Cell(122,5, "Saldo do Extrato Bancário (1):" ,"TB",0,"R",1);
    $pdf->Cell(25,5,$saldo_debitado 	== 0 ? "" : db_formatar($saldo_debitado,'f')	,"TLB",0,"R",1);
    $pdf->Cell(25,5,$saldo_creditado	== 0 ? "" : db_formatar($saldo_creditado,'f')	,"TB",0,"R",1);
    $pdf->ln();
    $pdf->SetFont('Arial','',7);
}

function imprimeTotalMovConta($pdf, $saldo_debitado, $saldo_creditado, $total){
	$pdf->SetFont('Arial','b',8);
	$pdf->Cell(20,5,""																	,"TB",0,"R",1);
	$pdf->Cell(122,5,"TOTAL ({$total}):" ,"TB",0,"R",1);
	$pdf->Cell(25,5,$saldo_debitado 	== 0 ? "" : db_formatar($saldo_debitado,'f')	,"TLB",0,"R",1);
	$pdf->Cell(25,5,$saldo_creditado	== 0 ? "" : db_formatar($saldo_creditado,'f')	,"TB",0,"R",1);
	$pdf->ln();
	$pdf->SetFont('Arial','',7);
}

function imprimeTotalMovContabilidade($pdf, $saldo_debitado, $saldo_creditado){
	$pdf->SetFont('Arial','b',8);
	$pdf->Cell(20,5,""																	,"TB",0,"R",1);
	$pdf->Cell(122,5,"SALDO NA CONTABILIDADE (6) = (1) + (2) + (3) - (4) - (5):" ,"TB",0,"R",1);
	$pdf->Cell(25,5,$saldo_debitado 	== 0 ? "" : db_formatar($saldo_debitado,'f')	,"TLB",0,"R",1);
	$pdf->Cell(25,5,$saldo_creditado	== 0 ? "" : db_formatar($saldo_creditado,'f')	,"TB",0,"R",1);
	$pdf->ln();
	$pdf->SetFont('Arial','',7);
}

/**
 * Retorna a data da conciliação atraves dos filtros de lancamentos
 * @return Bool
 */
function conciliado($conta, $data, $numcgm, $cod_doc, $documento, $cheque, $valor)
{
    $sql = "SELECT k172_dataconciliacao FROM conciliacaobancarialancamento WHERE k172_conta = {$conta} AND k172_data = '{$data}' AND k172_coddoc IN ({$cod_doc}) AND k172_valor = {$valor}";
    if ($numcgm)
        $sql .= " AND k172_numcgm = {$numcgm} ";
    if ($documento)
        $sql .= " AND k172_codigo = '{$documento}' ";
    $query = pg_query($sql);
    if (pg_num_rows($query) > 0) {
    	while ($row = pg_fetch_object($query)) {
    		if ($row->k172_dataconciliacao)
    			return TRUE;
    		else
    			return FALSE;
    	}
	} else {
        return FALSE;
    }
}

function query_lancamentos($conta, $data_inicial, $data_final)
{
	$condicao_lancamento = "";
	$sSQL = "SELECT k29_conciliacaobancaria FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
    $rsResult = db_query($sSQL);
    $dataImplantacao = db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->k29_conciliacaobancaria)) : "";
    $data_implantacao = data($dataImplantacao);
    $sql = query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    $sql .= " union all ";
    $sql .= query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao);
    return $sql;
}

function query_empenhos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$data_inicial}') ";
    }

    $sql = "select
            DISTINCT
                0 as tipo_lancamento,
                corrente.k12_data as data,
                k172_dataconciliacao data_conciliacao,
                conlancamdoc.c71_coddoc::text cod_doc,
                0 as valor_debito,
                corrente.k12_valor as valor_credito,
                e60_codemp || '/' || e60_anousu :: text as codigo,
                'OP' :: text as tipo,
                coremp.k12_cheque :: text as cheque,
                coremp.k12_codord::text as ordem,
                z01_nome :: text as credor,
                z01_numcgm :: text as numcgm,
                '' as historico
            from
                corrente
                inner join coremp on coremp.k12_id = corrente.k12_id
                and coremp.k12_data = corrente.k12_data
                and coremp.k12_autent = corrente.k12_autent
                inner join empempenho on e60_numemp = coremp.k12_empen
                inner join cgm on z01_numcgm = e60_numcgm
                left join corhist on corhist.k12_id = corrente.k12_id
                and corhist.k12_data = corrente.k12_data
                and corhist.k12_autent = corrente.k12_autent
                left join corautent on corautent.k12_id = corrente.k12_id
                and corautent.k12_data = corrente.k12_data
                and corautent.k12_autent = corrente.k12_autent
                left join corgrupocorrente on corrente.k12_data = k105_data
                and corrente.k12_id = k105_id
                and corrente.k12_autent = k105_autent
                LEFT JOIN conlancamord ON conlancamord.c80_codord = coremp.k12_codord
                AND conlancamord.c80_data = coremp.k12_data
                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamord.c80_codlan
                LEFT JOIN conlancamval ON conlancamval.c69_codlan = conlancamord.c80_codlan
                AND (
                    (
                        c69_credito = corrente.k12_conta
                        AND corrente.k12_valor > 0
                    )
                    OR (
                        c69_debito = corrente.k12_conta
                        AND corrente.k12_valor < 0
                    )
                )
                LEFT JOIN conciliacaobancarialancamento conc ON
                    conc.k172_conta = corrente.k12_conta
                    AND conc.k172_data = corrente.k12_data
                    AND conc.k172_coddoc = conlancamdoc.c71_coddoc
                    AND conc.k172_codigo = coremp.k12_codord::text || coremp.k12_cheque::text
                LEFT JOIN retencaopagordem ON e20_pagordem = coremp.k12_codord
                LEFT join retencaoreceitas on  e23_retencaopagordem = e20_sequencial  AND k12_valor = e23_valorretencao
            WHERE
                corrente.k12_conta = {$conta}
                AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))
                {$condicao_lancamento}
                AND c69_sequen IS NOT NULL
                AND e23_valorretencao IS NULL
                AND corrente.k12_instit = " . db_getsession("DB_instit");
    return $sql;
}

function query_planilhas($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND data < '{$data_inicial}') ";
    }

    $sql = "select
                0 as tipo_lancamento,
                data,
                data_conciliacao,
                cod_doc::text,
                valor_debito,
                valor_credito,
                codigo,
                tipo,
                cheque,
                ordem::text,
                credor,
                ''::text as numcgm,
                '' as historico
            from
                (
                    select
          data,
            conc.k172_dataconciliacao as data_conciliacao,
            cod_doc,
            sum(k12_valor) as valor_debito,
            0 as valor_credito,
            tipo_movimentacao :: text,
            codigo :: text,
            tipo :: text,
            cheque :: text,
            ordem,
            credor :: text
        from
                        (
                        SELECT
                               DISTINCT
                                corrente.k12_conta as conta,
                                corrente.k12_data as data,
                                case
                                    when conlancamdoc.c71_coddoc = 116 then 100
                                    else conlancamdoc.c71_coddoc
                                end as cod_doc,
                                k12_valor,
                                ('planilha :' || k81_codpla) :: text as tipo_movimentacao,
                                k81_codpla :: text as codigo,
                                'REC' :: text as tipo,
                                (coalesce(placaixarec.k81_obs, '.')) :: text as historico,
                                null :: text as cheque,
                                0 as ordem,
                                null :: text as credor
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
                                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                                AND conlancamcorrente.c86_data = corrente.k12_data
                                AND conlancamcorrente.c86_autent = corrente.k12_autent
                                LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan

                            where
                                corrente.k12_conta = {$conta}
                                and corrente.k12_instit = " . db_getsession("DB_instit") . " {$condicao_lancamento}
                        ) as x
                                LEFT JOIN  conciliacaobancarialancamento conc ON conc.k172_conta = conta
                    AND conc.k172_data = data
                    AND conc.k172_coddoc = cod_doc
                    WHERE
                     ((data between '{$data_inicial}' AND '{$data_final}'  AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))
                    group by

                    data,
                    data_conciliacao,
                    cod_doc,
                    valor_credito,
                    tipo_movimentacao,
                    codigo,
                    tipo,

                    historico,
                    cheque,

                    ordem,
                    credor
                ) as xx";
    return $sql;
}

function query_bancos($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$data_inicial}') ";
    }

    $sql = "select
                0 as tipo_lancamento,
                data,
                data_conciliacao,
                cod_doc::text,
                valor_debito,
                valor_credito,
                codigo,
                tipo,
                cheque,
                ordem::text,
                credor,
                ''::text as numcgm,
                '' as historico
            from
                (
                    select
                        caixa,
                        data,
                        data_conciliacao,
                        cod_doc,
                        sum(valor_debito) as valor_debito,
                        valor_credito,
                        tipo_movimentacao::text,
                        codigo::text,
                        tipo::text,
                        receita,
                        receita_descr::text,
                        historico::text,
                        cheque::text,
                        null::text as contrapartida,
                        ordem,
                        credor::text,
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
                                k172_dataconciliacao data_conciliacao,
                                conlancamdoc.c71_coddoc cod_doc,
                                cornump.k12_valor as valor_debito,
                                0 as valor_credito,
                                ('Baixa da banco ')::text as tipo_movimentacao,
                                discla.codret as codigo,
                                'baixa'::text as tipo,
                                cornump.k12_receit as receita,
                                tabrec.k02_drecei::text as receita_descr,
                                (coalesce(corhist.k12_histcor, '.'))::text as historico,
                                null::text as cheque,
                                null::text as contrapartida,
                                0 as ordem,
                                disarq.codret as codret,
                                disarq.dtretorno as dtretorno,
                                disarq.arqret as arqret,
                                disarq.dtarquivo as dtarquivo,
                                (
                                    select
                                        z01_nome::text
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
                                and discla.instit = " . db_getsession("DB_instit") . "
                                inner join disarq on disarq.codret = discla.codret
                                and disarq.instit = discla.instit
                                left join corplacaixa on corplacaixa.k82_id = corrente.k12_id
                                and corplacaixa.k82_data = corrente.k12_data
                                and corplacaixa.k82_autent = corrente.k12_autent
                                /* Inclusão do tipo doc */
                                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                                AND conlancamcorrente.c86_data = corrente.k12_data
                                AND conlancamcorrente.c86_autent = corrente.k12_autent
                                LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan
                                LEFT JOIN conciliacaobancarialancamento conc ON
                                    conc.k172_conta = corrente.k12_conta
                                    AND conc.k172_data = corrente.k12_data
                                    AND conc.k172_coddoc = conlancamdoc.c71_coddoc
                            where
                                corrente.k12_conta = {$conta}

                                    AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}'  AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))
                                and corrente.k12_instit = " . db_getsession("DB_instit") . "
                                and corplacaixa.k82_id is null
                                and corplacaixa.k82_data is null
                                and corplacaixa.k82_autent is null {$condicao_lancamento}
                        ) as x
                    group by
                        caixa,
                        data,
                        data_conciliacao,
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
                ) as xx";
    return $sql;
}

function query_transferencias_debito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corlanc.k12_data < '{$data_inicial}') ";
    }

    $sql = "select
                0 as tipo_lancamento,
                corlanc.k12_data as data,
                k172_dataconciliacao data_conciliacao,
                conlancamdoc.c71_coddoc::text cod_doc,
                corrente.k12_valor as valor_debito,
                0 as valor_credito,
                k12_codigo::text as codigo,
                'SLIP'::text as tipo,
                e91_cheque::text as cheque,
                '' as ordem,
                z01_nome::text as credor,
                z01_numcgm::text as numcgm,
                '' as historico
            from
                corlanc
                inner join corrente on corrente.k12_id = corlanc.k12_id
                and corrente.k12_data = corlanc.k12_data
                and corrente.k12_autent = corlanc.k12_autent
                inner join slip on slip.k17_codigo = corlanc.k12_codigo
                inner join conplanoreduz on c61_reduz = slip.k17_credito
                and c61_anousu =  " . db_getsession('DB_anousu') . "
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
                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
                AND conlancamcorrente.c86_data = corrente.k12_data
                AND conlancamcorrente.c86_autent = corrente.k12_autent
                LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
                LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan
    LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corlanc.k12_conta
    AND conc.k172_data = corrente.k12_data
    AND conc.k172_coddoc = conlancamdoc.c71_coddoc
    AND conc.k172_valor = corrente.k12_valor
            where
                corlanc.k12_conta = {$conta}

                AND ((corlanc.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}'))  {$condicao_lancamento}";
    return $sql;
}

function query_transferencias_credito($conta, $data_inicial, $data_final, $condicao_lancamento, $data_implantacao)
{
    $data_inicial = $data_inicial < $data_implantacao ? $data_implantacao : $data_inicial;
    if ($data_implantacao) {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data BETWEEN '{$data_implantacao}' AND '{$data_inicial}') ";
    } else {
        $condicao_implantacao = " OR (k172_dataconciliacao IS NULL AND corrente.k12_data < '{$data_inicial}') ";
    }

    $sql = "
        select
            0 as tipo_lancamento,
            corlanc.k12_data as data,
            k172_dataconciliacao data_conciliacao,
            conlancamdoc.c71_coddoc::text cod_doc,
            0 as valor_debito,
            corrente.k12_valor as valor_credito,
            k12_codigo::text as codigo,
            'SLIP'::text as tipo,
            e91_cheque::text as cheque,
            '' as ordem,
            z01_nome::text as credor,
            z01_numcgm::text as numcgm,
            '' as historico
        from
            corrente
            inner join corlanc on corrente.k12_id = corlanc.k12_id
            and corrente.k12_data = corlanc.k12_data
            and corrente.k12_autent = corlanc.k12_autent
            inner join slip on slip.k17_codigo = corlanc.k12_codigo
            inner join conplanoreduz on c61_reduz = slip.k17_debito
            and c61_anousu =  " . db_getsession('DB_anousu') . "
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
            LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
            AND conlancamcorrente.c86_data = corrente.k12_data
            AND conlancamcorrente.c86_autent = corrente.k12_autent
            LEFT JOIN conlancam ON conlancam.c70_codlan = conlancamcorrente.c86_conlancam
            LEFT JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancam.c70_codlan
       LEFT JOIN conciliacaobancarialancamento conc ON conc.k172_conta = corrente.k12_conta
            AND conc.k172_data = corrente.k12_data
            AND conc.k172_coddoc = conlancamdoc.c71_coddoc
            AND conc.k172_valor = corrente.k12_valor
        where
            corrente.k12_conta = {$conta}
            AND ((corrente.k12_data between '{$data_inicial}' AND '{$data_final}' AND k172_dataconciliacao IS NULL) {$condicao_implantacao} OR (k172_dataconciliacao > '{$data_final}')) {$condicao_lancamento}
        order by
            data,
            codigo";
    return $sql;
}

function data($data)
{
    $data = explode("/", $data);
    if (count($data) > 1) {
        return $data[2] . "-" . $data[1] . "-" . $data[0];
    } else {
        return $data[0];
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
        case "Baixa":
            return "Baixa Nº {$codigo}";
            break;
        case "REC":
            return "Planilha Nº {$codigo}";
            break;
    }
}
?>
