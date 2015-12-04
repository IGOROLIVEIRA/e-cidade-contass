<?php

require_once "classes/TestesEstruturaBasica.php";
require_once "classes/ITestes.interface.php";

class SaldoEstoqueDiferenteMovimentacao extends TestesAbstract implements ITestes {
  
  private $sMensagem = "";
  private $lErro     = false;
  
  function __construct(){
  }  
  
  public function run() {
    
    global $pConexao;
    $sSqlItens = "select  m60_codmater, ";
    $sSqlItens .= "       m60_descr,    ";
    $sSqlItens .= "       m71_quant - m71_quantatend as m70_quant,    ";
    $sSqlItens .= "       m70_coddepto,    ";
    $sSqlItens .= "       m70_codigo,   ";
    $sSqlItens .= "       m71_codlanc   ";
    $sSqlItens .= " from  matestoque  ";
    $sSqlItens .= "       inner join matmater       on m70_codmatmater   = m60_codmater";
    $sSqlItens .= "       inner join matestoqueitem on m71_codmatestoque = m70_codigo ";
    //$sSqlItens .= "  where m70_codmatmater   in(11754)";
    $sSqlItens .= " order by m60_codmater";
    $rsItens   = pg_query($sSqlItens);
    $this->sMensagem = "Sem itens com valores negativos";
    $this->initLog("material/".basename(__FILE__));
    $this->log("Pesquisando itens com dados difrentes entre estoque e movimentação");
    if ($rsItens) {
      
      if (pg_num_rows($rsItens) > 0) {

        $iTotalLinhas           = pg_num_rows($rsItens);
        $aItensComErro          = array();
        for ($iItens = 0; $iItens < $iTotalLinhas; $iItens++) {

          $this->processamento($iItens, $iTotalLinhas);
          $oMovimentacao          = db_utils::fieldsMemory($rsItens, $iItens); 
          $sSqlTotalMovimentacao  = "select sum(coalesce((case when m81_tipo  = 1  then m82_quant end),0)) as entradas,"; 
          $sSqlTotalMovimentacao .= "       sum(coalesce((case when m81_tipo = 2 then m82_quant end),0)) as saidas"; 
          $sSqlTotalMovimentacao .= "  from matestoqueinimei "; 
          $sSqlTotalMovimentacao .= "       inner join matestoqueitem on m82_matestoqueitem = m71_codlanc  "; 
          $sSqlTotalMovimentacao .= "       inner join matestoque     on m71_codmatestoque  = m70_codigo   "; 
          $sSqlTotalMovimentacao .= "       inner join matestoqueini  on m82_matestoqueini  = m80_codigo   "; 
          $sSqlTotalMovimentacao .= "       inner join matestoquetipo on m80_codtipo        = m81_codtipo  "; 
          $sSqlTotalMovimentacao .= " where m71_codlanc = {$oMovimentacao->m71_codlanc}";
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
          $sSqlTotaisTransferencias .= " where m71_codlanc = {$oMovimentacao->m71_codlanc} ";
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
          $sSqlMovimentacoesSemInicio .= "   and m71_codlanc = {$oMovimentacao->m71_codlanc}";
          $rsMovimentacoesSemInicio    = db_query($pConexao, $sSqlMovimentacoesSemInicio);
          $oMovimentacaoSemInicio      = db_utils::fieldsMemory($rsMovimentacoesSemInicio, 0);
          for ($i = 0; $i < $iTotalLinhasMov; $i++) {
            
            $oQuantidades = db_utils::fieldsMemory($rsMovimentacao, $i);
            if (round($oQuantidades->entradas-($oQuantidades->saidas+$oDadosTransferencia->saida), 2) != 
                round($oMovimentacao->m70_quant, 2)) {
            //if (round($oQuantidades->entradas-($oQuantidades->saidas+$oDadosTransferencia->saida), 2) < 0) {
                
              $this->lErro = true;
              $sMensagem  = "Erro: Item {$oMovimentacao->m60_codmater} - {$oMovimentacao->m60_descr} possui inconsistencias"; 
              $sMensagem .= " no estoque {$oMovimentacao->m71_codlanc} - {$oMovimentacao->m70_coddepto} Quantidade de Itens estoque: {$oMovimentacao->m70_quant}"; 
              $sMensagem .= " Quantidade na Movimentacao: ".($oQuantidades->entradas-$oQuantidades->saidas)." ";
              $sMensagem .= " Quantidade em Transferencia: {$oDadosTransferencia->saida} ";
              $sMensagem .= " Quantidade entradas: {$oQuantidades->entradas} ";
              $sMensagem .= " Quantidade SAIDAS: {$oQuantidades->saidas} ";
              $sMensagem .= " Quantidade SM: {$oMovimentacaoSemInicio->quantidade} ";
              $this->log($sMensagem); 
            }
          }
        }
      } else {
        $this->log("Sem itens no estoque");
      }
    } else {
      $this->log("Erro na Query");
    }
    if ($this->hasError()) {
      $this->sMensagem = "Encontrados Itens/estoques com diferença entre estoque/movimentacao. [Log: $this->sNameFileLog]";
    }
    
    $this->log($this->sMensagem);
  }

  public function hasError() {
    return $this->lErro;
  }

  public function getMessage(){
    return $this->sMensagem;  
  }

}
?>