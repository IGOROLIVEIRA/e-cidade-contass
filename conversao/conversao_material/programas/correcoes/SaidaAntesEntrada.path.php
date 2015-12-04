<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class SaidaAntesEntrada extends CorrecoesAbstract implements ICorrecoes {
  
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
    
    db_inicio_transacao($pConexao);

    $this->log("");
    $this->log("Fim do processamento");
    $this->log("");

    db_fim_transacao($pConexao,$this->getModoTeste());
    if ($this->getModoTeste() == true) {
      db_query($pConexao, "rollback;");
      $this->log("");
      $this->log(">>>>>> MODO DE TESTE. Rollback! <<<<<<");
      $this->log("");
    }
    $sSqlItens = "select distinct m60_codmater, ";
    $sSqlItens .= "       m60_descr    ";
    $sSqlItens .= " from  matestoque  ";
    $sSqlItens .= "       inner join matmater on m70_codmatmater = m60_codmater";
   // $sSqlItens .= "  where m60_codmater = 26   ";
    $sSqlItens .= " order by m60_codmater";
    $rsItens   = pg_query($sSqlItens);
    $this->sMensagem = "Sem itens com datas invalidas";
    $this->initLog("material/".basename(__FILE__));
    $this->log("Pesquisando itens datas inválidas");
    if ($rsItens) {
      
      if (pg_num_rows($rsItens) > 0) {

        $iTotalLinhas = pg_num_rows($rsItens);
        $this->log("Total de itens: {$iTotalLinhas}");
        $aItensComErro = array();
        for ($i = 0; $i < $iTotalLinhas; $i++) {
          
          $this->processamento($i, $iTotalLinhas);
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
          $sSqllItensMovimentacaoEntrada .= "  where m80_codtipo in(1, 3, 14, 12, 14, 15, 8) ";
          $sSqllItensMovimentacaoEntrada .= "    and m70_codmatmater = {$oItem->m60_codmater}"; 
          $sSqllItensMovimentacaoEntrada .= "  order by m80_data,m80_hora, m80_codigo";
          $rsMovimentacoes                 = pg_query($sSqllItensMovimentacaoEntrada);
          $iTotalMovimentacao   = pg_num_rows($rsMovimentacoes);
          if ($iTotalMovimentacao > 0) {    

            /**
             * Percorremos todas as saidas do item, que a dat ada saida é igual ou menor que a data da entrada. 
             */
            for ($iItem = 0; $iItem < $iTotalMovimentacao; $iItem++) {
              
              $oDadosEntrada                = db_utils::fieldsMemory($rsMovimentacoes, $iItem);
              $sDataEntrada                 = strtotime("{$oDadosEntrada->m80_data} {$oDadosEntrada->m80_hora}");
              $sSqllItensMovimentacaoSaida  = " SELECT distinct m70_codmatmater, ";
              $sSqllItensMovimentacaoSaida .= "        m80_data , "; 
              $sSqllItensMovimentacaoSaida .= "        m80_codigo as codigosaida, "; 
              $sSqllItensMovimentacaoSaida .= "        m80_hora "; 
              $sSqllItensMovimentacaoSaida .= "   from matestoqueinimei ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoqueitem on m71_codlanc       = m82_matestoqueitem  ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoqueini  on m82_matestoqueini = m80_codigo "; 
              $sSqllItensMovimentacaoSaida .= "        inner join matestoquetipo on m81_codtipo       = m80_codtipo   ";
              $sSqllItensMovimentacaoSaida .= "        inner join matestoque     on m70_codigo        = m71_codmatestoque  ";
              $sSqllItensMovimentacaoSaida .= "  where m81_tipo        = 2 ";
              $sSqllItensMovimentacaoSaida .= "    and m71_codlanc    = {$oDadosEntrada->codigoitementrada} ";
              $sSqllItensMovimentacaoSaida .= "    and to_timestamp(m80_data || ' ' || m80_hora, 'YYYY-MM-DD HH24:MI:SS') < "; 
              $sSqllItensMovimentacaoSaida .= "        to_timestamp('{$oDadosEntrada->m80_data} {$oDadosEntrada->m80_hora}', 'YYYY-MM-DD HH24:MI:SS')"; 
              $sSqllItensMovimentacaoSaida .= "  order by m70_codmatmater";
              $rsItensMovimentacaoSaida     = pg_query($sSqllItensMovimentacaoSaida);
              $iTotalSaidasInvalidas        = pg_num_rows($rsItens);
              if (pg_num_rows($rsItensMovimentacaoSaida) > 0) {
                
                $sDataSaida   = '';
                for ($iMov = 0; $iMov < $iTotalSaidasInvalidas; $iMov++) {
                  
                  $oDadosSaida = db_utils::fieldsMemory($rsItensMovimentacaoSaida, $iMov);
                  $sDataSaidaMovimento = strtotime("{$oDadosSaida->m80_data} {$oDadosSaida->m80_hora}"); 
                  if ($sDataSaida == '') {
                    $sDataSaida  = $sDataSaidaMovimento;  
                  }
                  if ($sDataSaidaMovimento < $sDataSaida) {
                   $sDataSaida  = $sDataSaidaMovimento;
                  }
                }
                if ($sDataSaida != "") {

                   $sDataEntradaNova = date("Y-m-d", mktime(date("H", $sDataSaida), 
                                                            date("i", $sDataSaida), 
                                                            date("s", $sDataSaida)-1,
                                                            date("m", $sDataSaida),
                                                            date("d", $sDataSaida),
                                                            date("Y", $sDataSaida)));
                                                             
                   $sHoraEntradaNova = date("H:i:s", mktime(date("H", $sDataSaida), 
                                                            date("i", $sDataSaida), 
                                                            date("s", $sDataSaida)-1,
                                                            date("m", $sDataSaida),
                                                            date("d", $sDataSaida),
                                                            date("Y", $sDataSaida)));
                                                                                                          
                   $sUpdate  = "update matestoqueini set m80_hora = '$sHoraEntradaNova', ";
                   $sUpdate .= "                         m80_data = '$sDataEntradaNova' ";
                   $sUpdate .= " where m80_codigo = {$oDadosEntrada->codigoentrada}";
                   $rsUpdate = pg_query($sUpdate);
                   if (!$rsUpdate) {
                     $this->lErro = true; 
                   }
                   $sErroString  = "[Erro]: Item {$oItem->m60_codmater} - {$oItem->m60_descr} possui saidas com data anterior ";
                   $sErroString .= "a Data de Entrada. Lançamento:{$oDadosEntrada->codigoentrada}Quantidade de Movimentações inválidas:{$iTotalMovimentacao}";
                   $this->log($sErroString);
                 }
              }
            }
          }            
        }
      } else {
        //$this->log("Sem itens no estoque");
      }
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
