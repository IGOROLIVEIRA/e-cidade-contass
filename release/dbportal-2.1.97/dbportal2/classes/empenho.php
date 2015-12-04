<?php

 /**
  * Model para controle de empenho (Notas liquidacao) 
  * @package empenho
  * @author Iuri Guntchnigg Revisão $Author: dbiuri $
  * @version $Revision: 1.51 $
  * 
  */

class empenho {

  public  $erro_status      = null;
  public  $erro_msg         = null;
  public  $datausu          = null;
  private $anousu           = null;
  public  $aItensAnulados   = array();
  private $lRecriarReserva  = false;
  public  $iCredor          = null;
  public  $iNumRowsNotas    = 0;
  private $sCamposNotas     = "";
  private $lEncode          = false;
  private $iCodigoMovimento = null;
  
  function empenho() {

    //$this->setNumEmp($iEmpenho);  
    if (!class_exists("cl_empempenho")){
      require "classes/db_empempenho_classe.php"; 
    }
     if (!class_exists("lancamentoContabil")){
      require "classes/lancamentoContabil.model.php"; 
    }
    if (!class_exists("cl_empnota")){
      require "classes/db_empnota_classe.php"; 
    }
    if (!class_exists("db_utils")){
      require "libs/db_utils.php"; 
    }
    if (!class_exists("cl_empempitem")){
      require "classes/db_empempitem_classe.php"; 
    }
    if (!class_exists("cl_empelemento")){
      require "classes/db_empelemento_classe.php"; 
    }
    if (!class_exists("services_json")){
      require "libs/JSON.php";
    }    
    $this->clempelemento  = new cl_empelemento();
    $this->datausu        = date("Y-m-d", db_getsession("DB_datausu"));
    $this->anousu         = db_getsession("DB_anousu");
    $this->clempempenho   = new cl_empempenho();
    $this->sCamposNota    = "e69_codnota,e69_numero,e69_anousu,e50_codord,e60_numemp, e50_anousu,e69_dtnota,";
    $this->sCamposNota   .= "e70_vlranu,e70_vlrliq,e70_valor,e53_vlrpag,m51_tipo,m51_codordem,z01_nome,z01_cgccpf,";
    $this->sCamposNota   .= "fc_valorretencaonota(e50_codord) as vlrretencao";
  }
  /**
   ** Metodo para set para a variavel recriar saldo
   ** @param boolean $lOpcao - true para recriar
   */ 
  function setRecriarSaldo($lOpcao){

    if ($lOpcao){
      $this->lRecriarReserva = true;
    }else{
      $this->lRecriarReserva = false;
    }
  }

  function getRecriarSaldo(){

    return $this->lRecriarReserva;
  }

  function setCredor($iCredor){
    $this->iCredor = $iCredor;
  }

  function getCredor(){

    if ($this->iCredor != null){
      return $this->iCredor;
    }else{
      return false;
    }

  }

  function setEncode($lEncode) {
    $this->lEncode = $lEncode;  
  } 

  function getEncode(){
    return $this->lEncode; 
  }   

  function liquidar($numemp = "", $codele = "", $codnota = "", $valor = "", $historico = "") {

    if ($numemp == "" || $codele == "" || $codnota == "" || $valor == "") {
      $this->erro_status = '0';
      $this->erro_msg = "Parametros faltando ($numemp,$codele,$codnota,$valor,$historico) ";
      return false;
    }
    
    
    // variaveis acessiveis nessa função
    global $o56_elemento, $e60_numemp, $e60_numcgm, $e60_anousu, $e60_coddot, $e60_codcom, $e64_vlrliq, $e60_vlrliq, $e64_codele, $e70_vlrliq, $e70_valor, $erro_msg;

    // busta empenho
    $clempempenho = new cl_empempenho;
    $res          = $clempempenho->sql_record($clempempenho->sql_query($numemp));
    if ($clempempenho->numrows > 0) {
      $oEmpenho = db_utils::fieldsMemory($res, 0);
    } else {
      
      $this->erro_status = '0';
      $this->erro_msg    = "Empempenho ".$clempempenho->erro_msg;
      return false;
      
    }
    /*
     * verificamos se a data e maior ou igual a data do empenho.
     * caso a data  da sessao seje maior , nao podemods permitir a liquidação
     */
    
     if ((db_strtotime($this->datausu) < db_strtotime($oEmpenho->e60_emiss)) 
          || ($this->anousu < $oEmpenho->e60_anousu)) {
        
        $this->erro_status = '0';
        $this->erro_msg    = "Data inválida. data da liquidação deve ser maior ou igual a data do empenho"; 
        return false;
        
     }   
    
    // busta elemento da empelemento
    $clempelemento = new cl_empelemento;
    $res           = $clempelemento->sql_record($clempelemento->sql_query($numemp));
    if ($clempelemento->numrows > 0) {

      db_fieldsmemory($res, 0);

    } else {

      $this->erro_status = '0';
      $this->erro_msg    = "Empelemento ".$clempelemento->erro_msg;
      return false;
    }

    // busta nota
    $clempnotaele = new cl_empnotaele;
    $res          = $clempnotaele->sql_record($clempnotaele->sql_query($codnota, $codele));
    if ($clempnotaele->numrows > 0) {
      db_fieldsmemory($res, 0);
    } else {
      $this->erro_status = '0';
      $this->erro_msg    = "Empnotaele".$clempnotaele->erro_msg;
      return false;
    }

    // este teste verifica se poderá ser feito lancamento na data e se tem saldo no empenho
    if ($e60_anousu < db_getsession("DB_anousu")){
      $codteste = "33";
    }else{
      $codteste = "3";
    }

    $sql    = "select fc_verifica_lancamento(".$numemp.",'".date("Y-m-d", db_getsession("DB_datausu"))."',".$codteste.",".$valor.")";
    $result = pg_query($sql);
    $status = pg_result($result, 0, 0);
    if (substr($status, 0, 2) > 0) {

      $this->erro_msg    = substr($status, 3);
      $this->erro_status = '0';
      return false;
    }
    // alterações na base de dados
    // - atualiza empenho
    // - atualiza empelemento
    // - atualiza empnotaele		
    // - atualiza conlancam
    // - atualiza conlancamcompl [texto complementar]
    // - atualiza conlancamele
    // - atualiza conlancamnota 
    // - atualiza conlancamcgm
    // - atualiza conlancamemp
    // - atualiza conlancamdoc
    // - atualiza conlancamdot [exceto RP]		

    // - atualiza conlancamval 

    $clempempenho->e60_numemp = $oEmpenho->e60_numemp;
    $clempempenho->e60_vlrliq = ($oEmpenho->e60_vlrliq + $valor);
    $res = $clempempenho->alterar($oEmpenho->e60_numemp);
    if ($clempempenho->erro_status == 0) {

      $this->erro_status = '0';
      $this->erro_msg    = "Empempenho ".$clempempenho->erro_msg;
      return false;
    }

    $clempelemento->e64_numemp = $oEmpenho->e60_numemp;
    $clempelemento->e64_codele = $e64_codele;
    $clempelemento->e64_vlrliq = ($e64_vlrliq + $valor);
    $res = $clempelemento->alterar($numemp, $codele);
    if ($clempelemento->erro_status == 0) {

      $this->erro_status = '0';
      $this->erro_msg    = "Empelemento ".$clempelemento->erro_msg;
      return false;
    }

    $clempnotaele->e70_codnota = $codnota;
    $clempnotaele->e70_codele  = $codele;
    $clempnotaele->e70_valor   = $e70_valor;
    $clempnotaele->e70_vlrliq  = ($e70_vlrliq + $valor);
    $res = $clempnotaele->alterar($codnota, $codele);
    if ($clempnotaele->erro_status == 0) {
      $this->erro_status = '0';
      $this->erro_msg    = "Empnotaele ".$clempnotaele->erro_msg;
      return false;
    }
    //atualizamos os valores liquidados do item.
    $clempnotaitem = $this->usarDao("empnotaitem",true);
    $rsItens       = $clempnotaitem->sql_record($clempnotaitem->sql_query_file(null,"*",
                                                null,"e72_codnota = {$codnota}"));
    if ($clempnotaitem->numrows > 0){

      (int)$iNumRowsItens = $clempnotaitem->numrows;
      for ($iInd = 0; $iInd < $iNumRowsItens; $iInd++){

        $oItens = db_utils::fieldsMemory($rsItens, $iInd);
        $clempnotaitem->e72_sequencial = $oItens->e72_sequencial;
        $clempnotaitem->e72_vlrliq     = $oItens->e72_valor;
        $clempnotaitem->alterar($oItens->e72_sequencial);
        if ($clempnotaitem->erro_status == 0){

          $this->erro_status = '0';
          $this->erro_msg    = "Empnotaitem ".$clempnotaitem->erro_msg;
          return false;

        }
      }
    }

     if ($this->anousu == $oEmpenho->e60_anousu) {
      if (substr($oEmpenho->o56_elemento, 0, 2) == '33') {
        $documento = '3'; // despesa corrente
      } else
        if (substr($oEmpenho->o56_elemento, 0, 2) == '34') {
          $documento = '23'; // despesa capital
        }
    } else {
      $documento = 33; // liquidação de RPs
    }
    try {
       $oLancam = new LancamentoContabil(
                                       $documento,
                                       $this->anousu,
                                       $this->datausu,
                                       ($valor)
                                      );
      $oLancam->setCgm($oEmpenho->e60_numcgm); 
      $oLancam->setEmpenho($oEmpenho->e60_numemp, $oEmpenho->e60_anousu, $oEmpenho->e60_codcom);  
      $oLancam->setElemento($e64_codele);
      $oLancam->setNota($codnota);
      if ($historico != '') {
        $oLancam->setComplemento($historico);
      }  
      if ($oEmpenho->e60_anousu == $this->anousu) {
         $oLancam->setDotacao($oEmpenho->e60_coddot);
      }
      $oLancam->salvar(); 
    }
    catch(Exception $e) {
      
       $this->erro_status = '0';
       $this->erro_msg    = $e->getMessage();
       return false;
    }    
    return true;
  }

  /**
   * estorna liquidação
   */
  function estornaLiq($numemp = "", $codele = "", $codnota = "", $valor = "", $historico = "") {
    
    if ($numemp == "" || $codele == "" || $codnota == "" || $valor == "") {
      
      $this->erro_status = '0';
      $this->erro_msg = "Parametros faltando ($numemp,$codele,$codnota,$valor,$historico) ";
      return false;
      
    }
    // variaveis acessiveis nessa função
    global $o56_elemento, $e60_numemp, $e60_numcgm, $e60_anousu, $e60_coddot, $e60_codcom, $e64_vlrliq, $e60_vlrliq, $e64_codele, $e70_vlrliq, $e70_valor, $erro_msg;

    // busca empenho
    $clempempenho = new cl_empempenho;
    $res          = $clempempenho->sql_record($clempempenho->sql_query($numemp));
    if ($clempempenho->numrows > 0) {
      $oEmpenho = db_utils::fieldsMemory($res, 0);
    } else {
      
      $this->erro_status = '0';
      $this->erro_msg    = "Empempenho ".$clempempenho->erro_msg;
      return false;
      
    }
    
      /*
       * Verificamos a data da sessao. se for maior que a data da nota, nao podemos realizare 
       * a operação;
       */
       if (db_strtotime($this->datausu) < db_strtotime($oEmpenho->e60_emiss) 
           || ($this->anousu < $oEmpenho->e60_anousu)) {
        
         $this->erro_status = '0';
         $this->erro_msg    = "Data inválida. data do estorno deve ser maior ou igual que a data do empenho"; 
         return false;
         
      }
    // busca elemento da empelemento
    $clempelemento = new cl_empelemento;
    $res           = $clempelemento->sql_record($clempelemento->sql_query_file($numemp));
    if ($clempelemento->numrows > 0) {
      db_fieldsmemory($res, 0);
    } else {
      
      $this->erro_status = '0';
      $this->erro_msg    = "Empelemento ".$clempelemento->erro_msg;
      return false;
      
    }

    // busca nota
    $clempnotaele = new cl_empnotaele;
    $res          = $clempnotaele->sql_record($clempnotaele->sql_query($codnota, $codele));
    if ($clempnotaele->numrows > 0) {
      db_fieldsmemory($res, 0);
    } else {
      $this->erro_status = '0';
      $this->erro_msg    = "Empnotaele".$clempnotaele->erro_msg;
      return false;
    }

    // este teste verifica se poderá ser feito lancamento na data e se tem saldo no empenho
    if ($e60_anousu < db_getsession("DB_anousu")){
      $codteste = "34";
    }else{
      $codteste = "4";
    }

    $sql    = "select fc_verifica_lancamento(".$numemp.",'".date("Y-m-d", db_getsession("DB_datausu"))."',".$codteste.",".$valor.") as teste";
    $result = pg_query($sql);
    $status = pg_result($result, 0, "teste");
    if (substr($status, 0, 2) > 0) {
      $this->erro_msg    = "Validação (codigo: fc_verifica_lançamento) ".substr($status,3);
      $this->erro_status = '0';
      return false;
    }
    // alterações na base de dados
    // - atualiza empenho
    // - atualiza empelemento
    // - atualiza empnotaele		
    // - atualiza conlancam
    // - atualiza conlancamcompl [texto complementar]
    // - atualiza conlancamele
    // - atualiza conlancamnota 
    // - atualiza conlancamcgm
    // - atualiza conlancamemp
    // - atualiza conlancamdoc
    // - atualiza conlancamdot [exceto RP]
    // - atualiza conlancamval         

    $clempempenho1             = new cl_empempenho;         
    $clempempenho1->e60_numemp = $oEmpenho->e60_numemp;
    $clempempenho1->e60_vlrliq = "$oEmpenho->e60_vlrliq - $valor";				
    $res                       = $clempempenho1->alterar($oEmpenho->e60_numemp);
    if ($clempempenho1->erro_status == 0) {
      $this->erro_status = '0';
      $this->erro_msg    = "Empempenho ".$clempempenho1->erro_msg;
      return false;
    }	
    					
    $clempelemento1             = new cl_empelemento;
    $clempelemento1->e64_numemp = $oEmpenho->e60_numemp;
    $clempelemento1->e64_codele = $e64_codele;
    $clempelemento1->e64_vlrliq = "$e64_vlrliq - $valor";
    $res                        = $clempelemento1->alterar($numemp, $codele);
    if ($clempelemento1->erro_status == 0) {
      $this->erro_status = '0';
      $this->erro_msg    = "Empelemento ".$clempelemento1->erro_msg;
      db_msgbox($this->erro_msg);
      return false;
    }	
    /*
       buscamos informacao da ordem.
       caso a ordem seje virtual, devemos zerar o valor liquidado, e lancar o valor da nota
       como anulado;
     */  
    $clempnotaord = $this->usarDao("empnotaord", true);
    $rsEmpNotaOrd = $clempnotaord->sql_record($clempnotaord->sql_query($codnota));
    //Verificamos se a nota de liquidacao está agendada. caso sim, nao pode  estornar a liquidação;
    $oEmpNotaOrd     = db_utils::fieldsMemory($rsEmpNotaOrd,0);
    $clepagordemnota = db_utils::getDao("pagordemnota");
    
    $clempnotaele1              = new cl_empnotaele;         	        	
    $clempnotaele1->e70_codnota = $codnota;
    $clempnotaele1->e70_codele  = $codele;		
    $clempnotaele1->e70_vlrliq  = "$e70_vlrliq - $valor";		
    if ($oEmpNotaOrd->m51_tipo == 2){
      $clempnotaele1->e70_vlranu = "$valor";		
    }
    
    $res = $clempnotaele1->alterar($codnota, $codele);
    if ($clempnotaele1->erro_status == 0) {
      $this->erro_status = '0';
      $this->erro_msg    = "Empnotaele ".$clempnotaele1->erro_msg;
      return false;
    }                

    $clempnotaitem = $this->usarDao("empnotaitem",true);
    $rsItens       = $clempnotaitem->sql_record($clempnotaitem->sql_query_ordemCompra(null,"*",null,"e72_codnota = {$codnota}"));
    if ($clempnotaitem->numrows > 0){

      (int)$iNumRowsItens = $clempnotaitem->numrows;
      for ($iInd = 0; $iInd < $iNumRowsItens; $iInd++){

        $oItens                        = db_utils::fieldsMemory($rsItens, $iInd);
        $clempnotaitem->e72_sequencial = $oItens->e72_sequencial;
        if ($oItens->m51_tipo == 2){
          $clempnotaitem->e72_vlranu = $oItens->e72_valor;
        }else if ($oItens->m51_tipo == 1){

          $clempnotaitem->e72_vlrliq = '0';
          $clempnotaitem->e72_vlranu = '0';
        }
        $clempnotaitem->alterar($oItens->e72_sequencial);
        if ($clempnotaitem->erro_status == 0){

          $this->erro_status = '0';
          $this->erro_msg    = "Empnotaitem ".$clempnotaitem->erro_msg;
          return false;

        }
      }
    }
    $documento = null;
    if ($this->anousu == $oEmpenho->e60_anousu) {
      if (substr($oEmpenho->o56_elemento, 0, 2) == '33') {
        $documento = '4'; // despesa corrente
      } else
        if (substr($oEmpenho->o56_elemento, 0, 2) == '34') {
          $documento = '24'; // despesa capital
        }
    } else {
      $documento = 34; // liquidação de RPs
    }
    try {
      
      $oLancam = new LancamentoContabil(
                                       $documento,
                                       $this->anousu,
                                       $this->datausu,
                                       ($valor)
                                      );
      $oLancam->setCgm($oEmpenho->e60_numcgm); 
      $oLancam->setEmpenho($oEmpenho->e60_numemp, $oEmpenho->e60_anousu, $oEmpenho->e60_codcom);  
      $oLancam->setElemento($e64_codele);
      $oLancam->setNota($codnota);
      if ($historico != '') {
        $oLancam->setComplemento($historico);
      }  
      if ($oEmpenho->e60_anousu == $this->anousu) {
         $oLancam->setDotacao($oEmpenho->e60_coddot);
      }
      $oLancam->salvar(); 
    }
    catch (Exception $e){
      
      $this->erro_status = '0';
      $this->erro_msg    = "Lancamento:".$e->getMessage();
      return false;
    }  

    return true;
  }

  /**
   *  gera registros como se fosse ordem de pagamento (OP)
   * 
   */
  function lancaOP($numemp = "", $codele = "", $codnota = "", $valor = "", $retencoes = "", $historico) {
    
    if ($numemp == "" || $codele == "" || $codnota == "" || $valor == "") {
      $this->erro_status = '0';
      $this->erro_msg    = "Parametros faltando ($numemp,$codele,$codnota,$valor,$retencoes) ";
      return false;
    }
    // variaveis acessiveis nessa função
    global $e60_numemp, $e71_codord, $key, $value;

    $clpagordemnota = new cl_pagordemnota;
    $res            = $clpagordemnota->sql_record($clpagordemnota->sql_query_file(null, $codnota));
       // se a OP não existe, lança uma op para a nota
    $clpagordem                 = new cl_pagordem;
    $clpagordem->e50_codord     = "";
    $clpagordem->e50_numemp     = $e60_numemp;
    $clpagordem->e50_data       = date("Y-m-d", db_getsession("DB_datausu"));
    $clpagordem->e50_obs        = $historico;
    $clpagordem->e50_id_usuario = db_getsession("DB_id_usuario");
    $clpagordem->e50_hora       = date("H:m", db_getsession("DB_datausu"));
    $clpagordem->e50_anousu     = $this->anousu;
    $clpagordem->incluir($clpagordem->e50_codord);
    if ($clpagordem->erro_status == 0) {
      
       $this->erro_status = '0';
       $this->erro_msg = "Pagordem:".$clpagordem->erro_msg;
       return false;
       
    }	
    //inclui elemento.	
    $clpagordemele = new cl_pagordemele;
    $clpagordemele->e53_codord = $clpagordem->e50_codord;
    $clpagordemele->e53_codele = $codele;
    $clpagordemele->e53_valor = $valor;
    $clpagordemele->e53_vlranu = '0.00';
    $clpagordemele->e53_vlrpag = '0.00';
    $clpagordemele->incluir($clpagordemele->e53_codord, $clpagordemele->e53_codele);
    if ($clpagordemele->erro_status == 0) {
      
       $this->erro_status = '0';
       $this->erro_msg = "Pagordemele:".$clpagordemele->erro_msg;
       return false;
       
    }
    $clpagordemnota              = new cl_pagordemnota;
    $clpagordemnota->e71_codord  = $clpagordem->e50_codord;
    $clpagordemnota->e71_codnota = $codnota;
    $clpagordemnota->e71_anulado = 'false';
    $clpagordemnota->incluir($clpagordemnota->e71_codord, $clpagordemnota->e71_codnota);
    $this->iCodOrdem  = $clpagordem->e50_codord;
    if ($clpagordemnota->erro_status == 0) {
      
       $this->erro_status = '0';
       $this->erro_msg    = "Pagordemnota:".$clpagordenota->erro_msg;
       return false;
       
     }
    //}
    //se foi setado algum credor para essa ordem, gravamos na pagordemconta

    if ($this->getCredor()){

      $clpagordemconta             = $this->usarDao("pagordemconta", true);
      $clpagordemconta->e49_codord = $clpagordem->e50_codord;
      $clpagordemconta->e49_numcgm = $this->getCredor();
      $clpagordemconta->incluir($clpagordem->e50_codord);
      if ($clpagordemconta->erro_status == 0){

        $this->erro_status = '0';
        $this->erro_msg    = "Pagordemconta:".$clpagordemconta->erro_status;
        return false;
      }

    }
   
    /*
     * Caso o usuário marcou que devemos agendar automaticamente 
     * a nota liquidada, fizemos o lancamento.
     */
    $clempparametro = $this->usarDao("empparametro", true);
    $rsParametros   = $clempparametro->sql_record($clempparametro->sql_query_file(db_getsession("DB_anousu"),"*"));
    if ($clempparametro->numrows > 0){
      $oParametros = db_utils::fieldsMemory($rsParametros,0);
    } else {
      throw new Exception("Erro [1] - Não foi possível encontrar parametros do empenho para o ano."); 
    }
    if (isset($oParametros->e30_agendaautomatico) && $oParametros->e30_agendaautomatico == "t") {

       require_once("model/agendaPagamento.model.php"); 
       $oAgenda = new agendaPagamento();
       $oAgenda->setCodigoAgenda($oAgenda->newAgenda());
       //Criamos o objeto da nota, que sera agendada.
       $oNota  = new stdClass;
       $oNota->iNumEmp   = $numemp;
       $oNota->iCodNota  = $clpagordem->e50_codord;
       $oNota->nValor    = $valor;
       $oNota->iCodTipo  = null;
       
       try {
         
         $this->iCodigoMovimento = $oAgenda->addMovimentoAgenda(1, $oNota);
         
       }
       catch (Exception $eErroNota) {

         $this->erro_status = '0';
         $this->erro_msg    = $eErroNota->getMessage();
         
       }
       
      //incluimos as retencoes da nota.
      require ('model/retencaoNota.model.php');
      try {
        
        $oRetencaoNota = new retencaoNota($codnota);
        $oRetencaoNota->setInSession(true);
        $oRetencaoNota->setCodigoMovimento($this->iCodigoMovimento);
        $oRetencaoNota->salvar($clpagordem->e50_codord);
        
      }
      catch (Exception $eErro) {
  
        $this->erro_status = '0';
        $this->erro_msg    = $eErro->getMessage();
        
      }
    }
    $this->iPagOrdem = $clpagordem->e50_codord;
    return true;
  }

  /**
   * quando estornar a nota de liquidação
   * colocar a pagordemele com valor liquidado =0 e valor anulado =valor
   * e colocar pagordemelenota com valor anulado =true
   *  
   */

  function estornaOP($numemp = "", $codele = "", $codnota = "", $valor = "", $retencoes = "", $historico) {
    if ($numemp == "" || $codele == "" || $codnota == "" || $valor == "") {
      
      $this->erro_status = '0';
      $this->erro_msg = "Parametros faltando ($numemp,$codele,$codnota,$valor,$retencoes) ";
      return false;
      
    }
    // variaveis acessiveis nessa função
    global $e60_numemp, $e71_codord;

    $clpagordemnota = new cl_pagordemnota;
    $res = $clpagordemnota->sql_record($clpagordemnota->sql_query(null, null
          ,"*",null,"e71_codnota = {$codnota} and e71_anulado is false"));
          
    if ($clpagordemnota->numrows > 0) {

      $oNota = db_utils::fieldsmemory($res, 0);
      /*
       * Verificamos a data da sessao. se for maior que a data da nota, nao podemos realizare 
       * a operação;
       */
       if (db_strtotime($this->datausu) < db_strtotime($oNota->e50_data)) {
        
         $this->erro_status = '0';
         $this->erro_msg    = "Data inválida. data do estorno deve ser maior ou igual que a data da nota de liquidação"; 
         return false;
         
      }   
      
      $clpagordemele = new cl_pagordemele;
      $clpagordemele->e53_codord = $oNota->e71_codord;
      $clpagordemele->e53_codele = $codele;
      $clpagordemele->e53_vlranu = "$valor";
      //$clpagordemele->e53_valor  = '0.00';
      //$clpagordemele->e53_vlrpag = '0.00';
      $clpagordemele->alterar($clpagordemele->e53_codord, $clpagordemele->e53_codele);
      if ($clpagordemele->erro_status == 0) {
        $this->erro_status = '0';
        $this->erro_msg    = "Pagordemele:".$clpagordemele->erro_msg;
        return false;
      }

      $clpagordemnota              = new cl_pagordemnota;
      $clpagordemnota->e71_codord  = $clpagordemele->e53_codord;
      $clpagordemnota->e71_codnota = $codnota;
      $clpagordemnota->e71_anulado = 'true';
      $clpagordemnota->alterar($clpagordemnota->e71_codord, $clpagordemnota->e71_codnota);
      if ($clpagordemnota->erro_status == 0) {
        
        $this->erro_status = '0';
        $this->erro_msg = "Pagordemnota:".$clpagordenota->erro_msg;
        return false;
      }
    } else {
      
      $this->erro_status = '0';
      $this->erro_msg = "Nota de liquidação não encontrada.";
      return false;
        
    }  
  }

  /**
   *  funcao para retorno dos dados do empenho (retona um objeto db_utils);
   *  @param integer $iEmpenho
   *  @param  string [$sWhere]
   */
  function getDados($iEmpenho, $sWhere = null){

    $objEmpenho        = new cl_empempenho();
    $rsEmp             = $objEmpenho->sql_record($objEmpenho->sql_query($iEmpenho,"*",null,$sWhere));
    $this->iNumRowsEmp = $objEmpenho->numrows;
    if ($this->iNumRowsEmp > 0){
      $this->dadosEmpenho  =  db_utils::fieldsMemory($rsEmp,0,false,false, $this->getEncode());
      return true;
    }else{
      return false; 
    }
  }
  /**
   *  funcao para retorno das notas do empenho (retona um resource);
   *  @param integer iEmpenho
   *  @param string [sWhere]     
   *  @param boolean [$lNotaCancelada] traz as nota com nota de liquidacao anulada.
   */
  function getNotas ($iEmpenho, $sWhere = '', $lNotaCancelada = true){

    $objNota  = new cl_empnota(); 
    if (trim($sWhere) != ''){
      $sWhere = " and $sWhere";
    }
    
    if ($lNotaCancelada) {
      $sJoinPag = ''; 
    } else {
      $sJoinPag = ' and e71_anulado is false';
    }   
    $sSqlNota  = "SELECT {$this->sCamposNota}";
    $sSqlNota .= "  from empnota ";
    $sSqlNota .= "       inner join empnotaele   on  e69_codnota              = e70_codnota";
    $sSqlNota .= "       inner join db_usuarios  on  db_usuarios.id_usuario   = empnota.e69_id_usuario";
    $sSqlNota .= "       inner join empempenho   on  empempenho.e60_numemp    = empnota.e69_numemp";
    $sSqlNota .= "       inner join cgm          on  cgm.z01_numcgm           = empempenho.e60_numcgm";
    $sSqlNota .= "       inner join db_config    on  db_config.codigo         = empempenho.e60_instit";
    $sSqlNota .= "                              and  e60_instit               =".db_getsession('DB_instit');
    $sSqlNota .= "       inner join orcdotacao   on  orcdotacao.o58_anousu    = empempenho.e60_anousu";
    $sSqlNota .= "                              and  orcdotacao.o58_coddot    = empempenho.e60_coddot";
    $sSqlNota .= "       inner join pctipocompra on  pctipocompra.pc50_codcom = empempenho.e60_codcom";
    $sSqlNota .= "       inner join emptipo      on  emptipo.e41_codtipo      = empempenho.e60_codtipo";
    $sSqlNota .= "       left join pagordemnota  on  e71_codnota              = empnota.e69_codnota {$sJoinPag}";
    $sSqlNota .= "       left join pagordem      on  e71_codord               = e50_codord";
    $sSqlNota .= "       left join pagordemele   on  e53_codord               = pagordemnota.e71_codord";
    $sSqlNota .= "       left join empnotaord    on  m72_codnota              = e69_codnota";
    $sSqlNota .= "       left join matordem      on  m72_codordem             = m51_codordem";
    $sSqlNota .= "       left join matordemanu   on  m51_codordem             = m53_codordem";
    $sSqlNota .= " where  e69_numemp = {$iEmpenho} {$sWhere}";
    $rsNota    = $objNota->sql_record($sSqlNota);
    //die($sSqlNota);
    $this->iNumRowsNotas = $objNota->numrows;
    if ($objNota->numrows > 0) {
      return $rsNota;
    } else {
      return false;
    }
  }
  function getItensNota($iCodNota) {
    
    $oNota           = $this->usarDao("empnotaitem", true);
    $sSqlItensNota   = "select pc01_descrmater, ";
    $sSqlItensNota  .= "       e72_qtd, ";
    $sSqlItensNota  .= "       e72_empempitem , ";
    $sSqlItensNota  .= "       e72_valor,";
    $sSqlItensNota  .= "       e72_vlrliq,";
    $sSqlItensNota  .= "       e72_vlranu";
    $sSqlItensNota  .= "  from empnotaitem";
    $sSqlItensNota  .= "         inner join empempitem on e62_sequencial = e72_empempitem";
    $sSqlItensNota  .= "         inner join pcmater    on  e62_item      = pc01_codmater";
    $sSqlItensNota  .= "  where e72_codnota = {$iCodNota}";
    $rsNota          = $oNota->sql_record($sSqlItensNota);
    $aItensNota      = array();
    if ($rsNota) {
      for ($iInd = 0; $iInd < $oNota->numrows; $iInd++) {
         $aItensNota[] = db_utils::fieldsMemory($rsNota, $iInd);
      }  
      return $aItensNota;
    }else{
      return false;   
    }
  }  

  /**
   *  funcao para para converter dados do empenho e notas em string json;
   *  @param  integer iEmpenho 
   *  @param  string [sWhere]
   *  @return string json;
   */
  function empenho2Json($sWhere = '',$itens = 0){

    if (!class_exists("services_json")){
      require "libs/JSON.php";
    }
    if (!class_exists("retencaoNota")){
      require_once "model/retencaoNota.model.php";
    }
    $objJson = new services_JSON();
    if ($this->getDados($this->numemp, $sWhere)){

      $this->getSolicitacoesAnulacoes();
      $strJson["status"]     = 1;
      $strJson["e60_numemp"] = $this->dadosEmpenho->e60_numemp;
      $strJson["e60_codemp"] = $this->dadosEmpenho->e60_codemp;
      $strJson["e60_anousu"] = $this->dadosEmpenho->e60_anousu;
      $strJson["e60_coddot"] = $this->dadosEmpenho->e60_coddot;
      $strJson["e60_numcgm"] = $this->dadosEmpenho->e60_numcgm;
      $strJson["z01_nome"]   = $this->dadosEmpenho->z01_nome;
      $strJson["o58_codigo"] = $this->dadosEmpenho->o58_codigo;
      $strJson["o15_descr"]  = trim($this->dadosEmpenho->o15_descr);
      $strJson["e60_vlremp"] = trim(db_formatar($this->dadosEmpenho->e60_vlremp,"f"));
      $strJson["e60_vlrliq"] = trim(db_formatar($this->dadosEmpenho->e60_vlrliq,"f"));
      $strJson["e60_vlrpag"] = trim(db_formatar($this->dadosEmpenho->e60_vlrpag,"f"));
      $strJson["e60_vlranu"] = trim(db_formatar($this->dadosEmpenho->e60_vlranu,"f"));
      $strJson["numnotas"]   = "0"; 
      if ($this->operacao == 1){
        $strJson["saldo_dis"] = trim(db_formatar($this->dadosEmpenho->e60_vlremp - $this->dadosEmpenho->e60_vlranu
            -$this->dadosEmpenho->e60_vlrliq,"f"));
        $sWhere = '';                                    

      }else if ($this->operacao == 2) {

        $sWhere = " e69_anousu = {$this->anousu}"; 
        $strJson["saldo_dis"] = 0; 
        $sSQLPgtoOrdem = "select  sum(e53_valor) as e53_valor,
          sum(e53_vlranu) as e53_vlranu,
          sum(e53_vlrpag) as e53_vlrpag
            from pagordem
            inner join pagordemele on e50_codord = e53_codord
            where e50_numemp = {$this->dadosEmpenho->e60_numemp}
            ";       
            $rsOrdem  = pg_query($sSQLPgtoOrdem);
        if (pg_num_rows($rsOrdem) == 1){
          $objOrdem = db_utils::fieldsMemory($rsOrdem,0);                              

          $strJson["saldo_dis"] = trim(db_formatar($objOrdem->e53_valor - $objOrdem->e53_vlranu - $objOrdem->e53_vlrpag,"f"));
        }
      }
      if ($itens == 0){
#$rsNotas = $this->getNotas($this->numemp, "m53_codordem is null");
        $rsNotas = $this->getNotas($this->numemp, $sWhere, false);
        if ($rsNotas){

          if ($this->iNumRowsNotas > 0){
            $strJson["numnotas"]   = $this->iNumRowsNotas; 

            for ($i = 0;$i < $this->iNumRowsNotas;$i++){

              
              $objNotas = db_utils::fieldsMemory($rsNotas,$i);
              $oRetencao = new retencaoNota($objNotas->e69_codnota);
              $oRetencao->unsetSession();
              
              if ($this->operacao == 1){
                $checked = "";
                if ($objNotas->e70_valor == $objNotas->e70_vlrliq+$objNotas->e70_vlranu){
                  $checked = "disabled";
                }
              }else{
                $checked = "disabled";
                if ($objNotas->e70_valor == $objNotas->e70_vlrliq){
                  $checked = "";
                }else{
                  $checked = "disabled";
                }
              }
              $sStrNotas = $this->getInfoAgenda($objNotas->e69_codnota);
              $strJson["data"][] = array (
                  "e69_codnota" => $objNotas->e69_codnota,
                  "e69_numero"  => urlencode($objNotas->e69_numero),
                  "e69_anousu"  => $objNotas->e69_anousu,
                  "e50_anousu"  => $objNotas->e50_anousu,
                  "e69_dtnota"  => db_formatar($objNotas->e69_dtnota,"d"),
                  "e70_vlranu"  => trim(db_formatar($objNotas->e70_vlranu,"f")),
                  "e70_vlrliq"  => trim(db_formatar($objNotas->e70_vlrliq,"f")),
                  "e70_valor"   => trim(db_formatar($objNotas->e70_valor,"f")),
                  "e53_vlrpag"  => trim(db_formatar($objNotas->e53_vlrpag,"f")),
                  "vlrretencao" => trim(db_formatar($objNotas->vlrretencao,"f")),
                  "e50_codord"  => $objNotas->e50_codord,
                  "sInfoAgenda" => urlencode($sStrNotas),
                  "libera"      => $checked
                  );
            }//end for
          }
        }
      }else if ($itens == 1){
        $rsItens = $this->getItensSaldo();
        if ($rsItens){

          if ($this->iNumRowsItens > 0){
            $strJson["numnotas"]   = $this->iNumRowsItens; 

            for ($i = 0;$i < $this->iNumRowsItens;$i++){

              $objNotas = db_utils::fieldsMemory($rsItens,$i);
              $checked  = '';
              if ($objNotas->saldovalor == 0){
                $checked = " disabled ";
              }
              $strJson["data"][] = array (
                  "pc01_descrmater" => urlencode($objNotas->pc01_descrmater),
                  "e62_sequen"      => $objNotas->e62_sequen,
                  "e62_sequencial"  => $objNotas->e62_sequencial,
                  "saldo"           => $objNotas->saldo,
                  "e62_vlrun"       => $objNotas->e62_vlrun,
                  "pc01_fraciona"   => $objNotas->pc01_fraciona,
                  "pc01_servico"    => $objNotas->pc01_servico, 
                  "e62_vlrtot"      => round($objNotas->saldovalor,2),
                  "libera"          => $checked
                  );
            }//end for
          }
        }
      }
      $strJson["itensAnulados"] = $this->aItensAnulados;
    }else{
      $strJson["status"]     = 0;

    }
    return $objJson->encode($strJson);
  }
  /**
   * callback apra liquidar as notas via ajax
   * @param integer $iEmpenho numero do empenho,
   * @param mixed $aNotas notas a liquidar 
   * @param string [historico] historico do procedimento
   * @return boolean;
   */
  function liquidarAjax($iEmpenho,$aNotas, $sHistorico = ''){

    (boolean)$this->lSqlErro = false; 
    (string) $this->sMsgErro = false;
    if ($sHistorico == ""){
      $sHistorico = "S/Historico";
    }
    /*Consultado dados do empenho
     * TODO Verificar estado do empenho antes de fazer as liquidacoes
     */
    //$aNotas deve ser um array
    if (!is_array($aNotas)){

      $this->lSqlErro = true;
      $this->sMsgErro = "Erro (0) Notas Inválidas.";
    }
    //verificamos se o empenho existe, e se a valor para liquidar
    if (!$this->getDados($iEmpenho)){

      $this->lSqlErro = true;
      $this->sMsgErro = "Erro (1) Não foi possível selecionar Empenho.";

    }else{

      if ($this->dadosEmpenho->e60_vlremp == $this->dadosEmpenho->e60_vlrliq){

        $this->sMsgErro = "Erro (3) Empenho sem valor para Liquidar.";
        $this->lSqlErro = true;
      }
    }
    if (!$this->lSqlErro){

      $clempelemento = new cl_empelemento();
      $rsEle         = $clempelemento->sql_record($clempelemento->sql_query($iEmpenho, null, "*"));
      if ($clempelemento->numrows == 1){
        $objEmpElem  = db_utils::fieldsMemory($rsEle,0);    
      }else{
        $this->lSqlErro = true; 
        $this->sMsgErro = "Erro (2) Empenho sem elemento.";
      }
    }
    if (!$this->lSqlErro){
      db_inicio_transacao(); 
      //inciamos lançamentos contabeis para cada nota lancada.
      (float)$totalLiquidado = 0;
      (string)$sV            = "";
      (string) $sNotas       = ""; 
      for ($i = 0; $i < count($aNotas); $i++){

        //pegamos dados das notas e tentamos fazer os lançamentos contábeis.
        $objNota = db_utils::fieldsMemory($this->getNotas($iEmpenho,"e69_codnota = ".$aNotas[$i]),0);
        $this->liquidar($iEmpenho, $objEmpElem->e64_codele, $objNota->e69_codnota, $objNota->e70_valor, $sHistorico);
        if ($this->erro_status == "0"){

          $this->lSqlErro = true;
          $this->sMsgErro = $this->erro_msg;
        }
        //lancando op para a nota
        if (!$this->lSqlErro){

          $this->lancaOP($iEmpenho, $objEmpElem->e64_codele, $objNota->e69_codnota, $objNota->e70_valor, null, $sHistorico);
          if ($this->erro_status == "0"){

            $this->lSqlErro = true;
            $this->sMsgErro = $this->erro_msg;
          } else {
            
            $sNotas .= $sV.$this->iCodOrdem;
            $sV      = ",";
          } 
        }
        if (!$this->lSqlErro){
          $totalLiquidado +=$objNota->e70_valor;
        }
      }//end for
    }

    db_fim_transacao($this->lSqlErro);
    $objJson = new services_JSON();
    if ($this->lSqlErro){
      $retorno = array("erro"=>2,"mensagem" => urlencode($this->sMsgErro),"e50_codord");
    }else{
      $total = 0;
      if ($totalLiquidado == $this->dadosEmpenho->e60_vlremp){

        $total = 1;   
      }

      $retorno = array("erro"=>1,"mensagem" => "OK","total"=>$total,"sOrdensGeradas"=> $sNotas);
    }
    return $objJson->encode($retorno);
  }//end function 

  /**
   * callback para estornar a liquidacao via ajax
   * @param  integer $iEmpenho numero do empenho,
   * @param  mixed $aNotas notas a liquidar  
   * @param  string [$sHistorico] historico do procedimento
   * @return boolean;
   */
  
  function estornarLiquidacaoAJAX($iEmpenho,$aNotas, $sHistorico = ''){

    (boolean)$this->lSqlErro = false; 
    (string) $this->sMsgErro = false;
    if ($sHistorico == ""){
      $sHistorico = "S/Historico";
    }
    /*Consultado dados do empenho
     * TODO Verificar estado do empenho antes de fazer as liquidacoes
     */
    //$aNotas deve ser um array
    if (!is_array($aNotas)){

      $this->lSqlErro = true;
      $this->sMsgErro = "Erro (0) Notas Inválidas.";
    }
    //verificamos se o empenho existe, e se a valor para liquidar
    if (!$this->getDados($iEmpenho)){

      $this->lSqlErro = true;
      $this->sMsgErro = "Erro (1) Não foi possível selecionar Empenho.";

    }
    if (!$this->lSqlErro){

      $clempelemento = new cl_empelemento();
      $rsEle         = $clempelemento->sql_record($clempelemento->sql_query($iEmpenho, null, "*"));
      if ($clempelemento->numrows == 1){
        $objEmpElem  = db_utils::fieldsMemory($rsEle,0);    
      }else{
        $this->lSqlErro = true; 
        $this->sMsgErro = "Erro (2) Empenho sem elemento.";
      }
    }

    if (!$this->lSqlErro){
      db_inicio_transacao(); 
      (float)$totalLiquidado = 0;
      for ($i = 0; $i < count($aNotas); $i++){

        $objNota    = db_utils::fieldsMemory($this->getNotas($iEmpenho,"e69_codnota = ".$aNotas[$i]),0);
        //verificamos o tipo da ordem , se for virtual devemos anular a ordem de compra e seus itens.
        $sSQLOrdem  = "select m51_tipo,";
        $sSQLOrdem .= "       m73_codmatestoqueitem,";
        $sSQLOrdem .= "       m52_codlanc,";
        $sSQLOrdem .= "       m72_codordem,";
        $sSQLOrdem .= "       m52_valor,";
        $sSQLOrdem .= "       m52_quant";
        $sSQLOrdem .= "  from matordem ";
        $sSQLOrdem .= "        inner join empnotaord   on m72_codordem    = m51_codordem";
        $sSQLOrdem .= "        inner join matordemitem on m51_codordem    = m52_codordem ";
        $sSQLOrdem .= "        left  join matestoqueitemoc on m52_codlanc = m73_codmatordemitem";
        $sSQLOrdem .= " where m72_codnota = {$objNota->e69_codnota}";
        $rOrdem    = pg_query($sSQLOrdem);
        if (pg_num_rows($rOrdem) > 0){

          if (!class_exists("cl_matordemanu")){
            require_once "classes/db_matordemanu_classe.php"; 
          }
          if (!class_exists("cl_matordemitemanu")){
            require_once "classes/db_matordemitemanu_classe.php"; 
          }
          if (!class_exists("cl_matordemanul")){
            require_once "classes/db_matordemanul_classe.php"; 
          }
          $clmatordemanu     = new cl_matordemanu();
          $clmatordemanul    = new cl_matordemanul();
          $clmatordemitemanu = new cl_matordemitemanu();
          /*
             vamos verificar se essa nota possui algum item em estoque.
             se possui, nao podemos deixar extornar a liquidacao
           */  
          for ($j = 0; $j < pg_num_rows($rOrdem);$j++){

            $oMatordemItem = db_utils::fieldsMemory($rOrdem,$j); 
            if ($oMatordemItem->m73_codmatestoqueitem != null and $oMatordemItem->m51_tipo == 2){

              $this->lSqlErro  = true;
              $this->sMsgErro  = "Nota ({$objNota->e69_numero}) possui Itens com entrada no estoque.";
              $this->sMsgErro .= "\nNão podera ser estornada (anulada) a liquidação.";

            }
            if (!$this->lSqlErro and $oMatordemItem->m51_tipo == 2){

              $clmatordemanul->m37_hora    = db_hora();
              $clmatordemanul->m37_data    = date("Y-m-d",db_getsession("DB_datausu"));
              $clmatordemanul->m37_usuario = db_getsession("DB_id_usuario");
              $clmatordemanul->m37_motivo  = "Cancelamento por anulação de liquidação";
              $clmatordemanul->m37_empanul = "0";
              $clmatordemanul->m37_tipo    = 1;//anulacao parcial;
              $clmatordemanul->incluir(null);
              if ($clmatordemanul->erro_status == 0){

                $this->lSqlErro  = true;
                $this->sMsgErro  = "Erro (3) anulacao do item nao incluso.";
                $this->sMsgErro .= "\n{$clmatordemanul->erro_msg}";
              }
            }
            if (!$this->lSqlErro and $oMatordemItem->m51_tipo == 2){

              $clmatordemitemanu->m36_matordemitem = $oMatordemItem->m52_codlanc;
              $clmatordemitemanu->m36_matordemanul = $clmatordemanul->m37_sequencial;
              $clmatordemitemanu->m36_vrlanu       = $oMatordemItem->m52_valor;
              $clmatordemitemanu->m36_qtd          = $oMatordemItem->m52_quant;
              $clmatordemitemanu->m36_vrlanu       = $oMatordemItem->m52_valor;

              $clmatordemitemanu->incluir(null);
              if ($clmatordemitemanu->erro_status == 0){

                $this->lSqlErro  = true;
                $this->sMsgErro  = "Erro (3) anulacao do item nao incluso.";
                $this->sMsgErro .= "\n{$clmatordemitemanu->erro_msg}";
              }
            }
            if (!$this->lSqlErro and $oMatordemItem->m51_tipo == 2){
              if (!class_exists("cl_empnotaele")){
                require_once "classes/db_empnotaele_classe.php";
              }
              $clempnotaele              = new cl_empnotaele();
              $clempnotaele->e70_vlranu  = $objNota->e70_valor;
              $clempnotaele->e70_codnota = $objNota->e69_codnota;
              $clempnotaele->alterar($objNota->e69_codnota);
              if ($clempnotaele->erro_status == 0){

                $this->lSqlErro  = true;
                $this->sMsgErro  = "Erro (5) anulacao do valor da nota nao incluso.";
                $this->sMsgErro .= "\\n{$clempnotaele->erro_msg}";

              }
            }
          }
        }
        if (!$this->lSqlErro){
          //pegamos dados das notas e tentamos fazer os lançamentos contábeis par ao estorno.
          $this->estornaLiq($iEmpenho, $objEmpElem->e64_codele, $objNota->e69_codnota, $objNota->e70_valor, $sHistorico);
          if ($this->erro_status == "0"){

            $this->lSqlErro = true;
            $this->sMsgErro = $this->erro_msg;
          }
        }
        //anulando o  op para a nota
        if (!$this->lSqlErro){

          $this->estornaOP($iEmpenho, $objEmpElem->e64_codele, $objNota->e69_codnota, $objNota->e70_valor, null, $sHistorico);
          if ($this->erro_status == "0"){

            $this->lSqlErro = true;
            $this->sMsgErro = $this->erro_msg;
          }
        }
        if (!$this->lSqlErro){
          $totalLiquidado +=$objNota->e70_valor;
        }
      }//end for
    }
    db_fim_transacao($this->lSqlErro);
    $objJson = new services_JSON();
    if ($this->lSqlErro){
      $retorno = array("erro"=>2,"mensagem" => urlencode($this->sMsgErro));
    }else{
      $total = 0;
      if ($totalLiquidado == $this->dadosEmpenho->e60_vlremp){

        $total = 1;   
      }
      $retorno = array("erro"=>1,"mensagem" => "OK","total"=>$total);
    }
    return $objJson->encode($retorno);
  }

  function setEmpenho($iEmpenho){

    $this->numemp = $iEmpenho;
  }

  function getEmpenho(){

    return $this->numemp;
  }
  /**
   *  funcao para para retornar itens do empenho (com saldo) ;
   *  @return recordset;
   */

  function getItensSaldo(){

    $this->clempempitem = new cl_empempitem();
    $sqlItensEmpenho  = "select rsdescr as pc01_descrmater, ";
    $sqlItensEmpenho .= "       rnquantini as e62_quant, ";
    $sqlItensEmpenho .= "       pc01_servico,";
    $sqlItensEmpenho .= "       pc01_fraciona,";
    $sqlItensEmpenho .= "       riseqitem as e62_sequen,";
    $sqlItensEmpenho .= "       ricoditem as e62_sequencial,";
    $sqlItensEmpenho .= "       rnsaldoitem as saldo, ";
    $sqlItensEmpenho .= "       rnvalorini as e62_vltot, ";
    $sqlItensEmpenho .= "       rnsaldovalor as saldovalor, ";
    $sqlItensEmpenho .= "       rnvaloruni as e62_vlrun ";
    $sqlItensEmpenho .= "  From fc_saldoitensempenho({$this->numemp}) ";
    $sqlItensEmpenho .= "       inner join pcmater on riCodmater = pc01_codmater " ;
    $sqlItensEmpenho .= " order by e62_sequen ";
    $rsItems         = $this->clempempitem->sql_record($sqlItensEmpenho); 
    if ($rsItems){
      $this->iNumRowsItens = pg_num_rows($rsItems);
      return $rsItems;
    }else{
      echo pg_last_error();
      return false;
    }
  }
  /**
   *  funcao para para gerar OC's ,
   *  @param integer $iNumNota numero da nota, float $nTotali valor total da nota,mixed $aItens [,boolean $lLiquidar,date $dDataNota] 
   *  @return recordset;
   */
  function gerarOrdemCompra($iNumNota, $nTotal,$aItens,$lLiquidar=false,$dDataNota = null, $sHistorico = null){

    $this->lSqlErro  = false;
    $this->sErroMsg  = '';
    $this->iPagOrdem = '';
    if ($dDataNota == null){
      $e69_dtnota  = date("Y-m-d",db_getsession("DB_datausu"));
    }else{
      $dtaux = explode("/",$dDataNota);
      if (count($dtaux) != 3){

        $this->lSqlErro = true;
        $this->sMsgErro = "Argumento [dDataNota] não é uma data válida.";
        return false;             
      }else{
        $e69_dtnota = $dtaux[2]."-".$dtaux[1]."-".$dtaux[0];         
      }
    }
    if (!class_exists("cl_matordem")){
      require "classes/db_matordem_classe.php";  
    }
    $objMatOrdem = new cl_matordem();
    if (!class_exists("cl_matordeitem")){
      require "classes/db_matordemitem_classe.php";  
    }
    $objMatOrdemItem = new cl_matordemitem();
    if (!class_exists("cl_empnotaord")){
      require "classes/db_empnotaord_classe.php";  
    }
    $objMatOrdemItem = new cl_matordemitem();
    if (!is_array($aItens)){
      $this->lSqlErro = true;
      $this->sMsgErro = "Argumento [ 1 ] não é um array.";
      return false;             
    }
    if (trim($iNumNota) == ''){

      $this->lSqlErro = true;
      $this->sMsgErro = "Número da nota nao pode ser vazio.";
      return false;             

    }
    //incluimos a ordem.
    db_inicio_transacao();
    $this->getDados($this->numemp);
    $objMatOrdem->m51_data       = $this->datausu;
    $objMatOrdem->m51_depto      = db_getsession("DB_coddepto");
    $objMatOrdem->m51_numcgm     = $this->dadosEmpenho->e60_numcgm;
    $objMatOrdem->m51_obs        = "Ordem de Compra Automatica";
    $objMatOrdem->m51_valortotal = $nTotal;
    $objMatOrdem->m51_prazoent   = "0";
    $objMatOrdem->m51_tipo       = 2;
    $objMatOrdem->Incluir(null);
    if ($objMatOrdem->erro_status == 0){

      $this->lSqlErro = true;
      $this->sMsgErro = "Erro (1) - não Foi possível gerar ordem de compra .\\nerro:{$objMatOrdem->erro_msg}"; 
    }
    if (!$this->lSqlErro){
      //incluimos os items da ordem de compra
      for ($i = 0; $i < count($aItens); $i++){

        $objMatOrdemItem->m52_codordem = $objMatOrdem->m51_codordem;
        $objMatOrdemItem->m52_numemp   = $this->numemp;
        $objMatOrdemItem->m52_sequen   = $aItens[$i]->sequen;
        $objMatOrdemItem->m52_quant    = $aItens[$i]->quantidade;
        $objMatOrdemItem->m52_valor    = $aItens[$i]->vlrtot;
        $objMatOrdemItem->m52_vlruni   = $aItens[$i]->vlruni;
        $objMatOrdemItem->incluir(null);
        if ($objMatOrdemItem->erro_status == 0){

          $this->lSqlErro = true;
          $this->sMsgErro = "Erro (1) - não Foi possível gerar itens da ordem de compra .\\nerro:{$objMatOrdemItem->erro_msg}"; 
        }  
      }
    }

    if (!$this->lSqlErro){
      //incluimos a nota com os valores da ordem de compra
      if (!class_exists("cl_empnota")){
        require "classes/db_empnota_classe.php";
      } 
      $objEmpNota = new cl_empnota();
      $objEmpNota->e69_numero     = $iNumNota;
      $objEmpNota->e69_numemp     = $this->numemp;
      $objEmpNota->e69_id_usuario = db_getsession("DB_id_usuario");
      $objEmpNota->e69_dtnota     = $e69_dtnota;
      $objEmpNota->e69_dtrecebe   = $this->datausu;
      $objEmpNota->e69_anousu     = db_getsession("DB_anousu");
      $objEmpNota->incluir(null);
      if ($objEmpNota->erro_status == 0){

        $this->lSqlErro = true;
        $this->sMsgErro = "Erro (1) - não Foi possível gerar nota do Empenho .\\nerro:{$objEmpNota->erro_msg}"; 
      }
    }
    if (!$this->lSqlErro){
      //incluimos os items na nota
      if (!class_exists("cl_empnotaitem")){
        require "classes/db_empnotaitem_classe.php";
      } 
      for ($i = 0; $i < count($aItens); $i++){

        $sSQL    = "select e62_sequencial";
        $sSQL   .= "   from empempitem ";
        $sSQL   .= "  where e62_numemp = {$this->numemp} ";
        $sSQL   .= "    and e62_sequen  = {$aItens[$i]->sequen}";
        $rsItem  = pg_query($sSQL);
        $oItem   = db_utils::fieldsMemory($rsItem,0);
        $this->iCodNota = $objEmpNota->e69_codnota;
        $objEmpNotaItem = new cl_empnotaitem();
        $objEmpNotaItem->e72_codnota    = $objEmpNota->e69_codnota;
        $objEmpNotaItem->e72_empempitem = $oItem->e62_sequencial;
        $objEmpNotaItem->e72_qtd        = $aItens[$i]->quantidade;
        $objEmpNotaItem->e72_valor      = $aItens[$i]->vlrtot;
        $objEmpNotaItem->e72_vlrliq     = $aItens[$i]->vlrtot;
        $objEmpNotaItem->incluir(null);
        if ($objEmpNotaItem->erro_status == 0){

          $this->lSqlErro = true;
          $this->sMsgErro = "Erro (1) - não Foi possível gerar itens da ordem de compra .\nerro:{$objEmpNotaItem->erro_msg}"; 
        }  
      }
    }

    if (!$this->lSqlErro){
      //geramos elemento da nota.
      $rsEle = $this->clempelemento->sql_record($this->clempelemento->sql_query($this->numemp)); 
      if ($this->clempelemento->numrows > 0){

        $objEmpElem = db_utils::fieldsMemory($rsEle,0);
        $this->dadosEmpenho->e64_codele = $objEmpElem->e64_codele;
        if (!class_exists("cl_empnotaele")){
          require "classes/db_empnotaele_classe.php";
        }
        $objEmpNotaEle = new cl_empnotaele();
        $objEmpNotaEle->e70_codnota = $objEmpNota->e69_codnota;
        $objEmpNotaEle->e70_codele  = $this->dadosEmpenho->e64_codele;
        $objEmpNotaEle->e70_valor   = round($nTotal, 2);
        $objEmpNotaEle->e70_vlranu  = "0";
        $objEmpNotaEle->e70_vlrliq  = "0";
        $objEmpNotaEle->incluir($objEmpNota->e69_codnota,$this->dadosEmpenho->e64_codele);
        if ($objEmpNotaEle->erro_status == 0){

          $this->lSqlErro  = true;
          $this->sMsgErro  = "Erro (1) -  Elemento da nota nao incluido.";
          $this->sMsgErro .= "\\nerro:{$objEmpNota->erro_msg}"; 
        } 
      }else{

        $this->lSqlErro  = true;
        $this->sMsgErro  = "Erro (2) -  Empenho ({$this->dadosEmpenho->e60_codemp}) sem elemento. operação cancelada.";
        $this->sMsgErro .= "\\nerro:{$objEmpNota->erro_msg}"; 

      }
    }

    if (!$this->lSqlErro){

      //incluimos empnotaord
      if (!class_exists("cl_empnotaord")){
        require ("classes/db_empnotaord_classe.php");
      }
      $objNotaOrd               = new cl_empnotaord();
      $objNotaOrd->m72_codordem = $objMatOrdem->m51_codordem;
      $objNotaOrd->m72_codnota  = $objEmpNota->e69_codnota;
      $objNotaOrd->incluir($objEmpNota->e69_codnota, $objMatOrdem->m51_codordem);
    }
    if ($lLiquidar && !$this->lSqlErro){

      $this->liquidar($this->numemp, $objEmpElem->e64_codele, $objEmpNota->e69_codnota, $nTotal,$sHistorico);
      if ($this->erro_status == "0"){

        $this->lSqlErro = true;
        $this->sMsgErro = $this->erro_msg;
      }
      //lancando op para a nota
      if (!$this->lSqlErro){

        $this->lancaOP($this->numemp, $objEmpElem->e64_codele, $objEmpNota->e69_codnota, $nTotal, null, $sHistorico);
        if ($this->erro_status == "0"){

          $this->lSqlErro = true;
          $this->sMsgErro = $this->erro_msg;
        }
      }
    }
    db_fim_transacao($this->lSqlErro);
    $objJson = new services_JSON();
    if ($this->lSqlErro){
      $retorno = array("erro"=>2,"mensagem" => urlencode($this->sMsgErro),"e50_codord" => null);
    }else{

      $retorno = array("erro"       =>1,
                       "mensagem"   => "OK",
                       "e50_codord" => $this->iPagOrdem,
                       "iCodMov"    => $this->getCodigoMovimento(),
                       "iCodNota"   => $objEmpNota->e69_codnota
                      );
    }
    return $objJson->encode($retorno);
  }

  function getSolicitacoesAnulacoes(){

    if (!class_exists('cl_empsolicitaanulitem')){
      require_once("classes/db_empsolicitaanulitem_classe.php");  
    }
    $clempsolicitaanulitem = new cl_empsolicitaanulitem();
    $sSQLAnulados          = "select e36_sequencial, ";
    $sSQLAnulados         .= "       e36_empempitem, ";   
    $sSQLAnulados         .= "       e36_vrlanu,     ";
    $sSQLAnulados         .= "       e62_sequen,     ";
    $sSQLAnulados         .= "       e36_qtdanu,     ";
    $sSQLAnulados         .= "       e36_empsolicitaanul,";
    $sSQLAnulados         .= "       pc01_descrmater "; 
    $sSQLAnulados         .= "  from empsolicitaanulitem";
    $sSQLAnulados         .= "       inner join empsolicitaanul on e36_empsolicitaanul = e35_sequencial  ";
    $sSQLAnulados         .= "       inner join empempitem      on e36_empempitem      = e62_sequencial ";
    $sSQLAnulados         .= "       inner join pcmater         on e62_item            = pc01_codmater  ";
    $sSQLAnulados         .= " where e35_numemp   = {$this->numemp} ";     
    $sSQLAnulados         .= "   and e35_situacao = 1";
    $sSQLAnulados         .= " order by e62_sequen";
    //echo $sSQLAnulados;exit;
    $rsAnulados            = $clempsolicitaanulitem->sql_record($sSQLAnulados);
    $this->aItensAnulados = array();
    if ($clempsolicitaanulitem->numrows > 0){

      for ($i = 0; $i < $clempsolicitaanulitem->numrows;$i++){

        $oAnulados = db_utils::fieldsMemory($rsAnulados,$i,false,false,true);
        $this->aItensAnulados[] = $oAnulados;
      }
    }
  }
  /**
   * @description Metodo para anular(itens) o empenho Itens do Empenho.
   * @param   $aItens array de itens que devem ser anulados - {[CodItemOrdem, CodItemEmp, Qtdem ,Valor]}
   * @param   $nValorAnular valor total a ser anulado;
   * @returns   void; 
   */

  function anularEmpenho($aItens , $nValorAnular = 0,$sMotivo = null, $aSolicitacoes = null,$iTipoAnulacao){

    if (!is_array($aItens)){

      $this->lSqlErro = true;
      $this->sErroMsg = "Erro [1]: Parametro aItens não e um array valido!\nContate Suporte"; 
      return false;
    }
    $this->lSqlErro = false;
    $this->sErroMsg = null;
    $this->getDados($this->numemp);
    $nValorAnular = round($nValorAnular,2);
    /*
       vericamos se existe saldo a anular;
     */
    (float)$nSaldoEmpenho = round($this->dadosEmpenho->e60_vlremp - $this->dadosEmpenho->e60_vlrliq - $this->dadosEmpenho->e60_vlranu,2);
    if ($nSaldoEmpenho < round($nValorAnular,2)) {

      $this->lSqlErro = true;

      $this->sErroMsg  = "Erro [2]: Não Existe saldo a anular no empenho!\nSaldo disponivel: R$ ".trim(db_formatar($nSaldoEmpenho,'f')); 
      $this->sErroMsg .=  "\nValor Solicitado para anulação: R$ ".trim(db_formatar($nValorAnular,'f')." $nSaldoEmpenho----$nValorAnular");
      return false;
    }
    $clempelemento  = $this->usarDao("empelemento", true);
    $rsEmpElemento  = $clempelemento->sql_record($clempelemento->sql_query($this->numemp, null, "e64_vlranu,e64_vlremp,e64_codele"));
    $oElemento      = db_utils::fieldsMemory($rsEmpElemento, 0);
    $nTotalElemento = $oElemento->e64_vlranu + $nValorAnular;
    if (bccomp($nTotalElemento,$oElemento->e64_vlremp) > 0){ // if $tot > $e64_vlremp

      $this->lSqlErro = true;
      $this->sErroMsg = "Erro[12](Sem saldo no elemento para anular\nNão pode anular o valor digitado para o elemento $elemento do empenho. Verifique!";
      return false;
    }

    //classes utilizadas pelo metodo;
    require_once("libs/db_libcontabilidade.php");
    $clempparametro = $this->usarDao("empparametro", true);
    $clpcparam      = $this->usarDao("pcparam", true);
    $rsParametros   = $clempparametro->sql_record($clempparametro->sql_query_file(db_getsession("DB_anousu"),"e30_verificarmatordem"));
    if ($clempparametro->numrows > 0){
      $oParametros = db_utils::fieldsMemory($rsParametros,0);
    }

    //pegamos os saldos da dotacao so empenho.
    db_inicio_transacao();
    $rsDotacaoSaldo = db_dotacaosaldo(8, 2, 2, "true", "o58_coddot={$this->dadosEmpenho->e60_coddot}", db_getsession("DB_anousu"));
    $oDotacaoSaldo	= db_utils::fieldsMemory($rsDotacaoSaldo, 0); 
    db_fim_transacao(true);

    /*
       testamos se existe saldo contabil disponivel para realizar a anulacao do empenho
     */ 
    if($this->dadosEmpenho->e60_anousu < db_getsession("DB_anousu")){
      $iCodTeste = "32";//anulação de restos a pagar.
    }else{
      $iCodTeste = "2"; //anulaçao de empenho.
    }

    db_inicio_transacao();
    $sSqlVerificacao  = "select fc_verifica_lancamento({$this->numemp},'";
    $sSqlVerificacao .= date("Y-m-d",db_getsession("DB_datausu"))."',{$iCodTeste},".round($nValorAnular,2).") as verificacao";
    $oVerificacao     = db_utils::fieldsMemory($this->clempempenho->sql_record($sSqlVerificacao),0);
    if (substr($oVerificacao->verificacao,0,2) > 0 ){

      $this->sErroMsg = substr($oVerificacao->verificacao,3);
      $this->lSqlErro = true;
      return false;
    }

    /*
       controle de andamento do empenho 
     */
    $rsPcParam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_contrandsol"));
    $oPcParam  = db_utils::fieldsMemory($rsPcParam, 0);

    if (isset ($oPcParam->pc30_contrandsol) && $oPcParam->pc30_contrandsol == 't') {		

      $clempautitem  = $this->usarDao("empautitem", true);
      $rsTransfItens = $clempautitem->sql_record($clempautitem->sql_query_anuaut(null,null," distinct pc11_codigo as cod_item",
            null,"e54_anulad is null and e61_numemp = {$this->numemp}"));
      $iNumRowsItensTransf = $clempautitem->numrows;
      if ($clempautitem->numrows > 0){

        $oTransfItens        = db_utils::fieldsMemory($rsTransfItens,0);
        $clsolandam          = $this->usarDao("solandam",true);
        $clsolandpadraodepto = $this->usarDao("solandpadraodepto",true);
        //local atual do empenho
        $rsLocal             = $clsolandam->sql_record($clsolandam->sql_query_andpad(null,"*",
              null,"pc43_solicitem = {$oTransfItens->cod_item} and pc47_pctipoandam = 6")
            );
        $sWhereSol           = "";
        if ($clsolandam->numrows>0){
          $sWhereSol = " pc47_pctipoandam = 5 ";	    		
        }else{
          $sWhereSol = " pc47_pctipoandam = 3 ";
        }	    	
        $rsDestino = $clsolandpadraodepto->sql_record($clsolandpadraodepto->sql_query(null, "*", null,
              "pc47_solicitem={$oTransfItens->cod_item} and {$sWhereSol}"));

        if ($clsolandpadraodepto->numrows > 0){

          $clproctransfer                  = $this->usarDao("proctransfer",true);
          $oDestino                        = db_utils::fieldsMemory($rsDestino,0);
          $clproctransfer->p62_hora        = db_hora();
          $clproctransfer->p62_dttran      = date("Y-m-d", db_getsession("DB_datausu"));
          $clproctransfer->p62_id_usuario  = db_getsession("DB_id_usuario");
          $clproctransfer->p62_coddepto    = db_getsession("DB_coddepto");
          $clproctransfer->p62_coddeptorec = $oDestino->pc48_depto;
          $clproctransfer->p62_id_usorec   = '0';
          $clproctransfer->incluir(null);
          $iCodTransf                      = $clproctransfer->p62_codtran;
          if ($clproctransfer->erro_status == 0) {

            $this->lSqlErro = true;
            $this->sErroMsg = "Erro [3] Não foi possível anular empenho\nErro ao incluir andamento\nErro:{$clproctransfer->erro_msg}";
            return false;
          }
          if (!$this->lSqlErro){

            $clsolicitemprot = $this->usarDao("solicitemproc",true);
            if (isset($iCodTransf) && $iCodTransf != ""){

              for ($w = 0; $w < $iNumRowsItensTransf; $w++){

                $oTransfItens = db_utils::fieldsMemory($rsTransfItens,$w);
                if (!$this->lSqlErro) {

                  $rsSolicProt = $clsolicitemprot->sql_record($clsolicitemprot->sql_query_file($oTransfItens->cod_item));
                  if ($clsolicitemprot->numrows > 0){

                    $oSolicProt         = db_utils::fieldsMemory($rsSolicProt, 0);					
                    $clproctransferproc = $this->usarDao("proctransferproc",true);
                    $clproctransferproc->incluir($iCodTransf,$oSolicProt->pc49_protprocesso);
                    // db_msgbox("proctransferproc");
                    if ($clproctransferproc->erro_status==0){

                      $this->lSqlErro = true;
                      $this->sErroMsg = $clproctransferproc->erro_msg;
                      return false;
                    }
                    if (!$this->lSqlErro) {

                      $clprotprocesso = $this->usarDao("protprocesso",true);
                      $clprotprocesso->p58_codproc= $oSolicProt->pc49_protprocesso;
                      $clprotprocesso->p58_despacho="Empenho Anulado!!";                        	
                      $clprotprocesso->alterar($oSolicProt->pc49_protprocesso);
                      //    db_msgbox("protprocesso");
                      if ($clprotprocesso->erro_status==0){

                        $this->lSqlErro = true;
                        $this->sErroMsg = $clprotprocesso->erro_msg;
                        return false;                    		
                      }
                    }
                  }
                  if ($this->lSqlErro == false) {

                    $clsolordemtransf = $this->usarDao("solordemtransf",true);
                    $clsolordemtransf->pc41_solicitem = $oTransfItens->cod_item;
                    $clsolordemtransf->pc41_codtran   = $iCodTransf;
                    $clsolordemtransf->pc41_ordem     = $oDestino->pc47_ordem;
                    $clsolordemtransf->incluir(null);
                    //db_msgbox("solordemtransf");
                    if ($clsolordemtransf->erro_status == 0){

                      $this->lSsqlErro = true;
                      $erro_msg=$clsolordemtransf->erro_msg;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }// fim  do controle de andamento de protocolo.
    /*
     ** Iniciamos as rotinas de inclusão nas tabelas de controle da anulação do empenho
     **
     */
    if (!$this->lSqlErro) {

      $this->clempempenho->e60_vlranu = $this->dadosEmpenho->e60_vlranu + round($nValorAnular,2);
      $this->clempempenho->e60_numemp = $this->numemp;
      $this->clempempenho->alterar($this->numemp);
      if ($this->clempempenho->erro_status == 0) {

        $this->lSqlErro = true;
        $this->sErroMsg = $this->clempempenho->erro_msg;
        return false;
      }
    }
    /*
     ** incluimos o dados do empenho na empanulado.
     */

    if (!$this->lSqlErro) {

      $clempanulado = $this->usarDao("empanulado",true);
      $clempanulado->e94_numemp         = $this->numemp;
      $clempanulado->e94_valor          = $nValorAnular;
      $clempanulado->e94_saldoant       = $nValorAnular; // carlos atualizado
      $clempanulado->e94_motivo         = $sMotivo;
      $clempanulado->e94_empanuladotipo = $iTipoAnulacao;
      $clempanulado->e94_data           = date("Y-m-d", db_getsession("DB_datausu"));
      $clempanulado->incluir(null);
      $iCodAnu = $clempanulado->e94_codanu;
      if ($clempanulado->erro_status == 0) {

        $this->lSqlErro  = true;
        $this->sErroMsg  = "Erro[10]\nNão Foi possível anular empenho.Erro ao cadastrar Empenho como anulado."; 
        $this->sErroMsg .= "\nErro:{$clempanulado->erro_msg}";
        return false;
      }
    }
    /*
     ** Alteramos o elemento do empenho, e em seguida incluimos na empanuladoele
     */
    if (!$this->lSqlErro) {

      $clempelemento->e64_numemp = $this->numemp;
      $clempelemento->e64_codele = $oElemento->e64_codele;
      $clempelemento->e64_vlranu = $nTotalElemento;
      $clempelemento->alterar($this->numemp, $oElemento->e64_codele);
      $erro_msg = $clempelemento->erro_msg;
      if ($clempelemento->erro_status == 0) {
        $this->lSqlErro = true;
        $this->sErroMsg  = "Erro[13]\nNão Foi possível anular empenho.Erro ao lançar valores do elemento."; 
        $this->sErroMsg .= "\nErro:{$clempelemento->erro_msg}";
        return false;

      }
    }
    if (!$this->lSqlErro) {

      $clempanuladoele             = $this->usarDao("empanuladoele",true);
      $clempanuladoele->e95_codanu = $iCodAnu;
      $clempanuladoele->e95_codele = $oElemento->e64_codele;
      $clempanuladoele->e95_valor  = $nValorAnular;
      $clempanuladoele->incluir($iCodAnu);
      if ($clempanuladoele->erro_status == 0) {

        $lSqlErro = true;
        $this->sErroMsg  = "Erro[14]\nNão Foi possível anular empenho.Erro ao incluir elemento anulado."; 
        $this->sErroMsg .= "\nErro:{$clempelemento->erro_msg}";
        return false;
      }
    }

    /*
     ** incluimos na empanuladoitem, e marcamos como realizada (2) a solicitação de anulacao,
     ** caso todos os itens da solicitação foram anulados.
     */
    if (!$this->lSqlErro){

      $clempanuladoitem = $this->usarDao("empanuladoitem",true);
      for ($iInd = 0; $iInd < count($aItens); $iInd++){

        $clempanuladoitem->e37_empempitem = $aItens[$iInd]->e62_sequencial;
        $clempanuladoitem->e37_empanulado = $iCodAnu;
        $clempanuladoitem->e37_vlranu     = $aItens[$iInd]->vlrtot;
        $clempanuladoitem->e37_qtd        = $aItens[$iInd]->quantidade;
        $clempanuladoitem->incluir(null);
        if ($clempanuladoitem->erro_status == 0){

          $this->lSqlErro = true;
          $this->sErroMsg  = "Erro[15]\nNão Foi possível anular empenho.Erro ao incluir Item como anulado."; 
          $this->sErroMsg .= "\nErro:{$clempanuladoitem->erro_msg}";
          return false;
        }
      }
    }
    /*
     ** Atualizamos as solicitações marcadas como atendidas....
     */ 
    if (!$this->lSqlErro && is_array($aSolicitacoes)){

      $clempsolicitaanul = $this->usarDao("empsolicitaanul",true);
      for ($iInd = 0; $iInd < count($aSolicitacoes); $iInd++){

        $clempsolicitaanul->e35_situacao   = 2;
        $clempsolicitaanul->e35_sequencial = $aSolicitacoes[$iInd]->e35_sequencial;
        $clempsolicitaanul->alterar($aSolicitacoes[$iInd]->e35_sequencial); 
        if ($clempsolicitaanul->erro_status == 0){

          $this->lSqlErro  = true;
          $this->sErroMsg  = "Erro[16]\nNão Foi possível anular empenho.Erro ao Atualizar situação da solicitaçao de anulação."; 
          $this->sErroMsg .= "\nErro:{$clempsolicitaanul->erro_msg}";
          return false;
        }
      }
    }

    /*
     ** Iniciamos os lancamentos contabeis para anulação do empenho.
     */ 
    for ($iEle = 0; $iEle < count($clempelemento->numrows); $iEle++){

      $oElemento = db_utils::fieldsMemory($rsEmpElemento,$iEle);
      if (!$this->lSqlErro){

        $iAnoUsu  = db_getsession("DB_anousu");
        $dDataUsu = date("Y-m-d", db_getsession("DB_datausu"));
        if ($this->dadosEmpenho->e60_anousu == $iAnoUsu) {
          $iCodDoc = '2';
        } else {
          $iCodDoc = '32';
        } 
        /*
         ** Atualização do orçamento.
         */
        if (!$this->lSqlErro && $this->dadosEmpenho->e60_anousu == $iAnoUsu) {

          $rsFcLancam = pg_query("select fc_lancam_dotacao({$this->dadosEmpenho->e60_coddot},
            '{$dDataUsu}',{$iCodDoc},{$nValorAnular}) as dotacao");
          $oFcLancam = db_utils::fieldsMemory($rsFcLancam, 0);
          if (substr($oFcLancam->dotacao, 0, 1) == 0) { //quando o primeiro caractere for igual a zero eh porque deu erro 

            $this->lSqlErro = true;
            $this->sErroMsg = "Erro [16]:Erro na atualização do orçamento \\n ".substr($dotacao, 1);
          }
        }
        /*
         ** Inicio dos lançamentos contabeis
         ** conlancam = tabela inicial do lançamento.
         */
        if (!$this->lSqlErro){

          $clconlancam             = $this->usarDao("conlancam",true);
          $clconlancam->c70_anousu = $iAnoUsu;
          $clconlancam->c70_data   = $dDataUsu;
          $clconlancam->c70_valor  = $nValorAnular;
          $clconlancam->incluir(null);
          $iCodLanc = $clconlancam->c70_codlan;
          if ($clconlancam->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[16] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancam->erro_msg})";
            return false;
          } 
        }
        /*
         ** conlancamele = lançamento do elemento.
         */
        if (!$this->lSqlErro) {

          $clconlancamele             = $this->usarDao("Conlancamele", true);
          $clconlancamele->c67_codlan = $iCodLanc;
          $clconlancamele->c67_codele = $oElemento->e64_codele;
          $clconlancamele->incluir($iCodLanc);
          if ($clconlancamele->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[17] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancamele->erro_msg})";
            return false;
          }
        }

        /*
         ** conlancamcgm = lançamento do cgm
         */

        if (!$this->lSqlErro) {

          $clconlancamcgm             = $this->usarDao("conlancamcgm", true);
          $clconlancamcgm->c76_data   = $dDataUsu;
          $clconlancamcgm->c76_codlan = $iCodLanc;
          $clconlancamcgm->c76_numcgm = $this->dadosEmpenho->e60_numcgm;
          $clconlancamcgm->incluir($iCodLanc);
          if ($clconlancamcgm->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[18] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancamcgm->erro_msg})";
            return false;
          }
        }
        /*
         ** conlancamcompl = lançamento do historico do lancamento
         */
        if (!$this->lSqlErro) {

          if ($sMotivo == '') {
            $sMotivo = 'Anulação de empenho';
          }
          $clconlancamcompl              = $this->usarDao("conlancamcompl", true);
          $clconlancamcompl->c72_codlan  = $iCodLanc;
          $clconlancamcompl->c72_complem = $sMotivo;
          $clconlancamcompl->incluir($iCodLanc);
          $erro_msg = $clconlancamcompl->erro_msg;
          if ($clconlancamcompl->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[19] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancamcompl->erro_msg})";
            return false;
          }
        }
        /*
         ** conlancamemp = lançamento de ligacao entre empenho e lancamento contabil
         */
        if (!$this->lSqlErro) {

          $clconlancamemp             = $this->usarDao("conlancamemp", true);
          $clconlancamemp->c75_data   = $dDataUsu;
          $clconlancamemp->c75_codlan = $iCodLanc;
          $clconlancamemp->c75_numemp = $this->numemp;
          $clconlancamemp->incluir($iCodLanc);
          if ($clconlancamemp->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[20] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancamemp->erro_msg})";
            return false;
          }
        }
        /*
         ** conlancamdot = lançamento das dotacoes
         */
        if ($this->dadosEmpenho->e60_anousu == db_getsession("DB_anousu")) {

          if (!$this->lSqlErro) {

            $clconlancamdot             = $this->usarDao("conlancamdot", true);
            $clconlancamdot->c73_data   = $dDataUsu;
            $clconlancamdot->c73_anousu = $iAnoUsu;
            $clconlancamdot->c73_coddot = $this->dadosEmpenho->e60_coddot;
            $clconlancamdot->c73_codlan = $iCodLanc;
            $clconlancamdot->incluir($iCodLanc);
            if ($clconlancamdot->erro_status == 0) {

              $this->lSqlErro  = true;
              $this->sErroMsg  = "Erro[21] Nao foi possivel iniciar lançamentos Contabeis\n";
              $this->sErroMsg .= "({$clconlancamdot->erro_msg})";
              return false;

            }
          }
        }
        /*
         ** conlancamdoc = lançamento do odocumento que oroginou o lançamento
         */
        if (!$this->lSqlErro) {

          $clconlancamdoc             = $this->usarDao("conlancamdoc", true);
          $clconlancamdoc->c71_data   = $dDataUsu;
          $clconlancamdoc->c71_coddoc = $iCodDoc;
          $clconlancamdoc->c71_codlan = $iCodLanc;
          $clconlancamdoc->incluir($iCodLanc);
          if ($clconlancamdoc->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro[22] Nao foi possivel iniciar lançamentos Contabeis\n";
            $this->sErroMsg .= "({$clconlancamdoc->erro_msg})";
            return false;
          }
        }
        /* 
         ** conlancamval = contas do lançamento
         */ 
        if (!$this->lSqlErro) {
          /*inicio-conlancamval*/
          $cltranslan = $this->usarDao("translan",true);
          if ($this->dadosEmpenho->e60_anousu < db_getsession("DB_anousu")) {
            $cltranslan->db_trans_estorna_empenho_resto($this->dadosEmpenho->e60_codcom, $this->dadosEmpenho->e60_anousu,
                $this->dadosEmpenho->e60_numemp);
          } else {
            $cltranslan->db_trans_estorna_empenho($this->dadosEmpenho->e60_codcom, $this->dadosEmpenho->e60_anousu);
          }
          if ($cltranslan->sqlerro){

            $this->lSqlErro = true;
            $this->sErroMsg = $cltranslan->erro_msg;
          }
          $arr_debito      = $cltranslan->arr_debito;
          $arr_credito     = $cltranslan->arr_credito;
          $arr_histori     = $cltranslan->arr_histori;
          $arr_seqtranslr  = $cltranslan->arr_seqtranslr;
          $clconplanoreduz = $this->usarDao("conplanoreduz",true); 
          for ($t = 0; $t < count($arr_credito); $t ++){
            //rotina que teste se a conta reduzida foi incluida no conplanoreduz
            $clconplanoreduz->sql_record($clconplanoreduz->sql_query_file(null,null, 'c61_codcon', '', 
                  "c61_anousu = ".DB_getsession("DB_anousu")." and c61_reduz=".$arr_debito[$t]));
            if ($clconplanoreduz->numrows == 0) {

              $this->lSqlErro = true;
              $this->sErroMsg = "Erro[23]: Conta ".$arr_debito[$t]." não dísponivel para o exercicio!";
            }
            $clconplanoreduz->sql_record($clconplanoreduz->sql_query_file(null,null, 'c61_codcon', '', 
                  "c61_anousu = ".DB_getsession("DB_anousu")." and c61_reduz=".$arr_credito[$t]));
            if ($clconplanoreduz->numrows == 0) {

              $this->lSqlErro = true;
              $this->sErroMsg = "Erro[24]: Conta ".$arr_credito[$t]." não dísponivel para o exercicio!";
            }
            //final  	
            if (!$this->lSqlErro) {

              $clconlancamval = $this->usarDao("conlancamval",true); 
              $clconlancamval->c69_codlan  = $iCodLanc;
              $clconlancamval->c69_credito = $arr_credito[$t];
              $clconlancamval->c69_debito  = $arr_debito[$t];
              $clconlancamval->c69_codhist = $arr_histori[$t];
              $clconlancamval->c69_valor   = $nValorAnular;
              $clconlancamval->c69_data    = $dDataUsu;
              $clconlancamval->c69_anousu  = $iAnoUsu;
              $clconlancamval->incluir(null);
              $c69_sequen                  = $clconlancamval->c69_sequen;
              if ($clconlancamval->erro_status == 0) {

                $this->lSqlErro  = true;
                $this->sErroMsg  = "Erro[25]:Empenho não anulado. Não foi possível contabilizar os valores.\n";
                $this->sErroMsg .= "({$clconlancamval->erro_msg})";
                return false;
              }
              /*conlancamlr   */
              if (!$this->lSqlErro) {

                $clconlancamlr = $this->usarDao("conlancamlr",true); 
                $clconlancamlr->c81_sequen     = $c69_sequen;
                $clconlancamlr->c81_seqtranslr = $arr_seqtranslr[$t];
                $clconlancamlr->incluir($c69_sequen, $arr_seqtranslr[$t]);
                $erro_msg = $clconlancamlr->erro_msg;
                if ($clconlancamlr->erro_status == 0) {

                  $this->lSqlErro = true;
                  $this->sErroMsg  = "Erro[26]:Empenho não anulado.\n";
                  $this->sErroMsg .= "({$clconlancamlr->erro_msg})";
                  return false;
                }
              } 
            }
          }
        }
      }
    }
    /* 
     ** fim dos lancamentos Contabeis e verificamos se o usuario solicitou a recriacao do saldo...
     */  
    if (!$this->lSqlErro){

      $iAutori         = 0;
      $clempautitem    = $this->usarDao("empempaut", true); 
      $rsItemSolic     = $clempautitem->sql_record($clempautitem->sql_query_file($this->numemp,"distinct e61_autori as autori"));
      $iNumRowsItemSol = $clempautitem->numrows;
      if ($iNumRowsItemSol > 0){
        $oItensSolic = db_utils::fieldsMemory($rsItemSolic,0);
        $iAutori     = $oItensSolic->autori;
      }
      // Se nao for RP e valor anulado nao for parcial e tiver solicitacao de compras
      if ($this->dadosEmpenho->e60_anousu >= db_getsession("DB_anousu") && 
          (round($this->dadosEmpenho->e60_vlremp,2) - round(($nValorAnular + $this->dadosEmpenho->e60_vlranu),2) == 0) &&
          $iAutori  > 0){
        $rsDotacao     = db_dotacaosaldo(8, 2, 2, "true", "o58_coddot={$this->dadosEmpenho->e60_coddot}", db_getsession("DB_anousu"));
        $oDotacaoSaldo = db_utils::fieldsMemory($rsDotacao, 0);
        pg_query("drop table work_dotacao");
        $saldo = (0 + $oDotacaoSaldo->atual_menos_reservado);
        $saldo = trim(str_replace(".","",db_formatar($saldo,"f")));
        $aDotacao[$this->dadosEmpenho->e60_coddot] = str_replace(",",".",$saldo);
        $clpcprocitem    = db_utils::getDao("pcprocitem");
        $clempautoriza   = db_utils::getDao("empautoriza");
        $clorcreservaaut = db_utils::getDao("orcreservaaut");
        $clorcreserva    = db_utils::getDao("orcreserva");
        $clorcreserva    = db_utils::getDao("orcreservasol");
        $clempautitem    = $this->usarDao("empautitem"); 
        $clempautoriza->sql_anulaautorizacao($iAutori,false,&$this->sErroMsg,&$this->lSqlErro,false,$aDotacao,$this->getRecriarSaldo());
      }

    }
    db_fim_transacao($this->lSqlErro);
    if (!$this->lSqlErro){
      $this->sErroMsg = "Anulação efetuadao com sucesso";
    }
  }//end function anularEmpenho;

  /**
   * Retorna os dados do empenho, caso ele seje RP
   * @param integer $iTipo  define o tipo de rp 1 - Nao Processao 2 processado
   */ 

  function getDadosRP($iTipo){

    $this->getDados($this->numemp);
    $oEmpResto      = $this->usarDao("empresto", true);
    $this->lSqlErro = false;
    $this->sErroMsg = '';
    $rsEmpResto     = $oEmpResto->sql_record($oEmpResto->sql_query_empenho($this->anousu, $this->numemp));
    if ($oEmpResto->numrows == 0) {

      $this->lSqlErro = true;
      $this->sErroMsg = "Erro [15] - Empenho não cadastrado com restos a pagar em {$this->anousu}!";
      return false;

    } else {

      if ($iTipo == 2) { 

        $rsNotas              = $this->getNotas($this->numemp,"e50_anousu < {$this->anousu}");  
        $nValorProcessado     = 0;
        $nValorProcessadoNota = 0;
        $aNotasProcessadas    = array();
        if ($this->iNumRowsNotas > 0) {

          for ( $iInd = 0; $iInd < $this->iNumRowsNotas; $iInd++ ){

            $oEmpNota              = db_utils::fieldsMemory($rsNotas, $iInd,false, false, $this->getEncode());
            $nValorProcessadoNota  = $oEmpNota->e70_vlrliq - $oEmpNota->e53_vlrpag - $oEmpNota->e70_vlranu;
            $nValorProcessado     += $nValorProcessadoNota;
            $aNotasProcessadas[]   = $oEmpNota;

          }
          if (!$this->lSqlErro){

            $this->dadosEmpenho->aNotasRP         = $aNotasProcessadas;   
            $this->dadosEmpenho->nValorProcessado = $nValorProcessado;
            return true;

          }  
        } else {

          $this->lSqlErro = true;
          $this->sErroMsg = "Erro [16] - Empenho nao possui liquidações";
          return false;         

        }
      } else if ( $iTipo == 1 ) {  

        $sWhereNotas             = "e69_anousu < {$this->anousu} and (e70_vlrliq is null or e70_vlrliq = 0)";         
        $rsNotas                 = $this->getNotas($this->numemp,$sWhereNotas);  
        $nValorNaoProcessado     = $this->dadosEmpenho->e60_vlremp - $this->dadosEmpenho->e60_vlrliq - $this->dadosEmpenho->e60_vlranu;
        $nValorNaoProcessadoNota = 0;
        $aNotasNaoProcessadas    = array();
        $aItensNota              = array();
        if ($this->iNumRowsNotas > 0) {

          for ( $iInd = 0; $iInd < $this->iNumRowsNotas; $iInd++ ){

            $oEmpNota                 = db_utils::fieldsMemory($rsNotas, $iInd,false, false, $this->getEncode());
            $aItensNota               = $this->getItensNota($oEmpNota->e69_codnota);
            $aNotasNaoProcessadas[]   = $oEmpNota;

          }
          if (!$this->lSqlErro){
            $this->dadosEmpenho->aNotasRP = $aNotasNaoProcessadas;
          }  
        }
        $this->dadosEmpenho->nValorProcessado = $nValorNaoProcessado;
        $rsItens = $this->getItensSaldo();
        $aItens = array();
        //print_r($aItensNota);
        if ($rsItens) {
          
          for ($iInd  = 0; $iInd < $this->iNumRowsItens; $iInd++) {
            
            $oEmpItem = db_utils::fieldsMemory($rsItens, $iInd,false, false,$this->getEncode());
            for ($iItens = 0; $iItens < count($aItensNota); $iItens++) {
              
              if ($oEmpItem->e62_sequencial == $aItensNota[$iItens]->e72_empempitem){
                
                $oEmpItem->saldo      -= $aItensNota[$iItens]->e72_qtd;
                $oEmpItem->saldovalor -= $aItensNota[$iItens]->e72_valor;
                
              }
            }
            $oEmpItem->saldo      = $oEmpItem->saldo < 0?0:$oEmpItem->saldo; 
            $oEmpItem->saldovalor = $oEmpItem->saldovalor < 0?0:$oEmpItem->saldovalor;
            $aItens[] =  $oEmpItem;
          }  
        }
        $this->dadosEmpenho->aItens = $aItens;
        return true;         
      }
    }  
  }

  function estornarRP($iTipo, $aNotas = null, $nValorEstornado, $sMotivo='',
                      $aItens = null, $iTipoAnulacao = null) {

    if (!db_utils::inTransaction()){
      throw new exception("Não foi possível iniciar Procedimento.Nao foi possível achar uma transacao valida");
    }
    $nValorLiquidado = 0;
    $nValorAnulado   = 0;
    $iQtdeItens      = 0; 
    $this->getDados($this->numemp);    
    $oEmpResto      = $this->usarDao("empresto", true);
    $this->lSqlErro = false;
    $rsEmpResto     = $oEmpResto->sql_record($oEmpResto->sql_query_empenho($this->anousu, $this->numemp));
    if (is_array($aItens)){
       $iQtdeItens = count($aItens) ;
    }
    if ($oEmpResto->numrows == 0) {

      $this->lSqlErro = true;
      $this->sErroMsg = "Erro [15] - Empenho não cadastrado com restos a pagar em {$this->anousu}!";
      throw new exception($this->sErroMsg);
      return false;

    } else {

      /*
       * estorna Liquidacao RP Processado;
       */
      if ($iTipo == 2) { 

        /*
         * Para Anular um RP Processado, é necessário ter ao menos 
         * uma nota selecionado pelo usuario
         */
        if (is_array($aNotas) && count($aNotas) == 0) {

          $this->lSqlErro = true;
          $this->sErroMsg = "[Erro 19] - Deve existir uma nota para ser extornada";
          throw new exception($this->sErroMsg);
          return false;
        } 

        /*
         * Verificamos se o empenho possui saldo para anular;
         * saldo solicitado deve ser menor que o saldo do empenho 
         */

        $iCodDoc         = 31;
        $nSaldoAEstornar = $this->dadosEmpenho->e60_vlrliq -$this->dadosEmpenho->e60_vlrpag - $this->dadosEmpenho->e60_vlranu ;
        if ($nSaldoAEstornar < $nValorEstornado){

          $this->lSqlErro = true;
          $this->sErroMsg = "Erro [17] - Sem saldo a estornar";
          throw new exception($this->sErroMsg);
          return false;

        } 

      }else if ($iTipo == 1){
        $iCodDoc = 32;
      } 

      /*
       * Fazemos as verificações de saldo da funcao fc_lancamento.
       */ 

      $sqlFcLancamento    = "select fc_verifica_lancamento({$this->numemp},'";
      $sqlFcLancamento   .=  date("Y-m-d",db_getsession("DB_datausu"))."',";
      $sqlFcLancamento   .= "{$iCodDoc},{$nValorEstornado})";
      $rsFcLancamento     = pg_query($sqlFcLancamento);
      $sErroFclancamento  = pg_result($rsFcLancamento,0,0);
      if (substr($sErroFclancamento,0,2) > 0 ){

        $this->sErroMsg = substr($sErroFclancamento,3);
        $this->lSqlErro = true;   
        throw new exception($this->sErroMsg);    

      }

      /*
       * -- empenho de RP processado, devemos diminuir o valor estornado da liquidação, 
       * e lancar como anulado (empempenho e empelemento)
       * -- Empenho RP nao processado apenas lancamos o valor anulado;
       */
      if (!$this->lSqlErro) {

        if ($iTipo == 2) {  

          $nValorLiquidado = $this->dadosEmpenho->e60_vlrliq - $nValorEstornado; 
          $nValorAnulado   = $nValorEstornado;               

        } else if ($iTipo == 1) {

          $nValorLiquidado = $this->dadosEmpenho->e60_vlrliq; 
          $nValorAnulado   = $nValorEstornado;  
        }
        /*
         * Atualizamos a empempenho e empelemento;
         */

        $this->clempempenho->e60_numemp = $this->numemp;
        $this->clempempenho->e60_vlrliq = "$nValorLiquidado";
        $this->clempempenho->e60_vlranu = $nValorAnulado + $this->dadosEmpenho->e60_vlranu;
        $this->clempempenho->alterar($this->numemp);
        if ($this->clempempenho->erro_status == 0) {

          $this->lSqlErro = true;
          $this->sErroMsg = "Erro [18] - Erro ao atualizar valores do empenho.";
          throw new exception($this->sErroMsg);
        }

        if (!$this->lSqlErro) {

          $rsEmpEle  = $this->clempelemento->sql_record($this->clempelemento->sql_query($this->numemp)); 
          if ($this->clempelemento->numrows == 0) {

            $this->lSqlErro = false;
            $this->sErroMsg = "Erro [20] Empenho sem elemento cadastrado";
            throw new exception($this->sErroMsg);
            return false;

          } 

          $oElemento = db_utils::fieldsMemory($rsEmpEle, 0);                                                                             
          $this->clempelemento->e64_numemp = $this->numemp;
          $this->clempelemento->e64_codele = $oElemento->e64_codele;
          $this->clempelemento->e64_vlrliq = "$nValorLiquidado";  
          $this->clempelemento->e64_vlranu = $nValorAnulado+$oElemento->e64_vlranu;
          $this->clempelemento->alterar($this->numemp);     

          if ($this->clempelemento->erro_status == 0) {

            $this->lSqlErro  = true;
            $this->sErroMsg  = "Erro [19] - Erro ao atualizar valores do elemento do empenho.";
            $this->sErroMsg .= "\n[Técnico] -{$this->clempelemento->erro_msg}";
            throw new exception($this->sErroMsg);

          }  
        }  
      }
      /*
       * Atualizamos empnota e empnotaele, caso existam notas para essa anulação.
       */
      if (!$this->lSqlErro){

        if (count($aNotas) > 0){

          $oEmpNota      = $this->usarDao("empnota",true);
          $oEmpNotaEle   = $this->usarDao("empnotaele",true);
          $oEmpNotaItem  = $this->usarDao("empnotaitem", true);
          for ($iNotas = 0; $iNotas < count($aNotas); $iNotas++){

            //verificamos se a nota possui entradas no almox;
            $this->verificaNotaEstoque($aNotas[$iNotas]->iCodNota);
            $oEmpNotaEle->e70_vlranu  = $aNotas[$iNotas]->sValorEstornado;    
            $oEmpNotaEle->e70_codnota = $aNotas[$iNotas]->iCodNota;
            $oEmpNotaEle->alterar($aNotas[$iNotas]->iCodNota);
            if ($oEmpNotaEle->erro_status == 0){

              $this->sErroMsg  = "Erro[20]  Não foi possivel Alterar nota\n";
              $this->sErroMsg .= "[Técnico] {$oEmpnotaEle->erro_msg}";
              throw new exception($this->sErroMsg);
              return false;

            } else {
              //Anulamos os itens da nota
              $rsItens       = $oEmpNotaItem->sql_record(
                  $oEmpNotaItem->sql_query_file(null,
                    "e72_sequencial,e72_valor,e72_empempitem,e72_qtd",
                    null,
                    "e72_codnota = {$aNotas[$iNotas]->iCodNota}"
                    )
                  );
              $iNumRowsItens = $oEmpNotaItem->numrows;
              for ($iItens = 0; $iItens < $iNumRowsItens; $iItens++){

                $oItens                       = db_utils::fieldsMemory($rsItens, $iItens);
                $oEmpNotaItem->e72_vlranu     = $oItens->e72_valor;
                $oEmpNotaItem->e72_sequencial = $oItens->e72_sequencial;
                $oEmpNotaItem->alterar($oItens->e72_sequencial);  
                $iIndice  = $iQtdeItens;
                $aItens[$iIndice]->iCodItem  = $oItens->e72_empempitem;              
                $aItens[$iIndice]->nVlrTotal = $oItens->e72_valor;
                $aItens[$iIndice]->nQtde     = $oItens->e72_qtd;
                $iQtdeItens++;
                if ($oEmpNotaItem->erro_status == 0 ) {

                  $this->sErroMsg  = "Erro[21]  Não foi possível alterar nota.";
                  $this->sErroMsg .= "[Técnico] {$oEmpNotaItem->erro_msg}.";
                  throw new exception($this->sErroMsg);
                  return false;
                }  
              }    
            }
            if ($iTipo == 2) {

              $oPagOrdemNota = $this->usarDao("pagordemnota", true);
              $oPagOrdemEle  = $this->usarDao("pagordemele", true);
              $res = $oPagOrdemNota->sql_record($oPagOrdemNota->sql_query_file(null, $aNotas[$iNotas]->iCodNota));
              if ($oPagOrdemNota->numrows > 0) {

                $oPagOrdem    = db_utils::fieldsmemory($res, 0);
                $oPagOrdemEle->e53_codord = $oPagOrdem->e71_codord;
                $oPagOrdemEle->e53_codele = $oElemento->e64_codele;
                $oPagOrdemEle->e53_vlranu = "{$aNotas[$iNotas]->sValorEstornado}";
                $oPagOrdemEle->alterar($oPagOrdemEle->e53_codord, $oElemento->e64_codele);
                if ($oPagOrdemEle->erro_status == 0) {
                  
                  $this->lSqlErro = true;
                  $this->sErroMsg = "Pagordemele:".$oPagOrdemEle->erro_msg;
                  throw new exception($this->sErroMsg);
                }
                $oPagOrdemNota->e71_codord  = $oPagOrdemEle->e53_codord;
                $oPagOrdemNota->e71_codnota = $aNotas[$iNotas]->iCodNota;
                $oPagOrdemNota->e71_anulado = 'true';
                $oPagOrdemNota->alterar($oPagOrdemNota->e71_codord, $oPagOrdemNota->e71_codnota);
                if ($oPagOrdemNota->erro_status == 0) {
                  
                  $this->lSqlErro = true;
                  $this->sErroMsg = "Pagordemnota:".$clpagordenota->erro_msg;
                  throw new exception($this->sErroMsg);
                  return false;
                }
              }    
            }  
          }
        }

        /*
         *incluimos Empanulado e (empanuladoitem (somente RP nao proc));
         */
        $oEmpAnulado = $this->usarDao("empanulado", true);
        $oEmpAnulado->e94_numemp         = $this->numemp;
        $oEmpAnulado->e94_valor          = $nValorEstornado;
        $oEmpAnulado->e94_saldoant       = $nValorEstornado; // carlos atualizado
        $oEmpAnulado->e94_motivo         = $sMotivo;
        $oEmpAnulado->e94_empanuladotipo = $iTipoAnulacao;
        $oEmpAnulado->e94_data           = date("Y-m-d", db_getsession("DB_datausu"));
        $oEmpAnulado->incluir(null);
        $iCodAnu                    = $oEmpAnulado->e94_codanu;
        if ($oEmpAnulado->erro_status == 0) {

          $this->lSqlErro  = true;
          $this->sErroMsg  = "Erro[22]\nNão Foi possível estornar RP.Erro ao cadastrar Empenho como anulado."; 
          $this->sErroMsg .= "\nErro:{$oEmpAnulado->erro_msg}";
          throw new exception($this->sErroMsg);
          return false;
        }
        /*
         * Incluimos os itens anulados;
         */
        if (is_array($aItens) && count($aItens) > 0) {

          $oEmpAnuladoItem = $this->usarDao("empanuladoitem", true);
          for ($iInd = 0; $iInd < count($aItens); $iInd++) {                

            $oEmpAnuladoItem->e37_empempitem = $aItens[$iInd]->iCodItem;
            $oEmpAnuladoItem->e37_empanulado = $iCodAnu;
            $oEmpAnuladoItem->e37_vlranu     = $aItens[$iInd]->nVlrTotal;
            $oEmpAnuladoItem->e37_qtd        = $aItens[$iInd]->nQtde;  
            $oEmpAnuladoItem->incluir(null);
            if ($oEmpAnuladoItem->erro_status == 0) {

              $this->lSqlErro  = true;
              $this->sErroMsg  = "Erro[24]\nNão Foi possível estornar RP.Erro incluir item como anulado."; 
              $this->sErroMsg .= "\nErro:{$oEmpAnuladoItem->erro_msg}";
              throw new exception($this->sErroMsg);
              return false;    
            }
          }
        }  
        /*
         * informações do elemento anulado
         */
        $oEmpAnuladoEle             = $this->usarDao("empanuladoele", true);
        $oEmpAnuladoEle->e95_codanu = $iCodAnu;
        $oEmpAnuladoEle->e95_codele = $oElemento->e64_codele;
        $oEmpAnuladoEle->e95_valor  = $nValorEstornado;
        $oEmpAnuladoEle->incluir($iCodAnu);
        if ($oEmpAnuladoEle->erro_status == 0) {

          $lSqlErro = true;
          $this->sErroMsg  = "Erro[25]\nNão Foi possível anular empenho.Erro ao incluir elemento anulado."; 
          $this->sErroMsg .= "\nErro:{$oEmpAnuladoEle->erro_msg}";
          throw new exception($this->sErroMsg);
          return false;

        }
        /*
         * Lançamentos contabeis
         */
        $oLancam = new LancamentoContabil($iCodDoc, 
            $this->anousu,
            date("Y-m-d",db_getsession("DB_datausu")),
            $nValorEstornado
            );
        $oLancam->setCgm($this->dadosEmpenho->e60_numcgm); 
        $oLancam->setEmpenho($this->numemp, $this->dadosEmpenho->e60_anousu, $this->dadosEmpenho->e60_codcom);  
        $oLancam->setElemento($oElemento->e64_codele);
        $oLancam->setComplemento($sMotivo);
        $oLancam->salvar();    
      }
    }
  }

  /**
   * Carrega a classe $sClasse 
   * @param string $sClasse nome da tabela
   * @param boolean $rInstance se deve retornar a instancia da classe
   * @returns Object
   */

  function usarDao($sClasse, $rInstance = false){

    if (!class_exists("cl_{$sClasse}")){
      require_once "classes/db_{$sClasse}_classe.php";     
    }
    if ($rInstance){

      eval ("\$objRet = new cl_{$sClasse};");
      return $objRet;

    }
  }

  function verificaNotaEstoque($iCodNota, $lRetorno = false) {

    $objNota    = db_utils::fieldsMemory($this->getNotas($this->numemp,"e69_codnota = ".$iCodNota),0);
    //verificamos o tipo da ordem , se for virtual devemos anular a ordem de compra e seus itens.
    $sSQLOrdem  = "select m51_tipo,";
    $sSQLOrdem .= "       m73_codmatestoqueitem,";
    $sSQLOrdem .= "       m52_codlanc,";
    $sSQLOrdem .= "       m72_codordem,";
    $sSQLOrdem .= "       m52_valor,";
    $sSQLOrdem .= "       m53_data,";    
    $sSQLOrdem .= "       m52_quant";
    $sSQLOrdem .= "  from matordem ";
    $sSQLOrdem .= "        inner join empnotaord   on m72_codordem    = m51_codordem";
    $sSQLOrdem .= "        inner join matordemitem on m51_codordem    = m52_codordem ";
    $sSQLOrdem .= "        left  join matestoqueitemoc on m52_codlanc = m73_codmatordemitem";
    $sSQLOrdem .= "        left  join matordemanu   on m53_codordem    = m51_codordem";
    $sSQLOrdem .= " where m72_codnota = {$iCodNota}";
    $sSQLOrdem .= "   and m53_codordem is null";    
    $rOrdem    = pg_query($sSQLOrdem);
    if (pg_num_rows($rOrdem) > 0){

      if (!class_exists("cl_matordemanu")){
        require_once "classes/db_matordemanu_classe.php"; 
      }
      if (!class_exists("cl_matordemitemanu")){
        require_once "classes/db_matordemitemanu_classe.php"; 
      }
      if (!class_exists("cl_matordemanul")){
        require_once "classes/db_matordemanul_classe.php"; 
      }
      $clmatordemanu     = new cl_matordemanu();
      $clmatordemanul    = new cl_matordemanul();
      $clmatordemitemanu = new cl_matordemitemanu();
      /*
         vamos verificar se essa nota possui algum item em estoque.
         se possui, nao podemos deixar extornar a liquidacao
       */  
      for ($j = 0; $j < pg_num_rows($rOrdem);$j++) {

        $oMatordemItem = db_utils::fieldsMemory($rOrdem,$j); 
        if ($oMatordemItem->m73_codmatestoqueitem != null and $oMatordemItem->m51_tipo == 2) {

          $this->lSqlErro  = true;
          $this->sMsgErro  = "Nota ({$objNota->e69_numero}) possui Itens com entrada no estoque.";
          $this->sMsgErro .= "\nNão podera ser estornada (anulada) a liquidação.";
          throw new exception($this->sMsgErro);

        } else if ($oMatordemItem->m51_tipo == 1) {

          /*
           * Como estamos tratando de RP, devemos antes de anular o empenho,  
           * solicitar ao usuário anular entradas no estoque, e ordens de compra 
           * da nota selecionada
           */
          if ($oMatordemItem->m73_codmatestoqueitem != null) {

            $this->sMsgErro  = "Nota ({$objNota->e69_numero}) possui Itens com entrada no estoque.";
            $this->sMsgErro .= "\nNão podera ser estornada (anulada) a liquidação.";  

          }else {

            $this->sMsgErro  = "[Erro 26]:\nNota ({$objNota->e69_numero}) possui a Ordem de Compra ";
            $this->sMsgErro .= "{$oMatordemItem->m72_codordem} em Aberto.";
            $this->sMsgErro .= "\nPara prosseguir, anule a ordem de compra.";
            $this->sMsgErro .= "\nNão podera ser estornada (anulada) a liquidação.";

          }  
          $this->lSqlErro  = true;

          throw new exception($this->sMsgErro);

        }
        if (!$this->lSqlErro and $oMatordemItem->m51_tipo == 2){

          $clmatordemanul->m37_hora    = db_hora();
          $clmatordemanul->m37_data    = date("Y-m-d",db_getsession("DB_datausu"));
          $clmatordemanul->m37_usuario = db_getsession("DB_id_usuario");
          $clmatordemanul->m37_motivo  = "Cancelamento por anulação de liquidação";
          $clmatordemanul->m37_empanul = "0";
          $clmatordemanul->m37_tipo    = 1;//anulacao parcial;
          $clmatordemanul->incluir(null);
          if ($clmatordemanul->erro_status == 0){

            $this->lSqlErro  = true;
            $this->sMsgErro  = "Erro (3) anulacao do item nao incluso.";
            $this->sMsgErro .= "\n{$clmatordemanul->erro_msg}";
            throw new exception($this->sMsgErro);
          }
        }
        if (!$this->lSqlErro and $oMatordemItem->m51_tipo == 2){

          $clmatordemitemanu->m36_matordemitem = $oMatordemItem->m52_codlanc;
          $clmatordemitemanu->m36_matordemanul = $clmatordemanul->m37_sequencial;
          $clmatordemitemanu->m36_vrlanu       = $oMatordemItem->m52_valor;
          $clmatordemitemanu->m36_qtd          = $oMatordemItem->m52_quant;
          $clmatordemitemanu->m36_vrlanu       = $oMatordemItem->m52_valor;
          $clmatordemitemanu->incluir(null);
          if ($clmatordemitemanu->erro_status == 0){

            $this->lSqlErro  = true;
            $this->sMsgErro  = "Erro (3) anulacao do item nao incluso.";
            $this->sMsgErro .= "\n{$clmatordemitemanu->erro_msg}";
            throw new exception($this->sMsgErro);
          }
        }

      }
    }
    return true;
  }
  
  /**
   * Retorna a informação da ordem agendada.
   *
   * @param integer $iCodNota Código da nota 
   * @return string
   */
  function getInfoAgenda($iCodNota) {
   
    $clpagordemnota = db_utils::getDao("pagordemnota");
    $res = $clpagordemnota->sql_record($clpagordemnota->sql_query(null, null
          ,"*",null,"e71_codnota = {$iCodNota} and e71_anulado is false"));
    if ($clpagordemnota->numrows > 0) {          
          
      $oNota           = db_utils::fieldsMemory($res, 0);
      $sSqlAgenda      = "select e80_codage,";
      $sSqlAgenda     .= "       to_char(e80_data,'dd/mm/YYYY') as e80_data"; 
      $sSqlAgenda     .= "  from empord ";
      $sSqlAgenda     .= "        inner join empagemov on e82_codmov = e81_codmov";
      $sSqlAgenda     .= "        inner join empage    on e81_codage = e80_codage"; 
      $sSqlAgenda     .= "  where e82_codord = {$oNota->e71_codord}";
      $sSqlAgenda     .= "    and e81_cancelado is null";
      $rsAgenda      = $clpagordemnota->sql_record($sSqlAgenda);
      if ($clpagordemnota->numrows > 0) {
      
        $sVir        = "";
        $sMsgAgenda = "";
        for ($i = 0; $i < $clpagordemnota->numrows; $i++) {
       
          $oAgenda      = db_utils::fieldsMemory($rsAgenda, $i);
          $sMsgAgenda .= "{$sVir} {$oAgenda->e80_codage} ({$oAgenda->e80_data})";  
          $sVir         = ","; 
             
        }
        return $sMsgAgenda;
      }            
    }
  }
  
  function getCodigoMovimento() {
    return $this->iCodigoMovimento;      
  }
}
