<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ext102020_classe.php");
require_once ("classes/db_ext202020_classe.php");
require_once ("classes/db_ext302020_classe.php");
require_once ("classes/db_ext312020_classe.php");


require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarEXT.model.php");

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
   * @var array Fontes encerradas em 2020
   */
  protected $aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

  /**
 	* @var bollean
	* Realiza transferência de fontes utilizadas no reg 20 para fonte principal da conta (PCASP)
	*/
  protected $bEncerramento = false;

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

  public function setEncerramentoExt($iEncerramento) {
	  if ($iEncerramento == 1) {
		  $this->bEncerramento = true;
	  }
  }

  /**
   * selecionar os dados de //
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

  	$cExt10 = new cl_ext102020();
  	$cExt20 = new cl_ext202020();
  	$cExt30 = new cl_ext302020();
  	$cExt31 = new cl_ext312020();

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

	   // echo pg_last_error();

	   db_fim_transacao();

	   $sSqlRespPGTO = "select z01_cgccpf from identificacaoresponsaveis join cgm on si166_numcgm = z01_numcgm where si166_tiporesponsavel = 1";
	   $rsResponsalvelPgto = db_query($sSqlRespPGTO);
	   $cpfRespPGTO = db_utils::fieldsMemory($rsResponsalvelPgto)->z01_cgccpf;;
  	    /*
  	     * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
  	     *
  	     */
  	    $sSqlExt = "SELECT 10 AS tiporegistro,
					       c61_codcon,
					       c61_reduz AS codext,
					       c61_codtce AS codtce,
					       si09_codorgaotce AS codorgao,
					       COALESCE(c60_tipolancamento,0) AS tipolancamento,
					       COALESCE(c60_subtipolancamento,0) AS subtipo,
					       COALESCE(c60_desdobramneto,0) AS desdobrasubtipo,
					       substr(c60_descr,1,50) AS descextraorc,
						   o15_codtri as recurso
					FROM conplano
					INNER JOIN conplanoreduz ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
					LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
					JOIN orctiporec ON c61_codigo = o15_codigo
					WHERE c60_anousu = ".db_getsession("DB_anousu")."
					  AND c60_codsis = 7
					  AND c61_instit = ".db_getsession("DB_instit")."
					ORDER BY c61_reduz";

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




	       		if (!isset($aExt10Agrupodo[$aHash]) ){

					$cExt10 = new cl_ext102020();

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
                   $sSqlVerifica  = "SELECT 1 FROM ext102020
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo = '".$cExt10->si124_desdobrasubtipo."'
                                       AND si124_mes             <= ".$this->sDataFinal['5'].$this->sDataFinal['6'];
                   $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102019
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo =  '".$cExt10->si124_desdobrasubtipo."' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102018
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo =  '".$cExt10->si124_desdobrasubtipo."' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102017
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo =  '".$cExt10->si124_desdobrasubtipo."' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102016
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo =  '".$cExt10->si124_desdobrasubtipo."' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102015
                                     WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                       AND si124_tipolancamento  = '".$cExt10->si124_tipolancamento."'
                                       AND si124_subtipo         = '".$cExt10->si124_subtipo."'
                                       AND si124_desdobrasubtipo =  '".$cExt10->si124_desdobrasubtipo."' ";
                $sSqlVerifica  .= " UNION ALL
                                    SELECT 1 FROM ext102014
                                    WHERE si124_codorgao        = '".$cExt10->si124_codorgao."'
                                      AND si124_tipolancamento    = '".$cExt10->si124_tipolancamento."'
                                      AND si124_subtipo           = '".$cExt10->si124_subtipo."'
                                      AND si124_desdobrasubtipo   = '".$cExt10->si124_desdobrasubtipo."' ";

		       		$rsResulVerifica = db_query($sSqlVerifica) or die ($sSqlVerifica);
					// echo $rsResulVerifica;db_criatabela($rsResulVerifica);exit;

		       		if (pg_num_rows($rsResulVerifica) == 0) {

		       			$cExt10->incluir(null);

			       	    if ($cExt10->erro_status == 0) {
				    	      throw new Exception($cExt10->erro_msg);
						}

		       		}
					$oExtra = new stdClass();
					$oExtra->codext = $oContaExtra->codext;
					$oExtra->recurso = $oContaExtra->recurso;

				    $cExt10->extras[] = $oExtra;
				    $aExt10Agrupodo[$aHash] = $cExt10;

	       		}else{
					$oExtra = new stdClass();
					$oExtra->codext = $oContaExtra->codext;
					$oExtra->recurso = $oContaExtra->recurso;
	       		   	$aExt10Agrupodo[$aHash]->extras[] = $oExtra;
	       		}
	    }
	    $aExt20 = array();
		
	    foreach ($aExt10Agrupodo as $oExt10Agrupado) {

	    	foreach ($oExt10Agrupado->extras as $oExtras) {

				/*
				 * pegar todas as fontes de recursos movimentadas para cada codext
				 */
				$sSql20Fonte  = "   SELECT DISTINCT codext, fonte  from (
   								    select c61_reduz  as codext,0 as contrapart,o15_codigo as fonte
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$oExtras->codext})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 UNION ALL
							        select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
									  from conextsaldo
								inner join conplanoreduz on conextsaldo.ces01_reduz = conplanoreduz.c61_reduz
								       and conplanoreduz.c61_anousu = conextsaldo.ces01_anousu
									 where conextsaldo.ces01_reduz  in ({$oExtras->codext})
									   and conextsaldo.ces01_anousu = ".db_getsession("DB_anousu")."
								 UNION ALL
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
									   and conlancamval.c69_credito in ({$oExtras->codext})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = ".db_getsession("DB_anousu")."
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= ".$this->sDataFinal['5'].$this->sDataFinal['6']."
									   and conlancaminstit.c02_instit = ".db_getsession("DB_instit")."
								 UNION ALL
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
									   and conlancamval.c69_debito in ({$oExtras->codext})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = ".db_getsession("DB_anousu")."
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= ".$this->sDataFinal['5'].$this->sDataFinal['6']."
									   and conlancaminstit.c02_instit = ".db_getsession("DB_instit")."
								  ) as extfonte order by codext,fonte";

				$rsExt20FonteRecurso = db_query($sSql20Fonte);// or die($sSql20Fonte);
				// echo "Movimento";
                //db_criatabela($rsExt20FonteRecurso);
				for ($iC = 0;$iC < pg_num_rows($rsExt20FonteRecurso); $iC++) {
					$Hash20 = '';
					$oContaExtraFonte = db_utils::fieldsMemory($rsExt20FonteRecurso, $iC);

					$sSqlSaldoFonte =	"select round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),28,13)::float8,2)::float8 as saldo_anterior,
												round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),42,13)::float8,2)::float8 as debitomes,
												round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),56,13)::float8,2)::float8 as creditomes,
												round(substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),70,13)::float8,2)::float8 as saldo_final,
												substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),83,1)::varchar(1) as  sinalanterior,
												substr(fc_saldoextfonte(".db_getsession("DB_anousu").",$oContaExtraFonte->codext,$oContaExtraFonte->fonte," . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "," . db_getsession("DB_instit") . "),85,1)::varchar(1) as  sinalfinal ";

					$rsExtSaldoFonteRecurso   = db_query($sSqlSaldoFonte);
					// echo "Saldo ".$oContaExtraFonte->codext."-".$oContaExtraFonte->fonte."<br>".$sSqlSaldoFonte."<br> [si165_codext] => ".$oExt10Agrupado->si124_codext." - ".$oContaExtraFonte->fonte;
					// db_criatabela($rsExtSaldoFonteRecurso);
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
					$sSqlExtRecurso = "SELECT o15_codtri FROM orctiporec WHERE o15_codigo = ". $oExtRecurso;
					$rsExtRecurso = db_query($sSqlExtRecurso);
					$oExtRecursoTCE = db_utils::fieldsMemory($rsExtRecurso, 0)->o15_codtri; //fonte encerrada

                    //OC11537
                    $bFonteEncerrada  = in_array($oExtRecursoTCE, $this->aFontesEncerradas);
                    $bCorrecaoFonte   = ($bFonteEncerrada && $this->sDataFinal['5'] . $this->sDataFinal['6'] == '01' && db_getsession("DB_anousu") == 2020);

                    $oExtRecursoTCE2 = $bFonteEncerrada ? substr($oExtRecursoTCE, 0, 1).'59' : $oExtRecursoTCE; //caso atenda condição, altera para fonte nova 159 ou 259

                    if ($bFonteEncerrada && $bCorrecaoFonte) {

                        $Hash20 = "20b".$oExt10Agrupado->si124_codorgao.$oExt10Agrupado->si124_codext.$oExtRecursoTCE;

                        if(!isset($aExt20[$Hash20])){

                            $cExt20   = new stdClass();

                            $cExt20->si165_tiporegistro          = '20';
                            $cExt20->si165_codorgao 			 = $oExt10Agrupado->si124_codorgao;
                            $cExt20->si165_codext                = $oExt10Agrupado->si124_codext;
                            $cExt20->si165_codfontrecursos       = $oExtRecursoTCE;
                            $cExt20->si165_vlsaldoanteriorfonte  = $saldoanterior;
                            $cExt20->si165_natsaldoanteriorfonte = $saldoanterior > 0 ? 'D' : 'C';
                            $cExt20->si165_totaldebitos          = $saldoanterior < 0 ? abs($saldoanterior) : 0;
                            $cExt20->si165_totalcreditos         = $saldoanterior > 0 ? abs($saldoanterior) : 0;
                            $cExt20->si165_vlsaldoatualfonte     = 0;
                            $cExt20->si165_natsaldoatualfonte    = $saldoanterior > 0 ? 'D' : 'C';
                            $cExt20->si165_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $cExt20->si165_instit                = db_getsession("DB_instit");
                            $cExt20->ext30                       = array();
                            $aExt20[$Hash20]                     = $cExt20;

                        }else{

                            $aExt20[$Hash20]->si165_vlsaldoanteriorfonte  += $saldoanterior;
                            $aExt20[$Hash20]->si165_totaldebitos          += $saldoanterior < 0 ? abs($saldoanterior) : 0;
                            $aExt20[$Hash20]->si165_totalcreditos         += $saldoanterior > 0 ? abs($saldoanterior) : 0;
                        }

                    }

					$Hash20 = "20".$oExt10Agrupado->si124_codorgao.$oExt10Agrupado->si124_codext.$oExtRecursoTCE2;

					if(!isset($aExt20[$Hash20])){

						$cExt20   = new stdClass();

						$cExt20->si165_tiporegistro          = '20';
						$cExt20->si165_codorgao 			 = $oExt10Agrupado->si124_codorgao;
						$cExt20->si165_codext                = $oExt10Agrupado->si124_codext;
						$cExt20->si165_codfontrecursos       = $oExtRecursoTCE2;
						$cExt20->si165_vlsaldoanteriorfonte  = ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : $saldoanterior;
                        $cExt20->si165_natsaldoanteriorfonte = $natsaldoanteriorfonte;

						if ($bFonteEncerrada && $bCorrecaoFonte) {
                            $cExt20->si165_totaldebitos = $saldoanterior > 0 ? abs($saldoanterior) : $saldodebito;
                            $cExt20->si165_totalcreditos = $saldoanterior < 0 ? abs($saldoanterior) : $saldocredito;
                        } else {
                            $cExt20->si165_totaldebitos = $saldodebito;
                            $cExt20->si165_totalcreditos = $saldocredito;
                        }

                        $cExt20->si165_vlsaldoatualfonte     = $saldofinal;
                        $cExt20->si165_natsaldoatualfonte    = $natsaldoatualfonte;
						$cExt20->si165_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
						$cExt20->si165_instit                = db_getsession("DB_instit");
						$cExt20->ext30                       = array();
						$cExt20->iFontePrincipal			 = $oExtras->recurso;
						$aExt20[$Hash20]                     = $cExt20;

					}else{

						$aExt20[$Hash20]->si165_vlsaldoanteriorfonte  += ($bFonteEncerrada && $bCorrecaoFonte) ? 0 : $saldoanterior;
						$aExt20[$Hash20]->si165_vlsaldoatualfonte     += $saldofinal;
                        if ($bFonteEncerrada && $bCorrecaoFonte) {
                            $aExt20[$Hash20]->si165_totaldebitos += $saldoanterior > 0 ? abs($saldoanterior) : $saldodebito;
                            $aExt20[$Hash20]->si165_totalcreditos += $saldoanterior < 0 ? abs($saldoanterior) : $saldocredito;
                        } else {
                            $aExt20[$Hash20]->si165_totaldebitos += $saldodebito;
                            $aExt20[$Hash20]->si165_totalcreditos += $saldocredito;
                        }
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
                                  and conlancamval.c69_debito = {$oExtras->codext}
                                  and DATE_PART('YEAR',conlancamval.c69_data) = " . db_getsession("DB_anousu") . "
                                  and DATE_PART('MONTH',conlancamval.c69_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                                  and orctiporec.o15_codigo = {$oExtRecurso}";

					$rsExtMov = db_query($sSqlMov);
					// echo "Reg30";db_criatabela($rsExtMov);
					/*FOR PARA PEGAR O REGISTRO 21 E COLOCAR NO 20*/
					for ($linha = 0; $linha < pg_num_rows($rsExtMov); $linha++) {

						$oExtMov = db_utils::fieldsMemory($rsExtMov, $linha);

                                $sSql30 = " SELECT '30' as tiporegistro,
                                                    /*e91_codcheque,*/
                                                    CASE 
                                                        WHEN conplano.c60_codsis = 5 
                                                        THEN 5
                                                        ELSE e91_codcheque
                                                    END AS e91_codcheque,
                                                    c86_data as dtpagamento,
                                                    (SELECT coalesce(c86_conlancam, 0) FROM conlancamcorrente
                                                        WHERE c86_id = corrente.k12_id
                                                            AND c86_data = corrente.k12_data
                                                            AND c86_autent = corrente.k12_autent) AS codreduzidomov,
                                                    (slip.k17_codigo||slip.k17_debito)::int8 AS codreduzidoop,
                                                    (slip.k17_codigo||slip.K17_debito)::int8 AS nroop,
                                                    CASE WHEN LENGTH(cc.z01_cgccpf::varchar) = 11 THEN 1 ELSE 2 END AS tipodocumentocredor,
                                                    cc.z01_cgccpf AS nrodocumentocredor,
                                                    k17_valor AS vlop,
                                                    k17_texto AS especificacaoop,
                                                    CASE WHEN c61_codtce <> 0 THEN c61_codtce ELSE slip.k17_credito END AS contapagadora,
                                                    orctiporec.o15_codtri AS fontepagadora,
                                                    (SELECT CASE WHEN o41_subunidade != 0
                                                                                OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                                                                OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                                                                            OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                                                                        ELSE lpad((CASE WHEN o40_codtri = '0'
                                                                                OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                                                                    OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                                                        END AS unidade
                                                        FROM orcunidade
                                                        JOIN orcorgao ON o41_anousu = o40_anousu and o41_orgao = o40_orgao
                                                        WHERE o41_instit = " . db_getsession("DB_instit") . " AND o40_anousu = " . db_getsession("DB_anousu") . " ORDER BY o40_orgao LIMIT 1) AS codunidadesub
                                            FROM corlanc
                                            INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id
                                                        AND corlanc.k12_data = corrente.k12_data
                                                        AND corlanc.k12_autent = corrente.k12_autent
                                            INNER JOIN slip on slip.k17_codigo = corlanc.k12_codigo
                                            INNER JOIN conplanoreduz on slip.k17_credito = conplanoreduz.c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
                                            INNER JOIN conplano ON (conplano.c60_codcon, conplano.c60_anousu) = (conplanoreduz.c61_codcon, conplanoreduz.c61_anousu)
                                            INNER JOIN orctiporec on orctiporec.o15_codigo = conplanoreduz.c61_codigo
                                            INNER JOIN slipnum on slipnum.k17_codigo = slip.k17_codigo
                                            INNER JOIN cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
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
								// db_criatabela($rsExt30);
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

                                    $cExt31 = new stdClass();

                                    $cExt31->si127_tiporegistro        = '31';
                                    $cExt31->si127_codreduzidoop       = $oExt30->codreduzidoop;
                                    $cExt31->si127_tipodocumentoop     = empty($oExt30->e91_codcheque) ? 99 : (($oExt30->e91_codcheque == 5) ? 5 : 1);
                                    $cExt31->si127_nrodocumento        = $oExt30->e91_codcheque == 5 ? '' : (!empty($oExt30->e91_codcheque) ? $oExt30->e91_codcheque : $aExt20[$Hash20]->ext30[$Hash30]->si126_codreduzidoop);
                                    $cExt31->si127_codctb              = $oExt30->e91_codcheque == 5 ? '' : $oExt30->contapagadora;
                                    $cExt31->si127_codfontectb         = $oExt30->fontepagadora;
                                    $cExt31->si127_desctipodocumentoop = $cExt31->si127_tipodocumentoop == 99 ? 'TED' : ' ';
                                    $cExt31->si127_dtemissao           = $cExt30->si126_dtpagamento;
                                    $cExt31->si127_vldocumento         = $cExt30->si126_vlop;
                                    $cExt31->si127_mes                 = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                                    $cExt31->si127_reg21               = 0;
                                    $cExt31->si127_instit              = db_getsession("DB_instit");

                                    $aExt20[$Hash20]->ext30[$Hash30]->ext31[]  = $cExt31;

								}
						//$aExt20[$Hash20] = $cExt20;
					}
				}
		}
	}
	
	/**
	 * Realiza trasnferências das fontes utilizadas no registro 20 para o registro da fonte principal (Cadastrada no PCASP)
	 */
	if ($this->bEncerramento) {

		//Percorre array dos registros 20 para fazer as transferências nas fontes que não são principal
		foreach($aExt20 as $sHash20 => $oExt20) {
			
			$sHashPrincipal = substr($sHash20,0,-3).$oExt20->iFontePrincipal;

			//Considera apena fonte diferente da principal
			if ($oExt20->iFontePrincipal != $oExt20->si165_codfontrecursos) {

				//Guarda soma dos saldos atuais/finais das fontes para, posteriormente, atribuir para a principal
				$aExt20[$sHashPrincipal]->iTotalSaldoAtual += $oExt20->si165_vlsaldoatualfonte;
				
				/**
				 * Caso saldo final seja D: soma vlSaldoAtualFonte com totalCreditos
				 * Caso saldo final seja C: soma vlSaldoAtualFonte com totalDebitos
				 * Zera vlSaldoAtualFonte
				 */
				if ($this->getNatSaldoAtual($oExt20) == 'D') {

					$oExt20->si165_totalcreditos += $oExt20->si165_vlsaldoatualfonte;
					$oExt20->si165_vlsaldoatualfonte = 0;

				} elseif ($this->getNatSaldoAtual($oExt20) == 'C') {
					
					$oExt20->si165_totaldebitos += abs($oExt20->si165_vlsaldoatualfonte);
					$oExt20->si165_vlsaldoatualfonte = 0;

				}

			}

		}

		//Percorre array dos registros 20 para atualizar os saldos da fonte principal
		foreach($aExt20 as $sHash20 => $oExt20) {

			//Considera apenas fonte principal
			if ($oExt20->iFontePrincipal == $oExt20->si165_codfontrecursos) {
				
				//Atualiza saldo atual da fonte principal utilizando o valor acumulado no for das fontes não principais
				if ($this->getNatSaldoAtual($oExt20) == 'C') {
					$oExt20->si165_vlsaldoatualfonte += $oExt20->iTotalSaldoAtual * -1;
				} else {
					$oExt20->si165_vlsaldoatualfonte += abs($oExt20->iTotalSaldoAtual);
				}
				
				//Atualiza o crédito/débito da fonte principal
				if ($oExt20->si165_vlsaldoatualfonte > 0) {
					$oExt20->si165_totaldebitos += abs($oExt20->iTotalSaldoAtual);
				} else {
					$oExt20->si165_totalcreditos += abs($oExt20->iTotalSaldoAtual);
				}

			}

		}

	}

	foreach($aExt20 as $oExt20) {

			$cExt   = new cl_ext202020();

			$cExt->si165_tiporegistro          = $oExt20->si165_tiporegistro;
			$cExt->si165_codorgao 			   = $oExt20->si165_codorgao;
			$cExt->si165_codext                = $oExt20->si165_codext;
			$cExt->si165_codfontrecursos       = $oExt20->si165_codfontrecursos;
			$cExt->si165_vlsaldoanteriorfonte  = abs($oExt20->si165_vlsaldoanteriorfonte);
			
			if (($oExt20->si165_vlsaldoanteriorfonte) < 0) {
				$cExt->si165_natsaldoanteriorfonte = 'C';
			} elseif ((($oExt20->si165_vlsaldoanteriorfonte) > 0)) {
				$cExt->si165_natsaldoanteriorfonte = 'D';
			} else {
				$cExt->si165_natsaldoanteriorfonte = $oExt20->si165_natsaldoanteriorfonte;
			}

			$cExt->si165_totaldebitos          = $oExt20->si165_totaldebitos;
			$cExt->si165_totalcreditos         = $oExt20->si165_totalcreditos;
			$cExt->si165_vlsaldoatualfonte     = abs($oExt20->si165_vlsaldoatualfonte);
			$cExt->si165_natsaldoatualfonte    = $this->getNatSaldoAtual($oExt20);
			$cExt->si165_mes                   = $oExt20->si165_mes;
			$cExt->si165_instit                = $oExt20->si165_instit;
			$cExt->incluir(null);

			if ($cExt->erro_status == 0) {
				throw new Exception("EXT20: ".$cExt->erro_msg);
			}
			foreach ($oExt20->ext30 as $oExtAgrupado) {

				$cExt30 = new cl_ext302020();

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

					$cExt31 = new cl_ext312020();


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
	$oGerarEXT->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
	$oGerarEXT->gerarDados();
  }

  	/**
	   * Separa função para buscar a natureza do saldo atual/final da conta
	   * utilizando as condições já existentes
	   */
  	private function getNatSaldoAtual($oExt20) {

		if (substr($oExt20->si165_codfontrecursos, 1, 2) == '59') {
			$verificaNatSaldoAtual = $oExt20->si165_vlsaldoatualfonte;
		} else {
			$verificaNatSaldoAtual = ($oExt20->si165_vlsaldoanteriorfonte + $oExt20->si165_totaldebitos - $oExt20->si165_totalcreditos);
		}

		if ($verificaNatSaldoAtual < 0) {
			return 'C';
		} elseif ($verificaNatSaldoAtual > 0) {
			return 'D';
		} else {
			return $oExt20->si165_natsaldoatualfonte;
		}

  	}

}
