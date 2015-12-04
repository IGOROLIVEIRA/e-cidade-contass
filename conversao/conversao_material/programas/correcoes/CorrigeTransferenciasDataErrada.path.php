<?
require_once "CorrecoesEstruturaBasica.php";
require_once "ICorrecoes.interface.php";

class CorrigeTransferenciasDataErrada extends CorrecoesAbstract implements ICorrecoes {
  
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
    
    $this->sMensagem = "Processamento de transferencias com data errada [Log: $this->sNameFileLog]";    
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
    $sSqlItens .= "  where m70_codmatmater   = 82";
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
          $sSqlTransferencias          = "SELECT distinct "; 
          $sSqlTransferencias         .= "       a.*, ";
          $sSqlTransferencias         .= "       b.m80_codigo as codigotransf, ";
          $sSqlTransferencias         .= "       to_timestamp(a.m80_data || ' ' ||a.m80_hora, 'YYYY-MM-DD HH24:MI:SS') ";
          $sSqlTransferencias         .= "       as datamovimento,";
          $sSqlTransferencias         .= "       to_char(to_timestamp(a.m80_data || ' ' ||a.m80_hora, 'YYYY-MM-DD HH24:MI:SS') +";
          $sSqlTransferencias         .= "       '2 seconds'::interval, 'YYYY-mm-dd') as datasaida,";
          $sSqlTransferencias         .= "       to_char(to_timestamp(a.m80_data || ' ' ||a.m80_hora, 'YYYY-MM-DD HH24:MI:SS') +";
          $sSqlTransferencias         .= "       '2 seconds'::interval, 'HH24:MI:SS') as horasaida";
          $sSqlTransferencias         .= "   from matestoqueini a ";
          $sSqlTransferencias         .= "        inner join matestoqueinil   on m86_matestoqueini  = a.m80_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueinill  on m87_matestoqueinil = m86_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueinimei on m82_matestoqueini  = m80_codigo ";
          $sSqlTransferencias         .= "        inner join matestoqueitem   on m82_matestoqueitem = m71_codlanc ";
          $sSqlTransferencias         .= "        inner join matestoqueini b  on m87_matestoqueini  = b.m80_codigo ";
          $sSqlTransferencias         .= " where a.m80_codtipo = 7 ";
          $sSqlTransferencias         .= "   and m71_codmatestoque = {$oMovimentacao->m70_codigo}";
          $rsTotalTransFerencias       = db_query($pConexao, $sSqlTransferencias);
          $iTotalLinhasTransferencias  = pg_num_rows($rsTotalTransFerencias);
          if ($iTotalLinhasTransferencias > 0) {
            
            for ($iTransferencia = 0; $iTransferencia < $iTotalLinhasTransferencias; $iTransferencia++) {

              $oTransf             = db_utils::fieldsMemory($rsTotalTransFerencias, $iTransferencia);
              $sSqlTransferencias  =  "SELECT a.*";
              $sSqlTransferencias .= "   from matestoqueini a ";
              $sSqlTransferencias .= "        left  join matestoqueinil   on m86_matestoqueini  = a.m80_codigo ";
              $sSqlTransferencias .= "        left  join matestoqueinill  on m87_matestoqueinil = m86_codigo ";
              $sSqlTransferencias .= "        left join matestoqueini b  on m87_matestoqueini  = b.m80_codigo ";
              $sSqlTransferencias .= " where a.m80_codigo = {$oTransf->codigotransf} ";
              $sSqlTransferencias .= "   and to_timestamp(a.m80_data || ' ' ||a.m80_hora, 'YYYY-MM-DD HH24:MI:SS') ";
              $sSqlTransferencias .= " <= '{$oTransf->datamovimento}'::timestamp";
              $sSqlTransferencias .= " order by a.m80_data ";
              $rsDadosTransf       =  db_query($pConexao, $sSqlTransferencias);
              if (pg_num_rows($rsDadosTransf) > 0) {

                $oDadosTransf = db_utils::fieldsMemory($rsDadosTransf, 0);
                if ($oDadosTransf->m80_hora == $oTransf->m80_hora && $oDadosTransf->m80_data == $oTransf->m80_data) {
                  
                  $sUpdate  = " update matestoque ";
                  $sUpdate .= "    set m80_data   = '{$oTransf->datasaida}', "; 
                  $sUpdate .= "    set m80_hora   = '{$oTransf->horasaida}', "; 
                  $sUpdate .= "  where m80_codigo = {$oTransf->codigotransf}"; 
                }
              }
            }
          }
        }
       
      } else {
        $this->log("Sem itens no estoque");
      }
    }
    $lFimTransacao    = $this->lErro?$this->lErro:$this->getModoTeste();
    db_fim_transacao($pConexao, $lFimTransacao);
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