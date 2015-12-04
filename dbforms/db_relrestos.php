<?
/*
 *  ------------------------------------------------------------------------
 *  funчуo auxiliar para montar sql do relatorio de RP 
 * 
 */
function sql_rp($anousu="",$instit="1",$dtini="",$dtfim="",$sql_where="",$sql_where_externo,$order="") {
     $where_datas = "";
     if ($dtini ==""){
     	$where_datas = "  <  '$dtfim'  "; 
     }	else {
     	 $where_datas = " between '$dtini' and '$dtfim' ";
     }	
	$sqlperiodo = "
	select  
	    e91_numemp, e91_vlremp,e91_vlranu,e91_vlrliq,e91_vlrpag,e91_recurso,o15_descr,
	    vlranu,vlrliq,vlrpag,e91_codtipo,e90_descr,
	    z01_nome,e60_numemp,e60_codemp,e60_emiss,e60_anousu
	from (
	  select 
	       e91_numemp,e91_codtipo,e90_descr,o15_descr,
           coalesce(e91_vlremp,0) as e91_vlremp, 
           coalesce(e91_vlranu,0) as e91_vlranu,
           coalesce(e91_vlrliq,0)  as e91_vlrliq,
           coalesce(e91_vlrpag,0) as e91_vlrpag,
           e91_recurso,
	       coalesce(vlranu,0) as vlranu,
           coalesce(vlrliq,0) as  vlrliq,
           coalesce(vlrpag,0) as vlrpag
	  from empresto
	       inner join emprestotipo on e91_codtipo = e90_codigo
	       inner join orctiporec on e91_recurso = o15_codigo
	       left outer join (
		     select c75_numemp,
		         sum( case when c53_tipo = 11 then c70_valor else 0 end) as vlranu,
		         sum( case when c53_tipo = 20 then c70_valor else ( case when c53_tipo = 21 then c70_valor*-1 else  0 end) end) as vlrliq,
		         sum( case when c53_tipo = 30 then c70_valor else ( case when c53_tipo = 31 then c70_valor*-1 else  0 end) end) as vlrpag
		     from conlancamemp
		         inner join conlancamdoc on c71_codlan = c75_codlan
		         inner join conhistdoc on c53_coddoc = c71_coddoc
		         inner join conlancam on c70_codlan = c75_codlan
		         inner join empempenho on e60_numemp = c75_numemp
		     where e60_anousu < ".$anousu." and c75_data $where_datas
		          and $instit
		     group by c75_numemp
	       ) as x on x.c75_numemp = e91_numemp
	       where e91_anousu = ".$anousu." $sql_where
	   ) as x
	      inner join empempenho on e60_numemp = e91_numemp
	      inner join cgm on z01_numcgm = e60_numcgm
       $sql_where_externo
       $order
	";
   return $sqlperiodo;
}
?>