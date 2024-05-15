<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

require_once("model/empenho/EmpenhoFinanceiro.model.php");
/**
 * Model restos a pagar
 * @author  Bruno Silva      <bruno.silva@dbseller.com.br>
 * @author  Jeferson Belmiro <jeferon.belmiro@dbseller.com.br>
 * @package empenho
 * @version $Revision: 1.6 $
 */
class RestosAPagar extends EmpenhoFinanceiro {

  /**
   * Retorna valor acumulado nao processado do ano
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorNaoProcessadoAno($iAno, $iInstituicao) {
    try {
      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      if(db_getsession('DB_anousu') == 2015){
        $WhereEmpresto = "e91_anousu = {$iAno}";
      }else{
      $WhereEmpresto = "e91_anousu = {$iAno} and e60_anousu = {$iAnoEmp}";
      }
      $WhereEmpresto .= " and e60_instit = {$iInstituicao}";

      $sCampos = "coalesce(sum(e91_vlremp - e91_vlranu - e91_vlrliq), 0) as valor";
      $sSqlEmpresto = $oDaoEmpresto->sql_query_empenho(null, null, $sCampos, null, $WhereEmpresto);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

      $nValor = db_utils::fieldsMemory($rsSqlEmpresto, 0)->valor;
      return (float) $nValor;

    } catch (Exception $ex){

      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar não processado1.');

    }


  }

  /**
   * Retorna o sql do valor nao processado detalhado por empenho
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorNaoProcessadoAnalitico($iAno, $iInstituicao) {
    try {
      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      if(db_getsession('DB_anousu') == 2015){
        $WhereEmpresto = "e91_anousu = {$iAno}";
      }else{
        $WhereEmpresto = "e91_anousu = {$iAno} and e60_anousu = {$iAnoEmp}";
      }
      $WhereEmpresto .= " and e60_instit = {$iInstituicao} group by 1 having round(coalesce(sum(e91_vlremp - e91_vlranu - e91_vlrliq), 0),4) > 0";

      $sCampos = "e91_numemp, round(sum(e91_vlremp - e91_vlranu - e91_vlrliq),4) as valor";
      $sSqlEmpresto = $oDaoEmpresto->sql_query_empenho(null, null, $sCampos, null, $WhereEmpresto);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

    } catch (Exception $ex){

      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar não processado.2');

    }

    return $rsSqlEmpresto;
  }

  /**
   * Retorna valor acumulado processado do ano
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorProcessadoAno($iAno, $iInstituicao) {
    try {
      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      if(db_getsession('DB_anousu') == 2015){
        $WhereEmpresto = "e91_anousu = {$iAno}";
      }else{
        $WhereEmpresto = "e91_anousu = {$iAno} and e60_anousu = {$iAnoEmp}";
      }
      $WhereEmpresto .= " and e60_instit = {$iInstituicao}";

      $sCampos = "coalesce(sum(e91_vlrliq - e91_vlrpag), 0) as valor";
      $sSqlEmpresto = $oDaoEmpresto->sql_query_empenho(null, null, $sCampos, null, $WhereEmpresto);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

      $nValor = db_utils::fieldsMemory($rsSqlEmpresto, 0)->valor;
      return (float) $nValor;

    } catch (Exception $ex){

      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar processado.');

    }

  }

  /**
   * Retorna o sql do valor processado detalhado por empenho
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorProcessadoAnalitico($iAno, $iInstituicao) {
    try {

      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      if(db_getsession('DB_anousu') == 2015){
        $WhereEmpresto = "e91_anousu = {$iAno}";
      }else{
        $WhereEmpresto = "e91_anousu = {$iAno} and e60_anousu = {$iAnoEmp}";
      }
      $WhereEmpresto .= " and e60_instit = {$iInstituicao} group by 1 having round(sum(e91_vlrliq - e91_vlrpag),4) > 0";

      $sCampos = "e91_numemp, round(sum(e91_vlrliq - e91_vlrpag),4) as valor";
      $sSqlEmpresto = $oDaoEmpresto->sql_query_empenho(null, null, $sCampos, null, $WhereEmpresto);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

    } catch (Exception $ex){
      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar processado.');
    }

    return $rsSqlEmpresto;
  }

  /**
   * Retorna o sql do valor processado detalhado por empenho
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorRpAnalitico($iAno, $iInstituicao) {
    try {

      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      $sSqlEmpresto = $oDaoEmpresto->sql_query_restosPagarInscricaoAbertura($iAnoEmp, $iInstituicao);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

    } catch (Exception $ex){
      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar em liquidacao.');
    }

    return $rsSqlEmpresto;
  }

  /**
   * Retorna o sql do valor processado detalhado por empenho
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorRpEmLiquidacaoAno($iAno, $iInstituicao) {
    try {

      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      $sSqlEmpresto = $oDaoEmpresto->sql_query_restosPagarInscricaoAberturaAno($iAnoEmp, $iInstituicao);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

      $nValor = db_utils::fieldsMemory($rsSqlEmpresto, 0)->vlrrpemlqdano;
      return (float) $nValor;
    } catch (Exception $ex){
      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar.');
    }

    return $rsSqlEmpresto;
  }

  /**
   * Retorna o sql do valor processado detalhado por empenho
   * @param integer $iAno
   * @param integer $iInstituicao
   */
  public static function getValorRpNpAno($iAno, $iInstituicao) {
    try {

      $oDaoEmpresto = db_utils::getDao("empresto");
      $iAnoEmp = $iAno - 1;
      $sSqlEmpresto = $oDaoEmpresto->sql_query_restosPagarInscricaoAberturaAno($iAnoEmp, $iInstituicao);
      $rsSqlEmpresto = $oDaoEmpresto->sql_record($sSqlEmpresto);

      $nValor = db_utils::fieldsMemory($rsSqlEmpresto, 0)->vlrrnpano;
      
      return (float) $nValor;

    } catch (Exception $ex){
      throw new Exception('Erro técnico: erro ao buscar valor de restos a pagar.');
    }

    return $rsSqlEmpresto;
  }

}