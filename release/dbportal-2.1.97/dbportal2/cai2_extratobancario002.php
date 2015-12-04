<?
include("fpdf151/pdf.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

//echo($HTTP_SERVER_VARS["QUERY_STRING"]); exit;

if($imprime_analitico=="a"){
  $head2 = "EXTRATO BANCÁRIO ANALÍTICO";
}else{
  $head2 = "EXTRATO BANCÁRIO SINTÉTICO";
}

$head4 = "PERÍODO : ".db_formatar(@$datai,"d")." A ".db_formatar(@$dataf,"d");

if ($somente_contas_bancarias == "s") {
  $head5 = "SOMENTE CONTAS BANCÁRIAS";
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();

/// CONTAS MOVIMENTO
$sql ="	select *
        from (
              select k13_reduz,
                     k13_descr,
                     c60_estrut,
                     c60_codsis,
	                   c63_conta,
	                   substr(fc_saltessaldo,2,13)::float8 as anterior,
	                   substr(fc_saltessaldo,15,13)::float8 as debitado ,
	                   substr(fc_saltessaldo,28,13)::float8 as creditado,
	                   substr(fc_saltessaldo,41,13)::float8 as atual
            	from (
 	                  select k13_reduz,
 	                         k13_descr,
	                         c60_estrut,
		                       c60_codsis,
		                       c63_conta,
	                         fc_saltessaldo(k13_reduz,'".$datai."','".$dataf."',null," . db_getsession("DB_instit") . ")
	                  from   saltes
	                         inner join conplanoexe   on k13_reduz = c62_reduz
		                                              and c62_anousu = ".db_getsession('DB_anousu')."
		                       inner join conplanoreduz on c61_anousu=c62_anousu and c61_reduz = c62_reduz and c61_instit = " . db_getsession("DB_instit") . "
	                         inner join conplano      on c60_codcon = c61_codcon and c60_anousu=c61_anousu
	                         left  join conplanoconta on c60_codcon = c63_codcon and c63_anousu=c60_anousu ";
if($conta > 0) {
  $sql .= "where c61_reduz = $conta ";
}

if ($conta > 0 && $somente_contas_bancarias == "s"){
  $sql .= " and c60_codsis = 6 ";
} else if ($somente_contas_bancarias == "s"){
  $sql .= "where c60_codsis = 6 ";
}

$sql .= "  ) as x ) as xx";


// verifica se é pra selecionar somente as contas com movimeto

if ($somente_contas_com_movimento=='s'){
  $sql.=" where (debitado > 0 or creditado > 0)  ";
}

$sql .= " order by substr(k13_descr,1,3),k13_reduz ";

//echo "2 ".$sql; exit;

$resultcontasmovimento = pg_query($sql);

if(pg_numrows($resultcontasmovimento) == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados neste periodo.');
}

/*
 if($conta <= 0) {
	$vet_contas = array();

	for($i=0; $i < pg_numrows($resultcontasmovimento); $i++) {
	db_fieldsmemory($resultcontasmovimento,$i);
	$vet_contas[$i][1] = $c63_conta;
	$vet_contas[$i][2] = $c63_conta;
	$vet_contas[$i][3] = $c63_conta;
	}
	}
	$saldo_inicial = 0;
	*/

/*
 for ($i = 0; $i < pg_numrows($resultcontasmovimento); $i++){
 db_fieldsmemory($resultcontasmovimento, $i);

 $saldo_inicial += $anterior;
 }
 */

db_fieldsmemory($resultcontasmovimento,0);
//db_criatabela($resultcontasmovimento);

$QuebraPagina = 10;
$total_deb    = 0;
$total_cre    = 0;
$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(0,0,0);
$pdf->setfillcolor(235);

$StrPad1 = 20;
$StrPad2 = 26;

$pre           = 0;
$alt = 5 ; //altura da celula
$numero_pagina=0; // o contador de hp do pdf começa em 1

$numrows = pg_numrows($resultcontasmovimento);
for($linha=0;$linha<$numrows;$linha++){
  db_fieldsmemory($resultcontasmovimento,$linha);
  $pdf->SetFont('Arial','B',7);
  // escreve a conta e a descrição + saldo inicial
  $pdf->Cell(120,$alt,"CONTA: $k13_reduz - $k13_descr ",'B',0,"L",1);
  $pdf->Cell(30,$alt,"SALDO ANTERIOR",'B',0,"L",1);

  // para contas bancárias, saldo positivo = debito, negativos indica debito
  if ($anterior > 0 ){
    $pdf->Cell(20,$alt,db_formatar($anterior,'f'),'B',0,"R",1);
    $pdf->Cell(20,$alt,'','B',0,"R",1);
  } else {
    $pdf->Cell(20,$alt,'','B',0,"R",1);
    $pdf->Cell(20,$alt,db_formatar($anterior,'f'),'B',0,"R",1);
  }
  $pdf->Ln();

  // imprime head interno, se for primeira pagina somente
  // if ($numero_pagina != $pdf->PageNo()){

  $y1= $pdf->GetY ();
  $x1= $pdf->GetX ();
  $pdf->Cell(15,$alt,'DATA','BR',0,"C",0);
  $pdf->Cell(60,$alt,'COD. AUTENTICAÇÃO','B',0,"L",0);
  $pdf->Cell(15,$alt,"PLANILHA",'B',0,"C",0);
  $pdf->Cell(15,$alt,"EMPENHO",'B',0,"C",0);
  $pdf->Cell(15,$alt,'ORDEM','B',0,"C",0);
  $pdf->Cell(15,$alt,'CHEQUE','B',0,"C",0);
  $pdf->Cell(15,$alt,'SLIP','B',0,"C",0);
  $pdf->Cell(20,$alt,'DEBITO','BL',0,"C",0);
  $pdf->Cell(20,$alt,'CREDITO','BL',0,"C",0);
  $pdf->Ln();
  $pdf->SetFont('Arial','',7);
  $numero_pagina = $pdf->PageNo();
  // }

  // lista movimentos da conta

  // ****************** ANALITICO e sintetico****************


  // *********************  EMPENHO ***************************
  $sqlempenho = " 
  /* empenhos- despesa orçamentaria */
  /*   EMPENHO */
  
  select
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
		    coremp.k12_cheque::text as cheque,
		    null::text as contrapartida,
		    coremp.k12_codord as ordem,
		    z01_nome::text as credor,
		    k12_codautent
 from corrente
      inner join coremp on coremp.k12_id = corrente.k12_id and coremp.k12_data   = corrente.k12_data  
                                                           and coremp.k12_autent = corrente.k12_autent                   
      inner join empempenho on e60_numemp = coremp.k12_empen
      inner join cgm on z01_numcgm = e60_numcgm		   
		    /*
		      se habilitar o left abaixo e o empenho tiver mais de um cheque os registros ficam duplicados
		      left join empord on e82_codord = coremp.k12_codord
		     left join empageconfche on e91_codcheque = e82_codmov
		   */
	    left join corhist on  corhist.k12_id     = corrente.k12_id    and corhist.k12_data   = corrente.k12_data  and 
					                                                              corhist.k12_autent = corrente.k12_autent     
      left join corautent	on corautent.k12_id     = corrente.k12_id   and corautent.k12_data   = corrente.k12_data
							                                                        and corautent.k12_autent = corrente.k12_autent				 
 where corrente.k12_conta = $k13_reduz  and corrente.k12_data between '".$datai."'  
                                        and '".$dataf."'  
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
		   cheque,
		   contrapartida,
       ordem,
		   credor,
		   k12_codautent
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
		               cheque::text,
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
			                  null::text as cheque,
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
                     and (corrente.k12_data between '".$datai."'  and '".$dataf."')
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
		         k12_codautent
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
		               cheque::text,
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
		                     null::text as cheque,
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
           			where corrente.k12_conta = $k13_reduz  and (corrente.k12_data between '".$datai."'  and '".$dataf."')
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
           cheque,
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
		         cheque,
		         contrapartida,
             ordem,
		         credor,
		         k12_codautent
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
		              cheque::text,
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
	                      ('Baixa da banco ')::text as tipo_movimentacao,
		                    null::text as codigo,
                        'Baixa'::text as tipo,
		                    cornump.k12_receit as receita,
		                    tabrec.k02_drecei::text as receita_descr,	
		                    (coalesce(corhist.k12_histcor,'.'))::text as historico,
		                    null::text as cheque,
		                    null::text as contrapartida,
			                  0 as ordem,
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
                     left join corplacaixa on corplacaixa.k82_id     = corrente.k12_id  
                                          and corplacaixa.k82_data   = corrente.k12_data
                                          and corplacaixa.k82_autent = corrente.k12_autent
			          where corrente.k12_conta = $k13_reduz  
                  and (corrente.k12_data between '".$datai."'  and '".$dataf."')  
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
			         cheque,
			         contrapartida,
			         ordem,
			         credor,
               k12_codautent		   
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
       cheque,
       contrapartida,
       ordem,
       credor,
       k12_codautent
from (
select caixa,
       data,
       sum(valor_debito) as valor_debito,
       sum(valor_credito) as valor_credito,
       codigo,
       tipo,
       historico,
       cheque,
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
		cheque,
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
		   e91_cheque::text as cheque,
           k17_debito||' - '||c60_descr as contrapartida,
		   0 as ordem,
		   z01_nome::text as credor,
           k12_codautent
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
	           
                  		   
		   left join corconf on corconf.k12_id = corlanc.k12_id and
		                        corconf.k12_data = corlanc.k12_data and
					corconf.k12_autent = corlanc.k12_autent
                   left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
                   left join corhist on   corhist.k12_id     = corrente.k12_id    and
		                          corhist.k12_data   = corrente.k12_data  and 
					  corhist.k12_autent = corrente.k12_autent
					left join corautent	on corautent.k12_id     = corrente.k12_id   
									and corautent.k12_data   = corrente.k12_data
									and corautent.k12_autent = corrente.k12_autent	
			     where corlanc.k12_conta = $k13_reduz  and
	           corlanc.k12_data between '".$datai."'  and '".$dataf."'  
	      
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
		   e91_cheque::text as cheque,
		   k17_debito||' - '||c60_descr as contrapartida,
		   0 as ordem,
		   z01_nome::text as credor,
           k12_codautent
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
               left join empageconfche on empageconfche.e91_codcheque = corconf.k12_codmov
	           left join corhist on corhist.k12_id     = corrente.k12_id    
                                and corhist.k12_data   = corrente.k12_data  
                                and corhist.k12_autent = corrente.k12_autent 
              left join corautent	on corautent.k12_id     = corrente.k12_id   
									and corautent.k12_data   = corrente.k12_data
									and corautent.k12_autent = corrente.k12_autent	
	     where corrente.k12_conta = $k13_reduz  and
	           corrente.k12_data between '".$datai."'  and '".$dataf."'  
	
	     order by data, caixa, cheque


";

  if($imprime_analitico == "a"){
    $sqltotal = $sqlempenho." union all ".$sqlanalitico.$sqlslip;
  }else{
    $sqltotal = $sqlempenho.$sqlsintetico.$sqlslip;
  }

//  die($sqltotal);

  //   die($sql);
//   echo $sql; exit;
  $resmovimentacao = pg_exec($sqltotal);

//  db_criatabela($resmovimentacao);

  $quebra_data = '';

  $saldo_dia_debito  = 0;
  $saldo_dia_credito = 0;

  $saldo_dia_final   = $anterior;

  if (pg_numrows($resmovimentacao)>0){
    for  ($i=0;$i < pg_numrows($resmovimentacao);$i++){
      db_fieldsmemory($resmovimentacao,$i);

      // controla quebra de saldo por dia
      if ($quebra_data!=$data && $quebra_data!=''  && $totalizador_diario=='s'){
        //
        $pdf->Cell(15,$alt,"",'R',0,"L",0);
        $pdf->Cell(135,$alt,'TOTAL DIA',0,0,"R",0,'');
        $pdf->Cell(20,$alt,db_formatar($saldo_dia_debito,'f' ),'L',0,"R",0);
        $pdf->Cell(20,$alt,db_formatar($saldo_dia_credito,'f'),'L',0,"R",0);
        $pdf->Ln();
        // calcula saldo a debito ou credito
        if ($saldo_dia_debito < 0){
          $saldo_dia_final -= abs($saldo_dia_debito);
        } else {
          $saldo_dia_final += $saldo_dia_debito;
        }

        if ($saldo_dia_credito < 0){
          $saldo_dia_final += abs($saldo_dia_credito);
        } else {
          $saldo_dia_final -= $saldo_dia_credito;
        }
		       
		      //$pdf->Cell(15,$alt,"",'BR',0,"L",0);
		      $pdf->Cell(150,$alt,'SALDO DO DIA','B',0,"R",0);
		      if ($saldo_dia_debito > $saldo_dia_credito){
		        $pdf->Cell(20,$alt,db_formatar($saldo_dia_final,'f' ),'B',0,"R",0);
		        $pdf->Cell(20,$alt,'','B',0,"R",0);
		      } else {
		        $pdf->Cell(20,$alt,'','B',0,"R",0);
		        $pdf->Cell(20,$alt,db_formatar($saldo_dia_final,'f'),'B',0,"R",0);
		      }
          
		      $pdf->Ln();

		      $saldo_dia_debito  = 0;
		      $saldo_dia_credito = 0;
      }
       
      //$pdf->Ln();
      $pdf->Cell(15,$alt,db_formatar($data,'d'),'R',0,"C",0);
      $pdf->Cell(60,$alt,$k12_codautent,0,0,"L",0);
      
      //planilha
      if($tipo=='planilha'){
        $pdf->Cell(15,$alt,$codigo,0,0,"C",0);
      }else{
        $pdf->Cell(15,$alt,"",0,0,"C",0);
      }
      
      //empenho
      if($tipo=='empenho'){
        $pdf->Cell(15,$alt,$codigo,0,0,"C",0);
        $pdf->Cell(15,$alt,$ordem,0,0,"C",0);
      }else{
        $pdf->Cell(15,$alt,"",0,0,"C",0);
        $pdf->Cell(15,$alt,"$ordem",0,0,"C",0);
      }

      $pdf->Cell(15,$alt,$cheque,0,0,"C",0);
      
      //slip
      if($tipo=='slip'){
        $pdf->Cell(15,$alt,$codigo,0,0,"C",0);
      }else{
        $pdf->Cell(15,$alt,"",0,0,"C",0);
      }
      
      // DEBITO E CREDITO
      
      if ($valor_debito ==0 &&  $valor_credito != 0  ){
        $pdf->Cell(20,$alt,'','L',0,"R",0);
        $pdf->Cell(20,$alt,db_formatar($valor_credito,'f'),'L',0,"R",0);
      } elseif ($valor_credito== 0 && $valor_debito != 0 ){
        $pdf->Cell(20,$alt,db_formatar($valor_debito,'f'),'L',0,"R",0);
        $pdf->Cell(20,$alt,'','L',0,"R",0);
      }
      else {
        $pdf->Cell(20,$alt,db_formatar($valor_debito,'f'),'L',0,"R",0);
        $pdf->Cell(20,$alt,db_formatar($valor_credito,'f'),'L',0,"R",0);
      }
      $pdf->Ln();

       
      if ($receita > 0){
        // selecina reduzido da receita no plano de contas
         
        $sql = "
                    select c61_reduz
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
        $res_rec = pg_query($sql);
        $c61_reduz ="";
        if (pg_numrows($res_rec)>0){
          db_fieldsmemory($res_rec,0);
        }
      }
      //$x1= $pdf->GetX ();
      if($tipo == 'recibo'  || $tipo == 'planilha' || $tipo == 'baixa'){
        
        if($imprime_analitico=="a"){
          $pdf->Cell(15,$alt,"",'R',0,"C",0);
          $pdf->Cell(30,$alt,'CONTRAPARTIDA:',0,0,"L",0);
          $pdf->Cell(105,$alt,"Receita ".$receita."(".$c61_reduz.") - ".$receita_descr,0,0,"L",0);
          $pdf->Cell(20,$alt,'','L',0,"R",0);
          $pdf->Cell(20,$alt,'','L',0,"R",0);
          $pdf->Ln();
        }
             
      }
      if($tipo == 'slip'){
        $pdf->Cell(15,$alt,"",'R',0,"C",0);
        $pdf->Cell(30,$alt,'CONTRAPARTIDA:',0,0,"L",0);
        $pdf->Cell(105,$alt,$contrapartida,0,0,"L",0);
        $pdf->Cell(20,$alt,'','L',0,"R",0);
        $pdf->Cell(20,$alt,'','L',0,"R",0);
        $pdf->Ln();
        
      }

      $pdf->Cell(15,$alt,"",'R',0,"C",0);
      $pdf->Cell(30,$alt,'CREDOR:',0,0,"L",0);
      $pdf->Cell(105,$alt,$credor,0,0,"L",0);
      $pdf->Cell(20,$alt,'','L',0,"R",0);
      $pdf->Cell(20,$alt,'','L',0,"R",0);
      $pdf->Ln();

      /*
       if ($historico!=""  && $imprime_historico=='s' ){
       $pdf->Cell(15,$alt,"",'R',0,"C",0);
       $pdf->Cell(30,$alt,'HISTORICO:',0,0,"L",0);
       $pdf->Cell(105,$alt,$historico,0,0,"L",0);
       $pdf->Cell(20,$alt,'','L',0,"R",0);
       $pdf->Cell(20,$alt,'','L',0,"R",0);
       $pdf->Ln();
       }*/


      
      if ($historico!=""  && $imprime_historico=='s' ){
        $lh = 0;
      while ($historico!=""){
        $lh = $lh + 1 ;
        if ($pdf->gety() > $pdf->h - 50){
          $y2= $pdf->GetY();
          $pdf->Line($x1+15, $y1, $x1+15, $y2);
          $pdf->Line($x1+150, $y1, $x1+150, $y2);
          $pdf->Line($x1+170, $y1, $x1+170, $y2);
          
          $pdf->addPage();
          $pdf->SetFont('Arial','B',7);
          // escreve a conta e a descrição + saldo inicial
          $pdf->Cell(190,$alt,"CONTA: $k13_reduz - $k13_descr ",'B',1,"L",1);
          $y1= $pdf->GetY();
          $pdf->Cell(15,$alt,'DATA','BR',0,"C",0);
          $pdf->Cell(60,$alt,'COD. AUTENTICAÇÃO','B',0,"L",0);
          $pdf->Cell(15,$alt,"PLANILHA",'B',0,"C",0);
          $pdf->Cell(15,$alt,"EMPENHO",'B',0,"C",0);
          $pdf->Cell(15,$alt,'ORDEM','B',0,"C",0);
          $pdf->Cell(15,$alt,'CHEQUE','B',0,"C",0);
          $pdf->Cell(15,$alt,'SLIP','B',0,"C",0);
          $pdf->Cell(20,$alt,'DEBITO','BL',0,"C",0);
          $pdf->Cell(20,$alt,'CREDITO','BL',0,"C",0);
          $pdf->SetFont('Arial','',7);
          $pdf->Ln();
          $numero_pagina = $pdf->PageNo();
        }

       
      $pdf->Cell(15,$alt,"",'R',0,"C",0);
      if($lh==1){
        $pdf->Cell(30,$alt,'HISTORICO:',0,0,"L",0);
      }else{
        $pdf->Cell(30,$alt,'',0,0,"L",0);
      }
      
      //$pdf->MultiCell(105,$alt,$historico,0,"L",0);
      $historico =  $pdf->Row_multicell(array('','','',$historico,'',''),$alt,false,5,0,true,true,3,($pdf->h - 45),105);
    }
    }
    /*
     $pdf->Cell(15,$alt,"",'R',0,"C",0);
     $pdf->Cell(30,$alt,'HISTORICO:',0,0,"L",0);
     $pdf->MultiCell(105,$alt,$historico,0,"L",0);
     */

    // UMA LINHA EM BRANCO NPO RELATORIO DEPOIS DO HISTORICO
    $pdf->Cell(15,$alt,"",'R',0,"C",0);
    $pdf->Cell(30,$alt,'',0,0,"L",0);
    $pdf->Cell(105,$alt,'',0,0,"L",0);
    $pdf->Cell(20,$alt,'','L',0,"R",0);
    $pdf->Cell(20,$alt,'','L',0,"R",0);
    $pdf->Ln();

    // soma acumuladores diarios
    $saldo_dia_debito  += $valor_debito;
    $saldo_dia_credito += $valor_credito;

    $quebra_data = $data;

    // imprime head interno, se for primeira pagina somente
    if ($pdf->gety() > $pdf->h - 50){

      $y2= $pdf->GetY();
      $pdf->Line($x1+15, $y1, $x1+15, $y2);
      $pdf->Line($x1+150, $y1, $x1+150, $y2);
      $pdf->Line($x1+170, $y1, $x1+170, $y2);
            
      $pdf->addPage();
      $pdf->SetFont('Arial','B',7);
      // escreve a conta e a descrição + saldo inicial
      
      $pdf->Cell(190,$alt,"CONTA: $k13_reduz - $k13_descr ",'B',1,"L",1);
      $y1= $pdf->GetY ();
      $x1= $pdf->GetX ();
      $pdf->Cell(15,$alt,'DATA','BR',0,"C",0);
      $pdf->Cell(60,$alt,'COD. AUTENTICAÇÃO','B',0,"L",0);
      $pdf->Cell(15,$alt,"PLANILHA",'B',0,"C",0);
      $pdf->Cell(15,$alt,"EMPENHO",'B',0,"C",0);
      $pdf->Cell(15,$alt,'ORDEM','B',0,"C",0);
      $pdf->Cell(15,$alt,'CHEQUE','B',0,"C",0);
      $pdf->Cell(15,$alt,'SLIP','B',0,"C",0);
      $pdf->Cell(20,$alt,'DEBITO','BL',0,"C",0);
      $pdf->Cell(20,$alt,'CREDITO','BL',0,"C",0);
      $pdf->SetFont('Arial','',7);



      $pdf->Ln();
      $numero_pagina = $pdf->PageNo();
    }

  }
}


if ($totalizador_diario=='s'){
  //
  $pdf->Cell(15,$alt,"",'R',0,"L",0);
  $pdf->Cell(135,$alt,'TOTAL DIA',0,0,"R",0,'');
  $pdf->Cell(20,$alt,db_formatar($saldo_dia_debito,'f' ),'L',0,"R",0);
  $pdf->Cell(20,$alt,db_formatar($saldo_dia_credito,'f'),'L',0,"R",0);
  $pdf->Ln();
  // calcula saldo a debito ou credito
  if ($saldo_dia_debito < 0){
    $saldo_dia_final -= abs($saldo_dia_debito);
  } else {
    $saldo_dia_final += $saldo_dia_debito;
  }

  if ($saldo_dia_credito < 0){
    $saldo_dia_final += abs($saldo_dia_credito);
  } else {
    $saldo_dia_final -= $saldo_dia_credito;
  }

  $pdf->Cell(150,$alt,'SALDO DO DIA','B',0,"R",0);
  if ($saldo_dia_debito > $saldo_dia_credito){
    $pdf->Cell(20,$alt,db_formatar($saldo_dia_final,'f' ),'B',0,"R",0);
    $pdf->Cell(20,$alt,'','B',0,"R",0);
  } else {
    $pdf->Cell(20,$alt,'','B',0,"R",0);
    $pdf->Cell(20,$alt,db_formatar($saldo_dia_final,'f'),'B',0,"R",0);
  }
  $pdf->Ln();


}


$y2= $pdf->GetY();
//$x1 = $x1+ 150;
$pdf->Line($x1+15, $y1, $x1+15, $y2);
$pdf->Line($x1+150, $y1, $x1+150, $y2);
$pdf->Line($x1+170, $y1, $x1+170, $y2);


// apos listar os movimentos lista saldo final+ debito + credito
$pdf->SetFont('Arial','B',7);
$pdf->Cell(20,$alt,"  ","T",0,"L",0);
$pdf->Cell(130,$alt,"MOVIMENTAÇÃO ","T",0,"L",0);
$pdf->Cell(20,$alt,db_formatar($debitado,'f'),"T",0,"R",0);
$pdf->Cell(20,$alt,db_formatar($creditado,'f'),"T",0,"R",0);
$pdf->Ln();

$pdf->Cell(20,$alt,"",0,0,"L",0);
$pdf->Cell(130,$alt,"SALDO FINAL",0,0,"L",0);
if ($atual > 0 ){
  $pdf->Cell(20,$alt,db_formatar($atual,'f'),0,0,"R",0);
  $pdf->Cell(20,$alt,'',0,0,"R",0);
} else {
  $pdf->Cell(20,$alt,'',0,0,"R",0);
  $pdf->Cell(20,$alt,db_formatar($atual,'f'),0,0,"R",0);
}
$pdf->SetFont('Arial','',7);
$pdf->Ln(10);
//$pdf->Ln();


}
/*
 $pdf->Cell(100,$alt,$x1." / ". $y1." / ". $x1." / ". $y2,0,0,"R",0);
 $pdf->Ln();
 $pdf->Line($x1, $y1, $x1, $y2);
 $pdf->Line($x1+20, $y1, $x1+20, $y2);
 */
$pdf->Output();

?>
