<?
require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
db_app::import("exceptions.*");
db_app::import("configuracao.*");
require_once("model/CgmFactory.model.php");
require_once("model/CgmBase.model.php");
require_once("model/CgmJuridico.model.php");
require_once("model/CgmFisico.model.php");
require_once("model/Dotacao.model.php");
require_once('model/empenho/EmpenhoFinanceiro.model.php');
require_once("libs/db_libcontabilidade.php");

//------------------------------------------------------
//   Arquivos que verificam se o boletim já foi liberado ou naum
require_once("classes/db_boletim_classe.php");
$clverficaboletim = new cl_verificaboletim(new cl_boletim);
//------------------------------------------------------

require_once("libs/db_liborcamento.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_empelemento_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_pagordem_classe.php");
require_once("classes/db_pagordemele_classe.php");
$clpagordem = new cl_pagordem;
$clpagordemele = new cl_pagordemele;
$clempempenho = new cl_empempenho;
$clempelemento = new cl_empelemento;
$clorcdotacao = new cl_orcdotacao;
$clempparamentro = new cl_empparametro;
require_once("libs/db_utils.php");
require_once("classes/ordemPagamento.model.php");
require_once("model/retencaoNota.model.php");

require_once("classes/db_conlancam_classe.php");
require_once("classes/db_conlancamele_classe.php");
require_once("classes/db_conlancampag_classe.php");
require_once("classes/db_conlancamcgm_classe.php");
require_once("classes/db_conparlancam_classe.php");
require_once("classes/db_conlancamemp_classe.php");
require_once("classes/db_conlancamval_classe.php");
require_once("classes/db_conlancamdot_classe.php");
require_once("classes/db_conlancamdoc_classe.php");
require_once("classes/db_conlancamcompl_classe.php");
require_once("classes/db_saltes_classe.php");
require_once("classes/db_conplanoreduz_classe.php");
require_once("classes/db_conlancamlr_classe.php");
require_once("classes/db_conlancamord_classe.php");
require_once("classes/db_empord_classe.php");
require_once("classes/db_empprestaitem_classe.php");

$clconlancam      = new cl_conlancam;
$clconlancamele   = new cl_conlancamele;
$clconlancampag   = new cl_conlancampag;
$clconlancamcompl = new cl_conlancamcompl;
$clconlancamcgm   = new cl_conlancamcgm;
$clconparlancam   = new cl_conparlancam;
$clconlancamemp   = new cl_conlancamemp;
$clconlancamval   = new cl_conlancamval;
$clconlancamdot   = new cl_conlancamdot;
$clconlancamdoc   = new cl_conlancamdoc;
$clsaltes         = new cl_saltes;
$clconplanoreduz  = new cl_conplanoreduz;
$clconlancamord   = new cl_conlancamord;
$clconlancamlr    = new cl_conlancamlr;

require_once("classes/db_cfautent_classe.php");
$clcfautent = new cl_cfautent;

require_once("libs/db_libcaixa.php");
$clautenticar = new cl_autenticar;

require_once("classes/db_empagemov_classe.php");
$clempagemov = new cl_empagemov;

//retorna os arrays de lancamento...
$cltranslan = new cl_translan;

$ip = db_getsession("DB_ip");
$porta = 5001;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);




		try {

		$sqlExcluirOp = "begin;
				create temporary table w_empordem on commit drop as select * from pagordem where  e50_codord = {$e50_codord}; 
				create temporary table w_lancamentos on commit drop
				                                     as select c70_codlan as lancam
				                                          from conlancam
				                                         where c70_codlan in (select c80_codlan from conlancamdoc 
				                                                                join conlancamord on c80_codlan = c71_codlan 
				                                                             where c71_coddoc in (select c53_coddoc 
														    from conhistdoc 
														    where c53_tipo in (30,31,11,21,414,90,92)) 
				 							       and c80_codord in (SELECT e50_codord 
														    FROM w_empordem));
				create temporary table w_chaves on commit drop 
				                                as select k12_id as id , k12_data as data, k12_autent as autent
				                                     from coremp
				                                    where k12_codord in (SELECT e50_codord FROM w_empordem); 
				insert into w_chaves 
				     select k105_id as id , k105_data as data, k105_autent as autent 
				       from corgrupocorrente 
				      where k105_sequencial in (select e47_corgrupocorrente 
				                                  from retencaocorgrupocorrente 
								 where e47_retencaoreceita in (select e23_sequencial 
				                                                                 from retencaoreceitas 
												where e23_retencaopagordem in (select e20_sequencial 
																 from retencaopagordem 
																where e20_pagordem in (SELECT e50_codord 
				                                                                         FROM w_empordem))));
                delete from contacorrentedetalheconlancamval 
				      using w_lancamentos 
				      where c28_conlancamval in (select c69_sequen from conlancamval where c69_codlan in (select lancam from w_lancamentos));			                                                                         
				delete from conlancamlr  
				      using w_lancamentos 
				      where c81_sequen in (select c69_sequen from conlancamval where c69_codlan in (select lancam from w_lancamentos ));
				DELETE FROM conlancamval 
				      using w_lancamentos 
				      where c69_codlan = lancam;
				DELETE FROM conlancamdoc 
				      using w_lancamentos 
				      where c71_codlan = lancam;
				DELETE FROM conlancamcgm 
				      using w_lancamentos 
				      where c76_codlan = lancam;
				DELETE FROM conlancamcorgrupocorrente 
				      using w_lancamentos 
				      where c23_conlancam = lancam ;
				DELETE FROM conlancamdot  
				      using w_lancamentos 
				      where c73_codlan = lancam;
				DELETE FROM conlancamele 
				      using w_lancamentos 
				      where c67_codlan = lancam;
				DELETE FROM conlancamord 
				      using w_lancamentos 
				      where c80_codlan = lancam;
				DELETE FROM conlancampag 
				      using w_lancamentos 
				      where c82_codlan = lancam;
				DELETE FROM conlancamemp 
				      using w_lancamentos 
				      where c75_codlan = lancam;
				DELETE FROM conlancamcompl 
				      using w_lancamentos 
				      where c72_codlan = lancam;
				delete from conlancamnota 
				      using w_lancamentos 
				      where c66_codlan = lancam;
				DELETE FROM pagordemdescontolanc
				      using w_lancamentos 
				      where e33_conlancam = lancam;
				delete from conlancaminstit
				 	  using w_lancamentos 
				      where c02_codlan = lancam;
				delete from conlancamordem
				      using w_lancamentos 
				      where c03_codlan = lancam;
				DELETE FROM conlancam 
				      using w_lancamentos 
				      where c70_codlan = lancam;
				delete from retencaocorgrupocorrente 
				      where e47_retencaoreceita in (select e23_sequencial 
				       						          from retencaoreceitas 
				       						         where e23_retencaopagordem in (select e20_sequencial 
				       						         								  from retencaopagordem 
				       						         								 where e20_pagordem in (SELECT e50_codord FROM w_empordem)));
				delete from retencaoempagemov 
					  where e27_retencaoreceitas in (select e23_sequencial 
					  								   from retencaoreceitas 
					  								  where e23_retencaopagordem in (select e20_sequencial 
					  								  								   from retencaopagordem 
					  								  								  where e20_pagordem in (SELECT e50_codord FROM w_empordem)));
				delete from retencaoreceitas 
					  where e23_sequencial in (select e23_sequencial 
					  							 from retencaoreceitas 
					  							where e23_retencaopagordem in (select e20_sequencial 
					  															 from retencaopagordem 
					  															where e20_pagordem in (SELECT e50_codord FROM w_empordem)));
				delete from retencaopagordem where e20_pagordem in (SELECT e50_codord FROM w_empordem);
				drop table w_lancamentos;
				create temporary table w_lancamentos on commit drop
				                                     as select c70_codlan as lancam
				                                          from conlancam
				                                         where c70_codlan in (SELECT c86_conlancam 
				                                         						FROM conlancamcorrente 
				                                         						join w_chaves on c86_id = id 
				                                         						 and c86_data = data 
				                                         						 and c86_autent = autent);
                delete from contacorrentedetalheconlancamval 
				      using w_lancamentos 
				      where c28_conlancamval in (select c69_sequen from conlancamval where c69_codlan in (select lancam from w_lancamentos));
				DELETE FROM conlancamval 
				      using w_lancamentos 
				      where c69_codlan = lancam;
				DELETE FROM conlancamdoc 
				      using w_lancamentos 
				      where c71_codlan = lancam;
				DELETE FROM conlancamcgm 
				      using w_lancamentos 
				      where c76_codlan = lancam;
				DELETE FROM conlancamcorgrupocorrente 
				      using w_lancamentos 
				      where c23_conlancam = lancam ;
				DELETE FROM conlancamdot  
				      using w_lancamentos 
				      where c73_codlan = lancam;
				DELETE FROM conlancamele 
				      using w_lancamentos 
				      where c67_codlan = lancam;
				DELETE FROM conlancamord 
				      using w_lancamentos 
				      where c80_codlan = lancam;
				DELETE FROM conlancampag 
				      using w_lancamentos 
				      where c82_codlan = lancam;
				DELETE FROM conlancamemp 
				      using w_lancamentos 
				      where c75_codlan = lancam;
				DELETE FROM conlancamcompl 
				      using w_lancamentos where c72_codlan = lancam;
				DELETE FROM conlancamconcarpeculiar
				      using w_lancamentos where c08_codlan = lancam;
				delete from conlancamcorrente
				      using w_chaves
				      where c86_id     = id 
				        and c86_data   = data 
				        and c86_autent = autent;
				delete from conlancamrec
				      using w_lancamentos 
				      where c74_codlan = lancam;
				delete from conlancaminstit
				 	  using w_lancamentos 
				      where c02_codlan = lancam;
				delete from conlancamordem
				      using w_lancamentos 
				      where c03_codlan = lancam;
				DELETE FROM conlancam 
				      using w_lancamentos 
				      where c70_codlan = lancam;
				delete from corconf  
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from corlanc  
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from corempagemov 
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from coremp 
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from cornump 
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from retencaocorgrupocorrente 
				      where e47_corgrupocorrente in (select k105_sequencial 
								       from corgrupocorrente 
				                                       join w_chaves on k105_data = data 
				                                        and k105_autent = autent 
								        and k105_id = id);
				delete from corgrupocorrente 
				      using w_chaves 
				      where k105_id     = id 
				        and k105_data   = data 
				        and k105_autent = autent;
				delete from corautent
				      using w_chaves
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from corhist
				      using w_chaves
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				delete from corrente 
				      using w_chaves 
				      where k12_id     = id 
				        and k12_data   = data 
				        and k12_autent = autent;
				create temporary table w_mov on commit drop
				                                     as select e82_codmov from empord where e82_codord in (SELECT e50_codord FROM w_empordem);
				
				DELETE FROM corconf where k12_codmov in (select e91_codcheque from empageconfche where e91_codmov in (select e82_codmov from w_mov));
				DELETE FROM empageconfche where e91_codmov in (select e82_codmov from w_mov);
				DELETE FROM retencaoempagemov where e27_empagemov in (select e82_codmov from w_mov);
				DELETE FROM empageconfgera where e90_codmov in (select e82_codmov from w_mov);
				DELETE FROM corempagemov where k12_codmov in (select e82_codmov from w_mov);
				DELETE FROM empagenotasordem where e43_empagemov in (select e82_codmov from w_mov);
				DELETE FROM empagemovslips where k107_empagemov in (select e82_codmov from w_mov);
				DELETE FROM empagemovconta where e98_codmov in (select e82_codmov from w_mov);
				
				
				UPDATE empelemento 
				   SET e64_vlrpag = (select  round(sum(case when c71_coddoc in (select c53_coddoc 
				   																  from conhistdoc 
				   																 where c53_tipo in (31)) then c70_valor * -1 else c70_valor end),2) as valor	                   
						    from conlancamemp                       
					      inner join conlancam on c70_codlan = c75_codlan									     
					left  outer join conlancampag on c82_codlan = c70_codlan 									     
					      inner join conlancamdoc on c71_codlan   = c70_codlan and 	c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (30,31))							     
					      inner join conhistdoc on c53_coddoc     = c71_coddoc									     
					       left join conlancamcompl on c72_codlan  =c70_codlan									     
					       left join conlancamnota  on c66_codlan  =c70_codlan									     
					       left join conlancamord   on c80_codlan  =c70_codlan									     
					       left join empnota        on c66_codnota = e69_codnota							         
					       left join conplanoreduz on c61_reduz = conlancampag.c82_reduz and c61_anousu=c70_anousu	
					       left join conplano on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=c61_anousu	
					       left join pagordem     on e50_codord  = c80_codord             
						   where  c75_numemp = (select e50_numemp from pagordem where e50_codord in (SELECT e50_codord FROM w_empordem))) 
				 WHERE e64_numemp in (select e50_numemp from pagordem where e50_codord in(SELECT e50_codord FROM w_empordem));
				 
				UPDATE empempenho 
				   SET e60_vlrpag = (select case when round(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (31)) then c70_valor * -1 
									  else c70_valor end),2) is null then 0 
						      else round(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (31)) then c70_valor * -1 
									  else c70_valor end),2) end as valor	                   
				            from conlancamemp                       
				      inner join conlancam on c70_codlan = c75_codlan									     
				left  outer join conlancampag on c82_codlan = c70_codlan 									     
				      inner join conlancamdoc on c71_codlan   = c70_codlan 
					     and c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (30,31))							     
				      inner join conhistdoc on c53_coddoc     = c71_coddoc									     
				       left join conlancamcompl on c72_codlan  =c70_codlan									     
				       left join conlancamnota  on c66_codlan  =c70_codlan									     
				       left join conlancamord   on c80_codlan  =c70_codlan									     
				       left join empnota        on c66_codnota = e69_codnota							         
				       left join conplanoreduz on c61_reduz = conlancampag.c82_reduz and c61_anousu=c70_anousu	
				       left join conplano on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=c61_anousu	
				       left join pagordem     on e50_codord  = c80_codord             
				           where  c75_numemp = (select e50_numemp from pagordem 
                                           where e50_codord in (SELECT e50_codord FROM w_empordem))) 
				 WHERE e60_numemp in (select e50_numemp from pagordem where e50_codord =(SELECT e50_codord FROM w_empordem));
				 UPDATE pagordemele 
				   SET e53_vlrpag = (select case when round(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (31)) then c70_valor * -1 
									  else c70_valor end),2) is null then 0 
						      else round(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (31)) then c70_valor * -1 
									  else c70_valor end),2) end as valor	                   
				            from conlancamemp                       
				      inner join conlancam on c70_codlan = c75_codlan									     
				left  outer join conlancampag on c82_codlan = c70_codlan 									     
				      inner join conlancamdoc on c71_codlan   = c70_codlan 
					     and c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (30,31))							     
				      inner join conhistdoc on c53_coddoc     = c71_coddoc									     
				       left join conlancamcompl on c72_codlan  =c70_codlan									     
				       left join conlancamnota  on c66_codlan  =c70_codlan									     
				       left join conlancamord   on c80_codlan  =c70_codlan									     
				       left join empnota        on c66_codnota = e69_codnota							         
				       left join conplanoreduz on c61_reduz = conlancampag.c82_reduz and c61_anousu=c70_anousu	
				       left join conplano on c60_codcon = conplanoreduz.c61_codcon and c60_anousu=c61_anousu	
				       left join pagordem     on e50_codord  = c80_codord             
				           where  c75_numemp = (select e50_numemp from pagordem 
                                           where e50_codord in (SELECT e50_codord FROM w_empordem))) 
				 WHERE e53_codord in (select e50_numemp from pagordem where e50_codord in(SELECT e50_codord FROM w_empordem));
				 
				 update pagordemele set e53_vlrpag = 0 where e53_codord in(SELECT e50_codord FROM w_empordem);
				 update empageconf set e86_data = (select e50_data from pagordem where e50_codord = {$e50_codord} limit 1) 
				  where e86_codmov in (select e82_codmov from empord where e82_codord = {$e50_codord});
				 update empagemov set e81_codage = (select e80_codage from empage where e80_instit = ".db_getsession("DB_instit")." and e80_data = (select e50_data from pagordem where e50_codord = {$e50_codord} limit 1) ) 
                  where e81_codmov in (select e82_codmov from empord where e82_codord = {$e50_codord});
				commit;
				";
				//echo pg_last_error();exit;
		      /*DELETE FROM empord where e82_codmov in (select e82_codmov from w_mov);
				DELETE FROM empageconf where e86_codmov in (select e82_codmov from w_mov);
				DELETE FROM empagemovforma  where e97_codmov in (select e82_codmov from w_mov);
				DELETE FROM empagepag where e85_codmov in (select e82_codmov from w_mov);
				DELETE FROM empageconcarpeculiar where e79_empagemov in (select e82_codmov from w_mov);
		        DELETE FROM empagemov where e81_codmov	 in (select e82_codmov from w_mov);
		       */
	    
		    //echo $sqlExcluirOp;exit;
	  	
	  	    $sqlOpPaga = "select c71_data as datapag 
	  	    				from conlancamdoc 
	  	    				join conlancamord on c80_codlan = c71_codlan 
	  	    				where c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo in (30)) 
	  	    				  and c80_codord = {$e50_codord} limit 1";
	  	    $rsSqlOpPaga = db_query($sqlOpPaga);
	  	    
	  	    if(pg_num_rows($rsSqlOpPaga) > 0){
		  	    
	  	    	$DtPagamento  = db_utils::fieldsMemory($rsSqlOpPaga, 0)->datapag;
	  	    	
	  	    	$sqlMesFechado = "SELECT * FROM condataconf  where c99_anousu = ".db_getsession("DB_anousu")." and c99_data >= '{$DtPagamento}'";
	  	    	
	  	    	$rsSqlMesFechado = db_query($sqlMesFechado);
	  	        
		  	    if(pg_num_rows($rsSqlMesFechado) > 0){
		        	
			        echo "<script> alert('Autenticação não excluída EXISTE ENCERRAMENTO de periodo contabil para esta data!');</script>";
			        
			        db_redireciona('emp1_emppagamentoexcluirpagamento001.php');
			        
		  	    }else{
		  	    	$rsExluirPagOp = db_query($sqlExcluirOp);
		  	    	
					    if ($rsExluirPagOp == false) {
					    	echo "<script> alert('Houve um erro ao excluir o pagamento!');</script>";
			          db_redireciona('emp1_emppagamentoexcluirpagamento001.php');
					    } else {
			          echo "<script> alert('Pagamento excluído com sucesso!');</script>";
			          db_redireciona('emp1_emppagamentoexcluirpagamento001.php');
					    }
		  	    }
		        
	  	    }else{
	  	    	echo "<script> alert('Ordem de Pagamento ainda não autenticada!');</script>";
		        
		        db_redireciona('emp1_emppagamentoexcluirpagamento001.php');
	  	    }
	        
	      } catch (Exception $erro) {
	
	        echo "<script> alert('Pagamento NÃO excluído!');</script>";
	        
	        db_redireciona('emp1_emppagamentoexcluirpagamento001.php');
	      }