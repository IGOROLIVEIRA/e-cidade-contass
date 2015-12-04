<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class InicialDividaSituacaoPaga extends CorrecoesAbstract implements ICorrecoes {
  
  private $sMensagem    = "";
  private $lErro        = false;
  private $lModoTeste   = false;
  
  function __construct(){
    
  }  
  
  public function setModoTeste($lModoTeste) {
    $this->lModoTeste = $lModoTeste;
  }
  
  public function getModoTeste() {
  	return $this->lModoTeste;
  }  
  
  public function getCommit() {
    if ( $this->lErro == true ) {
      return true;
    } else {
      return $this->getModoTeste();
    } 
  }  
  
  public function run() {
    
    global $pConexao;
    $iOffSet = 0;
    $iLimit  = 300000;
    $this->initLog(basename(__FILE__));
    $this->log("Iniciando Processamento");
    if ($this->getModoTeste() == true) {
      $this->log("");
      $this->log(">>>>>> MODO DE TESTE. Rollback! <<<<<<");
      $this->log("");
    }
    $this->sMensagem = "Processamento dos registros das Inicials que estão em aberto com a situação como Paga [Log: $this->sNameFileLog]";    
    
    db_inicio_transacao($pConexao);

    $this->log("Verificando os casos de Inicial com o debito em aberto que estão com a situação como paga");
    while (true) {
      echo "Buscando registros ... \r";
      
      $sSql      = "select distinct 
                           v50_inicial,
                           v50_codmov
                      from inicial
                     inner join inicialmov  on inicialmov.v56_inicial  = inicial.v50_inicial
                     inner join inicialcert on inicialcert.v51_inicial = inicial.v50_inicial
                     inner join certdiv     on certdiv.v14_certid      = inicialcert.v51_certidao
                     inner join divida      on divida.v01_coddiv       = certdiv.v14_coddiv
                     inner join arrecad     on arrecad.k00_numpre      = divida.v01_numpre
                                           and arrecad.k00_numpar      = divida.v01_numpar
                     where inicialmov.v56_codsit = 8
                       and (select max(v56_codmov) 
                              from inicialmov 
                             where inicialmov.v56_inicial = inicial.v50_inicial) = inicial.v50_codmov
                    offset {$iOffSet} limit {$iLimit}";
      $rsResult  = db_query($pConexao, $sSql);
      $iNumRows  = pg_num_rows($rsResult);
  
      if ($iNumRows == 0) {
        break;
      }
      
      for ($x = 0; $x < $iNumRows; $x++) {
        $oDados  = db_utils::fieldsMemory($rsResult,$x);
        
        $this->processamento($x, $iNumRows);
        
        /*
         * Verificamos os movimentos anteriores da inicial
         * Caso seja encontrado outro movimento que não seja de pagamento, alteramos o movimento e a situação da inicial para este movimento 
         * Do contrário, alteramos o movimento e a situação da inicial para Inicial Emitida.
         */
        $sSqlInicialMov = "select * 
                             from inicialmov 
                            where inicialmov.v56_inicial =  $oDados->v50_inicial
                              and inicialmov.v56_codmov  <> $oDados->v50_codmov
                              and inicialmov.v56_codsit  <> 8 
                            order by v56_data desc";
        $rsInicialMov   = db_query($pConexao,$sSqlInicialMov);
        if (pg_num_rows($rsInicialMov) > 0) {
          $iMovimento = db_utils::fieldsMemory($rsInicialMov, 0)->v56_codmov;
          
          $sSqlUpdate = " update inicial
                             set v50_codmov  = {$iMovimento}
                           where v50_inicial = {$oDados->v50_inicial}";
          $rsUpdate = db_query($pConexao, $sSqlUpdate);
          if ($rsUpdate) {
            $this->log("Processando {$x} de {$iNumRows} - Inicial {$oDados->v50_inicial} alterada para o movimento {$iMovimento}");
          } else {
            $this->lErro = true;
            $this->log("Processando {$x} de {$iNumRows} - Erro ao alterar movimento da inicial {$oDados->v50_inicial} para {$iMovimento}. Erro: ".pg_last_error());
          } 

          $sSqlDelete = "delete from inicialmov where v56_codmov = {$oDados->v50_codmov}";
          $rsDelete   = db_query($pConexao,$sSqlDelete);
          if ($rsDelete) {
          	$this->log("Processando {$x} de {$iNumRows} - Movimento {$oDados->v50_codmov} da Inicial {$oDados->v50_inicial} excluído");
          } else {
          	$this->lErro = true;
          	$this->log("Processando {$x} de {$iNumRows} - Erro ao excluir movimento {$oDados->v50_codmov} da inicial {$oDados->v50_inicial}. Erro: ".pg_last_error());
          }
                  	
        } else {
        	
          $sSqlUpdate = "update inicialmov 
                            set v56_codsit = 1, 
                                v56_obs    = '' 
                          where v56_codmov = {$oDados->v50_codmov}";
          $rsUpdate = db_query($pConexao, $sSqlUpdate);
          if ($rsUpdate) {
          	$this->log("Processando {$x} de {$iNumRows} - Alterada a situação do movimento da Inicial {$oDados->v50_inicial} para 1 - Inicial Emitida");
          } else {
          	$this->lErro = true;
          	$this->log("Processando {$x} de {$iNumRows} - Erro ao alterar situação do movimento da inicial {$oDados->v50_inicial} para 1 - Inicial Emitida. Erro: ".pg_last_error());
          }
          	
        } 
        
      }
      
      $iOffSet += $iLimit;
      unset($rsResult);
      
    }
    $this->log("");
    $this->log("Fim do processamento");
    $this->log("");

    db_fim_transacao($pConexao,$this->getCommit());
    if ($this->getModoTeste() == true) {
      db_query($pConexao, "rollback;");
      $this->log("");
      $this->log(">>>>>> MODO DE TESTE. Rollback! <<<<<<");
      $this->log("");
    }

    if ($this->hasError()) {
    	$this->sMensagem = "Ocorreram erros durante o processamento do script. Verificar o Log: [{$this->sNameFileLog}]";
    }
    
  }

  public function hasError() {
    return $this->lErro;
  }

  public function getMessage(){
    return $this->sMensagem;  
  }

}
?>