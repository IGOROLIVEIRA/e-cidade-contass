<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_flpgo102020_classe.php");
require_once ("classes/db_flpgo112020_classe.php");
require_once ("classes/db_flpgo122020_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/flpg/GerarFLPGO.model.php");


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

	public function getcpf($z01_numcgm,$matricula){
        $sql = "select z01_cgccpf from cgm where z01_numcgm = {$z01_numcgm}";
        $result = db_utils::fieldsMemory(db_query($sql), 0)->z01_cgccpf;
        if ( $result == 0) {
            $result = "";
        }
        return $result;
    }

	/**
	 *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
	 *@return Array
	 */
	public function getCampos() {

	}
  function convert_accented_characters($str){
    setlocale (LC_ALL, 'pt_BR');
    $new_string =  iconv('UTF-8','ASCII//IGNORE',$str);
    if(strlen($new_string) != strlen($str)){
      $new_string = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($str)));
      if(strlen($new_string) != strlen($str)){
        return $str;
      }else{
        return $new_string;
      }
    }else{
      return $new_string;
    }
  }



	/**
	 * selecionar os dados de Notas Fiscais referentes a instituicao logada
	 *
	 */
	public function gerarDados() {

		$clflpgo10 = new cl_flpgo102020();
		$clflpgo11 = new cl_flpgo112020();
		$clflpgo12 = new cl_flpgo122020();

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



		$sSql = "select
		r14_regist as rh02_regist,
		'10' as si195_tiporegistro,
		z01_cgccpf as si195_nrodocumento,
    'C' as si195_regime,
    'M' as si195_indtipopagamento,
   rh30_vinculo,
   rh02_cgminstituidor,
   rh02_dtobitoinstituidor,
   rh02_tipoparentescoinst,
       CASE
           WHEN rh37_exerceatividade = 't' THEN 1
           WHEN rh37_exerceatividade = 'f' THEN 2
           ELSE NULL
       END AS rh37_exerceatividade,
    case
    when rh05_recis < '{$this->sDataInicial}' then  'O'
    else COALESCE((select distinct rh25_vinculo from rhlotavinc where rh25_codigo = rhlota.r70_codigo and rh25_anousu = ".db_getsession('DB_anousu')." limit 1),'A')
      end as si195_indsituacaoservidorpensionista,
      case when rh05_recis < '{$this->sDataInicial}' then (SELECT r59_descr
FROM rescisao
WHERE (r59_anousu,
       r59_mesusu,
       r59_regime,
       r59_causa,
       r59_caub) = (rh02_anousu,
                    rh02_mesusu,
                    rh30_regime,
                    rh05_causa,
                    rh05_caub) LIMIT 1) else '' end as si195_dscsituacao,
      case when rh30_vinculo = 'P' AND rh30_naturezaregime = 4 then 2 
           when rh30_vinculo = 'P' AND rh30_naturezaregime != 4 then 1
      else null end as si195_indpensionistaprevidenciario,
    rh01_admiss as si195_datconcessaoaposentadoriapensao,
    case
    when rh20_cargo <> 0 then rh04_descr
    else rh37_descr
     end as si195_dsccargo,
   case
   when rh37_cbo is not null then rh37_cbo
   else '0'
     end as rh37_cbo,
   rh37_atividadedocargo,
   h13_dscapo,
   case
   when h13_tipocargo = '1' then 'CEF'
   when h13_tipocargo = '2' then 'CRA'
   when h13_tipocargo = '3' then 'CRR'
   when h13_tipocargo = '4' then 'FPU'
   when h13_tipocargo = '5' then 'EPU'
   when h13_tipocargo = '6' then 'APO'
   when h13_tipocargo = '7' then 'STP'
   when h13_tipocargo = '8' then 'OTC'
   end as si195_sglcargo,
   case
   when h13_tipocargo = '8' then h13_descr
   end as si195_dscsiglacargo,
   rh37_reqcargo as si195_reqcargo,
   case
   when rh01_tipadm = '1' then ' '
   when rh01_tipadm = '2' then ' '
   when rh01_tipadm = '3' then 'SCS'
   when rh01_tipadm = '4' then 'SCO'
   end as si195_indcessao,
   r70_descr as si195_dsclotacao,
   case
   when rh30_vinculo = 'P' then 00
   when rh30_vinculo = 'I' then 00
   when rh30_vinculo = 'A' then rh02_hrssem
   end as si195_vlrcargahorariasemanal,
   rh01_admiss as si195_datefetexercicio,
   rh05_recis as si195_datexclusao,

   '0.00' as si195_vlrabateteto,

   sum (case when y.ordem = 'gerfsal' or y.ordem = 'gerfres'  then desconto else 0 end) AS si195_vlrdescontos_mensal,

   sum (case when y.ordem = 'gerfcom' then desconto else 0 end) AS si195_vlrdescontos_com,

   sum (case when y.ordem = 'gerfs13' then desconto else 0 end) AS si195_vlrdescontos_13,

   sum (case when y.ordem = 'gerfres' then desconto else 0 end) AS si195_vlrdescontos_res,

   sum (case when y.ordem = 'gerfsal' then provento else 0 end) as si195_vlrremuneracaobruta_mensal,

   case when
   round((sum (case when y.ordem = 'gerfsal' or y.ordem = 'gerfres'  then provento else 0 end) - sum (case when y.ordem = 'gerfsal' or y.ordem = 'gerfres'  then desconto else 0 end) ),2)
   < 0 then 'D'
   else 'C'
     end as si195_natsaldoliquido_mensal,
   sum (case when y.ordem = 'gerfsal' or y.ordem = 'gerfres'  then provento else 0 end) - sum (case when y.ordem = 'gerfsal' or y.ordem = 'gerfres'  then desconto else 0 end) as si195_vlrremuneracaoliquida_mensal,

   sum (case when y.ordem = 'gerfcom'  then provento else 0 end) as si195_vlrremuneracaobruta_com,
   case when
   round((sum (case when y.ordem = 'gerfcom' then provento else 0 end) - sum (case when y.ordem = 'gerfcom' then desconto else 0 end) ),2)
   < 0 then 'D'
   else 'C'
     end as si195_natsaldoliquido_com,
   sum (case when y.ordem = 'gerfcom' then provento else 0 end) - sum (case when y.ordem = 'gerfcom' then desconto else 0 end) as si195_vlrremuneracaoliquida_com,

   sum (case when y.ordem = 'gerfs13'  then provento else 0 end) as si195_vlrremuneracaobruta_13,
   case when
   round((sum (case when y.ordem = 'gerfs13' then provento else 0 end) - sum (case when y.ordem = 'gerfs13' then desconto else 0 end) ),2)
   < 0 then 'D'
   else 'C'
     end as si195_natsaldoliquido_13,
   sum (case when y.ordem = 'gerfs13' then provento else 0 end) - sum (case when y.ordem = 'gerfs13' then desconto else 0 end) as si195_vlrremuneracaoliquida_13,

   sum (case when y.ordem = 'gerfres'  then provento else 0 end) as si195_vlrremuneracaobruta_res,
   case when
   round((sum (case when y.ordem = 'gerfres' then provento else 0 end) - sum (case when y.ordem = 'gerfres' then desconto else 0 end) ),2)
   < 0 then 'D'
   else 'C'
     end as si195_natsaldoliquido_res,
   sum (case when y.ordem = 'gerfres' then provento else 0 end) - sum (case when y.ordem = 'gerfres' then desconto else 0 end) as si195_vlrremuneracaoliquida_res
   FROM
   (
   SELECT 'gerfsal' AS ordem,
   'R950'::varchar(4) AS rubrica,
   provento,
   desconto,
   0 AS quant,
   'TOTAL'::varchar(40),
   ''::varchar(1) AS tipo,
   ''::varchar(10) AS provdesc,
   r14_regist

   FROM
   (SELECT r14_regist,
   sum(CASE WHEN r14_pd = 1 THEN r14_valor ELSE 0 END) AS provento,
   sum(CASE WHEN r14_pd = 2 THEN r14_valor ELSE 0 END) AS desconto
   FROM gerfsal
   INNER JOIN rhrubricas ON rh27_rubric = r14_rubric
   AND rh27_instit = ".db_getsession('DB_instit')."
   WHERE r14_anousu = ".db_getsession('DB_anousu')."
   AND r14_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
   AND r14_instit = ".db_getsession('DB_instit')."
   AND r14_pd != 3
   group by r14_regist) AS x
   union
   SELECT 'gerfs13' AS ordem,
   'R950'::varchar(4) AS rubrica,
   provento,
   desconto,
   0 AS quant,
   'TOTAL'::varchar(40),
   ''::varchar(1) AS tipo,
   ''::varchar(10) AS provdesc,
   r35_regist
   FROM
   (SELECT r35_regist,
   sum(CASE WHEN r35_pd = 1 THEN r35_valor ELSE 0 END) AS provento,
   sum(CASE WHEN r35_pd = 2 THEN r35_valor ELSE 0 END) AS desconto
   FROM gerfs13
   INNER JOIN rhrubricas ON rh27_rubric = r35_rubric
   AND rh27_instit = ".db_getsession('DB_instit')."
   WHERE r35_anousu = ".db_getsession('DB_anousu')."
   AND r35_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
   AND r35_instit = ".db_getsession('DB_instit')."
   AND r35_pd != 3
   group by r35_regist) AS x
   union
   SELECT 'gerfcom' AS ordem,
   'R950'::varchar(4) AS rubrica,
   provento,
   desconto,
   0 AS quant,
   'TOTAL'::varchar(40),
   ''::varchar(1) AS tipo,
   ''::varchar(10) AS provdesc,
   r48_regist
   FROM
   (SELECT r48_regist,
   sum(CASE WHEN r48_pd = 1 THEN r48_valor ELSE 0 END) AS provento,
   sum(CASE WHEN r48_pd = 2 THEN r48_valor ELSE 0 END) AS desconto
   FROM gerfcom
   INNER JOIN rhrubricas ON rh27_rubric = r48_rubric
   AND rh27_instit = ".db_getsession('DB_instit')."
   WHERE r48_anousu = ".db_getsession('DB_anousu')."
   AND r48_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
   AND r48_instit = ".db_getsession('DB_instit')."
   AND r48_pd != 3
   group by r48_regist) AS x
   union
   SELECT 'gerfres' AS ordem,
   'R950'::varchar(4) AS rubrica,
   provento,
   desconto,
   0 AS quant,
   'TOTAL'::varchar(40),
   ''::varchar(1) AS tipo,
   ''::varchar(10) AS provdesc,
   r20_regist
   FROM
   (SELECT r20_regist,
   sum(CASE WHEN r20_pd = 1 THEN r20_valor ELSE 0 END) AS provento,
   sum(CASE WHEN r20_pd = 2 THEN r20_valor ELSE 0 END) AS desconto
   FROM gerfres
   INNER JOIN rhrubricas ON rh27_rubric = r20_rubric
   AND rh27_instit = ".db_getsession('DB_instit')."
   WHERE r20_anousu = ".db_getsession('DB_anousu')."
   AND r20_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
   AND r20_instit = ".db_getsession('DB_instit')."
   AND r20_pd != 3
   group by r20_regist) AS x

   ) as y
   INNER JOIN rhpessoal on rhpessoal.rh01_regist = y.r14_regist
   INNER JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
   AND rhpessoalmov.rh02_anousu = ".db_getsession('DB_anousu')."
   AND rhpessoalmov.rh02_mesusu = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
   AND rhpessoalmov.rh02_instit = ".db_getsession('DB_instit')."
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
   AND padroes.r02_instit = ".db_getsession('DB_instit')."
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
   or rh05_recis IS NULL OR (((DATE_PART('YEAR',rh05_recis) < ".db_getsession("DB_anousu").")
       OR (DATE_PART('YEAR',rh05_recis) <= ".db_getsession("DB_anousu")."
           AND DATE_PART('MONTH',rh05_recis)<" .$this->sDataFinal['5'].$this->sDataFinal['6']."))
  AND (rh02_regist IN
    (SELECT r48_regist
     FROM gerfcom
     WHERE r48_anousu = ".db_getsession("DB_anousu")."
       AND r48_mesusu =" .$this->sDataFinal['5'].$this->sDataFinal['6'].")
  OR rh02_regist IN
    (SELECT r14_regist
     FROM gerfsal
     WHERE r14_anousu = ".db_getsession("DB_anousu")."
       AND r14_mesusu =" .$this->sDataFinal['5'].$this->sDataFinal['6'].")
  OR rh02_regist IN
    (SELECT r35_regist
     FROM gerfs13
     WHERE r35_anousu = ".db_getsession("DB_anousu")."
       AND r35_mesusu =" .$this->sDataFinal['5'].$this->sDataFinal['6'].")
  OR rh02_regist IN
    (SELECT r20_regist
     FROM gerfres
     WHERE r20_anousu = ".db_getsession("DB_anousu")."
       AND r20_mesusu =" .$this->sDataFinal['5'].$this->sDataFinal['6']."))))
   AND   rh01_sicom = 1
   AND rh01_instit = ".db_getsession('DB_instit')."
   GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,rh05_recis
   ";

   $rsResult10 = db_query($sSql);//echo $sSql;db_criatabela($rsResult10);exit;

   for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

     $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
     $iQuantTipoPagamento = 0;
     $aTiposPagamento = array();
    if($oDados10->si195_vlrremuneracaobruta_mensal != 0){
      $iQuantTipoPagamento++;
      $aTiposPagamento[$iQuantTipoPagamento] = array(
      'Matricula'=>$oDados10->rh02_regist,
      'codreduzidopessoa'=>$oDados10->rh02_regist.'1',
      'si195_indtipopagamento'=>'M',
      'si195_vlrdescontos'=>$oDados10->si195_vlrdescontos_mensal,
      'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_mensal,
      'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_mensal,
      'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_mensal,
      'tipo'=>'1',
      );
   }
   if($oDados10->si195_vlrremuneracaobruta_res != 0){
     $iQuantTipoPagamento++;
     $aTiposPagamento[$iQuantTipoPagamento] = array(
      'Matricula'=>$oDados10->rh02_regist,
      'codreduzidopessoa'=>$oDados10->rh02_regist.'1',
      'si195_indtipopagamento'=>'M',
      'si195_vlrdescontos'=>$oDados10->si195_vlrdescontos_res,
      'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_res,
      'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_res,
      'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_res,
      'tipo'=>'2',
      );
   }
   if($oDados10->si195_vlrremuneracaobruta_com != 0 ) {
    $iQuantTipoPagamento++;
    $aTiposPagamento[$iQuantTipoPagamento] = array(
     'Matricula'=>$oDados10->rh02_regist,
     'codreduzidopessoa'=>$oDados10->rh02_regist.'3',
     'si195_indtipopagamento'=>'E',
     'si195_vlrdescontos'=>$oDados10->si195_vlrdescontos_com,
     'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_com,
     'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_com,
     'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_com,
     'tipo'=>'3',
     );
  }
  if($oDados10->si195_vlrremuneracaobruta_13 != 0 ) {
    $iQuantTipoPagamento++;
    $aTiposPagamento[$iQuantTipoPagamento] = array(
     'Matricula'=>$oDados10->rh02_regist,
     'codreduzidopessoa'=>$oDados10->rh02_regist.'2',
     'si195_indtipopagamento'=>'D',
     'si195_vlrdescontos'=>$oDados10->si195_vlrdescontos_13,
     'si195_vlrremuneracaobruta'=>$oDados10->si195_vlrremuneracaobruta_13,
     'si195_natsaldoliquido'=>$oDados10->si195_natsaldoliquido_13,
     'si195_vlrremuneracaoliquida'=>$oDados10->si195_vlrremuneracaoliquida_13,
     'tipo'=>'4',
     );
  }
  //Descrição do tipo de pagamento extra
  for ($iContTiposPagamento=1; $iContTiposPagamento <= count($aTiposPagamento); $iContTiposPagamento++) { 
    if($aTiposPagamento[$iContTiposPagamento]['si195_indtipopagamento'] == 'E'){
      //Consulta se o servidor possui ferias cadastradas no mes
      $sSqlFerias = "SELECT *
      FROM cadferia
      WHERE r30_proc1 = '".db_getsession("DB_anousu")."/".$this->sDataFinal['5'].$this->sDataFinal['6']."'
      AND r30_regist = ".$oDados10->rh02_regist."
      ORDER BY r30_perai";
      $rsResultFerias = db_query($sSqlFerias);
      if(pg_num_rows($rsResultFerias)>0){
        $aTiposPagamento[$iContTiposPagamento]['si195_dsctipopagextra'] = 'FERIAS';
      }else{

        $sSqlRubricaCom = "SELECT rh27_descr
        FROM gerfcom
        INNER JOIN rhrubricas ON r48_rubric = rh27_rubric
        AND r48_instit = rh27_instit
        WHERE r48_anousu = ".db_getsession("DB_anousu")."
        AND r48_mesusu = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
        AND r48_regist = ".$oDados10->rh02_regist."
        ORDER BY r48_rubric LIMIT 1";
        $rsResultRubricaCom = db_query($sSqlRubricaCom);
        $oResultRubricaCom = db_utils::fieldsMemory($rsResultRubricaCom, 0);
        $aTiposPagamento[$iContTiposPagamento]['si195_dsctipopagextra'] = $oResultRubricaCom->rh27_descr;
      }

    }

  }
  $dscAPO = ' ';

  if($oDados10->si195_sglcargo == 'APO'){
      $dscAPO = $oDados10->h13_dscapo;
  }

  for ($iContEx = 1; $iContEx <= $iQuantTipoPagamento; $iContEx++) {

        $clflpgo10                                          = new cl_flpgo102020();
        $clflpgo10->si195_tiporegistro                      = $oDados10->si195_tiporegistro;
        $clflpgo10->si195_codvinculopessoa                  = $oDados10->rh02_regist;
		$clflpgo10->si195_regime             		        = $oDados10->si195_regime;
		$clflpgo10->si195_indtipopagamento                  = $aTiposPagamento[$iContEx]['si195_indtipopagamento'];
        $clflpgo10->si195_dsctipopagextra                   = $this->convert_accented_characters($aTiposPagamento[$iContEx]['si195_dsctipopagextra']);
        $clflpgo10->si195_indsituacaoservidorpensionista    = $oDados10->si195_indsituacaoservidorpensionista;
        $clflpgo10->si195_dscsituacao                       = $this->convert_accented_characters($oDados10->si195_dscsituacao);
        $clflpgo10->si195_indpensionistaprevidenciario      = $oDados10->si195_indpensionistaprevidenciario;
        if($oDados10->rh30_vinculo == 'P') {
            if($oDados10->rh02_cgminstituidor == "" || $oDados10->rh02_cgminstituidor == null){
                $clflpgo10->si195_nrocpfinstituidor         = "";
            }else{
                $clflpgo10->si195_nrocpfinstituidor         = $this->getcpf($oDados10->rh02_cgminstituidor,$oDados10->rh02_regist);
            }
            $clflpgo10->si195_datobitoinstituidor           = implode("-",array_reverse(explode("-",$oDados10->rh02_dtobitoinstituidor)));
            $clflpgo10->si195_tipodependencia               = $oDados10->rh02_tipoparentescoinst;
        }else{
            $clflpgo10->si195_nrocpfinstituidor             = "";
            $clflpgo10->si195_datobitoinstituidor           = "";
            $clflpgo10->si195_tipodependencia               = "";
        }
        $clflpgo10->si195_dscdependencia                       = ' ';
        $clflpgo10->si195_datafastpreliminar                   = NULL;
        $clflpgo10->si195_datconcessaoaposentadoriapensao   = $oDados10->si195_datconcessaoaposentadoriapensao;
        $clflpgo10->si195_dsccargo                          = $this->convert_accented_characters($oDados10->si195_dsccargo);
        $clflpgo10->si195_codcargo                          = ($oDados10->si195_indsituacaoservidorpensionista!='P')?$oDados10->rh37_cbo:0;
        $clflpgo10->si195_sglcargo 							= $this->convert_accented_characters($oDados10->si195_sglcargo);
        $clflpgo10->si195_dscsiglacargo                     = $this->convert_accented_characters($oDados10->si195_dscsiglacargo);
        $clflpgo10->si195_dscapo           					= $this->convert_accented_characters($dscAPO);
        $clflpgo10->si195_natcargo                          = $this->convert_accented_characters($oDados10->si195_reqcargo);
        $clflpgo10->si195_dscnatcargo 						= ($oDados10->si195_reqcargo == 4)?substr($this->convert_accented_characters($oDados10->rh37_atividadedocargo),0,150):' ';
        $clflpgo10->si195_indcessao 						= $this->convert_accented_characters($oDados10->si195_indcessao);
        $clflpgo10->si195_dsclotacao 						= $this->convert_accented_characters($oDados10->si195_dsclotacao);
        $clflpgo10->si195_indsalaaula 						= ($oDados10->rh30_vinculo != 'I' ? $oDados10->rh37_exerceatividade : '');
        $clflpgo10->si195_vlrcargahorariasemanal 		    = ($oDados10->si195_sglcargo != 'APO') ? $oDados10->si195_vlrcargahorariasemanal : '';
        $clflpgo10->si195_datefetexercicio                  = $oDados10->si195_datefetexercicio;
        $clflpgo10->si195_datcomissionado                   = $oDados10->si195_datefetexercicio;
        $clflpgo10->si195_datexclusao                       = $oDados10->si195_datexclusao;
        $clflpgo10->si195_datcomissionadoexclusao           = $oDados10->si195_datexclusao;
        $clflpgo10->si195_vlrremuneracaobruta               = $aTiposPagamento[$iContEx]['si195_vlrremuneracaobruta'];
        $clflpgo10->si195_vlrdescontos                      = $aTiposPagamento[$iContEx]['si195_vlrdescontos'];
        $clflpgo10->si195_vlrremuneracaoliquida             = $aTiposPagamento[$iContEx]['si195_vlrremuneracaoliquida'];
        $clflpgo10->si195_natsaldoliquido                   = $aTiposPagamento[$iContEx]['si195_natsaldoliquido'];
        $clflpgo10->si195_mes                               = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $clflpgo10->si195_inst                              = db_getsession("DB_instit");

        $clflpgo10->incluir(null);
        if ($clflpgo10->erro_status == 0) {
         echo $clflpgo10->erro_msg;
         exit;
         throw new Exception($clflpgo10->erro_msg);
       }

				//print_r($clflpgo10);
       $sSql2 = "select
       x.si196_tiporegistro,
       CASE
       when x.tipo = 'gerfsal' then 'M'
       when x.tipo = 'gerfres' then 'M'
       when x.tipo = 'gerfcom' then 'E'
       when x.tipo = 'gerfs13' then 'D'
       end as si196_indtipopagamento,
       x.rh02_regist as si196_codvinculopessoa,
       x.si196_desctiporemuneracao as si196_desctiporubrica,
       sum(x.si196_vlrremuneracaodetalhada) AS si196_vlrremuneracaodetalhada,
       x.si196_desctiporemuneracao,
       x.rh02_regist,
       x.si196_tiporemuneracao,
       x.si196_tiporemuneracao as si196_codrubricaremuneracao,
       x.si196_natsaldodetalhe,
       x.tipo
       from
       (SELECT 'gerfsal' as tipo,rh02_regist,

       '11' AS si196_tiporegistro, ";

         $sSql2 .= "e990_sequencial as si196_tiporemuneracao,";

         $sSql2 .= "rh27_descr AS si196_desctiporemuneracao,";

       $sSql2 .= "CASE

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
       INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric AND rh27_instit = e991_instit
       INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
       WHERE rh02_regist = $oDados10->rh02_regist
       AND (r14_pd in (1))
       group by 1,2,3,4,5,6,7

       UNION


       SELECT 'gerfcom' as tipo,rh02_regist,

       '11' AS si196_tiporegistro,";

         $sSql2 .= "e990_sequencial as si196_tiporemuneracao,";

         $sSql2 .= "rh27_descr AS si196_desctiporemuneracao,";

       $sSql2 .= "CASE
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
       INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric AND rh27_instit = e991_instit
       INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
       WHERE rh02_regist = $oDados10->rh02_regist
       AND (r48_pd in (1))
       group by 1,2,3,4,5,6,7

       UNION

       SELECT 'gerfs13' as tipo,rh02_regist,

       '11' AS si196_tiporegistro,";

         $sSql2 .= "e990_sequencial as si196_tiporemuneracao,";

         $sSql2 .= "rh27_descr AS si196_desctiporemuneracao,";

       $sSql2 .= "CASE
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
       INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric AND rh27_instit = e991_instit
       INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
       WHERE rh02_regist = $oDados10->rh02_regist
       AND (r35_pd in (1))
       group by 1,2,3,4,5,6,7

       UNION

       SELECT 'gerfres' as tipo,rh02_regist,

       '11' AS si196_tiporegistro,";

         $sSql2 .= "e990_sequencial as si196_tiporemuneracao,";

         $sSql2 .= "rh27_descr AS si196_desctiporemuneracao,";

       $sSql2 .= "CASE
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
       INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric AND rh27_instit = e991_instit
       INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
       WHERE rh02_regist = $oDados10->rh02_regist
       AND (r20_pd in (1))
       group by 1,2,3,4,5,6,7 ) as x ";

       if($aTiposPagamento[$iContEx]['tipo'] == 4) {
         $sSql2 .= " Where x.tipo = 'gerfs13' ";
       }elseif($aTiposPagamento[$iContEx]['tipo'] == 3) {
         $sSql2 .= " Where x.tipo = 'gerfcom' ";
       }else{

         $sSql2 .= " Where x.tipo <> 'gerfcom' and x.tipo <> 'gerfs13' ";

       }

       $sSql2 .= " group by x.tipo, x.rh02_regist, x.si196_tiporegistro,x.si196_tiporemuneracao, x.si196_desctiporemuneracao,x.si196_natsaldodetalhe ";

       $rsResult11 = db_query($sSql2);
				//echo $sSql2;
				//db_criatabela($rsResult11);exit;

       for ($iCont11 = 0; $iCont11 < pg_num_rows($rsResult11); $iCont11++) {

         $oDados11 = db_utils::fieldsMemory($rsResult11, $iCont11);

         $clflpgo11 = new cl_flpgo112020();
         $clflpgo11->si196_reg10                          = $clflpgo10->si195_sequencial;
         $clflpgo11->si196_tiporegistro                   = $oDados11->si196_tiporegistro;
         $clflpgo11->si196_indtipopagamento               = $oDados11->si196_indtipopagamento;
         $clflpgo11->si196_codvinculopessoa               = $oDados11->si196_codvinculopessoa;
         $clflpgo11->si196_desctiporubrica                = $this->convert_accented_characters($oDados11->si196_desctiporubrica);
         $clflpgo11->si196_vlrremuneracaodetalhada        = $oDados11->si196_vlrremuneracaodetalhada;
         $clflpgo11->si196_codrubricaremuneracao          = $oDados11->si196_codrubricaremuneracao;
         $clflpgo11->si196_mes                            = $this->sDataFinal['5'] . $this->sDataFinal['6'];
         $clflpgo11->si196_inst                           = db_getsession("DB_instit");
				 $clflpgo11->incluir(null);

         if ($clflpgo11->erro_status == 0) {
          throw new Exception($clflpgo11->erro_msg);
        }

      }

      $sSql3 = "
      Select x.si197_tiporegistro,
      CASE
      when x.tipo = 'gerfsal' then 'M'
      when x.tipo = 'gerfres' then 'M'
      when x.tipo = 'gerfcom' then 'E'
      when x.tipo = 'gerfs13' then 'D'
      end as si197_indtipopagamento,
      x.rh02_regist as si197_codvinculopessoa,
      x.si197_desctipodesconto as si197_desctiporubricadesconto,
      sum(x.si197_vlrdescontodetalhado) AS si197_vlrdescontodetalhado,
      x.si197_desctipodesconto,
      x.rh02_regist,
      x.si197_tipodesconto,
      x.si197_tipodesconto as si197_codrubricadesconto,
      x.si197_natsaldodetalhe,
      x.tipo
      from
      (SELECT 'gerfsal' as tipo,
      rh02_regist,
      e990_sequencial AS si197_tipodesconto,
      rh27_descr AS si197_desctipodesconto,
      '12' AS si197_tiporegistro,

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
      INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
      AND rh27_instit = e991_instit
      INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
      WHERE rh02_regist = $oDados10->rh02_regist
      AND (r14_pd in (2))
      group by 1,2,3,4,5,6,7

      UNION


      SELECT 'gerfcom' as tipo,
      rh02_regist,
      e990_sequencial AS si197_tipodesconto,
      rh27_descr AS si197_desctipodesconto,
      '12' AS si197_tiporegistro,

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
      INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
      AND rh27_instit = e991_instit
      INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
      WHERE rh02_regist = $oDados10->rh02_regist
      AND (r48_pd in (2))
      group by 1,2,3,4,5,6,7


      UNION

      SELECT 'gerfs13' as tipo,
      rh02_regist,
      e990_sequencial AS si197_tipodesconto,
      rh27_descr AS si197_desctipodesconto,
      '12' AS si197_tiporegistro,

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
      INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
      AND rh27_instit = e991_instit
      INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
      WHERE rh02_regist = $oDados10->rh02_regist
      AND (r35_pd in (2))
      group by 1,2,3,4,5,6,7


      UNION

      SELECT
      'gerfres' as tipo,
      rh02_regist,
      e990_sequencial AS si197_tipodesconto,
      rh27_descr AS si197_desctipodesconto,
      '12' AS si197_tiporegistro,

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
      INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
      AND rh27_instit = e991_instit
      INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
      WHERE rh02_regist = $oDados10->rh02_regist
      AND (r20_pd in (2))
      group by 1,2,3,4,5,6,7
      ) as x ";

      if($aTiposPagamento[$iContEx]['tipo'] == 4) {
       $sSql3 .= " Where x.tipo = 'gerfs13' ";
     }elseif($aTiposPagamento[$iContEx]['tipo'] == 3) {
       $sSql3 .= " Where x.tipo = 'gerfcom' ";
     }else{

       $sSql3 .= " Where x.tipo <> 'gerfcom' and x.tipo <> 'gerfs13' ";

     }


     $sSql3 .= "GROUP BY x.tipo,
     x.rh02_regist,
     x.si197_tiporegistro,
     x.si197_tipodesconto,
     x.si197_desctipodesconto,
     x.si197_natsaldodetalhe";

     $rsResult12 = db_query($sSql3);

     for ($iCont12 = 0; $iCont12 < pg_num_rows($rsResult12); $iCont12++) {

       $oDados12 = db_utils::fieldsMemory($rsResult12, $iCont12);

       $clflpgo12 = new cl_flpgo122020();

       $clflpgo12->si197_reg10                   = $clflpgo10->si195_sequencial;
       $clflpgo12->si197_tiporegistro            = $oDados12->si197_tiporegistro;
       $clflpgo12->si197_indtipopagamento        = $oDados12->si197_indtipopagamento;
       $clflpgo12->si197_codvinculopessoa        = $oDados12->si197_codvinculopessoa;
       $clflpgo12->si197_desctiporubricadesconto = $this->convert_accented_characters($oDados12->si197_desctiporubricadesconto);
       $clflpgo12->si197_codrubricadesconto      = $oDados12->si197_codrubricadesconto;
       $clflpgo12->si197_vlrdescontodetalhado    = $oDados12->si197_vlrdescontodetalhado;
       $clflpgo12->si197_mes                     = $this->sDataFinal['5'] . $this->sDataFinal['6'];
       $clflpgo12->si197_inst                    = db_getsession("DB_instit");
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
