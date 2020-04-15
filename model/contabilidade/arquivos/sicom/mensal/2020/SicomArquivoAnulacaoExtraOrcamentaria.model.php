<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_aex102020_classe.php");

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarAEX.model.php");

 /**
  * Anulacao Extra Orcamentaria Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoAnulacaoExtraOrcamentaria extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 * 
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
    protected $iCodigoLayout = 196;
  
    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'AEX';
  
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
     * selecionar os dados
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados() {
  	
        $cAex10 = new cl_aex102020();
  	
  	    /*
  	    * CASO JA TENHA SIDO GERADO ALTERIORMENTE PARA O MESMO PERIDO O SISTEMA IRA
  	    * EXCLUIR OS REGISTROS E GERAR NOVAMENTE
  	    *
  	    */

        $result = $cAex10->sql_record($cAex10->sql_query_file(NULL,"*",NULL,"si130_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));

	    if (pg_num_rows($result) > 0) {

	        $cAex10->excluir(NULL,"si130_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
	    
	        if ($cAex10->erro_status == 0) {
	    	    throw new Exception($cExt22->erro_msg);
	        }
	      	   
	    }

	    $sSqlContasExtras = "       SELECT
                                        c61_reduz AS codext,
                                        c61_codtce AS codtce
                                    FROM conplano
                                        INNER JOIN conplanoreduz ON c60_codcon = c61_codcon AND c60_anousu = c61_anousu
                                        LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
                                    WHERE c60_anousu = ".db_getsession("DB_anousu")."
                                    AND c60_codsis = 7
                                    AND c61_instit = ".db_getsession("DB_instit")."
                                    ORDER BY c61_reduz";

        $rsContasExtra = db_query($sSqlContasExtras) or die($sSqlContasExtras);
        $aAex10Agrupado = array();

        for ($iCont10 = 0;$iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

            $oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont10);

            $iCodExt = $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;

            /*
             * pegar todas as fontes de recursos movimentadas para cada codext
             */
            $sSqlFonte  = "   SELECT DISTINCT codext, fonte  from (
   								    select c61_reduz  as codext,0 as contrapart,o15_codigo as fonte
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$oContaExtra->codext})
									   and conplanoreduz.c61_anousu = " . db_getsession("DB_anousu") . "
								 UNION ALL
							        select ces01_reduz as codext, ces01_reduz as contrapart,ces01_fonte as fonte
									  from conextsaldo
								inner join conplanoreduz on conextsaldo.ces01_reduz = conplanoreduz.c61_reduz
								       and conplanoreduz.c61_anousu = conextsaldo.ces01_anousu
									 where conextsaldo.ces01_reduz  in ({$oContaExtra->codext})
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
									   and conlancamval.c69_credito in ({$oContaExtra->codext})
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
									   and conlancamval.c69_debito in ({$oContaExtra->codext})
									   and DATE_PART('YEAR',conlancamdoc.c71_data) = ".db_getsession("DB_anousu")."
									   and DATE_PART('MONTH',conlancamdoc.c71_data) <= ".$this->sDataFinal['5'].$this->sDataFinal['6']."
									   and conlancaminstit.c02_instit = ".db_getsession("DB_instit")."
								  ) as extfonte order by codext,fonte";

            $rsFont = db_query($sSqlFonte);

            for ($iCont = 0;$iCont < pg_num_rows($rsFont); $iCont++) {

                $oFont = db_utils::fieldsMemory($rsFont,$iCont);

                $sSqlMov = " SELECT                                 
                                conlancamcorrente.c86_id AS id,
                                conlancamcorrente.c86_data AS data,
                                conlancamcorrente.c86_autent AS autent
                            FROM conlancamval
                                INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                INNER JOIN conlancamcorrente ON conlancamval.c69_codlan = conlancamcorrente.c86_conlancam
                                INNER JOIN conplanoreduz ON conplanoreduz.c61_reduz = conlancamval.c69_credito
                                INNER JOIN orctiporec ON orctiporec.o15_codigo = conplanoreduz.c61_codigo AND conplanoreduz.c61_anousu = conlancamval.c69_anousu
                            WHERE conlancamdoc.c71_coddoc in (120,151,161)
                                AND conlancamval.c69_debito = {$oContaExtra->codext}
                                AND DATE_PART('YEAR',conlancamval.c69_data) = " . db_getsession("DB_anousu") . "
                                AND DATE_PART('MONTH',conlancamval.c69_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                                AND orctiporec.o15_codigo = {$oFont->fonte}";

                $rsMov = db_query($sSqlMov);

                for ($linha = 0; $linha < pg_num_rows($rsMov); $linha++) {

                    $oMov = db_utils::fieldsMemory($rsMov, $linha);

                    $sSql10 = " SELECT 
                                '10' AS tiporegistro,
                                c86_data AS dtpagamento,
                                (SELECT 
                                    coalesce(c86_conlancam, 0) FROM conlancamcorrente
                                WHERE c86_id = corrente.k12_id
                                    AND c86_data = corrente.k12_data
                                    AND c86_autent = corrente.k12_autent) AS codreduzidomov,
                                (slip.k17_codigo||slip.k17_debito)::int8 AS codreduzidoop,
                                (slip.k17_codigo||slip.K17_debito)::int8 AS nroop,
                                CASE WHEN LENGTH(cc.z01_cgccpf::varchar) = 11 THEN 1 ELSE 2 END AS tipodocumentocredor,
                                cc.z01_cgccpf AS nrodocumentocredor,
                                k17_valor AS vlanulacaoop,
                                k17_texto AS especificacaoop,
                                CASE 
                                    WHEN c61_codtce <> 0 THEN c61_codtce 
                                    ELSE slip.k17_credito 
                                END AS contapagadora,
                                orctiporec.o15_codtri AS fontepagadora,
                                slip.k17_dtanu AS dtanulacao,
                                (SELECT 
                                        CASE 
                                            WHEN o41_subunidade != 0 OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0) 
                                            ELSE lpad((CASE WHEN o40_codtri = '0' OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0' OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                                        END AS unidade
                                FROM orcunidade
                                    JOIN orcorgao ON o41_anousu = o40_anousu and o41_orgao = o40_orgao
                                WHERE o41_instit = " . db_getsession("DB_instit") . " AND o40_anousu = " . db_getsession("DB_anousu") . " ORDER BY o40_orgao LIMIT 1) AS codunidadesub
                            FROM corlanc
                                INNER JOIN corrente ON corlanc.k12_id = corrente.k12_id AND corlanc.k12_data = corrente.k12_data AND corlanc.k12_autent = corrente.k12_autent
                                INNER JOIN slip on slip.k17_codigo = corlanc.k12_codigo
                                INNER JOIN slipanul ON k18_codigo = k17_codigo
                                INNER JOIN conplanoreduz on slip.k17_credito = conplanoreduz.c61_reduz and c61_anousu = " . db_getsession("DB_anousu") . "
                                INNER JOIN conplano ON (conplano.c60_codcon, conplano.c60_anousu) = (conplanoreduz.c61_codcon, conplanoreduz.c61_anousu)
                                INNER JOIN orctiporec on orctiporec.o15_codigo = conplanoreduz.c61_codigo
                                INNER JOIN slipnum on slipnum.k17_codigo = slip.k17_codigo
                                INNER JOIN cgm cc on cc.z01_numcgm = slipnum.k17_numcgm
                                LEFT JOIN corconf ON corlanc.k12_id = corconf.k12_id AND corlanc.k12_data = corconf.k12_data AND corlanc.k12_autent = corconf.k12_autent
                                LEFT JOIN empageconfche ON k12_codmov = e91_codcheque
                                LEFT JOIN empagemovforma ON e91_codmov = e97_codmov
                                LEFT JOIN empageforma ON e97_codforma = e96_codigo
                                LEFT JOIN conlancamcorrente ON conlancamcorrente.c86_id = corrente.k12_id AND conlancamcorrente.c86_data = corrente.k12_data AND conlancamcorrente.c86_autent = corrente.k12_autent
                            WHERE c86_id = {$oMov->id} 
                                AND c86_data = '{$oMov->data}' 
                                AND c86_autent = {$oMov->autent} ";

                    $rsAex10 = db_query($sSql10) or die($sSql10);

                    for ($linha10 = 0; $linha10 < pg_num_rows($rsAex10); $linha10++) {

                        $oAex10 = db_utils::fieldsMemory($rsAex10, $linha10);

                        $sHash10 = $oContaExtra->codext.$oAex10->fontepagadora.$oAex10->nroop.$oAex10->codunidadesub;

                        if (!isset($aAex10Agrupado[$sHash10])) {

                            $cAex10 = new stdClass();

                            $cAex10->si130_tiporegistro     = $oAex10->tiporegistro;
                            $cAex10->si130_codext           = $iCodExt;
                            $cAex10->si130_codfontrecursos  = $oAex10->fontepagadora;
                            $cAex10->si130_nroop            = $oAex10->nroop;
                            $cAex10->si130_codunidadesub    = $oAex10->codunidadesub;
                            $cAex10->si130_dtpagamento      = $oAex10->dtpagamento;
                            $cAex10->si130_nroanulacaoop    = $oAex10->codreduzidomov;
                            $cAex10->si130_dtanulacaoop     = $oAex10->dtanulacao;
                            $cAex10->si130_vlanulacaoop     = $oAex10->vlanulacaoop;
                            $cAex10->si130_mes              = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                            $cAex10->si130_instit           = db_getsession("DB_instit");

                            $aAex10Agrupado[$sHash10] = $cAex10;

                        } else {

                            $aAex10Agrupado[$sHash10]->si130_vlanulacaoop += $oAex10->vlanulacaoop;

                        }

                    }

                }

            }

        }

        foreach ($aAex10Agrupado as $oDados10) {

            $claex = new cl_aex102020();

            $claex->si130_tiporegistro     = $oDados10->si130_tiporegistro;
            $claex->si130_codext           = $oDados10->si130_codext;
            $claex->si130_codfontrecursos  = $oDados10->si130_codfontrecursos;
            $claex->si130_nroop            = $oDados10->si130_nroop;
            $claex->si130_codunidadesub    = $oDados10->si130_codunidadesub;
            $claex->si130_dtpagamento      = $oDados10->si130_dtpagamento;
            $claex->si130_nroanulacaoop    = $oDados10->si130_nroanulacaoop;
            $claex->si130_dtanulacaoop     = $oDados10->si130_dtanulacaoop;
            $claex->si130_vlanulacaoop     = $oDados10->si130_vlanulacaoop;
            $claex->si130_mes              = $oDados10->si130_mes;
            $claex->si130_instit           = $oDados10->si130_instit;

            $claex->incluir(null);
            if ($claex->erro_status == 0) {
                throw new Exception($claex->erro_msg);
            }

        }

        $oGerarAEX = new GerarAEX();
        $oGerarAEX->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];;
        $oGerarAEX->gerarDados();


        /*$sSqlExt = "select 10 as tiporegistro,c61_codcon,
                       c61_reduz as codext,
                       si09_codorgaotce as codorgao,
                       (select CASE
                                        WHEN o41_subunidade != 0
                                             OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                                                OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                                  OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                                        ELSE lpad((CASE WHEN o40_codtri = '0'
                                             OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                               OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                                 end as unidade
                      from orcunidade
                      join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
                      where o41_instit = ".db_getsession("DB_instit")." limit 1) as codUnidadeSub,
                       c60_tipolancamento as tipolancamento,
                       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
                            when c60_tipolancamento = 2 then 1
                            when c60_tipolancamento = 3 and c60_subtipolancamento not in (1,2,3) then c61_reduz
                            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
                            else c60_subtipolancamento
                       end as subtipo,
                       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
                            when c60_tipolancamento = 2 then 0
                            when c60_tipolancamento = 3 then 0
                            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
                            else c60_desdobramneto
                       end as desdobrasubtipo,
                       substr(c60_descr,1,50) as descextraorc
                  from conplano
                  join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
                  left join infocomplementaresinstit on si09_instit = c61_instit
                  where c60_anousu = ".db_getsession("DB_anousu")." and c60_codsis = 7 and c61_instit = ".db_getsession("DB_instit")."
                    and c60_tipolancamento != 0  ";


          $rsContasExtra = db_query($sSqlExt);*/
  	    //db_criatabela($rsContasExtra);exit;
	    /**
	     * percorrer registros de contas retornados do sql acima para pega saldo anterior
	     */
  	    /*
	    $aAex10Agrupa = array();
	    for ($iCont = 0;$iCont < pg_num_rows($rsContasExtra); $iCont++) {
	        
	    	$oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont);
	    	 
	    	$sSqlMov10 = "select   '10' as tiporegitro,2 as tipo,k17_codigo as id,
						         k17_codigo as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         k17_credito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         k17_data as dtlancamento,
						         k17_dtanu as dtanulacaoextra,
						         k17_motivoestorno as justificativaanulacao,
						         k17_valor as valor
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where k17_dtestorno between '".$this->sDataInicial."' AND '".$this->sDataFinal."' 
						   and k17_credito = {$oContaExtra->codext} 
						   and c71_coddoc in (163,162,152,153,121,131)
						   and k17_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro,2 as tipo,k17_codigo as id,
						         k17_codigo as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         k17_debito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         k17_data as dtlancamento,
						         k17_dtanu as dtanulacaoextra,
						         k17_motivoestorno as justificativaanulacao,
						         k17_valor as valor
						     from slip 
						     join conlancamslip on k17_codigo = c84_slip
						     join conlancamdoc  on c71_codlan = c84_conlancam
						     join conplanoreduz on k17_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on k17_instit = si09_instit
						 where k17_dtestorno between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						   and k17_debito = {$oContaExtra->codext} 
						   and c71_coddoc in (163,162,152,153,121,131)
						   and k17_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro,1 as tipo,e50_codord as id,
						         e20_pagordem as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         c69_debito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         e50_data as dtlancamento,
						         c86_data as dtanulacaoextra,
						         'Estorno de Renteção' as justificativaanulacao,
						         c69_valor as valor
						     from retencaoreceitas 
						     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
						     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
						     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
						     join conlancamdoc  on c71_codlan = c86_conlancam
						     join conlancamval on c69_codlan = c71_codlan
						     join retencaopagordem on e23_retencaopagordem = e20_sequencial
						     join pagordem on e50_codord = e20_pagordem
						     join empempenho on e60_numemp = e50_numemp
						     join conplanoreduz on c69_debito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on e60_instit = si09_instit
						    where c71_coddoc in (131,152,153,162,163) 
						      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						      and c69_debito = {$oContaExtra->codext}
						      and e60_instit = ".db_getsession("DB_instit")."
						union all
						select   '10' as tiporegitro, 1 as tipo,e50_codord as id,
						         e20_pagordem as codreduzidoaex,
						         si09_codorgaotce as codorgao,
						         c69_credito as codext, 
						         o15_codtri::int as fonte,
						         case when c71_coddoc in (131,152,162) then 1 else 2 end as categoria,
						         e50_data as dtlancamento,
						         c86_data as dtanulacaoextra,
						         'Estorno de Renteção' as justificativaanulacao,
						         c69_valor as valor
						     from retencaoreceitas 
						     join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial 
						     join corgrupocorrente on e47_corgrupocorrente = k105_sequencial 
						     join conlancamcorrente on k105_data = c86_data and k105_autent = c86_autent and k105_id = c86_id
						     join conlancamdoc  on c71_codlan = c86_conlancam
						     join conlancamval on c69_codlan = c71_codlan
						     join retencaopagordem on e23_retencaopagordem = e20_sequencial
						     join pagordem on e50_codord = e20_pagordem
						     join empempenho on e60_numemp = e50_numemp
						     join conplanoreduz on c69_credito = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
						     join orctiporec on o15_codigo  = c61_codigo
						left join infocomplementaresinstit on e60_instit = si09_instit
						    where c71_coddoc in (131,152,153,162,163) 
						      and c86_data between '".$this->sDataInicial."' AND '".$this->sDataFinal."'
						      and c69_credito = {$oContaExtra->codext}
						      and e60_instit = ".db_getsession("DB_instit");
	    	
	    	$rsAex10 = db_query($sSqlMov10);
	    	
	    	
	    	for ($iContAex10 = 0; $iContAex10 < pg_num_rows($rsAex10); $iContAex10++){
	    		
	    		$oAex10 = db_utils::fieldsMemory($rsAex10,$iContAex10);
	    		
	    		$sHash  = $oAex10->tiporegitro.$oAex10->codorgao.$oAex10->codext.$oAex10->fonte;
	    		$sHash .= $oAex10->categoria.$oAex10->dtlancamento.$oAex10->dtanulacaoextra;
	    		
	    		if(!isset($aAex10Agrupa[$sHash])){
	    		    
	    			$cAex10 = new stdClass();
	    		
		    		$cAex10->si129_tiporegistro 		 = $oAex10->tiporegitro;
		    		$cAex10->si129_codreduzidoaex 		 = $oAex10->codreduzidoaex;
		    		$cAex10->si129_codorgao 			 = $oAex10->codorgao;
		    		$cAex10->si129_codext 				 = $oAex10->codext;
		    		$cAex10->si129_codfontrecursos 		 = $oAex10->fonte;
		    		$cAex10->si129_categoria 			 = $oAex10->categoria;
		    		$cAex10->si129_dtlancamento 		 = $oAex10->dtlancamento;
		    		$cAex10->si129_dtanulacaoextra 		 = $oAex10->dtanulacaoextra;
		    		$cAex10->si129_justificativaanulacao = $oAex10->justificativaanulacao;
		    		$cAex10->si129_vlanulacao 			 = $oAex10->valor;
		    		$cAex10->si129_mes 					 = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    		$cAex10->aex11						 = array();
		    		
		    		$aAex10Agrupa[$sHash] = $cAex10;
		    		
		    		if($oAex10->tipo == 1){
		    		       $sSqlPagExtra = "select c80_data from conlancamord 
		    		                                  join conlancamdoc on c80_codlan = c71_codlan 
		    		                                  where c71_coddoc = 5 and c80_codord = ".$oAex10->id." limit 1";
						   
		    		       $rsPagExtra = db_query($sSqlPagExtra);
		    		       
		    		       $dtPagamento = db_utils::fieldsMemory($rsPagExtra,0)->c80_data;
		    		}else{
		    			   $sSqlPagExtra = "select c71_data from conlancamslip 
		    			   									join conlancamdoc on c71_codlan = c84_conlancam 
		    			   									where c71_coddoc = 160 and c84_slip =".$oAex10->id;
		    			   
		    		       $rsPagExtra = db_query($sSqlPagExtra);
		    		       $dtPagamento = db_utils::fieldsMemory($rsPagExtra,0)->c71_data;
		    		}
		    		
		    		
		    		
		    		$oAex11 = new stdClass();
	    		    
		    		$oAex11->si130_tiporegistro     = '11';
		    		$oAex11->si130_codreduzidoaex   = $oAex10->codreduzidoaex;
		    		$oAex11->si130_nroop  		    = $oAex10->codext;
		    		$oAex11->si130_dtpagamento 	    = $dtPagamento;
		    		$oAex11->si130_nroanulacaoop    = $oAex10->codext;
		    		$oAex11->si130_dtanulacaoop 	= $oAex10->dtanulacaoextra;
		    		$oAex11->si130_vlanulacaoop 	= $oAex10->valor;
		    		$oAex11->si130_mes 			    = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    		$oAex11->si130_reg10		    = 0;
		    		
		    		
		    		$aAex10Agrupa[$sHash]->aex11[$sHash] 		  = $oAex11;
		    		
	    		}else{
	    			
	    			$aAex10Agrupa[$sHash]->si129_vlanulacao                  +=$oAex10->valor;
	    			$aAex10Agrupa[$sHash]->aex11[$sHash]->si130_vlanulacaoop +=$oAex10->valor;
	    			
	    		}
	    		
    		
	    	}
	    	
    	
	    }
	    
	     
	     foreach ($aAex10Agrupa as $oDados10) {
	    			
			    	    $claex   = new cl_aex102016();
			    	  
					    $claex->si129_tiporegistro 		     = $oDados10->si129_tiporegistro;
			    		$claex->si129_codreduzidoaex 		 = $oDados10->si129_codreduzidoaex;
			    		$claex->si129_codorgao 			     = $oDados10->si129_codorgao;
			    		$claex->si129_codext 				 = $oDados10->si129_codext;
			    		$claex->si129_codfontrecursos 		 = $oDados10->si129_codfontrecursos;
			    		$claex->si129_categoria 			 = $oDados10->si129_categoria;
			    		$claex->si129_dtlancamento 		     = $oDados10->si129_dtlancamento;
			    		$claex->si129_dtanulacaoextra 		 = $oDados10->si129_dtanulacaoextra;
			    		$claex->si129_justificativaanulacao  = $oDados10->si129_justificativaanulacao;
			    		$claex->si129_vlanulacao 			 = $oDados10->si129_vlanulacao;
			    		$claex->si129_mes 					 = $this->sDataFinal['5'].$this->sDataFinal['6'];
					    
					    $claex->incluir(null);
			    	if ($claex->erro_status == 0) {
			    	  throw new Exception($claex->erro_msg);
			        }
	      foreach ($oDados10->aex11 as $oDados11) {
	      	    
	            $aex11 = new cl_aex112016();
	            
	    		    $aex11->si130_tiporegistro      = $oDados11->si130_tiporegistro;
		    		$aex11->si130_codreduzidoaex    = $oDados11->si130_codreduzidoaex;
		    		$aex11->si130_nroop  		    = $oDados11->si130_nroop;
		    		$aex11->si130_dtpagamento 	    = $oDados11->si130_dtpagamento;
		    		$aex11->si130_nroanulacaoop     = $oDados11->si130_nroanulacaoop;
		    		$aex11->si130_dtanulacaoop 	    = $oDados11->si130_dtanulacaoop;
		    		$aex11->si130_vlanulacaoop      = $oDados11->si130_vlanulacaoop;
		    		$aex11->si130_mes 			    = $oDados11->si130_mes;
		    		$aex11->si130_reg10		        = $claex->si129_sequencial;
	    		
	            $aex11->incluir(null);
	    	  if ($aex11->erro_status == 0) {
	    	    throw new Exception($aex11->erro_msg);
	          }
	      	
	      }
	      
			  
	    }
	    
	    
	    
	    
	    $cAex10->incluir(null);
		    	    if ($cAex10->erro_status == 0) {
			    	  throw new Exception($cAex10->erro_msg);
			        }*/
	
  }
		
}
