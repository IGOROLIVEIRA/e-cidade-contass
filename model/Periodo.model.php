<?php
/*
 *     E-cidade Software P�blico para Gest�o Municipal                
 *  Copyright (C) 2014  DBseller Servi�os de Inform�tica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa � software livre; voc� pode redistribu�-lo e/ou     
 *  modific�-lo sob os termos da Licen�a P�blica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a vers�o 2 da      
 *  Licen�a como (a seu crit�rio) qualquer vers�o mais nova.          
 *                                                                    
 *  Este programa e distribu�do na expectativa de ser �til, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia impl�cita de              
 *  COMERCIALIZA��O ou de ADEQUA��O A QUALQUER PROP�SITO EM           
 *  PARTICULAR. Consulte a Licen�a P�blica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU     
 *  junto com este programa; se n�o, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  C�pia da licen�a no diret�rio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
 * Class PeriodoRelatorioContabil
 *
 * Respons�vel por controlar os per�odos dispon�veis no sistema
 *
 * @author Matheus Felini <matheus.felini@dbseller.com.br>
 * @version $Revision: 1.1 $
 */
final class Periodo {

  /**
   * C�digo
   * @var integer
   */
  private $iCodigo;

  /**
   * Descri��o
   * @var string
   */
  private $sDescricao;

  /**
   * Carrega as informa��es do objeto
   * @throws BusinessException
   * @param $iCodigo
   */
  public function __construct($iCodigo) {

    $oDaoPeriodo    = new cl_periodo();
    $rsBuscaPeriodo = $oDaoPeriodo->sql_record($oDaoPeriodo->sql_query_file($iCodigo));
    if ($oDaoPeriodo->erro_status == "0") {
      throw new BusinessException("Per�odo [{$iCodigo}] n�o encontrado.");
    }
    $oStdPeriodo      = db_utils::fieldsMemory($rsBuscaPeriodo, 0);
    $this->iCodigo    = $iCodigo;
    $this->sDescricao = $oStdPeriodo->o114_descricao;
    unset($oStdPeriodo);
  }

  /**
   * Retorna o c�digo sequencial
   * @return int
   */
  public function getCodigo() {
    return $this->iCodigo;
  }

  /**
   * Retorna a descri��o completa
   * @return string
   */
  public function getDescricao() {
    return $this->sDescricao;
  }
}