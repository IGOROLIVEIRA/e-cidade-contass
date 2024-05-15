<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
require_once("interfaces/IRegraLancamentoContabil.interface.php");
/**
 * E-cidade Software Publico para Gestão Municipal
 *   Copyright (C) 2014 DBSeller Serviços de Informática Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *   Este programa e distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   Cópia da licença no diretório licenca/licenca_en.txt
 *                                 licenca/licenca_pt.txt
 */


/**
 * Classe responsavel por criar a regra de lancamento de inscricao dos Restos a pagar
 * @author Iuri Guntchnigg
 * @package Contabilidade
 * @subpackage lancamento
 * @version $Revision: 1.2 $
 * Class RegraLancamentoEncerramentoRP
 */
class RegraLancamentoEncerramentoVariacoesPatrimoniais implements IRegraLancamentoContabil {

  public function getRegraLancamento($iCodigoDocumento, $iCodigoLancamento, ILancamentoAuxiliar $oLancamentoAuxiliar) {

    $oEventoContabil           = EventoContabilRepository::getEventoContabilByCodigo($iCodigoDocumento, db_getsession("DB_anousu"));
    $oLancamentoEventoContabil = $oEventoContabil->getEventoContabilLancamentoPorCodigo($iCodigoLancamento);
    $iContaEvento = '0';
    if (!$oLancamentoEventoContabil || count($oLancamentoEventoContabil->getRegrasLancamento()) == 0) {
      return false;
    }

    $aRegrasDoLancamento = $oLancamentoEventoContabil->getRegrasLancamento();
    if (count($aRegrasDoLancamento) == 0) {
      return false;
    }

    $oRegraLancamento = $aRegrasDoLancamento[0];
    $oMovimentoConta  = $oLancamentoAuxiliar->getMovimentacaoContabil();
    
    /*  A conta referência não deverá mais vir da transação.
        Será de acordo com o PRIMEIRO e QUINTO nível da conta do movimento, obedecendo as regras do TCE-MG.

    $iContaEvento     = $oRegraLancamento->getContaDebito();
    if ($oLancamentoAuxiliar->getContaReferencia() != "") {
      $iContaEvento = $oLancamentoAuxiliar->getContaReferencia();
    }*/

    $sSql  = "SELECT si09_tipoinstit FROM db_config
              JOIN infocomplementaresinstit ON si09_instit = codigo
              WHERE codigo = ".db_getsession("DB_instit");

    $rsInst = db_query($sSql);      
    $oInst  = db_utils::fieldsMemory($rsInst, 0)->si09_tipoinstit;

    $sContaSuperDefitConsolidadacao     = '237110101';
    $sContaSuperDefitIntraOFSS          = '237120101';
    $sContaSuperDefitInterOFSSUniao     = '237130101';
    $sContaSuperDefitInterOFSSEstado    = '237140101';
    $sContaSuperDefitInterOFSSMunicipio = '237150101';
    $sComplemnto = '0101';

    if($oInst == '1'){ // Câmaras
      $sComplemnto = '02'.$sComplemnto;
    }else if($oInst == '2' ){ // Prefeituras
      $sComplemnto = '01'.$sComplemnto;
    }else if($oInst == '5'){ // Previdências
      $sComplemnto = '03'.$sComplemnto;
    }else if($oInst == '51'){ // Consórcios
      $sComplemnto = '50'.$sComplemnto;
    }else { // Outros
      $sComplemnto = '04'.$sComplemnto;
    }    
   // echo $oInst." conta ".$sContaSuperDefitInterOFSSMunicipio.$sComplemnto;
    $oDaoConPlano  = db_utils::getDao("conplano");
    $sWhere        = " c61_reduz = {$oMovimentoConta->getConta()} ";
    $sSqlConplano  = $oDaoConPlano->sql_query_reduz(null, " substr(c60_estrut,5,1) as subtitulo ", null, $sWhere);
    $rsConplano    = $oDaoConPlano->sql_record($sSqlConplano);

    $sConPlanoSubTitulo  = db_utils::fieldsMemory($rsConplano)->subtitulo;

    $oDaoConPlanoRef  = db_utils::getDao("conplano");
    
    if($sConPlanoSubTitulo == '5'){// InterOFSSMunicipio 
        $sWhere        = " c60_estrut = '{$sContaSuperDefitInterOFSSMunicipio}{$sComplemnto}' ";
        $sSqlConplanoRef  = $oDaoConPlanoRef->sql_query_reduz(null, " c61_reduz ", null, $sWhere);
        $rsConplanoRef    = $oDaoConPlanoRef->sql_record($sSqlConplanoRef);
        $iContaEvento  = db_utils::fieldsMemory($rsConplanoRef)->c61_reduz;
    }else if($sConPlanoSubTitulo == '2'){// IntraOFSS
      $sWhere        = " c60_estrut = '{$sContaSuperDefitIntraOFSS}{$sComplemnto}' ";
        $sSqlConplanoRef  = $oDaoConPlanoRef->sql_query_reduz(null, " c61_reduz ", null, $sWhere);
        $rsConplanoRef    = $oDaoConPlanoRef->sql_record($sSqlConplanoRef);
        $iContaEvento  = db_utils::fieldsMemory($rsConplanoRef)->c61_reduz;
    }else if($sConPlanoSubTitulo == '3'){// InterOFSSUniao
      $sWhere        = " c60_estrut = '{$sContaSuperDefitInterOFSSUniao}{$sComplemnto}' ";
        $sSqlConplanoRef  = $oDaoConPlanoRef->sql_query_reduz(null, " c61_reduz ", null, $sWhere);
        $rsConplanoRef    = $oDaoConPlanoRef->sql_record($sSqlConplanoRef);
        $iContaEvento  = db_utils::fieldsMemory($rsConplanoRef)->c61_reduz;      
    }else if($sConPlanoSubTitulo == '4'){// InterOFSSEstado
      $sWhere        = " c60_estrut = '{$sContaSuperDefitInterOFSSEstado}{$sComplemnto}' ";
        $sSqlConplanoRef  = $oDaoConPlanoRef->sql_query_reduz(null, " c61_reduz ", null, $sWhere);
        $rsConplanoRef    = $oDaoConPlanoRef->sql_record($sSqlConplanoRef);
        $iContaEvento  = db_utils::fieldsMemory($rsConplanoRef)->c61_reduz;      
    }else {// 1 - Consolidadacao
        $sWhere        = " c60_estrut = '{$sContaSuperDefitConsolidadacao}{$sComplemnto}' ";
        $sSqlConplanoRef  = $oDaoConPlanoRef->sql_query_reduz(null, " c61_reduz ", null, $sWhere);
        $rsConplanoRef    = $oDaoConPlanoRef->sql_record($sSqlConplanoRef);
        $iContaEvento  = db_utils::fieldsMemory($rsConplanoRef)->c61_reduz;      
    }

    switch ($oMovimentoConta->getTipoSaldo()) {

      case 'D':

        $oRegraLancamento->setContaCredito($oMovimentoConta->getConta());
        $oRegraLancamento->setContaDebito($iContaEvento);
        break;
      case 'C':

        $oRegraLancamento->setContaCredito($iContaEvento);
        $oRegraLancamento->setContaDebito($oMovimentoConta->getConta());
        break;
    }

    /**
     * A conta sempre é modificada, nao podemos manter os dados no repositorio
     */
    EventoContabilRepository::removerEventoContabil($oEventoContabil);
    EventoContabilLancamentoRepository::removerEventoContabilLancamento($oLancamentoEventoContabil);
    return $oRegraLancamento;
  }

}