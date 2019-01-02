<?php


require_once("model/MSCXbrl.model.php");
require_once("model/MSCCsv.model.php");

class MSC {

  //@var integer
  public $iConta;
  //@var integer
  public $iIC1;
  //@var string
  public $sTipoIC1;
  //@var integer
  public $iIC2;
  //@var string
  public $sTipoIC2;
  //@var integer
  public $iIC3;
  //@var string
  public $sTipoIC3;
  //@var integer
  public $iIC4;
  //@var string
  public $sTipoIC4;
  //@var integer
  public $iIC5;
  //@var string
  public $sTipoIC5;
  //@var integer
  public $iIC6;
  //@var string
  public $sTipoIC6;
  //@var integer
  public $iIC7;
  //@var string
  public $sTipoIC7;
  //@var integer
  public $iValor;
  //@var string
  public $sTipoValor;
  //@var string
  public $sNaturezaValor;
  //@var string
  public $sIndetifier;
  //@var string
  public $sInstant;
  //@var string
  public $sEntriesType;
  //@var string
  public $sPeriodIdentifier;
  //@var string
  public $sPeriodDescription;
  //@var string
  public $sPeriodStart;
  //@var string
  public $sPeriodEnd;
  //@var integer
  public $iLineNumberCounter = 0;
  //@var string
  public $aRegistros = array();
  //@var string
  public $sNomeArq;
  //@var string
  public $sCaminhoArq;
  
  //NumberCounter
  public function setLineNumberCounter($iLineNumberCounter) {
    $this->iLineNumberCounter = $iLineNumberCounter;
  }
  public function getLineNumberCounter() {
    return $this->iLineNumberCounter;
  }
  //Conta
  public function setConta($iConta) {
    $this->iConta = $iConta;
  }
  public function getConta() {
    return $this->iConta;
  }
  //IC1
  public function setIC1($iIC1) {
    $this->iIC1 = $iIC1;
  }
  public function getIC1() {
    return $this->iIC1;
  }
  //Tipo1
  public function setTipoIC1($sTipoIC1) {
    $this->sTipoIC1 = $sTipoIC1;
  }
  public function getTipoIC1() {
    return $this->sTipoIC1;
  }
  //IC2
  public function setIC2($iIC2) {
    $this->iIC2 = $iIC2;
  }
  public function getIC2() {
    return $this->iIC2;
  }
  //Tipo2
  public function setTipoIC2($sTipoIC2) {
    $this->sTipoIC2 = $sTipoIC2;
  }
  public function getTipoIC2() {
    return $this->sTipoIC2;
  }
  //IC3
  public function setIC3($iIC3) {
    $this->iIC3 = $iIC3;
  }
  public function getIC3() {
    return $this->iIC3;
  }
  //Tipo3
  public function setTipoIC3($sTipoIC3) {
    $this->sTipoIC3 = $sTipoIC3;
  }
  public function getTipoIC3() {
    return $this->sTipoIC3;
  }
  //IC4
  public function setIC4($iIC4) {
    $this->iIC4 = $iIC4;
  }
  public function getIC4() {
    return $this->iIC4;
  }
  //Tipo4
  public function setTipoIC4($sTipoIC4) {
    $this->sTipoIC4 = $sTipoIC4;
  }
  public function getTipoIC4() {
    return $this->sTipoIC4;
  }
  //IC5
  public function setIC5($iIC5) {
    $this->iIC5 = $iIC5;
  }
  public function getIC5() {
    return $this->iIC5;
  }
  //Tipo5
  public function setTipoIC5($sTipoIC5) {
    $this->sTipoIC5 = $sTipoIC5;
  }
  public function getTipoIC5() {
    return $this->sTipoIC5;
  }
  //IC6
  public function setIC6($iIC6) {
    $this->iIC6 = $iIC6;
  }
  public function getIC6() {
    return $this->iIC6;
  }
  //Tipo6
  public function setTipoIC6($sTipoIC6) {
    $this->sTipoIC6 = $sTipoIC6;
  }
  public function getTipoIC6() {
    return $this->sTipoIC6;
  }
  
  //Valor
  public function setValor($iValor) {
    $this->iValor = $iValor;
  }
  public function getValor() {
    return $this->iValor;
  }
  //TipoValor
  public function setTipoValor($sTipoValor) {
    $this->sTipoValor = $sTipoValor;
  }
  public function getTipoValor() {
    return $this->sTipoValor;
  }
  //NaturezaValor
  public function setNaturezaValor($sNaturezaValor) {
    $this->sNaturezaValor = $sNaturezaValor;
  }
  public function getNaturezaValor() {
    return $this->sNaturezaValor;
  }
  //Indetifier
  public function setIndetifier($sIndetifier) {
    $this->sIndetifier = $sIndetifier;
  }
  public function getIndetifier() {
    return $this->sIndetifier;
  }
  //Instant
  public function setInstant($sInstant) {
    $this->sInstant = $sInstant;
  }
  public function getInstant() {
    return $this->sInstant;
  }
  //EntriesType
  public function setEntriesType($sEntriesType) {
    $this->sEntriesType = $sEntriesType;
  }
  public function getEntriesType() {
    return $this->sEntriesType;
  }
  //PeriodIdentifier
  public function setPeriodIdentifier($sPeriodIdentifier) {
    $this->sPeriodIdentifier = $sPeriodIdentifier;
  }
  public function getPeriodIdentifier() {
    return $this->sPeriodIdentifier;
  }
  //PeriodDescription
  public function setPeriodDescription($sPeriodDescription) {
    $this->sPeriodDescription = $sPeriodDescription;
  }
  public function getPeriodDescription() {
    return $this->sPeriodDescription;
  }
  //PeriodStart;
  public function setPeriodStart($sPeriodStart) {
    $this->sPeriodStart = $sPeriodStart;  
  }
  public function getPeriodStart() {
    return $this->sPeriodStart;
  }
  //PeriodEnd;
  public function setPeriodEnd($sPeriodEnd) {
    $this->sPeriodEnd = $sPeriodEnd;
  }
  public function getPeriodEnd() {
    return $this->sPeriodEnd;
  }
  //Nome do arquivo;
  public function setNomeArq($sNomeArq) {
    $this->sNomeArq = $sNomeArq;
  }
  public function getNomeArq() {
    return $this->sNomeArq;
  }
  //Caminho do arquivo;
  public function setCaminhoArq($sCaminhoArq) {
    $this->sCaminhoArq = $sCaminhoArq;
  }
  public function getCaminhoArq() {
    return $this->sCaminhoArq;
  }
  
  public function gerarMSC($ano, $mes, $formato) {

    $aRegis = $this->getConsulta($ano, $mes);
    //ksort($aRegis);
    foreach ($aRegis as $aRegistro){
      $this->aRegistros += array_merge($this->gerarLinhas($aRegistro));
    }
    
    switch ($formato) {

      case 'xbrl' :
        
          $xbrl = new MSCXbrl;
          $xbrl->setIndetifier($this->getIndetifier());
          $xbrl->setEntriesType($this->getEntriesType());
          $xbrl->setPeriodIdentifier($this->getPeriodIdentifier());
          $xbrl->setPeriodDescription($this->getPeriodDescription());
          $xbrl->setPeriodStart($this->getPeriodStart());
          $xbrl->setPeriodEnd($this->getPeriodEnd());
          $xbrl->setLineNumberCounter($this->getLineNumberCounter());
          $xbrl->setNomeArq($this->getNomeArq());
          $xbrl->gerarArquivoXBRL($this->aRegistros);

      break;

      case 'csv':

          $csv = new MSCCsv;
          $csv->setNomeArq($this->getNomeArq());
          $csv->setIndetifier($this->getIndetifier());
          $csv->setPeriodIdentifier($this->getPeriodIdentifier());
          $csv->gerarArquivoCSV($this->aRegistros);

      break;

      default:

    }
    
  }

  public function gerarLinhas($oRegistro) {
    /*'conta'=>'0', 'po'=>'1', 'fp'=>'2', 'fr'=>'3', 'nr'=>'4', 'nd'=>'5', 'fs'=>'6', 'ai'=>'7', 'dc'=>'8'
    'valor'=>'8', 'tipovalor'=>'9' , 'nat_vlr'=>'10', 'valor'=>'11', 'tipovalor'=>'12'
    'valor'=>'13', 'tipovalor'=>'14', 'valor'=>'15', 'tipovalor'=>'16', 'nat_vlr'=>'17'*/
    
    $aLinhas = array('beginning_balance', 'period_change_deb', 'period_change_cred', 'ending_balance');
    $aRegistros = array();
    $indice = "";

    for ($ind = 0; $ind <= 6; $ind++) {
      $indice .= ($oRegistro[$ind] != "_null") ? $oRegistro[$ind] : '';
    }

    $oContas = new stdClass;
    $oContas->registros = array();

    for ($i=0; $i < 4; $i++) {

      if (in_array($aLinhas[$i], $oRegistro, true)) {

        $key = array_search($aLinhas[$i], $oRegistro, true);
        $oNovoResgistro = new stdClass;
        $oNovoResgistro->conta = $oRegistro[0];

        // so vai ter um registro no arquivo se o valor for diferente de ZERO
        if ($oRegistro[$key-1] > 0) {
            if (($aLinhas[$i] == 'beginning_balance' || $aLinhas[$i] == 'ending_balance')) {
                $oNovoResgistro->nat_vlr   = $aLinhas[$i];
                $oNovoResgistro->tipoValor = $oRegistro[$key+1];
                $oNovoResgistro->valor     = $oRegistro[$key-1];
            } else if ($aLinhas[$i] == 'period_change_deb' || $aLinhas[$i] == 'period_change_cred') {
                $nat_valor = explode("_", $aLinhas[$i]);
                $oNovoResgistro->nat_vlr   = 'period_change';
                $oNovoResgistro->tipoValor = $nat_valor[2] == 'deb' ? 'D' : 'C';
                $oNovoResgistro->valor     = $oRegistro[$key-1];
            }
            
            $aTipoIC = array("po", "fp", "fr", "nr", "nd", "fs", "ai", "dc", "es");

            for ($ii = 1; $ii <= 6; $ii++) {
              $IC = "IC".$ii;
              $TipoIC = "TipoIC".$ii;
        
              if ($oRegistro[$ii] != "_null") {
                $cIC = explode("_", $oRegistro[$ii]);
                if (in_array($cIC[1], $aTipoIC, true)) {
                  $oNovoResgistro->{$IC}     = $cIC[0];
                  $oNovoResgistro->{$TipoIC} = $cIC[1];
                }       
              }
            }
            $aRegistros[$indice] = $oContas;
            $aRegistros[$indice]->registros[$i] = $oNovoResgistro;
            $this->iLineNumberCounter++;
        }
      }
    }

    return $aRegistros;
  }
  
  public function getConsulta($ano, $mes) {
      /*
       * Definindo o periodo em que serao selecionado os dados
       */
      $iUltimoDiaMes = date("d", mktime(0,0,0,$mes+1,0,db_getsession("DB_anousu")));
      $data_incio = db_getsession("DB_anousu")."-{$mes}-01";
      $data_fim   = db_getsession("DB_anousu")."-{$mes}-{$iUltimoDiaMes}";

      $aDadosAgrupados = array();
      $aDadosAgrupados = array_merge( $this->getDadosIC01($ano, $data_incio, $data_fim), $this->getDadosIC02($ano, $data_incio, $data_fim),
          $this->getDadosIC03($ano, $data_incio, $data_fim), $this->getDadosIC04($ano, $data_incio, $data_fim), $this->getDadosIC05($ano, $data_incio, $data_fim),
          $this->getDadosIC06($ano, $data_incio, $data_fim), $this->getDadosIC07($ano, $data_incio, $data_fim),  $this->getDadosIC08($ano, $data_incio, $data_fim),
          $this->getDadosIC09($ano, $data_incio, $data_fim) );
          
          return $aDadosAgrupados; 
  }

  public function getDadosIC($IC, $aCampos, $rsResult) {

      $aDadosIC  = "aDadosIC{$IC}"; 
      $$aDadosIC = array();
      $aIC       = "aIC{$IC}";
      
      for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
          $oReg = db_utils::fieldsMemory($rsResult, $iCont);
          $sHash = "";
          for ($ind = 0; $ind <= 6; $ind++) {
            $sHash .= isset($oReg->{$aCampos[$ind]}) ? $oReg->{$aCampos[$ind]} : '';
          }
          if (!isset(${$aDadosIC}[$sHash])) {
              $$aIC = array();
              for ($i = 0; $i < 17; $i++) {
                ${$aIC}[$i] = ($i > 0 && $i <= 6) ? $oReg->{$aCampos[$i]}."_{$aCampos[$i]}" : $oReg->{$aCampos[$i]};
              }
              ${$aDadosIC}[$sHash] = $$aIC;
          } else {
              ${$aDadosIC}[$sHash][7]  += ($oReg->nat_vlr_si == 'C' ? $oReg->saldoinicial * -1 : $oReg->saldoinicial);
              ${$aDadosIC}[$sHash][10]  += $oReg->debito;
              ${$aDadosIC}[$sHash][12] += $oReg->credito;
              ${$aDadosIC}[$sHash][14] += ($oReg->nat_vlr_sf == 'C' ? $oReg->saldofinal * -1 : $oReg->saldofinal);
          }
      }
      
      $aDadosICFinal  = "aDadosIC{$IC}Final";
      $$aDadosICFinal = array();

      foreach ($$aDadosIC as $obj) {
          $sHash = "";
          for ($ind = 0; $ind < 6; $ind++) {
            $sHash .= ($obj[$ind] != "_null") ? $obj[$ind] : '';
          }
          $oIC = $obj;
          $oIC[9]  = $obj[7] > 0 ? 'D' : 'C';
          $oIC[7]  = abs($obj[7]);
          $oIC[16] = $oIC[14] > 0 ? 'D' : 'C';
          $oIC[14] = abs($oIC[14]);
          ${$aDadosICFinal}[$sHash] = $oIC;
      }
      return $$aDadosICFinal;

  }

  public function getDadosIC01($iAno, $DataInicio, $DataFim) {
      
    $sSQL = "select * from ( 
        select estrut as conta,
                CASE
                WHEN db21_tipoinstit IN (6) THEN 10132
                WHEN db21_tipoinstit IN (2) THEN 20231
                ELSE 10131
            END AS po, 
		      round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
		      'beginning_balance' AS tipovalor_si,
		      substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
		      round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
		      CASE
		          WHEN round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 = 0 THEN NULL
		          ELSE 'period_change_deb'
		      END AS tipovalordeb,
		      round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
		      CASE
		          WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
		          ELSE 'period_change_cred'
		      END AS tipovalorcred,
		      round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
		      'ending_balance' AS tipovalor_sf,
		       substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf
         from 	
	      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
	      	      db21_tipoinstit,
				  c61_reduz,
				  c61_codcon,
				  c61_codigo,
				  r.c61_instit,                                   
				  fc_planosaldonovo(".$iAno.", c61_reduz, '".$DataInicio."', '".$DataFim."', false)
             from conplanoexe e
		     inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
		     inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
             inner join db_config ON codigo = r.c61_instit
	         left outer join consistema on c60_codsis = c52_codsis  
	         left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
	         where (c60_infcompmsc is null or c60_infcompmsc = 0 or c60_infcompmsc = 1) and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
	       ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "null", "null", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return $this->getDadosIC(1, $aCampos, $rsResult);
      
  }

    public function getDadosIC02($iAno, $DataInicio, $DataFim) {

        $sSQL = "select * from ( 
        select estrut as conta,
            CASE
            WHEN db21_tipoinstit IN (6) THEN 10132
            WHEN db21_tipoinstit IN (2) THEN 20231
            ELSE 10131
            END AS po, 
            c60_identificadorfinanceiro as fp,
		      round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
		      'beginning_balance' AS tipovalor_si,
		      substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
		      round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
		      CASE
		          WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
		          ELSE 'period_change_deb'
		      END AS tipovalordeb,
		      round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
		      CASE
		          WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
		          ELSE 'period_change_cred'
		      END AS tipovalorcred,
		      round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
		      'ending_balance' AS tipovalor_sf,
		       substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf,
		      c61_reduz,
		      c61_codcon,
		      c61_codigo,
		      c61_instit
         from 	
	      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
	      	      db21_tipoinstit,
				  c61_reduz,
				  c61_codcon,
				  c61_codigo,
				  r.c61_instit, c60_identificadorfinanceiro,                                  
				  fc_planosaldonovo(".$iAno.", c61_reduz, '".$DataInicio."', '".$DataFim."', false)
             from conplanoexe e
		     inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
		     inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
             inner join db_config ON codigo = r.c61_instit
	         left outer join consistema on c60_codsis = c52_codsis  
	         left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
	         where c60_infcompmsc = 2 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
	       ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";
        
        $rsResult = db_query($sSQL);
        $aCampos  = array("conta", "po", "fp", "null", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

        return $this->getDadosIC(2, $aCampos, $rsResult);

    }

    public function getDadosIC03($iAno, $DataInicio, $DataFim) {

      $sSQL = "select * from ( 
      select estrut as conta,
          CASE
          WHEN db21_tipoinstit IN (6) THEN 10132
          WHEN db21_tipoinstit IN (2) THEN 20231
          ELSE 10131
          END AS po, 
          null as fp
          null as dc 
        round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        c61_instit
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit, c60_identificadorfinanceiro,                                  
        fc_planosaldonovo(".$iAno.", c61_reduz, '".$DataInicio."', '".$DataFim."', false)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
          where c60_infcompmsc = 3 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";
      
      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "fp", "dc", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return $this->getDadosIC(3, $aCampos, $rsResult);
    }

    public function getDadosIC04($iAno, $DataInicio, $DataFim) {

      $iMes = date('m',strtotime($dataInicio));
      // sql retorna todas as fontes de recursos que teve movimentação para as contas de ics igual 4
      // todo trocar o o15_codtri pelo campo criado para ser a fonte do msc
      $sSQL = "select * from ( 
      select estrut as conta,
          CASE
          WHEN db21_tipoinstit IN (6) THEN 10132
          WHEN db21_tipoinstit IN (2) THEN 20231
          ELSE 10131
          END AS po, 
          c60_identificadorfinanceiro as fp,
          o15_codtri as fr,
        round(substr(fc_saldocontacorrente,43,15)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_saldocontacorrente,107,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_saldocontacorrente,91,15)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_saldocontacorrente,111,1)::varchar(1) AS nat_vlr_sf,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        c61_instit
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit, 
              c60_identificadorfinanceiro,o15_codtri,
              fc_saldocontacorrente($iAno,c19_sequencial,103,$iMes,codigo)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit
            inner join contacorrentedetalhe on c19_conplanoreduzanousu = c61_anousu and c19_reduz = c61_reduz
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut 
          left join orctiporec on c19_orctiporec = o15_codigo
          where c60_infcompmsc = 4 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "fp", "fr", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return  $this->getDadosIC(4, $aCampos, $rsResult);
    }

    public function getDadosIC05($iAno, $DataInicio, $DataFim) {

      $iMes = date('m',strtotime($dataInicio));
      // sql retorna todas as fontes de recursos que teve movimentação para as contas de ics igual 4
      // todo trocar o o15_codtri pelo campo criado para ser a fonte do msc
      $sSQL = "select * from ( 
      select estrut as conta,
          CASE
          WHEN db21_tipoinstit IN (6) THEN 10132
          WHEN db21_tipoinstit IN (2) THEN 20231
          ELSE 10131
          END AS po, 
          o15_codtri as fr,
        round(substr(fc_saldocontacorrente,43,15)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_saldocontacorrente,107,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_saldocontacorrente,91,15)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_saldocontacorrente,111,1)::varchar(1) AS nat_vlr_sf,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        c61_instit
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit, 
              c60_identificadorfinanceiro,o15_codtri,
              fc_saldocontacorrente($iAno,c19_sequencial,103,$iMes,codigo)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit
            inner join contacorrentedetalhe on c19_conplanoreduzanousu = c61_anousu and c19_reduz = c61_reduz 
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
          left join orctiporec on c19_orctiporec = o15_codigo
          where c60_infcompmsc = 5 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $aCampos  = array("conta", "po", "fr", "null", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return  $this->getDadosIC(5, $aCampos, $rsResult);
    }

    public function getDadosIC06($iAno, $DataInicio, $DataFim) {

      $iMes = date('m',strtotime($dataInicio));
      // sql retorna todas as fontes de recursos que teve movimentação para as contas de ics igual 4
      // todo trocar o o15_codtri pelo campo criado para ser a fonte do msc e colocar o natureza de receita segundo STN
      $sSQL = "select * from ( 
      select estrut as conta,
          CASE
          WHEN db21_tipoinstit IN (6) THEN 10132
          WHEN db21_tipoinstit IN (2) THEN 20231
          ELSE 10131
          END AS po, 
          o15_codtri as fr,
          null as nr
        round(substr(fc_saldocontacorrente,43,15)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_saldocontacorrente,107,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,59,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_saldocontacorrente,75,15)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_saldocontacorrente,91,15)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_saldocontacorrente,111,1)::varchar(1) AS nat_vlr_sf,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        c61_instit
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit, 
              c60_identificadorfinanceiro,o15_codtri,
              fc_saldocontacorrente($iAno,c19_sequencial,100,$iMes,codigo)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit  
          inner join contacorrentedetalhe on c19_conplanoreduzanousu = c61_anousu and c19_reduz = c61_reduz
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut 
          left join orctiporec on c19_orctiporec = o15_codigo
          where c60_infcompmsc = 6 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "fr", "nr", "null", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return  $this->getDadosIC(6, $aCampos, $rsResult);
    }

    public function getDadosIC07($iAno, $DataInicio, $DataFim) {

        // todo trocar o o15_codtri pelo campo criado para ser a fonte do msc
        $sSQL = "select * from ( 
        select estrut as conta,
                CASE
                WHEN db21_tipoinstit IN (6) THEN 10132
                WHEN db21_tipoinstit IN (2) THEN 20231
                ELSE 10131
            END AS po, 
            null as fs,
            100 as fr,
            null AS nd,
            null as es
          round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
          'beginning_balance' AS tipovalor_si,
          substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
          round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
          CASE
              WHEN round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 = 0 THEN NULL
              ELSE 'period_change_deb'
          END AS tipovalordeb,
          round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
          CASE
              WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
              ELSE 'period_change_cred'
          END AS tipovalorcred,
          round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
          'ending_balance' AS tipovalor_sf,
            substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf
          from 	
        (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
                db21_tipoinstit,
          c61_reduz,
          c61_codcon,
          c61_codigo,
          r.c61_instit,                                   
          fc_planosaldonovo(".$iAno.", c61_reduz, '".$dataInicio."', '".$dataFim."', false)
              from conplanoexe e
          inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
          inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
              inner join db_config ON codigo = r.c61_instit
            left outer join consistema on c60_codsis = c52_codsis  
            left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
            where c60_infcompmsc = 7 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
          ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

        $rsResult = db_query($sSQL);
        $aCampos  = array("conta", "po", "fs", "fr", "nd", "es", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

        return $this->getDadosIC(7, $aCampos, $rsResult);
    }

    public function getDadosIC08($iAno, $DataInicio, $DataFim) {

      $sSQL = "select * from ( 
      select estrut as conta,
              CASE
              WHEN db21_tipoinstit IN (6) THEN 10132
              WHEN db21_tipoinstit IN (2) THEN 20231
              ELSE 10131
          END AS po, 
          c60_identificadorfinanceiro as fp,
          null as dc,
          null AS fr,
        round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit,                                   
        fc_planosaldonovo(".$iAno.", c61_reduz, '".$dataInicio."', '".$dataFim."', false)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
          where c60_infcompmsc = 8 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "fp", "dc", "fr", "null", "null", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");
      
      return $this->getDadosIC(8, $aCampos, $rsResult);
    }

    public function getDadosIC09($iAno, $DataInicio, $DataFim) {

      $sSQL = "select * from ( 
      select estrut as conta,
              CASE
              WHEN db21_tipoinstit IN (6) THEN 10132
              WHEN db21_tipoinstit IN (2) THEN 20231
              ELSE 10131
          END AS po, 
          null as fs,
          null AS fr,
          null AS nd,
          null AS es,
          null AS ai,
        round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
        'beginning_balance' AS tipovalor_si,
        substr(fc_planosaldonovo,59,1)::varchar(1) AS nat_vlr_si,
        round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 AS debito,
        CASE
            WHEN round(substr(fc_planosaldonovo,18,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_deb'
        END AS tipovalordeb,
        round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS credito,
        CASE
            WHEN round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 = 0 THEN NULL
            ELSE 'period_change_cred'
        END AS tipovalorcred,
        round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldofinal,
        'ending_balance' AS tipovalor_sf,
          substr(fc_planosaldonovo,60,1)::varchar(1) AS nat_vlr_sf
        from 	
      (select case when c210_mscestrut is null then substr(p.c60_estrut,1,9) else c210_mscestrut end as estrut,
              db21_tipoinstit,
        c61_reduz,
        c61_codcon,
        c61_codigo,
        r.c61_instit,                                   
        fc_planosaldonovo(".$iAno.", c61_reduz, '".$dataInicio."', '".$dataFim."', false)
            from conplanoexe e
        inner join conplanoreduz r on   r.c61_anousu = c62_anousu  and  r.c61_reduz = c62_reduz 
        inner join conplano p on r.c61_codcon = c60_codcon and r.c61_anousu = c60_anousu
            inner join db_config ON codigo = r.c61_instit
          left outer join consistema on c60_codsis = c52_codsis  
          left join vinculopcaspmsc on substr(p.c60_estrut,1,9) = c210_pcaspestrut
          where c60_infcompmsc = 9 and c62_anousu = ".$iAno." and r.c61_reduz is not null order by p.c60_estrut 
        ) as movgeral) as movfinal where (saldoinicial <> 0 or debito <> 0 or credito <> 0)";

      $rsResult = db_query($sSQL);
      $aCampos  = array("conta", "po", "fs", "fr", "nd", "es", "ai", "saldoinicial", "tipovalor_si", "nat_vlr_si", "debito", "tipovalordeb", "credito", "tipovalorcred", "saldofinal", "tipovalor_sf", "nat_vlr_sf");

      return $this->getDadosIC(9, $aCampos, $rsResult);
    }
  
    /*$aDadosIC01 = array();
      for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
          $oReg = db_utils::fieldsMemory($rsResult, $iCont);
          $sHash = $oReg->conta.$oReg->po;
          if (!isset($aDadosIC01[$sHash])) {
              $aIC01 = array();
              $aIC01[0]  = $oReg->conta;
              $aIC01[1]  = $oReg->po;
              $aIC01[2]  = $oReg->fp;
              $aIC01[3]  = $oReg->fr;
              $aIC01[4]  = $oReg->nr;
              $aIC01[5]  = $oReg->nd;
              $aIC01[6]  = $oReg->fs;
              $aIC01[7]  = $oReg->ai;
              $aIC01[8]  = $oReg->saldoinicial;
              $aIC01[9]  = $oReg->tipovalor_si;
              $aIC01[10] = $oReg->nat_vlr_si;
              $aIC01[11] = $oReg->debito;
              $aIC01[12] = $oReg->tipovalordeb;
              $aIC01[13] = $oReg->credito;
              $aIC01[14] = $oReg->tipovalorcred;
              $aIC01[15] = $oReg->saldofinal;
              $aIC01[16] = $oReg->tipovalor_sf;
              $aIC01[17] = $oReg->nat_vlr_sf;
              $aDadosIC01[$sHash] = $aIC01;
          } else {
              $aDadosIC01[$sHash][8]  += ($oReg->nat_vlr_si == 'C' ? $oReg->saldoinicial * -1 : $oReg->saldoinicial);
              $aDadosIC01[$sHash][11] += $oReg->debito;
              $aDadosIC01[$sHash][13] += $oReg->credito;
              $aDadosIC01[$sHash][15] += ($oReg->nat_vlr_sf == 'C' ? $oReg->saldofinal * -1 : $oReg->saldofinal);
          }
      }
      $aDadosIC01Final = array();

      foreach ($aDadosIC01 as $obj) {
          $sHash = $obj[0].$obj[1];
          $oIC = $obj;
          $oIC[10] = $obj[8] > 0 ? 'D' : 'C';
          $oIC[8] = abs($obj[8]);
          $oIC[17] = $oIC[15] > 0 ? 'D' : 'C';
          $oIC[15] = abs($oIC[15]);
          $aDadosIC01Final[$sHash] = $oIC;
      }  
      return $aDadosIC01Final;
      
      $aIC01 = array();
              $aIC01[0]  = $oReg->conta;
              $aIC01[1]  = $oReg->po;
              $aIC01[2]  = $oReg->fp;
              $aIC01[3]  = $oReg->fr;
              $aIC01[4]  = $oReg->nr;
              $aIC01[5]  = $oReg->saldoinicial;
              $aIC01[6]  = $oReg->tipovalor_si;
              $aIC01[7] = $oReg->nat_vlr_si;
              $aIC01[8] = $oReg->debito;
              $aIC01[9] = $oReg->tipovalordeb;
              $aIC01[10] = $oReg->credito;
              $aIC01[11] = $oReg->tipovalorcred;
              $aIC01[12] = $oReg->saldofinal;
              $aIC01[13] = $oReg->tipovalor_sf;
              $aIC01[14] = $oReg->nat_vlr_sf;
      
      */
      

}

