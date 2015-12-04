<?php

class DBHelp {

  const URL_HELP_SERVER = 'http://centraldeajuda.dbseller.com.br/help/api/index.php/faq/findFaqByMenu/';

  private $sVersao = '';

  private $idItemMenu = null;

  public function __construct() {

    $this->idItemMenu = db_getsession('DB_itemmenu_acessado');

    include('libs/db_acessa.php');
    $this->sVersao = "2.$db_fonte_codversao.$db_fonte_codrelease";
  }

  public function getHelpData() {

    $sUrl = self::URL_HELP_SERVER . $this->idItemMenu . '/' . $this->sVersao . '/1';

    $aOptions = array(
      'http' => array(
        'header'  => "Accept: application/json\r\n",
        'method'  => 'GET'
      ),
    );

    $context  = stream_context_create($aOptions);

    $sRetorno = @file_get_contents($sUrl, false, $context);

    if ($sRetorno === false) {
      $error = error_get_last();
      throw new Exception("Erro ao buscar os faqs: " . $error['message']);
    }

    $aHelps = json_decode($sRetorno);

    if (!empty($aHelps->error)) {
      throw new BusinessException($aHelps->message);
    }

    return $aHelps;
  }

  public function getVersao() {
    return $this->sVersao;
  }

}