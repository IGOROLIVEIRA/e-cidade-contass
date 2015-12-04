<?php  
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2015  DBSeller Servicos de Informatica             
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

/**
 * Factory para o gerenciar os Assentamentos do sistema, será 
 * responsavém por tratar os assentamentos e retornar uma instância 
 * de Assentamento ou de AssentamentoSubstituicao
 * 
 * @author Renan Melo <renan@dbseller.com.br>
 * @package Pessoal
 */
class AssentamentoFactory {

  /**
   * Arquivo de mensagens
   */
  const MENSAGEM = "recursoshumanos.pessoal.AssentamentoFactory.";
  
  private function __construct(){}

  /**
   * Retorna uma instância de AssentamentoSubstituicao caso o assentamento informado 
   * por parâmetro for da Natureza substituição, caso contrário retorna uma 
   * instância de Assentamento.
   *
   * @param  integer  $iCodigoAssentamento
   * @return Assentamento - Caso a natureza do assentamento seja normal
   *         AssentamentoSubstituicao - Caso a natureza do assentamento seja substituição
   */
  public static function getByCodigo($iCodigoAssentamento) {

    if (empty($iCodigoAssentamento)) {
      throw new BusinessException (self::MENSAGEM . 'codigo_nao_informado');
    }

    /**
     * Montamos um objeto de assentamento para recuperar o seu tipo e consultar a natureza
     */
    $oAssentamento     = new Assentamento($iCodigoAssentamento);
    $iTipoAssentamento = $oAssentamento->getTipoAssentamento();

    if(empty($iTipoAssentamento)) {
      throw new BusinessException (self::MENSAGEM . 'erro_buscar_tipo_assentamento');
    }

    /**
     * Verificamos se a natureza do assentamento é substituição.
     */
    $oDaoTipoAsse = new cl_tipoasse();
    $rsTipoAsse   = $oDaoTipoAsse->sql_record($oDaoTipoAsse->sql_query_file($iTipoAssentamento, "h12_natureza"));

    if (!$rsTipoAsse) {
      throw new DBException(self::MENSAGEM . 'erro_buscar_assentamentos');
    } elseif(is_resource($rsTipoAsse) && $oDaoTipoAsse->numrows > 0){
      $oStdTipoAssentamento = db_utils::fieldsMemory($rsTipoAsse, 0);
    }

    if ($oStdTipoAssentamento->h12_natureza == AssentamentoSubstituicao::CODIGO_NATUREZA) {
      return new AssentamentoSubstituicao($iCodigoAssentamento);
    }

    return new Assentamento($iCodigoAssentamento);
  }

}