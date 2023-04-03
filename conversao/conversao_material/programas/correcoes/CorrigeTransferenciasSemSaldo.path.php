<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class CorrigeTransferenciasSemSaldo extends CorrecoesAbstract implements ICorrecoes {
  
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
    $this->sMensagem = "Processamento das saidas do estoque antes de existir uma entrada [Log: $this->sNameFileLog]";    
    
    $aTiposCriamEntradas = array(1, 3, 12, 8, 15, 14);
    $this->log("");
    $this->log("Fim do processamento");
    $this->log("");
    db_query($pConexao, "alter table matestoqueinimei disable trigger all");
    global $pConexao;
    $sSqlItens = "select  m60_codmater,  ";
    $sSqlItens .= "       m60_descr,     ";
    $sSqlItens .= "       m70_coddepto,  ";
    $sSqlItens .= "       m70_codigo,    ";
    $sSqlItens .= "       m71_quant,     ";
    $sSqlItens .= "       m71_quantatend, ";
    $sSqlItens .= "       m71_quant-m71_quantatend as saldomovimento, ";
    $sSqlItens .= "       m71_codlanc ";
    $sSqlItens .= " from  matestoque  ";
    $sSqlItens .= "       inner join matmater       on m70_codmatmater = m60_codmater";
    $sSqlItens .= "       inner join matestoqueitem on m70_codigo      = m71_codmatestoque";
    //$sSqlItens .= " where m70_codmatmater   in(12733)";
    //$sSqlItens .= "    and m71_codlanc     = 122500";
    $sSqlItens .= " order by m60_codmater";
    $rsItens   = pg_query($sSqlItens);
    $this->sMensagem = "Sem itens com valores negativos";
    $this->initLog("material/".basename(__FILE__));
    $this->log("Pesquisando itens com dados Negativos");
    if ($rsItens) {
      
      if (pg_num_rows($rsItens) > 0) {

        $iTotalLinhas = pg_num_rows($rsItens);
        $this->log("Total de itens: {$iTotalLinhas}");
        $aItensComErro      = array();
        
        for ($i = 0; $i < $iTotalLinhas; $i++) {
          
          $this->processamento($i, $iTotalLinhas);
          db_inicio_transacao($pConexao);
          $oItem = db_utils::fieldsMemory($rsItens, $i);
          
          $sSqlTotaisEstoque  = "select sum(coalesce(case when m81_tipo = 1 then m82_quant end, 0)) as entrada,";
          $sSqlTotaisEstoque .= "       sum(coalesce(case when m81_tipo = 2 then m82_quant end, 0)) as saida";
          $sSqlTotaisEstoque .= "  from matestoqueinimei ";
          $sSqlTotaisEstoque .= "       inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem";
          $sSqlTotaisEstoque .= "       inner join matestoque     on m71_codmatestoque = m70_codigo ";
          $sSqlTotaisEstoque .= "       inner join matestoqueini  on m80_codigo        = m82_matestoqueini ";
          $sSqlTotaisEstoque .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
          $sSqlTotaisEstoque .= " where m71_codlanc = {$oItem->m71_codlanc} ";
          
          $nQuantidadeEstoque   = 0;
          //die($sSqlTotalEstoqueItem);
          $rsTotaisEstoque    = db_query($pConexao, $sSqlTotaisEstoque);
          $oDadosEstoque      = db_utils::fieldsMemory($rsTotaisEstoque, 0);
          $sSqlTotaisTransferencias  = "select sum(coalesce(case when m81_tipo = 4 then m82_quant end, 0)) as saida";
          $sSqlTotaisTransferencias .= "  from matestoqueinimei ";
          $sSqlTotaisTransferencias .= "       inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem";
          $sSqlTotaisTransferencias .= "       inner join matestoque     on m71_codmatestoque = m70_codigo ";
          $sSqlTotaisTransferencias .= "       inner join matestoqueini  on m80_codigo        = m82_matestoqueini ";
          $sSqlTotaisTransferencias .= "       left  join matestoqueinil on m80_codigo        = m86_matestoqueini ";
          $sSqlTotaisTransferencias .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
          $sSqlTotaisTransferencias .= " where m71_codlanc = {$oItem->m71_codlanc} ";
          $sSqlTotaisTransferencias .= "   and m81_codtipo = 7";
          $sSqlTotaisTransferencias .= "   and m86_matestoqueini is null";
          $rsTotaisTransferencias    =  db_query($pConexao, $sSqlTotaisTransferencias);
          $oDadosTransferencia       = db_utils::fieldsMemory($rsTotaisTransferencias, 0);
          $nQuantidadeEstoque        = 0;
          $nTotalMovimentacao = round($oDadosEstoque->entrada-($oDadosEstoque->saida), 2);
          if ($nTotalMovimentacao == round($oItem->saldomovimento, 2) && $oDadosTransferencia->saida > 0) {
            
            
            echo "aqui.....";
            $sSqlTotalEstoqueItem  = "select m82_quant, ";
            $sSqlTotalEstoqueItem .= "       m80_codigo   as codigomovimentacao, ";
            $sSqlTotalEstoqueItem .= "       m80_data     as datamovimentacao,   ";
            $sSqlTotalEstoqueItem .= "       m80_hora     as horamovimentacao,   ";
            $sSqlTotalEstoqueItem .= "       m80_codtipo  as tipomovimentacao,   ";
            $sSqlTotalEstoqueItem .= "       m82_codigo,  ";
            $sSqlTotalEstoqueItem .= "       m80_coddepto,   ";
            $sSqlTotalEstoqueItem .= "       m71_codlanc,   ";
            $sSqlTotalEstoqueItem .= "       m70_codigo,  ";
            $sSqlTotalEstoqueItem .= "       m81_tipo,  ";
            $sSqlTotalEstoqueItem .= "       m81_codtipo  ";
            $sSqlTotalEstoqueItem .= "  from matestoqueinimei ";
            $sSqlTotalEstoqueItem .= "       inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem";
            $sSqlTotalEstoqueItem .= "       inner join matestoque     on m71_codmatestoque = m70_codigo ";
            $sSqlTotalEstoqueItem .= "       inner join matestoqueini  on m80_codigo        = m82_matestoqueini ";
            $sSqlTotalEstoqueItem .= "       inner join matestoquetipo on m80_codtipo       = m81_codtipo ";
            $sSqlTotalEstoqueItem .= "       left  join matestoqueinil on m80_codigo        = m86_matestoqueini ";
            $sSqlTotalEstoqueItem .= " where m71_codlanc = {$oItem->m71_codlanc} ";
            $sSqlTotalEstoqueItem .= "   and m81_codtipo    = 7";
            $sSqlTotalEstoqueItem .= "   and m86_codigo is null";
            $sSqlTotalEstoqueItem .= " order by to_timestamp(m80_data || ' ' || m80_hora, 'YYYY-MM-DD HH24:MI:SS'), m80_codigo";
            $rsTotalItemEstoque   = pg_query($sSqlTotalEstoqueItem);
            $iTotalMovimentacao   = pg_num_rows($rsTotalItemEstoque);
            for ($iMov = 0; $iMov < $iTotalMovimentacao; $iMov++) {

              $oMovimentacao = db_utils::fieldsMemory($rsTotalItemEstoque, $iMov);
              $sSqlDeletePM  = "delete from matestoqueinimeipm where m89_matestoqueinimei = {$oMovimentacao->m82_codigo}";
              $rsDeletePM    = db_query($pConexao, $sSqlDeletePM);
              if (!$rsDeletePM) {

                $this->lErro = true;
              }
              
              $sSqlDeleteIniMei = "delete from matestoqueinimei where m82_codigo = {$oMovimentacao->m82_codigo}";
              $rsDeleteIniMei   = db_query($pConexao, $sSqlDeleteIniMei);
              if (!$rsDeletePM) {
                $this->lErro = true;
              } 
              
              $sSqlDeleteIni = "delete from matestoqueini where m80_codigo = {$oMovimentacao->codigomovimentacao}";
              $rsDeleteIni   = db_query($pConexao, $sSqlDeleteIniMei);
              if (!$rsDeleteIni) {
                $this->lErro = true;
              } 
              unset($oMovimentacao);
            }
          }
          $rsTotaisTransferencias    =  db_query($pConexao, $sSqlTotaisTransferencias);
          $oDadosTransferencia       = db_utils::fieldsMemory($rsTotaisTransferencias, 0);
          $nTotalMovimentacao = round($oDadosEstoque->entrada-($oDadosEstoque->saida), 2);
          if ($nTotalMovimentacao == round($oItem->saldomovimento, 2) && $oDadosTransferencia->saida > 0) {
            
            $this->lErro = true;
            $sMsg  = "Erro: Item {$oItem->m60_codmater} possui Transferencias invalidas:";
            $sMsg .= "movimentação {$oItem->m71_codlanc}, estoque {$oItem->m70_coddepto} ";
            $sMsg .= "Quantidade apos correção:".round($oDadosEstoque->entrada-($oDadosEstoque->saida+$oDadosTransferencia->saida), 2);
            $sMsg .= "Quantidade em estoque: {$oItem->saldomovimento} ";
            $sMsg .= "Quantidade em Transferencia {$oDadosTransferencia->saida}";
            $this->log($sMsg);
          } else {
            
            if (round($nTotalMovimentacao-$oDadosTransferencia->saida, 2) != round($oItem->saldomovimento, 2)) {
              
              $this->lErro = true;
              $sMsg  = "Erro: Item {$oItem->m60_codmater} possui Movimentacao inválidas:";
              $sMsg .= "movimentação {$oItem->m71_codlanc}, estoque {$oItem->m70_coddepto} ";
              $sMsg .= "Quantidade apos correção:".round($oDadosEstoque->entrada-($oDadosEstoque->saida), 2);
              $sMsg .= "Quantidade apos entrada:".round($oDadosEstoque->entrada, 2);
              $sMsg .= "Quantidade apos saida:".round($oDadosEstoque->saida, 2);
              $sMsg .= "Total:".round($nTotalMovimentacao-$oDadosTransferencia->saida, 2);
              $sMsg .= "Quantidade em estoque: {$oItem->saldomovimento} ";
              $sMsg .= "Quantidade em Transferencia {$oDadosTransferencia->saida}";
              $this->log($sMsg);
            }
          }
          $lFimTransacao  = $this->lErro?$this->lErro:$this->getModoTeste();
          //$lFimTransacao  = true;
          db_fim_transacao($pConexao, $lFimTransacao);
        }
      } else {
        $this->log("Sem itens no estoque");
      }
    }
    db_query($pConexao, "alter table matestoqueinimei enable trigger all");

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
