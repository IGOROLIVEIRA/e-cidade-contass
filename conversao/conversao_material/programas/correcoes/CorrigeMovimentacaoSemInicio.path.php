<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class CorrigeMovimentacaoSemInicio extends CorrecoesAbstract implements ICorrecoes {
  
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
    
    $this->sMensagem = "Processamento de movimentações que nao possuem matestoqueini no estoque [Log: $this->sNameFileLog]";    
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

          db_inicio_transacao($pConexao);
          $this->processamento($iItens, $iTotalLinhas);
          $oMovimentacao          = db_utils::fieldsMemory($rsItens, $iItens); 
          $sSqlTotalMovimentacao  = "select sum(coalesce((case when m81_tipo  = 1  then m82_quant end),0)) as entradas,"; 
          $sSqlTotalMovimentacao .= "       sum(coalesce((case when m81_tipo  = 2 then m82_quant end),0)) as saidas"; 
          $sSqlTotalMovimentacao .= "  from matestoqueinimei "; 
          $sSqlTotalMovimentacao .= "       inner join matestoqueitem on m82_matestoqueitem = m71_codlanc  "; 
          $sSqlTotalMovimentacao .= "       inner join matestoque     on m71_codmatestoque  = m70_codigo   "; 
          $sSqlTotalMovimentacao .= "       inner join matestoqueini  on m82_matestoqueini  = m80_codigo   "; 
          $sSqlTotalMovimentacao .= "       inner join matestoquetipo on m80_codtipo        = m81_codtipo  "; 
          $sSqlTotalMovimentacao .= " where m70_codigo = {$oMovimentacao->m70_codigo}";
          $rsMovimentacao         = db_query($pConexao, $sSqlTotalMovimentacao);
          $iTotalLinhasMov        = pg_num_rows($rsMovimentacao); 
          /**
           * Calcular as transferencias que nao foram atendidas, e descontar.
           */
          $sSqlTotaisTransferencias  = "select sum(coalesce(case when m81_tipo = 4 then m82_quant end, 0)) as saida";
          $sSqlTotaisTransferencias .= "  from matestoqueinimei ";
          $sSqlTotaisTransferencias .= "       inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem";
          $sSqlTotaisTransferencias .= "       inner join matestoque     on m71_codmatestoque = m70_codigo ";
          $sSqlTotaisTransferencias .= "       inner join matestoqueini  on m80_codigo        = m82_matestoqueini ";
          $sSqlTotaisTransferencias .= "       left  join matestoqueinil on m80_codigo        = m86_matestoqueini ";
          $sSqlTotaisTransferencias .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
          $sSqlTotaisTransferencias .= " where m70_codigo  = {$oMovimentacao->m70_codigo} ";
          $sSqlTotaisTransferencias .= "   and m81_codtipo = 7";
          $sSqlTotaisTransferencias .= "   and m86_matestoqueini IS NULL";
          $rsTotaisTransferencias    =  db_query($pConexao, $sSqlTotaisTransferencias);
          $oDadosTransferencia       = db_utils::fieldsMemory($rsTotaisTransferencias, 0);
          
          $sSqlMovimentacoesSemInicio  = "SELECT coalesce(sum(m82_quant), 0) as quantidade";
          $sSqlMovimentacoesSemInicio .= "  from matestoqueinimei  ";
          $sSqlMovimentacoesSemInicio .= "       left join matestoqueini   on m80_codigo         = m82_matestoqueini ";
          $sSqlMovimentacoesSemInicio .= "       inner join matestoqueitem on m82_matestoqueitem = m71_codlanc ";
          $sSqlMovimentacoesSemInicio .= "       inner join matestoque     on m71_codmatestoque  = m70_codigo ";
          $sSqlMovimentacoesSemInicio .= " where m80_codigo is null ";
          $sSqlMovimentacoesSemInicio .= "   and m70_codigo = {$oMovimentacao->m70_codigo}";
          $rsTotalMovimentacoesSemInicio  = db_query($pConexao, $sSqlMovimentacoesSemInicio);
          $oMovimentacaoSemInicio         = db_utils::fieldsMemory($rsTotalMovimentacoesSemInicio, 0);
          if ($oMovimentacaoSemInicio->quantidade > 0) {

            $oQuantidades = db_utils::fieldsMemory($rsMovimentacao, 0);
            
            if (round($oQuantidades->entradas-($oQuantidades->saidas+$oDadosTransferencia->saida+
                                                 $oMovimentacaoSemInicio->quantidade), 2) == 
                  round($oMovimentacao->m70_quant, 2)) {
              $sSqlMovimentacoesSemInicio  = "SELECT m82_matestoqueitem, "; 
              $sSqlMovimentacoesSemInicio .= "       m82_matestoqueini ";
              $sSqlMovimentacoesSemInicio .= "  from matestoqueinimei  ";
              $sSqlMovimentacoesSemInicio .= "       left join matestoqueini   on m80_codigo         = m82_matestoqueini ";
              $sSqlMovimentacoesSemInicio .= "       inner join matestoqueitem on m82_matestoqueitem = m71_codlanc ";
              $sSqlMovimentacoesSemInicio .= "       inner join matestoque     on m71_codmatestoque  = m70_codigo ";
              $sSqlMovimentacoesSemInicio .= " where m80_codigo is null ";
              $sSqlMovimentacoesSemInicio .= "   and m70_codigo = {$oMovimentacao->m70_codigo}";
              
              $rsMovimentacoesSemInicio    = db_query($pConexao, $sSqlMovimentacoesSemInicio);
              $iTotalMovimentacoes         = pg_num_rows($rsMovimentacoesSemInicio);
              if ($iTotalMovimentacoes > 0) {
                
                for ($iMov = 0; $iMov < $iTotalMovimentacoes; $iMov++) {
                    
                  
                  $oMovimentacaoSemIni =  db_utils::fieldsMemory($rsMovimentacoesSemInicio, $iMov);
                  $sSqlVerificaInclusaoMatestoqueini  = "Select m80_codigo ";
                  $sSqlVerificaInclusaoMatestoqueini .= "  from matestoqueini ";
                  $sSqlVerificaInclusaoMatestoqueini .= " where m80_codigo = {$oMovimentacaoSemIni->m82_matestoqueini}";
                  $rsVerificaInclusaoMatestoqueini    = db_query($pConexao, $sSqlVerificaInclusaoMatestoqueini);
                  /**
                   * existe mais de uma matestoqueinimei para o mesmo matestoqueini.
                   * apenas incluimos na matestoqueini uma vez.
                   */
                   if (pg_num_rows($rsVerificaInclusaoMatestoqueini) > 0) {
                     continue;
                   }
                  /**
                   * pesquisamos qual o lancamento de Origem da Entrada
                   * o Movimenento sera migrado para a mesma data da entrada, mais 1 segundo, 
                   * e com o tipo saida manual (5).
                   */
                  $sSqlMovimentacaoEntrada  = "select matestoqueini.*,  ";    
                  $sSqlMovimentacaoEntrada .= "       to_char(to_timestamp(m80_data || ' ' ||m80_hora, 'YYYY-MM-DD HH24:MI:SS') +";
                  $sSqlMovimentacaoEntrada .= "       '".($iMov+1)." seconds'::interval, 'YYYY-mm-dd') as datasaida,";
                  $sSqlMovimentacaoEntrada .= "       to_char(to_timestamp(m80_data || ' ' ||m80_hora, 'YYYY-MM-DD HH24:MI:SS') +";
                  $sSqlMovimentacaoEntrada .= "       '".($iMov+1)." seconds'::interval, 'HH24:MI:SS') as horasaida";    
                  $sSqlMovimentacaoEntrada .= "  from matestoqueinimei ";    
                  $sSqlMovimentacaoEntrada .= "       inner join matestoqueini  on m82_matestoqueini = m80_codigo ";
                  $sSqlMovimentacaoEntrada .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
                  $sSqlMovimentacaoEntrada .= " where m82_matestoqueitem  = {$oMovimentacaoSemIni->m82_matestoqueitem} ";
                  $sSqlMovimentacaoEntrada .= "   and m81_tipo            = 1 ";
                  $rsMovimentacaoEntrada   = db_query($pConexao, $sSqlMovimentacaoEntrada);
                  $iTotalLinhasEntrada     = pg_num_rows($rsMovimentacaoEntrada);
                  if ($iTotalLinhasEntrada  > 0) {
                    
                    $oDadosEntrada  = db_utils::fieldsmemory($rsMovimentacaoEntrada, 0);
                    $sInsertIni     = "insert into matestoqueini";
                    $sInsertIni    .= " (m80_codigo,";
                    $sInsertIni    .= "  m80_codtipo,";
                    $sInsertIni    .= "  m80_obs,";
                    $sInsertIni    .= "  m80_login,";
                    $sInsertIni    .= "  m80_coddepto,";
                    $sInsertIni    .= "  m80_data,";
                    $sInsertIni    .= "  m80_hora";
                    $sInsertIni    .= " )";
                    $sInsertIni    .= " values ";
                    $sInsertIni    .= " ($oMovimentacaoSemIni->m82_matestoqueini,";
                    $sInsertIni    .= "  5,";
                    $sInsertIni    .= "  'Movimentacao migrada',";
                    $sInsertIni    .= "  {$oDadosEntrada->m80_login},";
                    $sInsertIni    .= "  {$oDadosEntrada->m80_coddepto},";
                    $sInsertIni    .= "  '{$oDadosEntrada->datasaida}',";
                    $sInsertIni    .= "  '{$oDadosEntrada->horasaida}'";
                    $sInsertIni    .= " )";
                    $rsInsertIni    = db_query($pConexao, $sInsertIni);
                    if (!$rsInsertIni) {
                         
                      $this->lErro = true;
                      $sMsgErro    = "Item {$oMovimentacao->m60_codmater} sem movimentacao de entrada para o movimento ";
                      $sMsgErro   .= "{$oMovimentacaoSemIni->m82_matestoqueitem}.".pg_last_error();
                    }
                    
                  } else {

                    $this->lErro  = true;
                    $sMsgErro     = "Item {$oMovimentacao->m60_codmater} sem movimentacao de entrada para o movimento ";
                    $sMsgErro    .= "{$oMovimentacaoSemIni->m82_matestoqueitem}.";
                    $this->log($sMsgErro); 
                  }
                }
              }
            }
          }
          /**
           * verificamos se apos a correçao o item ficou com alguma movimentação em branco
           */
          $sSqlMovimentacoesSemInicio  = "SELECT * ";
          $sSqlMovimentacoesSemInicio .= "  from matestoqueinimei  ";
          $sSqlMovimentacoesSemInicio .= "       left join matestoqueini   on m80_codigo         = m82_matestoqueini ";
          $sSqlMovimentacoesSemInicio .= "       inner join matestoqueitem on m82_matestoqueitem = m71_codlanc ";
          $sSqlMovimentacoesSemInicio .= "       inner join matestoque     on m71_codmatestoque  = m70_codigo ";
          $sSqlMovimentacoesSemInicio .= " where m80_codigo is null ";
          $sSqlMovimentacoesSemInicio .= "   and m70_codigo = {$oMovimentacao->m70_codigo}";
          $rsTotalMovimentacoesSemInicio  = db_query($pConexao, $sSqlMovimentacoesSemInicio);
          if (pg_num_rows($rsTotalMovimentacoesSemInicio) > 0) {
            
            $this->lErro  = true;
            $sMsgErro     = "Item {$oMovimentacao->m60_codmater} ainda possui movimentaçoes de saida sem matestoqueini. ";
            $this->log($sMsgErro); 
          }
        }
        
        $lFimTransacao    = $this->lErro?$this->lErro:$this->getModoTeste();
        //$lFimTransacao    = true;
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