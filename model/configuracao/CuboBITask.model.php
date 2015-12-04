<?php
/*
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

require_once ('model/configuracao/Task.model.php');
require_once ('interfaces/iTarefa.interface.php');

require_once ("dbagata/classes/core/AgataAPI.class");
require_once ("libs/db_libsys.php");
require_once ("model/dbColunaRelatorio.php");
require_once ("model/dbFiltroRelatorio.php");
require_once ("model/dbVariaveisRelatorio.php");
require_once ("model/dbGeradorRelatorio.model.php");
require_once ("model/dbOrdemRelatorio.model.php");
require_once ("model/dbPropriedadeRelatorio.php");
require_once ("model/dbPropriedadeRelatorio.php");
require_once ("std/DBFtp.model.php");

class CuboBITask extends Task implements iTarefa {

  /**
   * Inicia Execucao da Tarefa
   */
  public function iniciar() {

    parent::iniciar();

    /* Carrega os dados de conexão com o banco de dados */
    require_once('libs/db_conn.php');
    /* Variaveis de sessão e outras configurações */
    require_once('libs/db_cubo_bi_config.php');

    $sConnection = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";
    global $conn;
    $conn = pg_connect($sConnection);
    db_inicio_transacao();

    try {

      $aParametros     = $this->getTarefa()->getParametros();
      $iCodRelatorio   = $aParametros['iCubo'];
      $oRelatorio      = new dbGeradorRelatorio($iCodRelatorio);
      $sNome           = "CuboBi_{$iCodRelatorio}_".date("YmdHis");
      $sCaminhoArquivo = $_SESSION['DB_document_root'] . "/" . $oRelatorio->gerarRelatorio($sNome);

      /**
       * As primeira e segunda linha do arquivo esta sendo gerada em branca
       * Deletamos a primeira e terceira linha do arquivo
       */
      $pFile = file($sCaminhoArquivo); // Lê todo o arquivo para um vetor
      unset($pFile[2]); // Elininando a linha 3
      unset($pFile[0]); // Elininando a linha 1
      file_put_contents($sCaminhoArquivo, $pFile);

      $sNomeArquivoNoServidor = "{$sNome}.csv";
      if ( file_exists($sCaminhoArquivo) ) {

        $oFtp            = new DBFtp();
        $oFtp->setFtpServer( $configCuboBi['ftp']['server'] );
        $oFtp->setFtpUsuario( $configCuboBi['ftp']['usuario'] );
        $oFtp->setFtpSenha( $configCuboBi['ftp']['senha'] );
        $oFtp->setNome( $sNomeArquivoNoServidor );
        $oFtp->setPassiveMode( $configCuboBi['ftp']['passive_mode'] );
        $oFtp->setCaminhoArquivo( $sCaminhoArquivo );
        $oFtp->acessarDiretorio( $configCuboBi['ftp']['diretorio'] );

        if ( !$oFtp->enviarArquivo() ) {
          $this->log("Ocorreu um erro ao transmitir o arquivo {$sNome} para o servidor FTP.");
        }

        $oFtp->desconectar(true);

      } else {
        $this->log("Ocorreu um erro ao gerar o arquivo {$sNome}.");
      }

      db_fim_transacao(false);
    } catch (Exception $oErro ) {

      $this->log($oErro->getMessage());
      db_fim_transacao(true);
    }

    parent::terminar();
  }

  /**
   * Para execução da Tarefa
   */
  public function cancelar(){

  }

  /**
   * Aborta a Execução da Tarefa
   */
  public function abortar(){

  }
}