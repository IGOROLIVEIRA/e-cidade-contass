<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_flpgo102013_classe.php");
require_once ("classes/db_flpgo112013_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2013/flpg/GerarFLPGO.model.php");


/**
 * selecionar dados de Notas Fiscais Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoFlpgo extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout
     * @var Integer
     */
    protected $iCodigoLayout = 174;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'FLPGO';

    /**
     *
     * Contrutor da classe
     */
    public function __construct() {

    }

    /**
     * retornar o codio do layout
     *
     *@return Integer
     */
    public function getCodigoLayout(){
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     *@return Array
     */
    public function getCampos() {

    }

    /**
     * selecionar os dados de Notas Fiscais referentes a instituicao logada
     *
     */
    public function gerarDados() {

        $clflpgo10 = new cl_flpgo102013();
        $clflpgo11 = new cl_flpgo112013();
        $clflpgo12 = new cl_flpgo122013();

        db_inicio_transacao();

        /*
        * excluir informacoes do mes selecionado registro 12
        */
        $result = $clflpgo12->sql_record($clflpgo12->sql_query(NULL,"*",NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si197_inst = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clflpgo12->excluir(NULL,"si197_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si197_inst = ".db_getsession("DB_instit"));
            if ($clflpgo12->erro_status == 0) {
                throw new Exception($clflpgo12->erro_msg);
            }
        }

        /*
        * excluir informacoes do mes selecionado registro 11
        */
        $result = $clflpgo11->sql_record($clflpgo11->sql_query(NULL,"*",NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si196_inst = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {

            $clflpgo11->excluir(NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si196_inst = ".db_getsession("DB_instit"));
            if ($clflpgo11->erro_status == 0) {
                throw new Exception($clflpgo11->erro_msg);
            }
        }

        /*
         * excluir informacoes do mes selecionado registro 10
         */
        $result = $clflpgo10->sql_record($clflpgo10->sql_query(NULL,"*",NULL,"si195_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si195_inst = ".db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clflpgo10->excluir(NULL,"si195_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si195_inst = ".db_getsession("DB_instit"));
            if ($clflpgo10->erro_status == 0) {
                throw new Exception($clflpgo10->erro_msg);
            }
        }

        db_fim_transacao();

        /*
         * selecionar informacoes registro 10
         */
        db_inicio_transacao();

        $sSql = "  SELECT
	     rh02_regist,
        '10' as si195_tiporegistro,
        z01_cgccpf as si195_nrodocumento,
        'C' as si195_regime,
        'M' as si195_indtipopagamento,
        (select distinct rh25_vinculo from rhlotavinc where rh25_codigo = rhlota.r70_codigo and rh25_anousu = ".db_getsession('DB_anousu').") AS si195_indsituacaoservidorpensionista,
        rh01_admiss as si195_datconcessaoaposentadoriapensao,

    case
	  when rh20_cargo is not null then rh04_descr
	  else rh37_descr
	end as si195_dsccargo,

	case
	    when h13_tpcont = '20' then 'CRA'
	    when h13_tpcont = '21' then 'CEF'
	    when h13_tpcont = '12' then 'CEF'
	    when h13_tpcont = '19' then 'APO'
	    when h13_tpcont = '01' then 'EPU'
	end as si195_sglcargo,
	rh37_reqcargo as si195_reqcargo,
	' ' as si195_indcessao,
	r70_descr as si195_dsclotacao,
	case
	    when (select distinct rh25_vinculo from rhlotavinc where rh25_codigo = rhlota.r70_codigo and rh25_anousu = ".db_getsession('DB_anousu').") = 'P' then 00
	    when (select distinct rh25_vinculo from rhlotavinc where rh25_codigo = rhlota.r70_codigo and rh25_anousu = ".db_getsession('DB_anousu').") = 'I' then 00
	    when (select distinct rh25_vinculo from rhlotavinc where rh25_codigo = rhlota.r70_codigo and rh25_anousu = ".db_getsession('DB_anousu').") = 'A' then rh02_hrssem
	end as si195_vlrcargahorariasemanal,
	rh01_admiss as si195_datefetexercicio,
	rh05_recis as si195_datexclusao,

	'0.00' as si195_vlrabateteto,


	'D' as si195_natsaldobruto_mensal,

	SUM(CASE WHEN r14_pd = 2 and

	EXISTS((SELECT 1
	  FROM basesr
	  INNER JOIN bases ON r09_anousu = r08_anousu
	  AND r09_mesusu = r08_mesusu
	  AND r09_base = r08_codigo
	  AND r09_instit = r08_instit
	  where gerfsal.r14_rubric = r09_rubric)) = true


       THEN r14_valor ELSE 0 END) AS si195_vlrdeducoes_mensal,

    SUM(CASE WHEN r48_pd = 2 and

	EXISTS((SELECT 1
	  FROM basesr
	  INNER JOIN bases ON r09_anousu = r08_anousu
	  AND r09_mesusu = r08_mesusu
	  AND r09_base = r08_codigo
	  AND r09_instit = r08_instit
	  where gerfcom.r48_rubric = r09_rubric)) = true


       THEN r48_valor ELSE 0 END) AS si195_vlrdeducoes_com,

      SUM(CASE WHEN r35_pd = 2 and

	EXISTS((SELECT 1
	  FROM basesr
	  INNER JOIN bases ON r09_anousu = r08_anousu
	  AND r09_mesusu = r08_mesusu
	  AND r09_base = r08_codigo
	  AND r09_instit = r08_instit
	  where gerfs13.r35_rubric = r09_rubric)) = true


       THEN r35_valor ELSE 0 END) AS si195_vlrdeducoes_13,

       SUM(CASE WHEN r20_pd = 2 and

       EXISTS((SELECT 1
	  FROM basesr
	  INNER JOIN bases ON r09_anousu = r08_anousu
	  AND r09_mesusu = r08_mesusu
	  AND r09_base = r08_codigo
	  AND r09_instit = r08_instit
	  where gerfres.r20_rubric = r09_rubric)) = true


       THEN r20_valor ELSE 0 END) AS si195_vlrdeducoes_res,


	SUM(case when r14_pd = 1 then r14_valor else 0 end) as si195_vlrremuneracaobruta_mensal,
	case
	  when (SUM(case when r14_pd = 1 then r14_valor else 0 end) - SUM(case when r14_pd = 2 then r14_valor else 0 end)) < 0 then 'D'
	  else 'C'
	end as si195_natsaldoliquido_mensal,
	(SUM(case when r14_pd = 1 then r14_valor else 0 end) - SUM(case when r14_pd = 2 then r14_valor else 0 end)) as si195_vlrremuneracaoliquida_mensal,

	'D' as si195_natsaldobruto_com,
	SUM(case when r48_pd = 1 then r48_valor else 0 end) as si195_vlrremuneracaobruta_com,
	case
	  when (SUM(case when r48_pd = 1 then r48_valor else 0 end) - SUM(case when r48_pd = 2 then r48_valor else 0 end)) < 0 then 'D'
	  else 'C'
	end as si195_natsaldoliquido_com,
	(SUM(case when r48_pd = 1 then r48_valor else 0 end) - SUM(case when r48_pd = 2 then r48_valor else 0 end)) as si195_vlrremuneracaoliquida_com,

	'D' as si195_natsaldobruto_13,
	SUM(case when r35_pd = 1 then r35_valor else 0 end) as si195_vlrremuneracaobruta_13,
	case
	  when (SUM(case when r35_pd = 1 then r35_valor else 0 end) - SUM(case when r35_pd = 2 then r35_valor else 0 end)) < 0 then 'D'
	  else 'C'
	end as si195_natsaldoliquido_13,
	(SUM(case when r35_pd = 1 then r35_valor else 0 end) - SUM(case when r35_pd = 2 then r35_valor else 0 end)) as si195_vlrremuneracaoliquida_13,

	'D' as si195_natsaldobruto_res,
	SUM(case when r20_pd = 1 then r20_valor else 0 end) as si195_vlrremuneracaobruta_res,
	case
	  when (SUM(case when r20_pd = 1 then r20_valor else 0 end) - SUM(case when r20_pd = 2 then r20_valor else 0 end)) < 0 then 'D'
	  else 'C'
	end as si195_natsaldoliquido_res,
	(SUM(case when r20_pd = 1 then r20_valor else 0 end) - SUM(case when r20_pd = 2 then r20_valor else 0 end)) as si195_vlrremuneracaoliquida_res

	  FROM rhpessoal
	  INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
	  AND rhpessoalmov.rh02_anousu = ".db_getsession('DB_anousu')."
	  AND rhpessoalmov.rh02_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
	  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."

	  LEFT JOIN gerfsal ON gerfsal.r14_anousu = rhpessoalmov.rh02_anousu
	  AND gerfsal.r14_mesusu = rhpessoalmov.rh02_mesusu
	  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
	  AND gerfsal.r14_regist = rhpessoalmov.rh02_regist
	  AND gerfsal.r14_instit = rhpessoalmov.rh02_instit


	  LEFT JOIN gerfcom ON gerfcom.r48_anousu = rhpessoalmov.rh02_anousu
	  AND gerfcom.r48_mesusu = rhpessoalmov.rh02_mesusu
	  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
	  AND gerfcom.r48_regist = rhpessoalmov.rh02_regist
	  AND gerfcom.r48_instit = rhpessoalmov.rh02_instit

	  LEFT JOIN gerfs13 ON gerfs13.r35_anousu = rhpessoalmov.rh02_anousu
	  AND gerfs13.r35_mesusu = rhpessoalmov.rh02_mesusu
	  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
	  AND gerfs13.r35_regist = rhpessoalmov.rh02_regist
	  AND gerfs13.r35_instit = rhpessoalmov.rh02_instit

	  LEFT JOIN gerfres ON gerfres.r20_anousu = rhpessoalmov.rh02_anousu
	  AND gerfres.r20_mesusu = rhpessoalmov.rh02_mesusu
	  AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
	  AND gerfres.r20_regist = rhpessoalmov.rh02_regist
	  AND gerfres.r20_instit = rhpessoalmov.rh02_instit


	  LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
	  LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
	  AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
	  INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
	  INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
	  AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
	  INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
	  AND rhlota.r70_instit = rhpessoalmov.rh02_instit
	  INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
	  AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
	  LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
	  LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
	  AND rhpespadrao.rh03_anousu = ".db_getsession('DB_anousu')."
	  AND rhpespadrao.rh03_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
	  LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
	  AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
	  AND padroes.r02_regime = rhpespadrao.rh03_regime
	  AND padroes.r02_codigo = rhpespadrao.rh03_padrao
	  AND padroes.r02_instit = ".db_getsession('DB_anousu')."
	  LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
	  AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
	  INNER JOIN tpcontra ON tpcontra.h13_codigo       = rhpessoalmov.rh02_tpcont

	  WHERE
		  (rh02_anousu = ".db_getsession("DB_anousu")." AND rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6'].")

	  AND ((DATE_PART('YEAR',rh01_admiss) = ".db_getsession("DB_anousu")." and DATE_PART('MONTH',rh01_admiss)<=" .$this->sDataFinal['5'].$this->sDataFinal['6'].")
              or (DATE_PART('YEAR',rh01_admiss) < ".db_getsession("DB_anousu")." and DATE_PART('MONTH',rh01_admiss)<=12))

	  AND (
		      DATE_PART('YEAR',rh05_recis)= ".db_getsession("DB_anousu")."
		  and DATE_PART('MONTH',rh05_recis)=" .$this->sDataFinal['5'].$this->sDataFinal['6']."
		  or rh05_recis IS NULL
	  )
	  AND r14_valor is not null
	  AND rh01_sicom = 1
	  GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17
	  ORDER BY rh02_regist asc";

        $rsResult10 = db_query($sSql);
        //echo $sSql;exit;
        //db_criatabela($rsResult10);exit;

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

            $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
            $iQuantTipoPagamento = 0;
            $aTiposPagamento = array();
            if($oDados10->si195_vlrremuneracaobruta_mensal != 0 || $oDados10->si195_vlrremuneracaobruta_res != 0) {
                $iQuantTipoPagamento++;
                if($oDados10->si195_vlrremuneracaobruta_mensal != 0){
                    $aTiposPagamento[$iQuantTipoPagamento] = array(
                        'Matricula'=>$oDados10->rh02_regist,
                        'codreduzidopessoa'=>$oDados10->rh02_regist.'1',
                        'si195_indtipopagamento'=>'M',
                        'si195_vlrdeducoes'=>$oDados10->si195_vlrdeducoes_mensal,
                        'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_mensal,
                        'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_mensal,
                        'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_mensal,
                    );
                }
                if($oDados10->si195_vlrremuneracaobruta_res != 0){
                    $aTiposPagamento[$iQuantTipoPagamento] = array(
                        'Matricula'=>$oDados10->rh02_regist,
                        'codreduzidopessoa'=>$oDados10->rh02_regist.'1',
                        'si195_indtipopagamento'=>'M',
                        'si195_vlrdeducoes'=>$oDados10->si195_vlrdeducoes_res,
                        'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_res,
                        'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_res,
                        'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_res,
                    );
                }
            }
            if($oDados10->si195_vlrremuneracaobruta_com != 0 ) {
                $iQuantTipoPagamento++;
                $aTiposPagamento[$iQuantTipoPagamento] = array(
                    'Matricula'=>$oDados10->rh02_regist,
                    'codreduzidopessoa'=>$oDados10->rh02_regist.'3',
                    'si195_indtipopagamento'=>'E',
                    'si195_vlrdeducoes'=>$oDados10->si195_vlrdeducoes_com,
                    'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_com,
                    'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_com,
                    'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_com,
                );
            }
            if($oDados10->si195_vlrremuneracaobruta_13 != 0 ) {
                $iQuantTipoPagamento++;
                $aTiposPagamento[$iQuantTipoPagamento] = array(
                    'Matricula'=>$oDados10->rh02_regist,
                    'codreduzidopessoa'=>$oDados10->rh02_regist.'2',
                    'si195_indtipopagamento'=>'D',
                    'si195_vlrdeducoes'=>$oDados10->si195_vlrdeducoes_13,
                    'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_13,
                    'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_13,
                    'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_13,
                );
            }
            //print_r($aTiposPagamento);exit;
            for ($iContEx = 1; $iContEx <= $iQuantTipoPagamento; $iContEx++) {

                $clflpgo10                                          = new cl_flpgo102013();
                $clflpgo10->si195_tiporegistro                      = $oDados10->si195_tiporegistro;
                $clflpgo10->si195_nrodocumento                      = $oDados10->si195_nrodocumento; //NOME ALTERADO NO LAYOUT PARA nroDocumento
                $clflpgo10->si195_codreduzidopessoa                 = $aTiposPagamento[$iContEx]['codreduzidopessoa'];
                $clflpgo10->si195_regime             		        = $oDados10->si195_regime;
                $clflpgo10->si195_indtipopagamento                  = $aTiposPagamento[$iContEx]['si195_indtipopagamento'];
                $clflpgo10->si195_indsituacaoservidorpensionista    = $oDados10->si195_indsituacaoservidorpensionista;
                $clflpgo10->si195_dscsituacao                       = $oDados10->si195_dscsituacao;
                $clflpgo10->si195_datconcessaoaposentadoriapensao   = $oDados10->si195_datconcessaoaposentadoriapensao;
                $clflpgo10->si195_dsccargo                          = $oDados10->si195_dsccargo;
                $clflpgo10->si195_sglcargo 							= $oDados10->si195_sglcargo;
                $clflpgo10->si195_dscsiglacargo  					= $oDados10->si195_dscsiglacargo;
                $clflpgo10->si195_reqcargo 							= $oDados10->si195_reqcargo;
                $clflpgo10->si195_indcessao 						= $oDados10->si195_indcessao;
                $clflpgo10->si195_dsclotacao 						= $oDados10->si195_dsclotacao;
                $clflpgo10->si195_vlrcargahorariasemanal 		    = $oDados10->si195_vlrcargahorariasemanal;
                $clflpgo10->si195_datefetexercicio                  = $oDados10->si195_datefetexercicio;
                $clflpgo10->si195_datexclusao                       = $oDados10->si195_datexclusao;
                $clflpgo10->si195_vlrremuneracaobruta               = $aTiposPagamento[$iContEx]['si195_vlrremuneracaobruta'];
                $clflpgo10->si195_natsaldoliquido                   = $aTiposPagamento[$iContEx]['si195_natsaldoliquido'];
                $clflpgo10->si195_vlrremuneracaoliquida             = $aTiposPagamento[$iContEx]['si195_vlrremuneracaoliquida'];
                $clflpgo10->si195_vlrdeducoes                       = $aTiposPagamento[$iContEx]['si195_vlrdeducoes'];;
                $clflpgo10->si195_mes                               = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $clflpgo10->si195_inst                              = db_getsession("DB_instit");

                $clflpgo10->incluir(null);
                if ($clflpgo10->erro_status == 0) {
                    echo $clflpgo10->erro_msg;
                    exit;
                    throw new Exception($clflpgo10->erro_msg);
                }

                //print_r($clflpgo10);
                $sSql2 = "
               Select x.rh02_regist,
               x.si196_tiporegistro,
               x.si196_tiporemuneracao,
               x.si196_desctiporemuneracao,
               x.si196_natsaldodetalhe,
               sum(x.si196_vlrremuneracaodetalhada) as si196_vlrremuneracaodetalhada
               from
          (SELECT rh02_regist,
       '11' AS si196_tiporegistro,
       CASE
           WHEN r08_codigo = 'S001' THEN 01
           WHEN r08_codigo = 'S002' THEN 02
           WHEN r08_codigo = 'S003' THEN 03
           WHEN r08_codigo = 'S004' THEN 04
           WHEN r08_codigo = 'S005' THEN 05
           WHEN r08_codigo = 'S006' THEN 06
           WHEN r08_codigo = 'S007' THEN 07
           WHEN r08_codigo = 'S008' THEN 08
           WHEN r08_codigo = 'S009' THEN 09
           WHEN r08_codigo = 'S010' THEN 10
           WHEN r08_codigo = 'S011' THEN 11
           WHEN r08_codigo = 'S012' THEN 12
           WHEN r08_codigo = 'S013' THEN 13
           WHEN r08_codigo = 'S014' THEN 14
           WHEN r08_codigo = 'S015' THEN 15
           WHEN r08_codigo = 'S016' THEN 16
           WHEN r08_codigo = 'S017' THEN 17
       END AS si196_tiporemuneracao,
       CASE
           WHEN r08_codigo = 'S009' or r08_codigo = 'SP99' THEN rh27_descr
           ELSE ' '
       END AS si196_desctiporemuneracao,
       CASE
           WHEN r14_pd = 1 THEN 'D'
           WHEN r14_pd = 2 THEN 'C'
       END AS si196_natsaldodetalhe,
       r14_valor AS si196_vlrremuneracaodetalhada
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
LEFT JOIN gerfsal ON gerfsal.r14_anousu = rhpessoalmov.rh02_anousu
AND gerfsal.r14_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfsal.r14_regist = rhpessoalmov.rh02_regist
AND gerfsal.r14_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r14_rubric = rh27_rubric
AND r14_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r14_pd in (1))
  AND (r08_codigo BETWEEN 'S001' AND 'S017' or r08_codigo = 'SP99' )

  UNION


  SELECT rh02_regist,
       '11' AS si196_tiporegistro,
       CASE
           WHEN r08_codigo = 'S001' THEN 01
           WHEN r08_codigo = 'S002' THEN 02
           WHEN r08_codigo = 'S003' THEN 03
           WHEN r08_codigo = 'S004' THEN 04
           WHEN r08_codigo = 'S005' THEN 05
           WHEN r08_codigo = 'S006' THEN 06
           WHEN r08_codigo = 'S007' THEN 07
           WHEN r08_codigo = 'S008' THEN 08
           WHEN r08_codigo = 'S009' THEN 09
           WHEN r08_codigo = 'S010' THEN 10
           WHEN r08_codigo = 'S011' THEN 11
           WHEN r08_codigo = 'S012' THEN 12
           WHEN r08_codigo = 'S013' THEN 13
           WHEN r08_codigo = 'S014' THEN 14
           WHEN r08_codigo = 'S015' THEN 15
           WHEN r08_codigo = 'S016' THEN 16
           WHEN r08_codigo = 'S017' THEN 17
       END AS si196_tiporemuneracao,
       CASE
           WHEN r08_codigo = 'S009' or r08_codigo = 'SP99' THEN rh27_descr
           ELSE ' '
       END AS si196_desctiporemuneracao,
       CASE
           WHEN r48_pd = 1 THEN 'D'
           WHEN r48_pd = 2 THEN 'C'
       END AS si196_natsaldodetalhe,
       r48_valor AS si196_vlrremuneracaodetalhada
FROM rhpessoal
 INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  LEFT JOIN gerfcom ON gerfcom.r48_anousu = rhpessoalmov.rh02_anousu
AND gerfcom.r48_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfcom.r48_regist = rhpessoalmov.rh02_regist
AND gerfcom.r48_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r48_rubric = rh27_rubric
AND r48_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r48_pd in (1))
  AND (r08_codigo BETWEEN 'S001' AND 'S017' or r08_codigo = 'SP99' )

  UNION

  SELECT rh02_regist,
       '11' AS si196_tiporegistro,
       CASE
           WHEN r08_codigo = 'S001' THEN 01
           WHEN r08_codigo = 'S002' THEN 02
           WHEN r08_codigo = 'S003' THEN 03
           WHEN r08_codigo = 'S004' THEN 04
           WHEN r08_codigo = 'S005' THEN 05
           WHEN r08_codigo = 'S006' THEN 06
           WHEN r08_codigo = 'S007' THEN 07
           WHEN r08_codigo = 'S008' THEN 08
           WHEN r08_codigo = 'S009' THEN 09
           WHEN r08_codigo = 'S010' THEN 10
           WHEN r08_codigo = 'S011' THEN 11
           WHEN r08_codigo = 'S012' THEN 12
           WHEN r08_codigo = 'S013' THEN 13
           WHEN r08_codigo = 'S014' THEN 14
           WHEN r08_codigo = 'S015' THEN 15
           WHEN r08_codigo = 'S016' THEN 16
           WHEN r08_codigo = 'S017' THEN 17
       END AS si196_tiporemuneracao,
       CASE
           WHEN r08_codigo = 'S009' or r08_codigo = 'SP99' THEN rh27_descr
           ELSE ' '
       END AS si196_desctiporemuneracao,
       CASE
           WHEN r35_pd = 1 THEN 'D'
           WHEN r35_pd = 2 THEN 'C'
       END AS si196_natsaldodetalhe,
       r35_valor AS si196_vlrremuneracaodetalhada
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
 LEFT JOIN gerfs13 ON gerfs13.r35_anousu = rhpessoalmov.rh02_anousu
AND gerfs13.r35_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfs13.r35_regist = rhpessoalmov.rh02_regist
AND gerfs13.r35_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r35_rubric = rh27_rubric
AND r35_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r35_pd in (1))
  AND (r08_codigo BETWEEN 'S001' AND 'S017' or r08_codigo = 'SP99' )

  UNION

    SELECT rh02_regist,
       '11' AS si196_tiporegistro,
       CASE
           WHEN r08_codigo = 'S001' THEN 01
           WHEN r08_codigo = 'S002' THEN 02
           WHEN r08_codigo = 'S003' THEN 03
           WHEN r08_codigo = 'S004' THEN 04
           WHEN r08_codigo = 'S005' THEN 05
           WHEN r08_codigo = 'S006' THEN 06
           WHEN r08_codigo = 'S007' THEN 07
           WHEN r08_codigo = 'S008' THEN 08
           WHEN r08_codigo = 'S009' THEN 09
           WHEN r08_codigo = 'S010' THEN 10
           WHEN r08_codigo = 'S011' THEN 11
           WHEN r08_codigo = 'S012' THEN 12
           WHEN r08_codigo = 'S013' THEN 13
           WHEN r08_codigo = 'S014' THEN 14
           WHEN r08_codigo = 'S015' THEN 15
           WHEN r08_codigo = 'S016' THEN 16
           WHEN r08_codigo = 'S017' THEN 17
       END AS si196_tiporemuneracao,
       CASE
           WHEN r08_codigo = 'S009' or r08_codigo = 'SP99' THEN rh27_descr
           ELSE ' '
       END AS si196_desctiporemuneracao,
       CASE
           WHEN r20_pd = 1 THEN 'D'
           WHEN r20_pd = 2 THEN 'C'
       END AS si196_natsaldodetalhe,
       r20_valor AS si196_vlrremuneracaodetalhada
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  LEFT JOIN gerfres ON gerfres.r20_anousu = rhpessoalmov.rh02_anousu
AND gerfres.r20_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfres.r20_regist = rhpessoalmov.rh02_regist
AND gerfres.r20_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r20_rubric = rh27_rubric
AND r20_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r20_pd in (1))
  AND (r08_codigo BETWEEN 'S001' AND 'S017' or r08_codigo = 'SP99' ) ) as x
  group by x.rh02_regist, x.si196_tiporegistro,x.si196_tiporemuneracao, x.si196_desctiporemuneracao,x.si196_natsaldodetalhe";
                //echo '<pre>';
                //print_r($clflpgo10);
                //echo $sSql2;exit;

                $rsResult11 = db_query($sSql2);
                db_criatabela($rsResult11);

                for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

                    $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

                    $clflpgo11 = new cl_flpgo112013();
                    $clflpgo11->si196_tiporegistro            = $oDados11->si196_tiporegistro;
                    $clflpgo11->si196_reg10                   = $clflpgo10->si195_sequencial;
                    $clflpgo11->si196_nrodocumento            = $clflpgo10->si195_nrodocumento;
                    $clflpgo11->si196_codreduzidopessoa       = $clflpgo10->si195_codreduzidopessoa;
                    $clflpgo11->si196_tiporemuneracao         = $oDados11->si196_tiporemuneracao;
                    $clflpgo11->si196_desctiporemuneracao              = ' ';//$oDados11->si196_desctiporemuneracao;
                    $clflpgo11->si196_vlrremuneracaodetalhada = $oDados11->si196_vlrremuneracaodetalhada;
                    $clflpgo11->si196_mes                     = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clflpgo11->si196_inst                    = db_getsession("DB_instit");
                    //echo '<pre>';
                    //print_r($clflpgo11);exit;
                    $clflpgo11->incluir(null);

                    if ($clflpgo11->erro_status == 0) {
                        throw new Exception($clflpgo11->erro_msg);
                    }

                }

                $sSql3 = "
               Select x.rh02_regist,
               x.si197_tiporegistro,
               x.si197_tipodesconto,
               x.si197_desctiporemuneracao,
               sum(x.si197_vlrdescontodetalhado) as si197_vlrdescontodetalhado
               from
          (SELECT rh02_regist,
       '12' AS si197_tiporegistro,
       CASE
           WHEN r08_codigo = 'S050' THEN 50
           WHEN r08_codigo = 'S051' THEN 51
           WHEN r08_codigo = 'S052' THEN 52
           WHEN r08_codigo = 'S053' THEN 53
           WHEN r08_codigo = 'S054' THEN 54
           WHEN r08_codigo = 'S055' THEN 55
           WHEN r08_codigo = 'S059' THEN 59
           WHEN r08_codigo = 'S063' THEN 63
           WHEN r08_codigo = 'S064' THEN 64
           WHEN r08_codigo = 'S065' THEN 65
           WHEN r08_codigo = 'S066' THEN 66
           WHEN r08_codigo = 'S076' THEN 76
           WHEN r08_codigo = 'SD99' THEN 99
       END AS si197_tipodesconto,
       CASE
           WHEN r08_codigo = 'SD99' THEN rh27_descr
           ELSE ' '
       END AS si197_desctiporemuneracao,
       CASE
           WHEN r14_pd = 1 THEN 'D'
           WHEN r14_pd = 2 THEN 'C'
       END AS si197_natsaldodetalhe,
       r14_valor AS si197_vlrdescontodetalhado
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
LEFT JOIN gerfsal ON gerfsal.r14_anousu = rhpessoalmov.rh02_anousu
AND gerfsal.r14_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfsal.r14_regist = rhpessoalmov.rh02_regist
AND gerfsal.r14_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r14_rubric = rh27_rubric
AND r14_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r14_pd in (2))
  AND (r08_codigo BETWEEN 'S050' AND 'S076' or r08_codigo = 'SD99' )

  UNION


  SELECT rh02_regist,
       '12' AS si197_tiporegistro,
       CASE
           WHEN r08_codigo = 'S050' THEN 50
           WHEN r08_codigo = 'S051' THEN 51
           WHEN r08_codigo = 'S052' THEN 52
           WHEN r08_codigo = 'S053' THEN 53
           WHEN r08_codigo = 'S054' THEN 54
           WHEN r08_codigo = 'S055' THEN 55
           WHEN r08_codigo = 'S059' THEN 59
           WHEN r08_codigo = 'S063' THEN 63
           WHEN r08_codigo = 'S064' THEN 64
           WHEN r08_codigo = 'S065' THEN 65
           WHEN r08_codigo = 'S066' THEN 66
           WHEN r08_codigo = 'S076' THEN 76
           WHEN r08_codigo = 'SD99' THEN 99
       END AS si197_tipodesconto,
       CASE
           WHEN r08_codigo = 'SD99' THEN rh27_descr
           ELSE ' '
       END AS si197_desctiporemuneracao,
       CASE
           WHEN r48_pd = 1 THEN 'D'
           WHEN r48_pd = 2 THEN 'C'
       END AS si197_natsaldodetalhe,
       r48_valor AS si197_vlrdescontodetalhado
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  LEFT JOIN gerfcom ON gerfcom.r48_anousu = rhpessoalmov.rh02_anousu
AND gerfcom.r48_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfcom.r48_regist = rhpessoalmov.rh02_regist
AND gerfcom.r48_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r48_rubric = rh27_rubric
AND r48_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r48_pd in (2))
  AND (r08_codigo BETWEEN 'S050' AND 'S076' or r08_codigo = 'SD99' )

  UNION

  SELECT rh02_regist,
       '12' AS si197_tiporegistro,
       CASE
           WHEN r08_codigo = 'S050' THEN 50
           WHEN r08_codigo = 'S051' THEN 51
           WHEN r08_codigo = 'S052' THEN 52
           WHEN r08_codigo = 'S053' THEN 53
           WHEN r08_codigo = 'S054' THEN 54
           WHEN r08_codigo = 'S055' THEN 55
           WHEN r08_codigo = 'S059' THEN 59
           WHEN r08_codigo = 'S063' THEN 63
           WHEN r08_codigo = 'S064' THEN 64
           WHEN r08_codigo = 'S065' THEN 65
           WHEN r08_codigo = 'S066' THEN 66
           WHEN r08_codigo = 'S076' THEN 76
           WHEN r08_codigo = 'SD99' THEN 99
       END AS si197_tipodesconto,
       CASE
           WHEN r08_codigo = 'SD99' THEN rh27_descr
           ELSE ' '
       END AS si197_desctiporemuneracao,
       CASE
           WHEN r35_pd = 1 THEN 'D'
           WHEN r35_pd = 2 THEN 'C'
       END AS si197_natsaldodetalhe,
       r35_valor AS si197_vlrdescontodetalhado
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
 LEFT JOIN gerfs13 ON gerfs13.r35_anousu = rhpessoalmov.rh02_anousu
AND gerfs13.r35_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfs13.r35_regist = rhpessoalmov.rh02_regist
AND gerfs13.r35_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r35_rubric = rh27_rubric
AND r35_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r35_pd in (2))
  AND (r08_codigo BETWEEN 'S050' AND 'S076' or r08_codigo = 'SD99' )

  UNION

    SELECT rh02_regist,
       '12' AS si197_tiporegistro,
       CASE
           WHEN r08_codigo = 'S050' THEN 50
           WHEN r08_codigo = 'S051' THEN 51
           WHEN r08_codigo = 'S052' THEN 52
           WHEN r08_codigo = 'S053' THEN 53
           WHEN r08_codigo = 'S054' THEN 54
           WHEN r08_codigo = 'S055' THEN 55
           WHEN r08_codigo = 'S059' THEN 59
           WHEN r08_codigo = 'S063' THEN 63
           WHEN r08_codigo = 'S064' THEN 64
           WHEN r08_codigo = 'S065' THEN 65
           WHEN r08_codigo = 'S066' THEN 66
           WHEN r08_codigo = 'S076' THEN 76
           WHEN r08_codigo = 'SD99' THEN 99
       END AS si197_tipodesconto,
       CASE
           WHEN r08_codigo = 'SD99' THEN rh27_descr
           ELSE ' '
       END AS si197_desctiporemuneracao,
       CASE
           WHEN r20_pd = 1 THEN 'D'
           WHEN r20_pd = 2 THEN 'C'
       END AS si197_natsaldodetalhe,
       r20_valor AS si197_vlrdescontodetalhado
FROM rhpessoal
INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
AND rhpessoalmov.rh02_anousu = ".db_getsession("DB_anousu")."
AND rhpessoalmov.rh02_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
  LEFT JOIN gerfres ON gerfres.r20_anousu = rhpessoalmov.rh02_anousu
AND gerfres.r20_mesusu = rhpessoalmov.rh02_mesusu
AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
AND gerfres.r20_regist = rhpessoalmov.rh02_regist
AND gerfres.r20_instit = rhpessoalmov.rh02_instit

LEFT JOIN rhpescargo ON rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhcargo ON rhcargo.rh04_codigo = rhpescargo.rh20_cargo
AND rhcargo.rh04_instit = rhpessoalmov.rh02_instit
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
INNER JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
AND rhfuncao.rh37_instit = ".db_getsession('DB_instit')."
INNER JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota
AND rhlota.r70_instit = rhpessoalmov.rh02_instit
INNER JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
AND rhpespadrao.rh03_anousu = ".db_getsession("DB_anousu")."
AND rhpespadrao.rh03_mesusu = " .$this->sDataFinal['5'].$this->sDataFinal['6']."
LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu
AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu
AND padroes.r02_regime = rhpespadrao.rh03_regime
AND padroes.r02_codigo = rhpespadrao.rh03_padrao
AND padroes.r02_instit = ".db_getsession('DB_instit')."
LEFT JOIN rhlotaexe ON rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
AND rhlotaexe.rh26_codigo = rhlota.r70_codigo
LEFT JOIN rhlotavinc ON rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
AND rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
AND rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont

INNER JOIN rhrubricas ON r20_rubric = rh27_rubric
AND r20_instit = rh27_instit
INNER JOIN basesr ON r09_rubric = rh27_rubric
INNER JOIN bases ON r09_anousu = r08_anousu
AND r09_mesusu = r08_mesusu
AND r09_base = r08_codigo
AND r09_instit = r08_instit
WHERE rh02_regist = $oDados10->rh02_regist
  AND (r20_pd in (2))
  AND (r08_codigo BETWEEN 'S050' AND 'S076' or r08_codigo = 'SD99' ) ) as x
  group by x.rh02_regist,
               x.si197_tiporegistro,
               x.si197_tipodesconto,
               x.si197_desctiporemuneracao";
                //echo '<pre>';
                //print_r($clflpgo10);
                //echo $sSql2;exit;

                $rsResult12 = db_query($sSql3);
                //db_criatabela($rsResult11);

                for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

                    $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

                    $clflpgo12 = new cl_flpgo122013();
                    $clflpgo12->si197_tiporegistro            = $oDados12->si197_tiporegistro;
                    $clflpgo12->si197_reg10                   = $clflpgo10->si195_sequencial;
                    $clflpgo12->si197_nrodocumento            = $clflpgo10->si195_nrodocumento;
                    $clflpgo12->si197_codreduzidopessoa       = $clflpgo10->si195_codreduzidopessoa;
                    $clflpgo12->si197_tipodesconto            = $oDados12->si197_tipodesconto;
                    $clflpgo12->si197_vlrdescontodetalhado    = $oDados12->si197_vlrdescontodetalhado;
                    $clflpgo12->si197_mes                     = $this->sDataFinal['5'] . $this->sDataFinal['6'];
                    $clflpgo12->si197_inst                    = db_getsession("DB_instit");
                    //echo '<pre>';
                    //print_r($clflpgo11);exit;
                    $clflpgo12->incluir(null);

                    if ($clflpgo12->erro_status == 0) {
                        throw new Exception($clflpgo12->erro_msg);
                    }

                }

            }
        }

        //echo '<pre>';
        //print_r($aTiposPagamento);exit;

        db_fim_transacao();

        $oGerarFLPGO = new GerarFLPGO();
        $oGerarFLPGO->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarFLPGO->gerarDados();

    }

}
