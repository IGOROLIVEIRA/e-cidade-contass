<?php

set_time_limit(0);
if(!defined('DB_BIBLIOT')){

  session_cache_limiter('none');
  if ( !isset($_SESSION) ) {
    session_start();
  }

  if ( !function_exists("db_menu") ) {

    require_once "libs/db_stdlib.php";
    require_once "libs/db_conecta.php";
    include_once "libs/db_sessoes.php";
    include_once "libs/db_usuariosonline.php";
  }
  db_postmemory($_POST);
  db_postmemory($_SERVER);

}

use \Mpdf\Mpdf;

/**
 * PDF
 * @param string $mode              | padrão: BLANK
 * @param mixed $format             | padrão: A4
 * @param float $default_font_size  | padrão: 0
 * @param string $default_font      | padrão: ''
 * @param float $margin_left        | padrão: 7
 * @param float $margin_right       | padrão: 7
 * @param float $margin_top         | padrão: 16
 * @param float $margin_bottom      | padrão: 16
 * @param float $margin_header      | padrão: 9
 * @param float $margin_footer      | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */
class Relatorio extends mPDF
{
  /**
   * @var string HTML do cabeçalho
   */
  private $sHeaderHTML = '';


  /**
   * @var string HTML do rodapé
   */
  private $sFooterHTML = '';


  /**
   * @var array Informações de filtro e título do relatório
   */
  private $aInformacoes = array();


  private $lImprimeRodape = true;


  public function __construct(
    $mode = 'BLANK', $format = 'A4', $default_font_size = 0, $default_font = '',
    $margin_left = 7, $margin_right = 7, $margin_top = 40, $margin_bottom = 14,
    $margin_header = 6, $margin_footer = 0
  ) {
    parent::__construct();

    /*----------- Footer -----------*/
    $this->setHTMLFooter(utf8_encode($this->rodape()), 'O');

    /*------------ CSS ------------*/

    $this->WriteHTML(file_get_contents('estilos/relatorios/padrao.style.css'), 1);
    $this->WriteHTML(file_get_contents('estilos/relatorios/cabecalho.style.css'), 1);
    $this->WriteHTML(file_get_contents('estilos/relatorios/rodape.style.css'), 1);

    switch ($format) {
      case 'A4-L':
        $this->WriteHTML(file_get_contents('estilos/relatorios/cabecalho-landscape.style.css'), 1);
        break;

      default:
        $this->WriteHTML(file_get_contents('estilos/relatorios/cabecalho-portrait.style.css'), 1);
        $this->WriteHTML(file_get_contents('estilos/relatorios/rodape-portrait.style.css'), 1);
        break;
    }

  }


  /**
   *
   */
  private function setCabecalho()
  {
    $this->sHeaderHTML = '';
    $this->DefHTMLHeaderByName('_default', utf8_encode($this->cabecalho()));
    $this->SetHTMLHeaderByName('_default', 'O', true);
  }


  /**
   * Monta cabeçalho HTML com os dados do cliente
   * e as informações sobre os filtros
   *
   * @return string
   */
  protected function cabecalho()
  {
    if (!empty($this->sHeaderHTML)) {
      $this->sHeaderHTML;
    }

    global $conn;
    global $result;
    global $url;
    global $db21_compl;


    /*---------- Dados da Instituição ----------*/

    $oDados = db_query(
      $conn,
      " SELECT nomeinst, db21_compl,
        trim(ender)||',
        '||trim(cast(numero as text)) as ender,
        trim(ender) as rua, munic, numero, uf, cgc, telef, email, url, logo
        FROM db_config WHERE codigo = ".db_getsession("DB_instit")
    );

    $sUrl   = @pg_result($oDados,0,"url");
    $sLogo  = @pg_result($oDados,0,"logo");

    $sNome = pg_result($oDados,0,"nomeinst");
    global $sNomeInst;
    $sNomeInst = pg_result($oDados,0,"nomeinst");

    $sComplento = substr(trim(pg_result($oDados,0,"db21_compl")), 0, 20);
    if (!empty($sComplento)) {
      $sComplento = ', ' . substr(trim(pg_result($oDados,0,"db21_compl")), 0, 20);
    }
    $sLogradouro  = trim(pg_result($oDados,0,"rua")) . ', ' . trim(pg_result($oDados,0,"numero")) . $sComplento;
    $sCidadeUF    = trim(pg_result($oDados,0,"munic")) . ' - ' . pg_result($oDados,0,"uf");
    $sTelefone    = trim(pg_result($oDados,0,"telef")) . ' - CNPJ: ' .db_formatar(pg_result($oDados,0,"cgc"),"cnpj");
    $sEmail       = trim(pg_result($oDados,0,"email"));


    /*---------- Informações ----------*/
    $sInformacoes = $this->getParagrafosDeInformacoes();


    /*---------- HTML <header> ----------*/
    $header = <<<HEADER
    <header class='cabecalho'>
      <div class='logo' style='background-image: url(imagens/files/{$sLogo});'>
      </div>

      <div class='cliente'>
        <h1>{$sNome}</h1>
        <p>{$sLogradouro}</p>
        <p>{$sCidadeUF}</p>
        <p>{$sTelefone}</p>
        <p>{$sEmail}</p>
        <p>{$sUrl}</p>
      </div>

      <div class='info bg_eb'>
        {$sInformacoes}
      </div>

      <div class='both'></div>
    </header>
HEADER;

    $this->sHeaderHTML = $header;
    return $this->sHeaderHTML;
  }


  /**
   * Monta rodapé HTML
   *
   * @return string
   */
  protected function rodape()
  {
    if (!$this->lImprimeRodape) {
      return '';
    }

    if (!empty($this->sHeaderHTML)) {
      $this->sHeaderHTML;
    }

    global $conn;
    global $result;
    global $url;

    // Informa o caminho do menu na base
    $sDB_itemmenu_acessado  = db_getsession("DB_itemmenu_acessado");
    $sDB_modulo             = db_getsession("DB_modulo");
    $sSqlMenuAcess = "
      SELECT trim(modulo.descricao)||' > '||trim(menu.descricao)||' > '||trim(item.descricao) AS menu
      FROM db_menu
      INNER JOIN db_itensmenu AS modulo ON modulo.id_item = db_menu.modulo
      INNER JOIN db_itensmenu AS menu ON menu.id_item = db_menu.id_item
      INNER JOIN db_itensmenu AS item ON item.id_item = db_menu.id_item_filho
      WHERE id_item_filho = {$sDB_itemmenu_acessado} AND modulo = {$sDB_modulo}
    ";

    $rsMenuAcess  = db_query($conn,$sSqlMenuAcess);
    $sMenuAcess   = substr(pg_result($rsMenuAcess, 0, "menu"), 0, 50);
    $sDB_NBASE    = db_getsession("DB_NBASE");
    $sDB_usuario  = db_getsession("DB_id_usuario");

    $sNome = @$GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"];
    $sNome = substr($sNome, strrpos($sNome,"/")+1);
    $rsNomeUsu = db_query($conn, "SELECT nome AS nomeusu FROM db_usuarios WHERE id_usuario = {$sDB_usuario}");

    if (pg_numrows($rsNomeUsu)>0) {
      $sNomeUsu = pg_result($rsNomeUsu,0,0);
    }

    if (isset($sNomeUsu) && !empty($sNomeUsu)) {
      $sEmissor = $sNomeUsu;
    } else {
      $sEmissor = @$GLOBALS["DB_login"];
    }

    $sInfo  = $sMenuAcess
            . "  "
            . $sNome
            . ' | Emissor: '
            . substr(ucwords(strtolower($sEmissor)), 0, 30)
            . ' | Exerc: '
            . db_getsession("DB_anousu")
            . ' | Data: '
            . date("d-m-Y", db_getsession("DB_datausu"))
            . " - "
            . date("H:i:s");

    $footer = <<<FOOTER
      <footer class='rodape'>
        <div class='db-base'>
          Base: {$sDB_NBASE}
        </div>

        <div class='info'>
          <div class='rotina'>
            {$sInfo}
          </div>

          <div class='paginacao'>
            P&aacute;g {PAGENO}/{nbpg}
          </div>
        </div>
      </footer>
FOOTER;

    $this->sFooterHTML = $footer;
    return $this->sFooterHTML;

  }


  // // mudar o angulo do texto
  // function TextWithDirection($x,$y,$txt,$direction='R')
  // {
  //   $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
  //   if ($direction=='R')
  //       $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$txt);
  //   elseif ($direction=='L')
  //       $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$txt);
  //   elseif ($direction=='U')
  //       $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
  //   elseif ($direction=='D')
  //       $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
  //   else
  //       $s=sprintf('BT %.2f %.2f Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$txt);
  //   $this->_out($s);
  // }


  // // rotacionar o texto
  // function TextWithRotation($x,$y,$txt,$txt_angle,$font_angle=0)
  // {
  //   $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));

  //   $font_angle+=90+$txt_angle;
  //   $txt_angle*=M_PI/180;
  //   $font_angle*=M_PI/180;

  //   $txt_dx=cos($txt_angle);
  //   $txt_dy=sin($txt_angle);
  //   $font_dx=cos($font_angle);
  //   $font_dy=sin($font_angle);

  //   $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
  //            $txt_dx,$txt_dy,$font_dx,$font_dy,
  //            $x*$this->k,($this->h-$y)*$this->k,$txt);
  //   $this->_out($s);
  // }


  /**
   * Altera a exibição ou não do rodapé
   *
   * @param boolean $lMostra
   * @return object $this
   */
  public function imprimeRodape($lMostra = true)
  {
    $this->lImprimeRodape = !!$lMostra;

    return $this;
  }


  /**
   * Retorna o array de informações em um conjunto
   * de elementos <p> para cada um dos itens
   * @return string
   */
  private function getParagrafosDeInformacoes()
  {
    $aArrayAux = array_fill(0, 9, '');
    $aArrayAux = $this->aInformacoes + $aArrayAux;
    ksort($aArrayAux);

    return array_reduce($aArrayAux, function ($str, $item) {

      $item = empty($item) ? '&nbsp;' : htmlentities($item, ENT_QUOTES, 'ISO-8859-1');
      return $str . "<p>{$item}</p>\n";

    }, '');
  }


  /**
   * Insere informações no array $this->aInformacoes,
   * que aparecerão no topo direito do cabeçalho do relatório
   *
   * @param string $value
   * @param int $key position to insert in array
   * @return object $this
   */
  public function addInfo($value = '', $key = -1)
  {
    $iQtdInfo = count($this->aInformacoes);
    if ($iQtdInfo < 9) {

      $iPosicao = $key >= 0 ? $key : $iQtdInfo;
      $this->aInformacoes[$iPosicao] = $value;
      ksort($this->aInformacoes);

    }

    $this->setCabecalho();

    return $this;
  }


  public function Output($filename = '', $dest = '')
  {
    parent::Output($filename, $dest);
  }
}
