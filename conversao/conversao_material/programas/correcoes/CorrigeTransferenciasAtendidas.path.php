<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class CorrigeTransferenciasAtendidas extends CorrecoesAbstract implements ICorrecoes {
  
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
    
    $this->sMensagem = "Processamento de transferencias incompletas [Log: $this->sNameFileLog]";    
    $this->log("");
    $this->log("Fim do processamento");
    $this->log("");
    db_query($pConexao, "alter table matestoqueinimei disable trigger all");
    global $pConexao;
    $sSqlItens = "select  m60_codmater, ";
    $sSqlItens .= "       m60_descr,    ";
    $sSqlItens .= "       m70_quant,    ";
    $sSqlItens .= "       m70_coddepto,    ";
    $sSqlItens .= "       m70_codigo   ";
    $sSqlItens .= " from  matestoque  ";
    $sSqlItens .= "       inner join matmater on m70_codmatmater = m60_codmater";
    //$sSqlItens .= "  where m70_codmatmater   = 1";
    $sSqlItens .= " order by m60_codmater";
    $rsItens   = pg_query($sSqlItens);
    $this->sMensagem = "Itens com Movimentações sem tipo de estoque";
    $this->initLog("material/".basename(__FILE__));
    $this->log("Pesquisando itens com dados difrentes entre estoque e movimentação");
    if ($rsItens) {
      
      if (pg_num_rows($rsItens) > 0) {

        $iTotalLinhas           = pg_num_rows($rsItens);
        $aItensComErro          = array();
        for ($iItens = 0; $iItens < $iTotalLinhas; $iItens++) {

          $this->processamento($iItens, $iTotalLinhas);
          db_inicio_transacao($pConexao);
          $oMovimentacao               = db_utils::fieldsMemory($rsItens, $iItens); 
          $sSqlTransferencias          = "SELECT distinct m86_codigo, ";
          $sSqlTransferencias         .= "       a.*, ";
          $sSqlTransferencias         .= "       b.m80_codigo ";
          $sSqlTransferencias         .= "   from matestoqueini a ";
          $sSqlTransferencias         .= "        inner join matestoqueinil   on m86_matestoqueini  = a.m80_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueinill  on m87_matestoqueinil = m86_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueinimei on m82_matestoqueini  = m80_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueitem   on m82_matestoqueitem = m71_codlanc ";
          $sSqlTransferencias         .= "        left  join matestoqueini b  on m87_matestoqueini  = b.m80_codigo ";
          $sSqlTransferencias         .= " where a.m80_codtipo = 7 ";
          $sSqlTransferencias         .= "   and b.m80_codigo is null ";
          $sSqlTransferencias         .= "   and m71_codmatestoque = {$oMovimentacao->m70_codigo}";
          $sSqlTransferencias         .= "order by a.m80_data ";
          $rsTotalTransFerencias       = db_query($pConexao, $sSqlTransferencias);
          $iTotalLinhasTransferencias  = pg_num_rows($rsTotalTransFerencias);
          if ($iTotalLinhasTransferencias > 0) {
            
            for ($iTransferencia = 0; $iTransferencia < $iTotalLinhasTransferencias; $iTransferencia++) {
              
              $oDadosTransFerencia    = db_utils::fieldsMemory($rsTotalTransFerencias, $iTransferencia);
              $sDeleteMatestoqueNill  = "delete from matestoqueinill ";
              $sDeleteMatestoqueNill .= " where m87_matestoqueinil = {$oDadosTransFerencia->m86_codigo}";
              $rsDeleteMatestoquenill = db_query($pConexao, $sDeleteMatestoqueNill);
              if (!$rsDeleteMatestoquenill) {

                $this->lErro = true;
                $sLog = "Erro ao excluir movimentação da transferencia.".pg_last_error(); 
              }
              $sDeleteMatestoqueNil  = "delete from matestoqueinil ";      
              $sDeleteMatestoqueNil .= " where m86_codigo = {$oDadosTransFerencia->m86_codigo}";
              $rsDeleteMatestoquenil = db_query($pConexao, $sDeleteMatestoqueNil);      
              if (!$rsDeleteMatestoquenil) {

                $this->lErro = true;
                $sLog = "Erro ao excluir movimentação da transferencia.".pg_last_error(); 
              }
            }
          }
        }
        /**
         * verifica se o item ainda possui transferencias incomplentas
         */
        $rsTotalTransferencias       = db_query($pConexao, $sSqlTransferencias);
        $iTotalLinhasTransferencias  = pg_num_rows($rsTotalTransferencias);
        if ($iTotalLinhasTransferencias > 0) {
 
          $sMsgLog = "Item {$oMovimentacao->m60_codmater} ainda possui transferencias incompletas ($iTotalLinhasTransferencias)";
          $this->log($sMsgLog);
          $this->lErro = true;
        }
        $lFimTransacao    = $this->lErro?$this->lErro:$this->getModoTeste();
        db_fim_transacao($pConexao, $lFimTransacao);
      } else {
        $this->log("Sem itens no estoque");
      }
    }
   
    db_query($pConexao, "alter table matestoqueinimei enable trigger all");
    if ($this->getModoTeste() == true) {

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