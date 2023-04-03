<?php

require_once "classes/TestesEstruturaBasica.php";
require_once "classes/ITestes.interface.php";

class MaterialSaidaAnteriorentrada extends TestesAbstract implements ITestes {
  
  private $sMensagem = "";
  private $lErro     = false;
  
  function __construct(){
  }  
  
  public function run() {
    
    global $pConexao;
    $sSqlItens = "select distinct m60_codmater, ";
    $sSqlItens .= "       m60_descr    ";
    $sSqlItens .= " from  matestoque  ";
    $sSqlItens .= "       inner join matmater on m70_codmatmater = m60_codmater";
//    /$sSqlItens .= " where m60_codmater = 1718  ";
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
          $sSqllItensMovimentacaoEntrada  = " SELECT distinct m70_codmatmater, ";
          $sSqllItensMovimentacaoEntrada .= "        m80_data  , "; 
          $sSqllItensMovimentacaoEntrada .= "        m80_codigo  as codigoentrada, "; 
          $sSqllItensMovimentacaoEntrada .= "        m80_hora,  "; 
          $sSqllItensMovimentacaoEntrada .= "        m71_codlanc as codigoitementrada"; 
          $sSqllItensMovimentacaoEntrada .= "   from matestoqueinimei ";
          $sSqllItensMovimentacaoEntrada .= "        inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem  ";
          $sSqllItensMovimentacaoEntrada .= "        inner join matestoqueini  on m82_matestoqueini = m80_codigo "; 
          $sSqllItensMovimentacaoEntrada .= "        inner join matestoquetipo on m81_codtipo       = m80_codtipo   ";
          $sSqllItensMovimentacaoEntrada .= "        inner join matestoque     on m70_codigo        = m71_codmatestoque  ";
          $sSqllItensMovimentacaoEntrada .= "  where m81_codtipo in(1, 3, 14, 12) ";
          $sSqllItensMovimentacaoEntrada .= "    and m70_codmatmater = {$oItem->m60_codmater}"; 
          $sSqllItensMovimentacaoEntrada .= "  order by m70_codmatmater";
          
          $rsMovimentacoes      = pg_query($sSqllItensMovimentacaoEntrada);
          $iTotalMovimentacao   = pg_num_rows($rsMovimentacoes);
          if ($iTotalMovimentacao > 0) {    

            /**
             * Percorremos todas as saidas do item, que a dat ada saida é igual ou menor que a data da entrada. 
             */
            for ($iItem = 0; $iItem < $iTotalMovimentacao; $iItem++) {
              
              $oDadosSaida                  = db_utils::fieldsMemory($rsMovimentacoes, $iItem);
              $sSqllItensMovimentacaoSaida  = " SELECT distinct m70_codmatmater, ";
              $sSqllItensMovimentacaoSaida .= "        m80_data as datasaida, "; 
              $sSqllItensMovimentacaoSaida .= "        m80_codigo as codigosaida, "; 
              $sSqllItensMovimentacaoSaida .= "        m80_hora as horasaida "; 
              $sSqllItensMovimentacaoSaida .= "   from matestoqueinimei ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem  ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoqueini  on m82_matestoqueini = m80_codigo "; 
              $sSqllItensMovimentacaoSaida .= "        inner join matestoquetipo on m81_codtipo       = m80_codtipo   ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoque     on m70_codigo        = m71_codmatestoque  ";
              $sSqllItensMovimentacaoSaida .= "  where m81_tipo        = 2 ";
              $sSqllItensMovimentacaoSaida .= "    and m71_codlanc    = {$oDadosSaida->codigoentrada} ";
              $sSqllItensMovimentacaoSaida .= "    and to_timestamp(m80_data || ' ' || m80_hora, 'YYYY-MM-DD HH24:MI:SS') < "; 
              $sSqllItensMovimentacaoSaida .= "        to_timestamp('{$oDadosSaida->m80_data} {$oDadosSaida->m80_hora}', 'YYYY-MM-DD HH24:MI:SS')"; 
              $sSqllItensMovimentacaoSaida .= "  order by m70_codmatmater";
              $rsItensMovimentacaoSaida     = pg_query($sSqllItensMovimentacaoSaida);
              $iTotalSaidasInvalidas        = pg_num_rows($rsItens);
              if (pg_num_rows($rsItensMovimentacaoSaida) > 0) {
                
                $this->lErro  = true;
                $sErroString  = "[Erro]: Item {$oItem->m60_codmater} - {$oItem->m60_descr} possui saidas com data anterior ";
                $sErroString .= "a Data de Entrada. Lançamento:{$oDadosSaida->codigoentrada}Quantidade de Movimentações inválidas:{$iTotalMovimentacao}";
                $this->log($sErroString);
                $aItensComErro[$oItem->m60_codmater] = $oItem->m60_descr;
              }
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