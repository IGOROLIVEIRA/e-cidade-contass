<?php

require_once "classes/TestesEstruturaBasica.php";
require_once "classes/ITestes.interface.php";

class MaterialSaldoNegativo extends TestesAbstract implements ITestes {
  
  private $sMensagem = "";
  private $lErro     = false;
  
  function __construct(){
  }  
  
  public function run() {
    
    global $pConexao;
    $sSqlItens = "select  m60_codmater, ";
    $sSqlItens .= "       m60_descr,    ";
    $sSqlItens .= "       m70_coddepto, ";
    $sSqlItens .= "       m70_codigo    ";
    $sSqlItens .= " from  matestoque    ";
    $sSqlItens .= "       inner join matmater on m70_codmatmater = m60_codmater";
    $sSqlItens .= " order by m60_codmater";
    $rsItens   = pg_query($sSqlItens);
    $this->sMensagem = "Sem itens com valores negativos";
    $this->initLog("material/".basename(__FILE__));
    $this->log("Pesquisando itens com dados Negativos");
    if ($rsItens) {
      
      if (pg_num_rows($rsItens) > 0) {

        $iTotalLinhas = pg_num_rows($rsItens);
        $this->log("Total de itens: {$iTotalLinhas}");
        $aItensComErro = array();
        for ($i = 0; $i < $iTotalLinhas; $i++) {
          
          $oItem = db_utils::fieldsMemory($rsItens, $i);
          $sSqlTotalEstoqueItem  = "select case when m81_tipo = 1 then m82_quant ";
          $sSqlTotalEstoqueItem .= "            when m81_tipo = 2 then m82_quant*-1 end as quantidade,   ";
          $sSqlTotalEstoqueItem .= "       m80_codigo   as codigomovimentacao,   ";
          $sSqlTotalEstoqueItem .= "       m80_data     as datamovimentacao,   ";
          $sSqlTotalEstoqueItem .= "       m80_hora     as horamovimentacao,   ";
          $sSqlTotalEstoqueItem .= "       m80_codtipo  as tipomovimentacao,   ";
          $sSqlTotalEstoqueItem .= "       m80_coddepto  as deptomovimentacao,   ";
          $sSqlTotalEstoqueItem .= "       m71_codlanc,   ";
          $sSqlTotalEstoqueItem .= "       m70_codigo  ";
          $sSqlTotalEstoqueItem .= "  from matestoqueinimei ";
          $sSqlTotalEstoqueItem .= "       inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem";
          $sSqlTotalEstoqueItem .= "       inner join matestoque     on m71_codmatestoque = m70_codigo ";
          $sSqlTotalEstoqueItem .= "       inner join matestoqueini  on m80_codigo        = m82_matestoqueini ";
          $sSqlTotalEstoqueItem .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
          $sSqlTotalEstoqueItem .= " where m70_codigo = {$oItem->m70_codigo} ";
          $sSqlTotalEstoqueItem .= " order by to_timestamp(m80_data || ' ' || m80_hora, 'YYYY-MM-DD HH24:MI:SS'), m80_codigo";
          $nQuantidadeEstoque   = 0;
          $rsTotalItemEstoque   = pg_query($sSqlTotalEstoqueItem);
          $iTotalMovimentacao   = pg_num_rows($rsTotalItemEstoque);
          for ($iMov = 0; $iMov < $iTotalMovimentacao; $iMov++) {
             
            $this->processamento($iMov, $iTotalMovimentacao);
            $oMovimentacao = db_utils::fieldsMemory($rsTotalItemEstoque, $iMov);
            $nQuantidadeEstoque += $oMovimentacao->quantidade;
            if ($nQuantidadeEstoque < 0) {
              
              $this->lErro  = true;
              $sErroString  = "[Erro]: Item:{$oItem->m60_codmater} - {$oItem->m60_descr} Data:{$oMovimentacao->datamovimentacao} $oMovimentacao->horamovimentacao  ";
              $sErroString .= "Quantidade:".abs($oMovimentacao->quantidade)." Tipo: {$oMovimentacao->tipomovimentacao}  ";
              $sErroString .= "Estoque: {$oItem->m70_coddepto} Quantidade Negativa: {$nQuantidadeEstoque}";
              $this->log($sErroString);
              $aItensComErro[$oItem->m60_codmater] = $oItem->m60_descr;
            }
            unset($oMovimentacao);
          }
        }
        
        echo "Total Itens Negativos: {".count($aItensComErro)."}\n";
      } else {
        $this->log("Sem itens no estoque");
      }
    } else {
      $this->log("Erro na Query");
    }
    if ($this->hasError()) {
      $this->sMensagem = "Encontrados Item com estoque negativo. [Log: $this->sNameFileLog]";
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