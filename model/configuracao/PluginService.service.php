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

/**
 * Manipulador do model Plugin, utilizado para realizar comportamento do Plugin
 */
class PluginService {

  const MENSAGEM = 'configuracao.configuracao.pluginService.';
  const TMP_DIR  = "tmp/plugins/";

  /**
   * Instala o plugin validado
   *
   * @param  string $sNomeArquivo - Nome do plugin (É retornado pela função validarPlugin())
   * @throws Exception
   * @return boolean
   */
  public function instalarPlugin( $sNomeArquivo ) {

    if (!file_exists(self::TMP_DIR . "{$sNomeArquivo}.tar.gz")) {
      throw new Exception("Plugin não encotrado.");
    }

    try {

      $this->instalar( $sNomeArquivo );
      unlink(self::TMP_DIR . "{$sNomeArquivo}.tar.gz");
    } catch(Exception $e) {

      unlink(self::TMP_DIR . "{$sNomeArquivo}.tar.gz");
      throw new Exception($e->getMessage());
    }

    return true;
  }

  /**
   * Valida o arquivo do plugin
   *
   * @param  string $sCaminhoArquivo - Caminho do arquivo importado
   * @throws Exception
   * @return string - Nome do plugin Validado
   */
  public function validarPlugin( $sCaminhoArquivo ) {

    $sExt = pathinfo($sCaminhoArquivo, PATHINFO_EXTENSION);

    if ($sExt != "gz") {
      throw new Exception("Formato de arquivo inválido.");
    }

    /**
     * Descompacta o Plugin no temp
     */
    $sCaminhoPlugin = self::TMP_DIR . $this->descompactar( $sCaminhoArquivo );

    $oDataManifest = $this->loadManifest( $sCaminhoPlugin . "/Manifest.xml" );
    $sNomePlugin   = $oDataManifest->plugin->attributes()->name;
    $sNomeArquivo  = $sNomePlugin . time();

    /**
     * Renomeia o arquivo importado do plugin
     */
    rename($sCaminhoArquivo, self::TMP_DIR . "{$sNomeArquivo}.tar.gz");

    try {

      $this->validar( $sCaminhoPlugin . "/" );
      $this->recursiveRemove($sCaminhoPlugin);

    } catch (Exception $e) {

      if (is_dir($sCaminhoPlugin)) {
        $this->recursiveRemove($sCaminhoPlugin);
      }

      unlink(self::TMP_DIR . "{$sNomeArquivo}.tar.gz");

      throw new Exception( $e->getMessage() );
    }

    return $sNomeArquivo;
  }

  /**
   * Instala o plugin
   *
   * @param  string $sCaminhoArquivo - Caminho do arquivo que foi feito upload
   * @throws Exception
   * @return boolean                 - True se plugin instalado com sucesso
   */
  private function instalar( $sNomePlugin ) {

    $this->descompactar( self::TMP_DIR . "{$sNomePlugin}.tar.gz" );

    $sCaminhoPlugin = self::TMP_DIR . $sNomePlugin;
    $oDataManifest  = $this->loadManifest( "{$sCaminhoPlugin}/Manifest.xml" );
    $sNomePlugin    = $oDataManifest->plugin->attributes()->name;

    $sNomePluginAnterior = null;
    $lInstalarArquivos   = false;
    $oManifestAnterior   = null;

    /**
     * Verifica se o plugin já esta instalado para efetuar a atualização
     */
    if (is_dir("plugins/{$sNomePlugin}")) {

      $sNomePluginAnterior = $sNomePlugin . time();

      $oManifestAnterior = $this->loadManifest( "plugins/{$sNomePlugin}/Manifest.xml" );
      rename( "plugins/{$sNomePlugin}", self::TMP_DIR . $sNomePluginAnterior );

      $aFilesPluginAnterior = $this->getArquivosPlugin( self::TMP_DIR . "{$sNomePluginAnterior}/fontes.tar.gz" );

      /**
       * Verifica se os arquivos do plugin estão instalados no e-cidade e os remove para instalar os novos
       */
      if (!empty($aFilesPluginAnterior) && is_file(".{$aFilesPluginAnterior[0]}")) {

        $lInstalarArquivos = true;
        $this->removerArquivosInstalados($aFilesPluginAnterior);
      }
    }

    try {

      $lAtivo  = false;
      $oPlugin = new Plugin(null, $oDataManifest->plugin->attributes()->name);

      /**
       * Verifica se o plugin ja esta ativo e atualiza os menus e a estrutura do banco
       */
      if ($oPlugin->getCodigo()) {
        $lAtivo = $oPlugin->getSituacao();
      } else {

        $oPlugin->setNome($oDataManifest->plugin->attributes()->name);
        $oPlugin->setSituacao(false);
      }

      $oPlugin->setLabel($oDataManifest->plugin->attributes()->label);
      $oPlugin->salvar();

      rename($sCaminhoPlugin, "plugins/{$sNomePlugin}");

      if ($lInstalarArquivos || $lAtivo) {
        $this->instalarArquivosCompactados("plugins/{$sNomePlugin}/fontes.tar.gz");
      }

      if ($lAtivo) {

        /**
         * @todo Atualizar menus
         */
        $this->apagaMenus($oPlugin);

        if (!empty($oDataManifest->plugin->menus->menu)) {

          foreach ($oDataManifest->plugin->menus->menu as $oMenu) {
            $this->criaMenus($oMenu, $oPlugin->getCodigo(), $oDataManifest->plugin["id-modulo"]);
          }
        }

        if ($oManifestAnterior) {
          $this->rodaEstrutura($oPlugin, "update", (string) $oManifestAnterior->plugin['plugin-version']);
        }
      }

      /**
       * Remove a pasta do plugin anterior
       */
      if ($sNomePluginAnterior) {
        $this->recursiveRemove(self::TMP_DIR . $sNomePluginAnterior);
      }

    } catch (Exception $e) {

      if (is_dir("plugins/{$sNomePlugin}")) {

        rename("plugins/{$sNomePlugin}", $sCaminhoPlugin);

        if (!empty($sNomePluginAnterior)) {
          rename(self::TMP_DIR . $sNomePluginAnterior, "plugins/{$sNomePlugin}");
        }
      }

      $this->recursiveRemove($sCaminhoPlugin);

      throw new Exception($e->getMessage());
    }

    return true;
  }

  /**
   * Remove os arquivos do plugin do diretório do eCidade
   *
   * @param array $aFiles - Arquivos a serem removidos
   * @throws Exception
   */
  private function removerArquivosInstalados($aFiles) {

    foreach ($aFiles as $sFile) {

      if ( file_exists(".{$sFile}") ) {
        unlink(".{$sFile}");
      } else {
        throw new Exception( _M( self::MENSAGEM . "arquivo_nao_encontrado", (object) array('sPath' => $sFile) ));
      }
    }
  }

  /**
   * Instala os fontes compactados no diretório do eCidade
   * @param string $sArquivo - Caminho do arquivo compactado dos fontes
   */
  private function instalarArquivosCompactados($sArquivo) {

    $oArquivo = new PharData($sArquivo);
    $oArquivo->extractTo(".", null, true);
  }

  /**
   * Descompacta um arquivo tar.gz no diretório temporario do projeto
   *
   * @param  string $sCaminhoArquivo - Caminho do arquivo tar.gz
   * @param  string $sDestino - Caminho destino
   * @throws Exception
   * @return string - Nome do arquivo descompactado
   */
  private function descompactar($sCaminhoArquivo, $sDestino = '') {

    $oArquivo = new PharData($sCaminhoArquivo);
    $sDestino = empty($sDestino) ? basename($sCaminhoArquivo, ".tar.gz") : $sDestino;

    if (!$oArquivo->extractTo( self::TMP_DIR . $sDestino, null, true)) {
      throw new Exception( _M( self::MENSAGEM . "falha_descompactar" ) );
    }

    return $sDestino;
  }

  /**
   * Valida se o plugin esta instalado
   *
   * @param  string $sNomePlugin - Nome do plugin
   * @return boolean
   */
  private function instalado( $sNomePlugin ) {

    return (is_dir("plugins/{$sNomePlugin}") && file_exists("plugins/{$sNomePlugin}/Manifest.xml"));
  }

  /**
   * Verifica se o plugin já esta instalado
   *
   * @param string $sPathplugin Caminho do arquivo do plugin compactado
   * @return boolen
   */
  public function verificaAtualizacao( $sPathPlugin ) {

    if (!file_exists($sPathPlugin)) {
      return false;
    }

    if (!is_file("phar://{$sPathPlugin}/Manifest.xml")) {
      return false;
    }

    $oManifest = $this->loadManifest("phar://{$sPathPlugin}/Manifest.xml");

    return $this->instalado( $oManifest->plugin->attributes()->name );
  }

  /**
   * Descompacta os arquivos da estrutura e inclui o fonte dos callbacks
   * @param  string $sPathEstrutura
   * @param  string $sPathDestino
   */
  private function requireEstruturaCallback($sPathEstrutura, $sPathDestino) {

    $sPathEstruturaTmp = $this->descompactar($sPathEstrutura, $sPathDestino);

    require_once "interfaces/iEstruturaPluginCallback.interface.php";
    require_once self::TMP_DIR . "{$sPathEstruturaTmp}/EstruturaCallback.php";
  }

  /**
   * Retorna array com os itens de menu
   * @param  object $oMenus
   * @return array  $aMenus
   */
  private function getMenus($oMenus) {

    $aFiles = array();

    foreach ($oMenus->item as $oItem) {

      if (isset($oItem->item)) {

        $aRetorno = $this->getMenus($oItem);
        $aFiles   = array_merge($aFiles, $aRetorno);
      } else {

        if ($oItem['file'] == '') {

          throw new BusinessException(_M(self::MENSAGEM . 'item_menu_vazio', (object) array('sMenu' => $oItem['name'])));
        }

        $aFiles[] = "/" . preg_replace('/(\?.*)/', '', $oItem['file']);
      }
    }

    return $aFiles;
  }

  /**
   * Retorna um array com a arvore do Plugin.
   *
   * @param  string $sCaminho Caminho do diretorio
   * @param  string $sFolder  Diretorio a ser percorrido
   * @return array  $aRetorno caminho dos fontes.
   */
  private function getArquivosPlugin($sCaminho, $sFolder = '') {

    $sPathFontes     = 'phar://' . $sCaminho . $sFolder;
    $aRetorno        = array();
    $aArquivosPlugin = scandir($sPathFontes);

    foreach ($aArquivosPlugin as $sArquivo) {

      if ( is_dir($sPathFontes . '/' . $sArquivo ) ) {

       $aRetornoDiretorio = $this->getArquivosPlugin($sCaminho, $sFolder.'/'.$sArquivo);
       $aRetorno = array_merge($aRetorno, $aRetornoDiretorio);
      } else {
        $aRetorno[] = $sFolder . '/' . $sArquivo;
      }
    }

    return $aRetorno;
  }

  /**
   * Carrega o arquivo manifest.xml
   * @param  string $sCaminhosManifest
   * @return SimpleXml
   */
  private function loadManifest($sCaminhosManifest) {

    if (!file_exists($sCaminhosManifest)) {
      throw new Exception(_M(self::MENSAGEM . 'manifest_nao_existe'));
    }

    return simplexml_load_file($sCaminhosManifest);
  }

  /**
   * Desinstala um plugin do sistema
   *
   * @param  Plugin $oPlugin instância do plugin a ser desinstalado
   * @return boolean         True se desinstalado com sucesso
   */
  public function desinstalar(Plugin $oPlugin) {

    if ($oPlugin->getSituacao()) {
      $this->desativar($oPlugin);
    }

    if ($oPlugin->getCodigo()) {
      $oPlugin->excluir();
    }

    $sNomePlugin = $oPlugin->getNome();

    if (is_dir("plugins/{$sNomePlugin}")) {

      $aArquivosDesinstalar = $this->getArquivosPlugin( "plugins/{$sNomePlugin}/fontes.tar.gz" );

      if (!empty($aArquivosDesinstalar) && file_exists(".{$aArquivosDesinstalar[0]}")) {
        $this->removerArquivosInstalados($aArquivosDesinstalar);
      }

      $this->checkTempDir();

      if (!is_dir(self::TMP_DIR . date("YmdHis") . $sNomePlugin)) {
        rename("plugins/{$sNomePlugin}", self::TMP_DIR . date("YmdHis") . $sNomePlugin);
      }
    }

    return true;
  }

  /**
   * Verifica se existe o diretório temporario do plugin e cria o mesmo
   */
  public function checkTempDir() {

    if (!is_dir(self::TMP_DIR)) {
      mkdir(PluginService::TMP_DIR, 0777);
    }
  }

  /**
   * Ativa um plugin para uso
   * @param  Plugin $oPlugin instancia do Plugin que será ativado
   * @return boolean          Situação alterada
   */
  public function ativar(Plugin $oPlugin) {

    $oDataManifest = $this->loadManifest("plugins/{$oPlugin->getNome()}/Manifest.xml");

    $aDependenciasFaltando = $this->validarDependencias($oDataManifest->plugin);
    /**
     * Se estiver faltando alguma dependência
     */
    if (!empty($aDependenciasFaltando)) {

        $sListaPlugins = implode(', ', $aDependenciasFaltando);
        throw new BusinessException( _M( self::MENSAGEM . 'dependencias_faltando', (object) array('sListaPlugins' => $sListaPlugins)) );
    }

    if (!$oPlugin->isAtivo()) {

      /**
       * Cria a estrutura do banco de dados
       */
      $this->rodaEstrutura($oPlugin, "install");

      /**
       * Cria os menus do plugin
       */
      if (!empty($oDataManifest->plugin->menus->menu)) {

        foreach ($oDataManifest->plugin->menus->menu as $oMenu) {
          $this->criaMenus($oMenu, $oPlugin->getCodigo(), $oDataManifest->plugin["id-modulo"]);
        }
      }
    }

    /**
     * Move os arquivos para o ecidade
     */
    $this->instalarArquivosCompactados("plugins/{$oPlugin->getNome()}/fontes.tar.gz");

    $oPlugin->setSituacao(true);
    return $oPlugin->alterarSituacao();
  }

  /**
   * Desativa um plugin para uso
   *
   * @param  Plugin $oPlugin instancia do Plugin que será desativado
   * @return boolean          Situação alterada
   */
  public function desativar(Plugin $oPlugin) {

    if (!$oPlugin->isAtivo()) {
      return false;
    }

    $oPlugin->setSituacao(false);

    if ($oPlugin->getCodigo()) {

      $oPlugin->alterarSituacao();
      $this->apagaMenus($oPlugin);
    }

    $oDataManifest = $this->loadManifest("plugins/". $oPlugin->getNome()."/Manifest.xml");
    $oFiles = $oDataManifest->plugin->files;

    /**
     * Verifica se algum outro plugin depende do plugin que será desativado
     */
    $aDependenciasReversas = $this->validarDependenciasReversas($oDataManifest);
    if (!empty($aDependenciasReversas)) {

      $sDependenciasReversas = implode(', ', $aDependenciasReversas);
      throw new BusinessException(_M( self::MENSAGEM . "dependencias_reversas", (object) array("sListaPlugins" => $sDependenciasReversas)));
    }

    /**
     * Limpa o cache dos menus
     */
    DBMenu::limpaCache('', '', $oDataManifest->plugin["id-modulo"]);

    $aArquivosDesinstalar = $this->getArquivosPlugin( "plugins/". $oPlugin->getNome(). "/fontes.tar.gz" );

    $this->removerArquivosInstalados($aArquivosDesinstalar);

    /**
     * Remove a estrutura do banco de dados
     */
    $this->rodaEstrutura($oPlugin, "uninstall");

    return true;
  }

  /**
   * Roda a estrutura do plugin na base de dados
   *
   * @param  Plugin $oPlugin
   * @param  string $sEstrutura - Tipo do arquivo de estrutura (install|uninstall|update)
   * @param  string $sOldVersion - Versão do plugin instalada para atualizar
   * @throws Exception
   * @return boolean
   */
  private function rodaEstrutura(Plugin $oPlugin, $sEstrutura, $sVersaoAnterior = null) {

    $oConfiguracao = $this->getConfig()->AcessoBase;
    $lCallback = false;

    $sPathEstrutura = "plugins/{$oPlugin->getNome()}/estrutura.tar.gz";
    $oDataManifest  = $this->loadManifest("plugins/{$oPlugin->getNome()}/Manifest.xml");

    if (!property_exists($oDataManifest->plugin, 'estrutura')) {
      return false;
    }

    $aEstruturas   = array();
    $aAtualizacoes = (property_exists($oDataManifest->plugin->estrutura, 'estrutura') ? $oDataManifest->plugin->estrutura->estrutura : array());

    /**
     * Verifica quais arquivos devem ser rodados
     */
    switch ($sEstrutura) {

      /**
       * Caso seja instalação roda todos os arquivos de estrutura
       */
      case "install":

        $aEstruturas[] = file_get_contents( "phar://{$sPathEstrutura}{$oDataManifest->plugin->estrutura[$sEstrutura]}" );

        foreach ($aAtualizacoes as $aAtualizacao) {
          $aEstruturas[] = file_get_contents( "phar://{$sPathEstrutura}{$aAtualizacao['file']}" );
        }
        break;

      /**
       * Caso seja desinstalação roda o arquivo de desinstalação
       */
      case "uninstall":

        $aEstruturas[] = file_get_contents( "phar://{$sPathEstrutura}{$oDataManifest->plugin->estrutura[$sEstrutura]}" );
        break;

      /**
       * Caso seja atualização roda somente os arquivos acima da versão já instalada
       */
      case "update":

        if (empty($sVersaoAnterior)) {
          return false;
        }

        foreach ($aAtualizacoes as $aAtualizacao) {

          if ($aAtualizacao['version'] > $sVersaoAnterior && $aAtualizacao['version'] <= (string) $oDataManifest->plugin['plugin-version']) {
            $aEstruturas[] = file_get_contents( "phar://{$sPathEstrutura}{$aAtualizacao['file']}" );
          }
        }
        break;

      default:
        return false;
    }

    if ( file_exists("phar://{$sPathEstrutura}/EstruturaCallback.php") ) {

      $this->requireEstruturaCallback($sPathEstrutura, $oPlugin->getNome() . "/estrutura");
      $lCallback = true;

      $oEstruturaCallback = new EstruturaCallback();
    }

    $oDatabase = new Database();

    $oDatabase->setBase( pg_dbname() );
    $oDatabase->setServidor( pg_host() );
    $oDatabase->setPorta( pg_port() );
    $oDatabase->setUsuario( $oConfiguracao->usuario );
    $oDatabase->setSenha( $oConfiguracao->senha );

    try {

      $oDatabase->connect();

      $oDatabase->execute("select fc_startsession()");
      $oDatabase->execute("begin");

      $rsSearchPath = $oDatabase->execute("show search_path");

      /**
       * Roda o callback antes da estrutura
       */
      if ($lCallback) {

        if ($sEstrutura == 'install') {
          $oEstruturaCallback->beforeInstall($oDatabase);
        } else if ($sEstrutura == 'uninstall') {
          $oEstruturaCallback->beforeUninstall($oDatabase);
        }
      }

      $oDatabase->execute("set search_path to plugins");

      foreach ($aEstruturas as $sEstrutura) {
        $oDatabase->execute($sEstrutura);
      }

      $oDatabase->execute("set search_path to " . Database::fetchRow($rsSearchPath, 0)->search_path);

      /**
       * Roda o callback depois da estrutura
       */
      if ($lCallback) {

        if ($sEstrutura == 'install') {
          $oEstruturaCallback->afterInstall($oDatabase);
        } else if ($sEstrutura == 'uninstall') {
          $oEstruturaCallbacj->afterUninstall($oDatabase);
        }
      }

      $oDatabase->execute("commit");
      $oDatabase->disconnect();

    } catch (Exception $oException) {
      throw new Exception( "Estrutura:\n " . $oException->getMessage() );
    }

    /**
     * Retomando a conexão antiga
     * O PHP irá retomar a conexão antiga ativa e não criar uma nova
     */
    $GLOBALS['conn'] = pg_connect(   "host="     . db_getsession("DB_servidor")
                                   . " dbname="   . db_getsession("DB_base")
                                   . " port="     . db_getsession("DB_porta")
                                   . " user="     . db_getsession("DB_user")
                                   . " password=" . db_getsession("DB_senha") );
  }

  /**
   * Lê o arquivo de configuração "config/plugins.json" e retorna seu conteúdo
   * @throws Exception
   * @return JSON
   */
  public function getConfig() {

    $sPathConfigFile = "config/plugins.json";

    if (!file_exists($sPathConfigFile)) {
      throw new Exception( _M(self::MENSAGEM . "arquivo_config_nao_encontrado") );
    }

    $oConfiguracao = json_decode( file_get_contents($sPathConfigFile) );

    if (!property_exists($oConfiguracao, "AcessoBase")) {
      throw new Exception( _M(self::MENSAGEM . "acesso_base_nao_informado") );
    }

    if (!property_exists($oConfiguracao->AcessoBase, "usuario") || empty($oConfiguracao->AcessoBase->usuario)) {
      throw new Exception( _M(self::MENSAGEM . "usuario_base_nao_informado") );
    }

    if (!property_exists($oConfiguracao->AcessoBase, "senha") || empty($oConfiguracao->AcessoBase->senha)) {
      throw new Exception( _M(self::MENSAGEM . "senha_base_nao_informado") );
    }

    return $oConfiguracao;
  }

  /**
   * Cria os menus do plugin
   * @param  SimpleXMLElement $oMenu    Nó menu do xml Manifest
   * @param  integer          $iPlugin  Id do plugin
   * @param  integer          $iModulo  Id do módulo, especificado no xml Manifest
   * @param  integer          $iMenuPai Item de menu pai (utilizado para recursão da arvore)
   *                                    Caso não passe o pai, o método pega o pai de acordo com o xml Manifest e o módulo
   * @throws Exception
   * @return void
   */
  private function criaMenus(SimpleXMLElement $oMenu, $iPlugin, $iModulo, $iMenuPai = null) {

    $oDaoDbitensmenu = new cl_db_itensmenu();
    $oDaoDbpermissao = new cl_db_permissao();
    $oDaoDbmenu      = new cl_db_menu();
    $oDaoPluginMenu  = new cl_db_pluginitensmenu();

    if (empty($iMenuPai)) {
      switch ($oMenu["type"]) {
        case 1:
          $sTipoDescricao = "Cadastros";
        break;
        case 2:
          $sTipoDescricao = "Consultas";
        break;
        case 3:
          $sTipoDescricao = "Relatórios";
        break;
        case 4:
          $sTipoDescricao = "Procedimentos";
        break;
        default:
          throw new Exception( _M( self::MENSAGEM . "tipo_menu_desconhecido", (object) array("sTipo" => $oMenu["type"])));
      }

      $sSqlItenMenu = $oDaoDbitensmenu->sql_query_menus( null,
                                                         "i.id_item",
                                                         null,
                                                         "descricao = '{$sTipoDescricao}' and modulo = {$iModulo}" );

      $rsItenMenu = $oDaoDbitensmenu->sql_record($sSqlItenMenu);

      $oItemPai = db_utils::fieldsMemory($rsItenMenu, 0);

      $iMenuPai = $oItemPai->id_item;
    }


    foreach ($oMenu->item as $oItemMenu) {

      /**
       * Insere item de menu no sistema
       */
      $oDaoDbitensmenu->id_item    = null;
      $oDaoDbitensmenu->descricao  = utf8_decode($oItemMenu["name"]);
      $oDaoDbitensmenu->help       = utf8_decode($oItemMenu["name"]);
      $oDaoDbitensmenu->funcao     = $oItemMenu["file"];
      $oDaoDbitensmenu->itemativo  = "1";
      $oDaoDbitensmenu->manutencao = "1";
      $oDaoDbitensmenu->desctec    = utf8_decode($oItemMenu["name"]);
      $oDaoDbitensmenu->libcliente = $oItemMenu["liberado-cliente"];
      $oDaoDbitensmenu->incluir(null);

      if ($oDaoDbitensmenu->erro_status == '0') {
        throw new DBException($oDaoDbitensmenu->erro_msg);
      }

      $oDaoPluginMenu->db146_sequencial   = null;
      $oDaoPluginMenu->db146_db_plugin    = $iPlugin;
      $oDaoPluginMenu->db146_db_itensmenu = $oDaoDbitensmenu->id_item;
      $oDaoPluginMenu->incluir(null);

      if ($oDaoPluginMenu->erro_status == "0") {
        throw new DBException( _M( self::MENSAGEM . "falha_vinculacao_menu" ) );
      }

      /**
       * Busca o lugar certo na arvore de menus
       */
      $rsSequenciaMenu = $oDaoDbmenu->sql_record( $oDaoDbmenu->sql_query_file( null,
                                                                               "(max(menusequencia)+1) as menusequencia",
                                                                               null,
                                                                               "id_item = {$iMenuPai}") );

      if (!$rsSequenciaMenu) {
        throw new DBException( _M( self::MENSAGEM . "falha_organizar_menu", (object) array('sMenu' => $oItemMenu["name"]) ));
      }

      $oMenuSequencia = db_utils::fieldsMemory($rsSequenciaMenu,0);

      /**
       * Organizando o item de menu abaixo do item selecionado
       */
      $oDaoDbmenu->id_item        = $iMenuPai;
      $oDaoDbmenu->id_item_filho  = $oDaoDbitensmenu->id_item;
      $oDaoDbmenu->menusequencia  = $oMenuSequencia->menusequencia == NULL ? 1 : $oMenuSequencia->menusequencia;
      $oDaoDbmenu->modulo         = $iModulo;
      $oDaoDbmenu->incluir(null);

      if ($oDaoDbmenu->erro_status == '0') {
        throw new DBException($oDaoDbmenu->erro_msg);
      }


      /**
       * Liberando permissao de menu para o usuario que criou o relatorio
       */
      $oDaoDbpermissao->id_item        = $oDaoDbitensmenu->id_item;
      $oDaoDbpermissao->id_usuario     = db_getsession('DB_id_usuario');
      $oDaoDbpermissao->permissaoativa = '1';
      $oDaoDbpermissao->anousu         = db_getsession('DB_anousu');
      $oDaoDbpermissao->id_instit      = db_getsession('DB_instit');
      $oDaoDbpermissao->id_modulo      = $iModulo;

      $oDaoDbpermissao->incluir( db_getsession('DB_id_usuario'),
                                 $oDaoDbitensmenu->id_item,
                                 db_getsession('DB_anousu'),
                                 db_getsession('DB_instit'),
                                 $iModulo );

      if ($oDaoDbpermissao->erro_status == '0') {
        throw new DBException($oDaoDbpermissao->erro_msg);
      }

      if ( isset($oItemMenu->item) ) {
        $this->criaMenus($oItemMenu, $iPlugin, $iModulo, $oDaoDbitensmenu->id_item);
      }

      /**
       * Limpa o cache dos menus
       */
      DBMenu::limpaCache('', '', $iModulo);
    }

  }

  /**
   * Apaga os menus vinculados ao plugin
   * @param  Plugin $oPlugin instancia do plugin
   * @return void
   */
  private function apagaMenus(Plugin $oPlugin) {

    $oDaoDbitensmenu = new cl_db_itensmenu();
    $oDaoDbpermissao = new cl_db_permissao();
    $oDaoDbmenu      = new cl_db_menu();
    $oDaoPluginMenu  = new cl_db_pluginitensmenu();

    $sSqlPluginMenu = $oDaoPluginMenu->sql_query_file( null,
                                                       "db146_sequencial, db146_db_itensmenu",
                                                       null,
                                                       "db146_db_plugin = " . $oPlugin->getCodigo() );

    $rsPluginMenu = $oDaoPluginMenu->sql_record($sSqlPluginMenu);

    if ($oDaoPluginMenu->numrows > 0) {

      foreach (db_utils::getCollectionByRecord($rsPluginMenu) as $oPluginMenu) {
        $oDaoDbpermissao->excluir(null, null, null, null, null, "id_item = " . $oPluginMenu->db146_db_itensmenu );
        $oDaoDbmenu->excluir(null, "id_item_filho = " . $oPluginMenu->db146_db_itensmenu);
        $oDaoPluginMenu->excluir($oPluginMenu->db146_sequencial);
        $oDaoDbitensmenu->excluir($oPluginMenu->db146_db_itensmenu);
      }
    }

    return;
  }

  /**
   * Retorna todos os plugins que estão no sistema
   * @return Plugin[] Coleção de plugins
   */
  public function getPlugins() {

    $aPlugins = array();

    foreach (scandir("plugins/") as $sFolder) {

      $sManifest = "plugins/{$sFolder}/Manifest.xml";

      if (!in_array($sFolder, array("..", '.')) && is_dir("plugins/{$sFolder}") && file_exists($sManifest)) {

        $oPluginSistema = new Plugin(null, $sFolder);

        $oDataManifest = $this->loadManifest($sManifest);

        if (!$oPluginSistema->getCodigo()) {

          $oPluginSistema->setNome((string) $oDataManifest->plugin->attributes()->name);
          $oPluginSistema->setLabel((string) $oDataManifest->plugin->attributes()->label);
          $oPluginSistema->setSituacao(false);
          $oPluginSistema->salvar();
        }

        $oPlugin = new stdClass();
        $oPlugin->iCodigo       = $oPluginSistema->getCodigo();
        $oPlugin->sNome         = $oPluginSistema->getNome();
        $oPlugin->sLabel        = $oPluginSistema->getLabel();
        $oPlugin->lConfiguracao = (boolean) $this->getPluginConfig($oPluginSistema);
        $oPlugin->nVersao       = (string) $oDataManifest->plugin['plugin-version'];
        $oPlugin->lSituacao     = $this->isAtivo($oPluginSistema);

        $aPlugins[] = $oPlugin;
      }
    }

    return $aPlugins;
  }

  /**
   * Retorna a configuração de um plugin, caso exista o arquivo de configuração
   *
   * @param  Plugin $oPlugin
   * @return mixed array|null
   */
  public static function getPluginConfig(Plugin $oPlugin) {

    $sPathConfig = "plugins/{$oPlugin->getNome()}/config.ini";

    if (!is_file($sPathConfig)) {
      return null;
    }

    $aConfiguracao = parse_ini_file($sPathConfig);
    return $aConfiguracao;
  }

  /**
   * Grava o arquivo de configuração do plugin
   *
   * @param Plugin $oPlugin
   * @param array $aConfig | array('nome da configuracao' => 'valor')
   * @return boolean
   */
  public static function setPluginConfig(Plugin $oPlugin, $aConfig) {

    $sPathConfig = "plugins/{$oPlugin->getNome()}/config.ini";

    if (!is_file($sPathConfig) || !is_writable($sPathConfig)) {
      return false;
    }

    $sContent = "";
    foreach ($aConfig as $sProperty => $sValue) {
      $sContent .= "{$sProperty}={$sValue}\n";
    }

    return (boolean) file_put_contents($sPathConfig, $sContent);
  }

  /**
   * Verifica se o Plugin esta ativo
   *
   * @param  Plugin  $oPlugin
   * @return boolean
   */
  public function isAtivo(Plugin $oPlugin) {

    $lAtivoPlugin  = $oPlugin->isAtivo();
    $oDataManifest = $this->loadManifest("plugins/{$oPlugin->getNome()}/Manifest.xml");

    $oFiles = $oDataManifest->plugin->files;

    foreach ($oFiles->file as $oFile) {

      $lAtivoArquivos = file_exists(".{$oFile['path']}" );
      break;
    }

    return $lAtivoPlugin && $lAtivoArquivos;
  }

  /**
   * Metodo responsavel por fazer a validação do Plugin.
   *
   *  -Todos os arquivos especificados no Manifest.XML devem existir no plugin.
   *  -Todos os arquivos que existem no plugin devem estar especificados no Manifest.XML.
   *  -Os arquivos especificados no Manifest.XML não podem existir no e-cidade.
   *  -A versão especificada no Manifest.XML deve ser <= que a versão atual do e-cidade.
   *  -Todas as dependências do plugin devem estar instaladas e ativadas
   *
   * @param  string $sPlugin caminho temporário do plugin.
   * @throws Exception
   * @return boolean
   */
  private function validar( $sPlugin ){

    if (empty($sPlugin)) {
      throw new BusinessException(_M(self::MENSAGEM . 'manifest_nao_informado'));
    }

    /**
     * Carrega o Manifest.XML
     */
    $sCaminhosManifest = $sPlugin . "/Manifest.xml";
    $oPluginManifest   = $this->loadManifest($sCaminhosManifest);
    $oPlugin           = $oPluginManifest->plugin;
    $sNomePlugin       = $oPlugin->attributes()->name;

    /**
     * Verifica se o plugin já esta instalado
     */
    $lPluginInstalado  = $this->instalado( $sNomePlugin );

    /**
     * Verifica se o módulo informado é valido
     */
    if (!empty($oPlugin->menus)) {

      $oDaoModulo = new cl_db_modulos();

      $sSqlModulo = $oDaoModulo->sql_query_file($oPlugin['id-modulo']);
      $rsModulo   = $oDaoModulo->sql_record( $sSqlModulo );

      if (!$rsModulo || !pg_num_rows($rsModulo)) {
        throw new Exception( _M(self::MENSAGEM . 'id_modulo_invalido') );
      }
    }

    /**
     * Array com todos os arquivos especificados no XML.
     */
    $aFilesXML = array();

    /**
     * Array com todos o arquivos fontes do pluguin.
     */
    $sPathFontes     = $sPlugin . "fontes.tar.gz";
    $aArquivosPlugin = $this->getArquivosPlugin($sPathFontes);

    /**
     * Verifica se todos os arquivos especificados no
     * XML existem no diretorio do plugin.
     */
    $oFiles = $oPlugin->files;

    foreach ($oFiles->file as $aFile) {

      $aFilesXML[] = $aFile['path'];

      if (!in_array($aFile['path'], $aArquivosPlugin)) {
        throw new BusinessException( _M(self::MENSAGEM . 'arquivo_nao_encontrado', (object) array('sPath' => $aFile['path'])) );
      }
    }

    /**
     * Verifica se todos os arquivos contidos no diretorio do
     * plugin estão especificados no arquivo XML
     */
    foreach ($aArquivosPlugin as $sArquivo) {

      if (!in_array($sArquivo, $aFilesXML)) {
        throw new BusinessException( _M(self::MENSAGEM . 'arquivo_nao_especificado', (object) array('sPath' => $sArquivo)) );
      }
    }

    /**
     * Verifica se o plugin já esta instalado para validar a atualização
     */
    if ($lPluginInstalado) {

      $oManifestInstalado  = $this->loadManifest( "plugins/{$sNomePlugin}/Manifest.xml" );
      $aArquivosInstalados = $this->getArquivosPlugin( "plugins/{$sNomePlugin}/fontes.tar.gz" );

      if (((string) $oPlugin['plugin-version']) < ((string) $oManifestInstalado->plugin['plugin-version'])) {
        throw new Exception( _M( self::MENSAGEM . 'versao_ja_instalada') );
      }
    }

    /**
     * Verifica se os arquivos informados no plugin já existem no e-cidade e se
     * não esta sendo incluido nos fontes o arquivo db_conecta.php
     */
    foreach ($aArquivosPlugin as $sArquivo) {

      /**
       * Verifica se os arquivos estão incluindo o "db_conecta.php"
       */
      if (preg_match('/db_conecta\.php/', file_get_contents("phar://{$sPlugin}fontes.tar.gz{$sArquivo}"))) {
        throw new BusinessException( _M( self::MENSAGEM . 'db_conecta_incluido', (object) array('sPath' => $sArquivo)) );
      }

      /**
       * Verifica se o plugin já não esta instalado e se o arquivo já existe no eCidade
       */
      if (!$lPluginInstalado && file_exists("./$sArquivo")) {
        throw new BusinessException( _M( self::MENSAGEM . 'arquivo_ja_existe', (object) array('sPath' => $sArquivo)) );
      }

      /**
       * Verifica se o plugin já esta instalado e se o arquivo informado é um arquivo novo desta versão do plugin e se já existe no eCidade
       */
      if ($lPluginInstalado && !in_array($sArquivo, $aArquivosInstalados) && file_exists("./{$sArquivo}")) {
        throw new BusinessException( _M( self::MENSAGEM . 'arquivo_ja_existe', (object) array('sPath' => $sArquivo)) );
      }
    }

    /**
     * Verifica se a versão especificada no XML é menor ou igual a do e-cidade.
     */
    $iVersao  = $GLOBALS['db_fonte_codversao'];
    $iRelease = $GLOBALS['db_fonte_codrelease'];
    $sVersao  = "2.{$iVersao}.{$iRelease}";

    if ( $oPlugin['ecidade-version'] > $sVersao){
      throw new BusinessException(_M(self::MENSAGEM . 'versao_invalida'));
    }

    /**
     * Valida os itens de menus. Todos os itens de menu 'FOLHA' devem possuir
     * uma função cadastrada, e todos as funções devem ter sido informadas no manifest como file.
     */
    $oMenus = $oPlugin->menus;

    if ( !empty($oMenus->menu) ) {
      $aFilesMenus = $this->getMenus($oMenus->menu);

      foreach ($aFilesMenus as $sFileMenu) {

        if (!in_array($sFileMenu, $aArquivosPlugin)) {
          throw new BusinessException( _M(self::MENSAGEM . 'arquivo_nao_especificado_menu', (object) array('sPath' => $sFileMenu)) );
        }
      }
    }

    /**
     * Valida os arquivos que irão criar a estrutura no banco de dados
     */
    if (property_exists($oPlugin, "estrutura")) {

      /**
       * Caminho do arquivo de estrutura do plugin
       */
      $sPathEstrutura = $sPlugin . "estrutura.tar.gz";

      if (!file_exists($sPathEstrutura)) {
        throw new BusinessException( _M( self::MENSAGEM . 'arquivo_nao_encontrado',
                                         (object) array('sPath' => 'estrutura.tar.gz')) );
      }

      /**
       * Array contendo todos os arquivos de estrutura compactador
       */
      $aArquivosEstrutura = $this->getArquivosPlugin($sPathEstrutura);

      if (!isset($oPlugin->estrutura['install'])) {
        throw new BusinessException( _M( self::MENSAGEM . 'estrutura_install_nao_informado') );
      }

      if (!isset($oPlugin->estrutura['uninstall'])) {
        throw new BusinessException( _M( self::MENSAGEM . 'estrutura_uninstall_nao_informado') );
      }

      if (!in_array($oPlugin->estrutura['install'], $aArquivosEstrutura)) {

        throw new BusinessException( _M( self::MENSAGEM . 'arquivo_nao_encontrado',
                                         (object) array('sPath' => $oPlugin->estrutura['install'])) );
      }

      if (!in_array($oPlugin->estrutura['uninstall'], $aArquivosEstrutura)) {

        throw new BusinessException( _M( self::MENSAGEM . 'arquivo_nao_encontrado',
                                         (object) array('sPath' => $oPlugin->estrutura['uninstall'])) );
      }

      /**
       * Valida a estrutura das novas versões do plugin
       */
      if (property_exists($oPlugin->estrutura, "estrutura")) {

        foreach($oPlugin->estrutura->estrutura as $oEstrutura) {

          if ($oEstrutura["version"] > $oPlugin['plugin-version']) {
            throw new Exception( _M( self::MENSAGEM . 'versao_estrutura_superior' ) );
          }

          if (!in_array($oEstrutura["file"], $aArquivosEstrutura)) {
            throw new Exception( _M( self::MENSAGEM . 'arquivo_nao_encontrado', (object) array('sPath' => $oEstrutura["file"])) );
          }
        }
      }

      if (in_array("/EstruturaCallback.php", $aArquivosEstrutura)) {

        $this->requireEstruturaCallback( $sPathEstrutura, basename($sPlugin) . "/estrutura" );

        if (!class_exists("EstruturaCallback")) {
          throw new BusinessException( _M( self::MENSAGEM . 'classe_estrutura_nao_encontrada' ) );
        }

        if (!in_array("EstruturaPluginCallback", class_implements("EstruturaCallback"))) {
          throw new BusinessException( _M( self::MENSAGEM . 'classe_estrutura_sem_interface' ) );
        }
      }

    }

    $aDependenciasFaltando = $this->validarDependencias($oPlugin);
    /**
     * Se estiver faltando alguma dependência
     */
    if (!empty($aDependenciasFaltando)) {

        $sListaPlugins = implode(', ', $aDependenciasFaltando);
        throw new BusinessException( _M( self::MENSAGEM . 'dependencias_faltando', (object) array('sListaPlugins' => $sListaPlugins)) );
    }

    return true;
  }

  /**
   * Valida as dependências reversas de um plugin
   *
   * @return array Plugins dependentes
   */
  private function validarDependenciasReversas($oPlugin) {

    $aPlugins              = $this->getPlugins();
    $aDependenciasReversas = array();
    $sNomePlugin           = $oPlugin->plugin->attributes()->name;

    foreach ($aPlugins as $oPluginComparado) {

      $oPluginComparadoConfig = $this->loadManifest("plugins/{$oPluginComparado->sNome}/Manifest.xml");
      $sNomePluginComparado   = (string) $oPluginComparadoConfig->plugin['name'];
      $nVersaoPluginComparado = (string) $oPluginComparadoConfig->plugin['plugin-version'];

      if (property_exists($oPluginComparadoConfig->plugin, "dependencies")) {

        /**
         * Coloca o nome de todas as dependências em um array
         */
        $aDependenciasPlugin = array();
        foreach ($oPluginComparadoConfig->plugin->dependencies->plugin as $aDependencia) {
          $aDependenciasPlugin[] = (string) $aDependencia['name'];
        }

        /**
         * Verifica se o plugin validado está entre as dependências do plugin comparado
         */
        if (in_array($sNomePlugin, $aDependenciasPlugin) && $oPluginComparado->lSituacao) {
          /**
           * Adiciona o plugin comparado na lista de dependências reversas
           */
          $aDependenciasReversas[] = "{$sNomePluginComparado} {$nVersaoPluginComparado}";
        }

      }
    }

    return $aDependenciasReversas;
  }

  /**
   * Valida as dependências do plugin
   *
   * @return array Dependências faltando
   */
  private function validarDependencias($oPlugin) {

    $aDependenciasFaltando = array();

    if (property_exists($oPlugin, "dependencies")) {

      $aPlugins = $this->getPlugins();
      foreach ($oPlugin->dependencies->plugin as $aDependencia) {

        /**
         * Se a dependência não está ativa
         */
        if (!$this->validarDependenciaAtiva( $aDependencia, $aPlugins )) {
          /**
           * Adiciona na lista de dependências faltando
           */
          $aDependenciasFaltando[] = "{$aDependencia['name']} {$aDependencia['version']}";
        }

      }

    }

    return $aDependenciasFaltando;
  }

  /**
   * Verifica se a dependência informada está instalada e ativa
   *
   * @param array $aDependencia
   * @param array $aPlugins
   * @return boolean Verdadeiro se a dependência estiver instalada e ativa
   */
  private function validarDependenciaAtiva($aDependencia, $aPlugins) {

    foreach ($aPlugins as $oPlugin) {

      $oPluginConfig = $this->loadManifest("plugins/{$oPlugin->sNome}/Manifest.xml");
      $nVersao       = (float) $oPluginConfig->plugin['plugin-version'];

      if ($aDependencia['name'] == $oPlugin->sNome && $oPlugin->lSituacao && $nVersao >= $aDependencia['version']) {
        return true;
      }
    }

    return false;
  }

  /**
   * Remove um diretório recursivamente
   * @param string $sDir
   */
  private function recursiveRemove($sDir) {
    $oDirs = new DirectoryIterator($sDir);

    foreach ($oDirs as $oDir) {

      if ( $oDir->isDot() ) {
        continue;
      }

      if ( $oDir->isDir() ) {
        $this->__recursiveRemove($oDir->getPathname());
      }

      if ($oDir->isFile()) {
        unlink($oDir->getPathname());
      }

    }

    rmdir($sDir);
  }
}