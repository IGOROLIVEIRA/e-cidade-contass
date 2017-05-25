<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ext102017_classe.php");
require_once ("classes/db_ext202017_classe.php");
require_once ("classes/db_ext302017_classe.php");
require_once ("classes/db_ext312017_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2017/GerarEXT.model.php");

 /**
  * Detalhamento Extra Ocamentarias Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoExtraOrcamentariasPorFonte extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 171;
  
  /**
   * 
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'EXT';
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
    
  }
  
  /**
   * selecionar os dados de //
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
  	
  	$cExt10 = new cl_ext102017();
  	$cExt20 = new cl_ext202017();
  	$cExt30 = new cl_ext302017();
  	$cExt31 = new cl_ext312017();

  	/*
  	 * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA 
  	 * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	 * 
  	 */

  	     
  	    db_inicio_transacao();


	      $cExt31->excluir(NULL,"si127_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
	    								and si127_instit = ".db_getsession("DB_instit"));
	      if ($cExt31->erro_status == 0) {
	    	  throw new Exception($cExt31->erro_msg);
	      }

	      $cExt30->excluir(NULL,"si126_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si126_instit = ".db_getsession("DB_instit"));

	      if ($cExt30->erro_status == 0) {
	    	  throw new Exception($cExt31->erro_msg);
	      }
	      $cExt20->excluir(NULL,"si165_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
	    								and si165_instit = ".db_getsession("DB_instit"));

	      if ($cExt20->erro_status == 0) {
	    	  throw new Exception($cExt20->erro_msg);
	      }
	      $cExt10->excluir(NULL,"si124_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
	    								and si124_instit = ".db_getsession("DB_instit"));
		  if ($cExt10->erro_status == 0) {
		    	  throw new Exception($cExt10->erro_msg);
		  }

	   echo pg_last_error();

	   db_fim_transacao();

	   $sSqlRespPGTO = "select z01_cgccpf from identificacaoresponsaveis join cgm on si166_numcgm = z01_numcgm where si166_tiporesponsavel = 1";
	   $rsResponsalvelPgto = db_query($sSqlRespPGTO);
	   $cpfRespPGTO = db_utils::fieldsMemory($rsResponsalvelPgto)->z01_cgccpf;;
  	    /*
  	     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
  	     *
  	     */
  	    $sSqlExt = "select 10 as tiporegistro,c61_codcon,
				       c61_reduz as codext,
				       c61_codtce as codtce,
				       si09_codorgaotce as codorgao,
				       COALESCE(c60_tipolancamento,0) as tipolancamento,
				       COALESCE(c60_subtipolancamento,0) as subtipo,
				       COALESCE(c60_desdobramneto,0) as desdobrasubtipo,
				       substr(c60_descr,1,50) as descextraorc
				  from conplano
				  inner join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
				   left join infocomplementaresinstit on si09_instit = c61_instit
				  where c60_anousu = ".db_getsession("DB_anousu")." and c60_codsis = 7 and c61_instit = ".db_getsession("DB_instit")."
  				order by c61_reduz  ";

  	    $rsContasExtra = db_query($sSqlExt) or die($sSqlExt);
		//db_criatabela($rsContasExtra);
	    // matriz de entrada
    	$what = array("°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô',
    			'ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    	// matriz de saída
    	$by   = array('','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u',
    			'u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );


	    /*
	     * PERCORRE OS SQL PARA INSERIR NA BASE DE DADOS OS REGISTROS
	     */
	    db_inicio_transacao();


	    $aExt10Agrupodo = array();
	    for ($iCont10 = 0;$iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

	    	$oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont10);

	       		$aHash  = $oContaExtra->codorgao;
	       		$aHash .= $oContaExtra->tipolancamento;
	       		$aHash .= $oContaExtra->subtipo;
	       		$aHash .= $oContaExtra->desdobrasubtipo;




	       		if( !isset($aExt10Agrupodo[$aHash]) ){

					$cExt10 = new cl_ext102017();

		       		$cExt10->si124_tiporegistro     = $oContaExtra->tiporegistro;
		       		$cExt10->si124_codext  			= $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
		       		$cExt10->si124_codorgao 		= $oContaExtra->codorgao;
		       		$cExt10->si124_tipolancamento 	= substr(str_pad($oContaExtra->tipolancamento, 2, "0", STR_PAD_LEFT), 0, 2);
		       		$cExt10->si124_subtipo 			= substr(str_pad($oContaExtra->subtipo, 4, "0", STR_PAD_LEFT), 0, 4);
                	$cExt10->si124_desdobrasubtipo 	= substr(str_pad($oContaExtra->desdobrasubtipo, 4, "0", STR_PAD_LEFT), 0, 4);
		       		$cExt10->si124_descextraorc 	= $oContaExtra->descextraorc;
		       		$cExt10->si124_mes				= $this->sDataFinal['5'].$this->sDataFinal['6'];
		       		$cExt10->si124_instit			= db_getsession("DB_instit");
		       		$cExt10->extras					= array();

					/*
					 * VERIFICA SE NO EM ALGUMA REMESSA ENVIADA O CODEXT FOI IMFORMADO, CASO NÃO TENHA ENCONTRATO CRIA UM NOVO
					 */
          $sSqlVerifica  = "SELECT 1
                                        FROM ext102017
                                 WHERE si124_codorgao        = '".$oContaExtra->codorgao."'
                                   AND si124_tipolancamento  = '".$oContaExtra->tipolancamento."'
                                   AND si124_subtipo         = '".$oContaExtra->subtipo."'
                                   AND si124_desdobrasubtipo = '". $oContaExtra->desdobrasubtipo ."'
                                   AND si124_mes             < ".$this->sDataFinal['5'].$this->sDataFinal['6'];
					$sSqlVerifica  .= " UNION ALL 
                                SELECT 1
                                        FROM ext102016
		       		                   WHERE si124_codorgao        = '".$oContaExtra->codorgao."'
		       		                     AND si124_tipolancamento  = '".$oContaExtra->tipolancamento."'
		       		                     AND si124_subtipo         = '".$oContaExtra->subtipo."'
		       		                     AND si124_desdobrasubtipo =  '". $oContaExtra->desdobrasubtipo ."' ";
		       		$sSqlVerifica  .= " UNION ALL
									  SELECT 1
                                        FROM ext102015
		       		                   WHERE si124_codorgao        = '".$oContaExtra->codorgao."'
		       		                     AND si124_tipolancamento  = '".$oContaExtra->tipolancamento."'
		       		                     AND si124_subtipo         = '".$oContaExtra->subtipo."'
		       		                     AND si124_desdobrasubtipo =  '". $oContaExtra->desdobrasubtipo ."' ";
		       		$sSqlVerifica .= " UNION ALL
		       		                  SELECT 1 FROM ext102014
		       		                   WHERE si124_codorgao        = '".$oContaExtra->codorgao."'
		       						     AND si124_tipolancamento  = '".$oContaExtra->tipolancamento."'
		       							 AND si124_subtipo         = '".$oContaExtra->subtipo."'
		       							 AND si124_desdobrasubtipo = '". $oContaExtra->desdobrasubtipo ."' ";

		       		$rsResulVerifica = db_query($sSqlVerifica) or die ($sSqlVerifica);

		       		if ((pg_num_rows($rsResulVerifica) == 0) || (pg_num_rows($rsResulVerifica) != 0 && $this->sDataFinal['5'].$this->sDataFinal['6'] == 1)  ) {

		       			$cExt10->incluir(null);

			       	    if ($cExt10->erro_status == 0) {
				    	      throw new Exception($cExt10->erro_msg);
						}

		       		}

				    $cExt10->extras[]= $oContaExtra->codext;
				    $aExt10Agrupodo[$aHash] = $cExt10;

	       		}else{
	       		   $aExt10Agrupodo[$aHash]->extras[] = $oContaExtra->codext;
	       		}
	    }
	    $aExt20 = array();
	    foreach ($aExt10Agrupodo as $oExt10Agrupado) {

	    	foreach ($oExt10Agrupado->extras as $nExtras) {

				/*
				 * pegar todas as fontes de recursos movimentadas para cada codext
				 */
				$sSql20Fonte  = "   SELECT DISTINCT codext,fonte  from (
   								    select c61_reduz  as codext,0 as contrapart,o15_codigo as fonte
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$nExtras})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 union all
							        select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
									  from conextsaldo
								inner join conplanoreduz on conextsaldo.ces01_reduz = conplanoreduz.c61_reduz
								       and conplanoreduz.c61_anousu = conextsaldo.ces01_anousu
									 where conextsaldo.ces01_reduz  in ({$nExtras})
									   and conextsaldo.ces01_anousu = ".db_getsession("DB_anousu")."
								 union all
									SELECT  conlancamval.c69_credito AS codext,
									        conlancamval.c69_debito as contrapart,
											  orctiporec.o15_codigo AS fonte
									  FROM conlancamdoc
								INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
								INNER JOIN conplanoreduz ON conlancamval.c69_debito = conplanoreduz.c61_reduz
									   AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
								INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
								INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
								INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
								 LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
									 WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
									   and conlancamval.c69_credito in ({$nExtras})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = ".db_getsession("DB_anousu")."
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= ".$this->sDataFinal['5'].$this->sDataFinal['6']."
									   and conlancaminstit.c02_instit = ".db_getsession("DB_instit")."
								 union all
									SELECT conlancamval.c69_debito AS codext,
									       conlancamval.c69_credito as contrapart,
												orctiporec.o15_codigo AS fonte
									  FROM conlancamdoc
								INNER JOIN conlancamval ON conlancamval.c69_codlan = conlancamdoc.c71_codlan
								INNER JOIN conplanoreduz ON conlancamval.c69_credito = conplanoreduz.c61_reduz
									   AND conlancamval.c69_anousu = conplanoreduz.c61_anousu
								INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo
								INNER JOIN conlancaminstit ON conlancaminstit.c02_codlan = conlancamval.c69_codlan
								INNER JOIN conlancamcorrente ON conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
								 LEFT JOIN infocomplementaresinstit ON infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
									 WHERE conlancamdoc.c71_coddoc IN (120,121,130,131,150,151,152,153,160,161,162,163)
									   and conlancamval.c69_debito in ({$nExtras})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = ".db_getsession("DB_anousu")."
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= ".$this->sDataFinal['5'].$this->sDataFinal['6']."
									   and conlancaminstit.c02_instit = ".db_getsession("DB_instit")."
								  ) as extfonte order by codext,fonte";

				$rsExt20FonteRecurso = db_query($sSql20Fonte);// or die($sSql20Fonte);
				//echo "Movimento";db_criatabela($rsExt20FonteRecurso);
				for ($iC = 0;$iC < pg_num_rows($rsExt20FonteRecurso); $iC++) {
					$Hash20 = '';
					$oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iC);

					$sSqlSaldoFonte = " select round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),28,13)::float8,2)::float8 as saldo_anterior,
											   round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),42,13)::float8,2)::float8 as debitomes,
											   round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),56,13)::float8,2)::float8 as creditomes,
											   round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),70,13)::float8,2)::float8 as saldo_final,
											   substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),83,1)::varchar(1) as  sinalanterior,
											   substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),85,1)::varchar(1) as  sinalfinal ";

					$rsExtSaldoFonteRecurso   = db_query($sSqlSaldoFonte);
					//echo "Saldo ".$oContaExtraFonte->codext."-".$oContaExtraFonte->fonte."<br>".$sSqlSaldoFonte."<br> [si165_codext] => ".$oExt10Agrupado->si124_codext." -".$oContaExtraFonte->fonte;
					//db_criatabela($rsExtSaldoFonteRecurso);
					$saldoanteriorabs         = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->saldo_anterior;
					$oExtRecurso              = $oContaExtraFonte->fonte;
					$natsaldoanteriorfonte    = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->sinalanterior;
					$saldofinalabs            = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->saldo_final;
					$natsaldoatualfonte       = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->sinalfinal;
					$saldodebito              = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->debitomes;
                    $saldocredito			  = db_utils::fieldsMemory($rsExtSaldoFonteRecurso)->creditomes;
					$saldoanterior            = $natsaldoanteriorfonte == 'C' ? ($saldoanteriorabs == '' ? 0 : $saldoanteriorabs) * -1 : ($saldoanteriorabs == '' ? 0 : $saldoanteriorabs);
					$saldofinal               = $natsaldoatualfonte == 'C' ? ($saldofinalabs == '' ? 0 : $saldofinalabs) * -1 : ($saldofinalabs == '' ? 0 : $saldofinalabs);

					/* SQL RETORNA O CODTRI DA FONTE */
					$sSqlExtRecurso = "select o15_codtri
                                         from orctiporec
	        						    where o15_codigo = ". $oExtRecurso;
					$rsExtRecurso = db_query($sSqlExtRecurso);
					$oExtRecursoTCE = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri;

					$Hash20 = "20".$oExt10Agrupado->si124_codorgao.$oExt10Agrupado->si124_codext.$oExtRecursoTCE;
					//echo $Hash20."<br>";
					if(!isset($aExt20[$Hash20])){

						$cExt20   = new stdClass();

						$cExt20->si165_tiporegistro          = '20';
						$cExt20->si165_codorgao 			 = $oExt10Agrupado->si124_codorgao;
						$cExt20->si165_codext                = $oExt10Agrupado->si124_codext;
						$cExt20->si165_codfontrecursos       = $oExtRecursoTCE;
						$cExt20->si165_vlsaldoanteriorfonte  = $saldoanterior;
						$cExt20->si165_vlsaldoatualfonte     = $saldofinal;
						$cExt20->si165_totaldebitos          = $saldodebito;
						$cExt20->si165_totalcreditos         = $saldocredito;
						$cExt20->si165_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
						$cExt20->si165_instit                = db_getsession("DB_instit");
						$cExt20->ext30                       = array();
						$aExt20[$Hash20]                     = $cExt20;
					}else{

						$aExt20[$Hash20]->si165_vlsaldoanteriorfonte  += $saldoanterior;
						$aExt20[$Hash20]->si165_vlsaldoatualfonte     += $saldofinal;
						$aExt20[$Hash20]->si165_totaldebitos          += $saldodebito;
						$aExt20[$Hash20]->si165_totalcreditos         += $saldocredito;
						//$cExt20                                        = $aExt20[$Hash20];

					}

					/**
                     * CARREGA OS DADOS DO REGISTRO 30
                     */
					$sSqlMov = "select conlancamdoc.c71_codlan as codreduzidomov,
							   case when conplanoreduz.c61_codtce !=0 then conplanoreduz.c61_codtce else conplanoreduz.c61_reduz end as codext,
							   orctiporec.o15_codtri as codfontrecursos,
							   '2' as categoria,
							   conlancamval.c69_data as dtLancamento,
							   c69_valor as vllancamento,
							   conlancamcorrente.c86_id as id,
							   conlancamcorrente.c86_data as data,
							   conlancamcorrente.c86_autent as autent,
							   conlancamval.c69_credito as contapagadora
						  from conlancamval
					inner join conlancamdoc on conlancamdoc.c71_codlan = conlancamval.c69_codlan
					inner join conlancamcorrente on  conlancamval.c69_codlan = conlancamcorrente.c86_conlancam
					inner join conplanoreduz on conplanoreduz.c61_reduz = conlancamval.c69_credito
					inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
						   and conplanoreduz.c61_anousu = conlancamval.c69_anousu
						 where conlancamdoc.c71_coddoc in (120,151,161)
						   and conlancamval.c69_debito = {$nExtras}
						   and DATE_PART('YEAR',conlancamval.c69_data) = " . db_getsession("DB_anousu") . "
						   and DATE_PART('MONTH',conlancamval.c69_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
						   and orctiporec.o15_codigo = {$oExtRecurso}";

					$rsExtMov = db_query($sSqlMov);
					//echo "Reg30";db_criatabela($rsExtMov);
					/*FOR PARA PEGAR O REGISTRO 21 E COLOCAR NO 20*/
					for ($linha = 0; $linha < pg_num_rows($rsExtMov); $linha++) {

						$oExtMov = db_utils::fieldsMemory($rsExtMov, $linha);

						     $sSql30 = "SELECT '30' as tiporegistro,
												e91_codcheque,
											   c86_data as dtpagamento,
											   (SELECT coalesce(c86_conlancam, 0)
												  FROM conlancamcorrente
												 WHERE c86_id = corrente.k12_id
												   AND c86_data = corrente.k12_data
												   AND c86_autent = corrente.k12_autent) as codreduzidomov,
											   (slip.k17_codigo||slip.k17_debito)::int8 as codreduzidoop,
											   (slip.k17_codigo||slip.K17_debito)::int8 as nroop,
										   case when length(cc.z01_cgccpf::varchar) = 11 then 1 else 2 end as tipodocumentocredor,
										   cc.z01_cgccpf as nrodocumentocredor,
										   k17_valor as vlop,
										   k17_texto as especificacaoop,
										   slip.k17_credito as contapagadora,
										   orctiporec.o15_codtri as fontepagadora,
										   (select CASE WHEN o41_subunidade != 0
										                  OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
														  OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
															              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
															    ELSE lpad((CASE WHEN o40_codtri = '0'
															         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
															           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
													 end as unidade
												   from orcunidade
												   join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
												   where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codunidadesub
										  FROM corlanc
									INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id
										   AND corlanc.k12_data = corrente.k12_data
										   AND corlanc.k12_autent = corrente.k12_autent
									inner join slip on slip.k17_codigo = corlanc.k12_codigo
									inner join conplanoreduz on slip.k17_credito = conplanoreduz.c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
									inner join orctiporec on orctiporec.o15_codigo = conplanoreduz.c61_codigo
									inner join slipnum on slipnum.k17_codigo = slip.k17_codigo
									inner join cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
									 LEFT JOIN corconf ON corlanc.k12_id = corconf.k12_id
										   AND corlanc.k12_data = corconf.k12_data
										   AND corlanc.k12_autent = corconf.k12_autent										   
									 LEFT JOIN empageconfche ON k12_codmov = e91_codcheque
									 LEFT JOIN empagemovforma ON e91_codmov = e97_codmov
									 LEFT JOIN empageforma ON e97_codforma = e96_codigo
									 LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id
										   AND conlancamcorrente.c86_data = corrente.k12_data
										   AND conlancamcorrente.c86_autent = corrente.k12_autent
										 WHERE c86_id     = {$oExtMov->id}
										   AND c86_data   = '{$oExtMov->data}'
										   AND c86_autent = {$oExtMov->autent} ";

							    $rsExt30 = db_query($sSql30) or die($sSql30);
								//db_criatabela($rsExt30);
								for ($linha30 = 0; $linha30 < pg_num_rows($rsExt30); $linha30++) {

									$oExt30 = db_utils::fieldsMemory($rsExt30, $linha30);

									$Hash30 = $oExt10Agrupado->si124_codext.$oExt30->codfontrecursos.$oExt30->nroop.$oExt30->codunidadesub;

									if(!isset($aExt20[$Hash20]->ext30[$Hash30])){

										$cExt30 = new stdClass();

										$cExt30->si126_tiporegistro        = '30';
										$cExt30->si126_codext              = $oExt10Agrupado->si124_codext;
										$cExt30->si126_codfontrecursos     = $oExt30->fontepagadora;
										$cExt30->si126_codreduzidoop       = $oExt30->codreduzidoop;
										$cExt30->si126_nroop               = $oExt30->nroop;
										$cExt30->si126_codunidadesub       = $oExt30->codunidadesub;
										$cExt30->si126_dtpagamento         = $oExt30->dtpagamento;
										$cExt30->si126_tipodocumentocredor = $oExt30->tipodocumentocredor;
										$cExt30->si126_nrodocumentocredor  = $oExt30->nrodocumentocredor;
										$cExt30->si126_vlop                = $oExt30->vlop;
										$cExt30->si126_especificacaoop     = trim(preg_replace("/[^a-zA-Z0-9 ]/", "", substr(str_replace($what, $by, $oExt30->especificacaoop), 0, 200)));
										$cExt30->si126_cpfresppgto         = $cpfRespPGTO;
										$cExt30->si126_mes                 = $this->sDataFinal['5'] . $this->sDataFinal['6'];
										$cExt30->si126_instit              = db_getsession("DB_instit");
										$cExt30->ext31                     = array();
										$aExt20[$Hash20]->ext30[$Hash30]   = $cExt30;

									}else{
										$aExt20[$Hash20]->ext30[$Hash30]->si126_vlop                += $oExt30->vlop;
									}
									$sSqlContaPagFont = "select distinct si95_codctb  as conta, si96_codfontrecursos as fonte from conplanoconta
														      inner join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
														      inner join ctb102015 on si95_banco   = c63_banco
														             and si95_agencia = c63_agencia
														             and si95_digitoverificadoragencia = c63_dvagencia
														             and si95_contabancaria = (c63_conta::varchar||".'0'.")::int8
														             and si95_digitoverificadorcontabancaria = c63_dvconta
														             and si95_tipoconta::int8 = c63_tipoconta
														      inner join ctb202015 on si96_codctb = si95_codctb
														             and si96_mes = si95_mes
														             and si96_codfontrecursos = {$oExt30->fontepagadora}
														           where c61_reduz = {$oExt30->contapagadora}
														             and c61_anousu = " . db_getsession("DB_anousu") . "
														             and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
									$rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont);
									//echo $sSqlContaPagFont;exit;
									//db_criatabela($rsResultContaPag);
									if(pg_num_rows($rsResultContaPag) == 0) {
										$sSqlContaPagFont = "select distinct si95_codctb  as conta, si96_codfontrecursos as fonte from conplanoconta
														      inner join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
														      inner join ctb102016 on si95_banco   = c63_banco
														             and si95_agencia = c63_agencia
														             and si95_digitoverificadoragencia = c63_dvagencia
														             and si95_contabancaria = (c63_conta::varchar||" . '0' . ")::int8
														             and si95_digitoverificadorcontabancaria = c63_dvconta
														             and si95_tipoconta::int8 = c63_tipoconta
														      inner join ctb202016 on si96_codctb = si95_codctb
														             and si96_mes = si95_mes
														             and si96_codfontrecursos = {$oExt30->fontepagadora}
														           where c61_reduz = {$oExt30->contapagadora}
														             and c61_anousu = " . db_getsession("DB_anousu") . "
														             and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
										$rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont);
									}
                  if(pg_num_rows($rsResultContaPag) == 0) {
                    $sSqlContaPagFont = "select distinct si95_codctb  as conta, si96_codfontrecursos as fonte from conplanoconta
                                  inner join conplanoreduz on c61_codcon = c63_codcon and c61_anousu = c63_anousu
                                  inner join ctb102017 on si95_banco   = c63_banco
                                         and si95_agencia = c63_agencia
                                         and si95_digitoverificadoragencia = c63_dvagencia
                                         and si95_contabancaria = (c63_conta::varchar||" . '0' . ")::int8
                                         and si95_digitoverificadorcontabancaria = c63_dvconta
                                         and si95_tipoconta::int8 = c63_tipoconta
                                  inner join ctb202017 on si96_codctb = si95_codctb
                                         and si96_mes = si95_mes
                                         and si96_codfontrecursos = {$oExt30->fontepagadora}
                                       where c61_reduz = {$oExt30->contapagadora}
                                         and c61_anousu = " . db_getsession("DB_anousu") . "
                                         and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont);
                  }
                  if(pg_num_rows($rsResultContaPag) == 0) {
                    $sSqlContaPagFont = "select distinct conta,fonte from ( 
																				select si95_codctb as conta, si96_codfontrecursos as fonte 
																			  from conplanoconta 
																			  inner join conplanoreduz on c61_codcon = c63_codcon 
																			  and c61_anousu = c63_anousu 
																			  inner join ctb102014 on si95_banco = c63_banco 
																			  and si95_agencia = c63_agencia and si95_digitoverificadoragencia = c63_dvagencia 
																			  and si95_contabancaria = c63_conta::int8 
																			  and si95_digitoverificadorcontabancaria = c63_dvconta 
																			  and si95_tipoconta::int8 = c63_tipoconta 
																			  inner join ctb202014 on si96_codctb = si95_codctb 
																			  and si96_mes = si95_mes 
																			  and si96_codfontrecursos = {$oExt30->fontepagadora} 
																			  where c61_reduz = {$oExt30->contapagadora} and c61_anousu = " . db_getsession("DB_anousu") . " 
																			  union all
																			  select si95_codctb as conta, si96_codfontrecursos as fonte 
																			  from conplanoconta 
																			  inner join conplanoreduz on c61_codcon = c63_codcon 
																			  and c61_anousu = c63_anousu 
																			  inner join ctb102015 on si95_banco = c63_banco 
																			  and si95_agencia = c63_agencia and si95_digitoverificadoragencia = c63_dvagencia 
																			  and si95_contabancaria = c63_conta::int8 
																			  and si95_digitoverificadorcontabancaria = c63_dvconta 
																			  and si95_tipoconta::int8 = c63_tipoconta 
																			  inner join ctb202015 on si96_codctb = si95_codctb 
																			  and si96_mes = si95_mes 
																			  and si96_codfontrecursos = {$oExt30->fontepagadora} 
																			  where c61_reduz = {$oExt30->contapagadora} and c61_anousu = " . db_getsession("DB_anousu") . " 
																			  union all
																			  select si95_codctb as conta, si96_codfontrecursos as fonte 
																			  from conplanoconta 
																			  inner join conplanoreduz on c61_codcon = c63_codcon 
																			  and c61_anousu = c63_anousu 
																			  inner join ctb102016 on si95_banco = c63_banco 
																			  and si95_agencia = c63_agencia and si95_digitoverificadoragencia = c63_dvagencia 
																			  and si95_contabancaria = c63_conta::int8 
																			  and si95_digitoverificadorcontabancaria = c63_dvconta 
																			  and si95_tipoconta::int8 = c63_tipoconta 
																			  inner join ctb202016 on si96_codctb = si95_codctb 
																			  and si96_mes = si95_mes 
																			  and si96_codfontrecursos = {$oExt30->fontepagadora} 
																			  where c61_reduz = {$oExt30->contapagadora} and c61_anousu = " . db_getsession("DB_anousu") . " 
																			  union all
																			  select si95_codctb as conta, si96_codfontrecursos as fonte 
																			  from conplanoconta 
																			  inner join conplanoreduz on c61_codcon = c63_codcon 
																			  and c61_anousu = c63_anousu 
																			  inner join ctb102017 on si95_banco = c63_banco 
																			  and si95_agencia = c63_agencia and si95_digitoverificadoragencia = c63_dvagencia 
																			  and si95_contabancaria = c63_conta::int8 
																			  and si95_digitoverificadorcontabancaria = c63_dvconta 
																			  and si95_tipoconta::int8 = c63_tipoconta 
																			  inner join ctb202017 on si96_codctb = si95_codctb 
																			  and si96_mes = si95_mes 
																			  and si96_codfontrecursos = {$oExt30->fontepagadora} 
																			  where c61_reduz = {$oExt30->contapagadora} and c61_anousu = " . db_getsession("DB_anousu") . " 
																			  and si95_mes <=" . $this->sDataFinal['5'] . $this->sDataFinal['6']."
																			  ) as cb"; 
																			  $rsResultContaPag = db_query($sSqlContaPagFont) or die($sSqlContaPagFont);
                  }	
                  
									if(pg_num_rows($rsResultContaPag) > 0){

										$oConta = db_utils::fieldsMemory($rsResultContaPag, 0);

										$cExt31 = new stdClass();

										$cExt31->si127_tiporegistro        = '31';
										$cExt31->si127_codreduzidoop       = $oExt30->codreduzidoop;
										$cExt31->si127_tipodocumentoop     = $oExt30->e91_codcheque != '' ? 1 : 99;
										$cExt31->si127_nrodocumento        = $oExt30->e91_codcheque != '' ? $oExt30->e91_codcheque : $aExt20[$Hash20]->ext30[$Hash30]->si126_codreduzidoop;
										$cExt31->si127_codctb              = $oConta->conta;
										$cExt31->si127_codfontectb         = $oConta->fonte;
										$cExt31->si127_desctipodocumentoop = $cExt31->si127_tipodocumentoop == 99 ? 'TED' : ' ';
										$cExt31->si127_dtemissao           = $cExt30->si126_dtpagamento;
										$cExt31->si127_vldocumento         = $cExt30->si126_vlop;
										$cExt31->si127_mes                 = $this->sDataFinal['5'] . $this->sDataFinal['6'];
										$cExt31->si127_reg21               = 0;
										$cExt31->si127_instit              = db_getsession("DB_instit");

										$aExt20[$Hash20]->ext30[$Hash30]->ext31[]  = $cExt31;

									}

								}
						//$aExt20[$Hash20] = $cExt20;
					}
				}
	    }
	 }
      //echo "<pre>";print_r($aExt20);
	  foreach($aExt20 as $oExt20) {
			
			$cExt   = new cl_ext202017();
			
			$cExt->si165_tiporegistro          = $oExt20->si165_tiporegistro;
			$cExt->si165_codorgao 			   = $oExt20->si165_codorgao;
			$cExt->si165_codext                = $oExt20->si165_codext;
			$cExt->si165_codfontrecursos       = $oExt20->si165_codfontrecursos;
			$cExt->si165_vlsaldoanteriorfonte  = abs($oExt20->si165_vlsaldoanteriorfonte);
			$cExt->si165_natsaldoanteriorfonte = $oExt20->si165_vlsaldoanteriorfonte >= 0 ? 'D' : 'C';
		    $cExt->si165_totaldebitos          = $oExt20->si165_totaldebitos;
		    $cExt->si165_totalcreditos         = $oExt20->si165_totalcreditos;
			$cExt->si165_vlsaldoatualfonte     = abs($oExt20->si165_vlsaldoatualfonte);
			$cExt->si165_natsaldoatualfonte    = $oExt20->si165_vlsaldoatualfonte >= 0 ? 'D' : 'C';
			$cExt->si165_mes                   = $oExt20->si165_mes;
			$cExt->si165_instit                = $oExt20->si165_instit;
			$cExt->incluir(null);

			if ($cExt->erro_status == 0) {
				throw new Exception("EXT20: ".$cExt->erro_msg);
			}
			foreach ($oExt20->ext30 as $oExtAgrupado) {

				$cExt30 = new cl_ext302017();

				$cExt30->si126_tiporegistro        = $oExtAgrupado->si126_tiporegistro;
				$cExt30->si126_codext              = $oExtAgrupado->si126_codext;
				$cExt30->si126_codfontrecursos     = $oExtAgrupado->si126_codfontrecursos;
				$cExt30->si126_codreduzidoop       = $oExtAgrupado->si126_codreduzidoop;
				$cExt30->si126_nroop               = $oExtAgrupado->si126_nroop;
				$cExt30->si126_codunidadesub       = $oExtAgrupado->si126_codunidadesub;
				$cExt30->si126_dtpagamento         = $oExtAgrupado->si126_dtpagamento;
				$cExt30->si126_tipodocumentocredor = $oExtAgrupado->si126_tipodocumentocredor;
				$cExt30->si126_nrodocumentocredor  = $oExtAgrupado->si126_nrodocumentocredor;
				$cExt30->si126_vlop                = $oExtAgrupado->si126_vlop;
				$cExt30->si126_especificacaoop     = $oExtAgrupado->si126_especificacaoop;
				$cExt30->si126_cpfresppgto         = $oExtAgrupado->si126_cpfresppgto;
				$cExt30->si126_mes                 = $oExtAgrupado->si126_mes;
				$cExt30->si126_instit              = $oExtAgrupado->si126_instit;
				$cExt30->si125_reg20               = $cExt->si165_sequencial;

				$cExt30->incluir(null);
				if ($cExt30->erro_status == 0) {
					throw new Exception("EXT30: ".$cExt30->erro_msg);
				}

				foreach ($oExtAgrupado->ext31 as $oext31agrupado) {

					$cExt31 = new cl_ext312017();


					$cExt31->si127_tiporegistro        = 31;
					$cExt31->si127_codreduzidoop       = $oext31agrupado->si127_codreduzidoop;
					$cExt31->si127_tipodocumentoop     = $oext31agrupado->si127_tipodocumentoop;
					$cExt31->si127_nrodocumento        = $oext31agrupado->si127_nrodocumento;
					$cExt31->si127_codctb              = $oext31agrupado->si127_codctb;
					$cExt31->si127_codfontectb         = $oext31agrupado->si127_codfontectb;
					$cExt31->si127_desctipodocumentoop = $oext31agrupado->si127_desctipodocumentoop;
					$cExt31->si127_dtemissao           = $oext31agrupado->si127_dtemissao;
					$cExt31->si127_vldocumento         = $oext31agrupado->si127_vldocumento;
					$cExt31->si127_mes                 = $oext31agrupado->si127_mes;
					$cExt31->si127_reg30               = $cExt30->si126_sequencial;
					$cExt31->si127_instit              = db_getsession("DB_instit");

					$cExt31->incluir(null);
					if ($cExt31->erro_status == 0) {
						throw new Exception("EXT31: ".$cExt31->erro_msg);
					}

				}
			}
		}

	db_fim_transacao();
	$oGerarEXT = new GerarEXT();
    $oGerarEXT->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
	$oGerarEXT->gerarDados();
  }
		
}
